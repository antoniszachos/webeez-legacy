<?php
/**
 * Webeez Custom Navigation Walker Class
 *
 * @package webeez
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Webeez_Walker' ) ) :

	/**
	 * The Webeez custom navigation walker class
	 */
	class Webeez_Walker extends Walker_Nav_Menu {

		/**
		 * Sub menu css class
		 *
		 * @var string
		 */
		private $sub_class = '';

		/**
		 * Class constructor
		 *
		 * @param string $sub_class Menu sub class.
		 */
		public function __construct( $sub_class ) {
			$this->sub_class = $sub_class;
		}

		/**
		 * Start the element output.
		 *
		 * @see Walker::start_el()
		 *
		 * @since 3.0.0
		 *
		 * @param string $output Passed by reference. Used to append additional content.
		 * @param object $item   Menu item data object.
		 * @param int    $depth  Depth of menu item. Used for padding.
		 * @param array  $args   An array of arguments. @see wp_nav_menu().
		 * @param int    $id     Current item ID.
		 */
		public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
			$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

			$classes = empty( $item->classes ) ? array() : (array) $item->classes;
			$classes[] = 'menu-item-' . $item->ID;

			/**
			 * Filter the CSS class(es) applied to a menu item's list item element.
			 *
			 * @since 3.0.0
			 * @since 4.1.0 The `$depth` parameter was added.
			 *
			 * @param array  $classes The CSS classes that are applied to the menu item's `<li>` element.
			 * @param object $item    The current menu item.
			 * @param array  $args    An array of {@see wp_nav_menu()} arguments.
			 * @param int    $depth   Depth of menu item. Used for padding.
			 */
			$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
			$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

			/**
			 * Filter the ID applied to a menu item's list item element.
			 *
			 * @since 3.0.1
			 * @since 4.1.0 The `$depth` parameter was added.
			 *
			 * @param string $menu_id The ID that is applied to the menu item's `<li>` element.
			 * @param object $item    The current menu item.
			 * @param array  $args    An array of {@see wp_nav_menu()} arguments.
			 * @param int    $depth   Depth of menu item. Used for padding.
			 */
			$id = apply_filters( 'nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args, $depth );
			$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

			$output .= $indent . '<li' . $id . $class_names . '>';

			$atts = array();
			$atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
			$atts['target'] = ! empty( $item->target ) ? $item->target : '';
			$atts['rel']    = ! empty( $item->xfn ) ? $item->xfn : '';
			$atts['href']   = ! empty( $item->url ) ? $item->url : '';

			/**
			 * Filter the HTML attributes applied to a menu item's anchor element.
			 *
			 * @since 3.6.0
			 * @since 4.1.0 The `$depth` parameter was added.
			 *
			 * @param array $atts {
			 *     The HTML attributes applied to the menu item's `<a>` element, empty strings are ignored.
			 *
			 *     @type string $title  Title attribute.
			 *     @type string $target Target attribute.
			 *     @type string $rel    The rel attribute.
			 *     @type string $href   The href attribute.
			 * }
			 * @param object $item  The current menu item.
			 * @param array  $args  An array of {@see wp_nav_menu()} arguments.
			 * @param int    $depth Depth of menu item. Used for padding.
			 */
			$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );

			$attributes = '';
			foreach ( $atts as $attr => $value ) {
				if ( ! empty( $value ) ) {
					$value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
					$attributes .= ' ' . $attr . '="' . $value . '"';
				}
			}

			$css_classes = $item->classes;

			$item_output = $args->before;

			if ( in_array( 'featured', $css_classes ) ) {
				$thumb_id = get_term_meta( $item->object_id, 'thumbnail_id', true );
				$term_img = wp_get_attachment_url( $thumb_id, 'medium', false );
				$item_output .= '<img class="item-thumbnail" src="' . $term_img . '" alt="' . $item->title . '">';
			}

			$item_output .= '<a' . $attributes . '>';

			$item_output .= apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;

			if ( in_array( 'menu-item-has-children', $css_classes ) ) {
				$item_output .= '<span class="menu-toggler" data-depth="' . $depth . '">';
				$item_output .= '<span class="sr-only">' . esc_html__( 'Show sub menu', 'webeez' ) . '</span>';
				$item_output .= '<span class="icon-chevron-right"></span>';
				$item_output .= '</span>';
			}

			$item_output .= '</a>';

			if ( in_array( 'featured', $css_classes ) ) {
				$item_output .= '<p class="item-description">' . $item->description . '</p>';
				$item_output .= '<div class="item-link-wrap">';
				$item_output .= '<a href="' . $item->url . '" class="btn btn-icon">';
				$item_output .= '<span class="icon-link"></span> <!-- .btn-icon -->';
				$item_output .= '<span class="btn-icon-label">' . esc_html__( 'View More', 'webeez' ) . '</span>';
				$item_output .= '</a>';
				$item_output .= '</div> <!-- .item-link-wrap -->';
			}

			$item_output .= $args->after;

			/**
			 * Filter a menu item's starting output.
			 *
			 * The menu item's starting output only includes `$args->before`, the opening `<a>`,
			 * the menu item's title, the closing `</a>`, and `$args->after`. Currently, there is
			 * no filter for modifying the opening and closing `<li>` for a menu item.
			 *
			 * @since 3.0.0
			 *
			 * @param string $item_output The menu item's starting HTML output.
			 * @param object $item        Menu item data object.
			 * @param int    $depth       Depth of menu item. Used for padding.
			 * @param array  $args        An array of {@see wp_nav_menu()} arguments.
			 */
			$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
		}

		/**
		 * Starts the list before the elements are added.
		 *
		 * @param string   $output Used to append additional content (passed by reference).
		 * @param int      $depth  Depth of menu item. Used for padding.
		 * @param stdClass $args   An object of wp_nav_menu() arguments.
		 */
		public function start_lvl( &$output, $depth = 0, $args = null ) {
			if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
				$t = '';
				$n = '';
			} else {
				$t = "\t";
				$n = "\n";
			}
			$indent = str_repeat( $t, $depth );

			$css_class = $this->sub_class;

			if ( 1 <= $depth ) {
				$css_class .= '-sub';
			}
			// Default class.
			$classes = array( $css_class );

			$class_names = join( ' ', apply_filters( 'nav_menu_submenu_css_class', $classes, $args, $depth ) );
			$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';
			$output .= '<div class="' . $this->sub_class . '-wrapper">';
			$output .= "{$n}{$indent}<ul$class_names>{$n}";
		}

		/**
		 * Ends the list before the elements are added.
		 *
		 * @param string   $output Used to append additional content (passed by reference).
		 * @param int      $depth  Depth of menu item. Used for padding.
		 * @param stdClass $args   An object of wp_nav_menu() arguments.
		 */
		public function end_lvl( &$output, $depth = 0, $args = null ) {
			if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
				$t = '';
				$n = '';
			} else {
				$t = "\t";
				$n = "\n";
			}
			$indent  = str_repeat( $t, $depth );
			$output .= "$indent</ul>{$n}";
			$output .= '</div> <!-- .menu-primary-sub-wrapper -->';
		}
	}

endif;
