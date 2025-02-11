<?php

/**
 * Plugin Name: WooCommerce Manufacturer Field
 * Description: Plugin for adding a "Manufacturer" field to WooCommerce products
 * Author:      me & Copilot
 *
 * Version:     1.0
 */
 
if (!defined('ABSPATH')) {
    exit; // Direct access protection
}

// Adding a "Manufacturer" field to the product edit page
add_action('woocommerce_product_options_general_product_data', 'wcmf_add_custom_field');
function wcmf_add_custom_field() {
    woocommerce_wp_text_input(array(
        'id' => 'wcmf_manufacturer',
        'label' => __('Manufacturer', 'woocommerce'),
        'desc_tip' => 'true',
        'description' => __('Enter manufacturer name', 'woocommerce'),
    ));
}

// Saving the value of the "Manufacturer" field
add_action('woocommerce_process_product_meta', 'wcmf_save_custom_field');
function wcmf_save_custom_field($post_id) {
    $manufacturer = isset($_POST['wcmf_manufacturer']) ? sanitize_text_field($_POST['wcmf_manufacturer']) : '';
    update_post_meta($post_id, 'wcmf_manufacturer', $manufacturer);
}

// Displaying the "Manufacturer" field value on the product page
add_action('woocommerce_single_product_summary', 'wcmf_display_custom_field', 25);
function wcmf_display_custom_field() {
    global $post;
    $manufacturer = get_post_meta($post->ID, 'wcmf_manufacturer', true);
    if (!empty($manufacturer)) {
        echo '<p><strong>' . __('Manufacturer', 'woocommerce') . ':</strong> ' . esc_html($manufacturer) . '</p>';
    }
}
 