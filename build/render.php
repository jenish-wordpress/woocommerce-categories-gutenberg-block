<?php
/**
 * Render callback for WC Category Display block
 *
 * @param array    $attributes Block attributes
 * @param string   $content    Block content
 * @param WP_Block $block      Block instance
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Check if WooCommerce is active
if ( ! class_exists( 'WooCommerce' ) ) {
    return '<div class="wc-category-error">' . esc_html__( 'WooCommerce is not active.', 'wc-category-display' ) . '</div>';
}

// Get block attributes with defaults
$layout     = $attributes['layout'] ?? 'grid';
$columns    = $attributes['columns'] ?? 3;
$limit      = $attributes['limit'] ?? 6;
$show_all   = $attributes['showAll'] ?? false;
$order_by   = $attributes['orderBy'] ?? 'name';
$order      = $attributes['order'] ?? 'ASC';
$show_count = $attributes['showCount'] ?? false;
$hide_empty = $attributes['hideEmpty'] ?? true;

// Query arguments for getting categories
$args = array(
    'taxonomy'   => 'product_cat',
    'orderby'    => $order_by,
    'order'      => $order,
    'hide_empty' => $hide_empty,
);

if ( ! $show_all ) {
    $args['number'] = $limit;
}

$categories = get_terms( $args );

if ( empty( $categories ) || is_wp_error( $categories ) ) {
    return '<div class="wc-category-empty">' . esc_html__( 'No categories found.', 'wc-category-display' ) . '</div>';
}

// Helper function to render category item
if ( ! function_exists( 'wc_category_display_render_item' ) ) {
    function wc_category_display_render_item( $category, $show_count = false, $extra_class = '' ) {
        if ( ! isset( $category->term_id ) ) {
            return '';
        }

        $link = get_term_link( $category->term_id, 'product_cat' );
        if ( is_wp_error( $link ) ) {
            return '';
        }

        $thumbnail_id = get_term_meta( $category->term_id, 'thumbnail_id', true );
        $image_url = $thumbnail_id 
            ? wp_get_attachment_url( $thumbnail_id ) 
            : wc_placeholder_img_src();

        $item_classes = array( 'wc-cat-item', $extra_class );
        
        ob_start();
        ?>
        <a href="<?php echo esc_url( $link ); ?>" class="<?php echo esc_attr( implode( ' ', array_filter( $item_classes ) ) ); ?>">
            <div class="wc-cat-image">
                <?php if ( $image_url ) : ?>
                    <img 
                        src="<?php echo esc_url( $image_url ); ?>" 
                        alt="<?php echo esc_attr( $category->name ); ?>"
                        loading="lazy"
                    />
                <?php endif; ?>
            </div>
            <div class="wc-cat-content">
                <h4 class="wc-cat-title"><?php echo esc_html( $category->name ); ?></h4>
                <?php if ( $show_count ) : ?>
                    <span class="wc-cat-count">
                        <?php 
                        printf( 
                            _n( '%s Product', '%s Products', $category->count, 'wc-category-display' ),
                            number_format_i18n( $category->count )
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

// Generate unique ID for slider
$block_id = 'wc-cat-' . wp_unique_id();

// Wrapper classes
$wrapper_classes = array(
    'wc-category-block',
    'wc-cat-' . $layout,
    'wc-cat-cols-' . $columns,
);

$wrapper_attributes = get_block_wrapper_attributes( array(
    'class' => implode( ' ', $wrapper_classes ),
    'data-layout' => $layout,
    'data-columns' => $columns,
) );
?>

<div <?php echo $wrapper_attributes; ?>>
    <?php if ( $layout === 'slider' ) : ?>
        <!-- Slider Layout -->
        <div class="swiper" id="<?php echo esc_attr( $block_id ); ?>">
            <div class="swiper-wrapper">
                <?php foreach ( $categories as $category ) : 
                    echo wc_category_display_render_item( $category, $show_count, 'swiper-slide' );
                endforeach; ?>
            </div>
            
            <!-- Navigation -->
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
            
            <!-- Pagination -->
            <div class="swiper-pagination"></div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                if (typeof Swiper !== 'undefined') {
                    new Swiper('#<?php echo esc_js( $block_id ); ?>', {
                        slidesPerView: 1,
                        spaceBetween: 20,
                        loop: <?php echo count( $categories ) > $columns ? 'true' : 'false'; ?>,
                        navigation: {
                            nextEl: '#<?php echo esc_js( $block_id ); ?> .swiper-button-next',
                            prevEl: '#<?php echo esc_js( $block_id ); ?> .swiper-button-prev',
                        },
                        pagination: {
                            el: '#<?php echo esc_js( $block_id ); ?> .swiper-pagination',
                            clickable: true,
                        },
                        breakpoints: {
                            640: {
                                slidesPerView: Math.min(2, <?php echo (int) $columns; ?>),
                            },
                            768: {
                                slidesPerView: Math.min(3, <?php echo (int) $columns; ?>),
                            },
                            1024: {
                                slidesPerView: <?php echo (int) $columns; ?>,
                            },
                        },
                    });
                }
            });
        </script>

    <?php else : ?>
        <!-- Grid Layout -->
        <div class="wc-cat-grid-container">
            <?php foreach ( $categories as $category ) : 
                echo wc_category_display_render_item( $category, $show_count );
            endforeach; ?>
        </div>
    <?php endif; ?>
</div>