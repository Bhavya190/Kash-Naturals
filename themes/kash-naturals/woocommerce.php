<?php
/**
 * Main WooCommerce Fallback Template Wrapper
 *
 * @package KashNaturals
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>

<div class="kash-woocommerce-container container section-padding">
    <div class="woocommerce-page-wrapper">
        <?php woocommerce_content(); ?>
    </div>
</div>

<?php
get_footer();
