<?php
/**
 * Enqueue scripts and styles.
 *
 * @package KashNaturals
 */

if (!defined('ABSPATH')) {
    exit;
}

function kash_naturals_scripts() {
    // Enqueue Google Fonts (Playfair Display for headings & Outfit for body text)
    wp_enqueue_style(
        'kash-google-fonts',
        'https://fonts.googleapis.com/css2?family=Caveat:wght@600;700&family=Outfit:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,500;0,600;0,700;0,800;1,400;1,600&display=swap',
        array(),
        null
    );

    // Enqueue Font Awesome for icons
    wp_enqueue_style(
        'kash-fontawesome',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css',
        array(),
        '6.5.1'
    );

    // Theme Main CSS
    wp_enqueue_style(
        'kash-main-style',
        get_template_directory_uri() . '/assets/css/main.css',
        array(),
        time()
    );

    // WooCommerce Custom Overrides CSS (for shop, products, cart drawer, checkout)
    $woo_css_file = get_template_directory() . '/assets/css/woocommerce.css';
    $woo_css_ver = file_exists($woo_css_file) ? filemtime($woo_css_file) : (defined('KASH_NATURALS_VERSION') ? KASH_NATURALS_VERSION : time());
    wp_enqueue_style(
        'kash-woocommerce-style',
        get_template_directory_uri() . '/assets/css/woocommerce.css',
        array('kash-main-style'),
        $woo_css_ver
    );

    // Main Theme JS
    wp_enqueue_script(
        'kash-main-script',
        get_template_directory_uri() . '/assets/js/main.js',
        array('jquery'),
        time(),
        true
    );

    // Query dynamic published WooCommerce products for frontend JS live search & cart
    $dynamic_products_js = array();
    if (class_exists('WooCommerce')) {
        $wc_p_query = new WP_Query(array(
            'post_type'      => 'product',
            'post_status'    => 'publish',
            'posts_per_page' => 100,
        ));
        if ($wc_p_query->have_posts()) {
            while ($wc_p_query->have_posts()) {
                $wc_p_query->the_post();
                $prod = wc_get_product(get_the_ID());
                if ($prod && $prod->is_visible()) {
                    $img_url = wp_get_attachment_image_url($prod->get_image_id(), 'kash-product-card');
                    if (!$img_url && function_exists('wc_placeholder_img_src')) {
                        $img_url = wc_placeholder_img_src();
                    }
                    $cats = get_the_terms($prod->get_id(), 'product_cat');
                    $c_slug = (!empty($cats) && !is_wp_error($cats)) ? $cats[0]->slug : 'all';
                    $c_name = (!empty($cats) && !is_wp_error($cats)) ? $cats[0]->name : 'Specialty';

                    $dynamic_products_js[] = array(
                        'id'            => $prod->get_id(),
                        'name'          => $prod->get_name(),
                        'category'      => $c_slug,
                        'category_name' => $c_name,
                        'price'         => floatval($prod->get_price()) ?: 0,
                        'regular_price' => floatval($prod->get_regular_price()) ?: floatval($prod->get_price()),
                        'image'         => $img_url ?: '',
                        'badge'         => $prod->is_on_sale() ? 'Sale' : ($prod->is_featured() ? 'Featured' : ''),
                        'rating'        => ($prod->get_average_rating() > 0) ? number_format((float)$prod->get_average_rating(), 1) : '5.0',
                        'desc'          => wp_trim_words($prod->get_short_description() ?: get_the_excerpt(), 12, '...'),
                        'link'          => get_permalink($prod->get_id()),
                        'in_stock'      => $prod->is_in_stock(),
                        'stock_status'  => $prod->get_stock_status(),
                        'stock_quantity'=> $prod->managing_stock() ? $prod->get_stock_quantity() : null,
                        'managing_stock'=> $prod->managing_stock(),
                        'backorders'    => $prod->backorders_allowed(),
                    );
                }
            }
            wp_reset_postdata();
        }
    }

    wp_localize_script('kash-main-script', 'kash_dynamic_data', array(
        'products'        => $dynamic_products_js,
        'products_count'  => count($dynamic_products_js),
        'theme_uri'       => get_template_directory_uri(),
        'shop_url'        => home_url('/shop'),
        'cart_url'        => function_exists('wc_get_cart_url') ? wc_get_cart_url() : home_url('/cart'),
        'checkout_url'    => function_exists('wc_get_checkout_url') ? wc_get_checkout_url() : home_url('/checkout'),
        'ajax_url'        => admin_url('admin-ajax.php'),
        'is_wc_active'    => class_exists('WooCommerce'),
        'cart_nonce'      => wp_create_nonce('kash_cart_nonce'),
        'currency_symbol' => function_exists('get_woocommerce_currency_symbol') ? get_woocommerce_currency_symbol() : '₹',
    ));

    // WooCommerce Custom JS
    if (class_exists('WooCommerce')) {
        wp_enqueue_script(
            'kash-woocommerce-script',
            get_template_directory_uri() . '/assets/js/woocommerce-custom.js',
            array('jquery', 'kash-main-script'),
            '1.0.0',
            true
        );

        // Pass AJAX URL and Cart Nonce to JS
        wp_localize_script('kash-woocommerce-script', 'kash_wc_params', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'cart_url' => function_exists('wc_get_cart_url') ? wc_get_cart_url() : '',
            'checkout_url' => function_exists('wc_get_checkout_url') ? wc_get_checkout_url() : '',
            'currency_symbol' => function_exists('get_woocommerce_currency_symbol') ? get_woocommerce_currency_symbol() : '₹',
        ));
    }

    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'kash_naturals_scripts');
