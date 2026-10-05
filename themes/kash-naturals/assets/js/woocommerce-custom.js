/**
 * WooCommerce Specific Interactive Script
 */
jQuery(document).ready(function ($) {
    'use strict';

    // Auto-update cart badge on WooCommerce AJAX add-to-cart
    $(document.body).on('added_to_cart', function (event, fragments, cart_hash, $button) {
        if ($button && $button.length) {
            $button.addClass('added-success');
            setTimeout(function () {
                $button.removeClass('added-success');
            }, 2000);
        }
    });

    // Taste Now Quick Add Animation
    $('.product-card-item .add_to_cart_button').on('click', function () {
        const $badge = $('#mini-cart-count');
        $badge.addClass('bump-anim');
        setTimeout(() => $badge.removeClass('bump-anim'), 400);
    });
});
