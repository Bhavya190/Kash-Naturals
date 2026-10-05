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
    ob_start();
    $count = WC()->cart->get_cart_contents_count();
    ?>
    <span class="cart-count-badge" id="mini-cart-count"><?php echo esc_html($count); ?></span>
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
 * Add Custom Fields to Product Data Tabs in WP Admin (Cacao %, Origin, Flavor Notes)
 */
function kash_naturals_add_custom_product_fields() {
    echo '<div class="options_group">';

    // Cacao Percentage
    woocommerce_wp_text_input(array(
        'id'          => '_cacao_percentage',
        'label'       => __('Cacao Percentage (%)', 'kash-naturals'),
        'placeholder' => '72%',
        'desc_tip'    => 'true',
        'description' => __('Enter the cacao content percentage (e.g. 70%, 85%, 100%).', 'kash-naturals'),
    ));

    // Cocoa Origin
    woocommerce_wp_text_input(array(
        'id'          => '_cocoa_origin',
        'label'       => __('Cocoa Bean Origin', 'kash-naturals'),
        'placeholder' => 'Ecuador, Single Origin',
        'desc_tip'    => 'true',
        'description' => __('Country/Region where cocoa beans were harvested.', 'kash-naturals'),
    ));

    // Flavor Profile Notes
    woocommerce_wp_text_input(array(
        'id'          => '_flavor_notes',
        'label'       => __('Flavor Profile Notes', 'kash-naturals'),
        'placeholder' => 'Nutty, Espresso, Dried Cherry',
        'desc_tip'    => 'true',
        'description' => __('Comma-separated tasting notes.', 'kash-naturals'),
    ));

    echo '</div>';
}
add_action('woocommerce_product_options_general_product_data', 'kash_naturals_add_custom_product_fields');

/**
 * Save Product Custom Fields
 */
function kash_naturals_save_custom_product_fields($post_id) {
    $cacao = isset($_POST['_cacao_percentage']) ? sanitize_text_field($_POST['_cacao_percentage']) : '';
    $origin = isset($_POST['_cocoa_origin']) ? sanitize_text_field($_POST['_cocoa_origin']) : '';
    $flavor = isset($_POST['_flavor_notes']) ? sanitize_text_field($_POST['_flavor_notes']) : '';

    update_post_meta($post_id, '_cacao_percentage', $cacao);
    update_post_meta($post_id, '_cocoa_origin', $origin);
    update_post_meta($post_id, '_flavor_notes', $flavor);
}
add_action('woocommerce_process_product_meta', 'kash_naturals_save_custom_product_fields');

/**
 * Display Cacao % Tag on Shop Loop Product Cards
 */
function kash_naturals_show_cacao_tag_on_loop() {
    global $product;
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
