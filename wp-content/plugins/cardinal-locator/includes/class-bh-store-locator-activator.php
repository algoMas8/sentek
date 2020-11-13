<?php
/**
 * Activation class
 *
 * @package   BH_Store_Locator
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 */
class BH_Store_Locator_Activator {

	/**
	 * Primary plugin activation method
	 */
	public static function activate() {

		// Flush the rewrites since we're registering a CPT by default.
		flush_rewrite_rules();

		// Create custom table to store coordinates for quick searching when Over 1,000 locations option is selected.
		bh_storelocator_create_db_table();
	}
}
