<?php
/**
 * Promotional Product Deal & Offer Spotlight Section Template Part
 * Placed on Homepage after the "Shop on Amazon" section
 *
 * @package KashNaturals
 */

if (!defined('ABSPATH')) {
    exit;
}

// Check if section is enabled in Customizer
$is_enabled = (bool) get_theme_mod('kash_promo_enable', true);
if (!$is_enabled) {
    return;
}

$theme_uri       = get_template_directory_uri();
$currency_symbol = function_exists('get_woocommerce_currency_symbol') ? get_woocommerce_currency_symbol() : '₹';

// 1. Retrieve configured or auto-selected product
$chosen_prod_id = get_theme_mod('kash_promo_product_id', '');
$product        = null;

if (class_exists('WooCommerce')) {
    if (!empty($chosen_prod_id) && $chosen_prod_id !== 'none') {
        $product = wc_get_product(intval($chosen_prod_id));
    }

    // Auto-fallback: Find first on-sale product or bestselling product
    if (!$product || !is_a($product, 'WC_Product')) {
        $on_sale_ids = wc_get_product_ids_on_sale();
        if (!empty($on_sale_ids)) {
            $product = wc_get_product($on_sale_ids[0]);
        }
    }

    if (!$product || !is_a($product, 'WC_Product')) {
        $recent_prods = wc_get_products(array('limit' => 1, 'orderby' => 'menu_order date', 'order' => 'DESC'));
        if (!empty($recent_prods)) {
            $product = $recent_prods[0];
        }
    }
}

// 2. Prepare defaults from product
$prod_id      = ($product && is_a($product, 'WC_Product')) ? $product->get_id() : 0;
$product_link = ($product && is_a($product, 'WC_Product')) ? get_permalink($product->get_id()) : home_url('/shop');

// Title
$custom_title = get_theme_mod('kash_promo_title', '');
if (!empty($custom_title)) {
    $title = $custom_title;
} elseif ($product) {
    $title = $product->get_name();
} else {
    $title = __('Royal Calcutta Paan Shots & Mukhwas', 'kash-naturals');
}

// Eyebrow Tag
$eyebrow = get_theme_mod('kash_promo_eyebrow', __('⚡ LIMITED TIME EXCLUSIVE OFFER', 'kash-naturals'));

// Description
$custom_desc = get_theme_mod('kash_promo_desc', '');
if (!empty($custom_desc)) {
    $description = $custom_desc;
} elseif ($product) {
    $short_desc = $product->get_short_description();
    if (empty($short_desc)) {
        $short_desc = wp_strip_all_tags(get_post_field('post_excerpt', $product->get_id()));
    }
    $description = !empty($short_desc) ? wp_strip_all_tags($short_desc) : __('Handcrafted royal digestive blended with authentic betel leaves, dry dates, pure gulkand, and aromatic seeds for unmatched freshness.', 'kash-naturals');
} else {
    $description = __('Handcrafted royal digestive blended with authentic betel leaves, dry dates, pure gulkand, and aromatic seeds for unmatched freshness.', 'kash-naturals');
}

// Pricing calculation
$custom_deal_price = get_theme_mod('kash_promo_deal_price', '');
$custom_old_price  = get_theme_mod('kash_promo_old_price', '');
$calc_deal_price   = '';
$calc_old_price    = '';
$calc_percent_off  = 25;

if ($product) {
    $sale_p = $product->get_sale_price();
    $reg_p  = $product->get_regular_price();
    $curr_p = $product->get_price();

    if (!empty($sale_p)) {
        $calc_deal_price = $currency_symbol . $sale_p;
        if (!empty($reg_p) && floatval($reg_p) > floatval($sale_p)) {
            $calc_old_price = $currency_symbol . $reg_p;
            $calc_percent_off = round(((floatval($reg_p) - floatval($sale_p)) / floatval($reg_p)) * 100);
        }
    } elseif (!empty($curr_p)) {
        $calc_deal_price = $currency_symbol . $curr_p;
        $suggested_old = round(floatval($curr_p) * 1.35);
        $calc_old_price = $currency_symbol . $suggested_old;
    }
}

$deal_price = !empty($custom_deal_price) ? $custom_deal_price : (!empty($calc_deal_price) ? $calc_deal_price : $currency_symbol . '179');
$old_price  = !empty($custom_old_price) ? $custom_old_price : (!empty($calc_old_price) ? $calc_old_price : $currency_symbol . '249');

// Discount Badge Text
$custom_badge = get_theme_mod('kash_promo_badge', '');
if (!empty($custom_badge)) {
    $badge_text = $custom_badge;
} else {
    $badge_text = sprintf(__('FLAT %d%% OFF', 'kash-naturals'), $calc_percent_off);
}

// Savings Tag Ribbon
$custom_save_tag = get_theme_mod('kash_promo_save_text', '');
if (!empty($custom_save_tag)) {
    $save_tag = $custom_save_tag;
} else {
    $save_tag = sprintf(__('SPECIAL OFFER • SAVE %d%%', 'kash-naturals'), $calc_percent_off);
}

// Product Image
$custom_img = get_theme_mod('kash_promo_image', '');
if (!empty($custom_img)) {
    $image_url = $custom_img;
} elseif ($product && $product->get_image_id()) {
    $image_url = wp_get_attachment_image_url($product->get_image_id(), 'large');
} else {
    $image_url = $theme_uri . '/assets/images/jar-calcutta-pan.jpg';
    if (!file_exists(get_template_directory() . '/assets/images/jar-calcutta-pan.jpg')) {
        $image_url = $theme_uri . '/assets/images/product-royal-mukhwas.jpg';
    }
}

// Action Button Text & Link
$btn_text = get_theme_mod('kash_promo_btn_text', __('CLAIM OFFER & BUY NOW', 'kash-naturals'));
$custom_btn_url = get_theme_mod('kash_promo_btn_url', '');
if (!empty($custom_btn_url)) {
    $btn_link = $custom_btn_url;
} else {
    $btn_link = $product_link;
}

// Urgency notice text
$urgency_note = get_theme_mod('kash_promo_urgency_text', __('🔥 High Demand: Only 14 packs left at this promotional discount!', 'kash-naturals'));

// Timer configuration
$timer_hours = intval(get_theme_mod('kash_promo_timer_hours', 24));
if ($timer_hours <= 0) {
    $timer_hours = 24;
}
$timer_label = get_theme_mod('kash_promo_timer_label', __('⚡ Limited Time Deal Ends In:', 'kash-naturals'));
?>

<section class="kash-deal-promo-section" id="promotional-deal-section">
    <div class="container">
        
        <div class="deal-promo-card-banner">
            <!-- Decorative Ambient Lighting Glows -->
            <div class="deal-bg-glow-orb deal-glow-1"></div>
            <div class="deal-bg-glow-orb deal-glow-2"></div>

            <div class="deal-promo-grid">
                
                <!-- Left Column: Visual Product Showcase -->
                <div class="deal-product-showcase-col">
                    <div class="deal-image-stage">
                        
                        <!-- Floating Discount Badge -->
                        <?php if (!empty($badge_text)) : ?>
                            <div class="deal-discount-badge">
                                <i class="fa-solid fa-bolt"></i>
                                <span><?php echo esc_html($badge_text); ?></span>
                            </div>
                        <?php endif; ?>

                        <!-- Glass Rating Pill -->
                        <div class="deal-rating-pill">
                            <i class="fa-solid fa-star"></i>
                            <span class="rating-num">5.0</span>
                            <span class="rating-count">(500+ Reviews)</span>
                        </div>

                        <!-- Main Product Image Frame -->
                        <a href="<?php echo esc_url($product_link); ?>" class="deal-product-frame" aria-label="<?php echo esc_attr($title); ?>">
                            <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($title); ?>" class="deal-product-img" loading="lazy">
                        </a>

                        <!-- Micro Trust Pills Below Image -->
                        <div class="deal-trust-micro-badges">
                            <span class="micro-badge"><i class="fa-solid fa-leaf"></i> <?php esc_html_e('100% Natural', 'kash-naturals'); ?></span>
                            <span class="micro-badge"><i class="fa-solid fa-shield-heart"></i> <?php esc_html_e('Zero Preservatives', 'kash-naturals'); ?></span>
                            <span class="micro-badge"><i class="fa-solid fa-award"></i> <?php esc_html_e('Royal Heritage Taste', 'kash-naturals'); ?></span>
                        </div>

                    </div>
                </div>

                <!-- Right Column: Deal Information & Action Hub -->
                <div class="deal-content-col">
                    
                    <!-- Eyebrow Pill -->
                    <?php if (!empty($eyebrow)) : ?>
                        <div class="deal-eyebrow-pill">
                            <span><?php echo esc_html($eyebrow); ?></span>
                        </div>
                    <?php endif; ?>

                    <!-- Product Main Title -->
                    <h2 class="deal-title">
                        <a href="<?php echo esc_url($product_link); ?>">
                            <?php echo esc_html($title); ?>
                        </a>
                    </h2>

                    <!-- Flavor / Product Teaser Description -->
                    <p class="deal-description">
                        <?php echo esc_html($description); ?>
                    </p>

                    <!-- Realtime Countdown Timer Card -->
                    <div class="deal-countdown-box">
                        <div class="deal-countdown-header">
                            <i class="fa-regular fa-clock"></i>
                            <span><?php echo esc_html($timer_label); ?></span>
                        </div>
                        <div class="deal-timer-digits" data-timer-hours="<?php echo esc_attr($timer_hours); ?>">
                            <div class="timer-block">
                                <span class="timer-val timer-hours">00</span>
                                <span class="timer-unit"><?php esc_html_e('HOURS', 'kash-naturals'); ?></span>
                            </div>
                            <span class="timer-sep">:</span>
                            <div class="timer-block">
                                <span class="timer-val timer-mins">00</span>
                                <span class="timer-unit"><?php esc_html_e('MINS', 'kash-naturals'); ?></span>
                            </div>
                            <span class="timer-sep">:</span>
                            <div class="timer-block">
                                <span class="timer-val timer-secs">00</span>
                                <span class="timer-unit"><?php esc_html_e('SECS', 'kash-naturals'); ?></span>
                            </div>
                        </div>
                    </div>

                    <!-- Pricing & Savings Highlight -->
                    <div class="deal-price-row">
                        <div class="deal-price-current"><?php echo esc_html($deal_price); ?></div>
                        <?php if (!empty($old_price)) : ?>
                            <div class="deal-price-old"><?php echo esc_html($old_price); ?></div>
                        <?php endif; ?>
                        <?php if (!empty($save_tag)) : ?>
                            <span class="deal-save-ribbon"><?php echo esc_html($save_tag); ?></span>
                        <?php endif; ?>
                    </div>

                    <!-- Urgency Stock Notice -->
                    <?php if (!empty($urgency_note)) : ?>
                        <div class="deal-urgency-notice">
                            <span class="pulse-dot"></span>
                            <span><?php echo esc_html($urgency_note); ?></span>
                        </div>
                    <?php endif; ?>

                    <!-- Action Buttons -->
                    <div class="deal-actions-row">
                        <?php if ($prod_id > 0) : ?>
                            <button type="button" class="btn-deal-primary add-to-cart-btn add_to_cart_button ajax_add_to_cart" data-product-id="<?php echo esc_attr($prod_id); ?>" data-product_id="<?php echo esc_attr($prod_id); ?>" data-product-name="<?php echo esc_attr($title); ?>" data-product-price="<?php echo esc_attr($deal_price); ?>" data-product-img="<?php echo esc_url($image_url); ?>">
                                <i class="fa-solid fa-bag-shopping"></i>
                                <span><?php echo esc_html($btn_text); ?></span>
                            </button>
                        <?php else : ?>
                            <a href="<?php echo esc_url($btn_link); ?>" class="btn-deal-primary">
                                <i class="fa-solid fa-bag-shopping"></i>
                                <span><?php echo esc_html($btn_text); ?></span>
                            </a>
                        <?php endif; ?>

                        <a href="<?php echo esc_url($product_link); ?>" class="btn-deal-secondary">
                            <span><?php esc_html_e('View Product Details', 'kash-naturals'); ?></span>
                            <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    </div>

                    <!-- Trust Strip -->
                    <div class="deal-trust-strip">
                        <div class="trust-item">
                            <i class="fa-solid fa-truck-fast"></i>
                            <span><?php esc_html_e('Free Fast Shipping', 'kash-naturals'); ?></span>
                        </div>
                        <div class="trust-item">
                            <i class="fa-solid fa-shield-halved"></i>
                            <span><?php esc_html_e('100% Safe Checkout', 'kash-naturals'); ?></span>
                        </div>
                        <div class="trust-item">
                            <i class="fa-solid fa-circle-check"></i>
                            <span><?php esc_html_e('Authentic Freshness Guaranteed', 'kash-naturals'); ?></span>
                        </div>
                    </div>

                </div>

            </div>
        </div>

    </div>
</section>

<script>
(function() {
    function initDealCountdown() {
        var timerContainer = document.querySelector('.deal-timer-digits');
        if (!timerContainer) return;

        var hoursConfig = parseInt(timerContainer.getAttribute('data-timer-hours'), 10) || 24;
        var storageKey = 'kash_deal_timer_end_' + hoursConfig;
        var endTime = localStorage.getItem(storageKey);
        var now = Date.now();

        if (!endTime || parseInt(endTime, 10) <= now) {
            endTime = now + (hoursConfig * 60 * 60 * 1000);
            localStorage.setItem(storageKey, endTime);
        } else {
            endTime = parseInt(endTime, 10);
        }

        var hoursEl = timerContainer.querySelector('.timer-hours');
        var minsEl = timerContainer.querySelector('.timer-mins');
        var secsEl = timerContainer.querySelector('.timer-secs');

        function updateClock() {
            var diff = Math.max(0, endTime - Date.now());

            if (diff <= 0) {
                // Automatically reset rolling timer for persistent excitement
                endTime = Date.now() + (hoursConfig * 60 * 60 * 1000);
                localStorage.setItem(storageKey, endTime);
                diff = endTime - Date.now();
            }

            var hours = Math.floor(diff / (1000 * 60 * 60));
            var mins = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
            var secs = Math.floor((diff % (1000 * 60)) / 1000);

            if (hoursEl) hoursEl.textContent = (hours < 10 ? '0' : '') + hours;
            if (minsEl) minsEl.textContent = (mins < 10 ? '0' : '') + mins;
            if (secsEl) secsEl.textContent = (secs < 10 ? '0' : '') + secs;
        }

        updateClock();
        setInterval(updateClock, 1000);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initDealCountdown);
    } else {
        initDealCountdown();
    }
})();
</script>
