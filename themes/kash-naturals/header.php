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
                        <li class="menu-item-has-children nav-dropdown-item">
                            <a href="<?php echo esc_url(home_url('/shop')); ?>"><?php esc_html_e('SHOP', 'kash-naturals'); ?> <i class="fa-solid fa-chevron-down nav-chevron"></i></a>
                            <ul class="sub-menu header-dropdown-menu">
                                <li><a href="<?php echo esc_url(home_url('/shop?category=mouth-fresheners')); ?>"><i class="fa-solid fa-leaf"></i> <?php esc_html_e('Mouth Fresheners', 'kash-naturals'); ?></a></li>
                                <li><a href="<?php echo esc_url(home_url('/shop?category=chocolate-dragees')); ?>"><i class="fa-solid fa-cookie-bite"></i> <?php esc_html_e('Chocolate Dragees', 'kash-naturals'); ?></a></li>
                                <li><a href="<?php echo esc_url(home_url('/shop?category=kunafa-bars')); ?>"><i class="fa-solid fa-layer-group"></i> <?php esc_html_e('Kunafa Bars', 'kash-naturals'); ?></a></li>
                                <li><a href="<?php echo esc_url(home_url('/combos')); ?>"><i class="fa-solid fa-gift"></i> <?php esc_html_e('Gift Combos', 'kash-naturals'); ?></a></li>
                                <li class="dropdown-divider-line"></li>
                                <li><a href="<?php echo esc_url(home_url('/shop')); ?>"><i class="fa-solid fa-border-all"></i> <?php esc_html_e('All Products', 'kash-naturals'); ?></a></li>
                            </ul>
                        </li>

                        <li><a href="<?php echo esc_url(home_url('/combos/')); ?>"><?php esc_html_e('COMBOS', 'kash-naturals'); ?></a></li>

                        <li><a href="<?php echo esc_url(home_url('/about/')); ?>"><?php esc_html_e('ABOUT US', 'kash-naturals'); ?></a></li>
                        <li><a href="<?php echo esc_url(home_url('/contact/')); ?>"><?php esc_html_e('CONTACT US', 'kash-naturals'); ?></a></li>
                    </ul>
                    <?php
                }
                ?>
            </nav>

            <!-- Header Action Icons -->
            <div class="header-actions">
                <button type="button" class="action-btn-clean search-trigger" id="search-modal-trigger" aria-label="<?php esc_attr_e('Search', 'kash-naturals'); ?>" title="Search Products">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
                <button type="button" class="action-btn-clean account-trigger" id="account-modal-trigger" aria-label="<?php esc_attr_e('Account', 'kash-naturals'); ?>" title="My Account">
                    <i class="fa-regular fa-user" id="header-account-icon"></i>
                    <span class="header-user-badge" id="header-user-badge" style="display: none;"></span>
                </button>
                <button type="button" class="action-btn-clean cart-drawer-trigger" id="mini-cart-toggle" aria-label="<?php esc_attr_e('Cart', 'kash-naturals'); ?>" title="Shopping Cart">
                    <i class="fa-solid fa-cart-shopping"></i>
                    <span class="cart-count-badge-orange" id="mini-cart-count">0</span>
                </button>
            </div>

        </div>
    </header>

    <main id="primary" class="site-main">
