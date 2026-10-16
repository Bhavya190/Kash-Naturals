<?php
/**
 * Single Product Detail Page Template
 *
 * @package KashNaturals
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();

if (function_exists('have_posts') && have_posts()) {
    while (have_posts()) :
        the_post();
        if (function_exists('wc_get_template_part')) {
            wc_get_template_part('content', 'single-product');
        } else {
            require get_template_directory() . '/woocommerce/content-single-product.php';
        }
    endwhile;
} else {
    require get_template_directory() . '/woocommerce/content-single-product.php';
}

get_footer();
