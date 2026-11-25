<?php
/**
 * Output a single payment method for Kash Naturals
 *
 * @package KashNaturals
 */

if (!defined('ABSPATH')) {
    exit;
}

$is_checked = $gateway->chosen;
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
    <div class="wc-block-components-radio-control__option <?php echo $is_checked ? 'wc-block-components-radio-control__option--checked' : ''; ?>" style="display: flex; align-items: flex-start; gap: 14px; cursor: pointer; padding: 16px 20px; border: 1.5px solid <?php echo $is_checked ? '#c68b27' : '#ede5d8'; ?>; border-radius: 14px; background: <?php echo $is_checked ? '#ffffff' : '#faf8f5'; ?>; transition: all 0.25s ease;">
        <input id="payment_method_<?php echo esc_attr($gateway->id); ?>" type="radio" class="input-radio wc-block-components-radio-control__input" name="payment_method" value="<?php echo esc_attr($gateway->id); ?>" <?php checked($is_checked, true); ?> data-order_button_text="<?php echo esc_attr($gateway->order_button_text); ?>" style="margin-top: 4px; accent-color: #0f3820;">
        <div class="wc-block-components-radio-control__option-layout" style="flex: 1;">
            <label for="payment_method_<?php echo esc_attr($gateway->id); ?>" class="wc-block-components-radio-control__label" style="display: flex; align-items: center; justify-content: space-between; cursor: pointer; margin: 0; font-family: 'Outfit', sans-serif; font-weight: 700; font-size: 0.96rem; color: #0f3820;">
                <span><?php echo $icon_html; ?><?php echo esc_html($gateway->get_title()); ?></span>
                <?php if ($gateway->id === 'cod') : ?>
                    <span style="font-size: 0.72rem; padding: 2px 8px; background: #e8f5e9; color: #2e7d32; border-radius: 4px; font-weight: 600;">CASH ON DELIVERY</span>
                <?php elseif ($gateway->id === 'razorpay' || in_array($gateway->id, array('phonepe', 'paytm', 'cashfree', 'upi'))) : ?>
                    <span style="font-size: 0.72rem; padding: 2px 8px; background: #fff8e1; color: #b78103; border-radius: 4px; font-weight: 600;">INSTANT UPI, CARDS &amp; NETBANKING</span>
                <?php endif; ?>
            </label>
            <?php
            $fields_output = '';
            if ($gateway->has_fields() || $gateway->get_description()) {
                ob_start();
                $gateway->payment_fields();
                $fields_output = ob_get_clean();
            }
            ?>
            <?php if (!empty($fields_output)) : ?>
                <div class="payment_box payment_method_<?php echo esc_attr($gateway->id); ?>" style="<?php echo $is_checked ? 'display: block;' : 'display: none;'; ?> margin-top: 10px; padding: 12px 14px; background: #f4f8f5; border: 1px solid #d2e4d8; border-radius: 8px; font-size: 0.88rem; color: #444; line-height: 1.5;">
                    <?php echo $fields_output; ?>
                    <?php if ($gateway->id === 'razorpay' && strpos($fields_output, 'razorpay_payment_id') === false) : ?>
                        <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id" value="">
                        <input type="hidden" name="razorpay_order_id" id="razorpay_order_id" value="">
                        <input type="hidden" name="razorpay_signature" id="razorpay_signature" value="">
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</li>
