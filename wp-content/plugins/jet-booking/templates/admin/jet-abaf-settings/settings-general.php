<div>
	<cx-vui-select
		label="<?php _e( 'Booking mode', 'jet-booking' ); ?>"
		description="<?php _e( 'Select the booking mode type. It changes the display and behavior of the booking interface to match the chosen mode.', 'jet-booking' ); ?>"
		:options-list="[
			{
				value: 'plain',
				label: '<?php _e( 'Plain', 'jet-booking' ); ?>',
			},
			{
				value: 'wc_based',
				label: '<?php _e( 'WooCommerce based', 'jet-booking' ); ?>',
			}
		]"
		:wrapper-css="[ 'equalwidth' ]"
		:size="'fullwidth'"
		:value="generalSettings.booking_mode"
		@input="updateSetting( $event, 'booking_mode' )"
	>
		<div v-if="'plain' === generalSettings.booking_mode" class="cx-vui-component__desc">
			<p><?php _e( 'Booking system focusing on the core functionality for managing bookings.', 'jet-booking' ); ?></p>
		</div>
		<div v-else class="cx-vui-component__desc">
			<?php if ( ! jet_abaf()->wc->has_woocommerce() ) {
				printf(
					__( '<p>Requires <a href="%s" target="_blank">WooCommerce</a> to be installed and activated.</p>', 'jet-booking' ),
					add_query_arg( [ 's' => 'woocommerce', 'tab' => 'search', 'type' => 'term' ], admin_url( 'plugin-install.php' ) )
				);
			} else {
				if ( ! jet_abaf()->tools->get_booking_posts() ) {
					printf(
						__( '<p>Create booking products to start using this functionality. <a href="%s" target="_blank">Create the first product</a>.</p>', 'jet-booking' ),
						add_query_arg( [ 'post_type' => 'product', 'jet_booking_product' => 1 ], admin_url( 'post-new.php' ) )
					);
				}
			} ?>

			<p><?php _e( 'Booking system allowing you to create and manage custom products type specifically designed for booking and seamlessly integrate it into online store.', 'jet-booking' ); ?></p>

			<div class="cx-vui-component__meta">
				<a class="jet-abaf-dash-help-link" href="https://crocoblock.com/knowledge-base/jetbooking/how-to-use-booking-with-woocommerce/?utm_source=jetbooking&utm_medium=content&utm_campaign=need-help" target="_blank">
					<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M10.4413 7.39906C10.9421 6.89828 11.1925 6.29734 11.1925 5.59624C11.1925 4.71987 10.8795 3.9687 10.2535 3.34272C9.62754 2.71674 8.87637 2.40376 8 2.40376C7.12363 2.40376 6.37246 2.71674 5.74648 3.34272C5.1205 3.9687 4.80751 4.71987 4.80751 5.59624H6.38498C6.38498 5.17058 6.54773 4.79499 6.87324 4.46948C7.19875 4.14398 7.57434 3.98122 8 3.98122C8.42566 3.98122 8.80125 4.14398 9.12676 4.46948C9.45227 4.79499 9.61502 5.17058 9.61502 5.59624C9.61502 6.02191 9.45227 6.3975 9.12676 6.723L8.15024 7.73709C7.52426 8.41315 7.21127 9.16432 7.21127 9.99061V10.4038H8.78873C8.78873 9.57747 9.10172 8.82629 9.7277 8.15024L10.4413 7.39906ZM8.78873 13.5962V12.0188H7.21127V13.5962H8.78873ZM2.32864 2.3662C3.9061 0.788732 5.79656 0 8 0C10.2034 0 12.0814 0.788732 13.6338 2.3662C15.2113 3.91862 16 5.79656 16 8C16 10.2034 15.2113 12.0939 13.6338 13.6714C12.0814 15.2238 10.2034 16 8 16C5.79656 16 3.9061 15.2238 2.32864 13.6714C0.776213 12.0939 0 10.2034 0 8C0 5.79656 0.776213 3.91862 2.32864 2.3662Z" fill="#007CBA"></path>
					</svg>

					<?php _e( 'What is this and how it works?', 'jet-booking' ); ?>
				</a>
			</div>
		</div>
	</cx-vui-select>

	<cx-vui-select
		v-if="'plain' === generalSettings.booking_mode"
		label="<?php _e( 'Booking orders post type', 'jet-booking' ); ?>"
		description="<?php _e( 'Select the post type, which will record and store the booking orders. It could be called \'Orders\'. Once a new order is placed, the record will appear in the corresponding database table within the chosen post type.', 'jet-booking' ); ?>"
		:options-list="postTypes"
		:wrapper-css="[ 'equalwidth' ]"
		:size="'fullwidth'"
		:value="generalSettings.related_post_type"
		@input="updateSetting( $event, 'related_post_type' )"
	></cx-vui-select>

	<cx-vui-select
		v-if="'plain' === generalSettings.booking_mode"
		label="<?php _e( 'Booking instance post type', 'jet-booking' ); ?>"
		description="<?php _e( 'Select the post type containing the units to be booked (booking instances). Once selected, the related post IDs will be shown in the Bookings database table.', 'jet-booking' ); ?>"
		:options-list="postTypes"
		:wrapper-css="[ 'equalwidth' ]"
		:size="'fullwidth'"
		:value="generalSettings.apartment_post_type"
		@input="updateSetting( $event, 'apartment_post_type' )"
	></cx-vui-select>

	<?php if ( jet_abaf()->wc->has_woocommerce() ) : ?>
		<cx-vui-switcher
			v-if="'plain' === generalSettings.booking_mode"
			label="<?php _e( 'WooCommerce integration', 'jet-booking' ); ?>"
			description="<?php _e( 'Enable to connect the booking system to a WooCommerce checkout.', 'jet-booking' ); ?>"
			:wrapper-css="[ 'equalwidth' ]"
			:value="generalSettings.wc_integration"
			@input="updateSetting( $event, 'wc_integration' )"
		></cx-vui-switcher>

		<cx-vui-switcher
			v-if="'plain' === generalSettings.booking_mode && settings.wc_integration"
			label="<?php _e( 'Two-way WooCommerce orders sync', 'jet-appointments-booking' ); ?>"
			description="<?php _e( 'If you enable this option, WooCommerce order status will be updated once the booking status changes (by default, if you update a booking status, the related order will remain the same).', 'jet-booking' ); ?>"
			:wrapper-css="[ 'equalwidth' ]"
			:value="settings.wc_sync_orders"
			@input="updateSetting( $event, 'wc_sync_orders' )"
		></cx-vui-switcher>

		<cx-vui-select
			v-if="'plain' !== generalSettings.booking_mode"
			label="<?php _e( 'Booking hold time', 'jet-booking' ); ?>"
			description="<?php _e( 'Time during which the selected date range will be kept on hold after adding the booking instance to the cart.', 'jet-booking' ); ?>"
			:options-list="[
			{
				value: '300',
				label: '<?php _e( '5 min', 'jet-booking' ); ?>',
			},
			{
				value: '600',
				label: '<?php _e( '10 min', 'jet-booking' ); ?>',
			},
			{
				value: '900',
				label: '<?php _e( '15 min', 'jet-booking' ); ?>',
			},
			{
				value: '1200',
				label: '<?php _e( '20 min', 'jet-booking' ); ?>',
			},
			{
				value: '1500',
				label: '<?php _e( '25 min', 'jet-booking' ); ?>',
			},
			{
				value: '1800',
				label: '<?php _e( '30 min', 'jet-booking' ); ?>',
			}
		]"
			:wrapper-css="[ 'equalwidth' ]"
			:size="'fullwidth'"
			:value="generalSettings.booking_hold_time"
			@input="updateSetting( $event, 'booking_hold_time' )"
		></cx-vui-select>
	<?php else : ?>
		<cx-vui-component-wrapper
			v-if="'plain' === generalSettings.booking_mode"
			label="<?php _e( 'WooCommerce integration', 'jet-booking' ); ?>"
			description="<?php _e( 'Enable to connect the booking system with WooCommerce checkout.', 'jet-booking' ); ?>"
			:wrapper-css="[ 'equalwidth' ]"
		>
			<span>
				<?php printf(
					__( 'Please install and activate  <a href="%s" target="_blank">WooCommerce</a> to use this option.', 'jet-booking' ),
					admin_url() . 'plugin-install.php?s=woocommerce&tab=search&type=term'
				); ?>
			</span>
		</cx-vui-component-wrapper>
	<?php endif; ?>

	<cx-vui-select
		label="<?php _e( 'Filters storage type', 'jet-booking' ); ?>"
		description="<?php _e( 'Select the filter storage type for the searched date range.', 'jet-booking' ); ?>"
		:options-list="[
			{
				value: 'session',
				label: '<?php _e( 'Session', 'jet-booking' ); ?>',
			},
			{
				value: 'cookies',
				label: '<?php _e( 'Cookies', 'jet-booking' ); ?>',
			}
		]"
		:wrapper-css="[ 'equalwidth' ]"
		:size="'fullwidth'"
		:value="generalSettings.filters_store_type"
		@input="updateSetting( $event, 'filters_store_type' )"
	></cx-vui-select>
</div>
