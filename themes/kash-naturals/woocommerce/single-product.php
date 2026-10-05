<?php
/**
 * The Template for displaying single products
 *
 * @package KashNaturals
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header('shop');
?>

<div class="container section-padding single-product-container">
    <?php while (have_posts()) : the_post(); ?>

        <?php wc_get_template_part('content', 'single-product'); ?>

    <?php endwhile; ?>
</div>

<?php
get_footer('shop');
