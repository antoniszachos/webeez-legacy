<?php
/**
 * Webeez functions.
 *
 * @package webeez
 */

if ( ! function_exists( 'webeez_display_logo' ) ) {
	/**
	 * Return the site svg logo
	 */
	function webeez_display_logo() {
		$sgv_logo = get_theme_mod( 'svg-logo' );
		if ( ! empty( $sgv_logo ) ) {
			echo wp_kses(
				$sgv_logo,
				array(
					'svg' => array( 'viewbox' => true ),
					'path' => array(
						'd' => true,
						'class' => true,
					),
				)
			);
		}
	}
}

if ( ! function_exists( 'webeez_primary_nav' ) ) {
	/**
	 * Return the site primary navigation
	 *
	 * @param array $items Menu items.
	 * @param array $parent Parent id.
	 */
	function webeez_primary_nav( $items, $parent = 0 ) {
		$current_id = get_queried_object_id();

		echo '<ul class="nav-primary__list">';
		foreach ( $items as $item ) {
			if ( $parent == $item->menu_item_parent ) {
				$subitems = webeez_sub_items( $items, $item->ID );
				$link_class = '';
				if ( $current_id == $item->object_id ) {
					$link_class = ' nav-primary__link--active';
				}
				echo '<li class="nav-primary__item">';
				echo '<a href="' . esc_url( $item->url ) . '" class="nav-primary__link' . esc_attr( $link_class ) . '">' . esc_html( $item->title ) . '</a>';
				if ( ! empty( $subitems ) ) {
					echo '<div class="nav-primary__dropdown">';
					echo '<div class="nav-primary__dropdown-inner">';
					echo '<ul class="nav-primary__dropdown-list">';
					foreach ( $subitems  as $subitem ) {
						echo '<li class="nav-primary__dropdown-item">';
						echo '<a href="' . esc_url( $subitem->url ) . '" class="nav-primary__dropdown-link">';
						echo '<div class="nav-primary__dropdown-icon">';
						echo get_post_meta( $subitem->object_id, '_wbz_page_svg_icon', true ); //phpcs:ignore.
						echo '</div> <!-- .nav-primary__dropdown-icon -->';
						echo '<span>' . esc_html( $subitem->title ) . '</span>';
						echo '</a><!-- .nav-primary__dropdown-link -->';
						echo '</li> <!-- nav-primary__dropdown-item -->';
					}
					echo '</ul> <!-- .nav-primary__dropdown-list -->';
					echo '</div> <!-- ..nav-primary__dropdown-inner -->';
					echo '</div> <!-- .nav-primary__dropdown -->';
				}
				echo '</li> <!-- .nav-primary__item"> -->';
			}
		}
		echo '</ul> <!-- .nav-primary__list -->';
	}
}

if ( ! function_exists( 'webeez_sub_items' ) ) {
	/**
	 * Return menu sub items
	 *
	 * @param array $items Menu items.
	 * @param array $parent Parent id.
	 * @return array Sub items
	 */
	function webeez_sub_items( $items, $parent ) {
		$subitems = array();

		foreach ( $items as $item ) {

			if ( $parent == $item->menu_item_parent ) {
				$subitems[] = $item;
			}
		}

		return $subitems;
	}
}

if ( ! function_exists( 'webeez_social_share' ) ) {
	/**
	 * Display the social share list
	 *
	 * @param string $modifier Css Class modifier.
	 *
	 * @return string HTML output
	 */
	function webeez_social_share( $modifier ) {
		$output = '';
		$output .= '<div class="social-share social-share--' . esc_attr( $modifier ) . '">';
		$output .= '<ul class="social-share-list">';
		$output .= '<li class="social-share-item">';
		$output .= '<a rel="noopener noreferrer nofollow" href="https://www.facebook.com/sharer/sharer.php?u=https:' . esc_url( get_the_permalink() ) . '" target="_blank" class="social-share-icon social-share-icon--facebook" aria-label="' . esc_html__( 'Share on Facebook', 'webeez' ) . '">';
		$output .= '<span class="sr-only">' . esc_html__( 'Share on Facebook', 'webeez' ) . '</span>';
		$output .= '<span class="icon-facebook"></span>';
		$output .= '</a>';
		$output .= '</li>';
		$output .= '<li class="social-share-item">';
		$output .= '<a rel="noopener noreferrer nofollow" href="https://twitter.com/share?url=https:' . esc_url( get_the_permalink() ) . '" target="_blank" class="social-share-icon social-share-icon--twitter" aria-label="' . esc_html__( 'Share on Twitter', 'webeez' ) . '">';
		$output .= '<span class="sr-only">' . esc_html__( 'Share on Twitter', 'webeez' ) . '</span>';
		$output .= '<span class="icon-twitter"></span>';
		$output .= '</a>';
		$output .= '</li>';
		$output .= '<li class="social-share-item">';
		$output .= '<a rel="noopener noreferrer nofollow" href="https://pinterest.com/pin/create/button/?url=https:' . esc_url( get_the_permalink() ) . '&media=https:' . esc_url( get_the_post_thumbnail_url( null, 'full' ) ) . '&description=' . urlencode( get_the_title() ) . '" target="_blank" class="social-share-icon social-share-icon--pinterest" aria-label="' . esc_html__( 'Share on Pinterest', 'webeez' ) . '">';
		$output .= '<span class="sr-only">' . esc_html__( 'Share on Pinterest', 'webeez' ) . '</span>';
		$output .= '<span class="icon-pinterest"></span>';
		$output .= '</a>';
		$output .= '</li>';
		$output .= '<li class="social-share-item">';
		$output .= '<a rel="noopener noreferrer nofollow" href="https://www.linkedin.com/shareArticle?mini=true&url=https:' . esc_url( get_the_permalink() ) . '" target="_blank" class="social-share-icon social-share-icon--linkedin" aria-label="' . esc_html__( 'Share on LinkedIn', 'webeez' ) . '">';
		$output .= '<span class="sr-only">' . esc_html__( 'Share on LinkedIn', 'webeez' ) . '</span>';
		$output .= '<span class="icon-linkedin"></span>';
		$output .= '</a>';
		$output .= '</li>';
		$output .= '</ul> <!-- .social-share-icons -->';
		$output .= '</div> <!-- .social-share -->';

		return $output;
	}
}
