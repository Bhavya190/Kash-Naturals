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

<!-- Page Banner Header -->
<div class="policy-page-header">
    <div class="container text-center">
        <span class="policy-header-subtitle"><?php esc_html_e('LEGAL AGREEMENT & STORE GUIDELINES', 'kash-naturals'); ?></span>
        <h1 class="policy-header-title"><?php esc_html_e('Terms & Conditions', 'kash-naturals'); ?></h1>
        <div class="policy-breadcrumb">
            <a href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('Home', 'kash-naturals'); ?></a>
            <span class="sep">/</span>
            <span class="current"><?php esc_html_e('Terms & Conditions', 'kash-naturals'); ?></span>
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
                        <li><a href="<?php echo esc_url(home_url('/return-policy')); ?>"><i class="fa-solid fa-rotate-left"></i> <?php esc_html_e('Return Policy', 'kash-naturals'); ?></a></li>
                        <li><a href="<?php echo esc_url(home_url('/privacy-policy')); ?>"><i class="fa-solid fa-user-shield"></i> <?php esc_html_e('Privacy Policy', 'kash-naturals'); ?></a></li>
                        <li><a href="<?php echo esc_url(home_url('/terms-and-conditions')); ?>" class="active"><i class="fa-solid fa-file-contract"></i> <?php esc_html_e('Terms & Conditions', 'kash-naturals'); ?></a></li>
                        <li><a href="<?php echo esc_url(home_url('/faqs')); ?>"><i class="fa-solid fa-circle-question"></i> <?php esc_html_e('FAQs', 'kash-naturals'); ?></a></li>
                    </ul>
                </div>

                <div class="policy-help-card">
                    <i class="fa-solid fa-scale-balanced"></i>
                    <h4><?php esc_html_e('Legal Questions?', 'kash-naturals'); ?></h4>
                    <p><?php esc_html_e('For legal or vendor partnership queries, write to our compliance team.', 'kash-naturals'); ?></p>
                    <a href="mailto:legal@kashnatural.com" class="btn-sidebar-contact">legal@kashnatural.com</a>
                </div>
            </aside>

            <!-- Policy Content Area -->
            <div class="policy-content-card">
                <div class="policy-date-badge">
                    <i class="fa-solid fa-gavel"></i> <?php esc_html_e('Governed under Laws of India • Effective October 2026', 'kash-naturals'); ?>
                </div>

                <p class="policy-lead-text">
                    <?php esc_html_e('Welcome to Kash Natural. By accessing our website, placing an order, or utilizing our services, you agree to be bound by the following Terms and Conditions. Please review them carefully before making a purchase.', 'kash-naturals'); ?>
                </p>

                <!-- Terms Summary Cards Grid -->
                <div class="policy-highlights-grid">
                    <div class="policy-highlight-card">
                        <div class="highlight-icon"><i class="fa-solid fa-store"></i></div>
                        <h4><?php esc_html_e('Online Store Terms', 'kash-naturals'); ?></h4>
                        <p><?php esc_html_e('Agreement to legal age and valid purchasing information.', 'kash-naturals'); ?></p>
                    </div>
                    <div class="policy-highlight-card">
                        <div class="highlight-icon"><i class="fa-solid fa-tags"></i></div>
                        <h4><?php esc_html_e('Transparent Pricing', 'kash-naturals'); ?></h4>
                        <p><?php esc_html_e('All item prices inclusive of applicable GST taxes.', 'kash-naturals'); ?></p>
                    </div>
                    <div class="policy-highlight-card">
                        <div class="highlight-icon"><i class="fa-solid fa-copyright"></i></div>
                        <h4><?php esc_html_e('Brand IP Protection', 'kash-naturals'); ?></h4>
                        <p><?php esc_html_e('Kash Natural logos, images, and content copyrighted.', 'kash-naturals'); ?></p>
                    </div>
                </div>

                <div class="policy-body-section">
                    <h2><span class="sec-num">1</span> <?php esc_html_e('General Terms & Conditions', 'kash-naturals'); ?></h2>
                    <p><?php esc_html_e('By using Kash Natural’s platform, you represent that you are at least 18 years of age or accessing under parental supervision. We reserve the right to refuse service or cancel orders in cases of suspected fraud or policy misuse.', 'kash-naturals'); ?></p>

                    <h2><span class="sec-num">2</span> <?php esc_html_e('Products, Pricing & Inventory', 'kash-naturals'); ?></h2>
                    <p><?php esc_html_e('We strive to display exact product descriptions, net weights, and high-definition photography of our mouth fresheners, chocolate dragees, and gift combos. Prices for all products are subject to change without prior notice.', 'kash-naturals'); ?></p>

                    <h2><span class="sec-num">3</span> <?php esc_html_e('Order Placement & Cancellation Policy', 'kash-naturals'); ?></h2>
                    <p><?php esc_html_e('Orders can be modified or cancelled within 2 hours of placement before our dispatch team packages the parcel. Once an order is shipped, standard Return & Refund policies apply.', 'kash-naturals'); ?></p>

                    <h2><span class="sec-num">4</span> <?php esc_html_e('Intellectual Property Rights', 'kash-naturals'); ?></h2>
                    <p><?php esc_html_e('All brand assets, including the Kash Natural logo, product design packaging, graphics, website source code, and copy, are protected intellectual property and cannot be reproduced without explicit written consent.', 'kash-naturals'); ?></p>

                    <h2><span class="sec-num">5</span> <?php esc_html_e('Jurisdiction & Governing Law', 'kash-naturals'); ?></h2>
                    <p><?php esc_html_e('These Terms & Conditions are governed by and construed in accordance with the laws of India. Any legal disputes shall be subject to the exclusive jurisdiction of the courts in Surat, Gujarat.', 'kash-naturals'); ?></p>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Shop on Amazon Banner Section -->
<?php get_template_part('template-parts/content', 'amazon-banner'); ?>

<?php
get_footer();

