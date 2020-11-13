<?php
/**
 * Meta Settings
 *
 * @package BH_Store_Locator
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Meta settings tab
 *
 * @param array $meta_settings supported attributes and default values.
 */
function bh_storelocator_address_plugin_settings( $meta_settings ) {

	$meta_options = 'bh_storelocator_meta_options';

	// Fetch existing options.
	$meta_values = get_option( $meta_options );

	// Parse option values into predefined keys, throw the rest away.
	$meta_data = shortcode_atts( $meta_settings, $meta_values );

	register_setting(
		'plugin:bh_storelocator_meta_option_group',
		$meta_options,
		'bh_storelocator_validate_meta_options'
	);

	add_settings_section(
		'bh_storelocator_meta',
		__( 'Custom Field Address Settings', 'bh-storelocator' ),
		'bh_storelocator_section_meta_description',
		'bh_storelocator_meta_settings'
	);

	/**
	 * Explanation about the meta fields section
	 */
	function bh_storelocator_section_meta_description() {
		echo wp_kses( '<p>' . __( 'Select your custom field address meta keys below as needed if you want your locations geocoded when
		location posts are added or updated. If you have existing address data that uses only one field (the entire address
		is in one input box), add that key to the first address setting below and leave the rest blank. These settings expect that you already
		have existing locations set up as a custom post type with existing address meta fields - if you don\'t you should use another option for Data source
		under the Primary Settings tab.', 'bh-storelocator' ) . '</p>', array( 'p' => array() ) );
	}

	$custom_keys = array( '' );
	// Get the primary setting values.
	$primary_options     = get_option( 'bh_storelocator_primary_options' );
	if ( false !== $primary_options ) {
		$locations_post_type = $primary_options['posttype'];

		// Get all custom fields for our selected post type.
		$location_posts = get_posts( array(
			'post_type'      => $locations_post_type,
			'post_status'    => 'publish',
			'posts_per_page' => 500,
			'fields'         => 'ids',
			)
		);

		// Loop over all the posts to get the meta keys.
		foreach ( $location_posts as $lp ) {
			$meta_keys = get_post_custom_keys( $lp );
			foreach ( $meta_keys as $meta_key => $value ) {
				if ( ( ! in_array( $value, $custom_keys ) ) && ( '_' !== substr( $value, 0, 1 ) ) && ( 'bh_storelocator_location_lat' !== $value ) && ( 'bh_storelocator_location_lng' !== $value ) ) {
					$custom_keys[ $value ] = $value;
				}
			}
		}
	}

	/**
	 * Street address
	 */
	add_settings_field(
		'section_5_address',
		__( 'Street Address', 'bh-storelocator' ),
		'bh_storelocator_render_section_5_address',
		'bh_storelocator_meta_settings',
		'bh_storelocator_meta',
		array(
			'label_for'   => 'address',
			'name'        => 'address',
			'value'       => esc_attr( $meta_data['address'] ),
			'options'     => $custom_keys,
			'option_name' => $meta_options,
		)
	);

	/**
	 * Render street address field
	 *
	 * @param array $args label, name, value, option name.
	 */
	function bh_storelocator_render_section_5_address( $args ) {
		bh_storelocator_selectfield( $args );
	}

	/**
	 * Address 2
	 */
	add_settings_field(
		'section_5_address_secondary',
		__( 'Address 2', 'bh-storelocator' ),
		'bh_storelocator_render_section_5_address_secondary',
		'bh_storelocator_meta_settings',
		'bh_storelocator_meta',
		array(
			'label_for'   => 'address_secondary',
			'name'        => 'address_secondary',
			'value'       => esc_attr( $meta_data['address_secondary'] ),
			'options'     => $custom_keys,
			'option_name' => $meta_options,
		)
	);

	/**
	 * Render address 2 field
	 *
	 * @param array $args label, name, value, option name.
	 */
	function bh_storelocator_render_section_5_address_secondary( $args ) {
		bh_storelocator_selectfield( $args );
	}

	/**
	 * City
	 */
	add_settings_field(
		'section_5_city',
		__( 'City', 'bh-storelocator' ),
		'bh_storelocator_render_section_5_city',
		'bh_storelocator_meta_settings',
		'bh_storelocator_meta',
		array(
			'label_for'   => 'city',
			'name'        => 'city',
			'value'       => esc_attr( $meta_data['city'] ),
			'options'     => $custom_keys,
			'option_name' => $meta_options,
		)
	);

	/**
	 * Render city field
	 *
	 * @param array $args label, name, value, option name.
	 */
	function bh_storelocator_render_section_5_city( $args ) {
		bh_storelocator_selectfield( $args );
	}

	/**
	 * State
	 */
	add_settings_field(
		'section_5_state',
		__( 'State/Province', 'bh-storelocator' ),
		'bh_storelocator_render_section_5_state',
		'bh_storelocator_meta_settings',
		'bh_storelocator_meta',
		array(
			'label_for'   => 'state',
			'name'        => 'state',
			'value'       => esc_attr( $meta_data['state'] ),
			'options'     => $custom_keys,
			'option_name' => $meta_options,
		)
	);

	/**
	 * Render state field
	 *
	 * @param array $args label, name, value, option name.
	 */
	function bh_storelocator_render_section_5_state( $args ) {
		bh_storelocator_selectfield( $args );
	}

	/**
	 * Postal
	 */
	add_settings_field(
		'section_5_postal',
		__( 'Postal Code', 'bh-storelocator' ),
		'bh_storelocator_render_section_5_postal',
		'bh_storelocator_meta_settings',
		'bh_storelocator_meta',
		array(
			'label_for'   => 'postal',
			'name'        => 'postal',
			'value'       => esc_attr( $meta_data['postal'] ),
			'options'     => $custom_keys,
			'option_name' => $meta_options,
		)
	);

	/**
	 * Render postal field
	 *
	 * @param array $args label, name, value, option name.
	 */
	function bh_storelocator_render_section_5_postal( $args ) {
		bh_storelocator_selectfield( $args );
	}

	/**
	 * Country
	 */
	add_settings_field(
		'section_5_country',
		__( 'Country', 'bh-storelocator' ),
		'bh_storelocator_render_section_5_country',
		'bh_storelocator_meta_settings',
		'bh_storelocator_meta',
		array(
			'label_for'   => 'country',
			'name'        => 'country',
			'value'       => esc_attr( $meta_data['country'] ),
			'options'     => $custom_keys,
			'option_name' => $meta_options,
		)
	);

	/**
	 * Render country field
	 *
	 * @param array $args label, name, value, option name.
	 */
	function bh_storelocator_render_section_5_country( $args ) {
		$cctld_link = 'https://developers.google.com/maps/documentation/geocoding/#RegionCodes';

		bh_storelocator_selectfield(
			$args,
			sprintf( __( '<a target="%s" href="%s" rel="%s">ccTLD</a> two letter country codes highly recommended for field values.' , 'bh-storelocator' ), '_blank', $cctld_link, 'noopener noreferrer' )
		);
	}

	/**
	 * Phone
	 */
	add_settings_field(
		'section_5_phone',
		__( 'Phone', 'bh-storelocator' ),
		'bh_storelocator_render_section_5_phone',
		'bh_storelocator_meta_settings',
		'bh_storelocator_meta',
		array(
			'label_for'   => 'phone',
			'name'        => 'phone',
			'value'       => esc_attr( $meta_data['phone'] ),
			'options'     => $custom_keys,
			'option_name' => $meta_options,
		)
	);

	/**
	 * Render phone field
	 *
	 * @param array $args label, name, value, option name.
	 */
	function bh_storelocator_render_section_5_phone( $args ) {
		bh_storelocator_selectfield( $args );
	}

	/**
	 * Fax
	 */
	add_settings_field(
		'section_5_fax',
		__( 'Fax', 'bh-storelocator' ),
		'bh_storelocator_render_section_5_fax',
		'bh_storelocator_meta_settings',
		'bh_storelocator_meta',
		array(
			'label_for'   => 'fax',
			'name'        => 'fax',
			'value'       => esc_attr( $meta_data['fax'] ),
			'options'     => $custom_keys,
			'option_name' => $meta_options,
		)
	);

	/**
	 * Render fax field
	 *
	 * @param array $args label, name, value, option name.
	 */
	function bh_storelocator_render_section_5_fax( $args ) {
		bh_storelocator_selectfield( $args );
	}

	/**
	 * Email
	 */
	add_settings_field(
		'section_5_email',
		__( 'Email', 'bh-storelocator' ),
		'bh_storelocator_render_section_5_email',
		'bh_storelocator_meta_settings',
		'bh_storelocator_meta',
		array(
			'label_for'   => 'email',
			'name'        => 'email',
			'value'       => esc_attr( $meta_data['email'] ),
			'options'     => $custom_keys,
			'option_name' => $meta_options,
		)
	);

	/**
	 * Render email field
	 *
	 * @param array $args label, name, value, option name.
	 */
	function bh_storelocator_render_section_5_email( $args ) {
		bh_storelocator_selectfield( $args );
	}

	/**
	 * Website
	 */
	add_settings_field(
		'section_5_website',
		__( 'Website', 'bh-storelocator' ),
		'bh_storelocator_render_section_5_website',
		'bh_storelocator_meta_settings',
		'bh_storelocator_meta',
		array(
			'label_for'   => 'website',
			'name'        => 'website',
			'value'       => esc_attr( $meta_data['website'] ),
			'options'     => $custom_keys,
			'option_name' => $meta_options,
		)
	);

	/**
	 * Render website field
	 *
	 * @param array $args label, name, value, option name.
	 */
	function bh_storelocator_render_section_5_website( $args ) {
		bh_storelocator_selectfield( $args );
	}

	/**
	 * Hours 1
	 */
	add_settings_field(
		'section_5_hours_one',
		__( 'Hours 1', 'bh-storelocator' ),
		'bh_storelocator_render_section_5_hours_one',
		'bh_storelocator_meta_settings',
		'bh_storelocator_meta',
		array(
			'label_for'   => 'hours_one',
			'name'        => 'hours_one',
			'value'       => esc_attr( $meta_data['hours_one'] ),
			'options'     => $custom_keys,
			'option_name' => $meta_options,
		)
	);

	/**
	 * Render hours 1 field
	 *
	 * @param array $args label, name, value, option name.
	 */
	function bh_storelocator_render_section_5_hours_one( $args ) {
		bh_storelocator_selectfield( $args );
	}

	/**
	 * Hours 2
	 */
	add_settings_field(
		'section_5_hours_two',
		__( 'Hours 2', 'bh-storelocator' ),
		'bh_storelocator_render_section_5_hours_two',
		'bh_storelocator_meta_settings',
		'bh_storelocator_meta',
		array(
			'label_for'   => 'hours_two',
			'name'        => 'hours_two',
			'value'       => esc_attr( $meta_data['hours_two'] ),
			'options'     => $custom_keys,
			'option_name' => $meta_options,
		)
	);

	/**
	 * Render hours 2 field
	 *
	 * @param array $args label, name, value, option name.
	 */
	function bh_storelocator_render_section_5_hours_two( $args ) {
		bh_storelocator_selectfield( $args );
	}

	/**
	 * Hours 3
	 */
	add_settings_field(
		'section_5_hours_three',
		__( 'Hours 3', 'bh-storelocator' ),
		'bh_storelocator_render_section_5_hours_three',
		'bh_storelocator_meta_settings',
		'bh_storelocator_meta',
		array(
			'label_for'   => 'hours_three',
			'name'        => 'hours_three',
			'value'       => esc_attr( $meta_data['hours_three'] ),
			'options'     => $custom_keys,
			'option_name' => $meta_options,
		)
	);

	/**
	 * Render hours 3 field
	 *
	 * @param array $args label, name, value, option name.
	 */
	function bh_storelocator_render_section_5_hours_three( $args ) {
		bh_storelocator_selectfield( $args );
	}

	/**
	 * Hours 4
	 */
	add_settings_field(
		'section_5_hours_four',
		__( 'Hours 4', 'bh-storelocator' ),
		'bh_storelocator_render_section_5_hours_four',
		'bh_storelocator_meta_settings',
		'bh_storelocator_meta',
		array(
			'label_for'   => 'hours_four',
			'name'        => 'hours_four',
			'value'       => esc_attr( $meta_data['hours_four'] ),
			'options'     => $custom_keys,
			'option_name' => $meta_options,
		)
	);

	/**
	 * Render hours 4 field
	 *
	 * @param array $args label, name, value, option name.
	 */
	function bh_storelocator_render_section_5_hours_four( $args ) {
		bh_storelocator_selectfield( $args );
	}

	/**
	 * Hours 5
	 */
	add_settings_field(
		'section_5_hours_five',
		__( 'Hours 5', 'bh-storelocator' ),
		'bh_storelocator_render_section_5_hours_five',
		'bh_storelocator_meta_settings',
		'bh_storelocator_meta',
		array(
			'label_for'   => 'hours_five',
			'name'        => 'hours_five',
			'value'       => esc_attr( $meta_data['hours_five'] ),
			'options'     => $custom_keys,
			'option_name' => $meta_options,
		)
	);

	/**
	 * Render hours 5 field
	 *
	 * @param array $args label, name, value, option name.
	 */
	function bh_storelocator_render_section_5_hours_five( $args ) {
		bh_storelocator_selectfield( $args );
	}

	/**
	 * Hours 6
	 */
	add_settings_field(
		'section_5_hours_six',
		__( 'Hours 6', 'bh-storelocator' ),
		'bh_storelocator_render_section_5_hours_six',
		'bh_storelocator_meta_settings',
		'bh_storelocator_meta',
		array(
			'label_for'   => 'hours_six',
			'name'        => 'hours_six',
			'value'       => esc_attr( $meta_data['hours_six'] ),
			'options'     => $custom_keys,
			'option_name' => $meta_options,
		)
	);

	/**
	 * Render hours 6 field
	 *
	 * @param array $args label, name, value, option name.
	 */
	function bh_storelocator_render_section_5_hours_six( $args ) {
		bh_storelocator_selectfield( $args );
	}

	/**
	 * Hours 7
	 */
	add_settings_field(
		'section_5_hours_seven',
		__( 'Hours 7', 'bh-storelocator' ),
		'bh_storelocator_render_section_5_hours_seven',
		'bh_storelocator_meta_settings',
		'bh_storelocator_meta',
		array(
			'label_for'   => 'hours_seven',
			'name'        => 'hours_seven',
			'value'       => esc_attr( $meta_data['hours_seven'] ),
			'options'     => $custom_keys,
			'option_name' => $meta_options,
		)
	);

	/**
	 * Render hours 7 field
	 *
	 * @param array $args label, name, value, option name.
	 */
	function bh_storelocator_render_section_5_hours_seven( $args ) {
		bh_storelocator_selectfield( $args );
	}

	/**
	 * Latitude
	 */
	add_settings_field(
		'section_5_latitude',
		__( 'Latitude', 'bh-storelocator' ),
		'bh_storelocator_render_section_5_latitude',
		'bh_storelocator_meta_settings',
		'bh_storelocator_meta',
		array(
			'label_for'   => 'latitude',
			'name'        => 'latitude',
			'value'       => esc_attr( $meta_data['latitude'] ),
			'options'     => $custom_keys,
			'option_name' => $meta_options,
		)
	);

	/**
	 * Render latitude field
	 *
	 * @param array $args label, name, value, option name.
	 */
	function bh_storelocator_render_section_5_latitude( $args ) {
		bh_storelocator_selectfield( $args );
	}

	/**
	 * Longitude
	 */
	add_settings_field(
		'section_5_longitude',
		__( 'Longitude', 'bh-storelocator' ),
		'bh_storelocator_render_section_5_longitude',
		'bh_storelocator_meta_settings',
		'bh_storelocator_meta',
		array(
			'label_for'   => 'longitude',
			'name'        => 'longitude',
			'value'       => esc_attr( $meta_data['longitude'] ),
			'options'     => $custom_keys,
			'option_name' => $meta_options,
		)
	);

	/**
	 * Render longitude field
	 *
	 * @param array $args label, name, value, option name.
	 */
	function bh_storelocator_render_section_5_longitude( $args ) {
		bh_storelocator_selectfield( $args );
	}
}
