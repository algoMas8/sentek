<?php
/**
 * Fired when the plugin is uninstalled.
 *
 * @package   BH_Store_Locator
 * @author    Bjorn Holine <bjorn@cardinalwp.com>
 * @license   GPL-3.0+
 * @link      https://cardinalwp.com/
 * @copyright 2018 Bjorn Holine
 */

// If uninstall not called from WordPress, then exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

// Flush the rewrites.
flush_rewrite_rules();

// Delete the locations transient if it exists.
if ( false !== get_transient( 'bh_sl_locations' ) ) {
	delete_transient( 'bh_sl_locations' );
}

// Delete the license status option of it exists.
if ( false !== get_option( 'bh_storelocator_license_status' ) ) {
	delete_option( 'bh_storelocator_license_status' );
}

// Delete the license status transient if exists.
if ( false !== get_transient( 'bh_sl_license_status' ) ) {
	delete_transient( 'bh_sl_license_status' );
}
