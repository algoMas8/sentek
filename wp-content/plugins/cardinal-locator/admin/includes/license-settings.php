<?php
/**
 * License Settings
 *
 * @package BH_Store_Locator
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * License settings tab
 *
 * @param array $license_settings supported attributes and default values.
 */
function bh_storelocator_license_plugin_settings( $license_settings ) {

	$license_options = 'bh_storelocator_license_options';

	// Fetch existing options.
	$license_values = get_option( $license_options );

	// Parse option values into predefined keys, throw the rest away.
	$license_data = shortcode_atts( $license_settings, $license_values );

	register_setting(
		'plugin:bh_storelocator_license_option_group',
		$license_options,
		'bh_storelocator_validate_license_options'
	);

	add_settings_section(
		'bh_storelocator_license',
		__( 'License Settings', 'bh-storelocator' ),
		'bh_storelocator_section_license',
		'bh_storelocator_license_settings'
	);

	/**
	 * Explanation about license settings section.
	 */
	function bh_storelocator_section_license() {
		echo wp_kses( '<p>' . __( 'Activate your license below to receive updates and support.', 'bh-storelocator' ) . '</p>', array( 'p' => array() ) );
	}

	/**
	 * License field
	 */
	add_settings_field(
		'section_7_field_license_key',
		__( 'License key', 'bh-storelocator' ),
		'bh_storelocator_render_section_7_field_license_key',
		'bh_storelocator_license_settings',
		'bh_storelocator_license',
		array(
			'label_for'   => 'license_key',
			'name'        => 'license_key',
			'value'       => esc_attr( $license_data['license_key'] ),
			'option_name' => $license_options,
		)
	);

	/**
	 * Render the license input label field
	 *
	 * @param array $args label, name, value, option name.
	 */
	function bh_storelocator_render_section_7_field_license_key( $args ) {
		bh_storelocator_regulartextfield( $args, __( 'Enter the license key from your email receipt then click the Activate button.', 'bh-storelocator' ) );
	}
}
