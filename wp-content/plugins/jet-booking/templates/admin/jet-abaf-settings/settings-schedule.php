<div class="jet-abaf-settings-schedule">
	<div class="cx-vui-component__meta" style="align-items: flex-end;">
		<a class="jet-abaf-dash-help-link" href="https://crocoblock.com/knowledge-base/jetbooking/how-to-manage-days-and-weekends-in-booking/?utm_source=jetbooking&utm_medium=content&utm_campaign=need-help" target="_blank">
			<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M10.4413 7.39906C10.9421 6.89828 11.1925 6.29734 11.1925 5.59624C11.1925 4.71987 10.8795 3.9687 10.2535 3.34272C9.62754 2.71674 8.87637 2.40376 8 2.40376C7.12363 2.40376 6.37246 2.71674 5.74648 3.34272C5.1205 3.9687 4.80751 4.71987 4.80751 5.59624H6.38498C6.38498 5.17058 6.54773 4.79499 6.87324 4.46948C7.19875 4.14398 7.57434 3.98122 8 3.98122C8.42566 3.98122 8.80125 4.14398 9.12676 4.46948C9.45227 4.79499 9.61502 5.17058 9.61502 5.59624C9.61502 6.02191 9.45227 6.3975 9.12676 6.723L8.15024 7.73709C7.52426 8.41315 7.21127 9.16432 7.21127 9.99061V10.4038H8.78873C8.78873 9.57747 9.10172 8.82629 9.7277 8.15024L10.4413 7.39906ZM8.78873 13.5962V12.0188H7.21127V13.5962H8.78873ZM2.32864 2.3662C3.9061 0.788732 5.79656 0 8 0C10.2034 0 12.0814 0.788732 13.6338 2.3662C15.2113 3.91862 16 5.79656 16 8C16 10.2034 15.2113 12.0939 13.6338 13.6714C12.0814 15.2238 10.2034 16 8 16C5.79656 16 3.9061 15.2238 2.32864 13.6714C0.776213 12.0939 0 10.2034 0 8C0 5.79656 0.776213 3.91862 2.32864 2.3662Z" fill="#007CBA"></path>
			</svg>

			<?php _e( 'What is this and how it works?', 'jet-booking' ); ?>
		</a>
	</div>

	<div class="jet-abaf-settings-schedule__wrapper">
		<div class="jet-abaf-disabled-days jet-abaf-settings-schedule__column">
			<h4 slot="title" class="cx-vui-subtitle">
				<?php _e( 'Weekday Booking Rules', 'jet-booking' ); ?>
			</h4>
			<div class="cx-vui-component__desc">
				<?php _e( 'Configure which weekdays will be available for checking in/out and which will be disabled.', 'jet-booking' ); ?>
			</div>

			<cx-vui-list-table>
				<cx-vui-list-table-heading
					:slots="[ 'day', 'disable', 'check_in', 'check_out' ]"
					slot="heading"
				>
					<span slot="day"></span>
					<span slot="disable">
					<?php _e( 'Disable', 'jet-booking' ); ?>
				</span>
					<span slot="check_in">
					<?php _e( 'Check In', 'jet-booking' ); ?>
				</span>
					<span slot="check_out">
					<?php _e( 'Check Out', 'jet-booking' ); ?>
				</span>
				</cx-vui-list-table-heading>

				<cx-vui-list-table-item
					slot="items"
					:slots="[ 'day', 'disable', 'check_in', 'check_out' ]"
					class-name="status-row"
				>
				<span slot="day">
					<?php _e( 'Status', 'jet-booking' ); ?>
				</span>
					<span slot="disable">{{ disabledDaysStatusLabel }}</span>
					<span slot="check_in">{{ checkInOutDaysStatusLabel( 'in' ) }}</span>
					<span slot="check_out">{{ checkInOutDaysStatusLabel( 'out' ) }}</span>
				</cx-vui-list-table-item>

				<cx-vui-list-table-item
					slot="items"
					:slots="[ 'day', 'disable', 'check_in', 'check_out' ]"
				>
				<span slot="day">
					<?php _e( 'Monday', 'jet-booking' ); ?>
				</span>
					<div slot="disable">
						<cx-vui-switcher
							:return-true="true"
							:return-false="false"
							v-model="settings.disable_weekday_1"
							@input="updateSetting( $event, 'disable_weekday_1' )"
						></cx-vui-switcher>
					</div>
					<div slot="check_in">
						<cx-vui-switcher
							v-if="! settings.disable_weekday_1"
							:return-true="true"
							:return-false="false"
							v-model="settings.check_in_weekday_1"
							@input="updateSetting( $event, 'check_in_weekday_1' )"
						></cx-vui-switcher>
						<span v-else class="dashicons dashicons-no-alt"></span>
					</div>
					<div slot="check_out">
						<cx-vui-switcher
							v-if="! settings.disable_weekday_1"
							:return-true="true"
							:return-false="false"
							v-model="settings.check_out_weekday_1"
							@input="updateSetting( $event, 'check_out_weekday_1' )"
						></cx-vui-switcher>
						<span v-else class="dashicons dashicons-no-alt"></span>
					</div>
				</cx-vui-list-table-item>

				<cx-vui-list-table-item
					slot="items"
					:slots="[ 'day', 'disable', 'check_in', 'check_out' ]"
				>
				<span slot="day">
					<?php _e( 'Tuesday', 'jet-booking' ); ?>
				</span>
					<div slot="disable">
						<cx-vui-switcher
							:return-true="true"
							:return-false="false"
							v-model="settings.disable_weekday_2"
							@input="updateSetting( $event, 'disable_weekday_2' )"
						></cx-vui-switcher>
					</div>
					<div slot="check_in">
						<cx-vui-switcher
							v-if="! settings.disable_weekday_2"
							:return-true="true"
							:return-false="false"
							v-model="settings.check_in_weekday_2"
							@input="updateSetting( $event, 'check_in_weekday_2' )"
						></cx-vui-switcher>
						<span v-else class="dashicons dashicons-no-alt"></span>
					</div>
					<div slot="check_out">
						<cx-vui-switcher
							v-if="! settings.disable_weekday_2"
							:return-true="true"
							:return-false="false"
							v-model="settings.check_out_weekday_2"
							@input="updateSetting( $event, 'check_out_weekday_2' )"
						></cx-vui-switcher>
						<span v-else class="dashicons dashicons-no-alt"></span>
					</div>
				</cx-vui-list-table-item>

				<cx-vui-list-table-item
					slot="items"
					:slots="[ 'day', 'disable', 'check_in', 'check_out' ]"
				>
				<span slot="day">
					<?php _e( 'Wednesday', 'jet-booking' ); ?>
				</span>
					<div slot="disable">
						<cx-vui-switcher
							:return-true="true"
							:return-false="false"
							v-model="settings.disable_weekday_3"
							@input="updateSetting( $event, 'disable_weekday_3' )"
						></cx-vui-switcher>
					</div>
					<div slot="check_in">
						<cx-vui-switcher
							v-if="! settings.disable_weekday_3"
							:return-true="true"
							:return-false="false"
							v-model="settings.check_in_weekday_3"
							@input="updateSetting( $event, 'check_in_weekday_3' )"
						></cx-vui-switcher>
						<span v-else class="dashicons dashicons-no-alt"></span>
					</div>
					<div slot="check_out">
						<cx-vui-switcher
							v-if="! settings.disable_weekday_3"
							:return-true="true"
							:return-false="false"
							v-model="settings.check_out_weekday_3"
							@input="updateSetting( $event, 'check_out_weekday_3' )"
						></cx-vui-switcher>
						<span v-else class="dashicons dashicons-no-alt"></span>
					</div>
				</cx-vui-list-table-item>

				<cx-vui-list-table-item
					slot="items"
					:slots="[ 'day', 'disable', 'check_in', 'check_out' ]"
				>
				<span slot="day">
					<?php _e( 'Thursday', 'jet-booking' ); ?>
				</span>
					<div slot="disable">
						<cx-vui-switcher
							:return-true="true"
							:return-false="false"
							v-model="settings.disable_weekday_4"
							@input="updateSetting( $event, 'disable_weekday_4' )"
						></cx-vui-switcher>
					</div>
					<div slot="check_in">
						<cx-vui-switcher
							v-if="! settings.disable_weekday_4"
							:return-true="true"
							:return-false="false"
							v-model="settings.check_in_weekday_4"
							@input="updateSetting( $event, 'check_in_weekday_4' )"
						></cx-vui-switcher>
						<span v-else class="dashicons dashicons-no-alt"></span>
					</div>
					<div slot="check_out">
						<cx-vui-switcher
							v-if="! settings.disable_weekday_4"
							:return-true="true"
							:return-false="false"
							v-model="settings.check_out_weekday_4"
							@input="updateSetting( $event, 'check_out_weekday_4' )"
						></cx-vui-switcher>
						<span v-else class="dashicons dashicons-no-alt"></span>
					</div>
				</cx-vui-list-table-item>

				<cx-vui-list-table-item
					slot="items"
					:slots="[ 'day', 'disable', 'check_in', 'check_out' ]"
				>
				<span slot="day">
					<?php _e( 'Friday', 'jet-booking' ); ?>
				</span>
					<div slot="disable">
						<cx-vui-switcher
							:return-true="true"
							:return-false="false"
							v-model="settings.disable_weekday_5"
							@input="updateSetting( $event, 'disable_weekday_5' )"
						></cx-vui-switcher>
					</div>
					<div slot="check_in">
						<cx-vui-switcher
							v-if="! settings.disable_weekday_5"
							:return-true="true"
							:return-false="false"
							v-model="settings.check_in_weekday_5"
							@input="updateSetting( $event, 'check_in_weekday_5' )"
						></cx-vui-switcher>
						<span v-else class="dashicons dashicons-no-alt"></span>
					</div>
					<div slot="check_out">
						<cx-vui-switcher
							v-if="! settings.disable_weekday_5"
							:return-true="true"
							:return-false="false"
							v-model="settings.check_out_weekday_5"
							@input="updateSetting( $event, 'check_out_weekday_5' )"
						></cx-vui-switcher>
						<span v-else class="dashicons dashicons-no-alt"></span>
					</div>
				</cx-vui-list-table-item>

				<cx-vui-list-table-item
					slot="items"
					:slots="[ 'day', 'disable', 'check_in', 'check_out' ]"
				>
				<span slot="day">
					<?php _e( 'Saturday', 'jet-booking' ); ?>
				</span>
					<div slot="disable">
						<cx-vui-switcher
							:return-true="true"
							:return-false="false"
							v-model="settings.disable_weekend_1"
							@input="updateSetting( $event, 'disable_weekend_1' )"
						></cx-vui-switcher>
					</div>
					<div slot="check_in">
						<cx-vui-switcher
							v-if="! settings.disable_weekend_1"
							:return-true="true"
							:return-false="false"
							v-model="settings.check_in_weekend_1"
							@input="updateSetting( $event, 'check_in_weekend_1' )"
						></cx-vui-switcher>
						<span v-else class="dashicons dashicons-no-alt"></span>
					</div>
					<div slot="check_out">
						<cx-vui-switcher
							v-if="! settings.disable_weekend_1"
							:return-true="true"
							:return-false="false"
							v-model="settings.check_out_weekend_1"
							@input="updateSetting( $event, 'check_out_weekend_1' )"
						></cx-vui-switcher>
						<span v-else class="dashicons dashicons-no-alt"></span>
					</div>
				</cx-vui-list-table-item>

				<cx-vui-list-table-item
					slot="items"
					:slots="[ 'day', 'disable', 'check_in', 'check_out' ]"
				>
				<span slot="day">
					<?php _e( 'Sunday', 'jet-booking' ); ?>
				</span>
					<div slot="disable">
						<cx-vui-switcher
							:return-true="true"
							:return-false="false"
							v-model="settings.disable_weekend_2"
							@input="updateSetting( $event, 'disable_weekend_2' )"
						></cx-vui-switcher>
					</div>
					<div slot="check_in">
						<cx-vui-switcher
							v-if="! settings.disable_weekend_2"
							:return-true="true"
							:return-false="false"
							v-model="settings.check_in_weekend_2"
							@input="updateSetting( $event, 'check_in_weekend_2' )"
						></cx-vui-switcher>
						<span v-else class="dashicons dashicons-no-alt"></span>
					</div>
					<div slot="check_out">
						<cx-vui-switcher
							v-if="! settings.disable_weekend_2"
							:return-true="true"
							:return-false="false"
							v-model="settings.check_out_weekend_2"
							@input="updateSetting( $event, 'check_out_weekend_2' )"
						></cx-vui-switcher>
						<span v-else class="dashicons dashicons-no-alt"></span>
					</div>
				</cx-vui-list-table-item>
			</cx-vui-list-table>
		</div>

		<div class="jet-abaf-days-off jet-abaf-settings-schedule__column">
			<cx-vui-collapse :collapsed="false">
				<h4 slot="title" class="cx-vui-subtitle">
					<?php _e( 'Days Off', 'jet-booking' ); ?>
				</h4>

				<div slot="content">
					<div class="jet-abaf-days-off__heading">
						<div class="cx-vui-component__desc">
							<?php _e( 'Set the days off, holidays, and weekend dates.', 'jet-booking' ); ?>
						</div>

						<cx-vui-button size="mini" button-style="accent" @click="showEditDay( 'days_off' )">
						<span slot="label">
							<?php _e( '+ Add Days', 'jet-booking' ); ?>
						</span>
						</cx-vui-button>
					</div>

					<div class="jet-abaf-days-off__body">
						<div class="jet-abaf-days-off-schedule-slot" v-for="(offDate, key) in settings.days_off" :key="key">
							<div class="jet-abaf-days-off-schedule-slot__head">
								<div class="jet-abaf-days-off-schedule-slot__head-name">{{ offDate.name }}</div>

								<div class="jet-abaf-days-off-schedule-slot__head-actions">
									<span class="dashicons dashicons-edit" @click="showEditDay( 'days_off', offDate )"></span>

									<div style="position:relative;">
										<span class="dashicons dashicons-trash" @click="confirmDeleteDay( offDate )"></span>

										<div class="cx-vui-tooltip" v-if="deleteDayTrigger === offDate">
											<?php _e( 'Are you sure?', 'jet-booking' ); ?>

											<br>

											<span class="cx-vui-repeater-item__confrim-del" @click="deleteDay( 'days_off', offDate )">
											<?php _e( 'Yes', 'jet-booking' ); ?>
										</span>
											/
											<span class="cx-vui-repeater-item__cancel-del" @click="deleteDayTrigger = null">
											<?php _e( 'No', 'jet-booking' ); ?>
										</span>
										</div>
									</div>
								</div>
							</div>

							<div class="jet-abaf-days-off-schedule-slot__body">
								{{ offDate.start }}<span v-if=offDate.end> — {{ offDate.end }}</span>
							</div>
						</div>
					</div>
				</div>
			</cx-vui-collapse>
		</div>
	</div>

	<cx-vui-popup
		v-model="editDay"
		body-width="600px"
		ok-label="<?php _e( 'Save', 'jet-booking' ) ?>"
		cancel-label="<?php _e( 'Cancel', 'jet-booking' ) ?>"
		@on-cancel="handleDayCancel"
		@on-ok="handleDayOk"
	>
		<div class="cx-vui-subtitle" slot="title">
			<?php _e( 'Select Days', 'jet-booking' ); ?>
		</div>

		<cx-vui-input
			label="<?php _e( 'Range Label', 'jet-booking' ); ?>"
			description="<?php _e( 'Name the range that will be unavailable for booking (e.g., name of the holiday).', 'jet-booking' ); ?>"
			:wrapper-css="[ 'equalwidth' ]"
			size="fullwidth"
			v-model="date.name"
			slot="content"
		></cx-vui-input>

		<cx-vui-component-wrapper
			:wrapper-css="[ 'equalwidth' ]"
			label="<?php _e( 'Start Date *', 'jet-booking' ); ?>"
			description="<?php _e( 'Pick the start day.', 'jet-booking' ); ?>"
			slot="content"
		>
			<vuejs-datepicker
				input-class="cx-vui-input size-fullwidth"
				placeholder="<?php _e( 'Select Date', 'jet-booking' ); ?>"
				:format="datePickerFormat"
				:disabled-dates="disabledDate"
				:value="secondsToMilliseconds( date.startTimeStamp )"
				:monday-first="true"
				@selected="selectedDate( $event, 'start' )"
			></vuejs-datepicker>
		</cx-vui-component-wrapper>

		<cx-vui-component-wrapper
			:wrapper-css="[ 'equalwidth' ]"
			label="<?php _e( 'End Date', 'jet-booking' ); ?>"
			description="<?php _e( 'Pick the end day.', 'jet-booking' ); ?>"
			slot="content"
		>
			<vuejs-datepicker
				input-class="cx-vui-input size-fullwidth"
				placeholder="<?php _e( 'Select Date', 'jet-booking' ); ?>"
				:format="datePickerFormat"
				:disabled-dates="disabledDate"
				:value="secondsToMilliseconds( date.endTimeStamp )"
				:monday-first="true"
				@selected="selectedDate( $event, 'end' )"
			></vuejs-datepicker>
		</cx-vui-component-wrapper>
	</cx-vui-popup>
</div>