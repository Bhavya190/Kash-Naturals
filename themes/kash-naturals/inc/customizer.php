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
    if (class_exists('WP_Customize_Color_Control')) {
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'kash_noticebar_bg', array(
            'label'    => __('Background Color', 'kash-naturals'),
            'section'  => 'kash_noticebar_options',
        )));
    }

    // Notice Bar Text & Icon Color
    $wp_customize->add_setting('kash_noticebar_color', array(
        'default'           => '#ffffff',
        'sanitize_callback' => 'sanitize_hex_color',
    ));
    if (class_exists('WP_Customize_Color_Control')) {
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'kash_noticebar_color', array(
            'label'    => __('Text & Icon Color', 'kash-naturals'),
            'section'  => 'kash_noticebar_options',
        )));
    }

    // Default Items Data (Items 1 & 2 active by default, Items 3 & 4 optional for 3 or 4 column layout)
    $default_items = array(
        1 => array('icon' => 'fa-solid fa-truck-fast', 'text' => 'Free Shipping Above - ₹499', 'link' => ''),
        2 => array('icon' => 'fa-solid fa-tag', 'text' => 'New User get 10% Welcome10 code', 'link' => ''),
        3 => array('icon' => 'fa-solid fa-spa', 'text' => '', 'link' => ''),
        4 => array('icon' => 'fa-brands fa-amazon', 'text' => '', 'link' => ''),
    );

    foreach ($default_items as $i => $item) {
        $is_optional = ($i > 2) ? ' (Optional)' : '';

        // Icon Class
        $wp_customize->add_setting("kash_noticebar_item{$i}_icon", array(
            'default'           => $item['icon'],
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control("kash_noticebar_item{$i}_icon", array(
            'label'       => sprintf(__('Item %d Icon (FontAwesome Class)%s', 'kash-naturals'), $i, $is_optional),
            'description' => __('e.g., fa-solid fa-truck-fast, fa-solid fa-tag, fa-solid fa-leaf, fa-brands fa-amazon', 'kash-naturals'),
            'section'     => 'kash_noticebar_options',
            'type'        => 'text',
        ));

        // Text
        $wp_customize->add_setting("kash_noticebar_item{$i}_text", array(
            'default'           => $item['text'],
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control("kash_noticebar_item{$i}_text", array(
            'label'       => sprintf(__('Item %d Text%s', 'kash-naturals'), $i, $is_optional),
            'description' => ($i > 2) ? __('Leave empty if you only want 2 columns in the notice bar.', 'kash-naturals') : '',
            'section'     => 'kash_noticebar_options',
            'type'        => 'text',
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

    // =========================================================================
    // Homepage Hero Carousel Options
    // =========================================================================
    $wp_customize->add_section('kash_hero_options', array(
        'title'    => __('Homepage Hero Carousel Options', 'kash-naturals'),
        'priority' => 28,
    ));

    // Slide 1 Image
    $wp_customize->add_setting('kash_hero_slide1_image', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    if (class_exists('WP_Customize_Image_Control')) {
        $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'kash_hero_slide1_image', array(
            'label'       => __('Slide 1 Background Image', 'kash-naturals'),
            'description' => __('Default fallback: assets/images/hero-banner.jpg', 'kash-naturals'),
            'section'     => 'kash_hero_options',
        )));
    }

    // Slide 2 Video URL (MP4)
    $wp_customize->add_setting('kash_hero_slide2_video', array(
        'default'           => 'https://assets.mixkit.co/videos/preview/mixkit-liquid-chocolate-being-poured-over-hazelnuts-41554-large.mp4',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control('kash_hero_slide2_video', array(
        'label'       => __('Slide 2 Video URL (MP4 Direct Link)', 'kash-naturals'),
        'description' => __('Direct .mp4 URL for the background video slide.', 'kash-naturals'),
        'section'     => 'kash_hero_options',
        'type'        => 'url',
    ));

    // Slide 2 Poster / Fallback Image
    $wp_customize->add_setting('kash_hero_slide2_image', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    if (class_exists('WP_Customize_Image_Control')) {
        $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'kash_hero_slide2_image', array(
            'label'       => __('Slide 2 Video Poster / Fallback Image', 'kash-naturals'),
            'description' => __('Default fallback: assets/images/chocolate-dragees.jpg', 'kash-naturals'),
            'section'     => 'kash_hero_options',
        )));
    }

    // Slide 3 Image
    $wp_customize->add_setting('kash_hero_slide3_image', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    if (class_exists('WP_Customize_Image_Control')) {
        $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'kash_hero_slide3_image', array(
            'label'       => __('Slide 3 Background Image (Gift Hampers)', 'kash-naturals'),
            'description' => __('Default fallback: assets/images/gift-combos.jpg', 'kash-naturals'),
            'section'     => 'kash_hero_options',
        )));
    }

    // Slide 4 Image
    $wp_customize->add_setting('kash_hero_slide4_image', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    if (class_exists('WP_Customize_Image_Control')) {
        $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'kash_hero_slide4_image', array(
            'label'       => __('Slide 4 Background Image (Mukhwas)', 'kash-naturals'),
            'description' => __('Default fallback: assets/images/mouth-fresheners.jpg', 'kash-naturals'),
            'section'     => 'kash_hero_options',
        )));
    }

    // Slide Duration
    $wp_customize->add_setting('kash_hero_autoplay_speed', array(
        'default'           => 6000,
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control('kash_hero_autoplay_speed', array(
        'label'       => __('Autoplay Duration (milliseconds)', 'kash-naturals'),
        'description' => __('Default 6000ms = 6 seconds per slide.', 'kash-naturals'),
        'section'     => 'kash_hero_options',
        'type'        => 'number',
        'input_attrs' => array(
            'min'  => 3000,
            'max'  => 15000,
            'step' => 500,
        ),
    ));
}
add_action('customize_register', 'kash_naturals_customize_register');

/**
 * Sanitize Checkbox
 */
function kash_sanitize_checkbox($checked) {
    return (isset($checked) && true === (bool) $checked);
}
