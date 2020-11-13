<?php
/**
 * BH_Store_Locator
 *
 * @package   BH_Store_Locator
 * @author    Bjorn Holine <bjorn@cardinalwp.com>
 * @license   GPL-3.0+
 * @link      https://cardinalwp.com/
 * @copyright 2018 Bjorn Holine
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class BH_Store_Locator_Defaults
 */
class BH_Store_Locator_Defaults {
	/**
	 * Declare license defaults
	 *
	 * @var array
	 */
	public static $license_defaults = array();

	/**
	 * Declare primary defaults
	 *
	 * @var array
	 */
	public static $primary_defaults = array();

	/**
	 * Declare address defaults
	 *
	 * @var array
	 */
	public static $address_meta_defaults = array();

	/**
	 * Declare filter defaults
	 *
	 * @var array
	 */
	public static $filter_defaults = array();

	/**
	 * Declare style defaults
	 *
	 * @var array
	 */
	public static $style_defaults = array();

	/**
	 * Declare structure defaults
	 *
	 * @var array
	 */
	public static $structure_defaults = array();

	/**
	 * Declare language defaults
	 *
	 * @var array
	 */
	public static $language_defaults = array();

	/**
	 * Declare wp info defaults
	 *
	 * @var array
	 */
	public static $wp_info = array();


	/**
	 * Set the default values
	 *
	 * @param array $license License defaults.
	 * @param array $primary Primary defaults.
	 * @param array $address Address defaults.
	 * @param array $filter Filter defaults.
	 * @param array $style Style defaults.
	 * @param array $structure Structure defaults.
	 * @param array $language Language defaults.
	 * @param array $wp WP info defaults.
	 */
	public static function set_defaults( $license, $primary, $address, $filter, $style, $structure, $language, $wp ) {
		self::$license_defaults      = $license;
		self::$primary_defaults      = $primary;
		self::$address_meta_defaults = $address;
		self::$filter_defaults       = $filter;
		self::$style_defaults        = $style;
		self::$structure_defaults    = $structure;
		self::$language_defaults     = $language;
		self::$wp_info               = $wp;
	}

	/**
	 * Returns the license default settings.
	 *
	 * @return array
	 */
	public static function get_license_defaults() {
		return self::$license_defaults;
	}

	/**
	 * Returns the primary default settings.
	 *
	 * @return array
	 */
	public static function get_primary_defaults() {
		return self::$primary_defaults;
	}

	/**
	 * Returns the address default settings.
	 *
	 * @return array
	 */
	public static function get_address_defaults() {
		return self::$address_meta_defaults;
	}

	/**
	 * Returns the filter default settings.
	 *
	 * @return array
	 */
	public static function get_filter_defaults() {
		return self::$filter_defaults;
	}

	/**
	 * Returns the style default settings.
	 *
	 * @return array
	 */
	public static function get_style_defaults() {
		return self::$style_defaults;
	}

	/**
	 * Returns the structure default settings.
	 *
	 * @return array
	 */
	public static function get_structure_defaults() {
		return self::$structure_defaults;
	}

	/**
	 * Returns the language default settings.
	 *
	 * @return array
	 */
	public static function get_language_defaults() {
		return self::$language_defaults;
	}

	/**
	 * Returns the WP info default settings.
	 *
	 * @return array
	 */
	public static function get_wp_info_defaults() {
		return self::$wp_info;
	}
}


/**
 * Default settings for all the setting fields and some helper variables
 *
 * @package bh-storelocator
 */

/**
 * License setting defaults.
 *
 * @var array
 */

$license_vals = array(
	'license_key' => '',
);

/**
 * Primary setting defaults.
 *
 * @var array
 */
$primary_vals = array(
	'lengthunit'               => 'm',
	'zoom'                     => '12',
	'maptype'                  => 'roadmap',
	'storelimit'               => '26',
	'distancealert'            => '60',
	'datasource'               => 'locations',
	'posttype'                 => '',
	'datatype'                 => '',
	'xmlelement'               => 'marker',
	'datapath'                 => '',
	'manylocations'            => false,
	'originmarker'             => null,
	'originmarkerimg'          => '',
	'originmarkerimgdimwidth'  => '32',
	'originmarkerimgdimheight' => '32',
	'bouncemarker'             => true,
	'opennearest'              => false,
	'slidemap'                 => true,
	'modalwindow'              => false,
	'defaultloc'               => false,
	'defaultlat'               => null,
	'defaultlng'               => null,
	'autogeocode'              => false,
	'featuredlocations'        => false,
	'fullmapstart'             => false,
	'fullmapstartblank'        => false,
	'fullzoom'                 => '12',
	'fullmapstartlistlimit'    => '0',
	'pagination'               => false,
	'locationsperpage'         => '10',
	'inlinedirections'         => false,
	'visiblemarkerslist'       => false,
	'dragsearch'               => false,
	'querystrings'             => false,
	'autocomplete'             => false,
	'autocomplete_listener'    => false,
	'apikey'                   => '',
	'apikey_backend'           => '',
	'disablealphamarkers'      => false,
	'noresultsalt'             => false,
);

$address_vals = array(
	'address'           => '',
	'address_secondary' => '',
	'city'              => '',
	'state'             => '',
	'postal'            => '',
	'country'           => '',
	'email'             => '',
	'phone'             => '',
	'fax'               => '',
	'website'           => '',
	'hours_one'         => '',
	'hours_two'         => '',
	'hours_three'       => '',
	'hours_four'        => '',
	'hours_five'        => '',
	'hours_six'         => '',
	'hours_seven'       => '',
	'latitude'          => '',
	'longitude'         => '',
);

$filter_vals = array(
	'exclusivefiltering' => false,
	'taxfilterssetup'    => null,
	'bhslfilters'        => array(),
);

$style_vals = array(
	'listbgcolor'                => '#fff',
	'listbgcolor2'               => '#eee',
	'mapstyles'                  => false,
	'mapstylesfile'              => '',
	'replacemarker'              => null,
	'markerimage'                => null,
	'markerimgdimwidth'          => '',
	'markerimgdimheight'         => '',
	'loccatimgs'                 => false,
	'catimgdimwidth'             => '',
	'catimgdimheight'            => '',
	'switchactivemarker'         => false,
	'selectedmarkerimg'          => null,
	'selectedmarkerimgdimwidth'  => '',
	'selectedmarkerimgdimheight' => '',
);

$structure_vals = array(
	'mapid'                    => 'bh-sl-map',
	'listdiv'                  => 'bh-sl-loc-list',
	'formcontainerdiv'         => 'bh-sl-form-container',
	'formid'                   => 'bh-sl-user-location',
	'noform'                   => false,
	'inputid'                  => 'bh-sl-address',
	'region'                   => false,
	'regionid'                 => 'bh-sl-region',
	'regionvals'               => null,
	'overlaydiv'               => 'bh-sl-overlay',
	'modalwindowdiv'           => 'bh-sl-modal-window',
	'modalcontentdiv'          => 'bh-sl-modal-content',
	'modalcloseicondiv'        => 'bh-sl-close-icon',
	'maxdistance'              => false,
	'maxdistanceid'            => 'bh-sl-maxdistance',
	'maxdistvals'              => null,
	'loading'                  => false,
	'loadingdiv'               => 'bh-sl-loading',
	'lengthswap'               => false,
	'lengthswapid'             => 'bh-sl-length-swap',
	'customsorting'            => false,
	'customsortingid'          => 'bh-sl-sort',
	'customsortingmethod'      => 'alpha',
	'customorderid'            => 'bh-sl-order',
	'customsortingorder'       => 'asc',
	'customsortingprop'        => 'name',
	'namesearch'               => false,
	'namesearchid'             => 'bh-sl-search',
	'nameattribute'            => 'name',
	'geocodebtn'               => false,
	'geocodebtnid'             => 'bh-sl-geocode',
	'geocodebtnlabel'          => 'Find Me',
	'taxonomyfilterscontainer' => 'bh-sl-filters-container',
	'listid'                   => null,
	'infowindowid'             => null,
);

$language_defaults = array(
	'addressinputlabel' => __( 'Enter Address or Zip Code:', 'bh-storelocator' ),
	'namesearchlabel'   => __( 'Location name search:', 'bh-storelocator' ),
	'maxdistancelabel'  => __( 'Within:', 'bh-storelocator' ),
	'regionlabel'       => __( 'Region:', 'bh-storelocator' ),
	'lengthunitlabel'   => __( 'Length unit:', 'bh-storelocator' ),
	'sortbylabel'       => __( 'Sort by:', 'bh-storelocator' ),
	'orderlabel'        => __( 'Order:', 'bh-storelocator' ),
	'submitbtnlabel'    => __( 'Submit', 'bh-storelocator' ),
	'geocodeerror'      => __( 'Geocode was not successful for the following reason:', 'bh-storelocator' ),
	'addresserror'      => __( 'Unable to find address', 'bh-storelocator' ),
	'autogeocodeerror'  => __( 'Automatic location detection failed. Please fill in your address or zip code.', 'bh-storelocator' ),
	'distanceerror'     => __( 'Unfortunately, our closest location is more than', 'bh-storelocator' ),
	'milelang'          => __( 'mile', 'bh-storelocator' ),
	'mileslang'         => __( 'miles', 'bh-storelocator' ),
	'kilometerlang'     => __( 'kilometer', 'bh-storelocator' ),
	'kilometerslang'    => __( 'kilometers', 'bh-storelocator' ),
	'noresultstitle'    => __( 'No results', 'bh-storelocator' ),
	'noresultsdesc'     => __( 'No locations were found with the given criteria. Please modify your selections or input.', 'bh-storelocator' ),
	'nextpage'          => __( 'Next &raquo;', 'bh-storelocator' ),
	'prevpage'          => __( '&laquo; Prev', 'bh-storelocator' ),
);

$wp_info_vals = array(
	'template_path' => get_stylesheet_directory(),
	'template_uri'  => get_stylesheet_directory_uri(),
	'plugin_path'   => plugin_dir_url( dirname( __FILE__ ) ),
	'plugin_url'    => plugins_url(),
	'admin_ajax'    => admin_url( 'admin-ajax.php' ),
);

BH_Store_Locator_Defaults::set_defaults( $license_vals, $primary_vals, $address_vals, $filter_vals, $style_vals, $structure_vals, $language_defaults, $wp_info_vals );
