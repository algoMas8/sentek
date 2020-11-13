<?php
/**
 * Primary Settings
 *
 * @package BH_Store_Locator
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Primary settings tab
 *
 * @param array $primary_settings supported attributes and default values.
 */
function bh_storelocator_primary_plugin_settings( $primary_settings ) {

	$primary_options = 'bh_storelocator_primary_options';

	// Fetch existing options.
	$primary_values = get_option( $primary_options );

	// Parse option values into predefined keys, throw the rest away.
	$data = shortcode_atts( $primary_settings, $primary_values );

	register_setting(
		'plugin:bh_storelocator_primary_option_group',
		$primary_options,
		'bh_storelocator_validate_primary_options'
	);

	add_settings_section(
		'bh_storelocator_primary',
		__( 'Primary Settings', 'bh-storelocator' ),
		'bh_storelocator_section_primary',
		'bh_storelocator_primary_settings'
	);

	/**
	 * Explanation about primary settings section.
	 */
	function bh_storelocator_section_primary() {
		echo wp_kses( '<p>' . __( 'Primary plugin options.', 'bh-storelocator' ) . '</p>', array( 'p' => array() ) );
	}

	/**
	 * Google Maps API key field
	 */
	add_settings_field(
		'section_1_apikey',
		__( 'Google Maps API key (front-end)', 'bh-storelocator' ),
		'bh_storelocator_render_section_1_apikey',
		'bh_storelocator_primary_settings',
		'bh_storelocator_primary',
		array(
			'label_for'   => 'apikey',
			'name'        => 'apikey',
			'value'       => esc_attr( $data['apikey'] ),
			'option_name' => $primary_options,
		)
	);

	/**
	 * Render the Google Maps API key field
	 *
	 * @param array $args label, name, value, option name.
	 */
	function bh_storelocator_render_section_1_apikey( $args ) {
		bh_storelocator_textfield(
			$args,
			sprintf(
				__( 'Enter your Google Maps API key for front-end requests. See <a target="%1$s" href="%2$s" rel="%3$s">Google Maps API documentation for more details</a> <br>Make sure to also enable Google Places API Web Service, Google Maps Geocoding API and Google Maps Directions API for the project in the Google API Console.', 'bh-storelocator' ),
				'_blank',
				'https://developers.google.com/maps/documentation/javascript/get-api-key#quick-guide-to-getting-a-key',
				'noopener noreferrer'
			),
			false
		);
	}

	/**
	 * Google Maps API key field
	 */
	add_settings_field(
		'section_1_apikey_backend',
		__( 'Google Geocoding API key (back-end)', 'bh-storelocator' ),
		'bh_storelocator_render_section_1_apikey_backend',
		'bh_storelocator_primary_settings',
		'bh_storelocator_primary',
		array(
			'label_for'   => 'apikey_backend',
			'name'        => 'apikey_backend',
			'value'       => esc_attr( $data['apikey_backend'] ),
			'option_name' => $primary_options,
		)
	);

	/**
	 * Render the Geocoding API key field
	 *
	 * @param array $args label, name, value, option name.
	 */
	function bh_storelocator_render_section_1_apikey_backend( $args ) {
		bh_storelocator_textfield(
			$args,
			sprintf(
				__( 'Enter your Google Geocoding API key for back-end requests. Referrer restrictions will not work with this key. <br><sup>*</sup>This is required if you have set up HTTP referrer restrictions for the front-end Google Maps API key above (used to prevent unwanted use of your key).', 'bh-storelocator' )
			),
			true
		);
	}

	/**
	 * Length unit field
	 */
	add_settings_field(
		'section_1_field_length',
		__( 'Length unit', 'bh-storelocator' ),
		'bh_storelocator_render_section_1_field_length',
		'bh_storelocator_primary_settings',
		'bh_storelocator_primary',
		array(
			'label_for'   => 'lengthunit',
			'name'        => 'lengthunit',
			'value'       => esc_attr( $data['lengthunit'] ),
			'options'     => array(
				'm'  => __( 'Miles', 'bh-storelocator' ),
				'km' => __( 'Kilometers', 'bh-storelocator' ),
			),
			'option_name' => $primary_options,
		)
	);

	/**
	 * Render length unit field
	 *
	 * @param array $args label, name, value, option name.
	 */
	function bh_storelocator_render_section_1_field_length( $args ) {
		bh_storelocator_selectfield( $args, __( 'The unit of length.', 'bh-storelocator' ) );
	}

	/**
	 * Zoom level
	 */
	add_settings_field(
		'section_1_field_zoom',
		__( 'Zoom level', 'bh-storelocator' ),
		'bh_storelocator_render_section_1_field_zoom',
		'bh_storelocator_primary_settings',
		'bh_storelocator_primary',
		array(
			'label_for'   => 'zoom',
			'name'        => 'zoom',
			'value'       => esc_attr( $data['zoom'] ),
			'option_name' => $primary_options,
			'min'         => 0,
			'max'         => 50,
		)
	);

	/**
	 * Render zoom level field
	 *
	 * @param array $args label, name, value, option name.
	 */
	function bh_storelocator_render_section_1_field_zoom( $args ) {
		bh_storelocator_numberfield( $args, __( 'The zoom level of the Google Map. Set to 0 to have the map automatically center and zoom to show all display markers on the map.', 'bh-storelocator' ) );
	}

	/**
	 * Map type
	 */
	add_settings_field(
		'section_1_field_maptype',
		__( 'Map type', 'bh-storelocator' ),
		'bh_storelocator_render_section_1_field_maptype',
		'bh_storelocator_primary_settings',
		'bh_storelocator_primary',
		array(
			'label_for'   => 'maptype',
			'name'        => 'maptype',
			'value'       => esc_attr( $data['maptype'] ),
			'options'     => array(
				'roadmap'   => __( 'Road map', 'bh-storelocator' ),
				'satellite' => __( 'Satellite', 'bh-storelocator' ),
				'hybrid'    => __( 'Hybrid', 'bh-storelocator' ),
				'terrain'   => __( 'Terrain', 'bh-storelocator' ),
			),
			'option_name' => $primary_options,
		)
	);

	/**
	 * Render map type field
	 *
	 * @param array $args label, name, value, option name.
	 */
	function bh_storelocator_render_section_1_field_maptype( $args ) {
		bh_storelocator_selectfield(
			$args,
			sprintf( __( 'Select the type of map. See <a target="%s" href="%s" rel="%s">Google\'s map types documentation for more details</a>.', 'bh-storelocator' ), '_blank', 'https://developers.google.com/maps/documentation/javascript/maptypes', 'noopener noreferrer' ),
			false
		);
	}

	/**
	 * Store limit
	 */
	add_settings_field(
		'section_1_field_storelimit',
		__( 'Store limit', 'bh-storelocator' ),
		'bh_storelocator_render_section_1_field_storelimit',
		'bh_storelocator_primary_settings',
		'bh_storelocator_primary',
		array(
			'label_for'   => 'storelimit',
			'name'        => 'storelimit',
			'value'       => esc_attr( $data['storelimit'] ),
			'option_name' => $primary_options,
			'min'         => -1,
			'max'         => 50,
		)
	);

	/**
	 * Render store limit field
	 *
	 * @param array $args label, name, value, option name.
	 */
	function bh_storelocator_render_section_1_field_storelimit( $args ) {
		bh_storelocator_numberfield( $args, __( 'The number of closest locations displayed at one time. Set to -1 for unlimited.', 'bh-storelocator' ) );
	}

	/**
	 * Distance alert
	 */
	add_settings_field(
		'section_1_field_distancealert',
		__( 'Distance alert', 'bh-storelocator' ),
		'bh_storelocator_render_section_1_field_distancealert',
		'bh_storelocator_primary_settings',
		'bh_storelocator_primary',
		array(
			'label_for'   => 'distancealert',
			'name'        => 'distancealert',
			'value'       => esc_attr( $data['distancealert'] ),
			'option_name' => $primary_options,
			'min'         => -1,
			'max'         => 10000,
		)
	);

	/**
	 * Render distance alert field
	 *
	 * @param array $args label, name, value, option name.
	 */
	function bh_storelocator_render_section_1_field_distancealert( $args ) {
		bh_storelocator_numberfield( $args, __( 'Displays an alert if there are no locations within this distance from the user’s location. Set to -1 to disable.', 'bh-storelocator' ) );
	}

	/**
	 * Data source
	 */
	add_settings_field(
		'section_1_field_datasource',
		__( 'Data source', 'bh-storelocator' ),
		'bh_storelocator_render_section_1_field_datasource',
		'bh_storelocator_primary_settings',
		'bh_storelocator_primary',
		array(
			'label_for'   => 'datasource',
			'name'        => 'datasource',
			'value'       => esc_attr( $data['datasource'] ),
			'options'     => array(
				'locations' => __( 'Register Locations Post Type', 'bh-storelocator' ),
				'cpt'       => __( 'Other Custom Post Type', 'bh-storelocator' ),
				'localfile' => __( 'Local File', 'bh-storelocator' ),
				'remoteurl' => __( 'Remote URL', 'bh-storelocator' ),
			),
			'option_name' => $primary_options,
		)
	);

	/**
	 * Render data source field
	 *
	 * @param array $args label, name, value, option name.
	 */
	function bh_storelocator_render_section_1_field_datasource( $args ) {
		bh_storelocator_selectfield( $args, __( 'Select the source of your location data.', 'bh-storelocator' ) );
	}

	/**
	 * Post type
	 */
	$all_post_types = array( 'default' => '' );
	$post_type_args = array(
		'public'          => true,
		'capability_type' => 'post',
	);
	$post_types     = get_post_types( $post_type_args );
	unset( $post_types['attachment'] );
	foreach ( $post_types as $post_type ) {
		$all_post_types[ $post_type ] = $post_type;
	}

	add_settings_field(
		'section_1_field_posttype',
		__( 'Locations Post Type', 'bh-storelocator' ),
		'bh_storelocator_render_section_1_field_posttype',
		'bh_storelocator_primary_settings',
		'bh_storelocator_primary',
		array(
			'label_for'   => 'posttype',
			'name'        => 'posttype',
			'value'       => esc_attr( $data['posttype'] ),
			'options'     => $all_post_types,
			'option_name' => $primary_options,
		)
	);

	/**
	 * Render post type field
	 *
	 * @param array $args label, name, value, option name.
	 */
	function bh_storelocator_render_section_1_field_posttype( $args ) {
		bh_storelocator_selectfield( $args, __( 'Select a previously set up post type for your location posts.', 'bh-storelocator' ), true );
	}

	/**
	 * Data type
	 */
	add_settings_field(
		'section_1_field_datatype',
		__( 'Data type', 'bh-storelocator' ),
		'bh_storelocator_render_section_1_field_datatype',
		'bh_storelocator_primary_settings',
		'bh_storelocator_primary',
		array(
			'label_for' => 'datatype',
			'name'      => 'datatype',
			'value'     => esc_attr( $data['datatype'] ),
			'options'   => array(
				'default' => '',
				'kml'     => 'KML',
				'xml'     => 'XML',
				'json'    => 'JSON',
				'jsonp'   => 'JSONP',
			),
			'option_name' => $primary_options,
		)
	);

	/**
	 * Render data type field
	 *
	 * @param array $args label, name, value, option name.
	 */
	function bh_storelocator_render_section_1_field_datatype( $args ) {
		bh_storelocator_selectfield( $args, __( 'Select the locations file data type.', 'bh-storelocator' ), true );
	}

	/**
	 * XML element
	 */
	add_settings_field(
		'section_1_field_xmlelement',
		__( 'XML Element', 'bh-storelocator' ),
		'bh_storelocator_render_section_1_field_xmlelement',
		'bh_storelocator_primary_settings',
		'bh_storelocator_primary',
		array(
			'label_for'   => 'xmlelement',
			'name'        => 'xmlelement',
			'value'       => esc_attr( $data['xmlelement'] ),
			'option_name' => $primary_options,
		)
	);

	/**
	 * Render XML element field
	 *
	 * @param array $args label, name, value, option name.
	 */
	function bh_storelocator_render_section_1_field_xmlelement( $args ) {
		bh_storelocator_textfield( $args, __( 'XML element used for locations (tag).', 'bh-storelocator' ), true );
	}

	/**
	 * Data path
	 */
	add_settings_field(
		'section_1_field_datapath',
		__( 'Data file path', 'bh-storelocator' ),
		'bh_storelocator_render_section_1_field_datapath',
		'bh_storelocator_primary_settings',
		'bh_storelocator_primary',
		array(
			'label_for'   => 'datapath',
			'name'        => 'datapath',
			'value'       => esc_attr( $data['datapath'] ),
			'option_name' => $primary_options,
		)
	);

	/**
	 * Render data path field
	 *
	 * @param array $args label, name, value, option name.
	 */
	function bh_storelocator_render_section_1_field_datapath( $args ) {
		bh_storelocator_textfield( $args, __( 'Examples:<ul>
		<li>/wp-content/uploads/locations.kml</li>
		<li>/wp-content/themes/yourtheme/locations.xml</li>
		<li>https://example.com/locations.json</li></ul>', 'bh-storelocator' ), true );
	}

	/**
	 * Over 1000 locations
	 */
	add_settings_field(
		'section_1_field_manylocations',
		__( 'Over 1,000 locations?', 'bh-storelocator' ),
		'bh_storelocator_render_section_1_field_manylocations',
		'bh_storelocator_primary_settings',
		'bh_storelocator_primary',
		array(
			'label_for'   => 'manylocations',
			'name'        => 'manylocations',
			'value'       => esc_attr( $data['manylocations'] ),
			'options'     => array(
				'false' => 'False',
				'true'  => 'True',
			),
			'option_name' => $primary_options,
		)
	);

	/**
	 * Render over 1000 locations field
	 *
	 * @param array $args label, name, value, option name.
	 */
	function bh_storelocator_render_section_1_field_manylocations( $args ) {
		bh_storelocator_selectfield( $args, __( 'Set to true if you have over 1,000 locations. It\'s recommended to use a static file for the best performance if you have thousands of locations due to slow WordPress queries.', 'bh-storelocator' ), true );
	}

	/**
	 * Origin marker
	 */
	add_settings_field(
		'section_1_field_originmarker',
		__( 'Origin marker', 'bh-storelocator' ),
		'bh_storelocator_render_section_1_field_originmarker',
		'bh_storelocator_primary_settings',
		'bh_storelocator_primary',
		array(
			'label_for'   => 'originmarker',
			'name'        => 'originmarker',
			'value'       => esc_attr( $data['originmarker'] ),
			'options'     => array(
				'false' => 'False',
				'true'  => 'True',
			),
			'option_name' => $primary_options,
		)
	);

	/**
	 * Render origin marker field
	 *
	 * @param array $args label, name, value, option name.
	 */
	function bh_storelocator_render_section_1_field_originmarker( $args ) {
		bh_storelocator_selectfield( $args, __( 'Set to true to display a marker at the origin.', 'bh-storelocator' ) );
	}

	/**
	 * Origin marker override
	 */
	add_settings_field(
		'section_2_field_originmarkerimg',
		__( 'Origin marker override upload', 'bh-storelocatorimg' ),
		'bh_storelocator_render_section_1_field_originmarkerimg',
		'bh_storelocator_primary_settings',
		'bh_storelocator_primary',
		array(
			'label_for'   => 'originmarkerimg',
			'name'        => 'originmarkerimg',
			'value'       => esc_attr( $data['originmarkerimg'] ),
			'option_name' => $primary_options,
		)
	);

	/**
	 * Render origin marker override field
	 *
	 * @param array $args label, name, value, option name.
	 */
	function bh_storelocator_render_section_1_field_originmarkerimg( $args ) {
		bh_storelocator_imagefield( $args, __( 'Origin marker image.', 'bh-storelocator' ), true );
	}

	/**
	 * Origin marker dimensions
	 */
	add_settings_field(
		'section_2_field_originmarkerimgdim',
		__( 'Origin marker dimensions', 'bh-storelocatorimgdim' ),
		'bh_storelocator_render_section_1_field_originmarkerimgdim',
		'bh_storelocator_primary_settings',
		'bh_storelocator_primary',
		array(
			'label_for'   => 'originmarkerimgdim',
			'name'        => 'originmarkerimgdim',
			'value-width'       => esc_attr( $data['originmarkerimgdimwidth'] ),
			'value-height' => esc_attr( $data['originmarkerimgdimheight'] ),
			'option_name' => $primary_options,
		)
	);

	/**
	 * Render origin marker dimensions field
	 *
	 * @param array $args label, name, value, option name.
	 */
	function bh_storelocator_render_section_1_field_originmarkerimgdim( $args ) {
		bh_storelocator_imagedimfield( $args, __( 'Optional origin marker image dimensions. Fallback is 32px x 32px.<br> For HDPI devices make the marker image at least double the size of the dimensions set in this field.', 'bh-storelocator' ), true );
	}

	/**
	 * Bounce marker
	 */
	add_settings_field(
		'section_1_field_bouncemarker',
		__( 'Bounce marker', 'bh-storelocator' ),
		'bh_storelocator_render_section_1_field_bouncemarker',
		'bh_storelocator_primary_settings',
		'bh_storelocator_primary',
		array(
			'label_for'   => 'bouncemarker',
			'name'        => 'bouncemarker',
			'value'       => esc_attr( $data['bouncemarker'] ),
			'options'     => array(
				'true'  => 'True',
				'false' => 'False',
			),
			'option_name' => $primary_options,
		)
	);

	/**
	 * Render bounce marker field
	 *
	 * @param array $args label, name, value, option name.
	 */
	function bh_storelocator_render_section_1_field_bouncemarker( $args ) {
		bh_storelocator_selectfield( $args, __( 'Bounces the maker when a list element is clicked.', 'bh-storelocator' ) );
	}

	/**
	 * Open nearest
	 */
	add_settings_field(
		'section_1_field_opennearest',
		__( 'Open nearest location', 'bh-storelocator' ),
		'bh_storelocator_render_section_1_field_opennearest',
		'bh_storelocator_primary_settings',
		'bh_storelocator_primary',
		array(
			'label_for'   => 'opennearest',
			'name'        => 'opennearest',
			'value'       => esc_attr( $data['opennearest'] ),
			'options'     => array(
				'false' => 'False',
				'true'  => 'True',
			),
			'option_name' => $primary_options,
		)
	);

	/**
	 * Render open nearest field
	 *
	 * @param array $args label, name, value, option name.
	 */
	function bh_storelocator_render_section_1_field_opennearest( $args ) {
		bh_storelocator_selectfield( $args, __( 'Set to true to highlight the nearest location automatically after searching.', 'bh-storelocator' ) );
	}

	/**
	 * Slide map
	 */
	add_settings_field(
		'section_1_field_slidemap',
		__( 'Slide map', 'bh-storelocator' ),
		'bh_storelocator_render_section_1_field_slidemap',
		'bh_storelocator_primary_settings',
		'bh_storelocator_primary',
		array(
			'label_for'   => 'slidemap',
			'name'        => 'slidemap',
			'value'       => esc_attr( $data['slidemap'] ),
			'options'     => array(
				'true'  => 'True',
				'false' => 'False',
			),
			'option_name' => $primary_options,
		)
	);

	/**
	 * Render slide map field
	 *
	 * @param array $args label, name, value, option name.
	 */
	function bh_storelocator_render_section_1_field_slidemap( $args ) {
		bh_storelocator_selectfield( $args, __( 'First hides the map container and then uses jQuery\'s slideDown method to reveal the map.', 'bh-storelocator' ) );
	}

	/**
	 * Modal window
	 */
	add_settings_field(
		'section_1_field_modalwindow',
		__( 'Modal window', 'bh-storelocator' ),
		'bh_storelocator_render_section_1_field_modalwindow',
		'bh_storelocator_primary_settings',
		'bh_storelocator_primary',
		array(
			'label_for'   => 'modalwindow',
			'name'        => 'modalwindow',
			'value'       => esc_attr( $data['modalwindow'] ),
			'options'     => array(
				'false' => 'False',
				'true'  => 'True',
			),
			'option_name' => $primary_options,
		)
	);

	/**
	 * Render modal window field
	 *
	 * @param array $args label, name, value, option name.
	 */
	function bh_storelocator_render_section_1_field_modalwindow( $args ) {
		bh_storelocator_selectfield( $args, __( 'Shows the map container within a modal window. Set slideMap to false and this option to true to use. Note that you may need to adjust the height of the modal window with CSS depending on other options used.', 'bh-storelocator' ) );
	}

	/**
	 * Default location
	 */
	add_settings_field(
		'section_1_field_defaultloc',
		__( 'Default location', 'bh-storelocator' ),
		'bh_storelocator_render_section_1_field_defaultloc',
		'bh_storelocator_primary_settings',
		'bh_storelocator_primary',
		array(
			'label_for'   => 'defaultloc',
			'name'        => 'defaultloc',
			'value'       => esc_attr( $data['defaultloc'] ),
			'options'     => array(
				'false' => 'False',
				'true'  => 'True',
			),
			'option_name' => $primary_options,
		)
	);

	/**
	 * Render default location field
	 *
	 * @param array $args label, name, value, option name.
	 */
	function bh_storelocator_render_section_1_field_defaultloc( $args ) {
		bh_storelocator_selectfield( $args, __( 'If true, the map will load with a default location immediately. Set slideMap to false if you want to use this.', 'bh-storelocator' ) );
	}

	/**
	 * Default latitude
	 */
	add_settings_field(
		'section_1_field_defaultlat',
		__( 'Default latitude', 'bh-storelocator' ),
		'bh_storelocator_render_section_1_field_defaultlat',
		'bh_storelocator_primary_settings',
		'bh_storelocator_primary',
		array(
			'label_for'   => 'defaultlat',
			'name'        => 'defaultlat',
			'value'       => esc_attr( $data['defaultlat'] ),
			'option_name' => $primary_options,
		)
	);

	/**
	 * Render default latitude field
	 *
	 * @param array $args label, name, value, option name.
	 */
	function bh_storelocator_render_section_1_field_defaultlat( $args ) {
		bh_storelocator_textfield( $args, __( 'If using a default location, set this to the default location latitude.', 'bh-storelocator' ), true );
	}

	/**
	 * Default longitude
	 */
	add_settings_field(
		'section_1_field_defaultlng',
		__( 'Default longitude', 'bh-storelocator' ),
		'bh_storelocator_render_section_1_field_defaultlng',
		'bh_storelocator_primary_settings',
		'bh_storelocator_primary',
		array(
			'label_for'   => 'defaultlng',
			'name'        => 'defaultlng',
			'value'       => esc_attr( $data['defaultlng'] ),
			'option_name' => $primary_options,
		)
	);

	/**
	 * Render default longitude field
	 *
	 * @param array $args label, name, value, option name.
	 */
	function bh_storelocator_render_section_1_field_defaultlng( $args ) {
		bh_storelocator_textfield( $args, __( 'If using a default location, set this to the default location longitude.', 'bh-storelocator' ), true );
	}

	/**
	 * Auto geocode
	 */
	add_settings_field(
		'section_1_field_autogeocode',
		__( 'Auto geocode', 'bh-storelocator' ),
		'bh_storelocator_render_section_1_field_autogeocode',
		'bh_storelocator_primary_settings',
		'bh_storelocator_primary',
		array(
			'label_for'   => 'autogeocode',
			'name'        => 'autogeocode',
			'value'       => esc_attr( $data['autogeocode'] ),
			'options'     => array(
				'false' => 'False',
				'true'  => 'True',
			),
			'option_name' => $primary_options,
		)
	);

	/**
	 * Render auto geocode field
	 *
	 * @param array $args label, name, value, option name.
	 */
	function bh_storelocator_render_section_1_field_autogeocode( $args ) {
		bh_storelocator_selectfield( $args, __( 'If true, the script will attempt to use the HTML5 geolocation API to find the user\'s location.', 'bh-storelocator' ) );
	}

	/**
	 * Featured locations
	 */
	add_settings_field(
		'section_1_field_featuredlocations',
		__( 'Featured locations', 'bh-storelocator' ),
		'bh_storelocator_render_section_1_field_featuredlocations',
		'bh_storelocator_primary_settings',
		'bh_storelocator_primary',
		array(
			'label_for'   => 'featuredlocations',
			'name'        => 'featuredlocations',
			'value'       => esc_attr( $data['featuredlocations'] ),
			'options'     => array(
				'false' => 'False',
				'true'  => 'True',
			),
			'option_name' => $primary_options,
		)
	);

	/**
	 * Render featured location field
	 *
	 * @param array $args label, name, value, option name.
	 */
	function bh_storelocator_render_section_1_field_featuredlocations( $args ) {
		bh_storelocator_selectfield( $args, __( 'If true, featured locations will be displayed at the top of the location list (no matter the distance).', 'bh-storelocator' ) );
	}

	/**
	 * Full map start
	 */
	add_settings_field(
		'section_1_field_fullmapstart',
		__( 'Full map start', 'bh-storelocator' ),
		'bh_storelocator_render_section_1_field_fullmapstart',
		'bh_storelocator_primary_settings',
		'bh_storelocator_primary',
		array(
			'label_for'   => 'fullmapstart',
			'name'        => 'fullmapstart',
			'value'       => esc_attr( $data['fullmapstart'] ),
			'options'     => array(
				'false' => 'False',
				'true'  => 'True',
			),
			'option_name' => $primary_options,
		)
	);

	/**
	 * Render full map start field
	 *
	 * @param array $args label, name, value, option name.
	 */
	function bh_storelocator_render_section_1_field_fullmapstart( $args ) {
		bh_storelocator_selectfield( $args, __( 'Set to true if you want to immediately show a map of all locations. The map will center and zoom automatically.', 'bh-storelocator' ) );
	}

	/**
	 * Full map start blank
	 */
	add_settings_field(
		'section_1_field_fullmapstartblank',
		__( 'Full map start blank', 'bh-storelocator' ),
		'bh_storelocator_render_section_1_field_fullmapstartblank',
		'bh_storelocator_primary_settings',
		'bh_storelocator_primary',
		array(
			'label_for'   => 'fullmapstartblank',
			'name'        => 'fullmapstartblank',
			'value'       => esc_attr( $data['fullmapstartblank'] ),
			'options'     => array(
				'false' => 'False',
				'true'  => 'True',
			),
			'option_name' => $primary_options,
		)
	);

	/**
	 * Render full map start blank field
	 *
	 * @param array $args label, name, value, option name.
	 */
	function bh_storelocator_render_section_1_field_fullmapstartblank( $args ) {
		bh_storelocator_selectfield( $args, __( 'Set to true if you want to immediately show a map with no locations. This also requires the Default location to be set to true with a default latitude and longitude.', 'bh-storelocator' ) );
	}

	/**
	 * Full map start blank Zoom level
	 */
	add_settings_field(
		'section_1_field_fullzoom',
		__( 'Initial zoom level', 'bh-storelocator' ),
		'bh_storelocator_render_section_1_field_fullzoom',
		'bh_storelocator_primary_settings',
		'bh_storelocator_primary',
		array(
			'label_for'   => 'fullzoom',
			'name'        => 'fullzoom',
			'value'       => esc_attr( $data['fullzoom'] ),
			'option_name' => $primary_options,
			'min'         => 0,
			'max'         => 50,
		)
	);

	/**
	 * Render full map start blank zoom level field
	 *
	 * @param array $args label, name, value, option name.
	 */
	function bh_storelocator_render_section_1_field_fullzoom( $args ) {
		bh_storelocator_numberfield( $args, __( 'The initial zoom level of the map. After searching the zoom level with revert back to the primary Zoom level setting.', 'bh-storelocator' ), true );
	}

	/**
	 * Full map start list limit
	 */
	add_settings_field(
		'section_1_field_fullmapstartlistlimit',
		__( 'Full map start list limit', 'bh-storelocator' ),
		'bh_storelocator_render_section_1_field_fullmapstartlistlimit',
		'bh_storelocator_primary_settings',
		'bh_storelocator_primary',
		array(
			'label_for'   => 'fullmapstartlistlimit',
			'name'        => 'fullmapstartlistlimit',
			'value'       => esc_attr( $data['fullmapstartlistlimit'] ),
			'option_name' => $primary_options,
			'min'         => -1,
			'max'         => 1000,
		)
	);

	/**
	 * Render full map start list limit field
	 *
	 * @param array $args label, name, value, option name.
	 */
	function bh_storelocator_render_section_1_field_fullmapstartlistlimit( $args ) {
		bh_storelocator_numberfield( $args, __( 'The number locations to display in the location list when using one of the full map start options. Set to -1 for unlimited.', 'bh-storelocator' ) );
	}

	/**
	 * Pagination
	 */
	add_settings_field(
		'section_1_field_pagination',
		__( 'Pagination', 'bh-storelocator' ),
		'bh_storelocator_render_section_1_field_pagination',
		'bh_storelocator_primary_settings',
		'bh_storelocator_primary',
		array(
				'label_for'   => 'pagination',
				'name'        => 'pagination',
				'value'       => esc_attr( $data['pagination'] ),
				'options'     => array(
						'false' => 'False',
						'true'  => 'True',
				),
				'option_name' => $primary_options,
		)
	);

	/**
	 * Render pagination field
	 *
	 * @param array $args label, name, value, option name.
	 */
	function bh_storelocator_render_section_1_field_pagination( $args ) {
		bh_storelocator_selectfield( $args, __( 'Set to true to enable displaying location results in multiple "pages."', 'bh-storelocator' ) );
	}

	/**
	 * Locations per page
	 */
	add_settings_field(
		'section_1_field_locationsperpage',
		__( 'Locations Per Page', 'bh-storelocator' ),
		'bh_storelocator_render_section_1_field_locationsperpage',
		'bh_storelocator_primary_settings',
		'bh_storelocator_primary',
		array(
			'label_for'   => 'locationsperpage',
			'name'        => 'locationsperpage',
			'value'       => esc_attr( $data['locationsperpage'] ),
			'option_name' => $primary_options,
			'min'         => 1,
			'max'         => 1000,
		)
	);

	/**
	 * Render locations per page field
	 *
	 * @param array $args label, name, value, option name.
	 */
	function bh_storelocator_render_section_1_field_locationsperpage( $args ) {
		bh_storelocator_numberfield( $args, __( 'If using pagination, the number of locations to display per page.', 'bh-storelocator' ), true );
	}

	/**
	 * Inline directions
	 */
	add_settings_field(
		'section_1_field_inlinedirections',
		__( 'Inline directions', 'bh-storelocator' ),
		'bh_storelocator_render_section_1_field_inlinedirections',
		'bh_storelocator_primary_settings',
		'bh_storelocator_primary',
		array(
				'label_for'   => 'inlinedirections',
				'name'        => 'inlinedirections',
				'value'       => esc_attr( $data['inlinedirections'] ),
				'options'     => array(
						'false' => 'False',
						'true'  => 'True',
				),
				'option_name' => $primary_options,
		)
	);

	/**
	 * Render inline directions field
	 *
	 * @param array $args label, name, value, option name.
	 */
	function bh_storelocator_render_section_1_field_inlinedirections( $args ) {
		bh_storelocator_selectfield( $args, __( 'Set to true to enable displaying directions within the app instead of an off-site link.', 'bh-storelocator' ) );
	}

	/**
	 * Visible markers list
	 */
	add_settings_field(
		'section_1_field_visiblemarkerslist',
		__( 'Visible markers list', 'bh-storelocator' ),
		'bh_storelocator_render_section_1_field_visiblemarkerslist',
		'bh_storelocator_primary_settings',
		'bh_storelocator_primary',
		array(
				'label_for'   => 'visiblemarkerslist',
				'name'        => 'visiblemarkerslist',
				'value'       => esc_attr( $data['visiblemarkerslist'] ),
				'options'     => array(
						'false' => 'False',
						'true'  => 'True',
				),
				'option_name' => $primary_options,
		)
	);

	/**
	 * Render visible markers list field
	 *
	 * @param array $args label, name, value, option name.
	 */
	function bh_storelocator_render_section_1_field_visiblemarkerslist( $args ) {
		bh_storelocator_selectfield( $args, __( 'Set to true to have the location list only show data from markers that are visible on the map.', 'bh-storelocator' ) );
	}

	/**
	 * Drag Search
	 */
	add_settings_field(
		'section_1_field_dragsearch',
		__( 'Search on map drag', 'bh-storelocator' ),
		'bh_storelocator_render_section_1_field_dragsearch',
		'bh_storelocator_primary_settings',
		'bh_storelocator_primary',
		array(
			'label_for'   => 'dragsearch',
			'name'        => 'dragsearch',
			'value'       => esc_attr( $data['dragsearch'] ),
			'options'     => array(
				'false' => 'False',
				'true'  => 'True',
			),
			'option_name' => $primary_options,
		)
	);

	/**
	 * Render drag search field
	 *
	 * @param array $args label, name, value, option name.
	 */
	function bh_storelocator_render_section_1_field_dragsearch( $args ) {
		bh_storelocator_selectfield( $args, __( 'Set to true to perform a new search after the map is dragged.', 'bh-storelocator' ) );
	}

	/**
	 * Query string parameters
	 */
	add_settings_field(
		'section_1_field_querystrings',
		__( 'Query string parameters', 'bh-storelocator' ),
		'bh_storelocator_render_section_1_field_querystrings',
		'bh_storelocator_primary_settings',
		'bh_storelocator_primary',
		array(
			'label_for'   => 'querystrings',
			'name'        => 'querystrings',
			'value'       => esc_attr( $data['querystrings'] ),
			'options'     => array(
				'false' => 'False',
				'true'  => 'True',
			),
			'option_name' => $primary_options,
		)
	);

	/**
	 * Render query string parameters field
	 *
	 * @param array $args label, name, value, option name.
	 */
	function bh_storelocator_render_section_1_field_querystrings( $args ) {
		bh_storelocator_selectfield( $args, __( 'Set to true to enable query string support for passing input variables from page to page.', 'bh-storelocator' ) );
	}

	/**
	 * Autocomplete
	 */
	add_settings_field(
		'section_1_field_autocomplete',
		__( 'Google Places autocomplete', 'bh-storelocator' ),
		'bh_storelocator_render_section_1_field_autocomplete',
		'bh_storelocator_primary_settings',
		'bh_storelocator_primary',
		array(
			'label_for'   => 'autocomplete',
			'name'        => 'autocomplete',
			'value'       => esc_attr( $data['autocomplete'] ),
			'options'     => array(
				'false' => 'False',
				'true'  => 'True',
			),
			'option_name' => $primary_options,
		)
	);

	/**
	 * Render autocomplete field
	 *
	 * @param array $args label, name, value, option name.
	 */
	function bh_storelocator_render_section_1_field_autocomplete( $args ) {
		bh_storelocator_selectfield( $args, __( 'Set to true to enable Google Places autocomplete for the search field.', 'bh-storelocator' ) );
	}

	/**
	 * Disable Autocomplete listener
	 */
	add_settings_field(
		'section_1_field_autocomplete_listener',
		__( 'Disable autocomplete listener', 'bh-storelocator' ),
		'bh_storelocator_render_section_1_field_autocomplete_listener',
		'bh_storelocator_primary_settings',
		'bh_storelocator_primary',
		array(
			'label_for'   => 'autocomplete_listener',
			'name'        => 'autocomplete_listener',
			'value'       => esc_attr( $data['autocomplete_listener'] ),
			'options'     => array(
				'false' => 'False',
				'true'  => 'True',
			),
			'option_name' => $primary_options,
		)
	);

	/**
	 * Render disable autocomplete listener field
	 *
	 * @param array $args label, name, value, option name.
	 */
	function bh_storelocator_render_section_1_field_autocomplete_listener( $args ) {
		bh_storelocator_selectfield( $args, __( 'Disable the listener that immediately triggers a search when an auto complete location option is enabled.', 'bh-storelocator' ), true );
	}

	/**
	 * Disable alpha markers
	 */
	add_settings_field(
		'section_1_field_disablealphamarkers',
		__( 'Disable alpha markers', 'bh-storelocator' ),
		'bh_storelocator_render_section_1_field_disablealphamarkers',
		'bh_storelocator_primary_settings',
		'bh_storelocator_primary',
		array(
			'label_for'   => 'disablealphamarkers',
			'name'        => 'disablealphamarkers',
			'value'       => esc_attr( $data['disablealphamarkers'] ),
			'options'     => array(
				'false' => 'False',
				'true'  => 'True',
			),
			'option_name' => $primary_options,
		)
	);

	/**
	 * Render disablealphamarkers field
	 *
	 * @param array $args label, name, value, option name.
	 */
	function bh_storelocator_render_section_1_field_disablealphamarkers( $args ) {
		bh_storelocator_selectfield( $args, __( 'Disable displaying markers and location list indicators with alpha characters.', 'bh-storelocator' ) );
	}

	/**
	 * Alternative no distance results.
	 */
	add_settings_field(
		'section_1_field_noresultsalt',
		__( 'No results alternative', 'bh-storelocator' ),
		'bh_storelocator_render_section_1_field_noresultsalt',
		'bh_storelocator_primary_settings',
		'bh_storelocator_primary',
		array(
			'label_for'   => 'noresultsalt',
			'name'        => 'noresultsalt',
			'value'       => esc_attr( $data['noresultsalt'] ),
			'options'     => array(
				'false' => 'False',
				'true'  => 'True',
			),
			'option_name' => $primary_options,
		)
	);

	/**
	 * Render noresultsalt field
	 *
	 * @param array $args label, name, value, option name.
	 */
	function bh_storelocator_render_section_1_field_noresultsalt( $args ) {
		bh_storelocator_selectfield( $args, __( 'Display no results message instead of all locations when the closest location is further than the "Distance alert" setting.', 'bh-storelocator' ) );
	}
}
