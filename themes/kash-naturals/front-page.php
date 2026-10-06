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

<!-- Brand USPs & Value Features Bar -->
<?php get_template_part('template-parts/content', 'usps'); ?>

<!-- Bestselling Featured Products Grid -->
<?php get_template_part('template-parts/content', 'featured'); ?>

<!-- Combo Offers Section -->
<?php get_template_part('template-parts/content', 'combos'); ?>

<!-- Shop on Amazon Banner Section -->
<?php get_template_part('template-parts/content', 'amazon-banner'); ?>

<!-- Customer Testimonials -->
<?php get_template_part('template-parts/content', 'testimonials'); ?>

<!-- Our Story Section -->
<?php get_template_part('template-parts/content', 'story'); ?>

<?php

get_footer();
