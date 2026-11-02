<?php
/**
 * Customer Testimonials Template Part (Unified Review Card with Integrated Image & Rating)
 *
 * @package KashNaturals
 */

if (!defined('ABSPATH')) {
    exit;
}

$get_testi_media_url = function($setting_val, $default_path) {
    if (empty($setting_val)) {
        return get_template_directory_uri() . $default_path;
    }
    if (is_numeric($setting_val)) {
        $img_src = wp_get_attachment_image_url(intval($setting_val), 'full');
        if ($img_src) {
            return $img_src;
        }
    }
    return $setting_val;
};

$testimonials = array(
    array(
        'id'          => '01',
        'theme_color' => '#d48b10', // Royal Gold
        'image'       => $get_testi_media_url(get_theme_mod('kash_testi1_image'), '/assets/images/jar-royal-mukhwas.jpg'),
        'rating'      => get_theme_mod('kash_testi1_rating', '5.0'),
        'product'     => get_theme_mod('kash_testi1_product', __('Royal Calcutta Paan Mukhwas', 'kash-naturals')),
        'title'       => get_theme_mod('kash_testi1_title', __('UNMATCHED FRESHNESS', 'kash-naturals')),
        'quote'       => get_theme_mod('kash_testi1_quote', __('Excellent freshness and premium authentic taste. Every jar feels hand-picked and freshly packed with royal aroma! Loved all the varieties.', 'kash-naturals')),
        'author'      => get_theme_mod('kash_testi1_author', 'Priya Sharma'),
        'location'    => get_theme_mod('kash_testi1_location', 'Mumbai'),
    ),
    array(
        'id'          => '02',
        'theme_color' => '#2c5f3e', // Royal Emerald
        'image'       => $get_testi_media_url(get_theme_mod('kash_testi2_image'), '/assets/images/chocolate-dragees.jpg'),
        'rating'      => get_theme_mod('kash_testi2_rating', '5.0'),
        'product'     => get_theme_mod('kash_testi2_product', __('Belgian Roasted Dragees', 'kash-naturals')),
        'title'       => get_theme_mod('kash_testi2_title', __('MUST-TRY DRAGEES', 'kash-naturals')),
        'quote'       => get_theme_mod('kash_testi2_quote', __('Chocolate dragees are absolutely amazing! The smooth Belgian chocolate shell paired with roasted nuts is addictive. Must try for celebrations!', 'kash-naturals')),
        'author'      => get_theme_mod('kash_testi2_author', 'Rahul Mehta'),
        'location'    => get_theme_mod('kash_testi2_location', 'Delhi'),
    ),
    array(
        'id'          => '03',
        'theme_color' => '#c84c28', // Royal Coral
        'image'       => $get_testi_media_url(get_theme_mod('kash_testi3_image'), '/assets/images/combo-celebration.jpg'),
        'rating'      => get_theme_mod('kash_testi3_rating', '5.0'),
        'product'     => get_theme_mod('kash_testi3_product', __('Curated Gift Hamper', 'kash-naturals')),
        'title'       => get_theme_mod('kash_testi3_title', __('ROYAL QUALITY', 'kash-naturals')),
        'quote'       => get_theme_mod('kash_testi3_quote', __('Best quality mukhwas I have ever ordered online. Zero preservatives and 100% natural ingredients make all the difference. Highly recommended!', 'kash-naturals')),
        'author'      => get_theme_mod('kash_testi3_author', 'Neha Kapoor'),
        'location'    => get_theme_mod('kash_testi3_location', 'Bengaluru'),
    ),
);
?>

<section class="section-padding testimonials-ref-section" id="testimonials">
    <div class="container">
        
        <!-- Section Header -->
        <div class="testi-header-wrap text-center">
            <span class="testi-sub-heading"><?php echo esc_html(get_theme_mod('kash_testi_subheading', '— TESTIMONIALS —')); ?></span>
            <h2 class="testi-main-title"><?php echo esc_html(get_theme_mod('kash_testi_title', __('What Our Customers Say', 'kash-naturals'))); ?></h2>
            <p class="testi-subtitle"><?php echo esc_html(get_theme_mod('kash_testi_desc', __('Read real experiences from food lovers who savor our authentic digestives', 'kash-naturals'))); ?></p>
        </div>

        <!-- 3-Card Grid with Photo, Overlapping Glass Rating Badge, & Unified Review Content -->
        <div class="testi-cards-grid">
            <?php foreach ($testimonials as $item) : ?>
                <div class="testi-review-card testi-card-wrapper" style="--testi-accent: <?php echo esc_attr($item['theme_color']); ?>;">
                    
                    <!-- Top Featured Image Container (Integrated in the SAME Card Div) -->
                    <div class="testi-card-media">
                        <img src="<?php echo esc_url($item['image']); ?>" alt="<?php echo esc_attr($item['title']); ?>" class="testi-card-img" loading="lazy">
                        
                        <!-- Image Gradient Vignette -->
                        <div class="testi-img-overlay"></div>

                        <!-- Rating Badge with only 1 Star Overlapping the Image (Semi-Transparent Background) -->
                        <div class="testi-rating-badge">
                            <span class="testi-rating-num"><?php echo esc_html($item['rating']); ?></span>
                            <i class="fa-solid fa-star testi-single-star"></i>
                        </div>

                        <!-- Product Pill on Image -->
                        <?php if (!empty($item['product'])) : ?>
                            <div class="testi-product-pill">
                                <span><?php echo esc_html($item['product']); ?></span>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Review Content Area (Inside the EXACT SAME Card Div) -->
                    <div class="testi-card-content testi-card-body">
                        
                        <!-- Review Title / Category Header -->
                        <div class="testi-title-wrap">
                            <span class="testi-card-number"><?php echo esc_html($item['id']); ?></span>
                            <h3 class="testi-card-title"><?php echo esc_html($item['title']); ?></h3>
                        </div>

                        <!-- Customer Review Quote -->
                        <p class="testi-quote-text">
                            “<?php echo esc_html($item['quote']); ?>”
                        </p>

                        <!-- Customer Author Info -->
                        <div class="testi-author-footer">
                            <div class="testi-author-avatar">
                                <?php
                                $initials = '';
                                $words = explode(' ', trim($item['author']));
                                foreach ($words as $w) {
                                    if (!empty($w)) {
                                        $initials .= strtoupper(mb_substr($w, 0, 1));
                                    }
                                }
                                echo esc_html(substr($initials, 0, 2));
                                ?>
                            </div>
                            <div class="testi-author-meta">
                                <div class="testi-author-name"><?php echo esc_html($item['author']); ?></div>
                                <div class="testi-author-sub">
                                    <span class="testi-verified-pill"><i class="fa-solid fa-circle-check"></i> <?php esc_html_e('Verified Buyer', 'kash-naturals'); ?></span>
                                    <?php if (!empty($item['location'])) : ?>
                                        <span class="testi-dot">•</span>
                                        <span class="testi-location"><?php echo esc_html($item['location']); ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            <?php endforeach; ?>
        </div>

    </div>
</section>
