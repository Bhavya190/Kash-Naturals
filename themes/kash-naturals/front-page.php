<?php
/**
 * Front Page Template for Kash Naturals
 *
 * @package KashNaturals
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>

<!-- Hero Banner Section -->
<?php get_template_part('template-parts/content', 'hero'); ?>

<!-- Category Grid Showcase -->
<?php get_template_part('template-parts/content', 'categories'); ?>

<!-- Bestselling Featured Products Grid -->
<?php get_template_part('template-parts/content', 'featured'); ?>

<!-- Artisan Brand Craft & Process -->
<?php get_template_part('template-parts/content', 'story'); ?>

<!-- Customer Testimonials -->
<?php get_template_part('template-parts/content', 'testimonials'); ?>

<?php
get_footer();
