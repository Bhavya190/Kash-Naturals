<?php
/**
 * WooCommerce Custom Enhancements and Filters
 *
 * @package KashNaturals
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Update Mini-Cart Fragments via AJAX
 */
function kash_naturals_woocommerce_header_add_to_cart_fragment($fragments) {
    if (!function_exists('WC') || !WC() || !isset(WC()->cart) || !is_object(WC()->cart)) {
        return $fragments;
    }

    ob_start();
    $count = WC()->cart->get_cart_contents_count();
    ?>
    <span class="cart-count-badge-orange cart-count-badge" id="mini-cart-count"><?php echo esc_html($count); ?></span>
    <?php
    $fragments['span#mini-cart-count'] = ob_get_clean();

    ob_start();
    ?>
    <div class="header-mini-cart-total" id="mini-cart-total">
        <?php echo WC()->cart->get_cart_subtotal(); ?>
    </div>
    <?php
    $fragments['div#mini-cart-total'] = ob_get_clean();

    return $fragments;
}
add_filter('woocommerce_add_to_cart_fragments', 'kash_naturals_woocommerce_header_add_to_cart_fragment');

/**
 * Add Custom "Artisanal Specs & Nutrition" Tab to WooCommerce Product Data in WP Admin
 */
function kash_naturals_add_product_data_tab($tabs) {
    $tabs['kash_artisanal_specs'] = array(
        'label'    => __('Artisanal Specs & Nutrition', 'kash-naturals'),
        'target'   => 'kash_artisanal_specs_panel',
        'class'    => array('show_if_simple', 'show_if_variable'),
        'priority' => 65,
    );
    return $tabs;
}
add_filter('woocommerce_product_data_tabs', 'kash_naturals_add_product_data_tab');

/**
 * Render Custom Fields in the "Artisanal Specs & Nutrition" Panel
 */
function kash_naturals_render_product_data_panel() {
    global $post;
    if (!function_exists('woocommerce_wp_text_input') || !function_exists('woocommerce_wp_textarea_input')) {
        return;
    }
    ?>
    <div id="kash_artisanal_specs_panel" class="panel woocommerce_options_panel hidden" style="padding: 15px 20px;">
        
        <div style="background: #f0f7f2; border: 1px solid #c2dec9; border-left: 4px solid #2C5F3E; padding: 12px 18px; margin-bottom: 20px; border-radius: 6px;">
            <strong style="color: #2C5F3E; font-size: 14px; display: block; margin-bottom: 4px;">
                <i class="dashicons dashicons-info"></i> <?php esc_html_e('Dynamic Product Details & Variations Guide', 'kash-naturals'); ?>
            </strong>
            <p style="margin: 0; color: #333; font-size: 13px; line-height: 1.6;">
                <strong><?php esc_html_e('Variable Products (e.g. 200 GM, 500 GM):', 'kash-naturals'); ?></strong> <?php esc_html_e('Manage pack weights, prices, stock, and photos under the "Variations" tab on the left. The product detail page automatically detects all variations and switches prices, regular prices, stock, and images in real time.', 'kash-naturals'); ?><br>
                <strong><?php esc_html_e('Artisanal Details:', 'kash-naturals'); ?></strong> <?php esc_html_e('Use the fields below to add custom Highlights, Ingredients, Nutrition facts, Storage, and Product Video dynamically.', 'kash-naturals'); ?>
            </p>
        </div>

        <h3 style="margin-top: 10px; color: #2C5F3E; border-bottom: 2px solid #e0eae1; padding-bottom: 8px;">
            <i class="dashicons dashicons-star-filled"></i> <?php esc_html_e('Top Highlights & Artisanal Profiling', 'kash-naturals'); ?>
        </h3>
        <p style="color: #666; font-size: 13px; margin-bottom: 12px;">
            <?php esc_html_e('Featured highlights displayed prominently under the product price and in the product story.', 'kash-naturals'); ?>
        </p>

        <?php
        woocommerce_wp_textarea_input(array(
            'id'          => '_product_highlights',
            'label'       => __('Key Highlights / Bullets', 'kash-naturals'),
            'placeholder' => __("Authentic Heritage Recipe\n100% All-Natural Ingredients\nZero Chemical Preservatives\nAirtight Glass Jar Packaging", 'kash-naturals'),
            'desc_tip'    => true,
            'description' => __('Enter top highlights or key bullet points (one per line) to display on the product detail page.', 'kash-naturals'),
            'style'       => 'height: 90px; width: 70%;',
        ));

        woocommerce_wp_text_input(array(
            'id'          => '_dietary_type',
            'label'       => __('Dietary / Speciality', 'kash-naturals'),
            'placeholder' => __('e.g. 100% Vegetarian, Preservative Free', 'kash-naturals'),
            'desc_tip'    => true,
            'description' => __('Speciality dietary classification (e.g. Vegetarian, Vegan, Gluten Free).', 'kash-naturals'),
            'style'       => 'width: 70%;',
        ));

        woocommerce_wp_text_input(array(
            'id'          => '_flavor_notes',
            'label'       => __('Tasting / Flavor Notes', 'kash-naturals'),
            'placeholder' => 'Sweet, Minty, Rose Aroma, Crispy',
            'desc_tip'    => true,
            'description' => __('Highlights displayed as tags under product title.', 'kash-naturals'),
            'style'       => 'width: 70%;',
        ));

        woocommerce_wp_text_input(array(
            'id'          => '_cacao_percentage',
            'label'       => __('Cacao % (for chocolates)', 'kash-naturals'),
            'placeholder' => '72%',
            'desc_tip'    => true,
            'description' => __('Optional cacao percentage tag.', 'kash-naturals'),
        ));

        woocommerce_wp_text_input(array(
            'id'          => '_cocoa_origin',
            'label'       => __('Origin Region', 'kash-naturals'),
            'placeholder' => 'Ecuador, Single Origin / Rajasthan, India',
            'desc_tip'    => true,
            'description' => __('Origin of cacao or spices.', 'kash-naturals'),
            'style'       => 'width: 70%;',
        ));
        ?>

        <h3 style="margin-top: 25px; color: #2C5F3E; border-bottom: 2px solid #e0eae1; padding-bottom: 8px;">
            <i class="dashicons dashicons-carrot"></i> <?php esc_html_e('Ingredients & Allergen Information', 'kash-naturals'); ?>
        </h3>
        <p style="color: #666; font-size: 13px; margin-bottom: 12px;">
            <?php esc_html_e('Displayed in the "Ingredients & Nutrition" tab on the product detail page. Leave empty to use default artisanal ingredients.', 'kash-naturals'); ?>
        </p>

        <?php
        // Ingredients List
        woocommerce_wp_textarea_input(array(
            'id'          => '_ingredients',
            'label'       => __('Ingredients List', 'kash-naturals'),
            'placeholder' => __('e.g. Fennel seeds, roasted coriander seeds, cardamom, silver foil, natural rose extract...', 'kash-naturals'),
            'desc_tip'    => true,
            'description' => __('Enter the full ingredient composition for this product.', 'kash-naturals'),
            'style'       => 'height: 90px; width: 70%;',
        ));

        // Allergen Advice
        woocommerce_wp_text_input(array(
            'id'          => '_allergen_advice',
            'label'       => __('Allergen Advice', 'kash-naturals'),
            'placeholder' => __('e.g. Processed in a clean facility that handles tree nuts, sesame, and dairy.', 'kash-naturals'),
            'desc_tip'    => true,
            'description' => __('Specific allergen advisory warnings for customers.', 'kash-naturals'),
            'style'       => 'width: 70%;',
        ));
        ?>

        <h3 style="margin-top: 25px; color: #2C5F3E; border-bottom: 2px solid #e0eae1; padding-bottom: 8px;">
            <i class="dashicons dashicons-chart-bar"></i> <?php esc_html_e('Nutritional Facts (Per 100g approx.)', 'kash-naturals'); ?>
        </h3>
        <p style="color: #666; font-size: 13px; margin-bottom: 12px;">
            <?php esc_html_e('Leave empty to display standard balanced nutritional values.', 'kash-naturals'); ?>
        </p>

        <?php
        woocommerce_wp_text_input(array(
            'id'          => '_nutrition_energy',
            'label'       => __('Energy Value', 'kash-naturals'),
            'placeholder' => '385 kcal',
            'desc_tip'    => true,
            'description' => __('Energy in kcal per 100g.', 'kash-naturals'),
        ));

        woocommerce_wp_text_input(array(
            'id'          => '_nutrition_protein',
            'label'       => __('Protein', 'kash-naturals'),
            'placeholder' => '4.2 g',
            'desc_tip'    => true,
            'description' => __('Protein in grams per 100g.', 'kash-naturals'),
        ));

        woocommerce_wp_text_input(array(
            'id'          => '_nutrition_carbs',
            'label'       => __('Carbohydrates', 'kash-naturals'),
            'placeholder' => '78.5 g',
            'desc_tip'    => true,
            'description' => __('Total Carbohydrates in grams per 100g.', 'kash-naturals'),
        ));

        woocommerce_wp_text_input(array(
            'id'          => '_nutrition_sugars',
            'label'       => __('Total Sugars', 'kash-naturals'),
            'placeholder' => '32.0 g',
            'desc_tip'    => true,
            'description' => __('Sugars in grams per 100g.', 'kash-naturals'),
        ));

        woocommerce_wp_text_input(array(
            'id'          => '_nutrition_fiber',
            'label'       => __('Dietary Fiber', 'kash-naturals'),
            'placeholder' => '12.4 g',
            'desc_tip'    => true,
            'description' => __('Fiber in grams per 100g.', 'kash-naturals'),
        ));

        woocommerce_wp_text_input(array(
            'id'          => '_nutrition_fat',
            'label'       => __('Total Fat', 'kash-naturals'),
            'placeholder' => '2.1 g',
            'desc_tip'    => true,
            'description' => __('Total Fat in grams per 100g.', 'kash-naturals'),
        ));
        ?>

        <h3 style="margin-top: 25px; color: #2C5F3E; border-bottom: 2px solid #e0eae1; padding-bottom: 8px;">
            <i class="dashicons dashicons-archive"></i> <?php esc_html_e('Storage & Shelf Life', 'kash-naturals'); ?>
        </h3>
        <p style="color: #666; font-size: 13px; margin-bottom: 12px;">
            <?php esc_html_e('Displayed in the "Storage & Shelf Life" tab on the product detail page.', 'kash-naturals'); ?>
        </p>

        <?php
        woocommerce_wp_text_input(array(
            'id'          => '_shelf_life',
            'label'       => __('Shelf Life', 'kash-naturals'),
            'placeholder' => __('9 Months from Manufacturing Date', 'kash-naturals'),
            'desc_tip'    => true,
            'description' => __('Duration product retains optimal taste and aroma.', 'kash-naturals'),
            'style'       => 'width: 70%;',
        ));

        woocommerce_wp_textarea_input(array(
            'id'          => '_storage_instructions',
            'label'       => __('Storage Instructions', 'kash-naturals'),
            'placeholder' => __('Store in a cool, dry place away from direct sunlight, heat, and moisture. Always use a dry spoon and close lid securely after opening.', 'kash-naturals'),
            'desc_tip'    => true,
            'description' => __('Care and storage instructions for keeping freshness.', 'kash-naturals'),
            'style'       => 'height: 80px; width: 70%;',
        ));
        ?>

        <h3 style="margin-top: 25px; color: #2C5F3E; border-bottom: 2px solid #e0eae1; padding-bottom: 8px;">
            <i class="dashicons dashicons-screenoptions"></i> <?php esc_html_e('Simple Product Pack Sizes (Only if not using Variations)', 'kash-naturals'); ?>
        </h3>
        <p style="color: #666; font-size: 13px; margin-bottom: 12px;">
            <?php esc_html_e('For Variable Products with variations like 200 GM / 500 GM, please use the "Variations" tab instead. These fields below are for Simple Products only.', 'kash-naturals'); ?>
        </p>

        <?php
        woocommerce_wp_text_input(array(
            'id'          => '_pack_size_1_label',
            'label'       => __('1st Pack Size Label', 'kash-naturals'),
            'placeholder' => __('e.g. 200g Glass Jar (leave empty to use weight)', 'kash-naturals'),
            'desc_tip'    => true,
            'description' => __('Custom label for primary pack size pill. If left empty, uses product weight.', 'kash-naturals'),
            'style'       => 'width: 70%;',
        ));

        woocommerce_wp_text_input(array(
            'id'          => '_pack_size_2_label',
            'label'       => __('2nd Pack Size Label (Optional)', 'kash-naturals'),
            'placeholder' => '500g Value Jar (Leave empty if none)',
            'desc_tip'    => true,
            'description' => __('Label for the second pack size pill button (leave empty if product has only one size).', 'kash-naturals'),
        ));

        woocommerce_wp_text_input(array(
            'id'          => '_pack_size_2_price',
            'label'       => __('2nd Pack Size Price (Optional)', 'kash-naturals'),
            'placeholder' => '399',
            'desc_tip'    => true,
            'description' => __('Price when the 2nd pack size pill is selected.', 'kash-naturals'),
        ));
        ?>

        <h3 style="margin-top: 25px; color: #2C5F3E; border-bottom: 2px solid #e0eae1; padding-bottom: 8px;">
            <i class="dashicons dashicons-video-alt3"></i> <?php esc_html_e('Product Video (MP4 / YouTube / Vimeo)', 'kash-naturals'); ?>
        </h3>
        <p style="color: #666; font-size: 13px; margin-bottom: 12px;">
            <?php esc_html_e('Add a product video that displays alongside product images in the gallery on the product detail page.', 'kash-naturals'); ?>
        </p>
        <?php

        woocommerce_wp_text_input(array(
            'id'          => '_product_video_url',
            'label'       => __('Product Video URL', 'kash-naturals'),
            'placeholder' => 'https://example.com/video.mp4 or https://youtu.be/XYZ',
            'desc_tip'    => true,
            'description' => __('Direct MP4 file URL from Media Library, or a YouTube / Vimeo link.', 'kash-naturals'),
            'style'       => 'width: 70%;',
        ));

        woocommerce_wp_text_input(array(
            'id'          => '_product_video_poster',
            'label'       => __('Video Thumbnail / Poster (Optional)', 'kash-naturals'),
            'placeholder' => 'https://example.com/poster.jpg',
            'desc_tip'    => true,
            'description' => __('Custom image URL for video preview thumbnail. Defaults to main product image.', 'kash-naturals'),
            'style'       => 'width: 70%;',
        ));
        ?>

    </div>
    <?php
}
add_action('woocommerce_product_data_panels', 'kash_naturals_render_product_data_panel');

/**
 * Save All Product Custom Fields
 */
function kash_naturals_save_custom_product_fields($post_id) {
    $fields = array(
        '_product_highlights'   => 'textarea',
        '_dietary_type'         => 'text',
        '_ingredients'          => 'textarea',
        '_allergen_advice'      => 'text',
        '_nutrition_energy'     => 'text',
        '_nutrition_protein'    => 'text',
        '_nutrition_carbs'      => 'text',
        '_nutrition_sugars'     => 'text',
        '_nutrition_fiber'      => 'text',
        '_nutrition_fat'        => 'text',
        '_shelf_life'           => 'text',
        '_storage_instructions' => 'textarea',
        '_flavor_notes'         => 'text',
        '_cacao_percentage'     => 'text',
        '_cocoa_origin'         => 'text',
        '_pack_size_1_label'    => 'text',
        '_pack_size_2_label'    => 'text',
        '_pack_size_2_price'    => 'text',
        '_product_video_url'    => 'text',
        '_product_video_poster' => 'text',
    );

    foreach ($fields as $field => $type) {
        if (isset($_POST[$field])) {
            $val = ($type === 'textarea') ? sanitize_textarea_field($_POST[$field]) : sanitize_text_field($_POST[$field]);
            update_post_meta($post_id, $field, $val);
        }
    }
}
add_action('woocommerce_process_product_meta', 'kash_naturals_save_custom_product_fields');

/**
 * Add Custom Fields to WooCommerce Product Categories (Collections) in WP Admin
 */
function kash_naturals_add_category_fields($taxonomy) {
    ?>
    <div class="form-field term-kash-subtitle-wrap">
        <label for="kash_cat_subtitle"><?php esc_html_e('Collection Subtitle / Tagline', 'kash-naturals'); ?></label>
        <textarea name="kash_cat_subtitle" id="kash_cat_subtitle" rows="3" cols="40" placeholder="<?php esc_attr_e('e.g. Authentic centuries-old royal digestive recipes crafted with 100% natural herbs...', 'kash-naturals'); ?>"></textarea>
        <p><?php esc_html_e('Displayed under the category title on homepage collection cards and archive headers.', 'kash-naturals'); ?></p>
    </div>
    <div class="form-field term-kash-badge-wrap">
        <label for="kash_cat_badge"><?php esc_html_e('Collection Badge Tag', 'kash-naturals'); ?></label>
        <input type="text" name="kash_cat_badge" id="kash_cat_badge" placeholder="<?php esc_attr_e('e.g. BESTSELLER, LUXURY TREATS, ROYAL GIFTING', 'kash-naturals'); ?>" value="" />
        <p><?php esc_html_e('Ribbon badge text shown on collection cards (leave empty for default).', 'kash-naturals'); ?></p>
    </div>
    <div class="form-field term-kash-btn-wrap">
        <label for="kash_cat_btn_text"><?php esc_html_e('Explore Button Text', 'kash-naturals'); ?></label>
        <input type="text" name="kash_cat_btn_text" id="kash_cat_btn_text" placeholder="<?php esc_attr_e('e.g. EXPLORE MUKHWAS, SHOP NOW', 'kash-naturals'); ?>" value="" />
        <p><?php esc_html_e('Custom label for the call-to-action button on collection cards.', 'kash-naturals'); ?></p>
    </div>
    <?php
}
add_action('product_cat_add_form_fields', 'kash_naturals_add_category_fields', 10, 1);

/**
 * Edit Custom Fields on WooCommerce Product Category Screen
 */
function kash_naturals_edit_category_fields($term, $taxonomy) {
    $cat_subtitle = get_term_meta($term->term_id, '_kash_cat_subtitle', true);
    $cat_badge    = get_term_meta($term->term_id, '_kash_cat_badge', true);
    $cat_btn      = get_term_meta($term->term_id, '_kash_cat_btn_text', true);
    ?>
    <tr class="form-field term-kash-subtitle-wrap">
        <th scope="row"><label for="kash_cat_subtitle"><?php esc_html_e('Collection Subtitle / Tagline', 'kash-naturals'); ?></label></th>
        <td>
            <textarea name="kash_cat_subtitle" id="kash_cat_subtitle" rows="3" cols="50" style="width:95%;" placeholder="<?php esc_attr_e('e.g. Authentic centuries-old royal recipes crafted with 100% natural herbs...', 'kash-naturals'); ?>"><?php echo esc_textarea($cat_subtitle); ?></textarea>
            <p class="description"><?php esc_html_e('Displayed under the category title on collection cards and archive headers.', 'kash-naturals'); ?></p>
        </td>
    </tr>
    <tr class="form-field term-kash-badge-wrap">
        <th scope="row"><label for="kash_cat_badge"><?php esc_html_e('Collection Badge Tag', 'kash-naturals'); ?></label></th>
        <td>
            <input type="text" name="kash_cat_badge" id="kash_cat_badge" value="<?php echo esc_attr($cat_badge); ?>" style="width:60%;" placeholder="<?php esc_attr_e('e.g. BESTSELLER, LUXURY TREATS, ROYAL GIFTING', 'kash-naturals'); ?>" />
            <p class="description"><?php esc_html_e('Ribbon badge text shown on collection cards (leave empty for default).', 'kash-naturals'); ?></p>
        </td>
    </tr>
    <tr class="form-field term-kash-btn-wrap">
        <th scope="row"><label for="kash_cat_btn_text"><?php esc_html_e('Explore Button Text', 'kash-naturals'); ?></label></th>
        <td>
            <input type="text" name="kash_cat_btn_text" id="kash_cat_btn_text" value="<?php echo esc_attr($cat_btn); ?>" style="width:60%;" placeholder="<?php esc_attr_e('e.g. EXPLORE MUKHWAS, SHOP NOW', 'kash-naturals'); ?>" />
            <p class="description"><?php esc_html_e('Custom label for the call-to-action button on collection cards.', 'kash-naturals'); ?></p>
        </td>
    </tr>
    <?php
}
add_action('product_cat_edit_form_fields', 'kash_naturals_edit_category_fields', 10, 2);

/**
 * Save WooCommerce Category Custom Fields
 */
function kash_naturals_save_category_fields($term_id, $tt_id = '') {
    if (isset($_POST['kash_cat_subtitle'])) {
        update_term_meta($term_id, '_kash_cat_subtitle', sanitize_textarea_field($_POST['kash_cat_subtitle']));
    }
    if (isset($_POST['kash_cat_badge'])) {
        update_term_meta($term_id, '_kash_cat_badge', sanitize_text_field($_POST['kash_cat_badge']));
    }
    if (isset($_POST['kash_cat_btn_text'])) {
        update_term_meta($term_id, '_kash_cat_btn_text', sanitize_text_field($_POST['kash_cat_btn_text']));
    }
}
add_action('created_product_cat', 'kash_naturals_save_category_fields', 10, 2);
add_action('edited_product_cat', 'kash_naturals_save_category_fields', 10, 2);

/**
 * Display Cacao % Tag on Shop Loop Product Cards
 */
function kash_naturals_show_cacao_tag_on_loop() {
    global $product;
    if (!$product || !is_object($product) || !method_exists($product, 'get_id')) {
        return;
    }
    $cacao = get_post_meta($product->get_id(), '_cacao_percentage', true);
    if (!empty($cacao)) {
        echo '<span class="cacao-badge"><i class="fa-solid fa-seedling"></i> ' . esc_html($cacao) . ' Cacao</span>';
    }
}
add_action('woocommerce_before_shop_loop_item_title', 'kash_naturals_show_cacao_tag_on_loop', 15);

/**
 * Custom Add to Cart Button Text
 */
function kash_naturals_custom_add_to_cart_text() {
    return __('Taste Now', 'kash-naturals');
}
add_filter('woocommerce_product_add_to_cart_text', 'kash_naturals_custom_add_to_cart_text');
add_filter('woocommerce_product_single_add_to_cart_text', 'kash_naturals_custom_add_to_cart_text');

/**
 * Remove Default WooCommerce Styles (we provide custom high-performance styling)
 */
// add_filter('woocommerce_enqueue_styles', '__return_false');

/**
 * Helper to build dynamic cart payload from WC()->cart with real-time stock check
 */
function kash_naturals_get_cart_payload() {
    if (!function_exists('WC') || !WC() || !isset(WC()->cart) || !is_object(WC()->cart)) {
        return array(
            'items'             => array(),
            'count'             => 0,
            'subtotal'          => 0,
            'subtotal_html'     => '₹0',
            'shipping'          => 'FREE',
            'shipping_cost'     => 0,
            'total'             => 0,
            'total_html'        => '₹0',
            'has_out_of_stock'  => false,
            'currency_symbol'   => function_exists('get_woocommerce_currency_symbol') ? get_woocommerce_currency_symbol() : '₹',
        );
    }

    $cart = WC()->cart;
    $items = array();
    $subtotal = 0;
    $has_out_of_stock = false;
    $currency_symbol = function_exists('get_woocommerce_currency_symbol') ? get_woocommerce_currency_symbol() : '₹';

    foreach ($cart->get_cart() as $cart_item_key => $cart_item) {
        $_product   = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
        $product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);

        if ($_product && $_product->exists() && $cart_item['quantity'] > 0) {
            $is_in_stock      = $_product->is_in_stock();
            $stock_status     = $_product->get_stock_status();
            $stock_qty        = $_product->managing_stock() ? $_product->get_stock_quantity() : null;
            $has_enough_stock = $_product->has_enough_stock($cart_item['quantity']);

            if (!$is_in_stock || !$has_enough_stock || $stock_status === 'outofstock') {
                $has_out_of_stock = true;
            }

            $item_price      = floatval($_product->get_price()) ?: 0;
            $item_line_total = $item_price * $cart_item['quantity'];
            $subtotal       += $item_line_total;

            $img_url = wp_get_attachment_image_url($_product->get_image_id(), 'kash-product-card');
            if (!$img_url && function_exists('wc_placeholder_img_src')) {
                $img_url = wc_placeholder_img_src();
            }

            $items[] = array(
                'key'               => $cart_item_key,
                'id'                => $product_id,
                'variation_id'      => !empty($cart_item['variation_id']) ? $cart_item['variation_id'] : 0,
                'name'              => $_product->get_name(),
                'price'             => $item_price,
                'price_formatted'   => $currency_symbol . number_format($item_price),
                'qty'               => $cart_item['quantity'],
                'subtotal'          => $item_line_total,
                'subtotal_formatted'=> $currency_symbol . number_format($item_line_total),
                'image'             => $img_url ?: '',
                'permalink'         => $_product->get_permalink(),
                'in_stock'          => $is_in_stock,
                'stock_status'      => $stock_status,
                'stock_quantity'    => $stock_qty,
                'has_enough_stock'  => $has_enough_stock,
                'max_qty'           => $_product->get_max_purchase_quantity(),
            );
        }
    }

    $shipping_fee = ($subtotal >= 999 || $subtotal == 0) ? 0 : 49;
    $total = $subtotal + $shipping_fee;

    return array(
        'items'            => $items,
        'count'            => $cart->get_cart_contents_count(),
        'subtotal'         => $subtotal,
        'subtotal_html'    => $currency_symbol . number_format($subtotal),
        'shipping'         => $shipping_fee === 0 ? 'FREE' : ($currency_symbol . $shipping_fee),
        'shipping_cost'    => $shipping_fee,
        'total'            => $total,
        'total_html'       => $currency_symbol . number_format($total),
        'has_out_of_stock' => $has_out_of_stock,
        'currency_symbol'  => $currency_symbol,
    );
}

/**
 * AJAX Handler: Get Real-Time Dynamic Cart Data with Stock Checks
 */
function kash_naturals_ajax_get_cart() {
    wp_send_json_success(kash_naturals_get_cart_payload());
}
add_action('wp_ajax_kash_get_cart', 'kash_naturals_ajax_get_cart');
add_action('wp_ajax_nopriv_kash_get_cart', 'kash_naturals_ajax_get_cart');

/**
 * AJAX Handler: Add to Cart with Dynamic Stock Validation and Variation Support
 */
function kash_naturals_ajax_add_to_cart() {
    $product_id   = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
    $variation_id = isset($_POST['variation_id']) ? intval($_POST['variation_id']) : 0;
    $quantity     = isset($_POST['quantity']) ? max(1, intval($_POST['quantity'])) : 1;
    $variations   = (isset($_POST['variation']) && is_array($_POST['variation'])) ? array_map('sanitize_text_field', $_POST['variation']) : array();

    if (!$product_id && !$variation_id) {
        wp_send_json_error(array('message' => __('Invalid product.', 'kash-naturals')));
    }

    $target_id = $variation_id ? $variation_id : $product_id;
    $target_product = wc_get_product($target_id);

    if (!$target_product || !$target_product->exists()) {
        wp_send_json_error(array('message' => __('Product does not exist or has been removed from shop.', 'kash-naturals')));
    }

    if (!$target_product->is_in_stock() || $target_product->get_stock_status() === 'outofstock') {
        wp_send_json_error(array(
            'error_type' => 'out_of_stock',
            'message'    => sprintf(__('Sorry, "%s" is currently out of stock and unavailable.', 'kash-naturals'), $target_product->get_name())
        ));
    }

    // Check stock quantity limits if managed
    if ($target_product->managing_stock() && !$target_product->backorders_allowed()) {
        $stock_qty = $target_product->get_stock_quantity();
        if ($stock_qty !== null && $quantity > $stock_qty) {
            wp_send_json_error(array(
                'error_type' => 'insufficient_stock',
                'message'    => sprintf(__('Only %d item(s) available in stock for "%s".', 'kash-naturals'), $stock_qty, $target_product->get_name())
            ));
        }
    }

    if (function_exists('WC') && WC()->cart) {
        if ($variation_id) {
            $parent_id = $product_id ? $product_id : $target_product->get_parent_id();
            WC()->cart->add_to_cart($parent_id, $quantity, $variation_id, $variations);
        } else {
            WC()->cart->add_to_cart($product_id, $quantity);
        }
    }

    wp_send_json_success(array(
        'message' => sprintf(__('Added "%s" to your shopping bag!', 'kash-naturals'), $target_product->get_name()),
        'cart'    => kash_naturals_get_cart_payload(),
    ));
}
add_action('wp_ajax_kash_add_to_cart', 'kash_naturals_ajax_add_to_cart');
add_action('wp_ajax_nopriv_kash_add_to_cart', 'kash_naturals_ajax_add_to_cart');

/**
 * AJAX Handler: Update Cart Item Quantity
 */
function kash_naturals_ajax_update_cart_qty() {
    $item_key   = isset($_POST['item_key']) ? sanitize_text_field($_POST['item_key']) : '';
    $product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
    $quantity   = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;

    if (!function_exists('WC') || !WC()->cart) {
        wp_send_json_error(array('message' => __('WooCommerce cart not initialized.', 'kash-naturals')));
    }

    $cart = WC()->cart;
    if ($item_key && isset($cart->get_cart()[$item_key])) {
        if ($quantity <= 0) {
            $cart->remove_cart_item($item_key);
        } else {
            $cart->set_quantity($item_key, $quantity, true);
        }
    } elseif ($product_id) {
        foreach ($cart->get_cart() as $key => $cart_item) {
            if ($cart_item['product_id'] == $product_id) {
                if ($quantity <= 0) {
                    $cart->remove_cart_item($key);
                } else {
                    $cart->set_quantity($key, $quantity, true);
                }
                break;
            }
        }
    }

    wp_send_json_success(array(
        'cart' => kash_naturals_get_cart_payload(),
    ));
}
add_action('wp_ajax_kash_update_cart_qty', 'kash_naturals_ajax_update_cart_qty');
add_action('wp_ajax_nopriv_kash_update_cart_qty', 'kash_naturals_ajax_update_cart_qty');

/**
 * AJAX Handler: Remove Single Cart Item
 */
function kash_naturals_ajax_remove_cart_item() {
    $item_key   = isset($_POST['item_key']) ? sanitize_text_field($_POST['item_key']) : '';
    $product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;

    if (function_exists('WC') && WC()->cart) {
        if ($item_key && isset(WC()->cart->get_cart()[$item_key])) {
            WC()->cart->remove_cart_item($item_key);
        } elseif ($product_id) {
            foreach (WC()->cart->get_cart() as $key => $cart_item) {
                if ($cart_item['product_id'] == $product_id) {
                    WC()->cart->remove_cart_item($key);
                    break;
                }
            }
        }
    }

    wp_send_json_success(array(
        'message' => __('Item removed from bag.', 'kash-naturals'),
        'cart'    => kash_naturals_get_cart_payload(),
    ));
}
add_action('wp_ajax_kash_remove_cart_item', 'kash_naturals_ajax_remove_cart_item');
add_action('wp_ajax_nopriv_kash_remove_cart_item', 'kash_naturals_ajax_remove_cart_item');

/**
 * AJAX Handler: Remove All Out-of-Stock Items from Cart
 */
function kash_naturals_ajax_remove_out_of_stock() {
    if (function_exists('WC') && WC()->cart) {
        $cart = WC()->cart;
        foreach ($cart->get_cart() as $cart_item_key => $cart_item) {
            $_product = $cart_item['data'];
            if (!$_product || !$_product->exists() || !$_product->is_in_stock() || $_product->get_stock_status() === 'outofstock') {
                $cart->remove_cart_item($cart_item_key);
            }
        }
    }

    wp_send_json_success(array(
        'message' => __('Unavailable items removed from your cart.', 'kash-naturals'),
        'cart'    => kash_naturals_get_cart_payload(),
    ));
}
add_action('wp_ajax_kash_remove_out_of_stock', 'kash_naturals_ajax_remove_out_of_stock');
add_action('wp_ajax_nopriv_kash_remove_out_of_stock', 'kash_naturals_ajax_remove_out_of_stock');

/**
 * Automatically bypass & disable WooCommerce 9.1+ "Coming Soon" / Site Visibility Mode
 * Prevents logged-out visitors on mobile/incognito from seeing the "Great things are on the horizon" screen.
 */
// 1. Exclude all customer requests from WooCommerce Coming Soon restrictions
add_filter('woocommerce_coming_soon_exclude', '__return_true', 99);

// 2. Ensure WooCommerce store visibility option is set to Live ('no') in database
add_action('init', function() {
    if (get_option('woocommerce_coming_soon') === 'yes') {
        update_option('woocommerce_coming_soon', 'no');
    }
}, 5);

// 3. Remove Coming Soon / Site Visibility badge from the WP Admin bar
add_action('admin_bar_menu', function($wp_admin_bar) {
    if (is_object($wp_admin_bar)) {
        $wp_admin_bar->remove_node('woocommerce-site-visibility-badge');
    }
}, 100);

/**
 * Remove default WooCommerce top coupon & login banners from checkout
 * (Kash Naturals provides a built-in artisanal coupon accordion inside the order summary)
 */
remove_action('woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10);
remove_action('woocommerce_before_checkout_form', 'woocommerce_checkout_login_form', 10);

