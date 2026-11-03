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
 * Add Custom "Product Details & Tabs Specs" Tab to WooCommerce Product Data in WP Admin
 */
function kash_naturals_add_product_data_tab($tabs) {
    $tabs['kash_artisanal_specs'] = array(
        'label'    => __('Product Details & Tabs Specs', 'kash-naturals'),
        'target'   => 'kash_artisanal_specs_panel',
        'class'    => array('show_if_simple', 'show_if_variable'),
        'priority' => 65,
    );
    return $tabs;
}
add_filter('woocommerce_product_data_tabs', 'kash_naturals_add_product_data_tab');

/**
 * Render Custom Fields in the "Product Details & Tabs Specs" Panel
 */
function kash_naturals_render_product_data_panel() {
    global $post;
    if (!function_exists('woocommerce_wp_text_input') || !function_exists('woocommerce_wp_textarea_input')) {
        return;
    }
    ?>
    <div id="kash_artisanal_specs_panel" class="panel woocommerce_options_panel hidden" style="padding: 15px 20px;">
        
        <div style="background: #f0f7f2; border: 1px solid #c2dec9; border-left: 4px solid #2C5F3E; padding: 14px 18px; margin-bottom: 22px; border-radius: 6px;">
            <strong style="color: #2C5F3E; font-size: 14px; display: block; margin-bottom: 4px;">
                <i class="dashicons dashicons-info"></i> <?php esc_html_e('Product Detail Tabs & Specifications Settings', 'kash-naturals'); ?>
            </strong>
            <p style="margin: 0; color: #333; font-size: 13px; line-height: 1.6;">
                <?php esc_html_e('Configure data for the 3 product tabs: "About This Item" (with the 3 static heritage cards), "Top Highlights" (the full specifications grid), and "Customer Reviews" (dynamically pulls approved customer reviews).', 'kash-naturals'); ?>
            </p>
        </div>

        <!-- 1. About This Item Tab Settings -->
        <h3 style="margin-top: 15px; color: #2C5F3E; border-bottom: 2px solid #e0eae1; padding-bottom: 8px;">
            <i class="dashicons dashicons-text-page"></i> <?php esc_html_e('1. "About This Item" Tab Content', 'kash-naturals'); ?>
        </h3>
        <p style="color: #666; font-size: 13px; margin-bottom: 12px;">
            <?php esc_html_e('Custom product story and bullet points for the "About This Item" tab. The 3 static heritage cards (Small-Batch Artisan Made, Food-Grade Glass Packaging, Digestive Wellness) display here automatically.', 'kash-naturals'); ?>
        </p>

        <?php
        woocommerce_wp_textarea_input(array(
            'id'          => '_about_this_item',
            'label'       => __('About / Story Description', 'kash-naturals'),
            'placeholder' => __('Leave empty to use main product description from editor above.', 'kash-naturals'),
            'desc_tip'    => true,
            'description' => __('1st Priority: Custom story or editorial overview shown in the "About This Item" tab. If filled, replaces the main product description to prevent duplicate content.', 'kash-naturals'),
            'style'       => 'height: 100px; width: 75%;',
        ));

        woocommerce_wp_textarea_input(array(
            'id'          => '_about_bullets',
            'label'       => __('About This Item Bullets', 'kash-naturals'),
            'placeholder' => __("TRADITIONAL MUKHWAS: Premium quality mouth freshener made with fennel and aromatic spices\nNATURAL INGREDIENTS: Crafted with carefully selected whole spices\nCONVENIENT PACKAGING: Sealed in airtight glass jar to maintain aroma and crunch", 'kash-naturals'),
            'desc_tip'    => true,
            'description' => __('1st Priority: Enter bullet points (one per line) for "About this item". If filled, replaces the main product description.', 'kash-naturals'),
            'style'       => 'height: 110px; width: 75%;',
        ));
        ?>

        <!-- 2. Top Highlights & Specifications Grid -->
        <h3 style="margin-top: 30px; color: #2C5F3E; border-bottom: 2px solid #e0eae1; padding-bottom: 8px;">
            <i class="dashicons dashicons-list-view"></i> <?php esc_html_e('2. "Top Highlights" & Specifications Grid', 'kash-naturals'); ?>
        </h3>
        <p style="color: #666; font-size: 13px; margin-bottom: 12px;">
            <?php esc_html_e('Values for the luxury Specifications Grid card shown in the "Top Highlights" tab. Fill in what applies to this product.', 'kash-naturals'); ?>
        </p>

        <?php
        woocommerce_wp_textarea_input(array(
            'id'          => '_product_highlights',
            'label'       => __('Key Highlights / Bullets', 'kash-naturals'),
            'placeholder' => __("Authentic Heritage Recipe\n100% All-Natural Ingredients\nZero Chemical Preservatives\nAirtight Glass Jar Packaging", 'kash-naturals'),
            'desc_tip'    => true,
            'description' => __('Enter top key highlights (one per line) displayed in the Top Highlights tab.', 'kash-naturals'),
            'style'       => 'height: 85px; width: 75%;',
        ));

        woocommerce_wp_text_input(array(
            'id'          => '_spec_flavour',
            'label'       => __('Flavour', 'kash-naturals'),
            'placeholder' => 'Sweet, Minty, Tangy & Crisp',
            'desc_tip'    => true,
            'description' => __('Flavour profile for the specifications table.', 'kash-naturals'),
            'style'       => 'width: 70%;',
        ));

        woocommerce_wp_text_input(array(
            'id'          => '_spec_brand',
            'label'       => __('Brand', 'kash-naturals'),
            'placeholder' => 'Kash Natural',
            'desc_tip'    => true,
            'description' => __('Brand name for specifications.', 'kash-naturals'),
            'style'       => 'width: 70%;',
        ));

        woocommerce_wp_text_input(array(
            'id'          => '_dietary_type',
            'label'       => __('Speciality / Dietary', 'kash-naturals'),
            'placeholder' => 'Vegetarian, 100% Natural, Preservative Free',
            'desc_tip'    => true,
            'description' => __('Speciality dietary classification.', 'kash-naturals'),
            'style'       => 'width: 70%;',
        ));

        woocommerce_wp_text_input(array(
            'id'          => '_spec_item_weight',
            'label'       => __('Item Weight', 'kash-naturals'),
            'placeholder' => '200 Grams',
            'desc_tip'    => true,
            'description' => __('Item weight text (leave empty to use product weight).', 'kash-naturals'),
            'style'       => 'width: 70%;',
        ));

        woocommerce_wp_text_input(array(
            'id'          => '_spec_package_info',
            'label'       => __('Package Information', 'kash-naturals'),
            'placeholder' => 'Airtight Food-Grade Glass Jar / Bag',
            'desc_tip'    => true,
            'description' => __('Container / package info.', 'kash-naturals'),
            'style'       => 'width: 70%;',
        ));

        woocommerce_wp_text_input(array(
            'id'          => '_spec_package_weight',
            'label'       => __('Package Weight', 'kash-naturals'),
            'placeholder' => '200 Grams',
            'desc_tip'    => true,
            'description' => __('Total package weight including container.', 'kash-naturals'),
            'style'       => 'width: 70%;',
        ));

        woocommerce_wp_text_input(array(
            'id'          => '_spec_number_of_pieces',
            'label'       => __('Number of Pieces', 'kash-naturals'),
            'placeholder' => '1',
            'desc_tip'    => true,
            'description' => __('Pieces count (e.g. 1 jar or 2 pieces).', 'kash-naturals'),
            'style'       => 'width: 70%;',
        ));

        woocommerce_wp_text_input(array(
            'id'          => '_spec_net_quantity',
            'label'       => __('Net Quantity', 'kash-naturals'),
            'placeholder' => '200.0 Grams',
            'desc_tip'    => true,
            'description' => __('Net product content quantity.', 'kash-naturals'),
            'style'       => 'width: 70%;',
        ));

        woocommerce_wp_text_input(array(
            'id'          => '_cocoa_origin',
            'label'       => __('Region / Country of Origin', 'kash-naturals'),
            'placeholder' => 'Asia, India',
            'desc_tip'    => true,
            'description' => __('Origin of product or ingredients.', 'kash-naturals'),
            'style'       => 'width: 70%;',
        ));

        woocommerce_wp_text_input(array(
            'id'          => '_spec_claim',
            'label'       => __('Cultivation / Quality Claim', 'kash-naturals'),
            'placeholder' => 'No Chemical Fertilizers, Artisanal Batch',
            'desc_tip'    => true,
            'description' => __('Purity or cultivation claim.', 'kash-naturals'),
            'style'       => 'width: 70%;',
        ));

        woocommerce_wp_text_input(array(
            'id'          => '_flavor_notes',
            'label'       => __('Tasting / Flavor Tags', 'kash-naturals'),
            'placeholder' => 'Sweet, Minty, Rose Aroma, Crispy',
            'desc_tip'    => true,
            'description' => __('Pills displayed under product price.', 'kash-naturals'),
            'style'       => 'width: 70%;',
        ));

        woocommerce_wp_text_input(array(
            'id'          => '_cacao_percentage',
            'label'       => __('Cacao % (for chocolates)', 'kash-naturals'),
            'placeholder' => '72%',
            'desc_tip'    => true,
            'description' => __('Optional cacao percentage tag.', 'kash-naturals'),
        ));
        ?>

        <!-- 3. Ingredients & Nutrition -->
        <h3 style="margin-top: 30px; color: #2C5F3E; border-bottom: 2px solid #e0eae1; padding-bottom: 8px;">
            <i class="dashicons dashicons-carrot"></i> <?php esc_html_e('3. Ingredients & Nutrition Facts', 'kash-naturals'); ?>
        </h3>

        <?php
        woocommerce_wp_textarea_input(array(
            'id'          => '_ingredients',
            'label'       => __('Ingredients List', 'kash-naturals'),
            'placeholder' => __('e.g. Fennel seeds, roasted coriander seeds, cardamom, silver foil, natural rose extract...', 'kash-naturals'),
            'desc_tip'    => true,
            'description' => __('Enter the full ingredient composition for this product.', 'kash-naturals'),
            'style'       => 'height: 90px; width: 70%;',
        ));

        woocommerce_wp_text_input(array(
            'id'          => '_allergen_advice',
            'label'       => __('Allergen Advice', 'kash-naturals'),
            'placeholder' => __('e.g. Processed in a clean facility that handles tree nuts, sesame, and dairy.', 'kash-naturals'),
            'desc_tip'    => true,
            'description' => __('Specific allergen advisory warnings for customers.', 'kash-naturals'),
            'style'       => 'width: 70%;',
        ));

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

        <!-- 4. Simple Product Pack Sizes -->
        <h3 style="margin-top: 30px; color: #2C5F3E; border-bottom: 2px solid #e0eae1; padding-bottom: 8px;">
            <i class="dashicons dashicons-screenoptions"></i> <?php esc_html_e('4. Simple Product Pack Sizes (If not using Variable Product)', 'kash-naturals'); ?>
        </h3>
        <p style="color: #666; font-size: 13px; margin-bottom: 12px;">
            <?php esc_html_e('For Variable Products (with variations like 200 GM, 500 GM), manage variations in the "Variations" tab on the left. These fields below are for Simple Products only.', 'kash-naturals'); ?>
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

        <!-- 5. Product Video -->
        <h3 style="margin-top: 30px; color: #2C5F3E; border-bottom: 2px solid #e0eae1; padding-bottom: 8px;">
            <i class="dashicons dashicons-video-alt3"></i> <?php esc_html_e('5. Product Video (MP4 / YouTube / Vimeo)', 'kash-naturals'); ?>
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
        '_about_this_item'       => 'textarea',
        '_about_bullets'         => 'textarea',
        '_product_highlights'    => 'textarea',
        '_spec_flavour'          => 'text',
        '_spec_brand'            => 'text',
        '_dietary_type'          => 'text',
        '_spec_item_weight'      => 'text',
        '_spec_package_info'     => 'text',
        '_spec_package_weight'   => 'text',
        '_spec_number_of_pieces' => 'text',
        '_spec_net_quantity'     => 'text',
        '_cocoa_origin'          => 'text',
        '_spec_claim'            => 'text',
        '_flavor_notes'          => 'text',
        '_cacao_percentage'      => 'text',
        '_ingredients'           => 'textarea',
        '_allergen_advice'       => 'text',
        '_nutrition_energy'      => 'text',
        '_nutrition_protein'     => 'text',
        '_nutrition_carbs'       => 'text',
        '_nutrition_sugars'      => 'text',
        '_nutrition_fiber'       => 'text',
        '_nutrition_fat'         => 'text',
        '_shelf_life'            => 'text',
        '_storage_instructions'  => 'textarea',
        '_pack_size_1_label'     => 'text',
        '_pack_size_2_label'     => 'text',
        '_pack_size_2_price'     => 'text',
        '_product_video_url'     => 'text',
        '_product_video_poster'  => 'text',
    );

    foreach ($fields as $field => $type) {
        if (isset($_POST[$field])) {
            if ($field === '_about_this_item' || $field === '_ingredients') {
                $val = wp_kses_post(wp_unslash($_POST[$field]));
            } elseif ($field === '_about_bullets' || $field === '_product_highlights') {
                $raw = wp_unslash($_POST[$field]);
                $raw = preg_replace('/<table\b[^>]*>.*?<\/table>/is', '', $raw);
                $lines = explode("\n", str_replace("\r", "", $raw));
                $cleaned = array();
                foreach ($lines as $line) {
                    $clean_line = trim(wp_strip_all_tags($line));
                    if (!empty($clean_line) && strlen($clean_line) > 3) {
                        $cleaned[] = $clean_line;
                    }
                }
                $val = implode("\n", $cleaned);
            } elseif ($type === 'textarea') {
                $val = sanitize_textarea_field(wp_unslash($_POST[$field]));
            } else {
                $val = sanitize_text_field(wp_unslash($_POST[$field]));
            }
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
 * Retrieve clean variations array for a product (checks available variations and children directly)
 *
 * @param WC_Product|int $product_or_id
 * @return array
 */
function kash_get_product_variations_data($product_or_id) {
    $product = is_numeric($product_or_id) ? wc_get_product($product_or_id) : $product_or_id;
    if (!$product || !is_a($product, 'WC_Product')) {
        return array();
    }

    if (!$product->is_type('variable')) {
        return array();
    }

    $variations_list = array();
    $main_img = wp_get_attachment_image_url($product->get_image_id(), 'kash-product-card');
    if (!$main_img && function_exists('wc_placeholder_img_src')) {
        $main_img = wc_placeholder_img_src();
    }

    // 1. Try get_available_variations
    if (method_exists($product, 'get_available_variations')) {
        $av_vars = $product->get_available_variations();
        if (!empty($av_vars) && is_array($av_vars)) {
            foreach ($av_vars as $v) {
                $vid = isset($v['variation_id']) ? intval($v['variation_id']) : 0;
                $v_obj = $vid ? wc_get_product($vid) : null;
                if (!$v_obj) continue;

                $attr_labels = array();
                if (!empty($v['attributes'])) {
                    foreach ($v['attributes'] as $attr_k => $attr_v) {
                        if ($attr_v === '' || $attr_v === null) continue;
                        $tax_k = str_replace('attribute_', '', $attr_k);
                        if (taxonomy_exists($tax_k)) {
                            $t = get_term_by('slug', $attr_v, $tax_k);
                            $attr_labels[] = ($t && !is_wp_error($t)) ? $t->name : $attr_v;
                        } else {
                            $attr_labels[] = $attr_v;
                        }
                    }
                }
                $v_label = !empty($attr_labels) ? implode(' - ', $attr_labels) : '';
                if (empty($v_label)) {
                    if (method_exists($v_obj, 'get_formatted_variation_attributes')) {
                        $v_label = $v_obj->get_formatted_variation_attributes(true);
                    }
                    if (!$v_label) {
                        $w = $v_obj->get_weight();
                        $v_label = $w ? ($w . 'g') : $v_obj->get_name();
                    }
                }

                $v_price = floatval($v['display_price']) ?: floatval($v_obj->get_price()) ?: floatval($product->get_price());
                $v_reg   = floatval($v['display_regular_price']) ?: floatval($v_obj->get_regular_price()) ?: $v_price;
                $v_img   = (!empty($v['image']['src']) && strpos($v['image']['src'], 'placeholder') === false) ? $v['image']['src'] : $main_img;

                $variations_list[] = array(
                    'id'            => $vid,
                    'label'         => $v_label,
                    'price'         => $v_price,
                    'price_html'    => '₹' . number_format($v_price),
                    'regular_price' => $v_reg,
                    'in_stock'      => !empty($v['is_in_stock']),
                    'stock_status'  => $v_obj->get_stock_status(),
                    'image'         => $v_img ?: $main_img,
                    'attributes'    => !empty($v['attributes']) ? $v['attributes'] : array(),
                );
            }
        }
    }

    // 2. If get_available_variations returned empty, fallback to direct children
    if (empty($variations_list) && method_exists($product, 'get_children')) {
        $child_ids = $product->get_children();
        if (!empty($child_ids)) {
            foreach ($child_ids as $cid) {
                $v_obj = wc_get_product($cid);
                if ($v_obj && $v_obj->is_type('variation')) {
                    $attr = $v_obj->get_variation_attributes();
                    $attr_labels = array();
                    if (!empty($attr)) {
                        foreach ($attr as $attr_k => $attr_v) {
                            if ($attr_v === '' || $attr_v === null) continue;
                            $tax_k = str_replace('attribute_', '', $attr_k);
                            if (taxonomy_exists($tax_k)) {
                                $t = get_term_by('slug', $attr_v, $tax_k);
                                $attr_labels[] = ($t && !is_wp_error($t)) ? $t->name : $attr_v;
                            } else {
                                $attr_labels[] = $attr_v;
                            }
                        }
                    }
                    $v_label = !empty($attr_labels) ? implode(' - ', $attr_labels) : '';
                    if (empty($v_label) && method_exists($v_obj, 'get_formatted_variation_attributes')) {
                        $v_label = $v_obj->get_formatted_variation_attributes(true);
                    }
                    if (empty($v_label)) {
                        $w = $v_obj->get_weight();
                        $v_label = $w ? ($w . 'g') : $v_obj->get_name();
                    }

                    $v_price = floatval($v_obj->get_price()) ?: floatval($product->get_price());
                    $v_reg   = floatval($v_obj->get_regular_price()) ?: $v_price;
                    $v_img_id = $v_obj->get_image_id();
                    $v_img = $v_img_id ? wp_get_attachment_image_url($v_img_id, 'kash-product-card') : $main_img;

                    $variations_list[] = array(
                        'id'            => intval($cid),
                        'label'         => $v_label,
                        'price'         => $v_price,
                        'price_html'    => '₹' . number_format($v_price),
                        'regular_price' => $v_reg,
                        'in_stock'      => $v_obj->is_in_stock(),
                        'stock_status'  => $v_obj->get_stock_status(),
                        'image'         => $v_img ?: $main_img,
                        'attributes'    => $v_obj->get_variation_attributes() ?: array(),
                    );
                }
            }
        }
    }

    return $variations_list;
}

/**
 * AJAX Handler: Get variations for a product on demand
 */
function kash_naturals_ajax_get_variations() {
    $product_id = isset($_REQUEST['product_id']) ? intval($_REQUEST['product_id']) : 0;
    if (!$product_id) {
        wp_send_json_error(array('message' => 'Invalid product.'));
    }
    $product = wc_get_product($product_id);
    if (!$product) {
        wp_send_json_error(array('message' => 'Product not found.'));
    }

    $variations = kash_get_product_variations_data($product);
    $img_url = wp_get_attachment_image_url($product->get_image_id(), 'kash-product-card');

    wp_send_json_success(array(
        'id'          => $product->get_id(),
        'name'        => $product->get_name(),
        'image'       => $img_url ?: '',
        'price'       => floatval($product->get_price()) ?: 0,
        'is_variable' => !empty($variations),
        'variations'  => $variations,
    ));
}
add_action('wp_ajax_kash_get_variations', 'kash_naturals_ajax_get_variations');
add_action('wp_ajax_nopriv_kash_get_variations', 'kash_naturals_ajax_get_variations');

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

        WC()->cart->calculate_totals();
        if (method_exists(WC()->cart, 'maybe_set_cart_cookies')) {
            WC()->cart->maybe_set_cart_cookies();
        }
        if (WC()->session && method_exists(WC()->session, 'set_customer_session_cookie')) {
            WC()->session->set_customer_session_cookie(true);
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
    $item_key     = isset($_POST['item_key']) ? sanitize_text_field(wp_unslash($_POST['item_key'])) : '';
    $product_id   = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
    $variation_id = isset($_POST['variation_id']) ? intval($_POST['variation_id']) : 0;
    $quantity     = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;

    if (!function_exists('WC') || !WC()->cart) {
        wp_send_json_error(array('message' => __('WooCommerce cart not initialized.', 'kash-naturals')));
    }

    $cart = WC()->cart;
    $handled = false;

    // 1. Try by exact item_key
    if ($item_key && isset($cart->get_cart()[$item_key])) {
        if ($quantity <= 0) {
            $cart->remove_cart_item($item_key);
        } else {
            $cart->set_quantity($item_key, $quantity, true);
        }
        $handled = true;
    }

    // 2. Search by key, variation_id, or product_id
    if (!$handled) {
        foreach ($cart->get_cart() as $key => $cart_item) {
            $matches = false;
            if ($item_key && $key === $item_key) {
                $matches = true;
            } elseif ($variation_id && !empty($cart_item['variation_id']) && $cart_item['variation_id'] == $variation_id) {
                $matches = true;
            } elseif ($product_id && ($cart_item['product_id'] == $product_id || (!empty($cart_item['variation_id']) && $cart_item['variation_id'] == $product_id))) {
                $matches = true;
            }

            if ($matches) {
                if ($quantity <= 0) {
                    $cart->remove_cart_item($key);
                } else {
                    $cart->set_quantity($key, $quantity, true);
                }
                $handled = true;
                break;
            }
        }
    }

    $cart->calculate_totals();
    if (method_exists($cart, 'maybe_set_cart_cookies')) {
        $cart->maybe_set_cart_cookies();
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
    $item_key     = isset($_POST['item_key']) ? sanitize_text_field(wp_unslash($_POST['item_key'])) : '';
    $product_id   = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
    $variation_id = isset($_POST['variation_id']) ? intval($_POST['variation_id']) : 0;

    $removed = false;

    if (function_exists('WC') && WC()->cart) {
        $cart = WC()->cart;

        // 1. Try removing by exact item_key
        if ($item_key && isset($cart->get_cart()[$item_key])) {
            $removed = $cart->remove_cart_item($item_key);
        }

        // 2. Fallback search by key, variation_id, or product_id
        if (!$removed) {
            foreach ($cart->get_cart() as $key => $cart_item) {
                $matches = false;
                if ($item_key && $key === $item_key) {
                    $matches = true;
                } elseif ($variation_id && !empty($cart_item['variation_id']) && $cart_item['variation_id'] == $variation_id) {
                    $matches = true;
                } elseif ($product_id && ($cart_item['product_id'] == $product_id || (!empty($cart_item['variation_id']) && $cart_item['variation_id'] == $product_id))) {
                    $matches = true;
                }

                if ($matches) {
                    $removed = $cart->remove_cart_item($key);
                    break;
                }
            }
        }

        $cart->calculate_totals();
        if (method_exists($cart, 'maybe_set_cart_cookies')) {
            $cart->maybe_set_cart_cookies();
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
 * AJAX Handler: Clear / Empty Entire Cart
 */
function kash_naturals_ajax_clear_cart() {
    if (function_exists('WC') && WC()->cart) {
        WC()->cart->empty_cart();
        WC()->cart->calculate_totals();
        if (WC()->session) {
            WC()->session->set('cart', array());
        }
        if (method_exists(WC()->cart, 'maybe_set_cart_cookies')) {
            WC()->cart->maybe_set_cart_cookies();
        }
        if (function_exists('wc_clear_notices')) {
            wc_clear_notices();
        }
    }

    wp_send_json_success(array(
        'message' => __('All items removed from your bag.', 'kash-naturals'),
        'cart'    => kash_naturals_get_cart_payload(),
    ));
}
add_action('wp_ajax_kash_clear_cart', 'kash_naturals_ajax_clear_cart');
add_action('wp_ajax_nopriv_kash_clear_cart', 'kash_naturals_ajax_clear_cart');

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
        $cart->calculate_totals();
        if (method_exists($cart, 'maybe_set_cart_cookies')) {
            $cart->maybe_set_cart_cookies();
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

/**
 * AJAX Handler: Check Delivery Pincode Validity & Serviceability
 * Validates against dummy postal codes, verifies Indian Postal Circles,
 * and fetches real post office/district/state details with transient caching.
 */
add_action('wp_ajax_kash_check_pincode', 'kash_naturals_ajax_check_pincode');
add_action('wp_ajax_nopriv_kash_check_pincode', 'kash_naturals_ajax_check_pincode');

function kash_naturals_ajax_check_pincode() {
    $pincode = isset($_POST['pincode']) ? sanitize_text_field(wp_unslash($_POST['pincode'])) : '';
    $pincode = preg_replace('/[^0-9]/', '', $pincode);

    if (strlen($pincode) !== 6) {
        wp_send_json_error(array(
            'message' => __('Please enter a valid 6-digit Indian Postal Pincode.', 'kash-naturals')
        ));
    }

    if (substr($pincode, 0, 1) === '0') {
        wp_send_json_error(array(
            'message' => __('Invalid Indian Pincode: Postal codes cannot start with 0.', 'kash-naturals')
        ));
    }

    // Dummy and test sequences
    $dummy_codes = array(
        '123456', '234567', '345678', '456789', '567890', '654321',
        '000000', '111111', '222222', '333333', '444444', '555555',
        '666666', '777777', '888888', '999999', '112233', '121212',
        '101010', '123123'
    );
    if (in_array($pincode, $dummy_codes, true)) {
        wp_send_json_error(array(
            'message' => sprintf(__('Pincode <strong>%s</strong> is not a valid Indian Postal Code. Please enter your real delivery pincode.', 'kash-naturals'), esc_html($pincode))
        ));
    }

    // Valid 2-digit Indian Postal Circle prefixes
    $circle_prefix_map = array(
        '11' => 'Delhi', '12' => 'Haryana', '13' => 'Haryana',
        '14' => 'Punjab', '15' => 'Punjab', '16' => 'Punjab / Chandigarh',
        '17' => 'Himachal Pradesh', '18' => 'Jammu & Kashmir', '19' => 'Jammu & Kashmir / Ladakh',
        '20' => 'Uttar Pradesh', '21' => 'Uttar Pradesh', '22' => 'Uttar Pradesh', '23' => 'Uttar Pradesh',
        '24' => 'Uttar Pradesh / Uttarakhand', '25' => 'Uttar Pradesh', '26' => 'Uttar Pradesh / Uttarakhand',
        '27' => 'Uttar Pradesh', '28' => 'Uttar Pradesh',
        '30' => 'Rajasthan', '31' => 'Rajasthan', '32' => 'Rajasthan', '33' => 'Rajasthan', '34' => 'Rajasthan',
        '36' => 'Gujarat', '37' => 'Gujarat', '38' => 'Gujarat', '39' => 'Gujarat',
        '40' => 'Maharashtra / Goa', '41' => 'Maharashtra', '42' => 'Maharashtra', '43' => 'Maharashtra', '44' => 'Maharashtra',
        '45' => 'Madhya Pradesh', '46' => 'Madhya Pradesh', '47' => 'Madhya Pradesh', '48' => 'Madhya Pradesh',
        '49' => 'Chhattisgarh',
        '50' => 'Telangana / Andhra Pradesh', '51' => 'Andhra Pradesh', '52' => 'Andhra Pradesh', '53' => 'Andhra Pradesh',
        '56' => 'Karnataka', '57' => 'Karnataka', '58' => 'Karnataka', '59' => 'Karnataka',
        '60' => 'Tamil Nadu', '61' => 'Tamil Nadu', '62' => 'Tamil Nadu', '63' => 'Tamil Nadu', '64' => 'Tamil Nadu / Puducherry',
        '67' => 'Kerala', '68' => 'Kerala', '69' => 'Kerala / Lakshadweep',
        '70' => 'West Bengal', '71' => 'West Bengal', '72' => 'West Bengal', '73' => 'West Bengal', '74' => 'West Bengal / Andaman & Nicobar',
        '75' => 'Odisha', '76' => 'Odisha', '77' => 'Odisha',
        '78' => 'Assam', '79' => 'North Eastern States',
        '80' => 'Bihar', '81' => 'Bihar', '82' => 'Bihar', '83' => 'Jharkhand', '84' => 'Bihar', '85' => 'Bihar / Jharkhand'
    );

    $pfx = substr($pincode, 0, 2);
    if (!isset($circle_prefix_map[$pfx])) {
        wp_send_json_error(array(
            'message' => sprintf(__('Pincode <strong>%s</strong> does not match any valid Indian Postal Circle.', 'kash-naturals'), esc_html($pincode))
        ));
    }

    // Check transient cache first
    $transient_key = 'kash_pin_' . $pincode;
    $cached = get_transient($transient_key);
    if ($cached !== false) {
        if (!empty($cached['valid'])) {
            wp_send_json_success($cached);
        } else {
            wp_send_json_error(array(
                'message' => sprintf(__('Pincode <strong>%s</strong> is not a valid Indian Postal Code.', 'kash-naturals'), esc_html($pincode))
            ));
        }
    }

    // Query India Post Directory
    $response = wp_remote_get('https://api.postalpincode.in/pincode/' . $pincode, array(
        'timeout' => 4,
        'headers' => array('Accept' => 'application/json')
    ));

    if (!is_wp_error($response) && wp_remote_retrieve_response_code($response) === 200) {
        $body = wp_remote_retrieve_body($response);
        $data = json_decode($body, true);
        if (is_array($data) && !empty($data[0])) {
            if (isset($data[0]['Status']) && $data[0]['Status'] === 'Success' && !empty($data[0]['PostOffice'])) {
                $po = $data[0]['PostOffice'][0];
                $district = !empty($po['District']) ? $po['District'] : (!empty($po['Name']) ? $po['Name'] : '');
                $state = !empty($po['State']) ? $po['State'] : $circle_prefix_map[$pfx];
                $location = $district ? ($district . ', ' . $state) : $state;

                $cache_data = array(
                    'valid' => true,
                    'pincode' => $pincode,
                    'location' => $location,
                    'state' => $state
                );
                set_transient($transient_key, $cache_data, DAY_IN_SECONDS * 30);
                wp_send_json_success($cache_data);
            } else {
                // Postal API confirmed this 6-digit code does not exist
                set_transient($transient_key, array('valid' => false), DAY_IN_SECONDS * 7);
                wp_send_json_error(array(
                    'message' => sprintf(__('Pincode <strong>%s</strong> is not a valid Indian Postal Code. Please check and enter a real delivery pincode.', 'kash-naturals'), esc_html($pincode))
                ));
            }
        }
    }

    // Fallback: If external API was down or unreachable, allow based on valid Indian Circle prefix
    wp_send_json_success(array(
        'valid' => true,
        'pincode' => $pincode,
        'location' => $circle_prefix_map[$pfx],
        'state' => $circle_prefix_map[$pfx]
    ));
}


