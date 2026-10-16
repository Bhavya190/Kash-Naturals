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

$combo_items = array();

// Query Dynamic Combo Products from WooCommerce
if (class_exists('WooCommerce')) {
    $combo_query = new WP_Query(array(
        'post_type'      => 'product',
        'post_status'    => 'publish',
        'posts_per_page' => 4,
        'tax_query'      => array(
            'relation' => 'OR',
            array(
                'taxonomy' => 'product_cat',
                'field'    => 'slug',
                'terms'    => array('combos', 'gift-combos', 'combo', 'hampers', 'gifts'),
            ),
            array(
                'taxonomy' => 'product_tag',
                'field'    => 'slug',
                'terms'    => array('combo', 'combos', 'gift', 'hampers'),
            ),
        ),
    ));

    if ($combo_query->have_posts()) {
        $currency_symbol = function_exists('get_woocommerce_currency_symbol') ? get_woocommerce_currency_symbol() : '₹';
        $bg_palette = array('#688A28', '#DF8B2B', '#56771C', '#A13423');
        $scripts = array('Freshness', 'Bestseller', 'Handcrafted', 'Celebration');
        $idx = 0;

        while ($combo_query->have_posts()) {
            $combo_query->the_post();
            $wc_prod = wc_get_product(get_the_ID());
            if ($wc_prod && $wc_prod->is_visible()) {
                $img_url = wp_get_attachment_image_url($wc_prod->get_image_id(), 'kash-product-hero');
                if (!$img_url) {
                    $img_url = $theme_uri . '/assets/images/combo-freshness.jpg';
                }

                $sub = $wc_prod->get_short_description();
                if (empty($sub)) {
                    $sub = wp_strip_all_tags(get_the_excerpt());
                }
                if (empty($sub)) {
                    $sub = __('Handcrafted luxury combo pack carefully curated for gifting & celebration.', 'kash-naturals');
                }

                $rating = $wc_prod->get_average_rating();
                $rating_str = ($rating > 0) ? number_format((float)$rating, 1) : '5.0';

                $sale_price = $wc_prod->get_price();
                $reg_price = $wc_prod->get_regular_price();

                $combo_items[] = array(
                    'script'    => isset($scripts[$idx % 4]) ? $scripts[$idx % 4] : 'Special',
                    'title'     => $wc_prod->get_name(),
                    'subtitle'  => wp_trim_words($sub, 18, '...'),
                    'rating'    => $rating_str,
                    'price'     => !empty($sale_price) ? $currency_symbol . $sale_price : $currency_symbol . '0',
                    'old_price' => (!empty($reg_price) && $reg_price > $sale_price) ? $currency_symbol . $reg_price : '',
                    'bg_color'  => $bg_palette[$idx % 4],
                    'image'     => $img_url,
                    'link'      => get_permalink($wc_prod->get_id()),
                );
                $idx++;
            }
        }
        wp_reset_postdata();
    }
}

// If no combo products in WooCommerce, keep empty and display clean empty state notice
?>

<section class="section-padding combo-offers-section-exact" id="combos">
    <div class="container">
        
        <!-- Section Header -->
        <div class="combo-header-exact text-center mb-5">
            <span class="combo-sub-heading"><?php esc_html_e('— CURATED COMBOS —', 'kash-naturals'); ?></span>
            <h2 class="combo-main-heading"><?php esc_html_e('Special Savings & Gift Hampers', 'kash-naturals'); ?></h2>
            <div class="gold-divider"></div>
        </div>

        <?php if (!empty($combo_items)) : ?>
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
                            <span class="price-label"><?php esc_html_e('PRICE', 'kash-naturals'); ?></span>
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
                                <?php esc_html_e('ORDER NOW', 'kash-naturals'); ?>
                            </a>
                        </div>

                    </div>
                <?php endforeach; ?>
            </div>
        <?php else : ?>
            <div class="kash-empty-products-state text-center">
                <div class="empty-state-icon">
                    <i class="fa-solid fa-gift"></i>
                </div>
                <h3 class="empty-state-title"><?php esc_html_e('No Combo Offers Available', 'kash-naturals'); ?></h3>
                <p class="empty-state-desc"><?php esc_html_e('Check back soon for special gift hampers and curated value packs.', 'kash-naturals'); ?></p>
            </div>
        <?php endif; ?>

    </div>
</section>
