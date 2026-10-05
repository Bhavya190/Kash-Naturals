<?php
/**
 * WordPress Theme Customizer Settings
 *
 * @package KashNaturals
 */

if (!defined('ABSPATH')) {
    exit;
}

function kash_naturals_customize_register($wp_customize) {
    // Kash Naturals Settings Panel / Section
    $wp_customize->add_section('kash_noticebar_options', array(
        'title'    => __('Top Notice Bar Options', 'kash-naturals'),
        'priority' => 25,
    ));

    // Notice Bar Enable/Disable
    $wp_customize->add_setting('kash_noticebar_enable', array(
        'default'           => true,
        'sanitize_callback' => 'kash_sanitize_checkbox',
    ));
    $wp_customize->add_control('kash_noticebar_enable', array(
        'label'    => __('Enable Top Notice Bar', 'kash-naturals'),
        'section'  => 'kash_noticebar_options',
        'type'     => 'checkbox',
    ));

    // Notice Bar Background Color
    $wp_customize->add_setting('kash_noticebar_bg', array(
        'default'           => '#0a331a',
        'sanitize_callback' => 'sanitize_hex_color',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'kash_noticebar_bg', array(
        'label'    => __('Background Color', 'kash-naturals'),
        'section'  => 'kash_noticebar_options',
    )));

    // Notice Bar Text & Icon Color
    $wp_customize->add_setting('kash_noticebar_color', array(
        'default'           => '#ffffff',
        'sanitize_callback' => 'sanitize_hex_color',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'kash_noticebar_color', array(
        'label'    => __('Text & Icon Color', 'kash-naturals'),
        'section'  => 'kash_noticebar_options',
    )));

    // Default Items Data
    $default_items = array(
        1 => array('icon' => 'fa-solid fa-leaf', 'text' => 'Natural Ingredients', 'link' => ''),
        2 => array('icon' => 'fa-solid fa-spa', 'text' => 'Hygienically Manufactured', 'link' => ''),
        3 => array('icon' => 'fa-solid fa-truck-fast', 'text' => 'Pan India Delivery', 'link' => ''),
        4 => array('icon' => 'fa-brands fa-amazon', 'text' => 'Available on Amazon', 'link' => 'https://amazon.in'),
    );

    foreach ($default_items as $i => $item) {
        // Icon Class
        $wp_customize->add_setting("kash_noticebar_item{$i}_icon", array(
            'default'           => $item['icon'],
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control("kash_noticebar_item{$i}_icon", array(
            'label'       => sprintf(__('Item %d Icon (FontAwesome Class)', 'kash-naturals'), $i),
            'description' => __('e.g., fa-solid fa-leaf, fa-solid fa-truck-fast, fa-brands fa-amazon', 'kash-naturals'),
            'section'     => 'kash_noticebar_options',
            'type'        => 'text',
        ));

        // Text
        $wp_customize->add_setting("kash_noticebar_item{$i}_text", array(
            'default'           => $item['text'],
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control("kash_noticebar_item{$i}_text", array(
            'label'   => sprintf(__('Item %d Text', 'kash-naturals'), $i),
            'section' => 'kash_noticebar_options',
            'type'    => 'text',
        ));

        // Link
        $wp_customize->add_setting("kash_noticebar_item{$i}_link", array(
            'default'           => $item['link'],
            'sanitize_callback' => 'esc_url_raw',
        ));
        $wp_customize->add_control("kash_noticebar_item{$i}_link", array(
            'label'       => sprintf(__('Item %d Link URL (Optional)', 'kash-naturals'), $i),
            'section'     => 'kash_noticebar_options',
            'type'        => 'url',
        ));
    }

    // Kash Brand Options Section
    $wp_customize->add_section('kash_brand_options', array(
        'title'    => __('Kash General Options', 'kash-naturals'),
        'priority' => 30,
    ));

    // Top Bar Announcement Text
    $wp_customize->add_setting('kash_topbar_announcement', array(
        'default'           => __('✨ Free Express Shipping on Artisan Chocolate Orders Over $50 | 100% Organic & Single-Origin Cocoa', 'kash-naturals'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('kash_topbar_announcement', array(
        'label'    => __('Secondary Announcement Text', 'kash-naturals'),
        'section'  => 'kash_brand_options',
        'type'     => 'text',
    ));

    // Hero Tagline
    $wp_customize->add_setting('kash_hero_subtitle', array(
        'default'           => __('Pure. Artisanal. Handcrafted with Passion.', 'kash-naturals'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('kash_hero_subtitle', array(
        'label'    => __('Homepage Hero Subtitle', 'kash-naturals'),
        'section'  => 'kash_brand_options',
        'type'     => 'text',
    ));

    // Contact Phone
    $wp_customize->add_setting('kash_contact_phone', array(
        'default'           => '+1 (800) 527-4288',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('kash_contact_phone', array(
        'label'    => __('Customer Care Phone', 'kash-naturals'),
        'section'  => 'kash_brand_options',
        'type'     => 'text',
    ));
}
add_action('customize_register', 'kash_naturals_customize_register');

/**
 * Sanitize Checkbox
 */
function kash_sanitize_checkbox($checked) {
    return (isset($checked) && true === (bool) $checked);
}
