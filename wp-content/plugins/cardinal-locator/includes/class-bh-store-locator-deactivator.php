<?php
/**
 * Deactivation class
 *
 * @package   BH_Store_Locator
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 */
class BH_Store_Locator_Deactivator {

	/**
	 * Primary plugin deactivation method
	 */
	public static function deactivate() {

		// Flush the rewrites.
		flush_rewrite_rules();

		// Delete the locations transient if it exists.
		if ( false !== get_transient( 'bh_sl_locations' ) ) {
			delete_transient( 'bh_sl_locations' );
		}

		// TODO
		// Unschedule wp_cron task.
		//$timestamp = wp_next_scheduled( 'bh_storelocator_bg_process_coords' );
		//wp_unschedule_event( $timestamp, 'bh_storelocator_bg_process_coords' );
		wp_clear_scheduled_hook( 'bh_storelocator_bg_process_coords' );

	}

}
