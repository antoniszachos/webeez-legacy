<?php
/**
 * Webeez Addons plugin main class
 *
 * @package webeez-addons
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Webeez_Addons' ) ) :

	/**
	 * Webeez Addons plugin main class definition
	 */
	class Webeez_Addons {

		/**
		 * Class Constructor
		 */
		public function __construct() {}

		/**
		 * Initialize plugin
		 */
		public function init() {
			add_action( 'plugins_loaded', array( $this, 'setup' ) );
			add_shortcode( 'expertise', array( $this, 'display_expertise' ), 1 );
			add_shortcode( 'services', array( $this, 'display_services' ), 1 );
			add_shortcode( 'projects', array( $this, 'display_projects' ), 1 );
			add_action( 'init', array( $this, 'create_project' ), 0 );
			add_action( 'init', array( $this, 'create_project_category' ), 0 );
		}

		/**
		 * Setup
		 */
		public function setup() {

			load_textdomain( 'webeez-addons', WEBEEZ_ADDONS_PATH . 'languages/' . get_locale() . '.mo' );
		}

		/**
		 * Activation
		 */
		public function activate() {

			flush_rewrite_rules();
		}

		/**
		 * Deactivation Plugin
		 */
		public function deactivate() {

			flush_rewrite_rules();
		}

		/**
		 * Cleanup database
		 */
		public function clean() {}

		/**
		 * Display expertise
		 *
		 * @param array $arguments Short code arguments.
		 * @return string Shortcode html
		 */
		public function display_expertise( $arguments ) {

			$page_ids = array();
			if ( isset( $arguments['ids'] ) ) {
				$page_ids = explode( ',', $arguments['ids'] );
			}

			$output = '';
			$counter = 0.2;

			if ( ! empty( $page_ids ) ) {
				$output .= '<div class="section-expertise__wrapper">';
				foreach ( $page_ids as $page_id ) {

					$id = trim( $page_id );

					$title     = get_the_title( $id );
					$image     = get_the_post_thumbnail( $id, 'full' );
					$excerpt   = get_the_excerpt( $id );
					$permalink = get_the_permalink( $id );
					$icon      = get_post_meta( $id, '_wbz_page_svg_icon', true );

					$output .= '<div class="section-expertise__box reveal fadeInUp" data-wow-delay="' . esc_attr( $counter ) . 's">';
					$output .= '<div class="section-expertise__box-icon">';
					$output .= $icon;
					$output .= '</div> <!-- .expertise__box-icon -->';
					$output .= '<h2 class="section-expertise__box-title">' . $title . '</h2>';
					$output .= '<p class="section-expertise__box-text">' . $excerpt . '</p>';
					$output .= '<a href="' . $permalink . '" class="section-expertise__box-link">';
					$output .= '<span class="icon-right-arrow"></span>';
					$output .= '<span class="sr-only">' . esc_html__( 'Read More', 'webeez-addons' ) . '</span>';
					$output .= '</a> <!-- .section-expertise__box-link -->';
					$output .= '</div> <!-- .section-expertise__box -->';

					$counter += 0.2;
				}
				$output .= '</div> <!-- .section-expertise__wrapper -->';
			} else {
				$output .= '<div class="error-message">' . esc_html__( 'No featured services were found', 'webeez-addons' ) . '</div> <!-- .error-message -->';
			}

			wp_reset_postdata();
			return $output;
		}

		/**
		 * Display services
		 *
		 * @param array $arguments Short code arguments.
		 * @return string Shortcode html
		 */
		public function display_services( $arguments ) {

			$page_ids = array();
			if ( isset( $arguments['ids'] ) ) {
				$page_ids = explode( ',', $arguments['ids'] );
			}

			$output = '';
			$counter = 0.2;

			if ( ! empty( $page_ids ) ) {
				$output .= '<div class="section-services__wrapper">';
				foreach ( $page_ids as $page_id ) {

					$id = trim( $page_id );

					$title     = get_the_title( $id );
					$image     = get_the_post_thumbnail( $id, 'full' );
					$excerpt   = get_the_excerpt( $id );
					$permalink = get_the_permalink( $id );
					$icon      = get_post_meta( $id, '_wbz_page_svg_icon', true );

					$output .= '<div class="section-services__box reveal fadeInUp" data-wow-delay="' . esc_attr( $counter ) . 's">';
					$output .= '<div class="section-services__box-icon">';
					$output .= $icon;
					$output .= '</div> <!-- .services__box-icon -->';
					$output .= '<h2 class="section-services__box-title">' . $title . '</h2>';
					$output .= '<p class="section-services__box-text">' . $excerpt . '</p>';
					$output .= '<a href="' . $permalink . '" class="section-services__box-link">';
					$output .= '<span class="icon-right-arrow"></span>';
					$output .= '<span class="sr-only">' . esc_html__( 'Read More', 'webeez-addons' ) . '</span>';
					$output .= '</a> <!-- .section-services__box-link -->';
					$output .= '</div> <!-- .section-services__box -->';

					$counter += 0.2;
				}
				$output .= '</div> <!-- .section-services__wrapper -->';
			} else {
				$output .= '<div class="error-message">' . esc_html__( 'No featured services were found', 'webeez-addons' ) . '</div> <!-- .error-message -->';
			}

			wp_reset_postdata();
			return $output;
		}

		/**
		 * Register custom post type Project
		 */
		public function create_project() {

			$labels = array(
				'name'                  => __( 'Projects', 'webeez-addons' ),
				'singular_name'         => __( 'Project', 'webeez-addons' ),
				'menu_name'             => __( 'Projects', 'webeez-addons' ),
				'name_admin_bar'        => __( 'Projects', 'webeez-addons' ),
				'archives'              => __( 'Project Archives', 'webeez-addons' ),
				'attributes'            => __( 'Project Attributes', 'webeez-addons' ),
				'parent_item_colon'     => __( 'Parent Item:', 'webeez-addons' ),
				'all_items'             => __( 'All Projects', 'webeez-addons' ),
				'add_new_item'          => __( 'Add New Project', 'webeez-addons' ),
				'add_new'               => __( 'Add new project', 'webeez-addons' ),
				'new_item'              => __( 'New Project', 'webeez-addons' ),
				'edit_item'             => __( 'Edit Project', 'webeez-addons' ),
				'update_item'           => __( 'Update Project', 'webeez-addons' ),
				'view_item'             => __( 'View Project', 'webeez-addons' ),
				'view_items'            => __( 'View Projects', 'webeez-addons' ),
				'search_items'          => __( 'Search Project', 'webeez-addons' ),
				'not_found'             => __( 'No Projects Found', 'webeez-addons' ),
				'not_found_in_trash'    => __( 'No Projects found in Trash', 'webeez-addons' ),
				'featured_image'        => __( 'Featured Image', 'webeez-addons' ),
				'set_featured_image'    => __( 'Set featured image', 'webeez-addons' ),
				'remove_featured_image' => __( 'Remove featured image', 'webeez-addons' ),
				'use_featured_image'    => __( 'Use as featured image', 'webeez-addons' ),
				'insert_into_item'      => __( 'Insert into project', 'webeez-addons' ),
				'uploaded_to_this_item' => __( 'Uploaded to this item', 'webeez-addons' ),
				'items_list'            => __( 'Projects list', 'webeez-addons' ),
				'items_list_navigation' => __( 'Projects list navigation', 'webeez-addons' ),
				'filter_items_list'     => __( 'Filter projects list', 'webeez-addons' ),
			);
			$args = array(
				'label'                 => __( 'Project', 'webeez-addons' ),
				'description'           => __( 'Custom post type for managing projects', 'webeez-addons' ),
				'labels'                => $labels,
				'supports'              => array( 'title', 'editor', 'thumbnail' ),
				'taxonomies'            => array( 'project_category' ),
				'hierarchical'          => false,
				'public'                => true,
				'show_ui'               => true,
				'show_in_menu'          => true,
				'menu_position'         => 8,
				'menu_icon'             => 'dashicons-media-spreadsheet',
				'show_in_admin_bar'     => true,
				'show_in_nav_menus'     => true,
				'can_export'            => true,
				'has_archive'           => false,
				'exclude_from_search'   => false,
				'publicly_queryable'    => true,
				'query_var'             => 'project',
				'capability_type'       => 'page',
			);

			register_post_type( 'project', $args );
		}

		/**
		 * Register custom taxonomy Project Category
		 */
		public function create_project_category() {

			$labels = array(
				'name'                       => _x( 'Categories', 'Taxonomy General Name', 'webeez-addons' ),
				'singular_name'              => _x( 'Category', 'Taxonomy Singular Name', 'webeez-addons' ),
				'menu_name'                  => __( 'Category', 'webeez-addons' ),
				'all_items'                  => __( 'All Categories', 'webeez-addons' ),
				'parent_item'                => __( 'Parent Category', 'webeez-addons' ),
				'parent_item_colon'          => __( 'Parent Category:', 'webeez-addons' ),
				'new_item_name'              => __( 'New Category Name', 'webeez-addons' ),
				'add_new_item'               => __( 'Add New Category', 'webeez-addons' ),
				'edit_item'                  => __( 'Edit Category', 'webeez-addons' ),
				'update_item'                => __( 'Update Category', 'webeez-addons' ),
				'view_item'                  => __( 'View Category', 'webeez-addons' ),
				'separate_items_with_commas' => __( 'Separate categories with commas', 'webeez-addons' ),
				'add_or_remove_items'        => __( 'Add or remove categories', 'webeez-addons' ),
				'choose_from_most_used'      => __( 'Choose from the most used', 'webeez-addons' ),
				'popular_items'              => __( 'Popular Categories', 'webeez-addons' ),
				'search_items'               => __( 'Search Categories', 'webeez-addons' ),
				'not_found'                  => __( 'Not Found', 'webeez-addons' ),
				'no_terms'                   => __( 'No categories', 'webeez-addons' ),
				'items_list'                 => __( 'Categories list', 'webeez-addons' ),
				'items_list_navigation'      => __( 'Categories list navigation', 'webeez-addons' ),
			);
			$args = array(
				'labels'                     => $labels,
				'hierarchical'               => false,
				'public'                     => true,
				'show_ui'                    => true,
				'show_admin_column'          => true,
				'show_in_nav_menus'          => true,
				'show_tagcloud'              => true,
			);

			register_taxonomy( 'project_category', array( 'project' ), $args );
		}

		/**
		 * Display projects all
		 *
		 * @param array $arguments Short code arguments.
		 * @return string Shortcode html
		 */
		public function display_projects( $arguments ) {

			$args = array(
				'post_type' => 'project',
				'posts_per_page' => -1,
			);

			$page_ids = array();
			if ( isset( $arguments['ids'] ) ) {
				$page_ids = explode( ',', $arguments['ids'] );

				$args = array(
					'post_type' => 'project',
					'post__in' => $page_ids,
				);
			}

			$query = new WP_Query( $args );
			$output = '';

			if ( $query->have_posts() ) {
				$output .= '<div class="portfolio">';
				$output .= '<nav class="portfolio__filter">';
				$output .= '<ul class="portfolio__filter-list">';
				$output .= '<li class="portfolio__filter-item">';
				$output .= '<a href="#" class="portfolio__filter-link portfolio__filter-link--active" data-filter="all">' . esc_html__( 'All', 'webeez-addons' ) . '</a>';
				$output .= '</li> <!-- .portfolio__filter-item -->';

				$terms = get_terms(
					array(
						'taxonomy'   => 'project_category',
						'hide_empty' => true,
					)
				);

				foreach ( $terms as $term ) {
					$output .= '<li class="portfolio__filter-item">';
					$output .= '<a href="#" class="portfolio__filter-link" data-filter="' . esc_attr( $term->slug ) . '">' . esc_html( $term->name ) . '</a>';
					$output .= '</li> <!-- .portfolio__filter-item -->';
				}

				$output .= '</ul> <!-- .portfolio__filter-list -->';
				$output .= '</nav> <!-- .portfolio__filter -->';

				$output .= '<div class="portfolio__content">';
				while ( $query->have_posts() ) {
					$query->the_post();

					$category_list = '';
					$slug_list = '';

					$categories = get_the_terms( get_the_ID(), 'project_category' );

					if ( ! empty( $categories ) ) {
						foreach ( $categories as $category ) {
							$category_list .= $category->name . ', ';
							$slug_list .= $category->slug . ' ';
						}

						$category_list = substr( $category_list, 0, -2 );
						$slug_list = substr( $slug_list, 0, -1 );
					}

					$image_id  = get_post_thumbnail_id();
					$image_alt = get_post_meta( $image_id, '_wp_attachment_image_alt', true );

					$output .= '<div id="project-' . get_the_ID() . '" class="' . join( ' ', get_post_class() ) . '">';
					$output .= '<div class="portfolio__content-item ' . esc_html( $slug_list ) . '">';
					$output .= '<div class="portfolio__content-inner">';
					$output .= '<figure class="portfolio__content-figure">';
					$output .= '<img src="' . esc_url( get_the_post_thumbnail_url( get_the_ID(), 'portfolio-cover' ) ) . '" alt="' . esc_attr( $image_alt ) . '" class="portfolio__content-image">';
					$output .= '</figure> <!-- .portfolio__content-figure -->';
					$output .= '<div class="portfolio__content-caption">';
					$output .= '<span class="portfolio__content-category">' . esc_html( $category_list ) . '</span>';
					$output .= '<a href="' . esc_url( get_post_meta( get_the_ID(), '_wbz_project_url', true ) ) . '" class="portfolio__content-tagline">' . esc_url( get_post_meta( get_the_ID(), '_wbz_project_url', true ) ) . '</a>';
					$output .= '</div> <!-- .portfolio_content-caption -->';
					$output .= '<a href="' . esc_url( get_the_permalink() ) . '" class="portfolio__content-link" aria-label="' . esc_html__( 'Read More', 'webeez-addons' ) . '">';
					$output .= '<span class="icon-right-arrow"></span>';
					$output .= '<span class="sr-only">' . esc_html__( 'Read More', 'webeez-addons' ) . '</span>';
					$output .= '</a> <!-- .portfolio__content-link -->';
					$output .= '</div> <!-- .portfolio__content-inner -->';
					$output .= '</div> <!-- .portfolio__content-item -->';
					$output .= '</div> <!-- #project-' . get_the_ID() . ' -->';
				}
				$output .= '</div> <!-- .portfolio__content -->';

				$output .= '</div> <!-- .portfolio -->';

			}

			wp_reset_postdata();
			return $output;
		}
	}
endif;
