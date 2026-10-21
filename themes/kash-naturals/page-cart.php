<?php
/**
 * Template Name: Shopping Cart Page
 * The Template for displaying the modern, luxury Kash Naturals cart experience
 *
 * @package KashNaturals
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();

$theme_uri     = get_template_directory_uri();
$cart_url      = function_exists('wc_get_cart_url') ? wc_get_cart_url() : home_url('/cart');
$checkout_url  = function_exists('wc_get_checkout_url') ? wc_get_checkout_url() : home_url('/checkout');
$shop_url      = function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : home_url('/shop');
?>

<!-- Luxury Cart Header Hero Banner -->
<div class="shop-page-header checkout-hero-banner cart-hero-banner">
    <div class="container text-center">
        <span class="shop-header-subtitle">
            <i class="fa-solid fa-leaf"></i> <?php esc_html_e('100% PURE BOTANICAL HERITAGE • FREE EXPRESS DELIVERY OVER ₹999', 'kash-naturals'); ?>
        </span>
        <h1 class="shop-header-title">
            <i class="fa-solid fa-bag-shopping" style="color: #c68b27; margin-right: 10px;"></i><?php esc_html_e('Your Shopping Bag', 'kash-naturals'); ?>
        </h1>
        <div class="shop-breadcrumb">
            <a href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('Home', 'kash-naturals'); ?></a>
            <span class="sep">/</span>
            <a href="<?php echo esc_url($shop_url); ?>"><?php esc_html_e('Shop', 'kash-naturals'); ?></a>
            <span class="sep">/</span>
            <span class="current"><?php esc_html_e('Shopping Bag', 'kash-naturals'); ?></span>
        </div>

        <!-- 3-Step Trust Progress Stepper -->
        <div class="checkout-stepper-strip">
            <div class="checkout-step-badge active">
                <span class="step-num">1</span>
                <span class="step-label"><?php esc_html_e('Artisanal Bag', 'kash-naturals'); ?></span>
            </div>
            <div class="stepper-line"></div>
            <div class="checkout-step-badge">
                <span class="step-num">2</span>
                <span class="step-label"><?php esc_html_e('Shipping Details', 'kash-naturals'); ?></span>
            </div>
            <div class="stepper-line"></div>
            <div class="checkout-step-badge">
                <span class="step-num">3</span>
                <span class="step-label"><?php esc_html_e('Payment & Confirm', 'kash-naturals'); ?></span>
            </div>
        </div>
    </div>
</div>

<!-- Main Cart Section -->
<section class="checkout-main-section cart-main-section">
    <div class="container">

        <!-- Trust Badges Strip -->
        <div class="checkout-trust-banner">
            <div class="trust-badge-item">
                <div class="trust-icon">
                    <i class="fa-solid fa-lock"></i>
                </div>
                <div class="trust-text">
                    <strong><?php esc_html_e('256-Bit SSL', 'kash-naturals'); ?></strong>
                    <span><?php esc_html_e('Bank-grade Encryption', 'kash-naturals'); ?></span>
                </div>
            </div>
            <div class="trust-badge-item">
                <div class="trust-icon">
                    <i class="fa-solid fa-leaf"></i>
                </div>
                <div class="trust-text">
                    <strong><?php esc_html_e('100% Natural', 'kash-naturals'); ?></strong>
                    <span><?php esc_html_e('Pure & Artisanal Batches', 'kash-naturals'); ?></span>
                </div>
            </div>
            <div class="trust-badge-item">
                <div class="trust-icon">
                    <i class="fa-solid fa-truck-fast"></i>
                </div>
                <div class="trust-text">
                    <strong><?php esc_html_e('Express Delivery', 'kash-naturals'); ?></strong>
                    <span><?php esc_html_e('Pan-India Priority Dispatch', 'kash-naturals'); ?></span>
                </div>
            </div>
            <div class="trust-badge-item">
                <div class="trust-icon">
                    <i class="fa-solid fa-money-bill-1-wave"></i>
                </div>
                <div class="trust-text">
                    <strong><?php esc_html_e('UPI & COD Available', 'kash-naturals'); ?></strong>
                    <span><?php esc_html_e('Pay on delivery or instant UPI', 'kash-naturals'); ?></span>
                </div>
            </div>
        </div>

        <!-- Free Shipping Threshold Banner (Synced with Drawer & Checkout) -->
        <div class="kash-free-shipping-card" id="kash-cart-shipping-card">
            <div class="shipping-text" id="kash-cart-shipping-text">
                <i class="fa-solid fa-truck-fast" style="color: #c68b27;"></i>
                <span>Add <strong>₹462</strong> more to unlock <strong>FREE Express Shipping</strong>!</span>
            </div>
            <div class="shipping-progress-track">
                <div class="shipping-progress-fill" id="kash-cart-shipping-fill" style="width: 54%;"></div>
            </div>
        </div>

        <!-- Render Cart Content Wrap -->
        <div class="kash-cart-content-wrap">
            <?php
            // If in real WordPress environment and post content exists (WooCommerce Blocks / Shortcode)
            if (function_exists('have_posts') && have_posts() && class_exists('WooCommerce')) {
                while (have_posts()) :
                    the_post();
                    the_content();
                endwhile;
            } else {
                // Interactive Standalone High-Fidelity Cart (Matches Image 1 & Image 2)
                ?>
                <div class="kash-cart-grid-layout" id="kash-standalone-cart">
                    <!-- Left: Items Card -->
                    <div class="kash-cart-main-col">
                        <div class="kash-card-box kash-cart-items-card">
                            <div class="kash-card-header">
                                <div class="header-left">
                                    <h2 class="kash-card-title"><?php esc_html_e('Artisanal Items in Bag', 'kash-naturals'); ?></h2>
                                    <span class="kash-badge-count" id="cart-page-badge-count">3 Items</span>
                                </div>
                                <button type="button" class="btn-clear-cart-clean" id="btn-cart-page-clear">
                                    <i class="fa-regular fa-trash-can"></i> <?php esc_html_e('Clear Bag', 'kash-naturals'); ?>
                                </button>
                            </div>

                            <div class="kash-cart-items-list" id="cart-page-items-list">
                                <!-- Populated dynamically by client-side script from localStorage or fallback defaults -->
                                <div class="kash-cart-item-row" data-id="1">
                                    <div class="item-thumb-col">
                                        <img src="<?php echo esc_url($theme_uri . '/assets/images/jar-royal-mukhwas.jpg'); ?>" alt="Kash Natural Raj Ratan">
                                    </div>
                                    <div class="item-info-col">
                                        <a href="<?php echo esc_url(home_url('/product/kash-natural-raj-ratan')); ?>" class="item-title">
                                            <?php esc_html_e('Kash Natural Raj Ratan – Sweet & Salty Mukhwas | Traditional Indian Mouth Freshener, 200g', 'kash-naturals'); ?>
                                        </a>
                                        <div class="item-price-strip">
                                            <del class="price-original">₹300.00</del>
                                            <span class="price-current">₹179.00</span>
                                            <span class="badge-saving"><?php esc_html_e('Save ₹121.00', 'kash-naturals'); ?></span>
                                        </div>
                                        <div class="item-tags">
                                            <span class="tag-meta"><i class="fa-solid fa-leaf"></i> 100% Vegetarian</span>
                                            <span class="tag-meta">200g Artisanal Jar</span>
                                        </div>
                                    </div>
                                    <div class="item-actions-col">
                                        <div class="kash-qty-selector">
                                            <button type="button" class="qty-btn btn-minus" data-action="decrease">&minus;</button>
                                            <span class="qty-value">1</span>
                                            <button type="button" class="qty-btn btn-plus" data-action="increase">&plus;</button>
                                        </div>
                                        <div class="item-subtotal">₹179.00</div>
                                        <button type="button" class="item-trash-btn" title="Remove Item" data-id="1">
                                            <i class="fa-regular fa-trash-can"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="kash-cart-item-row" data-id="2">
                                    <div class="item-thumb-col">
                                        <img src="<?php echo esc_url($theme_uri . '/assets/images/product-royal-mukhwas.jpg'); ?>" alt="Jamun Shots Mukhwas">
                                    </div>
                                    <div class="item-info-col">
                                        <a href="<?php echo esc_url(home_url('/shop')); ?>" class="item-title">
                                            <?php esc_html_e('Kash Natural – Jamun Shots Mukhwas | Premium Indian Mouth Freshener | Sweet & Tangy After-Meal Digestive', 'kash-naturals'); ?>
                                        </a>
                                        <div class="item-price-strip">
                                            <del class="price-original">₹300.00</del>
                                            <span class="price-current">₹179.00</span>
                                            <span class="badge-saving"><?php esc_html_e('Save ₹121.00', 'kash-naturals'); ?></span>
                                        </div>
                                        <div class="item-tags">
                                            <span class="tag-meta"><i class="fa-solid fa-leaf"></i> 100% Vegetarian</span>
                                            <span class="tag-meta">Real Jamun Pulp</span>
                                        </div>
                                    </div>
                                    <div class="item-actions-col">
                                        <div class="kash-qty-selector">
                                            <button type="button" class="qty-btn btn-minus" data-action="decrease">&minus;</button>
                                            <span class="qty-value">1</span>
                                            <button type="button" class="qty-btn btn-plus" data-action="increase">&plus;</button>
                                        </div>
                                        <div class="item-subtotal">₹179.00</div>
                                        <button type="button" class="item-trash-btn" title="Remove Item" data-id="2">
                                            <i class="fa-regular fa-trash-can"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="kash-cart-item-row" data-id="3">
                                    <div class="item-thumb-col">
                                        <img src="<?php echo esc_url($theme_uri . '/assets/images/jar-sweet-saunf.jpg'); ?>" alt="Gotli Tal Mukhwas">
                                    </div>
                                    <div class="item-info-col">
                                        <a href="<?php echo esc_url(home_url('/shop')); ?>" class="item-title">
                                            <?php esc_html_e('Kash Natural Gotli Tal Mukhwas, Crispy Salty Mix, 200g', 'kash-naturals'); ?>
                                        </a>
                                        <div class="item-price-strip">
                                            <del class="price-original">₹300.00</del>
                                            <span class="price-current">₹179.00</span>
                                            <span class="badge-saving"><?php esc_html_e('Save ₹121.00', 'kash-naturals'); ?></span>
                                        </div>
                                        <div class="item-tags">
                                            <span class="tag-meta"><i class="fa-solid fa-leaf"></i> 100% Vegetarian</span>
                                            <span class="tag-meta">Crispy Mango Kernels</span>
                                        </div>
                                    </div>
                                    <div class="item-actions-col">
                                        <div class="kash-qty-selector">
                                            <button type="button" class="qty-btn btn-minus" data-action="decrease">&minus;</button>
                                            <span class="qty-value">1</span>
                                            <button type="button" class="qty-btn btn-plus" data-action="increase">&plus;</button>
                                        </div>
                                        <div class="item-subtotal">₹179.00</div>
                                        <button type="button" class="item-trash-btn" title="Remove Item" data-id="3">
                                            <i class="fa-regular fa-trash-can"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="kash-cart-footer-nav">
                                <a href="<?php echo esc_url($shop_url); ?>" class="btn-return-shop">
                                    <i class="fa-solid fa-arrow-left"></i> <?php esc_html_e('Continue Shopping', 'kash-naturals'); ?>
                                </a>
                                <span class="return-shop-note"><?php esc_html_e('Packed fresh in sealed food-grade jars', 'kash-naturals'); ?></span>
                            </div>
                        </div>
                    </div>

                    <!-- Right: Order Summary Sidebar -->
                    <div class="kash-cart-sidebar-col">
                        <div class="kash-card-box kash-cart-summary-card">
                            <h2 class="kash-summary-title"><?php esc_html_e('Order Summary', 'kash-naturals'); ?></h2>

                            <!-- Coupon Code Box -->
                            <div class="cart-coupon-section">
                                <div class="coupon-box-input-wrap">
                                    <input type="text" id="cart-page-coupon-input" placeholder="<?php esc_attr_e('Promo code (e.g. KASH10)', 'kash-naturals'); ?>" />
                                    <button type="button" id="cart-page-btn-apply-coupon"><?php esc_html_e('Apply', 'kash-naturals'); ?></button>
                                </div>
                                <div id="cart-page-coupon-applied-msg" class="coupon-applied-pill" style="display:none;">
                                    <span><i class="fa-solid fa-ticket"></i> <strong>KASH10</strong> applied (10% OFF)</span>
                                    <button type="button" id="cart-page-btn-remove-coupon">&times;</button>
                                </div>
                            </div>

                            <!-- Calculations List -->
                            <div class="kash-summary-breakdown">
                                <div class="summary-row">
                                    <span><?php esc_html_e('Subtotal', 'kash-naturals'); ?></span>
                                    <span id="cart-page-subtotal-val" class="row-val">₹537.00</span>
                                </div>
                                <div class="summary-row discount-row" id="cart-page-discount-row" style="display:none;">
                                    <span><?php esc_html_e('Coupon Discount (10%)', 'kash-naturals'); ?></span>
                                    <span id="cart-page-discount-val" class="row-val discount-val">-₹0.00</span>
                                </div>
                                <div class="summary-row">
                                    <span><?php esc_html_e('Pan-India Priority Shipping', 'kash-naturals'); ?></span>
                                    <span id="cart-page-shipping-val" class="row-val">₹49.00</span>
                                </div>
                                <div class="summary-row savings-row">
                                    <span><?php esc_html_e('Catalog Discount Savings', 'kash-naturals'); ?></span>
                                    <span id="cart-page-savings-val" class="row-val savings-val">Save ₹363.00</span>
                                </div>
                                <div class="summary-total-row">
                                    <div>
                                        <span class="total-label"><?php esc_html_e('Estimated Total', 'kash-naturals'); ?></span>
                                        <span class="tax-note"><?php esc_html_e('Inclusive of all taxes & priority packing', 'kash-naturals'); ?></span>
                                    </div>
                                    <span id="cart-page-total-val" class="total-val">₹586.00</span>
                                </div>
                            </div>

                            <!-- Proceed to Checkout Button -->
                            <a href="<?php echo esc_url($checkout_url); ?>" class="btn-cart-proceed-checkout" id="btn-cart-page-checkout">
                                <i class="fa-solid fa-lock"></i> <?php esc_html_e('PROCEED TO CHECKOUT', 'kash-naturals'); ?>
                            </a>

                            <!-- Trust Seals -->
                            <div class="cart-summary-trust-seals">
                                <div class="seal-line"><i class="fa-solid fa-shield-halved"></i> <span>256-Bit SSL Bank Encrypted Checkout</span></div>
                                <div class="seal-line"><i class="fa-solid fa-leaf"></i> <span>100% Pure Natural Botanical Ingredients</span></div>
                                <div class="seal-line"><i class="fa-solid fa-box-open"></i> <span>Hygienically Sealed Fresh In Artisanal Jars</span></div>
                            </div>

                            <!-- Accepted Payment Icons Strip -->
                            <div class="cart-payment-methods-strip">
                                <span class="payment-methods-title"><?php esc_html_e('WE ACCEPT ALL SECURE PAYMENT MODES', 'kash-naturals'); ?></span>
                                <div class="payment-icons-row">
                                    <span class="pay-chip"><i class="fa-brands fa-google-pay"></i> GPay</span>
                                    <span class="pay-chip"><i class="fa-solid fa-mobile-screen"></i> PhonePe / UPI</span>
                                    <span class="pay-chip"><i class="fa-brands fa-cc-visa"></i> Visa</span>
                                    <span class="pay-chip"><i class="fa-brands fa-cc-mastercard"></i> Mastercard</span>
                                    <span class="pay-chip"><i class="fa-solid fa-hand-holding-dollar"></i> COD</span>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- Empty State (Hidden when items present) -->
                <div class="kash-empty-cart-box" id="kash-cart-empty-box" style="display: none;">
                    <div class="empty-icon"><i class="fa-solid fa-basket-shopping"></i></div>
                    <h2 class="empty-title"><?php esc_html_e('Your Shopping Bag is Empty', 'kash-naturals'); ?></h2>
                    <p class="empty-desc">
                        <?php esc_html_e('Looks like you haven\'t added any artisanal mouth fresheners, chocolate dragees, or digestive mixes yet.', 'kash-naturals'); ?>
                    </p>
                    <a href="<?php echo esc_url($shop_url); ?>" class="btn-empty-shop-now">
                        <?php esc_html_e('EXPLORE ARTISANAL SHOP', 'kash-naturals'); ?>
                    </a>
                </div>
                <?php
            }
            ?>
        </div>

    </div>
</section>

<!-- Client-side Cart Sync Script for live page calculations & local cart consistency -->
<script>
(function() {
    function initCartPage() {
        var cartContainer = document.getElementById('kash-standalone-cart');
        if (!cartContainer) return;

        var defaultDemoCart = [
            {
                id: 1,
                name: "Kash Natural Raj Ratan – Sweet & Salty Mukhwas | Traditional Indian Mouth Freshener, 200g",
                price: 179,
                regular_price: 300,
                qty: 1,
                image: "<?php echo esc_url($theme_uri . '/assets/images/jar-royal-mukhwas.jpg'); ?>",
                tags: ["100% Vegetarian", "200g Artisanal Jar"]
            },
            {
                id: 2,
                name: "Kash Natural – Jamun Shots Mukhwas | Premium Indian Mouth Freshener | Sweet & Tangy After-Meal Digestive",
                price: 179,
                regular_price: 300,
                qty: 1,
                image: "<?php echo esc_url($theme_uri . '/assets/images/product-royal-mukhwas.jpg'); ?>",
                tags: ["100% Vegetarian", "Real Jamun Pulp"]
            },
            {
                id: 3,
                name: "Kash Natural Gotli Tal Mukhwas, Crispy Salty Mix, 200g",
                price: 179,
                regular_price: 300,
                qty: 1,
                image: "<?php echo esc_url($theme_uri . '/assets/images/jar-sweet-saunf.jpg'); ?>",
                tags: ["100% Vegetarian", "Crispy Mango Kernels"]
            }
        ];

        // Retrieve existing cart or initialize with demo items if not present
        var cart = [];
        try {
            var raw = localStorage.getItem('kash_cart');
            if (raw) {
                cart = JSON.parse(raw);
            }
        } catch(e) {}

        if (!cart || cart.length === 0) {
            cart = defaultDemoCart;
            try {
                localStorage.setItem('kash_cart', JSON.stringify(cart));
            } catch(e) {}
        }

        var isCouponApplied = false;

        function renderCartPageUI() {
            var itemsListEl = document.getElementById('cart-page-items-list');
            var emptyBoxEl = document.getElementById('kash-cart-empty-box');
            var badgeCountEl = document.getElementById('cart-page-badge-count');
            var shippingCardEl = document.getElementById('kash-cart-shipping-card');

            if (!cart || cart.length === 0) {
                cartContainer.style.display = 'none';
                if (shippingCardEl) shippingCardEl.style.display = 'none';
                if (emptyBoxEl) emptyBoxEl.style.display = 'block';
                return;
            }

            cartContainer.style.display = 'grid';
            if (shippingCardEl) shippingCardEl.style.display = 'block';
            if (emptyBoxEl) emptyBoxEl.style.display = 'none';

            var totalCount = cart.reduce(function(sum, item) { return sum + (item.qty || 1); }, 0);
            if (badgeCountEl) badgeCountEl.textContent = totalCount + (totalCount === 1 ? ' Item' : ' Items');

            // Render items
            var html = '';
            var subtotal = 0;
            var totalSavings = 0;

            cart.forEach(function(item) {
                var qty = item.qty || 1;
                var price = parseFloat(item.price) || 179;
                var regularPrice = parseFloat(item.regular_price) || (price + 121);
                var lineTotal = price * qty;
                var savePerItem = regularPrice - price;
                subtotal += lineTotal;
                totalSavings += (savePerItem * qty);

                var imgUrl = item.image || "<?php echo esc_url($theme_uri . '/assets/images/jar-royal-mukhwas.jpg'); ?>";
                var tagsHtml = '';
                if (item.tags && Array.isArray(item.tags)) {
                    tagsHtml = item.tags.map(function(t) { return '<span class="tag-meta">' + t + '</span>'; }).join('');
                } else {
                    tagsHtml = '<span class="tag-meta"><i class="fa-solid fa-leaf"></i> 100% Vegetarian</span><span class="tag-meta">Artisanal Batch</span>';
                }

                html += '<div class="kash-cart-item-row" data-id="' + item.id + '">' +
                    '<div class="item-thumb-col">' +
                        '<img src="' + imgUrl + '" alt="' + item.name + '" />' +
                    '</div>' +
                    '<div class="item-info-col">' +
                        '<a href="<?php echo esc_url(home_url('/shop')); ?>" class="item-title">' + item.name + '</a>' +
                        '<div class="item-price-strip">' +
                            '<del class="price-original">₹' + (regularPrice * qty).toFixed(2) + '</del>' +
                            '<span class="price-current">₹' + lineTotal.toFixed(2) + '</span>' +
                            '<span class="badge-saving">Save ₹' + (savePerItem * qty).toFixed(2) + '</span>' +
                        '</div>' +
                        '<div class="item-tags">' + tagsHtml + '</div>' +
                    '</div>' +
                    '<div class="item-actions-col">' +
                        '<div class="kash-qty-selector">' +
                            '<button type="button" class="qty-btn btn-minus" data-id="' + item.id + '" data-action="decrease">&minus;</button>' +
                            '<span class="qty-value">' + qty + '</span>' +
                            '<button type="button" class="qty-btn btn-plus" data-id="' + item.id + '" data-action="increase">&plus;</button>' +
                        '</div>' +
                        '<div class="item-subtotal">₹' + lineTotal.toFixed(2) + '</div>' +
                        '<button type="button" class="item-trash-btn" title="Remove Item" data-id="' + item.id + '">' +
                            '<i class="fa-regular fa-trash-can"></i>' +
                        '</button>' +
                    '</div>' +
                '</div>';
            });

            if (itemsListEl) itemsListEl.innerHTML = html;

            // Free shipping calculation against ₹999 threshold
            var shippingThreshold = 999;
            var shippingFee = 49;
            var shippingTextEl = document.getElementById('kash-cart-shipping-text');
            var shippingFillEl = document.getElementById('kash-cart-shipping-fill');

            if (subtotal >= shippingThreshold) {
                shippingFee = 0;
                if (shippingTextEl) {
                    shippingTextEl.innerHTML = '<i class="fa-solid fa-circle-check" style="color: #27ae60;"></i> <span><strong>Congratulations!</strong> You have unlocked <strong>FREE Express Shipping</strong>!</span>';
                }
                if (shippingFillEl) shippingFillEl.style.width = '100%';
            } else {
                var needed = shippingThreshold - subtotal;
                var pct = Math.min(100, Math.round((subtotal / shippingThreshold) * 100));
                if (shippingTextEl) {
                    shippingTextEl.innerHTML = '<i class="fa-solid fa-truck-fast" style="color: #c68b27;"></i> <span>Add <strong>₹' + needed.toFixed(0) + '</strong> more to unlock <strong>FREE Express Shipping</strong>!</span>';
                }
                if (shippingFillEl) shippingFillEl.style.width = pct + '%';
            }

            // Summary Totals
            var discountVal = isCouponApplied ? (subtotal * 0.10) : 0;
            var finalTotal = subtotal - discountVal + shippingFee;

            var subtotalEl = document.getElementById('cart-page-subtotal-val');
            var shippingEl = document.getElementById('cart-page-shipping-val');
            var savingsEl = document.getElementById('cart-page-savings-val');
            var totalEl = document.getElementById('cart-page-total-val');
            var discountRow = document.getElementById('cart-page-discount-row');
            var discountValEl = document.getElementById('cart-page-discount-val');

            if (subtotalEl) subtotalEl.textContent = '₹' + subtotal.toFixed(2);
            if (shippingEl) shippingEl.textContent = (shippingFee === 0) ? 'FREE' : '₹' + shippingFee.toFixed(2);
            if (savingsEl) savingsEl.textContent = 'Save ₹' + totalSavings.toFixed(2);
            if (totalEl) totalEl.textContent = '₹' + finalTotal.toFixed(2);

            if (discountRow && discountValEl) {
                if (isCouponApplied) {
                    discountRow.style.display = 'flex';
                    discountValEl.textContent = '-₹' + discountVal.toFixed(2);
                } else {
                    discountRow.style.display = 'none';
                }
            }

            // Sync with global header badge if exists
            var headerBadge = document.getElementById('mini-cart-count');
            if (headerBadge) headerBadge.textContent = totalCount;
        }

        // Event delegation for qty change & trash
        cartContainer.addEventListener('click', function(e) {
            var target = e.target.closest('button');
            if (!target) return;

            var id = target.getAttribute('data-id');
            var action = target.getAttribute('data-action');

            if (action === 'increase' && id) {
                var item = cart.find(function(i) { return i.id == id; });
                if (item) {
                    item.qty = (item.qty || 1) + 1;
                    localStorage.setItem('kash_cart', JSON.stringify(cart));
                    renderCartPageUI();
                }
            } else if (action === 'decrease' && id) {
                var item = cart.find(function(i) { return i.id == id; });
                if (item) {
                    if (item.qty > 1) {
                        item.qty -= 1;
                    } else {
                        cart = cart.filter(function(i) { return i.id != id; });
                    }
                    localStorage.setItem('kash_cart', JSON.stringify(cart));
                    renderCartPageUI();
                }
            } else if (target.classList.contains('item-trash-btn') && id) {
                cart = cart.filter(function(i) { return i.id != id; });
                localStorage.setItem('kash_cart', JSON.stringify(cart));
                renderCartPageUI();
            }
        });

        // Clear Bag Button
        var clearBtn = document.getElementById('btn-cart-page-clear');
        if (clearBtn) {
            clearBtn.addEventListener('click', function() {
                if (confirm('Are you sure you want to remove all items from your bag?')) {
                    cart = [];
                    localStorage.setItem('kash_cart', JSON.stringify(cart));
                    renderCartPageUI();
                }
            });
        }

        // Coupon Handling
        var applyCouponBtn = document.getElementById('cart-page-btn-apply-coupon');
        var couponInput = document.getElementById('cart-page-coupon-input');
        var couponMsg = document.getElementById('cart-page-coupon-applied-msg');
        var removeCouponBtn = document.getElementById('cart-page-btn-remove-coupon');

        if (applyCouponBtn && couponInput) {
            applyCouponBtn.addEventListener('click', function() {
                var code = (couponInput.value || '').trim().toUpperCase();
                if (code === 'KASH10' || code === 'NATURAL10') {
                    isCouponApplied = true;
                    if (couponMsg) couponMsg.style.display = 'inline-flex';
                    couponInput.value = '';
                    renderCartPageUI();
                } else if (code) {
                    alert('Invalid coupon code. Try "KASH10" for 10% OFF!');
                }
            });
        }

        if (removeCouponBtn) {
            removeCouponBtn.addEventListener('click', function() {
                isCouponApplied = false;
                if (couponMsg) couponMsg.style.display = 'none';
                renderCartPageUI();
            });
        }

        // Initial Render
        renderCartPageUI();
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initCartPage);
    } else {
        initCartPage();
    }
})();
</script>

<?php
get_footer();
