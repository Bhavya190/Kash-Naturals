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
        'title'       => __('Homepage Hero Carousel Options', 'kash-naturals'),
        'description' => __('Customize images, background video, titles, subtitles, and button links for each hero slide.', 'kash-naturals'),
        'priority'    => 28,
    ));

    // --- SLIDE 1 ---
    $wp_customize->add_setting('kash_hero_slide1_image', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    if (class_exists('WP_Customize_Image_Control')) {
        $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'kash_hero_slide1_image', array(
            'label'       => __('Slide 1: Background Image', 'kash-naturals'),
            'description' => __('Default: assets/images/hero-banner.jpg', 'kash-naturals'),
            'section'     => 'kash_hero_options',
        )));
    }

    $wp_customize->add_setting('kash_hero_slide1_badge', array(
        'default'           => 'AUTHENTIC • 100% NATURAL • HYGIENIC',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('kash_hero_slide1_badge', array(
        'label'    => __('Slide 1: Badge Pill Text', 'kash-naturals'),
        'section'  => 'kash_hero_options',
        'type'     => 'text',
    ));

    $wp_customize->add_setting('kash_hero_slide1_title_top', array(
        'default'           => 'Freshness',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('kash_hero_slide1_title_top', array(
        'label'    => __('Slide 1: Title Line 1', 'kash-naturals'),
        'section'  => 'kash_hero_options',
        'type'     => 'text',
    ));

    $wp_customize->add_setting('kash_hero_slide1_title_bottom', array(
        'default'           => 'Crafted by Nature',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('kash_hero_slide1_title_bottom', array(
        'label'    => __('Slide 1: Title Line 2', 'kash-naturals'),
        'section'  => 'kash_hero_options',
        'type'     => 'text',
    ));

    $wp_customize->add_setting('kash_hero_slide1_subtitle', array(
        'default'           => 'Premium Handcrafted Mouth Fresheners, Chocolate Dragees & Kunafa Delights.',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('kash_hero_slide1_subtitle', array(
        'label'    => __('Slide 1: Subtitle', 'kash-naturals'),
        'section'  => 'kash_hero_options',
        'type'     => 'textarea',
    ));

    $wp_customize->add_setting('kash_hero_slide1_btn1_link', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control('kash_hero_slide1_btn1_link', array(
        'label'       => __('Slide 1: Primary Button Link URL', 'kash-naturals'),
        'description' => __('Default: /shop', 'kash-naturals'),
        'section'     => 'kash_hero_options',
        'type'        => 'url',
    ));

    // --- SLIDE 2 (VIDEO) ---
    $wp_customize->add_setting('kash_hero_slide2_video', array(
        'default'           => 'https://assets.mixkit.co/videos/preview/mixkit-liquid-chocolate-being-poured-over-hazelnuts-41554-large.mp4',
        'sanitize_callback' => 'esc_url_raw',
    ));
    if (class_exists('WP_Customize_Media_Control')) {
        $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'kash_hero_slide2_video', array(
            'label'       => __('Slide 2: Background Video (MP4)', 'kash-naturals'),
            'description' => __('Select or upload an MP4 video from Media Library, or paste an MP4 URL.', 'kash-naturals'),
            'section'     => 'kash_hero_options',
            'mime_type'   => 'video',
        )));
    } else {
        $wp_customize->add_control('kash_hero_slide2_video', array(
            'label'       => __('Slide 2: Background Video URL (MP4)', 'kash-naturals'),
            'description' => __('Direct .mp4 URL (Upload in Media > Add New and copy file URL).', 'kash-naturals'),
            'section'     => 'kash_hero_options',
            'type'        => 'url',
        ));
    }

    $wp_customize->add_setting('kash_hero_slide2_image', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    if (class_exists('WP_Customize_Image_Control')) {
        $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'kash_hero_slide2_image', array(
            'label'       => __('Slide 2: Video Poster / Fallback Image', 'kash-naturals'),
            'description' => __('Default: assets/images/chocolate-dragees.jpg', 'kash-naturals'),
            'section'     => 'kash_hero_options',
        )));
    }

    $wp_customize->add_setting('kash_hero_slide2_badge', array(
        'default'           => 'LUXURY BELGIAN CACAO & KUNAFA',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('kash_hero_slide2_badge', array(
        'label'    => __('Slide 2: Badge Pill Text', 'kash-naturals'),
        'section'  => 'kash_hero_options',
        'type'     => 'text',
    ));

    $wp_customize->add_setting('kash_hero_slide2_title_top', array(
        'default'           => 'Belgian Chocolate',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('kash_hero_slide2_title_top', array(
        'label'    => __('Slide 2: Title Line 1', 'kash-naturals'),
        'section'  => 'kash_hero_options',
        'type'     => 'text',
    ));

    $wp_customize->add_setting('kash_hero_slide2_title_bottom', array(
        'default'           => 'Roasted Dragees',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('kash_hero_slide2_title_bottom', array(
        'label'    => __('Slide 2: Title Line 2', 'kash-naturals'),
        'section'  => 'kash_hero_options',
        'type'     => 'text',
    ));

    $wp_customize->add_setting('kash_hero_slide2_subtitle', array(
        'default'           => 'Whole slow-roasted Californian almonds & hazelnuts enrobed in smooth velvety dark and milk chocolate.',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('kash_hero_slide2_subtitle', array(
        'label'    => __('Slide 2: Subtitle', 'kash-naturals'),
        'section'  => 'kash_hero_options',
        'type'     => 'textarea',
    ));

    $wp_customize->add_setting('kash_hero_slide2_btn1_link', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control('kash_hero_slide2_btn1_link', array(
        'label'       => __('Slide 2: Primary Button Link URL', 'kash-naturals'),
        'description' => __('Default: /product-category/chocolates/', 'kash-naturals'),
        'section'     => 'kash_hero_options',
        'type'        => 'url',
    ));

    // --- SLIDE 3 ---
    $wp_customize->add_setting('kash_hero_slide3_image', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    if (class_exists('WP_Customize_Image_Control')) {
        $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'kash_hero_slide3_image', array(
            'label'       => __('Slide 3: Background Image (Gift Hampers)', 'kash-naturals'),
            'description' => __('Default: assets/images/gift-combos.jpg', 'kash-naturals'),
            'section'     => 'kash_hero_options',
        )));
    }

    $wp_customize->add_setting('kash_hero_slide3_badge', array(
        'default'           => 'FESTIVE CELEBRATIONS & GIFTING',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('kash_hero_slide3_badge', array(
        'label'    => __('Slide 3: Badge Pill Text', 'kash-naturals'),
        'section'  => 'kash_hero_options',
        'type'     => 'text',
    ));

    $wp_customize->add_setting('kash_hero_slide3_title_top', array(
        'default'           => 'Celebration Packs',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('kash_hero_slide3_title_top', array(
        'label'    => __('Slide 3: Title Line 1', 'kash-naturals'),
        'section'  => 'kash_hero_options',
        'type'     => 'text',
    ));

    $wp_customize->add_setting('kash_hero_slide3_title_bottom', array(
        'default'           => 'Curated Gift Hampers',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('kash_hero_slide3_title_bottom', array(
        'label'    => __('Slide 3: Title Line 2', 'kash-naturals'),
        'section'  => 'kash_hero_options',
        'type'     => 'text',
    ));

    $wp_customize->add_setting('kash_hero_slide3_subtitle', array(
        'default'           => 'Make every festival and wedding unforgettable with custom luxury hampers and value combo sets.',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('kash_hero_slide3_subtitle', array(
        'label'    => __('Slide 3: Subtitle', 'kash-naturals'),
        'section'  => 'kash_hero_options',
        'type'     => 'textarea',
    ));

    $wp_customize->add_setting('kash_hero_slide3_btn1_link', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control('kash_hero_slide3_btn1_link', array(
        'label'       => __('Slide 3: Primary Button Link URL', 'kash-naturals'),
        'description' => __('Default: /product-category/gift-hampers/', 'kash-naturals'),
        'section'     => 'kash_hero_options',
        'type'        => 'url',
    ));

    // --- SLIDE 4 ---
    $wp_customize->add_setting('kash_hero_slide4_image', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    if (class_exists('WP_Customize_Image_Control')) {
        $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'kash_hero_slide4_image', array(
            'label'       => __('Slide 4: Background Image (Mukhwas)', 'kash-naturals'),
            'description' => __('Default: assets/images/mouth-fresheners.jpg', 'kash-naturals'),
            'section'     => 'kash_hero_options',
        )));
    }

    $wp_customize->add_setting('kash_hero_slide4_badge', array(
        'default'           => 'ROYAL INDIAN AFTER-MEAL DIGESTIVES',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('kash_hero_slide4_badge', array(
        'label'    => __('Slide 4: Badge Pill Text', 'kash-naturals'),
        'section'  => 'kash_hero_options',
        'type'     => 'text',
    ));

    $wp_customize->add_setting('kash_hero_slide4_title_top', array(
        'default'           => 'Royal Mukhwas',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('kash_hero_slide4_title_top', array(
        'label'    => __('Slide 4: Title Line 1', 'kash-naturals'),
        'section'  => 'kash_hero_options',
        'type'     => 'text',
    ));

    $wp_customize->add_setting('kash_hero_slide4_title_bottom', array(
        'default'           => 'Calcutta Paan & Saunf',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('kash_hero_slide4_title_bottom', array(
        'label'    => __('Slide 4: Title Line 2', 'kash-naturals'),
        'section'  => 'kash_hero_options',
        'type'     => 'text',
    ));

    $wp_customize->add_setting('kash_hero_slide4_subtitle', array(
        'default'           => 'Aromatic silver-coated cardamom, sweet fennel, and betel leaf blends prepared under cleanroom standards.',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('kash_hero_slide4_subtitle', array(
        'label'    => __('Slide 4: Subtitle', 'kash-naturals'),
        'section'  => 'kash_hero_options',
        'type'     => 'textarea',
    ));

    $wp_customize->add_setting('kash_hero_slide4_btn1_link', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control('kash_hero_slide4_btn1_link', array(
        'label'       => __('Slide 4: Primary Button Link URL', 'kash-naturals'),
        'description' => __('Default: /product-category/mukhwas/', 'kash-naturals'),
        'section'     => 'kash_hero_options',
        'type'        => 'url',
    ));

    // --- GENERAL CAROUSEL & STORE SETTINGS ---
    $wp_customize->add_setting('kash_hero_autoplay_speed', array(
        'default'           => 5500,
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control('kash_hero_autoplay_speed', array(
        'label'       => __('Autoplay Duration (milliseconds)', 'kash-naturals'),
        'description' => __('Default: 5500 (5.5 seconds per slide).', 'kash-naturals'),
        'section'     => 'kash_hero_options',
        'type'        => 'number',
        'input_attrs' => array(
            'min'  => 3000,
            'max'  => 15000,
            'step' => 500,
        ),
    ));

    $wp_customize->add_setting('kash_amazon_shop_link', array(
        'default'           => 'https://amazon.in',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control('kash_amazon_shop_link', array(
        'label'       => __('Amazon Store Link URL', 'kash-naturals'),
        'description' => __('Link for the "Available on Amazon" button in the hero banner.', 'kash-naturals'),
        'section'     => 'kash_hero_options',
        'type'        => 'url',
    ));

    /* ==========================================================================
       CUSTOMER REVIEWS / TESTIMONIALS SECTION
       ========================================================================== */
    $wp_customize->add_section('kash_testimonials_options', array(
        'title'       => __('Customer Reviews / Testimonials', 'kash-naturals'),
        'description' => __('Configure the customer review cards (images, ratings, single star, customer names, quotes).', 'kash-naturals'),
        'priority'    => 35,
    ));

    $wp_customize->add_setting('kash_testi_subheading', array(
        'default'           => '— TESTIMONIALS —',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('kash_testi_subheading', array(
        'label'    => __('Section Subheading', 'kash-naturals'),
        'section'  => 'kash_testimonials_options',
        'type'     => 'text',
    ));

    $wp_customize->add_setting('kash_testi_title', array(
        'default'           => __('What Our Customers Say', 'kash-naturals'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('kash_testi_title', array(
        'label'    => __('Section Main Title', 'kash-naturals'),
        'section'  => 'kash_testimonials_options',
        'type'     => 'text',
    ));

    $wp_customize->add_setting('kash_testi_desc', array(
        'default'           => __('Read real experiences from food lovers who savor our authentic digestives', 'kash-naturals'),
        'sanitize_callback' => 'sanitize_textarea_field',
    ));
    $wp_customize->add_control('kash_testi_desc', array(
        'label'    => __('Section Subtitle / Description', 'kash-naturals'),
        'section'  => 'kash_testimonials_options',
        'type'     => 'textarea',
    ));

    $defaults_testi = array(
        1 => array(
            'image'    => '',
            'rating'   => '5.0',
            'product'  => 'Royal Calcutta Paan Mukhwas',
            'title'    => 'UNMATCHED FRESHNESS',
            'quote'    => 'Excellent freshness and premium authentic taste. Every jar feels hand-picked and freshly packed with royal aroma! Loved all the varieties.',
            'author'   => 'Priya Sharma',
            'location' => 'Mumbai',
        ),
        2 => array(
            'image'    => '',
            'rating'   => '5.0',
            'product'  => 'Belgian Roasted Dragees',
            'title'    => 'MUST-TRY DRAGEES',
            'quote'    => 'Chocolate dragees are absolutely amazing! The smooth Belgian chocolate shell paired with roasted nuts is addictive. Must try for celebrations!',
            'author'   => 'Rahul Mehta',
            'location' => 'Delhi',
        ),
        3 => array(
            'image'    => '',
            'rating'   => '5.0',
            'product'  => 'Curated Gift Hamper',
            'title'    => 'ROYAL QUALITY',
            'quote'    => 'Best quality mukhwas I have ever ordered online. Zero preservatives and 100% natural ingredients make all the difference. Highly recommended!',
            'author'   => 'Neha Kapoor',
            'location' => 'Bengaluru',
        ),
    );

    foreach ($defaults_testi as $t_id => $t_def) {
        $wp_customize->add_setting("kash_testi{$t_id}_image", array(
            'default'           => $t_def['image'],
            'sanitize_callback' => 'esc_url_raw',
        ));
        if (class_exists('WP_Customize_Image_Control')) {
            $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, "kash_testi{$t_id}_image", array(
                'label'       => sprintf(__('Card %d: Customer / Product Photo', 'kash-naturals'), $t_id),
                'section'     => 'kash_testimonials_options',
            )));
        }

        $wp_customize->add_setting("kash_testi{$t_id}_rating", array(
            'default'           => $t_def['rating'],
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control("kash_testi{$t_id}_rating", array(
            'label'       => sprintf(__('Card %d: Rating Number (e.g. 5.0 with 1 Star)', 'kash-naturals'), $t_id),
            'section'     => 'kash_testimonials_options',
            'type'        => 'text',
        ));

        $wp_customize->add_setting("kash_testi{$t_id}_product", array(
            'default'           => $t_def['product'],
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control("kash_testi{$t_id}_product", array(
            'label'       => sprintf(__('Card %d: Product / Category Pill', 'kash-naturals'), $t_id),
            'section'     => 'kash_testimonials_options',
            'type'        => 'text',
        ));

        $wp_customize->add_setting("kash_testi{$t_id}_title", array(
            'default'           => $t_def['title'],
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control("kash_testi{$t_id}_title", array(
            'label'       => sprintf(__('Card %d: Review Headline / Title', 'kash-naturals'), $t_id),
            'section'     => 'kash_testimonials_options',
            'type'        => 'text',
        ));

        $wp_customize->add_setting("kash_testi{$t_id}_quote", array(
            'default'           => $t_def['quote'],
            'sanitize_callback' => 'sanitize_textarea_field',
        ));
        $wp_customize->add_control("kash_testi{$t_id}_quote", array(
            'label'       => sprintf(__('Card %d: Customer Review Text', 'kash-naturals'), $t_id),
            'section'     => 'kash_testimonials_options',
            'type'        => 'textarea',
        ));

        $wp_customize->add_setting("kash_testi{$t_id}_author", array(
            'default'           => $t_def['author'],
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control("kash_testi{$t_id}_author", array(
            'label'       => sprintf(__('Card %d: Customer Name', 'kash-naturals'), $t_id),
            'section'     => 'kash_testimonials_options',
            'type'        => 'text',
        ));

        $wp_customize->add_setting("kash_testi{$t_id}_location", array(
            'default'           => $t_def['location'],
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control("kash_testi{$t_id}_location", array(
            'label'       => sprintf(__('Card %d: Location / City', 'kash-naturals'), $t_id),
            'section'     => 'kash_testimonials_options',
            'type'        => 'text',
        ));
    }
}
add_action('customize_register', 'kash_naturals_customize_register');

/**
 * Sanitize Checkbox
 */
function kash_sanitize_checkbox($checked) {
    return (isset($checked) && true === (bool) $checked);
}
