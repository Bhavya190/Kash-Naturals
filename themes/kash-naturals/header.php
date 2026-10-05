<?php
/**
 * The Header for Kash Naturals Theme
 *
 * @package KashNaturals
 */

if (!defined('ABSPATH')) {
    exit;
}
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site-wrapper">

    <!-- Top Notice Bar (Customizable via WP Admin Customizer) -->
    <?php if (get_theme_mod('kash_noticebar_enable', true)) : 
        $notice_bg = get_theme_mod('kash_noticebar_bg', '#0a331a');
        $notice_color = get_theme_mod('kash_noticebar_color', '#ffffff');
        $default_items = array(
            1 => array('icon' => 'fa-solid fa-leaf', 'text' => 'Natural Ingredients', 'link' => ''),
            2 => array('icon' => 'fa-solid fa-spa', 'text' => 'Hygienically Manufactured', 'link' => ''),
            3 => array('icon' => 'fa-solid fa-truck-fast', 'text' => 'Pan India Delivery', 'link' => ''),
            4 => array('icon' => 'fa-brands fa-amazon', 'text' => 'Available on Amazon', 'link' => ''),
        );
    ?>
    <div class="top-notice-bar" style="background-color: <?php echo esc_attr($notice_bg); ?>; color: <?php echo esc_attr($notice_color); ?>;">
        <div class="container notice-bar-container">
            <?php for ($i = 1; $i <= 4; $i++) :
                $icon = get_theme_mod("kash_noticebar_item{$i}_icon", $default_items[$i]['icon']);
                $text = get_theme_mod("kash_noticebar_item{$i}_text", $default_items[$i]['text']);
                $link = get_theme_mod("kash_noticebar_item{$i}_link", $default_items[$i]['link']);
                if (!empty($text)) : ?>
                    <div class="notice-bar-item">
                        <?php if (!empty($link)) : ?>
                            <a href="<?php echo esc_url($link); ?>" target="_blank" rel="noopener noreferrer" class="notice-link">
                        <?php endif; ?>
                            <?php if (!empty($icon)) : ?>
                                <i class="<?php echo esc_attr($icon); ?> notice-icon"></i>
                            <?php endif; ?>
                            <span class="notice-text"><?php echo esc_html($text); ?></span>
                        <?php if (!empty($link)) : ?>
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endif;
            endfor; ?>
        </div>
    </div>
    <?php endif; ?>

    <!-- Main Navigation Header -->
    <header id="masthead" class="site-header sticky-header">
        <div class="container header-container">

            <!-- Mobile Menu Toggle Button -->
            <button class="mobile-menu-toggle" id="mobile-menu-trigger" aria-label="<?php esc_attr_e('Toggle Menu', 'kash-naturals'); ?>">
                <i class="fa-solid fa-bars"></i>
            </button>

            <!-- Brand Logo -->
            <div class="site-branding">
                <?php if (has_custom_logo()) : ?>
                    <?php the_custom_logo(); ?>
                <?php else : ?>
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="brand-image-logo">
                        <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/logo.png'); ?>" alt="<?php bloginfo('name'); ?>" class="site-logo-img">
                    </a>
                <?php endif; ?>
            </div>

            <!-- Primary Navigation Menu -->
            <nav id="site-navigation" class="main-navigation" role="navigation">
                <?php
                if (has_nav_menu('primary')) {
                    wp_nav_menu(array(
                        'theme_location' => 'primary',
                        'menu_id'        => 'primary-menu',
                        'container'      => false,
                        'menu_class'     => 'nav-menu-list',
                    ));
                } else {
                    ?>
                    <ul class="nav-menu-list">
                        <li class="current-menu-item"><a href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('HOME', 'kash-naturals'); ?></a></li>
                        <li class="menu-item-has-children">
                            <a href="<?php echo esc_url(class_exists('WooCommerce') ? wc_get_page_permalink('shop') : '#'); ?>"><?php esc_html_e('SHOP', 'kash-naturals'); ?> <i class="fa-solid fa-chevron-down nav-chevron"></i></a>
                        </li>
                        <li><a href="<?php echo esc_url(home_url('/#combos')); ?>"><?php esc_html_e('COMBOS', 'kash-naturals'); ?></a></li>
                        <li><a href="<?php echo esc_url(home_url('/about/')); ?>"><?php esc_html_e('ABOUT US', 'kash-naturals'); ?></a></li>
                        <li><a href="<?php echo esc_url(home_url('/contact/')); ?>"><?php esc_html_e('CONTACT US', 'kash-naturals'); ?></a></li>
                    </ul>
                    <?php
                }
                ?>
            </nav>

            <!-- Header Action Icons -->
            <div class="header-actions">
                <button class="action-btn-clean search-trigger" id="search-modal-trigger" aria-label="<?php esc_attr_e('Search', 'kash-naturals'); ?>">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
                <a href="<?php echo esc_url(class_exists('WooCommerce') ? wc_get_page_permalink('myaccount') : '#'); ?>" class="action-btn-clean account-trigger" aria-label="<?php esc_attr_e('Account', 'kash-naturals'); ?>">
                    <i class="fa-regular fa-user"></i>
                </a>
                <a href="<?php echo esc_url(class_exists('WooCommerce') ? wc_get_cart_url() : '#'); ?>" class="action-btn-clean cart-drawer-trigger" id="mini-cart-toggle" aria-label="<?php esc_attr_e('Cart', 'kash-naturals'); ?>">
                    <i class="fa-solid fa-cart-shopping"></i>
                    <span class="cart-count-badge-orange" id="mini-cart-count"><?php echo class_exists('WooCommerce') ? esc_html(WC()->cart->get_cart_contents_count()) : '0'; ?></span>
                </a>
            </div>

        </div>
    </header>

    <!-- Search Overlay Modal -->
    <div class="search-modal-overlay" id="search-modal">
        <div class="search-modal-content">
            <button class="close-search-btn" id="close-search">&times;</button>
            <h3><?php esc_html_e('Search Artisan Chocolates', 'kash-naturals'); ?></h3>
            <form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
                <input type="search" class="search-field" placeholder="<?php esc_attr_e('Search dark chocolate, truffle gift boxes, vegan bars...', 'kash-naturals'); ?>" value="<?php echo function_exists('get_search_query') ? get_search_query() : ''; ?>" name="s" autofocus />
                <input type="hidden" name="post_type" value="product" />
                <button type="submit" class="search-submit-btn"><i class="fa-solid fa-arrow-right"></i></button>
            </form>
        </div>
    </div>

    <main id="primary" class="site-main">
