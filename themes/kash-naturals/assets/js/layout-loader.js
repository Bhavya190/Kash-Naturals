/**
 * Kash Natural - Single Centralized Layout Loader
 * Loads Noticebar, Header, and Footer across all pages seamlessly
 * Matches exact design from Image 2 screenshot
 */

(function () {
    'use strict';

    const noticeBarHTML = `
    <div class="top-notice-bar">
        <div class="notice-bar-container">
            <div class="notice-bar-item"><i class="fa-solid fa-leaf"></i> <span>Natural Ingredients</span></div>
            <div class="notice-bar-item"><i class="fa-solid fa-spa"></i> <span>Hygienically Manufactured</span></div>
            <div class="notice-bar-item"><i class="fa-solid fa-truck-fast"></i> <span>Pan India Delivery</span></div>
            <div class="notice-bar-item"><i class="fa-brands fa-amazon"></i> <span>Available on Amazon</span></div>
        </div>
    </div>`;

    const headerHTML = `
    <header class="site-header">
        <div class="header-container">
            <div class="site-branding">
                <a href="/" class="brand-image-logo">
                    <img src="/wp-content/themes/kash-naturals/assets/images/logo.png" alt="Kash Natural" class="site-logo-img">
                </a>
            </div>
            <nav class="main-navigation">
                <ul class="nav-menu-list">
                    <li id="nav-home"><a href="/">HOME</a></li>
                    <li id="nav-shop" class="menu-item-has-children"><a href="/shop">SHOP <i class="fa-solid fa-chevron-down nav-chevron"></i></a></li>
                    <li id="nav-combos"><a href="/#combos">COMBOS</a></li>
                    <li id="nav-about"><a href="/about">ABOUT US</a></li>
                    <li id="nav-contact"><a href="/contact">CONTACT US</a></li>
                </ul>
            </nav>
            <div class="header-actions">
                <button class="action-btn-clean" title="Search"><i class="fa-solid fa-magnifying-glass"></i></button>
                <button class="action-btn-clean" title="Account"><i class="fa-regular fa-user"></i></button>
                <a href="/cart" class="action-btn-clean cart-btn-badge" title="Cart">
                    <i class="fa-solid fa-bag-shopping"></i>
                    <span class="cart-count">0</span>
                </a>
            </div>
        </div>
    </header>`;

    const footerHTML = `
    <footer class="site-footer-exact">
        <div class="container footer-grid-5">

            <!-- Col 1: Brand Info -->
            <div class="footer-col brand-col">
                <div class="footer-logo">
                    <img src="/wp-content/themes/kash-naturals/assets/images/logo.png" alt="Kash Natural" class="footer-logo-img-white">
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
                <h4 class="footer-col-title">SHOP</h4>
                <ul class="footer-nav-list">
                    <li><a href="/shop?category=mouth-fresheners">Mouth Fresheners</a></li>
                    <li><a href="/shop?category=chocolate-dragees">Chocolate Dragees</a></li>
                    <li><a href="/shop?category=kunafa-bars">Kunafa Bars</a></li>
                    <li><a href="/shop?category=gift-combos">Gift Combos</a></li>
                    <li><a href="/shop">All Products</a></li>
                </ul>
            </div>

            <!-- Col 3: HELP & INFO -->
            <div class="footer-col">
                <h4 class="footer-col-title">HELP &amp; INFO</h4>
                <ul class="footer-nav-list">
                    <li><a href="/shipping-policy">Shipping Policy</a></li>
                    <li><a href="/return-policy">Return Policy</a></li>
                    <li><a href="/privacy-policy">Privacy Policy</a></li>
                    <li><a href="/terms-and-conditions">Terms &amp; Conditions</a></li>
                    <li><a href="/contact">FAQs</a></li>
                </ul>
            </div>

            <!-- Col 4: ABOUT US -->
            <div class="footer-col">
                <h4 class="footer-col-title">ABOUT US</h4>
                <ul class="footer-nav-list">
                    <li><a href="/about">Our Story</a></li>
                    <li><a href="/about">Why Kash Natural</a></li>
                    <li><a href="/about">Quality Promise</a></li>
                    <li><a href="/contact">Contact Us</a></li>
                </ul>
            </div>

            <!-- Col 5: CONTACT US -->
            <div class="footer-col contact-col">
                <h4 class="footer-col-title">CONTACT US</h4>
                <ul class="footer-contact-list">
                    <li><i class="fa-solid fa-phone"></i> +91 98765 43210</li>
                    <li><i class="fa-solid fa-envelope"></i> info@kashnatural.com</li>
                    <li><i class="fa-solid fa-location-dot"></i> Pan India Delivery</li>
                </ul>
                <div class="footer-amazon-badge">
                    <a href="https://amazon.in" target="_blank" rel="noopener noreferrer" class="amazon-footer-btn">
                        <span class="badge-subtext-white">Available on</span>
                        <img src="https://upload.wikimedia.org/wikipedia/commons/a/a9/Amazon_logo.svg" alt="Amazon" class="amazon-footer-logo">
                    </a>
                </div>
            </div>

        </div>

        <!-- Footer Bottom Copyright -->
        <div class="footer-bottom-exact">
            <div class="container text-center">
                <p class="copyright-text-exact">
                    &copy; 2026 Kash Natural. All Rights Reserved.
                </p>
            </div>
        </div>
    </footer>`;

    function loadLayout() {
        // Inject Notice Bar if placeholder exists
        const noticeTarget = document.getElementById('kash-noticebar');
        if (noticeTarget) {
            noticeTarget.outerHTML = noticeBarHTML;
        }

        // Inject Header if placeholder exists
        const headerTarget = document.getElementById('kash-header');
        if (headerTarget) {
            headerTarget.outerHTML = headerHTML;
        }

        // Inject Footer if placeholder exists
        const footerTarget = document.getElementById('kash-footer');
        if (footerTarget) {
            footerTarget.outerHTML = footerHTML;
        }

        // Set Active Menu Link based on URL
        const currentPath = window.location.pathname.replace(/\/$/, "");
        if (currentPath.endsWith('/about') || currentPath.endsWith('/about.html')) {
            document.getElementById('nav-about')?.classList.add('active', 'current-menu-item');
        } else if (currentPath.endsWith('/contact') || currentPath.endsWith('/contact.html')) {
            document.getElementById('nav-contact')?.classList.add('active', 'current-menu-item');
        } else if (currentPath.endsWith('/shop') || currentPath.endsWith('/shop.html')) {
            document.getElementById('nav-shop')?.classList.add('active', 'current-menu-item');
        } else if (currentPath === '' || currentPath === '/index' || currentPath === '/index.html') {
            document.getElementById('nav-home')?.classList.add('active', 'current-menu-item');
        }
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', loadLayout);
    } else {
        loadLayout();
    }
})();
