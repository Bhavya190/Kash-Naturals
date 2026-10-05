<?php
/**
 * Theme Setup and Configuration
 *
 * @package KashNaturals
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

if (!function_exists('kash_naturals_setup')) :
    /**
     * Sets up theme defaults and registers support for various WordPress features.
     */
    function kash_naturals_setup() {
        // Make theme available for translation
        load_theme_textdomain('kash-naturals', get_template_directory() . '/languages');

        // Add default posts and comments RSS feed links to head
        add_theme_support('automatic-feed-links');

        // Let WordPress manage the document title
        add_theme_support('title-tag');

        // Enable support for Post Thumbnails on posts and pages
        add_theme_support('post-thumbnails');

        // Register custom image sizes for chocolate products
        add_image_size('kash-product-card', 400, 400, true);
        add_image_size('kash-product-hero', 800, 800, true);
        add_image_size('kash-category-banner', 600, 400, true);

        // Register Navigation Menus
        register_nav_menus(array(
            'primary' => __('Primary Navigation Header', 'kash-naturals'),
            'footer'  => __('Footer Links Menu', 'kash-naturals'),
            'categories' => __('Chocolate Categories Menu', 'kash-naturals'),
        ));

        // HTML5 markup support
        add_theme_support('html5', array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
            'style',
            'script',
        ));

        // Set up the WordPress core custom logo feature
        add_theme_support('custom-logo', array(
            'height'      => 80,
            'width'       => 240,
            'flex-height' => true,
            'flex-width'  => true,
            'header-text' => array('site-title', 'site-description'),
        ));

        // Add theme support for Selective Refresh for Widgets
        add_theme_support('customize-selective-refresh-widgets');

        // Add WooCommerce Theme Support
        add_theme_support('woocommerce');
        add_theme_support('wc-product-gallery-zoom');
        add_theme_support('wc-product-gallery-lightbox');
        add_theme_support('wc-product-gallery-slider');
    }
endif;
add_action('after_setup_theme', 'kash_naturals_setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 */
function kash_naturals_content_width() {
    $GLOBALS['content_width'] = apply_filters('kash_naturals_content_width', 1200);
}
add_action('after_setup_theme', 'kash_naturals_content_width', 0);

/**
 * Register widget area.
 */
function kash_naturals_widgets_init() {
    register_sidebar(array(
        'name'          => __('Shop Sidebar', 'kash-naturals'),
        'id'            => 'shop-sidebar',
        'description'   => __('Add widgets here to appear in your WooCommerce shop sidebar.', 'kash-naturals'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));

    register_sidebar(array(
        'name'          => __('Footer Column 1', 'kash-naturals'),
        'id'            => 'footer-1',
        'description'   => __('First footer column widget area.', 'kash-naturals'),
        'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widget-title">',
        'after_title'   => '</h4>',
    ));

    register_sidebar(array(
        'name'          => __('Footer Column 2', 'kash-naturals'),
        'id'            => 'footer-2',
        'description'   => __('Second footer column widget area.', 'kash-naturals'),
        'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widget-title">',
        'after_title'   => '</h4>',
    ));
}
add_action('widgets_init', 'kash_naturals_widgets_init');
