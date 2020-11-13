<?php
/**
 * Cache remote location data
 *
 * @package BH_Store_Locator
 */

use function Cardinal_Locator\Helpers\is_relative_url;

/**
 * Class BH_Store_Locator_Cache_Remote_Data
 */
class BH_Store_Locator_Cache_Remote_Data {

	/**
	 * Primary option values.
	 *
	 * @var mixed|null|void
	 */
	public $primary_option_vals = null;

	/**
	 * BH_Store_Locator_Cache_Remote_Data constructor.
	 *
	 * @param array $primary_vals Primary setting values.
	 */
	public function __construct( $primary_vals ) {
		$this->primary_option_vals = $primary_vals;
	}

	/**
	 * Init.
	 */
	public function init() {

		// Skip everything if the Data file path is a relative URL.
		if ( isset( $this->primary_option_vals['datapath'] ) && ! is_relative_url( $this->primary_option_vals['datapath'] ) ) {
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		}
	}

	/**
	 * Enqueue scripts.
	 */
	public function enqueue_scripts() {
		$remote_data = $this->bh_storelocator_cache_remote_location_data();

		if ( ! empty( $remote_data ) ) {

			// Pass location data to the jQuery file.
			wp_localize_script( 'storelocator-script', 'bhStoreLocatorLocations', $remote_data );
		}
	}

	/**
	 * Attempt to cache the remote data locally to avoid making constant requests to the URL.
	 *
	 * @return array
	 */
	public function bh_storelocator_cache_remote_location_data() {
		return $this->bh_storelocator_parse_setup( $this->bh_storelocator_data_object_cache() );
	}

	/**
	 * Utilize object cache to store the remote JSON data.
	 */
	public function bh_storelocator_data_object_cache() {

		if ( false === ( $remote_data = wp_cache_get( 'bh_sl_remote_location_data', 'bh_storelocator' ) ) ) {
			$remote_data = $this->bh_storelocator_get_remote_location_data();
			wp_cache_set( 'bh_sl_remote_location_data', $remote_data, 'bh_storelocator', 30 * DAY_IN_SECONDS );
		}

		return $remote_data;
	}

	/**
	 * Get the value indicated in a multidimensional array from a string of keys.
	 *
	 * @param array  $arr Array to search.
	 * @param string $keys Keys to check for.
	 *
	 * @return array
	 */
	public function bh_storelocator_get_dynamic_array_val( $arr, $keys ) {
		$keys   = explode( ':', $keys );
		$active = $arr;

		if ( is_array( $keys ) ) {
			foreach ( $keys as $key => $val ) {

				if ( isset( $active[ $val ] ) ) {
					$active = $active[ $val ];
				} else {
					$active = null;
				}
			}
		}

		return $active;
	}

	/**
	 * Fetch the remote data from the URL entered in the primary settings.
	 *
	 * @return string
	 */
	public function bh_storelocator_get_remote_location_data() {
		$location_data = '';

		// Get the form data from the remote location.
		$response = wp_safe_remote_get(
			$this->primary_option_vals['datapath'],
			array(
				'timeout'     => 15,
				'httpversion' => '1.0',
			)
		);

		if ( is_wp_error( $response ) ) {
			echo esc_html( $response->get_error_message() );
		} else {
			$response_body = wp_remote_retrieve_body( $response );

			if ( ! empty( $response_body ) ) {
				$location_data = $response_body;
			}
		}

		return $location_data;
	}

	/**
	 * Set up the parsing
	 *
	 * @param string $data Location data string.
	 *
	 * @return array
	 */
	public function bh_storelocator_parse_setup( $data ) {
		$bh_sl_location_data            = array();
		$remote_data_structure_elements = apply_filters(
			'bh_sl_remote_locations_structure',
			array(
				'id'        => 'id',
				'name'      => 'name',
				'permalink' => 'permalink',
				'excerpt'   => 'excerpt',
				'address'   => 'address',
				'address2'  => 'address2',
				'city'      => 'city',
				'state'     => 'state',
				'postal'    => 'postal',
				'country'   => 'country',
				'email'     => 'email',
				'phone'     => 'phone',
				'fax'       => 'fax',
				'web'       => 'web',
				'hours1'    => 'hours1',
				'hours2'    => 'hours2',
				'hours3'    => 'hours3',
				'hours4'    => 'hours4',
				'hours5'    => 'hours5',
				'hours6'    => 'hours6',
				'hours7'    => 'hours7',
				'lat'       => 'lat',
				'lng'       => 'lng',
			)
		);

		// Parse data.
		if ( 'json' === $this->primary_option_vals['datatype'] || 'jsonp' === $this->primary_option_vals['datatype'] ) {
			$json_data     = json_decode( $data, true );
			$location_rows = apply_filters( 'bh_sl_remote_locations_array', $json_data );

			if ( is_array( $location_rows ) ) {
				foreach ( $location_rows as $location_row ) {
					$location_data = array();

					foreach ( $remote_data_structure_elements as $key => $val ) {
						$dynamic_val = $this->bh_storelocator_get_dynamic_array_val( $location_row, $val );

						$location_data[ $key ] = ( isset( $dynamic_val ) ) ? $dynamic_val : '';
					}

					if ( ! empty( $location_data['lat'] ) && ! empty( $location_data['lng'] ) ) {
						array_push( $bh_sl_location_data, $location_data );
					}
				}
			}
		} elseif ( 'xml' === $this->primary_option_vals['datatype'] || 'kml' === $this->primary_option_vals['datatype'] ) {
			$xml_data      = simplexml_load_string( $data );
			$row_count     = 0;
			$location_rows = apply_filters( 'bh_sl_remote_locations_array_xml', $xml_data );

			if ( is_array( $location_rows ) ) {
				foreach ( $location_rows as $location_row ) {
					$attributes    = array();
					$location_data = array();

					// First convert the attributes to a normal array.
					foreach ( $location_row->attributes() as $key => $val ) {
						$attributes[ $key ] = (string) $val[0];
					}

					foreach ( $remote_data_structure_elements as $key => $val ) {
						$dynamic_val = $this->bh_storelocator_get_dynamic_array_val( $attributes, $val );

						$location_data[ $key ] = ( isset( $dynamic_val ) ) ? $dynamic_val : '';
					}

					if ( ! empty( $location_data['lat'] ) && ! empty( $location_data['lng'] ) ) {
						array_push( $bh_sl_location_data, $location_data );
					}

					$row_count++;
				}
			}
		}

		return $bh_sl_location_data;
	}
}
