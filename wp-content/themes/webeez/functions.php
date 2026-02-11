<?php
/**
 * Webeez
 *
 * @package webeez
 */

 /**
  * Set the width of the content on the site
  * Only affects is the images uploaded to the image uploader, and videos embedded with the video shortcodes
  */
if ( ! isset( $content_width ) ) {
	$content_width = 1370;
}

$webeez = (object) array(
	'version'    => wp_get_theme()->get( 'Version' ),
	'main'       => require 'inc/class-webeez.php',
	'customizer' => require 'inc/customizer/class-webeez-customizer.php',
);

require 'inc/class-webeez-walker.php';
require 'inc/webeez-functions.php';
require 'inc/webeez-template-hooks.php';
require 'inc/webeez-template-functions.php';
