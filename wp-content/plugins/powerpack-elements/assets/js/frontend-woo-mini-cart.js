;(function($) {

	PPWooMiniCart = function($scope) {
		this.node      = $scope;
		this.wrap      = $scope.find('.pp-woo-mini-cart-container');
		this.behaviour = this.wrap.data('target');

		this._init();
	};

	PPWooMiniCart.prototype = {
		id: '',
		node: '',
		wrap: '',
		element: '',
		behaviour: '',
		isPreview: false,

		_init: function() {
			this.element = this.node.find('a.pp-woo-cart-contents');
			
			this._bindEvents();
		},

		_bindEvents: function() {
			var self = this;

			if ( 'on-click' === this.behaviour ) {
				this.element.on('click', $.proxy( this._toggleCart, this ) );
			}

			if ( 'on-hover' === this.behaviour ) {
				this.element.on('mouseover', function(e) {
					e.preventDefault();

					self._showCart();
				});
				this.node.find('.pp-woo-mini-cart-wrap').on('mouseover', function(e) {
					e.preventDefault();

					self._showCart();
				});
				this.element.on('mouseout', function(e) {
					e.preventDefault();

					self._hideCart();
				});
				this.node.find('.pp-woo-mini-cart-wrap').on('mouseout', function(e) {
					e.preventDefault();

					self._hideCart();
				});
			}

			if( this.wrap.hasClass( 'pp-woo-mini-cart-preview' ) ) {
				setTimeout( function() {
					self._togglePreview();
				}, 200 );
			}

			$(document).on('click', function(e) {
				if ( ! self.isPreview ) {
					if ( ! self.wrap.is(e.target) && self.wrap.has(e.target).length === 0 && e.which ) {
						self._hideCart();
					}
				}
			});
		},

		_showCart: function() {
			this.node.find('.pp-woo-mini-cart-wrap').addClass('show-mini-cart');
		},

		_hideCart: function() {
			this.node.find('.pp-woo-mini-cart-wrap').removeClass('show-mini-cart');
		},

		_toggleCart: function(e) {
			e.preventDefault();
			this.node.find('.pp-woo-mini-cart-wrap').toggleClass('show-mini-cart');
		},

		_togglePreview: function() {
			if ( ! this.isPreview ) {
				this.isPreview = true;
				this._showCart();
			} else {
				this.isPreview = false;
				this._hideCart();
			}
		},

		_renderPreview: function() {
			this.isPreview = true;
			this._showCart();
		},
	};

	var WooMiniCartHandler = function ($scope) {
		new PPWooMiniCart( $scope );
	};

	$(window).on('elementor/frontend/init', function () {
		elementorFrontend.hooks.addAction( 'frontend/element_ready/pp-woo-mini-cart.default', WooMiniCartHandler );
    });

})( jQuery );
