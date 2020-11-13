<?php
/**
 * Field validation
 *
 * @package BH_Store_Locator
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Main field validation function
 *
 * @param array $values New setting group values.
 * @param array $default_values Default setting group values.
 *
 * @return array
 */
function bh_storelocator_validate_field( $values, $default_values ) {
	if ( ! is_array( $values ) ) {
		return $default_values;
	}

	$out = array();

	// Loop over the default values and compare to the new ones.
	foreach ( $default_values as $key => $value ) {
		// If the new value is empty, revert to the default.
		if ( ! isset( $values[ $key ] ) ||  ( '' === $values[ $key ] ) ) {
			$out[ $key ] = $value;
		} else {
			$current_option_page = filter_input( INPUT_POST, 'option_page', FILTER_SANITIZE_STRING );

			// Check the option type from the default values.
			$option_value_type = gettype( $value );

			if ( 'integer' === $option_value_type ) {
				// Validate number values.
				$out[ $key ] = bh_storelocator_validate_number( $value, $values[ $key ] );
			} elseif ( 'boolean' === $option_value_type ) {
				// Validate bool values.
				$out[ $key ] = bh_storelocator_validate_bool( $value, $values[ $key ] );
			} elseif ( 'array' === $option_value_type ) {
				// Validate array values.
				$out[ $key ] = bh_storelocator_validate_array( $value, $values[ $key ] );
			} else {
				// Otherwise just run the value through sanitize_text_field.
				$out[ $key ] = sanitize_text_field( $values[ $key ] );
			}

			// Check map styles file existence and valid JSON.
			if ( 'plugin:bh_storelocator_style_option_group' === $current_option_page ) {
				if ( 'true' === $values['mapstyles'] && 'mapstylesfile' === $key ) {
					$map_styles_file = untrailingslashit( get_home_path() ) . sanitize_text_field( $values[ $key ] );

					// File path check.
					if ( ! file_exists( $map_styles_file ) ) {
						$out[ $key ] = $value;

						add_settings_error(
							'mapstyles_path',
							esc_attr( 'mapstyles-path' ),
							__( 'Invalid map styles path. Please make sure you\'ve uploaded the file and it\'s in the correct location.', 'bh-storelocator' )
						);
					}

					// Valid JSON check.
					if ( file_exists( $map_styles_file ) && ! bh_storelocator_check_valid_json( $map_styles_file ) ) {
						$out[ $key ] = $value;

						add_settings_error(
							'mapstyles_json',
							esc_attr( 'mapstyles-json' ),
							__( 'Invalid JSON data. The map styles file appears to have an error and is not valid JSON.', 'bh-storelocator' )
						);
					}
				}
			}
		}
	}

	return $out;
}

/**
 * Number value validation
 *
 * @param integer $default Default int value.
 * @param string  $val Field value.
 *
 * @return int
 */
function bh_storelocator_validate_number( $default, $val ) {
	$valid = $default;

	if ( is_int( $val ) ) {
		$valid = intval( $val );
	}

	return $valid;
}

/**
 * Boolean value validation
 *
 * We're not saving as true bool values so this checks that the string is set to 'true' or 'false'.
 *
 * @param string $default Default value.
 * @param string $val Field value.
 *
 * @return bool
 */
function bh_storelocator_validate_bool( $default, $val ) {
	$valid = $default;

	if ( 'false' === $val || 'true' === $val ) {
		$valid = $val;
	}

	return $valid;
}

/**
 * Array value validation
 *
 * @param string $default Default value.
 * @param string $val Field value.
 *
 * @return array
 */
function bh_storelocator_validate_array( $default, $val ) {
	$valid = $default;

	if ( is_array( $val ) ) {
		$new_array = array();

		foreach ( $val as $key => $value ) {
			$new_array[ $key ] = sanitize_text_field( $value );
		}

		$valid = $new_array;
	}

	return $valid;
}

/**
 * Validate license options
 *
 * @param array $values Primary option values.
 *
 * @return array
 */
function bh_storelocator_validate_license_options( $values ) {
	$license_defaults = BH_Store_Locator_Defaults::get_license_defaults();
	return bh_storelocator_validate_field( $values, $license_defaults );
}

/**
 * Validate primary options
 *
 * @param array $values Primary option values.
 *
 * @return array
 */
function bh_storelocator_validate_primary_options( $values ) {
	$primary_defaults = BH_Store_Locator_Defaults::get_primary_defaults();
	return bh_storelocator_validate_field( $values, $primary_defaults );
}

/**
 * Validate style options
 *
 * @param array $values Style option values.
 *
 * @return array
 */
function bh_storelocator_validate_style_options( $values ) {
	$style_defaults = BH_Store_Locator_Defaults::get_style_defaults();
	return bh_storelocator_validate_field( $values, $style_defaults );
}

/**
 * Validate structure options
 *
 * @param array $values Structure option values.
 *
 * @return array
 */
function bh_storelocator_validate_structure_options( $values ) {
	$structure_defaults = BH_Store_Locator_Defaults::get_structure_defaults();
	return bh_storelocator_validate_field( $values, $structure_defaults );
}

/**
 * Validate language options
 *
 * @param array $values Language option values.
 *
 * @return array
 */
function bh_storelocator_validate_language_options( $values ) {
	$language_defaults = BH_Store_Locator_Defaults::get_language_defaults();
	return bh_storelocator_validate_field( $values, $language_defaults );
}

/**
 * Validate meta options
 *
 * @param array $values Meta option values.
 *
 * @return array
 */
function bh_storelocator_validate_meta_options( $values ) {
	$address_meta_defaults = BH_Store_Locator_Defaults::get_address_defaults();
	return bh_storelocator_validate_field( $values, $address_meta_defaults );
}

/**
 * Validate filter options
 *
 * @param array $values Filter option values.
 *
 * @return array
 */
function bh_storelocator_validate_filter_options( $values ) {
	$filter_defaults = BH_Store_Locator_Defaults::get_filter_defaults();
	return bh_storelocator_validate_field( $values, $filter_defaults );
}

/**
 * Validate JSON file
 *
 * @param string $file File path.
 *
 * @return bool
 */
function bh_storelocator_check_valid_json( $file ) {
	$result = false;
	$json = file_get_contents( $file );

	if ( null !== json_decode( $json ) ) {
		$result = true;
	}

	return $result;
}
