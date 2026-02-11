<?php
 /**
  * The template for displaying service pages.
  *
  * Template name: Page template for Services
  *
  * @package webeez
  */

get_header();
?>

	<main id="main" class="site-main site-main--service">
		<div class="container">
			<div class="row">
				<div class="col-12 col-lg-8">
					<div class="featured-image">
						<?php the_post_thumbnail( 'full' ); ?>
					</div> <!-- .featured-image -->
					<div class="featured-icon">
						<?php echo get_post_meta( get_the_ID(), '_wbz_page_svg_icon', true ); //phpcs:ignore ?>
					</div> <!-- .featured-icon -->
					<?php
					/* Start the Loop */
					while ( have_posts() ) :

						the_post();

						/**
						 * Include the template for the page content.
						 */
						get_template_part( 'template-parts/content', 'page' );

						// If comments are open or we have at least one comment, load up the comment template.
						if ( comments_open() || get_comments_number() ) :
							comments_template();
						endif;

					endwhile; // End of the loop.
					?>
				</div> <!-- col-12 col-lg-8 -->
				<div class="col-12 col-lg-4">
					<aside class="sidebar sidebar-services">
						<?php
						if ( is_active_sidebar( 'sidebar_services' ) ) :
							dynamic_sidebar( 'sidebar_services' );
						endif;
						?>
					</aside>
				</div> <!-- col-12 col-lg-4 -->
			</div> <!-- .row -->
		</div> <!-- .container -->
		<?php
		/**
		 * Functions hooked in to webeez_service_after
		 */
		do_action( 'webeez_service_after' );
		?>
	</main> <!-- #main -->

<?php
get_footer();
