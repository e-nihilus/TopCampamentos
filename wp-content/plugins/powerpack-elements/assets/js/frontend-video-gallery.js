(function ($) {
	$( window ).on( 'elementor/frontend/init', () => {
		class VideoGalleryWidget extends elementorModules.frontend.handlers.Base {
			getDefaultSettings() {
				return {
					selectors: {
						gallery: '.pp-video-gallery',
						swiperContainer: '.pp-swiper-slider',
						swiperSlide: '.swiper-slide',
						itemWrap: '.pp-grid-item-wrap',
					},
					slidesPerView: {
						widescreen: 3,
						desktop: 3,
						laptop: 3,
						tablet_extra: 3,
						tablet: 2,
						mobile_extra: 2,
						mobile: 1
					},
					effect: 'slide'
				};
			}

			getDefaultElements() {
				const selectors = this.getSettings( 'selectors' );
				return {
					$gallery: this.$element.find( selectors.gallery ),
					$swiperContainer: this.$element.find( selectors.swiperContainer ),
					$swiperSlide: this.$element.find( selectors.swiperSlide ),
					$itemWrap: this.$element.find( selectors.itemWrap ),
				};
			}

			getSliderSettings(prop) {
				const sliderSettings = ( undefined !== this.elements.$swiperContainer.data('slider-settings') ) ? this.elements.$swiperContainer.data('slider-settings') : '';

				if ( 'undefined' !== typeof prop && 'undefined' !== sliderSettings[prop] ) {
					return sliderSettings[prop];
				}

				return sliderSettings;
			}

			getSlidesCount() {
				return this.elements.$swiperSlide.length;
			}

			getEffect() {
				return ( this.getSliderSettings('effect') || this.getSettings('effect') );
			}

			getDeviceSlidesPerView(device) {
				const slidesPerViewKey = 'slides_per_view' + ('desktop' === device ? '' : '_' + device);
				return Math.min(this.getSlidesCount(), +this.getSliderSettings(slidesPerViewKey) || this.getSettings('slidesPerView')[device]);
			}

			getSlidesPerView(device) {
				if ('slide' === this.getEffect()) {
					return this.getDeviceSlidesPerView(device);
				}
				return 1;
			}

			getDeviceSlidesToScroll(device) {
				const slidesToScrollKey = 'slides_to_scroll' + ('desktop' === device ? '' : '_' + device);
				return Math.min(this.getSlidesCount(), +this.getElementSettings(slidesToScrollKey) || 1);
			}

			getSlidesToScroll(device) {
				if ('slide' === this.getEffect()) {
					return this.getDeviceSlidesToScroll(device);
				}
				return 1;
			}

			getSpaceBetween(device) {
				let propertyName = 'space_between';
				if (device && 'desktop' !== device) {
					propertyName += '_' + device;
				}
				return elementorFrontend.utils.controls.getResponsiveControlValue(this.getSliderSettings(), 'space_between', 'size', device) || 0;
			}

			getSwiperOptions() {
				const sliderSettings = this.getSliderSettings();
				// const swiperOptions = ( undefined !== this.elements.$swiperContainer.data('slider-settings') ) ? this.elements.$swiperContainer.data('slider-settings') : '';

				const swiperOptions = {
					grabCursor:                'yes' === sliderSettings.grab_cursor,
					// initialSlide:               this.getInitialSlide(),
					slidesPerView:              this.getSlidesPerView('desktop'),
					slidesPerGroup:             this.getSlidesToScroll('desktop'),
					spaceBetween:               this.getSpaceBetween(),
					loop:                       'yes' === sliderSettings.loop,
					centeredSlides:             'yes' === sliderSettings.centered_slides,
					speed:                      sliderSettings.speed,
					autoHeight:                 sliderSettings.auto_height,
					effect:                     this.getEffect(),
					watchSlidesVisibility:      true,
					watchSlidesProgress:        true,
					preventClicksPropagation:   false,
					slideToClickedSlide:        true,
					handleElementorBreakpoints: true
				};

				if ( 'fade' === this.getEffect() ) {
					swiperOptions.fadeEffect = {
						crossFade: true,
					};
				}

				if ( sliderSettings.show_arrows ) {
					let prevEle = ( this.isEdit ) ? '.elementor-swiper-button-prev' : '.swiper-button-prev-' + this.getID();
					let nextEle = ( this.isEdit ) ? '.elementor-swiper-button-next' : '.swiper-button-next-' + this.getID();

					swiperOptions.navigation = {
						prevEl: prevEle,
						nextEl: nextEle,
					};
				}

				if ( sliderSettings.pagination ) {
					let paginationEle = ( this.isEdit ) ? '.swiper-pagination' : '.swiper-pagination-' + this.getID();

					swiperOptions.pagination = {
						el: paginationEle,
						type: sliderSettings.pagination,
						clickable: true
					};
				}

				if ('cube' !== this.getEffect()) {
					const breakpointsSettings = {},
					breakpoints = elementorFrontend.config.responsive.activeBreakpoints;

					Object.keys(breakpoints).forEach(breakpointName => {
						breakpointsSettings[breakpoints[breakpointName].value] = {
							slidesPerView: this.getSlidesPerView(breakpointName),
							slidesPerGroup: this.getSlidesToScroll(breakpointName),
						};

						if ( this.getSpaceBetween(breakpointName) ) {
							breakpointsSettings[breakpoints[breakpointName].value].spaceBetween = this.getSpaceBetween(breakpointName);
						}
					});

					swiperOptions.breakpoints = breakpointsSettings;
				}

				if ( !this.isEdit && sliderSettings.autoplay ) {
					swiperOptions.autoplay = {
						delay: sliderSettings.autoplay_speed,
						disableOnInteraction: !!sliderSettings.pause_on_interaction
					};
				}

				return swiperOptions;
			}

			bindEvents() {
				const elementSettings = this.getElementSettings(),
					$action = this.elements.$gallery.data( 'action' );

				if ( $action === 'inline') {
					this.inlineVideoPlay();
				}

				if ( $action === 'lightbox') {
					this.lightboxVideoPlay();
				}

				if ( ! elementorFrontend.isEditMode() ) {
					if ( 'grid' === elementSettings.layout ) {
						this.initFilters();
					}
				}

				if ( 'carousel' === elementSettings.layout ) {
					this.initSlider();
				}
			}

			inlineVideoPlay() {
				const videoPlay = this.$element.find( '.pp-video-play' ),
					elementSettings = this.getElementSettings();
				let items = ( 'carousel' === elementSettings.layout ) ? this.elements.$swiperSlide : this.elements.$itemWrap;

				videoPlay.off( 'click' ).on( 'click', function( e ) {
					e.preventDefault();

					items.each( function() {
						let selector   = $(this).find( '.pp-video-player' ),
							videoThumb = $(this).find( '.pp-video-thumb-wrap' ),
							$iframe    = $(this).find('iframe');

						if ( selector.find( 'iframe' ).length ) {
							$iframe.remove();
							videoThumb.show();
						}
					});

					let $iframe    = $('<iframe/>'),
						vidSrc     = $(this).data( 'src' ),
						$player    = $(this).find( '.pp-video-player' ),
						videoThumb = $(this).find( '.pp-video-thumb-wrap' );

					$iframe.attr( 'src', vidSrc );
					$iframe.attr( 'frameborder', '0' );
					$iframe.attr( 'allowfullscreen', '1' );
					$iframe.attr( 'allow', 'autoplay;encrypted-media;' );
					videoThumb.hide();
					$player.append( $iframe );
				});
			}

			lightboxVideoPlay() {
				$.fancybox.defaults.media.dailymotion = {
					matcher : /dailymotion.com\/video\/(.*)\/?(.*)/,
					params : {
						additionalInfos : 0,
						autoStart : 1
					},
					type : 'iframe',
					url  : '//www.dailymotion.com/embed/video/$1'
				};
			}

			initFilters() {
				if ( this.elements.$gallery.hasClass('pp-video-gallery-filter-enabled') ) {
                    let $isotope_args = {
                            itemSelector    : '.pp-grid-item-wrap',
                            layoutMode		: 'fitRows',
                            percentPosition : true
                        },
                        $isotope_gallery = {};

                    this.$element.imagesLoaded( function() {
                        $isotope_gallery = this.elements.$gallery.isotope( $isotope_args );
                    }.bind(this) );

                    this.$element.on( 'click', '.pp-gallery-filter', function() {
                        let $this = $(this),
                            filterValue = $this.attr('data-filter');

                        $this.siblings().removeClass('pp-active');
                        $this.addClass('pp-active');

                        $isotope_gallery.isotope({ filter: filterValue });
                    });
                }
			}

			async initSlider() {
				const elementSettings = this.getElementSettings();

				const Swiper = elementorFrontend.utils.swiper;
    			this.swiper = await new Swiper(this.elements.$swiperContainer, this.getSwiperOptions());

				if ('yes' === elementSettings.pause_on_hover) {
					this.togglePauseOnHover(true);
				}
			}

			togglePauseOnHover(toggleOn) {
				if (toggleOn) {
					this.elements.$swiperContainer.on({
						mouseenter: () => {
							this.swiper.autoplay.stop();
						},
						mouseleave: () => {
							this.swiper.autoplay.start();
						}
					});
				} else {
					this.elements.$swiperContainer.off('mouseenter mouseleave');
				}
			}
		}

		elementorFrontend.elementsHandler.attachHandler( 'pp-video-gallery', VideoGalleryWidget );
	} );
})(jQuery);