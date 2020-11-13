<?php
/**
 * Structure Settings
 *
 * @package BH_Store_Locator
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Structure settings tab
 *
 * @param array $structure_settings supported attributes and default values.
 */
function bh_storelocator_structure_plugin_settings( $structure_settings ) {

	$structure_options = 'bh_storelocator_structure_options';

	// Fetch existing options.
	$structure_values = get_option( $structure_options );

	// Parse option values into predefined keys, throw the rest away.
	$structure_data = shortcode_atts( $structure_settings, $structure_values );

	register_setting(
		'plugin:bh_storelocator_structure_option_group',
		$structure_options,
		'bh_storelocator_validate_structure_options'
	);

	add_settings_section(
		'bh_storelocator_structure',
		__( 'Structure Settings', 'bh-storelocator' ),
		'bh_storelocator_section_structure',
		'bh_storelocator_structure_settings'
	);

	/**
	 * Explanation about structure section.
	 */
	function bh_storelocator_section_structure() {
		echo wp_kses( '<p>' . __( 'The following options can be used to override the default HTML structure.', 'bh-storelocator' ) . '</p>', array( 'p' => array() ) );
	}

	/**
	 * Map container ID
	 */
	add_settings_field(
		'section_4_mapid',
		__( 'Map container ID', 'bh-storelocator' ),
		'bh_storelocator_render_section_4_mapid',
		'bh_storelocator_structure_settings',
		'bh_storelocator_structure',
		array(
			'label_for'   => 'mapid',
			'name'        => 'mapid',
			'value'       => esc_attr( $structure_data['mapid'] ),
			'option_name' => $structure_options,
		)
	);

	/**
	 * Render the map container ID field
	 *
	 * @param array $args label, name, value, option name.
	 */
	function bh_storelocator_render_section_4_mapid( $args ) {
		bh_storelocator_textfield( $args, __( 'The ID of the container element where the Google Map is displayed.', 'bh-storelocator' ) );
	}

	/**
	 * Location list container class
	 */
	add_settings_field(
		'section_4_listdiv',
		__( 'List container class', 'bh-storelocator' ),
		'bh_storelocator_render_section_4_listdiv',
		'bh_storelocator_structure_settings',
		'bh_storelocator_structure',
		array(
			'label_for'   => 'listdiv',
			'name'        => 'listdiv',
			'value'       => esc_attr( $structure_data['listdiv'] ),
			'option_name' => $structure_options,
		)
	);

	/**
	 * Render the location list container class field
	 *
	 * @param array $args label, name, value, option name.
	 */
	function bh_storelocator_render_section_4_listdiv( $args ) {
		bh_storelocator_textfield( $args, __( 'The class of the container around the location list.', 'bh-storelocator' ) );
	}

	/**
	 * Form container div
	 */
	add_settings_field(
		'section_4_formcontainerdiv',
		__( 'Form container class', 'bh-storelocator' ),
		'bh_storelocator_render_section_4_formcontainerdiv',
		'bh_storelocator_structure_settings',
		'bh_storelocator_structure',
		array(
			'label_for'   => 'formcontainerdiv',
			'name'        => 'formcontainerdiv',
			'value'       => esc_attr( $structure_data['formcontainerdiv'] ),
			'option_name' => $structure_options,
		)
	);

	/**
	 * Render the form container div field
	 *
	 * @param array $args label, name, value, option name.
	 */
	function bh_storelocator_render_section_4_formcontainerdiv( $args ) {
		bh_storelocator_textfield( $args, __( 'The class of the container around the form.', 'bh-storelocator' ) );
	}

	/**
	 * Form ID
	 */
	add_settings_field(
		'section_4_formid',
		__( 'Form ID', 'bh-storelocator' ),
		'bh_storelocator_render_section_4_formid',
		'bh_storelocator_structure_settings',
		'bh_storelocator_structure',
		array(
			'label_for'   => 'formid',
			'name'        => 'formid',
			'value'       => esc_attr( $structure_data['formid'] ),
			'option_name' => $structure_options,
		)
	);

	/**
	 * Render the form ID field
	 *
	 * @param array $args label, name, value, option name.
	 */
	function bh_storelocator_render_section_4_formid( $args ) {
		bh_storelocator_textfield( $args, __( 'The ID of the form.', 'bh-storelocator' ) );
	}

	/**
	 * No Form
	 */
	add_settings_field(
		'section_4_noform',
		__( 'Disable form tags', 'bh-storelocator' ),
		'bh_storelocator_render_section_4_noform',
		'bh_storelocator_structure_settings',
		'bh_storelocator_structure',
		array(
			'label_for'   => 'noform',
			'name'        => 'noform',
			'value'       => esc_attr( $structure_data['noform'] ),
			'options'     => array(
				'false' => 'False',
				'true'  => 'True',
			),
			'option_name' => $structure_options,
		)
	);

	/**
	 * Render the no form field
	 *
	 * @param array $args label, name, value, option name.
	 */
	function bh_storelocator_render_section_4_noform( $args ) {
		bh_storelocator_selectfield( $args, __( 'Set to true to disable form tags in shortcode output.', 'bh-storelocator' ) );
	}

	/**
	 * Address input ID
	 */
	add_settings_field(
		'section_4_inputid',
		__( 'Address input ID', 'bh-storelocator' ),
		'bh_storelocator_render_section_4_inputid',
		'bh_storelocator_structure_settings',
		'bh_storelocator_structure',
		array(
			'label_for'   => 'inputid',
			'name'        => 'inputid',
			'value'       => esc_attr( $structure_data['inputid'] ),
			'option_name' => $structure_options,
		)
	);

	/**
	 * Render the address input ID field
	 *
	 * @param array $args label, name, value, option name.
	 */
	function bh_storelocator_render_section_4_inputid( $args ) {
		bh_storelocator_textfield( $args, __( 'The ID of the form address input field.', 'bh-storelocator' ) );
	}

	/**
	 * Region
	 */
	add_settings_field(
		'section_4_field_region',
		__( 'Regions', 'bh-storelocator' ),
		'bh_storelocator_render_section_4_field_region',
		'bh_storelocator_structure_settings',
		'bh_storelocator_structure',
		array(
			'label_for'   => 'region',
			'name'        => 'region',
			'value'       => esc_attr( $structure_data['region'] ),
			'options'     => array(
				'false' => 'False',
				'true'  => 'True',
			),
			'option_name' => $structure_options,
		)
	);

	/**
	 * Render the region field
	 *
	 * @param array $args label, name, value, option name.
	 */
	function bh_storelocator_render_section_4_field_region( $args ) {
		bh_storelocator_selectfield( $args, __( 'Set to true to add a region/country parameter to the search form.', 'bh-storelocator' ) );
	}

	/**
	 * Region ID
	 */
	add_settings_field(
		'section_4_regionid',
		__( 'Region ID', 'bh-storelocator' ),
		'bh_storelocator_render_section_4_regionid',
		'bh_storelocator_structure_settings',
		'bh_storelocator_structure',
		array(
			'label_for'   => 'regionid',
			'name'        => 'regionid',
			'value'       => esc_attr( $structure_data['regionid'] ),
			'option_name' => $structure_options,
		)
	);

	/**
	 * Render the region ID field
	 *
	 * @param array $args label, name, value, option name.
	 */
	function bh_storelocator_render_section_4_regionid( $args ) {
		bh_storelocator_textfield( $args, __( 'The ID of the select element region (country) field.', 'bh-storelocator' ), true );
	}

	/**
	 * Region values
	 */
	add_settings_field(
		'section_4_regionvals',
		__( 'Region values', 'bh-storelocator' ),
		'bh_storelocator_render_section_4_regionvals',
		'bh_storelocator_structure_settings',
		'bh_storelocator_structure',
		array(
			'label_for'   => 'regionvals',
			'name'        => 'regionvals',
			'value'       => esc_attr( $structure_data['regionvals'] ),
			'option_name' => $structure_options,
		)
	);

	/**
	 * Render the region values textarea field
	 *
	 * @param array $args label, name, value, option name.
	 */
	function bh_storelocator_render_section_4_regionvals( $args ) {
		$cctld_link = 'https://developers.google.com/maps/documentation/javascript/geocoding#GeocodingRegionCodes';

		bh_storelocator_textareafield(
			$args,
			sprintf( __( 'Optional comma separated list of <a target="%s" href="%s" rel="%s">ccTLD</a> two letter country codes. Ex: US,UK,CA', 'bh-storelocator' ), '_blank', $cctld_link, 'noopener noreferrer' ),
			true
		);
	}

	/**
	 * Modal overlay class
	 */
	add_settings_field(
		'section_4_overlaydiv',
		__( 'Modal overlay class', 'bh-storelocator' ),
		'bh_storelocator_render_section_4_overlaydiv',
		'bh_storelocator_structure_settings',
		'bh_storelocator_structure',
		array(
			'label_for'   => 'overlaydiv',
			'name'        => 'overlaydiv',
			'value'       => esc_attr( $structure_data['overlaydiv'] ),
			'option_name' => $structure_options,
		)
	);

	/**
	 * Render the modal overlay class field
	 *
	 * @param array $args label, name, value, option name.
	 */
	function bh_storelocator_render_section_4_overlaydiv( $args ) {
		bh_storelocator_textfield( $args, __( 'The div that fills 100% of the window and fills with a transparent background image when the modal window option is used.', 'bh-storelocator' ) );
	}

	/**
	 * Modal class
	 */
	add_settings_field(
		'section_4_modalwindowdiv',
		__( 'Modal class', 'bh-storelocator' ),
		'bh_storelocator_render_section_4_modalwindowdiv',
		'bh_storelocator_structure_settings',
		'bh_storelocator_structure',
		array(
			'label_for'   => 'modalwindowdiv',
			'name'        => 'modalwindowdiv',
			'value'       => esc_attr( $structure_data['modalwindowdiv'] ),
			'option_name' => $structure_options,
		)
	);

	/**
	 * Render the modal class field
	 *
	 * @param array $args label, name, value, option name.
	 */
	function bh_storelocator_render_section_4_modalwindowdiv( $args ) {
		bh_storelocator_textfield( $args, __( 'The class of the modal window.', 'bh-storelocator' ) );
	}

	/**
	 * Modal content div
	 */
	add_settings_field(
		'section_4_modalcontentdiv',
		__( 'Modal content class', 'bh-storelocator' ),
		'bh_storelocator_render_section_4_modalcontentdiv',
		'bh_storelocator_structure_settings',
		'bh_storelocator_structure',
		array(
			'label_for'   => 'modalcontentdiv',
			'name'        => 'modalcontentdiv',
			'value'       => esc_attr( $structure_data['modalcontentdiv'] ),
			'option_name' => $structure_options,
		)
	);

	/**
	 * Render the modal content div field
	 *
	 * @param array $args label, name, value, option name.
	 */
	function bh_storelocator_render_section_4_modalcontentdiv( $args ) {
		bh_storelocator_textfield( $args, __( 'The div container of the actual modal window.', 'bh-storelocator' ) );
	}

	/**
	 * Modal close icon class
	 */
	add_settings_field(
		'section_4_modalcloseicondiv',
		__( 'Modal close icon class', 'bh-storelocator' ),
		'bh_storelocator_render_section_4_modalcloseicondiv',
		'bh_storelocator_structure_settings',
		'bh_storelocator_structure',
		array(
			'label_for'   => 'modalcloseicondiv',
			'name'        => 'modalcloseicondiv',
			'value'       => esc_attr( $structure_data['modalcloseicondiv'] ),
			'option_name' => $structure_options,
		)
	);

	/**
	 * Render the modal close icon class field
	 *
	 * @param array $args label, name, value, option name.
	 */
	function bh_storelocator_render_section_4_modalcloseicondiv( $args ) {
		bh_storelocator_textfield( $args, __( 'The class of the close modal icon.', 'bh-storelocator' ) );
	}

	/**
	 * Max distance
	 */
	add_settings_field(
		'section_4_field_maxdistance',
		__( 'Maximum distance', 'bh-storelocator' ),
		'bh_storelocator_render_section_4_field_maxdistance',
		'bh_storelocator_structure_settings',
		'bh_storelocator_structure',
		array(
			'label_for'   => 'maxdistance',
			'name'        => 'maxdistance',
			'value'       => esc_attr( $structure_data['maxdistance'] ),
			'options'     => array(
				'false' => 'False',
				'true'  => 'True',
			),
			'option_name' => $structure_options,
		)
	);

	/**
	 * Render the max distance field
	 *
	 * @param array $args label, name, value, option name.
	 */
	function bh_storelocator_render_section_4_field_maxdistance( $args ) {
		bh_storelocator_selectfield( $args, __( 'Set to true if you want to give users an option to limit the distance from their location to the markers.', 'bh-storelocator' ) );
	}

	/**
	 * Max distance ID
	 */
	add_settings_field(
		'section_4_maxdistanceid',
		__( 'Maximum distance ID', 'bh-storelocator' ),
		'bh_storelocator_render_section_4_maxdistanceid',
		'bh_storelocator_structure_settings',
		'bh_storelocator_structure',
		array(
			'label_for'   => 'maxdistanceid',
			'name'        => 'maxdistanceid',
			'value'       => esc_attr( $structure_data['maxdistanceid'] ),
			'option_name' => $structure_options,
		)
	);

	/**
	 * Render the max distance ID field
	 *
	 * @param array $args label, name, value, option name.
	 */
	function bh_storelocator_render_section_4_maxdistanceid( $args ) {
		bh_storelocator_textfield( $args, __( 'The ID of the select element for the maximum distance options.', 'bh-storelocator' ), true );
	}

	/**
	 * Max distance parameters
	 */
	add_settings_field(
		'section_4_maxdistvals',
		__( 'Max distance values', 'bh-storelocator' ),
		'bh_storelocator_render_section_4_maxdistvals',
		'bh_storelocator_structure_settings',
		'bh_storelocator_structure',
		array(
			'label_for'   => 'maxdistvals',
			'name'        => 'maxdistvals',
			'value'       => esc_attr( $structure_data['maxdistvals'] ),
			'option_name' => $structure_options,
		)
	);

	/**
	 * Render the max distance parameters field
	 *
	 * @param array $args label, name, value, option name.
	 */
	function bh_storelocator_render_section_4_maxdistvals( $args ) {
		bh_storelocator_textfield( $args, __( 'Optional comma separated list of distance values to include with shortcode markup. Ex: 10,20,30,40', 'bh-storelocator' ), true );
	}

	/**
	 * Loading
	 */
	add_settings_field(
		'section_4_field_loading',
		__( 'Loading Icon', 'bh-storelocator' ),
		'bh_storelocator_render_section_4_field_loading',
		'bh_storelocator_structure_settings',
		'bh_storelocator_structure',
		array(
			'label_for'   => 'loading',
			'name'        => 'loading',
			'value'       => esc_attr( $structure_data['loading'] ),
			'options'     => array(
				'false' => 'False',
				'true'  => 'True',
			),
			'option_name' => $structure_options,
		)
	);

	/**
	 * Render the loading field
	 *
	 * @param array $args label, name, value, option name.
	 */
	function bh_storelocator_render_section_4_field_loading( $args ) {
		bh_storelocator_selectfield( $args, __( 'Set to true to display a loading animated gif next to the submit button. Note, that if you don’t have a lot of location data, it may not even be shown because of the speed.', 'bh-storelocator' ) );
	}

	/**
	 * Loading container class
	 */
	add_settings_field(
		'section_4_loadingdiv',
		__( 'Loading container class', 'bh-storelocator' ),
		'bh_storelocator_render_section_4_loadingdiv',
		'bh_storelocator_structure_settings',
		'bh_storelocator_structure',
		array(
			'label_for'   => 'loadingdiv',
			'name'        => 'loadingdiv',
			'value'       => esc_attr( $structure_data['loadingdiv'] ),
			'option_name' => $structure_options,
		)
	);

	/**
	 * Render the loading container class field
	 *
	 * @param array $args label, name, value, option name.
	 */
	function bh_storelocator_render_section_4_loadingdiv( $args ) {
		bh_storelocator_textfield( $args, __( 'The class of the container around the loading animated gif.', 'bh-storelocator' ), true );
	}

	/**
	 * Length unit swap
	 */
	add_settings_field(
		'section_4_field_lengthswap',
		__( 'Length unit swap (mi/km)', 'bh-storelocator' ),
		'bh_storelocator_render_section_4_field_lengthswap',
		'bh_storelocator_structure_settings',
		'bh_storelocator_structure',
		array(
			'label_for'   => 'lengthswap',
			'name'        => 'lengthswap',
			'value'       => esc_attr( $structure_data['lengthswap'] ),
			'options'     => array(
				'false' => 'False',
				'true'  => 'True',
			),
			'option_name' => $structure_options,
		)
	);

	/**
	 * Render length unit swap field
	 *
	 * @param array $args label, name, value, option name.
	 */
	function bh_storelocator_render_section_4_field_lengthswap( $args ) {
		bh_storelocator_selectfield( $args, __( 'Set to true to display a front-end unit swap select field between miles and kilometers. The default length unit will be taken from the Primary Settings > Length unit setting.', 'bh-storelocator' ) );
	}

	/**
	 * Length unit ID
	 */
	add_settings_field(
		'section_4_lengthswapid',
		__( 'Length unit ID', 'bh-storelocator' ),
		'bh_storelocator_render_section_4_lengthswapid',
		'bh_storelocator_structure_settings',
		'bh_storelocator_structure',
		array(
			'label_for'   => 'lengthswapid',
			'name'        => 'lengthswapid',
			'value'       => esc_attr( $structure_data['lengthswapid'] ),
			'option_name' => $structure_options,
		)
	);

	/**
	 * Render the length swap ID field
	 *
	 * @param array $args label, name, value, option name.
	 */
	function bh_storelocator_render_section_4_lengthswapid( $args ) {
		bh_storelocator_textfield( $args, __( 'The ID of the select field.', 'bh-storelocator' ), true );
	}

	/**
	 * Custom sorting
	 */
	add_settings_field(
		'section_4_field_customsorting',
		__( 'Custom sorting', 'bh-storelocator' ),
		'bh_storelocator_render_section_4_field_customsorting',
		'bh_storelocator_structure_settings',
		'bh_storelocator_structure',
		array(
			'label_for'   => 'customsorting',
			'name'        => 'customsorting',
			'value'       => esc_attr( $structure_data['customsorting'] ),
			'options'     => array(
				'false' => 'False',
				'true'  => 'True',
			),
			'option_name' => $structure_options,
		)
	);

	/**
	 * Render customsorting field
	 *
	 * @param array $args label, name, value, option name.
	 */
	function bh_storelocator_render_section_4_field_customsorting( $args ) {
		bh_storelocator_selectfield( $args, __( 'Enable the option to sort locations using custom parameters.', 'bh-storelocator' ) );
	}

	/**
	 * Custom sorting ID.
	 */
	add_settings_field(
		'section_4_customsortingid',
		__( 'Custom sorting ID', 'bh-storelocator' ),
		'bh_storelocator_render_section_4_customsortingid',
		'bh_storelocator_structure_settings',
		'bh_storelocator_structure',
		array(
			'label_for'   => 'customsortingid',
			'name'        => 'customsortingid',
			'value'       => esc_attr( $structure_data['customsortingid'] ),
			'option_name' => $structure_options,
		)
	);

	/**
	 * Render customsortingid field
	 *
	 * @param array $args label, name, value, option name.
	 */
	function bh_storelocator_render_section_4_customsortingid( $args ) {
		bh_storelocator_textfield( $args, __( 'The ID of the select field.', 'bh-storelocator' ), true );
	}

	/**
	 * Initial sorting method
	 */
	add_settings_field(
		'section_4_field_customsortingmethod',
		__( 'Custom sorting initial method', 'bh-storelocator' ),
		'bh_storelocator_render_section_4_field_customsortingmethod',
		'bh_storelocator_structure_settings',
		'bh_storelocator_structure',
		array(
			'label_for'   => 'customsortingmethod',
			'name'        => 'customsortingmethod',
			'value'       => esc_attr( $structure_data['customsortingmethod'] ),
			'options'     => array(
				'alpha'   => __( 'Alphabetical', 'bh-storelocator' ),
				'date'    => __( 'Date', 'bh-storelocator' ),
				'numeric' => __( 'Numeric', 'bh-storelocator' ),
			),
			'option_name' => $structure_options,
		)
	);

	/**
	 * Custom order ID.
	 */
	add_settings_field(
		'section_4_customorderid',
		__( 'Custom order ID', 'bh-storelocator' ),
		'bh_storelocator_render_section_4_customorderid',
		'bh_storelocator_structure_settings',
		'bh_storelocator_structure',
		array(
			'label_for'   => 'customorderid',
			'name'        => 'customorderid',
			'value'       => esc_attr( $structure_data['customorderid'] ),
			'option_name' => $structure_options,
		)
	);

	/**
	 * Render customorderid field
	 *
	 * @param array $args label, name, value, option name.
	 */
	function bh_storelocator_render_section_4_customorderid( $args ) {
		bh_storelocator_textfield( $args, __( 'The ID of the order field.', 'bh-storelocator' ), true );
	}

	/**
	 * Render customsortingmethod field
	 *
	 * @param array $args label, name, value, option name.
	 */
	function bh_storelocator_render_section_4_field_customsortingmethod( $args ) {
		bh_storelocator_selectfield( $args, __( 'The initial sorting method that will used when the locator page first loads. Alphabetical is the default since this is an override.', 'bh-storelocator' ), true );
	}

	/**
	 * Sorting order
	 */
	add_settings_field(
		'section_4_field_customsortingorder',
		__( 'Custom sorting initial order', 'bh-storelocator' ),
		'bh_storelocator_render_section_4_field_customsortingorder',
		'bh_storelocator_structure_settings',
		'bh_storelocator_structure',
		array(
			'label_for'   => 'customsortingorder',
			'name'        => 'customsortingorder',
			'value'       => esc_attr( $structure_data['customsortingorder'] ),
			'options'     => array(
				'asc'  => __( 'Ascending', 'bh-storelocator' ),
				'desc' => __( 'Descending', 'bh-storelocator' ),
			),
			'option_name' => $structure_options,
		)
	);

	/**
	 * Render customsortingorder field
	 *
	 * @param array $args label, name, value, option name.
	 */
	function bh_storelocator_render_section_4_field_customsortingorder( $args ) {
		bh_storelocator_selectfield( $args, __( 'The initial sorting order that will used. Ascending is the default.', 'bh-storelocator' ), true );
	}

	/**
	 * Initial sorting property
	 */
	add_settings_field(
		'section_4_field_customsortingprop',
		__( 'Custom sorting initial property', 'bh-storelocator' ),
		'bh_storelocator_render_section_4_field_customsortingprop',
		'bh_storelocator_structure_settings',
		'bh_storelocator_structure',
		array(
			'label_for'   => 'customsortingprop',
			'name'        => 'customsortingprop',
			'value'       => esc_attr( $structure_data['customsortingprop'] ),
			'options'     => array(
				'name'     => __( 'Name', 'bh-storelocator' ),
				'address'  => __( 'Address', 'bh-storelocator' ),
				'address2' => __( 'Address 2', 'bh-storelocator' ),
				'city'     => __( 'City', 'bh-storelocator' ),
				'state'    => __( 'State', 'bh-storelocator' ),
				'country'  => __( 'Country', 'bh-storelocator' ),
				'distance' => __( 'Distance', 'bh-storelocator' ),
				'date'     => __( 'Post date', 'bh-storelocator' ),
			),
			'option_name' => $structure_options,
		)
	);

	/**
	 * Render customsortingprop field
	 *
	 * @param array $args label, name, value, option name.
	 */
	function bh_storelocator_render_section_4_field_customsortingprop( $args ) {
		bh_storelocator_selectfield( $args, __( 'The initial sorting property to sort by when the locator page first loads. Name is the default.', 'bh-storelocator' ), true );
	}

	/**
	 * Name search
	 */
	add_settings_field(
		'section_4_field_namesearch',
		__( 'Name Search', 'bh-storelocator' ),
		'bh_storelocator_render_section_4_field_namesearch',
		'bh_storelocator_structure_settings',
		'bh_storelocator_structure',
		array(
			'label_for'   => 'namesearch',
			'name'        => 'namesearch',
			'value'       => esc_attr( $structure_data['namesearch'] ),
			'options'     => array(
				'false' => 'False',
				'true'  => 'True',
			),
			'option_name' => $structure_options,
		)
	);

	/**
	 * Render name search field
	 *
	 * @param array $args label, name, value, option name.
	 */
	function bh_storelocator_render_section_4_field_namesearch( $args ) {
		bh_storelocator_selectfield( $args, __( 'Set to true to allow searching for locations by name using separate searchID field.', 'bh-storelocator' ) );
	}

	/**
	 * Name search ID
	 */
	add_settings_field(
		'section_4_namesearchid',
		__( 'Name search ID', 'bh-storelocator' ),
		'bh_storelocator_render_section_4_namesearchid',
		'bh_storelocator_structure_settings',
		'bh_storelocator_structure',
		array(
			'label_for'   => 'namesearchid',
			'name'        => 'namesearchid',
			'value'       => esc_attr( $structure_data['namesearchid'] ),
			'option_name' => $structure_options,
		)
	);

	/**
	 * Name attribute
	 */
	add_settings_field(
		'section_4_nameattribute',
		__( 'Name attribute', 'bh-storelocator' ),
		'bh_storelocator_render_section_4_nameattribute',
		'bh_storelocator_structure_settings',
		'bh_storelocator_structure',
		array(
			'label_for'   => 'nameattribute',
			'name'        => 'nameattribute',
			'value'       => esc_attr( $structure_data['nameattribute'] ),
			'option_name' => $structure_options,
		)
	);

	/**
	 * Render the name attribute field
	 *
	 * @param array $args label, name, value, option name.
	 */
	function bh_storelocator_render_section_4_nameattribute( $args ) {
		bh_storelocator_textfield( $args, __( 'If using nameSearch, the data attribute used for the location name in the data file. Leave as is if using a custom post type.', 'bh-storelocator' ), true );
	}

	/**
	 * Render the name search ID field
	 *
	 * @param array $args label, name, value, option name.
	 */
	function bh_storelocator_render_section_4_namesearchid( $args ) {
		bh_storelocator_textfield( $args, __( 'ID of the search input form field for location name searching.', 'bh-storelocator' ), true );
	}

	/**
	 * Geocode button
	 */
	add_settings_field(
		'section_4_field_geocodebtn',
		__( 'Geocode button', 'bh-storelocator' ),
		'bh_storelocator_render_section_4_field_geocodebtn',
		'bh_storelocator_structure_settings',
		'bh_storelocator_structure',
		array(
			'label_for'   => 'geocodebtn',
			'name'        => 'geocodebtn',
			'value'       => esc_attr( $structure_data['geocodebtn'] ),
			'options'     => array(
				'false' => 'False',
				'true'  => 'True',
			),
			'option_name' => $structure_options,
		)
	);

	/**
	 * Render the geocodebtn field
	 *
	 * @param array $args label, name, value, option name.
	 */
	function bh_storelocator_render_section_4_field_geocodebtn( $args ) {
		bh_storelocator_selectfield( $args, __( 'Set to true to assign a button ID to the HTML geolocation API (ex: a "find me" button).', 'bh-storelocator' ) );
	}

	/**
	 * Geocode button ID
	 */
	add_settings_field(
		'section_4_geocodebtnid',
		__( 'Geocode button ID', 'bh-storelocator' ),
		'bh_storelocator_render_section_4_geocodebtnid',
		'bh_storelocator_structure_settings',
		'bh_storelocator_structure',
		array(
			'label_for'   => 'geocodebtnid',
			'name'        => 'geocodebtnid',
			'value'       => esc_attr( $structure_data['geocodebtnid'] ),
			'option_name' => $structure_options,
		)
	);

	/**
	 * Render the geocode button ID field
	 *
	 * @param array $args label, name, value, option name.
	 */
	function bh_storelocator_render_section_4_geocodebtnid( $args ) {
		bh_storelocator_textfield( $args, __( 'The ID of the geocode button.', 'bh-storelocator' ), true );
	}

	/**
	 * Geocode button label
	 */
	add_settings_field(
		'section_4_geocodebtnlabel',
		__( 'Geocode button label', 'bh-storelocator' ),
		'bh_storelocator_render_section_4_geocodebtnlabel',
		'bh_storelocator_structure_settings',
		'bh_storelocator_structure',
		array(
			'label_for'   => 'geocodebtnlabel',
			'name'        => 'geocodebtnlabel',
			'value'       => esc_attr( $structure_data['geocodebtnlabel'] ),
			'option_name' => $structure_options,
		)
	);

	/**
	 * Render the geocode button label field
	 *
	 * @param array $args label, name, value, option name.
	 */
	function bh_storelocator_render_section_4_geocodebtnlabel( $args ) {
		bh_storelocator_textfield( $args, __( 'The label of the geocode button.', 'bh-storelocator' ), true );
	}

	/**
	 * Taxonomy filters container class
	 */
	add_settings_field(
		'section_4_taxonomyfilterscontainer',
		__( 'Taxonomy filters container class', 'bh-storelocator' ),
		'bh_storelocator_render_section_4_taxonomyfilterscontainer',
		'bh_storelocator_structure_settings',
		'bh_storelocator_structure',
		array(
			'label_for'   => 'taxonomyfilterscontainer',
			'name'        => 'taxonomyfilterscontainer',
			'value'       => esc_attr( $structure_data['taxonomyfilterscontainer'] ),
			'option_name' => $structure_options,
		)
	);

	/**
	 * Render the taxonomy filters container class field
	 *
	 * @param array $args label, name, value, option name.
	 */
	function bh_storelocator_render_section_4_taxonomyfilterscontainer( $args ) {
		bh_storelocator_textfield( $args, __( 'Class of the container around the filters.', 'bh-storelocator' ) );
	}

	/**
	 * List template ID
	 */
	add_settings_field(
		'section_4_listid',
		__( 'List template ID', 'bh-storelocator' ),
		'bh_storelocator_render_section_4_listid',
		'bh_storelocator_structure_settings',
		'bh_storelocator_structure',
		array(
			'label_for'   => 'listid',
			'name'        => 'listid',
			'value'       => esc_attr( $structure_data['listid'] ),
			'option_name' => $structure_options,
		)
	);

	/**
	 * Render the list template ID field
	 *
	 * @param array $args label, name, value, option name.
	 */
	function bh_storelocator_render_section_4_listid( $args ) {
		bh_storelocator_textfield( $args, __( 'ID of list template if using inline Handlebar templates instead of separate files (do not include the hash #).', 'bh-storelocator' ) );
	}

	/**
	 * Infowindow template ID
	 */
	add_settings_field(
		'section_4_infowindowid',
		__( 'Infowindow template ID', 'bh-storelocator' ),
		'bh_storelocator_render_section_4_infowindowid',
		'bh_storelocator_structure_settings',
		'bh_storelocator_structure',
		array(
			'label_for'   => 'infowindowid',
			'name'        => 'infowindowid',
			'value'       => esc_attr( $structure_data['infowindowid'] ),
			'option_name' => $structure_options,
		)
	);

	/**
	 * Render the infowindow template ID field
	 *
	 * @param array $args label, name, value, option name.
	 */
	function bh_storelocator_render_section_4_infowindowid( $args ) {
		bh_storelocator_textfield( $args, __( 'ID of infowindow template if using inline Handlebar templates instead of separate files (do not include the hash #).', 'bh-storelocator' ) );
	}
}
