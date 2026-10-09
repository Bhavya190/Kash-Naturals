<?php
/**
 * Single Product Detail Page Template
 *
 * @package KashNaturals
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();

$theme_uri = get_template_directory_uri();
$product_id = isset($_GET['id']) ? intval($_GET['id']) : (isset($GLOBALS['kash_product_id']) ? intval($GLOBALS['kash_product_id']) : 1);

// Master Product Catalog with detailed specs, ingredients, & gallery images
$products_catalog = array(
    1 => array(
        'id'            => 1,
        'name'          => 'Royal Calcutta Paan Mukhwas',
        'category'      => 'mouth-fresheners',
        'category_name' => 'Mouth Fresheners',
        'price'         => 299,
        'regular_price' => 399,
        'rating'        => '5.0',
        'reviews_count' => 148,
        'badge'         => 'Bestseller',
        'weight'        => '250g Glass Jar',
        'sku'           => 'KASH-MF-001',
        'stock'         => 'In Stock (Ready to Ship)',
        'main_image'    => $theme_uri . '/assets/images/product-calcutta-pan.jpg',
        'gallery'       => array(
            $theme_uri . '/assets/images/product-calcutta-pan.jpg',
            $theme_uri . '/assets/images/jar-calcutta-pan.jpg',
            $theme_uri . '/assets/images/product-royal-mukhwas.jpg',
            $theme_uri . '/assets/images/mouth-fresheners.jpg'
        ),
        'short_desc'    => 'Handcrafted traditional betel leaf mukhwas prepared with pure silver-coated cardamom, crisp fennel seeds, menthol pearls, and sweet aromatic gulkand infusion.',
        'full_desc'     => 'Experience the majestic taste of authentic Calcutta Sweet Paan without any tobacco or harmful additives. Our Royal Calcutta Paan Mukhwas is crafted using handpicked betel leaves, slowly dried and blended with silver-wrapped cardamom, organic fennel seeds, crushed dates, and genuine rose gulkand. Packed in airtight food-grade glass jars to preserve long-lasting aroma, every spoonful delivers a burst of cooling refreshment and natural digestive comfort after meals.',
        'ingredients'   => 'Dried Betel Leaf Strips (Paan), Fennel Seeds (Saunf), Silver Foil Coated Cardamom (Elaichi), Rose Petal Preserves (Gulkand), Menthol Crystals, Candied Dates (Khajoor), Coriander Seeds (Dhana Dal), Permitted Edible Silver Leaf (Vark).',
        'nutrition'     => array(
            'Energy'        => '385 kcal',
            'Protein'       => '4.2 g',
            'Carbohydrates' => '78.5 g',
            'Total Sugar'   => '32.0 g',
            'Dietary Fiber' => '12.4 g',
            'Total Fat'     => '2.1 g'
        ),
        'shelf_life'    => '9 Months from Manufacturing Date',
        'storage'       => 'Store in a cool, dry place away from direct sunlight and humidity. Keep jar tightly closed after each use.'
    ),

    2 => array(
        'id'            => 2,
        'name'          => 'Shahi Royal Mukhwas Blend',
        'category'      => 'mouth-fresheners',
        'category_name' => 'Mouth Fresheners',
        'price'         => 349,
        'regular_price' => 449,
        'rating'        => '4.9',
        'reviews_count' => 112,
        'badge'         => 'Heritage Blend',
        'weight'        => '250g Glass Jar',
        'sku'           => 'KASH-MF-002',
        'stock'         => 'In Stock',
        'main_image'    => $theme_uri . '/assets/images/product-royal-mukhwas.jpg',
        'gallery'       => array(
            $theme_uri . '/assets/images/product-royal-mukhwas.jpg',
            $theme_uri . '/assets/images/jar-royal-mukhwas.jpg',
            $theme_uri . '/assets/images/product-calcutta-pan.jpg',
            $theme_uri . '/assets/images/mouth-fresheners.jpg'
        ),
        'short_desc'    => 'Royal heritage digestive mix of slow-roasted sesame seeds, flax seeds, dry fruits, melon seeds, and fragrant spices.',
        'full_desc'     => 'Formulated according to ancient royal recipes, the Shahi Royal Mukhwas Blend combines 12 super-seeds and nuts. Lightly toasted to perfection without any oil, this blend is enriched with sesame, flaxseeds, watermelon seeds, roasted almonds, and digestive cardamom. It aids post-meal digestion while satisfying your palate with a rich, nutty crunch.',
        'ingredients'   => 'Roasted White & Black Sesame Seeds, Roasted Flax Seeds, Watermelon Seeds, Roasted Almond Slivers, Coriander Seeds, Cardamom Powder, Rock Salt, Natural Spices.',
        'nutrition'     => array(
            'Energy'        => '420 kcal',
            'Protein'       => '14.5 g',
            'Carbohydrates' => '45.0 g',
            'Total Sugar'   => '8.2 g',
            'Dietary Fiber' => '18.0 g',
            'Total Fat'     => '19.5 g'
        ),
        'shelf_life'    => '9 Months from Manufacturing Date',
        'storage'       => 'Store in an airtight container in a dry place.'
    ),

    3 => array(
        'id'            => 3,
        'name'          => 'Kash Sweet Saunf Digestif',
        'category'      => 'mouth-fresheners',
        'category_name' => 'Mouth Fresheners',
        'price'         => 249,
        'regular_price' => 329,
        'rating'        => '4.8',
        'reviews_count' => 96,
        'badge'         => '100% Natural',
        'weight'        => '250g Glass Jar',
        'sku'           => 'KASH-MF-003',
        'stock'         => 'In Stock',
        'main_image'    => $theme_uri . '/assets/images/product-sweet-saunf.jpg',
        'gallery'       => array(
            $theme_uri . '/assets/images/product-sweet-saunf.jpg',
            $theme_uri . '/assets/images/jar-sweet-saunf.jpg',
            $theme_uri . '/assets/images/product-royal-mukhwas.jpg'
        ),
        'short_desc'    => 'Crisp candied aniseeds blended with menthol crystals, silver sugar pearls, and aromatic herbs.',
        'full_desc'     => 'A beloved timeless Indian classic refreshed by Kash Naturals. Our Sweet Saunf Digestif pairs plump green aniseeds coated in subtle cane sugar syrup with cooling menthol and silver confetti. Ideal for soothing the stomach and leaving your mouth feeling fresh and fragrant.',
        'ingredients'   => 'Organic Green Fennel Seeds (Saunf), Cane Sugar Coating, Menthol, Natural Food Coloring, Silver Pearls, Mint Oil.',
        'nutrition'     => array(
            'Energy'        => '360 kcal',
            'Protein'       => '3.5 g',
            'Carbohydrates' => '82.0 g',
            'Total Sugar'   => '48.0 g',
            'Dietary Fiber' => '10.2 g',
            'Total Fat'     => '1.2 g'
        ),
        'shelf_life'    => '12 Months',
        'storage'       => 'Store away from warmth and moisture.'
    ),

    5 => array(
        'id'            => 5,
        'name'          => 'Belgian Dark Almond Dragees',
        'category'      => 'chocolate-dragees',
        'category_name' => 'Chocolate Dragees',
        'price'         => 499,
        'regular_price' => 649,
        'rating'        => '5.0',
        'reviews_count' => 175,
        'badge'         => 'Artisanal Bestseller',
        'weight'        => '200g Premium Box',
        'sku'           => 'KASH-DR-001',
        'stock'         => 'In Stock',
        'main_image'    => $theme_uri . '/assets/images/chocolate-dragees.jpg',
        'gallery'       => array(
            $theme_uri . '/assets/images/chocolate-dragees.jpg',
            $theme_uri . '/assets/images/jar-royal-mukhwas.jpg',
            $theme_uri . '/assets/images/combo-premium.jpg'
        ),
        'short_desc'    => 'Slow-roasted whole California almonds enrobed in 70% single-origin dark Belgian cocoa and dusted with fine cocoa powder.',
        'full_desc'     => 'Indulge in pure chocolate perfection. Whole California almonds are dry-roasted in small batches until crunchy, then repeatedly tumbled in revolving copper pans filled with silky 70% Belgian dark chocolate. Finished with a subtle dusting of French cocoa powder for a sophisticated, bittersweet cocoa finish.',
        'ingredients'   => 'California Almonds (40%), Dark Chocolate (Cocoa Mass, Sugar, Cocoa Butter, Soy Lecithin, Natural Vanilla), Cocoa Powder.',
        'nutrition'     => array(
            'Energy'        => '540 kcal',
            'Protein'       => '11.8 g',
            'Carbohydrates' => '42.5 g',
            'Total Sugar'   => '26.0 g',
            'Dietary Fiber' => '8.5 g',
            'Total Fat'     => '36.2 g'
        ),
        'shelf_life'    => '6 Months',
        'storage'       => 'Store in a cool place (15°C - 20°C). Refrigerate during hot weather.'
    ),

    9 => array(
        'id'            => 9,
        'name'          => 'Pistachio Kunafa Bar (100g)',
        'category'      => 'kunafa-bars',
        'category_name' => 'Kunafa Bars',
        'price'         => 599,
        'regular_price' => 749,
        'rating'        => '5.0',
        'reviews_count' => 210,
        'badge'         => 'Signature Luxury',
        'weight'        => '100g Handcrafted Bar',
        'sku'           => 'KASH-KB-001',
        'stock'         => 'In Stock',
        'main_image'    => $theme_uri . '/assets/images/kunafa-bars.jpg',
        'gallery'       => array(
            $theme_uri . '/assets/images/kunafa-bars.jpg',
            $theme_uri . '/assets/images/gift-combos.jpg',
            $theme_uri . '/assets/images/combo-celebration.jpg'
        ),
        'short_desc'    => 'Crispy golden kataifi pastry strands & rich roasted pistachio cream encapsulated inside smooth milk chocolate.',
        'full_desc'     => 'Our viral signature creation inspired by Dubai Middle Eastern confectionery traditions. Crispy shredded kataifi dough is butter-roasted to golden crispness and folded into luscious pistachio butter paste made from 100% Iranian pistachios. Sealed inside thick premium milk chocolate for an unbelievable crunch in every bite.',
        'ingredients'   => 'Pistachio Cream (Pistachios, Sugar, Vegetable Oil, Milk Powder), Crisp Kataifi Pastry (Wheat Flour, Water, Ghee), Milk Chocolate (Cocoa Butter, Whole Milk Powder, Sugar, Cocoa Mass, Soy Lecithin).',
        'nutrition'     => array(
            'Energy'        => '565 kcal',
            'Protein'       => '9.4 g',
            'Carbohydrates' => '51.0 g',
            'Total Sugar'   => '34.5 g',
            'Dietary Fiber' => '4.2 g',
            'Total Fat'     => '36.0 g'
        ),
        'shelf_life'    => '4 Months',
        'storage'       => 'Keep in a cool dry place (16°C-22°C). Do not expose to heat.'
    ),

    13 => array(
        'id'            => 13,
        'name'          => 'Freshness & Digestive Duo Pack',
        'category'      => 'gift-combos',
        'category_name' => 'Gift Combos',
        'price'         => 499,
        'regular_price' => 599,
        'rating'        => '4.9',
        'reviews_count' => 84,
        'badge'         => 'Gift Box',
        'weight'        => '500g Total (2x250g Jars)',
        'sku'           => 'KASH-GC-001',
        'stock'         => 'In Stock',
        'main_image'    => $theme_uri . '/assets/images/combo-freshness.jpg',
        'gallery'       => array(
            $theme_uri . '/assets/images/combo-freshness.jpg',
            $theme_uri . '/assets/images/product-calcutta-pan.jpg',
            $theme_uri . '/assets/images/product-sweet-saunf.jpg'
        ),
        'short_desc'    => 'Royal Calcutta Paan Mukhwas (250g) + Kash Sweet Saunf Digestif (250g) packaged in an elegant gift box.',
        'full_desc'     => 'The ultimate post-meal pairing presented in a luxury forest green gift box with gold foil stamping. Contains one 250g glass jar of Royal Calcutta Paan Mukhwas and one 250g glass jar of Kash Sweet Saunf. Perfect for housewarmings, weddings, corporate gifting, and family celebrations.',
        'ingredients'   => 'See individual product listings for Royal Calcutta Paan Mukhwas & Sweet Saunf Digestif.',
        'nutrition'     => array(
            'Energy'        => '375 kcal',
            'Protein'       => '3.8 g',
            'Carbohydrates' => '80.0 g',
            'Total Sugar'   => '40.0 g',
            'Dietary Fiber' => '11.0 g',
            'Total Fat'     => '1.6 g'
        ),
        'shelf_life'    => '9 Months',
        'storage'       => 'Store in cool dry conditions.'
    )
);

// Fallback for default product if ID not matched
$product = isset($products_catalog[$product_id]) ? $products_catalog[$product_id] : $products_catalog[1];
$product_price_formatted = '₹' . number_format($product['price']);
$product_regular_formatted = '₹' . number_format($product['regular_price']);
$discount_percent = round((($product['regular_price'] - $product['price']) / $product['regular_price']) * 100);

// Get related products (excluding current)
$related_products = array();
foreach ($products_catalog as $p_id => $p_item) {
    if ($p_id !== $product['id']) {
        $related_products[] = $p_item;
    }
}
?>

<!-- Single Product Hero Section -->
<section class="single-product-details-section">
    <div class="container">

        <!-- Breadcrumb Bar -->
        <nav class="product-breadcrumb-nav" aria-label="Breadcrumb">
            <a href="<?php echo esc_url(home_url('/')); ?>">Home</a>
            <i class="fa-solid fa-chevron-right breadcrumb-separator"></i>
            <a href="<?php echo esc_url(home_url('/shop')); ?>">Shop</a>
            <i class="fa-solid fa-chevron-right breadcrumb-separator"></i>
            <a href="<?php echo esc_url(home_url('/shop?category=' . $product['category'])); ?>"><?php echo esc_html($product['category_name']); ?></a>
            <i class="fa-solid fa-chevron-right breadcrumb-separator"></i>
            <span class="breadcrumb-current"><?php echo esc_html($product['name']); ?></span>
        </nav>

        <!-- Product Main Showcase Grid -->
        <div class="product-showcase-grid">

            <!-- Left: Image Gallery Showcase -->
            <div class="product-gallery-wrapper">
                <div class="main-image-display-card">
                    <span class="product-badge-pill-luxury"><?php echo esc_html($product['badge']); ?></span>
                    <span class="product-discount-tag"><?php echo esc_html($discount_percent); ?>% OFF</span>
                    <div class="main-img-container">
                        <img id="primaryProductImg" src="<?php echo esc_url($product['main_image']); ?>" alt="<?php echo esc_attr($product['name']); ?>">
                    </div>
                </div>

                <!-- Gallery Thumbnails Strip -->
                <div class="gallery-thumbs-strip">
                    <?php foreach ($product['gallery'] as $index => $thumb_src) : ?>
                        <button type="button" class="thumb-btn <?php echo ($index === 0) ? 'active' : ''; ?>" onclick="changeProductImage(this, '<?php echo esc_js($thumb_src); ?>')">
                            <img src="<?php echo esc_url($thumb_src); ?>" alt="Thumbnail <?php echo $index + 1; ?>">
                        </button>
                    <?php endforeach; ?>
                </div>

                <!-- Product Trust Badges Bar -->
                <div class="product-trust-features-bar">
                    <div class="trust-pill-item">
                        <i class="fa-solid fa-seedling trust-icon"></i>
                        <span>100% Natural</span>
                    </div>
                    <div class="trust-pill-item">
                        <i class="fa-solid fa-shield-heart trust-icon"></i>
                        <span>Zero Preservatives</span>
                    </div>
                    <div class="trust-pill-item">
                        <i class="fa-solid fa-snowflake trust-icon"></i>
                        <span>Cold Pack Delivery</span>
                    </div>
                    <div class="trust-pill-item">
                        <i class="fa-solid fa-jar trust-icon"></i>
                        <span>Airtight Glass Jar</span>
                    </div>
                </div>
            </div>

            <!-- Right: Product Purchase Info & Controls -->
            <div class="product-summary-info">
                <div class="product-meta-header">
                    <span class="product-cat-tag-pill"><?php echo esc_html($product['category_name']); ?></span>
                    <span class="product-sku-code">SKU: <?php echo esc_html($product['sku']); ?></span>
                </div>

                <h1 class="product-title-main"><?php echo esc_html($product['name']); ?></h1>

                <!-- Rating & Stock Status -->
                <div class="product-rating-stock-row">
                    <div class="star-rating-box">
                        <div class="stars-gold">★★★★★</div>
                        <span class="rating-num"><strong><?php echo esc_html($product['rating']); ?></strong> (<?php echo esc_html($product['reviews_count']); ?> Customer Reviews)</span>
                    </div>
                    <div class="stock-status-badge in-stock">
                        <i class="fa-solid fa-circle-check"></i> <?php echo esc_html($product['stock']); ?>
                    </div>
                </div>

                <!-- Price Box -->
                <div class="product-price-display-box">
                    <span class="current-price-val"><?php echo esc_html($product_price_formatted); ?></span>
                    <span class="regular-price-val"><?php echo esc_html($product_regular_formatted); ?></span>
                    <span class="price-tax-note">(Inclusive of all taxes & doorstep delivery)</span>
                </div>

                <!-- Short Editorial Description -->
                <p class="product-editorial-desc">
                    <?php echo esc_html($product['short_desc']); ?>
                </p>

                <!-- Weight / Size Selection Pills -->
                <div class="product-option-selector">
                    <label class="selector-label">SELECT PACK SIZE:</label>
                    <div class="size-pills-wrap">
                        <button type="button" class="size-pill-btn active">
                            <span><?php echo esc_html($product['weight']); ?></span>
                            <span class="pill-best-val">Best Seller</span>
                        </button>
                        <button type="button" class="size-pill-btn">
                            <span>500g Value Pack</span>
                            <span class="pill-save-val">Save 15%</span>
                        </button>
                    </div>
                </div>

                <!-- Quantity & Add to Cart Controls -->
                <div class="purchase-action-controls">
                    <div class="quantity-counter-box">
                        <button type="button" class="qty-btn minus" onclick="updateQty(-1)">-</button>
                        <input type="number" id="productQtyInput" value="1" min="1" max="20" readonly>
                        <button type="button" class="qty-btn plus" onclick="updateQty(1)">+</button>
                    </div>

                    <button type="button" class="btn-add-to-cart-gold" onclick="addToCartSingle(<?php echo $product['id']; ?>)">
                        <i class="fa-solid fa-cart-shopping"></i> ADD TO CART
                    </button>

                    <button type="button" class="btn-buy-now-green">
                        <i class="fa-solid fa-bolt"></i> BUY IT NOW
                    </button>
                </div>

                <!-- Pincode Delivery Checker Box -->
                <div class="pincode-checker-card">
                    <div class="pincode-header">
                        <i class="fa-solid fa-truck-fast"></i>
                        <span>Check Express Delivery & Cash on Delivery</span>
                    </div>
                    <div class="pincode-input-row">
                        <input type="text" id="pincodeInput" placeholder="Enter 6-digit Pincode" maxlength="6">
                        <button type="button" class="btn-check-pincode" onclick="checkDeliveryPincode()">Check</button>
                    </div>
                    <div id="pincodeResultMessage" class="pincode-result-msg"></div>
                </div>

                <!-- Quick Highlights Box -->
                <div class="product-highlights-box">
                    <div class="highlight-item">
                        <i class="fa-solid fa-leaf"></i>
                        <div>
                            <strong>100% Vegetarian & Natural</strong>
                            <p>No artificial flavors, preservatives, or chemical additives.</p>
                        </div>
                    </div>
                    <div class="highlight-item">
                        <i class="fa-solid fa-rotate-left"></i>
                        <div>
                            <strong>Easy 7-Day Replacement Guarantee</strong>
                            <p>Damaged or missing item? We issue an instant replacement.</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Product Detailed Tabs Section -->
        <div class="product-tabs-section">
            <div class="tabs-header-nav">
                <button type="button" class="tab-btn active" onclick="switchProductTab(this, 'tab-description')">Full Description & Story</button>
                <button type="button" class="tab-btn" onclick="switchProductTab(this, 'tab-ingredients')">Ingredients & Nutrition</button>
                <button type="button" class="tab-btn" onclick="switchProductTab(this, 'tab-storage')">Storage & Shelf Life</button>
                <button type="button" class="tab-btn" onclick="switchProductTab(this, 'tab-reviews')">Verified Customer Reviews (<?php echo esc_html($product['reviews_count']); ?>)</button>
            </div>

            <div class="tabs-content-viewport">

                <!-- Tab 1: Description -->
                <div id="tab-description" class="tab-pane-content active">
                    <div class="tab-story-card">
                        <h2>Craftsmanship & Heritage</h2>
                        <p><?php echo esc_html($product['full_desc']); ?></p>
                        <div class="story-grid-icons">
                            <div class="story-icon-box">
                                <i class="fa-solid fa-mortar-pestle"></i>
                                <h4>Small-Batch Artisan Made</h4>
                                <p>Prepared in traditional small batches to retain authentic essential oils and crisp texture.</p>
                            </div>
                            <div class="story-icon-box">
                                <i class="fa-solid fa-glass-water"></i>
                                <h4>Food-Grade Glass Packaging</h4>
                                <p>Sealed in thick glass containers preventing moisture absorption and flavor loss.</p>
                            </div>
                            <div class="story-icon-box">
                                <i class="fa-solid fa-heart-pulse"></i>
                                <h4>Digestive Wellness</h4>
                                <p>Natural herbal spices that naturally soothe digestive system post-heavy meals.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tab 2: Ingredients & Nutrition -->
                <div id="tab-ingredients" class="tab-pane-content">
                    <div class="ingredients-nutrition-grid">
                        <div class="ing-card">
                            <h3><i class="fa-solid fa-seedling"></i> Complete Ingredients List</h3>
                            <p class="ing-text"><?php echo esc_html($product['ingredients']); ?></p>
                            <span class="allergen-note">Allergen Advice: Processed in a facility that also handles tree nuts, sesame, and dairy.</span>
                        </div>

                        <div class="nutri-table-card">
                            <h3><i class="fa-solid fa-table-list"></i> Nutritional Facts (Per 100g)</h3>
                            <table class="nutri-table">
                                <tbody>
                                    <?php foreach ($product['nutrition'] as $key => $val) : ?>
                                        <tr>
                                            <th><?php echo esc_html($key); ?></th>
                                            <td><?php echo esc_html($val); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
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
                                <h4>Shelf Life</h4>
                                <p><?php echo esc_html($product['shelf_life']); ?></p>
                            </div>
                        </div>
                        <div class="storage-row">
                            <i class="fa-solid fa-temperature-arrow-down"></i>
                            <div>
                                <h4>Storage Instructions</h4>
                                <p><?php echo esc_html($product['storage']); ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tab 4: Customer Reviews -->
                <div id="tab-reviews" class="tab-pane-content">
                    <div class="reviews-summary-row">
                        <div class="review-score-box">
                            <div class="big-rating-num"><?php echo esc_html($product['rating']); ?></div>
                            <div class="stars-gold">★★★★★</div>
                            <p>Based on <?php echo esc_html($product['reviews_count']); ?> verified customer reviews</p>
                        </div>
                        <div class="review-bars-box">
                            <div class="bar-row"><span>5 Stars</span><div class="bar-fill"><div class="fill-inner" style="width: 92%;"></div></div><span>92%</span></div>
                            <div class="bar-row"><span>4 Stars</span><div class="bar-fill"><div class="fill-inner" style="width: 6%;"></div></div><span>6%</span></div>
                            <div class="bar-row"><span>3 Stars</span><div class="bar-fill"><div class="fill-inner" style="width: 2%;"></div></div><span>2%</span></div>
                        </div>
                    </div>

                    <div class="reviews-cards-list">
                        <div class="review-card">
                            <div class="review-header">
                                <strong>Priya Sharma</strong>
                                <span class="verified-badge"><i class="fa-solid fa-circle-check"></i> Verified Purchase</span>
                                <span class="review-date">2 days ago</span>
                            </div>
                            <div class="stars-gold">★★★★★</div>
                            <h4 class="review-headline">Unbelievable natural aroma & taste!</h4>
                            <p class="review-body">Ordered the Royal Calcutta Paan Mukhwas and it taste just like fresh pan from Kolkata! Packaging in glass jar is top notch. Delivery was fast too.</p>
                        </div>

                        <div class="review-card">
                            <div class="review-header">
                                <strong>Rohan Mehta</strong>
                                <span class="verified-badge"><i class="fa-solid fa-circle-check"></i> Verified Purchase</span>
                                <span class="review-date">1 week ago</span>
                            </div>
                            <div class="stars-gold">★★★★★</div>
                            <h4 class="review-headline">Pure luxury in every jar</h4>
                            <p class="review-body">Loved the silver coated elaichi and saunf mix. Perfect digestive after dinner. My family thoroughly enjoyed it.</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Related Products Section -->
        <div class="related-products-section">
            <div class="related-header">
                <h2>YOU MAY ALSO LIKE</h2>
                <p>Explore complementary mouth fresheners & artisan chocolates</p>
            </div>
            <div class="related-grid-4">
                <?php foreach (array_slice($related_products, 0, 4) as $rel) : ?>
                    <div class="shop-product-card-exact">
                        <span class="product-badge-tag"><?php echo esc_html($rel['badge']); ?></span>
                        <a href="<?php echo esc_url(home_url('/product?id=' . $rel['id'])); ?>" class="product-img-box-exact">
                            <img src="<?php echo esc_url($rel['main_image']); ?>" alt="<?php echo esc_attr($rel['name']); ?>">
                        </a>
                        <div class="product-card-info">
                            <div class="product-cat-label"><?php echo esc_html($rel['category_name']); ?></div>
                            <h3 class="product-title-exact">
                                <a href="<?php echo esc_url(home_url('/product?id=' . $rel['id'])); ?>" style="color: inherit; text-decoration: none;">
                                    <?php echo esc_html($rel['name']); ?>
                                </a>
                            </h3>
                            <div class="product-rating-stars">★★★★★ <span>(<?php echo esc_html($rel['rating']); ?>)</span></div>
                            <div class="product-price-row-exact">
                                <div class="price-wrap">
                                    <span class="current-price">₹<?php echo esc_html($rel['price']); ?></span>
                                    <span class="old-price">₹<?php echo esc_html($rel['regular_price']); ?></span>
                                </div>
                                <a href="<?php echo esc_url(home_url('/product?id=' . $rel['id'])); ?>" class="fav-btn-view" style="font-size: 0.82rem; padding: 8px 14px;">
                                    VIEW DETAILS
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

    </div>
</section>

<!-- Page specific inline JavaScript for Image Gallery & Tabs -->
<script>
function changeProductImage(thumbBtn, newSrc) {
    document.querySelectorAll('.thumb-btn').forEach(b => b.classList.remove('active'));
    thumbBtn.classList.add('active');
    const mainImg = document.getElementById('primaryProductImg');
    if (mainImg) {
        mainImg.style.opacity = '0.4';
        setTimeout(() => {
            mainImg.src = newSrc;
            mainImg.style.opacity = '1';
        }, 150);
    }
}

function updateQty(delta) {
    const input = document.getElementById('productQtyInput');
    if (input) {
        let val = parseInt(input.value) || 1;
        val += delta;
        if (val < 1) val = 1;
        if (val > 20) val = 20;
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
    const pincode = document.getElementById('pincodeInput').value.trim();
    const msg = document.getElementById('pincodeResultMessage');
    if (pincode.length === 6 && /^\d+$/.test(pincode)) {
        msg.innerHTML = '<span style="color: #2e7d32;"><i class="fa-solid fa-circle-check"></i> Delivery Available to ' + pincode + '! Express delivery in 2-4 business days. COD available.</span>';
    } else {
        msg.innerHTML = '<span style="color: #d32f2f;"><i class="fa-solid fa-circle-exclamation"></i> Please enter a valid 6-digit Indian Pincode.</span>';
    }
}

function addToCartSingle(id) {
    const qty = parseInt(document.getElementById('productQtyInput').value) || 1;
    let cart = JSON.parse(localStorage.getItem('kash_cart') || '[]');
    cart.push({ id: id, qty: qty });
    localStorage.setItem('kash_cart', JSON.stringify(cart));
    
    // Trigger header counter update if available
    const badge = document.querySelector('.cart-count-badge-orange');
    if (badge) badge.textContent = cart.length;
    
    alert('Product added to cart successfully!');
}
</script>

<?php
get_footer();
