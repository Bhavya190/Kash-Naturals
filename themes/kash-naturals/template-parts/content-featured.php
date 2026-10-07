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

$bestseller_products = array(
    array(
        'title' => 'Royal Mukhwas',
        'price' => '₹250',
        'rating' => '4.9',
        'image' => $theme_uri . '/assets/images/product-royal-mukhwas.jpg',
        'link'  => $shop_url . '?product=royal-mukhwas',
    ),
    array(
        'title' => 'Calcutta Pan Mix',
        'price' => '₹250',
        'rating' => '5.0',
        'image' => $theme_uri . '/assets/images/product-calcutta-pan.jpg',
        'link'  => $shop_url . '?product=calcutta-pan-mix',
    ),
    array(
        'title' => 'Sweet Saunf Mix',
        'price' => '₹240',
        'rating' => '4.8',
        'image' => $theme_uri . '/assets/images/product-sweet-saunf.jpg',
        'link'  => $shop_url . '?product=sweet-saunf-mix',
    ),
    array(
        'title' => 'Chocolate Dragees',
        'price' => '₹320',
        'rating' => '4.9',
        'image' => $theme_uri . '/assets/images/chocolate-dragees.jpg',
        'link'  => $shop_url . '?product=chocolate-dragees',
    ),
    array(
        'title' => 'Premium Kunafa Bar',
        'price' => '₹349',
        'rating' => '5.0',
        'image' => $theme_uri . '/assets/images/kunafa-bars.jpg',
        'link'  => $shop_url . '?product=premium-kunafa-bar',
    ),
    array(
        'title' => 'Assorted Combo Pack',
        'price' => '₹599',
        'rating' => '4.9',
        'image' => $theme_uri . '/assets/images/gift-combos.jpg',
        'link'  => $shop_url . '?product=assorted-combo-pack',
    ),
    array(
        'title' => 'Celebration Mukhwas Box',
        'price' => '₹499',
        'rating' => '4.9',
        'image' => $theme_uri . '/assets/images/combo-celebration.jpg',
        'link'  => $shop_url . '?product=celebration-mukhwas-box',
    ),
    array(
        'title' => 'Freshness Saunf Jar',
        'price' => '₹299',
        'rating' => '4.8',
        'image' => $theme_uri . '/assets/images/combo-freshness.jpg',
        'link'  => $shop_url . '?product=freshness-saunf-jar',
    ),
);
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

        <!-- Carousel Wrapper with Side Navigation Arrows -->
        <div class="fav-carousel-outer">
            
            <!-- Left Prev Arrow Button -->
            <button type="button" class="fav-arrow-btn fav-arrow-prev" id="favCarouselPrev" aria-label="Previous Slide">
                <i class="fa-solid fa-chevron-left"></i>
            </button>

            <!-- Carousel Viewport & Track -->
            <div class="fav-carousel-viewport" id="favCarouselViewport">
                <div class="fav-carousel-track" id="favCarouselTrack">
                    <?php foreach ($bestseller_products as $index => $product) : ?>
                        <div class="fav-card-item">
                            <div class="fav-card-inner">
                                <div class="fav-rating-badge">
                                    <i class="fa-solid fa-star"></i> <?php echo esc_html($product['rating']); ?>
                                </div>
                                <div class="fav-img-box">
                                    <img src="<?php echo esc_url($product['image']); ?>" alt="<?php echo esc_attr($product['title']); ?>" class="fav-prod-img" loading="lazy">
                                </div>
                                <div class="fav-card-body">
                                    <h3 class="fav-prod-title"><?php echo esc_html($product['title']); ?></h3>
                                    <div class="fav-prod-price"><?php echo esc_html($product['price']); ?></div>
                                    <div class="fav-card-actions">
                                        <a href="<?php echo esc_url($product['link']); ?>" class="fav-btn-view">
                                            <?php esc_html_e('View Product', 'kash-naturals'); ?> <i class="fa-solid fa-arrow-right"></i>
                                        </a>
                                        <button type="button" class="fav-btn-quick-add add-to-cart-btn" data-product-id="<?php echo esc_attr($index + 1); ?>" data-product-name="<?php echo esc_attr($product['title']); ?>" data-product-price="<?php echo esc_attr($product['price']); ?>" data-product-img="<?php echo esc_url($product['image']); ?>" title="Add to Cart">
                                            <i class="fa-solid fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Right Next Arrow Button -->
            <button type="button" class="fav-arrow-btn fav-arrow-next" id="favCarouselNext" aria-label="Next Slide">
                <i class="fa-solid fa-chevron-right"></i>
            </button>

        </div>

    </div>
</section>
