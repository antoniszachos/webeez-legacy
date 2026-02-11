<?php
/**
 * Webeez Class
 *
 * @package  webeez
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Webeez' ) ) :

	/**
	 * The Webeez theme configuration class
	 */
	class Webeez {

		/**
		 * Class constructor
		 */
		public function __construct() {

			$this->init();
		}

		/**
		 * Class Initialization
		 */
		public function init() {

			add_action( 'after_setup_theme', array( $this, 'setup_theme' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
			add_action( 'login_enqueue_scripts', array( $this, 'enqueue_scripts_login' ) );
			add_action( 'widgets_init', array( $this, 'widgets_init' ) );
			add_filter( 'wp_nav_menu_args', array( $this, 'change_navigation_arguments' ) );
			add_action( 'template_redirect', array( $this, 'replace_strings' ), 10 );
			add_filter( 'wp_footer', array( $this, 'remove_core_block_supports' ) );
		}

		/**
		 * Sets up theme defaults and registers support for various features.
		 */
		public function setup_theme() {
			// Load text domain files.
			load_theme_textdomain( 'webeez', get_template_directory() . '/languages' );

			// Add theme support for title tag.
			add_theme_support( 'title-tag' );

			// Add RSS feed links to HTML head.
			add_theme_support( 'automatic-feed-links' );

			// Add support for custom header.
			add_theme_support( 'custom-header' );

			// Add support for custom background.
			add_theme_support( 'custom-background' );

			// Add support for responsive embeds.
			add_theme_support( 'responsive-embeds' );

			// Add support for align full and align wide option for the block editor.
			add_theme_support( 'align-wide' );

			// Add support for HTML5 markup in search forms, comment forms, comment lists, gallery, caption, widgets, style and script.
			$html5_args = array(
				'comment-list',
				'comment-form',
				'search-form',
				'gallery',
				'caption',
				'widgets',
				'style',
				'script',
			);
			add_theme_support( 'html5', $html5_args );

			// Add custom logo support.
			$custom_logo_args = array(
				'width'       => 300,
				'height'      => 22,
				'flex-width'  => true,
				'flex-height' => true,
			);

			add_theme_support( 'custom-logo', $custom_logo_args );

			// Add post thumbnail support.
			add_theme_support( 'post-thumbnails' );

			// Register menu locations.
			register_nav_menus(
				array(
					'nav-primary' => esc_html__( 'Primary Menu', 'webeez' ),
					'nav-mobile'  => esc_html__( 'Mobile Menu', 'webeez' ),
				)
			);

			// Disable Gutenberg Duotone Filter.
			remove_action( 'wp_body_open', 'wp_global_styles_render_svg_filters' );
			remove_action( 'in_admin_header', 'wp_global_styles_render_svg_filters' );

			// Disable Gutenberg widgets.
			remove_theme_support( 'widgets-block-editor' );

			// Remove id from menu item.
			add_filter( 'nav_menu_item_id', '__return_false' );

			// Add excerpt support for pages.
			add_post_type_support( 'page', 'excerpt' );

			// Remove auto generated excerpt feature.
			remove_filter( 'get_the_excerpt', 'wp_trim_excerpt' );

			// Remove <p> and <br/> from Contact Form 7.
			add_filter( 'wpcf7_autop_or_not', '__return_false' );

			// Add Custom image size for portfolio cover images.
			add_image_size( 'portfolio-cover', 415, 405, array( 'center', 'center' ) );
		}

		/**
		 * Enqueue scripts and styles.
		 */
		public function enqueue_scripts() {
			$version = wp_get_theme()->get( 'Version' );

			// Enqueue comment reply scripts.
			if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
				wp_enqueue_script( 'comment-reply' );
			}
			if ( is_admin() ) {
				return;
			}

			wp_dequeue_style( 'wc-blocks-style' );

			// Remove Global editor styles.
			wp_dequeue_style( 'global-styles' );

			// Remove Classic theme styles.
			wp_dequeue_style( 'classic-theme-styles' );

			wp_enqueue_style( 'adobe-typekit', 'https://use.typekit.net/sxx0puz.css', array(), $version );
			wp_enqueue_style( 'bootstrap-reboot', get_template_directory_uri() . '/assets/dist/css/vendor/bootstrap-reboot.min.css', array(), '5.0.2' );
			wp_enqueue_style( 'bootstrap-grid', get_template_directory_uri() . '/assets/dist/css/vendor/bootstrap-grid.min.css', array(), '5.0.2' );
			wp_enqueue_style( 'animate', get_template_directory_uri() . '/assets/dist/css/vendor/animate.min.css', array(), $version );
			wp_enqueue_style( 'slick', get_template_directory_uri() . '/assets/dist/css/vendor/slick.css', array(), $version );
			wp_enqueue_style( 'odometer', get_template_directory_uri() . '/assets/dist/css/vendor/odometer-theme-default.css', array(), '0.4.8' );
			wp_enqueue_style( 'styles', get_template_directory_uri() . '/assets/dist/css/styles.min.css', array(), $version );

			wp_enqueue_script( 'jquery' );

			wp_enqueue_script( 'jquery-appear', get_template_directory_uri() . '/assets/dist/js/vendor/jquery.appear.min.js', array(), $version, true );
			wp_enqueue_script( 'isotope-pkgd', get_template_directory_uri() . '/assets/dist/js/vendor/isotope.pkgd.min.js', array(), '3.0.6', true );
			wp_enqueue_script( 'slick-slider', get_template_directory_uri() . '/assets/dist/js/vendor/slick.min.js', array(), $version, true );
			wp_enqueue_script( 'odometer-script', get_template_directory_uri() . '/assets/dist/js/vendor/odometer.min.js', array(), '0.4.8', true );
			wp_enqueue_script( 'wow', get_template_directory_uri() . '/assets/dist/js/vendor/wow.js', array(), '1.0.1', true );
			wp_enqueue_script( 'scripts', get_template_directory_uri() . '/assets/dist/js/scripts.min.js', array(), $version, true );
		}

		/**
		 * Register login page styles
		 */
		public function enqueue_scripts_login() {
			wp_enqueue_style( 'admin-styles', get_template_directory_uri() . '/assets/dist/css/admin-styles.min.css', array(), wp_get_theme()->get( 'Version' ) );
		}

		/**
		 * Register widget area.
		 */
		public function widgets_init() {
			register_sidebar(
				array(
					'name'          => esc_html__( 'Telephone', 'webeez' ),
					'id'            => 'sidebar_phone',
					'before_widget' => '<div id="%1$s" class="widget %2$s">',
					'after_widget'  => '</div>',
					'before_title'  => '<h2 class="widget-title">',
					'after_title'   => '</h2>',
				)
			);

			register_sidebar(
				array(
					'name'          => esc_html__( 'Services Sidebar', 'webeez' ),
					'id'            => 'sidebar_services',
					'before_widget' => '<div id="%1$s" class="widget %2$s">',
					'after_widget'  => '</div>',
					'before_title'  => '<h3 class="widget-title">',
					'after_title'   => '</h3>',
				)
			);

			register_sidebar(
				array(
					'name'          => esc_html__( 'Footer Sidebar 1', 'webeez' ),
					'id'            => 'sidebar_footer_1',
					'before_widget' => '<div class="widget %2$s">',
					'after_widget'  => '</div> <!-- .widget -->',
					'before_title'  => '<div class="widget-title">',
					'after_title'   => '</div> <!-- .widget-title -->',
				)
			);

			register_sidebar(
				array(
					'name'          => esc_html__( 'Footer Sidebar 2', 'webeez' ),
					'id'            => 'sidebar_footer_2',
					'before_widget' => '<div class="widget %2$s">',
					'after_widget'  => '</div> <!-- .widget -->',
					'before_title'  => '<div class="widget-title">',
					'after_title'   => '</div> <!-- .widget-title -->',
				)
			);

			register_sidebar(
				array(
					'name'          => esc_html__( 'Footer Sidebar 3', 'webeez' ),
					'id'            => 'sidebar_footer_3',
					'before_widget' => '<div class="widget %2$s">',
					'after_widget'  => '</div> <!-- .widget -->',
					'before_title'  => '<div class="widget-title">',
					'after_title'   => '</div> <!-- .widget-title -->',
				)
			);

			register_sidebar(
				array(
					'name'          => esc_html__( 'Footer Sidebar 4', 'webeez' ),
					'id'            => 'sidebar_footer_4',
					'before_widget' => '<div class="widget %2$s">',
					'after_widget'  => '</div> <!-- .widget -->',
					'before_title'  => '<div class="widget-title">',
					'after_title'   => '</div> <!-- .widget-title -->',
				)
			);

			register_sidebar(
				array(
					'name'          => esc_html__( 'Footer Sidebar Bottom Left', 'webeez' ),
					'id'            => 'sidebar_footer_bottom_left',
					'before_widget' => '<div class="widget %2$s">',
					'after_widget'  => '</div> <!-- .widget -->',
					'before_title'  => '<div class="widget-title">',
					'after_title'   => '</div> <!-- .widget-title -->',
				)
			);

			register_sidebar(
				array(
					'name'          => esc_html__( 'Footer Sidebar Bottom Right', 'webeez' ),
					'id'            => 'sidebar_footer_bottom_right',
					'before_widget' => '<div class="widget %2$s">',
					'after_widget'  => '</div> <!-- .widget -->',
					'before_title'  => '<div class="widget-title">',
					'after_title'   => '</div> <!-- .widget-title -->',
				)
			);
		}

		/**
		 * Change default post navigation template
		 *
		 * @param array $args The array of arguments.
		 * @return array The modified array of arguments.
		 */
		public function change_navigation_arguments( $args ) {

			$args['container'] = false;

			if ( 'menu' == $args['menu_class'] ) {
				$args['items_wrap'] = '<nav class="nav nav-' . $args['menu']->slug . '"><ul class="%2$s">%3$s</ul></nav>';
			}

			return $args;
		}

		/**
		 * Replace strings from content to fix W3C Validator issues
		 */
		public function replace_strings() {
			ob_start(
				function ( $buffer ) {
					$buffer = str_replace( array( ' type="text/javascript"', " type='text/javascript'", 'type="text/css"', "type='text/css'", ' role="main"', ' cellspacing="0"', ' action=""', ' name="%ce%ae-%ce%ad"', ' frameborder="0"' ), '', $buffer );
					$buffer = str_replace( array( ' />', '/>' ), '>', $buffer );

					return $buffer;
				}
			);
		}

		/**
		 * Remove core block supports
		 */
		public function remove_core_block_supports() {
			wp_dequeue_style( 'core-block-supports' );
		}
	}

endif;

return new Webeez();
