<?php
/**
 * The Editor Class
 *
 * @package webeez-addons
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Webeez_Addons_Editor' ) ) :

	/**
	 * The Editor configuration class
	 */
	class Webeez_Addons_Editor {

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
			add_action( 'admin_init', array( $this, 'add_editor_styles' ) );
			add_action( 'init', array( $this, 'reset_editor' ), 10 );
			add_action( 'init', array( $this, 'set_theme_colors' ), 20 );
			add_action( 'init', array( $this, 'set_font_sizes' ), 30 );
			add_action( 'enqueue_block_editor_assets', array( $this, 'register_blocks' ) );
		}

		/**
		 * Add editor custom styles
		 */
		public function add_editor_styles() {
			wp_enqueue_style( 'adobe-typekit', 'https://use.typekit.net/sxx0puz.css', array(), '1.0.0' );

			// Add support for editor styles.
			add_theme_support( 'editor-styles' );
			// Add custom style to visual editor.
			add_editor_style( './assets/css/editor.min.css' );
		}

		/**
		 * Reset editor
		 */
		public function reset_editor() {
			// Add support for default Gutenberg block styles.
			add_theme_support( 'wp-block-styles' );
		}

		/**
		 * Setup theme color palette
		 */
		public function set_theme_colors() {

			// Editor Color Palette.
			add_theme_support(
				'editor-color-palette',
				array(
					array(
						'name'  => 'White',
						'slug'  => 'white',
						'color' => '#ffffff',
					),
					array(
						'name'  => 'Black',
						'slug'  => 'black',
						'color' => '#000000',
					),
					array(
						'name'  => 'Primary',
						'slug'  => 'primary',
						'color' => '#fc653c',
					),
					array(
						'name'  => 'Secondary',
						'slug'  => 'secondary',
						'color' => '#626265',
					),
				)
			);
		}

		/**
		 * Setup theme font-sizes
		 */
		public function set_font_sizes() {

			// Editor Color Palette.
			add_theme_support(
				'editor-font-sizes',
				array(
					array(
						'name'  => 'XS',
						'slug'  => 'xs',
						'size'  => 12,
					),
					array(
						'name'  => 'S',
						'slug'  => 's',
						'size'  => 14,
					),
					array(
						'name'  => 'Base',
						'slug'  => 'base',
						'size'  => 16,
					),
					array(
						'name'  => 'M',
						'slug'  => 'm',
						'size'  => 18,
					),
					array(
						'name'  => 'L',
						'slug'  => 'l',
						'size'  => 21,
					),
					array(
						'name'  => 'XL',
						'slug'  => 'xl',
						'size'  => 24,
					),
					array(
						'name'  => 'XXL',
						'slug'  => 'xxl',
						'size'  => 32,
					),
					array(
						'name'  => 'XXXL',
						'slug'  => 'xxxl',
						'size'  => 80,
					),

				)
			);
		}

		/**
		 * Register theme specific blocks
		 */
		public function register_blocks() {}
	}

endif;

return new Webeez_Addons_Editor();
