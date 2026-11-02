<?php
/**
 * Newsletter Subscription System for Kash Naturals
 * Stores subscribers natively in WordPress under Custom Post Type `kash_subscriber`
 * Provides Admin List, Search, CSV Export, and AJAX Submission.
 *
 * @package KashNaturals
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * 1. Register Custom Post Type: kash_subscriber
 */
function kash_register_newsletter_subscriber_cpt() {
    $labels = array(
        'name'               => __('Subscribers', 'kash-naturals'),
        'singular_name'      => __('Subscriber', 'kash-naturals'),
        'menu_name'          => __('Newsletter Subscribers', 'kash-naturals'),
        'name_admin_bar'     => __('Subscriber', 'kash-naturals'),
        'add_new'            => __('Add Subscriber', 'kash-naturals'),
        'add_new_item'       => __('Add New Subscriber', 'kash-naturals'),
        'edit_item'          => __('Edit Subscriber', 'kash-naturals'),
        'new_item'           => __('New Subscriber', 'kash-naturals'),
        'view_item'          => __('View Subscriber', 'kash-naturals'),
        'search_items'       => __('Search Subscribers', 'kash-naturals'),
        'not_found'          => __('No subscribers found.', 'kash-naturals'),
        'not_found_in_trash' => __('No subscribers found in Trash.', 'kash-naturals'),
        'all_items'          => __('All Subscribers', 'kash-naturals'),
    );

    $args = array(
        'labels'              => $labels,
        'public'              => false,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'menu_position'       => 30,
        'menu_icon'           => 'dashicons-email-alt',
        'capability_type'     => 'post',
        'hierarchical'        => false,
        'supports'            => array('title'), // Title stores the subscriber's email
        'has_archive'         => false,
        'exclude_from_search' => true,
        'publicly_queryable'  => false,
    );

    register_post_type('kash_subscriber', $args);
}
add_action('init', 'kash_register_newsletter_subscriber_cpt');

/**
 * 2. Customize Admin Table Columns for Subscribers
 */
add_filter('manage_kash_subscriber_posts_columns', function($columns) {
    return array(
        'cb'         => $columns['cb'],
        'title'      => __('Subscriber Email', 'kash-naturals'),
        'sub_name'   => __('Name', 'kash-naturals'),
        'sub_coupon' => __('Issued Coupon', 'kash-naturals'),
        'sub_date'   => __('Date Subscribed', 'kash-naturals'),
        'sub_ip'     => __('IP Address', 'kash-naturals'),
    );
});

add_action('manage_kash_subscriber_posts_custom_column', function($column, $post_id) {
    switch ($column) {
        case 'sub_name':
            $name = get_post_meta($post_id, '_subscriber_name', true);
            echo !empty($name) ? esc_html($name) : '<span style="color:#999;">—</span>';
            break;
        case 'sub_coupon':
            $coupon = get_post_meta($post_id, '_subscriber_coupon', true);
            if (!empty($coupon)) {
                echo '<code style="background:#e8f4ea;color:#0a331a;font-weight:700;padding:3px 8px;border-radius:4px;border:1px solid #c2e2c6;">' . esc_html($coupon) . '</code>';
            } else {
                echo '—';
            }
            break;
        case 'sub_date':
            $date = get_post_meta($post_id, '_subscriber_date', true);
            if (!empty($date)) {
                echo esc_html(date_i18n(get_option('date_format') . ' ' . get_option('time_format'), strtotime($date)));
            } else {
                echo esc_html(get_the_date('', $post_id));
            }
            break;
        case 'sub_ip':
            $ip = get_post_meta($post_id, '_subscriber_ip', true);
            echo !empty($ip) ? esc_html($ip) : '—';
            break;
    }
}, 10, 2);

/**
 * 3. Make Columns Sortable
 */
add_filter('manage_edit-kash_subscriber_sortable_columns', function($columns) {
    $columns['sub_date'] = 'date';
    return $columns;
});

/**
 * 4. Add "Export to CSV" Button in WordPress Admin
 */
add_action('manage_posts_extra_tablenav', function($which) {
    global $typenow;
    if ($typenow === 'kash_subscriber' && $which === 'top') {
        $export_url = admin_url('admin-post.php?action=kash_export_subscribers&nonce=' . wp_create_nonce('kash_export_subscribers_nonce'));
        echo '<div class="alignleft actions">';
        echo '<a href="' . esc_url($export_url) . '" class="button button-primary" style="background:#0a331a;border-color:#0a331a;">';
        echo '<i class="dashicons dashicons-download" style="vertical-align:middle;margin-top:-2px;margin-right:4px;"></i> ' . esc_html__('Export to CSV', 'kash-naturals');
        echo '</a>';
        echo '</div>';
    }
});

/**
 * 5. Handle CSV Export Action
 */
add_action('admin_post_kash_export_subscribers', function() {
    if (!current_user_can('manage_options') || !isset($_GET['nonce']) || !wp_verify_nonce($_GET['nonce'], 'kash_export_subscribers_nonce')) {
        wp_die(esc_html__('Unauthorized request or security nonce expired.', 'kash-naturals'));
    }

    $filename = 'kash-naturals-subscribers-' . gmdate('Y-m-d') . '.csv';

    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    header('Pragma: no-cache');
    header('Expires: 0');

    $output = fopen('php://output', 'w');
    // Output column headers
    fputcsv($output, array('Email Address', 'Name', 'Issued Coupon', 'Date Subscribed', 'IP Address'));

    $subscribers = get_posts(array(
        'post_type'      => 'kash_subscriber',
        'post_status'    => 'publish',
        'posts_per_page' => -1,
        'orderby'        => 'date',
        'order'          => 'DESC',
    ));

    if (!empty($subscribers)) {
        foreach ($subscribers as $sub) {
            $email  = $sub->post_title;
            $name   = get_post_meta($sub->ID, '_subscriber_name', true);
            $coupon = get_post_meta($sub->ID, '_subscriber_coupon', true);
            $date   = get_post_meta($sub->ID, '_subscriber_date', true) ?: $sub->post_date;
            $ip     = get_post_meta($sub->ID, '_subscriber_ip', true);

            fputcsv($output, array($email, $name, $coupon, $date, $ip));
        }
    }

    fclose($output);
    exit;
});

/**
 * 6. AJAX Newsletter Subscribe Endpoint
 */
add_action('wp_ajax_kash_newsletter_subscribe', 'kash_handle_newsletter_subscribe');
add_action('wp_ajax_nopriv_kash_newsletter_subscribe', 'kash_handle_newsletter_subscribe');

function kash_handle_newsletter_subscribe() {
    // Check security nonce
    $nonce = isset($_POST['nonce']) ? sanitize_text_field($_POST['nonce']) : '';
    if (!wp_verify_nonce($nonce, 'kash_newsletter_nonce')) {
        wp_send_json_error(array(
            'message' => __('Security verification failed. Please reload the page and try again.', 'kash-naturals'),
        ));
    }

    // Sanitize and validate email
    $email = isset($_POST['email']) ? sanitize_email(trim($_POST['email'])) : '';
    if (empty($email) || !is_email($email)) {
        wp_send_json_error(array(
            'message' => __('Please provide a valid email address.', 'kash-naturals'),
        ));
    }

    $name = isset($_POST['name']) ? sanitize_text_field(trim($_POST['name'])) : '';
    $coupon = get_theme_mod('kash_newsletter_coupon', 'WELCOME10');
    if (empty($coupon)) {
        $coupon = 'WELCOME10';
    }

    // Check if email is already registered
    $existing = get_posts(array(
        'post_type'      => 'kash_subscriber',
        'post_status'    => 'publish',
        'title'          => $email,
        'posts_per_page' => 1,
    ));

    if (!empty($existing)) {
        wp_send_json_success(array(
            'message'     => __('Welcome back! You are already subscribed to our newsletter.', 'kash-naturals'),
            'coupon_code' => $coupon,
            'is_existing' => true,
        ));
    }

    // Create new subscriber post
    $post_id = wp_insert_post(array(
        'post_type'   => 'kash_subscriber',
        'post_title'  => $email,
        'post_status' => 'publish',
    ));

    if ($post_id && !is_wp_error($post_id)) {
        update_post_meta($post_id, '_subscriber_name', $name);
        update_post_meta($post_id, '_subscriber_email', $email);
        update_post_meta($post_id, '_subscriber_coupon', $coupon);
        update_post_meta($post_id, '_subscriber_date', current_time('mysql'));
        update_post_meta($post_id, '_subscriber_ip', sanitize_text_field($_SERVER['REMOTE_ADDR'] ?? ''));

        wp_send_json_success(array(
            'message'     => __('Thank you for subscribing! Your discount code is ready.', 'kash-naturals'),
            'coupon_code' => $coupon,
            'is_existing' => false,
        ));
    } else {
        wp_send_json_error(array(
            'message' => __('Could not save subscription. Please try again later.', 'kash-naturals'),
        ));
    }
}
