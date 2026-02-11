<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @package webeez
 */

 get_header();

?>

<div id="primary" class="content-area">
	<main id="main" class="site-main">
		<div clPass="page-content page-content--404">
			<?php
			$page_404 = get_page_by_path( 'error404' );
			echo wp_kses_post( apply_filters( 'the_content', $page_404->post_content ) );
			?>
		</div> <!-- .page-content -->
	</main> <!-- #main -->
</div> <!-- #primary -->

<?php
get_footer();
