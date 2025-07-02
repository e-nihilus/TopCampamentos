<?php
/**
 * The template for displaying a booking summary to customers.
 * It will display in:
 * - Thank you page after checkout;
 * - Order confirmation email;
 * - Review order in My Account > Orders.
 *
 * This template can be overridden by copying it to yourtheme/jet-booking/booking-summary.php.
 *
 * @since   3.0.0
 * @version 3.0.0
 */

defined( 'ABSPATH' ) || exit; // Exit if accessed directly.
?>

<div class="jet-booking-summary">
	<div class="jet-booking-summary__number">
		<strong><?php printf( __( 'Booking #%s', 'jet-booking' ), $booking->get_id() ); ?></strong>
	</div>
	<div class="jet-booking-summary__dates">
		<div class="jet-booking-summary__date-check-in">
			<?php printf( __( 'Check in: %s', 'jet-booking' ), date_i18n( get_option( 'date_format' ), $booking->get_check_in_date() ) ); ?>
		</div>
		<div class="jet-booking-summary__date-check-out">
			<?php printf( __( 'Check out: %s', 'jet-booking' ), date_i18n( get_option( 'date_format' ), $booking->get_check_out_date() ) ); ?>
		</div>
	</div>

	<?php if ( $booking->get_guests() ) : ?>
		<div class="jet-booking-summary__guests">
			<?php printf( __( 'Guests: %s', 'jet-booking' ), $booking->get_guests() ); ?>
		</div>
	<?php endif;

		$this->display_booking_additional_services( $booking );

		/**
		 * Fires on render booking summary in order metadata.
		 * Allows to add any content to booking summary.
		 */
		do_action( 'jet-booking/wc-integration/order-summary', $booking, $item, $order );
	?>
</div>
