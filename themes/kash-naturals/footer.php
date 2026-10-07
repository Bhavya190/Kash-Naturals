<?php
/**
 * The Centralized Global Footer for Kash Naturals Theme
 * Included across all site pages via get_footer()
 *
 * @package KashNaturals
 */

if (!defined('ABSPATH')) {
    exit;
}
?>
    </main><!-- #primary -->



    <!-- Main Global Site Footer -->
    <footer id="colophon" class="site-footer-exact">
        <div class="container footer-grid-5">

            <!-- Col 1: Brand Info -->
            <div class="footer-col brand-col">
                <div class="footer-logo">
                    <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/logo.png'); ?>" alt="<?php bloginfo('name'); ?>" class="footer-logo-img-white">
                </div>
                <p class="brand-desc-text">
                    Premium Mouth Fresheners,<br>
                    Chocolate Dragees &amp; Kunafa<br>
                    Delights crafted by nature
                </p>
                <div class="footer-social-icons">
                    <a href="#" aria-label="Facebook" class="social-icon-btn"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#" aria-label="Instagram" class="social-icon-btn"><i class="fa-brands fa-instagram"></i></a>
                    <a href="#" aria-label="WhatsApp" class="social-icon-btn"><i class="fa-brands fa-whatsapp"></i></a>
                    <a href="#" aria-label="Email" class="social-icon-btn"><i class="fa-solid fa-envelope"></i></a>
                </div>
            </div>

            <!-- Col 2: SHOP -->
            <div class="footer-col">
                <h4 class="footer-col-title"><?php esc_html_e('SHOP', 'kash-naturals'); ?></h4>
                <ul class="footer-nav-list">
                    <li><a href="<?php echo esc_url(home_url('/shop')); ?>"><?php esc_html_e('Mouth Fresheners', 'kash-naturals'); ?></a></li>
                    <li><a href="<?php echo esc_url(home_url('/shop')); ?>"><?php esc_html_e('Chocolate Dragees', 'kash-naturals'); ?></a></li>
                    <li><a href="<?php echo esc_url(home_url('/shop')); ?>"><?php esc_html_e('Kunafa Bars', 'kash-naturals'); ?></a></li>
                    <li><a href="<?php echo esc_url(home_url('/combos')); ?>"><?php esc_html_e('Gift Combos', 'kash-naturals'); ?></a></li>
                    <li><a href="<?php echo esc_url(home_url('/shop')); ?>"><?php esc_html_e('All Products', 'kash-naturals'); ?></a></li>
                </ul>
            </div>

            <!-- Col 3: HELP & INFO -->
            <div class="footer-col">
                <h4 class="footer-col-title"><?php esc_html_e('HELP & INFO', 'kash-naturals'); ?></h4>
                <ul class="footer-nav-list">
                    <li><a href="<?php echo esc_url(home_url('/shipping-policy')); ?>"><?php esc_html_e('Shipping Policy', 'kash-naturals'); ?></a></li>
                    <li><a href="<?php echo esc_url(home_url('/return-policy')); ?>"><?php esc_html_e('Return Policy', 'kash-naturals'); ?></a></li>
                    <li><a href="<?php echo esc_url(home_url('/privacy-policy')); ?>"><?php esc_html_e('Privacy Policy', 'kash-naturals'); ?></a></li>
                    <li><a href="<?php echo esc_url(home_url('/terms-and-conditions')); ?>"><?php esc_html_e('Terms & Conditions', 'kash-naturals'); ?></a></li>
                    <li><a href="<?php echo esc_url(home_url('/faqs')); ?>"><?php esc_html_e('FAQs', 'kash-naturals'); ?></a></li>

                </ul>
            </div>

            <!-- Col 4: ABOUT US -->
            <div class="footer-col">
                <h4 class="footer-col-title"><?php esc_html_e('ABOUT US', 'kash-naturals'); ?></h4>
                <ul class="footer-nav-list">
                    <li><a href="<?php echo esc_url(home_url('/about')); ?>"><?php esc_html_e('Our Story', 'kash-naturals'); ?></a></li>
                    <li><a href="<?php echo esc_url(home_url('/about')); ?>"><?php esc_html_e('Why Kash Natural', 'kash-naturals'); ?></a></li>
                    <li><a href="<?php echo esc_url(home_url('/about')); ?>"><?php esc_html_e('Quality Promise', 'kash-naturals'); ?></a></li>
                    <li><a href="<?php echo esc_url(home_url('/contact')); ?>"><?php esc_html_e('Contact Us', 'kash-naturals'); ?></a></li>
                </ul>
            </div>

            <!-- Col 5: CONTACT US -->
            <div class="footer-col contact-col">
                <h4 class="footer-col-title"><?php esc_html_e('CONTACT US', 'kash-naturals'); ?></h4>
                <ul class="footer-contact-list">
                    <li><i class="fa-solid fa-phone"></i> +91 98765 43210</li>
                    <li><i class="fa-solid fa-envelope"></i> info@kashnatural.com</li>
                    <li><i class="fa-solid fa-location-dot"></i> Pan India Delivery</li>
                </ul>
                <div class="footer-amazon-badge">
                    <a href="<?php echo esc_url(get_theme_mod('kash_amazon_shop_link', 'https://amazon.in')); ?>" target="_blank" rel="noopener noreferrer" class="amazon-footer-btn">
                        <span class="badge-subtext-white">Available on</span>
                        <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/amazon-logo-png.png'); ?>" alt="Amazon" class="amazon-footer-logo">
                    </a>
                </div>
            </div>

        </div>

        <!-- Footer Bottom Copyright -->
        <div class="footer-bottom-exact">
            <div class="container text-center">
                <p class="copyright-text-exact">
                    &copy; <?php echo esc_html(date('Y')); ?> Kash Natural. All Rights Reserved.
                </p>
            </div>
        </div>
    </footer>

    <!-- ==========================================
         GLOBAL INTERACTIVE MODALS & CART DRAWER
         ========================================== -->

    <!-- 1. LIVE SEARCH MODAL -->
    <div class="search-modal-overlay" id="search-modal">
        <div class="search-modal-container">
            <button class="close-modal-btn" id="close-search" aria-label="Close Search">&times;</button>
            
            <div class="search-modal-header text-center">
                <span class="search-badge-label">— INSTANT SEARCH —</span>
                <h3 class="search-modal-title">Search Artisan Chocolates &amp; Mukhwas</h3>
            </div>

            <!-- Search Input Box -->
            <div class="search-input-wrap">
                <i class="fa-solid fa-magnifying-glass search-input-icon"></i>
                <input type="search" id="live-search-field" class="search-input-field" placeholder="Type paan, kunafa, dragees, mukhwas, saunf..." autocomplete="off" autofocus />
                <button type="button" class="search-clear-btn" id="search-clear-btn" style="display:none;">&times;</button>
            </div>

            <!-- Category Quick Filter Pills -->
            <div class="search-cat-pills" id="search-cat-pills">
                <button type="button" class="search-pill active" data-cat="all">All Items</button>
                <button type="button" class="search-pill" data-cat="mouth-fresheners">Mouth Fresheners</button>
                <button type="button" class="search-pill" data-cat="chocolate-dragees">Chocolate Dragees</button>
                <button type="button" class="search-pill" data-cat="kunafa-bars">Kunafa Bars</button>
                <button type="button" class="search-pill" data-cat="gift-combos">Gift Combos</button>
            </div>

            <!-- Live Search Results Grid -->
            <div class="search-results-container" id="search-results-container">
                <div class="search-status-label" id="search-status-label">Explore our 16+ artisanal mouth fresheners &amp; chocolates...</div>
                <div class="search-results-grid" id="search-results-grid">
                    <!-- Populated dynamically via JS -->
                </div>
            </div>
        </div>
    </div>


    <!-- 2. MY ACCOUNT MODAL -->
    <div class="account-modal-overlay" id="account-modal">
        <div class="account-modal-container">
            <button class="close-modal-btn" id="close-account" aria-label="Close Account">&times;</button>

            <!-- AUTH STATE (Login / Register) -->
            <div class="account-view" id="account-auth-view">
                <div class="account-auth-tabs">
                    <button type="button" class="auth-tab-btn active" id="tab-login-btn">Sign In</button>
                    <button type="button" class="auth-tab-btn" id="tab-register-btn">Create Account</button>
                </div>

                <!-- Sign In Form -->
                <form id="form-login" class="account-form active">
                    <h3 class="auth-title">Welcome Back to Kash Natural</h3>
                    <p class="auth-sub">Access your orders, wishlist, and exclusive rewards.</p>

                    <div class="form-group-clean">
                        <label for="login-email">Email or Mobile Number</label>
                        <div class="input-icon-wrap">
                            <i class="fa-regular fa-envelope"></i>
                            <input type="email" id="login-email" class="form-control-clean" placeholder="name@example.com" required value="bhavya@kashnaturals.com" autocomplete="username" />
                        </div>
                    </div>

                    <div class="form-group-clean">
                        <label for="login-password">Password</label>
                        <div class="input-icon-wrap">
                            <i class="fa-solid fa-lock"></i>
                            <input type="password" id="login-password" class="form-control-clean" placeholder="••••••••" required value="password123" autocomplete="current-password" />
                        </div>
                    </div>

                    <div class="form-flex-row">
                        <label class="remember-label"><input type="checkbox" checked /> Remember Me</label>
                        <a href="#" class="forgot-link" onclick="alert('Password reset link sent to your registered email!'); return false;">Forgot Password?</a>
                    </div>

                    <button type="submit" class="btn-account-submit">
                        SIGN IN <i class="fa-solid fa-arrow-right"></i>
                    </button>

                    <div class="quick-demo-login-box">
                        <button type="button" class="btn-quick-demo-login" id="btn-quick-demo">
                            <i class="fa-solid fa-bolt"></i> Quick 1-Click Demo Login
                        </button>
                    </div>
                </form>

                <!-- Register Form -->
                <form id="form-register" class="account-form" style="display:none;">
                    <h3 class="auth-title">Create Your Kash Account</h3>
                    <p class="auth-sub">Join Kash Royal Club for 10% off your first order.</p>

                    <div class="form-group-clean">
                        <label for="reg-name">Full Name</label>
                        <div class="input-icon-wrap">
                            <i class="fa-regular fa-user"></i>
                            <input type="text" id="reg-name" class="form-control-clean" placeholder="Bhavya Sharma" required autocomplete="name" />
                        </div>
                    </div>

                    <div class="form-group-clean">
                        <label for="reg-email">Email Address</label>
                        <div class="input-icon-wrap">
                            <i class="fa-regular fa-envelope"></i>
                            <input type="email" id="reg-email" class="form-control-clean" placeholder="bhavya@example.com" required autocomplete="email" />
                        </div>
                    </div>

                    <div class="form-group-clean">
                        <label for="reg-phone">Phone Number</label>
                        <div class="input-icon-wrap">
                            <i class="fa-solid fa-phone"></i>
                            <input type="tel" id="reg-phone" class="form-control-clean" placeholder="+91 98765 43210" required autocomplete="tel" />
                        </div>
                    </div>

                    <div class="form-group-clean">
                        <label for="reg-password">Password</label>
                        <div class="input-icon-wrap">
                            <i class="fa-solid fa-lock"></i>
                            <input type="password" id="reg-password" class="form-control-clean" placeholder="Create strong password" required autocomplete="new-password" />
                        </div>
                    </div>

                    <button type="submit" class="btn-account-submit">
                        CREATE ACCOUNT <i class="fa-solid fa-user-plus"></i>
                    </button>
                </form>
            </div>

            <!-- DASHBOARD STATE (When Logged In) -->
            <div class="account-view" id="account-dashboard-view" style="display:none;">
                <div class="user-profile-header">
                    <div class="user-avatar-circle" id="user-avatar-initials">BS</div>
                    <div class="user-info-text">
                        <h3 class="user-display-name" id="dash-user-name">Bhavya Sharma</h3>
                        <p class="user-display-email" id="dash-user-email">bhavya@kashnaturals.com</p>
                        <span class="user-vip-badge"><i class="fa-solid fa-crown"></i> Kash Royal Gold Member</span>
                    </div>
                    <button type="button" class="btn-logout-clean" id="btn-logout" title="Sign Out">
                        <i class="fa-solid fa-right-from-bracket"></i> Logout
                    </button>
                </div>

                <!-- Dashboard Nav Tabs -->
                <div class="dash-nav-tabs">
                    <button type="button" class="dash-tab-btn active" data-dashtab="orders"><i class="fa-solid fa-box-archive"></i> My Orders</button>
                    <button type="button" class="dash-tab-btn" data-dashtab="addresses"><i class="fa-solid fa-location-dot"></i> Saved Address</button>
                    <button type="button" class="dash-tab-btn" data-dashtab="wishlist"><i class="fa-regular fa-heart"></i> Wishlist</button>
                </div>

                <!-- Tab 1: Orders -->
                <div class="dash-tab-content active" id="dashtab-orders">
                    <h4 class="dash-section-title">Recent Order History</h4>
                    <div class="orders-list-wrap" id="orders-list-wrap">
                        <!-- Populated dynamically via JS -->
                    </div>
                </div>

                <!-- Tab 2: Addresses -->
                <div class="dash-tab-content" id="dashtab-addresses" style="display:none;">
                    <h4 class="dash-section-title">Primary Delivery Address</h4>
                    <div class="saved-address-card">
                        <div class="address-tag-badge">PRIMARY ADDRESS</div>
                        <h4 class="addr-name" id="addr-display-name">Bhavya Sharma</h4>
                        <p class="addr-text" id="addr-display-text">Flat 402, Royal Residency, Park Street<br>New Delhi, Delhi - 110001</p>
                        <p class="addr-phone" id="addr-display-phone"><i class="fa-solid fa-phone"></i> +91 98765 43210</p>
                    </div>
                </div>

                <!-- Tab 3: Wishlist -->
                <div class="dash-tab-content" id="dashtab-wishlist" style="display:none;">
                    <h4 class="dash-section-title">My Saved Favorites</h4>
                    <div class="wishlist-grid" id="wishlist-grid">
                        <!-- Populated dynamically via JS -->
                    </div>
                </div>
            </div>

        </div>
    </div>


    <!-- 3. SLIDE-OVER CART DRAWER -->
    <div class="cart-drawer-overlay" id="cart-drawer-overlay"></div>
    <div class="cart-drawer-panel" id="cart-drawer">
        <div class="cart-drawer-header">
            <div class="cart-title-wrap">
                <i class="fa-solid fa-bag-shopping cart-header-icon"></i>
                <h3>Shopping Bag</h3>
                <span class="cart-badge-total" id="cart-drawer-count-badge">0 Items</span>
            </div>
            <button class="close-drawer-btn" id="close-cart-drawer" aria-label="Close Cart">&times;</button>
        </div>

        <!-- Free Shipping Threshold Progress Bar -->
        <div class="free-shipping-bar-wrap">
            <div class="shipping-bar-text" id="shipping-bar-text">Add ₹300 more for FREE shipping!</div>
            <div class="shipping-progress-track">
                <div class="shipping-progress-fill" id="shipping-progress-fill" style="width: 0%;"></div>
            </div>
        </div>

        <!-- Cart Items Body -->
        <div class="cart-drawer-body" id="cart-drawer-items-list">
            <!-- Rendered dynamically by JS -->
        </div>

        <!-- Cart Drawer Footer -->
        <div class="cart-drawer-footer">
            <!-- Coupon Input -->
            <div class="coupon-input-group">
                <input type="text" id="coupon-code-input" placeholder="Promo code (e.g. KASH10)" />
                <button type="button" id="btn-apply-coupon">Apply</button>
            </div>
            <div id="coupon-applied-tag" style="display:none;" class="coupon-success-msg">
                <span><i class="fa-solid fa-tag"></i> 'KASH10' applied (10% OFF)</span>
                <button type="button" id="btn-remove-coupon">&times;</button>
            </div>

            <!-- Price Breakdown -->
            <div class="cart-summary-totals">
                <div class="summary-line">
                    <span>Subtotal</span>
                    <span id="cart-subtotal-val">₹0</span>
                </div>
                <div class="summary-line discount-line" id="discount-summary-line" style="display:none;">
                    <span>Discount (10%)</span>
                    <span id="cart-discount-val">-₹0</span>
                </div>
                <div class="summary-line">
                    <span>Shipping</span>
                    <span id="cart-shipping-val">FREE</span>
                </div>
                <div class="summary-line total-line">
                    <span>Estimated Total</span>
                    <span id="cart-total-val">₹0</span>
                </div>
            </div>

            <!-- Action Buttons -->
            <button type="button" class="btn-checkout-drawer" id="btn-open-checkout">
                PROCEED TO CHECKOUT <i class="fa-solid fa-lock"></i>
            </button>
            <button type="button" class="btn-continue-shopping" id="btn-close-cart-continue">
                CONTINUE SHOPPING
            </button>
        </div>
    </div>


    <!-- 4. CHECKOUT MODAL -->
    <div class="checkout-modal-overlay" id="checkout-modal">
        <div class="checkout-modal-container">
            <button class="close-modal-btn" id="close-checkout" aria-label="Close Checkout">&times;</button>
            
            <div class="checkout-modal-header text-center">
                <span class="search-badge-label">— EXPRESS CHECKOUT —</span>
                <h3 class="checkout-modal-title">100% Safe &amp; Encrypted Order</h3>
            </div>

            <form id="checkout-form" class="checkout-form-grid">
                <div class="checkout-left-col">
                    <h4 class="checkout-step-title"><i class="fa-solid fa-truck"></i> 1. Shipping Details</h4>
                    <div class="form-grid-2">
                        <div class="form-group-clean">
                            <label>Full Name *</label>
                            <input type="text" id="chk-name" class="form-control-clean" placeholder="Bhavya Sharma" required value="Bhavya Sharma" />
                        </div>
                        <div class="form-group-clean">
                            <label>Phone Number *</label>
                            <input type="tel" id="chk-phone" class="form-control-clean" placeholder="+91 98765 43210" required value="+91 98765 43210" />
                        </div>
                    </div>
                    <div class="form-group-clean">
                        <label>Delivery Address *</label>
                        <input type="text" id="chk-address" class="form-control-clean" placeholder="House/Flat No., Building, Street Name" required value="Flat 402, Royal Residency, Park Street" />
                    </div>
                    <div class="form-grid-3">
                        <div class="form-group-clean">
                            <label>Pincode *</label>
                            <input type="text" id="chk-pin" class="form-control-clean" placeholder="110001" required value="110001" />
                        </div>
                        <div class="form-group-clean">
                            <label>City *</label>
                            <input type="text" id="chk-city" class="form-control-clean" placeholder="New Delhi" required value="New Delhi" />
                        </div>
                        <div class="form-group-clean">
                            <label>State *</label>
                            <input type="text" id="chk-state" class="form-control-clean" placeholder="Delhi" required value="Delhi" />
                        </div>
                    </div>

                    <h4 class="checkout-step-title mt-4"><i class="fa-solid fa-credit-card"></i> 2. Payment Method</h4>
                    <div class="payment-methods-selector">
                        <label class="payment-option active">
                            <input type="radio" name="payment_method" value="upi" checked />
                            <div class="pay-option-content">
                                <span class="pay-title"><i class="fa-solid fa-qrcode"></i> UPI Instant (GPay / PhonePe / Paytm)</span>
                                <span class="pay-sub">Fast &amp; 100% Secure Instant Payment</span>
                            </div>
                        </label>
                        <label class="payment-option">
                            <input type="radio" name="payment_method" value="cod" />
                            <div class="pay-option-content">
                                <span class="pay-title"><i class="fa-solid fa-money-bill-1-wave"></i> Cash on Delivery (COD)</span>
                                <span class="pay-sub">Pay cash when your parcel is delivered</span>
                            </div>
                        </label>
                        <label class="payment-option">
                            <input type="radio" name="payment_method" value="card" />
                            <div class="pay-option-content">
                                <span class="pay-title"><i class="fa-solid fa-credit-card"></i> Credit / Debit Card</span>
                                <span class="pay-sub">Visa, MasterCard, RuPay, Amex</span>
                            </div>
                        </label>
                    </div>
                </div>

                <div class="checkout-right-col">
                    <div class="order-summary-box">
                        <h4 class="checkout-step-title"><i class="fa-solid fa-receipt"></i> Order Summary</h4>
                        <div class="checkout-items-mini-list" id="checkout-items-mini">
                            <!-- Populated dynamically via JS -->
                        </div>
                        <div class="checkout-totals-wrap">
                            <div class="chk-line"><span>Subtotal</span><span id="chk-subtotal">₹0</span></div>
                            <div class="chk-line" id="chk-discount-row" style="display:none;"><span>Coupon Discount</span><span id="chk-discount">-₹0</span></div>
                            <div class="chk-line"><span>Cold Shipping</span><span id="chk-shipping">FREE</span></div>
                            <div class="chk-line chk-grand-total"><span>Grand Total</span><span id="chk-total">₹0</span></div>
                        </div>

                        <button type="submit" class="btn-place-order" id="btn-place-order">
                            CONFIRM &amp; PLACE ORDER <i class="fa-solid fa-circle-check"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <!-- 5. ORDER SUCCESS CONFIRMATION MODAL -->
    <div class="order-success-overlay" id="order-success-modal">
        <div class="order-success-card text-center">
            <div class="success-icon-wrap">
                <i class="fa-solid fa-circle-check"></i>
            </div>
            <h2 class="success-title">Order Placed Successfully! 🎉</h2>
            <p class="success-sub">Thank you for ordering with Kash Natural. Your order is being freshly prepared and packed.</p>
            
            <div class="order-details-pill-box">
                <div class="detail-pill">
                    <span class="label">ORDER NUMBER</span>
                    <span class="val" id="success-order-id">#KASH-9482</span>
                </div>
                <div class="detail-pill">
                    <span class="label">ESTIMATED DELIVERY</span>
                    <span class="val">2 - 3 Business Days</span>
                </div>
                <div class="detail-pill">
                    <span class="label">TOTAL PAID</span>
                    <span class="val" id="success-order-total">₹0</span>
                </div>
            </div>

            <button type="button" class="btn-success-done" id="btn-success-done">
                CONTINUE SHOPPING
            </button>
        </div>
    </div>


    <!-- 6. TOAST NOTIFICATION CONTAINER -->
    <div class="kash-toast-container" id="kash-toast-container"></div>

</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>
