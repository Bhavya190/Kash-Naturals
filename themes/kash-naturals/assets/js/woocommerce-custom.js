/**
 * WooCommerce Specific Interactive Script for Kash Naturals
 * Handles AJAX cart synchronization, dynamic checkout payment switching, and coupon application
 *
 * @package KashNaturals
 */
jQuery(document).ready(function ($) {
    'use strict';

    // Auto-update cart badge & drawer on WooCommerce AJAX add-to-cart
    $(document.body).on('added_to_cart', function (event, fragments, cart_hash, $button) {
        if ($button && $button.length) {
            $button.addClass('added-success');
            setTimeout(function () {
                $button.removeClass('added-success');
            }, 2000);
        }
        if (typeof window.syncWithWooCommerceCart === 'function') {
            window.syncWithWooCommerceCart();
        }
    });

    $(document.body).on('wc_fragments_refreshed wc_fragments_loaded', function () {
        if (typeof window.syncWithWooCommerceCart === 'function') {
            window.syncWithWooCommerceCart();
        }
    });

    // Taste Now Quick Add Animation
    $('.product-card-item .add_to_cart_button').on('click', function () {
        const $badge = $('#mini-cart-count');
        $badge.addClass('bump-anim');
        setTimeout(() => $badge.removeClass('bump-anim'), 400);
    });

    // Checkout payment method dynamic switcher & visual active toggle
    function syncCheckoutPaymentState() {
        var $checked = $('input[name="payment_method"]:checked');
        if (!$checked.length) return;

        var gatewayId = $checked.val();

        // Reset visual cards
        $('.wc_payment_method .wc-block-components-radio-control__option')
            .removeClass('wc-block-components-radio-control__option--checked')
            .css({
                'border-color': '#ede5d8',
                'background': '#faf8f5'
            });

        // Highlight selected card
        $checked.closest('.wc-block-components-radio-control__option')
            .addClass('wc-block-components-radio-control__option--checked')
            .css({
                'border-color': '#c68b27',
                'background': '#ffffff'
            });

        // Toggle payment boxes
        $('.wc_payment_method .payment_box').hide();
        $('.payment_method_' + gatewayId + ' .payment_box').slideDown(200);
    }

    $(document.body).on('change', 'input[name="payment_method"]', function () {
        syncCheckoutPaymentState();
        $(document.body).trigger('payment_method_selected');
    });

    // Initialize on page load and after checkout fragments update
    $(document.body).on('updated_checkout init_checkout', function () {
        syncCheckoutPaymentState();
    });

    // Run initial payment state sync
    syncCheckoutPaymentState();

    // Checkout Coupon Code Application Handler
    $(document).on('click', '#kash-checkout-apply-coupon', function (e) {
        e.preventDefault();
        var $btn = $(this);
        var $input = $('#kash-checkout-coupon-code');
        var couponCode = $.trim($input.val());

        if (!couponCode) {
            alert('Please enter a coupon code.');
            return;
        }

        $btn.prop('disabled', true).text('Applying...');

        var ajaxUrl = (typeof kash_wc_params !== 'undefined' && kash_wc_params.ajax_url) 
            ? kash_wc_params.ajax_url 
            : ((typeof kash_dynamic_data !== 'undefined' && kash_dynamic_data.ajax_url) ? kash_dynamic_data.ajax_url : '/admin-ajax.php');

        $.ajax({
            type: 'POST',
            url: ajaxUrl,
            data: {
                action: 'kash_apply_coupon',
                coupon_code: couponCode,
                security: (typeof kash_dynamic_data !== 'undefined' && kash_dynamic_data.cart_nonce) ? kash_dynamic_data.cart_nonce : ''
            },
            success: function (res) {
                $btn.prop('disabled', false).text('Apply');
                if (res.success) {
                    if (typeof $(document.body).trigger === 'function') {
                        $(document.body).trigger('update_checkout');
                    }
                    window.location.reload();
                } else {
                    var msg = (res.data && res.data.message) ? res.data.message : 'Invalid or expired coupon code.';
                    alert(msg);
                }
            },
            error: function () {
                $btn.prop('disabled', false).text('Apply');
                // Fallback reload checkout
                window.location.reload();
            }
        });
    });

    // Allow Enter key to apply coupon
    $(document).on('keypress', '#kash-checkout-coupon-code', function (e) {
        if (e.which === 13) {
            e.preventDefault();
            $('#kash-checkout-apply-coupon').trigger('click');
        }
    });
});
