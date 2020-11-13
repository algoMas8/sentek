<?php
/**
 * Language Settings
 *
 * @package BH_Store_Locator
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Language settings tab
 *
 * @param array $language_settings supported attributes and default values.
 */
function bh_storelocator_language_plugin_settings( $language_settings ) {

	$language_options = 'bh_storelocator_language_options';

	// Fetch existing options.
	$language_values = get_option( $language_options );

	// Parse option values into predefined keys, throw the rest away.
	$language_data = shortcode_atts( $language_settings, $language_values );

	register_setting(
		'plugin:bh_storelocator_language_option_group',
		$language_options,
		'bh_storelocator_validate_language_options'
	);

	// Language shortcode section.
	add_settings_section(
		'bh_storelocator_shortcode_language',
		__( 'Shortcode language Settings', 'bh-storelocator' ),
		'bh_storelocator_shortcode_language_description',
		'bh_storelocator_language_settings'
	);

	/**
	 * Explanation about shortcode language settings section.
	 */
	function bh_storelocator_shortcode_language_description() {
		echo wp_kses( '<p>' . __( 'Use the following options if you are using the shortcode.', 'bh-storelocator' ) . '</p>', array( 'p' => array() ) );
	}

	/**
	 * Address input label
	 */
	add_settings_field(
		'section_3_field_addressinputlabel',
		__( 'Address form input label', 'bh-storelocator' ),
		'bh_storelocator_render_section_3_field_addressinputlabel',
		'bh_storelocator_language_settings',
		'bh_storelocator_shortcode_language',
		array(
			'label_for'   => 'addressinputlabel',
			'name'        => 'addressinputlabel',
			'value'       => esc_attr( $language_data['addressinputlabel'] ),
			'option_name' => $language_options,
		)
	);

	/**
	 * Render the address input label field
	 *
	 * @param array $args label, name, value, option name.
	 */
	function bh_storelocator_render_section_3_field_addressinputlabel( $args ) {
		bh_storelocator_regulartextfield( $args, __( 'Address form input label displayed next to the main form field.', 'bh-storelocator' ) );
	}

	/**
	 * Name search label
	 */
	add_settings_field(
		'section_3_field_namesearchlabel',
		__( 'Name search input label', 'bh-storelocator' ),
		'bh_storelocator_render_section_3_field_namesearchlabel',
		'bh_storelocator_language_settings',
		'bh_storelocator_shortcode_language',
		array(
			'label_for'   => 'namesearchlabel',
			'name'        => 'namesearchlabel',
			'value'       => esc_attr( $language_data['namesearchlabel'] ),
			'option_name' => $language_options,
		)
	);

	/**
	 * Render the name search input label field
	 *
	 * @param array $args label, name, value, option name.
	 */
	function bh_storelocator_render_section_3_field_namesearchlabel( $args ) {
		bh_storelocator_regulartextfield( $args, __( 'Name search input label displayed next to the name search field.', 'bh-storelocator' ) );
	}

	/**
	 * Max distance label
	 */
	add_settings_field(
		'section_3_field_maxdistancelabel',
		__( 'Maximum distance label', 'bh-storelocator' ),
		'bh_storelocator_render_section_3_field_maxdistancelabel',
		'bh_storelocator_language_settings',
		'bh_storelocator_shortcode_language',
		array(
			'label_for'   => 'maxdistancelabel',
			'name'        => 'maxdistancelabel',
			'value'       => esc_attr( $language_data['maxdistancelabel'] ),
			'option_name' => $language_options,
		)
	);

	/**
	 * Render the max distance label field
	 *
	 * @param array $args label, name, value, option name.
	 */
	function bh_storelocator_render_section_3_field_maxdistancelabel( $args ) {
		bh_storelocator_regulartextfield( $args, __( 'Maximum distance label displayed next to the maximum distance field.', 'bh-storelocator' ) );
	}

	/**
	 * Region label
	 */
	add_settings_field(
		'section_3_field_regionlabel',
		__( 'Region label', 'bh-storelocator' ),
		'bh_storelocator_render_section_3_field_regionlabel',
		'bh_storelocator_language_settings',
		'bh_storelocator_shortcode_language',
		array(
			'label_for'   => 'regionlabel',
			'name'        => 'regionlabel',
			'value'       => esc_attr( $language_data['regionlabel'] ),
			'option_name' => $language_options,
		)
	);

	/**
	 * Render the region label field
	 *
	 * @param array $args label, name, value, option name.
	 */
	function bh_storelocator_render_section_3_field_regionlabel( $args ) {
		bh_storelocator_regulartextfield( $args, __( 'Region label displayed next to the region field.', 'bh-storelocator' ) );
	}

	/**
	 * Length unit label
	 */
	add_settings_field(
		'section_3_field_lengthunitlabel',
		__( 'Length unit swap label', 'bh-storelocator' ),
		'bh_storelocator_render_section_3_field_lengthunitlabel',
		'bh_storelocator_language_settings',
		'bh_storelocator_shortcode_language',
		array(
			'label_for'   => 'lengthunitlabel',
			'name'        => 'lengthunitlabel',
			'value'       => esc_attr( $language_data['lengthunitlabel'] ),
			'option_name' => $language_options,
		)
	);

	/**
	 * Render the length unit label field
	 *
	 * @param array $args label, name, value, option name.
	 */
	function bh_storelocator_render_section_3_field_lengthunitlabel( $args ) {
		bh_storelocator_regulartextfield( $args, __( 'Length unit swap label displayed next to the length unit swap (mi/km) field.', 'bh-storelocator' ) );
	}

	/**
	 * Sort by label
	 */
	add_settings_field(
		'section_3_field_sortbylabel',
		__( 'Sorting label', 'bh-storelocator' ),
		'bh_storelocator_render_section_3_field_sortbylabel',
		'bh_storelocator_language_settings',
		'bh_storelocator_shortcode_language',
		array(
			'label_for'   => 'sortbylabel',
			'name'        => 'sortbylabel',
			'value'       => esc_attr( $language_data['sortbylabel'] ),
			'option_name' => $language_options,
		)
	);

	/**
	 * Render the sortbylabel field
	 *
	 * @param array $args label, name, value, option name.
	 */
	function bh_storelocator_render_section_3_field_sortbylabel( $args ) {
		bh_storelocator_regulartextfield( $args, __( 'Sort label displayed next to the custom sorting select field.', 'bh-storelocator' ) );
	}

	/**
	 * Order label
	 */
	add_settings_field(
		'section_3_field_orderlabel',
		__( 'Order label', 'bh-storelocator' ),
		'bh_storelocator_render_section_3_field_orderlabel',
		'bh_storelocator_language_settings',
		'bh_storelocator_shortcode_language',
		array(
			'label_for'   => 'orderlabel',
			'name'        => 'orderlabel',
			'value'       => esc_attr( $language_data['orderlabel'] ),
			'option_name' => $language_options,
		)
	);

	/**
	 * Render the orderlabel field
	 *
	 * @param array $args label, name, value, option name.
	 */
	function bh_storelocator_render_section_3_field_orderlabel( $args ) {
		bh_storelocator_regulartextfield( $args, __( 'Order label displayed next to the custom sorting order (ascending/descending) select field.', 'bh-storelocator' ) );
	}

	/**
	 * Submit button label
	 */
	add_settings_field(
		'section_3_field_submitbtnlabel',
		__( 'Submit button label', 'bh-storelocator' ),
		'bh_storelocator_render_section_3_field_submitbtnlabel',
		'bh_storelocator_language_settings',
		'bh_storelocator_shortcode_language',
		array(
			'label_for'   => 'submitbtnlabel',
			'name'        => 'submitbtnlabel',
			'value'       => esc_attr( $language_data['submitbtnlabel'] ),
			'option_name' => $language_options,
		)
	);

	/**
	 * Render the submit button input label field
	 *
	 * @param array $args label, name, value, option name.
	 */
	function bh_storelocator_render_section_3_field_submitbtnlabel( $args ) {
		bh_storelocator_regulartextfield( $args, __( 'Text displayed on the submit button.', 'bh-storelocator' ) );
	}

	// Language section.
	add_settings_section(
		'bh_storelocator_language',
		__( 'Primary language Settings', 'bh-storelocator' ),
		'bh_storelocator_language_description',
		'bh_storelocator_language_settings'
	);

	/**
	 * Explanation about language settings section.
	 */
	function bh_storelocator_language_description() {
		echo wp_kses( '<p>' . __( 'Plugin language settings.', 'bh-storelocator' ) . '</p>', array( 'p' => array() ) );
	}

	/**
	 * Geocode error
	 */
	add_settings_field(
		'section_3_field_geocodeerror',
		__( 'Geocode error', 'bh-storelocator' ),
		'bh_storelocator_render_section_3_field_geocodeerror',
		'bh_storelocator_language_settings',
		'bh_storelocator_language',
		array(
			'label_for'   => 'geocodeerror',
			'name'        => 'geocodeerror',
			'value'       => esc_attr( $language_data['geocodeerror'] ),
			'option_name' => $language_options,
		)
	);

	/**
	 * Render the geocode error field
	 *
	 * @param array $args label, name, value, option name.
	 */
	function bh_storelocator_render_section_3_field_geocodeerror( $args ) {
		bh_storelocator_regulartextfield( $args, __( 'Error alert displayed when there is a geocoding error.', 'bh-storelocator' ) );
	}

	/**
	 * Address error
	 */
	add_settings_field(
		'section_3_field_addresserror',
		__( 'Address error', 'bh-storelocator' ),
		'bh_storelocator_render_section_3_field_addresserror',
		'bh_storelocator_language_settings',
		'bh_storelocator_language',
		array(
			'label_for'   => 'addresserror',
			'name'        => 'addresserror',
			'value'       => esc_attr( $language_data['addresserror'] ),
			'option_name' => $language_options,
		)
	);

	/**
	 * Render the address error field
	 *
	 * @param array $args label, name, value, option name.
	 */
	function bh_storelocator_render_section_3_field_addresserror( $args ) {
		bh_storelocator_regulartextfield( $args, __( 'Error alert displayed when an address is unable to be found.', 'bh-storelocator' ) );
	}

	/**
	 * Auto geocode error
	 */
	add_settings_field(
		'section_3_field_autogeocodeerror',
		__( 'Auto geocode error', 'bh-storelocator' ),
		'bh_storelocator_render_section_3_field_autogeocodeerror',
		'bh_storelocator_language_settings',
		'bh_storelocator_language',
		array(
			'label_for'   => 'autogeocodeerror',
			'name'        => 'autogeocodeerror',
			'value'       => esc_attr( $language_data['autogeocodeerror'] ),
			'option_name' => $language_options,
		)
	);

	/**
	 * Render auto geocode error field
	 *
	 * @param array $args label, name, value, option name.
	 */
	function bh_storelocator_render_section_3_field_autogeocodeerror( $args ) {
		bh_storelocator_regulartextfield( $args, __( 'Error alert displayed when HTML5 API geocoding fails.', 'bh-storelocator' ) );
	}

	/**
	 * Distance error
	 */
	add_settings_field(
		'section_3_field_distanceerror',
		__( 'Distance error', 'bh-storelocator' ),
		'bh_storelocator_render_section_3_field_distanceerror',
		'bh_storelocator_language_settings',
		'bh_storelocator_language',
		array(
			'label_for'   => 'distanceerror',
			'name'        => 'distanceerror',
			'value'       => esc_attr( $language_data['distanceerror'] ),
			'option_name' => $language_options,
		)
	);

	/**
	 * Render distance error field
	 *
	 * @param array $args label, name, value, option name.
	 */
	function bh_storelocator_render_section_3_field_distanceerror( $args ) {
		bh_storelocator_regulartextfield( $args, __( 'Error displayed when the closest location is more than the distance alert setting. Number and length unit are appended to this sentence. For example: Unfortunately, our closest location is more than 20 miles.', 'bh-storelocator' ) );
	}

	/**
	 * Mile
	 */
	add_settings_field(
		'section_3_field_milelang',
		__( 'Mile', 'bh-storelocator' ),
		'bh_storelocator_render_section_3_field_milelang',
		'bh_storelocator_language_settings',
		'bh_storelocator_language',
		array(
			'label_for'   => 'milelang',
			'name'        => 'milelang',
			'value'       => esc_attr( $language_data['milelang'] ),
			'option_name' => $language_options,
		)
	);

	/**
	 * Render mile field
	 *
	 * @param array $args label, name, value, option name.
	 */
	function bh_storelocator_render_section_3_field_milelang( $args ) {
		bh_storelocator_textfield( $args );
	}

	/**
	 * Miles
	 */
	add_settings_field(
		'section_3_field_mileslang',
		'Miles',
		'bh_storelocator_render_section_3_field_mileslang',
		'bh_storelocator_language_settings',
		'bh_storelocator_language',
		array(
			'label_for'   => 'mileslang',
			'name'        => 'mileslang',
			'value'       => esc_attr( $language_data['mileslang'] ),
			'option_name' => $language_options,
		)
	);

	/**
	 * Render miles field
	 *
	 * @param array $args label, name, value, option name.
	 */
	function bh_storelocator_render_section_3_field_mileslang( $args ) {
		bh_storelocator_textfield( $args );
	}

	/**
	 * Kilometer
	 */
	add_settings_field(
		'section_3_field_kilometerlang',
		__( 'Kilometer', 'bh-storelocator' ),
		'bh_storelocator_render_section_3_field_kilometerlang',
		'bh_storelocator_language_settings',
		'bh_storelocator_language',
		array(
			'label_for'   => 'kilometerlang',
			'name'        => 'kilometerlang',
			'value'       => esc_attr( $language_data['kilometerlang'] ),
			'option_name' => $language_options,
		)
	);

	/**
	 * Render kilometer field
	 *
	 * @param array $args label, name, value, option name.
	 */
	function bh_storelocator_render_section_3_field_kilometerlang( $args ) {
		bh_storelocator_textfield( $args );
	}

	/**
	 * Kilometers
	 */
	add_settings_field(
		'section_3_field_kilometerslang',
		__( 'Kilometers', 'bh-storelocator' ),
		'bh_storelocator_render_section_3_field_kilometerslang',
		'bh_storelocator_language_settings',
		'bh_storelocator_language',
		array(
			'label_for'   => 'kilometerslang',
			'name'        => 'kilometerslang',
			'value'       => esc_attr( $language_data['kilometerslang'] ),
			'option_name' => $language_options,
		)
	);

	/**
	 * Render kilometers field
	 *
	 * @param array $args label, name, value, option name.
	 */
	function bh_storelocator_render_section_3_field_kilometerslang( $args ) {
		bh_storelocator_textfield( $args );
	}

	/**
	 * No results title
	 */
	add_settings_field(
		'section_3_field_noresultstitle',
		__( 'No results title', 'bh-storelocator' ),
		'bh_storelocator_render_section_3_field_noresultstitle',
		'bh_storelocator_language_settings',
		'bh_storelocator_language',
		array(
			'label_for'   => 'noresultstitle',
			'name'        => 'noresultstitle',
			'value'       => esc_attr( $language_data['noresultstitle'] ),
			'option_name' => $language_options,
		)
	);

	/**
	 * Render no results title field
	 *
	 * @param array $args label, name, value, option name.
	 */
	function bh_storelocator_render_section_3_field_noresultstitle( $args ) {
		bh_storelocator_textfield( $args, __( 'Error title displayed when there are no results.', 'bh-storelocator' ) );
	}

	/**
	 * No results description
	 */
	add_settings_field(
		'section_3_field_noresultsdesc',
		__( 'No results description', 'bh-storelocator' ),
		'bh_storelocator_render_section_3_field_noresultsdesc',
		'bh_storelocator_language_settings',
		'bh_storelocator_language',
		array(
			'label_for'   => 'noresultsdesc',
			'name'        => 'noresultsdesc',
			'value'       => esc_attr( $language_data['noresultsdesc'] ),
			'option_name' => $language_options,
		)
	);

	/**
	 * Render no results description field
	 *
	 * @param array $args label, name, value, option name.
	 */
	function bh_storelocator_render_section_3_field_noresultsdesc( $args ) {
		bh_storelocator_regulartextfield( $args, __( 'Error description displayed when there are no results.', 'bh-storelocator' ) );
	}

	/**
	 * Next page field
	 */
	add_settings_field(
		'section_3_field_nextpage',
		__( 'Next page', 'bh-storelocator' ),
		'bh_storelocator_render_section_3_field_nextpage',
		'bh_storelocator_language_settings',
		'bh_storelocator_language',
		array(
			'label_for'   => 'nextpage',
			'name'        => 'nextpage',
			'value'       => esc_attr( $language_data['nextpage'] ),
			'option_name' => $language_options,
		)
	);

	/**
	 * Render next page field
	 *
	 * @param array $args label, name, value, option name.
	 */
	function bh_storelocator_render_section_3_field_nextpage( $args ) {
		bh_storelocator_textfield( $args, __( 'Displayed when pagination is enabled.', 'bh-storelocator' ) );
	}

	/**
	 * Prev page field
	 */
	add_settings_field(
		'section_3_field_prevpage',
		__( 'Previous page', 'bh-storelocator' ),
		'bh_storelocator_render_section_3_field_prevpage',
		'bh_storelocator_language_settings',
		'bh_storelocator_language',
		array(
			'label_for'   => 'prevpage',
			'name'        => 'prevpage',
			'value'       => esc_attr( $language_data['prevpage'] ),
			'option_name' => $language_options,
		)
	);

	/**
	 * Render prev page field
	 *
	 * @param array $args label, name, value, option name.
	 */
	function bh_storelocator_render_section_3_field_prevpage( $args ) {
		bh_storelocator_textfield( $args, __( 'Displayed when pagination is enabled.', 'bh-storelocator' ) );
	}
}
