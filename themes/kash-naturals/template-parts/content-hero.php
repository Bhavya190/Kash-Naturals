<?php
/**
 * Hero Banner Section Template Part
 *
 * @package KashNaturals
 */

if (!defined('ABSPATH')) {
    exit;
}
?>
<section class="hero-banner-section-exact">
    <div class="container hero-banner-container">
        <div class="hero-left-content">
            <h1 class="hero-main-title">
                <span class="title-top">Freshness</span>
                <span class="title-bottom">Crafted by Nature</span>
            </h1>
            <p class="hero-main-subtitle">
                Premium Mouth Fresheners,<br>
                Chocolate Dragees &amp; Kunafa Delights
            </p>
            <div class="hero-action-buttons">
                <a href="<?php echo esc_url(class_exists('WooCommerce') ? wc_get_page_permalink('shop') : '#'); ?>" class="btn-shop-now">
                    SHOP NOW
                </a>
                <a href="#combos" class="btn-explore-combos">
                    EXPLORE COMBOS
                </a>
            </div>
            <div class="hero-amazon-badge-wrapper">
                <a href="https://amazon.in" target="_blank" rel="noopener noreferrer" class="amazon-pill-badge">
                    <span class="badge-subtext">Available on</span>
                    <img src="https://upload.wikimedia.org/wikipedia/commons/a/a9/Amazon_logo.svg" alt="Amazon" class="amazon-logo-img">
                </a>
            </div>
        </div>
    </div>
</section>
