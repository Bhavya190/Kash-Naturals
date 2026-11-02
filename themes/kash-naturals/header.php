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
            1 => array('icon' => 'fa-solid fa-truck-fast', 'text' => 'Free Shipping Above - ₹499', 'link' => ''),
            2 => array('icon' => 'fa-solid fa-tag', 'text' => 'New User get 10% Welcome10 code', 'link' => ''),
            3 => array('icon' => 'fa-solid fa-spa', 'text' => '', 'link' => ''),
            4 => array('icon' => 'fa-brands fa-amazon', 'text' => '', 'link' => ''),
        );

        $active_notice_items = array();
        for ($i = 1; $i <= 4; $i++) {
            $def_icon = isset($default_items[$i]['icon']) ? $default_items[$i]['icon'] : '';
            $def_text = isset($default_items[$i]['text']) ? $default_items[$i]['text'] : '';
            $def_link = isset($default_items[$i]['link']) ? $default_items[$i]['link'] : '';

            $icon = get_theme_mod("kash_noticebar_item{$i}_icon", $def_icon);
            $text = get_theme_mod("kash_noticebar_item{$i}_text", $def_text);
            $link = get_theme_mod("kash_noticebar_item{$i}_link", $def_link);

            // Clean up old defaults from original theme version if still in DB
            if ($text === 'Natural Ingredients') {
                $text = 'Free Shipping Above - ₹499';
                $icon = 'fa-solid fa-truck-fast';
            } elseif ($text === 'Hygienically Manufactured') {
                $text = 'New User get 10% Welcome10 code';
                $icon = 'fa-solid fa-tag';
            } elseif ($text === 'Pan India Delivery' || $text === 'Available on Amazon') {
                $text = '';
                $icon = '';
            }

            if (!empty($text)) {
                $active_notice_items[] = array(
                    'icon' => $icon,
                    'text' => $text,
                    'link' => $link,
                );
            }
        }

        $item_count = count($active_notice_items);
        if ($item_count === 0) {
            $active_notice_items = array(
                array('icon' => 'fa-solid fa-truck-fast', 'text' => 'Free Shipping Above - ₹499', 'link' => ''),
                array('icon' => 'fa-solid fa-tag', 'text' => 'New User get 10% Welcome10 code', 'link' => ''),
            );
            $item_count = 2;
        }

        $render_single_notice_item = function($n_item) {
            ?>
            <div class="notice-bar-item">
                <?php if (!empty($n_item['link'])) : ?>
                    <a href="<?php echo esc_url($n_item['link']); ?>" target="_blank" rel="noopener noreferrer" class="notice-link">
                <?php endif; ?>
                    <?php if (!empty($n_item['icon'])) : ?>
                        <i class="<?php echo esc_attr($n_item['icon']); ?> notice-icon"></i>
                    <?php endif; ?>
                    <span class="notice-text"><?php echo esc_html($n_item['text']); ?></span>
                <?php if (!empty($n_item['link'])) : ?>
                    </a>
                <?php endif; ?>
            </div>
            <?php
        };
    ?>
    <div class="top-notice-bar" style="background-color: <?php echo esc_attr($notice_bg); ?>; color: <?php echo esc_attr($notice_color); ?>;">
        <div class="container notice-bar-container">
            <!-- Desktop Layout: dynamically uses 1, 2, 3, or 4 columns based on array item count -->
            <div class="notice-bar-desktop notice-bar-grid notice-cols-<?php echo esc_attr($item_count); ?>" id="noticeBarDesktop" style="--notice-cols: <?php echo intval($item_count); ?>;">
                <?php foreach ($active_notice_items as $n_item) : ?>
                    <?php $render_single_notice_item($n_item); ?>
                <?php endforeach; ?>
            </div>

            <!-- Mobile Layout: Continuous moving line (infinite ticker marquee) -->
            <div class="notice-bar-mobile" id="noticeBarMobile">
                <div class="notice-bar-marquee-track">
                    <div class="notice-bar-marquee-content">
                        <?php 
                        $repeats = ($item_count <= 2) ? 3 : 2;
                        for ($r = 0; $r < $repeats; $r++) :
                            foreach ($active_notice_items as $n_item) :
                                $render_single_notice_item($n_item);
                            endforeach;
                        endfor;
                        ?>
                    </div>
                    <div class="notice-bar-marquee-content" aria-hidden="true">
                        <?php 
                        for ($r = 0; $r < $repeats; $r++) :
                            foreach ($active_notice_items as $n_item) :
                                $render_single_notice_item($n_item);
                            endforeach;
                        endfor;
                        ?>
                    </div>
                </div>
            </div>
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
            <div class="site-branding header-branding-box">
                <?php if (has_custom_logo()) : ?>
                    <?php the_custom_logo(); ?>
                <?php else : ?>
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="brand-image-logo" rel="home">
                        <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/logo.png'); ?>" alt="<?php bloginfo('name'); ?>" class="site-logo-img" width="180" height="55" style="max-height: 55px; width: auto; object-fit: contain;">
                    </a>
                <?php endif; ?>
            </div>

            <!-- Primary Navigation Menu (Dynamic WordPress wp_nav_menu) -->
            <nav id="site-navigation" class="main-navigation" role="navigation" aria-label="<?php esc_attr_e('Primary Navigation', 'kash-naturals'); ?>">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'primary',
                    'menu_id'        => 'primary-menu',
                    'container'      => false,
                    'menu_class'     => 'nav-menu-list',
                    'depth'          => 3,
                    'fallback_cb'    => function() {
                        // 1. If no menu is explicitly assigned to 'primary', check if any custom menu was created in Appearance > Menus
                        $menus = wp_get_nav_menus();
                        if (!empty($menus)) {
                            wp_nav_menu(array(
                                'menu'        => $menus[0]->term_id,
                                'menu_id'     => 'primary-menu',
                                'container'   => false,
                                'menu_class'  => 'nav-menu-list',
                                'depth'       => 3,
                                'fallback_cb' => false,
                            ));
                            return;
                        }

                        // 2. If no custom menu has been created yet, list published pages dynamically from WordPress
                        echo '<ul id="primary-menu" class="nav-menu-list">';
                        wp_list_pages(array(
                            'title_li' => '',
                            'depth'    => 2,
                            'number'   => 8,
                        ));
                        echo '</ul>';
                    },
                ));
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
                <?php
                $initial_cart_count = 0;
                if (function_exists('WC') && WC() && isset(WC()->cart) && is_object(WC()->cart)) {
                    $initial_cart_count = WC()->cart->get_cart_contents_count();
                }
                $cart_page_url = function_exists('wc_get_cart_url') ? wc_get_cart_url() : home_url('/cart');
                ?>
                <a href="<?php echo esc_url($cart_page_url); ?>" class="action-btn-clean header-cart-link" id="header-cart-icon" aria-label="<?php esc_attr_e('Cart', 'kash-naturals'); ?>" title="<?php esc_attr_e('Shopping Cart', 'kash-naturals'); ?>">
                    <i class="fa-solid fa-cart-shopping"></i>
                    <span class="cart-count-badge-orange cart-count-badge" id="mini-cart-count"><?php echo esc_html($initial_cart_count); ?></span>
                </a>
            </div>

        </div>
    </header>

    <main id="primary" class="site-main">
