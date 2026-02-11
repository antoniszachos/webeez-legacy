<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package webeez
 */

?>

<article id="project-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="entry-content">

		<?php
		/**
		 * Functions hooked in to page
		 */
		do_action( 'webeez_project' );
		?>

	</div><!-- .entry-content -->

</article><!-- #post-<?php the_ID(); ?> -->
