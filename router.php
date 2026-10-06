<?php
/**
 * Standalone WordPress Theme Development Router
 * Allows testing the WordPress theme in themes/kash-naturals/
 * without needing a full MySQL/WordPress database setup.
 */

// 1. Define WordPress Environment Constants
if (!defined('ABSPATH')) {
    define('ABSPATH', __DIR__ . '/');
}

define('KASH_THEME_DIR', __DIR__ . '/themes/kash-naturals');
define('KASH_THEME_URI', '/themes/kash-naturals');

// 2. Define WordPress Helper Functions Mock Layer
if (!function_exists('get_template_directory_uri')) {
    function get_template_directory_uri() {
        return KASH_THEME_URI;
    }
}

if (!function_exists('get_template_directory')) {
    function get_template_directory() {
        return KASH_THEME_DIR;
    }
}

if (!function_exists('get_theme_mod')) {
    function get_theme_mod($name, $default = false) {
        return $default;
    }
}

if (!function_exists('get_header')) {
    function get_header($name = null) {
        $file = KASH_THEME_DIR . '/header.php';
        if ($name && file_exists(KASH_THEME_DIR . "/header-{$name}.php")) {
            $file = KASH_THEME_DIR . "/header-{$name}.php";
        }
        require $file;
    }
}

if (!function_exists('get_footer')) {
    function get_footer($name = null) {
        $file = KASH_THEME_DIR . '/footer.php';
        if ($name && file_exists(KASH_THEME_DIR . "/footer-{$name}.php")) {
            $file = KASH_THEME_DIR . "/footer-{$name}.php";
        }
        require $file;
    }
}

if (!function_exists('get_template_part')) {
    function get_template_part($slug, $name = null, $args = array()) {
        $file = KASH_THEME_DIR . "/{$slug}.php";
        if ($name && file_exists(KASH_THEME_DIR . "/{$slug}-{$name}.php")) {
            $file = KASH_THEME_DIR . "/{$slug}-{$name}.php";
        }
        if (file_exists($file)) {
            require $file;
        }
    }
}

if (!function_exists('language_attributes')) {
    function language_attributes() {
        echo 'lang="en-US"';
    }
}

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
        echo '<link rel="stylesheet" href="' . KASH_THEME_URI . '/assets/css/main.css?v=' . time() . '">' . "\n";
        echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">' . "\n";
        echo '<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,600;0,700;1,400&display=swap" rel="stylesheet">' . "\n";
    }
}

if (!function_exists('body_class')) {
    function body_class($class = '') {
        echo 'class="kash-theme-dark ' . esc_attr($class) . '"';
    }
}

if (!function_exists('wp_body_open')) {
    function wp_body_open() {}
}

if (!function_exists('wp_footer')) {
    function wp_footer() {
        echo '<script src="' . KASH_THEME_URI . '/assets/js/layout-loader.js"></script>' . "\n";
    }
}

if (!function_exists('esc_attr')) {
    function esc_attr($text) {
        return htmlspecialchars((string)$text, ENT_QUOTES, 'UTF-8');
    }
}

if (!function_exists('esc_url')) {
    function esc_url($url) {
        return htmlspecialchars((string)$url, ENT_QUOTES, 'UTF-8');
    }
}

if (!function_exists('esc_html')) {
    function esc_html($text) {
        return htmlspecialchars((string)$text, ENT_QUOTES, 'UTF-8');
    }
}

if (!function_exists('esc_html_e')) {
    function esc_html_e($text, $domain = 'default') {
        echo htmlspecialchars((string)$text, ENT_QUOTES, 'UTF-8');
    }
}

if (!function_exists('esc_attr_e')) {
    function esc_attr_e($text, $domain = 'default') {
        echo htmlspecialchars((string)$text, ENT_QUOTES, 'UTF-8');
    }
}

if (!function_exists('esc_js')) {
    function esc_js($text) {
        return addslashes((string)$text);
    }
}

if (!function_exists('wp_kses_post')) {
    function wp_kses_post($content) {
        return $content;
    }
}

if (!function_exists('wp_kses')) {
    function wp_kses($content, $allowed_html = array()) {
        return $content;
    }
}

if (!function_exists('_e')) {
    function _e($text, $domain = 'default') {
        echo htmlspecialchars((string)$text, ENT_QUOTES, 'UTF-8');
    }
}

if (!function_exists('__')) {
    function __($text, $domain = 'default') {
        return $text;
    }
}

if (!function_exists('home_url')) {
    function home_url($path = '/') {
        return $path;
    }
}

if (!function_exists('has_custom_logo')) {
    function has_custom_logo() {
        return false;
    }
}

if (!function_exists('the_custom_logo')) {
    function the_custom_logo() {}
}

if (!function_exists('has_nav_menu')) {
    function has_nav_menu($location) {
        return false;
    }
}

if (!function_exists('the_title')) {
    function the_title() {
        global $kash_page_title;
        echo esc_html(str_replace(' | Kash Naturals', '', $kash_page_title));
    }
}

if (!function_exists('add_filter')) {
    function add_filter($tag, $function_to_add, $priority = 10, $accepted_args = 1) {}
}

if (!function_exists('add_action')) {
    function add_action($tag, $function_to_add, $priority = 10, $accepted_args = 1) {}
}

if (!function_exists('do_action')) {
    function do_action($tag, ...$arg) {}
}

if (!function_exists('apply_filters')) {
    function apply_filters($tag, $value, ...$args) {
        return $value;
    }
}

if (!function_exists('is_front_page')) {
    function is_front_page() {
        global $kash_is_front;
        return !empty($kash_is_front);
    }
}

if (!function_exists('is_home')) {
    function is_home() {
        return false;
    }
}

if (!function_exists('is_shop')) {
    function is_shop() {
        global $kash_is_shop;
        return !empty($kash_is_shop);
    }
}

if (!function_exists('wc_get_page_id')) {
    function wc_get_page_id($page) {
        return 0;
    }
}

if (!function_exists('get_permalink')) {
    function get_permalink($id = 0) {
        return '/shop';
    }
}

// Load Theme Functions
require_once KASH_THEME_DIR . '/functions.php';

// 3. Handle Routing for Server
$rawUri = $_SERVER['REQUEST_URI'] ?? $_SERVER['PATH_INFO'] ?? '/';
$uri = parse_url($rawUri, PHP_URL_PATH);
$filePath = __DIR__ . $uri;

// Assets fallback
if (strpos($uri, '/assets/') === 0 || strpos($uri, '/themes/') === 0 || strpos($uri, '/wp-content/') === 0) {
    $themeAssetPath = __DIR__ . str_replace('/wp-content', '', $uri);
    if (file_exists($themeAssetPath) && !is_dir($themeAssetPath)) {
        $mime = mime_content_type($themeAssetPath);
        if (substr($themeAssetPath, -4) === '.css') $mime = 'text/css';
        if (substr($themeAssetPath, -3) === '.js') $mime = 'application/javascript';
        header('Content-Type: ' . $mime);
        readfile($themeAssetPath);
        exit;
    }
}

// Serve existing files directly
if ($uri !== '/' && file_exists($filePath) && !is_dir($filePath)) {
    return false;
}

// Clean URL Mapping to Theme Templates
$cleanUri = rtrim(strtolower($uri), '/');

switch ($cleanUri) {
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

    default:
        header("HTTP/1.0 404 Not Found");
        $GLOBALS['kash_page_title'] = 'Page Not Found';
        require KASH_THEME_DIR . '/404.php';
        exit;
}
