<?php
/**
 * Standalone WordPress Theme Development Router
 * Allows testing the WordPress theme in wp-content/themes/kash-naturals/
 * without needing a full MySQL/WordPress database setup on local & Vercel serverless.
 */

// 0. Static Asset MIME Type Interceptor (Guarantees Content-Type: text/css for stylesheets)
$rawUri = $_SERVER['REQUEST_URI'] ?? $_SERVER['PATH_INFO'] ?? '/';
$uri = parse_url($rawUri, PHP_URL_PATH);

if (preg_match('/\.(css|js|png|jpg|jpeg|gif|svg|webp|ico|woff|woff2|ttf|eot)$/i', $uri)) {
    $cleanRel = str_replace(array('/wp-content/themes/kash-naturals', '/themes/kash-naturals'), '', $uri);
    $possibleAssetPaths = array(
        __DIR__ . $uri,
        __DIR__ . '/themes/kash-naturals' . $cleanRel,
        __DIR__ . '/wp-content/themes/kash-naturals' . $cleanRel,
        dirname(__DIR__) . '/themes/kash-naturals' . $cleanRel,
        dirname(__DIR__) . '/wp-content/themes/kash-naturals' . $cleanRel
    );

    foreach ($possibleAssetPaths as $assetPath) {
        if (file_exists($assetPath) && !is_dir($assetPath)) {
            $ext = strtolower(pathinfo($assetPath, PATHINFO_EXTENSION));
            $mimes = array(
                'css'   => 'text/css; charset=UTF-8',
                'js'    => 'application/javascript; charset=UTF-8',
                'png'   => 'image/png',
                'jpg'   => 'image/jpeg',
                'jpeg'  => 'image/jpeg',
                'gif'   => 'image/gif',
                'svg'   => 'image/svg+xml',
                'webp'  => 'image/webp',
                'ico'   => 'image/png',
                'woff'  => 'font/woff',
                'woff2' => 'font/woff2',
                'ttf'   => 'font/ttf',
            );
            $contentType = isset($mimes[$ext]) ? $mimes[$ext] : mime_content_type($assetPath);
            header("Content-Type: {$contentType}");
            header("Cache-Control: public, max-age=86400");
            readfile($assetPath);
            exit;
        }
    }
}

// 1. Define WordPress Environment Constants
if (!defined('ABSPATH')) {
    define('ABSPATH', __DIR__ . '/');
}

// Dynamically locate theme directory whether executed from root or inside wp-content
$possibleThemeDirs = array(
    __DIR__ . '/themes/kash-naturals',
    __DIR__ . '/wp-content/themes/kash-naturals',
    dirname(__DIR__) . '/themes/kash-naturals',
    dirname(__DIR__) . '/wp-content/themes/kash-naturals'
);

$themeDir = __DIR__ . '/themes/kash-naturals';
foreach ($possibleThemeDirs as $dir) {
    if (file_exists($dir . '/functions.php')) {
        $themeDir = $dir;
        break;
    }
}

if (!defined('KASH_THEME_DIR')) {
    define('KASH_THEME_DIR', $themeDir);
}
if (!defined('KASH_THEME_URI')) {
    define('KASH_THEME_URI', '/wp-content/themes/kash-naturals');
}

// 2. Define WordPress Helper Functions Mock Layer
if (!function_exists('get_template_directory_uri')) { function get_template_directory_uri() { return KASH_THEME_URI; } }
if (!function_exists('get_template_directory')) { function get_template_directory() { return KASH_THEME_DIR; } }
if (!function_exists('get_stylesheet_directory_uri')) { function get_stylesheet_directory_uri() { return KASH_THEME_URI; } }
if (!function_exists('get_stylesheet_directory')) { function get_stylesheet_directory() { return KASH_THEME_DIR; } }
if (!function_exists('get_theme_mod')) { function get_theme_mod($name, $default = false) { return $default; } }

if (!function_exists('get_header')) {
    function get_header($name = null) {
        $file = KASH_THEME_DIR . '/header.php';
        if ($name && file_exists(KASH_THEME_DIR . "/header-{$name}.php")) {
            $file = KASH_THEME_DIR . "/header-{$name}.php";
        }
        if (file_exists($file)) require $file;
    }
}

if (!function_exists('get_footer')) {
    function get_footer($name = null) {
        $file = KASH_THEME_DIR . '/footer.php';
        if ($name && file_exists(KASH_THEME_DIR . "/footer-{$name}.php")) {
            $file = KASH_THEME_DIR . "/footer-{$name}.php";
        }
        if (file_exists($file)) require $file;
    }
}

if (!function_exists('get_template_part')) {
    function get_template_part($slug, $name = null, $args = array()) {
        $file = KASH_THEME_DIR . "/{$slug}.php";
        if ($name && file_exists(KASH_THEME_DIR . "/{$slug}-{$name}.php")) {
            $file = KASH_THEME_DIR . "/{$slug}-{$name}.php";
        }
        if (file_exists($file)) require $file;
    }
}

if (!function_exists('language_attributes')) { function language_attributes() { echo 'lang="en-US"'; } }

$GLOBALS['kash_page_title'] = 'Kash Naturals | Authentic Mouth Fresheners & Chocolates';
if (!function_exists('bloginfo')) {
    function bloginfo($show = '') {
        if ($show === 'charset') echo 'UTF-8';
        elseif ($show === 'name') echo 'Kash Naturals';
        elseif ($show === 'description') echo 'Artisanal Mouth Fresheners & Chocolates';
        else echo 'Kash Naturals';
    }
}

if (!function_exists('wp_head')) {
    function wp_head() {
        global $kash_page_title;
        echo '<title>' . esc_html($kash_page_title) . '</title>' . "\n";
        echo '<meta name="description" content="Kash Naturals offers premium mouth fresheners, chocolate dragees, and handcrafted confectioneries using 100% natural ingredients across India.">' . "\n";
        echo '<link rel="icon" type="image/png" href="' . KASH_THEME_URI . '/assets/images/Kash Natural Leaf Logo.png">' . "\n";
        echo '<link rel="shortcut icon" type="image/png" href="' . KASH_THEME_URI . '/assets/images/Kash Natural Leaf Logo.png">' . "\n";
        echo '<link rel="stylesheet" href="' . KASH_THEME_URI . '/assets/css/main.css?v=' . time() . '">' . "\n";
        echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">' . "\n";
        echo '<link href="https://fonts.googleapis.com/css2?family=Caveat:wght@600;700&family=Outfit:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,600;0,700;1,400;1,600&display=swap" rel="stylesheet">' . "\n";
    }
}

if (!function_exists('body_class')) { function body_class($class = '') { echo 'class="kash-theme-dark ' . esc_attr($class) . '"'; } }
if (!function_exists('wp_body_open')) { function wp_body_open() {} }
if (!function_exists('wp_footer')) {
    function wp_footer() {
        echo '<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>' . "\n";
        echo '<script src="' . KASH_THEME_URI . '/assets/js/main.js?v=' . time() . '"></script>' . "\n";
        echo '<script src="' . KASH_THEME_URI . '/assets/js/layout-loader.js"></script>' . "\n";
    }
}

if (!function_exists('sanitize_text_field')) { function sanitize_text_field($str) { return trim(strip_tags((string)$str)); } }
if (!function_exists('sanitize_title')) { function sanitize_title($str) { return strtolower(trim(preg_replace('/[^a-zA-Z0-9-]+/', '-', (string)$str), '-')); } }
if (!function_exists('esc_attr')) { function esc_attr($text) { return htmlspecialchars((string)$text, ENT_QUOTES, 'UTF-8'); } }
if (!function_exists('esc_url')) { function esc_url($url) { return htmlspecialchars((string)$url, ENT_QUOTES, 'UTF-8'); } }
if (!function_exists('esc_html')) { function esc_html($text) { return htmlspecialchars((string)$text, ENT_QUOTES, 'UTF-8'); } }
if (!function_exists('esc_html_e')) { function esc_html_e($text, $domain = 'default') { echo htmlspecialchars((string)$text, ENT_QUOTES, 'UTF-8'); } }
if (!function_exists('esc_html__')) { function esc_html__($text, $domain = 'default') { return htmlspecialchars((string)$text, ENT_QUOTES, 'UTF-8'); } }
if (!function_exists('esc_attr__')) { function esc_attr__($text, $domain = 'default') { return htmlspecialchars((string)$text, ENT_QUOTES, 'UTF-8'); } }
if (!function_exists('esc_attr_e')) { function esc_attr_e($text, $domain = 'default') { echo htmlspecialchars((string)$text, ENT_QUOTES, 'UTF-8'); } }
if (!function_exists('esc_js')) { function esc_js($text) { return addslashes((string)$text); } }
if (!function_exists('wp_kses_post')) { function wp_kses_post($content) { return $content; } }
if (!function_exists('wp_kses')) { function wp_kses($content, $allowed_html = array()) { return $content; } }
if (!function_exists('_e')) { function _e($text, $domain = 'default') { echo htmlspecialchars((string)$text, ENT_QUOTES, 'UTF-8'); } }
if (!function_exists('__')) { function __($text, $domain = 'default') { return $text; } }
if (!function_exists('_n')) { function _n($single, $plural, $number, $domain = 'default') { return ($number === 1) ? $single : $plural; } }
if (!function_exists('_x')) { function _x($text, $context, $domain = 'default') { return $text; } }
if (!function_exists('home_url')) { function home_url($path = '/') { return $path; } }
if (!function_exists('admin_url')) { function admin_url($path = '/') { return '/admin' . $path; } }
if (!function_exists('has_custom_logo')) { function has_custom_logo() { return false; } }
if (!function_exists('the_custom_logo')) { function the_custom_logo() {} }
if (!function_exists('has_nav_menu')) { function has_nav_menu($location) { return false; } }
if (!function_exists('wp_nav_menu')) { function wp_nav_menu($args = array()) {} }
if (!function_exists('the_title')) {
    function the_title() {
        global $kash_page_title;
        echo esc_html(str_replace(' | Kash Naturals', '', $kash_page_title));
    }
}
if (!function_exists('add_filter')) { function add_filter($tag, $function_to_add, $priority = 10, $accepted_args = 1) {} }
if (!function_exists('add_action')) { function add_action($tag, $function_to_add, $priority = 10, $accepted_args = 1) {} }
if (!function_exists('do_action')) { function do_action($tag, ...$arg) {} }
if (!function_exists('apply_filters')) { function apply_filters($tag, $value, ...$args) { return $value; } }
if (!function_exists('is_front_page')) { function is_front_page() { global $kash_is_front; return !empty($kash_is_front); } }
if (!function_exists('is_home')) { function is_home() { return false; } }
if (!function_exists('is_shop')) { function is_shop() { global $kash_is_shop; return !empty($kash_is_shop); } }
if (!function_exists('load_theme_textdomain')) { function load_theme_textdomain($domain, $path = false) { return true; } }
if (!function_exists('add_theme_support')) { function add_theme_support($feature, ...$args) { return true; } }
if (!function_exists('add_image_size')) { function add_image_size($name, $width = 0, $height = 0, $crop = false) { return true; } }
if (!function_exists('register_nav_menus')) { function register_nav_menus($locations = array()) { return true; } }
if (!function_exists('register_sidebar')) { function register_sidebar($args = array()) { return true; } }
if (!function_exists('wp_enqueue_style')) { function wp_enqueue_style($handle, $src = '', $deps = array(), $ver = false, $media = 'all') { return true; } }
if (!function_exists('wp_enqueue_script')) { function wp_enqueue_script($handle, $src = '', $deps = array(), $ver = false, $in_footer = false) { return true; } }
if (!function_exists('wp_register_style')) { function wp_register_style($handle, $src = '', $deps = array(), $ver = false, $media = 'all') { return true; } }
if (!function_exists('wp_register_script')) { function wp_register_script($handle, $src = '', $deps = array(), $ver = false, $in_footer = false) { return true; } }
if (!function_exists('wp_localize_script')) { function wp_localize_script($handle, $object_name, $l10n) { return true; } }
if (!function_exists('wp_create_nonce')) { function wp_create_nonce($action = -1) { return 'mock_nonce'; } }
if (!function_exists('get_option')) { function get_option($option, $default = false) { return $default; } }
if (!function_exists('update_option')) { function update_option($option, $value, $autoload = null) { return true; } }
if (!function_exists('get_post_meta')) { function get_post_meta($post_id, $key = '', $single = false) { return $single ? '' : array(); } }
if (!function_exists('update_post_meta')) { function update_post_meta($post_id, $meta_key, $meta_value, $prev_value = '') { return true; } }
if (!function_exists('is_wp_error')) { function is_wp_error($thing) { return false; } }

// WooCommerce mocks
if (!function_exists('wc_get_page_id')) { function wc_get_page_id($page) { return 0; } }
if (!function_exists('get_permalink')) { function get_permalink($id = 0) { return '/shop'; } }
if (!function_exists('wc_get_page_permalink')) { function wc_get_page_permalink($page) { return '/' . $page; } }
if (!function_exists('wc_get_cart_url')) { function wc_get_cart_url() { return '/cart'; } }
if (!function_exists('wc_get_checkout_url')) { function wc_get_checkout_url() { return '/checkout'; } }
if (!function_exists('wc_get_product')) { function wc_get_product($id) { return false; } }
if (!function_exists('wc_price')) { function wc_price($price) { return '₹' . number_format((float)$price, 2); } }
if (!function_exists('get_woocommerce_currency_symbol')) { function get_woocommerce_currency_symbol($currency = '') { return '₹'; } }
if (!function_exists('is_cart')) { function is_cart() { return false; } }
if (!function_exists('is_checkout')) { function is_checkout() { return false; } }
if (!function_exists('is_account_page')) { function is_account_page() { return false; } }
if (!function_exists('woocommerce_page_title')) { function woocommerce_page_title() { echo 'Shop Collection'; } }
if (!function_exists('is_active_sidebar')) { function is_active_sidebar($index) { return false; } }
if (!function_exists('dynamic_sidebar')) { function dynamic_sidebar($index = 1) { return false; } }
if (!function_exists('woocommerce_product_loop')) { function woocommerce_product_loop() { return false; } }
if (!function_exists('woocommerce_result_count')) { function woocommerce_result_count() {} }
if (!function_exists('woocommerce_catalog_ordering')) { function woocommerce_catalog_ordering() {} }
if (!function_exists('woocommerce_product_loop_start')) { function woocommerce_product_loop_start() {} }
if (!function_exists('woocommerce_product_loop_end')) { function woocommerce_product_loop_end() {} }
if (!function_exists('woocommerce_pagination')) { function woocommerce_pagination() {} }
if (!function_exists('wc_get_template_part')) { function wc_get_template_part($slug, $name = '') {} }
if (!function_exists('wc_get_formatted_cart_item_data')) { function wc_get_formatted_cart_item_data($cart_item) { return ''; } }

// Load Theme Functions
if (file_exists(KASH_THEME_DIR . '/functions.php')) {
    require_once KASH_THEME_DIR . '/functions.php';
}

// 3. Handle Routing for Server
$filePath = __DIR__ . $uri;

// Clean URL Mapping to Theme Templates
$cleanUri = rtrim(strtolower($uri), '/');

switch ($cleanUri) {
    case '/favicon.ico':
        $favPath = KASH_THEME_DIR . '/assets/images/Kash Natural Leaf Logo.png';
        if (file_exists($favPath)) {
            header('Content-Type: image/png');
            readfile($favPath);
            exit;
        }
        exit;

    case '':
    case '/index':
    case '/index.php':
    case '/index.html':
        $GLOBALS['kash_is_front'] = true;
        $GLOBALS['kash_page_title'] = 'Home';
        require KASH_THEME_DIR . '/front-page.php';
        exit;

    case '/shop':
    case '/shop.php':
    case '/shop.html':
        $GLOBALS['kash_is_shop'] = true;
        $GLOBALS['kash_page_title'] = 'Shop | Kash Naturals';
        require KASH_THEME_DIR . '/page-shop.php';
        exit;

    case '/about':
    case '/about-us':
    case '/about.php':
    case '/about.html':
        $GLOBALS['kash_page_title'] = 'About Us';
        require KASH_THEME_DIR . '/page-about.php';
        exit;

    case '/contact':
    case '/contact-us':
    case '/contact.php':
    case '/contact.html':
        $GLOBALS['kash_page_title'] = 'Contact Us';
        require KASH_THEME_DIR . '/page-contact.php';
        exit;

    case '/combos':
    case '/combo':
    case '/combos.php':
    case '/combos.html':
        $GLOBALS['kash_page_title'] = 'Curated Combos & Gift Hampers';
        require KASH_THEME_DIR . '/page-combos.php';
        exit;

    case '/product':
    case '/product-detail':
    case '/single-product':
    case '/product.php':
        $productId = isset($_GET['id']) ? intval($_GET['id']) : 1;
        $GLOBALS['kash_product_id'] = $productId;
        $GLOBALS['kash_page_title'] = 'Product Detail';
        require KASH_THEME_DIR . '/single-product.php';
        exit;

    case '/privacy-policy':
    case '/privacy-policy.php':
    case '/privacy-policy.html':
        $GLOBALS['kash_page_title'] = 'Privacy Policy';
        require KASH_THEME_DIR . '/page-privacy-policy.php';
        exit;

    case '/terms-and-conditions':
    case '/terms':
    case '/terms.php':
    case '/terms.html':
        $GLOBALS['kash_page_title'] = 'Terms & Conditions';
        require KASH_THEME_DIR . '/page-terms.php';
        exit;

    case '/return-policy':
    case '/return-policy.php':
    case '/return-policy.html':
        $GLOBALS['kash_page_title'] = 'Return Policy';
        require KASH_THEME_DIR . '/page-return-policy.php';
        exit;

    case '/shipping-policy':
    case '/shipping-policy.php':
    case '/shipping-policy.html':
        $GLOBALS['kash_page_title'] = 'Shipping Policy';
        require KASH_THEME_DIR . '/page-shipping-policy.php';
        exit;

    case '/faqs':
    case '/faq':
    case '/faqs.php':
    case '/faqs.html':
        $GLOBALS['kash_page_title'] = 'Frequently Asked Questions';
        require KASH_THEME_DIR . '/page-faqs.php';
        exit;

    default:
        header("HTTP/1.0 404 Not Found");
        $GLOBALS['kash_page_title'] = 'Page Not Found';
        if (file_exists(KASH_THEME_DIR . '/404.php')) {
            require KASH_THEME_DIR . '/404.php';
        } else {
            echo "<h1>404 Not Found</h1>";
        }
        exit;
}
