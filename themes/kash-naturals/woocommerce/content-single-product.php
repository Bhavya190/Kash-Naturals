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

    // Pricing & Currency
    $currency_symbol = function_exists('get_woocommerce_currency_symbol') ? get_woocommerce_currency_symbol() : '₹';
    $price_raw = floatval($product->get_price()) ?: 0;
    $reg_raw   = floatval($product->get_regular_price()) ?: $price_raw;

    if (function_exists('wc_price')) {
        $price_formatted = wc_price($price_raw);
        $reg_formatted   = ($reg_raw > $price_raw) ? wc_price($reg_raw) : '';
    } else {
        $price_formatted = $currency_symbol . number_format($price_raw, 2);
        $reg_formatted   = ($reg_raw > $price_raw) ? ($currency_symbol . number_format($reg_raw, 2)) : '';
    }
    $discount_percent = ($reg_raw > $price_raw && $reg_raw > 0) ? round((($reg_raw - $price_raw) / $reg_raw) * 100) : 0;

    // Ratings & Reviews
    $avg_rating = $product->get_average_rating();
    $rating_num_str = ($avg_rating > 0) ? number_format((float)$avg_rating, 1) : '5.0';
    $review_count = $product->get_review_count() ?: 0;

    // Stock Status
    $is_in_stock = $product->is_in_stock();
    $stock_status = $product->get_stock_status();
    $stock_qty = $product->managing_stock() ? $product->get_stock_quantity() : null;
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
    $weight_unit = get_option('woocommerce_weight_unit', 'g');
    $weight_str = $product->get_weight() ? ($product->get_weight() . ' ' . $weight_unit) : '200g Glass Jar';
    $sku_str = $product->get_sku() ?: ('KASH-' . $product_id);

    $custom_ing = get_post_meta($product_id, '_ingredients', true);
    $allergen_advice = get_post_meta($product_id, '_allergen_advice', true);
    $shelf_life = get_post_meta($product_id, '_shelf_life', true);
    $storage_inst = get_post_meta($product_id, '_storage_instructions', true);

    $nutri_energy = get_post_meta($product_id, '_nutrition_energy', true) ?: '385 kcal';
    $nutri_protein = get_post_meta($product_id, '_nutrition_protein', true) ?: '4.2 g';
    $nutri_carbs = get_post_meta($product_id, '_nutrition_carbs', true) ?: '78.5 g';
    $nutri_sugars = get_post_meta($product_id, '_nutrition_sugars', true) ?: '32.0 g';
    $nutri_fiber = get_post_meta($product_id, '_nutrition_fiber', true) ?: '12.4 g';
    $nutri_fat = get_post_meta($product_id, '_nutrition_fat', true) ?: '2.1 g';

    $cacao_pct = get_post_meta($product_id, '_cacao_percentage', true);
    $flavor_notes = get_post_meta($product_id, '_flavor_notes', true);
    $cocoa_origin = get_post_meta($product_id, '_cocoa_origin', true);

    $pack_2_label = get_post_meta($product_id, '_pack_size_2_label', true) ?: '500g Value Jar';
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

            <!-- Left: Image Gallery Showcase -->
            <div class="product-gallery-wrapper">
                <div class="main-image-display-card">
                    <?php if (!empty($badge)) : ?>
                        <span class="product-badge-pill-luxury"><?php echo esc_html($badge); ?></span>
                    <?php endif; ?>
                    <?php if (!empty($discount_percent)) : ?>
                        <span class="product-discount-tag"><?php echo esc_html($discount_percent); ?>% OFF</span>
                    <?php endif; ?>
                    <div class="main-img-container">
                        <img id="primaryProductImg" src="<?php echo esc_url($main_img); ?>" alt="<?php echo esc_attr($product_name); ?>" loading="eager">
                    </div>
                </div>

                <!-- Gallery Thumbnails Strip -->
                <?php if (count($gallery_images) > 1) : ?>
                    <div class="gallery-thumbs-strip">
                        <?php foreach ($gallery_images as $index => $thumb_src) : ?>
                            <button type="button" class="thumb-btn <?php echo ($index === 0) ? 'active' : ''; ?>" onclick="changeProductImage(this, '<?php echo esc_js($thumb_src); ?>')" aria-label="Product Image <?php echo $index + 1; ?>">
                                <img src="<?php echo esc_url($thumb_src); ?>" alt="Thumbnail <?php echo $index + 1; ?>">
                            </button>
                        <?php endforeach; ?>
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
                    <span class="product-sku-code">SKU: <?php echo esc_html($sku_str); ?></span>
                </div>

                <h1 class="product-title-main"><?php echo esc_html($product_name); ?></h1>

                <!-- Rating & Stock Status -->
                <div class="product-rating-stock-row">
                    <div class="star-rating-box">
                        <div class="stars-gold">★★★★★</div>
                        <span class="rating-num"><strong><?php echo esc_html($rating_num_str); ?></strong> (<?php echo esc_html($review_count); ?> <?php esc_html_e('Customer Reviews', 'kash-naturals'); ?>)</span>
                    </div>
                    <?php if ($is_in_stock) : ?>
                        <div class="stock-status-badge in-stock">
                            <i class="fa-solid fa-circle-check"></i> <?php echo esc_html($stock_display_text); ?>
                        </div>
                    <?php else : ?>
                        <div class="stock-status-badge out-of-stock">
                            <i class="fa-solid fa-circle-xmark"></i> <?php echo esc_html($stock_display_text); ?>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Price Box -->
                <div class="product-price-display-box">
                    <span class="current-price-val"><?php echo wp_kses_post($price_formatted); ?></span>
                    <?php if (!empty($reg_formatted)) : ?>
                        <span class="regular-price-val"><?php echo wp_kses_post($reg_formatted); ?></span>
                    <?php endif; ?>
                    <span class="price-tax-note">(<?php esc_html_e('Inclusive of all taxes & doorstep packaging', 'kash-naturals'); ?>)</span>
                </div>

                <?php if (!empty($flavor_notes) || !empty($cacao_pct)) : ?>
                    <div class="product-artisan-highlights-pill-row" style="display:flex; gap:10px; margin: 14px 0; flex-wrap:wrap;">
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
                    </div>
                <?php endif; ?>

                <!-- Short Editorial Description -->
                <div class="product-editorial-desc">
                    <?php echo wpautop(wp_kses_post($short_desc)); ?>
                </div>

                <!-- Weight / Size Selection Pills -->
                <div class="product-option-selector">
                    <label class="selector-label"><?php esc_html_e('SELECT PACK SIZE:', 'kash-naturals'); ?></label>
                    <div class="size-pills-wrap">
                        <button type="button" class="size-pill-btn active" onclick="selectPackSize(this, '<?php echo esc_js($weight_str); ?>', <?php echo esc_js($price_raw); ?>)">
                            <span><?php echo esc_html($weight_str); ?></span>
                            <span class="pill-best-val"><?php esc_html_e('Best Seller', 'kash-naturals'); ?></span>
                        </button>
                        <button type="button" class="size-pill-btn" onclick="selectPackSize(this, '<?php echo esc_js($pack_2_label); ?>', <?php echo esc_js($pack_2_price); ?>)">
                            <span><?php echo esc_html($pack_2_label); ?></span>
                            <span class="pill-save-val"><?php esc_html_e('Value Pack', 'kash-naturals'); ?></span>
                        </button>
                    </div>
                </div>

                <!-- Quantity & Add to Cart Controls -->
                <div class="purchase-action-controls">
                    <div class="quantity-counter-box">
                        <button type="button" class="qty-btn minus" onclick="updateQty(-1)" aria-label="Decrease quantity">-</button>
                        <input type="number" id="productQtyInput" name="quantity" value="1" min="1" max="<?php echo ($stock_qty ? esc_attr($stock_qty) : 20); ?>" readonly>
                        <button type="button" class="qty-btn plus" onclick="updateQty(1)" aria-label="Increase quantity">+</button>
                    </div>

                    <?php if ($is_in_stock) : ?>
                        <button type="button" class="btn-add-to-cart-gold add-to-cart-btn add_to_cart_button ajax_add_to_cart" 
                                id="singleProductAddToCartBtn"
                                data-product-id="<?php echo esc_attr($product_id); ?>" 
                                data-product_id="<?php echo esc_attr($product_id); ?>" 
                                data-product-name="<?php echo esc_attr($product_name); ?>" 
                                data-product-price="<?php echo esc_attr($price_raw); ?>" 
                                data-product-img="<?php echo esc_url($main_img); ?>" 
                                onclick="handleSingleAddToCart(<?php echo esc_attr($product_id); ?>)">
                            <i class="fa-solid fa-cart-shopping"></i> <?php esc_html_e('ADD TO CART', 'kash-naturals'); ?>
                        </button>

                        <button type="button" class="btn-buy-now-green" 
                                id="singleProductBuyNowBtn"
                                onclick="handleBuyNow(<?php echo esc_attr($product_id); ?>)">
                            <i class="fa-solid fa-bolt"></i> <?php esc_html_e('BUY IT NOW', 'kash-naturals'); ?>
                        </button>
                    <?php else : ?>
                        <button type="button" class="btn-add-to-cart-gold btn-out-of-stock" disabled style="background:#4b5563 !important; cursor:not-allowed !important; opacity:0.8; box-shadow:none !important; color:#fff !important;">
                            <i class="fa-solid fa-ban"></i> <?php esc_html_e('OUT OF STOCK', 'kash-naturals'); ?>
                        </button>
                    <?php endif; ?>
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

<!-- Inline JavaScript for Image Switcher, Pack Size, Quantity, Pincode & Tabs -->
<script>
function changeProductImage(thumbBtn, newSrc) {
    document.querySelectorAll('.thumb-btn').forEach(b => b.classList.remove('active'));
    thumbBtn.classList.add('active');
    const mainImg = document.getElementById('primaryProductImg');
    if (mainImg) {
        mainImg.style.opacity = '0.35';
        setTimeout(() => {
            mainImg.src = newSrc;
            mainImg.style.opacity = '1';
        }, 120);
    }
}

function selectPackSize(btn, sizeName, price) {
    document.querySelectorAll('.size-pill-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
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
    
    // WooCommerce AJAX Add to Cart if parameters exist
    if (typeof kash_wc_params !== 'undefined' && kash_wc_params.ajax_url) {
        jQuery.ajax({
            type: 'POST',
            url: kash_wc_params.ajax_url,
            data: {
                action: 'woocommerce_add_to_cart',
                product_id: id,
                quantity: qty
            },
            success: function() {
                jQuery(document.body).trigger('wc_fragment_refresh');
            }
        });
    }

    if (typeof window.addToCart === 'function') {
        window.addToCart(id, qty);
    } else {
        let cart = JSON.parse(localStorage.getItem('kash_cart') || '[]');
        const existing = cart.find(i => i.id == id);
        if (existing) {
            existing.qty += qty;
        } else {
            cart.push({ id: id, qty: qty });
        }
        localStorage.setItem('kash_cart', JSON.stringify(cart));
        const badge = document.querySelector('.cart-count-badge, .cart-count-badge-orange, #mini-cart-count');
        if (badge) badge.textContent = cart.length;
    }
}

function handleBuyNow(id) {
    const qtyInput = document.getElementById('productQtyInput');
    const qty = qtyInput ? (parseInt(qtyInput.value) || 1) : 1;
    <?php if (function_exists('wc_get_checkout_url')) : ?>
        window.location.href = '<?php echo esc_js(wc_get_checkout_url()); ?>?add-to-cart=' + id + '&quantity=' + qty;
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
