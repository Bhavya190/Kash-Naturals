<?php
/**
 * Theme Setup and Configuration
 *
 * @package KashNaturals
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

if (!function_exists('kash_naturals_setup')) :
    /**
     * Sets up theme defaults and registers support for various WordPress features.
     */
    function kash_naturals_setup() {
        // Make theme available for translation
        load_theme_textdomain('kash-naturals', get_template_directory() . '/languages');

        // Add default posts and comments RSS feed links to head
        add_theme_support('automatic-feed-links');

        // Let WordPress manage the document title
        add_theme_support('title-tag');

        // Enable support for Post Thumbnails on posts and pages
        add_theme_support('post-thumbnails');

        // Register custom image sizes for chocolate products
        add_image_size('kash-product-card', 400, 400, true);
        add_image_size('kash-product-hero', 800, 800, true);
        add_image_size('kash-category-banner', 600, 400, true);

        // Register Navigation Menus
        register_nav_menus(array(
            'primary' => __('Primary Navigation Header', 'kash-naturals'),
            'footer'  => __('Footer Links Menu', 'kash-naturals'),
            'categories' => __('Chocolate Categories Menu', 'kash-naturals'),
        ));

        // HTML5 markup support
        add_theme_support('html5', array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
            'style',
            'script',
        ));

        // Set up the WordPress core custom logo feature
        add_theme_support('custom-logo', array(
            'height'      => 80,
            'width'       => 240,
            'flex-height' => true,
            'flex-width'  => true,
            'header-text' => array('site-title', 'site-description'),
        ));

        // Add theme support for Selective Refresh for Widgets
        add_theme_support('customize-selective-refresh-widgets');

        // Add WooCommerce Theme Support
        add_theme_support('woocommerce');
        add_theme_support('wc-product-gallery-zoom');
        add_theme_support('wc-product-gallery-lightbox');
        add_theme_support('wc-product-gallery-slider');
    }
endif;
add_action('after_setup_theme', 'kash_naturals_setup');

/**
 * Ensure Custom Logo markup is strictly constrained and responsive across all viewports
 */
function kash_naturals_custom_logo_markup($html) {
    if (!empty($html)) {
        if (strpos($html, 'class="') !== false) {
            $html = str_replace('class="custom-logo', 'class="custom-logo site-logo-img', $html);
        }
        $html = preg_replace('/<img (.*?)>/i', '<img $1 style="max-height: 55px; width: auto; max-width: 200px; object-fit: contain;">', $html);
    }
    return $html;
}
add_filter('get_custom_logo', 'kash_naturals_custom_logo_markup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 */
function kash_naturals_content_width() {
    $GLOBALS['content_width'] = apply_filters('kash_naturals_content_width', 1200);
}
add_action('after_setup_theme', 'kash_naturals_content_width', 0);

/**
 * Register widget area.
 */
function kash_naturals_widgets_init() {
    register_sidebar(array(
        'name'          => __('Shop Sidebar', 'kash-naturals'),
        'id'            => 'shop-sidebar',
        'description'   => __('Add widgets here to appear in your WooCommerce shop sidebar.', 'kash-naturals'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));

    register_sidebar(array(
        'name'          => __('Footer Column 1', 'kash-naturals'),
        'id'            => 'footer-1',
        'description'   => __('First footer column widget area.', 'kash-naturals'),
        'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widget-title">',
        'after_title'   => '</h4>',
    ));

    register_sidebar(array(
        'name'          => __('Footer Column 2', 'kash-naturals'),
        'id'            => 'footer-2',
        'description'   => __('Second footer column widget area.', 'kash-naturals'),
        'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widget-title">',
        'after_title'   => '</h4>',
    ));
}
add_action('widgets_init', 'kash_naturals_widgets_init');

/**
 * Append dropdown chevron icon to parent menu items with children in the header nav
 */
function kash_naturals_add_menu_chevron($title, $item, $args, $depth) {
    // Only apply to primary navigation or when theme_location is primary
    if (isset($args->theme_location) && $args->theme_location === 'primary') {
        if (in_array('menu-item-has-children', (array) $item->classes, true)) {
            $title .= ' <i class="fa-solid fa-chevron-down nav-chevron"></i>';
        }
    }
    return $title;
}
add_filter('nav_menu_item_title', 'kash_naturals_add_menu_chevron', 10, 4);

/**
 * Synchronize Nav Menu Active Classes for Product Categories and Home Screen
 * - By default on the home screen, removes active/current underline from all items (unless an explicit Home link exists)
 * - When visiting any category (archive or filter), adds active/current underline to that category's nav menu item if present
 * - If that category is not in the nav menu, no menu item is underlined
 */
function kash_filter_nav_menu_css_class($classes, $item, $args, $depth = 0) {
    if (!isset($args->theme_location) || $args->theme_location !== 'primary') {
        return $classes;
    }

    $classes = (array) $classes;
    $item_url = trim((string) $item->url);
    $item_title = strtolower(trim((string) $item->title));

    // 1. If on front page (home screen)
    if (is_front_page() || is_home()) {
        $home_url = trim(home_url('/'));
        $home_url_bare = trim(home_url());

        // Check if this menu item is genuinely linking to the home screen
        $is_real_home = ($item_url === $home_url || $item_url === $home_url_bare || $item_url === '/') && ($item_title === 'home');
        if (!$is_real_home) {
            $classes = array_diff($classes, array('current-menu-item', 'current_page_item', 'active', 'current-menu-ancestor', 'current-menu-parent', 'current_page_parent', 'current_page_ancestor'));
        }
        return array_values($classes);
    }

    // 2. Identify active product category (from taxonomy archive or ?category= / ?product_cat= query param)
    $active_cat_slug = '';
    if (function_exists('is_product_category') && is_product_category()) {
        $queried = get_queried_object();
        if ($queried && isset($queried->slug)) {
            $active_cat_slug = strtolower($queried->slug);
        }
    } elseif (isset($_GET['category']) && !empty($_GET['category']) && $_GET['category'] !== 'all') {
        $active_cat_slug = sanitize_title($_GET['category']);
    } elseif (isset($_GET['product_cat']) && !empty($_GET['product_cat']) && $_GET['product_cat'] !== 'all') {
        $active_cat_slug = sanitize_title($_GET['product_cat']);
    }

    if (!empty($active_cat_slug)) {
        $is_match = false;

        // Check if item object is product_cat and matches
        if (isset($item->object) && $item->object === 'product_cat' && isset($item->object_id)) {
            $term = get_term($item->object_id, 'product_cat');
            if ($term && !is_wp_error($term) && strtolower($term->slug) === $active_cat_slug) {
                $is_match = true;
            }
        }

        // Check if item URL matches category slug
        if (!$is_match && !empty($item_url)) {
            $parsed_path = strtolower(trim((string) parse_url($item_url, PHP_URL_PATH), '/'));
            $path_segments = explode('/', $parsed_path);
            if (in_array($active_cat_slug, $path_segments, true)) {
                $is_match = true;
            } else {
                parse_str((string) parse_url($item_url, PHP_URL_QUERY), $query_params);
                if ((isset($query_params['category']) && strtolower($query_params['category']) === $active_cat_slug) ||
                    (isset($query_params['product_cat']) && strtolower($query_params['product_cat']) === $active_cat_slug)) {
                    $is_match = true;
                }
            }
        }

        // Check if menu item title matches category name or slug (e.g. "Dry Fruits" === "dry-fruits")
        if (!$is_match) {
            $item_title_clean = strtolower(trim((string) preg_replace('/[^a-zA-Z0-9]+/', ' ', $item->title)));
            $cat_slug_clean = strtolower(trim((string) str_replace(array('-', '_'), ' ', $active_cat_slug)));
            if (!empty($item_title_clean) && $item_title_clean === $cat_slug_clean) {
                $is_match = true;
            }
        }

        if ($is_match) {
            $classes[] = 'current-menu-item';
            $classes[] = 'active';
        } else {
            // Strip active classes if this item is not the active category
            $classes = array_diff($classes, array('current-menu-item', 'current_page_item', 'active', 'current-menu-ancestor', 'current-menu-parent'));
        }
    }

    return array_unique(array_values($classes));
}
add_filter('nav_menu_css_class', 'kash_filter_nav_menu_css_class', 10, 4);

/**
 * =========================================================================
 * SITE IDENTITY & BRANDING AUTO-CORRECTION
 * =========================================================================
 * Automatically ensures the site title and description in WordPress database
 * reflect "Kash Naturals" instead of temporary staging domains (e.g. magenta-ant-151641.hostinger...).
 */
function kash_ensure_site_identity() {
    $current_name = get_option('blogname');
    if (empty($current_name) || 
        stripos($current_name, 'hostinger') !== false || 
        stripos($current_name, 'magenta') !== false || 
        stripos($current_name, 'temp') !== false || 
        stripos($current_name, 'localhost') !== false ||
        stripos($current_name, '.site') !== false) {
        update_option('blogname', 'Kash Naturals');
    }

    $current_desc = get_option('blogdescription');
    if (empty($current_desc) || 
        stripos($current_desc, 'just another') !== false || 
        stripos($current_desc, 'hostinger') !== false) {
        update_option('blogdescription', 'Authentic Indian Mouth Fresheners & Chocolates');
    }
}
add_action('init', 'kash_ensure_site_identity', 1);
add_action('after_setup_theme', 'kash_ensure_site_identity', 1);

/**
 * Filter blogname option so any call to get_bloginfo('name') or get_option('blogname')
 * always returns the official brand name without any Hostinger temporary subdomain string.
 */
function kash_filter_blogname($value) {
    if (empty($value) || 
        stripos($value, 'hostinger') !== false || 
        stripos($value, 'magenta') !== false || 
        stripos($value, 'temp') !== false || 
        stripos($value, 'localhost') !== false) {
        return get_theme_mod('kash_site_name_title', 'Kash Naturals');
    }
    return $value;
}
add_filter('pre_option_blogname', 'kash_filter_blogname');
add_filter('option_blogname', 'kash_filter_blogname');

/**
 * Filter blogdescription option so get_bloginfo('description') returns the authentic brand tagline.
 */
function kash_filter_blogdescription($value) {
    if (empty($value) || 
        stripos($value, 'just another') !== false || 
        stripos($value, 'hostinger') !== false) {
        return 'Authentic Indian Mouth Fresheners & Chocolates';
    }
    return $value;
}
add_filter('pre_option_blogdescription', 'kash_filter_blogdescription');
add_filter('option_blogdescription', 'kash_filter_blogdescription');

/**
 * =========================================================================
 * SEO PAGE TITLES & DOCUMENT TITLE MANAGEMENT
 * =========================================================================
 * Generates clean, luxury, brand-consistent browser tab titles for every page:
 * - Home Page: "Kash Naturals | Authentic Indian Mouth Fresheners & Chocolates"
 * - Shop Archive: "Shop Authentic Products | Kash Naturals"
 * - Category Pages: "Royal Mukhwas & Mouth Fresheners | Kash Naturals"
 * - Products: "{Product Title} | Kash Naturals"
 * - Cart / Bag: "Shopping Bag | Kash Naturals"
 * - Checkout: "Secure Checkout | Kash Naturals"
 * - Content Pages: "{Page Title} | Kash Naturals"
 */
function kash_naturals_document_title($title) {
    // Respect active dedicated SEO plugins if installed
    if (defined('WPSEO_VERSION') || defined('RANK_MATH_VERSION') || defined('AIOSEO_VERSION') || defined('SEOPRESS_VERSION')) {
        return $title;
    }

    $site_name = get_theme_mod('kash_site_name_title', 'Kash Naturals');
    $sep = get_theme_mod('kash_title_separator', '|');

    // 1. Home / Front Page
    if (is_front_page() || is_home()) {
        $custom_home_title = get_theme_mod('kash_home_page_title', '');
        if (!empty($custom_home_title)) {
            return $custom_home_title;
        }
        return "{$site_name} {$sep} Authentic Indian Mouth Fresheners & Chocolates";
    }

    // 2. WooCommerce Single Product
    if (function_exists('is_product') && is_product()) {
        $product_title = get_the_title();
        return "{$product_title} {$sep} {$site_name}";
    }

    // 3. WooCommerce Product Category Archive
    if (function_exists('is_product_category') && is_product_category()) {
        $current_term = get_queried_object();
        if ($current_term && isset($current_term->name)) {
            $cat_name = $current_term->name;
            $cat_slug = strtolower($current_term->slug);
            if ($cat_slug === 'mukhwas') {
                return "Royal Mukhwas & Mouth Fresheners {$sep} {$site_name}";
            } elseif ($cat_slug === 'chocolates') {
                return "Artisan Belgian Chocolates & Roasted Dragees {$sep} {$site_name}";
            } elseif ($cat_slug === 'dry-fruits') {
                return "Premium Dry Fruits & Masala Kharek {$sep} {$site_name}";
            } elseif ($cat_slug === 'gift-hampers' || $cat_slug === 'combos') {
                return "Curated Gift Hampers & Celebration Packs {$sep} {$site_name}";
            }
            return "{$cat_name} {$sep} {$site_name}";
        }
    }

    // 4. WooCommerce Shop / Catalog Archive
    if (function_exists('is_shop') && is_shop()) {
        $shop_title = get_theme_mod('kash_shop_page_title', 'Shop Authentic Products');
        return "{$shop_title} {$sep} {$site_name}";
    }

    // 5. Shopping Bag / Cart Page
    if (function_exists('is_cart') && is_cart()) {
        return "Shopping Bag {$sep} {$site_name}";
    }

    // 6. Secure Checkout Page
    if (function_exists('is_checkout') && is_checkout()) {
        return "Secure Checkout {$sep} {$site_name}";
    }

    // 7. Pages by slug & template
    if (is_page()) {
        global $post;
        $slug = isset($post->post_name) ? strtolower($post->post_name) : '';
        $page_title = get_the_title();

        switch ($slug) {
            case 'our-story':
            case 'about':
            case 'about-us':
                return "Our Story & Craftsmanship {$sep} {$site_name}";
            case 'bulk-order':
            case 'bulk-orders':
            case 'corporate-orders':
                return "Bulk & Corporate Orders {$sep} {$site_name}";
            case 'combos':
            case 'combo':
            case 'gift-combos':
                return "Curated Combos & Gift Hampers {$sep} {$site_name}";
            case 'contact':
            case 'contact-us':
                return "Contact Us {$sep} {$site_name}";
            case 'faqs':
            case 'faq':
                return "Frequently Asked Questions (FAQs) {$sep} {$site_name}";
            case 'shipping-policy':
            case 'shipping':
                return "Shipping & Delivery Policy {$sep} {$site_name}";
            case 'return-policy':
            case 'refund-policy':
            case 'returns':
                return "Return & Refund Policy {$sep} {$site_name}";
            case 'terms':
            case 'terms-and-conditions':
            case 'terms-conditions':
                return "Terms & Conditions {$sep} {$site_name}";
            case 'privacy-policy':
            case 'privacy':
                return "Privacy Policy {$sep} {$site_name}";
            case 'cart':
                return "Shopping Bag {$sep} {$site_name}";
            case 'checkout':
                return "Secure Checkout {$sep} {$site_name}";
            case 'shop':
                return "Shop Authentic Products {$sep} {$site_name}";
            default:
                if (!empty($page_title)) {
                    return "{$page_title} {$sep} {$site_name}";
                }
                break;
        }
    }

    // 8. Search Results
    if (is_search()) {
        $search_query = get_search_query();
        return "Search Results for \"{$search_query}\" {$sep} {$site_name}";
    }

    // 9. 404 Page Not Found
    if (is_404()) {
        return "Page Not Found {$sep} {$site_name}";
    }

    // 10. Single Blog Post
    if (is_singular('post')) {
        $post_title = get_the_title();
        return "{$post_title} {$sep} {$site_name}";
    }

    // 11. General Archives
    if (is_archive()) {
        $archive_title = get_the_archive_title();
        $clean_archive_title = preg_replace('/^[^:]+:\s*/', '', $archive_title);
        return "{$clean_archive_title} {$sep} {$site_name}";
    }

    // 12. Fallback
    $fallback_title = get_the_title();
    if (!empty($fallback_title)) {
        return "{$fallback_title} {$sep} {$site_name}";
    }

    return "{$site_name} {$sep} Authentic Indian Mouth Fresheners & Chocolates";
}
add_filter('pre_get_document_title', 'kash_naturals_document_title', 20);

/**
 * Filter Document Title Parts as secondary fallback
 */
function kash_naturals_document_title_parts($parts) {
    $site_name = get_theme_mod('kash_site_name_title', 'Kash Naturals');

    // Ensure site title is always Kash Naturals and never Hostinger temporary string
    if (isset($parts['site']) && (empty($parts['site']) || stripos($parts['site'], 'hostinger') !== false || stripos($parts['site'], 'magenta') !== false)) {
        $parts['site'] = $site_name;
    }
    if (isset($parts['title']) && (stripos($parts['title'], 'hostinger') !== false || stripos($parts['title'], 'magenta') !== false)) {
        $parts['title'] = $site_name;
    }
    if (isset($parts['tagline']) && (stripos($parts['tagline'], 'just another') !== false || stripos($parts['tagline'], 'hostinger') !== false)) {
        $parts['tagline'] = 'Authentic Indian Mouth Fresheners & Chocolates';
    }

    if (is_front_page() || is_home()) {
        $parts['title'] = $site_name;
        $parts['tagline'] = 'Authentic Indian Mouth Fresheners & Chocolates';
    }

    return $parts;
}
add_filter('document_title_parts', 'kash_naturals_document_title_parts', 20);

/**
 * Set Title Separator
 */
function kash_naturals_document_title_separator($sep) {
    return get_theme_mod('kash_title_separator', '|');
}
add_filter('document_title_separator', 'kash_naturals_document_title_separator', 20);

/**
 * Filter Amazon Store Link Theme Mod to ensure the official storefront URL is always returned.
 */
function kash_filter_amazon_shop_link($link) {
    $official_amazon_store = 'https://www.amazon.in/s?me=A30KTY4XP7ZA4W&marketplaceID=A21TJRUUN4KGV';
    if (empty($link) || $link === 'https://amazon.in' || $link === 'https://amazon.in/' || $link === 'https://www.amazon.in' || $link === 'https://www.amazon.in/') {
        return $official_amazon_store;
    }
    return $link;
}
add_filter('theme_mod_kash_amazon_shop_link', 'kash_filter_amazon_shop_link');

