<?php
/**
 * Our Story Section Template Part (Matching Reference Screenshot Design)
 *
 * @package KashNaturals
 */

if (!defined('ABSPATH')) {
    exit;
}

$theme_uri = get_template_directory_uri();
$about_url = home_url('/about');

$left_img  = $theme_uri . '/assets/images/product-calcutta-pan.jpg';
$right_img = $theme_uri . '/assets/images/chocolate-dragees.jpg';
$small_img1 = $theme_uri . '/assets/images/jar-sweet-saunf.jpg';
$small_img2 = $theme_uri . '/assets/images/product-royal-mukhwas.jpg';
?>

<section class="section-padding our-story-ref-section" id="story">
    <div class="container">
        
        <!-- Main Story Banner Card Matching Reference Design -->
        <div class="story-ref-card-banner">

            <!-- 1. Left Overflowing Dish/Plate -->
            <div class="story-ref-plate story-plate-left">
                <div class="plate-ring-shadow">
                    <img src="<?php echo esc_url($left_img); ?>" alt="Artisanal Mukhwas" class="story-plate-img">
                </div>
            </div>

            <!-- 2. Floating Top Background Ingredient Bowls -->
            <div class="story-ref-floating-bowls">
                <div class="mini-bowl mini-bowl-1">
                    <img src="<?php echo esc_url($small_img1); ?>" alt="Sweet Saunf Bowl">
                </div>
                <div class="mini-bowl mini-bowl-2">
                    <img src="<?php echo esc_url($small_img2); ?>" alt="Royal Spices Bowl">
                </div>
            </div>

            <!-- 3. Center Content Area -->
            <div class="story-ref-center-content text-center">
                
                <!-- Gold Crest Circle Icon -->
                <div class="story-gold-emblem">
                    <i class="fa-solid fa-leaf"></i>
                </div>

                <!-- Cursive Handwriting Title -->
                <div class="story-script-heading">Authentic Roots</div>

                <!-- Main Section Title -->
                <h2 class="story-main-title">Crafted with Pure Ingredients</h2>

                <!-- Story Text Paragraph -->
                <p class="story-body-paragraph">
                    Kash Natural was born from a passion for authentic Indian flavors &amp; royal digestives. 
                    From hand-selected sweet saunf &amp; silver paan to luxury Belgian chocolate dragees, 
                    every jar is freshly blended with 100% natural ingredients &amp; zero artificial preservatives.
                </p>

                <!-- Pill CTA Button -->
                <div class="story-cta-wrap">
                    <a href="<?php echo esc_url($about_url); ?>" class="story-pill-btn">
                        DISCOVER OUR STORY <i class="fa-solid fa-arrow-right ms-1"></i>
                    </a>
                </div>

            </div>

            <!-- 4. Right Overflowing Dish/Plate -->
            <div class="story-ref-plate story-plate-right">
                <div class="plate-ring-shadow">
                    <img src="<?php echo esc_url($right_img); ?>" alt="Chocolate Dragees" class="story-plate-img">
                </div>
            </div>

        </div>

    </div>
</section>
