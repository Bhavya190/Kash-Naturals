<?php
/**
 * Template Name: Terms & Conditions Page
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

    <p><?php esc_html_e('Welcome to Kash Natural. By accessing or purchasing from our website, you agree to comply with and be bound by the following terms and conditions.', 'kash-naturals'); ?></p>

    <h2><?php esc_html_e('1. General Online Store Terms', 'kash-naturals'); ?></h2>
    <p><?php esc_html_e('By agreeing to these Terms of Service, you represent that you are at least the age of majority in your state or province of residence.', 'kash-naturals'); ?></p>

    <h2><?php esc_html_e('2. Products & Pricing', 'kash-naturals'); ?></h2>
    <p><?php esc_html_e('All prices for our mouth fresheners, chocolate dragees, kunafa bars, and gift combos are subject to change without notice.', 'kash-naturals'); ?></p>

    <h2><?php esc_html_e('3. Orders & Cancellations', 'kash-naturals'); ?></h2>
    <p><?php esc_html_e('Orders can be modified or cancelled within 2 hours of placement before dispatch.', 'kash-naturals'); ?></p>

    <h2><?php esc_html_e('4. Governing Law', 'kash-naturals'); ?></h2>
    <p><?php esc_html_e('These terms and conditions are governed by and construed in accordance with the laws of India.', 'kash-naturals'); ?></p>
</div>

<?php
get_footer();
