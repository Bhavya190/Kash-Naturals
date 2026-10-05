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
?>

<div class="page-header-banner">
    <h1 class="page-banner-title"><?php the_title(); ?></h1>
    <div class="breadcrumb-links">
        <a href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('Home', 'kash-naturals'); ?></a> &nbsp;&nbsp;/&nbsp;&nbsp; <span><?php the_title(); ?></span>
    </div>
</div>

<div class="about-section">
    <div class="story-hero-grid">
        <div class="story-text" id="our-story">
            <h2><?php esc_html_e('Freshness Crafted by Nature', 'kash-naturals'); ?></h2>
            <p>
                <?php esc_html_e('Kash Natural was founded with a singular mission: to bring authentic, premium mouth fresheners, artisanal chocolate dragees, and Middle Eastern inspired kunafa delights to every Indian household.', 'kash-naturals'); ?>
            </p>
            <p>
                <?php esc_html_e('We carefully select the finest natural ingredients — from aromatic aniseeds and betel nut paan mixes to rich cocoa and roasted nuts — preparing each batch under strict hygienic conditions.', 'kash-naturals'); ?>
            </p>
        </div>
        <div>
            <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/hero-banner.jpg'); ?>" alt="Kash Natural Craftsmanship" style="width: 100%; border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
        </div>
    </div>

    <!-- Pillars -->
    <h2 style="font-family: 'Playfair Display', serif; text-align: center; color: #0a331a; font-size: 2.3rem;" id="quality"><?php esc_html_e('Our Core Pillars', 'kash-naturals'); ?></h2>
    <div class="pillars-grid">
        <div class="pillar-card">
            <div class="pillar-icon"><i class="fa-solid fa-leaf"></i></div>
            <div class="pillar-title"><?php esc_html_e('100% Natural', 'kash-naturals'); ?></div>
            <div class="pillar-desc"><?php esc_html_e('Carefully selected herbal ingredients, spices, and premium cacao without artificial additives.', 'kash-naturals'); ?></div>
        </div>
        <div class="pillar-card">
            <div class="pillar-icon"><i class="fa-solid fa-spa"></i></div>
            <div class="pillar-title"><?php esc_html_e('Hygienic Process', 'kash-naturals'); ?></div>
            <div class="pillar-desc"><?php esc_html_e('Manufactured in state-of-the-art hygienic facilities following strict safety protocols.', 'kash-naturals'); ?></div>
        </div>
        <div class="pillar-card">
            <div class="pillar-icon"><i class="fa-solid fa-award"></i></div>
            <div class="pillar-title"><?php esc_html_e('Master Quality', 'kash-naturals'); ?></div>
            <div class="pillar-desc"><?php esc_html_e('Small-batch stone-ground recipes ensuring rich flavor profile and long-lasting freshness.', 'kash-naturals'); ?></div>
        </div>
        <div class="pillar-card">
            <div class="pillar-icon"><i class="fa-solid fa-truck-fast"></i></div>
            <div class="pillar-title"><?php esc_html_e('Pan India Delivery', 'kash-naturals'); ?></div>
            <div class="pillar-desc"><?php esc_html_e('Temperature-controlled insulated packaging ensuring fresh delivery anywhere across India.', 'kash-naturals'); ?></div>
        </div>
    </div>
</div>

<?php
get_footer();
