<?php
/**
 * Featured Products Grid Template Part
 *
 * @package KashNaturals
 */

if (!defined('ABSPATH')) {
    exit;
}
?>
<section class="section-padding featured-products-section">
    <div class="container">
        <div class="section-header flex-between">
            <div>
                <span class="section-subtitle">Chocolatier's Picks</span>
                <h2 class="section-title">Bestselling Artisan Chocolates</h2>
            </div>
            <a href="<?php echo esc_url(class_exists('WooCommerce') ? wc_get_page_permalink('shop') : '#'); ?>" class="btn btn-outline">
                View All Products <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>

        <div class="products-grid">
            <?php
            if (class_exists('WooCommerce')) {
                $args = array(
                    'post_type'      => 'product',
                    'posts_per_page' => 4,
                    'meta_key'       => '_featured',
                    'meta_value'     => 'yes'
                );
                $featured_query = new WP_Query($args);

                if ($featured_query->have_posts()) {
                    while ($featured_query->have_posts()) {
                        $featured_query->the_post();
                        wc_get_template_part('content', 'product');
                    }
                    wp_reset_postdata();
                } else {
                    // Fallback to recent products
                    $args_recent = array('post_type' => 'product', 'posts_per_page' => 4);
                    $recent_query = new WP_Query($args_recent);
                    if ($recent_query->have_posts()) {
                        while ($recent_query->have_posts()) {
                            $recent_query->the_post();
                            wc_get_template_part('content', 'product');
                        }
                        wp_reset_postdata();
                    } else {
                        // Display Demo Products if no WP products created yet
                        kash_naturals_render_demo_products();
                    }
                }
            } else {
                kash_naturals_render_demo_products();
            }
            ?>
        </div>
    </div>
</section>

<?php
function kash_naturals_render_demo_products() {
    $demo_products = array(
        array(
            'title' => '85% Arriba Super Dark Bar',
            'cacao' => '85%',
            'price' => '$12.50',
            'rating' => 5,
            'tag'   => 'Single Origin',
            'notes' => 'Espresso & Cinnamon Notes'
        ),
        array(
            'title' => 'Smoked Himalayan Sea Salt Truffles',
            'cacao' => '72%',
            'price' => '$18.00',
            'rating' => 5,
            'tag'   => 'Award Winner',
            'notes' => 'Caramel Ganache Core'
        ),
        array(
            'title' => 'Wild Raspberry & Ruby Cacao Bar',
            'cacao' => '65%',
            'price' => '$14.00',
            'rating' => 4.8,
            'tag'   => 'Limited Batch',
            'notes' => 'Tart Berry & Floral Blend'
        ),
        array(
            'title' => 'Roasted Pistachio & Matcha Crunch',
            'cacao' => '70%',
            'price' => '$15.50',
            'rating' => 4.9,
            'tag'   => 'Organic Vegan',
            'notes' => 'Crisp Matcha Crust'
        ),
    );

    foreach ($demo_products as $prod) :
        ?>
        <div class="product-card-item">
            <div class="product-thumb-holder">
                <span class="cacao-badge"><i class="fa-solid fa-seedling"></i> <?php echo esc_html($prod['cacao']); ?> Cacao</span>
                <span class="product-tag"><?php echo esc_html($prod['tag']); ?></span>
                <div class="demo-image-placeholder">
                    <i class="fa-solid fa-cookie-bite"></i>
                </div>
                <div class="product-hover-actions">
                    <button class="action-icon-btn" title="Quick View"><i class="fa-solid fa-eye"></i></button>
                    <button class="action-icon-btn" title="Add to Wishlist"><i class="fa-solid fa-heart"></i></button>
                </div>
            </div>
            <div class="product-info-holder">
                <div class="star-rating-row">
                    <span class="stars">★★★★★</span>
                    <span class="rating-val">(<?php echo esc_html($prod['rating']); ?>)</span>
                </div>
                <h3 class="product-card-title"><a href="#"><?php echo esc_html($prod['title']); ?></a></h3>
                <p class="flavor-notes-snippet"><i class="fa-solid fa-wand-magic-sparkles"></i> <?php echo esc_html($prod['notes']); ?></p>
                <div class="product-card-footer">
                    <span class="price-amount"><?php echo esc_html($prod['price']); ?></span>
                    <button class="btn btn-gold btn-sm"><i class="fa-solid fa-cart-plus"></i> Taste Now</button>
                </div>
            </div>
        </div>
        <?php
    endforeach;
}
?>
