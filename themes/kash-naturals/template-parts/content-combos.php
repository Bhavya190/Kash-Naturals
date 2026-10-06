<?php
/**
 * Combo Offers Section Template Part (Matches Reference Screenshot Design)
 *
 * @package KashNaturals
 */

if (!defined('ABSPATH')) {
    exit;
}

$theme_uri = get_template_directory_uri();
$shop_url = home_url('/shop');

$combo_items = array(
    array(
        'title'    => 'FRESHNESS COMBO',
        'subtitle' => '3 Mouth Fresheners',
        'price'    => '₹699',
        'old_price'=> '₹870',
        'image'    => $theme_uri . '/assets/images/combo-freshness.jpg',
        'link'     => $shop_url . '?combo=freshness-combo',
    ),
    array(
        'title'    => 'FAMILY COMBO',
        'subtitle' => '5 Mouth Fresheners',
        'price'    => '₹999',
        'old_price'=> '₹1,245',
        'image'    => $theme_uri . '/assets/images/combo-family.jpg',
        'link'     => $shop_url . '?combo=family-combo',
    ),
    array(
        'title'    => 'PREMIUM COMBO',
        'subtitle' => '5 Mouth Fresheners<br>+ Chocolate Dragees',
        'price'    => '₹1,299',
        'old_price'=> '₹1,650',
        'image'    => $theme_uri . '/assets/images/combo-premium.jpg',
        'link'     => $shop_url . '?combo=premium-combo',
    ),
    array(
        'title'    => 'CELEBRATION BOX',
        'subtitle' => 'Mouth Fresheners<br>+ Dragees + Kunafa Bars',
        'price'    => '₹1,599',
        'old_price'=> '₹2,000',
        'image'    => $theme_uri . '/assets/images/combo-celebration.jpg',
        'link'     => $shop_url . '?combo=celebration-box',
    ),
);
?>

<section class="section-padding combo-offers-section-exact" id="combos">
    <div class="container">
        
        <!-- Section Header -->
        <div class="combo-header-exact text-center">
            <span class="combo-sub-heading">— COMBO OFFERS —</span>
        </div>

        <!-- 4-Combo Card Grid -->
        <div class="combo-cards-grid-4">
            <?php foreach ($combo_items as $combo) : ?>
                <div class="combo-card-exact">
                    <div class="combo-img-container">
                        <img src="<?php echo esc_url($combo['image']); ?>" alt="<?php echo esc_attr($combo['title']); ?>" class="combo-card-img" loading="lazy">
                    </div>
                    <div class="combo-card-body">
                        <h3 class="combo-card-title"><?php echo esc_html($combo['title']); ?></h3>
                        <p class="combo-card-subtitle"><?php echo function_exists('wp_kses_post') ? wp_kses_post($combo['subtitle']) : $combo['subtitle']; ?></p>
                        
                        <div class="combo-pricing-wrap">
                            <span class="combo-sale-price"><?php echo esc_html($combo['price']); ?></span>
                            <span class="combo-old-price"><?php echo esc_html($combo['old_price']); ?></span>
                        </div>

                        <a href="<?php echo esc_url($combo['link']); ?>" class="btn-combo-shop-now">
                            <?php esc_html_e('SHOP NOW', 'kash-naturals'); ?>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

    </div>
</section>
