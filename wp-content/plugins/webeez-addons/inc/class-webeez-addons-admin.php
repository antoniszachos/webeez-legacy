<?php
/**
 * Webeez Addons plugin admin class
 *
 * @package webeez-addons
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Webeez_Addons_Admin' ) ) :

	/**
	 * Webeez Addons plugin admin class definition
	 */
	class Webeez_Addons_Admin {

		/**
		 * Class Constructor
		 */
		public function __construct() {}

		/**
		 * Initialize plugin
		 */
		public function init() {
			add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ), 20 );
			add_action( 'add_meta_boxes', array( $this, 'add_page_meta_box' ), 10, 1 );
			add_action( 'add_meta_boxes', array( $this, 'add_project_meta_box' ), 20, 1 );
			add_action( 'save_post', array( $this, 'save_page_icon_meta_box_content' ), 10, 1 );
			add_action( 'save_post', array( $this, 'save_project_details_meta_box_content' ), 20, 1 );
		}

		/**
		 * Enqueue Admin Styles & Scripts
		 */
		public function admin_enqueue_scripts() {
			$plugin_data = get_plugin_data( WEBEEZ_ADDONS_PATH . '/webeez-addons.php' );

			wp_enqueue_style( 'webeez-addons', WEBEEZ_ADDONS_URL . 'assets/css/styles.min.css', array(), $plugin_data['Version'] );
		}

		/**
		 * Adds the page meta box container.
		 *
		 * @param string $post_type Post type.
		 */
		public function add_page_meta_box( $post_type ) {
			add_meta_box(
				'page_icon_meta_box_',
				esc_html__( 'Page Icon', 'webeez-addons' ),
				array( $this, 'page_icon_meta_box_content' ),
				'page',
				'side'
			);
		}

		/**
		 * Adds the project meta box container.
		 *
		 * @param string $post_type Post type.
		 */
		public function add_project_meta_box( $post_type ) {
			add_meta_box(
				'project_details_meta_box_',
				esc_html__( 'Project Details', 'webeez-addons' ),
				array( $this, 'project_details_meta_box_content' ),
				'project',
				'advanced'
			);
		}

		/**
		 * Render page icon meta box content.
		 *
		 * @param WP_Post $post The post object.
		 */
		public function page_icon_meta_box_content( $post ) {

			wp_nonce_field( 'page_icon_meta_box_content', 'page_icon_meta_box_content_nonce' );

			$svg_icon = get_post_meta( $post->ID, '_wbz_page_svg_icon', true );
			?>

			<div class='meta-box'>
				<div class="meta-box-col">
					<label for="pageSvgIcon"><?php esc_html_e( 'SVG source code', 'webeez-addons' ); ?></label>
					<textarea name="wbz_page_svg_icon" id="pageSvgIcon"><?php echo esc_html( $svg_icon ); ?></textarea>
				</div> <!-- .meta-box-col -->
			</div><!-- .meta-box -->
			<?php
		}

		/**
		 * Render project icon meta box content.
		 *
		 * @param WP_Post $post The post object.
		 */
		public function project_details_meta_box_content( $post ) {

			wp_nonce_field( 'project_details_meta_box_content', 'project_details_meta_box_content_nonce' );

			$url = get_post_meta( $post->ID, '_wbz_project_url', true );
			$client = get_post_meta( $post->ID, '_wbz_project_client', true );
			?>

			<div class='meta-box'>
				<div class="meta-box-row">
					<label for="projectURL"><?php esc_html_e( 'URL', 'webeez-addons' ); ?></label>
					<input type="text" name="wbz_project_url" id="projectURL" value="<?php echo esc_url( $url ); ?>" class="input-large">
				</div> <!-- .meta-box-row -->
				<div class="meta-box-row">
					<label for="projectClient"><?php esc_html_e( 'Client', 'webeez-addons' ); ?></label>
					<input type="text" name="wbz_project_client" id="projectClient" value="<?php echo esc_attr( $client ); ?>" class="input-medium">
				</div> <!-- .meta-box-row -->
			</div><!-- .meta-box -->
			<?php
		}


		/**
		 * Save the page icon meta when the post is saved.
		 *
		 * @param int $post_id The ID of the post being saved.
		 */
		public function save_page_icon_meta_box_content( $post_id ) {

			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
				return $post_id;
			}

			$is_autosave = wp_is_post_autosave( $post_id );
			$is_revision = wp_is_post_revision( $post_id );

			if ( $is_autosave || $is_revision ) {
				return;
			}

			if ( ! current_user_can( 'edit_page', $post_id ) ) {
				return;
			}

			if ( isset( $_POST['post_type'] ) && 'page' != $_POST['post_type'] ) {
				return;
			}

			if ( isset( $_POST['page_icon_meta_box_content_nonce'] ) && wp_verify_nonce( sanitize_key( $_POST['page_icon_meta_box_content_nonce'] ), 'page_icon_meta_box_content' ) ) {
				if ( isset( $_POST['wbz_page_svg_icon'] ) ) {
					update_post_meta(
						$post_id,
						'_wbz_page_svg_icon',
						wp_kses(
							wp_unslash( $_POST['wbz_page_svg_icon'] ),
							array(
								'svg' => array(
									'viewbox' => true,
								),
								'circle' => array(
									'cx' => true,
									'cy' => true,
									'r' => true,
									'transform' => true,
									'style' => true,
									'class' => true,
								),
								'path' => array(
									'd' => true,
									'class' => true,
									'fill-rule' => true,
									'style' => true,
									'transform' => true,
								),
								'rect' => array(
									'x' => true,
									'y' => true,
									'width' => true,
									'height' => true,
									'transform' => true,
									'style' => true,
									'class' => true,
								),
								'g' => array(
									'clip-path' => true,
									'transform' => true,
								),
							)
						)
					);
				}
			}
		}

		/**
		 * Save the project details meta when the post is saved.
		 *
		 * @param int $post_id The ID of the post being saved.
		 */
		public function save_project_details_meta_box_content( $post_id ) {

			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
				return $post_id;
			}

			$is_autosave = wp_is_post_autosave( $post_id );
			$is_revision = wp_is_post_revision( $post_id );

			if ( $is_autosave || $is_revision ) {
				return;
			}

			if ( ! current_user_can( 'edit_page', $post_id ) ) {
				return;
			}

			if ( isset( $_POST['post_type'] ) && 'project' != $_POST['post_type'] ) {
				return;
			}

			if ( isset( $_POST['project_details_meta_box_content_nonce'] ) && wp_verify_nonce( sanitize_key( $_POST['project_details_meta_box_content_nonce'] ), 'project_details_meta_box_content' ) ) {
				if ( isset( $_POST['wbz_project_url'] ) ) {
					update_post_meta( $post_id, '_wbz_project_url', esc_url_raw( wp_unslash( $_POST['wbz_project_url'] ) ) );
				}

				if ( isset( $_POST['wbz_project_client'] ) ) {
					update_post_meta( $post_id, '_wbz_project_client', sanitize_text_field( wp_unslash( $_POST['wbz_project_client'] ) ) );
				}
			}
		}
	}

endif;

