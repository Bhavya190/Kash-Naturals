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
       HOMEPAGE COLLECTION SHOWCASE (Categories Below Hero)
       ========================================================================== */
    $wp_customize->add_section('kash_collection_showcase_options', array(
        'title'       => __('Homepage Category Showcase (Below Hero)', 'kash-naturals'),
        'description' => __('Manage the category collection cards displayed right below the hero banner. Choose how many cards to show, select specific categories, or let WooCommerce show them automatically.', 'kash-naturals'),
        'priority'    => 28,
    ));

    // Number of Categories to Show (Select dropdown)
    $wp_customize->add_setting('kash_cats_count', array(
        'default'           => '4',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('kash_cats_count', array(
        'label'       => __('Number of Category Cards to Show', 'kash-naturals'),
        'description' => __('Choose how many cards to show on the homepage. The grid automatically expands evenly so no empty space appears.', 'kash-naturals'),
        'section'     => 'kash_collection_showcase_options',
        'type'        => 'select',
        'choices'     => array(
            '1' => __('1 Card (Centered)', 'kash-naturals'),
            '2' => __('2 Cards (2 Equal Columns)', 'kash-naturals'),
            '3' => __('3 Cards (3 Equal Columns)', 'kash-naturals'),
            '4' => __('4 Cards (4 Equal Columns - Default)', 'kash-naturals'),
            '5' => __('5 Cards (5 Columns)', 'kash-naturals'),
            '6' => __('6 Cards (2 Rows of 3)', 'kash-naturals'),
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
