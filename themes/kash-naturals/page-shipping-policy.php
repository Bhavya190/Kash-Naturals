<?php
/**
 * Template Name: Shipping Policy Page
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
    <p style="font-size: 0.9rem; color: #777;"><?php esc_html_e('Effective Date: October 2026', 'kash-naturals'); ?></p>

    <p><?php esc_html_e('At Kash Natural, we ensure that your natural mouth fresheners, chocolate dragees, and luxury combos reach you in peak freshness and perfect packaging. We partner with reliable courier services for fast, Pan-India delivery.', 'kash-naturals'); ?></p>

    <div class="shipping-grid">
        <div class="shipping-card">
            <h3><i class="fa-solid fa-clock" style="color:#d4af37; margin-right:8px;"></i> <?php esc_html_e('Processing Time', 'kash-naturals'); ?></h3>
            <p><?php esc_html_e('Orders are dispatched within 24 to 48 working hours from order confirmation.', 'kash-naturals'); ?></p>
        </div>
        <div class="shipping-card">
            <h3><i class="fa-solid fa-truck" style="color:#d4af37; margin-right:8px;"></i> <?php esc_html_e('Delivery Window', 'kash-naturals'); ?></h3>
            <p><?php esc_html_e('Standard delivery takes 3 to 7 business days depending on delivery pincode.', 'kash-naturals'); ?></p>
        </div>
        <div class="shipping-card">
            <h3><i class="fa-solid fa-box-open" style="color:#d4af37; margin-right:8px;"></i> <?php esc_html_e('Secure Packaging', 'kash-naturals'); ?></h3>
            <p><?php esc_html_e('All items are sealed in airtight glass jars and eco-protective bubble padding.', 'kash-naturals'); ?></p>
        </div>
    </div>

    <h2><?php esc_html_e('1. Shipping Charges', 'kash-naturals'); ?></h2>
    <p><?php esc_html_e('We offer FREE Shipping on all prepaid orders across India. For Cash on Delivery (COD) orders, a nominal handling fee of ₹49 may apply.', 'kash-naturals'); ?></p>

    <h2><?php esc_html_e('2. Order Tracking', 'kash-naturals'); ?></h2>
    <p><?php esc_html_e('Once your order is dispatched, a tracking link with live carrier updates will be sent via SMS and Email to the contact details provided at checkout.', 'kash-naturals'); ?></p>

    <h2><?php esc_html_e('3. Delivery Locations', 'kash-naturals'); ?></h2>
    <p><?php esc_html_e('We deliver across 26,000+ pincodes in India. For remote locations where express shipping is unavailable, standard India Post or surface logistics may be utilized.', 'kash-naturals'); ?></p>

    <h2><?php esc_html_e('4. Non-Delivery & Failed Delivery Attempts', 'kash-naturals'); ?></h2>
    <p><?php esc_html_e('If courier agents are unable to reach you after 3 attempts, the shipment will return to our central warehouse. Contact customer care at care@kashnatural.com to schedule re-dispatch.', 'kash-naturals'); ?></p>
</div>

<?php
get_footer();
