/**
 * WooCommerce Specific Interactive Script for Kash Naturals
 * Handles AJAX cart synchronization, dynamic checkout payment switching,
 * interactive checkout step progression, and coupon application.
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

    /* ==========================================================================
       CHECKOUT STEPPER & PROCEED-TO-PAYMENT INTERACTIVITY
       ========================================================================== */

    function activatePaymentStep() {
        $('#step-badge-2').removeClass('active').addClass('done');
        $('#step-num-2').html('<i class="fa-solid fa-check"></i>');
        $('#stepper-line-2').addClass('active');
        $('#step-badge-3').addClass('active');

        var $paymentStep = $('.wc-block-components-checkout-step--payment-method');
        if ($paymentStep.length) {
            $('html, body').animate({ scrollTop: $paymentStep.offset().top - 90 }, 550);
            $paymentStep.css('transition', 'box-shadow 0.4s ease, border-color 0.4s ease');
            $paymentStep.css('box-shadow', '0 0 0 3px #c68b27, 0 10px 30px rgba(198, 139, 39, 0.18)');
            setTimeout(function () {
                $paymentStep.css('box-shadow', '');
            }, 1800);
        }
    }

    function activateShippingStep() {
        $('#step-badge-2').addClass('active').removeClass('done');
        $('#step-num-2').text('2');
        $('#stepper-line-2').removeClass('active');
        $('#step-badge-3').removeClass('active');
    }

    // "Proceed to Payment Options" Button Click Handler
    $(document).on('click', '#btn-proceed-to-payment', function (e) {
        e.preventDefault();

        var requiredSelectors = [
            '#billing_email',
            '#billing_phone',
            '#billing_first_name',
            '#billing_last_name',
            '#billing_address_1',
            '#billing_city',
            '#billing_postcode'
        ];

        var firstInvalid = null;

        requiredSelectors.forEach(function (sel) {
            var $el = $(sel);
            if ($el.length && !$.trim($el.val())) {
                if (!firstInvalid) firstInvalid = $el;
                $el.css({
                    'border-color': '#d9534f',
                    'background': '#fff8f8'
                });
            } else if ($el.length) {
                $el.css({
                    'border-color': '',
                    'background': ''
                });
            }
        });

        if (firstInvalid) {
            $('html, body').animate({ scrollTop: firstInvalid.offset().top - 120 }, 400);
            firstInvalid.focus();
            return;
        }

        activatePaymentStep();
    });

    // Clear red warning highlight when user types into required fields
    $(document).on('input change', '#billing_email, #billing_phone, #billing_first_name, #billing_last_name, #billing_address_1, #billing_city, #billing_postcode', function () {
        if ($.trim($(this).val())) {
            $(this).css({
                'border-color': '',
                'background': ''
            });
        }
    });

    // Stepper header badge click handlers
    $(document).on('click', '#step-badge-2', function (e) {
        e.preventDefault();
        var $addr = $('.wc-block-components-checkout-step--billing-address');
        if ($addr.length) {
            $('html, body').animate({ scrollTop: $addr.offset().top - 80 }, 450);
            activateShippingStep();
        }
    });

    $(document).on('click', '#step-badge-3', function (e) {
        e.preventDefault();
        $('#btn-proceed-to-payment').trigger('click');
    });

    // Scroll-Spy Stepper Synchronization
    var isScrollingThrottled = false;
    $(window).on('scroll', function () {
        if (isScrollingThrottled) return;
        isScrollingThrottled = true;
        setTimeout(function () {
            isScrollingThrottled = false;
        }, 100);

        var $paymentStep = $('.wc-block-components-checkout-step--payment-method');
        if (!$paymentStep.length) return;

        var paymentTop = $paymentStep.offset().top - 160;
        var scrollPos = $(window).scrollTop();

        if (scrollPos >= paymentTop) {
            $('#step-badge-2').removeClass('active').addClass('done');
            $('#step-num-2').html('<i class="fa-solid fa-check"></i>');
            $('#stepper-line-2').addClass('active');
            $('#step-badge-3').addClass('active');
        } else {
            $('#step-badge-2').addClass('active').removeClass('done');
            $('#step-num-2').text('2');
            $('#stepper-line-2').removeClass('active');
            $('#step-badge-3').removeClass('active');
        }
    });

    /* ==========================================================================
       CHECKOUT COUPON CODE HANDLER
       ========================================================================== */
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
                window.location.reload();
            }
        });
    });

    // Enter key triggers coupon apply
    $(document).on('keypress', '#kash-checkout-coupon-code', function (e) {
        if (e.which === 13) {
            e.preventDefault();
            $('#kash-checkout-apply-coupon').trigger('click');
        }
    });
});
