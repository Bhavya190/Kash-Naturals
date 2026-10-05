<?php
/**
 * Template Name: Privacy Policy Page
 *
 * @package KashNaturals
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>

<div class="page-header-banner">
    <h1 class="page-banner-title"><?php the_title(); ?></h1>
    <div class="breadcrumb-links">
        <a href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('Home', 'kash-naturals'); ?></a> &nbsp;&nbsp;/&nbsp;&nbsp; <span><?php the_title(); ?></span>
    </div>
</div>

<div class="policy-container">
    <p style="font-size: 0.9rem; color: #777;"><?php esc_html_e('Last updated: October 2026', 'kash-naturals'); ?></p>

    <p><?php esc_html_e('At Kash Natural, we are committed to protecting your privacy and ensuring your personal information is handled in a safe and responsible manner.', 'kash-naturals'); ?></p>

    <h2><?php esc_html_e('1. Information We Collect', 'kash-naturals'); ?></h2>
    <p><?php esc_html_e('When you visit or place an order on Kash Natural, we collect information necessary to process your purchase and enhance your experience:', 'kash-naturals'); ?></p>
    <ul>
        <li><strong><?php esc_html_e('Personal Identifiers', 'kash-naturals'); ?></strong>: Name, shipping address, billing address, phone number, and email address.</li>
        <li><strong><?php esc_html_e('Order Details', 'kash-naturals'); ?></strong>: Products purchased, payment confirmation tokens, and delivery preferences.</li>
        <li><strong><?php esc_html_e('Technical Data', 'kash-naturals'); ?></strong>: IP address, browser type, cookies, and website interaction analytics.</li>
    </ul>

    <h2><?php esc_html_e('2. How We Use Your Information', 'kash-naturals'); ?></h2>
    <p><?php esc_html_e('Your information is strictly used for the following purposes:', 'kash-naturals'); ?></p>
    <ul>
        <li>To process, fulfill, and deliver your orders for mouth fresheners, dragees, and gift combos.</li>
        <li>To communicate shipping updates, tracking info, and order receipts.</li>
        <li>To send promotional updates or discount codes (only if opted-in).</li>
        <li>To prevent fraudulent transactions and secure our platform.</li>
    </ul>

    <h2><?php esc_html_e('3. Data Protection & Security', 'kash-naturals'); ?></h2>
    <p><?php esc_html_e('We implement strict security measures, SSL encryption, and secure payment gateways to ensure your data is safeguarded at all times.', 'kash-naturals'); ?></p>

    <h2><?php esc_html_e('4. Contact Us', 'kash-naturals'); ?></h2>
    <p><?php esc_html_e('If you have any questions regarding our Privacy Policy, please contact us at info@kashnatural.com or call +91 98765 43210.', 'kash-naturals'); ?></p>
</div>

<?php
get_footer();
