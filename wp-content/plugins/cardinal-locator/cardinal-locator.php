<?php
/**
 * Cardinal Store Locator
 *
 * Store locator plugin for WordPress
 *
 * @package   BH_Store_Locator
 * @author    Bjorn Holine <bjorn@cardinalwp.com>
 * @license   GPL-3.0+
 * @link      https://cardinalwp.com/
 * @copyright 2018 Bjorn Holine
 *
 * @wordpress-plugin
 * Plugin Name:       Cardinal Store Locator
 * Plugin URI:        https://cardinalwp.com/
 * Description:       Store locator plugin for WordPress
 * Version:           1.4.6
 * Author:            Bjorn Holine
 * Author URI:        http://www.bjornblog.com
 * Text Domain:       bh-storelocator
 * License:           GPL-3.0+
 * License URI:       https://www.gnu.org/licenses/gpl-3.0.txt
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/*----------------------------------------------------------------------------*
 * Updater
 *----------------------------------------------------------------------------*/

if ( ! class_exists( 'BH_Store_Locator_Plugin_Updater' ) ) {
	include( plugin_dir_path( __FILE__ ) . 'includes/BH_Store_Locator_Plugin_Updater.php' );
}

/*----------------------------------------------------------------------------*
 * Shared Functionality
 *----------------------------------------------------------------------------*/

require_once( plugin_dir_path( __FILE__ ) . 'includes/class-bh-store-locator-defaults.php' );
require_once( plugin_dir_path( __FILE__ ) . 'includes/helpers.php' );
require_once( plugin_dir_path( __FILE__ ) . 'includes/bh-store-locator-db.php' );

/*----------------------------------------------------------------------------*
 * Public-Facing Functionality
 *----------------------------------------------------------------------------*/

require_once( plugin_dir_path( __FILE__ ) . 'public/class-bh-store-locator.php' );

/**
 * The code that runs during plugin activation.
 */
function activate_bh_store_locator() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-bh-store-locator-activator.php';
	BH_Store_Locator_Activator::activate();
}
/**
 * The code that runs during plugin deactivation.
 */
function deactivate_bh_store_locator() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-bh-store-locator-deactivator.php';
	BH_Store_Locator_Deactivator::deactivate();
}

/*
 * Register hooks that are fired when the plugin is activated or deactivated.
 * When the plugin is deleted, the uninstall.php file is loaded.
 */
register_activation_hook( __FILE__, 'activate_bh_store_locator' );
register_deactivation_hook( __FILE__, 'deactivate_bh_store_locator' );

add_action( 'plugins_loaded', array( 'BH_Store_Locator', 'get_instance' ) );

/*----------------------------------------------------------------------------*
 * Dashboard and Administrative Functionality
 *----------------------------------------------------------------------------*/

if ( is_admin() ) {

	require_once( plugin_dir_path( __FILE__ ) . 'admin/class-bh-store-locator-admin.php' );
	add_action( 'plugins_loaded', array( 'BH_Store_Locator_Admin', 'get_instance' ) );

}
