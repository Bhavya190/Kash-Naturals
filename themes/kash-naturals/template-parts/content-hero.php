<?php
/**
 * Hero Carousel Slider Section Template Part
 * Supports dynamic slides with background images, HTML5 videos, autoplay, and touch controls.
 *
 * @package KashNaturals
 */

if (!defined('ABSPATH')) {
    exit;
}

$theme_uri = get_template_directory_uri();

// Default Hero Carousel Slides (Images & Videos)
$default_slides = array(
    array(
        'id'          => 'slide-1',
        'type'        => 'image',
        'badge'       => __('AUTHENTIC • 100% NATURAL • HYGIENIC', 'kash-naturals'),
        'title_top'   => __('Freshness', 'kash-naturals'),
        'title_bottom'=> __('Crafted by Nature', 'kash-naturals'),
        'subtitle'    => __('Premium Handcrafted Mouth Fresheners, Chocolate Dragees &amp; Kunafa Delights.', 'kash-naturals'),
        'image'       => get_theme_mod('kash_hero_slide1_image', $theme_uri . '/assets/images/hero-banner.jpg'),
        'video_url'   => '',
        'btn_primary_text'   => __('SHOP NOW', 'kash-naturals'),
        'btn_primary_link'   => home_url('/shop'),
        'btn_secondary_text' => __('EXPLORE COMBOS', 'kash-naturals'),
        'btn_secondary_link' => home_url('/combos/'),
        'show_amazon' => true,
    ),
    array(
        'id'          => 'slide-2',
        'type'        => 'video',
        'badge'       => __('LUXURY BELGIAN CACAO &amp; KUNAFA', 'kash-naturals'),
        'title_top'   => __('Belgian Chocolate', 'kash-naturals'),
        'title_bottom'=> __('Roasted Dragees', 'kash-naturals'),
        'subtitle'    => __('Whole slow-roasted Californian almonds &amp; hazelnuts enrobed in smooth velvety dark and milk chocolate.', 'kash-naturals'),
        'image'       => get_theme_mod('kash_hero_slide2_image', $theme_uri . '/assets/images/chocolate-dragees.jpg'),
        'video_url'   => get_theme_mod('kash_hero_slide2_video', 'https://assets.mixkit.co/videos/preview/mixkit-liquid-chocolate-being-poured-over-hazelnuts-41554-large.mp4'),
        'btn_primary_text'   => __('DISCOVER CHOCOLATES', 'kash-naturals'),
        'btn_primary_link'   => home_url('/product-category/chocolates/'),
        'btn_secondary_text' => __('OUR STORY', 'kash-naturals'),
        'btn_secondary_link' => home_url('/our-story/'),
        'show_amazon' => false,
    ),
    array(
        'id'          => 'slide-3',
        'type'        => 'image',
        'badge'       => __('FESTIVE CELEBRATIONS &amp; GIFTING', 'kash-naturals'),
        'title_top'   => __('Celebration Packs', 'kash-naturals'),
        'title_bottom'=> __('Curated Gift Hampers', 'kash-naturals'),
        'subtitle'    => __('Make every festival and wedding unforgettable with custom luxury hampers and value combo sets.', 'kash-naturals'),
        'image'       => get_theme_mod('kash_hero_slide3_image', $theme_uri . '/assets/images/gift-combos.jpg'),
        'video_url'   => '',
        'btn_primary_text'   => __('VIEW GIFT HAMPERS', 'kash-naturals'),
        'btn_primary_link'   => home_url('/product-category/gift-hampers/'),
        'btn_secondary_text' => __('BULK ORDERS', 'kash-naturals'),
        'btn_secondary_link' => home_url('/bulk-order/'),
        'show_amazon' => false,
    ),
    array(
        'id'          => 'slide-4',
        'type'        => 'image',
        'badge'       => __('ROYAL INDIAN AFTER-MEAL DIGESTIVES', 'kash-naturals'),
        'title_top'   => __('Royal Mukhwas', 'kash-naturals'),
        'title_bottom'=> __('Calcutta Paan &amp; Saunf', 'kash-naturals'),
        'subtitle'    => __('Aromatic silver-coated cardamom, sweet fennel, and betel leaf blends prepared under cleanroom standards.', 'kash-naturals'),
        'image'       => get_theme_mod('kash_hero_slide4_image', $theme_uri . '/assets/images/mouth-fresheners.jpg'),
        'video_url'   => '',
        'btn_primary_text'   => __('SHOP MUKHWAS', 'kash-naturals'),
        'btn_primary_link'   => home_url('/product-category/mukhwas/'),
        'btn_secondary_text' => __('ALL PRODUCTS', 'kash-naturals'),
        'btn_secondary_link' => home_url('/shop'),
        'show_amazon' => true,
    ),
);

$slides = apply_filters('kash_hero_slides', $default_slides);
$total_slides = count($slides);
$autoplay_speed = get_theme_mod('kash_hero_autoplay_speed', 5500);
?>

<section class="hero-carousel-section" id="heroCarouselSection" data-autoplay-speed="<?php echo esc_attr($autoplay_speed); ?>" aria-roledescription="carousel" aria-label="<?php esc_attr_e('Featured Highlights Slider', 'kash-naturals'); ?>">
    
    <!-- Slides Track Wrapper -->
    <div class="hero-carousel-track" id="heroCarouselTrack">
        <?php foreach ($slides as $index => $slide) : 
            $is_active = ($index === 0);
            $has_video = ($slide['type'] === 'video' && !empty($slide['video_url']));
        ?>
            <div class="hero-slide <?php echo $is_active ? 'active' : ''; ?> <?php echo $has_video ? 'has-video-media' : 'has-image-media'; ?>" 
                 data-slide-index="<?php echo esc_attr($index); ?>" 
                 data-slide-type="<?php echo esc_attr($slide['type']); ?>"
                 role="group" 
                 aria-roledescription="slide" 
                 aria-label="<?php echo esc_attr($slide['title_top'] . ' ' . $slide['title_bottom']); ?>">

                <!-- Background Media Layer (Image / Video) -->
                <div class="hero-slide-media-layer">
                    <?php if ($has_video) : ?>
                        <video class="hero-slide-video" 
                               autoplay 
                               muted 
                               loop 
                               playsinline 
                               poster="<?php echo esc_url($slide['image']); ?>"
                               preload="metadata">
                            <source src="<?php echo esc_url($slide['video_url']); ?>" type="video/mp4">
                        </video>
                        <div class="hero-video-controls" title="<?php esc_attr_e('Video Controls', 'kash-naturals'); ?>">
                            <button type="button" class="btn-hero-video-toggle btn-video-audio" aria-label="<?php esc_attr_e('Toggle Sound', 'kash-naturals'); ?>" title="<?php esc_attr_e('Toggle Sound', 'kash-naturals'); ?>">
                                <i class="fa-solid fa-volume-xmark"></i>
                            </button>
                            <button type="button" class="btn-hero-video-toggle btn-video-playback" aria-label="<?php esc_attr_e('Play/Pause Video', 'kash-naturals'); ?>" title="<?php esc_attr_e('Play/Pause Video', 'kash-naturals'); ?>">
                                <i class="fa-solid fa-pause"></i>
                            </button>
                        </div>
                    <?php endif; ?>

                    <div class="hero-slide-bg-img" style="background-image: url('<?php echo esc_url($slide['image']); ?>');"></div>
                    <div class="hero-slide-overlay"></div>
                </div>

                <!-- Slide Foreground Text Content -->
                <div class="container hero-banner-container">
                    <div class="hero-left-content">
                        <?php if (!empty($slide['badge'])) : ?>
                            <div class="hero-badge-pill">
                                <span class="badge-dot">✦</span>
                                <span><?php echo esc_html($slide['badge']); ?></span>
                            </div>
                        <?php endif; ?>

                        <h1 class="hero-main-title">
                            <span class="title-top"><?php echo esc_html($slide['title_top']); ?></span>
                            <span class="title-bottom"><?php echo esc_html($slide['title_bottom']); ?></span>
                        </h1>

                        <p class="hero-main-subtitle">
                            <?php echo wp_kses_post($slide['subtitle']); ?>
                        </p>

                        <div class="hero-actions-row">
                            <div class="hero-action-buttons">
                                <?php if (!empty($slide['btn_primary_text'])) : ?>
                                    <a href="<?php echo esc_url($slide['btn_primary_link']); ?>" class="btn-shop-now">
                                        <span><?php echo esc_html($slide['btn_primary_text']); ?></span>
                                        <i class="fa-solid fa-arrow-right ms-2"></i>
                                    </a>
                                <?php endif; ?>
                                <?php if (!empty($slide['btn_secondary_text'])) : ?>
                                    <a href="<?php echo esc_url($slide['btn_secondary_link']); ?>" class="btn-explore-combos">
                                        <?php echo esc_html($slide['btn_secondary_text']); ?>
                                    </a>
                                <?php endif; ?>
                            </div>

                            <?php if (!empty($slide['show_amazon'])) : ?>
                                <div class="hero-amazon-badge-wrapper">
                                    <a href="<?php echo esc_url(get_theme_mod('kash_amazon_shop_link', 'https://amazon.in')); ?>" target="_blank" rel="noopener noreferrer" class="amazon-pill-badge" title="<?php esc_attr_e('Buy Kash Naturals on Amazon', 'kash-naturals'); ?>">
                                        <span class="badge-subtext"><?php esc_html_e('Available on', 'kash-naturals'); ?></span>
                                        <img src="<?php echo esc_url($theme_uri . '/assets/images/amazon-logo-clean.png'); ?>" alt="Amazon" class="amazon-logo-img" width="76" height="24">
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

            </div>
        <?php endforeach; ?>
    </div>

    <!-- Arrow Navigation Controls -->
    <button type="button" class="hero-arrow-btn hero-arrow-prev" id="heroPrevBtn" aria-label="<?php esc_attr_e('Previous Slide', 'kash-naturals'); ?>">
        <i class="fa-solid fa-chevron-left"></i>
    </button>
    <button type="button" class="hero-arrow-btn hero-arrow-next" id="heroNextBtn" aria-label="<?php esc_attr_e('Next Slide', 'kash-naturals'); ?>">
        <i class="fa-solid fa-chevron-right"></i>
    </button>

    <!-- Bottom Carousel Navigation Bar (Progress Dots + Autoplay Toggle) -->
    <div class="hero-carousel-nav-bar">
        <div class="container hero-nav-bar-inner">
            <div class="hero-carousel-nav-capsule">
                <!-- Progress Indicator Dots -->
                <div class="hero-progress-dots" id="heroProgressDots">
                    <?php foreach ($slides as $idx => $s) : ?>
                        <button type="button" 
                                class="hero-dot <?php echo ($idx === 0) ? 'active' : ''; ?>" 
                                data-slide-target="<?php echo esc_attr($idx); ?>" 
                                aria-label="<?php echo esc_attr(sprintf(__('Go to slide %d: %s', 'kash-naturals'), $idx + 1, $s['title_top'])); ?>">
                            <span class="dot-progress-track">
                                <span class="dot-progress-fill"></span>
                            </span>
                        </button>
                    <?php endforeach; ?>
                </div>

                <!-- Autoplay Pause / Play Control -->
                <button type="button" class="hero-autoplay-toggle" id="heroAutoplayToggle" aria-label="<?php esc_attr_e('Pause Slideshow', 'kash-naturals'); ?>" title="<?php esc_attr_e('Pause / Play Slideshow', 'kash-naturals'); ?>">
                    <i class="fa-solid fa-pause"></i>
                </button>
            </div>
        </div>
    </div>

</section>
