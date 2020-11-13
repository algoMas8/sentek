<?php
/**
 * Custom database setup and import
 *
 * @package   BH_Store_Locator
 */

// Add hook for coords wp_cron process.
add_action( 'bh_storelocator_bg_process_coords', 'bh_storelocator_bg_process_init' );

// Create custom DB table.
if ( ! function_exists( 'bh_storelocator_create_db_table' ) ) {
	/**
	 * Create custom table to store coordinates for quick searching when Over 1,000 locations option is selected
	 */
	function bh_storelocator_create_db_table() {
		global $wpdb;
		$table_name = $wpdb->prefix . 'cardinal_locator_coords';
		$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE $table_name (
		  id bigint(20) NOT NULL,
		  lat DECIMAL(12,9) NOT NULL,
		  lng DECIMAL(12,9) NOT NULL,
		  UNIQUE KEY id (id)
		) $charset_collate;";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );

		// Index lat/lng columns.
		$wpdb->query( "
		ALTER TABLE $table_name
		ADD INDEX(lat),
		ADD INDEX(lng)
		" );
	}
}

// Cron filter.
if ( ! function_exists( 'bh_storelocator_coords_cron' ) ) {
	/**
	 * Custom wp_cron for moving coordinates to the custom table
	 *
	 * @param array $schedules wp_cron schedule array.
	 *
	 * @return mixed
	 */
	function bh_storelocator_coords_cron( $schedules ) {
		$schedules['fifteen_minutes'] = array(
			'interval' => 15 * 60,
			'display'  => esc_html__( 'Every Fifteen Minutes' ),
		);

		return $schedules;
	}
}

// Add custom wp_cron schedule for moving coordinates to the custom table.
add_filter( 'cron_schedules', 'bh_storelocator_coords_cron' );


// Cron schedule.
if ( ! function_exists( 'bh_storelocator_coords_cron_schedule' ) ) {
	/**
	 * Set up wp_cron if location meta count doesn't equal coordinate total in the custom DB table
	 */
	function bh_storelocator_coords_cron_schedule() {
		if ( ! wp_next_scheduled( 'bh_storelocator_bg_process_coords' ) ) {
			wp_schedule_event( time(), 'fifteen_minutes', 'bh_storelocator_bg_process_coords' );
		}
	}
}

// Move existing post coordinates into a custom table with wp_cron.
add_action( 'plugins_loaded', 'bh_storelocator_coords_cron_schedule' );

// Set up the cron process for moving coordinates.
if ( ! function_exists( 'bh_storelocator_bg_process_init' ) ) {
	/**
	 * Starts a background process to move existing location post coordinates into the custom DB table
	 */
	function bh_storelocator_bg_process_init() {
		global $wpdb;
		$table_name = $wpdb->prefix . 'cardinal_locator_coords';
		$table_postmeta = $wpdb->prefix . 'postmeta';
		$location_post_count = wp_count_posts( BH_Store_Locator::BH_SL_CPT );
		$coordinate_count = $wpdb->get_var( "SELECT COUNT(*) FROM $table_name" );
		$location_coords = array();

		if ( property_exists( $location_post_count, 'publish' ) && ( $location_post_count->publish !== $coordinate_count ) && ( $coordinate_count < $location_post_count->publish ) ) {
			$location_meta = $wpdb->get_results(
				$wpdb->prepare( "
				SELECT DISTINCT post_id
				FROM $table_postmeta
				WHERE `meta_key` = %s
				OR `meta_key` = %s
			",
					'bh_storelocator_location_lat',
					'bh_storelocator_location_lng'
				)
			);

			if ( get_option( 'bh_storelocator_coord_count' ) ) {
				$loop_end = get_option( 'bh_storelocator_coord_count' );
				$loop_start = $loop_end + 1;
			} else {
				$loop_start = $location_meta[0]->post_id;
			}

			if ( is_numeric( $loop_start ) ) {
				for ( $i = $loop_start; $i < $loop_start + 100; $i++ ) {

					if ( ! isset( $location_meta[ $i ] ) ) {
						continue;
					}

					$post       = $location_meta[ $i ];
					$loop_count = $post->post_id;

					// Only move meta values of published posts.
					if ( 'publish' === get_post_status( $post->post_id ) && BH_Store_Locator::BH_SL_CPT === get_post_type( $post->post_id ) ) {
						// First get the coordinates.
						$lat = $wpdb->get_var( $wpdb->prepare("
						SELECT meta_value
						FROM $wpdb->postmeta
						WHERE post_id = $post->post_id
						AND meta_key = %s
						",
							'bh_storelocator_location_lat'
						));

						$lng = $wpdb->get_var( $wpdb->prepare("
						SELECT meta_value
						FROM $wpdb->postmeta
						WHERE post_id = $post->post_id
						AND meta_key = %s
						",
							'bh_storelocator_location_lng'
						));

						// Create an array with the values to insert.
						if ( is_numeric( $lat ) && is_numeric( $lng ) ) {
							array_push( $location_coords, array( $post->post_id, $lat, $lng ) );
						}
					}
				}

				// Send for insertion.
				if ( count( $location_coords ) > 0 ) {
					update_option( 'bh_storelocator_coord_count', $i );

					bh_storelocator_bg_process_insert( $location_coords );
				}
			}
		} else {
			wp_clear_scheduled_hook( 'bh_storelocator_bg_process_coords' );
		}
	}
}

// Insert the coordinates into the custom DB table.
if ( ! function_exists( 'bh_storelocator_bg_process_insert' ) ) {
	/**
	 * Prepare the data for insertion into the custom DB table
	 *
	 * @param array $values coordinate values in the current set: post id, latitude, longitude.
	 */
	function bh_storelocator_bg_process_insert( $values ) {
		global $wpdb;
		$table_name = $wpdb->prefix . 'cardinal_locator_coords';
		$formatted_vals = array();
		$formatted_data = null;

		// Loop over the values, check them and format for insertion.
		foreach ( $values as $value ) {
			if ( is_numeric( $value[0] ) && is_numeric( $value[1] ) && is_numeric( $value[2] ) && 0 !== $value[0] ) {
				$insert_data = implode( ',', $value );

				array_push( $formatted_vals, '(' . $insert_data . ')' );
			}
		}

		if ( count( $formatted_vals ) > 0 ) {
			$formatted_data = implode( ',', $formatted_vals );

			// Insert into custom table.
			$wpdb->query("INSERT IGNORE
				INTO $table_name
				( id, lat, lng )
				VALUES $formatted_data" );
		}
	}
}
