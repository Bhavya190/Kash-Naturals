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
define('KASH_NATURALS_VERSION', '1.0.0');
define('KASH_NATURALS_DIR', get_template_directory());
define('KASH_NATURALS_URI', get_template_directory_uri());

/**
 * Include Required Modules
 */
require_once KASH_NATURALS_DIR . '/inc/setup.php';
require_once KASH_NATURALS_DIR . '/inc/enqueue.php';
require_once KASH_NATURALS_DIR . '/inc/customizer.php';

if (class_exists('WooCommerce')) {
    require_once KASH_NATURALS_DIR . '/inc/woocommerce-custom.php';
}

/**
 * Custom Body Classes
 */
function kash_naturals_body_classes($classes) {
    if (class_exists('WooCommerce')) {
        $classes[] = 'kash-woocommerce-active';
    }
    $classes[] = 'kash-theme-dark';
    return $classes;
}
add_filter('body_class', 'kash_naturals_body_classes');
