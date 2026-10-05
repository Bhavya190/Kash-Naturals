<?php
/**
 * Template Name: Return & Refund Policy Page
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
    <p style="font-size: 0.9rem; color: #777;"><?php esc_html_e('Last Updated: October 2026', 'kash-naturals'); ?></p>

    <p><?php esc_html_e('At Kash Natural, we take immense pride in crafting premium mouth fresheners, chocolate dragees, kunafa bars, and herbal blends using the finest ingredients. Customer satisfaction is our highest priority.', 'kash-naturals'); ?></p>

    <h2><?php esc_html_e('1. Eligibility for Returns & Replacements', 'kash-naturals'); ?></h2>
    <p><?php esc_html_e('Due to the consumable nature of our food and confectionery items, we accept return or replacement requests under the following conditions:', 'kash-naturals'); ?></p>
    <ul>
        <li><?php esc_html_e('The product delivered is damaged, leaked, or corrupted during transit.', 'kash-naturals'); ?></li>
        <li><?php esc_html_e('An incorrect item was delivered.', 'kash-naturals'); ?></li>
        <li><?php esc_html_e('The item has passed its printed expiration date upon arrival.', 'kash-naturals'); ?></li>
    </ul>

    <h2><?php esc_html_e('2. Return & Refund Process', 'kash-naturals'); ?></h2>
    <div class="steps-box">
        <p><strong><?php esc_html_e('Step 1:', 'kash-naturals'); ?></strong> <?php esc_html_e('Notify us within 48 hours of order delivery with your order ID and clear photo/video proof of damage or issue to customer care email.', 'kash-naturals'); ?></p>
        <p><strong><?php esc_html_e('Step 2:', 'kash-naturals'); ?></strong> <?php esc_html_e('Our support team will verify your request within 24 business hours.', 'kash-naturals'); ?></p>
        <p><strong><?php esc_html_e('Step 3:', 'kash-naturals'); ?></strong> <?php esc_html_e('Once approved, a replacement shipment will be dispatched or full refund initiated to original payment source.', 'kash-naturals'); ?></p>
    </div>

    <h2><?php esc_html_e('3. Non-Returnable Items', 'kash-naturals'); ?></h2>
    <p><?php esc_html_e('Opened or partially consumed items cannot be returned due to hygiene and food safety standards unless product quality defect is identified.', 'kash-naturals'); ?></p>

    <h2><?php esc_html_e('4. Refund Timeline', 'kash-naturals'); ?></h2>
    <p><?php esc_html_e('Approved refunds will be processed back to original payment method (Credit/Debit Card, UPI, Net Banking) within 5-7 business days.', 'kash-naturals'); ?></p>
</div>

<?php
get_footer();
