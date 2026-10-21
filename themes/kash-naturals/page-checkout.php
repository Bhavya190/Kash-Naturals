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
            // Initialize WooCommerce checkout instance if available
            $checkout = function_exists('WC') && WC()->checkout ? WC()->checkout() : null;

            // Check for real WooCommerce cart items and totals
            $wc_checkout_items = array();
            $has_real_wc_items = false;
            $cart_subtotal_display = '₹179.00';
            $cart_total_display = '₹179.00';
            $shipping_display = __('FREE', 'kash-naturals');

            if (function_exists('WC') && WC()->cart && !WC()->cart->is_empty()) {
                $has_real_wc_items = true;
                $cart_subtotal_display = WC()->cart->get_cart_subtotal();
                $cart_total_display = WC()->cart->get_total();
                $shipping_display = WC()->cart->get_cart_shipping_total() ? WC()->cart->get_cart_shipping_total() : __('FREE', 'kash-naturals');

                foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
                    $_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
                    if ($_product && $_product->exists() && $cart_item['quantity'] > 0) {
                        $image_id = $_product->get_image_id();
                        $image_url = $image_id ? wp_get_attachment_image_url($image_id, 'medium') : $theme_uri . '/assets/images/jar-royal-mukhwas.jpg';
                        $wc_checkout_items[] = array(
                            'name' => $_product->get_name(),
                            'qty' => $cart_item['quantity'],
                            'image' => $image_url,
                            'price_html' => WC()->cart->get_product_subtotal($_product, $cart_item['quantity'])
                        );
                    }
                }
            }

            // Indian states list
            $indian_states = array(
                'AP' => 'Andhra Pradesh',
                'AR' => 'Arunachal Pradesh',
                'AS' => 'Assam',
                'BR' => 'Bihar',
                'CT' => 'Chhattisgarh',
                'GA' => 'Goa',
                'GJ' => 'Gujarat',
                'HR' => 'Haryana',
                'HP' => 'Himachal Pradesh',
                'JK' => 'Jammu and Kashmir',
                'JH' => 'Jharkhand',
                'KA' => 'Karnataka',
                'KL' => 'Kerala',
                'MP' => 'Madhya Pradesh',
                'MH' => 'Maharashtra',
                'MN' => 'Manipur',
                'ML' => 'Meghalaya',
                'MZ' => 'Mizoram',
                'NL' => 'Nagaland',
                'OR' => 'Odisha',
                'PB' => 'Punjab',
                'RJ' => 'Rajasthan',
                'SK' => 'Sikkim',
                'TN' => 'Tamil Nadu',
                'TS' => 'Telangana',
                'TR' => 'Tripura',
                'UK' => 'Uttarakhand',
                'UP' => 'Uttar Pradesh',
                'WB' => 'West Bengal',
                'AN' => 'Andaman and Nicobar Islands',
                'CH' => 'Chandigarh',
                'DH' => 'Dadra and Nagar Haveli and Daman and Diu',
                'DL' => 'Delhi',
                'LD' => 'Lakshadweep',
                'PY' => 'Puducherry',
                'LA' => 'Ladakh',
            );
            if (function_exists('WC') && WC()->countries) {
                $wc_states = WC()->countries->get_states('IN');
                if (!empty($wc_states) && is_array($wc_states)) {
                    $indian_states = $wc_states;
                }
            }
            $current_state = ($checkout && $checkout->get_value('billing_state')) ? $checkout->get_value('billing_state') : 'GJ';
            ?>

            <!-- Display WooCommerce Validation & Error Notices -->
            <div class="woocommerce-notices-wrapper">
                <?php
                if (function_exists('woocommerce_output_all_notices')) {
                    woocommerce_output_all_notices();
                } elseif (function_exists('wc_print_notices')) {
                    wc_print_notices();
                }
                ?>
            </div>

            <div class="wp-block-woocommerce-checkout alignwide wc-block-checkout is-large">
                <div class="wc-block-components-sidebar-layout">
                    <!-- Left Column: Order Summary (Swapped for optimal width & focus) -->
                    <div class="wc-block-components-sidebar wc-block-checkout__sidebar">
                        <div class="wc-block-components-order-summary">
                            <h2 class="wc-block-components-order-summary__header"><?php esc_html_e('Order summary', 'kash-naturals'); ?></h2>

                            <?php if ($has_real_wc_items) : ?>
                                <?php foreach ($wc_checkout_items as $item) : ?>
                                    <div class="wc-block-components-order-summary-item">
                                        <div class="wc-block-components-order-summary-item__image">
                                            <img src="<?php echo esc_url($item['image']); ?>" alt="<?php echo esc_attr($item['name']); ?>">
                                            <span class="wc-block-components-order-summary-item__quantity"><?php echo esc_html($item['qty']); ?></span>
                                        </div>
                                        <div class="wc-block-components-order-summary-item__description">
                                            <span class="wc-block-components-product-name"><?php echo esc_html($item['name']); ?></span>
                                            <div class="wc-block-components-order-summary-item__price">
                                                <ins><?php echo wp_kses_post($item['price_html']); ?></ins>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else : ?>
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
                            <?php endif; ?>

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
                                        <span style="font-weight: 600; color: #222;"><?php echo wp_kses_post($cart_subtotal_display); ?></span>
                                    </div>
                                    <div class="wc-block-components-totals-item" style="display: flex; justify-content: space-between; padding: 6px 0; font-size: 0.92rem; color: #555;">
                                        <span><?php esc_html_e('Pan-India Priority Shipping', 'kash-naturals'); ?></span>
                                        <span style="font-weight: 700; color: #27ae60;"><?php echo wp_kses_post($shipping_display); ?></span>
                                    </div>
                                    <div class="wc-block-components-totals-footer-item" style="display: flex; justify-content: space-between; align-items: baseline; border-top: 2px dashed #e2d8c9; margin-top: 16px; padding-top: 18px;">
                                        <div>
                                            <span style="display: block; font-family: 'Playfair Display', serif; font-size: 1.25rem; font-weight: 700; color: #0f3820;"><?php esc_html_e('Total', 'kash-naturals'); ?></span>
                                            <span style="font-size: 0.75rem; color: #777;"><?php esc_html_e('Inclusive of all applicable taxes', 'kash-naturals'); ?></span>
                                        </div>
                                        <span class="wc-block-components-totals-item__value" style="font-family: 'Playfair Display', serif; font-size: 1.6rem; font-weight: 800; color: #c68b27;"><?php echo wp_kses_post($cart_total_display); ?></span>
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
                            <form name="checkout" method="post" class="wc-block-checkout__form checkout woocommerce-checkout" action="<?php echo esc_url(function_exists('wc_get_checkout_url') ? wc_get_checkout_url() : home_url('/checkout')); ?>" enctype="multipart/form-data">
                                <?php if (function_exists('wp_nonce_field')) { wp_nonce_field('woocommerce-process_checkout', 'woocommerce-process-checkout-nonce'); } ?>
                                <?php do_action('woocommerce_checkout_before_customer_details'); ?>

                            <!-- Step 1: Contact Information -->
                            <div class="wc-block-components-checkout-step wc-block-components-checkout-step--contact-information">
                                <h2 class="wc-block-components-checkout-step__heading"><?php esc_html_e('Contact information', 'kash-naturals'); ?></h2>
                                <div class="wc-block-components-checkout-step__container">
                                    <div class="checkout-form-row checkout-form-row-2col">
                                        <div class="wc-block-components-text-input">
                                            <label for="billing_email"><?php esc_html_e('Email address', 'kash-naturals'); ?> <span class="required" style="color:#d9534f;">*</span></label>
                                            <input type="email" id="billing_email" name="billing_email" class="input-text" placeholder="example@gmail.com" required value="<?php echo esc_attr($checkout ? $checkout->get_value('billing_email') : ''); ?>" autocomplete="email">
                                        </div>
                                        <div class="wc-block-components-text-input">
                                            <label for="billing_phone"><?php esc_html_e('Phone number', 'kash-naturals'); ?> <span class="required" style="color:#d9534f;">*</span></label>
                                            <input type="tel" id="billing_phone" name="billing_phone" class="input-text" placeholder="10-digit mobile number" required value="<?php echo esc_attr($checkout ? $checkout->get_value('billing_phone') : ''); ?>" autocomplete="tel">
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
                                                <select id="billing_country" name="billing_country" class="input-text" autocomplete="country">
                                                    <option value="IN" selected>India</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="checkout-form-row checkout-form-row-2col">
                                        <div class="wc-block-components-text-input">
                                            <label for="billing_first_name"><?php esc_html_e('First name', 'kash-naturals'); ?> <span class="required" style="color:#d9534f;">*</span></label>
                                            <input type="text" id="billing_first_name" name="billing_first_name" class="input-text" placeholder="<?php esc_attr_e('First name', 'kash-naturals'); ?>" required value="<?php echo esc_attr($checkout ? $checkout->get_value('billing_first_name') : ''); ?>" autocomplete="given-name">
                                        </div>
                                        <div class="wc-block-components-text-input">
                                            <label for="billing_last_name"><?php esc_html_e('Last name', 'kash-naturals'); ?> <span class="required" style="color:#d9534f;">*</span></label>
                                            <input type="text" id="billing_last_name" name="billing_last_name" class="input-text" placeholder="<?php esc_attr_e('Last name', 'kash-naturals'); ?>" required value="<?php echo esc_attr($checkout ? $checkout->get_value('billing_last_name') : ''); ?>" autocomplete="family-name">
                                        </div>
                                    </div>

                                    <div class="checkout-form-row checkout-form-row-full">
                                        <div class="wc-block-components-text-input">
                                            <label for="billing_address_1"><?php esc_html_e('Address', 'kash-naturals'); ?> <span class="required" style="color:#d9534f;">*</span></label>
                                            <input type="text" id="billing_address_1" name="billing_address_1" class="input-text" placeholder="<?php esc_attr_e('House number and street name', 'kash-naturals'); ?>" required value="<?php echo esc_attr($checkout ? $checkout->get_value('billing_address_1') : ''); ?>" autocomplete="address-line1">
                                        </div>
                                    </div>

                                    <div class="checkout-form-row checkout-form-row-full">
                                        <div class="wc-block-components-text-input">
                                            <label for="billing_address_2"><?php esc_html_e('Apartment, suite, unit, etc. (optional)', 'kash-naturals'); ?></label>
                                            <input type="text" id="billing_address_2" name="billing_address_2" class="input-text" placeholder="<?php esc_attr_e('Apartment, suite, landmark, etc.', 'kash-naturals'); ?>" value="<?php echo esc_attr($checkout ? $checkout->get_value('billing_address_2') : ''); ?>" autocomplete="address-line2">
                                        </div>
                                    </div>

                                    <div class="checkout-form-row checkout-form-row-2col">
                                        <div class="wc-block-components-text-input">
                                            <label for="billing_city"><?php esc_html_e('City / Town', 'kash-naturals'); ?> <span class="required" style="color:#d9534f;">*</span></label>
                                            <input type="text" id="billing_city" name="billing_city" class="input-text" placeholder="<?php esc_attr_e('City', 'kash-naturals'); ?>" required value="<?php echo esc_attr($checkout ? $checkout->get_value('billing_city') : ''); ?>" autocomplete="address-level2">
                                        </div>
                                        <div class="wc-block-components-combobox">
                                            <label for="billing_state"><?php esc_html_e('State', 'kash-naturals'); ?> <span class="required" style="color:#d9534f;">*</span></label>
                                            <div class="checkout-select-wrap">
                                                <select id="billing_state" name="billing_state" class="input-text" autocomplete="address-level1">
                                                    <?php foreach ($indian_states as $st_code => $st_name) : ?>
                                                        <option value="<?php echo esc_attr($st_code); ?>" <?php selected($current_state, $st_code); ?>>
                                                            <?php echo esc_html($st_name); ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="checkout-form-row checkout-form-row-full">
                                        <div class="wc-block-components-text-input">
                                            <label for="billing_postcode"><?php esc_html_e('PIN Code', 'kash-naturals'); ?> <span class="required" style="color:#d9534f;">*</span></label>
                                            <input type="text" id="billing_postcode" name="billing_postcode" class="input-text" placeholder="<?php esc_attr_e('6-digit PIN code', 'kash-naturals'); ?>" required value="<?php echo esc_attr($checkout ? $checkout->get_value('billing_postcode') : ''); ?>" autocomplete="postal-code" maxlength="6" pattern="[0-9]{6}">
                                        </div>
                                    </div>

                                    <!-- Shipping Synchronization & Compatibility Fields -->
                                    <input type="hidden" name="ship_to_different_address" value="0">
                                    <input type="hidden" name="terms" value="1">
                                    <input type="hidden" name="terms-field" value="1">
                                    <?php
                                    if ( function_exists('WC') && WC()->cart && WC()->cart->needs_shipping() ) {
                                        $chosen_shipping_methods = function_exists('WC') && WC()->session ? WC()->session->get( 'chosen_shipping_methods', array() ) : array();
                                        $packages = function_exists('WC') && WC()->shipping ? WC()->shipping()->get_packages() : array();
                                        if ( ! empty( $packages ) ) {
                                            foreach ( $packages as $i => $package ) {
                                                $chosen = isset( $chosen_shipping_methods[ $i ] ) ? $chosen_shipping_methods[ $i ] : '';
                                                if ( ! empty( $package['rates'] ) ) {
                                                    if ( empty( $chosen ) || ! isset( $package['rates'][ $chosen ] ) ) {
                                                        $chosen = key( $package['rates'] );
                                                    }
                                                    echo '<input type="hidden" name="shipping_method[' . esc_attr( $i ) . ']" value="' . esc_attr( $chosen ) . '" class="shipping_method">';
                                                }
                                            }
                                        }
                                    }
                                    ?>
                                </div>
                            </div>

                            <?php do_action('woocommerce_checkout_after_customer_details'); ?>

                            <!-- Step 3: Payment Options -->
                            <div class="wc-block-components-checkout-step wc-block-components-checkout-step--payment-method">
                                <h2 class="wc-block-components-checkout-step__heading"><?php esc_html_e('Payment options', 'kash-naturals'); ?></h2>
                                <div class="wc-block-components-checkout-step__container">
                                    <?php
                                    $available_gateways = array();
                                    if (function_exists('WC') && WC()->payment_gateways) {
                                        $available_gateways = WC()->payment_gateways->get_available_payment_gateways();
                                    }

                                    $chosen_gateway = '';
                                    if (function_exists('WC') && WC()->session) {
                                        $chosen_gateway = WC()->session->get('chosen_payment_method');
                                    }
                                    if (empty($chosen_gateway) && !empty($available_gateways)) {
                                        $chosen_gateway = isset($available_gateways['cod']) ? 'cod' : key($available_gateways);
                                    }

                                    do_action('woocommerce_review_order_before_payment');
                                    ?>

                                    <div id="payment" class="wc-block-components-radio-control payment-methods-list">
                                        <?php if (!empty($available_gateways)) : ?>
                                            <ul class="wc_payment_methods payment_methods methods" style="list-style: none; margin: 0; padding: 0;">
                                                <?php foreach ($available_gateways as $gateway) :
                                                    $is_checked = ($gateway->id === $chosen_gateway);
                                                    $icon_html = '';
                                                    if ($gateway->id === 'cod') {
                                                        $icon_html = '<i class="fa-solid fa-hand-holding-dollar" style="color: #27ae60; margin-right: 8px;"></i>';
                                                    } elseif (in_array($gateway->id, array('razorpay', 'phonepe', 'phonepe_woocommerce', 'paytm', 'cashfree', 'upi'))) {
                                                        $icon_html = '<i class="fa-solid fa-bolt" style="color: #c68b27; margin-right: 8px;"></i>';
                                                    } elseif ($gateway->id === 'bacs') {
                                                        $icon_html = '<i class="fa-solid fa-building-columns" style="color: #0f3820; margin-right: 8px;"></i>';
                                                    } else {
                                                        $icon_html = '<i class="fa-solid fa-credit-card" style="color: #c68b27; margin-right: 8px;"></i>';
                                                    }
                                                ?>
                                                    <li class="wc_payment_method payment_method_<?php echo esc_attr($gateway->id); ?>" style="margin-bottom: 12px;">
                                                        <label class="wc-block-components-radio-control__option <?php echo $is_checked ? 'wc-block-components-radio-control__option--checked' : ''; ?>" for="payment_method_<?php echo esc_attr($gateway->id); ?>" style="display: flex; align-items: flex-start; gap: 14px; cursor: pointer;">
                                                            <input id="payment_method_<?php echo esc_attr($gateway->id); ?>" type="radio" class="input-radio wc-block-components-radio-control__input" name="payment_method" value="<?php echo esc_attr($gateway->id); ?>" <?php checked($is_checked, true); ?> data-order_button_text="<?php echo esc_attr($gateway->order_button_text); ?>" style="margin-top: 4px;">
                                                            <div class="wc-block-components-radio-control__option-layout" style="flex: 1;">
                                                                <span class="wc-block-components-radio-control__label" style="display: flex; align-items: center; justify-content: space-between;">
                                                                    <span><?php echo $icon_html; ?><?php echo esc_html($gateway->get_title()); ?></span>
                                                                    <?php if ($gateway->id === 'cod') : ?>
                                                                        <span style="font-size: 0.72rem; padding: 2px 8px; background: #e8f5e9; color: #2e7d32; border-radius: 4px; font-weight: 600;">RECOMMENDED</span>
                                                                    <?php elseif ($gateway->has_fields() || in_array($gateway->id, array('razorpay', 'phonepe', 'paytm', 'cashfree', 'upi'))) : ?>
                                                                        <span style="font-size: 0.72rem; padding: 2px 8px; background: #fff8e1; color: #b78103; border-radius: 4px; font-weight: 600;">INSTANT UPI &amp; CARDS</span>
                                                                    <?php endif; ?>
                                                                </span>
                                                                <?php if ($gateway->get_description()) : ?>
                                                                    <div class="wc-block-components-radio-control__description payment_box payment_method_<?php echo esc_attr($gateway->id); ?>" style="font-size: 0.85rem; color: #666; margin-top: 4px; line-height: 1.45;">
                                                                        <?php echo wp_kses_post($gateway->get_description()); ?>
                                                                    </div>
                                                                <?php endif; ?>
                                                                <?php if ($gateway->has_fields()) : ?>
                                                                    <div class="payment_box payment_method_<?php echo esc_attr($gateway->id); ?>" style="<?php echo $is_checked ? '' : 'display:none;'; ?> margin-top: 10px; padding: 12px; background: #fdfcf9; border: 1px solid #e8dfd2; border-radius: 8px;">
                                                                        <?php $gateway->payment_fields(); ?>
                                                                    </div>
                                                                <?php endif; ?>
                                                            </div>
                                                        </label>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        <?php else : ?>
                                            <!-- Fallback if gateways not yet initialized -->
                                            <div class="wc-block-components-radio-control">
                                                <label class="wc-block-components-radio-control__option wc-block-components-radio-control__option--checked" style="display: flex; align-items: flex-start; gap: 14px; cursor: pointer;">
                                                    <input type="radio" name="payment_method" value="cod" checked class="wc-block-components-radio-control__input" style="margin-top: 4px;">
                                                    <div class="wc-block-components-radio-control__option-layout">
                                                        <span class="wc-block-components-radio-control__label">
                                                            <i class="fa-solid fa-hand-holding-dollar" style="color: #27ae60; margin-right: 6px;"></i>
                                                            <?php esc_html_e('Cash on delivery (COD)', 'kash-naturals'); ?>
                                                        </span>
                                                        <div class="wc-block-components-radio-control__description">
                                                            <?php esc_html_e('Pay with cash or UPI QR scan upon delivery at your doorstep.', 'kash-naturals'); ?>
                                                        </div>
                                                    </div>
                                                </label>
                                            </div>
                                        <?php endif; ?>
                                    </div>

                                    <?php do_action('woocommerce_review_order_after_payment'); ?>

                                    <div class="checkout-order-notes-wrap" style="margin-top: 20px; padding: 14px 18px; background: #faf8f5; border: 1.5px solid #ede5d8; border-radius: 12px;">
                                        <label style="display: flex; align-items: center; gap: 10px; font-size: 0.9rem; font-weight: 600; color: #333; cursor: pointer;">
                                            <input type="checkbox" id="order_notes_toggle" name="order_notes_toggle" style="accent-color: #0f3820; width: 17px; height: 17px;" onchange="var el = document.getElementById('order_comments_container'); if(el) el.style.display = this.checked ? 'block' : 'none';">
                                            <?php esc_html_e('Add a note to your order (gift message, landmark, or special delivery instructions)', 'kash-naturals'); ?>
                                        </label>
                                        <div id="order_comments_container" style="display: none; margin-top: 12px;">
                                            <textarea id="order_comments" name="order_comments" class="input-text" rows="3" placeholder="<?php esc_attr_e('Notes about your order, e.g. special notes for delivery or gift message.', 'kash-naturals'); ?>" style="width: 100%; border: 1.5px solid #d4c8b8; border-radius: 8px; padding: 10px 14px; font-family: inherit; font-size: 0.9rem; background: #fff; box-sizing: border-box;"></textarea>
                                        </div>
                                    </div>

                                    <?php do_action('woocommerce_review_order_before_submit'); ?>

                                    <div class="wc-block-checkout__terms" style="margin-top: 18px; font-size: 0.85rem; color: #666; line-height: 1.5;">
                                        <?php esc_html_e('By proceeding with your purchase you agree to our', 'kash-naturals'); ?> <a href="<?php echo esc_url(home_url('/terms-and-conditions')); ?>" style="color: #0f3820; font-weight: 600; text-decoration: underline;"><?php esc_html_e('Terms and Conditions', 'kash-naturals'); ?></a> <?php esc_html_e('and', 'kash-naturals'); ?> <a href="<?php echo esc_url(home_url('/privacy-policy')); ?>" style="color: #0f3820; font-weight: 600; text-decoration: underline;"><?php esc_html_e('Privacy Policy', 'kash-naturals'); ?></a>.
                                    </div>

                                    <div class="wc-block-checkout__actions" style="margin-top: 22px;">
                                        <?php
                                        $order_btn_text = apply_filters('woocommerce_order_button_text', sprintf(__('Place Order • %s', 'kash-naturals'), strip_tags($cart_total_display)));
                                        ?>
                                        <button type="submit" class="wc-block-components-checkout-place-order-button" name="woocommerce_checkout_place_order" id="place_order" value="<?php echo esc_attr($order_btn_text); ?>" data-value="<?php echo esc_attr($order_btn_text); ?>">
                                            <i class="fa-solid fa-lock" style="margin-right: 8px;"></i> <?php echo esc_html($order_btn_text); ?>
                                        </button>
                                    </div>

                                    <?php do_action('woocommerce_review_order_after_submit'); ?>
                                </div>
                            </div>

                            </form>
                            <?php if ($checkout) { do_action('woocommerce_after_checkout_form', $checkout); } ?>
                        </div>
                    </div>
                </div>
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
