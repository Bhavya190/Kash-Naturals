<?php
/**
 * Shop on Amazon Horizontal Banner Template Part
 * Clean, Crisp Product Showcase matching reference design
 *
 * @package KashNaturals
 */

if (!defined('ABSPATH')) {
    exit;
}

$theme_uri   = get_template_directory_uri();
$amazon_link = get_theme_mod('kash_amazon_shop_link', 'https://amazon.in');

$amazon_logo = $theme_uri . '/assets/images/amazon-a-logo.png';
$jar_img1    = $theme_uri . '/assets/images/jar-royal-mukhwas.jpg';
$combo_img   = $theme_uri . '/assets/images/combo-premium.jpg';
?>

<section class="amz-horizontal-section" id="amazon-store">
    <div class="container">
        
        <!-- Main Horizontal Banner Container -->
        <div class="amz-ref-banner-card">
            
            <!-- Left White Curved Arch Area -->
            <div class="amz-banner-left-arch">
                
                <!-- Amazon Logo Header -->
                <div class="amz-logo-header">
                    <img src="<?php echo esc_url($amazon_logo); ?>" alt="Amazon Prime" class="amz-ref-logo">
                    <span class="amz-prime-badge"><i class="fa-brands fa-amazon"></i> prime</span>
                </div>

                <!-- Main Bold Headline -->
                <h2 class="amz-ref-headline">
                    Shop Kash Naturals, <br>
                    <span class="amz-text-green">Available on Amazon</span>
                </h2>

                <!-- Subtext -->
                <p class="amz-ref-subtext">
                    Free &amp; fast Prime delivery, 100% natural ingredients, exclusive deals &amp; secure payments.
                </p>

                <!-- Action Button -->
                <div class="amz-ref-cta">
                    <a href="<?php echo esc_url($amazon_link); ?>" target="_blank" rel="noopener noreferrer" class="btn-amz-ref-pill">
                        Shop on Amazon <i class="fa-solid fa-arrow-right ms-2"></i>
                    </a>
                </div>

            </div>

            <!-- Right Sage Green Product Showcase Area -->
            <div class="amz-banner-right-showcase">
                <div class="amz-showcase-grid">
                    
                    <!-- Main Combo Box Card -->
                    <div class="amz-showcase-card amz-card-main">
                        <img src="<?php echo esc_url($combo_img); ?>" alt="Kash Naturals Premium Combo" class="amz-showcase-img">
                        <span class="amz-img-label">Bestselling Combo</span>
                    </div>

                    <!-- Secondary Jar Card -->
                    <div class="amz-showcase-card amz-card-secondary">
                        <img src="<?php echo esc_url($jar_img1); ?>" alt="Royal Mukhwas Jar" class="amz-showcase-img">
                        <span class="amz-img-label">Royal Mukhwas</span>
                    </div>

                </div>
            </div>

        </div>

    </div>
</section>
