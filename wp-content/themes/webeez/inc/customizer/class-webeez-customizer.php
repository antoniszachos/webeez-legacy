<?php
/**
 * Webeez Customizer Class
 *
 * @package webeez
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Webeez_Customizer' ) ) :

	/**
	 * Restart Diet customizer class
	 */
	class Webeez_Customizer {

		/**
		 * Class constructor
		 */
		public function __construct() {

			add_action( 'customize_register', array( $this, 'add_custom_sections' ), 1 );
			add_action( 'customize_register', array( $this, 'remove_sections' ) );
		}

		/**
		 * Add custom logos options
		 *
		 * @param WP_Customize_Manager $wp_customize Instance of the WP_Customize_Manager class.
		 */
		public function add_custom_sections( $wp_customize ) {

			$wp_customize->add_setting(
				'svg-logo',
				array(
					'sanitize_callback' => array( $this, 'sanitize_svg_html' ),
				)
			);

			$wp_customize->add_control(
				new WP_Customize_Control(
					$wp_customize,
					'svg-logo-src',
					array(
						'label'   => esc_html__( 'SVG logo source code', 'webeez' ),
						'section'  => 'title_tagline',
						'settings' => 'svg-logo',
						'type'     => 'textarea',
						'priority' => 10,
					)
				)
			);
		}

		/**
		 * Custom sanitization function for svg logo
		 *
		 * @param mixed $code SVG textarea control contents.
		 */
		public function sanitize_svg_html( $code ) {
			return wp_kses(
				$code,
				array(
					'svg' => array(
						'viewbox' => true,
					),
					'path' => array(
						'd' => true,
						'class' => true,
						'fill-rule' => true,
					),
				)
			);
		}

		/**
		 * Remove sections
		 *
		 * @param WP_Customize_Manager $wp_customize Instance of the WP_Customize_Manager class.
		 */
		public function remove_sections( $wp_customize ) {

			// Remove Colors Section.
			$wp_customize->remove_section( 'colors' );

			// Remove Custom CSS Section.
			$wp_customize->remove_section( 'custom_css' );
		}
	}

endif;

return new Webeez_Customizer();
