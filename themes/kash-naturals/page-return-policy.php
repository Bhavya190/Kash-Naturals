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

<!-- Page Banner Header -->
<div class="policy-page-header">
    <div class="container text-center">
        <span class="policy-header-subtitle"><?php esc_html_e('HASSLE-FREE REPLACEMENTS & REFUNDS', 'kash-naturals'); ?></span>
        <h1 class="policy-header-title"><?php esc_html_e('Return & Refund Policy', 'kash-naturals'); ?></h1>
        <div class="policy-breadcrumb">
            <a href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('Home', 'kash-naturals'); ?></a>
            <span class="sep">/</span>
            <span class="current"><?php esc_html_e('Return Policy', 'kash-naturals'); ?></span>
        </div>
    </div>
</div>

<!-- Main Policy Layout -->
<section class="policy-main-section">
    <div class="container">
        <div class="policy-layout-grid">
            
            <!-- Policy Navigation Sidebar -->
            <aside class="policy-sidebar">
                <div class="policy-nav-card">
                    <h3 class="policy-sidebar-title"><?php esc_html_e('Policy Navigation', 'kash-naturals'); ?></h3>
                    <ul class="policy-nav-list">
                        <li><a href="<?php echo esc_url(home_url('/shipping-policy')); ?>"><i class="fa-solid fa-truck-fast"></i> <?php esc_html_e('Shipping Policy', 'kash-naturals'); ?></a></li>
                        <li><a href="<?php echo esc_url(home_url('/return-policy')); ?>" class="active"><i class="fa-solid fa-rotate-left"></i> <?php esc_html_e('Return Policy', 'kash-naturals'); ?></a></li>
                        <li><a href="<?php echo esc_url(home_url('/privacy-policy')); ?>"><i class="fa-solid fa-user-shield"></i> <?php esc_html_e('Privacy Policy', 'kash-naturals'); ?></a></li>
                        <li><a href="<?php echo esc_url(home_url('/terms-and-conditions')); ?>"><i class="fa-solid fa-file-contract"></i> <?php esc_html_e('Terms & Conditions', 'kash-naturals'); ?></a></li>
                        <li><a href="<?php echo esc_url(home_url('/faqs')); ?>"><i class="fa-solid fa-circle-question"></i> <?php esc_html_e('FAQs', 'kash-naturals'); ?></a></li>
                    </ul>
                </div>

                <div class="policy-help-card">
                    <i class="fa-solid fa-rotate-left"></i>
                    <h4><?php esc_html_e('Need to Report an Issue?', 'kash-naturals'); ?></h4>
                    <p><?php esc_html_e('Send photos of damaged items along with your Order ID for instant review.', 'kash-naturals'); ?></p>
                    <a href="mailto:support@kashnatural.com" class="btn-sidebar-contact">support@kashnatural.com</a>
                </div>
            </aside>

            <!-- Policy Content Area -->
            <div class="policy-content-card">
                <div class="policy-date-badge">
                    <i class="fa-solid fa-shield-check"></i> <?php esc_html_e('Customer Delight Guarantee • October 2026', 'kash-naturals'); ?>
                </div>

                <p class="policy-lead-text">
                    <?php esc_html_e('At Kash Natural, customer satisfaction is our top priority. We take immense pride in handcrafting fresh mouth fresheners, chocolate dragees, and luxury combos. If your package arrives damaged or defective, we offer prompt replacement or refund options.', 'kash-naturals'); ?>
                </p>

                <!-- 3-Step Return Flow Box -->
                <div class="return-steps-wrapper">
                    <h3 class="steps-title"><i class="fa-solid fa-list-check"></i> <?php esc_html_e('How to File a Return Request in 3 Steps', 'kash-naturals'); ?></h3>
                    <div class="steps-grid">
                        <div class="step-card">
                            <div class="step-num">1</div>
                            <h4><?php esc_html_e('Notify Us in 48h', 'kash-naturals'); ?></h4>
                            <p><?php esc_html_e('Email photos/videos of damaged item and Order ID to support@kashnatural.com', 'kash-naturals'); ?></p>
                        </div>
                        <div class="step-card">
                            <div class="step-num">2</div>
                            <h4><?php esc_html_e('Fast Verification', 'kash-naturals'); ?></h4>
                            <p><?php esc_html_e('Our support team reviews and approves your request within 24 working hours.', 'kash-naturals'); ?></p>
                        </div>
                        <div class="step-card">
                            <div class="step-num">3</div>
                            <h4><?php esc_html_e('Replacement or Refund', 'kash-naturals'); ?></h4>
                            <p><?php esc_html_e('A fresh parcel is dispatched or full refund credited to your payment source.', 'kash-naturals'); ?></p>
                        </div>
                    </div>
                </div>

                <div class="policy-body-section">
                    <h2><span class="sec-num">1</span> <?php esc_html_e('Eligible Conditions for Return & Replacement', 'kash-naturals'); ?></h2>
                    <p><?php esc_html_e('Due to strict food safety guidelines, returns are accepted under the following conditions:', 'kash-naturals'); ?></p>
                    <ul>
                        <li><?php esc_html_e('Products damaged, leaked, or unsealed during transit.', 'kash-naturals'); ?></li>
                        <li><?php esc_html_e('Incorrect product or quantity delivered.', 'kash-naturals'); ?></li>
                        <li><?php esc_html_e('Product past its printed shelf-life date upon delivery.', 'kash-naturals'); ?></li>
                    </ul>

                    <h2><span class="sec-num">2</span> <?php esc_html_e('Non-Returnable Items', 'kash-naturals'); ?></h2>
                    <p><?php esc_html_e('Opened or partially consumed items cannot be returned due to hygiene and food safety standards unless a manufacturing quality defect is proven.', 'kash-naturals'); ?></p>

                    <h2><span class="sec-num">3</span> <?php esc_html_e('Refund Timeline & Payment Method', 'kash-naturals'); ?></h2>
                    <p><?php esc_html_e('Approved refunds are processed back to your original payment source (Credit/Debit Card, UPI, Net Banking) within 5 to 7 business days. For COD orders, refund is transferred via UPI or Bank Transfer.', 'kash-naturals'); ?></p>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Shop on Amazon Banner Section -->
<?php get_template_part('template-parts/content', 'amazon-banner'); ?>

<?php
get_footer();

