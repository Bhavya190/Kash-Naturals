<?php
/**
 * Combo Offers Section Template Part (Matching Reference UI Design)
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
        'script'    => 'Freshness',
        'title'     => 'Signature Duo',
        'subtitle'  => 'Aromatic Calcutta Paan & Sweet Saunf Mukhwas in sealed glass jars for daily post-meal digestive freshness.',
        'rating'    => '4.9',
        'price'     => '₹499',
        'old_price' => '₹599',
        'bg_color'  => '#688A28',
        'image'     => $theme_uri . '/assets/images/combo-freshness.jpg',
        'link'      => $shop_url . '?combo=freshness-combo',
    ),
    array(
        'script'    => 'Bestseller',
        'title'     => 'Family Pack',
        'subtitle'  => 'Complete family assortment featuring 4 signature jars of mouth fresheners & chocolate dragees.',
        'rating'    => '5.0',
        'price'     => '₹899',
        'old_price' => '₹1,199',
        'bg_color'  => '#DF8B2B',
        'image'     => $theme_uri . '/assets/images/combo-family.jpg',
        'link'      => $shop_url . '?combo=family-combo',
    ),
    array(
        'script'    => 'Handcrafted',
        'title'     => 'Royal Connoisseur',
        'subtitle'  => 'Luxury hamper packed with crunchy Pistachio Kunafa, Dark Chocolate Almond Dragees & Silver Paan.',
        'rating'    => '4.9',
        'price'     => '₹1,299',
        'old_price' => '₹1,799',
        'bg_color'  => '#56771C',
        'image'     => $theme_uri . '/assets/images/combo-premium.jpg',
        'link'      => $shop_url . '?combo=premium-combo',
    ),
    array(
        'script'    => 'Celebration',
        'title'     => 'Artisanal Box',
        'subtitle'  => 'Grand gift hamper featuring Hazelnut Dragees, Royal Mukhwas, Pistachio Kunafa Bar & gift ribbon box.',
        'rating'    => '4.8',
        'price'     => '₹1,599',
        'old_price' => '₹2,000',
        'bg_color'  => '#A13423',
        'image'     => $theme_uri . '/assets/images/combo-celebration.jpg',
        'link'      => $shop_url . '?combo=celebration-box',
    ),
);
?>

<section class="section-padding combo-offers-section-exact" id="combos">
    <div class="container">
        
        <!-- Section Header -->
        <div class="combo-header-exact text-center mb-5">
            <span class="combo-sub-heading">— CURATED COMBOS —</span>
            <h2 class="combo-main-heading">Special Savings & Gift Hampers</h2>
            <div class="gold-divider"></div>
        </div>

        <!-- 4-Combo Card Grid Matching Reference UI -->
        <div class="combo-ref-grid-4">
            <?php foreach ($combo_items as $index => $combo) : ?>
                <div class="combo-ref-card" style="--card-bg: <?php echo esc_attr($combo['bg_color']); ?>;">
                    
                    <!-- Floating Image Tray Overflowing Top -->
                    <div class="combo-ref-img-wrapper">
                        <div class="combo-ref-img-tray">
                            <img src="<?php echo esc_url($combo['image']); ?>" alt="<?php echo esc_attr($combo['title']); ?>" class="combo-ref-img" loading="lazy">
                        </div>
                    </div>

                    <!-- Circular Price Badge Top Right -->
                    <div class="combo-ref-price-badge">
                        <span class="price-label">PRICE</span>
                        <span class="price-sale"><?php echo esc_html($combo['price']); ?></span>
                        <span class="price-old"><?php echo esc_html($combo['old_price']); ?></span>
                    </div>

                    <!-- Card Body Content -->
                    <div class="combo-ref-card-body">
                        <div class="combo-ref-script"><?php echo esc_html($combo['script']); ?></div>
                        <h3 class="combo-ref-title"><?php echo esc_html($combo['title']); ?></h3>
                        
                        <div class="combo-ref-rating-pill">
                            <span class="stars">
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star-half-stroke"></i>
                            </span>
                            <span class="score"><?php echo esc_html($combo['rating']); ?></span>
                        </div>

                        <p class="combo-ref-desc"><?php echo esc_html($combo['subtitle']); ?></p>

                        <a href="<?php echo esc_url($combo['link']); ?>" class="combo-ref-btn">
                            ORDER NOW
                        </a>
                    </div>

                </div>
            <?php endforeach; ?>
        </div>

    </div>
</section>
