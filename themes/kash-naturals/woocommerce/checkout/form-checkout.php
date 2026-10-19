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
    <form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url(wc_get_checkout_url()); ?>" enctype="multipart/form-data">

        <?php if ($checkout->get_checkout_fields()) : ?>

            <?php do_action('woocommerce_checkout_before_customer_details'); ?>

            <div class="col2-set checkout-grid" id="customer_details">
                <div class="col-1 billing-shipping-column">
                    <div class="checkout-box-card">
                        <div class="checkout-card-header">
                            <span class="step-badge">1</span>
                            <h3><?php esc_html_e('Contact & Delivery Details', 'kash-naturals'); ?></h3>
                        </div>
                        <?php do_action('woocommerce_checkout_billing'); ?>
                        <?php do_action('woocommerce_checkout_shipping'); ?>
                    </div>
                </div>

                <div class="col-2 order-summary-column">
                    <div class="checkout-box-card summary-card sticky-summary">
                        <div class="checkout-card-header">
                            <span class="step-badge">2</span>
                            <h3 id="order_review_heading"><?php esc_html_e('Your Order Summary', 'kash-naturals'); ?></h3>
                        </div>

                        <?php do_action('woocommerce_checkout_before_order_review'); ?>

                        <div id="order_review" class="woocommerce-checkout-review-order">
                            <?php do_action('woocommerce_checkout_order_review'); ?>
                        </div>

                        <?php do_action('woocommerce_checkout_after_order_review'); ?>

                        <!-- Trust seals inside summary card -->
                        <div class="summary-trust-seals">
                            <div class="seal-item"><i class="fa-solid fa-lock"></i> <span>256-Bit SSL Encrypted Checkout</span></div>
                            <div class="seal-item"><i class="fa-solid fa-shield-halved"></i> <span>Kash Naturals Purity Guarantee</span></div>
                        </div>
                    </div>
                </div>
            </div>

            <?php do_action('woocommerce_checkout_after_customer_details'); ?>

        <?php endif; ?>

    </form>
</div>

<?php do_action('woocommerce_after_checkout_form', $checkout); ?>
