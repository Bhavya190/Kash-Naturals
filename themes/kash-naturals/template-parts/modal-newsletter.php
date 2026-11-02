<?php
/**
 * Welcome Newsletter Popup Modal Template Part
 * Included in footer.php across the site
 *
 * @package KashNaturals
 */

if (!defined('ABSPATH')) {
    exit;
}

$is_enabled = (bool) get_theme_mod('kash_newsletter_enable', true);
if (!$is_enabled) {
    return;
}

$theme_uri    = get_template_directory_uri();
$eyebrow      = get_theme_mod('kash_newsletter_eyebrow', __('🌿 ROYAL REWARDS CLUB', 'kash-naturals'));
$headline     = get_theme_mod('kash_newsletter_headline', __('Unlock 10% Off Your First Order', 'kash-naturals'));
$subtext      = get_theme_mod('kash_newsletter_desc', __('Subscribe to receive an instant 10% discount code, secret seasonal drop alerts & authentic artisanal mukhwas recipes.', 'kash-naturals'));
$badge_text   = get_theme_mod('kash_newsletter_badge', __('SPECIAL 10% OFF', 'kash-naturals'));
$coupon_code  = get_theme_mod('kash_newsletter_coupon', 'WELCOME10');
$btn_text     = get_theme_mod('kash_newsletter_btn_text', __('CLAIM 10% DISCOUNT', 'kash-naturals'));
$popup_delay  = floatval(get_theme_mod('kash_newsletter_delay', 3.5));
if ($popup_delay <= 0) {
    $popup_delay = 3.5;
}

$custom_image = get_theme_mod('kash_newsletter_image', '');
if (!empty($custom_image)) {
    $image_url = $custom_image;
} else {
    $image_url = $theme_uri . '/assets/images/combo-celebration.jpg';
    if (!file_exists(get_template_directory() . '/assets/images/combo-celebration.jpg')) {
        $image_url = $theme_uri . '/assets/images/combo-premium.jpg';
    }
}
?>

<!-- One-Time Welcome Newsletter Popup Modal -->
<div class="kash-newsletter-overlay" id="kash-newsletter-modal" data-delay="<?php echo esc_attr($popup_delay); ?>" style="display:none;" aria-hidden="true" role="dialog" aria-labelledby="newsletter-title">
    <div class="kash-newsletter-dialog">

        <div class="kash-newsletter-card">
            
            <!-- Left Side: Visual Luxury Media with Discount Badge -->
            <div class="kash-newsletter-media-col">
                <img src="<?php echo esc_url($image_url); ?>" alt="<?php esc_attr_e('Kash Naturals Welcome Offer', 'kash-naturals'); ?>" class="newsletter-cover-img" loading="lazy">
                <div class="newsletter-media-overlay"></div>
                <div class="newsletter-floating-badge">
                    <i class="fa-solid fa-gift"></i>
                    <span><?php echo esc_html($badge_text); ?></span>
                </div>
            </div>

            <!-- Right Side: Content & Interactive Subscription Form -->
            <div class="kash-newsletter-content-col">
                
                <!-- Close Button (✕) -->
                <button type="button" class="btn-newsletter-close" id="kash-newsletter-close" aria-label="<?php esc_attr_e('Close popup', 'kash-naturals'); ?>">
                    <i class="fa-solid fa-xmark"></i>
                </button>
                
                <!-- 1. Form View -->
                <div id="newsletter-form-container">
                    <?php if (!empty($eyebrow)) : ?>
                        <div class="newsletter-eyebrow-pill">
                            <i class="fa-solid fa-crown"></i>
                            <span><?php echo esc_html($eyebrow); ?></span>
                        </div>
                    <?php endif; ?>

                    <h3 class="newsletter-modal-title" id="newsletter-title"><?php echo esc_html($headline); ?></h3>
                    <p class="newsletter-modal-desc"><?php echo esc_html($subtext); ?></p>

                    <form id="kash-newsletter-form" class="kash-newsletter-form">
                        <div class="newsletter-input-group">
                            <span class="input-icon"><i class="fa-regular fa-user"></i></span>
                            <input type="text" name="subscriber_name" id="newsletter-name" placeholder="<?php esc_attr_e('Your Name (Optional)', 'kash-naturals'); ?>" class="newsletter-field">
                        </div>

                        <div class="newsletter-input-group">
                            <span class="input-icon"><i class="fa-regular fa-envelope"></i></span>
                            <input type="email" name="subscriber_email" id="newsletter-email" placeholder="<?php esc_attr_e('Enter your email address *', 'kash-naturals'); ?>" required class="newsletter-field">
                        </div>

                        <div class="newsletter-alert-msg" id="newsletter-error" style="display:none;"></div>

                        <button type="submit" class="btn-newsletter-submit" id="btn-newsletter-submit">
                            <span class="btn-submit-text"><?php echo esc_html($btn_text); ?></span>
                            <i class="fa-solid fa-arrow-right btn-submit-icon"></i>
                            <i class="fa-solid fa-circle-notch fa-spin btn-submit-spinner" style="display:none;"></i>
                        </button>
                    </form>

                    <div class="newsletter-reassurance">
                        <span><i class="fa-solid fa-shield-halved"></i> <?php esc_html_e('100% Privacy. Zero Spam. Unsubscribe anytime.', 'kash-naturals'); ?></span>
                    </div>

                    <div class="newsletter-dismiss-wrap">
                        <button type="button" class="btn-newsletter-dismiss" id="btn-newsletter-dismiss">
                            <?php esc_html_e('No thanks, continue shopping', 'kash-naturals'); ?>
                        </button>
                    </div>
                </div>

                <!-- 2. Success View (Revealed via AJAX upon subscription) -->
                <div id="newsletter-success-container" style="display:none;" class="newsletter-success-box text-center">
                    <div class="newsletter-success-icon">
                        <i class="fa-solid fa-circle-check"></i>
                    </div>
                    <h3 class="newsletter-success-title"><?php esc_html_e('Welcome to the Royal Family! 🎉', 'kash-naturals'); ?></h3>
                    <p class="newsletter-success-text" id="newsletter-success-msg"><?php esc_html_e('Here is your exclusive welcome discount code:', 'kash-naturals'); ?></p>
                    
                    <div class="newsletter-coupon-box">
                        <div class="coupon-code-wrap">
                            <span class="coupon-code-val" id="newsletter-coupon-code"><?php echo esc_html($coupon_code); ?></span>
                        </div>
                        <button type="button" class="btn-copy-coupon" id="btn-copy-coupon" title="<?php esc_attr_e('Copy Code', 'kash-naturals'); ?>">
                            <i class="fa-regular fa-copy"></i>
                            <span class="copy-text"><?php esc_html_e('COPY', 'kash-naturals'); ?></span>
                        </button>
                    </div>

                    <p class="coupon-use-hint"><?php esc_html_e('Apply this code at checkout to enjoy 10% off your entire first order.', 'kash-naturals'); ?></p>

                    <div class="newsletter-success-actions">
                        <a href="<?php echo esc_url(home_url('/shop')); ?>" class="btn-newsletter-shop-now">
                            <span><?php esc_html_e('START SHOPPING WITH 10% OFF', 'kash-naturals'); ?></span>
                            <i class="fa-solid fa-bag-shopping"></i>
                        </a>
                    </div>
                </div>

            </div>

        </div>

    </div>
</div>
