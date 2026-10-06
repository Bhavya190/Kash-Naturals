<?php
/**
 * Best Sellers / Customer Favorites Products Section Template Part
 * Exact match to reference screenshot design with 6 bestselling products
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
        'image' => $theme_uri . '/assets/images/product-royal-mukhwas.jpg',
        'link'  => $shop_url . '?product=royal-mukhwas',
    ),
    array(
        'title' => 'Calcutta Pan Mix',
        'price' => '₹250',
        'image' => $theme_uri . '/assets/images/product-calcutta-pan.jpg',
        'link'  => $shop_url . '?product=calcutta-pan-mix',
    ),
    array(
        'title' => 'Sweet Saunf Mix',
        'price' => '₹240',
        'image' => $theme_uri . '/assets/images/product-sweet-saunf.jpg',
        'link'  => $shop_url . '?product=sweet-saunf-mix',
    ),
    array(
        'title' => 'Chocolate Dragees',
        'price' => '₹320',
        'image' => $theme_uri . '/assets/images/chocolate-dragees.jpg',
        'link'  => $shop_url . '?product=chocolate-dragees',
    ),
    array(
        'title' => 'Premium Kunafa Bar',
        'price' => '₹349',
        'image' => $theme_uri . '/assets/images/kunafa-bars.jpg',
        'link'  => $shop_url . '?product=premium-kunafa-bar',
    ),
    array(
        'title' => 'Assorted Combo Pack',
        'price' => '₹599',
        'image' => $theme_uri . '/assets/images/gift-combos.jpg',
        'link'  => $shop_url . '?product=assorted-combo-pack',
    ),
);
?>

<section class="section-padding best-sellers-section-exact">
    <div class="container">
        
        <!-- Section Header -->
        <div class="bestseller-header-exact text-center">
            <span class="bestseller-sub-heading">— BEST SELLERS —</span>
            <h2 class="bestseller-main-title"><?php esc_html_e('Customer Favorites', 'kash-naturals'); ?></h2>
            <div class="bestseller-star-rating">★★★★★</div>
        </div>

        <!-- 6-Product Cards Grid -->
        <div class="bestseller-grid-6">
            <?php foreach ($bestseller_products as $product) : ?>
                <div class="bestseller-card-exact">
                    <div class="bestseller-img-wrap">
                        <img src="<?php echo esc_url($product['image']); ?>" alt="<?php echo esc_attr($product['title']); ?>" class="bestseller-prod-img" loading="lazy">
                    </div>
                    <div class="bestseller-card-content">
                        <h3 class="bestseller-prod-title"><?php echo esc_html($product['title']); ?></h3>
                        <div class="bestseller-prod-price"><?php echo esc_html($product['price']); ?></div>
                        <a href="<?php echo esc_url($product['link']); ?>" class="btn-add-to-cart-outline">
                            <?php esc_html_e('ADD TO CART', 'kash-naturals'); ?> <i class="fa-solid fa-cart-shopping"></i>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

    </div>
</section>
