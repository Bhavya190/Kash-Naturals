<?php
/**
 * The template for displaying product content within loops
 * Luxury Kash Naturals Artisanal Product Card
 *
 * @package KashNaturals
 */

if (!defined('ABSPATH')) {
    exit;
}

global $product;

// Ensure visibility
if (empty($product) || !$product->is_visible()) {
    return;
}

$prod_id = $product->get_id();
$img_url = wp_get_attachment_image_url($product->get_image_id(), 'kash-product-card');
if (!$img_url && function_exists('wc_placeholder_img_src')) {
    $img_url = wc_placeholder_img_src();
}

$cats = wc_get_product_category_list($prod_id);
$cat_names = wp_strip_all_tags($cats);

$sale_price = $product->get_price();
$reg_price = $product->get_regular_price();
$currency_symbol = function_exists('get_woocommerce_currency_symbol') ? get_woocommerce_currency_symbol() : '₹';

$is_in_stock = $product->is_in_stock();

$badge = 'Fresh Batch';
if (!$is_in_stock) {
    $badge = 'Out of Stock';
} elseif ($product->is_on_sale()) {
    $badge = 'Sale';
} elseif ($product->is_featured()) {
    $badge = 'Featured';
}

$rating = $product->get_average_rating();
$rating_str = ($rating > 0) ? number_format((float)$rating, 1) : '5.0';

$desc = $product->get_short_description();
if (empty($desc)) {
    $desc = wp_strip_all_tags(get_the_excerpt());
}
$desc_short = wp_trim_words($desc, 12, '...');
?>

<div <?php wc_product_class('shop-product-card-exact' . (!$is_in_stock ? ' card-out-of-stock' : ''), $product); ?>>
    <?php if (!$is_in_stock) : ?>
        <span class="product-badge-tag badge-out-of-stock"><?php esc_html_e('Out of Stock', 'kash-naturals'); ?></span>
    <?php else : ?>
        <span class="product-badge-tag"><?php echo esc_html($badge); ?></span>
    <?php endif; ?>

    <a href="<?php the_permalink(); ?>" class="product-img-box-exact">
        <img src="<?php echo esc_url($img_url); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy">
    </a>
    <div class="product-card-info">
        <div class="product-cat-label"><?php echo esc_html(!empty($cat_names) ? $cat_names : __('Specialty', 'kash-naturals')); ?></div>
        <h3 class="product-title-exact">
            <a href="<?php the_permalink(); ?>" style="color: inherit; text-decoration: none;">
                <?php the_title(); ?>
            </a>
        </h3>
        <p class="product-desc-short"><?php echo esc_html($desc_short); ?></p>
        <div class="product-rating-stars">★★★★★ <span>(<?php echo esc_html($rating_str); ?>)</span></div>
        <div class="product-price-row-exact">
            <div class="price-wrap">
                <span class="current-price"><?php echo esc_html(!empty($sale_price) ? $currency_symbol . $sale_price : $currency_symbol . '0'); ?></span>
                <?php if (!empty($reg_price) && $reg_price > $sale_price) : ?>
                    <span class="old-price"><?php echo esc_html($currency_symbol . $reg_price); ?></span>
                <?php endif; ?>
            </div>
            <?php if ($is_in_stock) : ?>
                <button type="button" class="btn-add-cart-exact add-to-cart-btn add_to_cart_button ajax_add_to_cart" data-product-id="<?php echo esc_attr($prod_id); ?>" data-product_id="<?php echo esc_attr($prod_id); ?>" data-product-name="<?php the_title_attribute(); ?>" data-product-price="<?php echo esc_attr($sale_price); ?>" data-product-img="<?php echo esc_url($img_url); ?>">
                    <i class="fa-solid fa-cart-plus"></i> <?php esc_html_e('ADD TO CART', 'kash-naturals'); ?>
                </button>
            <?php else : ?>
                <button type="button" class="btn-add-cart-exact btn-out-of-stock" disabled title="<?php esc_attr_e('Product is currently out of stock', 'kash-naturals'); ?>">
                    <i class="fa-solid fa-ban"></i> <?php esc_html_e('OUT OF STOCK', 'kash-naturals'); ?>
                </button>
            <?php endif; ?>
        </div>
    </div>
</div>
