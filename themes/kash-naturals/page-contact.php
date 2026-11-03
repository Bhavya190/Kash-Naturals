<?php
/**
 * Template Name: Contact Us Page
 *
 * @package KashNaturals
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();

$theme_uri = get_template_directory_uri();
$post_id   = get_the_ID();

// Helper to retrieve meta or theme_mod or default fallback
$kash_get = function($key, $default = '') use ($post_id) {
    if ($post_id) {
        $meta = get_post_meta($post_id, '_kash_' . $key, true);
        if ($meta !== '' && $meta !== false) {
            return $meta;
        }
    }
    return get_theme_mod('kash_' . $key, $default);
};

// 1. Header Section
$header_sub     = $kash_get('contact_header_subtitle', "WE'RE HERE TO HELP YOU • GET IN TOUCH WITH US");
$header_title   = $kash_get('contact_header_title', 'Contact Kash Natural');

// 2. Card 1: Phone & WhatsApp
$phone_title    = $kash_get('contact_phone_title', 'Call & WhatsApp');
$phone          = $kash_get('contact_phone', '+91 98765 43210');
$timing         = $kash_get('contact_phone_timing', 'Mon - Sat: 10:00 AM - 7:00 PM');
$phone_clean    = preg_replace('/[^0-9+]/', '', $phone);

// 3. Card 2: Email Support
$email_title    = $kash_get('contact_email_title', 'Email Support');
$email          = $kash_get('contact_email', 'info@kashnatural.com');
$sec_email      = $kash_get('contact_secondary_email', 'support@kashnatural.com');

// 4. Card 3: Corporate & Bulk Orders
$bulk_title     = $kash_get('contact_bulk_title', 'Corporate & Bulk Orders');
$bulk_email     = $kash_get('contact_bulk_email', 'b2b@kashnatural.com');
$bulk_sub       = $kash_get('contact_bulk_sub', 'Custom Branding & Hampers');

// 5. Card 4: Headquarters
$hq_title       = $kash_get('contact_hq_title', 'Headquarters');
$hq_address     = $kash_get('contact_hq_address', 'Surat, Gujarat, India');
$hq_sub         = $kash_get('contact_hq_sub', 'Pan India Insulated Shipping');

// 6. WhatsApp Direct Chat
$wa_num_raw     = $kash_get('whatsapp_number', '919876543210');
$wa_digits      = preg_replace('/[^0-9]/', '', $wa_num_raw);
if (strlen($wa_digits) === 10) {
    $wa_digits = '91' . $wa_digits;
}
$wa_prefill     = $kash_get('whatsapp_prefill_text', 'Hi Kash Natural, I have an inquiry');
$wa_url         = 'https://wa.me/' . ($wa_digits ?: '919876543210') . '?text=' . rawurlencode($wa_prefill);
$wa_card_title  = $kash_get('contact_wa_card_title', 'Need Instant Help?');
$wa_card_desc   = $kash_get('contact_wa_card_desc', 'Chat directly with our support team on WhatsApp for quick order assistance and inquiries.');
$wa_btn_text    = $kash_get('contact_wa_btn_text', 'CHAT ON WHATSAPP');

// 7. Contact Form
$form_badge     = $kash_get('contact_form_badge', 'SEND A MESSAGE');
$form_heading   = $kash_get('contact_form_heading', 'How Can We Help You?');
$form_subtext   = $kash_get('contact_form_subtext', 'Have questions about our products, order status, or custom gifts? Fill out the form below and our team will get back to you promptly.');

// 8. Map Section
$map_title      = $kash_get('contact_map_title', 'Pan-India Distribution & Support Hub');
$map_subtitle   = $kash_get('contact_map_subtitle', 'Delivering freshness from Surat to every state across India');
$map_badge      = $kash_get('contact_map_badge', 'All Pincodes Active');
$map_iframe     = $kash_get('contact_map_iframe', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d119066.41709425492!2d72.75225624794274!3d21.16102683501712!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3be04e59411d1563%3A0xfe4558290938b042!2sSurat%2C%20Gujarat!5e0!3m2!1sen!2sin!4v1700000000000!5m2!1sen!2sin');
?>

<!-- Page Header Banner -->
<div class="contact-page-header">
    <div class="container text-center">
        <span class="contact-header-subtitle"><?php echo esc_html($header_sub); ?></span>
        <h1 class="contact-header-title"><?php echo esc_html($header_title); ?></h1>
        <div class="contact-breadcrumb">
            <a href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('Home', 'kash-naturals'); ?></a>
            <span class="sep">/</span>
            <span class="current"><?php esc_html_e('Contact Us', 'kash-naturals'); ?></span>
        </div>
    </div>
</div>

<!-- Interactive Contact Info Cards Bar -->
<section class="contact-info-section">
    <div class="container">
        <div class="contact-cards-grid">
            
            <!-- Card 1: Call & Phone -->
            <a href="tel:<?php echo esc_attr($phone_clean); ?>" class="contact-info-card-exact">
                <div class="contact-card-icon">
                    <i class="fa-solid fa-phone-volume"></i>
                </div>
                <div class="contact-card-body">
                    <h3 class="contact-card-title"><?php echo esc_html($phone_title); ?></h3>
                    <p class="contact-card-detail"><?php echo esc_html($phone); ?></p>
                    <span class="contact-card-sub"><?php echo esc_html($timing); ?></span>
                </div>
            </a>

            <!-- Card 2: Email -->
            <a href="mailto:<?php echo esc_attr($email); ?>" class="contact-info-card-exact">
                <div class="contact-card-icon">
                    <i class="fa-solid fa-envelope-open-text"></i>
                </div>
                <div class="contact-card-body">
                    <h3 class="contact-card-title"><?php echo esc_html($email_title); ?></h3>
                    <p class="contact-card-detail"><?php echo esc_html($email); ?></p>
                    <span class="contact-card-sub"><?php echo esc_html($sec_email); ?></span>
                </div>
            </a>

            <!-- Card 3: Corporate & B2B -->
            <a href="mailto:<?php echo esc_attr($bulk_email); ?>" class="contact-info-card-exact">
                <div class="contact-card-icon">
                    <i class="fa-solid fa-gift"></i>
                </div>
                <div class="contact-card-body">
                    <h3 class="contact-card-title"><?php echo esc_html($bulk_title); ?></h3>
                    <p class="contact-card-detail"><?php echo esc_html($bulk_email); ?></p>
                    <span class="contact-card-sub"><?php echo esc_html($bulk_sub); ?></span>
                </div>
            </a>

            <!-- Card 4: Headquarters -->
            <div class="contact-info-card-exact">
                <div class="contact-card-icon">
                    <i class="fa-solid fa-location-dot"></i>
                </div>
                <div class="contact-card-body">
                    <h3 class="contact-card-title"><?php echo esc_html($hq_title); ?></h3>
                    <p class="contact-card-detail"><?php echo esc_html($hq_address); ?></p>
                    <span class="contact-card-sub"><?php echo esc_html($hq_sub); ?></span>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Main Contact Form & FAQ Section -->
<section class="contact-main-section">
    <div class="container">
        <div class="contact-main-grid">
            
            <!-- Left: Interactive Contact Form -->
            <div class="contact-form-wrapper-exact">
                <div class="form-header-box">
                    <span class="form-badge"><?php echo esc_html($form_badge); ?></span>
                    <h2 class="form-heading"><?php echo esc_html($form_heading); ?></h2>
                    <p class="form-subtext">
                        <?php echo esc_html($form_subtext); ?>
                    </p>
                </div>

                <div id="form-success-alert" class="contact-success-alert" style="display: none;">
                    <i class="fa-solid fa-circle-check"></i>
                    <div>
                        <strong><?php esc_html_e('Thank you for reaching out!', 'kash-naturals'); ?></strong>
                        <span id="form-success-msg"><?php esc_html_e('Your message has been sent successfully. We will contact you shortly.', 'kash-naturals'); ?></span>
                    </div>
                </div>

                <div id="form-error-alert" class="contact-error-alert" style="display: none; background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; align-items: center; gap: 10px;">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <span id="form-error-msg"><?php esc_html_e('Something went wrong. Please try again.', 'kash-naturals'); ?></span>
                </div>

                <form id="kash-contact-form" class="kash-interactive-form">
                    <?php wp_nonce_field('kash_contact_nonce', 'contact_nonce'); ?>
                    <input type="hidden" name="action" value="kash_submit_contact">

                    <div class="form-row-2">
                        <div class="form-group-exact">
                            <label for="contact-name"><?php esc_html_e('Full Name *', 'kash-naturals'); ?></label>
                            <input type="text" id="contact-name" name="name" class="form-input-exact" placeholder="e.g. Rahul Sharma" required>
                        </div>
                        <div class="form-group-exact">
                            <label for="contact-email"><?php esc_html_e('Email Address *', 'kash-naturals'); ?></label>
                            <input type="email" id="contact-email" name="email" class="form-input-exact" placeholder="name@example.com" required>
                        </div>
                    </div>

                    <div class="form-row-2">
                        <div class="form-group-exact">
                            <label for="contact-phone"><?php esc_html_e('Phone Number', 'kash-naturals'); ?></label>
                            <input type="tel" id="contact-phone" name="phone" class="form-input-exact" placeholder="<?php echo esc_attr($phone); ?>">
                        </div>
                        <div class="form-group-exact">
                            <label for="contact-subject"><?php esc_html_e('Inquiry Subject', 'kash-naturals'); ?></label>
                            <select id="contact-subject" name="subject" class="form-select-exact">
                                <option value="general"><?php esc_html_e('General Inquiry', 'kash-naturals'); ?></option>
                                <option value="order"><?php esc_html_e('Order Status & Shipping', 'kash-naturals'); ?></option>
                                <option value="bulk"><?php esc_html_e('Corporate / Bulk Orders', 'kash-naturals'); ?></option>
                                <option value="feedback"><?php esc_html_e('Product Feedback', 'kash-naturals'); ?></option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group-exact">
                        <label for="contact-message"><?php esc_html_e('Your Message *', 'kash-naturals'); ?></label>
                        <textarea id="contact-message" name="message" class="form-textarea-exact" rows="5" placeholder="<?php esc_attr_e('Write your query or requirements here...', 'kash-naturals'); ?>" required></textarea>
                    </div>

                    <div class="form-submit-row">
                        <button type="submit" id="btn-contact-submit" class="btn-contact-submit-exact">
                            <i class="fa-solid fa-paper-plane"></i>
                            <span id="btn-contact-submit-text"><?php esc_html_e('SEND MESSAGE', 'kash-naturals'); ?></span>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Right: Interactive FAQ & Quick WhatsApp Card -->
            <div class="contact-sidebar-wrapper">
                
                <!-- Quick WhatsApp Support Card -->
                <div class="whatsapp-support-card">
                    <div class="whatsapp-card-icon">
                        <i class="fa-brands fa-whatsapp"></i>
                    </div>
                    <div class="whatsapp-card-content">
                        <h3><?php echo esc_html($wa_card_title); ?></h3>
                        <p><?php echo esc_html($wa_card_desc); ?></p>
                        <a href="<?php echo esc_url($wa_url); ?>" target="_blank" rel="noopener noreferrer" class="btn-whatsapp-chat">
                            <i class="fa-brands fa-whatsapp"></i>
                            <span><?php echo esc_html($wa_btn_text); ?></span>
                        </a>
                    </div>
                </div>

                <!-- Interactive FAQ Accordion -->
                <div class="contact-faq-wrapper">
                    <h3 class="faq-section-title"><?php esc_html_e('Frequently Asked Questions', 'kash-naturals'); ?></h3>
                    
                    <div class="faq-accordion-container">
                        
                        <details class="faq-item" open>
                            <summary class="faq-question">
                                <span><?php esc_html_e('How long does shipping take across India?', 'kash-naturals'); ?></span>
                                <i class="fa-solid fa-chevron-down faq-icon"></i>
                            </summary>
                            <div class="faq-answer">
                                <p><?php esc_html_e('We process all orders within 24 hours. Delivery takes 2 to 4 business days across India using temperature-controlled insulated packaging to prevent melting.', 'kash-naturals'); ?></p>
                            </div>
                        </details>

                        <details class="faq-item">
                            <summary class="faq-question">
                                <span><?php esc_html_e('Do you offer corporate gift hampers?', 'kash-naturals'); ?></span>
                                <i class="fa-solid fa-chevron-down faq-icon"></i>
                            </summary>
                            <div class="faq-answer">
                                <p><?php esc_html_e('Yes! We offer custom-branded gift boxes, corporate mukhwas jars, and festive hampers with special bulk discounts.', 'kash-naturals'); ?></p>
                            </div>
                        </details>

                        <details class="faq-item">
                            <summary class="faq-question">
                                <span><?php esc_html_e('Where can I buy Kash Natural products?', 'kash-naturals'); ?></span>
                                <i class="fa-solid fa-chevron-down faq-icon"></i>
                            </summary>
                            <div class="faq-answer">
                                <p><?php esc_html_e('You can purchase directly on our website or order through our official store on Amazon India for fast delivery.', 'kash-naturals'); ?></p>
                            </div>
                        </details>

                    </div>
                </div>

            </div>

        </div>
    </div>
</section>

<!-- Interactive Location Map Section -->
<section class="contact-map-section">
    <div class="container">
        <div class="map-card-container">
            <div class="map-header-bar">
                <div class="map-header-left">
                    <i class="fa-solid fa-map-location-dot"></i>
                    <div>
                        <h4><?php echo esc_html($map_title); ?></h4>
                        <p><?php echo esc_html($map_subtitle); ?></p>
                    </div>
                </div>
                <div class="map-header-right">
                    <span class="delivery-status-badge">
                        <i class="fa-solid fa-circle-check"></i> <?php echo esc_html($map_badge); ?>
                    </span>
                </div>
            </div>

            <div class="map-iframe-box">
                <iframe 
                    title="Kash Natural Location Map"
                    src="<?php echo esc_url($map_iframe); ?>" 
                    width="100%" 
                    height="380" 
                    style="border:0;" 
                    allowfullscreen="" 
                    loading="lazy" 
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        </div>
    </div>
</section>

<!-- Shop on Amazon Banner Section -->
<?php get_template_part('template-parts/content', 'amazon-banner'); ?>

<?php
get_footer();
