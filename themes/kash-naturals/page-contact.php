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
?>

<!-- Page Header Banner -->
<div class="contact-page-header">
    <div class="container text-center">
        <span class="contact-header-subtitle"><?php esc_html_e("WE'RE HERE TO HELP YOU • GET IN TOUCH WITH US", 'kash-naturals'); ?></span>
        <h1 class="contact-header-title"><?php esc_html_e('Contact Kash Natural', 'kash-naturals'); ?></h1>
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
            <a href="tel:+919876543210" class="contact-info-card-exact">
                <div class="contact-card-icon">
                    <i class="fa-solid fa-phone-volume"></i>
                </div>
                <div class="contact-card-body">
                    <h3 class="contact-card-title"><?php esc_html_e('Call & WhatsApp', 'kash-naturals'); ?></h3>
                    <p class="contact-card-detail">+91 98765 43210</p>
                    <span class="contact-card-sub"><?php esc_html_e('Mon - Sat: 10:00 AM - 7:00 PM', 'kash-naturals'); ?></span>
                </div>
            </a>

            <!-- Card 2: Email -->
            <a href="mailto:info@kashnatural.com" class="contact-info-card-exact">
                <div class="contact-card-icon">
                    <i class="fa-solid fa-envelope-open-text"></i>
                </div>
                <div class="contact-card-body">
                    <h3 class="contact-card-title"><?php esc_html_e('Email Support', 'kash-naturals'); ?></h3>
                    <p class="contact-card-detail">info@kashnatural.com</p>
                    <span class="contact-card-sub">support@kashnatural.com</span>
                </div>
            </a>

            <!-- Card 3: Corporate & B2B -->
            <a href="mailto:b2b@kashnatural.com" class="contact-info-card-exact">
                <div class="contact-card-icon">
                    <i class="fa-solid fa-gift"></i>
                </div>
                <div class="contact-card-body">
                    <h3 class="contact-card-title"><?php esc_html_e('Corporate & Bulk Orders', 'kash-naturals'); ?></h3>
                    <p class="contact-card-detail">b2b@kashnatural.com</p>
                    <span class="contact-card-sub"><?php esc_html_e('Custom Branding & Hampers', 'kash-naturals'); ?></span>
                </div>
            </a>

            <!-- Card 4: Headquarters -->
            <div class="contact-info-card-exact">
                <div class="contact-card-icon">
                    <i class="fa-solid fa-location-dot"></i>
                </div>
                <div class="contact-card-body">
                    <h3 class="contact-card-title"><?php esc_html_e('Headquarters', 'kash-naturals'); ?></h3>
                    <p class="contact-card-detail"><?php esc_html_e('Surat, Gujarat, India', 'kash-naturals'); ?></p>
                    <span class="contact-card-sub"><?php esc_html_e('Pan India Insulated Shipping', 'kash-naturals'); ?></span>
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
                    <span class="form-badge"><?php esc_html_e('SEND A MESSAGE', 'kash-naturals'); ?></span>
                    <h2 class="form-heading"><?php esc_html_e('How Can We Help You?', 'kash-naturals'); ?></h2>
                    <p class="form-subtext">
                        <?php esc_html_e('Have questions about our products, order status, or custom gifts? Fill out the form below and our team will get back to you promptly.', 'kash-naturals'); ?>
                    </p>
                </div>

                <div id="form-success-alert" class="contact-success-alert" style="display: none;">
                    <i class="fa-solid fa-circle-check"></i>
                    <div>
                        <strong><?php esc_html_e('Thank you for reaching out!', 'kash-naturals'); ?></strong>
                        <span><?php esc_html_e('Your message has been sent successfully. We will contact you shortly.', 'kash-naturals'); ?></span>
                    </div>
                </div>

                <form id="kash-contact-form" class="kash-interactive-form" onsubmit="event.preventDefault(); document.getElementById('form-success-alert').style.display = 'flex'; this.reset();">
                    <div class="form-row-2">
                        <div class="form-group-exact">
                            <label for="contact-name"><?php esc_html_e('Full Name *', 'kash-naturals'); ?></label>
                            <input type="text" id="contact-name" class="form-input-exact" placeholder="e.g. Rahul Sharma" required>
                        </div>
                        <div class="form-group-exact">
                            <label for="contact-email"><?php esc_html_e('Email Address *', 'kash-naturals'); ?></label>
                            <input type="email" id="contact-email" class="form-input-exact" placeholder="name@example.com" required>
                        </div>
                    </div>

                    <div class="form-row-2">
                        <div class="form-group-exact">
                            <label for="contact-phone"><?php esc_html_e('Phone Number', 'kash-naturals'); ?></label>
                            <input type="tel" id="contact-phone" class="form-input-exact" placeholder="+91 98765 43210">
                        </div>
                        <div class="form-group-exact">
                            <label for="contact-subject"><?php esc_html_e('Inquiry Subject', 'kash-naturals'); ?></label>
                            <select id="contact-subject" class="form-select-exact">
                                <option value="general"><?php esc_html_e('General Inquiry', 'kash-naturals'); ?></option>
                                <option value="order"><?php esc_html_e('Order Status & Shipping', 'kash-naturals'); ?></option>
                                <option value="bulk"><?php esc_html_e('Corporate / Bulk Orders', 'kash-naturals'); ?></option>
                                <option value="feedback"><?php esc_html_e('Product Feedback', 'kash-naturals'); ?></option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group-exact">
                        <label for="contact-message"><?php esc_html_e('Your Message *', 'kash-naturals'); ?></label>
                        <textarea id="contact-message" class="form-textarea-exact" rows="5" placeholder="<?php esc_attr_e('Write your query or requirements here...', 'kash-naturals'); ?>" required></textarea>
                    </div>

                    <div class="form-submit-row">
                        <button type="submit" class="btn-contact-submit-exact">
                            <i class="fa-solid fa-paper-plane"></i>
                            <span><?php esc_html_e('SEND MESSAGE', 'kash-naturals'); ?></span>
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
                        <h3><?php esc_html_e('Need Instant Help?', 'kash-naturals'); ?></h3>
                        <p><?php esc_html_e('Chat directly with our support team on WhatsApp for quick order assistance and inquiries.', 'kash-naturals'); ?></p>
                        <a href="https://wa.me/919876543210?text=Hi%20Kash%20Natural,%20I%20have%20an%20inquiry" target="_blank" rel="noopener noreferrer" class="btn-whatsapp-chat">
                            <i class="fa-brands fa-whatsapp"></i>
                            <span><?php esc_html_e('CHAT ON WHATSAPP', 'kash-naturals'); ?></span>
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
                        <h4><?php esc_html_e('Pan-India Distribution & Support Hub', 'kash-naturals'); ?></h4>
                        <p><?php esc_html_e('Delivering freshness from Surat to every state across India', 'kash-naturals'); ?></p>
                    </div>
                </div>
                <div class="map-header-right">
                    <span class="delivery-status-badge">
                        <i class="fa-solid fa-circle-check"></i> <?php esc_html_e('All Pincodes Active', 'kash-naturals'); ?>
                    </span>
                </div>
            </div>

            <div class="map-iframe-box">
                <iframe 
                    title="Kash Natural Location Map"
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d119066.41709425492!2d72.75225624794274!3d21.16102683501712!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3be04e59411d1563%3A0xfe4558290938b042!2sSurat%2C%20Gujarat!5e0!3m2!1sen!2sin!4v1700000000000!5m2!1sen!2sin" 
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

