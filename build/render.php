<?php
/**
 * Render callback for Category Display for WooCommerce block.
 *
 * @param array    $attributes Block attributes.
 * @param string   $content    Block content.
 * @param WP_Block $block      Block instance.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Check if WooCommerce is active.
if ( ! class_exists( 'WooCommerce' ) ) {
	echo '<div class="cat-display-error">' . esc_html__( 'WooCommerce is not active.', 'category-display-for-woocommerce' ) . '</div>';
	return;
}

// Get block attributes with defaults — all prefixed with cat_display_block_.
$cat_display_block_layout     = isset( $attributes['layout'] ) ? $attributes['layout'] : 'grid';
$cat_display_block_columns    = isset( $attributes['columns'] ) ? (int) $attributes['columns'] : 3;
$cat_display_block_limit      = isset( $attributes['limit'] ) ? (int) $attributes['limit'] : 6;
$cat_display_block_show_all   = isset( $attributes['showAll'] ) ? (bool) $attributes['showAll'] : false;
$cat_display_block_order_by   = isset( $attributes['orderBy'] ) ? $attributes['orderBy'] : 'name';
$cat_display_block_order      = isset( $attributes['order'] ) ? $attributes['order'] : 'ASC';
$cat_display_block_show_count = isset( $attributes['showCount'] ) ? (bool) $attributes['showCount'] : false;
$cat_display_block_hide_empty = isset( $attributes['hideEmpty'] ) ? (bool) $attributes['hideEmpty'] : true;

// Query arguments.
$cat_display_block_args = array(
	'taxonomy'   => 'product_cat',
	'orderby'    => $cat_display_block_order_by,
	'order'      => $cat_display_block_order,
	'hide_empty' => $cat_display_block_hide_empty,
);

if ( ! $cat_display_block_show_all ) {
	$cat_display_block_args['number'] = $cat_display_block_limit;
}

$cat_display_block_categories = get_terms( $cat_display_block_args );

if ( empty( $cat_display_block_categories ) || is_wp_error( $cat_display_block_categories ) ) {
	echo '<div class="cat-display-empty">' . esc_html__( 'No categories found.', 'category-display-for-woocommerce' ) . '</div>';
	return;
}

/**
 * Render a single category item.
 *
 * @param object $cat_display_item_category   The category term object.
 * @param bool   $cat_display_item_show_count Whether to show product count.
 * @param string $cat_display_item_extra_class Extra CSS class (e.g. swiper-slide).
 * @return string HTML output.
 */
if ( ! function_exists( 'cat_display_woo_render_item' ) ) {
	function cat_display_woo_render_item( $cat_display_item_category, $cat_display_item_show_count = false, $cat_display_item_extra_class = '' ) {
		if ( ! isset( $cat_display_item_category->term_id ) ) {
			return '';
		}

		$cat_display_item_link = get_term_link( $cat_display_item_category->term_id, 'product_cat' );
		if ( is_wp_error( $cat_display_item_link ) ) {
			return '';
		}

		$cat_display_item_thumbnail_id = get_term_meta( $cat_display_item_category->term_id, 'thumbnail_id', true );
		$cat_display_item_image_url    = $cat_display_item_thumbnail_id
			? wp_get_attachment_url( $cat_display_item_thumbnail_id )
			: wc_placeholder_img_src();

		$cat_display_item_classes = array_filter( array( 'cat-display-item', $cat_display_item_extra_class ) );

		ob_start();
		?>
		<a href="<?php echo esc_url( $cat_display_item_link ); ?>" class="<?php echo esc_attr( implode( ' ', $cat_display_item_classes ) ); ?>">
			<div class="cat-display-image">
				<?php if ( $cat_display_item_image_url ) : ?>
					<img
						src="<?php echo esc_url( $cat_display_item_image_url ); ?>"
						alt="<?php echo esc_attr( $cat_display_item_category->name ); ?>"
						loading="lazy"
					/>
				<?php endif; ?>
			</div>
			<div class="cat-display-content">
				<h4 class="cat-display-title"><?php echo esc_html( $cat_display_item_category->name ); ?></h4>
				<?php if ( $cat_display_item_show_count ) : ?>
					<span class="cat-display-count">
						<?php
						echo esc_html(
							sprintf(
								/* translators: %s: number of products */
								_n( '%s Product', '%s Products', $cat_display_item_category->count, 'category-display-for-woocommerce' ),
								number_format_i18n( $cat_display_item_category->count )
							)
						);
						?>
					</span>
				<?php endif; ?>
			</div>
		</a>
		<?php
		return ob_get_clean();
	}
}

// Generate unique ID for this block instance.
$cat_display_block_id = 'cat-display-' . wp_unique_id();

// Wrapper classes.
$cat_display_block_wrapper_classes = array(
	'cat-display-block',
	'cat-display-layout-' . $cat_display_block_layout,
	'cat-display-cols-' . $cat_display_block_columns,
);

$cat_display_block_wrapper_attrs = get_block_wrapper_attributes(
	array(
		'class'        => implode( ' ', $cat_display_block_wrapper_classes ),
		'data-layout'  => $cat_display_block_layout,
		'data-columns' => (string) $cat_display_block_columns,
	)
);
?>

<div <?php echo $cat_display_block_wrapper_attrs; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- get_block_wrapper_attributes() returns safely escaped output. ?>>
	<?php if ( 'slider' === $cat_display_block_layout ) : ?>

		<div class="swiper" id="<?php echo esc_attr( $cat_display_block_id ); ?>">
			<div class="swiper-wrapper">
				<?php
				foreach ( $cat_display_block_categories as $cat_display_block_category ) {
					echo wp_kses_post( cat_display_woo_render_item( $cat_display_block_category, $cat_display_block_show_count, 'swiper-slide' ) );
				}
				?>
			</div>
			<div class="swiper-button-prev"></div>
			<div class="swiper-button-next"></div>
			<div class="swiper-pagination"></div>
		</div>

		<script>
		( function() {
			var cat_display_slider_id = '<?php echo esc_js( $cat_display_block_id ); ?>';
			function cat_display_init_slider() {
				if ( typeof Swiper === 'undefined' ) return;
				var cat_display_el = document.getElementById( cat_display_slider_id );
				if ( ! cat_display_el || cat_display_el.swiper ) return;
				new Swiper( cat_display_el, {
					slidesPerView: 1,
					spaceBetween: 20,
					loop: <?php echo count( $cat_display_block_categories ) > $cat_display_block_columns ? 'true' : 'false'; ?>,
					navigation: {
						nextEl: '#' + cat_display_slider_id + ' .swiper-button-next',
						prevEl: '#' + cat_display_slider_id + ' .swiper-button-prev',
					},
					pagination: {
						el: '#' + cat_display_slider_id + ' .swiper-pagination',
						clickable: true,
					},
					breakpoints: {
						640:  { slidesPerView: Math.min( 2, <?php echo (int) $cat_display_block_columns; ?> ) },
						768:  { slidesPerView: Math.min( 3, <?php echo (int) $cat_display_block_columns; ?> ) },
						1024: { slidesPerView: <?php echo (int) $cat_display_block_columns; ?> },
					},
				} );
			}
			if ( document.readyState === 'loading' ) {
				document.addEventListener( 'DOMContentLoaded', cat_display_init_slider );
			} else {
				cat_display_init_slider();
			}
		} )();
		</script>

	<?php else : ?>

		<div class="cat-display-grid">
			<?php
			foreach ( $cat_display_block_categories as $cat_display_block_category ) {
				echo wp_kses_post( cat_display_woo_render_item( $cat_display_block_category, $cat_display_block_show_count ) );
			}
			?>
		</div>

	<?php endif; ?>
</div>
