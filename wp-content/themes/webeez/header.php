<?php
/**
 * The header for the theme
 *
 * @package webeez
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
	<div class="site-wrapper">
		<?php

		$head_class = '';
		$body_class = '';
		if ( is_front_page() ) {
			$head_class = ' site-header--home';
			$body_class = ' site-content--home';
		}

		wp_body_open();

		/**
		 * Functions hooked into webeez_body_open_after action
		 */
		do_action( 'webeez_body_open_after' );

		?>

		<div id="page" class="site">

			<?php
			/**
			 * Functions hooked into webeez_header_before action
			 */
			do_action( 'webeez_header_before' );
			?>

			<header id="masthead" class="site-header<?php echo esc_attr( $head_class ); ?>">

				<?php
				/**
				 * Functions hooked into webeez_header action
				 */
				do_action( 'webeez_header' );
				?>

			</header><!-- #masthead -->

			<?php
			/**
			 * Functions hooked into webeez_header_after action
			 */
			do_action( 'webeez_header_after' );
			?>


			<div id="content" class="site-content<?php echo esc_attr( $body_class ); ?>" tabindex="-1">
