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
        );

        $render_notice_items = function() use ($default_items) {
            foreach ($default_items as $i => $item_def) :
                $icon = get_theme_mod("kash_noticebar_item{$i}_icon", $item_def['icon']);
                $text = get_theme_mod("kash_noticebar_item{$i}_text", $item_def['text']);
                $link = get_theme_mod("kash_noticebar_item{$i}_link", $item_def['link']);

                // Reset old defaults if still stored in theme_mods
                if ($text === 'Natural Ingredients' || $text === 'Hygienically Manufactured' || $text === 'Pan India Delivery' || $text === 'Available on Amazon') {
                    $text = $item_def['text'];
                    $icon = $item_def['icon'];
                }

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
            endforeach;
        };
    ?>
    <div class="top-notice-bar" style="background-color: <?php echo esc_attr($notice_bg); ?>; color: <?php echo esc_attr($notice_color); ?>;">
        <div class="container notice-bar-container">
            <!-- Desktop Layout: Centered clean spaced row across the bar -->
            <div class="notice-bar-desktop" id="noticeBarDesktop">
                <?php $render_notice_items(); ?>
            </div>

            <!-- Mobile Layout: Continuous moving line (infinite ticker marquee) -->
            <div class="notice-bar-mobile" id="noticeBarMobile">
                <div class="notice-bar-marquee-track">
                    <div class="notice-bar-marquee-content">
                        <?php $render_notice_items(); ?>
                        <?php $render_notice_items(); ?>
                        <?php $render_notice_items(); ?>
                    </div>
                    <div class="notice-bar-marquee-content" aria-hidden="true">
                        <?php $render_notice_items(); ?>
                        <?php $render_notice_items(); ?>
                        <?php $render_notice_items(); ?>
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

            <!-- Primary Navigation Menu -->
            <nav id="site-navigation" class="main-navigation" role="navigation">
                <?php
                // Function to render navigation items
                $render_kash_nav_items = function() {
                    /**
                     * Kash Naturals Top Navigation Configuration
                     * - collection: dynamically resolves WooCommerce product_cat permalink via get_term_link() or falls back to /product-category/{slug}/
                     * - page: dynamically resolves WordPress page permalink via get_page_by_path() or falls back to /{slug}/
                     */
                    $nav_items = array(
                        array(
                            'title' => __('MUKHWAS', 'kash-naturals'),
                            'slug'  => 'mukhwas',
                            'type'  => 'collection',
                        ),
                        array(
                            'title' => __('CHOCOLATES', 'kash-naturals'),
                            'slug'  => 'chocolates',
                            'type'  => 'collection',
                        ),
                        array(
                            'title' => __('DRY FRUITS', 'kash-naturals'),
                            'slug'  => 'dry-fruits',
                            'type'  => 'collection',
                        ),
                        array(
                            'title' => __('GIFT HAMPERS', 'kash-naturals'),
                            'slug'  => 'gift-hampers',
                            'type'  => 'collection',
                        ),
                        array(
                            'title' => __('DEAL COMBOS', 'kash-naturals'),
                            'slug'  => 'combos',
                            'type'  => 'page',
                            'aliases' => array('combo'),
                        ),
                        array(
                            'title' => __('BULK ORDER', 'kash-naturals'),
                            'slug'  => 'bulk-order',
                            'type'  => 'page',
                            'aliases' => array('bulk-orders'),
                        ),
                        array(
                            'title' => __('OUR STORY', 'kash-naturals'),
                            'slug'  => 'our-story',
                            'type'  => 'page',
                            'aliases' => array('about', 'about-us'),
                        ),
                        array(
                            'title' => __('CONTACT', 'kash-naturals'),
                            'slug'  => 'contact',
                            'type'  => 'page',
                            'aliases' => array('contact-us'),
                        ),
                    );

                    $nav_items = apply_filters('kash_top_nav_items', $nav_items);

                    // Current Request Context for Active Highlighting
                    $req_uri = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '/';
                    $req_path = trim(parse_url($req_uri, PHP_URL_PATH), '/');

                    $current_tax_slug = '';
                    if (function_exists('is_product_category') && is_product_category()) {
                        $queried_obj = get_queried_object();
                        if ($queried_obj && isset($queried_obj->slug)) {
                            $current_tax_slug = $queried_obj->slug;
                        }
                    } elseif (isset($_GET['category'])) {
                        $current_tax_slug = sanitize_text_field($_GET['category']);
                    }
                    ?>
                    <ul class="nav-menu-list">
                        <?php foreach ($nav_items as $item) :
                            $item_slug  = $item['slug'];
                            $item_type  = isset($item['type']) ? $item['type'] : 'page';
                            $item_title = $item['title'];
                            $is_active  = false;
                            $nav_url    = '';

                            if ($item_type === 'collection') {
                                // 1. WooCommerce Product Category / Collection
                                if (function_exists('get_term_by') && function_exists('get_term_link')) {
                                    $term = get_term_by('slug', $item_slug, 'product_cat');
                                    if ($term && !is_wp_error($term)) {
                                        $t_link = get_term_link($term, 'product_cat');
                                        if (!is_wp_error($t_link)) {
                                            $nav_url = $t_link;
                                        }
                                    }
                                }
                                if (empty($nav_url)) {
                                    $nav_url = home_url('/product-category/' . $item_slug . '/');
                                }

                                // Active state check
                                if (!empty($current_tax_slug) && $current_tax_slug === $item_slug) {
                                    $is_active = true;
                                } elseif (function_exists('is_product_category') && is_product_category($item_slug)) {
                                    $is_active = true;
                                } elseif (function_exists('is_tax') && is_tax('product_cat', $item_slug)) {
                                    $is_active = true;
                                } elseif (strpos($req_path, 'product-category/' . $item_slug) !== false || $req_path === 'product-category/' . $item_slug) {
                                    $is_active = true;
                                }

                            } else {
                                // 2. Standard WordPress Page
                                if (function_exists('get_page_by_path') && function_exists('get_permalink')) {
                                    $page_obj = get_page_by_path($item_slug);
                                    if ($page_obj) {
                                        $p_link = get_permalink($page_obj);
                                        if (!is_wp_error($p_link)) {
                                            $nav_url = $p_link;
                                        }
                                    }
                                }
                                if (empty($nav_url)) {
                                    $nav_url = home_url('/' . trim($item_slug, '/') . '/');
                                }

                                // Active state check
                                $check_slugs = array($item_slug);
                                if (!empty($item['aliases']) && is_array($item['aliases'])) {
                                    $check_slugs = array_merge($check_slugs, $item['aliases']);
                                }

                                if (function_exists('is_page') && is_page($check_slugs)) {
                                    $is_active = true;
                                } else {
                                    foreach ($check_slugs as $chk) {
                                        if ($req_path === $chk || strpos($req_path, $chk . '/') === 0 || strpos($req_path, '/' . $chk) !== false) {
                                            $is_active = true;
                                            break;
                                        }
                                    }
                                }
                            }
                        ?>
                            <li class="nav-item-<?php echo esc_attr($item_slug); ?> nav-type-<?php echo esc_attr($item_type); ?> <?php echo $is_active ? 'current-menu-item active' : ''; ?>">
                                <a href="<?php echo esc_url($nav_url); ?>"><?php echo esc_html($item_title); ?></a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                    <?php
                };

                if (has_nav_menu('primary')) {
                    wp_nav_menu(array(
                        'theme_location' => 'primary',
                        'menu_id'        => 'primary-menu',
                        'container'      => false,
                        'menu_class'     => 'nav-menu-list',
                        'fallback_cb'    => $render_kash_nav_items,
                    ));
                } else {
                    $render_kash_nav_items();
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
