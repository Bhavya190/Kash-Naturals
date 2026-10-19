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
        
        <h3 style="margin-top: 10px; color: #2C5F3E; border-bottom: 2px solid #e0eae1; padding-bottom: 8px;">
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
            <i class="dashicons dashicons-star-filled"></i> <?php esc_html_e('Artisan Notes & Chocolate Profiling (Optional)', 'kash-naturals'); ?>
        </h3>

        <?php
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
            'placeholder' => 'Ecuador, Single Origin',
            'desc_tip'    => true,
            'description' => __('Origin of cacao or spices.', 'kash-naturals'),
            'style'       => 'width: 70%;',
        ));

        woocommerce_wp_text_input(array(
            'id'          => '_pack_size_1_label',
            'label'       => __('1st Pack Size Label (Primary)', 'kash-naturals'),
            'placeholder' => __('e.g. 200g Glass Jar (leave empty to use weight)', 'kash-naturals'),
            'desc_tip'    => true,
            'description' => __('Custom label for primary pack size pill. If left empty, uses product weight.', 'kash-naturals'),
            'style'       => 'width: 70%;',
        ));

        woocommerce_wp_text_input(array(
            'id'          => '_pack_size_2_label',
            'label'       => __('2nd Pack Size Label', 'kash-naturals'),
            'placeholder' => '500g Value Jar',
            'desc_tip'    => true,
            'description' => __('Label for the second pack size pill button (e.g. 500g Value Jar, 1kg Family Pack).', 'kash-naturals'),
        ));

        woocommerce_wp_text_input(array(
            'id'          => '_pack_size_2_price',
            'label'       => __('2nd Pack Size Price', 'kash-naturals'),
            'placeholder' => '399',
            'desc_tip'    => true,
            'description' => __('Price when the 2nd pack size pill is selected.', 'kash-naturals'),
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
 * AJAX Handler: Add to Cart with Dynamic Stock Validation
 */
function kash_naturals_ajax_add_to_cart() {
    $product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
    $quantity   = isset($_POST['quantity']) ? max(1, intval($_POST['quantity'])) : 1;

    if (!$product_id) {
        wp_send_json_error(array('message' => __('Invalid product.', 'kash-naturals')));
    }

    $product = wc_get_product($product_id);
    if (!$product || !$product->exists()) {
        wp_send_json_error(array('message' => __('Product does not exist or has been removed from shop.', 'kash-naturals')));
    }

    if (!$product->is_in_stock() || $product->get_stock_status() === 'outofstock') {
        wp_send_json_error(array(
            'error_type' => 'out_of_stock',
            'message'    => sprintf(__('Sorry, "%s" is currently out of stock and unavailable.', 'kash-naturals'), $product->get_name())
        ));
    }

    // Check stock quantity limits if managed
    if ($product->managing_stock() && !$product->backorders_allowed()) {
        $stock_qty = $product->get_stock_quantity();
        if ($stock_qty !== null && $quantity > $stock_qty) {
            wp_send_json_error(array(
                'error_type' => 'insufficient_stock',
                'message'    => sprintf(__('Only %d item(s) available in stock for "%s".', 'kash-naturals'), $stock_qty, $product->get_name())
            ));
        }
    }

    if (function_exists('WC') && WC()->cart) {
        WC()->cart->add_to_cart($product_id, $quantity);
    }

    wp_send_json_success(array(
        'message' => sprintf(__('Added "%s" to your shopping bag!', 'kash-naturals'), $product->get_name()),
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
