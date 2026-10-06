<?php
/**
 * Template Name: About Us Page
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
<div class="about-page-header">
    <div class="container text-center">
        <span class="about-header-subtitle"><?php esc_html_e('AUTHENTIC • NATURAL • HYGIENIC', 'kash-naturals'); ?></span>
        <h1 class="about-header-title"><?php esc_html_e('About Kash Natural', 'kash-naturals'); ?></h1>
        <div class="about-breadcrumb">
            <a href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('Home', 'kash-naturals'); ?></a>
            <span class="sep">/</span>
            <span class="current"><?php esc_html_e('About Us', 'kash-naturals'); ?></span>
        </div>
    </div>
</div>

<!-- Main About Hero Story Section -->
<section class="about-hero-section">
    <div class="container">
        <div class="about-hero-grid">
            
            <!-- Left Text Column -->
            <div class="about-hero-content">
                <div class="section-badge-gold">
                    <span><?php esc_html_e('OUR HERITAGE & MISSION', 'kash-naturals'); ?></span>
                    <span class="badge-line"></span>
                </div>
                <h2 class="about-hero-heading">
                    <?php esc_html_e('Freshness & Taste Crafted by Nature', 'kash-naturals'); ?>
                </h2>
                <p class="about-hero-lead">
                    <?php esc_html_e('Kash Natural was founded with a singular mission: to bring authentic, premium mouth fresheners, artisanal chocolate dragees, and Middle Eastern inspired kunafa delights to every Indian household.', 'kash-naturals'); ?>
                </p>
                <p class="about-hero-desc">
                    <?php esc_html_e('We carefully select the finest natural ingredients — from aromatic aniseeds and betel nut paan mixes to rich cocoa and roasted nuts — preparing each batch under strict hygienic conditions. Every jar represents our dedication to purity, taste, and long-lasting aroma.', 'kash-naturals'); ?>
                </p>

                <!-- Key Metrics / Stats Row -->
                <div class="about-stats-row">
                    <div class="stat-item">
                        <span class="stat-number">100%</span>
                        <span class="stat-label"><?php esc_html_e('Natural & Herbal', 'kash-naturals'); ?></span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">50,000+</span>
                        <span class="stat-label"><?php esc_html_e('Happy Customers', 'kash-naturals'); ?></span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">15+</span>
                        <span class="stat-label"><?php esc_html_e('Signature Blends', 'kash-naturals'); ?></span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">Pan India</span>
                        <span class="stat-label"><?php esc_html_e('Cold Delivery', 'kash-naturals'); ?></span>
                    </div>
                </div>
            </div>

            <!-- Right Image Column -->
            <div class="about-hero-media">
                <div class="about-img-frame">
                    <img src="<?php echo esc_url($theme_uri . '/assets/images/jar-royal-mukhwas.jpg'); ?>" alt="Kash Natural Craftsmanship" class="about-main-img">
                    <div class="about-floating-badge">
                        <i class="fa-solid fa-leaf"></i>
                        <div>
                            <strong><?php esc_html_e('100% Purity Guaranteed', 'kash-naturals'); ?></strong>
                            <span><?php esc_html_e('Zero Artificial Preservatives', 'kash-naturals'); ?></span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Core Pillars Section -->
<section class="about-pillars-section">
    <div class="container">
        <div class="section-header text-center">
            <span class="section-subtitle-exact"><?php esc_html_e('WHY CHOOSE KASH NATURAL', 'kash-naturals'); ?></span>
            <h2 class="section-title-exact"><?php esc_html_e('Our Core Pillars of Quality', 'kash-naturals'); ?></h2>
            <div class="title-gold-divider"></div>
        </div>

        <div class="about-pillars-grid">
            
            <div class="about-pillar-card">
                <div class="pillar-icon-box">
                    <i class="fa-solid fa-leaf"></i>
                </div>
                <h3 class="pillar-card-title"><?php esc_html_e('100% Natural Sourcing', 'kash-naturals'); ?></h3>
                <p class="pillar-card-desc">
                    <?php esc_html_e('We source non-GMO spices, aromatic seeds, real dry fruits, and pure cacao without artificial additives or harsh preservatives.', 'kash-naturals'); ?>
                </p>
            </div>

            <div class="about-pillar-card">
                <div class="pillar-icon-box">
                    <i class="fa-solid fa-mortar-pestle"></i>
                </div>
                <h3 class="pillar-card-title"><?php esc_html_e('Artisan Master Blending', 'kash-naturals'); ?></h3>
                <p class="pillar-card-desc">
                    <?php esc_html_e('Small-batch recipes crafted by experienced connoisseurs ensuring long-lasting freshness, rich aroma, and authentic taste.', 'kash-naturals'); ?>
                </p>
            </div>

            <div class="about-pillar-card">
                <div class="pillar-icon-box">
                    <i class="fa-solid fa-shield-halved"></i>
                </div>
                <h3 class="pillar-card-title"><?php esc_html_e('Hygienic Glass Packaging', 'kash-naturals'); ?></h3>
                <p class="pillar-card-desc">
                    <?php esc_html_e('Sealed in food-grade airtight glass jars under strict cleanroom conditions to protect aroma and flavor from moisture.', 'kash-naturals'); ?>
                </p>
            </div>

            <div class="about-pillar-card">
                <div class="pillar-icon-box">
                    <i class="fa-solid fa-truck-fast"></i>
                </div>
                <h3 class="pillar-card-title"><?php esc_html_e('Pan-India Cold Delivery', 'kash-naturals'); ?></h3>
                <p class="pillar-card-desc">
                    <?php esc_html_e('Delivered across India with temperature-managed protective packaging to guarantee zero heat damage or melting.', 'kash-naturals'); ?>
                </p>
            </div>

        </div>
    </div>
</section>

<!-- Specialties Showcase Grid -->
<section class="about-specialties-section">
    <div class="container">
        <div class="section-header text-center">
            <span class="section-subtitle-exact"><?php esc_html_e('WHAT WE CRAFT', 'kash-naturals'); ?></span>
            <h2 class="section-title-exact"><?php esc_html_e('Our Signature Product Ranges', 'kash-naturals'); ?></h2>
            <div class="title-gold-divider"></div>
        </div>

        <div class="about-specialties-grid">
            
            <!-- Range 1 -->
            <div class="specialty-card">
                <div class="specialty-img-box">
                    <img src="<?php echo esc_url($theme_uri . '/assets/images/jar-calcutta-pan.jpg'); ?>" alt="Mouth Fresheners & Mukhwas">
                </div>
                <div class="specialty-content">
                    <span class="specialty-tag"><?php esc_html_e('MOUTH FRESHENERS', 'kash-naturals'); ?></span>
                    <h3 class="specialty-title"><?php esc_html_e('Royal Paan & Sweet Saunf Blends', 'kash-naturals'); ?></h3>
                    <p class="specialty-desc">
                        <?php esc_html_e('Traditional digestive mixes made with silver-coated cardamom, betel leaves, fennel, and real gulkand.', 'kash-naturals'); ?>
                    </p>
                </div>
            </div>

            <!-- Range 2 -->
            <div class="specialty-card">
                <div class="specialty-img-box">
                    <img src="<?php echo esc_url($theme_uri . '/assets/images/chocolate-dragees.jpg'); ?>" alt="Chocolate Dragees">
                </div>
                <div class="specialty-content">
                    <span class="specialty-tag"><?php esc_html_e('CHOCOLATE DRAGEES', 'kash-naturals'); ?></span>
                    <h3 class="specialty-title"><?php esc_html_e('Chocolate Coated Nuts & Berries', 'kash-naturals'); ?></h3>
                    <p class="specialty-desc">
                        <?php esc_html_e('Slow-roasted premium almonds and hazelnuts enrobed in smooth Belgian dark and milk chocolate.', 'kash-naturals'); ?>
                    </p>
                </div>
            </div>

            <!-- Range 3 -->
            <div class="specialty-card">
                <div class="specialty-img-box">
                    <img src="<?php echo esc_url($theme_uri . '/assets/images/kunafa-bars.jpg'); ?>" alt="Kunafa Bars & Gift Combos">
                </div>
                <div class="specialty-content">
                    <span class="specialty-tag"><?php esc_html_e('KUNAFA & GIFT COMBOS', 'kash-naturals'); ?></span>
                    <h3 class="specialty-title"><?php esc_html_e('Crunch Kunafa & Festive Hampers', 'kash-naturals'); ?></h3>
                    <p class="specialty-desc">
                        <?php esc_html_e('Exquisite crunch-filled pistachio kunafa chocolate bars and curated gift boxes for all celebrations.', 'kash-naturals'); ?>
                    </p>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Shop on Amazon Banner Section -->
<?php get_template_part('template-parts/content', 'amazon-banner'); ?>

<?php
get_footer();

