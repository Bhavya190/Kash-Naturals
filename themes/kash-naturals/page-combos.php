<?php
/**
 * Template Name: Combos & Gift Hampers Page
 *
 * @package KashNaturals
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();

$theme_uri = get_template_directory_uri();
?>

<!-- Page Header Banner -->
<div class="combos-page-header">
    <div class="container text-center">
        <span class="combos-header-subtitle"><?php esc_html_e('SPECIAL SAVINGS & GIFT HAMPERS', 'kash-naturals'); ?></span>
        <h1 class="combos-header-title"><?php esc_html_e('Curated Gift Combos & Value Packs', 'kash-naturals'); ?></h1>
        <div class="combos-breadcrumb">
            <a href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('Home', 'kash-naturals'); ?></a>
            <span class="sep">/</span>
            <span class="current"><?php esc_html_e('Combos', 'kash-naturals'); ?></span>
        </div>
    </div>
</div>

<!-- Combos Value Features Banner -->
<section class="combos-value-bar">
    <div class="container combos-value-grid">
        <div class="value-item">
            <div class="value-icon"><i class="fa-solid fa-gift"></i></div>
            <div class="value-text">
                <h4><?php esc_html_e('Festive Gift Packaging', 'kash-naturals'); ?></h4>
                <p><?php esc_html_e('Hand-packed in luxury gift boxes ready for celebrations', 'kash-naturals'); ?></p>
            </div>
        </div>
        <div class="value-item">
            <div class="value-icon"><i class="fa-solid fa-percent"></i></div>
            <div class="value-text">
                <h4><?php esc_html_e('Save Up To 30% Off', 'kash-naturals'); ?></h4>
                <p><?php esc_html_e('Exclusive savings compared to buying individual jars', 'kash-naturals'); ?></p>
            </div>
        </div>
        <div class="value-item">
            <div class="value-icon"><i class="fa-solid fa-truck-fast"></i></div>
            <div class="value-text">
                <h4><?php esc_html_e('Free Cold Delivery', 'kash-naturals'); ?></h4>
                <p><?php esc_html_e('Insulated temperature-controlled shipping nationwide', 'kash-naturals'); ?></p>
            </div>
        </div>
    </div>
</section>

<!-- Combos Showcase Section -->
<section class="combos-showcase-section">
    <div class="container">
        
        <div class="section-header text-center">
            <span class="section-subtitle-exact"><?php esc_html_e('HANDPICKED ASSORTMENTS', 'kash-naturals'); ?></span>
            <h2 class="section-title-exact"><?php esc_html_e('Our Bestselling Gift Combos', 'kash-naturals'); ?></h2>
            <div class="title-gold-divider"></div>
        </div>

        <div class="combos-grid-showcase">
            
            <!-- Combo 1 -->
            <div class="combo-card-exact">
                <div class="combo-badge-floating tag-popular">
                    <?php esc_html_e('POPULAR CHOICE • SAVE 20%', 'kash-naturals'); ?>
                </div>
                <div class="combo-img-box">
                    <img src="<?php echo esc_url($theme_uri . '/assets/images/combo-freshness.jpg'); ?>" alt="Freshness & Digestive Duo Pack">
                </div>
                <div class="combo-card-content">
                    <div class="combo-rating-stars">★★★★★ <span>(4.9/5)</span></div>
                    <h3 class="combo-title"><?php esc_html_e('Freshness & Digestive Duo Pack', 'kash-naturals'); ?></h3>
                    <p class="combo-desc">
                        <?php esc_html_e('The ultimate daily post-meal digestive combination of aromatic paan and sweet saunf in sealed glass jars.', 'kash-naturals'); ?>
                    </p>

                    <div class="combo-items-checklist">
                        <h4><?php esc_html_e('Box Includes:', 'kash-naturals'); ?></h4>
                        <ul>
                            <li><i class="fa-solid fa-check"></i> <?php esc_html_e('1x Royal Calcutta Paan Mukhwas (250g)', 'kash-naturals'); ?></li>
                            <li><i class="fa-solid fa-check"></i> <?php esc_html_e('1x Shahi Sweet Saunf Mix (250g)', 'kash-naturals'); ?></li>
                            <li><i class="fa-solid fa-check"></i> <?php esc_html_e('1x Eco-friendly Gift Outer Box', 'kash-naturals'); ?></li>
                        </ul>
                    </div>

                    <div class="combo-price-row">
                        <div class="combo-price-wrap">
                            <span class="combo-sale-price">₹499</span>
                            <span class="combo-regular-price">₹599</span>
                        </div>
                        <button type="button" class="btn-combo-add-cart" onclick="alert('Freshness & Digestive Duo Pack added to your cart!');">
                            <i class="fa-solid fa-cart-plus"></i> <?php esc_html_e('ADD TO CART', 'kash-naturals'); ?>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Combo 2 -->
            <div class="combo-card-exact">
                <div class="combo-badge-floating tag-value">
                    <?php esc_html_e('BEST VALUE • SAVE 25%', 'kash-naturals'); ?>
                </div>
                <div class="combo-img-box">
                    <img src="<?php echo esc_url($theme_uri . '/assets/images/combo-family.jpg'); ?>" alt="Family Festive Celebration Pack">
                </div>
                <div class="combo-card-content">
                    <div class="combo-rating-stars">★★★★★ <span>(5.0/5)</span></div>
                    <h3 class="combo-title"><?php esc_html_e('Family Festive Celebration Pack', 'kash-naturals'); ?></h3>
                    <p class="combo-desc">
                        <?php esc_html_e('Complete family assortment featuring 4 signature jars of mouth fresheners and chocolate dragees.', 'kash-naturals'); ?>
                    </p>

                    <div class="combo-items-checklist">
                        <h4><?php esc_html_e('Box Includes:', 'kash-naturals'); ?></h4>
                        <ul>
                            <li><i class="fa-solid fa-check"></i> <?php esc_html_e('1x Royal Mukhwas Jar (250g)', 'kash-naturals'); ?></li>
                            <li><i class="fa-solid fa-check"></i> <?php esc_html_e('1x Chocolate Dragees Jar (200g)', 'kash-naturals'); ?></li>
                            <li><i class="fa-solid fa-check"></i> <?php esc_html_e('1x Calcutta Paan Jar (250g)', 'kash-naturals'); ?></li>
                            <li><i class="fa-solid fa-check"></i> <?php esc_html_e('1x Shahi Sweet Saunf Jar (250g)', 'kash-naturals'); ?></li>
                        </ul>
                    </div>

                    <div class="combo-price-row">
                        <div class="combo-price-wrap">
                            <span class="combo-sale-price">₹899</span>
                            <span class="combo-regular-price">₹1,199</span>
                        </div>
                        <button type="button" class="btn-combo-add-cart" onclick="alert('Family Festive Celebration Pack added to your cart!');">
                            <i class="fa-solid fa-cart-plus"></i> <?php esc_html_e('ADD TO CART', 'kash-naturals'); ?>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Combo 3 -->
            <div class="combo-card-exact">
                <div class="combo-badge-floating tag-luxury">
                    <?php esc_html_e('LUXURY EDITION • SAVE 30%', 'kash-naturals'); ?>
                </div>
                <div class="combo-img-box">
                    <img src="<?php echo esc_url($theme_uri . '/assets/images/combo-premium.jpg'); ?>" alt="Royal Connoisseur Treasure Box">
                </div>
                <div class="combo-card-content">
                    <div class="combo-rating-stars">★★★★★ <span>(4.9/5)</span></div>
                    <h3 class="combo-title"><?php esc_html_e('Royal Connoisseur Treasure Box', 'kash-naturals'); ?></h3>
                    <p class="combo-desc">
                        <?php esc_html_e('Our flagship luxury hamper packed with crunch pistachio kunafa bars, chocolate dragees, and silver paan.', 'kash-naturals'); ?>
                    </p>

                    <div class="combo-items-checklist">
                        <h4><?php esc_html_e('Box Includes:', 'kash-naturals'); ?></h4>
                        <ul>
                            <li><i class="fa-solid fa-check"></i> <?php esc_html_e('2x Pistachio Kunafa Bars (100g each)', 'kash-naturals'); ?></li>
                            <li><i class="fa-solid fa-check"></i> <?php esc_html_e('1x Dark Chocolate Almond Dragees (250g)', 'kash-naturals'); ?></li>
                            <li><i class="fa-solid fa-check"></i> <?php esc_html_e('1x Silver Cardamom Paan Jar (250g)', 'kash-naturals'); ?></li>
                            <li><i class="fa-solid fa-check"></i> <?php esc_html_e('Gold Embossed Velvet Gift Box', 'kash-naturals'); ?></li>
                        </ul>
                    </div>

                    <div class="combo-price-row">
                        <div class="combo-price-wrap">
                            <span class="combo-sale-price">₹1,299</span>
                            <span class="combo-regular-price">₹1,799</span>
                        </div>
                        <button type="button" class="btn-combo-add-cart" onclick="alert('Royal Connoisseur Treasure Box added to your cart!');">
                            <i class="fa-solid fa-cart-plus"></i> <?php esc_html_e('ADD TO CART', 'kash-naturals'); ?>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Combo 4 -->
            <div class="combo-card-exact">
                <div class="combo-badge-floating tag-favorite">
                    <?php esc_html_e('GIFT FAVORITE • SAVE 22%', 'kash-naturals'); ?>
                </div>
                <div class="combo-img-box">
                    <img src="<?php echo esc_url($theme_uri . '/assets/images/combo-celebration.jpg'); ?>" alt="Artisanal Celebration Hamper">
                </div>
                <div class="combo-card-content">
                    <div class="combo-rating-stars">★★★★★ <span>(4.8/5)</span></div>
                    <h3 class="combo-title"><?php esc_html_e('Artisanal Celebration Hamper', 'kash-naturals'); ?></h3>
                    <p class="combo-desc">
                        <?php esc_html_e('Perfect gift hamper for corporate occasions, weddings, and festive celebrations.', 'kash-naturals'); ?>
                    </p>

                    <div class="combo-items-checklist">
                        <h4><?php esc_html_e('Box Includes:', 'kash-naturals'); ?></h4>
                        <ul>
                            <li><i class="fa-solid fa-check"></i> <?php esc_html_e('1x Roasted Hazelnut Dragees (200g)', 'kash-naturals'); ?></li>
                            <li><i class="fa-solid fa-check"></i> <?php esc_html_e('1x Royal Paan Mukhwas (250g)', 'kash-naturals'); ?></li>
                            <li><i class="fa-solid fa-check"></i> <?php esc_html_e('1x Pistachio Kunafa Bar (100g)', 'kash-naturals'); ?></li>
                            <li><i class="fa-solid fa-check"></i> <?php esc_html_e('Custom Gift Ribbon & Greeting Card', 'kash-naturals'); ?></li>
                        </ul>
                    </div>

                    <div class="combo-price-row">
                        <div class="combo-price-wrap">
                            <span class="combo-sale-price">₹1,099</span>
                            <span class="combo-regular-price">₹1,399</span>
                        </div>
                        <button type="button" class="btn-combo-add-cart" onclick="alert('Artisanal Celebration Hamper added to your cart!');">
                            <i class="fa-solid fa-cart-plus"></i> <?php esc_html_e('ADD TO CART', 'kash-naturals'); ?>
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Shop on Amazon Banner Section -->
<?php get_template_part('template-parts/content', 'amazon-banner'); ?>

<?php
get_footer();
