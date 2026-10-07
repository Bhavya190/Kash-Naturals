<?php
/**
 * Customer Testimonials Template Part (Matching Reference Ribbon Card UI)
 *
 * @package KashNaturals
 */

if (!defined('ABSPATH')) {
    exit;
}

$testimonials = array(
    array(
        'number'       => '01',
        'theme_class'  => 'testi-theme-gold',
        'title'        => 'UNMATCHED FRESHNESS',
        'rating'       => '★★★★★',
        'quote'        => 'Excellent freshness and premium authentic taste. Every jar feels hand-picked and freshly packed with royal aroma! Loved all the varieties.',
        'author'       => 'Priya Sharma',
        'location'     => 'Verified Buyer • Mumbai',
        'icon_class'   => 'fa-solid fa-quote-right',
    ),
    array(
        'number'       => '02',
        'theme_class'  => 'testi-theme-emerald',
        'title'        => 'MUST-TRY DRAGEES',
        'rating'       => '★★★★★',
        'quote'        => 'Chocolate dragees are absolutely amazing! The smooth Belgian chocolate shell paired with roasted nuts is addictive. Must try for celebrations!',
        'author'       => 'Rahul Mehta',
        'location'     => 'Verified Buyer • Delhi',
        'icon_class'   => 'fa-solid fa-heart',
    ),
    array(
        'number'       => '03',
        'theme_class'  => 'testi-theme-coral',
        'title'        => 'ROYAL QUALITY',
        'rating'       => '★★★★★',
        'quote'        => 'Best quality mukhwas I have ever ordered online. Zero preservatives and 100% natural ingredients make all the difference. Highly recommended!',
        'author'       => 'Neha Kapoor',
        'location'     => 'Verified Buyer • Bengaluru',
        'icon_class'   => 'fa-solid fa-star',
    ),
);
?>

<section class="section-padding testimonials-ref-section" id="testimonials">
    <div class="container">
        
        <!-- Section Header -->
        <div class="testi-header-wrap text-center">
            <span class="testi-sub-heading">— TESTIMONIALS —</span>
            <h2 class="testi-main-title"><?php esc_html_e('What Our Customers Say', 'kash-naturals'); ?></h2>
            <p class="testi-subtitle">Read real experiences from food lovers who savor our authentic digestives</p>
        </div>

        <!-- 3-Card Grid Matching Reference Design -->
        <div class="testi-cards-grid">
            <?php foreach ($testimonials as $item) : ?>
                <div class="testi-card-wrapper <?php echo esc_attr($item['theme_class']); ?>">
                    
                    <!-- Top Ribbon Backing Header Frame -->
                    <div class="testi-ribbon-backing">
                        <div class="ribbon-tail ribbon-tail-left"></div>
                        <div class="ribbon-tail ribbon-tail-right"></div>
                    </div>

                    <!-- Main White Floating Card Body -->
                    <div class="testi-card-body">
                        
                        <!-- Number Badge -->
                        <div class="testi-num-badge"><?php echo esc_html($item['number']); ?></div>

                        <!-- Card Category/Title -->
                        <h3 class="testi-card-title"><?php echo esc_html($item['title']); ?></h3>

                        <!-- Star Rating -->
                        <div class="testi-stars"><?php echo esc_html($item['rating']); ?></div>

                        <!-- Quote Text -->
                        <p class="testi-quote-text">
                            "<?php echo esc_html($item['quote']); ?>"
                        </p>

                        <!-- Author Info -->
                        <div class="testi-author-info">
                            <div class="testi-author-name"><?php echo esc_html($item['author']); ?></div>
                            <div class="testi-author-location"><?php echo esc_html($item['location']); ?></div>
                        </div>

                        <!-- Bottom Circular Icon Badge -->
                        <div class="testi-circle-badge">
                            <i class="<?php echo esc_attr($item['icon_class']); ?>"></i>
                        </div>

                    </div>

                </div>
            <?php endforeach; ?>
        </div>

    </div>
</section>
