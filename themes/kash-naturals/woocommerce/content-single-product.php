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
                }
            }
        }
    }

    // Default Selection: Always pre-select 200 GM by default if available, or first in-stock
    if ($is_variable && !empty($variations_json_data) && ($default_variation_id === 0 || empty($default_variation_data))) {
        // 1. Look for 200 GM variant first
        foreach ($variations_json_data as $vid_check => $vdata_check) {
            if (stripos($vdata_check['label'], '200') !== false && !empty($vdata_check['in_stock'])) {
                $default_variation_id = $vid_check;
                $default_variation_data = $vdata_check;
                break;
            }
        }
        // 2. Fallback to first in-stock variant
        if ($default_variation_id === 0) {
            foreach ($variations_json_data as $vid_check => $vdata_check) {
                if (!empty($vdata_check['in_stock'])) {
                    $default_variation_id = $vid_check;
                    $default_variation_data = $vdata_check;
                    break;
                }
            }
        }
        // 3. Fallback to first variant in list
        if ($default_variation_id === 0) {
            $f_vid = array_key_first($variations_json_data);
            $default_variation_id = $f_vid;
            $default_variation_data = $variations_json_data[$f_vid];
        }
    }

    if ($default_variation_data) {
        $price_raw        = $default_variation_data['price'];
        $reg_raw          = $default_variation_data['regular_price'];
        $price_formatted  = $default_variation_data['price_html'];
        $reg_formatted    = $default_variation_data['regular_html'];
        $discount_percent = $default_variation_data['discount'];
    } else {
        if ($is_variable && method_exists($product, 'get_price_html')) {
            $price_formatted  = $product->get_price_html();
            $reg_formatted    = '';
            $discount_percent = 0;
            $price_raw        = $product->get_variation_price('min', true);
            $reg_raw          = $product->get_variation_regular_price('max', true);
        } elseif (function_exists('wc_price')) {
            $price_formatted = wc_price($price_raw);
            $reg_formatted   = ($reg_raw > $price_raw) ? wc_price($reg_raw) : '';
            $discount_percent = ($reg_raw > $price_raw && $reg_raw > 0) ? round((($reg_raw - $price_raw) / $reg_raw) * 100) : 0;
        } else {
            $price_formatted = $currency_symbol . number_format($price_raw, 2);
            $reg_formatted   = ($reg_raw > $price_raw) ? ($currency_symbol . number_format($reg_raw, 2)) : '';
            $discount_percent = ($reg_raw > $price_raw && $reg_raw > 0) ? round((($reg_raw - $price_raw) / $reg_raw) * 100) : 0;
        }
    }

    // Resolve Composite Product Title: [Product Title] | [Post Title/s] | [Variant]
    $default_v_label = !empty($default_variation_data['label']) ? $default_variation_data['label'] : '';
    $title_parts     = function_exists('kash_get_product_title_parts') 
        ? kash_get_product_title_parts($product, $default_v_label) 
        : array(
            'base_title' => $product_name,
            'subtitles'  => '',
            'variant'    => $default_v_label,
            'full_title' => $product_name,
        );

    // Real WooCommerce Customer Reviews & Dynamic Rating
    $approved_reviews = array();
    if (function_exists('get_comments')) {
        $approved_reviews = get_comments(array(
            'post_id' => $product_id,
            'status'  => 'approve',
        ));
    }
    $real_review_count = count($approved_reviews);
    $rating_counts = array(5 => 0, 4 => 0, 3 => 0, 2 => 0, 1 => 0);
    $sum_ratings = 0;
    if ($real_review_count > 0) {
        foreach ($approved_reviews as $rev_item) {
            $r_val = intval(get_comment_meta($rev_item->comment_ID, 'rating', true));
            if ($r_val < 1 || $r_val > 5) $r_val = 5;
            $rating_counts[$r_val]++;
            $sum_ratings += $r_val;
        }
        $display_avg_rating = round($sum_ratings / $real_review_count, 1);
        $rating_num_str = number_format($display_avg_rating, 1);
    } else {
        $wc_avg = $product->get_average_rating();
        $display_avg_rating = ($wc_avg > 0) ? (float)$wc_avg : 5.0;
        $rating_num_str = number_format($display_avg_rating, 1);
    }
    $review_count = $real_review_count;

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

    // Custom Tabs Backend Meta
    $meta_about_item        = get_post_meta($product_id, '_about_this_item', true);
    $meta_about_bullets     = get_post_meta($product_id, '_about_bullets', true);
    $meta_highlights        = get_post_meta($product_id, '_product_highlights', true);

    $meta_flavour           = get_post_meta($product_id, '_spec_flavour', true);
    $meta_brand             = get_post_meta($product_id, '_spec_brand', true);
    $meta_item_weight       = get_post_meta($product_id, '_spec_item_weight', true);
    $meta_package_info      = get_post_meta($product_id, '_spec_package_info', true);
    $dietary_type           = get_post_meta($product_id, '_dietary_type', true);
    $meta_package_weight    = get_post_meta($product_id, '_spec_package_weight', true);
    $meta_number_of_pieces  = get_post_meta($product_id, '_spec_number_of_pieces', true);
    $meta_net_quantity      = get_post_meta($product_id, '_spec_net_quantity', true);
    $cocoa_origin           = get_post_meta($product_id, '_cocoa_origin', true);
    $meta_claim             = get_post_meta($product_id, '_spec_claim', true);
    $flavor_notes           = get_post_meta($product_id, '_flavor_notes', true);
    $cacao_pct              = get_post_meta($product_id, '_cacao_percentage', true);

    $custom_ing             = get_post_meta($product_id, '_ingredients', true);
    $allergen_advice        = get_post_meta($product_id, '_allergen_advice', true);
    $shelf_life             = get_post_meta($product_id, '_shelf_life', true);
    $storage_inst           = get_post_meta($product_id, '_storage_instructions', true);

    $nutri_energy           = get_post_meta($product_id, '_nutrition_energy', true) ?: '385 kcal';
    $nutri_protein          = get_post_meta($product_id, '_nutrition_protein', true) ?: '4.2 g';
    $nutri_carbs            = get_post_meta($product_id, '_nutrition_carbs', true) ?: '78.5 g';
    $nutri_sugars           = get_post_meta($product_id, '_nutrition_sugars', true) ?: '32.0 g';
    $nutri_fiber            = get_post_meta($product_id, '_nutrition_fiber', true) ?: '12.4 g';
    $nutri_fat              = get_post_meta($product_id, '_nutrition_fat', true) ?: '2.1 g';

    $pack_2_label           = get_post_meta($product_id, '_pack_size_2_label', true);
    $pack_2_price           = floatval(get_post_meta($product_id, '_pack_size_2_price', true)) ?: ($price_raw * 2.2);

    $ingredients_display    = !empty($custom_ing) ? $custom_ing : __('Authentic fennel seeds (saunf), natural menthol, cardamom (elaichi), silver foil (varak), pure rose petals, dates, betel leaves extract, rock sugar, Permitted Natural Flavors.', 'kash-naturals');
    $allergen_display       = !empty($allergen_advice) ? $allergen_advice : __('Allergen Advice: Processed in a clean facility that also handles tree nuts, sesame, and pure dairy.', 'kash-naturals');
    $shelf_life_display     = !empty($shelf_life) ? $shelf_life : __('9 Months from the date of manufacturing when kept sealed in the original glass container.', 'kash-naturals');
    $storage_display        = !empty($storage_inst) ? $storage_inst : __('Store in a cool, dry place away from direct sunlight, heat, and moisture. Always use a dry spoon and close lid securely after opening.', 'kash-naturals');

    // Smart Fallback Parser for Imported Catalog Products & HTML Tables
    $raw_combined_desc = $short_desc . "\n" . $full_desc;
    $parsed_specs = array();
    $parsed_bullets = array();
    $clean_short_intro = '';

    $spec_labels = array(
        'Flavour', 'Brand', 'Item Weight', 'Package Information', 'Speciality', 
        'Package Weight', 'Number of Pieces', 'Net Quantity', 'Region of Origin', 
        'Cultivation Method Claim', 'Diet Type', 'Country of Origin'
    );

    // 1. Parse HTML <table> rows if an HTML table exists in content (e.g. Amazon specs table)
    if (stripos($raw_combined_desc, '<table') !== false) {
        if (preg_match_all('/<tr\b[^>]*>(.*?)<\/tr>/is', $raw_combined_desc, $tr_matches, PREG_SET_ORDER)) {
            foreach ($tr_matches as $tr_match) {
                $tr_tag = $tr_match[0];
                $tr_inner = $tr_match[1];
                
                // Match by row class if Amazon specific (e.g. po-flavor, po-brand, po-item_weight, po-container.type)
                $target_label = '';
                if (stripos($tr_tag, 'po-flavor') !== false) $target_label = 'Flavour';
                elseif (stripos($tr_tag, 'po-brand') !== false) $target_label = 'Brand';
                elseif (stripos($tr_tag, 'po-item_weight') !== false) $target_label = 'Item Weight';
                elseif (stripos($tr_tag, 'po-container.type') !== false || stripos($tr_tag, 'po-package_information') !== false) $target_label = 'Package Information';
                elseif (stripos($tr_tag, 'po-speciality') !== false || stripos($tr_tag, 'po-diet_type') !== false) $target_label = 'Speciality';
                elseif (stripos($tr_tag, 'po-package_weight') !== false) $target_label = 'Package Weight';
                elseif (stripos($tr_tag, 'po-number_of_pieces') !== false) $target_label = 'Number of Pieces';
                elseif (stripos($tr_tag, 'po-net_quantity') !== false) $target_label = 'Net Quantity';
                elseif (stripos($tr_tag, 'po-region_of_origin') !== false || stripos($tr_tag, 'po-country_of_origin') !== false) $target_label = 'Region of Origin';
                elseif (stripos($tr_tag, 'po-cultivation_method_claim') !== false) $target_label = 'Cultivation Method Claim';

                if (preg_match_all('/<(?:td|th)\b[^>]*>(.*?)<\/(?:td|th)>/is', $tr_inner, $cell_matches)) {
                    $cells = $cell_matches[1];
                    if (count($cells) >= 2) {
                        $cell_k = trim(wp_strip_all_tags($cells[0]));
                        $cell_v = trim(wp_strip_all_tags($cells[1]));
                        if (!empty($cell_v)) {
                            if (!empty($target_label)) {
                                $parsed_specs[$target_label] = $cell_v;
                            } else {
                                foreach ($spec_labels as $slbl) {
                                    if (strcasecmp($cell_k, $slbl) === 0 || stripos($cell_k, $slbl) !== false) {
                                        $parsed_specs[$slbl] = $cell_v;
                                        break;
                                    }
                                }
                            }
                        }
                    } elseif (count($cells) === 1 && !empty($target_label)) {
                        $cell_v = trim(wp_strip_all_tags($cells[0]));
                        if (!empty($cell_v)) {
                            $parsed_specs[$target_label] = $cell_v;
                        }
                    }
                }
            }
        }
    }

    // 2. Also parse plain-text "Top highlights" if present
    if (stripos($raw_combined_desc, 'Top highlights') !== false) {
        $before_top = trim(substr($short_desc, 0, stripos($short_desc, 'Top highlights')));
        if (!empty($before_top) && strlen($before_top) > 15) {
            $clean_short_intro = trim(wp_strip_all_tags($before_top));
        }

        preg_match('/Top highlights\s+(.*?)(?:About this item\s*(.*))?$/is', $raw_combined_desc, $matches);
        $specs_raw = isset($matches[1]) ? trim($matches[1]) : '';
        // Only parse if not raw HTML table
        if (stripos($specs_raw, '<table') === false) {
            $pattern = '/(?=' . implode('|', array_map('preg_quote', $spec_labels)) . ')/i';
            $parts = preg_split($pattern, $specs_raw, -1, PREG_SPLIT_NO_EMPTY);
            if (!empty($parts)) {
                foreach ($parts as $part) {
                    foreach ($spec_labels as $lbl) {
                        if (stripos($part, $lbl) === 0) {
                            $val = trim(substr($part, strlen($lbl)));
                            $val = ltrim($val, ': ');
                            if (!empty($val) && empty($parsed_specs[$lbl])) {
                                $parsed_specs[$lbl] = trim(wp_strip_all_tags($val));
                            }
                            break;
                        }
                    }
                }
            }
        }
    }

    // 3. Extract Clean Bullet Points (Completely stripped of any tables or HTML markup)
    $clean_for_bullets = $raw_combined_desc;
    // Strip all tables so table rows/cells can NEVER become bullet points
    $clean_for_bullets = preg_replace('/<table\b[^>]*>.*?<\/table>/is', '', $clean_for_bullets);
    $clean_for_bullets = preg_replace('/<h[1-6]\b[^>]*>.*?<\/h[1-6]>/is', '', $clean_for_bullets);
    $clean_for_bullets = preg_replace('/<div\b[^>]*id="productOverview[^"]*"[^>]*>.*?<\/div>/is', '', $clean_for_bullets);
    $clean_for_bullets = preg_replace('/<a\b[^>]*class="[^"]*expander[^"]*"[^>]*>.*?<\/a>/is', '', $clean_for_bullets);
    $clean_for_bullets = preg_replace('/\{[^{}]*"(?:allowLinkDefault|expand_prompt|collapse_prompt)"[^{}]*\}/is', '', $clean_for_bullets);
    $clean_for_bullets = preg_replace('/<script\b[^>]*>.*?<\/script>/is', '', $clean_for_bullets);
    $clean_for_bullets = preg_replace('/<style\b[^>]*>.*?<\/style>/is', '', $clean_for_bullets);

    // Look for <li> tags first
    if (preg_match_all('/<li\b[^>]*>(.*?)<\/li>/is', $clean_for_bullets, $li_matches)) {
        foreach ($li_matches[1] as $li_candidate) {
            $cleaned_li = trim(wp_strip_all_tags($li_candidate));
            $cleaned_li = html_entity_decode($cleaned_li, ENT_QUOTES, 'UTF-8');
            $cleaned_li = trim(preg_replace('/^[\s\-•*–—:;]+/u', '', $cleaned_li));
            if (!empty($cleaned_li) && strlen($cleaned_li) > 8 && !preg_match('/(?:role=|aria-|class=|po-|allowLinkDefault|<|>|\{|\}|table|tbody|tr\b|td\b)/i', $cleaned_li)) {
                $parsed_bullets[] = $cleaned_li;
            }
        }
    }

    // If no <li> found, extract lines after "About this item" or from description
    if (empty($parsed_bullets)) {
        $about_chunk = '';
        if (stripos($clean_for_bullets, 'About this item') !== false) {
            $about_chunk = substr($clean_for_bullets, stripos($clean_for_bullets, 'About this item') + strlen('About this item'));
        } else {
            $about_chunk = $clean_for_bullets;
        }

        $lines = preg_split('/(?:\r\n|\r|\n|\x{2022}|\x{25E6}|\x{25AA}|\*|•)/u', $about_chunk);
        if (!empty($lines)) {
            foreach ($lines as $ln) {
                $clean_ln = trim(wp_strip_all_tags($ln));
                $clean_ln = html_entity_decode($clean_ln, ENT_QUOTES, 'UTF-8');
                $clean_ln = trim(preg_replace('/^[\s\-•*–—:;]+/u', '', $clean_ln));
                if (!empty($clean_ln) && strlen($clean_ln) > 10 && !preg_match('/(?:role=|aria-|class=|po-|allowLinkDefault|<|>|\{|\}|table|tbody|tr\b|td\b|^\[\.+\]$|^\.+$)/i', $clean_ln)) {
                    // Make sure it is not just heading
                    if (!preg_match('/^(?:top highlights|about this item|product description|specifications)[\s:]*$/i', $clean_ln)) {
                        $parsed_bullets[] = $clean_ln;
                    }
                }
            }
        }
    }

    // Clean short intro beside image
    if (empty($clean_short_intro)) {
        $clean_cand = $short_desc;
        $clean_cand = preg_replace('/<table\b[^>]*>.*?<\/table>/is', '', $clean_cand);
        $clean_cand = preg_replace('/Top highlights.*$/is', '', $clean_cand);
        $clean_cand = preg_replace('/About this item.*$/is', '', $clean_cand);
        $clean_cand = trim(wp_strip_all_tags($clean_cand));
        if (!empty($clean_cand) && strlen($clean_cand) > 15) {
            $clean_short_intro = $clean_cand;
        } else {
            $clean_short_intro = sprintf(__('Exquisite artisanal %s handcrafted using authentic royal heritage recipes, natural seeds, and soothing digestive herbs for pure freshness and crisp crunch.', 'kash-naturals'), esc_html($product_name));
        }
    }

    // Priority 1: Check if "About This Item" tab content has been modified in backend
    $has_custom_tab_story   = !empty(trim($meta_about_item));
    $has_custom_tab_bullets = !empty(trim($meta_about_bullets));
    $has_custom_tab_content = ($has_custom_tab_story || $has_custom_tab_bullets);

    $display_about_text = '';
    $final_bullets = array();

    if ($has_custom_tab_content) {
        // FIRST PRIORITY: Custom Tab Content provided in the backend.
        // Product description from the backend editor MUST NOT SHOW to prevent duplicate content.
        if ($has_custom_tab_story) {
            $display_about_text = trim($meta_about_item);
        }
        if ($has_custom_tab_bullets) {
            $bl_lines = explode("\n", str_replace("\r", "", $meta_about_bullets));
            foreach ($bl_lines as $b_line) {
                $clean_bl = trim(wp_strip_all_tags($b_line));
                if (!empty($clean_bl) && strlen($clean_bl) > 3 && !preg_match('/(?:role=|aria-|class=|po-|allowLinkDefault|<|>|\{|\}|table|tbody|tr\b|td\b)/i', $clean_bl)) {
                    $final_bullets[] = $clean_bl;
                }
            }
        }
    } else {
        // SECONDARY PRIORITY: Custom Tab Content not modified in backend.
        // Fall back to product description from backend editor, displayed strictly ONCE.
        $clean_desc = $full_desc;
        // Strip duplicate Amazon Top highlights overview table / expanders from story text (these belong in Tab 2)
        $clean_desc = preg_replace('/<div\b[^>]*id="productOverview[^"]*"[^>]*>.*?<\/div>/is', '', $clean_desc);
        $clean_desc = preg_replace('/<table\b[^>]*class="[^"]*a-normal[^"]*"[^>]*>.*?<\/table>/is', '', $clean_desc);
        $clean_desc = preg_replace('/<a\b[^>]*data-action="a-expander-toggle"[^>]*>.*?<\/a>/is', '', $clean_desc);
        $clean_desc = preg_replace('/<h[1-6]\b[^>]*>.*?Top highlights.*?<\/h[1-6]>/is', '', $clean_desc);
        $clean_desc = preg_replace('/\{[^{}]*"(?:allowLinkDefault|expand_prompt|collapse_prompt)"[^{}]*\}/is', '', $clean_desc);
        $clean_desc = preg_replace('/Top highlights\s+(?:Flavour|Brand).*?(?=(About this item|$))/is', '', $clean_desc);
        $clean_desc = preg_replace('/About this item[\s:]*/i', '', $clean_desc);
        $clean_desc = trim($clean_desc);

        if (empty($clean_desc)) {
            $clean_desc = $clean_short_intro;
        }

        $display_about_text = $clean_desc;
        // Keep $final_bullets empty so the bullet card is NOT outputted as duplicate text
        $final_bullets = array();
    }

    // Specifications Grid for Tab 2 ("Top Highlights") - Exactly 10 slots matching 2-column screenshot
    $spec_flavour_val = !empty($meta_flavour) ? $meta_flavour : (!empty($parsed_specs['Flavour']) ? $parsed_specs['Flavour'] : __('Sweet, Tangy & Crisp', 'kash-naturals'));
    $spec_brand_val   = !empty($meta_brand) ? $meta_brand : (!empty($parsed_specs['Brand']) ? $parsed_specs['Brand'] : 'Kash Natural');
    $spec_weight_val  = !empty($meta_item_weight) ? $meta_item_weight : (!empty($parsed_specs['Item Weight']) ? $parsed_specs['Item Weight'] : $weight_str);
    $spec_pkg_info    = !empty($meta_package_info) ? $meta_package_info : (!empty($parsed_specs['Package Information']) ? $parsed_specs['Package Information'] : __('Food-Grade Glass Jar', 'kash-naturals'));
    $spec_speciality  = !empty($dietary_type) ? $dietary_type : (!empty($parsed_specs['Speciality']) ? $parsed_specs['Speciality'] : (!empty($parsed_specs['Diet Type']) ? $parsed_specs['Diet Type'] : __('Vegetarian', 'kash-naturals')));
    $spec_pkg_weight  = !empty($meta_package_weight) ? $meta_package_weight : (!empty($parsed_specs['Package Weight']) ? $parsed_specs['Package Weight'] : $weight_str);
    $spec_pieces      = !empty($meta_number_of_pieces) ? $meta_number_of_pieces : (!empty($parsed_specs['Number of Pieces']) ? $parsed_specs['Number of Pieces'] : '1');
    $spec_net_qty     = !empty($meta_net_quantity) ? $meta_net_quantity : (!empty($parsed_specs['Net Quantity']) ? $parsed_specs['Net Quantity'] : $weight_str);
    $spec_origin      = !empty($cocoa_origin) ? $cocoa_origin : (!empty($parsed_specs['Region of Origin']) ? $parsed_specs['Region of Origin'] : (!empty($parsed_specs['Country of Origin']) ? $parsed_specs['Country of Origin'] : 'India'));
    $spec_claim_val   = !empty($meta_claim) ? $meta_claim : (!empty($parsed_specs['Cultivation Method Claim']) ? $parsed_specs['Cultivation Method Claim'] : __('No Chemical Fertilizers', 'kash-naturals'));

    $final_specs = array(
        array('label' => __('FLAVOUR', 'kash-naturals'), 'val' => $spec_flavour_val, 'icon' => 'fa-solid fa-wand-magic-sparkles'),
        array('label' => __('BRAND', 'kash-naturals'), 'val' => $spec_brand_val, 'icon' => 'fa-solid fa-crown'),
        array('label' => __('ITEM WEIGHT', 'kash-naturals'), 'val' => $spec_weight_val, 'icon' => 'fa-solid fa-scale-balanced'),
        array('label' => __('PACKAGE INFORMATION', 'kash-naturals'), 'val' => $spec_pkg_info, 'icon' => 'fa-solid fa-box-archive'),
        array('label' => __('SPECIALITY', 'kash-naturals'), 'val' => $spec_speciality, 'icon' => 'fa-solid fa-leaf'),
        array('label' => __('PACKAGE WEIGHT', 'kash-naturals'), 'val' => $spec_pkg_weight, 'icon' => 'fa-solid fa-scale-balanced'),
        array('label' => __('NUMBER OF PIECES', 'kash-naturals'), 'val' => $spec_pieces, 'icon' => 'fa-solid fa-circle-check'),
        array('label' => __('NET QUANTITY', 'kash-naturals'), 'val' => $spec_net_qty, 'icon' => 'fa-solid fa-scale-balanced'),
        array('label' => __('REGION OF ORIGIN', 'kash-naturals'), 'val' => $spec_origin, 'icon' => 'fa-solid fa-location-dot'),
        array('label' => __('CULTIVATION METHOD CLAIM', 'kash-naturals'), 'val' => $spec_claim_val, 'icon' => 'fa-solid fa-circle-check'),
    );

    // Custom Highlights Bullets List
    $custom_highlights_list = array();
    if (!empty($meta_highlights)) {
        $hl_lines = explode("\n", str_replace("\r", "", $meta_highlights));
        foreach ($hl_lines as $hl_l) {
            $hl_l = trim($hl_l);
            if (!empty($hl_l)) {
                $custom_highlights_list[] = $hl_l;
            }
        }
    }

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
    $product_name = 'Kash Natural Raj Ratan – Sweet & Salty Mukhwas';
    $title_parts  = array(
        'base_title' => 'Kash Natural Raj Ratan – Sweet & Salty Mukhwas',
        'subtitles'  => 'Traditional Indian Mouth Freshener',
        'variant'    => '200g',
        'full_title' => 'Kash Natural Raj Ratan – Sweet & Salty Mukhwas | Traditional Indian Mouth Freshener | 200g',
    );
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
    $display_avg_rating = 5.0;
    $rating_num_str = '5.0';
    $review_count = 0;
    $real_review_count = 0;
    $approved_reviews = array();
    $rating_counts = array(5 => 0, 4 => 0, 3 => 0, 2 => 0, 1 => 0);
    $is_in_stock = true;
    $stock_status = 'instock';
    $stock_qty = 5;
    $stock_display_text = 'In Stock (Ready to Ship)';
    $badge = 'Special Offer';
    $short_desc = 'A royal traditional blend of crispy fennel seeds, silver coated cardamom, sweet roasted coriander seeds (dhana dal), and digestive herbs.';
    $full_desc = 'Crafted from age-old royal Indian recipes, Kash Natural Raj Ratan Mukhwas is an exquisite mouth freshener celebrating authentic after-meal traditions. Every jar contains meticulously hand-selected fennel seeds, silver-coated cardamom seeds, naturally aromatic rose extract, and digestive seeds roasted to crispy perfection in small artisanal batches.';
    $clean_short_intro = $short_desc;
    $display_about_text = $full_desc;
    $weight_str = '200g Glass Jar';
    $sku_str = 'KASH-RR-200';
    $cacao_pct = '';
    $flavor_notes = 'Sweet, Minty, Rose Aroma, Crispy';
    $ingredients_display = 'Fennel seeds (Saunf), Roasted coriander seeds (Dhana dal), Cardamom seeds (Elaichi), Silver foil (Varak), Natural rose extract, Menthol, Vegetable oil, Permitted food colors & natural flavoring.';
    $allergen_display = 'Allergen Advice: Processed in a clean facility that handles tree nuts, sesame, and pure dairy.';
    $shelf_life_display = '9 Months from the date of manufacturing when kept sealed in the original glass container.';
    $storage_display = 'Store in a cool, dry place away from direct sunlight, heat, and moisture. Always use a dry spoon and close lid securely after opening.';
    $nutri_energy = '385 kcal';
    $nutri_protein = '4.2 g';
    $nutri_carbs = '78.5 g';
    $nutri_sugars = '32.0 g';
    $nutri_fiber = '12.4 g';
    $nutri_fat = '2.1 g';

    $final_bullets = array(
        'AUTHENTIC MUKHWAS: Premium quality traditional mouth freshener crafted with aromatic Indian spices.',
        'NATURAL INGREDIENTS: Meticulously sourced fennel, dhana dal, and soothing herbs with zero chemical preservatives.',
        'CONVENIENT PACKAGING: Sealed in an airtight glass jar to maintain optimal crispness, essential oils, and aroma.',
        'DIGESTIVE WELLNESS: Naturally rich in digestive seeds that gently soothe the stomach after heavy meals.',
        'ROYAL TASTE: Perfect blend of time-honored heritage craftsmanship for a refreshing post-meal experience.',
    );

    $final_specs = array(
        array('label' => 'FLAVOUR', 'val' => 'Sweet, Minty & Crispy', 'icon' => 'fa-solid fa-wand-magic-sparkles'),
        array('label' => 'BRAND', 'val' => 'Kash Natural', 'icon' => 'fa-solid fa-crown'),
        array('label' => 'ITEM WEIGHT', 'val' => '200 Grams', 'icon' => 'fa-solid fa-scale-balanced'),
        array('label' => 'PACKAGE INFORMATION', 'val' => 'Airtight Glass Jar', 'icon' => 'fa-solid fa-box-archive'),
        array('label' => 'SPECIALITY', 'val' => 'Vegetarian', 'icon' => 'fa-solid fa-leaf'),
        array('label' => 'PACKAGE WEIGHT', 'val' => '200 Grams', 'icon' => 'fa-solid fa-scale-balanced'),
        array('label' => 'NUMBER OF PIECES', 'val' => '1', 'icon' => 'fa-solid fa-circle-check'),
        array('label' => 'NET QUANTITY', 'val' => '200.0 Grams', 'icon' => 'fa-solid fa-scale-balanced'),
        array('label' => 'REGION OF ORIGIN', 'val' => 'India', 'icon' => 'fa-solid fa-location-dot'),
        array('label' => 'CULTIVATION METHOD CLAIM', 'val' => 'Artisanal Batch, Preservative Free', 'icon' => 'fa-solid fa-circle-check'),
    );

    $custom_highlights_list = array(
        'Prepared using royal heritage recipes from Rajasthan and Gujarat',
        '100% natural fennel seeds, silver coated cardamom, and coriander seeds',
        'No artificial colors, saccharin, or chemical preservatives',
        'Delivered fresh in eco-friendly protective packaging',
    );

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
            <span class="breadcrumb-current"><?php echo esc_html($title_parts['base_title']); ?></span>
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

                <h1 class="product-title-main" id="productTitleMain">
                    <span class="kash-base-title"><?php echo esc_html($title_parts['base_title']); ?></span><?php if (!empty($title_parts['subtitles'])) : ?><span class="kash-post-titles"> | <?php echo esc_html($title_parts['subtitles']); ?></span><?php endif; ?><span class="kash-variant-title" id="productTitleVariant"><?php echo !empty($title_parts['variant']) ? ' | ' . esc_html($title_parts['variant']) : ''; ?></span>
                </h1>

                <!-- Rating & Stock Status -->
                <div class="product-rating-stock-row">
                    <div class="star-rating-box">
                        <div class="stars-gold">
                            <?php
                            $st_full = floor($display_avg_rating);
                            for ($si = 0; $si < $st_full; $si++) echo '<i class="fa-solid fa-star"></i>';
                            if (($display_avg_rating - $st_full) >= 0.5) echo '<i class="fa-solid fa-star-half-stroke"></i>';
                            for ($si = 0; $si < (5 - ceil($display_avg_rating)); $si++) echo '<i class="fa-regular fa-star"></i>';
                            ?>
                        </div>
                        <span class="rating-num">
                            <strong><?php echo esc_html($rating_num_str); ?></strong> 
                            <a href="#tab-reviews" class="rating-count-link" onclick="openReviewsTab(event)" style="color: inherit; text-decoration: none;">
                                (<?php echo esc_html($real_review_count); ?> <?php esc_html_e('Customer Reviews', 'kash-naturals'); ?>)
                            </a>
                        </span>
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

                <!-- Short Editorial Description (Clean 1-2 Sentences, Specifications moved to Tabs below) -->
                <div class="product-editorial-desc">
                    <p class="clean-product-intro"><?php echo esc_html($clean_short_intro); ?></p>
                </div>

                <!-- Weight / Size Selection Pills -->
                <div class="product-option-selector">
                    <label class="selector-label"><?php esc_html_e('SELECT PACK SIZE:', 'kash-naturals'); ?></label>
                    <div class="size-pills-wrap">
                        <?php if ($is_variable && !empty($variations_json_data)) : ?>
                            <?php foreach ($variations_json_data as $vid => $vdata) : 
                                $is_active = ($default_variation_id > 0 && $vid === $default_variation_id);
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

                    <button type="button" class="btn-add-to-cart-gold <?php echo !$is_in_stock ? 'btn-out-of-stock' : ''; ?>" 
                            id="singleProductAddToCartBtn"
                            data-product-id="<?php echo esc_attr($product_id); ?>" 
                            data-variation-id="<?php echo esc_attr($default_variation_id); ?>" 
                            data-product_id="<?php echo esc_attr($product_id); ?>" 
                            data-product-name="<?php echo esc_attr($title_parts['full_title']); ?>" 
                            data-base-title="<?php echo esc_attr($title_parts['base_title']); ?>" 
                            data-post-titles="<?php echo esc_attr($title_parts['subtitles']); ?>" 
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
                        <input type="text" id="pincodeInput" placeholder="<?php esc_attr_e('Enter 6-digit Pincode', 'kash-naturals'); ?>" maxlength="6" inputmode="numeric" pattern="[0-9]*" oninput="this.value = this.value.replace(/[^0-9]/g, '')" onkeypress="if(event.key==='Enter') checkDeliveryPincode()">
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
                <button type="button" class="tab-btn active" onclick="switchProductTab(this, 'tab-about-item')"><?php esc_html_e('About This Item', 'kash-naturals'); ?></button>
                <button type="button" class="tab-btn" onclick="switchProductTab(this, 'tab-top-highlights')"><?php esc_html_e('Top Highlights', 'kash-naturals'); ?></button>
                <button type="button" class="tab-btn" onclick="switchProductTab(this, 'tab-reviews')"><?php esc_html_e('Customer Reviews', 'kash-naturals'); ?> (<?php echo esc_html($real_review_count); ?>)</button>
            </div>

            <div class="tabs-content-viewport">

                <!-- Tab 1: About This Item -->
                <div id="tab-about-item" class="tab-pane-content active">
                    <div class="tab-story-card">
                        <?php if (!empty($display_about_text)) : ?>
                        <h2><?php esc_html_e('Craftsmanship & Heritage', 'kash-naturals'); ?></h2>
                        <div class="tab-story-text" style="font-size: 1.02rem; line-height: 1.8; color: #444; margin-bottom: 25px;">
                            <?php 
                            if (stripos($display_about_text, '<table') !== false) {
                                echo wp_kses_post($display_about_text);
                            } else {
                                echo wpautop(wp_kses_post($display_about_text));
                            }
                            ?>
                        </div>
                        <?php endif; ?>

                        <?php if (!empty($final_bullets)) : ?>
                        <div class="about-item-bullets-wrapper" style="margin-bottom: 35px; background: #FAF7F2; border-radius: 18px; padding: 24px 28px; border: 1px solid rgba(44, 95, 62, 0.12);">
                            <h3 style="font-family: 'Playfair Display', Georgia, serif; font-size: 1.35rem; color: #1C2B1F; margin-bottom: 16px;">
                                <i class="fa-solid fa-list-check" style="color: #2C5F3E;"></i> <?php esc_html_e('About This Item', 'kash-naturals'); ?>
                            </h3>
                            <ul class="about-item-bullets-list" style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 12px;">
                                <?php foreach ($final_bullets as $bullet) : 
                                    $clean_bullet_text = trim(wp_strip_all_tags($bullet));
                                    if (empty($clean_bullet_text) || strlen($clean_bullet_text) < 3 || preg_match('/(?:<|>|table|tbody|tr\b|td\b|aria-|role=|class=)/i', $clean_bullet_text)) continue;
                                ?>
                                    <li style="display: flex; align-items: flex-start; gap: 12px; font-size: 0.98rem; line-height: 1.6; color: #334155;">
                                        <i class="fa-solid fa-circle-check" style="color: #2C5F3E; font-size: 1.1rem; margin-top: 3px; flex-shrink: 0;"></i>
                                        <span><?php echo esc_html($clean_bullet_text); ?></span>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <?php endif; ?>

                        <!-- 3 Static Heritage Cards (Small-Batch Artisan Made, Food-Grade Glass Packaging, Digestive Wellness) -->
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

                <!-- Tab 2: Top Highlights & Specifications Grid -->
                <div id="tab-top-highlights" class="tab-pane-content">
                    <div class="tab-highlights-card">
                        <h2 style="font-family: 'Playfair Display', Georgia, serif; font-size: 1.6rem; color: #1C2B1F; margin-bottom: 20px;">
                            <?php esc_html_e('Product Specifications & Highlights', 'kash-naturals'); ?>
                        </h2>

                        <!-- 2-Column Luxury Specifications Grid Card -->
                        <div class="kash-specs-grid-card" style="background: #FAF7F2; border: 1px solid rgba(44, 95, 62, 0.12); border-radius: 18px; padding: 26px 30px; margin-bottom: 30px;">
                            <div class="kash-specs-two-col-grid" style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px 30px;">
                                <?php foreach ($final_specs as $spec_row) : ?>
                                    <div class="kash-spec-item" style="display: flex; flex-direction: column; gap: 4px;">
                                        <span class="spec-label" style="display: inline-flex; align-items: center; gap: 8px; font-size: 0.8rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #2C5F3E;">
                                            <i class="<?php echo esc_attr($spec_row['icon']); ?>" style="font-size: 0.95rem;"></i>
                                            <?php echo esc_html($spec_row['label']); ?>
                                        </span>
                                        <span class="spec-value" style="font-size: 1.05rem; font-weight: 700; color: #1C2B1F; padding-left: 2px;">
                                            <?php echo esc_html($spec_row['val']); ?>
                                        </span>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <?php if (!empty($custom_highlights_list)) : ?>
                        <!-- Key Highlights Bullets (if configured in backend) -->
                        <div class="kash-custom-highlights-box" style="margin-bottom: 30px; background: #ffffff; border: 1px solid #EBF3EC; border-radius: 16px; padding: 22px 26px;">
                            <h3 style="font-family: 'Playfair Display', Georgia, serif; font-size: 1.25rem; color: #1C2B1F; margin-bottom: 14px;">
                                <i class="fa-solid fa-star" style="color: #c49a56;"></i> <?php esc_html_e('Key Highlights', 'kash-naturals'); ?>
                            </h3>
                            <ul style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 10px;">
                                <?php foreach ($custom_highlights_list as $kh) : ?>
                                    <li style="display: flex; align-items: flex-start; gap: 10px; font-size: 0.96rem; line-height: 1.55; color: #334155;">
                                        <i class="fa-solid fa-check" style="color: #c49a56; font-size: 1rem; margin-top: 3px; flex-shrink: 0;"></i>
                                        <span><?php echo esc_html($kh); ?></span>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <?php endif; ?>

                        <!-- Ingredients & Nutrition Grid -->
                        <div class="ingredients-nutrition-grid">
                            <div class="ing-card">
                                <h3><i class="fa-solid fa-seedling"></i> <?php esc_html_e('Complete Ingredients List', 'kash-naturals'); ?></h3>
                                <p class="ing-text"><?php echo esc_html($ingredients_display); ?></p>
                                <span class="allergen-note"><?php echo esc_html($allergen_display); ?></span>

                                <div class="storage-info-subbox" style="margin-top: 24px; padding-top: 18px; border-top: 1px dashed rgba(44, 95, 62, 0.15);">
                                    <h4 style="font-size: 1.05rem; color: #1C2B1F; margin-bottom: 8px; display: flex; align-items: center; gap: 8px;">
                                        <i class="fa-solid fa-clock-rotate-left" style="color: #2C5F3E;"></i> <?php esc_html_e('Shelf Life & Freshness', 'kash-naturals'); ?>
                                    </h4>
                                    <p style="font-size: 0.92rem; color: #555; line-height: 1.6; margin-bottom: 10px;">
                                        <?php echo esc_html($shelf_life_display); ?>
                                    </p>
                                    <p style="font-size: 0.9rem; color: #666; line-height: 1.5; margin: 0;">
                                        <i class="fa-solid fa-shield-halved" style="color: #c49a56;"></i> <?php echo esc_html($storage_display); ?>
                                    </p>
                                </div>
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
                </div>

                <!-- Tab 3: Dynamic Customer Reviews (100% Real Reviews, Zero Fake Reviews) -->
                <div id="tab-reviews" class="tab-pane-content">
                    <div class="tab-reviews-card">
                        <h2 style="font-family: 'Playfair Display', Georgia, serif; font-size: 1.6rem; color: #1C2B1F; margin-bottom: 24px;">
                            <?php esc_html_e('Customer Reviews', 'kash-naturals'); ?> (<?php echo esc_html($real_review_count); ?>)
                        </h2>

                        <!-- Overall Rating Summary & Progress Breakdown -->
                        <div class="reviews-summary-dashboard" style="display: grid; grid-template-columns: 200px 1fr; gap: 35px; align-items: center; background: #FAF7F2; padding: 26px 30px; border-radius: 18px; border: 1px solid rgba(44, 95, 62, 0.12); margin-bottom: 30px;">
                            <div class="rating-large-stat" style="text-align: center; border-right: 1px solid rgba(44, 95, 62, 0.15); padding-right: 25px;">
                                <span class="rating-big-num" style="font-size: 3.2rem; font-weight: 800; color: #1C2B1F; line-height: 1;"><?php echo esc_html($rating_num_str); ?></span>
                                <div class="stars-gold-big" style="color: #c49a56; font-size: 1.15rem; margin: 8px 0;">
                                    <?php
                                    $full_s = floor($display_avg_rating);
                                    $half_s = ($display_avg_rating - $full_s) >= 0.5 ? 1 : 0;
                                    $empty_s = 5 - $full_s - $half_s;
                                    for ($i = 0; $i < $full_s; $i++) echo '<i class="fa-solid fa-star"></i> ';
                                    if ($half_s) echo '<i class="fa-solid fa-star-half-stroke"></i> ';
                                    for ($i = 0; $i < $empty_s; $i++) echo '<i class="fa-regular fa-star"></i> ';
                                    ?>
                                </div>
                                <span class="based-on-txt" style="font-size: 0.84rem; color: #666;">
                                    <?php printf(esc_html(_n('Based on %d review', 'Based on %d reviews', $real_review_count, 'kash-naturals')), $real_review_count); ?>
                                </span>
                            </div>

                            <div class="rating-progress-breakdown">
                                <?php
                                for ($star = 5; $star >= 1; $star--) {
                                    $cnt = isset($rating_counts[$star]) ? $rating_counts[$star] : 0;
                                    $pct = ($real_review_count > 0) ? round(($cnt / $real_review_count) * 100) : ($star === 5 ? 100 : 0);
                                    ?>
                                    <div class="progress-bar-row" style="display: flex; align-items: center; gap: 12px; margin-bottom: 8px;">
                                        <span style="font-size: 0.85rem; font-weight: 600; color: #1C2B1F; width: 45px;"><?php echo $star; ?> <?php esc_html_e('Star', 'kash-naturals'); ?></span>
                                        <div style="flex-grow: 1; height: 8px; background: #E2EFE3; border-radius: 10px; overflow: hidden;">
                                            <div style="width: <?php echo esc_attr($pct); ?>%; height: 100%; background: #2C5F3E; border-radius: 10px;"></div>
                                        </div>
                                        <span style="font-size: 0.82rem; color: #666; width: 35px; text-align: right;"><?php echo esc_html($pct); ?>%</span>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>

                        <!-- Real Reviews List or Clean Empty State (Zero Fake Dummy Reviews) -->
                        <div class="real-reviews-list-container">
                            <?php if (!empty($approved_reviews)) : ?>
                                <?php foreach ($approved_reviews as $rev) :
                                    $c_author = $rev->comment_author;
                                    $c_date   = human_time_diff(strtotime($rev->comment_date), current_time('timestamp')) . ' ' . __('ago', 'kash-naturals');
                                    $c_body   = $rev->comment_content;
                                    $c_rating = intval(get_comment_meta($rev->comment_ID, 'rating', true)) ?: 5;
                                    $is_ver   = function_exists('wc_review_is_from_verified_owner') ? wc_review_is_from_verified_owner($rev->comment_ID) : true;
                                ?>
                                    <div class="review-card" style="background: #ffffff; border: 1px solid #EBF3EC; border-radius: 18px; padding: 22px 26px; margin-bottom: 18px; box-shadow: 0 4px 14px rgba(0,0,0,0.02);">
                                        <div class="review-header" style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 10px; flex-wrap: wrap; gap: 10px;">
                                            <div style="display: flex; align-items: center; gap: 10px;">
                                                <div style="width: 36px; height: 36px; border-radius: 50%; background: #2C5F3E; color: #fff; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.95rem;">
                                                    <?php echo esc_html(strtoupper(substr($c_author, 0, 1))); ?>
                                                </div>
                                                <div>
                                                    <strong style="color: #1C2B1F; font-size: 1rem;"><?php echo esc_html($c_author); ?></strong>
                                                    <?php if ($is_ver) : ?>
                                                        <span class="verified-badge" style="display: inline-block; background: rgba(44, 95, 62, 0.1); color: #2C5F3E; font-size: 0.75rem; font-weight: 700; padding: 2px 8px; border-radius: 12px; margin-left: 6px;">
                                                            <i class="fa-solid fa-circle-check"></i> <?php esc_html_e('Verified Purchase', 'kash-naturals'); ?>
                                                        </span>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                            <span class="review-date" style="font-size: 0.85rem; color: #888;"><?php echo esc_html($c_date); ?></span>
                                        </div>
                                        <div class="stars-gold" style="color: #c49a56; font-size: 0.95rem; margin-bottom: 10px;">
                                            <?php for ($i = 0; $i < $c_rating; $i++) echo '<i class="fa-solid fa-star"></i> '; ?>
                                        </div>
                                        <p class="review-body" style="font-size: 0.96rem; line-height: 1.65; color: #4A5568; margin: 0;"><?php echo esc_html($c_body); ?></p>
                                    </div>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <!-- Clean Empty State (Zero Dummy Reviews) -->
                                <div class="kash-empty-reviews-box" style="text-align: center; padding: 45px 24px; background: #FAF7F2; border-radius: 18px; border: 1px dashed rgba(44, 95, 62, 0.25); margin-bottom: 25px;">
                                    <div style="font-size: 2.8rem; color: #c49a56; margin-bottom: 12px;">
                                        <i class="fa-regular fa-comments"></i>
                                    </div>
                                    <h4 style="font-family: 'Playfair Display', Georgia, serif; font-size: 1.4rem; color: #1C2B1F; margin-bottom: 8px;">
                                        <?php esc_html_e('No Reviews Yet', 'kash-naturals'); ?>
                                    </h4>
                                    <p style="color: #666; font-size: 0.95rem; max-width: 480px; margin: 0 auto;">
                                        <?php esc_html_e('Be the first to review this royal artisanal creation! Share your tasting experience with the Kash Naturals community.', 'kash-naturals'); ?>
                                    </p>
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
    if (!kashVariationsData) return;

    // Resilient lookup by ID (handles int, string, or array values)
    let v = kashVariationsData[vid] || kashVariationsData[String(vid)] || kashVariationsData[parseInt(vid, 10)];
    if (!v && typeof kashVariationsData === 'object') {
        const all = Object.values(kashVariationsData);
        v = all.find(item => item && (item.id == vid || item.id == String(vid)));
    }
    if (!v) {
        console.warn('Variation not found for id:', vid, kashVariationsData);
        return;
    }
    activeVariationId = vid;

    // 1. Highlight pill
    document.querySelectorAll('.size-pill-btn').forEach(btn => {
        const btnVid = btn.getAttribute('data-variation-id');
        if (btnVid && (btnVid == vid || parseInt(btnVid, 10) === parseInt(vid, 10))) {
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
        const titleMainEl = document.getElementById('productTitleMain');
        if (titleMainEl) {
            addBtn.setAttribute('data-product-name', titleMainEl.textContent.replace(/\s+/g, ' ').trim());
        }
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

    // 7. Update Product Title Variant on Storefront Dynamically
    const titleVarEl = document.getElementById('productTitleVariant');
    if (titleVarEl && v.label) {
        let vClean = v.label.split('(')[0].trim();
        titleVarEl.textContent = ' | ' + vClean;
        titleVarEl.style.display = 'inline';
    }
}
window.kashSelectVariation = kashSelectVariation;

function selectPackSize(btn, sizeName, price) {
    document.querySelectorAll('.size-pill-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    
    // Update simple product price display
    const mainPriceEl = document.getElementById('productMainPrice');
    const currency = '<?php echo esc_js($currency_symbol); ?>';
    if (mainPriceEl && price) {
        mainPriceEl.textContent = currency + parseFloat(price).toFixed(2);
    }

    // Update Product Title Variant
    const titleVarEl = document.getElementById('productTitleVariant');
    if (titleVarEl && sizeName) {
        let sClean = sizeName.split('(')[0].trim();
        titleVarEl.textContent = ' | ' + sClean;
        titleVarEl.style.display = 'inline';
    }

    const addBtn = document.getElementById('singleProductAddToCartBtn');
    if (addBtn && price) {
        addBtn.setAttribute('data-product-price', price);
    }
}
window.selectPackSize = selectPackSize;

// Delegate click on pack size buttons for bulletproof interaction
document.addEventListener('DOMContentLoaded', function() {
    document.addEventListener('click', function(e) {
        const pill = e.target.closest('.size-pill-btn');
        if (!pill) return;
        const vid = pill.getAttribute('data-variation-id');
        if (vid) {
            kashSelectVariation(vid);
        }
    });
});

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

function openReviewsTab(e) {
    if (e && e.preventDefault) e.preventDefault();
    const reviewsBtn = document.querySelector('.tab-btn[onclick*="tab-reviews"]');
    if (reviewsBtn) {
        reviewsBtn.click();
        const tabSec = document.querySelector('.product-tabs-section');
        if (tabSec) {
            tabSec.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    }
}

function checkDeliveryPincode() {
    const input = document.getElementById('pincodeInput');
    const pincode = input ? input.value.trim() : '';
    const msg = document.getElementById('pincodeResultMessage');
    const checkBtn = document.querySelector('.btn-check-pincode');
    if (!msg) return;

    if (!pincode) {
        msg.innerHTML = '<span style="color: #c0392b; font-weight:600;"><i class="fa-solid fa-circle-exclamation"></i> Please enter a 6-digit postal pincode.</span>';
        return;
    }

    if (pincode.length !== 6 || !/^\d{6}$/.test(pincode)) {
        msg.innerHTML = '<span style="color: #c0392b; font-weight:600;"><i class="fa-solid fa-circle-exclamation"></i> Invalid format: Indian Postal Codes must be exactly 6 digits.</span>';
        return;
    }

    if (pincode.charAt(0) === '0') {
        msg.innerHTML = '<span style="color: #c0392b; font-weight:600;"><i class="fa-solid fa-circle-xmark"></i> Invalid Indian Pincode: Postal codes in India cannot begin with 0.</span>';
        return;
    }

    // Reject common dummy/test sequences and repeating digits (e.g. 123456, 111111, 999999)
    const dummyCodes = [
        '123456', '234567', '345678', '456789', '567890', '654321',
        '000000', '111111', '222222', '333333', '444444', '555555',
        '666666', '777777', '888888', '999999', '112233', '121212',
        '101010', '123123'
    ];
    if (dummyCodes.indexOf(pincode) !== -1) {
        msg.innerHTML = '<span style="color: #c0392b; font-weight:600;"><i class="fa-solid fa-circle-xmark"></i> Pincode <strong>' + pincode + '</strong> is not a valid Indian Postal Code. Please enter your real delivery pincode.</span>';
        return;
    }

    // Valid 2-digit Indian Postal Circle prefixes
    const circlePrefixMap = {
        '11': 'Delhi', '12': 'Haryana', '13': 'Haryana',
        '14': 'Punjab', '15': 'Punjab', '16': 'Punjab / Chandigarh',
        '17': 'Himachal Pradesh', '18': 'Jammu & Kashmir', '19': 'Jammu & Kashmir / Ladakh',
        '20': 'Uttar Pradesh', '21': 'Uttar Pradesh', '22': 'Uttar Pradesh', '23': 'Uttar Pradesh',
        '24': 'Uttar Pradesh / Uttarakhand', '25': 'Uttar Pradesh', '26': 'Uttar Pradesh / Uttarakhand',
        '27': 'Uttar Pradesh', '28': 'Uttar Pradesh',
        '30': 'Rajasthan', '31': 'Rajasthan', '32': 'Rajasthan', '33': 'Rajasthan', '34': 'Rajasthan',
        '36': 'Gujarat', '37': 'Gujarat', '38': 'Gujarat', '39': 'Gujarat',
        '40': 'Maharashtra / Goa', '41': 'Maharashtra', '42': 'Maharashtra', '43': 'Maharashtra', '44': 'Maharashtra',
        '45': 'Madhya Pradesh', '46': 'Madhya Pradesh', '47': 'Madhya Pradesh', '48': 'Madhya Pradesh',
        '49': 'Chhattisgarh',
        '50': 'Telangana / Andhra Pradesh', '51': 'Andhra Pradesh', '52': 'Andhra Pradesh', '53': 'Andhra Pradesh',
        '56': 'Karnataka', '57': 'Karnataka', '58': 'Karnataka', '59': 'Karnataka',
        '60': 'Tamil Nadu', '61': 'Tamil Nadu', '62': 'Tamil Nadu', '63': 'Tamil Nadu', '64': 'Tamil Nadu / Puducherry',
        '67': 'Kerala', '68': 'Kerala', '69': 'Kerala / Lakshadweep',
        '70': 'West Bengal', '71': 'West Bengal', '72': 'West Bengal', '73': 'West Bengal', '74': 'West Bengal / Andaman & Nicobar',
        '75': 'Odisha', '76': 'Odisha', '77': 'Odisha',
        '78': 'Assam', '79': 'North Eastern States',
        '80': 'Bihar', '81': 'Bihar', '82': 'Bihar', '83': 'Jharkhand', '84': 'Bihar', '85': 'Bihar / Jharkhand'
    };

    const pfx = pincode.substring(0, 2);
    if (!circlePrefixMap[pfx]) {
        msg.innerHTML = '<span style="color: #c0392b; font-weight:600;"><i class="fa-solid fa-circle-xmark"></i> Pincode <strong>' + pincode + '</strong> does not match any valid Indian Postal Circle. Please check and try again.</span>';
        return;
    }

    // Show verification loading spinner
    msg.innerHTML = '<span style="color: #666; font-weight:600;"><i class="fa-solid fa-spinner fa-spin"></i> Checking postal serviceability for ' + pincode + '...</span>';
    if (checkBtn) checkBtn.disabled = true;

    function renderSuccess(loc) {
        if (checkBtn) checkBtn.disabled = false;
        msg.innerHTML = '<span style="color: #2C5F3E; font-weight:600; line-height: 1.5; display: inline-block;"><i class="fa-solid fa-circle-check" style="color: #2C5F3E;"></i> Express Delivery Available to <strong>' + loc + ' (' + pincode + ')</strong>! Estimated arrival in 2–4 business days. Free Doorstep Delivery. Cash on Delivery Available.</span>';
    }

    function renderError(errText) {
        if (checkBtn) checkBtn.disabled = false;
        msg.innerHTML = '<span style="color: #c0392b; font-weight:600; line-height: 1.5; display: inline-block;"><i class="fa-solid fa-circle-xmark"></i> ' + errText + '</span>';
    }

    // Direct India Post Directory Verification
    const controller = (typeof AbortController !== 'undefined') ? new AbortController() : null;
    const timeoutId = controller ? setTimeout(function() { controller.abort(); }, 3500) : null;

    fetch('https://api.postalpincode.in/pincode/' + pincode, controller ? { signal: controller.signal } : {})
        .then(function(res) {
            if (timeoutId) clearTimeout(timeoutId);
            return res.json();
        })
        .then(function(data) {
            if (Array.isArray(data) && data[0]) {
                if (data[0].Status === 'Success' && data[0].PostOffice && data[0].PostOffice.length > 0) {
                    const po = data[0].PostOffice[0];
                    const dist = po.District || po.Name || '';
                    const st = po.State || circlePrefixMap[pfx];
                    const loc = dist ? (dist + ', ' + st) : st;
                    renderSuccess(loc);
                } else {
                    renderError('Pincode <strong>' + pincode + '</strong> is not a valid Indian Postal Code. Please check and enter a valid delivery pincode.');
                }
            } else {
                callBackendPincodeCheck();
            }
        })
        .catch(function() {
            if (timeoutId) clearTimeout(timeoutId);
            callBackendPincodeCheck();
        });

    function callBackendPincodeCheck() {
        const ajaxUrl = (typeof kash_dynamic_data !== 'undefined' && kash_dynamic_data.ajax_url)
            ? kash_dynamic_data.ajax_url
            : ((typeof kash_wc_params !== 'undefined') ? kash_wc_params.ajax_url : '<?php echo esc_js(admin_url('admin-ajax.php')); ?>');

        jQuery.ajax({
            type: 'POST',
            url: ajaxUrl,
            data: {
                action: 'kash_check_pincode',
                pincode: pincode
            },
            dataType: 'json',
            success: function(resp) {
                if (checkBtn) checkBtn.disabled = false;
                if (resp && resp.success && resp.data) {
                    renderSuccess(resp.data.location || circlePrefixMap[pfx]);
                } else {
                    const errMsg = (resp && resp.data && resp.data.message) ? resp.data.message : ('Pincode <strong>' + pincode + '</strong> is not a valid Indian Postal Code.');
                    renderError(errMsg);
                }
            },
            error: function() {
                if (checkBtn) checkBtn.disabled = false;
                if (circlePrefixMap[pfx]) {
                    renderSuccess(circlePrefixMap[pfx]);
                } else {
                    renderError('Pincode <strong>' + pincode + '</strong> is not a valid Indian Postal Code.');
                }
            }
        });
    }
}

function handleSingleAddToCart(id) {
    const isVariable = <?php echo $is_variable ? 'true' : 'false'; ?>;
    const qtyInput = document.getElementById('productQtyInput');
    const qty = qtyInput ? (parseInt(qtyInput.value) || 1) : 1;
    const varId = activeVariationId || (document.getElementById('singleProductAddToCartBtn') ? parseInt(document.getElementById('singleProductAddToCartBtn').getAttribute('data-variation-id')) : 0);

    // If product has variations (e.g. 200 GM and 500 GM), ask via popup if customer wants to choose 500 GM or another variant
    if (isVariable && typeof openVariantModal === 'function') {
        let prodMatch = null;
        if (typeof PRODUCTS_DB !== 'undefined' && Array.isArray(PRODUCTS_DB) && PRODUCTS_DB.length) {
            prodMatch = PRODUCTS_DB.find(p => p.id == id);
        }
        if (!prodMatch && typeof kashVariationsData !== 'undefined') {
            prodMatch = {
                id: id,
                name: <?php echo wp_json_encode($product_name); ?>,
                image: <?php echo wp_json_encode($main_img); ?>,
                is_variable: true,
                variations: Object.values(kashVariationsData)
            };
        }
        if (prodMatch && prodMatch.variations && prodMatch.variations.length > 1) {
            openVariantModal(prodMatch, varId, qty);
            return;
        }
    }

    const addBtn = document.getElementById('singleProductAddToCartBtn');
    if (addBtn && addBtn.disabled) return;

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
            if (typeof showToast === 'function') {
                showToast('Unable to add product to cart at this moment.', 'info');
            }
        }
    });
}

function handleBuyNow(id) {
    const isVariable = <?php echo $is_variable ? 'true' : 'false'; ?>;
    if (isVariable && (!activeVariationId || activeVariationId <= 0)) {
        if (typeof showToast === 'function') {
            showToast('Please choose a pack size (e.g. 200 GM or 500 GM) before proceeding.', 'info');
        } else {
            alert('Please choose a pack size before proceeding.');
        }
        const selectorWrap = document.querySelector('.product-option-selector');
        if (selectorWrap) {
            selectorWrap.classList.add('selector-pulse-alert');
            selectorWrap.scrollIntoView({ behavior: 'smooth', block: 'center' });
            setTimeout(() => selectorWrap.classList.remove('selector-pulse-alert'), 1600);
        }
        return;
    }

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
