<?php
/**
 * The Template for displaying product archives, including the main shop page
 *
 * @package KashNaturals
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header('shop');
?>

<div class="shop-hero-header section-padding text-center">
    <div class="container">
        <span class="section-subtitle">Artisan Collection</span>
        <h1 class="shop-title"><?php woocommerce_page_title(); ?></h1>
        <p class="shop-subtitle">Discover handcrafted single-origin chocolate bars, velvety truffles, and cocoa nibs.</p>
        <div class="gold-divider"></div>
    </div>
</div>

<div class="container section-padding shop-layout-container">
    <div class="shop-grid-wrapper">

        <!-- Shop Sidebar / Filters -->
        <aside class="shop-sidebar-area">
            <?php if (is_active_sidebar('shop-sidebar')) : ?>
                <?php dynamic_sidebar('shop-sidebar'); ?>
            <?php else : ?>
                <div class="custom-shop-filter-widget">
                    <h3 class="widget-title"><i class="fa-solid fa-sliders"></i> Filter by Cocoa Intensity</h3>
                    <ul class="cocoa-filter-list">
                        <li><a href="#"><span class="filter-radio"></span> 90% - 100% Raw Extra Dark</a></li>
                        <li><a href="#"><span class="filter-radio"></span> 70% - 89% Single-Origin Dark</a></li>
                        <li><a href="#"><span class="filter-radio"></span> 50% - 69% Dark Milk</a></li>
                        <li><a href="#"><span class="filter-radio"></span> Plant-Based / Vegan & Sugar-Free</a></li>
                    </ul>
                </div>

                <div class="custom-shop-filter-widget">
                    <h3 class="widget-title"><i class="fa-solid fa-lemon"></i> Tasting Notes</h3>
                    <div class="flavor-chips-cloud">
                        <span class="flavor-chip">Nutty Espresso</span>
                        <span class="flavor-chip">Wild Cherry</span>
                        <span class="flavor-chip">Sea Salt Caramel</span>
                        <span class="flavor-chip">Matcha Crisp</span>
                        <span class="flavor-chip">Bourbon Vanilla</span>
                    </div>
                </div>
            <?php endif; ?>
        </aside>

        <!-- Product Grid Content -->
        <main class="shop-products-area">
            <?php if (woocommerce_product_loop()) : ?>

                <div class="shop-toolbar flex-between">
                    <div class="result-count-box">
                        <?php woocommerce_result_count(); ?>
                    </div>
                    <div class="catalog-ordering-box">
                        <?php woocommerce_catalog_ordering(); ?>
                    </div>
                </div>

                <?php
                woocommerce_product_loop_start();

                if (wc_get_loop_prop('total')) {
                    while (have_posts()) {
                        the_post();
                        do_action('woocommerce_shop_loop');
                        wc_get_template_part('content', 'product');
                    }
                }

                woocommerce_product_loop_end();
                do_action('woocommerce_after_shop_loop');

            else :

                do_action('woocommerce_no_products_found');

            endif;
            ?>
        </main>

    </div>
</div>

<?php
get_footer('shop');
