<?php
/**
 * Webeez template hooks
 *
 * @package webeez
 */

 /**
  * Header
  */
add_action( 'webeez_header_before', 'webeez_skip_links', 0 );
add_action( 'webeez_header', 'webeez_scroll_indicator', 0 );
add_action( 'webeez_header', 'webeez_header_left', 10 );
add_action( 'webeez_header', 'webeez_header_center', 20 );
add_action( 'webeez_header', 'webeez_header_right', 30 );

 /**
  * Page
  */
add_action( 'webeez_page', 'webeez_page_content', 0 );

 /**
  * Project
  */
add_action( 'webeez_project', 'webeez_project_content', 0 );

 /**
  * Service
  */
add_action( 'webeez_service_after', 'webeez_section_cta', 0 );
/**
 * Footer
 */

// Display footer.
add_action( 'webeez_footer', 'webeez_footer', 0 );
// Display mobile navigation sidebar.
add_action( 'webeez_footer_after', 'webeez_mobile_nav', 0 );
// Display body overlay.
add_action( 'webeez_footer_after', 'webeez_overlay', 10 );

add_action( 'webeez_footer_after', 'webeez_scroll_top', 20 );
