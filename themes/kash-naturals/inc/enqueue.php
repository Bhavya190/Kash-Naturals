<?php
/**
 * Enqueue scripts and styles.
 *
 * @package KashNaturals
 */

if (!defined('ABSPATH')) {
    exit;
}

function kash_naturals_scripts() {
    // Enqueue Google Fonts (Playfair Display for headings & Outfit for body text)
    wp_enqueue_style(
        'kash-google-fonts',
        'https://fonts.googleapis.com/css2?family=Caveat:wght@600;700&family=Outfit:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,500;0,600;0,700;0,800;1,400;1,600&display=swap',
        array(),
        null
    );

    // Enqueue Font Awesome for icons
    wp_enqueue_style(
        'kash-fontawesome',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css',
        array(),
        '6.5.1'
    );

    // Theme Main CSS
    wp_enqueue_style(
        'kash-main-style',
        get_template_directory_uri() . '/assets/css/main.css',
        array(),
        '1.0.0'
    );

    // WooCommerce Custom Overrides CSS if WooCommerce is active
    if (class_exists('WooCommerce')) {
        wp_enqueue_style(
            'kash-woocommerce-style',
            get_template_directory_uri() . '/assets/css/woocommerce.css',
            array('kash-main-style'),
            '1.0.0'
        );
    }

    // Main Theme JS
    wp_enqueue_script(
        'kash-main-script',
        get_template_directory_uri() . '/assets/js/main.js',
        array('jquery'),
        '1.0.0',
        true
    );

    // WooCommerce Custom JS
    if (class_exists('WooCommerce')) {
        wp_enqueue_script(
            'kash-woocommerce-script',
            get_template_directory_uri() . '/assets/js/woocommerce-custom.js',
            array('jquery', 'kash-main-script'),
            '1.0.0',
            true
        );

        // Pass AJAX URL and Cart Nonce to JS
        wp_localize_script('kash-woocommerce-script', 'kash_wc_params', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'cart_url' => wc_get_cart_url(),
            'checkout_url' => wc_get_checkout_url(),
            'currency_symbol' => get_woocommerce_currency_symbol(),
        ));
    }

    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'kash_naturals_scripts');
