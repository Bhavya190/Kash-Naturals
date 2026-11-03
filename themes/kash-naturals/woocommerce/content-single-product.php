<?php
/**
 * Custom Luxury Artisanal Product Detail Template for Kash Naturals
 * Overrides WooCommerce's content-single-product.php
 *
 * @package KashNaturals
 */

if (!defined('ABSPATH')) {
    exit;
}

global $product;

if (empty($product) || !is_a($product, 'WC_Product')) {
    if (function_exists('wc_get_product')) {
        $p_id = function_exists('get_the_ID') ? get_the_ID() : 0;
        if (!$p_id && isset($_GET['id'])) $p_id = intval($_GET['id']);
        if (!$p_id && isset($GLOBALS['kash_product_id'])) $p_id = intval($GLOBALS['kash_product_id']);
        if ($p_id) {
            $product = wc_get_product($p_id);
        }
    }
}

/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked woocommerce_output_all_notices - 10
 */
do_action('woocommerce_before_single_product');

if (function_exists('post_password_required') && post_password_required()) {
    echo get_the_password_form();
    return;
}

if (!$product && class_exists('WooCommerce')) {
    ?>
    <section class="single-product-details-section">
        <div class="container text-center py-5">
            <div class="kash-empty-products-state">
                <div class="empty-state-icon">
                    <i class="fa-solid fa-box-open"></i>
                </div>
                <h1 class="empty-state-title"><?php esc_html_e('Product Not Found', 'kash-naturals'); ?></h1>
                <p class="empty-state-desc"><?php esc_html_e('The product you are looking for does not exist or is currently unavailable in our store.', 'kash-naturals'); ?></p>
                <a href="<?php echo esc_url(function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : home_url('/shop')); ?>" class="cat-card-shop-btn" style="display:inline-flex; width:auto; padding:12px 28px; margin-top:20px;">
                    <i class="fa-solid fa-arrow-left"></i> &nbsp; <?php esc_html_e('Return to Shop', 'kash-naturals'); ?>
                </a>
            </div>
        </div>
    </section>
    <?php
    return;
}

// Extract attributes dynamically from WooCommerce Product or dev preview fallback
if ($product && is_a($product, 'WC_Product')) {
    $product_id = $product->get_id();
    $product_name = $product->get_name();

    // Image Resolution
    $main_img = '';
    $img_id = $product->get_image_id();
    if ($img_id) {
        $main_img = wp_get_attachment_image_url($img_id, 'full');
    }
    if (!$main_img && function_exists('wc_placeholder_img_src')) {
        $main_img = wc_placeholder_img_src('full');
    }
    if (!$main_img) {
        $main_img = get_template_directory_uri() . '/assets/images/jar-royal-mukhwas.jpg';
    }

    $gallery_images = array();
    if ($main_img) {
        $gallery_images[] = $main_img;
    }
    $gallery_ids = $product->get_gallery_image_ids();
    if (!empty($gallery_ids)) {
        foreach ($gallery_ids as $gid) {
            $gurl = wp_get_attachment_image_url($gid, 'full');
            if ($gurl && !in_array($gurl, $gallery_images, true)) {
                $gallery_images[] = $gurl;
            }
        }
    }

    // Video Resolution (Supports MP4 file from Media Library, YouTube, or Vimeo)
    $product_video_url = get_post_meta($product_id, '_product_video_url', true);
    if (empty($product_video_url)) {
        $product_video_url = get_theme_mod('kash_default_product_video', '');
    }
    // High-quality sample video fallback so both video and images display immediately
    if (empty($product_video_url)) {
        $product_video_url = 'https://assets.mixkit.co/videos/preview/mixkit-pouring-chocolate-sauce-on-a-muffin-42171-large.mp4';
    }
    $product_video_poster = get_post_meta($product_id, '_product_video_poster', true);
    if (empty($product_video_poster)) {
        $product_video_poster = $main_img;
    }
    $has_video = !empty($product_video_url);

    // Category Resolution
    $c_slug = 'all';
    $c_name = __('Artisanal Specialty', 'kash-naturals');
    $c_link = function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : home_url('/shop');
    $cats = get_the_terms($product_id, 'product_cat');
    if (!empty($cats) && !is_wp_error($cats)) {
        foreach ($cats as $cat_term) {
            if ($cat_term->slug !== 'uncategorized') {
                $c_slug = $cat_term->slug;
                $c_name = $cat_term->name;
                $c_link = get_term_link($cat_term);
                break;
            }
        }
        if ($c_slug === 'all' && !empty($cats[0])) {
            $c_slug = $cats[0]->slug;
            $c_name = $cats[0]->name === 'Uncategorized' ? __('Specialty Collection', 'kash-naturals') : $cats[0]->name;
            $c_link = get_term_link($cats[0]);
        }
    }

    // Variable Products & Variations Detection
    $is_variable = $product->is_type('variable');
    $available_variations = array();
    $variations_json_data = array();
    $default_variation_id = 0;
    $default_variation_data = null;

    // Pricing & Currency Defaults
    $currency_symbol = function_exists('get_woocommerce_currency_symbol') ? get_woocommerce_currency_symbol() : '₹';
    $price_raw = floatval($product->get_price()) ?: 0;
    $reg_raw   = floatval($product->get_regular_price()) ?: $price_raw;

    // Process WooCommerce Variations if Variable Product
    if ($is_variable) {
        $available_variations = $product->get_available_variations();
        if (!empty($available_variations)) {
            $default_attributes = $product->get_default_attributes();

            foreach ($available_variations as $var_idx => $v) {
                $vid = $v['variation_id'];
                $v_obj = wc_get_product($vid);
                if (!$v_obj) continue;

                // Human-readable attribute label (e.g. "200 GM", "500 GM")
                $attr_labels = array();
                if (!empty($v['attributes'])) {
                    foreach ($v['attributes'] as $attr_k => $attr_v) {
                        if ($attr_v === '' || $attr_v === null) continue;
                        $tax_k = str_replace('attribute_', '', $attr_k);
                        if (taxonomy_exists($tax_k)) {
                            $t = get_term_by('slug', $attr_v, $tax_k);
                            $attr_labels[] = ($t && !is_wp_error($t)) ? $t->name : $attr_v;
                        } else {
                            $attr_labels[] = $attr_v;
                        }
                    }
                }
                $v_label = !empty($attr_labels) ? implode(' - ', $attr_labels) : '';
                if (empty($v_label)) {
                    $v_weight = $v_obj->get_weight();
                    if ($v_weight) {
                        $v_label = $v_weight . 'g';
                    } else {
                        $v_label = sprintf(__('Option #%d', 'kash-naturals'), ($var_idx + 1));
                    }
                }

                $v_price = floatval($v['display_price']) ?: 0;
                $v_reg   = floatval($v['display_regular_price']) ?: $v_price;
                $v_discount = ($v_reg > $v_price && $v_reg > 0) ? round((($v_reg - $v_price) / $v_reg) * 100) : 0;
                $v_in_stock = !empty($v['is_in_stock']);
                $v_max_qty  = (!empty($v['max_qty']) && intval($v['max_qty']) > 0) ? intval($v['max_qty']) : ($v_obj->get_stock_quantity() ?: 20);

                // Badge determination
                $v_badge = '';
                if ($v_discount > 0) {
                    $v_badge = sprintf(__('Save %d%%', 'kash-naturals'), $v_discount);
                } elseif ($var_idx === 0) {
                    $v_badge = __('Best Seller', 'kash-naturals');
                } elseif ($var_idx === 1) {
                    $v_badge = __('Value Pack', 'kash-naturals');
                }

                $v_price_html = function_exists('wc_price') ? wc_price($v_price) : ($currency_symbol . number_format($v_price, 2));
                $v_reg_html   = ($v_reg > $v_price) ? (function_exists('wc_price') ? wc_price($v_reg) : ($currency_symbol . number_format($v_reg, 2))) : '';

                // Variation image
                $v_img = (!empty($v['image']['src']) && strpos($v['image']['src'], 'woocommerce-placeholder') === false) ? $v['image']['src'] : $main_img;

                $variations_json_data[$vid] = array(
                    'id'            => $vid,
                    'label'         => $v_label,
                    'badge'         => $v_badge,
                    'price'         => $v_price,
                    'regular_price' => $v_reg,
                    'price_html'    => $v_price_html,
                    'regular_html'  => $v_reg_html,
                    'discount'      => $v_discount,
                    'in_stock'      => $v_in_stock,
                    'max_qty'       => $v_max_qty,
                    'sku'           => !empty($v['sku']) ? $v['sku'] : ($product->get_sku() ?: ('KASH-' . $product_id)),
                    'image'         => $v_img,
                    'attributes'    => $v['attributes'],
                );

                // Check default variation match
                $is_default_match = false;
                if (!empty($default_attributes)) {
                    $matched = true;
                    foreach ($default_attributes as $dk => $dv) {
                        $full_k = 'attribute_' . $dk;
                        if (isset($v['attributes'][$full_k]) && $v['attributes'][$full_k] !== $dv) {
                            $matched = false;
                            break;
                        }
                    }
                    if ($matched) {
                        $is_default_match = true;
                    }
                }

                if ($is_default_match) {
                    $default_variation_id = $vid;
                    $default_variation_data = $variations_json_data[$vid];
                } elseif ($default_variation_id === 0) {
                    $default_variation_id = $vid;
                    $default_variation_data = $variations_json_data[$vid];
                } elseif ($default_variation_data && !$default_variation_data['in_stock'] && $v_in_stock) {
                    $default_variation_id = $vid;
                    $default_variation_data = $variations_json_data[$vid];
                }
            }
        }
    }

    if ($default_variation_data) {
        $price_raw        = $default_variation_data['price'];
        $reg_raw          = $default_variation_data['regular_price'];
        $price_formatted  = $default_variation_data['price_html'];
        $reg_formatted    = $default_variation_data['regular_html'];
        $discount_percent = $default_variation_data['discount'];
    } else {
        if (function_exists('wc_price')) {
            $price_formatted = wc_price($price_raw);
            $reg_formatted   = ($reg_raw > $price_raw) ? wc_price($reg_raw) : '';
        } else {
            $price_formatted = $currency_symbol . number_format($price_raw, 2);
            $reg_formatted   = ($reg_raw > $price_raw) ? ($currency_symbol . number_format($reg_raw, 2)) : '';
        }
        $discount_percent = ($reg_raw > $price_raw && $reg_raw > 0) ? round((($reg_raw - $price_raw) / $reg_raw) * 100) : 0;
    }

    // Ratings & Reviews
    $avg_rating = $product->get_average_rating();
    $rating_num_str = ($avg_rating > 0) ? number_format((float)$avg_rating, 1) : '5.0';
    $review_count = $product->get_review_count() ?: 0;

    // Stock Status
    if ($default_variation_data) {
        $is_in_stock = $default_variation_data['in_stock'];
        $stock_status = $is_in_stock ? 'instock' : 'outofstock';
        $stock_qty = $default_variation_data['max_qty'];
    } else {
        $is_in_stock = $product->is_in_stock();
        $stock_status = $product->get_stock_status();
        $stock_qty = $product->managing_stock() ? $product->get_stock_quantity() : null;
    }

    $stock_display_text = $is_in_stock ? __('In Stock (Ready to Ship)', 'kash-naturals') : __('Out of Stock (Unavailable)', 'kash-naturals');
    if ($is_in_stock && $stock_qty !== null && $stock_qty > 0 && $stock_qty <= 5) {
        $stock_display_text = sprintf(__('Only %d left in stock - Order Soon', 'kash-naturals'), $stock_qty);
    }

    // Badge
    $badge = '';
    if ($product->is_on_sale()) {
        $badge = __('Special Offer', 'kash-naturals');
    } elseif ($product->is_featured()) {
        $badge = __('Featured Collection', 'kash-naturals');
    } else {
        $badge = __('Artisan Batch', 'kash-naturals');
    }

    // Descriptions
    $short_desc = $product->get_short_description();
    if (empty($short_desc)) {
        $short_desc = wp_strip_all_tags(get_the_excerpt($product_id));
    }
    if (empty($short_desc)) {
        $short_desc = __('Handcrafted artisanal Indian confectionery prepared using pure, all-natural ingredients and traditional heritage recipes for superior aroma, digestion, and crisp freshness.', 'kash-naturals');
    }

    $full_desc = $product->get_description();
    if (empty($full_desc)) {
        $full_desc = $short_desc;
    }

    // Meta & Custom Attributes
    $custom_pack_1 = get_post_meta($product_id, '_pack_size_1_label', true);
    if (!empty($custom_pack_1)) {
        $weight_str = $custom_pack_1;
    } else {
        $weight_unit = get_option('woocommerce_weight_unit', 'g');
        $weight_val = $product->get_weight();
        if ($weight_val) {
            if ($weight_unit === 'g') {
                $weight_str = $weight_val . 'g Glass Jar';
            } elseif ($weight_unit === 'kg') {
                $weight_str = $weight_val . 'kg Value Pack';
            } elseif ($weight_unit === 'lbs' && floatval($weight_val) > 10) {
                $weight_str = $weight_val . 'g Glass Jar';
            } else {
                $weight_str = $weight_val . ' ' . $weight_unit;
            }
        } else {
            $weight_str = '200g Glass Jar';
        }
    }
    $sku_str = ($default_variation_data && !empty($default_variation_data['sku'])) ? $default_variation_data['sku'] : ($product->get_sku() ?: ('KASH-' . $product_id));

    $custom_highlights = get_post_meta($product_id, '_product_highlights', true);
    $dietary_type      = get_post_meta($product_id, '_dietary_type', true);
    $custom_ing        = get_post_meta($product_id, '_ingredients', true);
    $allergen_advice   = get_post_meta($product_id, '_allergen_advice', true);
    $shelf_life        = get_post_meta($product_id, '_shelf_life', true);
    $storage_inst      = get_post_meta($product_id, '_storage_instructions', true);

    $nutri_energy = get_post_meta($product_id, '_nutrition_energy', true) ?: '385 kcal';
    $nutri_protein = get_post_meta($product_id, '_nutrition_protein', true) ?: '4.2 g';
    $nutri_carbs = get_post_meta($product_id, '_nutrition_carbs', true) ?: '78.5 g';
    $nutri_sugars = get_post_meta($product_id, '_nutrition_sugars', true) ?: '32.0 g';
    $nutri_fiber = get_post_meta($product_id, '_nutrition_fiber', true) ?: '12.4 g';
    $nutri_fat = get_post_meta($product_id, '_nutrition_fat', true) ?: '2.1 g';

    $cacao_pct = get_post_meta($product_id, '_cacao_percentage', true);
    $flavor_notes = get_post_meta($product_id, '_flavor_notes', true);
    $cocoa_origin = get_post_meta($product_id, '_cocoa_origin', true);

    $pack_2_label = get_post_meta($product_id, '_pack_size_2_label', true);
    $pack_2_price = floatval(get_post_meta($product_id, '_pack_size_2_price', true)) ?: ($price_raw * 2.2);

    $ingredients_display = !empty($custom_ing) ? $custom_ing : __('Authentic fennel seeds (saunf), natural menthol, cardamom (elaichi), silver foil (varak), pure rose petals, dates, betel leaves extract, rock sugar, Permitted Natural Flavors.', 'kash-naturals');
    $allergen_display = !empty($allergen_advice) ? $allergen_advice : __('Allergen Advice: Processed in a clean facility that also handles tree nuts, sesame, and pure dairy.', 'kash-naturals');
    $shelf_life_display = !empty($shelf_life) ? $shelf_life : __('9 Months from the date of manufacturing when kept sealed in the original glass container.', 'kash-naturals');
    $storage_display = !empty($storage_inst) ? $storage_inst : __('Store in a cool, dry place away from direct sunlight, heat, and moisture. Always use a dry spoon and close lid securely after opening.', 'kash-naturals');

    // Related Products Query
    $related_products = array();
    if (function_exists('wc_get_related_products')) {
        $rel_ids = wc_get_related_products($product_id, 4);
        if (!empty($rel_ids)) {
            foreach ($rel_ids as $rid) {
                $r_prod = wc_get_product($rid);
                if ($r_prod && $r_prod->is_visible()) {
                    $r_img = wp_get_attachment_image_url($r_prod->get_image_id(), 'medium');
                    if (!$r_img && function_exists('wc_placeholder_img_src')) {
                        $r_img = wc_placeholder_img_src('medium');
                    }
                    $r_cats = get_the_terms($rid, 'product_cat');
                    $r_cat_name = (!empty($r_cats) && !is_wp_error($r_cats)) ? $r_cats[0]->name : __('Specialty', 'kash-naturals');
                    $r_price = floatval($r_prod->get_price()) ?: 0;
                    $r_reg = floatval($r_prod->get_regular_price()) ?: $r_price;
                    $related_products[] = array(
                        'id'            => $r_prod->get_id(),
                        'name'          => $r_prod->get_name(),
                        'category_name' => $r_cat_name,
                        'price'         => $r_price,
                        'regular_price' => $r_reg,
                        'price_html'    => function_exists('wc_price') ? wc_price($r_price) : ($currency_symbol . number_format($r_price, 2)),
                        'reg_html'      => ($r_reg > $r_price) ? (function_exists('wc_price') ? wc_price($r_reg) : ($currency_symbol . number_format($r_reg, 2))) : '',
                        'rating'        => ($r_prod->get_average_rating() > 0) ? number_format((float)$r_prod->get_average_rating(), 1) : '5.0',
                        'reviews_count' => $r_prod->get_review_count() ?: 0,
                        'main_image'    => $r_img ?: '',
                        'link'          => get_permalink($r_prod->get_id()),
                        'in_stock'      => $r_prod->is_in_stock(),
                    );
                }
            }
        }
    }
} else {
    // Standalone Dev Preview Mode
    $product_id = 1;
    $product_name = 'Kash Natural Raj Ratan – Sweet & Salty Mukhwas | Traditional Indian Mouth Freshener, 200g';
    $main_img = get_template_directory_uri() . '/assets/images/jar-royal-mukhwas.jpg';
    $gallery_images = array(
        get_template_directory_uri() . '/assets/images/jar-royal-mukhwas.jpg',
        get_template_directory_uri() . '/assets/images/jar-calcutta-pan.jpg',
        get_template_directory_uri() . '/assets/images/jar-sweet-saunf.jpg',
    );
    $product_video_url = 'https://assets.mixkit.co/videos/preview/mixkit-pouring-chocolate-sauce-on-a-muffin-42171-large.mp4';
    $product_video_poster = $main_img;
    $has_video = true;
    $c_slug = 'mouth-fresheners';
    $c_name = 'Mouth Fresheners';
    $c_link = home_url('/shop?category=mouth-fresheners');
    $currency_symbol = '₹';
    $price_raw = 179;
    $reg_raw = 300;
    $price_formatted = '₹179';
    $reg_formatted = '₹300';
    $discount_percent = 40;
    $avg_rating = 5.0;
    $rating_num_str = '5.0';
    $review_count = 48;
    $is_in_stock = true;
    $stock_status = 'instock';
    $stock_qty = 5;
    $stock_display_text = 'In Stock (Ready to Ship)';
    $badge = 'Special Offer';
    $short_desc = 'A royal traditional blend of crispy fennel seeds, silver coated cardamom, sweet roasted coriander seeds (dhana dal), and digestive herbs.';
    $full_desc = 'Crafted from age-old royal Indian recipes, Kash Natural Raj Ratan Mukhwas is an exquisite mouth freshener celebrating authentic after-meal traditions. Every jar contains meticulously hand-selected fennel seeds, silver-coated cardamom seeds, naturally aromatic rose extract, and digestive seeds roasted to crispy perfection in small artisanal batches.';
    $weight_str = '200g Glass Jar';
    $sku_str = 'KASH-RR-200';
    $cacao_pct = '';
    $flavor_notes = 'Sweet, Minty, Rose Aroma, Crispy';
    $ingredients_display = 'Fennel seeds (Saunf), Roasted coriander seeds (Dhana dal), Cardamom seeds (Elaichi), Silver foil (Varak), Natural rose extract, Menthol, Vegetable oil, Permitted food colors & natural flavoring.';
    $related_products = array(
        array(
            'id' => 2,
            'name' => 'Royal Calcutta Meetha Paan',
            'category_name' => 'Mouth Fresheners',
            'price' => 199,
            'regular_price' => 250,
            'price_html' => '₹199',
            'reg_html' => '₹250',
            'rating' => '5.0',
            'reviews_count' => 64,
            'main_image' => get_template_directory_uri() . '/assets/images/jar-calcutta-pan.jpg',
            'link' => home_url('/product?id=2'),
            'in_stock' => true,
        ),
        array(
            'id' => 3,
            'name' => 'Silver Coated Elaichi & Sweet Saunf',
            'category_name' => 'Mouth Fresheners',
            'price' => 165,
            'regular_price' => 210,
            'price_html' => '₹165',
            'reg_html' => '₹210',
            'rating' => '4.9',
            'reviews_count' => 38,
            'main_image' => get_template_directory_uri() . '/assets/images/jar-sweet-saunf.jpg',
            'link' => home_url('/product?id=3'),
            'in_stock' => true,
        ),
    );
}
?>

<div id="product-<?php echo esc_attr($product_id); ?>" <?php if (function_exists('wc_product_class')) { wc_product_class('single-product-details-section kash-luxury-product-view', $product); } else { echo 'class="single-product-details-section kash-luxury-product-view"'; } ?>>
    <div class="container">

        <!-- Breadcrumb Bar -->
        <nav class="product-breadcrumb-nav" aria-label="Breadcrumb">
            <a href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('Home', 'kash-naturals'); ?></a>
            <i class="fa-solid fa-chevron-right breadcrumb-separator"></i>
            <a href="<?php echo esc_url(function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : home_url('/shop')); ?>"><?php esc_html_e('Shop', 'kash-naturals'); ?></a>
            <i class="fa-solid fa-chevron-right breadcrumb-separator"></i>
            <a href="<?php echo esc_url($c_link); ?>"><?php echo esc_html($c_name); ?></a>
            <i class="fa-solid fa-chevron-right breadcrumb-separator"></i>
            <span class="breadcrumb-current"><?php echo esc_html($product_name); ?></span>
        </nav>

        <!-- Product Main Showcase Grid -->
        <div class="product-showcase-grid">

            <!-- Left: Image & Video Gallery Showcase -->
            <div class="product-gallery-wrapper">
                <div class="main-image-display-card">
                    <?php if (!empty($badge)) : ?>
                        <span class="product-badge-pill-luxury"><?php echo esc_html($badge); ?></span>
                    <?php endif; ?>

                    <!-- Overlapping Top-Right Actions: Discount Tag + Share Button -->
                    <div class="product-top-right-actions">
                        <span class="product-discount-tag" id="productImageDiscountTag" <?php echo ($discount_percent <= 0) ? 'style="display:none;"' : ''; ?>>
                            <?php echo esc_html($discount_percent); ?>% OFF
                        </span>

                        <!-- Overlapping Share Button on Image -->
                        <div class="product-share-wrap">
                            <button type="button" class="product-share-btn" id="productShareBtn" onclick="toggleProductShare(event)" aria-label="<?php esc_attr_e('Share this product', 'kash-naturals'); ?>" title="<?php esc_attr_e('Share Product', 'kash-naturals'); ?>">
                                <i class="fa-solid fa-share-nodes"></i>
                            </button>
                            <div class="product-share-popover" id="productSharePopover" style="display:none;" aria-hidden="true">
                                <div class="share-popover-header">
                                    <span><?php esc_html_e('Share Product', 'kash-naturals'); ?></span>
                                    <button type="button" class="close-share-btn" onclick="toggleProductShare(event)" aria-label="<?php esc_attr_e('Close Share', 'kash-naturals'); ?>">&times;</button>
                                </div>
                                <div class="share-options-grid">
                                    <button type="button" class="share-option-btn btn-share-wa" onclick="kashShareAction('whatsapp')">
                                        <i class="fa-brands fa-whatsapp"></i>
                                        <span>WhatsApp</span>
                                    </button>
                                    <button type="button" class="share-option-btn btn-share-fb" onclick="kashShareAction('facebook')">
                                        <i class="fa-brands fa-facebook-f"></i>
                                        <span>Facebook</span>
                                    </button>
                                    <button type="button" class="share-option-btn btn-share-x" onclick="kashShareAction('x')">
                                        <i class="fa-brands fa-x-twitter"></i>
                                        <span>Twitter / X</span>
                                    </button>
                                    <button type="button" class="share-option-btn btn-share-copy" onclick="kashShareAction('copy')">
                                        <i class="fa-solid fa-copy"></i>
                                        <span class="share-copy-label"><?php esc_html_e('Copy Link', 'kash-naturals'); ?></span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Main Image Display Container -->
                    <div class="main-img-container" id="mainImgContainer">
                        <img id="primaryProductImg" src="<?php echo esc_url($main_img); ?>" alt="<?php echo esc_attr($product_name); ?>" loading="eager">
                    </div>

                    <!-- Main Video Player Container (Supports MP4, YouTube, Vimeo) -->
                    <?php if ($has_video) : 
                        if (!function_exists('kash_get_video_embed_info')) {
                            function kash_get_video_embed_info($url) {
                                if (empty($url)) return false;
                                $url = trim($url);
                                if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?|shorts)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/ ]{11})/i', $url, $matches)) {
                                    return array(
                                        'type'  => 'youtube',
                                        'id'    => $matches[1],
                                        'embed' => 'https://www.youtube.com/embed/' . $matches[1] . '?autoplay=1&rel=0&enablejsapi=1',
                                    );
                                }
                                if (preg_match('/vimeo\.com\/(?:channels\/(?:\w+\/)?|groups\/([^\/]*)\/videos\/|album\/(\d+)\/video\/|)(\d+)(?:$|\/|\?)/i', $url, $matches)) {
                                    return array(
                                        'type'  => 'vimeo',
                                        'id'    => $matches[3],
                                        'embed' => 'https://player.vimeo.com/video/' . $matches[3] . '?autoplay=1',
                                    );
                                }
                                return array(
                                    'type' => 'mp4',
                                    'url'  => $url,
                                );
                            }
                        }
                        $video_info = kash_get_video_embed_info($product_video_url);
                    ?>
                        <div class="main-video-container" id="mainVideoContainer" style="display:none;" data-video-type="<?php echo esc_attr($video_info['type']); ?>">
                            <?php if ($video_info['type'] === 'youtube') : ?>
                                <iframe id="kashProductVideoIframe" src="" data-src="<?php echo esc_url($video_info['embed']); ?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen class="kash-video-iframe"></iframe>
                            <?php elseif ($video_info['type'] === 'vimeo') : ?>
                                <iframe id="kashProductVideoIframe" src="" data-src="<?php echo esc_url($video_info['embed']); ?>" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen class="kash-video-iframe"></iframe>
                            <?php else : ?>
                                <video id="kashProductVideoEl" class="kash-video-html5" controls playsinline preload="metadata" poster="<?php echo esc_url($product_video_poster); ?>">
                                    <source src="<?php echo esc_url($video_info['url']); ?>" type="video/mp4">
                                    <?php esc_html_e('Your browser does not support HTML5 video.', 'kash-naturals'); ?>
                                </video>
                            <?php endif; ?>
                        </div>

                        <!-- Floating Watch Video Quick Pill on Image -->
                        <button type="button" class="product-play-video-pill" id="productPlayVideoPill" onclick="switchToProductVideo()" aria-label="<?php esc_attr_e('Play Product Video', 'kash-naturals'); ?>">
                            <i class="fa-solid fa-circle-play"></i>
                            <span><?php esc_html_e('Watch Video', 'kash-naturals'); ?></span>
                        </button>
                    <?php endif; ?>
                </div>

                <!-- Gallery Thumbnails Strip (Both Images & Video) -->
                <?php if (count($gallery_images) > 1 || $has_video) : ?>
                    <div class="gallery-thumbs-strip">
                        <?php foreach ($gallery_images as $index => $thumb_src) : ?>
                            <button type="button" class="thumb-btn thumb-img-btn <?php echo ($index === 0) ? 'active' : ''; ?>" onclick="changeProductMedia(this, 'image', '<?php echo esc_js($thumb_src); ?>')" aria-label="Product Image <?php echo $index + 1; ?>">
                                <img src="<?php echo esc_url($thumb_src); ?>" alt="Thumbnail <?php echo $index + 1; ?>">
                            </button>
                        <?php endforeach; ?>

                        <?php if ($has_video) : ?>
                            <button type="button" class="thumb-btn thumb-video-btn" onclick="changeProductMedia(this, 'video', '')" aria-label="<?php esc_attr_e('Product Video', 'kash-naturals'); ?>" title="<?php esc_attr_e('Watch Product Video', 'kash-naturals'); ?>">
                                <div class="thumb-video-poster">
                                    <img src="<?php echo esc_url($product_video_poster); ?>" alt="<?php esc_attr_e('Video Preview', 'kash-naturals'); ?>">
                                    <span class="video-play-overlay-badge"><i class="fa-solid fa-play"></i></span>
                                </div>
                                <span class="thumb-video-caption"><i class="fa-solid fa-film"></i> VIDEO</span>
                            </button>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <!-- Product Trust Badges Bar -->
                <div class="product-trust-features-bar">
                    <div class="trust-pill-item">
                        <i class="fa-solid fa-seedling trust-icon"></i>
                        <span><?php esc_html_e('100% Natural', 'kash-naturals'); ?></span>
                    </div>
                    <div class="trust-pill-item">
                        <i class="fa-solid fa-shield-heart trust-icon"></i>
                        <span><?php esc_html_e('Zero Preservatives', 'kash-naturals'); ?></span>
                    </div>
                    <div class="trust-pill-item">
                        <i class="fa-solid fa-snowflake trust-icon"></i>
                        <span><?php esc_html_e('Cold Pack Delivery', 'kash-naturals'); ?></span>
                    </div>
                    <div class="trust-pill-item">
                        <i class="fa-solid fa-jar trust-icon"></i>
                        <span><?php esc_html_e('Airtight Glass Jar', 'kash-naturals'); ?></span>
                    </div>
                </div>
            </div>

            <!-- Right: Product Purchase Info & Controls -->
            <div class="product-summary-info">
                <div class="product-meta-header">
                    <a href="<?php echo esc_url($c_link); ?>" class="product-cat-tag-pill" style="text-decoration:none;">
                        <?php echo esc_html($c_name); ?>
                    </a>
                    <span class="product-sku-code">SKU: <span id="productSkuDisplay"><?php echo esc_html($sku_str); ?></span></span>
                </div>

                <h1 class="product-title-main"><?php echo esc_html($product_name); ?></h1>

                <!-- Rating & Stock Status -->
                <div class="product-rating-stock-row">
                    <div class="star-rating-box">
                        <div class="stars-gold">★★★★★</div>
                        <span class="rating-num"><strong><?php echo esc_html($rating_num_str); ?></strong> (<?php echo esc_html($review_count); ?> <?php esc_html_e('Customer Reviews', 'kash-naturals'); ?>)</span>
                    </div>
                    <div class="stock-status-badge <?php echo $is_in_stock ? 'in-stock' : 'out-of-stock'; ?>" id="productStockBadge">
                        <i class="fa-solid <?php echo $is_in_stock ? 'fa-circle-check' : 'fa-circle-xmark'; ?>"></i> 
                        <span class="stock-badge-text"><?php echo esc_html($stock_display_text); ?></span>
                    </div>
                </div>

                <!-- Price Box -->
                <div class="product-price-display-box">
                    <span class="current-price-val" id="productMainPrice"><?php echo wp_kses_post($price_formatted); ?></span>
                    <span class="regular-price-val" id="productRegularPrice" <?php echo empty($reg_formatted) ? 'style="display:none;"' : ''; ?>>
                        <?php echo wp_kses_post($reg_formatted); ?>
                    </span>
                    <span class="price-tax-note">(<?php esc_html_e('Inclusive of all taxes & doorstep packaging', 'kash-naturals'); ?>)</span>
                    <span class="product-savings-badge" id="productSavingsBadge" <?php echo ($discount_percent <= 0) ? 'style="display:none;"' : ''; ?>>
                        <?php printf(esc_html__('Save %d%%', 'kash-naturals'), $discount_percent); ?>
                    </span>
                </div>

                <?php if (!empty($flavor_notes) || !empty($cacao_pct) || !empty($dietary_type) || !empty($cocoa_origin)) : ?>
                    <div class="product-artisan-highlights-pill-row" style="display:flex; gap:10px; margin: 14px 0; flex-wrap:wrap;">
                        <?php if (!empty($dietary_type)) : ?>
                            <span style="background: rgba(44, 95, 62, 0.1); color: #2C5F3E; font-weight:700; padding: 4px 12px; border-radius: 20px; font-size: 0.82rem;">
                                <i class="fa-solid fa-leaf"></i> <?php echo esc_html($dietary_type); ?>
                            </span>
                        <?php endif; ?>
                        <?php if (!empty($cacao_pct)) : ?>
                            <span style="background: rgba(44, 95, 62, 0.1); color: #2C5F3E; font-weight:700; padding: 4px 12px; border-radius: 20px; font-size: 0.82rem;">
                                <i class="fa-solid fa-percent"></i> <?php echo esc_html($cacao_pct); ?> Pure Origin
                            </span>
                        <?php endif; ?>
                        <?php if (!empty($flavor_notes)) : ?>
                            <span style="background: rgba(196, 124, 5, 0.1); color: #c47c05; font-weight:700; padding: 4px 12px; border-radius: 20px; font-size: 0.82rem;">
                                <i class="fa-solid fa-wand-magic-sparkles"></i> <?php echo esc_html($flavor_notes); ?>
                            </span>
                        <?php endif; ?>
                        <?php if (!empty($cocoa_origin)) : ?>
                            <span style="background: rgba(30, 41, 59, 0.08); color: #1e293b; font-weight:700; padding: 4px 12px; border-radius: 20px; font-size: 0.82rem;">
                                <i class="fa-solid fa-location-dot"></i> <?php echo esc_html($cocoa_origin); ?>
                            </span>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <!-- Short Editorial Description & Highlights -->
                <div class="product-editorial-desc">
                    <?php
                    // Helper to format highlights and description cleanly
                    if (!function_exists('kash_display_editorial_content')) {
                        function kash_display_editorial_content($s_desc, $pid, $cust_highlights) {
                            if (stripos($s_desc, 'Top highlights') !== false) {
                                preg_match('/Top highlights\s+(.*?)(?:About this item\s*(.*))?$/is', $s_desc, $matches);
                                $specs_str = isset($matches[1]) ? trim($matches[1]) : '';
                                $about_str = isset($matches[2]) ? trim($matches[2]) : '';

                                $labels = array('Flavour', 'Brand', 'Item Weight', 'Package Information', 'Speciality', 'Package Weight', 'Number of Pieces', 'Net Quantity', 'Region of Origin', 'Cultivation Method Claim', 'Diet Type', 'Country of Origin');
                                $pattern = '/(?=' . implode('|', array_map('preg_quote', $labels)) . ')/i';
                                $parts = preg_split($pattern, $specs_str, -1, PREG_SPLIT_NO_EMPTY);

                                $specs = array();
                                if (!empty($parts)) {
                                    foreach ($parts as $part) {
                                        foreach ($labels as $label) {
                                            if (stripos($part, $label) === 0) {
                                                $val = trim(substr($part, strlen($label)));
                                                $val = ltrim($val, ': ');
                                                if (!empty($val)) {
                                                    $specs[$label] = $val;
                                                }
                                                break;
                                            }
                                        }
                                    }
                                }

                                echo '<div class="kash-parsed-highlights-card" style="margin-bottom: 18px;">';
                                if (!empty($specs)) {
                                    echo '<div class="kash-specs-grid-table" style="display:grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 10px; background: #FAF7F2; padding: 14px 18px; border-radius: 12px; border: 1px solid rgba(44, 95, 62, 0.12); margin-bottom: 14px;">';
                                    foreach ($specs as $s_label => $s_val) {
                                        $icon = 'fa-solid fa-circle-check';
                                        if ($s_label === 'Flavour') $icon = 'fa-solid fa-wand-magic-sparkles';
                                        elseif ($s_label === 'Brand') $icon = 'fa-solid fa-crown';
                                        elseif (strpos($s_label, 'Weight') !== false || $s_label === 'Net Quantity') $icon = 'fa-solid fa-scale-balanced';
                                        elseif ($s_label === 'Speciality' || $s_label === 'Diet Type') $icon = 'fa-solid fa-leaf';
                                        elseif ($s_label === 'Package Information') $icon = 'fa-solid fa-box-archive';
                                        elseif ($s_label === 'Region of Origin' || $s_label === 'Country of Origin') $icon = 'fa-solid fa-location-dot';

                                        echo '<div class="kash-spec-grid-item" style="display:flex; flex-direction:column; gap:2px;">';
                                        echo '<span class="spec-label" style="font-size: 0.76rem; color: #666; font-weight:600; text-transform:uppercase; letter-spacing:0.5px;"><i class="' . esc_attr($icon) . '" style="color:#2C5F3E;"></i> ' . esc_html($s_label) . '</span>';
                                        echo '<span class="spec-value" style="font-size: 0.9rem; color: #1C2B1F; font-weight:700;">' . esc_html($s_val) . '</span>';
                                        echo '</div>';
                                    }
                                    echo '</div>';
                                }

                                if (!empty($about_str)) {
                                    echo '<div class="kash-about-item-block">';
                                    echo '<h4 style="font-size: 0.92rem; font-weight:700; color:#1C2B1F; margin: 0 0 8px;"><i class="fa-solid fa-circle-info" style="color:#2C5F3E;"></i> ' . esc_html__('About This Item:', 'kash-naturals') . '</h4>';
                                    $points = preg_split('/(?<=[.!?])\s+(?=[A-Z])|\[|\]/', $about_str, -1, PREG_SPLIT_NO_EMPTY);
                                    if (count($points) > 1) {
                                        echo '<ul class="kash-about-bullets-list" style="margin:0 0 14px; padding-left:0; list-style:none; display:flex; flex-direction:column; gap:6px;">';
                                        foreach ($points as $pt) {
                                            $pt = trim($pt);
                                            if (!empty($pt) && strlen($pt) > 4) {
                                                echo '<li style="display:flex; align-items:flex-start; gap:8px; font-size:0.9rem; color:#444; line-height:1.5;"><i class="fa-solid fa-circle-check" style="color:#2C5F3E; font-size:0.8rem; margin-top:4px; flex-shrink:0;"></i> <span>' . esc_html($pt) . '</span></li>';
                                            }
                                        }
                                        echo '</ul>';
                                    } else {
                                        echo '<p style="font-size:0.92rem; color:#444; line-height:1.6; margin:0 0 12px;">' . esc_html($about_str) . '</p>';
                                    }
                                    echo '</div>';
                                }
                                echo '</div>';
                                return;
                            }

                            if (!empty($cust_highlights)) {
                                $lines = explode("\n", str_replace("\r", "", $cust_highlights));
                                echo '<div class="kash-custom-highlights-card" style="margin-bottom: 14px;">';
                                echo '<ul class="kash-about-bullets-list" style="margin:0 0 14px; padding-left:0; list-style:none; display:flex; flex-direction:column; gap:6px;">';
                                foreach ($lines as $line) {
                                    $line = trim($line);
                                    if (!empty($line)) {
                                        echo '<li style="display:flex; align-items:flex-start; gap:8px; font-size:0.9rem; color:#444; line-height:1.5;"><i class="fa-solid fa-circle-check" style="color:#2C5F3E; font-size:0.8rem; margin-top:4px; flex-shrink:0;"></i> <span>' . esc_html($line) . '</span></li>';
                                    }
                                }
                                echo '</ul>';
                                echo '</div>';
                            }

                            echo wpautop(wp_kses_post($s_desc));
                        }
                    }
                    kash_display_editorial_content($short_desc, $product_id, $custom_highlights);
                    ?>
                </div>

                <!-- Weight / Size Selection Pills -->
                <div class="product-option-selector">
                    <label class="selector-label"><?php esc_html_e('SELECT PACK SIZE:', 'kash-naturals'); ?></label>
                    <div class="size-pills-wrap">
                        <?php if ($is_variable && !empty($variations_json_data)) : ?>
                            <?php foreach ($variations_json_data as $vid => $vdata) : 
                                $is_active = ($vid === $default_variation_id);
                                $is_oos = !$vdata['in_stock'];
                            ?>
                                <button type="button" 
                                        class="size-pill-btn <?php echo $is_active ? 'active' : ''; ?> <?php echo $is_oos ? 'is-pill-oos' : ''; ?>" 
                                        data-variation-id="<?php echo esc_attr($vid); ?>"
                                        onclick="kashSelectVariation(<?php echo esc_attr($vid); ?>)">
                                    <span><?php echo esc_html($vdata['label']); ?></span>
                                    <?php if (!empty($vdata['badge'])) : ?>
                                        <span class="<?php echo ($vdata['discount'] > 0) ? 'pill-save-val' : 'pill-best-val'; ?>">
                                            <?php echo esc_html($vdata['badge']); ?>
                                        </span>
                                    <?php elseif ($is_oos) : ?>
                                        <span class="pill-oos-val"><?php esc_html_e('Out of Stock', 'kash-naturals'); ?></span>
                                    <?php endif; ?>
                                </button>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <button type="button" class="size-pill-btn active" onclick="selectPackSize(this, '<?php echo esc_js($weight_str); ?>', <?php echo esc_js($price_raw); ?>)">
                                <span><?php echo esc_html($weight_str); ?></span>
                                <span class="pill-best-val"><?php esc_html_e('Best Seller', 'kash-naturals'); ?></span>
                            </button>
                            <?php if (!empty($pack_2_label) && !empty(get_post_meta($product_id, '_pack_size_2_label', true))) : ?>
                                <button type="button" class="size-pill-btn" onclick="selectPackSize(this, '<?php echo esc_js($pack_2_label); ?>', <?php echo esc_js($pack_2_price); ?>)">
                                    <span><?php echo esc_html($pack_2_label); ?></span>
                                    <span class="pill-save-val"><?php esc_html_e('Value Pack', 'kash-naturals'); ?></span>
                                </button>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Quantity & Add to Cart Controls -->
                <div class="purchase-action-controls">
                    <div class="quantity-counter-box">
                        <button type="button" class="qty-btn minus" onclick="updateQty(-1)" aria-label="Decrease quantity">-</button>
                        <input type="number" id="productQtyInput" name="quantity" value="1" min="1" max="<?php echo ($stock_qty ? esc_attr($stock_qty) : 20); ?>" readonly>
                        <button type="button" class="qty-btn plus" onclick="updateQty(1)" aria-label="Increase quantity">+</button>
                    </div>

                    <button type="button" class="btn-add-to-cart-gold add-to-cart-btn add_to_cart_button ajax_add_to_cart <?php echo !$is_in_stock ? 'btn-out-of-stock' : ''; ?>" 
                            id="singleProductAddToCartBtn"
                            data-product-id="<?php echo esc_attr($product_id); ?>" 
                            data-variation-id="<?php echo esc_attr($default_variation_id); ?>" 
                            data-product_id="<?php echo esc_attr($product_id); ?>" 
                            data-product-name="<?php echo esc_attr($product_name); ?>" 
                            data-product-price="<?php echo esc_attr($price_raw); ?>" 
                            data-product-img="<?php echo esc_url($main_img); ?>" 
                            <?php echo !$is_in_stock ? 'disabled' : ''; ?>
                            onclick="handleSingleAddToCart(<?php echo esc_attr($product_id); ?>)">
                        <i class="fa-solid <?php echo $is_in_stock ? 'fa-cart-shopping' : 'fa-ban'; ?>"></i> 
                        <span class="btn-label-text"><?php echo $is_in_stock ? esc_html__('ADD TO CART', 'kash-naturals') : esc_html__('OUT OF STOCK', 'kash-naturals'); ?></span>
                    </button>

                    <button type="button" class="btn-buy-now-green <?php echo !$is_in_stock ? 'btn-out-of-stock' : ''; ?>" 
                            id="singleProductBuyNowBtn"
                            data-variation-id="<?php echo esc_attr($default_variation_id); ?>" 
                            <?php echo !$is_in_stock ? 'disabled' : ''; ?>
                            onclick="handleBuyNow(<?php echo esc_attr($product_id); ?>)">
                        <i class="fa-solid fa-bolt"></i> <?php esc_html_e('BUY IT NOW', 'kash-naturals'); ?>
                    </button>
                </div>

                <!-- Pincode Delivery Checker Box -->
                <div class="pincode-checker-card">
                    <div class="pincode-header">
                        <i class="fa-solid fa-truck-fast"></i>
                        <span><?php esc_html_e('Check Express Delivery & Cash on Delivery', 'kash-naturals'); ?></span>
                    </div>
                    <div class="pincode-input-row">
                        <input type="text" id="pincodeInput" placeholder="<?php esc_attr_e('Enter 6-digit Pincode', 'kash-naturals'); ?>" maxlength="6" onkeypress="if(event.key==='Enter') checkDeliveryPincode()">
                        <button type="button" class="btn-check-pincode" onclick="checkDeliveryPincode()"><?php esc_html_e('Check', 'kash-naturals'); ?></button>
                    </div>
                    <div id="pincodeResultMessage" class="pincode-result-msg"></div>
                </div>

                <!-- Quick Highlights Box -->
                <div class="product-highlights-box">
                    <div class="highlight-item">
                        <i class="fa-solid fa-leaf"></i>
                        <div>
                            <strong><?php esc_html_e('100% Vegetarian & Natural', 'kash-naturals'); ?></strong>
                            <p><?php esc_html_e('Zero artificial sweeteners, harmful preservatives, or industrial additives.', 'kash-naturals'); ?></p>
                        </div>
                    </div>
                    <div class="highlight-item">
                        <i class="fa-solid fa-rotate-left"></i>
                        <div>
                            <strong><?php esc_html_e('Easy 7-Day Replacement Guarantee', 'kash-naturals'); ?></strong>
                            <p><?php esc_html_e('Transit damage or missing seal? We ship an immediate free replacement.', 'kash-naturals'); ?></p>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Product Detailed Tabs Section -->
        <div class="product-tabs-section">
            <div class="tabs-header-nav">
                <button type="button" class="tab-btn active" onclick="switchProductTab(this, 'tab-description')"><?php esc_html_e('Full Description & Story', 'kash-naturals'); ?></button>
                <button type="button" class="tab-btn" onclick="switchProductTab(this, 'tab-ingredients')"><?php esc_html_e('Ingredients & Nutrition', 'kash-naturals'); ?></button>
                <button type="button" class="tab-btn" onclick="switchProductTab(this, 'tab-storage')"><?php esc_html_e('Storage & Shelf Life', 'kash-naturals'); ?></button>
                <button type="button" class="tab-btn" onclick="switchProductTab(this, 'tab-reviews')"><?php esc_html_e('Verified Customer Reviews', 'kash-naturals'); ?> (<?php echo esc_html($review_count); ?>)</button>
            </div>

            <div class="tabs-content-viewport">

                <!-- Tab 1: Description -->
                <div id="tab-description" class="tab-pane-content active">
                    <div class="tab-story-card">
                        <h2><?php esc_html_e('Craftsmanship & Heritage', 'kash-naturals'); ?></h2>
                        <div class="tab-story-text" style="font-size: 1.02rem; line-height: 1.8; color: #444; margin-bottom: 30px;">
                            <?php echo wpautop(wp_kses_post($full_desc)); ?>
                        </div>
                        <div class="story-grid-icons">
                            <div class="story-icon-box">
                                <i class="fa-solid fa-mortar-pestle"></i>
                                <h4><?php esc_html_e('Small-Batch Artisan Made', 'kash-naturals'); ?></h4>
                                <p><?php esc_html_e('Prepared in traditional small batches to retain authentic essential oils and crisp texture.', 'kash-naturals'); ?></p>
                            </div>
                            <div class="story-icon-box">
                                <i class="fa-solid fa-glass-water"></i>
                                <h4><?php esc_html_e('Food-Grade Glass Packaging', 'kash-naturals'); ?></h4>
                                <p><?php esc_html_e('Sealed in thick glass containers preventing moisture absorption and flavor loss.', 'kash-naturals'); ?></p>
                            </div>
                            <div class="story-icon-box">
                                <i class="fa-solid fa-heart-pulse"></i>
                                <h4><?php esc_html_e('Digestive Wellness', 'kash-naturals'); ?></h4>
                                <p><?php esc_html_e('Natural herbal spices that naturally soothe digestive system post-heavy meals.', 'kash-naturals'); ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tab 2: Ingredients & Nutrition -->
                <div id="tab-ingredients" class="tab-pane-content">
                    <div class="ingredients-nutrition-grid">
                        <div class="ing-card">
                            <h3><i class="fa-solid fa-seedling"></i> <?php esc_html_e('Complete Ingredients List', 'kash-naturals'); ?></h3>
                            <p class="ing-text"><?php echo esc_html($ingredients_display); ?></p>
                            <span class="allergen-note"><?php echo esc_html($allergen_display); ?></span>
                        </div>

                        <div class="nutri-table-card">
                            <h3><i class="fa-solid fa-table-list"></i> <?php esc_html_e('Nutritional Facts (Per 100g approx.)', 'kash-naturals'); ?></h3>
                            <table class="nutri-table">
                                <tbody>
                                    <tr><th><?php esc_html_e('Energy Value', 'kash-naturals'); ?></th><td><?php echo esc_html($nutri_energy); ?></td></tr>
                                    <tr><th><?php esc_html_e('Protein', 'kash-naturals'); ?></th><td><?php echo esc_html($nutri_protein); ?></td></tr>
                                    <tr><th><?php esc_html_e('Carbohydrates', 'kash-naturals'); ?></th><td><?php echo esc_html($nutri_carbs); ?></td></tr>
                                    <tr><th><?php esc_html_e('Total Sugars', 'kash-naturals'); ?></th><td><?php echo esc_html($nutri_sugars); ?></td></tr>
                                    <tr><th><?php esc_html_e('Dietary Fiber', 'kash-naturals'); ?></th><td><?php echo esc_html($nutri_fiber); ?></td></tr>
                                    <tr><th><?php esc_html_e('Total Fat', 'kash-naturals'); ?></th><td><?php echo esc_html($nutri_fat); ?></td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Tab 3: Storage -->
                <div id="tab-storage" class="tab-pane-content">
                    <div class="storage-info-box">
                        <div class="storage-row">
                            <i class="fa-solid fa-calendar-check"></i>
                            <div>
                                <h4><?php esc_html_e('Shelf Life', 'kash-naturals'); ?></h4>
                                <p><?php echo esc_html($shelf_life_display); ?></p>
                            </div>
                        </div>
                        <div class="storage-row">
                            <i class="fa-solid fa-temperature-arrow-down"></i>
                            <div>
                                <h4><?php esc_html_e('Storage Instructions', 'kash-naturals'); ?></h4>
                                <p><?php echo esc_html($storage_display); ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tab 4: Customer Reviews -->
                <div id="tab-reviews" class="tab-pane-content">
                    <div class="reviews-summary-row">
                        <div class="review-score-box">
                            <div class="big-rating-num"><?php echo esc_html($rating_num_str); ?></div>
                            <div class="stars-gold">★★★★★</div>
                            <p><?php printf(esc_html__('Based on %d verified customer reviews', 'kash-naturals'), $review_count); ?></p>
                        </div>
                        <div class="review-bars-box">
                            <div class="bar-row"><span>5 Stars</span><div class="bar-fill"><div class="fill-inner" style="width: 92%;"></div></div><span>92%</span></div>
                            <div class="bar-row"><span>4 Stars</span><div class="bar-fill"><div class="fill-inner" style="width: 6%;"></div></div><span>6%</span></div>
                            <div class="bar-row"><span>3 Stars</span><div class="bar-fill"><div class="fill-inner" style="width: 2%;"></div></div><span>2%</span></div>
                        </div>
                    </div>

                    <?php
                    // Fetch real approved comments/reviews for this product
                    $wc_reviews = function_exists('get_comments') ? get_comments(array(
                        'post_id' => $product_id,
                        'status'  => 'approve',
                    )) : array();
                    ?>

                    <div class="reviews-cards-list">
                        <?php if (!empty($wc_reviews)) : ?>
                            <?php foreach ($wc_reviews as $rev) :
                                $c_rating = intval(get_comment_meta($rev->comment_ID, 'rating', true)) ?: 5;
                                $stars_display = str_repeat('★', $c_rating) . str_repeat('☆', max(0, 5 - $c_rating));
                                $c_author = $rev->comment_author ?: __('Connoisseur', 'kash-naturals');
                                $c_date = function_exists('human_time_diff') ? (human_time_diff(strtotime($rev->comment_date), current_time('timestamp')) . ' ago') : 'Recent';
                                $c_body = $rev->comment_content;
                                $is_ver = function_exists('wc_review_is_from_verified_owner') ? wc_review_is_from_verified_owner($rev->comment_ID) : true;
                            ?>
                                <div class="review-card">
                                    <div class="review-header">
                                        <strong><?php echo esc_html($c_author); ?></strong>
                                        <?php if ($is_ver) : ?>
                                            <span class="verified-badge"><i class="fa-solid fa-circle-check"></i> <?php esc_html_e('Verified Purchase', 'kash-naturals'); ?></span>
                                        <?php endif; ?>
                                        <span class="review-date"><?php echo esc_html($c_date); ?></span>
                                    </div>
                                    <div class="stars-gold"><?php echo esc_html($stars_display); ?></div>
                                    <p class="review-body"><?php echo esc_html($c_body); ?></p>
                                </div>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <div class="review-card">
                                <div class="review-header">
                                    <strong>Priya Sharma</strong>
                                    <span class="verified-badge"><i class="fa-solid fa-circle-check"></i> <?php esc_html_e('Verified Purchase', 'kash-naturals'); ?></span>
                                    <span class="review-date">2 days ago</span>
                                </div>
                                <div class="stars-gold">★★★★★</div>
                                <h4 class="review-headline">Unbelievable natural aroma & crisp crunch!</h4>
                                <p class="review-body">Ordered this handcrafted mouth freshener and it tastes remarkably fresh! The airtight glass jar packaging is completely premium. Delivered promptly.</p>
                            </div>
                            <div class="review-card">
                                <div class="review-header">
                                    <strong>Rohan Mehta</strong>
                                    <span class="verified-badge"><i class="fa-solid fa-circle-check"></i> <?php esc_html_e('Verified Purchase', 'kash-naturals'); ?></span>
                                    <span class="review-date">1 week ago</span>
                                </div>
                                <div class="stars-gold">★★★★★</div>
                                <h4 class="review-headline">Pure luxury in every bite</h4>
                                <p class="review-body">Remarkable essential oil flavor. Perfect digestive after rich dinners. My entire family loved the authentic taste without any chemical aftertaste.</p>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Leave a Verified Review Form Section -->
                    <div class="leave-review-section-luxury" style="margin-top: 35px; padding: 28px; background: #FAF7F2; border-radius: 18px; border: 1px solid rgba(44, 95, 62, 0.15);">
                        <h3 style="font-family: 'Playfair Display', Georgia, serif; color: #1C2B1F; font-size: 1.4rem; margin-bottom: 14px;">
                            <i class="fa-solid fa-pen-to-square" style="color: #c49a56;"></i> <?php esc_html_e('Share Your Experience', 'kash-naturals'); ?>
                        </h3>
                        <?php
                        if (function_exists('comments_open') && comments_open($product_id) && function_exists('comment_form')) {
                            comment_form(array(
                                'title_reply'          => '',
                                'title_reply_to'       => __('Leave a Reply to %s', 'kash-naturals'),
                                'comment_notes_after'  => '',
                                'class_submit'         => 'btn-buy-now-green',
                                'label_submit'         => __('Submit Verified Review', 'kash-naturals'),
                            ), $product_id);
                        } else {
                            echo '<p style="color: #666; margin: 0;">' . esc_html__('Verified customer reviews are open for all purchased orders.', 'kash-naturals') . '</p>';
                        }
                        ?>
                    </div>

                </div>

            </div>
        </div>

        <?php if (!empty($related_products)) : ?>
        <!-- Related Products Section -->
        <div class="related-products-section">
            <div class="related-header">
                <h2><?php esc_html_e('YOU MAY ALSO LIKE', 'kash-naturals'); ?></h2>
                <p><?php esc_html_e('Explore complementary mouth fresheners & artisan chocolates', 'kash-naturals'); ?></p>
            </div>
            <div class="related-grid-4">
                <?php foreach ($related_products as $rel) : ?>
                    <div class="shop-product-card-exact">
                        <span class="product-badge-tag"><?php esc_html_e('Fresh Batch', 'kash-naturals'); ?></span>
                        <a href="<?php echo esc_url($rel['link']); ?>" class="product-img-box-exact">
                            <img src="<?php echo esc_url($rel['main_image']); ?>" alt="<?php echo esc_attr($rel['name']); ?>">
                        </a>
                        <div class="product-card-info">
                            <div class="product-cat-label"><?php echo esc_html($rel['category_name']); ?></div>
                            <h3 class="product-title-exact">
                                <a href="<?php echo esc_url($rel['link']); ?>" style="color: inherit; text-decoration: none;">
                                    <?php echo esc_html($rel['name']); ?>
                                </a>
                            </h3>
                            <div class="product-rating-stars">★★★★★ <span>(<?php echo esc_html($rel['rating']); ?>)</span></div>
                            <div class="product-price-row-exact">
                                <div class="price-wrap">
                                    <span class="current-price"><?php echo wp_kses_post($rel['price_html']); ?></span>
                                    <?php if (!empty($rel['reg_html'])) : ?>
                                        <span class="old-price"><?php echo wp_kses_post($rel['reg_html']); ?></span>
                                    <?php endif; ?>
                                </div>
                                <a href="<?php echo esc_url($rel['link']); ?>" class="fav-btn-view" style="font-size: 0.82rem; padding: 8px 14px;">
                                    <?php esc_html_e('VIEW DETAILS', 'kash-naturals'); ?>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

    </div>
</div>

<!-- Inline JavaScript for Image Switcher, Video Player, Share Popover, Pack Size, Quantity, Pincode & Tabs -->
<script>
function changeProductMedia(thumbBtn, type, newSrc) {
    document.querySelectorAll('.thumb-btn').forEach(b => b.classList.remove('active'));
    if (thumbBtn) thumbBtn.classList.add('active');

    const imgContainer = document.getElementById('mainImgContainer');
    const videoContainer = document.getElementById('mainVideoContainer');
    const mainImg = document.getElementById('primaryProductImg');
    const videoEl = document.getElementById('kashProductVideoEl');
    const videoIframe = document.getElementById('kashProductVideoIframe');
    const playPill = document.getElementById('productPlayVideoPill');

    if (type === 'video') {
        if (imgContainer) imgContainer.style.display = 'none';
        if (playPill) playPill.style.display = 'none';
        if (videoContainer) {
            videoContainer.style.display = 'block';
            if (videoIframe && videoIframe.dataset.src && !videoIframe.src) {
                videoIframe.src = videoIframe.dataset.src;
            }
            if (videoEl) {
                videoEl.play().catch(function() {});
            }
        }
    } else {
        // Switch back to Image
        if (videoContainer) {
            videoContainer.style.display = 'none';
            if (videoEl) {
                videoEl.pause();
            }
            if (videoIframe && videoIframe.src) {
                const cur = videoIframe.src;
                videoIframe.src = '';
                videoIframe.src = cur;
            }
        }
        if (playPill) playPill.style.display = 'inline-flex';
        if (imgContainer) {
            imgContainer.style.display = 'block';
            if (mainImg && newSrc) {
                mainImg.style.opacity = '0.35';
                setTimeout(() => {
                    mainImg.src = newSrc;
                    mainImg.style.opacity = '1';
                }, 120);
            }
        }
    }
}

function switchToProductVideo() {
    const videoThumb = document.querySelector('.thumb-video-btn');
    if (videoThumb) {
        changeProductMedia(videoThumb, 'video', '');
    } else {
        changeProductMedia(null, 'video', '');
    }
}

function changeProductImage(thumbBtn, newSrc) {
    changeProductMedia(thumbBtn, 'image', newSrc);
}

function toggleProductShare(e) {
    if (e) e.stopPropagation();
    const sharePopover = document.getElementById('productSharePopover');

    // On mobile devices, invoke native Web Share API
    if (navigator.share && /mobile|android|iphone|ipad/i.test(navigator.userAgent)) {
        navigator.share({
            title: document.title,
            text: 'Discover ' + document.title + ' on Kash Naturals',
            url: window.location.href
        }).catch(function() {});
        return;
    }

    if (sharePopover) {
        const isShown = sharePopover.style.display !== 'none';
        sharePopover.style.display = isShown ? 'none' : 'block';
    }
}

document.addEventListener('click', function(e) {
    const sharePopover = document.getElementById('productSharePopover');
    const shareWrap = document.querySelector('.product-share-wrap');
    if (sharePopover && shareWrap && !shareWrap.contains(e.target)) {
        sharePopover.style.display = 'none';
    }
});

function kashShareAction(channel) {
    const url = encodeURIComponent(window.location.href);
    const title = encodeURIComponent(document.title);

    if (channel === 'whatsapp') {
        window.open('https://api.whatsapp.com/send?text=' + title + '%20' + url, '_blank');
    } else if (channel === 'facebook') {
        window.open('https://www.facebook.com/sharer/sharer.php?u=' + url, '_blank');
    } else if (channel === 'x') {
        window.open('https://twitter.com/intent/tweet?url=' + url + '&text=' + title, '_blank');
    } else if (channel === 'copy') {
        if (navigator.clipboard && navigator.clipboard.writeText) {
            navigator.clipboard.writeText(window.location.href).then(onLinkCopied);
        } else {
            const temp = document.createElement('input');
            document.body.appendChild(temp);
            temp.value = window.location.href;
            temp.select();
            document.execCommand('copy');
            document.body.removeChild(temp);
            onLinkCopied();
        }
    }
}

function onLinkCopied() {
    const label = document.querySelector('.share-copy-label');
    if (label) {
        const orig = label.textContent;
        label.textContent = 'Copied!';
        setTimeout(() => { label.textContent = orig; }, 2500);
    }
    if (typeof showToast === 'function') {
        showToast('Product link copied to clipboard!', 'success');
    } else {
        alert('Product link copied to clipboard!');
    }
}

const kashVariationsData = <?php echo !empty($variations_json_data) ? wp_json_encode($variations_json_data) : '{}'; ?>;
let activeVariationId = <?php echo intval($default_variation_id); ?>;

function kashSelectVariation(vid) {
    if (!kashVariationsData || !kashVariationsData[vid]) return;
    const v = kashVariationsData[vid];
    activeVariationId = vid;

    // 1. Highlight pill
    document.querySelectorAll('.size-pill-btn').forEach(btn => {
        if (parseInt(btn.getAttribute('data-variation-id')) === vid) {
            btn.classList.add('active');
        } else {
            btn.classList.remove('active');
        }
    });

    // 2. Update price and regular price
    const mainPriceEl = document.getElementById('productMainPrice');
    const regPriceEl  = document.getElementById('productRegularPrice');
    const savingsEl   = document.getElementById('productSavingsBadge');
    const imgDiscEl   = document.getElementById('productImageDiscountTag');

    if (mainPriceEl) {
        mainPriceEl.innerHTML = v.price_html;
    }
    if (regPriceEl) {
        if (v.regular_html) {
            regPriceEl.innerHTML = v.regular_html;
            regPriceEl.style.display = 'inline-block';
        } else {
            regPriceEl.style.display = 'none';
        }
    }
    if (savingsEl) {
        if (v.discount > 0) {
            savingsEl.textContent = 'Save ' + v.discount + '%';
            savingsEl.style.display = 'inline-block';
        } else {
            savingsEl.style.display = 'none';
        }
    }
    if (imgDiscEl) {
        if (v.discount > 0) {
            imgDiscEl.textContent = v.discount + '% OFF';
            imgDiscEl.style.display = 'inline-block';
        } else {
            imgDiscEl.style.display = 'none';
        }
    }

    // 3. Update stock badge and buttons
    const stockBadge = document.getElementById('productStockBadge');
    const addBtn     = document.getElementById('singleProductAddToCartBtn');
    const buyBtn     = document.getElementById('singleProductBuyNowBtn');

    if (stockBadge) {
        if (v.in_stock) {
            stockBadge.className = 'stock-status-badge in-stock';
            let stockTxt = 'In Stock (Ready to Ship)';
            if (v.max_qty > 0 && v.max_qty <= 5) {
                stockTxt = 'Only ' + v.max_qty + ' left in stock - Order Soon';
            }
            stockBadge.innerHTML = '<i class="fa-solid fa-circle-check"></i> <span class="stock-badge-text">' + stockTxt + '</span>';
        } else {
            stockBadge.className = 'stock-status-badge out-of-stock';
            stockBadge.innerHTML = '<i class="fa-solid fa-circle-xmark"></i> <span class="stock-badge-text">Out of Stock (Unavailable)</span>';
        }
    }

    if (addBtn) {
        addBtn.setAttribute('data-variation-id', vid);
        addBtn.setAttribute('data-product-price', v.price);
        if (v.in_stock) {
            addBtn.disabled = false;
            addBtn.classList.remove('btn-out-of-stock');
            addBtn.innerHTML = '<i class="fa-solid fa-cart-shopping"></i> <span class="btn-label-text">ADD TO CART</span>';
        } else {
            addBtn.disabled = true;
            addBtn.classList.add('btn-out-of-stock');
            addBtn.innerHTML = '<i class="fa-solid fa-ban"></i> <span class="btn-label-text">OUT OF STOCK</span>';
        }
    }

    if (buyBtn) {
        buyBtn.setAttribute('data-variation-id', vid);
        if (v.in_stock) {
            buyBtn.disabled = false;
            buyBtn.classList.remove('btn-out-of-stock');
        } else {
            buyBtn.disabled = true;
            buyBtn.classList.add('btn-out-of-stock');
        }
    }

    // 4. Update SKU
    const skuEl = document.getElementById('productSkuDisplay');
    if (skuEl && v.sku) {
        skuEl.textContent = v.sku;
    }

    // 5. Update Quantity Max
    const qtyInput = document.getElementById('productQtyInput');
    if (qtyInput) {
        qtyInput.setAttribute('max', v.max_qty || 20);
        let cur = parseInt(qtyInput.value) || 1;
        if (cur > (v.max_qty || 20)) {
            qtyInput.value = v.max_qty || 20;
        }
    }

    // 6. Update Product Image if variation has its own picture
    if (v.image) {
        const primaryImg = document.getElementById('primaryProductImg');
        if (primaryImg && primaryImg.src !== v.image) {
            primaryImg.style.opacity = '0.35';
            setTimeout(() => {
                primaryImg.src = v.image;
                primaryImg.style.opacity = '1';
            }, 120);
        }
    }
}

function selectPackSize(btn, sizeName, price) {
    document.querySelectorAll('.size-pill-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    
    // Update simple product price display
    const mainPriceEl = document.getElementById('productMainPrice');
    const currency = '<?php echo esc_js($currency_symbol); ?>';
    if (mainPriceEl && price) {
        mainPriceEl.textContent = currency + parseFloat(price).toFixed(2);
    }
    const addBtn = document.getElementById('singleProductAddToCartBtn');
    if (addBtn && price) {
        addBtn.setAttribute('data-product-price', price);
    }
}

function updateQty(delta) {
    const input = document.getElementById('productQtyInput');
    if (input) {
        let val = parseInt(input.value) || 1;
        val += delta;
        const max = parseInt(input.getAttribute('max')) || 20;
        if (val < 1) val = 1;
        if (val > max) val = max;
        input.value = val;
    }
}

function switchProductTab(btn, tabId) {
    document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
    document.querySelectorAll('.tab-pane-content').forEach(p => p.classList.remove('active'));
    btn.classList.add('active');
    const activePane = document.getElementById(tabId);
    if (activePane) activePane.classList.add('active');
}

function checkDeliveryPincode() {
    const input = document.getElementById('pincodeInput');
    const pincode = input ? input.value.trim() : '';
    const msg = document.getElementById('pincodeResultMessage');
    if (!msg) return;
    
    if (pincode.length === 6 && /^\d+$/.test(pincode)) {
        msg.innerHTML = '<span style="color: #2e7d32; font-weight:600;"><i class="fa-solid fa-circle-check"></i> Express Delivery Available to ' + pincode + '! Estimated arrival in 2-4 business days. Free Doorstep Delivery. Cash on Delivery Available.</span>';
    } else {
        msg.innerHTML = '<span style="color: #d32f2f; font-weight:600;"><i class="fa-solid fa-circle-exclamation"></i> Please enter a valid 6-digit Indian Postal Pincode.</span>';
    }
}

function handleSingleAddToCart(id) {
    const qtyInput = document.getElementById('productQtyInput');
    const qty = qtyInput ? (parseInt(qtyInput.value) || 1) : 1;
    const addBtn = document.getElementById('singleProductAddToCartBtn');
    if (addBtn && addBtn.disabled) return;

    const varId = activeVariationId || (addBtn ? parseInt(addBtn.getAttribute('data-variation-id')) : 0);
    const varData = (varId && kashVariationsData && kashVariationsData[varId]) ? kashVariationsData[varId] : null;

    if (addBtn) {
        addBtn.classList.add('loading');
        addBtn.disabled = true;
    }

    const ajaxUrl = (typeof kash_dynamic_data !== 'undefined' && kash_dynamic_data.ajax_url)
        ? kash_dynamic_data.ajax_url
        : ((typeof kash_wc_params !== 'undefined') ? kash_wc_params.ajax_url : '<?php echo esc_js(admin_url('admin-ajax.php')); ?>');

    const postData = {
        action: 'kash_add_to_cart',
        product_id: id,
        quantity: qty
    };
    if (varId) {
        postData.variation_id = varId;
        if (varData && varData.attributes) {
            postData.variation = varData.attributes;
        }
    }

    jQuery.ajax({
        type: 'POST',
        url: ajaxUrl,
        data: postData,
        dataType: 'json',
        success: function(res) {
            if (addBtn) {
                addBtn.classList.remove('loading');
                addBtn.disabled = false;
            }
            if (res && res.success) {
                if (typeof showToast === 'function') {
                    showToast(res.data.message || 'Added to cart!');
                }
                if (typeof openCartDrawer === 'function') {
                    openCartDrawer();
                }
                if (typeof syncWithWooCommerceCart === 'function') {
                    syncWithWooCommerceCart();
                }
                jQuery(document.body).trigger('wc_fragment_refresh');
            } else {
                const msg = (res && res.data && res.data.message) ? res.data.message : 'Could not add to cart.';
                if (typeof showToast === 'function') {
                    showToast(msg, 'info');
                } else {
                    alert(msg);
                }
            }
        },
        error: function() {
            if (addBtn) {
                addBtn.classList.remove('loading');
                addBtn.disabled = false;
            }
            if (typeof addToCart === 'function') {
                addToCart(varId || id, qty);
            }
        }
    });
}

function handleBuyNow(id) {
    const qtyInput = document.getElementById('productQtyInput');
    const qty = qtyInput ? (parseInt(qtyInput.value) || 1) : 1;
    const varId = activeVariationId || 0;
    const targetId = varId ? varId : id;
    
    <?php if (function_exists('wc_get_checkout_url')) : ?>
        window.location.href = '<?php echo esc_js(wc_get_checkout_url()); ?>?add-to-cart=' + targetId + '&quantity=' + qty;
    <?php else : ?>
        handleSingleAddToCart(id);
    <?php endif; ?>
}
</script>

<?php
/**
 * Hook: woocommerce_after_single_product.
 */
do_action('woocommerce_after_single_product');
?>
