<?php
/**
 * The template for displaying product content within loops
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
?>
<li <?php wc_product_class('product-card-item', $product); ?>>
    <div class="product-thumb-holder">
        <?php
        // Cacao Percentage Badge
        $cacao = get_post_meta($product->get_id(), '_cacao_percentage', true);
        if (!empty($cacao)) :
            ?>
            <span class="cacao-badge"><i class="fa-solid fa-seedling"></i> <?php echo esc_html($cacao); ?> Cacao</span>
        <?php endif; ?>

        <?php if ($product->is_on_sale()) : ?>
            <span class="product-tag sale-tag">Sale</span>
        <?php endif; ?>

        <a href="<?php the_permalink(); ?>" class="product-image-link">
            <?php
            if (has_post_thumbnail()) {
                the_post_thumbnail('kash-product-card');
            } else {
                echo '<div class="demo-image-placeholder"><i class="fa-solid fa-cookie-bite"></i></div>';
            }
            ?>
        </a>
    </div>

    <div class="product-info-holder">
        <div class="star-rating-row">
            <?php if ($rating_html = wc_get_rating_html($product->get_average_rating())) : ?>
                <?php echo $rating_html; ?>
            <?php else : ?>
                <span class="stars">★★★★★</span>
            <?php endif; ?>
        </div>

        <h3 class="product-card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>

        <?php
        $flavor_notes = get_post_meta($product->get_id(), '_flavor_notes', true);
        if (!empty($flavor_notes)) :
            ?>
            <p class="flavor-notes-snippet"><i class="fa-solid fa-wand-magic-sparkles"></i> <?php echo esc_html($flavor_notes); ?></p>
        <?php endif; ?>

        <div class="product-card-footer">
            <span class="price-amount"><?php echo $product->get_price_html(); ?></span>
            <?php woocommerce_template_loop_add_to_cart(); ?>
        </div>
    </div>
</li>
