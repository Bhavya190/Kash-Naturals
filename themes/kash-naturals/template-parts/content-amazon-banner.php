<?php
/**
 * Shop on Amazon Banner Section Template Part (Matches Reference Screenshot Design)
 *
 * @package KashNaturals
 */

if (!defined('ABSPATH')) {
    exit;
}

$theme_uri = get_template_directory_uri();
$amazon_link = get_theme_mod('kash_amazon_shop_link', 'https://amazon.in');
?>

<section class="section-padding amazon-banner-section-exact">
    <div class="container">
        <div class="amazon-banner-card-exact">
            
            <!-- Left Area: App Icon + Headline + Subhead + Button -->
            <div class="amazon-banner-content-wrap">
                
                <!-- Amazon Badge Icon Box -->
                <div class="amazon-app-badge-box">
                    <svg class="amazon-badge-svg" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                        <rect width="100" height="100" rx="22" fill="#111111"/>
                        <g transform="translate(14, 10) scale(0.72)">
                            <!-- Official Amazon 'a' -->
                            <path d="M57.6 51.2c-2.4 1.8-6.1 2.8-9.4 2.8-6.7 0-9.8-3.4-9.8-8.2 0-6.7 5.7-10.2 16.5-10.2v-.4c0-2.3-1.6-3.8-5.3-3.8-3.4 0-6.9 1.1-9.4 2.6l-1.9-4.8c3.2-1.9 8.1-3.2 13-3.2 8.6 0 12.3 3.9 12.3 11.2v14.4c0 3 .9 4.3 2.5 4.3 1.2 0 2.3-.5 3.3-1.4l1.8 4.6c-2 2.1-4.8 3.3-8.3 3.3-4.2 0-7.1-2.5-7.3-6.8zm-2.5-10.7c-5.2 0-8.9 1.4-8.9 4.9 0 2.4 1.5 3.8 4.2 3.8 2.7 0 5.4-1.2 7-3.1v-5.6z" fill="#FFFFFF"/>
                            <!-- Official Amazon Smile Arrow -->
                            <path d="M22 68.5c11.8 6.5 29.8 8.4 43.8 1.5 1.9-.9 3.2 1.1 1.5 2.7-8.3 7.3-28.3 10.3-45.1-.4-1.6-1.1-.5-2.8 1.2-3.8z" fill="#FF9900"/>
                            <path d="M66.8 66.2c1.5-1.3 5.5-.9 7.2.7 1.7 1.6.7 5.5-1.1 6.7-1.5 1.2-4 0-4.8-1.1-.9-1.3-2.4-4.9-1.3-6.3z" fill="#FF9900"/>
                        </g>
                    </svg>
                </div>

                <!-- Text & Button -->
                <div class="amazon-banner-text-content">
                    <h2 class="amazon-banner-headline">
                        <?php esc_html_e('Shop Kash Natural on', 'kash-naturals'); ?> <span class="amazon-gold-text">Amazon</span>
                    </h2>
                    <p class="amazon-banner-subheadline">
                        <?php esc_html_e('with trusted delivery and secure payments.', 'kash-naturals'); ?>
                    </p>
                    <a href="<?php echo esc_url($amazon_link); ?>" target="_blank" rel="noopener noreferrer" class="btn-amazon-buy-now">
                        <?php esc_html_e('BUY ON AMAZON', 'kash-naturals'); ?>
                    </a>
                </div>

            </div>

            <!-- Right Showcase Product Image -->
            <div class="amazon-banner-image-wrap">
                <img src="<?php echo esc_url($theme_uri . '/assets/images/combo-premium.jpg'); ?>" alt="Shop Kash Natural on Amazon" class="amazon-banner-img" loading="lazy">
            </div>

        </div>
    </div>
</section>
