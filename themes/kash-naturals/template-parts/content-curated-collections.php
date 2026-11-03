<?php
/**
 * Curated 3-in-1-Row Collections Showcase Template Part
 * Displays 3 signature collection cards on an elegant light background
 *
 * @package KashNaturals
 */

if (!defined('ABSPATH')) {
    exit;
}

$is_enabled = (bool) get_theme_mod('kash_curated_enable', true);
if (!$is_enabled) {
    return;
}

$theme_uri = get_template_directory_uri();
$shop_url  = home_url('/shop');

$subheading = get_theme_mod('kash_curated_subheading', __('— SIGNATURE COLLECTIONS —', 'kash-naturals'));
$heading    = get_theme_mod('kash_curated_heading', __('Curated For The Royal Taste', 'kash-naturals'));
$desc       = get_theme_mod('kash_curated_desc', __('Explore our three signature pillars: authentic royal digestives, artisanal Belgian chocolates, and luxury celebration hampers.', 'kash-naturals'));

$default_cards = array(
    1 => array(
        'tag'         => __('BESTSELLER', 'kash-naturals'),
        'cat_slug'    => 'mukhwas',
        'title'       => __('Royal Artisanal Mukhwas', 'kash-naturals'),
        'desc'        => __('Centuries-old royal recipes crafted with 100% natural fennel, dry dates, betel leaves, and soothing herbs for wholesome digestion.', 'kash-naturals'),
        'image'       => $theme_uri . '/assets/images/mouth-fresheners.jpg',
        'btn_text'    => __('EXPLORE MUKHWAS', 'kash-naturals'),
        'badge_class' => 'badge-green',
        'badge_icon'  => 'fa-solid fa-leaf',
    ),
    2 => array(
        'tag'         => __('LUXURY TREATS', 'kash-naturals'),
        'cat_slug'    => 'chocolates',
        'title'       => __('Belgian Chocolate Dragees', 'kash-naturals'),
        'desc'        => __('Slow-roasted Californian almonds, hazelnuts, and pistachios richly coated in smooth artisanal Belgian milk and dark chocolate.', 'kash-naturals'),
        'image'       => $theme_uri . '/assets/images/chocolate-dragees.jpg',
        'btn_text'    => __('EXPLORE CHOCOLATES', 'kash-naturals'),
        'badge_class' => 'badge-brown',
        'badge_icon'  => 'fa-solid fa-cookie',
    ),
    3 => array(
        'tag'         => __('ROYAL GIFTING', 'kash-naturals'),
        'cat_slug'    => 'gift-hampers',
        'title'       => __('Curated Festive Hampers', 'kash-naturals'),
        'desc'        => __('Handcrafted celebration boxes and festive assortments packed with royal aroma and heritage flavors, perfect for memorable moments.', 'kash-naturals'),
        'image'       => $theme_uri . '/assets/images/gift-combos.jpg',
        'btn_text'    => __('EXPLORE HAMPERS', 'kash-naturals'),
        'badge_class' => 'badge-gold',
        'badge_icon'  => 'fa-solid fa-gift',
    ),
);

$cards = array();
for ($i = 1; $i <= 3; $i++) {
    $def = $default_cards[$i];

    $custom_cat   = get_theme_mod("kash_curated_card{$i}_cat", $def['cat_slug']);
    $custom_tag   = get_theme_mod("kash_curated_card{$i}_tag", $def['tag']);
    $custom_title = get_theme_mod("kash_curated_card{$i}_title", $def['title']);
    $custom_desc  = get_theme_mod("kash_curated_card{$i}_desc", $def['desc']);
    $custom_img   = get_theme_mod("kash_curated_card{$i}_image", '');
    $custom_btn   = get_theme_mod("kash_curated_card{$i}_btn_text", $def['btn_text']);
    $custom_url   = get_theme_mod("kash_curated_card{$i}_btn_url", '');

    $item_link  = !empty($custom_url) ? $custom_url : $shop_url;
    $count_info = '';
    $final_img  = !empty($custom_img) ? $custom_img : $def['image'];

    if (class_exists('WooCommerce') && !empty($custom_cat)) {
        $term = get_term_by('slug', $custom_cat, 'product_cat');
        if (!$term || is_wp_error($term)) {
            $term = get_term_by('name', $custom_cat, 'product_cat');
        }
        if ($term && !is_wp_error($term)) {
            if (empty($custom_url)) {
                $item_link = get_term_link($term);
            }
            if (empty($custom_img)) {
                $thumb_id = get_term_meta($term->term_id, 'thumbnail_id', true);
                if ($thumb_id) {
                    $wc_img = wp_get_attachment_url($thumb_id);
                    if ($wc_img) {
                        $final_img = $wc_img;
                    }
                }
            }
            $count_info = sprintf(_n('%s Item', '%s Items', $term->count, 'kash-naturals'), number_format_i18n($term->count));
        }
    }

    $cards[$i] = array(
        'tag'         => $custom_tag,
        'title'       => $custom_title,
        'desc'        => $custom_desc,
        'image'       => $final_img,
        'btn_text'    => $custom_btn,
        'link'        => $item_link,
        'count'       => $count_info,
        'badge_class' => $def['badge_class'],
        'badge_icon'  => $def['badge_icon'],
    );
}
?>

<!-- Curated 3-in-1-Row Collections Showcase -->
<section class="kash-curated-collections-section" aria-label="<?php esc_attr_e('Signature Collections', 'kash-naturals'); ?>">
    <div class="container">
        
        <!-- Section Header -->
        <div class="kash-curated-header text-center">
            <?php if (!empty($subheading)) : ?>
                <span class="kash-curated-eyebrow"><?php echo esc_html($subheading); ?></span>
            <?php endif; ?>

            <?php if (!empty($heading)) : ?>
                <h2 class="kash-curated-title"><?php echo esc_html($heading); ?></h2>
            <?php endif; ?>

            <?php if (!empty($desc)) : ?>
                <p class="kash-curated-desc"><?php echo esc_html($desc); ?></p>
            <?php endif; ?>
        </div>

        <!-- 3 Cards in 1 Row Grid -->
        <div class="kash-curated-grid">
            <?php foreach ($cards as $card) : ?>
                <div class="kash-curated-card">
                    <!-- Top Media Wrap -->
                    <div class="kash-curated-media">
                        <a href="<?php echo esc_url($card['link']); ?>" class="kash-curated-img-link" tabindex="-1" aria-hidden="true">
                            <img src="<?php echo esc_url($card['image']); ?>" alt="<?php echo esc_attr($card['title']); ?>" class="kash-curated-img" loading="lazy">
                        </a>

                        <?php if (!empty($card['tag'])) : ?>
                            <span class="kash-curated-tag"><?php echo esc_html($card['tag']); ?></span>
                        <?php endif; ?>

                        <!-- Overlapping Round Badge Emblem -->
                        <div class="kash-curated-badge <?php echo esc_attr($card['badge_class']); ?>" aria-hidden="true">
                            <i class="<?php echo esc_attr($card['badge_icon']); ?>"></i>
                        </div>
                    </div>

                    <!-- Card Content Body -->
                    <div class="kash-curated-body">
                        <h3 class="kash-curated-card-title">
                            <a href="<?php echo esc_url($card['link']); ?>">
                                <?php echo esc_html($card['title']); ?>
                            </a>
                        </h3>

                        <?php if (!empty($card['desc'])) : ?>
                            <p class="kash-curated-card-desc"><?php echo esc_html($card['desc']); ?></p>
                        <?php endif; ?>

                        <div class="kash-curated-footer">
                            <?php if (!empty($card['count'])) : ?>
                                <span class="kash-curated-count"><i class="fa-solid fa-layer-group"></i> <?php echo esc_html($card['count']); ?></span>
                            <?php endif; ?>

                            <a href="<?php echo esc_url($card['link']); ?>" class="kash-curated-btn">
                                <span><?php echo esc_html($card['btn_text']); ?></span>
                                <i class="fa-solid fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

    </div>
</section>
