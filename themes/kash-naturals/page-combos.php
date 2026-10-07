<?php
/**
 * Template Name: Combos & Gift Hampers Page
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
<div class="combos-page-header">
    <div class="container text-center">
        <span class="combos-header-subtitle"><?php esc_html_e('SPECIAL SAVINGS & GIFT HAMPERS', 'kash-naturals'); ?></span>
        <h1 class="combos-header-title"><?php esc_html_e('Curated Gift Combos & Value Packs', 'kash-naturals'); ?></h1>
        <div class="combos-breadcrumb">
            <a href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('Home', 'kash-naturals'); ?></a>
            <span class="sep">/</span>
            <span class="current"><?php esc_html_e('Combos', 'kash-naturals'); ?></span>
        </div>
    </div>
</div>

<!-- Combos Value Features Banner -->
<section class="combos-value-bar">
    <div class="container combos-value-grid">
        <div class="value-item">
            <div class="value-icon"><i class="fa-solid fa-gift"></i></div>
            <div class="value-text">
                <h4><?php esc_html_e('Festive Gift Packaging', 'kash-naturals'); ?></h4>
                <p><?php esc_html_e('Hand-packed in luxury gift boxes ready for celebrations', 'kash-naturals'); ?></p>
            </div>
        </div>
        <div class="value-item">
            <div class="value-icon"><i class="fa-solid fa-percent"></i></div>
            <div class="value-text">
                <h4><?php esc_html_e('Save Up To 30% Off', 'kash-naturals'); ?></h4>
                <p><?php esc_html_e('Exclusive savings compared to buying individual jars', 'kash-naturals'); ?></p>
            </div>
        </div>
        <div class="value-item">
            <div class="value-icon"><i class="fa-solid fa-truck-fast"></i></div>
            <div class="value-text">
                <h4><?php esc_html_e('Free Cold Delivery', 'kash-naturals'); ?></h4>
                <p><?php esc_html_e('Insulated temperature-controlled shipping nationwide', 'kash-naturals'); ?></p>
            </div>
        </div>
    </div>
</section>

<!-- Combos Showcase Section (Using exact Reference UI 4-Card Grid) -->
<?php get_template_part('template-parts/content', 'combos'); ?>

<!-- Shop on Amazon Banner Section -->
<?php get_template_part('template-parts/content', 'amazon-banner'); ?>

<?php
get_footer();
