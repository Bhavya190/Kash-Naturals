<?php
/**
 * Main WooCommerce Dispatcher Template
 *
 * @package KashNaturals
 */

if (!defined('ABSPATH')) {
    exit;
}

if (is_singular('product')) {
    get_header();
    while (have_posts()) :
        the_post();
        if (function_exists('wc_get_template_part')) {
            wc_get_template_part('content', 'single-product');
        } else {
            require get_template_directory() . '/woocommerce/content-single-product.php';
        }
    endwhile;
    get_footer();
} else {
    // All WooCommerce archives: Shop, Categories, Collections, Tags
    require get_template_directory() . '/woocommerce/archive-product.php';
}
