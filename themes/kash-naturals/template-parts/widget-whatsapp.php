<?php
/**
 * Universal Floating WhatsApp Chat Widget Template Part
 * Included in footer.php across all pages of the website
 *
 * @package KashNaturals
 */

if (!defined('ABSPATH')) {
    exit;
}

$is_enabled = (bool) get_theme_mod('kash_whatsapp_enable', true);
if (!$is_enabled) {
    return;
}

$raw_phone = get_theme_mod('kash_whatsapp_number', '+91 98765 43210');
// Extract only digits for international wa.me standard format
$clean_phone = preg_replace('/[^0-9]/', '', $raw_phone);

// If phone starts with 0 and has 11 digits (local with leading zero), strip leading 0
if (strlen($clean_phone) === 11 && substr($clean_phone, 0, 1) === '0') {
    $clean_phone = substr($clean_phone, 1);
}

// Fallback if empty
if (empty($clean_phone)) {
    $clean_phone = '919876543210';
}

$message   = get_theme_mod('kash_whatsapp_message', __('Hello Kash Naturals! I have an inquiry about your artisanal mukhwas and products.', 'kash-naturals'));
$tooltip   = get_theme_mod('kash_whatsapp_tooltip', __('Chat with us', 'kash-naturals'));
$position  = get_theme_mod('kash_whatsapp_position', 'right');
$pos_class = ($position === 'left') ? 'pos-left' : 'pos-right';

$wa_url = 'https://wa.me/' . esc_attr($clean_phone);
if (!empty($message)) {
    $wa_url .= '?text=' . rawurlencode($message);
}
?>

<!-- Universal Floating WhatsApp Chat Widget -->
<aside class="kash-whatsapp-widget <?php echo esc_attr($pos_class); ?>" aria-label="<?php esc_attr_e('WhatsApp Customer Support', 'kash-naturals'); ?>">
    <?php if (!empty($tooltip)) : ?>
        <a href="<?php echo esc_url($wa_url); ?>" 
           target="_blank" 
           rel="noopener noreferrer" 
           class="kash-whatsapp-pill"
           title="<?php echo esc_attr($tooltip); ?>">
            <span class="kash-wa-dot"></span>
            <span class="kash-wa-pill-text"><?php echo esc_html($tooltip); ?></span>
        </a>
    <?php endif; ?>

    <a href="<?php echo esc_url($wa_url); ?>" 
       target="_blank" 
       rel="noopener noreferrer" 
       class="kash-whatsapp-btn" 
       aria-label="<?php esc_attr_e('Chat with Kash Naturals on WhatsApp', 'kash-naturals'); ?>"
       title="<?php esc_attr_e('Chat with us on WhatsApp', 'kash-naturals'); ?>">
        <i class="fa-brands fa-whatsapp"></i>
        <span class="kash-wa-status-badge" aria-hidden="true"></span>
    </a>
</aside>
