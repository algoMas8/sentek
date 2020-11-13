<?php
/**
 * Filter Settings
 *
 * @package BH_Store_Locator
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Filter settings tab
 *
 * @param array $filter_settings supported attributes and default values.
 */
function bh_storelocator_filter_plugin_settings( $filter_settings ) {

	$filter_options = 'bh_storelocator_filter_options';

	// Fetch existing options.
	$filter_values = get_option( $filter_options );

	// Parse option values into predefined keys, throw the rest away.
	$filter_data = shortcode_atts( $filter_settings, $filter_values );

	register_setting(
		'plugin:bh_storelocator_filter_option_group',
		$filter_options,
		'bh_storelocator_validate_filter_options'
	);

	add_settings_section(
		'bh_storelocator_filters',
		__( 'Filter Settings', 'bh-storelocator' ),
		'bh_storelocator_section_filters',
		'bh_storelocator_filter_settings'
	);

	/**
	 * Explanation about filter settings section.
	 */
	function bh_storelocator_section_filters() {
		echo wp_kses( '<p>' . __( 'Options to add filtering to the locator. Filter type settings are only used for the shortcode.', 'bh-storelocator' ) . '</p>', array( 'p' => array() ) );
	}

	/**
	 * Exclusive filtering
	 */
	add_settings_field(
		'section_6_field_exclusivefiltering',
		__( 'Exclusive filtering', 'bh-storelocator' ),
		'bh_storelocator_render_section_6_field_exclusivefiltering',
		'bh_storelocator_filter_settings',
		'bh_storelocator_filters',
		array(
			'label_for'   => 'exclusivefiltering',
			'name'        => 'exclusivefiltering',
			'value'       => esc_attr( $filter_data['exclusivefiltering'] ),
			'options'     => array(
				'false' => 'False',
				'true'  => 'True',
			),
			'option_name' => $filter_options,
		)
	);

	/**
	 * Render exclusive filtering field
	 *
	 * @param array $args label, name, value, option name.
	 */
	function bh_storelocator_render_section_6_field_exclusivefiltering( $args ) {
		bh_storelocator_selectfield( $args, __( 'Set to true to enable exclusive taxonomy filtering (OR) rather than the default inclusive (AND).', 'bh-storelocator' ) );
	}

	/**
	 * Set up the container and the initial fields for jQuery cloning
	 */
	add_settings_field(
		'section_6_field_taxfilterssetup',
		__( 'Filters', 'bh-storelocator' ),
		'bh_storelocator_render_section_6_field_taxfilterssetup',
		'bh_storelocator_filter_settings',
		'bh_storelocator_filters',
		array(
			'label_for'   => 'taxfilterssetup',
			'name'        => 'taxfilterssetup',
			'value'       => esc_attr( $filter_data['taxfilterssetup'] ),
			'option_name' => $filter_options,
		)
	);

	/**
	 * Render taxonomy filters section
	 *
	 * @param array $args label, name, value, option name.
	 */
	function bh_storelocator_render_section_6_field_taxfilterssetup( $args ) {
		bh_storelocator_taxfilters( $args );
	}
}
