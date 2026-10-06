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

<!-- Page Banner Header -->
<div class="policy-page-header">
    <div class="container text-center">
        <span class="policy-header-subtitle"><?php esc_html_e('TRANSPARENT & TRUSTED SHIPPING', 'kash-naturals'); ?></span>
        <h1 class="policy-header-title"><?php esc_html_e('Shipping & Delivery Policy', 'kash-naturals'); ?></h1>
        <div class="policy-breadcrumb">
            <a href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('Home', 'kash-naturals'); ?></a>
            <span class="sep">/</span>
            <span class="current"><?php esc_html_e('Shipping Policy', 'kash-naturals'); ?></span>
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
                        <li><a href="<?php echo esc_url(home_url('/shipping-policy')); ?>" class="active"><i class="fa-solid fa-truck-fast"></i> <?php esc_html_e('Shipping Policy', 'kash-naturals'); ?></a></li>
                        <li><a href="<?php echo esc_url(home_url('/return-policy')); ?>"><i class="fa-solid fa-rotate-left"></i> <?php esc_html_e('Return Policy', 'kash-naturals'); ?></a></li>
                        <li><a href="<?php echo esc_url(home_url('/privacy-policy')); ?>"><i class="fa-solid fa-user-shield"></i> <?php esc_html_e('Privacy Policy', 'kash-naturals'); ?></a></li>
                        <li><a href="<?php echo esc_url(home_url('/terms-and-conditions')); ?>"><i class="fa-solid fa-file-contract"></i> <?php esc_html_e('Terms & Conditions', 'kash-naturals'); ?></a></li>
                        <li><a href="<?php echo esc_url(home_url('/faqs')); ?>"><i class="fa-solid fa-circle-question"></i> <?php esc_html_e('FAQs', 'kash-naturals'); ?></a></li>
                    </ul>
                </div>

                <div class="policy-help-card">
                    <i class="fa-solid fa-headset"></i>
                    <h4><?php esc_html_e('Need Assistance?', 'kash-naturals'); ?></h4>
                    <p><?php esc_html_e('Our customer care team is available to help with tracking and logistics queries.', 'kash-naturals'); ?></p>
                    <a href="mailto:info@kashnatural.com" class="btn-sidebar-contact">info@kashnatural.com</a>
                </div>
            </aside>

            <!-- Policy Content Area -->
            <div class="policy-content-card">
                <div class="policy-date-badge">
                    <i class="fa-solid fa-calendar-check"></i> <?php esc_html_e('Effective Date: October 2026 • Pan-India Logistics', 'kash-naturals'); ?>
                </div>

                <p class="policy-lead-text">
                    <?php esc_html_e('At Kash Natural, we ensure that your natural mouth fresheners, chocolate dragees, and luxury gift combos reach you in peak freshness, sealed packaging, and optimal condition. We partner with India’s leading express logistics providers for fast, reliable delivery.', 'kash-naturals'); ?>
                </p>

                <!-- Highlight Cards Row -->
                <div class="policy-highlights-grid">
                    <div class="policy-highlight-card">
                        <div class="highlight-icon"><i class="fa-solid fa-clock-rotate-left"></i></div>
                        <h4><?php esc_html_e('24-48 Hour Dispatch', 'kash-naturals'); ?></h4>
                        <p><?php esc_html_e('Orders prepared & packed within 24 to 48 hours.', 'kash-naturals'); ?></p>
                    </div>
                    <div class="policy-highlight-card">
                        <div class="highlight-icon"><i class="fa-solid fa-truck-ramp-box"></i></div>
                        <h4><?php esc_html_e('2-5 Days Delivery', 'kash-naturals'); ?></h4>
                        <p><?php esc_html_e('Fast express shipping across 26,000+ pincodes.', 'kash-naturals'); ?></p>
                    </div>
                    <div class="policy-highlight-card">
                        <div class="highlight-icon"><i class="fa-solid fa-snowflake"></i></div>
                        <h4><?php esc_html_e('Cold Insulated', 'kash-naturals'); ?></h4>
                        <p><?php esc_html_e('Temperature managed packing preventing melt.', 'kash-naturals'); ?></p>
                    </div>
                </div>

                <div class="policy-body-section">
                    <h2><span class="sec-num">1</span> <?php esc_html_e('Shipping Rates & Delivery Options', 'kash-naturals'); ?></h2>
                    <p><?php esc_html_e('We provide simple, transparent shipping pricing for orders placed on our website:', 'kash-naturals'); ?></p>
                    <ul>
                        <li><strong><?php esc_html_e('Prepaid Orders', 'kash-naturals'); ?>:</strong> <?php esc_html_e('FREE Shipping on all prepaid orders nationwide.', 'kash-naturals'); ?></li>
                        <li><strong><?php esc_html_e('Cash on Delivery (COD)', 'kash-naturals'); ?>:</strong> <?php esc_html_e('A nominal convenience fee of ₹49 applies on COD orders to cover courier handling charges.', 'kash-naturals'); ?></li>
                        <li><strong><?php esc_html_e('Express Air Dispatch', 'kash-naturals'); ?>:</strong> <?php esc_html_e('Priority air courier option available for select metro cities.', 'kash-naturals'); ?></li>
                    </ul>

                    <h2><span class="sec-num">2</span> <?php esc_html_e('Order Dispatch & Tracking', 'kash-naturals'); ?></h2>
                    <p><?php esc_html_e('Once your order is confirmed, our warehouse team handpicks and seals your items. As soon as your parcel is handed over to our courier partner, a live tracking link is sent via WhatsApp, SMS, and Email.', 'kash-naturals'); ?></p>

                    <h2><span class="sec-num">3</span> <?php esc_html_e('Insulated Packaging Guarantee', 'kash-naturals'); ?></h2>
                    <p><?php esc_html_e('To ensure our artisanal chocolates and dragees arrive intact even in warm weather, we utilize thermal insulation liners and ice gel pods during peak summer shipping.', 'kash-naturals'); ?></p>

                    <h2><span class="sec-num">4</span> <?php esc_html_e('Failed Delivery Attempts & Address Resolution', 'kash-naturals'); ?></h2>
                    <p><?php esc_html_e('Our courier partners attempt delivery up to 3 times. If delivery cannot be completed due to incorrect address or recipient unavailability, our support team will contact you to schedule re-delivery.', 'kash-naturals'); ?></p>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Shop on Amazon Banner Section -->
<?php get_template_part('template-parts/content', 'amazon-banner'); ?>

<?php
get_footer();

