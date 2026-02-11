/* global google, WOW */
/* eslint-env jquery */

'use strict';

jQuery( function( $ ) {

	/*
	 * ---------------------------------------------------------------
	 * Mobile Menu
	 * ---------------------------------------------------------------
	 */

	/*
	 * Event: OnClick - Show mobile menu button
	 *
	 * Show mobile menu sidebar & body overlay
	 */

	$(document).on('click', '#showMobileMenu', function (event) {
		event.preventDefault();
		$('#sidebarNav').addClass('sidebar-nav--visible');
		$('#bodyOverlay').addClass('body-overlay--visible');
		$(this).addClass('btn-menu--open');
	});

	/*
	 * Event: OnClick - Hide mobile menu button
	 *
	 * Hide mobile menu sidebar & body overlay
	 */

	$(document).on('click', '#hideMobileMenu', function (event) {
		event.preventDefault();
		$('#sidebarNav').removeClass('sidebar-nav--visible');
		$('#bodyOverlay').removeClass('body-overlay--visible');
		$('#showMobileMenu').removeClass('btn-menu--open');
	});

	/*
	 * Event: OnClick - Mobile menu toggler
	 *
	 * Show / Hide mobile sub menu
	 */

	$(document).on('click', '.menu-toggler', function (event) {
		event.preventDefault();
		const button = $(this);
		const link = button.parent();
		const sub = link.siblings('.menu-mobile-sub-wrapper');

		if (link.hasClass('menu-link--visible')) {
			sub.slideToggle();
			link.removeClass('menu-link--visible');
			button.removeClass('menu-toggler--open');
		} else {
			sub.slideToggle();
			link.addClass('menu-link--visible');
			button.addClass('menu-toggler--open');
		}
	});

	/*
	 * Event: OnClick - Body overlay
	 *
	 * Hide overlay, mobile menu and mini cart if open
	 */

	$(document).on('click', '#bodyOverlay', function (event) {
		event.preventDefault();
		const menu = $('#sidebarNav');
		const button = $('#showMobileMenu');

		if (menu.hasClass('sidebar-nav--visible')) {
			menu.removeClass('sidebar-nav--visible');
		}

		if (button.hasClass('btn-menu--open')) {
			button.removeClass('btn-menu--open');
		}

		$(this).removeClass('body-overlay--visible');
	});

	/*
	 * ---------------------------------------------------------------
	 * Scroll Actions
	 * ---------------------------------------------------------------
	 */

	/*
	 * Event: OnScroll - Main window scroll
	 *
	 * Update horizontal scroll indicator bar when scrolling
	 */

	$( window ).on( 'scroll', function () {
		const docHeight = $( '.site-wrapper' ).height();
		const winHeight = $( window ).height();
		const viewport = docHeight - winHeight;
		const scrollPos = $( this ).scrollTop();
		const scrollPercent = ( scrollPos / viewport ) * 100;
		$( '.scroll-indicator__inner' ).css( 'width', scrollPercent + '%' );

		if ( $( '#masthead' ).length ) {
			const headerScrollPos = 120;
			const sticky = $( '#masthead' );

			if ( $( window ).scrollTop() > headerScrollPos ) {
				sticky.addClass( 'site-header--sticky' );
				$( '#scrollTop' ).addClass( 'btn-scroll-top--visible' );
			} else if ( $( this ).scrollTop() <= headerScrollPos ) {
				sticky.removeClass( 'site-header--sticky' );
				$( '#scrollTop' ).removeClass( 'btn-scroll-top--visible' );
			}
		}
    } );

	/*
	 * Event: OnClick - Scroll top button
	 *
	 * Scroll to top
	 */

	if ( $( '#scrollTop' ).length ) {
		$( '#scrollTop' ).on( 'click', function ( event ) {
			event.preventDefault();
			const target = $( this ).attr( 'data-target' );
			$( 'html, body' ).animate( {
				scrollTop: $( target ).offset().top,
				},
				1000
			);
		} );
	}

	/*
	 * Event: OnClick - Scroll to button
	 *
	 * Scroll to section welcome
	 */

	$( document ).on( 'click', '#scrollTo', function( event ) {
		event.preventDefault();
		const gutter = 70;
		$( 'html, body' ).animate( { scrollTop: ( $( '#sectionWelcome' ).offset().top - gutter ) }, 800 );
	} );

	/*
	 * ---------------------------------------------------------------
	 * Sliders
	 * ---------------------------------------------------------------
	 */

	/*
	 * Slider History
	 */

	$( '#sliderHistory' ).slick( {
		mobileFirst:	true,
		dots:           false,
		infinite:       true,
		prevArrow:      false,
		nextArrow:      false,
		autoplay:       false,
  		autoplaySpeed:  10000,
		speed:          1000,
		slidesToShow:   1,
		slidesToScroll: 1,
		pauseOnHover:   true,
		adaptiveHeight: true,
		responsive: [
			{
				breakpoint: 768,
				settings: {
					adaptiveHeight: false,
				},
			},
		],
	} );

	/*
	 * Event: OnClick - Slider paging list item
	 *
	 * Navigate to slide
	 */

	$( document ).on( 'click', '.slider-paging li', function( event ) {
		event.preventDefault();
		const attrClass = $(this).attr('class');
		const index = attrClass.substr(4);
		$('#sliderHistory').slick('slickGoTo', index - 1);
	} );

	/*
	 * Event: BeforeChange - Slide
	 *
	 * Add styles to slide paging list item
	 */

	$('#sliderHistory').on('beforeChange', function(event, slick, currentSlide, nextSlide) {
		const page = '.page' + (nextSlide + 1);
		$('.slider-paging li').removeClass('selected');
		$(page).addClass('selected');
	});

	/*
	 * Slider Testimonials - Customer
	 */

	$( '#sliderCustomers' ).slick( {
		dots:           false,
		infinite:       false,
		prevArrow:      false,
		nextArrow:      false,
		speed:          1000,
		slidesToShow:   4,
		slidesToScroll: 1,
		asNavFor:       '#sliderTestimonials',
        focusOnSelect:  true,
		centerMode:     false,
	} );

	/*
	 * Slider Testimonials - Review
	 */

	$( '#sliderTestimonials' ).slick( {
		dots:          true,
		infinite:      false,
		prevArrow:     false,
		nextArrow:     false,
		autoplay:      false,
  		autoplaySpeed: 3000,
		speed:         1000,
		asNavFor:      '#sliderCustomers'
	} );

	/*
	 * Slider Brands
	 */

	$( '#sliderBrands' ).slick( {
		mobileFirst:	true,
		dots:           false,
		infinite:       true,
		prevArrow:      false,
		nextArrow:      false,
		autoplay:       true,
  		autoplaySpeed:  3000,
		speed:          1000,
		slidesToShow:   3,
		slidesToScroll: 1,
		pauseOnHover:   false,
		variableWidth:  false,
		centerMode:     true,
		centerPadding:  0,
		responsive: [
			{
				breakpoint: 768,
				settings: {
					slidesToShow: 8,
				},
			},
		],
	} );

	/*
	 * ---------------------------------------------------------------
	 * Odometer
	 * ---------------------------------------------------------------
	 */

	/*
	 * Initialize Odometer
	 */

	if ($(".odometer").length) {
		var odo = $(".odometer");
		odo.each(function () {
			$(this).appear(function () {
				var countNumber = $(this).attr("data-count");
				$(this).html(countNumber);
			});
		});
	}

	/*
	 * ---------------------------------------------------------------
	 * Accordion
	 * ---------------------------------------------------------------
	 */

	/*
	 * Initialize Accordion
	 */

    if ( $( '.accordion' ).length ) {
        const  accordion = $( '.accordion' );
		accordion.each( function () {
            const self = $( this );
            const item = self.find( '.wp-block-group' );
            self.find( 'p' ).hide();
            self.find( '.active' ).find( 'p' ).show();
            item.each( function () {
                $( this )
                    .find( '.wp-block-heading' )
                    .on( 'click', function () {
                        if ( $( this ).parent().hasClass( 'active' ) === false ) {
                            $( '.accordion' ).find( '.wp-block-group' ).removeClass( 'active' );
							$( '.accordion' ).find( '.wp-block-group' ).find( 'p' ).slideUp();
                            $( this ).parent().addClass( 'active' );
                            $( this ).parent().find( 'p' ).slideDown();
                        }
                    } );
            } );
        } );
    }

	/*
	 * ---------------------------------------------------------------
	 * Portfolio
	 * ---------------------------------------------------------------
	 */

	/*
	 * Initialize Isotope
	 */

	const grid = $( '.portfolio__content' ).isotope( {
		itemSelector: '.portfolio__content-item',
		resizable: true,
		layoutMode: 'fitRows',
		transitionDuration: '0.8s'
	} );

	/*
	 * Event: OnClick Portfolio filter link
	 *
	 * Filter portfolio items
	 */

	$( document ).on( 'click', '.portfolio__filter-link', function( event ) {
		event.preventDefault();
		const filter = $( this ).data( 'filter' );

		$( '.portfolio__filter-link' ).removeClass( 'portfolio__filter-link--active' );
		$( this ).addClass( 'portfolio__filter-link--active' );

		if ( filter === 'all' ) {
			grid.isotope( { filter: '*' } );
		} else {
			grid.isotope( { filter: '.' + filter } );
		}
	} );

	/*
	 * ---------------------------------------------------------------
	 * Progress bars
	 * ---------------------------------------------------------------
	 */

	/*
	 * Initialize progress bars
	 */

	if ( $( '.progress-bar' ).length ) {
		$( '.progress-bar' ).appear( function () {
			const el = $( this );
			const percent = el.data( 'percent' );
			$( el ).css( 'width', percent ).addClass( 'progress-bar--counted' );
		}, {
			accY: -50
		} );
	}

	/*
	 * ---------------------------------------------------------------
	 * Block Animations : Wow
	 * ---------------------------------------------------------------
	 */

	/*
	 * Initialize Wow
	 */

	if ( $( '.reveal' ).length ) {
        const reveal = new WOW( {
            boxClass:     'reveal',
            animateClass: 'animated',
            mobile:        true,
            live:          true,
        } );
        reveal.init();
    }
} );
