<?php
/**
 * Category Grid Showcase Template Part (Matches Image Design Exactly)
 *
 * @package KashNaturals
 */

if (!defined('ABSPATH')) {
    exit;
}

$theme_uri = get_template_directory_uri();
$shop_url = home_url('/shop');
?>

<section class="section-padding home-category-showcase">
    <div class="container">
        <div class="category-cards-grid">

            <!-- Card 1: Mouth Fresheners -->
            <div class="cat-exact-card">
                <div class="cat-card-image-wrap">
                    <div class="cat-card-img-container">
                        <img src="<?php echo esc_url($theme_uri . '/assets/images/mouth-fresheners.jpg'); ?>" alt="Mouth Fresheners" class="cat-card-img" loading="lazy">
                    </div>
                    <div class="cat-card-badge badge-green">
                        <i class="fa-solid fa-leaf"></i>
                    </div>
                </div>
                <div class="cat-card-body">
                    <h3 class="cat-card-title"><?php esc_html_e('MOUTH FRESHENERS', 'kash-naturals'); ?></h3>
                    <p class="cat-card-subtitle"><?php esc_html_e('10 Premium Varieties', 'kash-naturals'); ?></p>
                    <a href="<?php echo esc_url($shop_url . '?category=mouth-fresheners'); ?>" class="cat-card-shop-btn">
                        <?php esc_html_e('SHOP NOW', 'kash-naturals'); ?> <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>
            </div>

            <!-- Card 2: Chocolate Dragees -->
            <div class="cat-exact-card">
                <div class="cat-card-image-wrap">
                    <div class="cat-card-img-container">
                        <img src="<?php echo esc_url($theme_uri . '/assets/images/chocolate-dragees.jpg'); ?>" alt="Chocolate Dragees" class="cat-card-img" loading="lazy">
                    </div>
                    <div class="cat-card-badge badge-brown">
                        <i class="fa-solid fa-cookie"></i>
                    </div>
                </div>
                <div class="cat-card-body">
                    <h3 class="cat-card-title"><?php esc_html_e('CHOCOLATE DRAGEES', 'kash-naturals'); ?></h3>
                    <p class="cat-card-subtitle"><?php esc_html_e('Chocolate Coated Delights', 'kash-naturals'); ?></p>
                    <a href="<?php echo esc_url($shop_url . '?category=chocolate-dragees'); ?>" class="cat-card-shop-btn">
                        <?php esc_html_e('SHOP NOW', 'kash-naturals'); ?> <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>
            </div>

            <!-- Card 3: Kunafa Bars -->
            <div class="cat-exact-card">
                <div class="cat-card-image-wrap">
                    <div class="cat-card-img-container">
                        <img src="<?php echo esc_url($theme_uri . '/assets/images/kunafa-bars.jpg'); ?>" alt="Kunafa Bars" class="cat-card-img" loading="lazy">
                    </div>
                    <div class="cat-card-badge badge-gold">
                        <i class="fa-solid fa-layer-group"></i>
                    </div>
                </div>
                <div class="cat-card-body">
                    <h3 class="cat-card-title"><?php esc_html_e('KUNAFA BARS', 'kash-naturals'); ?></h3>
                    <p class="cat-card-subtitle"><?php esc_html_e('Middle Eastern Inspired Treats', 'kash-naturals'); ?></p>
                    <a href="<?php echo esc_url($shop_url . '?category=kunafa-bars'); ?>" class="cat-card-shop-btn">
                        <?php esc_html_e('SHOP NOW', 'kash-naturals'); ?> <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>
            </div>

            <!-- Card 4: Gift Combos -->
            <div class="cat-exact-card">
                <div class="cat-card-image-wrap">
                    <div class="cat-card-img-container">
                        <img src="<?php echo esc_url($theme_uri . '/assets/images/gift-combos.jpg'); ?>" alt="Gift Combos" class="cat-card-img" loading="lazy">
                    </div>
                    <div class="cat-card-badge badge-green">
                        <i class="fa-solid fa-gift"></i>
                    </div>
                </div>
                <div class="cat-card-body">
                    <h3 class="cat-card-title"><?php esc_html_e('GIFT COMBOS', 'kash-naturals'); ?></h3>
                    <p class="cat-card-subtitle"><?php esc_html_e('Perfect for Family & Corporate Gifting', 'kash-naturals'); ?></p>
                    <a href="<?php echo esc_url($shop_url . '?category=gift-combos'); ?>" class="cat-card-shop-btn">
                        <?php esc_html_e('SHOP NOW', 'kash-naturals'); ?> <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>
