<?php
/**
 * Kash Naturals Theme Functions & Definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package KashNaturals
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Define Theme Constants
 */
define('KASH_NATURALS_VERSION', '1.0.3');
define('KASH_NATURALS_DIR', get_template_directory());
define('KASH_NATURALS_URI', get_template_directory_uri());

/**
 * Safely load a required theme file, handling both standard forward slashes
 * and Windows backslashes (in case a zip was extracted on a Linux server with literal backslashes).
 */
function kash_naturals_require_file($relative_path) {
    $theme_dir = get_template_directory();
    $clean_rel = ltrim($relative_path, '/\\');

    // 1. Standard forward-slash path (e.g. /inc/setup.php)
    $forward_path = $theme_dir . '/' . str_replace('\\', '/', $clean_rel);
    if (file_exists($forward_path)) {
        require_once $forward_path;
        return true;
    }

    // 2. Fallback for Windows-compressed zip extracted on Linux (literal backslashes in filename e.g. inc\setup.php)
    $backslash_path = $theme_dir . '/' . str_replace('/', '\\', $clean_rel);
    if (file_exists($backslash_path)) {
        require_once $backslash_path;
        return true;
    }

    // Log warning gracefully rather than throwing an unhandled fatal error
    error_log(sprintf('[Kash Naturals] Required theme file not found: %s', $forward_path));
    return false;
}

/**
 * Include Required Modules
 */
kash_naturals_require_file('inc/setup.php');
kash_naturals_require_file('inc/enqueue.php');
kash_naturals_require_file('inc/customizer.php');

if (class_exists('WooCommerce')) {
    kash_naturals_require_file('inc/woocommerce-custom.php');
}

/**
 * Custom Body Classes
 */
function kash_naturals_body_classes($classes) {
    if (!is_array($classes)) {
        $classes = array();
    }
    if (class_exists('WooCommerce')) {
        $classes[] = 'kash-woocommerce-active';
    }
    $classes[] = 'kash-theme-dark';
    return $classes;
}
add_filter('body_class', 'kash_naturals_body_classes');
