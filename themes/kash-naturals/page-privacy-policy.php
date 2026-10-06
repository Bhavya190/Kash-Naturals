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

<!-- Page Banner Header -->
<div class="policy-page-header">
    <div class="container text-center">
        <span class="policy-header-subtitle"><?php esc_html_e('DATA PROTECTION & SECURITY COMMITMENT', 'kash-naturals'); ?></span>
        <h1 class="policy-header-title"><?php esc_html_e('Privacy Policy', 'kash-naturals'); ?></h1>
        <div class="policy-breadcrumb">
            <a href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('Home', 'kash-naturals'); ?></a>
            <span class="sep">/</span>
            <span class="current"><?php esc_html_e('Privacy Policy', 'kash-naturals'); ?></span>
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
                        <li><a href="<?php echo esc_url(home_url('/privacy-policy')); ?>" class="active"><i class="fa-solid fa-user-shield"></i> <?php esc_html_e('Privacy Policy', 'kash-naturals'); ?></a></li>
                        <li><a href="<?php echo esc_url(home_url('/terms-and-conditions')); ?>"><i class="fa-solid fa-file-contract"></i> <?php esc_html_e('Terms & Conditions', 'kash-naturals'); ?></a></li>
                        <li><a href="<?php echo esc_url(home_url('/faqs')); ?>"><i class="fa-solid fa-circle-question"></i> <?php esc_html_e('FAQs', 'kash-naturals'); ?></a></li>
                    </ul>
                </div>

                <div class="policy-help-card">
                    <i class="fa-solid fa-user-shield"></i>
                    <h4><?php esc_html_e('Data Privacy Queries?', 'kash-naturals'); ?></h4>
                    <p><?php esc_html_e('Contact our Data Governance officer for any privacy or account data questions.', 'kash-naturals'); ?></p>
                    <a href="mailto:privacy@kashnatural.com" class="btn-sidebar-contact">privacy@kashnatural.com</a>
                </div>
            </aside>

            <!-- Policy Content Area -->
            <div class="policy-content-card">
                <div class="policy-date-badge">
                    <i class="fa-solid fa-lock"></i> <?php esc_html_e('256-Bit SSL Encrypted • Updated October 2026', 'kash-naturals'); ?>
                </div>

                <p class="policy-lead-text">
                    <?php esc_html_e('At Kash Natural, we are deeply committed to safeguarding your personal privacy. This Privacy Policy details how we collect, use, protect, and handle your data when you browse our website or purchase our natural mouth fresheners and confectionery products.', 'kash-naturals'); ?>
                </p>

                <!-- Security Badges Row -->
                <div class="policy-highlights-grid">
                    <div class="policy-highlight-card">
                        <div class="highlight-icon"><i class="fa-solid fa-shield-halved"></i></div>
                        <h4><?php esc_html_e('SSL Encrypted', 'kash-naturals'); ?></h4>
                        <p><?php esc_html_e('Bank-grade 256-bit data encryption.', 'kash-naturals'); ?></p>
                    </div>
                    <div class="policy-highlight-card">
                        <div class="highlight-icon"><i class="fa-solid fa-ban-smoking"></i></div>
                        <h4><?php esc_html_e('Zero Spam Policy', 'kash-naturals'); ?></h4>
                        <p><?php esc_html_e('We never sell or rent your personal information.', 'kash-naturals'); ?></p>
                    </div>
                    <div class="policy-highlight-card">
                        <div class="highlight-icon"><i class="fa-solid fa-credit-card"></i></div>
                        <h4><?php esc_html_e('Secure Payments', 'kash-naturals'); ?></h4>
                        <p><?php esc_html_e('PCI-DSS compliant payment gateways.', 'kash-naturals'); ?></p>
                    </div>
                </div>

                <div class="policy-body-section">
                    <h2><span class="sec-num">1</span> <?php esc_html_e('Information We Collect', 'kash-naturals'); ?></h2>
                    <p><?php esc_html_e('When you visit or purchase from Kash Natural, we collect necessary information to fulfill your orders securely:', 'kash-naturals'); ?></p>
                    <ul>
                        <li><strong><?php esc_html_e('Personal Identifiers', 'kash-naturals'); ?>:</strong> <?php esc_html_e('Full name, shipping address, billing address, phone number, and email address.', 'kash-naturals'); ?></li>
                        <li><strong><?php esc_html_e('Transaction Data', 'kash-naturals'); ?>:</strong> <?php esc_html_e('Order items, delivery notes, and payment authorization tokens provided by certified gateways (Razorpay, Paytm, Cashfree).', 'kash-naturals'); ?></li>
                        <li><strong><?php esc_html_e('Technical Data', 'kash-naturals'); ?>:</strong> <?php esc_html_e('IP address, browser type, device info, and browsing activity logs for site optimization.', 'kash-naturals'); ?></li>
                    </ul>

                    <h2><span class="sec-num">2</span> <?php esc_html_e('How We Use Your Information', 'kash-naturals'); ?></h2>
                    <p><?php esc_html_e('Your information is utilized solely for legitimate operational purposes:', 'kash-naturals'); ?></p>
                    <ul>
                        <li><?php esc_html_e('To process, package, and deliver your orders across India.', 'kash-naturals'); ?></li>
                        <li><?php esc_html_e('To send real-time order tracking updates via WhatsApp, SMS, and Email.', 'kash-naturals'); ?></li>
                        <li><?php esc_html_e('To provide dedicated customer support and handle inquiry responses.', 'kash-naturals'); ?></li>
                        <li><?php esc_html_e('To notify you about special festive discounts or new product launches (only if opted-in).', 'kash-naturals'); ?></li>
                    </ul>

                    <h2><span class="sec-num">3</span> <?php esc_html_e('Payment Security & Gateway Tokenization', 'kash-naturals'); ?></h2>
                    <p><?php esc_html_e('Kash Natural does NOT store card numbers or UPI PINs on our servers. All financial transactions are directly processed through PCI-DSS Level 1 compliant payment partners.', 'kash-naturals'); ?></p>

                    <h2><span class="sec-num">4</span> <?php esc_html_e('Data Rights & Deletion Requests', 'kash-naturals'); ?></h2>
                    <p><?php esc_html_e('You have the right to inspect, update, or request deletion of your personal account data at any time by emailing privacy@kashnatural.com.', 'kash-naturals'); ?></p>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Shop on Amazon Banner Section -->
<?php get_template_part('template-parts/content', 'amazon-banner'); ?>

<?php
get_footer();

