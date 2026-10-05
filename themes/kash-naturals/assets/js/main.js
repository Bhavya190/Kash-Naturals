/**
 * Kash Naturals Main JavaScript
 */
jQuery(document).ready(function ($) {
    'use strict';

    // Search Modal Toggles
    const $searchModal = $('#search-modal');
    $('#search-modal-trigger').on('click', function (e) {
        e.preventDefault();
        $searchModal.addClass('active');
        $searchModal.find('.search-field').focus();
    });

    $('#close-search, .search-modal-overlay').on('click', function (e) {
        if (e.target === this) {
            $searchModal.removeClass('active');
        }
    });

    $(document).keyup(function (e) {
        if (e.key === "Escape") {
            $searchModal.removeClass('active');
        }
    });

    // Mobile Navigation Drawer Toggle
    $('#mobile-menu-trigger').on('click', function () {
        $('#site-navigation').toggleClass('active-mobile');
        $(this).find('i').toggleClass('fa-bars fa-xmark');
    });

    // Smooth Scroll for Internal Anchors
    $('a[href^="#"]').on('click', function (e) {
        const target = $(this.getAttribute('href'));
        if (target.length) {
            e.preventDefault();
            $('html, body').stop().animate({
                scrollTop: target.offset().top - 90
            }, 600);
        }
    });

    // Sticky Header Scroll Shadow Effect
    $(window).on('scroll', function () {
        if ($(window).scrollTop() > 50) {
            $('.site-header').addClass('scrolled');
        } else {
            $('.site-header').removeClass('scrolled');
        }
    });
});
