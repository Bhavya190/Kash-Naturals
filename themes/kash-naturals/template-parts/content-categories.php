<?php
/**
 * Category Grid Showcase Template Part (Matches Image Design Exactly)
 *
 * @package KashNaturals
 */

if (!defined('ABSPATH')) {
    exit;
}

$theme_uri = get_template_directory_uri();
$shop_url = home_url('/shop');

$display_cats = array();

$badge_styles = array(
    array('class' => 'badge-green', 'icon' => 'fa-solid fa-leaf'),
    array('class' => 'badge-brown', 'icon' => 'fa-solid fa-cookie'),
    array('class' => 'badge-gold',  'icon' => 'fa-solid fa-layer-group'),
    array('class' => 'badge-green', 'icon' => 'fa-solid fa-gift'),
);

$default_cat_images = array(
    $theme_uri . '/assets/images/mouth-fresheners.jpg',
    $theme_uri . '/assets/images/chocolate-dragees.jpg',
    $theme_uri . '/assets/images/kunafa-bars.jpg',
    $theme_uri . '/assets/images/gift-combos.jpg',
);

// Check desired number of categories to show (from Customizer setting)
$max_cats = intval(get_theme_mod('kash_cats_count', 4));
if ($max_cats <= 0) {
    $max_cats = 4;
}

// Check if specific categories were chosen in Appearance > Customize
$custom_chosen_slugs = array();
for ($i = 1; $i <= $max_cats; $i++) {
    $slug = get_theme_mod("kash_cat_slot_{$i}");
    if ($slug === 'none') {
        continue;
    }
    if (!empty($slug)) {
        $custom_chosen_slugs[$i] = $slug;
    }
}

if (class_exists('WooCommerce')) {
    $hide_empty = (bool) get_theme_mod('kash_cats_hide_empty', false);

    // Case A: User explicitly picked 1 or more categories in WordPress Customizer
    if (!empty($custom_chosen_slugs)) {
        for ($slot = 1; $slot <= $max_cats; $slot++) {
            $slot_slug = isset($custom_chosen_slugs[$slot]) ? $custom_chosen_slugs[$slot] : '';
            if (empty($slot_slug) || $slot_slug === 'none') {
                continue;
            }
            $term = get_term_by('slug', $slot_slug, 'product_cat');
            if ($term && !is_wp_error($term)) {
                // If hide_empty is enabled and count is 0, skip
                if ($hide_empty && intval($term->count) === 0) {
                    continue;
                }

                $custom_img = get_theme_mod("kash_cat_image_{$slot}");
                $custom_title = get_theme_mod("kash_cat_title_{$slot}");

                $thumb_id = get_term_meta($term->term_id, 'thumbnail_id', true);
                if (!empty($custom_img)) {
                    $img_url = $custom_img;
                } elseif ($thumb_id) {
                    $img_url = wp_get_attachment_url($thumb_id);
                } else {
                    $img_url = $default_cat_images[($slot - 1) % 4];
                }

                $count_label = sprintf(_n('%s Item', '%s Items', $term->count, 'kash-naturals'), number_format_i18n($term->count));
                $style = $badge_styles[($slot - 1) % 4];

                $display_cats[] = array(
                    'title'       => !empty($custom_title) ? strtoupper($custom_title) : strtoupper($term->name),
                    'subtitle'    => !empty($term->description) ? wp_trim_words($term->description, 6, '') : $count_label,
                    'image'       => $img_url,
                    'link'        => get_term_link($term),
                    'badge_class' => $style['class'],
                    'badge_icon'  => $style['icon'],
                );
            }
        }
    }

    // Case B: If no categories were manually assigned in Customizer, auto-query from WooCommerce
    if (empty($display_cats)) {
        $wc_cats = get_terms(array(
            'taxonomy'   => 'product_cat',
            'hide_empty' => $hide_empty,
            'parent'     => 0,
            'exclude'    => array(get_option('default_product_cat')),
            'orderby'    => 'menu_order',
            'order'      => 'ASC',
            'number'     => $max_cats,
        ));

        if (!empty($wc_cats) && !is_wp_error($wc_cats)) {
            foreach ($wc_cats as $idx => $term) {
                $custom_img = get_theme_mod("kash_cat_image_" . ($idx + 1));
                $custom_title = get_theme_mod("kash_cat_title_" . ($idx + 1));

                $thumb_id = get_term_meta($term->term_id, 'thumbnail_id', true);
                if (!empty($custom_img)) {
                    $img_url = $custom_img;
                } elseif ($thumb_id) {
                    $img_url = wp_get_attachment_url($thumb_id);
                } else {
                    $img_url = $default_cat_images[$idx % 4];
                }

                $count_label = sprintf(_n('%s Item', '%s Items', $term->count, 'kash-naturals'), number_format_i18n($term->count));
                $style = $badge_styles[$idx % 4];

                $display_cats[] = array(
                    'title'       => !empty($custom_title) ? strtoupper($custom_title) : strtoupper($term->name),
                    'subtitle'    => !empty($term->description) ? wp_trim_words($term->description, 6, '') : $count_label,
                    'image'       => $img_url,
                    'link'        => get_term_link($term),
                    'badge_class' => $style['class'],
                    'badge_icon'  => $style['icon'],
                );
            }
        }
    }
}

$actual_cat_count = count($display_cats);
?>

<?php if (!empty($display_cats)) : ?>
<section class="home-category-circles-showcase" aria-label="<?php esc_attr_e('Product Collections', 'kash-naturals'); ?>">
    <div class="container">
        <!-- Scrollable track on mobile/tablet, centered flex on desktop -->
        <div class="kash-circle-cats-track cat-count-<?php echo intval($actual_cat_count); ?>">
            <?php foreach ($display_cats as $cat) : ?>
                <a href="<?php echo esc_url($cat['link']); ?>" class="kash-circle-cat-item" title="<?php echo esc_attr($cat['title']); ?>">
                    <!-- Circular Medium Image Container -->
                    <div class="kash-circle-cat-avatar">
                        <img src="<?php echo esc_url($cat['image']); ?>" alt="<?php echo esc_attr($cat['title']); ?>" class="circle-cat-img" loading="lazy">
                        
                        <!-- Desktop & Laptop Hover Overlay (Reveals Category Name on Hover) -->
                        <div class="kash-circle-cat-overlay" aria-hidden="true">
                            <span class="circle-cat-hover-name"><?php echo esc_html($cat['title']); ?></span>
                            <span class="circle-cat-hover-cta"><?php esc_html_e('SHOP NOW', 'kash-naturals'); ?> &rarr;</span>
                        </div>
                    </div>

                    <!-- Tablet & Mobile Category Label (Displayed Under the Circle) -->
                    <div class="kash-circle-cat-caption">
                        <span class="circle-cat-title"><?php echo esc_html($cat['title']); ?></span>
                        <?php if (!empty($cat['subtitle'])) : ?>
                            <span class="circle-cat-count"><?php echo esc_html($cat['subtitle']); ?></span>
                        <?php endif; ?>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php else : ?>
<section class="section-padding home-category-showcase">
    <div class="container">
        <div class="kash-empty-products-state text-center">
            <div class="empty-state-icon">
                <i class="fa-solid fa-layer-group"></i>
            </div>
            <h3 class="empty-state-title"><?php esc_html_e('No Collections Available', 'kash-naturals'); ?></h3>
            <p class="empty-state-desc"><?php esc_html_e('Product collections will appear here once categories are added in WooCommerce.', 'kash-naturals'); ?></p>
        </div>
    </div>
</section>
<?php endif; ?>
