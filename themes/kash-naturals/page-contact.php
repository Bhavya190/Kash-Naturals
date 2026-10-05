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
?>

<div class="page-header-banner">
    <h1 class="page-banner-title"><?php the_title(); ?></h1>
    <div class="breadcrumb-links">
        <a href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('Home', 'kash-naturals'); ?></a> &nbsp;&nbsp;/&nbsp;&nbsp; <span><?php the_title(); ?></span>
    </div>
</div>

<div class="contact-section-grid">
    <!-- Info Card -->
    <div class="contact-info-card">
        <h2 style="font-family: 'Playfair Display', serif; color: #0a331a; margin-top: 0; margin-bottom: 25px;"><?php esc_html_e('Get In Touch', 'kash-naturals'); ?></h2>
        <p style="color: #555; line-height: 1.6; margin-bottom: 35px;">
            <?php esc_html_e('Have questions about our artisanal mouth fresheners, chocolate dragees, or custom combo orders? Send us a message and our team will get back to you promptly.', 'kash-naturals'); ?>
        </p>
        
        <div class="info-item">
            <div class="info-icon-box"><i class="fa-solid fa-phone"></i></div>
            <div class="info-text">
                <h4><?php esc_html_e('Customer Care Phone', 'kash-naturals'); ?></h4>
                <p>+91 98765 43210<br><small style="color: #777;"><?php esc_html_e('Mon - Sat (9:30 AM - 6:30 PM)', 'kash-naturals'); ?></small></p>
            </div>
        </div>

        <div class="info-item">
            <div class="info-icon-box"><i class="fa-solid fa-envelope"></i></div>
            <div class="info-text">
                <h4><?php esc_html_e('Email Support', 'kash-naturals'); ?></h4>
                <p>info@kashnatural.com<br>support@kashnatural.com</p>
            </div>
        </div>

        <div class="info-item">
            <div class="info-icon-box"><i class="fa-solid fa-location-dot"></i></div>
            <div class="info-text">
                <h4><?php esc_html_e('Headquarters & Facility', 'kash-naturals'); ?></h4>
                <p><?php esc_html_e('Kash Natural Confectionery Works, Industrial Estate, New Delhi, India 110020', 'kash-naturals'); ?></p>
            </div>
        </div>
    </div>

    <!-- Form Card -->
    <div class="contact-form-card">
        <h2 style="font-family: 'Playfair Display', serif; color: #0a331a; margin-top: 0; margin-bottom: 25px;"><?php esc_html_e('Send Us a Message', 'kash-naturals'); ?></h2>
        <form onsubmit="event.preventDefault(); alert('Thank you for contacting Kash Natural!');">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                <div class="form-group">
                    <label><?php esc_html_e('Your Name *', 'kash-naturals'); ?></label>
                    <input type="text" class="form-control" required>
                </div>
                <div class="form-group">
                    <label><?php esc_html_e('Email Address *', 'kash-naturals'); ?></label>
                    <input type="email" class="form-control" required>
                </div>
            </div>

            <div class="form-group">
                <label><?php esc_html_e('Phone Number', 'kash-naturals'); ?></label>
                <input type="tel" class="form-control">
            </div>

            <div class="form-group">
                <label><?php esc_html_e('Message *', 'kash-naturals'); ?></label>
                <textarea class="form-control" rows="5" required></textarea>
            </div>

            <button type="submit" class="btn-submit-contact"><?php esc_html_e('SEND MESSAGE', 'kash-naturals'); ?></button>
        </form>
    </div>
</div>

<?php
get_footer();
