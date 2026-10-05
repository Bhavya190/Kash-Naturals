<?php
/**
 * Checkout Form Template Override for Kash Naturals
 *
 * @package KashNaturals
 */

if (!defined('ABSPATH')) {
    exit;
}

do_action('woocommerce_before_checkout_form', $checkout);

// If checkout registration is disabled and not logged in, the user cannot checkout.
if (!$checkout->is_registration_enabled() && $checkout->is_registration_required() && !is_user_logged_in()) {
    echo esc_html(apply_filters('woocommerce_checkout_must_be_logged_in_message', __('You must be logged in to checkout.', 'woocommerce')));
    return;
}
?>

<div class="kash-checkout-page-wrapper">
    <div class="checkout-header text-center">
        <h1 class="page-title"><i class="fa-solid fa-lock"></i> Secure Checkout</h1>
        <p class="checkout-subtitle">All orders are shipped in cold-insulated eco-friendly packaging.</p>
        <div class="gold-divider"></div>
    </div>

    <form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url(wc_get_checkout_url()); ?>" enctype="multipart/form-data">

        <?php if ($checkout->get_checkout_fields()) : ?>

            <?php do_action('woocommerce_checkout_before_customer_details'); ?>

            <div class="col2-set checkout-grid" id="customer_details">
                <div class="col-1 billing-shipping-column">
                    <div class="checkout-box-card">
                        <?php do_action('woocommerce_checkout_billing'); ?>
                        <?php do_action('woocommerce_checkout_shipping'); ?>
                    </div>
                </div>

                <div class="col-2 order-summary-column">
                    <div class="checkout-box-card summary-card">
                        <h3 id="order_review_heading"><i class="fa-solid fa-receipt"></i> <?php esc_html_e('Your Order Summary', 'woocommerce'); ?></h3>

                        <?php do_action('woocommerce_checkout_before_order_review'); ?>

                        <div id="order_review" class="woocommerce-checkout-review-order">
                            <?php do_action('woocommerce_checkout_order_review'); ?>
                        </div>

                        <?php do_action('woocommerce_checkout_after_order_review'); ?>
                    </div>
                </div>
            </div>

            <?php do_action('woocommerce_checkout_after_customer_details'); ?>

        <?php endif; ?>

    </form>
</div>

<?php do_action('woocommerce_after_checkout_form', $checkout); ?>
