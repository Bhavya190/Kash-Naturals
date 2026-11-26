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

if (!function_exists('selected')) {
    function selected($selected, $current = true, $echo = true) {
        $result = ((string) $selected === (string) $current) ? ' selected="selected"' : '';
        if ($echo) { echo $result; }
        return $result;
    }
}
if (!function_exists('checked')) {
    function checked($checked, $current = true, $echo = true) {
        $result = ((string) $checked === (string) $current) ? ' checked="checked"' : '';
        if ($echo) { echo $result; }
        return $result;
    }
}
if (!function_exists('absint')) {
    function absint($maybeint) {
        return abs((int) $maybeint);
    }
}

// Check for WooCommerce order-pay and order-received endpoints first!
$is_received_page = (function_exists('is_order_received_page') && is_order_received_page())
    || (!empty($GLOBALS['wp']) && !empty($GLOBALS['wp']->query_vars['order-received']))
    || (isset($_GET['order-received']));

$is_pay_page = (function_exists('is_checkout_pay_page') && is_checkout_pay_page())
    || (!empty($_GET['pay_for_order']) && !empty($_GET['key']))
    || (!empty($GLOBALS['wp']) && !empty($GLOBALS['wp']->query_vars['order-pay']));

if ($is_received_page) {
    get_header();
    $shop_url = function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : home_url('/shop');
    global $wp;
    $order_id = (isset($wp->query_vars['order-received']) && $wp->query_vars['order-received']) ? absint($wp->query_vars['order-received']) : 0;
    if (!$order_id && isset($_GET['order-received'])) {
        $order_id = absint($_GET['order-received']);
    }
    $order = ($order_id && function_exists('wc_get_order')) ? wc_get_order($order_id) : false;
    ?>
    <!-- Luxury Order Confirmed Header -->
    <div class="shop-page-header checkout-hero-banner">
        <div class="container text-center">
            <span class="shop-header-subtitle">
                <i class="fa-solid fa-circle-check" style="color: #4ade80;"></i> <?php esc_html_e('100% SECURE & VERIFIED ORDER • ROYAL PATRONAGE', 'kash-naturals'); ?>
            </span>
            <h1 class="shop-header-title"><?php esc_html_e('Thank You For Your Order', 'kash-naturals'); ?></h1>
            <div class="shop-breadcrumb">
                <a href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('Home', 'kash-naturals'); ?></a>
                <span class="sep">/</span>
                <a href="<?php echo esc_url($shop_url); ?>"><?php esc_html_e('Shop', 'kash-naturals'); ?></a>
                <span class="sep">/</span>
                <span class="current"><?php esc_html_e('Order Confirmation', 'kash-naturals'); ?></span>
            </div>

            <!-- 3-Step Trust Progress Stepper (All Completed) -->
            <div class="checkout-stepper-strip" id="checkout-stepper-strip" style="margin-top: 24px;">
                <div class="checkout-step-badge done">
                    <span class="step-num"><i class="fa-solid fa-check"></i></span>
                    <span class="step-label"><?php esc_html_e('Artisanal Bag', 'kash-naturals'); ?></span>
                </div>
                <div class="stepper-line active"></div>
                <div class="checkout-step-badge done">
                    <span class="step-num"><i class="fa-solid fa-check"></i></span>
                    <span class="step-label"><?php esc_html_e('Shipping Details', 'kash-naturals'); ?></span>
                </div>
                <div class="stepper-line active"></div>
                <div class="checkout-step-badge done active">
                    <span class="step-num"><i class="fa-solid fa-check"></i></span>
                    <span class="step-label"><?php esc_html_e('Order Confirmed', 'kash-naturals'); ?></span>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Thank You / Confirmation Section -->
    <section class="checkout-main-section order-confirmation-section" style="padding: 50px 0 80px;">
        <div class="container">
            <div class="kash-order-received-card" style="max-width: 860px; margin: 0 auto; background: #ffffff; border-radius: 20px; border: 1.5px solid #ede5d8; padding: 40px 45px; box-shadow: 0 12px 35px rgba(15, 56, 32, 0.06);">
                <div class="woocommerce-notices-wrapper">
                    <?php
                    if (function_exists('woocommerce_output_all_notices')) {
                        woocommerce_output_all_notices();
                    } elseif (function_exists('wc_print_notices')) {
                        wc_print_notices();
                    }
                    ?>
                </div>

                <?php
                if (class_exists('WC_Shortcode_Checkout')) {
                    WC_Shortcode_Checkout::output(array());
                } elseif ($order && function_exists('wc_get_template')) {
                    wc_get_template('checkout/thankyou.php', array('order' => $order));
                } elseif (function_exists('have_posts') && have_posts()) {
                    while (have_posts()) : the_post();
                        the_content();
                    endwhile;
                } else {
                    ?>
                    <div class="text-center" style="padding: 30px 20px;">
                        <div style="font-size: 3.5rem; color: #27ae60; margin-bottom: 16px;">
                            <i class="fa-solid fa-circle-check"></i>
                        </div>
                        <h2 style="font-family: 'Playfair Display', serif; color: #0f3820; font-size: 2.1rem; margin-bottom: 12px;">
                            <?php esc_html_e('Your Order Has Been Received!', 'kash-naturals'); ?>
                        </h2>
                        <p style="font-family: 'Outfit', sans-serif; color: #666; font-size: 1.05rem; line-height: 1.6; max-width: 540px; margin: 0 auto 30px;">
                            <?php esc_html_e('Thank you for choosing Kash Naturals. An email confirmation with order and delivery tracking details has been sent to your email address.', 'kash-naturals'); ?>
                        </p>
                        <a href="<?php echo esc_url($shop_url); ?>" class="btn-royal-gold" style="display: inline-block; padding: 14px 32px; background: linear-gradient(135deg, #c68b27 0%, #a8721a 100%); color: #fff; font-family: 'Outfit', sans-serif; font-weight: 700; border-radius: 30px; text-decoration: none; box-shadow: 0 6px 18px rgba(198, 139, 39, 0.35);">
                            <?php esc_html_e('Continue Shopping', 'kash-naturals'); ?>
                        </a>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
    </section>
    <?php
    get_footer();
    return;
}

if ($is_pay_page) {
    get_header();
    $shop_url = function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : home_url('/shop');
    global $wp;
    $order_id = (isset($wp->query_vars['order-pay']) && $wp->query_vars['order-pay']) ? absint($wp->query_vars['order-pay']) : 0;
    if (!$order_id && isset($_GET['order-pay'])) {
        $order_id = absint($_GET['order-pay']);
    }
    if (!$order_id && isset($_GET['order_id'])) {
        $order_id = absint($_GET['order_id']);
    }
    $order = ($order_id && function_exists('wc_get_order')) ? wc_get_order($order_id) : false;
    ?>
    <!-- Luxury Checkout Pay Banner -->
    <div class="shop-page-header checkout-hero-banner">
        <div class="container text-center">
            <span class="shop-header-subtitle">
                <i class="fa-solid fa-shield-halved"></i> <?php esc_html_e('100% SECURE & ENCRYPTED PAYMENT • RAZORPAY GATEWAY', 'kash-naturals'); ?>
            </span>
            <h1 class="shop-header-title"><?php esc_html_e('Complete Your Payment', 'kash-naturals'); ?></h1>
            <div class="shop-breadcrumb">
                <a href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('Home', 'kash-naturals'); ?></a>
                <span class="sep">/</span>
                <a href="<?php echo esc_url($shop_url); ?>"><?php esc_html_e('Shop', 'kash-naturals'); ?></a>
                <span class="sep">/</span>
                <span class="current"><?php esc_html_e('Order Payment', 'kash-naturals'); ?></span>
            </div>

            <!-- 3-Step Stepper -->
            <div class="checkout-stepper-strip" id="checkout-stepper-strip" style="margin-top: 24px;">
                <div class="checkout-step-badge done">
                    <span class="step-num"><i class="fa-solid fa-check"></i></span>
                    <span class="step-label"><?php esc_html_e('Artisanal Bag', 'kash-naturals'); ?></span>
                </div>
                <div class="stepper-line active"></div>
                <div class="checkout-step-badge done">
                    <span class="step-num"><i class="fa-solid fa-check"></i></span>
                    <span class="step-label"><?php esc_html_e('Shipping Details', 'kash-naturals'); ?></span>
                </div>
                <div class="stepper-line active"></div>
                <div class="checkout-step-badge active">
                    <span class="step-num">3</span>
                    <span class="step-label"><?php esc_html_e('Payment & Confirm', 'kash-naturals'); ?></span>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Payment Section -->
    <section class="checkout-main-section order-pay-section" style="padding: 50px 0 80px;">
        <div class="container">
            <div class="kash-order-pay-card" style="max-width: 800px; margin: 0 auto; background: #ffffff; border-radius: 20px; border: 1.5px solid #ede5d8; padding: 40px 45px; box-shadow: 0 12px 35px rgba(15, 56, 32, 0.06);">
                <div class="woocommerce-notices-wrapper">
                    <?php
                    if (function_exists('woocommerce_output_all_notices')) {
                        woocommerce_output_all_notices();
                    } elseif (function_exists('wc_print_notices')) {
                        wc_print_notices();
                    }
                    ?>
                </div>

                <?php
                if (class_exists('WC_Shortcode_Checkout')) {
                    WC_Shortcode_Checkout::output(array());
                } elseif ($order && function_exists('wc_get_template')) {
                    wc_get_template('checkout/form-pay.php', array('order' => $order));
                } elseif (function_exists('have_posts') && have_posts()) {
                    while (have_posts()) : the_post();
                        the_content();
                    endwhile;
                } else {
                    ?>
                    <div class="text-center" style="padding: 30px 20px;">
                        <h2 style="font-family: 'Playfair Display', serif; color: #0f3820; font-size: 2rem; margin-bottom: 12px;">
                            <?php esc_html_e('Payment Authorization', 'kash-naturals'); ?>
                        </h2>
                        <p style="font-family: 'Outfit', sans-serif; color: #666; font-size: 1.05rem; line-height: 1.6; max-width: 520px; margin: 0 auto 25px;">
                            <?php esc_html_e('Processing secure Razorpay gateway transaction... If the payment window does not open automatically, please return to checkout.', 'kash-naturals'); ?>
                        </p>
                        <a href="<?php echo esc_url(function_exists('wc_get_checkout_url') ? wc_get_checkout_url() : home_url('/checkout')); ?>" class="btn-royal-gold" style="display: inline-block; padding: 14px 32px; background: linear-gradient(135deg, #0f3820 0%, #17482b 100%); color: #fff; border: 2px solid #c68b27; font-family: 'Outfit', sans-serif; font-weight: 700; border-radius: 30px; text-decoration: none; box-shadow: 0 6px 18px rgba(15, 56, 32, 0.25);">
                            <?php esc_html_e('Return to Checkout', 'kash-naturals'); ?>
                        </a>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
    </section>
    <?php
    get_footer();
    return;
}

get_header();

$theme_uri = get_template_directory_uri();
$cart_url  = function_exists('wc_get_cart_url') ? wc_get_cart_url() : home_url('/cart');
$shop_url  = function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : home_url('/shop');

// Check if cart is empty on real WooCommerce
$is_real_wc = function_exists('WC') && WC()->cart;
$cart_is_empty = $is_real_wc && WC()->cart->is_empty() && (!function_exists('is_customize_preview') || !is_customize_preview());
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
        <div class="checkout-stepper-strip" id="checkout-stepper-strip">
            <a href="<?php echo esc_url($cart_url); ?>" class="checkout-step-badge done" id="step-badge-1" style="text-decoration: none;">
                <span class="step-num"><i class="fa-solid fa-check"></i></span>
                <span class="step-label"><?php esc_html_e('Artisanal Bag', 'kash-naturals'); ?></span>
            </a>
            <div class="stepper-line active" id="stepper-line-1"></div>
            <div class="checkout-step-badge active" id="step-badge-2" style="cursor: pointer;">
                <span class="step-num" id="step-num-2">2</span>
                <span class="step-label"><?php esc_html_e('Shipping Details', 'kash-naturals'); ?></span>
            </div>
            <div class="stepper-line" id="stepper-line-2"></div>
            <div class="checkout-step-badge" id="step-badge-3" style="cursor: pointer;">
                <span class="step-num" id="step-num-3">3</span>
                <span class="step-label"><?php esc_html_e('Payment & Confirm', 'kash-naturals'); ?></span>
            </div>
        </div>
    </div>
</div>

<!-- Main Checkout Section -->
<section class="checkout-main-section">
    <div class="container">

        <?php if ($cart_is_empty) : ?>
            <!-- Friendly Empty Cart Notice -->
            <div class="empty-cart-container text-center" style="padding: 70px 20px; background: #ffffff; border-radius: 18px; border: 1.5px solid #ede5d8; max-width: 680px; margin: 40px auto; box-shadow: 0 10px 30px rgba(15, 56, 32, 0.05);">
                <div class="empty-cart-icon" style="font-size: 4rem; color: #c68b27; margin-bottom: 20px;">
                    <i class="fa-solid fa-bag-shopping"></i>
                </div>
                <h2 style="font-family: 'Playfair Display', serif; font-size: 2.2rem; color: #0f3820; margin-bottom: 14px;">
                    <?php esc_html_e('Your Artisanal Bag is Empty', 'kash-naturals'); ?>
                </h2>
                <p style="font-family: 'Outfit', sans-serif; font-size: 1.05rem; color: #666; max-width: 500px; margin: 0 auto 30px auto; line-height: 1.6;">
                    <?php esc_html_e('Explore our collection of authentic royal mukhwas and luxury chocolates before proceeding to checkout.', 'kash-naturals'); ?>
                </p>
                <a href="<?php echo esc_url($shop_url); ?>" class="btn-royal-gold" style="display: inline-block; padding: 15px 36px; background: linear-gradient(135deg, #c68b27 0%, #a8721a 100%); color: #fff; font-family: 'Outfit', sans-serif; font-weight: 700; font-size: 1rem; border-radius: 30px; text-decoration: none; box-shadow: 0 6px 18px rgba(198, 139, 39, 0.35); transition: transform 0.2s ease;">
                    <i class="fa-solid fa-arrow-left" style="margin-right: 8px;"></i> <?php esc_html_e('Explore Artisanal Collection', 'kash-naturals'); ?>
                </a>
            </div>
        <?php else : ?>

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
                        <i class="fa-solid fa-bolt"></i>
                    </div>
                    <div class="trust-text">
                        <strong><?php esc_html_e('Razorpay & UPI Active', 'kash-naturals'); ?></strong>
                        <span><?php esc_html_e('Cards, UPI, NetBanking & COD', 'kash-naturals'); ?></span>
                    </div>
                </div>
            </div>

            <!-- Render WooCommerce Checkout Form -->
            <div class="kash-checkout-content-wrap">
                <?php
                // Initialize WooCommerce checkout instance if available
                $checkout = function_exists('WC') && WC()->checkout ? WC()->checkout() : null;

                // Ensure shipping calculation is triggered if needed
                if (function_exists('WC') && WC()->cart && WC()->cart->needs_shipping() && WC()->shipping()) {
                    WC()->shipping()->calculate_shipping(WC()->cart->get_shipping_packages());
                }

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
                <div class="woocommerce-NoticeGroup woocommerce-NoticeGroup-checkout"></div>

                <!-- Unified WooCommerce Checkout Form (Enveloping both columns for 100% API compliance) -->
                <form name="checkout" method="post" class="checkout woocommerce-checkout wc-block-checkout__form" action="<?php echo esc_url(function_exists('wc_get_checkout_url') ? wc_get_checkout_url() : home_url('/checkout')); ?>" enctype="multipart/form-data">

                    <?php if ($checkout) { do_action('woocommerce_before_checkout_form', $checkout); } ?>

                    <div class="wp-block-woocommerce-checkout alignwide wc-block-checkout is-large">
                        <div class="wc-block-components-sidebar-layout">

                            <!-- Left Column: Order Summary (Sticky on Desktop) -->
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
                                                    <div class="wc-block-components-order-summary-item__price" style="font-family: 'Outfit', sans-serif;">
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
                                                <div class="wc-block-components-order-summary-item__price" style="font-family: 'Outfit', sans-serif;">
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
                                                    <input type="text" id="kash-checkout-coupon-code" placeholder="<?php esc_attr_e('Enter code', 'kash-naturals'); ?>">
                                                </div>
                                                <button type="button" class="wc-block-components-totals-coupon__button" id="kash-checkout-apply-coupon"><?php esc_html_e('Apply', 'kash-naturals'); ?></button>
                                            </div>
                                        </details>
                                    </div>

                                    <!-- Totals breakdown -->
                                    <div class="wc-block-components-totals-wrapper">
                                        <div class="wc-block-components-totals-item" style="display: flex; justify-content: space-between; padding: 6px 0; font-size: 0.92rem; color: #555;">
                                            <span><?php esc_html_e('Subtotal', 'kash-naturals'); ?></span>
                                            <span style="font-family: 'Outfit', sans-serif; font-weight: 600; color: #222;"><?php echo wp_kses_post($cart_subtotal_display); ?></span>
                                        </div>
                                        <div class="wc-block-components-totals-item" style="display: flex; justify-content: space-between; padding: 6px 0; font-size: 0.92rem; color: #555;">
                                            <span><?php esc_html_e('Pan-India Priority Shipping', 'kash-naturals'); ?></span>
                                            <span style="font-family: 'Outfit', sans-serif; font-weight: 700; color: #27ae60;"><?php echo wp_kses_post($shipping_display); ?></span>
                                        </div>
                                        <div class="wc-block-components-totals-footer-item" style="display: flex; justify-content: space-between; align-items: baseline; border-top: 2px dashed #e2d8c9; margin-top: 16px; padding-top: 18px;">
                                            <div>
                                                <span style="display: block; font-family: 'Playfair Display', serif; font-size: 1.25rem; font-weight: 700; color: #0f3820;"><?php esc_html_e('Total', 'kash-naturals'); ?></span>
                                                <span style="font-size: 0.75rem; color: #777;"><?php esc_html_e('Inclusive of all applicable taxes', 'kash-naturals'); ?></span>
                                            </div>
                                            <span class="wc-block-components-totals-item__value" style="font-family: 'Outfit', sans-serif; font-size: 1.6rem; font-weight: 800; color: #c68b27;"><?php echo wp_kses_post($cart_total_display); ?></span>
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

                                <?php if ($checkout) { do_action('woocommerce_checkout_before_customer_details'); } ?>

                                <!-- TAB PANE 2: Shipping Details (Step 2) -->
                                <div id="kash-checkout-tab-step-2" class="kash-checkout-tab-pane active-tab">

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

                                        <!-- Step 2 to Step 3 Transition Action Button -->
                                        <div class="checkout-form-row checkout-form-row-full checkout-proceed-btn-wrap" style="margin-top: 20px;">
                                            <button type="button" class="btn-proceed-to-payment" id="btn-proceed-to-payment" style="width: 100%; padding: 16px 24px; background: linear-gradient(135deg, #0f3820 0%, #17482b 100%); color: #ffffff; border: 2px solid #c68b27; border-radius: 14px; font-family: 'Outfit', sans-serif; font-size: 1.05rem; font-weight: 700; letter-spacing: 0.5px; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 10px; box-shadow: 0 8px 24px rgba(15, 56, 32, 0.25); transition: all 0.25s ease;">
                                                <span><?php esc_html_e('Proceed to Payment Options', 'kash-naturals'); ?></span>
                                                <i class="fa-solid fa-arrow-right" style="color: #c68b27; font-size: 1.1rem;"></i>
                                            </button>
                                        </div>

                                        <!-- Shipping Synchronization & Compatibility Fields -->
                                        <input type="hidden" name="ship_to_different_address" value="0">
                                        <input type="hidden" name="terms" value="1">
                                        <input type="hidden" name="terms-field" value="1">
                                        <?php
                                        $rendered_shipping = false;
                                        if (function_exists('WC') && WC()->cart && WC()->cart->needs_shipping()) {
                                            $chosen_shipping_methods = function_exists('WC') && WC()->session ? WC()->session->get('chosen_shipping_methods', array()) : array();
                                            $packages = function_exists('WC') && WC()->shipping ? WC()->shipping()->get_packages() : array();
                                            if (!empty($packages)) {
                                                foreach ($packages as $i => $package) {
                                                    $chosen = isset($chosen_shipping_methods[$i]) ? $chosen_shipping_methods[$i] : '';
                                                    if (!empty($package['rates'])) {
                                                        if (empty($chosen) || !isset($package['rates'][$chosen])) {
                                                            $chosen = key($package['rates']);
                                                        }
                                                        echo '<input type="hidden" name="shipping_method[' . esc_attr($i) . ']" value="' . esc_attr($chosen) . '" class="shipping_method">';
                                                        $rendered_shipping = true;
                                                    }
                                                }
                                            }
                                        }
                                        if (!$rendered_shipping) {
                                            echo '<input type="hidden" name="shipping_method[0]" value="free_shipping:1" class="shipping_method">';
                                        }
                                        ?>
                                    </div>
                                </div>
                                </div><!-- /#kash-checkout-tab-step-2 -->

                                <?php if ($checkout) { do_action('woocommerce_checkout_after_customer_details'); } ?>

                                <!-- TAB PANE 3: Payment & Confirm (Step 3) -->
                                <div id="kash-checkout-tab-step-3" class="kash-checkout-tab-pane">

                                    <!-- Step 3 Delivery & Contact Summary Box -->
                                    <div class="wc-block-components-checkout-step kash-step-3-shipping-card" style="margin-bottom: 24px; padding: 22px 28px; background: #ffffff; border: 1.5px solid #eee7dd; border-radius: 18px; box-shadow: 0 4px 18px rgba(15, 40, 25, 0.03);">
                                        <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #f3ece2; padding-bottom: 12px; margin-bottom: 14px;">
                                            <div style="display: flex; align-items: center; gap: 10px;">
                                                <span style="display: inline-flex; align-items: center; justify-content: center; width: 24px; height: 24px; background: #e8f5e9; color: #27ae60; border-radius: 50%; font-size: 0.8rem;"><i class="fa-solid fa-check"></i></span>
                                                <strong style="color: #0f3820; font-family: 'Outfit', sans-serif; font-size: 1.05rem;"><?php esc_html_e('Delivery & Contact Details', 'kash-naturals'); ?></strong>
                                            </div>
                                            <button type="button" class="btn-return-to-shipping" id="btn-edit-shipping-step" style="padding: 6px 14px; background: #fdfaf5; border: 1.5px solid #c68b27; color: #0f3820; border-radius: 8px; font-size: 0.82rem; font-weight: 700; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; transition: all 0.2s ease;">
                                                <i class="fa-solid fa-pen-to-square" style="color: #c68b27;"></i> <?php esc_html_e('Change', 'kash-naturals'); ?>
                                            </button>
                                        </div>
                                        <div style="display: grid; grid-template-columns: 80px 1fr; row-gap: 8px; font-size: 0.92rem;">
                                            <span style="color: #777; font-weight: 500;"><?php esc_html_e('Contact:', 'kash-naturals'); ?></span>
                                            <span id="kash-step-3-summary-contact" style="color: #222; font-weight: 600;"></span>
                                            <span style="color: #777; font-weight: 500;"><?php esc_html_e('Ship to:', 'kash-naturals'); ?></span>
                                            <span id="kash-step-3-summary-address" style="color: #222; line-height: 1.5;"></span>
                                            <span style="color: #777; font-weight: 500;"><?php esc_html_e('Method:', 'kash-naturals'); ?></span>
                                            <span style="color: #27ae60; font-weight: 600;"><?php esc_html_e('Pan-India Priority Express • FREE', 'kash-naturals'); ?></span>
                                        </div>
                                    </div>

                                    <!-- Step 3: Payment Options & Standard Order Review Container -->
                                    <div id="order_review" class="woocommerce-checkout-review-order">
                                        <?php do_action('woocommerce_checkout_before_order_review'); ?>

                                        <div class="wc-block-components-checkout-step wc-block-components-checkout-step--payment-method">
                                            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 18px;">
                                                <h2 class="wc-block-components-checkout-step__heading" style="margin: 0;"><?php esc_html_e('Payment options', 'kash-naturals'); ?></h2>
                                                <span style="font-size: 0.8rem; font-weight: 600; color: #27ae60; background: #e8f5e9; padding: 4px 10px; border-radius: 20px;"><i class="fa-solid fa-shield-halved" style="margin-right: 4px;"></i><?php esc_html_e('256-Bit SSL Secure', 'kash-naturals'); ?></span>
                                            </div>
                                            <div class="wc-block-components-checkout-step__container">
                                                <?php
                                                if (function_exists('woocommerce_checkout_payment')) {
                                                    woocommerce_checkout_payment();
                                                } else {
                                                    $theme_payment_file = defined('KASH_THEME_DIR') ? KASH_THEME_DIR . '/woocommerce/checkout/payment.php' : __DIR__ . '/woocommerce/checkout/payment.php';
                                                    if (file_exists($theme_payment_file)) {
                                                        include $theme_payment_file;
                                                    }
                                                }
                                                ?>
                                            </div>
                                        </div>

                                        <?php do_action('woocommerce_checkout_after_order_review'); ?>
                                    </div>

                                    <!-- Bottom Back Link to Shipping Details -->
                                    <div style="text-align: center; margin-top: 14px;">
                                        <button type="button" class="btn-return-to-shipping" id="btn-return-to-shipping" style="background: none; border: none; color: #0f3820; font-family: 'Outfit', sans-serif; font-size: 0.95rem; font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; text-decoration: underline; padding: 8px 12px;">
                                            <i class="fa-solid fa-arrow-left"></i> <?php esc_html_e('Return to Shipping Details', 'kash-naturals'); ?>
                                        </button>
                                    </div>

                                </div><!-- /#kash-checkout-tab-step-3 -->

                            </div>
                        </div>
                    </div>

                    <?php if ($checkout) { do_action('woocommerce_after_checkout_form', $checkout); } ?>

                </form>
            </div>

            <!-- Bottom Security & Quality Seal -->
            <div class="checkout-security-footer text-center">
                <div class="security-seal-pills">
                    <span><i class="fa-solid fa-shield-heart"></i> <?php esc_html_e('Kash Naturals Authentic Quality Guaranteed', 'kash-naturals'); ?></span>
                    <span><i class="fa-solid fa-headset"></i> <?php esc_html_e('Dedicated Customer Support: +91 98765 43210', 'kash-naturals'); ?></span>
                    <span><i class="fa-solid fa-rotate-left"></i> <?php esc_html_e('Hassle-Free Return Policy', 'kash-naturals'); ?></span>
                </div>
            </div>

        <?php endif; ?>

    </div>
</section>

<?php
get_footer();
