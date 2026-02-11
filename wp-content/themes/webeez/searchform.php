<?php
/**
 * Custom search form
 *
 * @package webeez
 */

?>

<form role="search" method="get" class="form form-search" >
	<label class="sr-only" for="searchField"><?php esc_html_e( 'Search for', 'webeez' ); ?></label>
	<input name="s" id="searchField" type="text" class="form-input" placeholder="<?php esc_attr_e( 'Search for', 'webeez' ); ?>...">
	<button type="submit" class="btn btn-submit"><?php esc_html_e( 'Submit search form', 'webeez' ); ?></button>
</form> <!-- .form -->
