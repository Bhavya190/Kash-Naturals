<?php
/**
 * Chocolate Categories Showcase Template Part
 *
 * @package KashNaturals
 */

if (!defined('ABSPATH')) {
    exit;
}
?>
<section class="section-padding categories-section">
    <div class="container">
        <div class="section-header text-center">
            <span class="section-subtitle">Curated Taste Collections</span>
            <h2 class="section-title">Shop by Chocolate Craft</h2>
            <div class="gold-divider"></div>
        </div>

        <div class="category-grid">
            <div class="category-card">
                <div class="category-card-bg dark-cocoa-bg"></div>
                <div class="category-card-content">
                    <span class="cat-tag">Intensity 70% - 99%</span>
                    <h3>Single-Origin Dark</h3>
                    <p>Bold, roasted cacao notes with low sugar density.</p>
                    <a href="<?php echo esc_url(class_exists('WooCommerce') ? wc_get_page_permalink('shop') : '#'); ?>" class="cat-link">Explore Dark <i class="fa-solid fa-arrow-right"></i></a>
                </div>
            </div>

            <div class="category-card">
                <div class="category-card-bg milk-hazelnut-bg"></div>
                <div class="category-card-content">
                    <span class="cat-tag">Smooth & Creamy</span>
                    <h3>Velvet Milk & Hazelnut</h3>
                    <p>Alpine milk infused with slow-roasted Oregon hazelnuts.</p>
                    <a href="<?php echo esc_url(class_exists('WooCommerce') ? wc_get_page_permalink('shop') : '#'); ?>" class="cat-link">Explore Milk <i class="fa-solid fa-arrow-right"></i></a>
                </div>
            </div>

            <div class="category-card">
                <div class="category-card-bg truffles-bg"></div>
                <div class="category-card-content">
                    <span class="cat-tag">Hand-Dipped</span>
                    <h3>Artisan Truffle Boxes</h3>
                    <p>Ganache-filled silk truffles coated in gold dust & sea salt.</p>
                    <a href="<?php echo esc_url(class_exists('WooCommerce') ? wc_get_page_permalink('shop') : '#'); ?>" class="cat-link">Explore Truffles <i class="fa-solid fa-arrow-right"></i></a>
                </div>
            </div>

            <div class="category-card">
                <div class="category-card-bg vegan-bg"></div>
                <div class="category-card-content">
                    <span class="cat-tag">Plant-Based</span>
                    <h3>Vegan & Keto Chocolate</h3>
                    <p>Sweetened naturally with monkfruit & coconut nectar.</p>
                    <a href="<?php echo esc_url(class_exists('WooCommerce') ? wc_get_page_permalink('shop') : '#'); ?>" class="cat-link">Explore Vegan <i class="fa-solid fa-arrow-right"></i></a>
                </div>
            </div>
        </div>
    </div>
</section>
