<?php
/**
 * Our Story Section Template Part
 *
 * @package KashNaturals
 */

if (!defined('ABSPATH')) {
    exit;
}

$story_img = function_exists('get_template_directory_uri') ? get_template_directory_uri() . '/assets/images/jar-royal-mukhwas.jpg' : '/wp-content/themes/kash-naturals/assets/images/jar-royal-mukhwas.jpg';
$about_url = function_exists('home_url') ? home_url('/about') : '/about';
?>
<section class="our-story-section-exact">
    <div class="container">
        <div class="our-story-card-exact">
            
            <!-- Decorative Leaf Vector Accent -->
            <div class="our-story-leaf-wrapper">
                <svg width="160" height="160" viewBox="0 0 160 160" fill="none" xmlns="http://www.w3.org/2000/svg" class="leaf-svg-accent">
                    <!-- Branch Stem -->
                    <path d="M160 0 C130 25 90 60 35 125" stroke="#264b2d" stroke-width="3.5" stroke-linecap="round"/>
                    <!-- Leaf 1 (Top) -->
                    <path d="M135 12 C108 2 82 20 92 50 C110 64 132 46 135 12 Z" fill="#3c7345"/>
                    <path d="M135 12 C118 24 102 37 92 50" stroke="#1d3d23" stroke-width="1.2"/>
                    <!-- Leaf 2 (Upper Right) -->
                    <path d="M155 38 C128 32 108 52 122 80 C144 88 162 65 155 38 Z" fill="#295431"/>
                    <path d="M155 38 C141 52 130 66 122 80" stroke="#152f1b" stroke-width="1.2"/>
                    <!-- Leaf 3 (Middle) -->
                    <path d="M96 52 C70 42 52 60 62 88 C83 94 101 77 96 52 Z" fill="#4d8956"/>
                    <path d="M96 52 C82 63 71 75 62 88" stroke="#254a2c" stroke-width="1.2"/>
                    <!-- Leaf 4 (Lower) -->
                    <path d="M65 90 C44 80 25 98 35 125 C56 131 74 114 65 90 Z" fill="#34633b"/>
                    <path d="M65 90 C52 101 42 113 35 125" stroke="#1b3820" stroke-width="1.2"/>
                </svg>
            </div>

            <div class="our-story-grid-exact">
                <!-- Left Image Column -->
                <div class="our-story-img-col">
                    <img src="<?php echo esc_url($story_img); ?>" alt="About Kash Natural" class="our-story-main-img">
                </div>

                <!-- Right Text Column -->
                <div class="our-story-text-col">
                    <div class="our-story-subtitle">
                        <span>OUR STORY</span>
                        <span class="sub-line"></span>
                    </div>
                    <h2 class="our-story-title">About Kash Natural</h2>
                    <p class="our-story-desc">
                        Kash Natural was founded with a simple mission &ndash; to bring premium mouth fresheners and delightful confectionery products made with quality ingredients to every Indian household.
                    </p>
                    <div class="our-story-action">
                        <a href="<?php echo esc_url($about_url); ?>" class="btn-our-story-exact">
                            KNOW MORE ABOUT US
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

