<?php
/**
 * Best Sellers / Customer Favorites Products Section Template Part
 * Creative Carousel Layout matching reference design with 3.5 cards visible in frame
 *
 * @package KashNaturals
 */

if (!defined('ABSPATH')) {
    exit;
}

$theme_uri = get_template_directory_uri();
$shop_url = home_url('/shop');

$bestseller_products = array();

// Query Dynamic Products from WooCommerce Category "customer-favorite"
if (class_exists('WooCommerce')) {
    // Collect potential slugs matching the category created by the user
    $fav_term_slugs = array('customer-favorite', 'customer-favorites', 'customer_favorite', 'customer_favorites');

    // Dynamically look up category term by name or slug to ensure 100% match with user's WP admin category
    $candidate_names = array('customer-favorite', 'customer-favorites', 'Customer Favorite', 'Customer Favorites', 'customer_favorite', 'Customer-Favorite', 'customer favorite', 'customer favorites');
    foreach ($candidate_names as $cand) {
        $term_by_name = get_term_by('name', $cand, 'product_cat');
        if ($term_by_name && !is_wp_error($term_by_name)) {
            $fav_term_slugs[] = $term_by_name->slug;
        }
        $term_by_slug = get_term_by('slug', sanitize_title($cand), 'product_cat');
        if ($term_by_slug && !is_wp_error($term_by_slug)) {
            $fav_term_slugs[] = $term_by_slug->slug;
        }
    }
    $fav_term_slugs = array_values(array_unique(array_filter($fav_term_slugs)));

    $wc_query = new WP_Query(array(
        'post_type'      => 'product',
        'post_status'    => 'publish',
        'posts_per_page' => 24,
        'tax_query'      => array(
            array(
                'taxonomy'         => 'product_cat',
                'field'            => 'slug',
                'terms'            => $fav_term_slugs,
                'operator'         => 'IN',
                'include_children' => true,
            ),
        ),
        'orderby'        => 'menu_order date',
        'order'          => 'DESC',
    ));

    if ($wc_query->have_posts()) {
        $currency_symbol = function_exists('get_woocommerce_currency_symbol') ? get_woocommerce_currency_symbol() : '₹';
        while ($wc_query->have_posts()) {
            $wc_query->the_post();
            $wc_prod = wc_get_product(get_the_ID());
            if ($wc_prod && $wc_prod->is_visible()) {
                $img_url = wp_get_attachment_image_url($wc_prod->get_image_id(), 'kash-product-card');
                if (!$img_url) {
                    $img_url = $theme_uri . '/assets/images/product-royal-mukhwas.jpg';
                }
                $avg_rating = $wc_prod->get_average_rating();
                $rating_str = ($avg_rating > 0) ? number_format((float)$avg_rating, 1) : '5.0';

                $price_val = $wc_prod->get_price();
                $price_display = !empty($price_val) ? $currency_symbol . $price_val : $currency_symbol . '0';

                $bestseller_products[] = array(
                    'id'              => $wc_prod->get_id(),
                    'title'           => $wc_prod->get_name(),
                    'price'           => $price_display,
                    'rating'          => $rating_str,
                    'image'           => $img_url,
                    'link'            => get_permalink($wc_prod->get_id()),
                    'add_to_cart_url' => $wc_prod->add_to_cart_url(),
                    'in_stock'        => $wc_prod->is_in_stock(),
                    'stock_status'    => $wc_prod->get_stock_status(),
                );
            }
        }
        wp_reset_postdata();
    }
}

// If no products available in WooCommerce, keep empty and display clean empty state notice
?>

<section class="fav-carousel-section" id="customer-favorites">
    <div class="fav-section-container">
        
        <!-- Header Section with Green Pill Badge Title -->
        <div class="fav-header-wrap text-center">
            <div class="fav-title-pill">
                <span class="fav-pill-circle"><i class="fa-solid fa-leaf"></i></span>
                <h2 class="fav-pill-title"><?php esc_html_e('Customer Favorites', 'kash-naturals'); ?></h2>
            </div>
            <p class="fav-subtitle"><?php esc_html_e('Handpicked gourmet digestives & royal treats most loved by our customers', 'kash-naturals'); ?></p>
        </div>

        <?php if (!empty($bestseller_products)) : ?>
            <!-- Carousel Wrapper with Side Navigation Arrows -->
            <div class="fav-carousel-outer">
                
                <!-- Left Prev Arrow Button -->
                <button type="button" class="fav-arrow-btn fav-arrow-prev" id="favCarouselPrev" aria-label="<?php esc_attr_e('Previous Slide', 'kash-naturals'); ?>">
                    <i class="fa-solid fa-chevron-left"></i>
                </button>

                <!-- Carousel Viewport & Track -->
                <div class="fav-carousel-viewport" id="favCarouselViewport">
                    <div class="fav-carousel-track" id="favCarouselTrack">
                        <?php foreach ($bestseller_products as $index => $product) : 
                            $is_prod_in_stock = isset($product['in_stock']) ? !empty($product['in_stock']) : true;
                        ?>
                            <div class="fav-card-item <?php echo !$is_prod_in_stock ? 'item-out-of-stock' : ''; ?>">
                                <div class="fav-card-inner">
                                    <?php if (!$is_prod_in_stock) : ?>
                                        <div class="fav-stock-badge-oos"><i class="fa-solid fa-ban"></i> <?php esc_html_e('Out of Stock', 'kash-naturals'); ?></div>
                                    <?php endif; ?>
                                    <div class="fav-rating-badge">
                                        <i class="fa-solid fa-star"></i> <?php echo esc_html($product['rating']); ?>
                                    </div>
                                    <a href="<?php echo esc_url($product['link']); ?>" class="fav-img-box" aria-label="<?php echo esc_attr($product['title']); ?>">
                                        <img src="<?php echo esc_url($product['image']); ?>" alt="<?php echo esc_attr($product['title']); ?>" class="fav-prod-img" loading="lazy">
                                    </a>
                                    <div class="fav-card-body">
                                        <h3 class="fav-prod-title">
                                            <a href="<?php echo esc_url($product['link']); ?>" style="color: inherit; text-decoration: none;">
                                                <?php echo esc_html($product['title']); ?>
                                            </a>
                                        </h3>
                                        <div class="fav-prod-price"><?php echo esc_html($product['price']); ?></div>
                                        <div class="fav-card-actions">
                                            <a href="<?php echo esc_url($product['link']); ?>" class="fav-btn-view">
                                                <?php esc_html_e('View Product', 'kash-naturals'); ?> <i class="fa-solid fa-arrow-right"></i>
                                            </a>
                                            <?php if ($is_prod_in_stock) : ?>
                                                <button type="button" class="fav-btn-quick-add add-to-cart-btn add_to_cart_button ajax_add_to_cart" data-product-id="<?php echo esc_attr($product['id']); ?>" data-product_id="<?php echo esc_attr($product['id']); ?>" data-product-name="<?php echo esc_attr($product['title']); ?>" data-product-price="<?php echo esc_attr($product['price']); ?>" data-product-img="<?php echo esc_url($product['image']); ?>" title="<?php esc_attr_e('Add to Cart', 'kash-naturals'); ?>">
                                                    <i class="fa-solid fa-plus"></i>
                                                </button>
                                            <?php else : ?>
                                                <button type="button" class="fav-btn-quick-add disabled" disabled title="<?php esc_attr_e('Out of stock', 'kash-naturals'); ?>">
                                                    <i class="fa-solid fa-ban"></i>
                                                </button>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Right Next Arrow Button -->
                <button type="button" class="fav-arrow-btn fav-arrow-next" id="favCarouselNext" aria-label="<?php esc_attr_e('Next Slide', 'kash-naturals'); ?>">
                    <i class="fa-solid fa-chevron-right"></i>
                </button>

            </div>

            <!-- Bottom Navigation Pagination Dots -->
            <div class="fav-carousel-pagination" id="favCarouselPagination" role="tablist" aria-label="<?php esc_attr_e('Customer Favorites Slider Pagination', 'kash-naturals'); ?>"></div>
        <?php else : ?>
            <div class="kash-empty-products-state text-center">
                <div class="empty-state-icon">
                    <i class="fa-solid fa-box-open"></i>
                </div>
                <h3 class="empty-state-title"><?php esc_html_e('No Products Available', 'kash-naturals'); ?></h3>
                <p class="empty-state-desc"><?php esc_html_e('We are preparing fresh batches. Please check back soon!', 'kash-naturals'); ?></p>
            </div>
        <?php endif; ?>

    </div>
</section>
