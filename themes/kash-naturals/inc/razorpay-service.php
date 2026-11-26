<?php
/**
 * Self-Contained Razorpay Service Module for Kash Naturals
 *
 * Provides standalone & WooCommerce integrated order creation,
 * HMAC-SHA256 signature verification, and safe AJAX handlers.
 *
 * @package KashNaturals
 */

if (!defined('ABSPATH') && !defined('KASH_ROUTER_MODE')) {
    // Allow inclusion in standalone API scripts if needed
}

// --------------------------------------------------------------------------
// 1. Environment Variable Loader
// --------------------------------------------------------------------------
if (!function_exists('kash_load_env')) {
    function kash_load_env($filePath = null) {
        if (!$filePath) {
            $candidates = array(
                defined('ABSPATH') ? ABSPATH . '.env' : '',
                defined('ABSPATH') ? dirname(ABSPATH) . '/.env' : '',
                dirname(__DIR__, 4) . '/.env',
                dirname(__DIR__, 3) . '/.env',
                dirname(__DIR__, 2) . '/.env',
                dirname(__DIR__, 1) . '/.env',
                __DIR__ . '/.env',
                ($_SERVER['DOCUMENT_ROOT'] ?? '') . '/.env'
            );
            foreach ($candidates as $candidate) {
                if (!empty($candidate) && file_exists($candidate)) {
                    $filePath = $candidate;
                    break;
                }
            }
        }

        if (!$filePath || !file_exists($filePath)) {
            return;
        }

        $lines = @file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        if (!$lines) {
            return;
        }

        foreach ($lines as $line) {
            $line = trim($line);
            if (empty($line) || strpos($line, '#') === 0) {
                continue;
            }

            if (strpos($line, '=') !== false) {
                list($key, $val) = explode('=', $line, 2);
                $key = trim($key);
                $val = trim($val, " \t\n\r\0\x0B\"'");

                if (!array_key_exists($key, $_SERVER) && !array_key_exists($key, $_ENV)) {
                    putenv("$key=$val");
                    $_ENV[$key] = $val;
                    $_SERVER[$key] = $val;
                }
            }
        }
    }
}

// Auto-load .env if not yet loaded into environment
if (!getenv('RAZORPAY_KEY_ID')) {
    kash_load_env();
}

// --------------------------------------------------------------------------
// 2. Razorpay Credentials Accessors (with WP options & fallback)
// --------------------------------------------------------------------------
if (!function_exists('kash_get_razorpay_key_id')) {
    function kash_get_razorpay_key_id() {
        // 1. Priority: Check WooCommerce Razorpay official plugin settings in WordPress Admin
        if (function_exists('get_option')) {
            $wc_rzp = get_option('woocommerce_razorpay_settings', array());
            if (!empty($wc_rzp['key_id'])) {
                return trim((string)$wc_rzp['key_id']);
            }
        }

        // 2. Check environment variables
        $key_id = getenv('RAZORPAY_KEY_ID') ?: ($_ENV['RAZORPAY_KEY_ID'] ?? ($_SERVER['RAZORPAY_KEY_ID'] ?? ''));
        if (!empty($key_id)) {
            return trim((string)$key_id);
        }

        // 3. Check custom theme options or global options
        if (function_exists('get_option')) {
            $opt = get_option('razorpay_key_id', '');
            if (!empty($opt)) {
                return trim((string)$opt);
            }
        }

        // 4. Default test fallback credential
        return 'rzp_test_U4hJ4Xslre9Mh5';
    }
}

if (!function_exists('kash_get_razorpay_key_secret')) {
    function kash_get_razorpay_key_secret() {
        // 1. Priority: Check WooCommerce Razorpay official plugin settings in WordPress Admin
        if (function_exists('get_option')) {
            $wc_rzp = get_option('woocommerce_razorpay_settings', array());
            if (!empty($wc_rzp['key_secret'])) {
                return trim((string)$wc_rzp['key_secret']);
            }
        }

        // 2. Check environment variables
        $key_secret = getenv('RAZORPAY_KEY_SECRET') ?: ($_ENV['RAZORPAY_KEY_SECRET'] ?? ($_SERVER['RAZORPAY_KEY_SECRET'] ?? ''));
        if (!empty($key_secret)) {
            return trim((string)$key_secret);
        }

        // 3. Check custom theme options or global options
        if (function_exists('get_option')) {
            $opt = get_option('razorpay_key_secret', '');
            if (!empty($opt)) {
                return trim((string)$opt);
            }
        }

        // 4. Default test fallback credential
        return 'IskrOyk9yxSR0WannfPJDq9b';
    }
}

// --------------------------------------------------------------------------
// 3. Razorpay Order Creation Engine
// --------------------------------------------------------------------------
if (!function_exists('kash_create_razorpay_order')) {
    /**
     * Create an order on Razorpay servers
     *
     * @param int|float $amount Amount in paise (e.g. 17900 for ₹179.00). Must be >= 100.
     * @param string $currency 3-letter currency code, default INR.
     * @param string|null $receipt Optional unique receipt identifier.
     * @param array $notes Optional key-value metadata notes.
     * @return array Result array with ['status', 'data' => [...]] or ['status', 'error' => '...']
     */
    function kash_create_razorpay_order($amount, $currency = 'INR', $receipt = null, $notes = array()) {
        $amount_int = (int) round($amount);

        if ($amount_int < 100) {
            return array(
                'status' => 400,
                'error'  => 'Amount must be at least 100 paise (₹1.00).'
            );
        }

        $key_id = kash_get_razorpay_key_id();
        $key_secret = kash_get_razorpay_key_secret();

        if (empty($key_id) || empty($key_secret)) {
            return array(
                'status' => 500,
                'error'  => 'Razorpay credentials not configured. Please set Key ID and Key Secret in WooCommerce Settings > Payments > Razorpay or in .env.'
            );
        }

        $payload = array(
            'amount'   => $amount_int,
            'currency' => strtoupper($currency ?: 'INR'),
        );

        if (!empty($receipt)) {
            $payload['receipt'] = (string) $receipt;
        } else {
            $payload['receipt'] = 'kash_rcpt_' . time() . '_' . mt_rand(100, 999);
        }

        if (!empty($notes) && is_array($notes)) {
            $payload['notes'] = $notes;
        }

        $payload_json = json_encode($payload);
        $http_code = 0;
        $body = false;

        // Transport 1: WordPress HTTP API (wp_remote_post)
        if (function_exists('wp_remote_post')) {
            $response = wp_remote_post('https://api.razorpay.com/v1/orders', array(
                'headers' => array(
                    'Authorization' => 'Basic ' . base64_encode($key_id . ':' . $key_secret),
                    'Content-Type'  => 'application/json',
                ),
                'body'    => $payload_json,
                'timeout' => 20,
            ));

            if (!is_wp_error($response)) {
                $http_code = (int) wp_remote_retrieve_response_code($response);
                $body = wp_remote_retrieve_body($response);
            }
        }

        // Transport 2: PHP cURL Extension
        if (($body === false || empty($http_code)) && function_exists('curl_init')) {
            $ch = curl_init('https://api.razorpay.com/v1/orders');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $payload_json);
            curl_setopt($ch, CURLOPT_USERPWD, $key_id . ':' . $key_secret);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($payload_json)
            ));
            curl_setopt($ch, CURLOPT_TIMEOUT, 20);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);

            if (defined('CURLOPT_SSL_OPTIONS') && defined('CURLSSLOPT_NATIVE_CA')) {
                curl_setopt($ch, CURLOPT_SSL_OPTIONS, CURLSSLOPT_NATIVE_CA);
            }

            $body = curl_exec($ch);
            $http_code = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $curl_err = curl_error($ch);
            curl_close($ch);

            // Transport 2b: System curl.exe fallback on Windows
            if (($body === false || !empty($curl_err)) && function_exists('exec')) {
                $tmp_file = tempnam(sys_get_temp_dir(), 'rzp_');
                file_put_contents($tmp_file, $payload_json);
                $cmd = 'curl.exe -s -w "\n%{http_code}" -u ' . escapeshellarg($key_id . ':' . $key_secret) . ' -X POST https://api.razorpay.com/v1/orders -H "Content-Type: application/json" -d @' . escapeshellarg($tmp_file);
                $output_lines = array();
                @exec($cmd, $output_lines);
                @unlink($tmp_file);
                if (!empty($output_lines)) {
                    $last_line = array_pop($output_lines);
                    if (is_numeric(trim($last_line))) {
                        $http_code = (int) trim($last_line);
                        $body = implode("\n", $output_lines);
                    }
                }
            }
        }

        // Transport 3: Native PHP Stream Context
        if ($body === false || empty($http_code)) {
            $opts = array(
                'http' => array(
                    'method'        => 'POST',
                    'header'        => "Authorization: Basic " . base64_encode($key_id . ':' . $key_secret) . "\r\n" .
                                       "Content-Type: application/json\r\n" .
                                       "Content-Length: " . strlen($payload_json) . "\r\n",
                    'content'       => $payload_json,
                    'timeout'       => 20,
                    'ignore_errors' => true
                ),
                'ssl' => array(
                    'verify_peer'      => true,
                    'verify_peer_name' => true,
                )
            );
            $ctx = stream_context_create($opts);
            $body = @file_get_contents('https://api.razorpay.com/v1/orders', false, $ctx);

            if (!empty($http_response_header) && is_array($http_response_header)) {
                if (preg_match('#HTTP/\S+\s+(\d{3})#', $http_response_header[0], $matches)) {
                    $http_code = (int) $matches[1];
                }
            }
        }

        if ($body === false && $http_code === 0) {
            return array(
                'status' => 500,
                'error'  => 'Network connection error: Unable to reach Razorpay servers. Please check server internet connectivity.'
            );
        }

        $data = json_decode($body, true);

        if ($http_code === 401) {
            return array(
                'status' => 401,
                'error'  => 'Razorpay Authentication Failed: Key ID or Key Secret is incorrect. Please verify credentials in WooCommerce > Settings > Payments > Razorpay.'
            );
        }

        if ($http_code < 200 || $http_code >= 300 || empty($data['id'])) {
            $msg = $data['error']['description'] ?? ($data['error']['message'] ?? ('Razorpay returned HTTP ' . $http_code));
            return array(
                'status' => ($http_code >= 400 && $http_code < 500) ? $http_code : 500,
                'error'  => 'Razorpay order creation failed: ' . $msg
            );
        }

        return array(
            'status' => 200,
            'data'   => array(
                'order_id' => $data['id'],
                'amount'   => $data['amount'],
                'currency' => $data['currency'],
                'receipt'  => $data['receipt'] ?? $payload['receipt'],
            )
        );
    }
}

// --------------------------------------------------------------------------
// 4. Razorpay Signature Verification
// --------------------------------------------------------------------------
if (!function_exists('kash_verify_razorpay_signature')) {
    /**
     * Verify payment signature using HMAC-SHA256
     *
     * @param string $order_id Razorpay Order ID (e.g. order_XXXX)
     * @param string $payment_id Razorpay Payment ID (e.g. pay_XXXX)
     * @param string $signature Razorpay signature from frontend checkout
     * @return bool True if valid, false otherwise.
     */
    function kash_verify_razorpay_signature($order_id, $payment_id, $signature) {
        if (empty($order_id) || empty($payment_id) || empty($signature)) {
            return false;
        }

        $key_secret = kash_get_razorpay_key_secret();
        if (empty($key_secret)) {
            return false;
        }

        $data = $order_id . '|' . $payment_id;
        $expected = hash_hmac('sha256', $data, $key_secret);

        return hash_equals($expected, (string)$signature);
    }
}

// --------------------------------------------------------------------------
// 5. WordPress AJAX Endpoints (Safe, No Unhandled 500s)
// --------------------------------------------------------------------------
if (function_exists('add_action')) {
    add_action('wp_ajax_nopriv_kash_create_razorpay_order', 'kash_ajax_create_razorpay_order');
    add_action('wp_ajax_kash_create_razorpay_order', 'kash_ajax_create_razorpay_order');
    // Also bind to WooCommerce's wc-ajax pipeline for extra resilience
    add_action('wc_ajax_kash_create_razorpay_order', 'kash_ajax_create_razorpay_order');

    if (!function_exists('kash_ajax_create_razorpay_order')) {
        function kash_ajax_create_razorpay_order() {
            try {
                $amount   = $_POST['amount'] ?? ($_GET['amount'] ?? 0);
                $currency = $_POST['currency'] ?? 'INR';
                $receipt  = $_POST['receipt'] ?? null;
                $notes    = $_POST['notes'] ?? array();

                $result = kash_create_razorpay_order($amount, $currency, $receipt, $notes);

                if ($result['status'] === 200) {
                    wp_send_json_success($result['data'], 200);
                } else {
                    // Send 400 with clean error payload so client catches it cleanly
                    wp_send_json_error(array('error' => $result['error']), 400);
                }
            } catch (\Throwable $e) {
                wp_send_json_error(array('error' => 'Server error creating order: ' . $e->getMessage()), 400);
            }
        }
    }

    add_action('wp_ajax_nopriv_kash_verify_razorpay_payment', 'kash_ajax_verify_razorpay_payment');
    add_action('wp_ajax_kash_verify_razorpay_payment', 'kash_ajax_verify_razorpay_payment');
    add_action('wc_ajax_kash_verify_razorpay_payment', 'kash_ajax_verify_razorpay_payment');

    if (!function_exists('kash_ajax_verify_razorpay_payment')) {
        function kash_ajax_verify_razorpay_payment() {
            try {
                $order_id   = $_POST['razorpay_order_id'] ?? '';
                $payment_id = $_POST['razorpay_payment_id'] ?? '';
                $signature  = $_POST['razorpay_signature'] ?? '';

                if (empty($order_id) || empty($payment_id) || empty($signature)) {
                    wp_send_json_error(array('error' => 'Missing required fields: order ID, payment ID, and signature are required.'), 400);
                }

                $valid = kash_verify_razorpay_signature($order_id, $payment_id, $signature);

                if ($valid) {
                    wp_send_json_success(array(
                        'message'    => 'Payment verified successfully.',
                        'order_id'   => $order_id,
                        'payment_id' => $payment_id
                    ), 200);
                } else {
                    wp_send_json_error(array('error' => 'Payment signature verification failed. Possible tampering detected.'), 400);
                }
            } catch (\Throwable $e) {
                wp_send_json_error(array('error' => 'Server error verifying payment: ' . $e->getMessage()), 400);
            }
        }
    }
}
