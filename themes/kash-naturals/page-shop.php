<?php
/**
 * Template Name: Shop Page
 *
 * @package KashNaturals
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();

$theme_uri = get_template_directory_uri();
$raw_category = isset($_GET['category']) ? $_GET['category'] : 'all';
$current_category = function_exists('sanitize_text_field') ? sanitize_text_field($raw_category) : trim(strip_tags((string)$raw_category));

// Map category slug to display title
$category_titles = array(
    'all'                => __('All Products', 'kash-naturals'),
    'mouth-fresheners'   => __('Mouth Fresheners Collection', 'kash-naturals'),
    'chocolate-dragees'  => __('Chocolate Dragees Collection', 'kash-naturals'),
    'kunafa-bars'        => __('Kunafa Bars Collection', 'kash-naturals'),
    'gift-combos'        => __('Gift Combos Collection', 'kash-naturals'),
);

$page_display_title = isset($category_titles[$current_category]) ? $category_titles[$current_category] : __('Shop Collection', 'kash-naturals');

// Dummy products array for all 4 categories
$all_products = array(
    // Category 1: Mouth Fresheners
    array(
        'id'            => 1,
        'name'          => 'Royal Calcutta Paan Mukhwas',
        'category'      => 'mouth-fresheners',
        'category_name' => 'Mouth Fresheners',
        'price'         => '₹299',
        'regular_price' => '₹399',
        'image'         => $theme_uri . '/assets/images/product-calcutta-pan.jpg',
        'badge'         => 'Bestseller',
        'rating'        => '5.0',
        'desc'          => 'Traditional betel leaf mukhwas with silver cardamom & sweet gulkand.'
    ),
    array(
        'id'            => 2,
        'name'          => 'Shahi Royal Mukhwas Blend',
        'category'      => 'mouth-fresheners',
        'category_name' => 'Mouth Fresheners',
        'price'         => '₹349',
        'regular_price' => '₹449',
        'image'         => $theme_uri . '/assets/images/product-royal-mukhwas.jpg',
        'badge'         => 'Heritage',
        'rating'        => '4.9',
        'desc'          => 'Royal digestive mix of roasted seeds, dry fruits, and aromatic spices.'
    ),
    array(
        'id'            => 3,
        'name'          => 'Kash Sweet Saunf Digestif',
        'category'      => 'mouth-fresheners',
        'category_name' => 'Mouth Fresheners',
        'price'         => '₹249',
        'regular_price' => '₹329',
        'image'         => $theme_uri . '/assets/images/product-sweet-saunf.jpg',
        'badge'         => '100% Natural',
        'rating'        => '4.8',
        'desc'          => 'Crisp candied aniseeds blended with menthol and silver pearls.'
    ),
    array(
        'id'            => 4,
        'name'          => 'Silver Coated Elaichi Paan',
        'category'      => 'mouth-fresheners',
        'category_name' => 'Mouth Fresheners',
        'price'         => '₹399',
        'regular_price' => '₹499',
        'image'         => $theme_uri . '/assets/images/jar-calcutta-pan.jpg',
        'badge'         => 'Luxury Paan',
        'rating'        => '5.0',
        'desc'          => 'Premium silver leaf wrapped cardamom and dry paan infusion.'
    ),

    // Category 2: Chocolate Dragees
    array(
        'id'            => 5,
        'name'          => 'Belgian Dark Almond Dragees',
        'category'      => 'chocolate-dragees',
        'category_name' => 'Chocolate Dragees',
        'price'         => '₹499',
        'regular_price' => '₹649',
        'image'         => $theme_uri . '/assets/images/chocolate-dragees.jpg',
        'badge'         => 'Bestseller',
        'rating'        => '5.0',
        'desc'          => 'Slow-roasted almonds enrobed in 70% dark Belgian cocoa.'
    ),
    array(
        'id'            => 6,
        'name'          => 'Milk Chocolate Hazelnut Dragees',
        'category'      => 'chocolate-dragees',
        'category_name' => 'Chocolate Dragees',
        'price'         => '₹549',
        'regular_price' => '₹699',
        'image'         => $theme_uri . '/assets/images/jar-royal-mukhwas.jpg',
        'badge'         => 'Artisanal',
        'rating'        => '4.9',
        'desc'          => 'Whole Turkish hazelnuts dipped in smooth creamy milk chocolate.'
    ),
    array(
        'id'            => 7,
        'name'          => 'Cranberry Dark Chocolate Bites',
        'category'      => 'chocolate-dragees',
        'category_name' => 'Chocolate Dragees',
        'price'         => '₹479',
        'regular_price' => '₹599',
        'image'         => $theme_uri . '/assets/images/jar-sweet-saunf.jpg',
        'badge'         => 'New Arrival',
        'rating'        => '4.8',
        'desc'          => 'Tangy dried cranberries coated in rich dark chocolate.'
    ),
    array(
        'id'            => 8,
        'name'          => 'Gold Dusted Cashew Dragees',
        'category'      => 'chocolate-dragees',
        'category_name' => 'Chocolate Dragees',
        'price'         => '₹599',
        'regular_price' => '₹749',
        'image'         => $theme_uri . '/assets/images/mouth-fresheners.jpg',
        'badge'         => 'Festive Special',
        'rating'        => '5.0',
        'desc'          => 'Jumbo cashews wrapped in milk chocolate with gold shimmer.'
    ),

    // Category 3: Kunafa Bars
    array(
        'id'            => 9,
        'name'          => 'Pistachio Kunafa Bar (100g)',
        'category'      => 'kunafa-bars',
        'category_name' => 'Kunafa Bars',
        'price'         => '₹599',
        'regular_price' => '₹749',
        'image'         => $theme_uri . '/assets/images/kunafa-bars.jpg',
        'badge'         => 'Signature',
        'rating'        => '5.0',
        'desc'          => 'Crispy kataifi pastry & roasted pistachio cream wrapped in chocolate.'
    ),
    array(
        'id'            => 10,
        'name'          => 'Baklava Kunafa Milk Bar (100g)',
        'category'      => 'kunafa-bars',
        'category_name' => 'Kunafa Bars',
        'price'         => '₹549',
        'regular_price' => '₹699',
        'image'         => $theme_uri . '/assets/images/gift-combos.jpg',
        'badge'         => 'Middle Eastern',
        'rating'        => '4.9',
        'desc'          => 'Traditional Middle Eastern baklava crunch with milk chocolate.'
    ),
    array(
        'id'            => 11,
        'name'          => '70% Dark Kunafa Crunch Bar',
        'category'      => 'kunafa-bars',
        'category_name' => 'Kunafa Bars',
        'price'         => '₹649',
        'regular_price' => '₹799',
        'image'         => $theme_uri . '/assets/images/combo-celebration.jpg',
        'badge'         => 'Dark Special',
        'rating'        => '4.9',
        'desc'          => 'Rich dark cocoa paired with crispy roasted pistachio kunafa.'
    ),
    array(
        'id'            => 12,
        'name'          => 'Kunafa Trio Gift Bar Pack',
        'category'      => 'kunafa-bars',
        'category_name' => 'Kunafa Bars',
        'price'         => '₹899',
        'regular_price' => '₹1,099',
        'image'         => $theme_uri . '/assets/images/combo-premium.jpg',
        'badge'         => 'Value Pack',
        'rating'        => '5.0',
        'desc'          => 'Set of 3 mini kunafa bars: Pistachio, Hazelnut & Almond Crunch.'
    ),

    // Category 4: Gift Combos
    array(
        'id'            => 13,
        'name'          => 'Freshness & Digestive Duo Pack',
        'category'      => 'gift-combos',
        'category_name' => 'Gift Combos',
        'price'         => '₹499',
        'regular_price' => '₹599',
        'image'         => $theme_uri . '/assets/images/combo-freshness.jpg',
        'badge'         => 'Popular',
        'rating'        => '4.9',
        'desc'          => 'Royal Paan Mukhwas (250g) + Shahi Sweet Saunf (250g) Gift Box.'
    ),
    array(
        'id'            => 14,
        'name'          => 'Family Festive Celebration Pack',
        'category'      => 'gift-combos',
        'category_name' => 'Gift Combos',
        'price'         => '₹899',
        'regular_price' => '₹1,199',
        'image'         => $theme_uri . '/assets/images/combo-family.jpg',
        'badge'         => 'Best Value',
        'rating'        => '5.0',
        'desc'          => 'Assortment of 4 signature jars of mukhwas and dragees.'
    ),
    array(
        'id'            => 15,
        'name'          => 'Royal Connoisseur Treasure Box',
        'category'      => 'gift-combos',
        'category_name' => 'Gift Combos',
        'price'         => '₹1,299',
        'regular_price' => '₹1,799',
        'image'         => $theme_uri . '/assets/images/combo-premium.jpg',
        'badge'         => 'Luxury Edition',
        'rating'        => '5.0',
        'desc'          => 'Flagship luxury hamper with kunafa bars, dragees & silver paan.'
    ),
    array(
        'id'            => 16,
        'name'          => 'Artisanal Celebration Hamper',
        'category'      => 'gift-combos',
        'category_name' => 'Gift Combos',
        'price'         => '₹1,099',
        'regular_price' => '₹1,399',
        'image'         => $theme_uri . '/assets/images/combo-celebration.jpg',
        'badge'         => 'Gift Favorite',
        'rating'        => '4.8',
        'desc'          => 'Roasted hazelnut dragees, paan mukhwas & pistachio kunafa bar.'
    ),
);

// Filter products based on selected category
$filtered_products = array();
if ($current_category === 'all' || !isset($category_titles[$current_category])) {
    $filtered_products = $all_products;
} else {
    foreach ($all_products as $p) {
        if ($p['category'] === $current_category) {
            $filtered_products[] = $p;
        }
    }
}
?>

<!-- Page Header Banner -->
<div class="shop-page-header">
    <div class="container text-center">
        <span class="shop-header-subtitle"><?php esc_html_e('100% NATURAL • ARTISANAL QUALITY • PAN-INDIA DELIVERY', 'kash-naturals'); ?></span>
        <h1 class="shop-header-title"><?php echo esc_html($page_display_title); ?></h1>
        <div class="shop-breadcrumb">
            <a href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('Home', 'kash-naturals'); ?></a>
            <span class="sep">/</span>
            <a href="<?php echo esc_url(home_url('/shop')); ?>"><?php esc_html_e('Shop', 'kash-naturals'); ?></a>
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
        
        <!-- Category Filter Tabs Bar -->
        <div class="shop-filter-bar-exact">
            <div class="filter-pills-exact">
                <a href="<?php echo esc_url(home_url('/shop')); ?>" class="filter-pill-btn <?php echo ($current_category === 'all') ? 'active' : ''; ?>">
                    <i class="fa-solid fa-border-all"></i> <?php esc_html_e('All Products', 'kash-naturals'); ?>
                </a>
                <a href="<?php echo esc_url(home_url('/shop?category=mouth-fresheners')); ?>" class="filter-pill-btn <?php echo ($current_category === 'mouth-fresheners') ? 'active' : ''; ?>">
                    <i class="fa-solid fa-leaf"></i> <?php esc_html_e('Mouth Fresheners', 'kash-naturals'); ?>
                </a>
                <a href="<?php echo esc_url(home_url('/shop?category=chocolate-dragees')); ?>" class="filter-pill-btn <?php echo ($current_category === 'chocolate-dragees') ? 'active' : ''; ?>">
                    <i class="fa-solid fa-cookie-bite"></i> <?php esc_html_e('Chocolate Dragees', 'kash-naturals'); ?>
                </a>
                <a href="<?php echo esc_url(home_url('/shop?category=kunafa-bars')); ?>" class="filter-pill-btn <?php echo ($current_category === 'kunafa-bars') ? 'active' : ''; ?>">
                    <i class="fa-solid fa-layer-group"></i> <?php esc_html_e('Kunafa Bars', 'kash-naturals'); ?>
                </a>
                <a href="<?php echo esc_url(home_url('/combos')); ?>" class="filter-pill-btn <?php echo ($current_category === 'gift-combos') ? 'active' : ''; ?>">
                    <i class="fa-solid fa-gift"></i> <?php esc_html_e('Gift Combos', 'kash-naturals'); ?>
                </a>
            </div>
            
            <div class="filter-count-label">
                <?php printf(esc_html__('Showing %d Items', 'kash-naturals'), count($filtered_products)); ?>
            </div>
        </div>

        <!-- Products Grid -->
        <div class="shop-grid-exact">
            <?php foreach ($filtered_products as $prod) : ?>
                <div class="shop-product-card-exact">
                    <span class="product-badge-tag"><?php echo esc_html($prod['badge']); ?></span>
                    <a href="<?php echo esc_url(home_url('/product?id=' . $prod['id'])); ?>" class="product-img-box-exact">
                        <img src="<?php echo esc_url($prod['image']); ?>" alt="<?php echo esc_attr($prod['name']); ?>" loading="lazy">
                    </a>
                    <div class="product-card-info">
                        <div class="product-cat-label"><?php echo esc_html($prod['category_name']); ?></div>
                        <h3 class="product-title-exact">
                            <a href="<?php echo esc_url(home_url('/product?id=' . $prod['id'])); ?>" style="color: inherit; text-decoration: none;">
                                <?php echo esc_html($prod['name']); ?>
                            </a>
                        </h3>
                        <p class="product-desc-short"><?php echo esc_html($prod['desc']); ?></p>
                        <div class="product-rating-stars">★★★★★ <span>(<?php echo esc_html($prod['rating']); ?>)</span></div>
                        <div class="product-price-row-exact">
                            <div class="price-wrap">
                                <span class="current-price"><?php echo esc_html($prod['price']); ?></span>
                                <span class="old-price"><?php echo esc_html($prod['regular_price']); ?></span>
                            </div>
                            <button type="button" class="btn-add-cart-exact" onclick="event.stopPropagation(); addToCartSingle(<?php echo $prod['id']; ?>)">
                                <i class="fa-solid fa-cart-plus"></i> <?php esc_html_e('ADD TO CART', 'kash-naturals'); ?>
                            </button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

    </div>
</section>

<!-- Shop on Amazon Banner Section -->
<?php get_template_part('template-parts/content', 'amazon-banner'); ?>

<?php
get_footer();

