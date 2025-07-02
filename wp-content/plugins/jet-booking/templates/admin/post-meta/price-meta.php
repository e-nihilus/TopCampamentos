<div id='jet-abaf-price-meta-box'>
	<cx-vui-component-wrapper
		label="<?php _e( 'Price per 1 day/night', 'jet-booking' ); ?>"
		description="<?php _e( 'Name: _apartment_price.', 'jet-booking' ); ?>"
		:wrapper-css="[ 'width-30-40', 'apartment-price' ]"
	>
		<cx-vui-input
			type="number"
			:min="0"
			:step="0.1"
			v-model="meta._apartment_price"
			@on-blur="updateSetting"
		></cx-vui-input>

		<cx-vui-button
			:class="{ 'jet-abaf-price-active': meta._pricing_rates.length }"
			button-style="accent-border"
			size="mini"
			@click="showPopUp( meta._pricing_rates, meta._apartment_price, 'rates' )"
		>
			<template slot="label">
				<?php _e( 'Add rates', 'jet-booking' ); ?>
			</template>
		</cx-vui-button>

		<cx-vui-button
			:class="{ 'jet-abaf-price-active': isWeekendPriceActive( meta._weekend_prices ) }"
			button-style="accent-border"
			size="mini"
			@click="showPopUp( meta._weekend_prices, meta._apartment_price, 'weekend' )"
		>
			<template slot="label">
				<?php _e( 'Add weekend ', 'jet-booking' ); ?>
			</template>
		</cx-vui-button>
	</cx-vui-component-wrapper>

	<div class="cx-vui-component cx-vui-component--width-30-40">
		<div class="cx-vui-component__meta">
			<div class="cx-vui-component__label">
				<?php _e( 'Seasonal prices', 'jet-booking' ); ?>
			</div>

			<div class="cx-vui-component__meta" style="margin-top: 10px;">
				<a class="jet-abaf-dash-help-link" href="https://crocoblock.com/knowledge-base/jetbooking/how-to-set-up-the-seasonal-pricing/?utm_source=jetbooking&utm_medium=content&utm_campaign=need-help" target="_blank">
					<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M10.4413 7.39906C10.9421 6.89828 11.1925 6.29734 11.1925 5.59624C11.1925 4.71987 10.8795 3.9687 10.2535 3.34272C9.62754 2.71674 8.87637 2.40376 8 2.40376C7.12363 2.40376 6.37246 2.71674 5.74648 3.34272C5.1205 3.9687 4.80751 4.71987 4.80751 5.59624H6.38498C6.38498 5.17058 6.54773 4.79499 6.87324 4.46948C7.19875 4.14398 7.57434 3.98122 8 3.98122C8.42566 3.98122 8.80125 4.14398 9.12676 4.46948C9.45227 4.79499 9.61502 5.17058 9.61502 5.59624C9.61502 6.02191 9.45227 6.3975 9.12676 6.723L8.15024 7.73709C7.52426 8.41315 7.21127 9.16432 7.21127 9.99061V10.4038H8.78873C8.78873 9.57747 9.10172 8.82629 9.7277 8.15024L10.4413 7.39906ZM8.78873 13.5962V12.0188H7.21127V13.5962H8.78873ZM2.32864 2.3662C3.9061 0.788732 5.79656 0 8 0C10.2034 0 12.0814 0.788732 13.6338 2.3662C15.2113 3.91862 16 5.79656 16 8C16 10.2034 15.2113 12.0939 13.6338 13.6714C12.0814 15.2238 10.2034 16 8 16C5.79656 16 3.9061 15.2238 2.32864 13.6714C0.776213 12.0939 0 10.2034 0 8C0 5.79656 0.776213 3.91862 2.32864 2.3662Z" fill="#007CBA"></path>
					</svg>

					<?php _e( 'What is this and how it works?', 'jet-booking' ); ?>
				</a>
			</div>
		</div>

		<div class="cx-vui-component__control">
			<cx-vui-repeater
				button-label="<?php _e( 'Add price', 'jet-booking' ); ?>"
				button-style="accent-border"
				button-size="mini"
				v-model="meta._seasonal_prices"
				@add-new-item="addSP"
			>
				<cx-vui-repeater-item
					v-for="( item, index ) in meta._seasonal_prices"
					:title="getRepeaterTitle( item )"
					:index="index"
					:key="index"
					:collapsed="isCollapsed( item )"
					@clone-item="cloneSP( item )"
					@delete-item="deleteSP( index )"
				>
					<cx-vui-input
						label="<?php _e( 'Title', 'jet-booking' ); ?>"
						size="fullwidth"
						:value="item.title"
						@on-blur="changeSPValue( $event, 'title', index )"
					></cx-vui-input>

					<cx-vui-component-wrapper
						label="<?php _e( 'Price per 1 day/night', 'jet-booking' ); ?>"
						:wrapper-css="[ 'width-30-40', 'apartment-price' ]"
					>
						<cx-vui-input
							type="number"
							min="0"
							step="0.1"
							:value="item.price"
							@on-blur="changeSPValue( $event, 'price', index )"
						></cx-vui-input>

						<cx-vui-button
							:class="{ 'jet-abaf-price-active': item._pricing_rates.length }"
							button-style="accent-border"
							size="mini"
							@click="showPopUp( item._pricing_rates, item.price, 'rates' )"
						>
							<template slot="label"><?php _e( 'Add rates', 'jet-booking' ); ?></template>
						</cx-vui-button>

						<cx-vui-button
							:class="{ 'jet-abaf-price-active': isWeekendPriceActive( item._weekend_prices ) }"
							button-style="accent-border"
							size="mini"
							@click="showPopUp( item._weekend_prices, item.price, 'weekend' )"
						>
							<template slot="label"><?php _e( 'Add weekend ', 'jet-booking' ); ?></template>
						</cx-vui-button>
					</cx-vui-component-wrapper>

					<cx-vui-switcher
						label="<?php _e( 'Date Picker Configuration', 'jet-booking' ); ?>"
						description="<?php _e( 'You can enable and setup datepicker configuration for apartment season.', 'jet-booking' ); ?>"
						:wrapper-css="[ 'equalwidth' ]"
						:value="item.enable_config"
						@input="changeSPValue( $event, 'enable_config', index )"
					></cx-vui-switcher>

					<div v-if="item.enable_config">
						<cx-vui-input
							type="number"
							label="<?php _e( 'Starting day offset', 'jet-booking' ); ?>"
							description="<?php _e( 'This string defines offset for the earliest date which is available to the user.', 'jet-booking' ); ?>"
							:wrapper-css="[ 'equalwidth' ]"
							size="fullwidth"
							min="0"
							:value="item.start_day_offset"
							@on-blur="changeSPValue( $event, 'start_day_offset', index )"
						></cx-vui-input>

						<cx-vui-input
							type="number"
							label="<?php _e( 'Min days', 'jet-booking' ); ?>"
							description="<?php _e( 'This number defines the minimum days of the selected range. If it equals 0, it means minimum days are not limited.', 'jet-booking' ); ?>"
							:wrapper-css="[ 'equalwidth' ]"
							size="fullwidth"
							min="0"
							:value="item.min_days"
							@on-blur="changeSPValue( $event, 'min_days', index )"
						></cx-vui-input>

						<cx-vui-input
							type="number"
							label="<?php _e( 'Max days', 'jet-booking' ); ?>"
							description="<?php _e( 'This number defines the maximum days of the selected range. If it equals 0, it means maximum days are not limited.', 'jet-booking' ); ?>"
							:wrapper-css="[ 'equalwidth' ]"
							size="fullwidth"
							min="0"
							:value="item.max_days"
							@on-blur="changeSPValue( $event, 'max_days', index )"
						></cx-vui-input>
					</div>

					<cx-vui-component-wrapper
						label="<?php _e( 'Start Date', 'jet-booking' ); ?>"
						:wrapper-css="[ 'width-30-40' ]"
					>
						<vuejs-datepicker
							input-class="cx-vui-input size-fullwidth"
							placeholder="<?php _e( 'Select Date', 'jet-booking' ); ?>"
							:format="datePickerFormat"
							:value="secondsToMilliseconds( item.startTimestamp )"
							@selected="changeSPValue( $event, 'startTimestamp', index )"
						></vuejs-datepicker>
					</cx-vui-component-wrapper>

					<cx-vui-component-wrapper
						label="<?php _e( 'End Date', 'jet-booking' ); ?>"
						:wrapper-css="[ 'width-30-40' ]"
					>
						<vuejs-datepicker
							input-class="cx-vui-input size-fullwidth"
							placeholder="<?php _e( 'Select Date', 'jet-booking' ); ?>"
							:format="datePickerFormat"
							:value="secondsToMilliseconds( item.endTimestamp )"
							@selected="changeSPValue( $event, 'endTimestamp', index )"
						></vuejs-datepicker>
					</cx-vui-component-wrapper>
					<?php /*
				<cx-vui-select
					label="<?php esc_html_e( 'Repeat Season', 'jet-booking' ); ?>"
					description="<?php esc_html_e( 'Select the aging period of the season. For example every year, month or week.', 'jet-booking' ); ?>"
					:options-list="period_repeats_seasons"
					:wrapper-css="[ 'width-30-40' ]"
					:size="'fullwidth'"
					:value="item.repeatSeason"
					@input="changeSPValue( $event, 'repeatSeason', index )"
				></cx-vui-select>
				*/ ?>

				</cx-vui-repeater-item>
			</cx-vui-repeater>
		</div>
	</div>

	<cx-vui-popup
		v-model="popUpActive_rates"
		body-width="600px"
		:footer="false"
		@on-cancel="hidePopUp('rates')"
		class="jet-apb-popup"
	>
		<div class="cx-vui-subtitle" slot="title">
			<?php _e( 'Set up advanced pricing rates', 'jet-booking' ); ?>
		</div>

		<div slot="content">
			<div class="jet-abaf-rates-list">
				<div class="jet-abaf-rates-list__item default">
					<div class="jet-abaf-rates-list__col col-title">
						<?php _e( 'From', 'jet-booking' ); ?>&nbsp;&nbsp;
						<input type="number" value="1" disabled>&nbsp;&nbsp;
						<?php _e( 'days/nights', 'jet-booking' ); ?>
					</div>

					<div class="jet-abaf-rates-list__col col-price">
						<?php _e( 'Price:', 'jet-booking' ); ?>&nbsp;&nbsp;
						<input type="number" min="0" :value="popUpData.price" disabled>&nbsp;&nbsp;
						<?php _e( 'per day/night', 'jet-booking' ); ?>
					</div>
					<div class="jet-abaf-rates-list__col col-delete">&nbsp;</div>
				</div>

				<div
					class="jet-abaf-rates-list__item"
					v-for="( rate, index ) in popUpData.items"
					:key="'rate-' + index">
					<div class="jet-abaf-rates-list__col col-title">
						<?php _e( 'From', 'jet-booking' ); ?>&nbsp;&nbsp;
						<input type="number" min="2" step="1" v-model="rate.duration">&nbsp;&nbsp;
						<?php _e( 'days/nights', 'jet-booking' ); ?>
					</div>

					<div class="jet-abaf-rates-list__col col-price">
						<?php _e( 'Price:', 'jet-booking' ); ?>&nbsp;&nbsp;
						<input type="number" min="0" step="0.1" v-model="rate.value">&nbsp;&nbsp;
						<?php _e( 'per day/night', 'jet-booking' ); ?>
					</div>
					<div class="jet-abaf-rates-list__col col-delete">
						<span @click="deleteRate( index )" class="dashicons dashicons-trash"></span>
					</div>
				</div>
			</div>

			<a href="#" class="jet-abaf-add-rate" @click.prevent="newRate">
				<?php _e( '+ Add new rate', 'jet-booking' ); ?>
			</a>

			<div class="jet-abaf-popup-actions">
				<button class="button button-primary" type="button" aria-expanded="true" @click="saveMeta">
					<span v-if="!saving">
						<?php _e( 'Save', 'jet-booking' ); ?>
					</span>
					<span v-else>
						<?php _e( 'Saving...', 'jet-booking' ); ?>
					</span>
				</button>

				<button class="button-link" type="button" aria-expanded="true" @click="hidePopUp('rates')">
					<?php _e( 'Cancel', 'jet-booking' ); ?>
				</button>
			</div>
		</div>
	</cx-vui-popup>

	<cx-vui-popup
		v-model="popUpActive_weekend"
		body-width="400px"
		class="jet-apb-popup"
		@on-ok="saveMeta"
		@on-cancel="hidePopUp('weekend')"
		ok-label="<?php _e( 'Save', 'jet-booking' ) ?>"
		cancel-label="<?php _e( 'Close', 'jet-booking' ) ?>"
	>
		<div class="cx-vui-subtitle" slot="title">
			<?php _e( 'Set up weekend pricing', 'jet-appointments-booking' ); ?>
		</div>

		<template slot="content">
			<div class="jet-abaf-weekend-list__item" v-for="( item, index ) in popUpData.items" :key="'price-' + index">
				<div class="jet-abaf-weekend-list__col col-title">
					<strong>{{ weekdays_label[ index ] }}</strong>
				</div>

				<div class="jet-abaf-weekend-list__col col-price">
					<cx-vui-switcher
						v-model="item.active"
						class="jet-abaf-weekend-switcher"
					></cx-vui-switcher>

					<label>
						<?php _e( 'Price:', 'jet-booking' ); ?>
					</label>

					<cx-vui-input
						type="number"
						:min="0"
						:step="0.1"
						v-model="item.price"
					></cx-vui-input>&nbsp;&nbsp;

					<?php _e( 'per day/night', 'jet-booking' ); ?>
				</div>
			</div>

			<div class="cx-vui-component__meta" style="align-items: flex-end; margin-top: 10px;">
				<a class="jet-abaf-dash-help-link" href="https://crocoblock.com/knowledge-base/jetbooking/jetbooking-how-to-configure-the-weekend-pricing/?utm_source=jetbooking&utm_medium=content&utm_campaign=need-help" target="_blank">
					<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M10.4413 7.39906C10.9421 6.89828 11.1925 6.29734 11.1925 5.59624C11.1925 4.71987 10.8795 3.9687 10.2535 3.34272C9.62754 2.71674 8.87637 2.40376 8 2.40376C7.12363 2.40376 6.37246 2.71674 5.74648 3.34272C5.1205 3.9687 4.80751 4.71987 4.80751 5.59624H6.38498C6.38498 5.17058 6.54773 4.79499 6.87324 4.46948C7.19875 4.14398 7.57434 3.98122 8 3.98122C8.42566 3.98122 8.80125 4.14398 9.12676 4.46948C9.45227 4.79499 9.61502 5.17058 9.61502 5.59624C9.61502 6.02191 9.45227 6.3975 9.12676 6.723L8.15024 7.73709C7.52426 8.41315 7.21127 9.16432 7.21127 9.99061V10.4038H8.78873C8.78873 9.57747 9.10172 8.82629 9.7277 8.15024L10.4413 7.39906ZM8.78873 13.5962V12.0188H7.21127V13.5962H8.78873ZM2.32864 2.3662C3.9061 0.788732 5.79656 0 8 0C10.2034 0 12.0814 0.788732 13.6338 2.3662C15.2113 3.91862 16 5.79656 16 8C16 10.2034 15.2113 12.0939 13.6338 13.6714C12.0814 15.2238 10.2034 16 8 16C5.79656 16 3.9061 15.2238 2.32864 13.6714C0.776213 12.0939 0 10.2034 0 8C0 5.79656 0.776213 3.91862 2.32864 2.3662Z" fill="#007CBA"></path>
					</svg>

					<?php _e( 'What is this and how it works?', 'jet-booking' ); ?>
				</a>
			</div>
		</template>
	</cx-vui-popup>
</div>
