<?php
/**
 * The Footer for Kash Naturals Theme
 *
 * @package KashNaturals
 */

if (!defined('ABSPATH')) {
    exit;
}
?>
    </main><!-- #primary -->

    <!-- Trust Badges Section -->
    <section class="trust-features-section">
        <div class="container trust-grid">
            <div class="trust-card">
                <div class="trust-icon"><i class="fa-solid fa-leaf"></i></div>
                <div class="trust-text">
                    <h4>100% Organic Cocoa</h4>
                    <p>Sustainably grown, non-GMO, zero artificial add-ons.</p>
                </div>
            </div>
            <div class="trust-card">
                <div class="trust-icon"><i class="fa-solid fa-handshake-simple"></i></div>
                <div class="trust-text">
                    <h4>Ethical Fair-Trade</h4>
                    <p>Directly supporting farming families in Ecuador & Ghana.</p>
                </div>
            </div>
            <div class="trust-card">
                <div class="trust-icon"><i class="fa-solid fa-snowflake"></i></div>
                <div class="trust-text">
                    <h4>Insulated Cold Shipping</h4>
                    <p>Temperature-managed delivery guarantees no melting.</p>
                </div>
            </div>
            <div class="trust-card">
                <div class="trust-icon"><i class="fa-solid fa-award"></i></div>
                <div class="trust-text">
                    <h4>Master Craftsmanship</h4>
                    <p>Small-batch stone-ground Belgian-style chocolatiering.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Footer (Exact Design Matching Screenshot) -->
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
                    <li><a href="#"><?php esc_html_e('Mouth Fresheners', 'kash-naturals'); ?></a></li>
                    <li><a href="#"><?php esc_html_e('Chocolate Dragees', 'kash-naturals'); ?></a></li>
                    <li><a href="#"><?php esc_html_e('Kunafa Bars', 'kash-naturals'); ?></a></li>
                    <li><a href="#"><?php esc_html_e('Gift Combos', 'kash-naturals'); ?></a></li>
                    <li><a href="#"><?php esc_html_e('All Products', 'kash-naturals'); ?></a></li>
                </ul>
            </div>

            <!-- Col 3: HELP & INFO -->
            <div class="footer-col">
                <h4 class="footer-col-title"><?php esc_html_e('HELP & INFO', 'kash-naturals'); ?></h4>
                <ul class="footer-nav-list">
                    <li><a href="<?php echo esc_url(home_url('/shipping-policy/')); ?>"><?php esc_html_e('Shipping Policy', 'kash-naturals'); ?></a></li>
                    <li><a href="<?php echo esc_url(home_url('/return-policy/')); ?>"><?php esc_html_e('Return Policy', 'kash-naturals'); ?></a></li>
                    <li><a href="<?php echo esc_url(home_url('/privacy-policy/')); ?>"><?php esc_html_e('Privacy Policy', 'kash-naturals'); ?></a></li>
                    <li><a href="<?php echo esc_url(home_url('/terms-and-conditions/')); ?>"><?php esc_html_e('Terms & Conditions', 'kash-naturals'); ?></a></li>
                    <li><a href="<?php echo esc_url(home_url('/contact/')); ?>"><?php esc_html_e('FAQs', 'kash-naturals'); ?></a></li>
                </ul>
            </div>

            <!-- Col 4: ABOUT US -->
            <div class="footer-col">
                <h4 class="footer-col-title"><?php esc_html_e('ABOUT US', 'kash-naturals'); ?></h4>
                <ul class="footer-nav-list">
                    <li><a href="<?php echo esc_url(home_url('/about/')); ?>"><?php esc_html_e('Our Story', 'kash-naturals'); ?></a></li>
                    <li><a href="<?php echo esc_url(home_url('/about/')); ?>"><?php esc_html_e('Why Kash Natural', 'kash-naturals'); ?></a></li>
                    <li><a href="<?php echo esc_url(home_url('/about/')); ?>"><?php esc_html_e('Quality Promise', 'kash-naturals'); ?></a></li>
                    <li><a href="<?php echo esc_url(home_url('/contact/')); ?>"><?php esc_html_e('Contact Us', 'kash-naturals'); ?></a></li>
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
                    &copy; <?php echo esc_html(date('Y')); ?> Kash Natural. All Rights Reserved.
                </p>
            </div>
        </div>
    </footer>

</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>
