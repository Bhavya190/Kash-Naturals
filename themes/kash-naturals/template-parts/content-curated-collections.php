<?php
/**
 * Curated 3-in-1-Row Product Catalog Showcase Template Part
 * Displays products from WooCommerce category (default: 'home') on an elegant light background
 *
 * @package KashNaturals
 */

if (!defined('ABSPATH')) {
    exit;
}

$is_enabled = (bool) get_theme_mod('kash_curated_enable', true);
if (!$is_enabled) {
    return;
}

$theme_uri = get_template_directory_uri();
$shop_url  = home_url('/shop');

$subheading = get_theme_mod('kash_curated_subheading', __('— SIGNATURE SELECTION —', 'kash-naturals'));
$heading    = get_theme_mod('kash_curated_heading', __('Curated For The Royal Taste', 'kash-naturals'));
$desc       = get_theme_mod('kash_curated_desc', __('Explore our signature handcrafted royal digestives, artisanal Belgian chocolates, and luxury treats.', 'kash-naturals'));

// Category & Query parameters
$custom_slug = trim((string) get_theme_mod('kash_curated_product_cat_slug', ''));
$cat_slug    = !empty($custom_slug) ? sanitize_title($custom_slug) : get_theme_mod('kash_curated_product_cat', 'home');
$prod_count  = intval(get_theme_mod('kash_curated_products_count', 3));

// Check front page post meta override if saved directly in page editor
$front_page_id = (int) get_option('page_on_front');
if ($front_page_id) {
    $meta_count = get_post_meta($front_page_id, '_kash_curated_products_count', true);
    if (!empty($meta_count) && is_numeric($meta_count) && intval($meta_count) > 0) {
        $prod_count = intval($meta_count);
    }
    $meta_cat = get_post_meta($front_page_id, '_kash_curated_product_cat', true);
    if (!empty($meta_cat)) {
        $cat_slug = sanitize_title($meta_cat);
    }
}

if ($prod_count <= 0) {
    $prod_count = 3;
}
$orderby_mod = get_theme_mod('kash_curated_orderby', 'menu_order');

$show_view_all = (bool) get_theme_mod('kash_curated_show_view_all', true);
$view_all_text = get_theme_mod('kash_curated_view_all_text', __('VIEW ALL HOME PRODUCTS', 'kash-naturals'));
$custom_view_url = trim((string) get_theme_mod('kash_curated_view_all_url', ''));

// Resolve View All URL
$view_all_url = $custom_view_url;
if (empty($view_all_url)) {
    if (!empty($cat_slug) && $cat_slug !== 'all') {
        $term = get_term_by('slug', $cat_slug, 'product_cat');
        if (!$term || is_wp_error($term)) {
            $term = get_term_by('name', $cat_slug, 'product_cat');
        }
        if ($term && !is_wp_error($term)) {
            $view_all_url = get_term_link($term);
        } else {
            $view_all_url = home_url('/product-category/' . $cat_slug . '/');
        }
    } else {
        $view_all_url = $shop_url;
    }
}

$products_list = array();
$currency_symbol = function_exists('get_woocommerce_currency_symbol') ? get_woocommerce_currency_symbol() : '₹';

if (class_exists('WooCommerce')) {
    // Map orderby
    $query_orderby = 'menu_order date';
    $query_order   = 'ASC';
    $meta_key      = '';

    switch ($orderby_mod) {
        case 'date':
            $query_orderby = 'date';
            $query_order   = 'DESC';
            break;
        case 'popularity':
            $query_orderby = 'meta_value_num';
            $meta_key      = 'total_sales';
            $query_order   = 'DESC';
            break;
        case 'rating':
            $query_orderby = 'meta_value_num';
            $meta_key      = '_wc_average_rating';
            $query_order   = 'DESC';
            break;
        case 'price':
            $query_orderby = 'meta_value_num';
            $meta_key      = '_price';
            $query_order   = 'ASC';
            break;
        case 'price-desc':
            $query_orderby = 'meta_value_num';
            $meta_key      = '_price';
            $query_order   = 'DESC';
            break;
        case 'menu_order':
        default:
            $query_orderby = 'menu_order date';
            $query_order   = 'ASC';
            break;
    }

    $query_args = array(
        'post_type'      => 'product',
        'post_status'    => 'publish',
        'posts_per_page' => $prod_count,
        'orderby'        => $query_orderby,
        'order'          => $query_order,
    );
    if (!empty($meta_key)) {
        $query_args['meta_key'] = $meta_key;
    }

    if (!empty($cat_slug) && $cat_slug !== 'all') {
        $slug_terms = array($cat_slug);
        if ($cat_slug === 'home') {
            $slug_terms = array('home', 'homepage', 'home-page');
        }
        $query_args['tax_query'] = array(
            array(
                'taxonomy'         => 'product_cat',
                'field'            => 'slug',
                'terms'            => $slug_terms,
                'operator'         => 'IN',
                'include_children' => true,
            ),
        );
    }

    $prod_query = new WP_Query($query_args);

    // Fallback: If category query returned 0 products, query published products so section is never blank
    if (!$prod_query->have_posts() && !empty($cat_slug) && $cat_slug !== 'all') {
        $fallback_args = array(
            'post_type'      => 'product',
            'post_status'    => 'publish',
            'posts_per_page' => $prod_count,
            'orderby'        => 'date',
            'order'          => 'DESC',
        );
        $prod_query = new WP_Query($fallback_args);
    }

    if ($prod_query->have_posts()) {
        while ($prod_query->have_posts()) {
            $prod_query->the_post();
            $wc_prod = wc_get_product(get_the_ID());
            if ($wc_prod && $wc_prod->is_visible()) {
                $pid = $wc_prod->get_id();

                $img_url = wp_get_attachment_image_url($wc_prod->get_image_id(), 'kash-product-card');
                if (!$img_url && function_exists('wc_placeholder_img_src')) {
                    $img_url = wc_placeholder_img_src();
                }
                if (!$img_url) {
                    $img_url = $theme_uri . '/assets/images/product-royal-mukhwas.jpg';
                }

                $is_variable = $wc_prod->is_type('variable');
                if ($is_variable) {
                    $sale_price    = $wc_prod->get_variation_price('min', true);
                    $reg_price     = $wc_prod->get_variation_regular_price('max', true);
                    $price_display = $wc_prod->get_price_html();
                    $is_sale       = $wc_prod->is_on_sale();
                } else {
                    $sale_price    = $wc_prod->get_price();
                    $reg_price     = $wc_prod->get_regular_price();
                    $price_display = !empty($sale_price) ? ($currency_symbol . $sale_price) : ($currency_symbol . '0');
                    $is_sale       = $wc_prod->is_on_sale() && !empty($reg_price) && floatval($reg_price) > floatval($sale_price);
                }

                $discount_pct = 0;
                $savings_display = '';
                if ($is_sale && floatval($reg_price) > 0 && floatval($sale_price) > 0) {
                    $savings_val  = floatval($reg_price) - floatval($sale_price);
                    $discount_pct = round(($savings_val / floatval($reg_price)) * 100);
                    $savings_display = sprintf(__('Save %s%s', 'kash-naturals'), $currency_symbol, number_format_i18n($savings_val));
                }

                $avg_rating = $wc_prod->get_average_rating();
                $rating_str = ($avg_rating > 0) ? number_format((float) $avg_rating, 1) : '5.0';

                // Category name
                $term_names = wp_get_post_terms($pid, 'product_cat', array('fields' => 'names'));
                $cat_badge = '';
                if (!empty($term_names) && !is_wp_error($term_names)) {
                    $filtered_names = array_filter($term_names, function($name) {
                        $low = strtolower($name);
                        return $low !== 'home' && $low !== 'uncategorized' && $low !== 'homepage';
                    });
                    $cat_badge = !empty($filtered_names) ? reset($filtered_names) : reset($term_names);
                }

                // Short Description
                $p_desc = $wc_prod->get_short_description();
                if (empty($p_desc)) {
                    $p_desc = wp_strip_all_tags(get_the_excerpt());
                }
                $p_desc_short = wp_trim_words($p_desc, 12, '...');

                $products_list[] = array(
                    'id'                => $pid,
                    'title'             => $wc_prod->get_name(),
                    'is_variable'       => $is_variable,
                    'link'              => get_permalink($pid),
                    'image'             => $img_url,
                    'category'          => $cat_badge,
                    'desc'              => $p_desc_short,
                    'rating'            => $rating_str,
                    'price_display'     => !empty($price_display) ? $price_display : (!empty($sale_price) ? ($currency_symbol . $sale_price) : ($currency_symbol . '0')),
                    'raw_price'         => $sale_price,
                    'old_price_display' => (!$is_variable && $is_sale) ? ($currency_symbol . $reg_price) : '',
                    'discount_pct'      => $discount_pct,
                    'savings_display'   => $savings_display,
                    'in_stock'          => $wc_prod->is_in_stock(),
                    'is_featured'       => $wc_prod->is_featured(),
                );
            }
        }
        wp_reset_postdata();
    }
}

// Fallback luxury sample products if catalog is completely empty or WooCommerce inactive
if (empty($products_list)) {
    $products_list = array(
        array(
            'id'                => 101,
            'title'             => __('Kash Natural Raj Ratan – Royal Digestive Mukhwas, 200g', 'kash-naturals'),
            'link'              => $shop_url,
            'image'             => $theme_uri . '/assets/images/product-royal-mukhwas.jpg',
            'category'          => __('MUKHWAS', 'kash-naturals'),
            'desc'              => __('Handcrafted royal recipe blended with aromatic fennel seeds, dry dates, and pure gulkand.', 'kash-naturals'),
            'rating'            => '5.0',
            'price_display'     => $currency_symbol . '179',
            'raw_price'         => '179',
            'old_price_display' => $currency_symbol . '300',
            'discount_pct'      => 40,
            'savings_display'   => __('Save ₹121', 'kash-naturals'),
            'in_stock'          => true,
            'is_featured'       => true,
        ),
        array(
            'id'                => 102,
            'title'             => __('Artisanal Belgian Chocolate Dragees Assortment, 180g', 'kash-naturals'),
            'link'              => $shop_url,
            'image'             => $theme_uri . '/assets/images/chocolate-dragees.jpg',
            'category'          => __('CHOCOLATES', 'kash-naturals'),
            'desc'              => __('Slow-roasted Californian almonds and pistachios generously coated in velvety Belgian chocolate.', 'kash-naturals'),
            'rating'            => '5.0',
            'price_display'     => $currency_symbol . '349',
            'raw_price'         => '349',
            'old_price_display' => $currency_symbol . '499',
            'discount_pct'      => 30,
            'savings_display'   => __('Save ₹150', 'kash-naturals'),
            'in_stock'          => true,
            'is_featured'       => false,
        ),
        array(
            'id'                => 103,
            'title'             => __('Curated Royal Festive Celebration Hamper Box', 'kash-naturals'),
            'link'              => $shop_url,
            'image'             => $theme_uri . '/assets/images/gift-combos.jpg',
            'category'          => __('ROYAL HAMPERS', 'kash-naturals'),
            'desc'              => __('Luxurious handcrafted gift assortment featuring premium digestive blends and gourmet treats.', 'kash-naturals'),
            'rating'            => '5.0',
            'price_display'     => $currency_symbol . '899',
            'raw_price'         => '899',
            'old_price_display' => $currency_symbol . '1299',
            'discount_pct'      => 31,
            'savings_display'   => __('Save ₹400', 'kash-naturals'),
            'in_stock'          => true,
            'is_featured'       => true,
        ),
    );
}
?>

<!-- Curated 3-in-1-Row Product Catalog Showcase Section -->
<section class="kash-curated-collections-section kash-curated-catalog-section" id="curated-catalog" aria-label="<?php esc_attr_e('Featured Home Collection', 'kash-naturals'); ?>">
    <div class="container">
        
        <!-- Section Header -->
        <div class="kash-curated-header text-center">
            <?php if (!empty($subheading)) : ?>
                <span class="kash-curated-eyebrow"><?php echo esc_html($subheading); ?></span>
            <?php endif; ?>

            <?php if (!empty($heading)) : ?>
                <h2 class="kash-curated-title"><?php echo esc_html($heading); ?></h2>
            <?php endif; ?>

            <div class="kash-curated-divider" aria-hidden="true">
                <span class="divider-line"></span>
                <span class="divider-icon"><i class="fa-solid fa-leaf"></i></span>
                <span class="divider-line"></span>
            </div>

            <?php if (!empty($desc)) : ?>
                <p class="kash-curated-desc"><?php echo esc_html($desc); ?></p>
            <?php endif; ?>
        </div>

        <!-- 3 Cards in 1 Row Grid -->
        <div class="kash-curated-grid kash-curated-product-grid">
            <?php foreach ($products_list as $item) : 
                $is_in_stock = isset($item['in_stock']) ? (bool) $item['in_stock'] : true;
            ?>
                <div class="kash-curated-card kash-product-catalog-card <?php echo !$is_in_stock ? 'item-out-of-stock' : ''; ?>">
                    <!-- Top Media Box -->
                    <div class="kash-curated-media">
                        <a href="<?php echo esc_url($item['link']); ?>" class="kash-curated-img-link" aria-label="<?php echo esc_attr($item['title']); ?>">
                            <img src="<?php echo esc_url($item['image']); ?>" alt="<?php echo esc_attr($item['title']); ?>" class="kash-curated-img" loading="lazy">
                        </a>

                        <!-- Discount / Promo Badge -->
                        <?php if (!empty($item['discount_pct']) && $item['discount_pct'] > 0) : ?>
                            <span class="kash-curated-badge-discount">
                                <i class="fa-solid fa-bolt"></i> <?php echo esc_html($item['discount_pct']); ?>% OFF
                            </span>
                        <?php elseif (!empty($item['is_featured'])) : ?>
                            <span class="kash-curated-badge-discount badge-featured">
                                <i class="fa-solid fa-star"></i> <?php esc_html_e('FEATURED', 'kash-naturals'); ?>
                            </span>
                        <?php endif; ?>

                        <!-- Rating Badge -->
                        <span class="kash-curated-badge-rating">
                            <i class="fa-solid fa-star"></i> <?php echo esc_html($item['rating']); ?>
                        </span>

                        <?php if (!$is_in_stock) : ?>
                            <div class="kash-curated-stock-badge-oos">
                                <i class="fa-solid fa-ban"></i> <?php esc_html_e('Out of Stock', 'kash-naturals'); ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Card Body -->
                    <div class="kash-curated-body">
                        <?php if (!empty($item['category'])) : ?>
                            <span class="kash-curated-card-cat"><?php echo esc_html($item['category']); ?></span>
                        <?php endif; ?>

                        <h3 class="kash-curated-card-title">
                            <a href="<?php echo esc_url($item['link']); ?>">
                                <?php echo esc_html($item['title']); ?>
                            </a>
                        </h3>

                        <?php if (!empty($item['desc'])) : ?>
                            <p class="kash-curated-card-desc"><?php echo esc_html($item['desc']); ?></p>
                        <?php endif; ?>

                        <!-- Price & Savings Row -->
                        <div class="kash-curated-price-row">
                            <div class="kash-curated-prices">
                                <span class="kash-curated-current-price"><?php echo esc_html($item['price_display']); ?></span>
                                <?php if (!empty($item['old_price_display'])) : ?>
                                    <span class="kash-curated-old-price"><?php echo esc_html($item['old_price_display']); ?></span>
                                <?php endif; ?>
                            </div>
                            <?php if (!empty($item['savings_display'])) : ?>
                                <span class="kash-curated-savings-tag"><?php echo esc_html($item['savings_display']); ?></span>
                            <?php endif; ?>
                        </div>

                        <!-- Card Action Buttons -->
                        <div class="kash-curated-actions">
                            <a href="<?php echo esc_url($item['link']); ?>" class="kash-curated-btn-view">
                                <span><?php esc_html_e('View Product', 'kash-naturals'); ?></span>
                                <i class="fa-solid fa-arrow-right"></i>
                            </a>

                            <?php if ($is_in_stock) : ?>
                                <?php if (!empty($item['is_variable'])) : ?>
                                    <a href="<?php echo esc_url($item['link']); ?>" class="kash-curated-btn-cart" style="text-decoration:none;" aria-label="<?php echo esc_attr(sprintf(__('Choose pack size for %s', 'kash-naturals'), $item['title'])); ?>">
                                        <i class="fa-solid fa-layer-group"></i>
                                        <span><?php esc_html_e('Select Options', 'kash-naturals'); ?></span>
                                    </a>
                                <?php else : ?>
                                    <button type="button" class="kash-curated-btn-cart add-to-cart-btn add_to_cart_button ajax_add_to_cart" 
                                        data-product-id="<?php echo esc_attr($item['id']); ?>" 
                                        data-product_id="<?php echo esc_attr($item['id']); ?>" 
                                        data-product-name="<?php echo esc_attr($item['title']); ?>" 
                                        data-product-price="<?php echo esc_attr($item['raw_price']); ?>" 
                                        data-product-img="<?php echo esc_url($item['image']); ?>" 
                                        aria-label="<?php echo esc_attr(sprintf(__('Add %s to cart', 'kash-naturals'), $item['title'])); ?>"
                                        title="<?php esc_attr_e('Add to Cart', 'kash-naturals'); ?>">
                                        <i class="fa-solid fa-cart-plus"></i>
                                        <span><?php esc_html_e('Add to Cart', 'kash-naturals'); ?></span>
                                    </button>
                                <?php endif; ?>
                            <?php else : ?>
                                <button type="button" class="kash-curated-btn-cart is-oos" disabled title="<?php esc_attr_e('Out of stock', 'kash-naturals'); ?>">
                                    <i class="fa-solid fa-ban"></i>
                                    <span><?php esc_html_e('Out of Stock', 'kash-naturals'); ?></span>
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Section Footer CTA Button -->
        <?php if ($show_view_all && !empty($view_all_url)) : ?>
            <div class="kash-curated-footer-cta text-center">
                <a href="<?php echo esc_url($view_all_url); ?>" class="kash-curated-view-all-btn">
                    <span><?php echo esc_html($view_all_text); ?></span>
                    <i class="fa-solid fa-arrow-right"></i>
                </a>

                <div class="kash-curated-trust-pills">
                    <span><i class="fa-solid fa-leaf"></i> <?php esc_html_e('100% Natural', 'kash-naturals'); ?></span>
                    <span><i class="fa-solid fa-shield-halved"></i> <?php esc_html_e('Zero Preservatives', 'kash-naturals'); ?></span>
                    <span><i class="fa-solid fa-award"></i> <?php esc_html_e('Royal Heritage Taste', 'kash-naturals'); ?></span>
                </div>
            </div>
        <?php endif; ?>

    </div>
</section>
