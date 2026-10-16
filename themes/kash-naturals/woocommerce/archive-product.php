<?php
/**
 * The Template for displaying product archives, including the main shop page
 * Luxury Kash Naturals Artisanal Shop & Collection Design
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

// 1. Identify active category (from URL param or WooCommerce taxonomy query)
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

// 2. Fetch all published WooCommerce Product Categories for Filter Tabs
$active_categories = array('all' => __('All Products', 'kash-naturals'));
if (class_exists('WooCommerce')) {
    $wc_terms = get_terms(array(
        'taxonomy'   => 'product_cat',
        'hide_empty' => false,
        'parent'     => 0,
        'exclude'    => array(get_option('default_product_cat')),
    ));
    if (!empty($wc_terms) && !is_wp_error($wc_terms)) {
        foreach ($wc_terms as $t) {
            $active_categories[$t->slug] = $t->name;
        }
    }
}

// 3. Page Title & Breadcrumb labels
if ($current_category !== 'all' && !empty($current_category_name)) {
    $page_display_title = $current_category_name . ' ' . __('Collection', 'kash-naturals');
} elseif ($current_category !== 'all' && isset($active_categories[$current_category])) {
    $page_display_title = $active_categories[$current_category] . ' ' . __('Collection', 'kash-naturals');
} elseif ($current_category !== 'all') {
    $page_display_title = ucfirst(str_replace('-', ' ', $current_category)) . ' ' . __('Collection', 'kash-naturals');
} else {
    $page_display_title = __('All Products', 'kash-naturals');
}

// 4. Sorting / Orderby Handling
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

// 5. Query Dynamic WooCommerce Products
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

    $shop_query = new WP_Query($shop_args);

    if ($shop_query->have_posts()) {
        $currency_symbol = function_exists('get_woocommerce_currency_symbol') ? get_woocommerce_currency_symbol() : '₹';
        while ($shop_query->have_posts()) {
            $shop_query->the_post();
            $wc_prod = wc_get_product(get_the_ID());
            if ($wc_prod && $wc_prod->is_visible()) {
                $img_url = wp_get_attachment_image_url($wc_prod->get_image_id(), 'kash-product-card');
                if (!$img_url && function_exists('wc_placeholder_img_src')) {
                    $img_url = wc_placeholder_img_src();
                }

                $cats = wc_get_product_category_list($wc_prod->get_id());
                $cat_names = wp_strip_all_tags($cats);

                $sale_price = $wc_prod->get_price();
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

<!-- Main Shop Container -->
<section class="shop-main-section">
    <div class="container">
        
        <!-- Category Filter Tabs Bar & Sorting -->
        <div class="shop-filter-bar-exact">
            <?php /* Category pills temporarily hidden as requested
            <div class="filter-pills-exact">
                <a href="<?php echo esc_url($shop_base_url); ?>" class="filter-pill-btn <?php echo ($current_category === 'all') ? 'active' : ''; ?>">
                    <i class="fa-solid fa-border-all"></i> <?php esc_html_e('All Products', 'kash-naturals'); ?>
                </a>
                <?php if (count($active_categories) > 1) : ?>
                    <?php foreach ($active_categories as $c_slug => $c_name) : 
                        if ($c_slug === 'all') continue; ?>
                        <a href="<?php echo esc_url(add_query_arg('category', $c_slug, $shop_base_url)); ?>" class="filter-pill-btn <?php echo ($current_category === $c_slug) ? 'active' : ''; ?>">
                            <i class="fa-solid fa-leaf"></i> <?php echo esc_html($c_name); ?>
                        </a>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            */ ?>
            
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
                    $curr_page_url = $current_category !== 'all' ? add_query_arg('category', $current_category, $shop_base_url) : $shop_base_url;
                    foreach ($sort_options as $s_val => $s_label) :
                        $opt_url = add_query_arg('orderby', $s_val, $curr_page_url);
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
                <h2 class="empty-state-title"><?php esc_html_e('No Products Found', 'kash-naturals'); ?></h2>
                <p class="empty-state-desc"><?php esc_html_e('There are currently no products available in this collection.', 'kash-naturals'); ?></p>
                <?php if ($current_category !== 'all') : ?>
                    <a href="<?php echo esc_url($shop_base_url); ?>" class="cat-card-shop-btn" style="display:inline-flex; width:auto; padding:12px 28px; margin-top:15px;">
                        <i class="fa-solid fa-rotate-left"></i> &nbsp; <?php esc_html_e('View All Products', 'kash-naturals'); ?>
                    </a>
                <?php endif; ?>
            </div>
        <?php endif; ?>

    </div>
</section>

<!-- Shop on Amazon Banner Section -->
<?php get_template_part('template-parts/content', 'amazon-banner'); ?>

<?php
get_footer();
