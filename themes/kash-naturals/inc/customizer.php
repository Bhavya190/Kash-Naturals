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

    // Default Product Video URL
    $wp_customize->add_setting('kash_default_product_video', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control('kash_default_product_video', array(
        'label'       => __('Default Product Video URL (Optional)', 'kash-naturals'),
        'description' => __('Optional default MP4, YouTube, or Vimeo link for products that do not have their own video set in WooCommerce.', 'kash-naturals'),
        'section'     => 'kash_brand_options',
        'type'        => 'url',
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
       HOMEPAGE COLLECTION SHOWCASE (Categories Below Hero)
       ========================================================================== */
    $wp_customize->add_section('kash_collection_showcase_options', array(
        'title'       => __('Homepage Category Showcase (Below Hero)', 'kash-naturals'),
        'description' => __('Manage the circular category collection displayed right below the hero banner. Choose how many categories to show, select specific categories, or let WooCommerce show them automatically.', 'kash-naturals'),
        'priority'    => 28,
    ));

    // Number of Categories to Show (Select dropdown)
    $wp_customize->add_setting('kash_cats_count', array(
        'default'           => '4',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('kash_cats_count', array(
        'label'       => __('Number of Categories to Show', 'kash-naturals'),
        'description' => __('Choose how many circular categories to show on the homepage. On desktop they center evenly; on mobile and tablet they scroll horizontally.', 'kash-naturals'),
        'section'     => 'kash_collection_showcase_options',
        'type'        => 'select',
        'choices'     => array(
            '1' => __('1 Category (Centered)', 'kash-naturals'),
            '2' => __('2 Categories', 'kash-naturals'),
            '3' => __('3 Categories', 'kash-naturals'),
            '4' => __('4 Categories (Default)', 'kash-naturals'),
            '5' => __('5 Categories', 'kash-naturals'),
            '6' => __('6 Categories', 'kash-naturals'),
        ),
    ));

    // Hide Empty Categories Checkbox
    $wp_customize->add_setting('kash_cats_hide_empty', array(
        'default'           => false,
        'sanitize_callback' => 'kash_sanitize_checkbox',
    ));
    $wp_customize->add_control('kash_cats_hide_empty', array(
        'label'       => __('Hide Empty Categories (0 Products)', 'kash-naturals'),
        'description' => __('Check to automatically exclude categories that have 0 products.', 'kash-naturals'),
        'section'     => 'kash_collection_showcase_options',
        'type'        => 'checkbox',
    ));

    // Fetch list of WooCommerce categories for the dropdown selectors
    $cat_options = array(
        ''     => __('-- Auto: Use Next Available Category --', 'kash-naturals'),
        'none' => __('-- Do Not Show (Hide This Slot) --', 'kash-naturals'),
    );
    if (taxonomy_exists('product_cat')) {
        $all_prod_terms = get_terms(array(
            'taxonomy'   => 'product_cat',
            'hide_empty' => false,
            'parent'     => 0,
        ));
        if (!empty($all_prod_terms) && !is_wp_error($all_prod_terms)) {
            foreach ($all_prod_terms as $term_obj) {
                $cat_options[$term_obj->slug] = $term_obj->name . ' (' . $term_obj->count . ' items)';
            }
        }
    }

    // Up to 6 Category Slots
    for ($c_i = 1; $c_i <= 6; $c_i++) {
        // Dropdown to pick category
        $wp_customize->add_setting("kash_cat_slot_{$c_i}", array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control("kash_cat_slot_{$c_i}", array(
            'label'       => sprintf(__('Card %d: Choose Category', 'kash-naturals'), $c_i),
            'description' => __('Select a category, leave as Auto, or choose Do Not Show to hide this slot.', 'kash-naturals'),
            'section'     => 'kash_collection_showcase_options',
            'type'        => 'select',
            'choices'     => $cat_options,
        ));

        // Optional Image Override
        $wp_customize->add_setting("kash_cat_image_{$c_i}", array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ));
        if (class_exists('WP_Customize_Image_Control')) {
            $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, "kash_cat_image_{$c_i}", array(
                'label'       => sprintf(__('Card %d: Custom Image (Optional)', 'kash-naturals'), $c_i),
                'description' => __('Defaults to the category thumbnail uploaded in Products > Categories.', 'kash-naturals'),
                'section'     => 'kash_collection_showcase_options',
            )));
        }

        // Optional Title Override
        $wp_customize->add_setting("kash_cat_title_{$c_i}", array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control("kash_cat_title_{$c_i}", array(
            'label'       => sprintf(__('Card %d: Custom Title (Optional)', 'kash-naturals'), $c_i),
            'description' => __('Leave blank to use the category name from WooCommerce.', 'kash-naturals'),
            'section'     => 'kash_collection_showcase_options',
            'type'        => 'text',
        ));
    }

    /* ==========================================================================
       HOMEPAGE CURATED PRODUCT CATALOG SHOWCASE (Light Background, 3 in 1 Row)
       ========================================================================== */
    $wp_customize->add_section('kash_curated_collections_options', array(
        'title'       => __('Homepage Product Catalog (3 in 1 Row)', 'kash-naturals'),
        'description' => __('Display products from a selected collection (e.g. Home collection) in a luxury 3-in-1-row grid on the light background.', 'kash-naturals'),
        'priority'    => 30,
    ));

    // Enable / Disable
    $wp_customize->add_setting('kash_curated_enable', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    $wp_customize->add_control('kash_curated_enable', array(
        'label'       => __('Enable Product Catalog Section', 'kash-naturals'),
        'description' => __('Display this section on the homepage.', 'kash-naturals'),
        'section'     => 'kash_curated_collections_options',
        'type'        => 'checkbox',
    ));

    // Subheading
    $wp_customize->add_setting('kash_curated_subheading', array(
        'default'           => __('— SIGNATURE SELECTION —', 'kash-naturals'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('kash_curated_subheading', array(
        'label'    => __('Section Subheading / Eyebrow', 'kash-naturals'),
        'section'  => 'kash_curated_collections_options',
        'type'     => 'text',
    ));

    // Heading
    $wp_customize->add_setting('kash_curated_heading', array(
        'default'           => __('Curated For The Royal Taste', 'kash-naturals'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('kash_curated_heading', array(
        'label'    => __('Section Main Title', 'kash-naturals'),
        'section'  => 'kash_curated_collections_options',
        'type'     => 'text',
    ));

    // Description
    $wp_customize->add_setting('kash_curated_desc', array(
        'default'           => __('Explore our signature handcrafted royal digestives, artisanal Belgian chocolates, and luxury treats.', 'kash-naturals'),
        'sanitize_callback' => 'sanitize_textarea_field',
    ));
    $wp_customize->add_control('kash_curated_desc', array(
        'label'    => __('Section Description', 'kash-naturals'),
        'section'  => 'kash_curated_collections_options',
        'type'     => 'textarea',
    ));

    // Category Selector
    $curated_cat_choices = array(
        'home' => __('Home Collection (product-category/home/)', 'kash-naturals'),
        'all'  => __('-- All Products (Latest) --', 'kash-naturals'),
    );
    if (!empty($cat_options)) {
        foreach ($cat_options as $c_slug => $c_label) {
            if (!empty($c_slug) && $c_slug !== 'none' && !isset($curated_cat_choices[$c_slug])) {
                $curated_cat_choices[$c_slug] = $c_label;
            }
        }
    }

    $wp_customize->add_setting('kash_curated_product_cat', array(
        'default'           => 'home',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('kash_curated_product_cat', array(
        'label'       => __('Product Collection / Category', 'kash-naturals'),
        'description' => __('Select which WooCommerce category to query products from. Default: Home collection.', 'kash-naturals'),
        'section'     => 'kash_curated_collections_options',
        'type'        => 'select',
        'choices'     => $curated_cat_choices,
    ));

    // Custom Category Slug (Manual override if needed)
    $wp_customize->add_setting('kash_curated_product_cat_slug', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('kash_curated_product_cat_slug', array(
        'label'       => __('Custom Category Slug (Optional Override)', 'kash-naturals'),
        'description' => __('Enter a specific category slug (e.g. "home"). If left empty, uses the dropdown selection above.', 'kash-naturals'),
        'section'     => 'kash_curated_collections_options',
        'type'        => 'text',
    ));

    // Number of products to display (Free numeric input - numbers can be anything)
    $wp_customize->add_setting('kash_curated_products_count', array(
        'default'           => 3,
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control('kash_curated_products_count', array(
        'label'       => __('Number of Products to Display', 'kash-naturals'),
        'description' => __('Enter any number of products you want to display (e.g. 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 12, etc.). Numbers can be anything.', 'kash-naturals'),
        'section'     => 'kash_curated_collections_options',
        'type'        => 'number',
        'input_attrs' => array(
            'min'         => 1,
            'max'         => 999,
            'step'        => 1,
            'placeholder' => '3',
            'style'       => 'width: 120px;',
        ),
    ));

    // Sort order
    $wp_customize->add_setting('kash_curated_orderby', array(
        'default'           => 'menu_order',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('kash_curated_orderby', array(
        'label'       => __('Product Sort Order', 'kash-naturals'),
        'section'     => 'kash_curated_collections_options',
        'type'        => 'select',
        'choices'     => array(
            'menu_order' => __('Menu Order / Default', 'kash-naturals'),
            'date'       => __('Newest First', 'kash-naturals'),
            'popularity' => __('Best Sellers / Popularity', 'kash-naturals'),
            'rating'     => __('Highest Rated', 'kash-naturals'),
            'price'      => __('Price: Low to High', 'kash-naturals'),
            'price-desc' => __('Price: High to Low', 'kash-naturals'),
        ),
    ));

    // Show View All Button
    $wp_customize->add_setting('kash_curated_show_view_all', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    $wp_customize->add_control('kash_curated_show_view_all', array(
        'label'       => __('Show "View All" Button at Bottom', 'kash-naturals'),
        'section'     => 'kash_curated_collections_options',
        'type'        => 'checkbox',
    ));

    // View All Button Text
    $wp_customize->add_setting('kash_curated_view_all_text', array(
        'default'           => __('VIEW ALL HOME PRODUCTS', 'kash-naturals'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('kash_curated_view_all_text', array(
        'label'       => __('View All Button Text', 'kash-naturals'),
        'section'     => 'kash_curated_collections_options',
        'type'        => 'text',
    ));

    // View All Button Custom URL
    $wp_customize->add_setting('kash_curated_view_all_url', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control('kash_curated_view_all_url', array(
        'label'       => __('Custom Button URL (Optional)', 'kash-naturals'),
        'description' => __('Leave blank to automatically link to the chosen WooCommerce collection (e.g. /product-category/home/).', 'kash-naturals'),
        'section'     => 'kash_curated_collections_options',
        'type'        => 'url',
    ));

    /* ==========================================================================
       HOMEPAGE PROMOTIONAL PRODUCT DEAL / SPOTLIGHT SECTION
       ========================================================================== */
    $wp_customize->add_section('kash_deal_promo_options', array(
        'title'       => __('Homepage Product Deal & Promotion', 'kash-naturals'),
        'description' => __('Promote a featured product with discount offer, countdown timer, and badges right after the Amazon section.', 'kash-naturals'),
        'priority'    => 33,
    ));

    // Enable / Disable Section
    $wp_customize->add_setting('kash_promo_enable', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    $wp_customize->add_control('kash_promo_enable', array(
        'label'       => __('Enable Promotional Deal Section', 'kash-naturals'),
        'description' => __('Show this promotional product spotlight on the homepage.', 'kash-naturals'),
        'section'     => 'kash_deal_promo_options',
        'type'        => 'checkbox',
    ));

    // WooCommerce Products Choice Dropdown
    $all_wc_products = array(
        ''     => __('-- Auto: First On-Sale / Recent Product --', 'kash-naturals'),
        'none' => __('-- Do Not Use Auto-Product (Manual Only) --', 'kash-naturals'),
    );
    if (class_exists('WooCommerce')) {
        $found_prods = get_posts(array(
            'post_type'      => 'product',
            'post_status'    => 'publish',
            'posts_per_page' => 100,
            'orderby'        => 'title',
            'order'          => 'ASC',
        ));
        if (!empty($found_prods)) {
            foreach ($found_prods as $fp) {
                $all_wc_products[$fp->ID] = $fp->post_title . ' (ID: ' . $fp->ID . ')';
            }
        }
    }

    $wp_customize->add_setting('kash_promo_product_id', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('kash_promo_product_id', array(
        'label'       => __('Select Product to Promote', 'kash-naturals'),
        'description' => __('Choose any WooCommerce product to automatically pull its title, image, price, sale price, and link.', 'kash-naturals'),
        'section'     => 'kash_deal_promo_options',
        'type'        => 'select',
        'choices'     => $all_wc_products,
    ));

    // Eyebrow Tag
    $wp_customize->add_setting('kash_promo_eyebrow', array(
        'default'           => __('⚡ LIMITED TIME EXCLUSIVE OFFER', 'kash-naturals'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('kash_promo_eyebrow', array(
        'label'       => __('Eyebrow Tag', 'kash-naturals'),
        'section'     => 'kash_deal_promo_options',
        'type'        => 'text',
    ));

    // Custom Title Override
    $wp_customize->add_setting('kash_promo_title', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('kash_promo_title', array(
        'label'       => __('Product Title (Optional Override)', 'kash-naturals'),
        'description' => __('Leave blank to use the selected product name automatically.', 'kash-naturals'),
        'section'     => 'kash_deal_promo_options',
        'type'        => 'text',
    ));

    // Custom Description Override
    $wp_customize->add_setting('kash_promo_desc', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_textarea_field',
    ));
    $wp_customize->add_control('kash_promo_desc', array(
        'label'       => __('Description / Flavor Profile (Optional Override)', 'kash-naturals'),
        'description' => __('Leave blank to use the product excerpt automatically.', 'kash-naturals'),
        'section'     => 'kash_deal_promo_options',
        'type'        => 'textarea',
    ));

    // Discount Badge Text
    $wp_customize->add_setting('kash_promo_badge', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('kash_promo_badge', array(
        'label'       => __('Discount Badge Text (Optional)', 'kash-naturals'),
        'description' => __('E.g. "FLAT 25% OFF" or "SAVE 30%". Leave blank to calculate automatically.', 'kash-naturals'),
        'section'     => 'kash_deal_promo_options',
        'type'        => 'text',
    ));

    // Deal Price (Sale Price) Override
    $wp_customize->add_setting('kash_promo_deal_price', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('kash_promo_deal_price', array(
        'label'       => __('Promotional Deal Price (Optional)', 'kash-naturals'),
        'description' => __('E.g. "₹179". Leave blank to use WooCommerce sale price automatically.', 'kash-naturals'),
        'section'     => 'kash_deal_promo_options',
        'type'        => 'text',
    ));

    // Regular / Old Price Override
    $wp_customize->add_setting('kash_promo_old_price', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('kash_promo_old_price', array(
        'label'       => __('Original / Regular Price (Crossed Out)', 'kash-naturals'),
        'description' => __('E.g. "₹249". Leave blank to use WooCommerce regular price automatically.', 'kash-naturals'),
        'section'     => 'kash_deal_promo_options',
        'type'        => 'text',
    ));

    // Savings Ribbon Text
    $wp_customize->add_setting('kash_promo_save_text', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('kash_promo_save_text', array(
        'label'       => __('Savings Ribbon Text (Optional)', 'kash-naturals'),
        'description' => __('E.g. "SPECIAL OFFER • SAVE 28%". Leave blank to generate automatically.', 'kash-naturals'),
        'section'     => 'kash_deal_promo_options',
        'type'        => 'text',
    ));

    // Custom Image Override
    $wp_customize->add_setting('kash_promo_image', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    if (class_exists('WP_Customize_Image_Control')) {
        $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'kash_promo_image', array(
            'label'       => __('Custom Product Image (Optional)', 'kash-naturals'),
            'description' => __('Upload an image or leave blank to use the product image.', 'kash-naturals'),
            'section'     => 'kash_deal_promo_options',
        )));
    }

    // Urgency Note
    $wp_customize->add_setting('kash_promo_urgency_text', array(
        'default'           => __('🔥 High Demand: Only 14 packs left at this promotional discount!', 'kash-naturals'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('kash_promo_urgency_text', array(
        'label'       => __('Stock / Urgency Note', 'kash-naturals'),
        'section'     => 'kash_deal_promo_options',
        'type'        => 'text',
    ));

    // Countdown Timer Hours
    $wp_customize->add_setting('kash_promo_timer_hours', array(
        'default'           => '24',
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control('kash_promo_timer_hours', array(
        'label'       => __('Countdown Timer Duration (Hours)', 'kash-naturals'),
        'description' => __('Duration in hours for the limited-time offer countdown (e.g. 24 or 12).', 'kash-naturals'),
        'section'     => 'kash_deal_promo_options',
        'type'        => 'number',
    ));

    // Button Text
    $wp_customize->add_setting('kash_promo_btn_text', array(
        'default'           => __('CLAIM OFFER & BUY NOW', 'kash-naturals'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('kash_promo_btn_text', array(
        'label'       => __('Primary Button Text', 'kash-naturals'),
        'section'     => 'kash_deal_promo_options',
        'type'        => 'text',
    ));

    // Custom Button Link (Optional)
    $wp_customize->add_setting('kash_promo_btn_url', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control('kash_promo_btn_url', array(
        'label'       => __('Custom Button URL (Optional)', 'kash-naturals'),
        'description' => __('Leave blank to direct to product page or add to cart.', 'kash-naturals'),
        'section'     => 'kash_deal_promo_options',
        'type'        => 'text',
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

    /* ==========================================================================
       WELCOME NEWSLETTER POPUP MODAL
       ========================================================================== */
    $wp_customize->add_section('kash_newsletter_options', array(
        'title'       => __('Welcome Newsletter Popup Modal', 'kash-naturals'),
        'description' => __('Configure the welcome discount popup shown to visitors on the website.', 'kash-naturals'),
        'priority'    => 40,
    ));

    // Enable / Disable
    $wp_customize->add_setting('kash_newsletter_enable', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    $wp_customize->add_control('kash_newsletter_enable', array(
        'label'       => __('Enable Newsletter Popup', 'kash-naturals'),
        'description' => __('Shows to visitors on website load and refresh.', 'kash-naturals'),
        'section'     => 'kash_newsletter_options',
        'type'        => 'checkbox',
    ));

    // Delay in Seconds
    $wp_customize->add_setting('kash_newsletter_delay', array(
        'default'           => '3.5',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('kash_newsletter_delay', array(
        'label'       => __('Popup Trigger Delay (Seconds)', 'kash-naturals'),
        'description' => __('Number of seconds to wait after page load before displaying the popup (e.g. 3 or 5).', 'kash-naturals'),
        'section'     => 'kash_newsletter_options',
        'type'        => 'number',
    ));

    // Eyebrow Tag
    $wp_customize->add_setting('kash_newsletter_eyebrow', array(
        'default'           => __('🌿 ROYAL REWARDS CLUB', 'kash-naturals'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('kash_newsletter_eyebrow', array(
        'label'    => __('Eyebrow Tag', 'kash-naturals'),
        'section'  => 'kash_newsletter_options',
        'type'     => 'text',
    ));

    // Headline
    $wp_customize->add_setting('kash_newsletter_headline', array(
        'default'           => __('Unlock 10% Off Your First Order', 'kash-naturals'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('kash_newsletter_headline', array(
        'label'    => __('Popup Headline', 'kash-naturals'),
        'section'  => 'kash_newsletter_options',
        'type'     => 'text',
    ));

    // Description / Subtitle
    $wp_customize->add_setting('kash_newsletter_desc', array(
        'default'           => __('Subscribe to receive an instant 10% discount code, secret seasonal drop alerts & authentic artisanal mukhwas recipes.', 'kash-naturals'),
        'sanitize_callback' => 'sanitize_textarea_field',
    ));
    $wp_customize->add_control('kash_newsletter_desc', array(
        'label'    => __('Popup Subtitle / Description', 'kash-naturals'),
        'section'  => 'kash_newsletter_options',
        'type'     => 'textarea',
    ));

    // Offer Badge on Image
    $wp_customize->add_setting('kash_newsletter_badge', array(
        'default'           => __('SPECIAL 10% OFF', 'kash-naturals'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('kash_newsletter_badge', array(
        'label'    => __('Image Floating Badge Text', 'kash-naturals'),
        'section'  => 'kash_newsletter_options',
        'type'     => 'text',
    ));

    // Coupon Code Given
    $wp_customize->add_setting('kash_newsletter_coupon', array(
        'default'           => 'WELCOME10',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('kash_newsletter_coupon', array(
        'label'       => __('Coupon Code to Give Subscribers', 'kash-naturals'),
        'description' => __('This coupon code is displayed to the user immediately after they submit.', 'kash-naturals'),
        'section'     => 'kash_newsletter_options',
        'type'        => 'text',
    ));

    // Button Text
    $wp_customize->add_setting('kash_newsletter_btn_text', array(
        'default'           => __('CLAIM 10% DISCOUNT', 'kash-naturals'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('kash_newsletter_btn_text', array(
        'label'    => __('Submit Button Text', 'kash-naturals'),
        'section'  => 'kash_newsletter_options',
        'type'     => 'text',
    ));

    // Left Banner Image
    $wp_customize->add_setting('kash_newsletter_image', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    if (class_exists('WP_Customize_Image_Control')) {
        $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'kash_newsletter_image', array(
            'label'       => __('Popup Banner Image (Optional)', 'kash-naturals'),
            'description' => __('Upload an image for the left side of the popup or leave blank to use the default luxury hamper image.', 'kash-naturals'),
            'section'     => 'kash_newsletter_options',
        )));
    }

    /* ==========================================================================
       WHATSAPP FLOATING CHAT WIDGET
       ========================================================================== */
    $wp_customize->add_section('kash_whatsapp_options', array(
        'title'       => __('WhatsApp Chat Widget', 'kash-naturals'),
        'description' => __('Configure the floating WhatsApp contact button displayed across all pages of the website.', 'kash-naturals'),
        'priority'    => 42,
    ));

    // Enable / Disable
    $wp_customize->add_setting('kash_whatsapp_enable', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    $wp_customize->add_control('kash_whatsapp_enable', array(
        'label'       => __('Enable WhatsApp Widget', 'kash-naturals'),
        'description' => __('Display floating WhatsApp button site-wide.', 'kash-naturals'),
        'section'     => 'kash_whatsapp_options',
        'type'        => 'checkbox',
    ));

    // WhatsApp Phone Number
    $wp_customize->add_setting('kash_whatsapp_number', array(
        'default'           => '+91 98765 43210',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('kash_whatsapp_number', array(
        'label'       => __('WhatsApp Phone Number', 'kash-naturals'),
        'description' => __('Include country code (e.g. +91 98765 43210 or 919876543210). Spaces, dashes, and symbols are formatted automatically.', 'kash-naturals'),
        'section'     => 'kash_whatsapp_options',
        'type'        => 'text',
    ));

    // Pre-filled Message
    $wp_customize->add_setting('kash_whatsapp_message', array(
        'default'           => __('Hello Kash Naturals! I have an inquiry about your artisanal mukhwas and products.', 'kash-naturals'),
        'sanitize_callback' => 'sanitize_textarea_field',
    ));
    $wp_customize->add_control('kash_whatsapp_message', array(
        'label'       => __('Pre-filled Message', 'kash-naturals'),
        'description' => __('Message automatically drafted when a visitor clicks to start a WhatsApp chat.', 'kash-naturals'),
        'section'     => 'kash_whatsapp_options',
        'type'        => 'textarea',
    ));

    // Tooltip / Pill Badge Text (Optional)
    $wp_customize->add_setting('kash_whatsapp_tooltip', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('kash_whatsapp_tooltip', array(
        'label'       => __('Tooltip / Pill Text (Optional)', 'kash-naturals'),
        'description' => __('Leave blank to show only the circular WhatsApp icon (default).', 'kash-naturals'),
        'section'     => 'kash_whatsapp_options',
        'type'        => 'text',
    ));

    // Screen Position
    $wp_customize->add_setting('kash_whatsapp_position', array(
        'default'           => 'right',
        'sanitize_callback' => 'sanitize_key',
    ));
    $wp_customize->add_control('kash_whatsapp_position', array(
        'label'       => __('Screen Position', 'kash-naturals'),
        'section'     => 'kash_whatsapp_options',
        'type'        => 'select',
        'choices'     => array(
            'right' => __('Bottom Right (Recommended)', 'kash-naturals'),
            'left'  => __('Bottom Left', 'kash-naturals'),
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

/**
 * ============================================================================
 * HOMEPAGE PRODUCTS CATALOG: DIRECT WP-ADMIN MENU & EDIT PAGE SETTINGS
 * Allows entering ANY number of products directly from WordPress admin
 * ============================================================================
 */

/**
 * Add "Homepage Products Catalog" Admin Submenu under Appearance in WP Admin
 */
function kash_curated_admin_menu() {
    add_theme_page(
        __('Homepage Products Catalog Settings', 'kash-naturals'),
        __('Homepage Products Catalog', 'kash-naturals'),
        'edit_theme_options',
        'kash-curated-products',
        'kash_curated_render_admin_page'
    );
}
add_action('admin_menu', 'kash_curated_admin_menu');

/**
 * Render the dedicated WP Admin Settings Page
 */
function kash_curated_render_admin_page() {
    if (!current_user_can('edit_theme_options')) {
        return;
    }

    // Handle Form Submission
    if (isset($_POST['kash_save_curated']) && check_admin_referer('kash_curated_settings_nonce', 'kash_curated_nonce')) {
        if (isset($_POST['kash_curated_products_count'])) {
            $new_count = max(1, intval($_POST['kash_curated_products_count']));
            set_theme_mod('kash_curated_products_count', $new_count);
            
            // Also sync to front page post meta if front page exists
            $fp_id = (int) get_option('page_on_front');
            if ($fp_id) {
                update_post_meta($fp_id, '_kash_curated_products_count', $new_count);
            }
        }
        if (isset($_POST['kash_curated_product_cat'])) {
            set_theme_mod('kash_curated_product_cat', sanitize_text_field($_POST['kash_curated_product_cat']));
        }
        if (isset($_POST['kash_curated_product_cat_slug'])) {
            set_theme_mod('kash_curated_product_cat_slug', sanitize_title($_POST['kash_curated_product_cat_slug']));
        }
        if (isset($_POST['kash_curated_heading'])) {
            set_theme_mod('kash_curated_heading', sanitize_text_field($_POST['kash_curated_heading']));
        }
        if (isset($_POST['kash_curated_subheading'])) {
            set_theme_mod('kash_curated_subheading', sanitize_text_field($_POST['kash_curated_subheading']));
        }
        if (isset($_POST['kash_curated_desc'])) {
            set_theme_mod('kash_curated_desc', sanitize_textarea_field($_POST['kash_curated_desc']));
        }
        set_theme_mod('kash_curated_enable', isset($_POST['kash_curated_enable']) ? true : false);

        echo '<div class="notice notice-success is-dismissible" style="margin-top: 15px;"><p><strong>' . esc_html__('Settings saved successfully! Homepage product catalog updated.', 'kash-naturals') . '</strong></p></div>';
    }

    $current_count = intval(get_theme_mod('kash_curated_products_count', 3));
    $current_cat   = get_theme_mod('kash_curated_product_cat', 'home');
    $current_slug  = get_theme_mod('kash_curated_product_cat_slug', '');
    $current_head  = get_theme_mod('kash_curated_heading', __('Curated For The Royal Taste', 'kash-naturals'));
    $current_sub   = get_theme_mod('kash_curated_subheading', __('— SIGNATURE SELECTION —', 'kash-naturals'));
    $current_desc  = get_theme_mod('kash_curated_desc', __('Explore our signature handcrafted royal digestives, artisanal Belgian chocolates, and luxury treats.', 'kash-naturals'));
    $current_en    = (bool) get_theme_mod('kash_curated_enable', true);

    // Dynamic categories from WooCommerce
    $categories = array();
    if (class_exists('WooCommerce')) {
        $terms = get_terms(array('taxonomy' => 'product_cat', 'hide_empty' => false));
        if (!empty($terms) && !is_wp_error($terms)) {
            foreach ($terms as $t) {
                $categories[$t->slug] = $t->name . ' (' . $t->count . ' products)';
            }
        }
    }
    ?>
    <div class="wrap" style="max-width: 880px;">
        <h1 style="display: flex; align-items: center; gap: 10px; margin-bottom: 20px;">
            <span class="dashicons dashicons-products" style="font-size: 32px; width: 32px; height: 32px; color: #0a331a;"></span>
            <?php esc_html_e('Homepage Product Catalog Settings', 'kash-naturals'); ?>
        </h1>

        <div style="background: #ffffff; border-radius: 12px; border: 1px solid #ccd0d4; padding: 26px 32px; box-shadow: 0 3px 12px rgba(0,0,0,0.04);">
            <p style="font-size: 14px; color: #444; margin-top: 0; margin-bottom: 22px;">
                <?php esc_html_e('Manage the light-background Product Catalog section shown on your homepage. You can set any number of products to display, choose which category to show, and customize all titles.', 'kash-naturals'); ?>
            </p>

            <form method="post" action="">
                <?php wp_nonce_field('kash_curated_settings_nonce', 'kash_curated_nonce'); ?>

                <table class="form-table" style="margin-top: 0;">
                    <tr>
                        <th scope="row" style="width: 250px;">
                            <label for="kash_curated_products_count" style="font-weight: 700; font-size: 14px; color: #0a331a;">
                                <?php esc_html_e('Number of Products to Display', 'kash-naturals'); ?>
                            </label>
                        </th>
                        <td>
                            <input type="number" id="kash_curated_products_count" name="kash_curated_products_count" value="<?php echo esc_attr($current_count); ?>" min="1" max="999" step="1" style="width: 130px; font-size: 18px; font-weight: bold; padding: 8px 12px; border-radius: 6px; border: 2px solid #0a331a; color: #0a331a;" required />
                            <p class="description" style="margin-top: 6px; color: #555; font-size: 13px;">
                                <strong><?php esc_html_e('Numbers can be anything!', 'kash-naturals'); ?></strong> <?php esc_html_e('Enter any number you wish (e.g. 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 12, 15, etc.). Displayed in clean 3-in-a-row cards on desktop.', 'kash-naturals'); ?>
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <th scope="row">
                            <label for="kash_curated_product_cat" style="font-weight: 700; font-size: 14px;">
                                <?php esc_html_e('Collection / Category', 'kash-naturals'); ?>
                            </label>
                        </th>
                        <td>
                            <select id="kash_curated_product_cat" name="kash_curated_product_cat" style="min-width: 280px; font-size: 14px; padding: 6px 10px; border-radius: 6px;">
                                <option value="home" <?php selected($current_cat, 'home'); ?>><?php esc_html_e('Home Collection (slug: home)', 'kash-naturals'); ?></option>
                                <option value="all" <?php selected($current_cat, 'all'); ?>><?php esc_html_e('-- All Products (Latest) --', 'kash-naturals'); ?></option>
                                <?php foreach ($categories as $c_slug => $c_name) : 
                                    if ($c_slug === 'home') continue;
                                ?>
                                    <option value="<?php echo esc_attr($c_slug); ?>" <?php selected($current_cat, $c_slug); ?>><?php echo esc_html($c_name); ?></option>
                                <?php endforeach; ?>
                            </select>
                            <p class="description" style="margin-top: 6px; color: #555;">
                                <?php esc_html_e('Select the category to query products from. Default is Home (slug: home).', 'kash-naturals'); ?>
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <th scope="row">
                            <label for="kash_curated_product_cat_slug" style="font-weight: 700; font-size: 14px;">
                                <?php esc_html_e('Manual Category Slug (Optional)', 'kash-naturals'); ?>
                            </label>
                        </th>
                        <td>
                            <input type="text" id="kash_curated_product_cat_slug" name="kash_curated_product_cat_slug" value="<?php echo esc_attr($current_slug); ?>" placeholder="home" class="regular-text" style="border-radius: 6px;" />
                            <p class="description" style="margin-top: 6px; color: #555;">
                                <?php esc_html_e('Optional override if you want to type a specific slug like "home" directly.', 'kash-naturals'); ?>
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <th scope="row">
                            <label for="kash_curated_heading" style="font-weight: 700; font-size: 14px;">
                                <?php esc_html_e('Section Main Title', 'kash-naturals'); ?>
                            </label>
                        </th>
                        <td>
                            <input type="text" id="kash_curated_heading" name="kash_curated_heading" value="<?php echo esc_attr($current_head); ?>" class="regular-text" style="border-radius: 6px;" />
                        </td>
                    </tr>

                    <tr>
                        <th scope="row">
                            <label for="kash_curated_subheading" style="font-weight: 700; font-size: 14px;">
                                <?php esc_html_e('Subheading / Eyebrow', 'kash-naturals'); ?>
                            </label>
                        </th>
                        <td>
                            <input type="text" id="kash_curated_subheading" name="kash_curated_subheading" value="<?php echo esc_attr($current_sub); ?>" class="regular-text" style="border-radius: 6px;" />
                        </td>
                    </tr>

                    <tr>
                        <th scope="row">
                            <label for="kash_curated_desc" style="font-weight: 700; font-size: 14px;">
                                <?php esc_html_e('Section Description', 'kash-naturals'); ?>
                            </label>
                        </th>
                        <td>
                            <textarea id="kash_curated_desc" name="kash_curated_desc" rows="3" class="large-text" style="border-radius: 6px;"><?php echo esc_textarea($current_desc); ?></textarea>
                        </td>
                    </tr>

                    <tr>
                        <th scope="row">
                            <label for="kash_curated_enable" style="font-weight: 700; font-size: 14px;">
                                <?php esc_html_e('Enable Section', 'kash-naturals'); ?>
                            </label>
                        </th>
                        <td>
                            <label>
                                <input type="checkbox" id="kash_curated_enable" name="kash_curated_enable" value="1" <?php checked($current_en, true); ?> />
                                <?php esc_html_e('Display this product catalog section on the homepage', 'kash-naturals'); ?>
                            </label>
                        </td>
                    </tr>
                </table>

                <p class="submit" style="margin-top: 24px; padding-top: 18px; border-top: 1px solid #eee; display: flex; align-items: center; gap: 14px;">
                    <input type="submit" name="kash_save_curated" class="button button-primary button-large" value="<?php esc_attr_e('Save Changes', 'kash-naturals'); ?>" style="background: #0a331a; border-color: #0a331a; font-weight: bold; border-radius: 6px; padding: 6px 28px; font-size: 15px;" />
                    <a href="<?php echo esc_url(admin_url('customize.php?autofocus[section]=kash_curated_collections_options')); ?>" class="button button-secondary" style="border-radius: 6px; padding: 6px 16px;">
                        <?php esc_html_e('Open in Live Customizer', 'kash-naturals'); ?>
                    </a>
                </p>
            </form>
        </div>
    </div>
    <?php
}

/**
 * Add Meta Box on the Front Page editor in WP Admin
 */
function kash_curated_add_page_metabox() {
    global $post;
    if (!$post) {
        return;
    }

    $front_page_id = (int) get_option('page_on_front');
    $is_front_page = ($front_page_id && (int) $post->ID === $front_page_id);
    $slug          = $post->post_name;
    $template      = get_post_meta($post->ID, '_wp_page_template', true);

    if ($is_front_page || $slug === 'home' || $template === 'front-page.php') {
        add_meta_box(
            'kash_curated_homepage_metabox',
            __('Homepage Product Catalog Section Settings', 'kash-naturals'),
            'kash_curated_render_page_metabox',
            'page',
            'normal',
            'high'
        );
    }
}
add_action('add_meta_boxes', 'kash_curated_add_page_metabox');

function kash_curated_render_page_metabox($post) {
    wp_nonce_field('kash_curated_metabox_save', 'kash_curated_metabox_nonce');

    $meta_count = get_post_meta($post->ID, '_kash_curated_products_count', true);
    if ($meta_count === '' || $meta_count === false) {
        $count_val = get_theme_mod('kash_curated_products_count', 3);
    } else {
        $count_val = intval($meta_count);
    }

    $meta_cat = get_post_meta($post->ID, '_kash_curated_product_cat', true);
    if (empty($meta_cat)) {
        $meta_cat = get_theme_mod('kash_curated_product_cat', 'home');
    }
    ?>
    <div style="padding: 6px 0;">
        <p style="margin-bottom: 16px; color: #555; font-size: 13px;">
            <?php esc_html_e('Customize the products shown in the 3-in-a-row light collection catalog on the homepage.', 'kash-naturals'); ?>
        </p>

        <table class="form-table" style="margin: 0;">
            <tr>
                <th scope="row" style="width: 240px; font-weight: 600;">
                    <label for="kash_mb_products_count"><?php esc_html_e('Number of Products to Display', 'kash-naturals'); ?></label>
                </th>
                <td>
                    <input type="number" id="kash_mb_products_count" name="kash_curated_products_count" value="<?php echo esc_attr($count_val); ?>" min="1" max="999" step="1" style="width: 120px; font-weight: bold; font-size: 16px; padding: 5px 10px; border-radius: 4px;" />
                    <span class="description" style="margin-left: 12px; color: #555;">
                        <strong><?php esc_html_e('Numbers can be anything!', 'kash-naturals'); ?></strong> <?php esc_html_e('(e.g. 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 12, etc.)', 'kash-naturals'); ?>
                    </span>
                </td>
            </tr>
            <tr>
                <th scope="row" style="font-weight: 600;">
                    <label for="kash_mb_product_cat"><?php esc_html_e('Collection / Category Slug', 'kash-naturals'); ?></label>
                </th>
                <td>
                    <input type="text" id="kash_mb_product_cat" name="kash_curated_product_cat" value="<?php echo esc_attr($meta_cat); ?>" placeholder="home" class="regular-text" style="border-radius: 4px;" />
                    <span class="description" style="margin-left: 12px; color: #555;">
                        <?php esc_html_e('Default is "home" (product-category/home/).', 'kash-naturals'); ?>
                    </span>
                </td>
            </tr>
        </table>
    </div>
    <?php
}

function kash_curated_save_page_metabox($post_id) {
    if (!isset($_POST['kash_curated_metabox_nonce']) || !wp_verify_nonce($_POST['kash_curated_metabox_nonce'], 'kash_curated_metabox_save')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (!current_user_can('edit_page', $post_id)) {
        return;
    }

    if (isset($_POST['kash_curated_products_count'])) {
        $count = max(1, intval($_POST['kash_curated_products_count']));
        update_post_meta($post_id, '_kash_curated_products_count', $count);
        set_theme_mod('kash_curated_products_count', $count);
    }

    if (isset($_POST['kash_curated_product_cat'])) {
        $cat = sanitize_title($_POST['kash_curated_product_cat']);
        update_post_meta($post_id, '_kash_curated_product_cat', $cat);
        set_theme_mod('kash_curated_product_cat', $cat);
    }
}
add_action('save_post', 'kash_curated_save_page_metabox');
