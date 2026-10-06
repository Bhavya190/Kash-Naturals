<?php
/**
 * Template Name: FAQs Page
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
        <span class="policy-header-subtitle"><?php esc_html_e('HELP CENTER & COMMON QUESTIONS', 'kash-naturals'); ?></span>
        <h1 class="policy-header-title"><?php esc_html_e('Frequently Asked Questions', 'kash-naturals'); ?></h1>
        <div class="policy-breadcrumb">
            <a href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('Home', 'kash-naturals'); ?></a>
            <span class="sep">/</span>
            <span class="current"><?php esc_html_e('FAQs', 'kash-naturals'); ?></span>
        </div>
    </div>
</div>

<!-- Main FAQ Layout -->
<section class="policy-main-section">
    <div class="container">
        <div class="policy-layout-grid">
            
            <!-- Sidebar Navigation -->
            <aside class="policy-sidebar">
                <div class="policy-nav-card">
                    <h3 class="policy-sidebar-title"><?php esc_html_e('Policy Navigation', 'kash-naturals'); ?></h3>
                    <ul class="policy-nav-list">
                        <li><a href="<?php echo esc_url(home_url('/shipping-policy')); ?>"><i class="fa-solid fa-truck-fast"></i> <?php esc_html_e('Shipping Policy', 'kash-naturals'); ?></a></li>
                        <li><a href="<?php echo esc_url(home_url('/return-policy')); ?>"><i class="fa-solid fa-rotate-left"></i> <?php esc_html_e('Return Policy', 'kash-naturals'); ?></a></li>
                        <li><a href="<?php echo esc_url(home_url('/privacy-policy')); ?>"><i class="fa-solid fa-user-shield"></i> <?php esc_html_e('Privacy Policy', 'kash-naturals'); ?></a></li>
                        <li><a href="<?php echo esc_url(home_url('/terms-and-conditions')); ?>"><i class="fa-solid fa-file-contract"></i> <?php esc_html_e('Terms & Conditions', 'kash-naturals'); ?></a></li>
                        <li><a href="<?php echo esc_url(home_url('/faqs')); ?>" class="active"><i class="fa-solid fa-circle-question"></i> <?php esc_html_e('FAQs', 'kash-naturals'); ?></a></li>
                    </ul>
                </div>

                <div class="policy-help-card">
                    <i class="fa-brands fa-whatsapp"></i>
                    <h4><?php esc_html_e('Still Have Questions?', 'kash-naturals'); ?></h4>
                    <p><?php esc_html_e('Connect directly with our customer support team via WhatsApp for instant assistance.', 'kash-naturals'); ?></p>
                    <a href="https://wa.me/919876543210" target="_blank" rel="noopener noreferrer" class="btn-sidebar-contact"><?php esc_html_e('WhatsApp Support', 'kash-naturals'); ?></a>
                </div>
            </aside>

            <!-- FAQ Accordion Content Area -->
            <div class="policy-content-card">
                
                <!-- Category 1: Orders & Shipping -->
                <div class="faq-category-block">
                    <h2 class="faq-cat-title"><i class="fa-solid fa-truck-fast"></i> <?php esc_html_e('1. Orders & Delivery', 'kash-naturals'); ?></h2>
                    
                    <div class="faq-accordion-group">
                        <details class="faq-item-exact" open>
                            <summary class="faq-question-exact">
                                <span><?php esc_html_e('How long does delivery take across India?', 'kash-naturals'); ?></span>
                                <i class="fa-solid fa-chevron-down faq-chevron"></i>
                            </summary>
                            <div class="faq-answer-exact">
                                <p><?php esc_html_e('Orders are processed within 24 hours. Delivery typically takes 2 to 5 business days across 26,000+ pincodes in India. We use express courier partners and cold-insulated packing for chocolates.', 'kash-naturals'); ?></p>
                            </div>
                        </details>

                        <details class="faq-item-exact">
                            <summary class="faq-question-exact">
                                <span><?php esc_html_e('Do you offer Free Shipping and Cash on Delivery?', 'kash-naturals'); ?></span>
                                <i class="fa-solid fa-chevron-down faq-chevron"></i>
                            </summary>
                            <div class="faq-answer-exact">
                                <p><?php esc_html_e('Yes! All prepaid orders receive FREE shipping across India. Cash on Delivery (COD) is available with a nominal ₹49 handling fee.', 'kash-naturals'); ?></p>
                            </div>
                        </details>

                        <details class="faq-item-exact">
                            <summary class="faq-question-exact">
                                <span><?php esc_html_e('How can I track my order?', 'kash-naturals'); ?></span>
                                <i class="fa-solid fa-chevron-down faq-chevron"></i>
                            </summary>
                            <div class="faq-answer-exact">
                                <p><?php esc_html_e('Once dispatched, a live tracking link will be sent to your registered mobile number and email address via WhatsApp/SMS.', 'kash-naturals'); ?></p>
                            </div>
                        </details>
                    </div>
                </div>

                <!-- Category 2: Ingredients & Freshness -->
                <div class="faq-category-block">
                    <h2 class="faq-cat-title"><i class="fa-solid fa-leaf"></i> <?php esc_html_e('2. Ingredients & Quality', 'kash-naturals'); ?></h2>
                    
                    <div class="faq-accordion-group">
                        <details class="faq-item-exact">
                            <summary class="faq-question-exact">
                                <span><?php esc_html_e('Are Kash Natural mouth fresheners 100% vegetarian?', 'kash-naturals'); ?></span>
                                <i class="fa-solid fa-chevron-down faq-chevron"></i>
                            </summary>
                            <div class="faq-answer-exact">
                                <p><?php esc_html_e('Yes! 100% of our products, including mouth fresheners, mukhwas mixes, and chocolate dragees, are strictly 100% vegetarian.', 'kash-naturals'); ?></p>
                            </div>
                        </details>

                        <details class="faq-item-exact">
                            <summary class="faq-question-exact">
                                <span><?php esc_html_e('What is the shelf life of your products?', 'kash-naturals'); ?></span>
                                <i class="fa-solid fa-chevron-down faq-chevron"></i>
                            </summary>
                            <div class="faq-answer-exact">
                                <p><?php esc_html_e('Our airtight glass jar products have a shelf life of 9 to 12 months when stored in a cool, dry place away from direct sunlight.', 'kash-naturals'); ?></p>
                            </div>
                        </details>
                    </div>
                </div>

                <!-- Category 3: Returns & Refunds -->
                <div class="faq-category-block">
                    <h2 class="faq-cat-title"><i class="fa-solid fa-rotate-left"></i> <?php esc_html_e('3. Returns & Replacements', 'kash-naturals'); ?></h2>
                    
                    <div class="faq-accordion-group">
                        <details class="faq-item-exact">
                            <summary class="faq-question-exact">
                                <span><?php esc_html_e('What should I do if my package is damaged during transit?', 'kash-naturals'); ?></span>
                                <i class="fa-solid fa-chevron-down faq-chevron"></i>
                            </summary>
                            <div class="faq-answer-exact">
                                <p><?php esc_html_e('Please take a clear photo/video of the damaged parcel and email it to support@kashnatural.com within 48 hours. We will send a free replacement immediately.', 'kash-naturals'); ?></p>
                            </div>
                        </details>
                    </div>
                </div>

                <!-- Category 4: Corporate & Bulk Gifting -->
                <div class="faq-category-block">
                    <h2 class="faq-cat-title"><i class="fa-solid fa-gift"></i> <?php esc_html_e('4. Corporate & Bulk Orders', 'kash-naturals'); ?></h2>
                    
                    <div class="faq-accordion-group">
                        <details class="faq-item-exact">
                            <summary class="faq-question-exact">
                                <span><?php esc_html_e('Do you supply custom hampers for weddings and corporate events?', 'kash-naturals'); ?></span>
                                <i class="fa-solid fa-chevron-down faq-chevron"></i>
                            </summary>
                            <div class="faq-answer-exact">
                                <p><?php esc_html_e('Yes! We specialize in custom-branded luxury hampers, festive gift boxes, and wedding return gifts. Write to b2b@kashnatural.com for catalog and wholesale pricing.', 'kash-naturals'); ?></p>
                            </div>
                        </details>
                    </div>
                </div>

            </div>

        </div>
    </div>
</section>

<!-- Shop on Amazon Banner Section -->
<?php get_template_part('template-parts/content', 'amazon-banner'); ?>

<?php
get_footer();
