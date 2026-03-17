<?php
/**
 * Plugin Name:       Category Display for WooCommerce
 * Description:       Display product categories in beautiful grid or slider layouts. Native Gutenberg block with live editor preview.
 * Version:           1.0.0
 * Requires at least: 6.0
 * Requires PHP:      7.4
 * Author:            Jenish Dholakiya
 * Author URI:        https://github.com/jenish-wordpress
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       category-display-for-woocommerce
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'CAT_DISPLAY_WOO_VERSION', '1.0.0' );
define( 'CAT_DISPLAY_WOO_DIR', plugin_dir_path( __FILE__ ) );
define( 'CAT_DISPLAY_WOO_URL', plugin_dir_url( __FILE__ ) );

/**
 * Register the block.
 */
function cat_display_woo_register_block() {
	register_block_type( CAT_DISPLAY_WOO_DIR . 'build' );
}
add_action( 'init', 'cat_display_woo_register_block' );

/**
 * Enqueue frontend assets.
 * Swiper is bundled locally in /assets/.
 */
function cat_display_woo_enqueue_assets() {
	wp_enqueue_style(
		'cat-display-woo-swiper',
		CAT_DISPLAY_WOO_URL . 'assets/swiper-bundle.min.css',
		array(),
		'11.0.0'
	);

	wp_enqueue_script(
		'cat-display-woo-swiper',
		CAT_DISPLAY_WOO_URL . 'assets/swiper-bundle.min.js',
		array(),
		'11.0.0',
		true
	);

	wp_enqueue_script(
		'cat-display-woo-frontend',
		CAT_DISPLAY_WOO_URL . 'assets/frontend.js',
		array( 'cat-display-woo-swiper' ),
		CAT_DISPLAY_WOO_VERSION,
		true
	);

	wp_enqueue_style(
		'cat-display-woo-extra',
		CAT_DISPLAY_WOO_URL . 'assets/style.css',
		array(),
		CAT_DISPLAY_WOO_VERSION
	);
}
add_action( 'wp_enqueue_scripts', 'cat_display_woo_enqueue_assets' );
