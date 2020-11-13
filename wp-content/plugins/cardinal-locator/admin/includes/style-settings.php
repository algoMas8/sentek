<?php
/**
 * Style Settings
 *
 * @package BH_Store_Locator
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Style settings tabs
 *
 * @param array $style_settings supported attributes and default values.
 */
function bh_storelocator_style_plugin_settings( $style_settings ) {

	$style_options = 'bh_storelocator_style_options';

	// Fetch existing options.
	$style_values = get_option( $style_options );

	// Parse option values into predefined keys, throw the rest away.
	$style_data = shortcode_atts( $style_settings, $style_values );

	register_setting(
		'plugin:bh_storelocator_style_option_group',
		$style_options,
		'bh_storelocator_validate_style_options'
	);

	// Colors section.
	add_settings_section(
		'bh_storelocator_styles',
		__( 'Style Settings', 'bh-storelocator' ),
		'bh_storelocator_styles_description',
		'bh_storelocator_style_settings'
	);

	/**
	 * Explanation about colors section.
	 */
	function bh_storelocator_styles_description() {
		echo wp_kses( '<p>' . __( 'Color options. Other styles can be overwritten via CSS.', 'bh-storelocator' ) . '</p>', array( 'p' => array() ) );
	}

	/**
	 * List background color 1
	 */
	add_settings_field(
		'section_2_field_listbgcolor',
		__( 'List background color 1', 'bh-storelocator' ),
		'bh_storelocator_render_section_2_field_listbgcolor',
		'bh_storelocator_style_settings',
		'bh_storelocator_styles',
		array(
			'label_for'   => 'listbgcolor',
			'name'        => 'listbgcolor',
			'value'       => esc_attr( $style_data['listbgcolor'] ),
			'option_name' => $style_options,
		)
	);

	/**
	 * Render list background color 1 field
	 *
	 * @param array $args label, name, value, option name.
	 */
	function bh_storelocator_render_section_2_field_listbgcolor( $args ) {
		bh_storelocator_colorfield( $args );
	}

	/**
	 * List background color 2
	 */
	add_settings_field(
		'section_2_field_listbgcolor2',
		__( 'List background color 2', 'bh-storelocator' ),
		'bh_storelocator_render_section_2_field_listbgcolor2',
		'bh_storelocator_style_settings',
		'bh_storelocator_styles',
		array(
			'label_for'   => 'listbgcolor2',
			'name'        => 'listbgcolor2',
			'value'       => esc_attr( $style_data['listbgcolor2'] ),
			'option_name' => $style_options,
		)
	);

	/**
	 * Render list background color 2 field
	 *
	 * @param array $args label, name, value, option name.
	 */
	function bh_storelocator_render_section_2_field_listbgcolor2( $args ) {
		bh_storelocator_colorfield( $args );
	}

	/**
	 * Custom map styling
	 */
	add_settings_field(
		'section_2_field_mapstyles',
		__( 'Custom map styling', 'bh-storelocator' ),
		'bh_storelocator_render_section_2_field_mapstyles',
		'bh_storelocator_style_settings',
		'bh_storelocator_styles',
		array(
			'label_for'   => 'mapstyles',
			'name'        => 'mapstyles',
			'value'       => esc_attr( $style_data['mapstyles'] ),
			'options'     => array(
				'false' => 'False',
				'true'  => 'True',
			),
			'option_name' => $style_options,
		)
	);

	/**
	 * Render map styles field
	 *
	 * @param array $args label, name, value, option name.
	 */
	function bh_storelocator_render_section_2_field_mapstyles( $args ) {
		bh_storelocator_selectfield(
			$args,
			sprintf( __( 'Set to true if you want to <a target="%s" href="%s" rel="%s">customize the styling</a> of the Google Map.', 'bh-storelocator' ), '_blank', 'https://developers.google.com/maps/documentation/javascript/styling', 'noopener noreferrer' )
		);
	}

	/**
	 * Map styles file path
	 */
	add_settings_field(
		'section_2_field_mapstylesfile',
		__( 'Map styles path', 'bh-storelocator' ),
		'bh_storelocator_render_section_2_field_mapstylesfile',
		'bh_storelocator_style_settings',
		'bh_storelocator_styles',
		array(
			'label_for'   => 'mapstylesfile',
			'name'        => 'mapstylesfile',
			'value'       => esc_attr( $style_data['mapstylesfile'] ),
			'option_name' => $style_options,
		)
	);

	/**
	 * Render map styles file path field
	 *
	 * @param array $args label, name, value, option name.
	 */
	function bh_storelocator_render_section_2_field_mapstylesfile( $args ) {
		bh_storelocator_textfield(
			$args,
			sprintf( __( 'Upload path of JS file with styling array - do not set the array to a variable. Copying the array from <a target="%s" href="%s" rel="%s">Snazzy Maps</a> recommended. Path example: <ul><li>/wp-content/mapstyles.js</li></ul>', 'bh-storelocator' ), '_blank', 'https://snazzymaps.com/', 'noopener noreferrer' ),
			true
		);
	}

	/**
	 * Marker image replacement
	 */
	add_settings_field(
		'section_2_field_replacemarker',
		__( 'Custom map location marker', 'bh-storelocator' ),
		'bh_storelocator_render_section_2_field_replacemarker',
		'bh_storelocator_style_settings',
		'bh_storelocator_styles',
		array(
			'label_for'   => 'replacemarker',
			'name'        => 'replacemarker',
			'value'       => esc_attr( $style_data['replacemarker'] ),
			'options'     => array(
				'false' => 'False',
				'true'  => 'True',
			),
			'option_name' => $style_options,
		)
	);

	/**
	 * Render marker image replacement field
	 *
	 * @param array $args label, name, value, option name.
	 */
	function bh_storelocator_render_section_2_field_replacemarker( $args ) {
		bh_storelocator_selectfield( $args, __( 'Replace the location markers with a custom marker image.', 'bh-storelocator' ) );
	}

	/**
	 * Marker image path
	 */
	add_settings_field(
		'section_2_field_markerimage',
		__( 'Marker image', 'bh-storelocator' ),
		'bh_storelocator_render_section_2_field_markerimage',
		'bh_storelocator_style_settings',
		'bh_storelocator_styles',
		array(
			'label_for'   => 'markerimage',
			'name'        => 'markerimage',
			'value'       => esc_attr( $style_data['markerimage'] ),
			'option_name' => $style_options,
		)
	);

	/**
	 * Render marker image field
	 *
	 * @param array $args label, name, value, option name.
	 */
	function bh_storelocator_render_section_2_field_markerimage( $args ) {
		bh_storelocator_imagefield( $args, __( 'Replacement marker image used for all locations.', 'bh-storelocator' ), true );
	}

	/**
	 * Custom marker image dimensions
	 */
	add_settings_field(
		'section_2_field_markerimgdim',
		__( 'Marker dimensions', 'bh-storelocator' ),
		'bh_storelocator_render_section_2_field_markerimgdim',
		'bh_storelocator_style_settings',
		'bh_storelocator_styles',
		array(
			'label_for'   => 'markerimgdim',
			'name'        => 'markerimgdim',
			'value-width'       => esc_attr( $style_data['markerimgdimwidth'] ),
			'value-height' => esc_attr( $style_data['markerimgdimheight'] ),
			'option_name' => $style_options,
		)
	);

	/**
	 * Render custom marker image dimensions field
	 *
	 * @param array $args label, name, value, option name.
	 */
	function bh_storelocator_render_section_2_field_markerimgdim( $args ) {
		bh_storelocator_imagedimfield( $args, __( 'Optional marker image dimensions. Fallback is 32px x 32px.<br> For HDPI devices make the marker image at least double the size of the dimensions set in this field.', 'bh-storelocator' ), true );
	}

	/**
	 * Custom location category images
	 */
	add_settings_field(
		'section_2_field_loccatimgs',
		__( 'Custom location category marker images', 'bh-storelocator' ),
		'bh_storelocator_render_section_2_field_loccatimgs',
		'bh_storelocator_style_settings',
		'bh_storelocator_styles',
		array(
			'label_for'   => 'loccatimgs',
			'name'        => 'loccatimgs',
			'value'       => esc_attr( $style_data['loccatimgs'] ),
			'options'     => array(
				'false' => 'False',
				'true'  => 'True',
			),
			'option_name' => $style_options,
		)
	);

	/**
	 * Render custom category location images field
	 *
	 * @param array $args label, name, value, option name.
	 */
	function bh_storelocator_render_section_2_field_loccatimgs( $args ) {
		bh_storelocator_selectfield( $args, __( 'Set to true to add image upload settings to the location categories.', 'bh-storelocator' ) );
	}

	/**
	 * Custom location category marker image dimensions
	 */
	add_settings_field(
		'section_2_field_catimgdim',
		__( 'Marker dimensions', 'bh-storelocator' ),
		'bh_storelocator_render_section_2_field_catimgdim',
		'bh_storelocator_style_settings',
		'bh_storelocator_styles',
		array(
			'label_for'   => 'catimgdim',
			'name'        => 'catimgdim',
			'value-width'       => esc_attr( $style_data['catimgdimwidth'] ),
			'value-height' => esc_attr( $style_data['catimgdimheight'] ),
			'option_name' => $style_options,
		)
	);

	/**
	 * Render custom location category marker image dimensions field
	 *
	 * @param array $args label, name, value, option name.
	 */
	function bh_storelocator_render_section_2_field_catimgdim( $args ) {
		bh_storelocator_imagedimfield( $args, __( 'Optional location category marker image dimensions. Fallback is 32px x 32px.<br> For HDPI devices make the marker image at least double the size of the dimensions set in this field.', 'bh-storelocator' ), true );
	}

	/**
	 * Active marker image replacement
	 */
	add_settings_field(
		'section_2_field_switchactivemarker',
		__( 'Switch active marker icon', 'bh-storelocator' ),
		'bh_storelocator_render_section_2_field_switchactivemarker',
		'bh_storelocator_style_settings',
		'bh_storelocator_styles',
		array(
			'label_for'   => 'switchactivemarker',
			'name'        => 'switchactivemarker',
			'value'       => esc_attr( $style_data['switchactivemarker'] ),
			'options'     => array(
				'false' => 'False',
				'true'  => 'True',
			),
			'option_name' => $style_options,
		)
	);

	/**
	 * Render active marker image replacement field
	 *
	 * @param array $args label, name, value, option name.
	 */
	function bh_storelocator_render_section_2_field_switchactivemarker( $args ) {
		bh_storelocator_selectfield( $args, __( 'Replace the active marker with a custom marker image.', 'bh-storelocator' ) );
	}

	/**
	 * Active marker image path
	 */
	add_settings_field(
		'section_2_field_selectedmarkerimg',
		__( 'Active marker image', 'bh-storelocator' ),
		'bh_storelocator_render_section_2_field_selectedmarkerimg',
		'bh_storelocator_style_settings',
		'bh_storelocator_styles',
		array(
			'label_for'   => 'selectedmarkerimg',
			'name'        => 'selectedmarkerimg',
			'value'       => esc_attr( $style_data['selectedmarkerimg'] ),
			'option_name' => $style_options,
		)
	);

	/**
	 * Render active marker image field
	 *
	 * @param array $args label, name, value, option name.
	 */
	function bh_storelocator_render_section_2_field_selectedmarkerimg( $args ) {
		bh_storelocator_imagefield( $args, __( 'Replacement marker image used for active marker.', 'bh-storelocator' ), true );
	}

	/**
	 * Custom active marker image dimensions
	 */
	add_settings_field(
		'section_2_field_selectedmarkerimgdim',
		__( 'Active marker dimensions', 'bh-storelocator' ),
		'bh_storelocator_render_section_2_field_selectedmarkerimgdim',
		'bh_storelocator_style_settings',
		'bh_storelocator_styles',
		array(
			'label_for'   => 'selectedmarkerimgdim',
			'name'        => 'selectedmarkerimgdim',
			'value-width'       => esc_attr( $style_data['selectedmarkerimgdimwidth'] ),
			'value-height' => esc_attr( $style_data['selectedmarkerimgdimheight'] ),
			'option_name' => $style_options,
		)
	);

	/**
	 * Render custom active marker image dimensions field
	 *
	 * @param array $args label, name, value, option name.
	 */
	function bh_storelocator_render_section_2_field_selectedmarkerimgdim( $args ) {
		bh_storelocator_imagedimfield( $args, __( 'Optional active marker image dimensions. Fallback is 32px x 32px.<br> For HDPI devices make the marker image at least double the size of the dimensions set in this field.', 'bh-storelocator' ), true );
	}
}
