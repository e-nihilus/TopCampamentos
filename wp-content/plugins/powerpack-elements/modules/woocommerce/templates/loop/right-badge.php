<?php
/**
 * PowerPack WooCommerce Products - Sale Badge.
 *
 * @package PowerPack
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

global $post, $product;

$sale_badge_position = $settings['sale_badge_position'];
$featured_badge_position = $settings['featured_badge_position'];
$top_rating_badge_position = $settings['top_rating_badge_position'];
$best_selling_badge_position = $settings['best_selling_badge_position'];
$badge_text = esc_html__( 'Sale!', 'powerpack' );
$badge_text = apply_filters( 'woocommerce_sale_flash', $badge_text, $post, $product );

if ( 'right' === $sale_badge_position ) {

	if ( '' !== $settings['sale_badge_custom_text'] ) {

		if ( 'variable' === $product->get_type() ) {
			$regular_price = $product->get_variation_regular_price();
		} else {
			$regular_price = $product->get_regular_price();
		}

		if ( 'variable' === $product->get_type() ) {
			$sale_price = $product->get_variation_sale_price();
		} else {
			$sale_price = $product->get_sale_price();
		}

		$badge_text = $settings['sale_badge_custom_text'];
		if ( $sale_price ) {
			$percent_sale = round( ( ( ( $regular_price - $sale_price ) / $regular_price ) * 100 ), 0 );
			$badge_text   = $badge_text ? $badge_text : '-[value]%';
			$badge_text   = str_replace( '[value]', $percent_sale, $badge_text );
		}

		if ( 'grouped' === $product->get_type() ) {
			if ( $badge_text ) {
				$badge_text = $settings['sale_badge_custom_text'];
			}
		}
	};

	if ( $product->is_on_sale() ) :

		$sale_badge = sprintf( '<div class="pp-right-badge-wrap"><span class="pp-right-badge pp-sale-badge">%s</span></div>', wp_kses_post( $badge_text ) );
		echo wp_kses_post( apply_filters( 'pp_woo_products_sale_flash', $sale_badge, $post, $product ) );

	endif;
}

if ( 'right' === $featured_badge_position ) {

	$badge_text = esc_html__( 'New', 'powerpack' );

	if ( '' !== $settings['featured_badge_custom_text'] ) {
		$badge_text = $settings['featured_badge_custom_text'];
	}

	if ( $product->is_featured() ) : ?>

		<?php echo wp_kses_post( apply_filters( 'pp_woo_products_featured_flash', '<div class="pp-right-badge-wrap"><span class="pp-right-badge pp-featured-badge">' . wp_kses_post( $badge_text ) . '</span></div>', $post, $product ) ); ?>

	<?php endif;
}

if ( 'right' === $top_rating_badge_position ) {

	$badge_text = esc_html__( 'Top Rated', 'powerpack' );

	if ( '' !== $settings['top_rating_badge_custom_text'] ) {
		$badge_text = $settings['top_rating_badge_custom_text'];
	}

	if ( $this->is_top_rated_product( $product->get_id() ) ) {
		echo '<div class="pp-right-badge-wrap"><span class="pp-right-badge pp-top-rated-badge">' . wp_kses_post( $badge_text ) . '</span></div>';
	}
}

if ( 'right' === $best_selling_badge_position ) {
	$badge_text = esc_html__( 'Best Selling', 'powerpack' );

	if ( '' !== $settings['best_selling_badge_custom_text'] ) {
		$badge_text = $settings['best_selling_badge_custom_text'];
	}

	if ( $this->is_best_selling_product( $product->get_id() ) ) {
		echo '<div class="pp-right-badge-wrap"><span class="pp-right-badge pp-best-selling-badge">' . wp_kses_post( $badge_text ) . '</span></div>';
	}
}
