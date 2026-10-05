<?php
/**
 * Template Name: Shop Page
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

<div class="shop-container">
    <?php
    if (class_exists('WooCommerce')) {
        woocommerce_content();
    } else {
        ?>
        <div class="shop-filter-bar">
            <div class="filter-pills">
                <button class="filter-btn active"><?php esc_html_e('All Products', 'kash-naturals'); ?></button>
                <button class="filter-btn"><?php esc_html_e('Mouth Fresheners', 'kash-naturals'); ?></button>
                <button class="filter-btn"><?php esc_html_e('Chocolate Dragees', 'kash-naturals'); ?></button>
                <button class="filter-btn"><?php esc_html_e('Kunafa Bars', 'kash-naturals'); ?></button>
                <button class="filter-btn"><?php esc_html_e('Gift Combos', 'kash-naturals'); ?></button>
            </div>
        </div>

        <div class="shop-products-grid">
            <div class="shop-card">
                <span class="badge-tag"><?php esc_html_e('Bestseller', 'kash-naturals'); ?></span>
                <div class="shop-img-box"><i class="fa-solid fa-jar"></i></div>
                <div>
                    <div class="shop-card-cat"><?php esc_html_e('Mouth Freshener', 'kash-naturals'); ?></div>
                    <h3 class="shop-card-title"><?php esc_html_e('Royal Paan Mukhwas', 'kash-naturals'); ?></h3>
                    <div class="shop-card-price">₹299 <span>₹399</span></div>
                </div>
                <button class="btn-add-cart-main"><?php esc_html_e('ADD TO CART', 'kash-naturals'); ?></button>
            </div>

            <div class="shop-card">
                <span class="badge-tag"><?php esc_html_e('Artisanal', 'kash-naturals'); ?></span>
                <div class="shop-img-box"><i class="fa-solid fa-cookie-bite"></i></div>
                <div>
                    <div class="shop-card-cat"><?php esc_html_e('Chocolate Dragee', 'kash-naturals'); ?></div>
                    <h3 class="shop-card-title"><?php esc_html_e('Belgian Almond Dragees', 'kash-naturals'); ?></h3>
                    <div class="shop-card-price">₹499 <span>₹649</span></div>
                </div>
                <button class="btn-add-cart-main"><?php esc_html_e('ADD TO CART', 'kash-naturals'); ?></button>
            </div>

            <div class="shop-card">
                <span class="badge-tag"><?php esc_html_e('Signature', 'kash-naturals'); ?></span>
                <div class="shop-img-box"><i class="fa-solid fa-stroopwafel"></i></div>
                <div>
                    <div class="shop-card-cat"><?php esc_html_e('Kunafa Delight', 'kash-naturals'); ?></div>
                    <h3 class="shop-card-title"><?php esc_html_e('Pistachio Kunafa Bar', 'kash-naturals'); ?></h3>
                    <div class="shop-card-price">₹599 <span>₹749</span></div>
                </div>
                <button class="btn-add-cart-main"><?php esc_html_e('ADD TO CART', 'kash-naturals'); ?></button>
            </div>

            <div class="shop-card">
                <span class="badge-tag"><?php esc_html_e('Luxury Gift', 'kash-naturals'); ?></span>
                <div class="shop-img-box"><i class="fa-solid fa-gift"></i></div>
                <div>
                    <div class="shop-card-cat"><?php esc_html_e('Combo Pack', 'kash-naturals'); ?></div>
                    <h3 class="shop-card-title"><?php esc_html_e('Royal Festive Box', 'kash-naturals'); ?></h3>
                    <div class="shop-card-price">₹1,299 <span>₹1,699</span></div>
                </div>
                <button class="btn-add-cart-main"><?php esc_html_e('ADD TO CART', 'kash-naturals'); ?></button>
            </div>
        </div>
        <?php
    }
    ?>
</div>

<?php
get_footer();
