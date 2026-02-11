<?php
/**
 * Webeez template functions.
 *
 * @package webeez
 */

if ( ! function_exists( 'webeez_skip_links' ) ) {
	/**
	 * Display skip links to content
	 */
	function webeez_skip_links() {
		?>
		 <a class="sr-only" href="#navigation"><?php esc_html_e( 'Skip to navigation', 'webeez' ); ?></a>
		 <a class="sr-only" href="#content"><?php esc_html_e( 'Skip to content', 'webeez' ); ?></a>
		<?php
	}
}

if ( ! function_exists( 'webeez_scroll_indicator' ) ) {
	/**
	 * Display scroll indicator
	 */
	function webeez_scroll_indicator() {
		?>
		<div class="scroll-indicator">
			<div class="scroll-indicator__inner"></div>
		</div> <!-- .scroll-indicator -->
		<?php
	}
}

if ( ! function_exists( 'webeez_header_left' ) ) {
	/**
	 * Display header left
	 */
	function webeez_header_left() {
		?>
		<div class="site-header__left">
				<div class="site-branding site-branding--large">
					<a href="<?php echo esc_url( home_url() ); ?>" class="site-logo">
						<?php webeez_display_logo(); ?>
						<span><?php echo esc_html( get_bloginfo( 'name' ) ); ?></span>
					</a> <!-- .site-logo -->
				</div> <!-- .site-branding -->
			</div> <!-- .site-header__left -->
		<?php
	}
}

if ( ! function_exists( 'webeez_header_center' ) ) {
	/**
	 * Display header center
	 */
	function webeez_header_center() {
		$nav_class = '';
		if ( is_front_page() ) {
			$nav_class = ' nav-primary--home';
		}
		?>
			<div class="site-header__center">
				<nav class="nav nav-primary<?php echo esc_attr( $nav_class ); ?>" id="navigation">
					<?php
					$locations = get_nav_menu_locations();
					if ( isset( $locations['nav-primary'] ) ) {
						$nav = get_term( $locations['nav-primary'], 'nav_menu' );
						$items = wp_get_nav_menu_items( $nav->term_id );

						if ( ! empty( $items ) ) {
							webeez_primary_nav( $items );
						}
					}
					?>
				</nav> <!-- .nav-primary -->
			</div> <!-- .site-header__center -->
		<?php
	}
}

if ( ! function_exists( 'webeez_header_right' ) ) {
	/**
	 * Display header right
	 */
	function webeez_header_right() {
		?>
		<div class="site-header__right">
			<div class="site-phone">
				<div class="site-phone__icon">
					<svg viewBox="0 0 480.56 480.56">
						<path class="path-phone" d="M365.354,317.9c-15.7-15.5-35.3-15.5-50.9,0c-11.9,11.8-23.8,23.6-35.5,35.6c-3.2,3.3-5.9,4-9.8,1.8
							c-7.7-4.2-15.9-7.6-23.3-12.2c-34.5-21.7-63.4-49.6-89-81c-12.7-15.6-24-32.3-31.9-51.1c-1.6-3.8-1.3-6.3,1.8-9.4
							c11.9-11.5,23.5-23.3,35.2-35.1c16.3-16.4,16.3-35.6-0.1-52.1c-9.3-9.4-18.6-18.6-27.9-28c-9.6-9.6-19.1-19.3-28.8-28.8
							c-15.7-15.3-35.3-15.3-50.9,0.1c-12,11.8-23.5,23.9-35.7,35.5c-11.3,10.7-17,23.8-18.2,39.1c-1.9,24.9,4.2,48.4,12.8,71.3
							c17.6,47.4,44.4,89.5,76.9,128.1c43.9,52.2,96.3,93.5,157.6,123.3c27.6,13.4,56.2,23.7,87.3,25.4c21.4,1.2,40-4.2,54.9-20.9
							c10.2-11.4,21.7-21.8,32.5-32.7c16-16.2,16.1-35.8,0.2-51.8C403.554,355.9,384.454,336.9,365.354,317.9z"></path>
						<path class="path-line-small" d="M346.254,238.2l36.9-6.3c-5.8-33.9-21.8-64.6-46.1-89c-25.7-25.7-58.2-41.9-94-46.9l-5.2,37.1
							c27.7,3.9,52.9,16.4,72.8,36.3C329.454,188.2,341.754,212,346.254,238.2z"></path>
						<path class="path-line-large" d="M403.954,77.8c-42.6-42.6-96.5-69.5-156-77.8l-5.2,37.1c51.4,7.2,98,30.5,134.8,67.2c34.9,34.9,57.8,79,66.1,127.5
							l36.9-6.3C470.854,169.3,444.354,118.3,403.954,77.8z"></path>
					</svg>
				</div> <!-- .site-phone__icon -->
				<?php
				if ( is_active_sidebar( 'sidebar_phone' ) ) {
					dynamic_sidebar( 'sidebar_phone' );
				}
				?>
			</div> <!-- .site-phone -->
			<button type="button" class="btn btn-menu" id="showMobileMenu" aria-label="<?php esc_attr_e( 'Show mobile menu', 'webeez' ); ?>">
				<span></span>
				<span class="grow"></span>
				<span></span>
			</button>
		</div> <!-- .site-header__right -->
		<?php
	}
}

if ( ! function_exists( 'webeez_mobile_nav' ) ) {
	/**
	 * Display mobile navigation sidebar
	 *
	 * @return void
	 */
	function webeez_mobile_nav() {
		?>
			<div class="sidebar sidebar-nav" id="sidebarNav">
				<div class="sidebar-nav__header">
					<a href="<?php echo esc_url( home_url() ); ?>" class="site-logo" aria-label="<?php esc_attr_e( 'Navigate to Home Page', 'webeez' ); ?>">
						<?php webeez_display_logo(); ?>
						<span class="sr-only"><?php echo esc_html( get_bloginfo( 'name' ) ); ?></span>
					</a> <!-- .site-logo -->
					<button class="btn btn-close" id="hideMobileMenu">
						<span class="text"><?php esc_html_e( 'Show mobile menu', 'webeez' ); ?></span>
						<span class="icon-close"></span>
					</button>
				</div> <!-- .sidebar-nav-header -->
				<div class="sidebar-nav__content">
					<nav class="nav nav-mobile">
						<?php
						wp_nav_menu(
							array(
								'theme_location' => 'nav-mobile',
								'menu_class'     => 'menu-mobile',
								'items_wrap'     => '<ul id="mobile-menu-list" class="%2$s">%3$s</ul>',
								'fallback_cb'    => false,
								'walker'         => new Webeez_Walker( 'menu-mobile-sub' ),
							)
						);
						?>
					</nav> <!-- .nav nav-mobile -->
				</div> <!-- .sidebar-nav-content -->
			</div> <!-- .sidebar-nav -->
		<?php
	}
}

if ( ! function_exists( 'webeez_page_content' ) ) {
	/**
	 * Display the page content
	 */
	function webeez_page_content() {
		the_content();

		wp_link_pages(
			array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'webeez' ),
				'after'  => '</div> <!-- .page-links -->',
			)
		);
	}
}

if ( ! function_exists( 'webeez_project_content' ) ) {
	/**
	 * Display the project content
	 */
	function webeez_project_content() {
		$url = get_post_meta( get_the_ID(), '_wbz_project_url', true );
		?>
		<div class="container project">
			<div class="row">
				<div class="col-12">
					<div class="project-header">
						<div class="project-wrapper">
							<div class="project-title">
								<h1><?php the_title(); ?></h1>
								<a href="<?php echo esc_url( $url ); ?>" target="_black"><?php echo esc_url( $url ); ?></a>
							</div> <!-- .project-title -->
							<div class="project-thumbnail">
								<?php the_post_thumbnail(); ?>
							</div> <!-- .project-thumbnail -->
							<div class="project-overlay"></div> <!-- .project-overlay -->
						</div> <!-- .project-wrapper -->
						<div class="project-meta">
							<ul class="project-meta__list">
								<li class="project-meta__item">
									<h5><?php esc_html_e( 'Client:', 'webeez' ); ?></h5>
									<p><?php echo esc_html( get_post_meta( get_the_ID(), '_wbz_project_client', true ) ); ?></p>
								</li>
								<li class="project-meta__item">
									<h5><?php esc_html_e( 'Category:', 'webeez' ); ?></h5>
									<p><?php echo esc_html( strip_tags( get_the_term_list( get_the_ID(), 'project_category', '', ', ' ) ) ); ?></p>
								</li>
								<li class="project-meta__item">
									<h5><?php esc_html_e( 'Date:', 'webeez' ); ?></h5>
									<p><?php echo esc_html( get_the_date() ); ?></p>
								</li>
								<li class="project-meta__item">
									<a href="<?php echo esc_url( $url ); ?>" target="_black" class="btn btn-brand btn-brand--primary"><span class="btn-brand__text"><?php esc_html_e( 'Visit Website', 'webeez' ); ?></span></a>
								</li>
								<?php
								/*
								<li class="project-meta__item">
									<?php echo webeez_social_share( 'single' ); //phpcs:ignore ?>
								</li>
								*/
								?>
							</ul>
						</div> <!-- .project-meta -->
					</div> <!-- .project-header -->
				</div> <!-- .col-12 -->
			</div> <!-- .row -->
			<div class="row">
				<div class="col-12 col-lg-10 mx-auto">
					<?php
					the_content();

					wp_link_pages(
						array(
							'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'webeez' ),
							'after'  => '</div> <!-- .page-links -->',
						)
					);
					?>
				</div> <!-- .col-12 col-lg-10 mx-auto -->
			</div> <!-- .row -->
		</div> <!-- .container -->
		<?php
	}
}

if ( ! function_exists( 'webeez_section_cta' ) ) {
	/**
	 * Display the cta section
	 */
	function webeez_section_cta() {
		?>
			<div class="section section-cta">
				<div class="container">
					<div class="row">
						<div class="col-12">
						<div class="section-cta__inner">
							<h2 class="section-cta__heading"><?php esc_html_e( 'Let\'s put your idea into practice!', 'webeez' ); ?></h2>
							<a href="<?php echo esc_url( get_permalink( 4 ) ); ?>" class="btn btn-brand btn-brand--dark">
								<span class="btn-brand__text"><?php esc_html_e( 'Contact Us Today', 'webeez' ); ?></span>
							</a> <!-- .btn btn-brand -->
						</div> <!-- .section-cta-inner -->
						</div> <!-- .col-12 -->
					</div> <!-- .row -->
				</div> <!-- .container -->

			</div> <!-- .section section-cta -->
		<?php
	}
}

if ( ! function_exists( 'webeez_footer' ) ) {
	/**
	 * Display the footer widgets container
	 *
	 * @return void
	 */
	function webeez_footer() {
		?>
		<div class="site-footer__top">
			<div class="container">
				<div class="row">
					<div class="col-12">
						<div class="site-footer__top-wrapper">
							<div class="site-footer__widget reveal fadeInUp animated" data-wow-delay="0.1s" style="visibility: visible; animation-delay: 0.1s; animation-name: fadeInUp;">
								<div class="site-branding">
									<a href="<?php echo esc_url( get_home_url() ); ?>" class="site-logo" rel="home" aria-current="page">
										<?php webeez_display_logo(); ?>
										<span><?php echo esc_html( get_bloginfo( 'name' ) ); ?></span>
									</a>
								</div> <!-- .site-branding -->
								<?php
								if ( is_active_sidebar( 'sidebar_footer_1' ) ) :
									dynamic_sidebar( 'sidebar_footer_1' );
								endif;
								?>
							</div> <!-- .site-footer__widget -->
							<div class="site-footer__widget reveal fadeInUp animated" data-wow-delay="0.2s" style="visibility: visible; animation-delay: 0.1s; animation-name: fadeInUp;">
								<?php
								if ( is_active_sidebar( 'sidebar_footer_2' ) ) :
									dynamic_sidebar( 'sidebar_footer_2' );
								endif;
								?>
							</div> <!-- .site-footer__widget -->
							<div class="site-footer__widget reveal fadeInUp animated" data-wow-delay="0.3s" style="visibility: visible; animation-delay: 0.1s; animation-name: fadeInUp;">
								<?php
								if ( is_active_sidebar( 'sidebar_footer_3' ) ) :
									dynamic_sidebar( 'sidebar_footer_3' );
								endif;
								?>
							</div> <!-- .site-footer__widget -->
							<div class="site-footer__widget reveal fadeInUp animated" data-wow-delay="0.4s" style="visibility: visible; animation-delay: 0.1s; animation-name: fadeInUp;">
								<?php
								if ( is_active_sidebar( 'sidebar_footer_4' ) ) :
									dynamic_sidebar( 'sidebar_footer_4' );
								endif;
								?>
							</div> <!-- .site-footer__widget -->
						</div> <!-- .site-footer__top-wrapper -->
					</div> <!-- .col-12 -->
				</div> <!-- .row -->
			</div> <!-- .container -->
		</div> <!-- .site-footer__top -->
		<div class="site-footer__bottom">
			<div class="container">
				<div class="row">
					<div class="col-12">
						<div class="site-footer__bottom-breadcrumbs">
							<span class="breadcrumbs-title"><?php esc_html_e( 'You are here', 'webeez' ); ?>:</span>
							<?php
							if ( function_exists( 'rank_math_the_breadcrumbs' ) ) {
								rank_math_the_breadcrumbs();
							}
							?>
						</div> <!-- .site-footer__bottom-breadcrumbs -->
					</div> <!-- .col-12 -->
				</div> <!-- .row -->
				<div class="row">
					<div class="col-12">
						<div class="site-footer__bottom-wrapper">
							<div class="site-footer__bottom-left">
								<p>
									<?php esc_html_e( 'Copyright', 'webeez' ); ?> &copy; <?php echo esc_html( gmdate( 'Y' ) ); ?>
									<a href="<?php echo esc_url( home_url() ); ?>"><?php echo esc_html( get_bloginfo( 'name' ) ); ?></a>
									&bull;
								</p>
								<?php
								if ( is_active_sidebar( 'sidebar_footer_bottom_left' ) ) :
									dynamic_sidebar( 'sidebar_footer_bottom_left' );
								endif;
								?>
							</div> <!-- .site-footer__bottom-left -->
							<div class="site-footer__bottom-right">
								<?php
								if ( is_active_sidebar( 'sidebar_footer_bottom_right' ) ) :
									dynamic_sidebar( 'sidebar_footer_bottom_right' );
								endif;
								?>
							</div> <!-- .site-footer__bottom-right -->
						</div> <!-- .site-footer__bottom-wrapper -->
					</div> <!-- .col-12 -->
				</div> <!-- .row -->
			</div> <!-- .container -->
		</div> <!-- .site-footer__bottom -->
		<?php
	}
}

if ( ! function_exists( 'webeez_overlay' ) ) {
	/**
	 * Display the body overlay
	 *
	 * @return void
	 */
	function webeez_overlay() {
		?>
		<div class="body-overlay" id="bodyOverlay"></div> <!-- .body-overlay -->
		<?php
	}
}

if ( ! function_exists( 'webeez_scroll_top' ) ) {
	/**
	 * Display scroll to top button
	 *
	 * @return void
	 */
	function webeez_scroll_top() {
		?>
		<button class="btn btn-scroll-top" id="scrollTop" data-target="html" title="<?php esc_attr_e( 'Scroll to top', 'webeez' ); ?>">
			<span class="sr-only"><?php esc_html_e( 'Scroll to top', 'webeez' ); ?></span>
		</button>
		<?php
	}
}




