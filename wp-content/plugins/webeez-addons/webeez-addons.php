<?php
/**
 * Webeez Addons Plugin
 *
 * @package webeez-addons
 *
 * Plugin Name: Webeez Theme Addons
 * Plugin URI: https://webeez.gr/plugins/webeez-addons
 * Description: Adds additional features to Webeez custom theme
 * Version: 1.0.0
 * Author: Antonis Zachos
 * Author URI: https://antoniszachos.com/
 * License GPLv2 or later
 * Text Domain: webeez-addons
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * Copyright 2020 Webeez
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'get_plugin_data' ) ) {
	require_once ABSPATH . 'wp-admin/includes/plugin.php';
}

define( 'WEBEEZ_ADDONS_URL', plugin_dir_url( __FILE__ ) );
define( 'WEBEEZ_ADDONS_PATH', plugin_dir_path( __FILE__ ) );

// Include the main plugin class.
include_once WEBEEZ_ADDONS_PATH . 'inc/class-webeez-addons.php';

if ( class_exists( 'Webeez_Addons' ) ) {
	$webeez_addons = new Webeez_Addons();
	$webeez_addons->init();
}

// Include the editor class.
include_once WEBEEZ_ADDONS_PATH . 'inc/class-webeez-addons-editor.php';

if ( class_exists( 'Webeez_Addons_Editor' ) ) {
	$webeez_addons_editor = new Webeez_Addons_Editor();
	$webeez_addons_editor->init();
}

if ( is_admin() ) {
	include_once WEBEEZ_ADDONS_PATH . 'inc/class-webeez-addons-admin.php';

	if ( class_exists( 'Webeez_Addons_Admin' ) ) {
		$webeez_addons_admin = new Webeez_Addons_Admin();
		$webeez_addons_admin->init();
	}
}

// Activation.
register_activation_hook( __FILE__, array( $webeez_addons, 'activate' ) );

// Deactivation.
register_deactivation_hook( __FILE__, array( $webeez_addons, 'deactivate' ) );
