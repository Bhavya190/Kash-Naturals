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

// Query Dynamic Product Categories from WooCommerce
if (class_exists('WooCommerce')) {
    $wc_cats = get_terms(array(
        'taxonomy'   => 'product_cat',
        'hide_empty' => false,
        'parent'     => 0,
        'exclude'    => array(get_option('default_product_cat')),
        'number'     => 4,
    ));

    if (!empty($wc_cats) && !is_wp_error($wc_cats)) {
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

        foreach ($wc_cats as $idx => $term) {
            $thumb_id = get_term_meta($term->term_id, 'thumbnail_id', true);
            $img_url = $thumb_id ? wp_get_attachment_url($thumb_id) : $default_cat_images[$idx % 4];
            $count_label = sprintf(_n('%s Item', '%s Items', $term->count, 'kash-naturals'), number_format_i18n($term->count));

            $style = $badge_styles[$idx % 4];

            $display_cats[] = array(
                'title'       => strtoupper($term->name),
                'subtitle'    => !empty($term->description) ? wp_trim_words($term->description, 6, '') : $count_label,
                'image'       => $img_url,
                'link'        => get_term_link($term),
                'badge_class' => $style['class'],
                'badge_icon'  => $style['icon'],
            );
        }
    }
}

// If no categories in WooCommerce, keep empty and display clean empty state notice
?>

<?php if (!empty($display_cats)) : ?>
<section class="section-padding home-category-showcase">
    <div class="container">
        <div class="category-cards-grid">
            <?php foreach ($display_cats as $cat) : ?>
                <div class="cat-exact-card">
                    <div class="cat-card-image-wrap">
                        <div class="cat-card-img-container">
                            <img src="<?php echo esc_url($cat['image']); ?>" alt="<?php echo esc_attr($cat['title']); ?>" class="cat-card-img" loading="lazy">
                        </div>
                        <div class="cat-card-badge <?php echo esc_attr($cat['badge_class']); ?>">
                            <i class="<?php echo esc_attr($cat['badge_icon']); ?>"></i>
                        </div>
                    </div>
                    <div class="cat-card-body">
                        <h3 class="cat-card-title"><?php echo esc_html($cat['title']); ?></h3>
                        <p class="cat-card-subtitle"><?php echo esc_html($cat['subtitle']); ?></p>
                        <a href="<?php echo esc_url($cat['link']); ?>" class="cat-card-shop-btn">
                            <?php esc_html_e('SHOP NOW', 'kash-naturals'); ?> <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
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
