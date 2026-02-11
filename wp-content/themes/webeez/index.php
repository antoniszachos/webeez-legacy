<?php
 /**
  * The main template file
  *
  * @package webeez
  */

get_header();

?>

	<main id="main" class="site-main">
		<?php

		/**
		 * Functions hooked in to webeez_post_loop_before action.
		 */
		do_action( 'webeez_post_loop_before' );

		if ( have_posts() ) {

			/**
			 * Include the template for the page content.
			 */
			get_template_part( 'template-parts/loop' );

		} else {

			/**
			 * Include the template for content none.
			 */

			get_template_part( 'template-parts/content', 'none' );

		}

		/**
		 * Functions hooked in to webeez_post_loop_after action.
		 */
		do_action( 'webeez_post_loop_after' );
		?>

	</main> <!-- #main -->

<?php
get_footer();
