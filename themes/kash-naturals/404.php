<?php
/**
 * The template for displaying 404 pages (Not Found)
 *
 * @package KashNaturals
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>

<div class="container section-padding text-center">
    <div class="error-404-wrapper">
        <span class="error-badge">404</span>
        <h1 class="error-title">Oops! Cocoa Trail Lost</h1>
        <p class="error-subtitle">
            The chocolate bar page you are looking for might have been eaten or moved to a different shelf.
        </p>
        <div class="gold-divider"></div>
        <div class="error-actions">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn-gold btn-large">
                <i class="fa-solid fa-house"></i> Return Home
            </a>
            <a href="<?php echo esc_url(class_exists('WooCommerce') ? wc_get_page_permalink('shop') : '#'); ?>" class="btn btn-outline btn-large">
                <i class="fa-solid fa-shop"></i> Browse Chocolates
            </a>
        </div>
    </div>
</div>

<?php
get_footer();
