<?php
/**
 * Template Name: Checkout Page
 * The Template for displaying the modern, luxury Kash Naturals checkout experience
 *
 * @package KashNaturals
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();

$theme_uri = get_template_directory_uri();
$cart_url  = function_exists('wc_get_cart_url') ? wc_get_cart_url() : home_url('/cart');
$shop_url  = function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : home_url('/shop');
?>

<!-- Luxury Checkout Header Banner -->
<div class="shop-page-header checkout-hero-banner">
    <div class="container text-center">
        <span class="shop-header-subtitle">
            <i class="fa-solid fa-shield-halved"></i> <?php esc_html_e('100% SECURE & ENCRYPTED CHECKOUT • PAN-INDIA EXPRESS DELIVERY', 'kash-naturals'); ?>
        </span>
        <h1 class="shop-header-title"><?php esc_html_e('Complete Your Order', 'kash-naturals'); ?></h1>
        <div class="shop-breadcrumb">
            <a href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('Home', 'kash-naturals'); ?></a>
            <span class="sep">/</span>
            <a href="<?php echo esc_url($shop_url); ?>"><?php esc_html_e('Shop', 'kash-naturals'); ?></a>
            <span class="sep">/</span>
            <span class="current"><?php esc_html_e('Checkout', 'kash-naturals'); ?></span>
        </div>

        <!-- 3-Step Trust Progress Stepper -->
        <div class="checkout-stepper-strip">
            <div class="checkout-step-badge done">
                <span class="step-num"><i class="fa-solid fa-check"></i></span>
                <span class="step-label"><?php esc_html_e('Artisanal Bag', 'kash-naturals'); ?></span>
            </div>
            <div class="stepper-line active"></div>
            <div class="checkout-step-badge active">
                <span class="step-num">2</span>
                <span class="step-label"><?php esc_html_e('Shipping Details', 'kash-naturals'); ?></span>
            </div>
            <div class="stepper-line"></div>
            <div class="checkout-step-badge">
                <span class="step-num">3</span>
                <span class="step-label"><?php esc_html_e('Payment & Confirm', 'kash-naturals'); ?></span>
            </div>
        </div>
    </div>
</div>

<!-- Main Checkout Section -->
<section class="checkout-main-section">
    <div class="container">

        <!-- Trust Badges Strip -->
        <div class="checkout-trust-banner">
            <div class="trust-badge-item">
                <div class="trust-icon">
                    <i class="fa-solid fa-lock"></i>
                </div>
                <div class="trust-text">
                    <strong><?php esc_html_e('256-Bit SSL', 'kash-naturals'); ?></strong>
                    <span><?php esc_html_e('Bank-grade Encryption', 'kash-naturals'); ?></span>
                </div>
            </div>
            <div class="trust-badge-item">
                <div class="trust-icon">
                    <i class="fa-solid fa-leaf"></i>
                </div>
                <div class="trust-text">
                    <strong><?php esc_html_e('100% Natural', 'kash-naturals'); ?></strong>
                    <span><?php esc_html_e('Pure & Artisanal Batches', 'kash-naturals'); ?></span>
                </div>
            </div>
            <div class="trust-badge-item">
                <div class="trust-icon">
                    <i class="fa-solid fa-truck-fast"></i>
                </div>
                <div class="trust-text">
                    <strong><?php esc_html_e('Express Delivery', 'kash-naturals'); ?></strong>
                    <span><?php esc_html_e('Pan-India Priority Dispatch', 'kash-naturals'); ?></span>
                </div>
            </div>
            <div class="trust-badge-item">
                <div class="trust-icon">
                    <i class="fa-solid fa-money-bill-1-wave"></i>
                </div>
                <div class="trust-text">
                    <strong><?php esc_html_e('UPI & COD Available', 'kash-naturals'); ?></strong>
                    <span><?php esc_html_e('Pay on delivery or instant UPI', 'kash-naturals'); ?></span>
                </div>
            </div>
        </div>

        <!-- Render WooCommerce Checkout Form / Block Content -->
        <div class="kash-checkout-content-wrap">
            <?php
            if (function_exists('have_posts') && have_posts()) {
                while (have_posts()) :
                    the_post();
                    the_content();
                endwhile;
            } elseif (class_exists('WooCommerce')) {
                echo do_shortcode('[woocommerce_checkout]');
            } else {
                // High-Fidelity Standalone Preview for Local Dev & Testing
                ?>
                <div class="wp-block-woocommerce-checkout alignwide wc-block-checkout is-large">
                    <div class="wc-block-components-sidebar-layout">
                        <!-- Left Column: Order Summary (Swapped for optimal width & focus) -->
                        <div class="wc-block-components-sidebar wc-block-checkout__sidebar">
                            <div class="wc-block-components-order-summary">
                                <h2 class="wc-block-components-order-summary__header"><?php esc_html_e('Order summary', 'kash-naturals'); ?></h2>

                                <div class="wc-block-components-order-summary-item">
                                    <div class="wc-block-components-order-summary-item__image">
                                        <img src="<?php echo esc_url($theme_uri . '/assets/images/jar-royal-mukhwas.jpg'); ?>" alt="Kash Natural Raj Ratan">
                                        <span class="wc-block-components-order-summary-item__quantity">1</span>
                                    </div>
                                    <div class="wc-block-components-order-summary-item__description">
                                        <span class="wc-block-components-product-name">
                                            <?php esc_html_e('Kash Natural Raj Ratan - Sweet & Salty Mukhwas - Traditional Indian Mouth Freshener, 200g', 'kash-naturals'); ?>
                                        </span>
                                        <div class="wc-block-components-order-summary-item__price">
                                            <del>₹300.00</del>
                                            <ins>₹179.00</ins>
                                            <span class="wc-block-components-sale-badge"><?php esc_html_e('Save ₹121.00', 'kash-naturals'); ?></span>
                                        </div>
                                        <div class="wc-block-components-product-metadata">
                                            <span class="wc-block-components-product-metadata__item">200 Grams</span>
                                            <span class="wc-block-components-product-metadata__item">Flavour: Sweet &amp; Salty</span>
                                            <span class="wc-block-components-product-metadata__item" style="color: #1e7e45; font-weight: 600;"><i class="fa-solid fa-circle" style="font-size: 6px;"></i> Vegetarian</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Add a coupon toggle -->
                                <div class="wc-block-components-totals-coupon">
                                    <details style="cursor: pointer;">
                                        <summary class="wc-block-components-panel__button wc-block-components-totals-coupon-link">
                                            <span><i class="fa-solid fa-ticket" style="color: #c68b27; margin-right: 6px;"></i> <?php esc_html_e('Add coupons', 'kash-naturals'); ?></span>
                                            <i class="fa-solid fa-chevron-down" style="font-size: 0.8rem; color: #888;"></i>
                                        </summary>
                                        <div class="wc-block-components-totals-coupon__form">
                                            <div class="wc-block-components-totals-coupon__input">
                                                <input type="text" placeholder="<?php esc_attr_e('Enter code', 'kash-naturals'); ?>">
                                            </div>
                                            <button type="button" class="wc-block-components-totals-coupon__button"><?php esc_html_e('Apply', 'kash-naturals'); ?></button>
                                        </div>
                                    </details>
                                </div>

                                <!-- Totals breakdown -->
                                <div class="wc-block-components-totals-wrapper">
                                    <div class="wc-block-components-totals-item" style="display: flex; justify-content: space-between; padding: 6px 0; font-size: 0.92rem; color: #555;">
                                        <span><?php esc_html_e('Subtotal', 'kash-naturals'); ?></span>
                                        <span style="font-weight: 600; color: #222;">₹179.00</span>
                                    </div>
                                    <div class="wc-block-components-totals-item" style="display: flex; justify-content: space-between; padding: 6px 0; font-size: 0.92rem; color: #555;">
                                        <span><?php esc_html_e('Pan-India Priority Shipping', 'kash-naturals'); ?></span>
                                        <span style="font-weight: 700; color: #27ae60;"><?php esc_html_e('FREE', 'kash-naturals'); ?></span>
                                    </div>
                                    <div class="wc-block-components-totals-footer-item" style="display: flex; justify-content: space-between; align-items: baseline; border-top: 2px dashed #e2d8c9; margin-top: 16px; padding-top: 18px;">
                                        <div>
                                            <span style="display: block; font-family: 'Playfair Display', serif; font-size: 1.25rem; font-weight: 700; color: #0f3820;"><?php esc_html_e('Total', 'kash-naturals'); ?></span>
                                            <span style="font-size: 0.75rem; color: #777;"><?php esc_html_e('Inclusive of all applicable taxes', 'kash-naturals'); ?></span>
                                        </div>
                                        <span class="wc-block-components-totals-item__value" style="font-family: 'Playfair Display', serif; font-size: 1.6rem; font-weight: 800; color: #c68b27;">₹179.00</span>
                                    </div>
                                </div>

                                <div class="summary-trust-seals" style="margin-top: 24px; padding-top: 18px; border-top: 1px dashed #e2d8c9; display: flex; flex-direction: column; gap: 8px;">
                                    <div class="seal-item" style="display: flex; align-items: center; gap: 8px; font-size: 0.8rem; color: #666;"><i class="fa-solid fa-lock" style="color: #27ae60;"></i> <span><?php esc_html_e('256-Bit SSL Encrypted Checkout', 'kash-naturals'); ?></span></div>
                                    <div class="seal-item" style="display: flex; align-items: center; gap: 8px; font-size: 0.8rem; color: #666;"><i class="fa-solid fa-leaf" style="color: #27ae60;"></i> <span><?php esc_html_e('100% Pure Natural Ingredients', 'kash-naturals'); ?></span></div>
                                    <div class="seal-item" style="display: flex; align-items: center; gap: 8px; font-size: 0.8rem; color: #666;"><i class="fa-solid fa-shield-halved" style="color: #27ae60;"></i> <span><?php esc_html_e('Kash Naturals Authentic Quality Guaranteed', 'kash-naturals'); ?></span></div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column: Customer Details, Address & Payment -->
                        <div class="wc-block-components-main">
                            <form class="wc-block-checkout__form">

                            <!-- Step 1: Contact Information -->
                            <div class="wc-block-components-checkout-step wc-block-components-checkout-step--contact-information">
                                <h2 class="wc-block-components-checkout-step__heading"><?php esc_html_e('Contact information', 'kash-naturals'); ?></h2>
                                <div class="wc-block-components-checkout-step__container">
                                    <div class="checkout-form-row checkout-form-row-2col">
                                        <div class="wc-block-components-text-input">
                                            <label for="email"><?php esc_html_e('Email address', 'kash-naturals'); ?> <span class="required" style="color:#d9534f;">*</span></label>
                                            <input type="email" id="email" name="email" value="admin@kashnaturals.com" placeholder="name@domain.com" required>
                                        </div>
                                        <div class="wc-block-components-text-input">
                                            <label for="phone"><?php esc_html_e('Phone number', 'kash-naturals'); ?> <span class="required" style="color:#d9534f;">*</span></label>
                                            <input type="tel" id="phone" name="phone" placeholder="10-digit mobile number" required>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Step 2: Billing & Delivery Address -->
                            <div class="wc-block-components-checkout-step wc-block-components-checkout-step--billing-address">
                                <h2 class="wc-block-components-checkout-step__heading"><?php esc_html_e('Billing address', 'kash-naturals'); ?></h2>
                                <div class="wc-block-components-checkout-step__container">
                                    <div class="checkout-form-row checkout-form-row-full">
                                        <div class="wc-block-components-combobox">
                                            <label for="billing_country"><?php esc_html_e('Country / Region', 'kash-naturals'); ?> <span class="required" style="color:#d9534f;">*</span></label>
                                            <div class="checkout-select-wrap">
                                                <select id="billing_country" name="billing_country" class="input-text">
                                                    <option value="IN" selected>India</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="checkout-form-row checkout-form-row-2col">
                                        <div class="wc-block-components-text-input">
                                            <label for="first_name"><?php esc_html_e('First name', 'kash-naturals'); ?> <span class="required" style="color:#d9534f;">*</span></label>
                                            <input type="text" id="first_name" name="first_name" placeholder="First name" required>
                                        </div>
                                        <div class="wc-block-components-text-input">
                                            <label for="last_name"><?php esc_html_e('Last name', 'kash-naturals'); ?> <span class="required" style="color:#d9534f;">*</span></label>
                                            <input type="text" id="last_name" name="last_name" placeholder="Last name" required>
                                        </div>
                                    </div>

                                    <div class="checkout-form-row checkout-form-row-full">
                                        <div class="wc-block-components-text-input">
                                            <label for="address_1"><?php esc_html_e('Address', 'kash-naturals'); ?> <span class="required" style="color:#d9534f;">*</span></label>
                                            <input type="text" id="address_1" name="address_1" placeholder="House number and street name" required>
                                        </div>
                                    </div>

                                    <div class="checkout-form-row checkout-form-row-full">
                                        <div class="wc-block-components-text-input">
                                            <label for="address_2"><?php esc_html_e('Apartment, suite, unit, etc. (optional)', 'kash-naturals'); ?></label>
                                            <input type="text" id="address_2" name="address_2" placeholder="Apartment, suite, landmark, etc.">
                                        </div>
                                    </div>

                                    <div class="checkout-form-row checkout-form-row-2col">
                                        <div class="wc-block-components-text-input">
                                            <label for="city"><?php esc_html_e('City / Town', 'kash-naturals'); ?> <span class="required" style="color:#d9534f;">*</span></label>
                                            <input type="text" id="city" name="city" placeholder="City" required>
                                        </div>
                                        <div class="wc-block-components-combobox">
                                            <label for="state"><?php esc_html_e('State', 'kash-naturals'); ?> <span class="required" style="color:#d9534f;">*</span></label>
                                            <div class="checkout-select-wrap">
                                                <select id="state" name="state" class="input-text">
                                                    <option value="GJ" selected>Gujarat</option>
                                                    <option value="MH">Maharashtra</option>
                                                    <option value="DL">Delhi</option>
                                                    <option value="KA">Karnataka</option>
                                                    <option value="RJ">Rajasthan</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="checkout-form-row checkout-form-row-full">
                                        <div class="wc-block-components-text-input">
                                            <label for="postcode"><?php esc_html_e('PIN Code', 'kash-naturals'); ?> <span class="required" style="color:#d9534f;">*</span></label>
                                            <input type="text" id="postcode" name="postcode" placeholder="6-digit PIN code" required>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Step 3: Payment Options -->
                            <div class="wc-block-components-checkout-step wc-block-components-checkout-step--payment-method">
                                <h2 class="wc-block-components-checkout-step__heading"><?php esc_html_e('Payment options', 'kash-naturals'); ?></h2>
                                <div class="wc-block-components-checkout-step__container">
                                    <div class="wc-block-components-radio-control">
                                        <label class="wc-block-components-radio-control__option wc-block-components-radio-control__option--checked" style="display: flex; align-items: flex-start; gap: 14px; cursor: pointer;">
                                            <input type="radio" name="payment_method" value="cod" checked class="wc-block-components-radio-control__input" style="margin-top: 4px;">
                                            <div class="wc-block-components-radio-control__option-layout">
                                                <span class="wc-block-components-radio-control__label">
                                                    <i class="fa-solid fa-hand-holding-dollar" style="color: #27ae60; margin-right: 6px;"></i>
                                                    <?php esc_html_e('Cash on delivery', 'kash-naturals'); ?>
                                                </span>
                                                <div class="wc-block-components-radio-control__description">
                                                    <?php esc_html_e('Pay with cash or UPI QR scan upon delivery at your doorstep.', 'kash-naturals'); ?>
                                                </div>
                                            </div>
                                        </label>

                                        <label class="wc-block-components-radio-control__option" style="display: flex; align-items: flex-start; gap: 14px; cursor: pointer;">
                                            <input type="radio" name="payment_method" value="online" class="wc-block-components-radio-control__input" style="margin-top: 4px;">
                                            <div class="wc-block-components-radio-control__option-layout">
                                                <span class="wc-block-components-radio-control__label">
                                                    <i class="fa-solid fa-bolt" style="color: #c68b27; margin-right: 6px;"></i>
                                                    <?php esc_html_e('Instant UPI / Cards / NetBanking', 'kash-naturals'); ?>
                                                </span>
                                                <div class="wc-block-components-radio-control__description">
                                                    <?php esc_html_e('Fast, contactless payment via Google Pay, PhonePe, Paytm, Cards & UPI.', 'kash-naturals'); ?>
                                                </div>
                                            </div>
                                        </label>
                                    </div>

                                    <div style="margin-top: 20px; padding: 14px 18px; background: #faf8f5; border: 1.5px solid #ede5d8; border-radius: 12px;">
                                        <label style="display: flex; align-items: center; gap: 10px; font-size: 0.9rem; font-weight: 600; color: #333; cursor: pointer;">
                                            <input type="checkbox" name="order_notes_toggle" style="accent-color: #0f3820; width: 17px; height: 17px;">
                                            <?php esc_html_e('Add a note to your order (gift message, landmark, or special delivery instructions)', 'kash-naturals'); ?>
                                        </label>
                                    </div>

                                    <div class="wc-block-checkout__terms" style="margin-top: 18px; font-size: 0.85rem; color: #666; line-height: 1.5;">
                                        <?php esc_html_e('By proceeding with your purchase you agree to our', 'kash-naturals'); ?> <a href="<?php echo esc_url(home_url('/terms-and-conditions')); ?>" style="color: #0f3820; font-weight: 600; text-decoration: underline;"><?php esc_html_e('Terms and Conditions', 'kash-naturals'); ?></a> <?php esc_html_e('and', 'kash-naturals'); ?> <a href="<?php echo esc_url(home_url('/privacy-policy')); ?>" style="color: #0f3820; font-weight: 600; text-decoration: underline;"><?php esc_html_e('Privacy Policy', 'kash-naturals'); ?></a>.
                                    </div>

                                    <div class="wc-block-checkout__actions" style="margin-top: 22px;">
                                        <button type="submit" class="wc-block-components-checkout-place-order-button">
                                            <i class="fa-solid fa-lock" style="margin-right: 8px;"></i> <?php esc_html_e('Place Order • ₹179.00', 'kash-naturals'); ?>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            </form>
                        </div>

                    </div>
                </div>
                <?php
            }
            ?>
        </div>

        <!-- Bottom Security & Quality Seal -->
        <div class="checkout-security-footer text-center">
            <div class="security-seal-pills">
                <span><i class="fa-solid fa-shield-heart"></i> <?php esc_html_e('Kash Naturals Authentic Quality Guaranteed', 'kash-naturals'); ?></span>
                <span><i class="fa-solid fa-headset"></i> <?php esc_html_e('Dedicated Customer Support: +91 98765 43210', 'kash-naturals'); ?></span>
                <span><i class="fa-solid fa-rotate-left"></i> <?php esc_html_e('Hassle-Free Return Policy', 'kash-naturals'); ?></span>
            </div>
        </div>

    </div>
</section>

<?php
get_footer();
