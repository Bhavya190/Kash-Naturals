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

        // Update single place order button label dynamically based on selected payment gateway
        var $btn = $('#place_order');
        if ($btn.length && !$btn.prop('disabled')) {
            var totalDisplay = $('.wc-block-components-totals-item__value, .order-total .amount, .wc-block-components-order-summary__total-value').first().text();
            totalDisplay = $.trim(totalDisplay);

            if (gatewayId === 'cod') {
                $btn.html('<i class="fa-solid fa-hand-holding-dollar" style="margin-right: 8px;"></i> Place Order (Cash on Delivery)' + (totalDisplay ? ' • ' + totalDisplay : ''));
            } else {
                $btn.html('<i class="fa-solid fa-lock" style="margin-right: 8px; color: #c68b27;"></i> Pay with Razorpay' + (totalDisplay ? ' • ' + totalDisplay : ''));
            }
        }
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
       CHECKOUT STEPPER & MULTI-STEP FLOW (Step 2 -> Step 3)
       ========================================================================== */

    function activatePaymentStep() {
        // Update Stepper Top Badges
        $('#step-badge-2').removeClass('active').addClass('done');
        $('#step-num-2').html('<i class="fa-solid fa-check"></i>');
        $('#stepper-line-2').addClass('active');
        $('#step-badge-3').addClass('active');

        // Smooth scroll to Step 3 Payment Options
        var $target = $('#order_review');
        if ($target.length) {
            $('html, body').stop().animate({ scrollTop: $target.offset().top - 90 }, 450);
            $target.addClass('kash-step-active-glow');
            setTimeout(function () {
                $target.removeClass('kash-step-active-glow');
            }, 1800);
        }

        // Focus selected payment radio
        var $checkedGateway = $('input[name="payment_method"]:checked');
        if ($checkedGateway.length) {
            $checkedGateway.focus();
        }
    }

    function activateShippingStep() {
        // Update Stepper Top Badges
        $('#step-badge-2').addClass('active').removeClass('done');
        $('#step-num-2').text('2');
        $('#stepper-line-2').removeClass('active');
        $('#step-badge-3').removeClass('active');

        // Smooth scroll to Billing Details
        var $target = $('#billing_first_name');
        if ($target.length) {
            $('html, body').stop().animate({ scrollTop: $target.offset().top - 140 }, 350);
            $target.focus();
        }
    }

    // "Proceed to Payment Options" Button Click Handler
    $(document).on('click', '#btn-proceed-to-payment', function (e) {
        e.preventDefault();
        e.stopPropagation();

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
            $('html, body').stop().animate({ scrollTop: firstInvalid.offset().top - 120 }, 350);
            firstInvalid.focus();
            showRazorpayNotice('Please complete all required shipping details before proceeding to payment options.', true);
            return false;
        }

        activatePaymentStep();
        return false;
    });

    // Step 2 Badge Click Handler
    $(document).on('click', '#step-badge-2', function (e) {
        e.preventDefault();
        activateShippingStep();
    });

    // Step 3 Header Badge Click Handler
    $(document).on('click', '#step-badge-3', function (e) {
        e.preventDefault();
        $('#btn-proceed-to-payment').trigger('click');
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

    /* ==========================================================================
       RAZORPAY STANDARD WEB CHECKOUT INTEGRATION
       ========================================================================== */

    function getRazorpayKeyId() {
        if (typeof window.RAZORPAY_KEY_ID !== 'undefined' && window.RAZORPAY_KEY_ID) {
            return window.RAZORPAY_KEY_ID;
        }
        if (typeof window.kash_dynamic_data !== 'undefined' && window.kash_dynamic_data.razorpay_key_id) {
            return window.kash_dynamic_data.razorpay_key_id;
        }
        if (typeof window.kash_wc_params !== 'undefined' && window.kash_wc_params.razorpay_key_id) {
            return window.kash_wc_params.razorpay_key_id;
        }
        return 'rzp_test_U4hJ4Xslre9Mh5';
    }

    function ensureRazorpayScript(callback) {
        if (typeof window.Razorpay === 'function') {
            if (callback) callback();
            return;
        }
        var script = document.createElement('script');
        script.src = 'https://checkout.razorpay.com/v1/checkout.js';
        script.async = true;
        script.onload = function () {
            if (callback) callback();
        };
        script.onerror = function () {
            console.error('[Razorpay] Failed to load Checkout SDK script.');
            showRazorpayNotice('Unable to load Razorpay payment gateway SDK. Please check your internet connection.', true);
        };
        document.head.appendChild(script);
    }

    function showRazorpayNotice(message, isError) {
        $('.kash-razorpay-notice').remove();
        var bg = isError ? '#fff5f5' : '#f0fdf4';
        var border = isError ? '#feb2b2' : '#86efac';
        var borderLeft = isError ? '#e53e3e' : '#22c55e';
        var color = isError ? '#9b2c2c' : '#15803d';
        var icon = isError ? 'fa-triangle-exclamation' : 'fa-circle-check';

        var $notice = $(
            '<div class="kash-razorpay-notice" style="background: ' + bg + '; border: 1.5px solid ' + border + '; border-left: 5px solid ' + borderLeft + '; border-radius: 10px; padding: 14px 18px; margin-bottom: 20px; color: ' + color + '; font-family: \'Outfit\', sans-serif; font-size: 0.95rem; line-height: 1.5; box-shadow: 0 4px 12px rgba(0,0,0,0.05);">' +
            '<i class="fa-solid ' + icon + '" style="margin-right: 10px;"></i>' +
            '<span>' + message + '</span>' +
            '</div>'
        );

        var $target = $('.woocommerce-notices-wrapper:visible, .woocommerce-NoticeGroup:visible, #order_review, form.checkout');
        if ($target.length) {
            $target.first().prepend($notice);
            $('html, body').animate({ scrollTop: $notice.offset().top - 100 }, 300);
        } else {
            alert(message);
        }
    }

    function getCheckoutAmountPaise() {
        var rawText = '';
        var $btn = $('#place_order');
        if ($btn.length) {
            rawText = $btn.text() || $btn.val() || '';
        }
        if (!rawText) {
            var $totalEl = $('.wc-block-components-totals-item__value, .order-total .amount, .wc-block-components-order-summary__total-value');
            if ($totalEl.length) rawText = $totalEl.text();
        }
        var cleanAmount = rawText.replace(/[^0-9.]/g, '');
        var floatVal = parseFloat(cleanAmount);
        if (!isNaN(floatVal) && floatVal > 0) {
            return Math.max(100, Math.round(floatVal * 100));
        }
        return 17900; // Standard fallback (179 INR = 17900 paise, min 100)
    }

    function ensureHiddenInputs(resp) {
        var $form = $('form.checkout');
        if (!$form.length) $form = $('body');

        if (!$('#razorpay_payment_id').length) {
            $form.append('<input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id" value="">');
        }
        if (!$('#razorpay_order_id').length) {
            $form.append('<input type="hidden" name="razorpay_order_id" id="razorpay_order_id" value="">');
        }
        if (!$('#razorpay_signature').length) {
            $form.append('<input type="hidden" name="razorpay_signature" id="razorpay_signature" value="">');
        }

        $('#razorpay_payment_id').val(resp.razorpay_payment_id || '');
        $('#razorpay_order_id').val(resp.razorpay_order_id || '');
        $('#razorpay_signature').val(resp.razorpay_signature || '');
    }

    /**
     * Core Razorpay Standard Checkout Handler
     * 1. Calls /api/create-order
     * 2. Opens Razorpay popup checkout modal
     * 3. Sends received payment details to /api/verify-payment
     */
    window.kashPayWithRazorpay = function (customOpts, onSuccess, onError) {
        customOpts = customOpts || {};
        var keyId = getRazorpayKeyId();
        var amountPaise = customOpts.amount || getCheckoutAmountPaise();

        var billingFirst = customOpts.firstName || $('#billing_first_name').val() || '';
        var billingLast  = customOpts.lastName || $('#billing_last_name').val() || '';
        var billingEmail = customOpts.email || $('#billing_email').val() || 'customer@kashnatural.com';
        var billingPhone = customOpts.phone || $('#billing_phone').val() || '9876543210';
        var customerName = (billingFirst + ' ' + billingLast).trim() || 'Valued Customer';

        var orderPayload = {
            amount: amountPaise,
            currency: customOpts.currency || 'INR',
            receipt: customOpts.receipt || ('rcpt_' + Date.now())
        };

        ensureRazorpayScript(function () {
            // STEP 1: Call Backend to Create Order (with fallback to WP AJAX)
            var ajaxUrl = (typeof window.kash_dynamic_data !== 'undefined' && window.kash_dynamic_data.ajax_url)
                ? window.kash_dynamic_data.ajax_url
                : ((typeof window.kash_wc_params !== 'undefined') ? window.kash_wc_params.ajax_url : '/wp-admin/admin-ajax.php');

            function executeOrderCreation(callbackSuccess, callbackError) {
                // Try WordPress AJAX endpoint first (guaranteed on all WP hosts)
                $.ajax({
                    type: 'POST',
                    url: ajaxUrl,
                    data: {
                        action: 'kash_create_razorpay_order',
                        amount: orderPayload.amount,
                        currency: orderPayload.currency || 'INR',
                        receipt: orderPayload.receipt
                    },
                    dataType: 'json',
                    success: function (res) {
                        if (res && res.success && res.data && res.data.order_id) {
                            callbackSuccess(res.data);
                        } else {
                            var errMsg = (res && res.data && res.data.error) ? res.data.error : 'Order creation failed.';
                            tryApiFallback(errMsg);
                        }
                    },
                    error: function (xhr) {
                        var errJson = {};
                        try { errJson = JSON.parse(xhr.responseText); } catch (e) {}
                        var errMsg = (errJson && errJson.data && errJson.data.error) ? errJson.data.error : (errJson.error || '');
                        tryApiFallback(errMsg);
                    }
                });

                function tryApiFallback(primaryError) {
                    $.ajax({
                        type: 'POST',
                        url: '/api/create-order',
                        contentType: 'application/json',
                        data: JSON.stringify(orderPayload),
                        success: function (orderData) {
                            if (orderData && orderData.order_id) {
                                callbackSuccess(orderData);
                            } else {
                                callbackError(primaryError || 'Failed to initialize payment order with Razorpay.');
                            }
                        },
                        error: function () {
                            callbackError(primaryError || 'Failed to initialize payment order with Razorpay.');
                        }
                    });
                }
            }

            executeOrderCreation(function (orderData) {
                // STEP 2: Configure & Open Razorpay Modal
                var logoUrl = (typeof window.kash_dynamic_data !== 'undefined' && window.kash_dynamic_data.theme_uri)
                    ? window.kash_dynamic_data.theme_uri + '/assets/images/Kash Natural Leaf Logo.png'
                    : '/wp-content/themes/kash-naturals/assets/images/Kash Natural Leaf Logo.png';

                var options = {
                    key: keyId,
                    amount: orderData.amount,
                    currency: orderData.currency || 'INR',
                    name: 'Kash Naturals',
                    description: 'Authentic Royal Mukhwas & Digestives',
                    image: logoUrl,
                    order_id: orderData.order_id,
                    prefill: {
                        name: customerName,
                        email: billingEmail,
                        contact: billingPhone
                    },
                    notes: {
                        store: 'Kash Naturals Online Store',
                        receipt: orderPayload.receipt
                    },
                    theme: {
                        color: '#0f3820' // Kash Royal Emerald Green
                    },
                    modal: {
                        ondismiss: function () {
                            console.log('[Razorpay] Payment modal dismissed by user.');
                            if (typeof onError === 'function') {
                                onError({ cancelled: true, message: 'Payment cancelled by user.' });
                            }
                        }
                    },
                    handler: function (response) {
                        // Received razorpay_payment_id, razorpay_order_id, razorpay_signature
                        // STEP 3: Verify Payment Signature with Backend (with fallback)
                        function executeVerification(onVerSuccess, onVerError) {
                            // Try WordPress AJAX verification first
                            $.ajax({
                                type: 'POST',
                                url: ajaxUrl,
                                data: {
                                    action: 'kash_verify_razorpay_payment',
                                    razorpay_order_id: response.razorpay_order_id,
                                    razorpay_payment_id: response.razorpay_payment_id,
                                    razorpay_signature: response.razorpay_signature
                                },
                                dataType: 'json',
                                success: function (res) {
                                    if (res && res.success) {
                                        onVerSuccess(res.data);
                                    } else {
                                        var failMsg = (res && res.data && res.data.error) ? res.data.error : 'Payment signature verification failed.';
                                        tryApiVerify(failMsg);
                                    }
                                },
                                error: function (xhr) {
                                    var errJson = {};
                                    try { errJson = JSON.parse(xhr.responseText); } catch (e) {}
                                    var failMsg = (errJson && errJson.data && errJson.data.error) ? errJson.data.error : (errJson.error || '');
                                    tryApiVerify(failMsg);
                                }
                            });

                            function tryApiVerify(primaryFailMsg) {
                                $.ajax({
                                    type: 'POST',
                                    url: '/api/verify-payment',
                                    contentType: 'application/json',
                                    data: JSON.stringify({
                                        razorpay_order_id: response.razorpay_order_id,
                                        razorpay_payment_id: response.razorpay_payment_id,
                                        razorpay_signature: response.razorpay_signature
                                    }),
                                    success: function (verifyRes) {
                                        if (verifyRes && verifyRes.success) {
                                            onVerSuccess(verifyRes);
                                        } else {
                                            onVerError(primaryFailMsg || 'Payment signature verification failed.');
                                        }
                                    },
                                    error: function () {
                                        onVerError(primaryFailMsg || 'Payment signature verification failed. Please contact support.');
                                    }
                                });
                            }
                        }

                        executeVerification(
                            function (verifyRes) {
                                ensureHiddenInputs(response);
                                if (typeof onSuccess === 'function') {
                                    onSuccess(response, verifyRes);
                                }
                            },
                            function (failMsg) {
                                if (typeof onError === 'function') {
                                    onError({ error: failMsg });
                                }
                            }
                        );
                    }
                };

                var rzp = new window.Razorpay(options);

                // Handle payment.failed event
                rzp.on('payment.failed', function (failureResponse) {
                    console.error('[Razorpay] Payment Failed:', failureResponse.error);
                    var errMsg = (failureResponse.error && failureResponse.error.description)
                        ? failureResponse.error.description
                        : 'Payment transaction failed or declined by your bank.';
                    if (typeof onError === 'function') {
                        onError({ error: errMsg, details: failureResponse.error });
                    }
                });

                rzp.open();
            }, function (errMsg) {
                if (typeof onError === 'function') {
                    onError(errMsg);
                }
            });
        });
    };

    /* --------------------------------------------------------------------------
       CHECKOUT FORM SUBMISSION INTERCEPTOR FOR RAZORPAY
       -------------------------------------------------------------------------- */
    var originalButtonHtml = '';

    function resetPlaceOrderBtn() {
        var $btn = $('#place_order');
        if ($btn.length && originalButtonHtml) {
            $btn.prop('disabled', false).html(originalButtonHtml);
        }
    }

    $(document).on('click', '#place_order', function (e) {
        var $checked = $('input[name="payment_method"]:checked');
        var method = $checked.length ? $checked.val() : 'razorpay';

        // If Cash On Delivery, let WooCommerce process normally
        if (method === 'cod') {
            return true;
        }

        // If payment ID already generated and verified, let form proceed
        var existingPaymentId = $('#razorpay_payment_id').val();
        if (existingPaymentId && existingPaymentId.length > 5) {
            return true;
        }

        // Validate mandatory customer shipping fields before starting payment
        var requiredSelectors = [
            '#billing_first_name',
            '#billing_last_name',
            '#billing_address_1',
            '#billing_city',
            '#billing_postcode',
            '#billing_phone',
            '#billing_email'
        ];

        var firstInvalid = null;
        requiredSelectors.forEach(function (sel) {
            var $el = $(sel);
            if ($el.length && !$.trim($el.val())) {
                if (!firstInvalid) firstInvalid = $el;
                $el.css({ 'border-color': '#d9534f', 'background': '#fff8f8' });
            } else if ($el.length) {
                $el.css({ 'border-color': '', 'background': '' });
            }
        });

        if (firstInvalid) {
            e.preventDefault();
            activateShippingStep();
            $('html, body').animate({ scrollTop: firstInvalid.offset().top - 120 }, 400);
            firstInvalid.focus();
            showRazorpayNotice('Please complete all required shipping details before proceeding with payment.', true);
            return false;
        }

        e.preventDefault();

        var $btn = $(this);
        if (!originalButtonHtml) {
            originalButtonHtml = $btn.html();
        }
        $btn.prop('disabled', true).html('<i class="fa-solid fa-spinner fa-spin" style="margin-right: 8px;"></i> Opening Razorpay Secure Checkout...');

        window.kashPayWithRazorpay(
            {},
            function (response, verifyRes) {
                // Payment Verified Successfully
                showRazorpayNotice('Payment authorized & verified successfully! Confirming your order...', false);
                $btn.html('<i class="fa-solid fa-check" style="margin-right: 8px;"></i> Payment Confirmed! Finalizing...');

                var $form = $('form.checkout');
                if ($form.length) {
                    $form.off('submit.kash_rzp');
                    $form.trigger('submit');
                }

                // Fallback redirect for preview / standalone environment
                setTimeout(function () {
                    if (window.location.pathname.indexOf('order-received') === -1) {
                        var returnOrderId = response.razorpay_order_id ? response.razorpay_order_id.replace('order_', '') : '1001';
                        window.location.href = '/checkout/order-received/' + returnOrderId + '?order-received=' + returnOrderId + '&payment=razorpay&payment_id=' + response.razorpay_payment_id;
                    }
                }, 1000);
            },
            function (errObj) {
                resetPlaceOrderBtn();
                if (errObj && errObj.cancelled) {
                    showRazorpayNotice('Payment modal closed. You can re-open payment whenever you are ready.', false);
                } else {
                    var errorMsg = (errObj && (errObj.error || errObj.message)) ? (errObj.error || errObj.message) : (typeof errObj === 'string' ? errObj : 'Payment could not be completed.');
                    showRazorpayNotice(errorMsg, true);
                }
            }
        );
    });

    /* --------------------------------------------------------------------------
       STANDALONE RAZORPAY BUTTON BINDING (#rzp-button1 / .rzp-checkout-button)
       -------------------------------------------------------------------------- */
    $(document).on('click', '#rzp-button1, .rzp-checkout-button, [data-action="razorpay-checkout"]', function (e) {
        e.preventDefault();
        var $btn = $(this);
        var origText = $btn.html();
        $btn.prop('disabled', true).html('<i class="fa-solid fa-spinner fa-spin"></i> Processing...');

        var customAmount = $btn.data('amount') ? parseInt($btn.data('amount'), 10) : getCheckoutAmountPaise();

        window.kashPayWithRazorpay(
            { amount: customAmount },
            function (response, verifyRes) {
                $btn.prop('disabled', false).html(origText);
                showRazorpayNotice('Payment verified! Payment ID: ' + response.razorpay_payment_id, false);
                alert('Payment Successful!\nPayment ID: ' + response.razorpay_payment_id + '\nOrder ID: ' + response.razorpay_order_id);
            },
            function (errObj) {
                $btn.prop('disabled', false).html(origText);
                if (errObj && errObj.cancelled) {
                    console.log('Payment modal dismissed.');
                } else {
                    var msg = (errObj && (errObj.error || errObj.message)) ? (errObj.error || errObj.message) : 'Payment failed.';
                    showRazorpayNotice(msg, true);
                }
            }
        );
    });
});
