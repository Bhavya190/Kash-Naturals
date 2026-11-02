<?php
/**
 * Template Name: Bulk Order Page
 *
 * @package KashNaturals
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();

$theme_uri = get_template_directory_uri();
?>

<!-- Page Banner Header -->
<div class="combos-page-header">
    <div class="container text-center">
        <span class="combos-header-subtitle"><?php esc_html_e('CORPORATE GIFTING • WEDDING FAVORS • CUSTOM PACKAGING', 'kash-naturals'); ?></span>
        <h1 class="combos-header-title"><?php esc_html_e('Bulk & Corporate Orders', 'kash-naturals'); ?></h1>
        <div class="combos-breadcrumb">
            <a href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('Home', 'kash-naturals'); ?></a>
            <span class="sep">/</span>
            <span class="current"><?php esc_html_e('Bulk Order', 'kash-naturals'); ?></span>
        </div>
    </div>
</div>

<!-- Bulk Order Value Pillars Bar -->
<section class="combos-value-bar">
    <div class="container combos-value-grid">
        <div class="value-item">
            <div class="value-icon"><i class="fa-solid fa-building"></i></div>
            <div class="value-text">
                <h4><?php esc_html_e('Corporate Gifting', 'kash-naturals'); ?></h4>
                <p><?php esc_html_e('Custom branded gift boxes with your company logo & greeting cards', 'kash-naturals'); ?></p>
            </div>
        </div>
        <div class="value-item">
            <div class="value-icon"><i class="fa-solid fa-champagne-glasses"></i></div>
            <div class="value-text">
                <h4><?php esc_html_e('Wedding & Event Favors', 'kash-naturals'); ?></h4>
                <p><?php esc_html_e('Artisanal luxury mukhwas & chocolate dragee jars for your guests', 'kash-naturals'); ?></p>
            </div>
        </div>
        <div class="value-item">
            <div class="value-icon"><i class="fa-solid fa-tags"></i></div>
            <div class="value-text">
                <h4><?php esc_html_e('Tiered Volume Discounts', 'kash-naturals'); ?></h4>
                <p><?php esc_html_e('Direct manufacturer pricing with up to 40% bulk order savings', 'kash-naturals'); ?></p>
            </div>
        </div>
        <div class="value-item">
            <div class="value-icon"><i class="fa-solid fa-truck-fast"></i></div>
            <div class="value-text">
                <h4><?php esc_html_e('Pan India Express Delivery', 'kash-naturals'); ?></h4>
                <p><?php esc_html_e('Multi-address direct dispatch or single-destination bulk pallets', 'kash-naturals'); ?></p>
            </div>
        </div>
    </div>
</section>

<!-- Main Bulk Order Inquiry Section -->
<section class="contact-main-section">
    <div class="container">
        <div class="contact-main-grid">

            <!-- Left: Interactive Bulk Inquiry Form -->
            <div class="contact-form-wrapper-exact">
                <div class="form-header-box">
                    <span class="form-badge"><?php esc_html_e('BULK & B2B INQUIRY', 'kash-naturals'); ?></span>
                    <h2 class="form-heading"><?php esc_html_e('Request a Custom Bulk Quote', 'kash-naturals'); ?></h2>
                    <p class="form-subtext">
                        <?php esc_html_e('Whether you are planning festive corporate gifts, wedding favors, or retail distribution, our gifting concierges will create a personalized proposal for you within 24 hours.', 'kash-naturals'); ?>
                    </p>
                </div>

                <div id="bulk-form-success" class="contact-success-alert" style="display: none;">
                    <i class="fa-solid fa-circle-check"></i>
                    <div>
                        <strong><?php esc_html_e('Bulk inquiry submitted successfully! 🎉', 'kash-naturals'); ?></strong>
                        <span><?php esc_html_e('Our B2B gifting specialist will reach out with samples, catalog, and wholesale pricing shortly.', 'kash-naturals'); ?></span>
                    </div>
                </div>

                <form id="kash-bulk-order-form" class="kash-interactive-form" onsubmit="event.preventDefault(); document.getElementById('bulk-form-success').style.display = 'flex'; this.reset();">
                    <div class="form-row-2">
                        <div class="form-group-exact">
                            <label for="bulk-name"><?php esc_html_e('Full Name *', 'kash-naturals'); ?></label>
                            <input type="text" id="bulk-name" class="form-input-exact" placeholder="e.g. Vikram Mehta" required>
                        </div>
                        <div class="form-group-exact">
                            <label for="bulk-company"><?php esc_html_e('Company / Event Name', 'kash-naturals'); ?></label>
                            <input type="text" id="bulk-company" class="form-input-exact" placeholder="e.g. Acme Corp / Sharma Wedding">
                        </div>
                    </div>

                    <div class="form-row-2">
                        <div class="form-group-exact">
                            <label for="bulk-email"><?php esc_html_e('Email Address *', 'kash-naturals'); ?></label>
                            <input type="email" id="bulk-email" class="form-input-exact" placeholder="name@company.com" required>
                        </div>
                        <div class="form-group-exact">
                            <label for="bulk-phone"><?php esc_html_e('Phone / WhatsApp Number *', 'kash-naturals'); ?></label>
                            <input type="tel" id="bulk-phone" class="form-input-exact" placeholder="+91 98765 43210" required>
                        </div>
                    </div>

                    <div class="form-row-2">
                        <div class="form-group-exact">
                            <label for="bulk-category"><?php esc_html_e('Product Category of Interest', 'kash-naturals'); ?></label>
                            <select id="bulk-category" class="form-select-exact">
                                <option value="mukhwas"><?php esc_html_e('Mukhwas & Mouth Fresheners', 'kash-naturals'); ?></option>
                                <option value="chocolates"><?php esc_html_e('Artisanal Chocolates & Dragees', 'kash-naturals'); ?></option>
                                <option value="dry-fruits"><?php esc_html_e('Dry Fruits & Roasted Seeds', 'kash-naturals'); ?></option>
                                <option value="gift-hampers"><?php esc_html_e('Curated Luxury Gift Hampers', 'kash-naturals'); ?></option>
                                <option value="combos"><?php esc_html_e('Deal Combos & Value Packs', 'kash-naturals'); ?></option>
                                <option value="custom"><?php esc_html_e('Custom Mix / Multiple Categories', 'kash-naturals'); ?></option>
                            </select>
                        </div>
                        <div class="form-group-exact">
                            <label for="bulk-qty"><?php esc_html_e('Estimated Quantity (Units/Boxes)', 'kash-naturals'); ?></label>
                            <select id="bulk-qty" class="form-select-exact">
                                <option value="25-50">25 - 50 Units</option>
                                <option value="50-100">50 - 100 Units</option>
                                <option value="100-250">100 - 250 Units</option>
                                <option value="250-500">250 - 500 Units</option>
                                <option value="500-1000">500 - 1,000 Units</option>
                                <option value="1000+">1,000+ Units (Enterprise)</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row-2">
                        <div class="form-group-exact">
                            <label for="bulk-pincode"><?php esc_html_e('Delivery Pincode / City', 'kash-naturals'); ?></label>
                            <input type="text" id="bulk-pincode" class="form-input-exact" placeholder="e.g. 110001 / New Delhi">
                        </div>
                        <div class="form-group-exact">
                            <label for="bulk-date"><?php esc_html_e('Target Delivery Date', 'kash-naturals'); ?></label>
                            <input type="date" id="bulk-date" class="form-input-exact">
                        </div>
                    </div>

                    <div class="form-group-exact">
                        <label for="bulk-message"><?php esc_html_e('Special Customization & Requirements', 'kash-naturals'); ?></label>
                        <textarea id="bulk-message" class="form-textarea-exact" rows="4" placeholder="<?php esc_attr_e('Mention any custom branding, ribbon colors, specific flavors, or gift card messages you need...', 'kash-naturals'); ?>"></textarea>
                    </div>

                    <button type="submit" class="contact-submit-btn-exact">
                        <span><?php esc_html_e('SUBMIT BULK INQUIRY', 'kash-naturals'); ?></span>
                        <i class="fa-solid fa-paper-plane"></i>
                    </button>
                </form>
            </div>

            <!-- Right: Corporate Gifting Concierge Info -->
            <div class="contact-sidebar-exact">
                <div class="contact-sidebar-card">
                    <span class="sidebar-tag"><?php esc_html_e('DIRECT DESK', 'kash-naturals'); ?></span>
                    <h3 class="sidebar-title"><?php esc_html_e('Corporate Gifting Concierge', 'kash-naturals'); ?></h3>
                    <p class="sidebar-desc">
                        <?php esc_html_e('Need quick assistance or sample kits for corporate review? Contact our dedicated B2B desk directly.', 'kash-naturals'); ?>
                    </p>

                    <div class="sidebar-contact-list">
                        <a href="tel:+919876543210" class="sidebar-contact-item">
                            <i class="fa-solid fa-phone"></i>
                            <div>
                                <span class="label"><?php esc_html_e('Call Direct', 'kash-naturals'); ?></span>
                                <span class="val">+91 98765 43210</span>
                            </div>
                        </a>
                        <a href="https://wa.me/919876543210?text=Hi%2C%20I%20would%20like%20to%20inquire%20about%20bulk%20orders%20at%20Kash%20Natural" target="_blank" rel="noopener noreferrer" class="sidebar-contact-item">
                            <i class="fa-brands fa-whatsapp"></i>
                            <div>
                                <span class="label"><?php esc_html_e('WhatsApp Inquiry', 'kash-naturals'); ?></span>
                                <span class="val">+91 98765 43210</span>
                            </div>
                        </a>
                        <a href="mailto:b2b@kashnatural.com" class="sidebar-contact-item">
                            <i class="fa-solid fa-envelope"></i>
                            <div>
                                <span class="label"><?php esc_html_e('B2B Email Desk', 'kash-naturals'); ?></span>
                                <span class="val">b2b@kashnatural.com</span>
                            </div>
                        </a>
                    </div>

                    <div class="sidebar-trust-box" style="margin-top: 25px; padding-top: 20px; border-top: 1px solid rgba(0,0,0,0.08);">
                        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 10px; color: #0b381e; font-weight: 600; font-size: 0.9rem;">
                            <i class="fa-solid fa-award" style="color: #ed8e00;"></i>
                            <span><?php esc_html_e('100% Food-Grade Hygienic Packaging', 'kash-naturals'); ?></span>
                        </div>
                        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 10px; color: #0b381e; font-weight: 600; font-size: 0.9rem;">
                            <i class="fa-solid fa-file-invoice" style="color: #ed8e00;"></i>
                            <span><?php esc_html_e('GST Invoicing & Input Tax Credit', 'kash-naturals'); ?></span>
                        </div>
                        <div style="display: flex; align-items: center; gap: 10px; color: #0b381e; font-weight: 600; font-size: 0.9rem;">
                            <i class="fa-solid fa-box-open" style="color: #ed8e00;"></i>
                            <span><?php esc_html_e('Sample Tasting Kits on Request', 'kash-naturals'); ?></span>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <?php
        // If content was entered in WordPress Editor for this page, display it here
        if (have_posts()) :
            while (have_posts()) : the_post();
                $page_content = get_the_content();
                if (!empty(trim(strip_tags($page_content)))) :
                    echo '<div class="entry-content mt-5" style="background:#fff; border-radius:12px; padding:30px; box-shadow:0 4px 15px rgba(0,0,0,0.04);">';
                    the_content();
                    echo '</div>';
                endif;
            endwhile;
        endif;
        ?>

    </div>
</section>

<?php
get_footer();
