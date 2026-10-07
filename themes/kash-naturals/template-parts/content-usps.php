<?php
/**
 * Brand USPs & Value Features Bar Template Part
 * Exact match to reference design layout (Left-aligned clean minimalist icons & typography)
 *
 * @package KashNaturals
 */

if (!defined('ABSPATH')) {
    exit;
}

$usps = array(
    array(
        'icon'  => 'fa-solid fa-seedling',
        'title' => '100% Natural Seeds',
        'desc'  => 'Hand-selected sweet saunf & premium spices with zero artificial preservatives.',
    ),
    array(
        'icon'  => 'fa-solid fa-fire-flame-curved',
        'title' => 'Fresh Batch Roasting',
        'desc'  => 'Roasted in small artisanal batches every week to lock in rich aroma & crisp taste.',
    ),
    array(
        'icon'  => 'fa-solid fa-mortar-pestle',
        'title' => 'Master Blended',
        'desc'  => 'Crafted by heritage blenders following royal digestive recipes passed down generations.',
    ),
    array(
        'icon'  => 'fa-solid fa-box-open',
        'title' => 'Royal Digestive Care',
        'desc'  => 'Freshly sealed in luxury glass jars & shipped safely right to your doorstep.',
    ),
);
?>

<section class="kash-usp-bar-section">
    <div class="container">
        <div class="kash-usp-grid">
            <?php foreach ($usps as $item) : ?>
                <div class="kash-usp-item">
                    <div class="kash-usp-icon">
                        <i class="<?php echo esc_attr($item['icon']); ?>"></i>
                    </div>
                    <h4 class="kash-usp-title"><?php echo esc_html($item['title']); ?></h4>
                    <p class="kash-usp-desc"><?php echo esc_html($item['desc']); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
