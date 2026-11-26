<?php
/**
 * Checkout Payment Section Template Override for Kash Naturals
 *
 * @package KashNaturals
 */

if (!defined('ABSPATH')) {
    exit;
}

if (!wp_doing_ajax()) {
    do_action('woocommerce_review_order_before_payment');
}
?>

<div id="payment" class="woocommerce-checkout-payment wc-block-components-radio-control payment-methods-list">
    <?php if (WC()->cart && WC()->cart->needs_payment()) : ?>
        <ul class="wc_payment_methods payment_methods methods" style="list-style: none; margin: 0; padding: 0;">
            <?php
            if (!empty($available_gateways)) {
                foreach ($available_gateways as $gateway) {
                    wc_get_template('checkout/payment-method.php', array('gateway' => $gateway));
                }
            } else {
                echo '<li class="woocommerce-notice woocommerce-notice--info woocommerce-info">' . apply_filters('woocommerce_no_available_payment_methods_message', WC()->customer->get_billing_country() ? esc_html__('Sorry, it seems that there are no available payment methods for your region.', 'kash-naturals') : esc_html__('Please fill in your details above to see available payment methods.', 'kash-naturals')) . '</li>';
            }
            ?>
        </ul>
    <?php endif; ?>

    <div class="form-row place-order">
        <noscript>
            <?php
            printf(esc_html__('Since your browser does not support JavaScript, please click the %1$sUpdate Totals%2$s button before placing your order.', 'kash-naturals'), '<a href="' . esc_url(wc_get_checkout_url()) . '">', '</a>');
            ?>
            <br/><button type="submit" class="button alt" name="woocommerce_checkout_update_totals" value="<?php esc_attr_e('Update totals', 'kash-naturals'); ?>"><?php esc_html_e('Update totals', 'kash-naturals'); ?></button>
        </noscript>

        <!-- Order Notes Toggle & Textarea -->
        <div class="checkout-order-notes-wrap" style="margin-top: 18px; padding: 14px 18px; background: #faf8f5; border: 1.5px solid #ede5d8; border-radius: 12px;">
            <label style="display: flex; align-items: center; gap: 10px; font-size: 0.9rem; font-weight: 600; color: #333; cursor: pointer; margin: 0;">
                <input type="checkbox" id="order_notes_toggle" name="order_notes_toggle" style="accent-color: #0f3820; width: 17px; height: 17px;" onchange="var el = document.getElementById('order_comments_container'); if(el) el.style.display = this.checked ? 'block' : 'none';">
                <span><?php esc_html_e('Add a note to your order (gift message, landmark, or special delivery instructions)', 'kash-naturals'); ?></span>
            </label>
            <div id="order_comments_container" style="display: none; margin-top: 12px;">
                <textarea id="order_comments" name="order_comments" class="input-text" rows="3" placeholder="<?php esc_attr_e('Notes about your order, e.g. special notes for delivery or gift message.', 'kash-naturals'); ?>" style="width: 100%; border: 1.5px solid #d4c8b8; border-radius: 8px; padding: 10px 14px; font-family: inherit; font-size: 0.9rem; background: #fff; box-sizing: border-box;"></textarea>
            </div>
        </div>

        <!-- Terms and Conditions Agreement -->
        <div class="wc-block-checkout__terms" style="margin-top: 16px; font-size: 0.85rem; color: #666; line-height: 1.5;">
            <?php esc_html_e('By proceeding with your purchase you agree to our', 'kash-naturals'); ?> <a href="<?php echo esc_url(home_url('/terms-and-conditions')); ?>" target="_blank" style="color: #0f3820; font-weight: 600; text-decoration: underline;"><?php esc_html_e('Terms and Conditions', 'kash-naturals'); ?></a> <?php esc_html_e('and', 'kash-naturals'); ?> <a href="<?php echo esc_url(home_url('/privacy-policy')); ?>" target="_blank" style="color: #0f3820; font-weight: 600; text-decoration: underline;"><?php esc_html_e('Privacy Policy', 'kash-naturals'); ?></a>.
        </div>

        <?php do_action('woocommerce_review_order_before_submit'); ?>

        <!-- Single Place Order Action Button -->
        <div class="wc-block-checkout__actions" style="margin-top: 20px;">
            <?php
            $order_btn_text = apply_filters('woocommerce_order_button_text', sprintf(__('Place Order • %s', 'kash-naturals'), strip_tags(WC()->cart ? WC()->cart->get_total() : '')));
            $order_btn_html = '<button type="submit" class="button alt wc-block-components-checkout-place-order-button" name="woocommerce_checkout_place_order" id="place_order" value="' . esc_attr($order_btn_text) . '" data-value="' . esc_attr($order_btn_text) . '"><i class="fa-solid fa-lock" style="margin-right: 8px;"></i> ' . esc_html($order_btn_text) . '</button>';
            echo apply_filters('woocommerce_order_button_html', $order_btn_html);
            ?>
        </div>

        <?php do_action('woocommerce_review_order_after_submit'); ?>

        <?php wp_nonce_field('woocommerce-process_checkout', 'woocommerce-process-checkout-nonce'); ?>
    </div>
</div>

<?php
if (!wp_doing_ajax()) {
    do_action('woocommerce_review_order_after_payment');
}
