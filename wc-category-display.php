<?php
/**
 * Plugin Name:       WC Category Display
 * Description:       Display WooCommerce categories in grid or slider layout with customizable options.
 * Version:           1.0.0
 * Requires at least: 6.0
 * Requires PHP:      7.4
 * Author:            Jenish
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       wc-category-display
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

/**
 * Register the block
 */
function wc_category_display_register_block() {
    register_block_type( __DIR__ . '/build' );
}
add_action( 'init', 'wc_category_display_register_block' );

/**
 * Enqueue frontend styles and scripts
 */
function wc_category_display_enqueue_assets() {
    // Enqueue Swiper CSS and JS for slider layout
    wp_enqueue_style( 
        'swiper-css', 
        'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css',
        array(),
        '11.0.0'
    );
    
    wp_enqueue_script( 
        'swiper-js', 
        'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js',
        array(),
        '11.0.0',
        true
    );

    // Enqueue custom frontend script
    wp_enqueue_script(
        'wc-category-display-frontend',
        plugins_url( 'assets/frontend.js', __FILE__ ),
        array( 'swiper-js' ),
        '1.0.0',
        true
    );

    // Enqueue custom styles
    wp_enqueue_style(
        'wc-category-display-style',
        plugins_url( 'assets/style.css', __FILE__ ),
        array(),
        '1.0.0'
    );
}
add_action( 'wp_enqueue_scripts', 'wc_category_display_enqueue_assets' );