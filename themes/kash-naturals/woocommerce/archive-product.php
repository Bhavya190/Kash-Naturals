<?php
/**
 * The Template for displaying product archives, including the main shop page
 * Luxury Kash Naturals Artisanal Shop & Collection Design with Amazon-Style Left Sidebar Filter
 *
 * @package KashNaturals
 */

if (!defined('ABSPATH')) {
    exit;
}

if (!function_exists('add_query_arg')) {
    function add_query_arg($key, $value, $url = '') {
        $url = empty($url) ? (isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '') : $url;
        $sep = (strpos($url, '?') !== false) ? '&' : '?';
        return $url . $sep . urlencode((string)$key) . '=' . urlencode((string)$value);
    }
}

get_header();

$theme_uri = get_template_directory_uri();
$shop_base_url = function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : home_url('/shop');
if (empty($shop_base_url)) {
    $shop_base_url = home_url('/shop');
}

// 1. Identify active category (from taxonomy query or URL parameter)
$current_category = 'all';
$current_category_name = '';

if (function_exists('is_product_category') && is_product_category()) {
    $queried_term = get_queried_object();
    if ($queried_term && isset($queried_term->slug)) {
        $current_category = $queried_term->slug;
        $current_category_name = $queried_term->name;
    }
} elseif (isset($_GET['category']) && !empty($_GET['category'])) {
    $raw_category = sanitize_text_field($_GET['category']);
    if ($raw_category !== 'all') {
        $current_category = $raw_category;
        if (class_exists('WooCommerce')) {
            $t = get_term_by('slug', $current_category, 'product_cat');
            if ($t && !is_wp_error($t)) {
                $current_category_name = $t->name;
            }
        }
    }
}

// 2. Fetch all WooCommerce Product Categories for the Department Filter
$all_categories = array();
$total_products_count = 0;

if (class_exists('WooCommerce')) {
    $default_cat_id = (int) get_option('default_product_cat');
    $wc_terms = get_terms(array(
        'taxonomy'   => 'product_cat',
        'hide_empty' => false,
    ));

    if (!empty($wc_terms) && !is_wp_error($wc_terms)) {
        foreach ($wc_terms as $t) {
            if ($t->term_id === $default_cat_id || strtolower($t->slug) === 'uncategorized') {
                continue;
            }
            $all_categories[] = array(
                'id'    => $t->term_id,
                'slug'  => $t->slug,
                'name'  => $t->name,
                'count' => (int) $t->count,
                'link'  => get_term_link($t),
            );
            $total_products_count += (int) $t->count;
        }
    }
}

// 3. Price Filter Handling (Radio brackets or Min/Max inputs)
$min_price = isset($_GET['min_price']) && is_numeric($_GET['min_price']) ? floatval($_GET['min_price']) : 0;
$max_price = isset($_GET['max_price']) && is_numeric($_GET['max_price']) ? floatval($_GET['max_price']) : 0;
$price_range = isset($_GET['price_range']) ? sanitize_text_field($_GET['price_range']) : '';

if (!empty($price_range) && $price_range !== 'all') {
    $parts = explode('-', $price_range);
    if (isset($parts[0]) && is_numeric($parts[0])) {
        $min_price = floatval($parts[0]);
    }
    if (isset($parts[1])) {
        if (is_numeric($parts[1])) {
            $max_price = floatval($parts[1]);
        } elseif ($parts[1] === 'above') {
            $max_price = 0;
        }
    }
}

// Predefined price brackets
$price_filters = array(
    'all' => array(
        'label' => __('All Prices', 'kash-naturals'),
        'min'   => 0,
        'max'   => 0,
    ),
    '0-200' => array(
        'label' => __('Under ₹200', 'kash-naturals'),
        'min'   => 0,
        'max'   => 200,
    ),
    '200-500' => array(
        'label' => __('₹200 to ₹500', 'kash-naturals'),
        'min'   => 200,
        'max'   => 500,
    ),
    '500-1000' => array(
        'label' => __('₹500 to ₹1,000', 'kash-naturals'),
        'min'   => 500,
        'max'   => 1000,
    ),
    '1000-above' => array(
        'label' => __('Over ₹1,000', 'kash-naturals'),
        'min'   => 1000,
        'max'   => 0,
    ),
);

// Active Filter Checks
$is_cat_filtered = ($current_category !== 'all');
$is_price_filtered = (!empty($price_range) && $price_range !== 'all') || ($min_price > 0 || $max_price > 0);
$active_filters_count = ($is_cat_filtered ? 1 : 0) + ($is_price_filtered ? 1 : 0);

$active_price_label = '';
if ($is_price_filtered) {
    if (isset($price_filters[$price_range])) {
        $active_price_label = $price_filters[$price_range]['label'];
    } elseif ($min_price > 0 && $max_price > 0) {
        $active_price_label = sprintf('₹%s - ₹%s', number_format_i18n($min_price), number_format_i18n($max_price));
    } elseif ($min_price > 0) {
        $active_price_label = sprintf('Over ₹%s', number_format_i18n($min_price));
    } elseif ($max_price > 0) {
        $active_price_label = sprintf('Under ₹%s', number_format_i18n($max_price));
    }
}

// 4. Page Title & Breadcrumb labels
if ($current_category !== 'all' && !empty($current_category_name)) {
    $page_display_title = $current_category_name . ' ' . __('Collection', 'kash-naturals');
} elseif ($current_category !== 'all') {
    $page_display_title = ucfirst(str_replace('-', ' ', $current_category)) . ' ' . __('Collection', 'kash-naturals');
} else {
    $page_display_title = __('All Products', 'kash-naturals');
}

// 5. Sorting / Orderby Handling
$orderby = isset($_GET['orderby']) ? sanitize_text_field($_GET['orderby']) : 'menu_order';
$order_args = array();

switch ($orderby) {
    case 'price':
        $order_args = array('meta_key' => '_price', 'orderby' => 'meta_value_num', 'order' => 'ASC');
        break;
    case 'price-desc':
        $order_args = array('meta_key' => '_price', 'orderby' => 'meta_value_num', 'order' => 'DESC');
        break;
    case 'rating':
        $order_args = array('meta_key' => '_wc_average_rating', 'orderby' => 'meta_value_num', 'order' => 'DESC');
        break;
    case 'date':
        $order_args = array('orderby' => 'date', 'order' => 'DESC');
        break;
    case 'popularity':
        $order_args = array('meta_key' => 'total_sales', 'orderby' => 'meta_value_num', 'order' => 'DESC');
        break;
    default:
        $order_args = array('orderby' => 'menu_order date', 'order' => 'ASC');
        break;
}

// Helper: Construct Filter URLs preserving active filters
function kash_build_shop_filter_url($target_cat = null, $target_price_key = null, $target_min = null, $target_max = null) {
    global $current_category, $shop_base_url, $price_range, $min_price, $max_price, $orderby;

    $cat_slug = ($target_cat !== null) ? $target_cat : $current_category;
    
    // Base archive link
    if ($cat_slug === 'all' || empty($cat_slug)) {
        $base = $shop_base_url;
    } else {
        $term = get_term_by('slug', $cat_slug, 'product_cat');
        if ($term && !is_wp_error($term)) {
            $base = get_term_link($term);
        } else {
            $base = home_url('/product-category/' . sanitize_title($cat_slug) . '/');
        }
    }

    $params = array();

    // Price parameter
    if ($target_price_key !== null) {
        if ($target_price_key !== 'all' && !empty($target_price_key)) {
            $params['price_range'] = $target_price_key;
        }
    } elseif (!empty($price_range) && $price_range !== 'all') {
        $params['price_range'] = $price_range;
    } elseif ($target_min !== null || $target_max !== null) {
        if ($target_min > 0) $params['min_price'] = $target_min;
        if ($target_max > 0) $params['max_price'] = $target_max;
    } elseif ($min_price > 0 || $max_price > 0) {
        if ($min_price > 0) $params['min_price'] = $min_price;
        if ($max_price > 0) $params['max_price'] = $max_price;
    }

    // Orderby
    if (!empty($orderby) && $orderby !== 'menu_order') {
        $params['orderby'] = $orderby;
    }

    $final_url = $base;
    if (!empty($params)) {
        $final_url = add_query_arg($params, $base);
    }
    return $final_url;
}

// 6. Query Dynamic WooCommerce Products
$dynamic_products = array();

if (class_exists('WooCommerce')) {
    $shop_args = array_merge(array(
        'post_type'      => 'product',
        'post_status'    => 'publish',
        'posts_per_page' => 48,
    ), $order_args);

    if ($current_category !== 'all' && term_exists($current_category, 'product_cat')) {
        $shop_args['tax_query'] = array(
            array(
                'taxonomy' => 'product_cat',
                'field'    => 'slug',
                'terms'    => $current_category,
            ),
        );
    }

    // Price Filter Meta Query
    $meta_query = array();
    if ($min_price > 0 && $max_price > 0) {
        $meta_query[] = array(
            'key'     => '_price',
            'value'   => array($min_price, $max_price),
            'compare' => 'BETWEEN',
            'type'    => 'NUMERIC',
        );
    } elseif ($min_price > 0) {
        $meta_query[] = array(
            'key'     => '_price',
            'value'   => $min_price,
            'compare' => '>=',
            'type'    => 'NUMERIC',
        );
    } elseif ($max_price > 0) {
        $meta_query[] = array(
            'key'     => '_price',
            'value'   => $max_price,
            'compare' => '<=',
            'type'    => 'NUMERIC',
        );
    }
    if (!empty($meta_query)) {
        $shop_args['meta_query'] = $meta_query;
    }

    $shop_query = new WP_Query($shop_args);

    if ($shop_query->have_posts()) {
        $currency_symbol = function_exists('get_woocommerce_currency_symbol') ? get_woocommerce_currency_symbol() : '₹';
        while ($shop_query->have_posts()) {
            $shop_query->the_post();
            $wc_prod = wc_get_product(get_the_ID());
            if ($wc_prod && $wc_prod->is_visible()) {
                $sale_price = $wc_prod->get_price();
                $raw_price = floatval($sale_price);

                // Precise price filter validation
                if ($min_price > 0 && $raw_price < $min_price) {
                    continue;
                }
                if ($max_price > 0 && $raw_price > $max_price) {
                    continue;
                }

                $img_url = wp_get_attachment_image_url($wc_prod->get_image_id(), 'kash-product-card');
                if (!$img_url && function_exists('wc_placeholder_img_src')) {
                    $img_url = wc_placeholder_img_src();
                }

                $cats = wc_get_product_category_list($wc_prod->get_id());
                $cat_names = wp_strip_all_tags($cats);

                $reg_price = $wc_prod->get_regular_price();

                $badge = 'Fresh Batch';
                if (!$wc_prod->is_in_stock()) {
                    $badge = 'Out of Stock';
                } elseif ($wc_prod->is_on_sale()) {
                    $badge = 'Sale';
                } elseif ($wc_prod->is_featured()) {
                    $badge = 'Featured';
                }

                $rating = $wc_prod->get_average_rating();
                $rating_str = ($rating > 0) ? number_format((float)$rating, 1) : '5.0';

                $desc = $wc_prod->get_short_description();
                if (empty($desc)) {
                    $desc = wp_strip_all_tags(get_the_excerpt());
                }

                $dynamic_products[] = array(
                    'id'            => $wc_prod->get_id(),
                    'name'          => $wc_prod->get_name(),
                    'category'      => $current_category,
                    'category_name' => !empty($cat_names) ? $cat_names : __('Specialty', 'kash-naturals'),
                    'price'         => !empty($sale_price) ? $currency_symbol . $sale_price : $currency_symbol . '0',
                    'raw_price'     => !empty($sale_price) ? $sale_price : 0,
                    'regular_price' => (!empty($reg_price) && $reg_price > $sale_price) ? $currency_symbol . $reg_price : '',
                    'image'         => $img_url,
                    'badge'         => $badge,
                    'rating'        => $rating_str,
                    'desc'          => wp_trim_words($desc, 12, '...'),
                    'link'          => get_permalink($wc_prod->get_id()),
                    'in_stock'      => $wc_prod->is_in_stock(),
                    'stock_status'  => $wc_prod->get_stock_status(),
                );
            }
        }
        wp_reset_postdata();
    }
}

$filtered_products = $dynamic_products;
$current_page_base = ($current_category !== 'all' && is_product_category()) ? get_term_link(get_queried_object()) : $shop_base_url;
?>

<!-- Luxury Page Header Banner -->
<div class="shop-page-header">
    <div class="container text-center">
        <span class="shop-header-subtitle"><?php esc_html_e('100% NATURAL • ARTISANAL QUALITY • PAN-INDIA DELIVERY', 'kash-naturals'); ?></span>
        <h1 class="shop-header-title"><?php echo esc_html($page_display_title); ?></h1>
        <div class="shop-breadcrumb">
            <a href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('Home', 'kash-naturals'); ?></a>
            <span class="sep">/</span>
            <a href="<?php echo esc_url($shop_base_url); ?>"><?php esc_html_e('Shop', 'kash-naturals'); ?></a>
            <?php if ($current_category !== 'all') : ?>
                <span class="sep">/</span>
                <span class="current"><?php echo esc_html(str_replace(' Collection', '', $page_display_title)); ?></span>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Main Shop Container with 2-Column Sidebar Layout -->
<section class="shop-main-section">
    <div class="container">
        
        <!-- 2-Column Shop Content Layout: Left Filter Sidebar + Right Products Grid -->
        <div class="shop-layout-with-sidebar">
            
            <!-- Left Filter Sidebar (Amazon-Style Radio Buttons & Price Inputs) -->
            <aside class="shop-filter-sidebar" id="kashShopSidebar" aria-label="<?php esc_attr_e('Product Filters', 'kash-naturals'); ?>">
                
                <!-- Mobile Drawer Header -->
                <div class="kash-filter-drawer-header">
                    <h3 class="kash-filter-drawer-title">
                        <i class="fa-solid fa-sliders"></i> <?php esc_html_e('Filter Products', 'kash-naturals'); ?>
                    </h3>
                    <button type="button" class="kash-filter-close-btn" id="kashFilterCloseBtn" aria-label="<?php esc_attr_e('Close Filters', 'kash-naturals'); ?>">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>

                <!-- Active Filters Chips / Reset Bar -->
                <?php if ($is_cat_filtered || $is_price_filtered) : ?>
                    <div class="kash-active-filters-wrap">
                        <div class="kash-active-filters-top">
                            <span class="kash-active-filters-label"><?php esc_html_e('Active Filters:', 'kash-naturals'); ?></span>
                            <a href="<?php echo esc_url($shop_base_url); ?>" class="kash-clear-all-link">
                                <?php esc_html_e('Clear all', 'kash-naturals'); ?>
                            </a>
                        </div>
                        <div class="kash-active-tags-list">
                            <?php if ($is_cat_filtered) : ?>
                                <a href="<?php echo esc_url(kash_build_shop_filter_url('all', null)); ?>" class="kash-active-tag" title="<?php esc_attr_e('Remove category filter', 'kash-naturals'); ?>">
                                    <span><?php echo esc_html($current_category_name ? $current_category_name : ucfirst($current_category)); ?></span>
                                    <i class="fa-solid fa-xmark"></i>
                                </a>
                            <?php endif; ?>

                            <?php if ($is_price_filtered) : ?>
                                <a href="<?php echo esc_url(kash_build_shop_filter_url(null, 'all', 0, 0)); ?>" class="kash-active-tag" title="<?php esc_attr_e('Remove price filter', 'kash-naturals'); ?>">
                                    <span><?php echo esc_html($active_price_label); ?></span>
                                    <i class="fa-solid fa-xmark"></i>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- 1. Department / Categories Filter Group -->
                <div class="kash-filter-group">
                    <h4 class="kash-filter-group-title"><?php esc_html_e('Department', 'kash-naturals'); ?></h4>
                    
                    <div class="kash-filter-options-list">
                        <!-- "All" Radio Option -->
                        <a href="<?php echo esc_url(kash_build_shop_filter_url('all', null)); ?>" class="kash-filter-radio-item <?php echo ($current_category === 'all') ? 'is-active' : ''; ?>">
                            <span class="kash-radio-circle" aria-hidden="true"></span>
                            <span class="kash-filter-label"><?php esc_html_e('All', 'kash-naturals'); ?></span>
                        </a>

                        <!-- Dynamic Category Radio Items -->
                        <?php 
                        $cat_idx = 0;
                        foreach ($all_categories as $cat_item) : 
                            $cat_idx++;
                            $is_this_cat_active = ($current_category === $cat_item['slug']);
                            $is_hidden_slot = ($cat_idx > 5);
                        ?>
                            <a href="<?php echo esc_url(kash_build_shop_filter_url($cat_item['slug'], null)); ?>" 
                               class="kash-filter-radio-item <?php echo $is_this_cat_active ? 'is-active' : ''; ?> <?php echo $is_hidden_slot ? 'kash-cat-extra' : ''; ?>"
                               <?php echo $is_hidden_slot ? 'style="display:none;"' : ''; ?>>
                                <span class="kash-radio-circle" aria-hidden="true"></span>
                                <span class="kash-filter-label"><?php echo esc_html($cat_item['name']); ?></span>
                                <?php if ($cat_item['count'] > 0) : ?>
                                    <span class="kash-filter-count">(<?php echo intval($cat_item['count']); ?>)</span>
                                <?php endif; ?>
                            </a>
                        <?php endforeach; ?>

                        <?php if (count($all_categories) > 5) : ?>
                            <button type="button" class="kash-see-more-btn" id="kashSeeMoreCatsBtn" aria-expanded="false">
                                <i class="fa-solid fa-chevron-down"></i>
                                <span class="btn-text"><?php esc_html_e('See more', 'kash-naturals'); ?></span>
                            </button>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="kash-filter-divider" aria-hidden="true"></div>

                <!-- 2. Price Filter Group -->
                <div class="kash-filter-group">
                    <h4 class="kash-filter-group-title"><?php esc_html_e('Price', 'kash-naturals'); ?></h4>

                    <div class="kash-filter-options-list">
                        <?php foreach ($price_filters as $p_key => $p_data) : 
                            $is_this_price_active = false;
                            if ($p_key === 'all' && !$is_price_filtered) {
                                $is_this_price_active = true;
                            } elseif ($price_range === $p_key) {
                                $is_this_price_active = true;
                            } elseif ($p_key !== 'all' && $min_price == $p_data['min'] && ($p_data['max'] == 0 ? $max_price == 0 : $max_price == $p_data['max'])) {
                                $is_this_price_active = true;
                            }
                        ?>
                            <a href="<?php echo esc_url(kash_build_shop_filter_url(null, $p_key, $p_data['min'], $p_data['max'])); ?>" class="kash-filter-radio-item <?php echo $is_this_price_active ? 'is-active' : ''; ?>">
                                <span class="kash-radio-circle" aria-hidden="true"></span>
                                <span class="kash-filter-label"><?php echo esc_html($p_data['label']); ?></span>
                            </a>
                        <?php endforeach; ?>
                    </div>

                    <!-- Custom Min / Max Price Form with "Go" Button -->
                    <form method="get" action="<?php echo esc_url($current_page_base); ?>" class="kash-price-custom-form">
                        <?php if ($current_category !== 'all' && !is_product_category()) : ?>
                            <input type="hidden" name="category" value="<?php echo esc_attr($current_category); ?>">
                        <?php endif; ?>
                        <?php if (!empty($orderby) && $orderby !== 'menu_order') : ?>
                            <input type="hidden" name="orderby" value="<?php echo esc_attr($orderby); ?>">
                        <?php endif; ?>

                        <div class="kash-price-inputs-row">
                            <div class="kash-price-input-wrap">
                                <span>₹</span>
                                <input type="number" name="min_price" value="<?php echo ($min_price > 0) ? esc_attr($min_price) : ''; ?>" placeholder="<?php esc_attr_e('Min', 'kash-naturals'); ?>" min="0" step="10" aria-label="<?php esc_attr_e('Minimum price', 'kash-naturals'); ?>">
                            </div>
                            <span class="kash-price-sep">–</span>
                            <div class="kash-price-input-wrap">
                                <span>₹</span>
                                <input type="number" name="max_price" value="<?php echo ($max_price > 0) ? esc_attr($max_price) : ''; ?>" placeholder="<?php esc_attr_e('Max', 'kash-naturals'); ?>" min="0" step="10" aria-label="<?php esc_attr_e('Maximum price', 'kash-naturals'); ?>">
                            </div>
                            <button type="submit" class="kash-price-go-btn" title="<?php esc_attr_e('Apply custom price range', 'kash-naturals'); ?>">
                                <?php esc_html_e('Go', 'kash-naturals'); ?>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Mobile Drawer Apply Button -->
                <div class="kash-mobile-filter-apply-bar">
                    <button type="button" class="kash-mobile-apply-btn" id="kashMobileApplyBtn">
                        <?php esc_html_e('View Results', 'kash-naturals'); ?>
                    </button>
                </div>

            </aside>

            <!-- Right Products Main Column -->
            <main class="shop-products-main-col">
                
                <!-- Filter Bar: Mobile Trigger & Sorting Controls -->
                <div class="shop-filter-bar-exact">
                    
                    <!-- Mobile Filter Trigger Button -->
                    <button type="button" class="kash-mobile-filter-trigger" id="kashFilterToggleBtn" aria-expanded="false" aria-controls="kashShopSidebar">
                        <i class="fa-solid fa-sliders"></i>
                        <span><?php esc_html_e('Filters', 'kash-naturals'); ?></span>
                        <?php if ($active_filters_count > 0) : ?>
                            <span class="kash-filter-active-pill"><?php echo intval($active_filters_count); ?></span>
                        <?php endif; ?>
                    </button>

                    <div class="shop-filter-right-controls">
                        <div class="filter-count-label">
                            <?php printf(esc_html__('Showing %d Items', 'kash-naturals'), count($filtered_products)); ?>
                        </div>

                        <!-- Custom Luxury Sort Dropdown -->
                        <select class="shop-sort-select" onchange="window.location.href=this.value;" aria-label="<?php esc_attr_e('Sort Products', 'kash-naturals'); ?>">
                            <?php
                            $sort_options = array(
                                'menu_order' => __('Default Sorting', 'kash-naturals'),
                                'popularity' => __('Sort by Popularity', 'kash-naturals'),
                                'rating'     => __('Sort by Average Rating', 'kash-naturals'),
                                'date'       => __('Sort by Latest', 'kash-naturals'),
                                'price'      => __('Price: Low to High', 'kash-naturals'),
                                'price-desc' => __('Price: High to Low', 'kash-naturals'),
                            );
                            foreach ($sort_options as $s_val => $s_label) :
                                $opt_url = add_query_arg('orderby', $s_val);
                                $is_selected = ($orderby === $s_val) ? 'selected' : '';
                                ?>
                                <option value="<?php echo esc_url($opt_url); ?>" <?php echo $is_selected; ?>>
                                    <?php echo esc_html($s_label); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <!-- Products Grid -->
                <?php if (!empty($filtered_products)) : ?>
                    <div class="shop-grid-exact">
                        <?php foreach ($filtered_products as $prod) : 
                            $prod_link = !empty($prod['link']) ? $prod['link'] : $shop_base_url;
                            $is_in_stock = isset($prod['in_stock']) ? !empty($prod['in_stock']) : true;
                        ?>
                            <div class="shop-product-card-exact <?php echo !$is_in_stock ? 'card-out-of-stock' : ''; ?>">
                                <?php if (!$is_in_stock) : ?>
                                    <span class="product-badge-tag badge-out-of-stock"><?php esc_html_e('Out of Stock', 'kash-naturals'); ?></span>
                                <?php else : ?>
                                    <span class="product-badge-tag"><?php echo esc_html($prod['badge']); ?></span>
                                <?php endif; ?>

                                <a href="<?php echo esc_url($prod_link); ?>" class="product-img-box-exact">
                                    <img src="<?php echo esc_url($prod['image']); ?>" alt="<?php echo esc_attr($prod['name']); ?>" loading="lazy">
                                </a>
                                <div class="product-card-info">
                                    <div class="product-cat-label"><?php echo esc_html($prod['category_name']); ?></div>
                                    <h3 class="product-title-exact">
                                        <a href="<?php echo esc_url($prod_link); ?>" style="color: inherit; text-decoration: none;">
                                            <?php echo esc_html($prod['name']); ?>
                                        </a>
                                    </h3>
                                    <p class="product-desc-short"><?php echo esc_html($prod['desc']); ?></p>
                                    <div class="product-rating-stars">★★★★★ <span>(<?php echo esc_html($prod['rating']); ?>)</span></div>
                                    <div class="product-price-row-exact">
                                        <div class="price-wrap">
                                            <span class="current-price"><?php echo esc_html($prod['price']); ?></span>
                                            <?php if (!empty($prod['regular_price'])) : ?>
                                                <span class="old-price"><?php echo esc_html($prod['regular_price']); ?></span>
                                            <?php endif; ?>
                                        </div>
                                        <?php if ($is_in_stock) : ?>
                                            <button type="button" class="btn-add-cart-exact add-to-cart-btn add_to_cart_button ajax_add_to_cart" data-product-id="<?php echo esc_attr($prod['id']); ?>" data-product_id="<?php echo esc_attr($prod['id']); ?>" data-product-name="<?php echo esc_attr($prod['name']); ?>" data-product-price="<?php echo esc_attr($prod['raw_price']); ?>" data-product-img="<?php echo esc_url($prod['image']); ?>">
                                                <i class="fa-solid fa-cart-plus"></i> <?php esc_html_e('ADD TO CART', 'kash-naturals'); ?>
                                            </button>
                                        <?php else : ?>
                                            <button type="button" class="btn-add-cart-exact btn-out-of-stock" disabled title="<?php esc_attr_e('Product is currently out of stock', 'kash-naturals'); ?>">
                                                <i class="fa-solid fa-ban"></i> <?php esc_html_e('OUT OF STOCK', 'kash-naturals'); ?>
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else : ?>
                    <div class="kash-empty-products-state text-center py-5">
                        <div class="empty-state-icon">
                            <i class="fa-solid fa-box-open"></i>
                        </div>
                        <h2 class="empty-state-title"><?php esc_html_e('No Products Match Your Filter', 'kash-naturals'); ?></h2>
                        <p class="empty-state-desc"><?php esc_html_e('Try selecting a different category or adjusting your price range.', 'kash-naturals'); ?></p>
                        <a href="<?php echo esc_url($shop_base_url); ?>" class="cat-card-shop-btn" style="display:inline-flex; width:auto; padding:12px 28px; margin-top:15px;">
                            <i class="fa-solid fa-rotate-left"></i> &nbsp; <?php esc_html_e('Clear All Filters', 'kash-naturals'); ?>
                        </a>
                    </div>
                <?php endif; ?>

            </main>

        </div>

    </div>
</section>

<!-- Mobile Filter Backdrop Overlay -->
<div class="kash-sidebar-backdrop" id="kashSidebarBackdrop" aria-hidden="true"></div>

<!-- Shop on Amazon Banner Section -->
<?php get_template_part('template-parts/content', 'amazon-banner'); ?>

<?php
get_footer();
