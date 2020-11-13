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

use function Cardinal_Locator\Helpers\check_plugin_active;
use function Cardinal_Locator\Helpers\check_plugin_network_active;

// Includes.
require_once 'includes/class-bh-store-locator-post-meta.php';
require_once 'includes/class-bh-store-locator-shortcode.php';
require_once 'includes/class-bh-store-locator-widget.php';
require_once 'includes/class-bh-store-locator-cache-remote-data.php';

/**
 * BH_Store_Locator class. This class should ideally be used to work with the
 * public-facing side of the WordPress site.
 *
 * If you're interested in introducing administrative or dashboard
 * functionality, then refer to `class-bh-store-locator-admin.php`
 *
 * @package BH_Store_Locator
 * @author  Bjorn Holine <bjorn@cardinalwp.com>
 */
class BH_Store_Locator {

	/**
	 * Plugin version, used for cache-busting of style and script file references.
	 *
	 * @var string
	 */
	const VERSION = '1.4.6';

	/**
	 * Optional custom post type name that may be registered depending on setting selection.
	 *
	 * @var string
	 */
	const BH_SL_CPT = 'bh_sl_locations';

	/**
	 * Custom locations taxonomy name that gets registered along with the optional custom post type
	 */
	const BH_SL_TAX = 'bh_sl_loc_cat';

	/**
	 * Unique identifier for your plugin.
	 *
	 * The variable name is used as the text domain when internationalizing strings
	 * of text. Its value should match the Text Domain file header in the main
	 * plugin file.
	 *
	 * @var string
	 */
	protected $plugin_slug = 'bh-storelocator';

	/**
	 * Instance of this class.
	 *
	 * @var object
	 */
	protected static $instance = null;

	/**
	 * Primary defaults.
	 *
	 * @var array|null
	 */
	public $primary_defaults = null;

	/**
	 * Address defaults.
	 *
	 * @var array|null
	 */
	public $address_meta_defaults = null;

	/**
	 * Filter defaults.
	 *
	 * @var array|null
	 */
	public $filter_defaults = null;

	/**
	 * Stuyle defaults.
	 *
	 * @var array|null
	 */
	public $style_defaults = null;

	/**
	 * Structure defaults.
	 *
	 * @var array|null
	 */
	public $structure_defaults = null;

	/**
	 * Language defaults.
	 *
	 * @var array|null
	 */
	public $language_defaults = null;

	/**
	 * WP Info passed to the JS.
	 *
	 * @var array|null
	 */
	public $wp_info = null;

	/**
	 * Primary option values.
	 *
	 * @var mixed|null|void
	 */
	public $primary_option_vals = null;

	/**
	 * Address option values.
	 *
	 * @var mixed|null|void
	 */
	public $address_option_vals = null;

	/**
	 * Filter option values.
	 *
	 * @var mixed|null|void
	 */
	public $filter_option_vals = null;

	/**
	 * Style options values.
	 *
	 * @var mixed|null|void
	 */
	public $style_option_vals = null;

	/**
	 * Structure option values.
	 *
	 * @var mixed|null|void
	 */
	public $structure_option_vals = null;

	/**
	 * Language option values.
	 *
	 * @var mixed|null|void
	 */
	public $language_option_vals = null;

	/**
	 * Initialize the plugin by setting localization and loading public scripts
	 * and styles.
	 */
	private function __construct() {

		// Set up settings defaults.
		$this->primary_defaults      = BH_Store_Locator_Defaults::get_primary_defaults();
		$this->address_meta_defaults = BH_Store_Locator_Defaults::get_address_defaults();
		$this->filter_defaults       = BH_Store_Locator_Defaults::get_filter_defaults();
		$this->style_defaults        = BH_Store_Locator_Defaults::get_style_defaults();
		$this->structure_defaults    = BH_Store_Locator_Defaults::get_structure_defaults();
		$this->language_defaults     = BH_Store_Locator_Defaults::get_language_defaults();
		$this->wp_info               = BH_Store_Locator_Defaults::get_wp_info_defaults();

		// Get option values for use.
		$this->primary_option_vals   = get_option( 'bh_storelocator_primary_options', $this->primary_defaults );
		$this->address_option_vals   = get_option( 'bh_storelocator_meta_options', $this->address_meta_defaults );
		$this->filter_option_vals    = get_option( 'bh_storelocator_filter_options', $this->filter_defaults );
		$this->style_option_vals     = get_option( 'bh_storelocator_style_options', $this->style_defaults );
		$this->structure_option_vals = get_option( 'bh_storelocator_structure_options', $this->structure_defaults );
		$this->language_option_vals  = get_option( 'bh_storelocator_language_options', $this->language_defaults );

		// Update posttype if cpt is being used.
		if ( 'locations' === $this->primary_option_vals['datasource'] ) {
			$this->primary_option_vals['posttype'] = self::BH_SL_CPT;
		}

		// Check for template overrides in the current theme's directory and add to $wp_info if they exist.
		if ( file_exists( $this->wp_info['template_path'] . '/cardinal-locator' ) && is_dir( $this->wp_info['template_path'] . '/cardinal-locator' ) ) {
			// Infowindow.
			if ( file_exists( $this->wp_info['template_path'] . '/cardinal-locator/infowindow-description.html' ) ) {
				$this->wp_info['infowindow_template'] = $this->wp_info['template_uri'] . '/cardinal-locator/infowindow-description.html';
			}
			// List.
			if ( file_exists( $this->wp_info['template_path'] . '/cardinal-locator/location-list-description.html' ) ) {
				$this->wp_info['list_template'] = $this->wp_info['template_uri'] . '/cardinal-locator/location-list-description.html';
			}
			// KML infowindow.
			if ( file_exists( $this->wp_info['template_path'] . '/cardinal-locator/kml-infowindow-description.html' ) ) {
				$this->wp_info['kml_infowindow_template'] = $this->wp_info['template_uri'] . '/cardinal-locator/kml-infowindow-description.html';
			}
			// KML list.
			if ( file_exists( $this->wp_info['template_path'] . '/cardinal-locator/kml-location-list-description.html' ) ) {
				$this->wp_info['kml_list_template'] = $this->wp_info['template_uri'] . '/cardinal-locator/kml-location-list-description.html';
			}
		}
		$this->wp_info['plugin-slug'] = $this->plugin_slug;

		// Load plugin text domain.
		add_action( 'init', array( $this, 'load_plugin_textdomain' ) );

		// WPML URL filtering.
		if ( function_exists( 'icl_object_id' ) ) {
			add_filter( 'bh_sl_plugin_paths_filter', array( $this, 'bh_storelocator_wpml_plugin_paths' ) );
		}

		// Load public-facing style sheet and JavaScript.
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

		// Register new post type, taxonomy and post meta if option is selected.
		if ( 'locations' === $this->primary_option_vals['datasource'] || 'cpt' === $this->primary_option_vals['datasource'] ) {
			add_action( 'init', array( $this, 'bh_storelocator_post_type' ) );
			add_action( 'init', array( $this, 'bh_storelocator_post_tax' ) );
			add_action( 'load-post.php', array( $this, 'call_bh_storelocator_post_meta' ) );
			add_action( 'load-post-new.php', array( $this, 'call_bh_storelocator_post_meta' ) );
		}

		// Add custom plugin shortcode.
		add_action( 'init', array( $this, 'bh_storelocator_setup_shortcode' ) );

		// Add map widget for single location pages.
		add_action( 'init', array( $this, 'bh_storelocator_setup_map_widget' ) );

		// Remote data.
		if ( 'remoteurl' === $this->primary_option_vals['datasource'] ) {
			add_action( 'init', array( $this, 'bh_storelocator_setup_remote_location_data_caching' ) );
		}

		// AJAX data.
		if ( 'true' === $this->primary_option_vals['manylocations'] ) {
			add_action( 'wp_ajax_bh_storelocator_posts_query_ajax', array( $this, 'bh_storelocator_posts_query_ajax' ) );
			add_action( 'wp_ajax_nopriv_bh_storelocator_posts_query_ajax', array( $this, 'bh_storelocator_posts_query_ajax' ) );
		}
	}

	/**
	 * Return the plugin slug.
	 *
	 * @return string Plugin slug variable.
	 */
	public function get_plugin_slug() {
		return $this->plugin_slug;
	}

	/**
	 * Return an instance of this class.
	 *
	 * @return object A single instance of this class.
	 */
	public static function get_instance() {

		// If the single instance hasn't been set, set it now.
		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Load the plugin text domain for translation.
	 */
	public function load_plugin_textdomain() {

		$domain = $this->plugin_slug;
		$locale = apply_filters( 'bh_sl_locale', get_locale(), $domain );

		load_textdomain( $domain, trailingslashit( WP_LANG_DIR ) . $domain . '/' . $domain . '-' . $locale . '.mo' );
		load_plugin_textdomain( $domain, false, basename( plugin_dir_path( dirname( __FILE__ ) ) ) . '/languages/' );

	}

	/**
	 * Filter to allow styles and scripts to be skipped.
	 *
	 * @return bool
	 */
	public function disable_scripts_styles_check() {
		$check = true;

		return apply_filters( 'bh_sl_page_check', $check );
	}

	/**
	 * Register and enqueue public-facing style sheet.
	 */
	public function enqueue_styles() {

		// Check for locator disable scripts and styles filter.
		if ( false === $this->disable_scripts_styles_check() ) {
			return;
		}

		wp_enqueue_style( $this->plugin_slug . '-plugin-styles', plugins_url( 'assets/css/public-min.css', __FILE__ ), array(), self::VERSION );

		// Hook.
		do_action( 'bh_sl_enqueue_styles' );
	}

	/**
	 * Register and enqueues public-facing JavaScript files.
	 */
	public function enqueue_scripts() {

		// Check for locator disable scripts and styles filter.
		if ( false === $this->disable_scripts_styles_check() ) {
			return;
		}

		global $post;
		$post_id                  = false;
		$loc_imgs                 = array();
		$maps_query_string        = '';
		$maps_query_string_params = array();

		// Check to see if a post is being viewed.
		if ( is_object( $post ) ) {
			$post_id = $post->ID;
		}

		// Check for Google Maps API key.
		if ( array_key_exists( 'apikey', $this->primary_option_vals ) && ! empty( $this->primary_option_vals['apikey'] ) ) {
			$maps_query_string_params['key'] = $this->primary_option_vals['apikey'];
		}

		// Set up Google Places auto complete URL parameter when the option is set to true.
		if ( array_key_exists( 'autocomplete', $this->primary_option_vals ) ) {
			if ( 'true' === $this->primary_option_vals['autocomplete'] ) {
				$maps_query_string_params['libraries'] = 'places';
			}
		}

		// Build query string if params are set.
		if ( count( $maps_query_string_params ) > 0 ) {
			$maps_query_string = '?' . http_build_query( $maps_query_string_params );
		}

		wp_enqueue_script( 'jquery' ); // Make sure jQuery is loaded.
		$this->bh_storelocator_maybe_load_google_maps( $maps_query_string, $maps_query_string_params );
		wp_enqueue_script( 'handlebars', plugins_url( 'assets/js/vendor/handlebars-min.js', __FILE__ ), array(), '4.0.5', true );
		wp_enqueue_script( 'storelocator-script', plugins_url( 'assets/js/vendor/jquery.storelocator-min.js', __FILE__ ), array( 'jquery' ), '2.7.4', true );
		wp_enqueue_script( $this->plugin_slug . '-plugin-script', plugins_url( 'assets/js/public-min.js', __FILE__ ), array( 'jquery' ), self::VERSION, true );

		// Get the location category terms and set up an array to pass to the plugin options.
		if ( taxonomy_exists( self::BH_SL_TAX ) && 'true' === $this->style_option_vals['loccatimgs'] ) {
			$cat_imgs      = array();
			$location_cats = get_terms( self::BH_SL_TAX );

			// Set up the location category images array.
			foreach ( $location_cats as $location_cat ) {
				$cat_img = get_option( 'catimage_' . $location_cat->term_id );
				if ( $cat_img && ! empty( $cat_img['catimage'] ) && 'true' === $this->style_option_vals['loccatimgs'] && '' !== $this->style_option_vals['catimgdimwidth'] && '' !== $this->style_option_vals['catimgdimheight'] ) {
					$cat_imgs[ $location_cat->name ] = array( $cat_img['catimage'], (int) $this->style_option_vals['catimgdimwidth'], (int) $this->style_option_vals['catimgdimheight'] );
				} elseif ( $cat_img && ! empty( $cat_img['catimage'] ) ) {
					$cat_imgs[ $location_cat->name ] = array( $cat_img['catimage'], '32', '32' );
				}
			}

			if ( count( $cat_imgs ) > 0 ) {
				$loc_imgs['catimages'] = $cat_imgs;
			}
		}

		// AJAX nonce.
		$this->wp_info['ajax_nonce'] = wp_create_nonce( 'bh_storelocator_ajax_query' );

		// Current post ID.
		$this->wp_info['post_id'] = $post_id;

		// Debug.
		if ( defined( 'WP_DEBUG' ) && true === WP_DEBUG ) {
			$this->wp_info['wp_debug'] = 'true';
		}

		// Do not pass the template_path to the JS file - full path disclosure security problem. Change approach in the future.
		if ( isset( $this->wp_info['template_path'] ) ) {
			unset( $this->wp_info['template_path'] );
		}

		// Pass setting values to jQuery plugin as one array.
		$bh_storelocator_all_options = array_merge(
			$this->primary_option_vals,
			$this->address_option_vals,
			$this->filter_option_vals,
			$this->style_option_vals,
			$this->structure_option_vals,
			$this->language_option_vals,
			$loc_imgs,
			apply_filters( 'bh_sl_plugin_paths_filter', $this->wp_info )
		);

		// Do not pass the back-end Geocoding API key value to the JS file so it remains protected.
		if ( isset( $bh_storelocator_all_options['apikey_backend'] ) ) {
			unset( $bh_storelocator_all_options['apikey_backend'] );
		}

		// Pass plugin options to the jQuery file.
		wp_localize_script( 'storelocator-script', 'bhStoreLocatorWpSettings', $bh_storelocator_all_options );

		// Map settings filter.
		$map_settings = apply_filters( 'bh_sl_map_settings', array() );

		// Pass the map settings array to the jQuery file.
		wp_localize_script( 'storelocator-script', 'bhStoreLocatorMapSettings', $map_settings );

		// Custom post type setup.
		if ( 'locations' === $bh_storelocator_all_options['datasource'] || 'cpt' === $bh_storelocator_all_options['datasource'] ) {
			$cpt = '';

			// Set the custom post type name to pass to the query method.
			if ( 'locations' === $bh_storelocator_all_options['datasource'] ) {
				$cpt = self::BH_SL_CPT;
			} elseif ( 'cpt' === $bh_storelocator_all_options['datasource'] ) {
				$cpt = $bh_storelocator_all_options['posttype'];
			}

			// Posts query saved to transient.
			if ( 'true' !== $bh_storelocator_all_options['manylocations'] ) {
				if ( false === ( $locations_query = get_transient( 'bh_sl_locations' ) ) ) {
					$locations_query = $this->bh_storelocator_posts_query( $cpt );
					// Store the JSON data in a transient.
					if ( ! empty( $locations_query ) ) {
						set_transient( 'bh_sl_locations', $locations_query );
					}

					wp_reset_postdata();
				}

				// Pass location data to the jQuery file.
				if ( ! empty( $locations_query ) ) {
					wp_localize_script( 'storelocator-script', 'bhStoreLocatorLocations', apply_filters( 'bh_sl_location_data', $locations_query, $post_id ) );
				}
			}

			// Pass single location data on location posts.
			if ( is_single() && is_object( $post ) ) {
				// Set up the location data.
				$bh_sl_single_location_meta = $this->bh_storelocator_build_location_data( $post->post_type, get_option( 'bh_storelocator_meta_options' ) );

				wp_localize_script( 'storelocator-script', 'bhStoreLocatorLocation', $bh_sl_single_location_meta );
			}
		}

		// Custom map styling.
		if ( 'true' === $bh_storelocator_all_options['mapstyles'] && '' !== $bh_storelocator_all_options['mapstylesfile'] ) {
			$map_styles_file = $this->bh_storelocator_get_home_path() . $bh_storelocator_all_options['mapstylesfile'];

			// Check to make sure the file exists, then read it.
			if ( file_exists( $map_styles_file ) ) {
				$map_styles = file_get_contents( $map_styles_file );
			}

			// Check for valid JSON, then localize the data.
			if ( isset( $map_styles ) && null !== json_decode( $map_styles ) ) {

				// Pass the styling data to the jQuery file.
				wp_localize_script( 'storelocator-script', 'bhStoreLocatorMapStyles', $map_styles );
			}
		}

		// Hook.
		do_action( 'bh_sl_enqueue_scripts', $bh_storelocator_all_options );
	}

	/**
	 * Check for known conflicts to avoid loading Google Maps multiple times.
	 *
	 * @param string $maps_query_string Google maps query string parameters.
	 * @param array  $maps_query_string_params Google maps query string parameters in array format.
	 */
	public function bh_storelocator_maybe_load_google_maps( $maps_query_string, $maps_query_string_params ) {

		// Skip Events Calendar single event posts.
		if ( check_plugin_active( 'the-events-calendar/the-events-calendar.php' ) && is_singular( 'tribe_events' ) ) {
			return;
		}

		if ( is_multisite() && check_plugin_network_active( 'the-events-calendar/the-events-calendar.php' ) && is_singular( 'tribe_events' ) ) {
			return;
		}

		wp_enqueue_script( 'google-maps', apply_filters( 'bh_sl_gmap', 'https://maps.google.com/maps/api/js' . $maps_query_string, $maps_query_string, $maps_query_string_params ), array(), '1.0.0', true );
	}

	/**
	 * Sanitize a directory path
	 *
	 * @param string $dir Directory path to sanitize.
	 * @param bool   $recursive Recursive.
	 *
	 * @return string
	 */
	public static function bh_storelocator_conform_dir( $dir, $recursive = false ) {
		// Assume empty dir is root.
		if ( ! $dir ) {
			$dir = '/';
		}

		// Replace single forward slash (looks like double slash because we have to escape it).
		$dir = str_replace( '\\', '/', $dir );
		$dir = str_replace( '//', '/', $dir );
		// Remove the trailing slash.
		if ( '/' !== $dir ) {
			$dir = untrailingslashit( $dir );
		}

		// Carry on until completely normalized.
		if ( ! $recursive && self::bh_storelocator_conform_dir( $dir, true ) !== $dir ) {
			return self::bh_storelocator_conform_dir( $dir );
		}

		return (string) $dir;
	}

	/**
	 * Attempt to work out the root directory of the site, that is, the path equivalent of home_url().
	 *
	 * @return string $home_path
	 */
	public static function bh_storelocator_get_home_path() {
		$home_url  = home_url();
		$site_url  = site_url();
		$home_path = ABSPATH;
		// Attempt to guess the home path based on the location of wp-config.php.
		if ( ! file_exists( ABSPATH . 'wp-config.php' ) ) {
			$home_path = trailingslashit( dirname( ABSPATH ) );
		}
		// If site_url contains home_url and they differ then assume WordPress is installed in a sub directory.
		if ( $home_url !== $site_url && strpos( $site_url, $home_url ) === 0 ) {
			$home_path = trailingslashit( substr( self::bh_storelocator_conform_dir( ABSPATH ), 0, strrpos( self::bh_storelocator_conform_dir( ABSPATH ), str_replace( $home_url, '', $site_url ) ) ) );
		}

		return self::bh_storelocator_conform_dir( $home_path );
	}

	/**
	 * Build the location data array
	 *
	 * @param string $post_type       Post type to check.
	 * @param array  $address_options Address meta mapping options.
	 *
	 * @return array
	 */
	protected function bh_storelocator_build_location_data( $post_type, $address_options ) {
		$bh_sl_location_data = array();

		// Standard post meta for our locations.
		$location_id                           = get_the_ID();
		$bh_sl_location_data['id']             = $location_id;
		$bh_sl_location_data['name']           = get_the_title( $location_id );
		$bh_sl_location_data['date']           = get_the_date( 'F j, Y g:i A', $location_id );
		$bh_sl_location_data['permalink']      = get_the_permalink( $location_id );
		$bh_sl_location_data['template_uri']   = get_template_directory_uri();
		$bh_sl_location_data['stylesheet_uri'] = get_stylesheet_directory_uri();
		$bh_sl_location_data['excerpt']        = get_the_excerpt();
		$bh_sl_location_meta                   = get_post_meta( $location_id );
		$bh_sl_location_data['lat']            = ( isset( $bh_sl_location_meta['bh_storelocator_location_lat'][0] ) ) ? $bh_sl_location_meta['bh_storelocator_location_lat'][0] : '';
		$bh_sl_location_data['lng']            = ( isset( $bh_sl_location_meta['bh_storelocator_location_lng'][0] ) ) ? $bh_sl_location_meta['bh_storelocator_location_lng'][0] : '';
		// Featured image.
		$image_size                           = 'thumbnail';
		$thumb                                = wp_get_attachment_image_src( get_post_thumbnail_id( $location_id ), apply_filters( 'bh_sl_featured_img', $image_size ) );
		$bh_sl_location_data['featuredimage'] = ( is_array( $thumb ) ) ? $thumb['0'] : '';

		if ( self::BH_SL_CPT !== $post_type ) {
			// Keys taken from mapped address meta settings.
			$bh_sl_location_data['address']  = ( isset( $bh_sl_location_meta[ $address_options['address'] ][0] ) ) ? $bh_sl_location_meta[ $address_options['address'] ][0] : '';
			$bh_sl_location_data['address2'] = ( isset( $bh_sl_location_meta[ $address_options['address_secondary'] ][0] ) ) ? $bh_sl_location_meta[ $address_options['address_secondary'] ][0] : '';
			$bh_sl_location_data['city']     = ( isset( $bh_sl_location_meta[ $address_options['city'] ][0] ) ) ? $bh_sl_location_meta[ $address_options['city'] ][0] : '';
			$bh_sl_location_data['state']    = ( isset( $bh_sl_location_meta[ $address_options['state'] ][0] ) ) ? $bh_sl_location_meta[ $address_options['state'] ][0] : '';
			$bh_sl_location_data['postal']   = ( isset( $bh_sl_location_meta[ $address_options['postal'] ][0] ) ) ? $bh_sl_location_meta[ $address_options['postal'] ][0] : '';
			$bh_sl_location_data['country']  = ( isset( $bh_sl_location_meta[ $address_options['country'] ][0] ) ) ? $bh_sl_location_meta[ $address_options['country'] ][0] : '';
			$bh_sl_location_data['email']    = ( isset( $bh_sl_location_meta[ $address_options['email'] ][0] ) ) ? $bh_sl_location_meta[ $address_options['email'] ][0] : '';
			$bh_sl_location_data['phone']    = ( isset( $bh_sl_location_meta[ $address_options['phone'] ][0] ) ) ? $bh_sl_location_meta[ $address_options['phone'] ][0] : '';
			$bh_sl_location_data['fax']      = ( isset( $bh_sl_location_meta[ $address_options['fax'] ][0] ) ) ? $bh_sl_location_meta[ $address_options['fax'] ][0] : '';
			$bh_sl_location_data['web']      = ( isset( $bh_sl_location_meta[ $address_options['website'] ][0] ) ) ? $bh_sl_location_meta[ $address_options['website'] ][0] : '';
			$bh_sl_location_data['hours1']   = ( isset( $bh_sl_location_meta[ $address_options['hours_one'] ][0] ) ) ? $bh_sl_location_meta[ $address_options['hours_one'] ][0] : '';
			$bh_sl_location_data['hours2']   = ( isset( $bh_sl_location_meta[ $address_options['hours_two'] ][0] ) ) ? $bh_sl_location_meta[ $address_options['hours_two'] ][0] : '';
			$bh_sl_location_data['hours3']   = ( isset( $bh_sl_location_meta[ $address_options['hours_three'] ][0] ) ) ? $bh_sl_location_meta[ $address_options['hours_three'] ][0] : '';
			$bh_sl_location_data['hours4']   = ( isset( $bh_sl_location_meta[ $address_options['hours_four'] ][0] ) ) ? $bh_sl_location_meta[ $address_options['hours_four'] ][0] : '';
			$bh_sl_location_data['hours5']   = ( isset( $bh_sl_location_meta[ $address_options['hours_five'] ][0] ) ) ? $bh_sl_location_meta[ $address_options['hours_five'] ][0] : '';
			$bh_sl_location_data['hours6']   = ( isset( $bh_sl_location_meta[ $address_options['hours_six'] ][0] ) ) ? $bh_sl_location_meta[ $address_options['hours_six'] ][0] : '';
			$bh_sl_location_data['hours7']   = ( isset( $bh_sl_location_meta[ $address_options['hours_seven'] ][0] ) ) ? $bh_sl_location_meta[ $address_options['hours_seven'] ][0] : '';
		} elseif ( self::BH_SL_CPT === $post_type ) {
			// Locations meta fields.
			$bh_sl_location_data['address']  = ( isset( $bh_sl_location_meta['_bh_sl_address'][0] ) ) ? $bh_sl_location_meta['_bh_sl_address'][0] : '';
			$bh_sl_location_data['address2'] = ( isset( $bh_sl_location_meta['_bh_sl_address_two'][0] ) ) ? $bh_sl_location_meta['_bh_sl_address_two'][0] : '';
			$bh_sl_location_data['city']     = ( isset( $bh_sl_location_meta['_bh_sl_city'][0] ) ) ? $bh_sl_location_meta['_bh_sl_city'][0] : '';
			$bh_sl_location_data['state']    = ( isset( $bh_sl_location_meta['_bh_sl_state'][0] ) ) ? $bh_sl_location_meta['_bh_sl_state'][0] : '';
			$bh_sl_location_data['postal']   = ( isset( $bh_sl_location_meta['_bh_sl_postal'][0] ) ) ? $bh_sl_location_meta['_bh_sl_postal'][0] : '';
			$bh_sl_location_data['country']  = ( isset( $bh_sl_location_meta['_bh_sl_country'][0] ) ) ? $bh_sl_location_meta['_bh_sl_country'][0] : '';
			$bh_sl_location_data['email']    = ( isset( $bh_sl_location_meta['_bh_sl_email'][0] ) ) ? $bh_sl_location_meta['_bh_sl_email'][0] : '';
			$bh_sl_location_data['phone']    = ( isset( $bh_sl_location_meta['_bh_sl_phone'][0] ) ) ? $bh_sl_location_meta['_bh_sl_phone'][0] : '';
			$bh_sl_location_data['fax']      = ( isset( $bh_sl_location_meta['_bh_sl_fax'][0] ) ) ? $bh_sl_location_meta['_bh_sl_fax'][0] : '';
			$bh_sl_location_data['web']      = ( isset( $bh_sl_location_meta['_bh_sl_web'][0] ) ) ? $bh_sl_location_meta['_bh_sl_web'][0] : '';
			if ( '1' === get_post_meta( $location_id, '_bh_sl_featured', true ) ) {
				$bh_sl_location_data['featured'] = 'true';
			} else {
				$bh_sl_location_data['featured'] = '';
			}
			$bh_sl_location_data['hours1'] = ( isset( $bh_sl_location_meta['_bh_sl_hours_one'][0] ) ) ? $bh_sl_location_meta['_bh_sl_hours_one'][0] : '';
			$bh_sl_location_data['hours2'] = ( isset( $bh_sl_location_meta['_bh_sl_hours_two'][0] ) ) ? $bh_sl_location_meta['_bh_sl_hours_two'][0] : '';
			$bh_sl_location_data['hours3'] = ( isset( $bh_sl_location_meta['_bh_sl_hours_three'][0] ) ) ? $bh_sl_location_meta['_bh_sl_hours_three'][0] : '';
			$bh_sl_location_data['hours4'] = ( isset( $bh_sl_location_meta['_bh_sl_hours_four'][0] ) ) ? $bh_sl_location_meta['_bh_sl_hours_four'][0] : '';
			$bh_sl_location_data['hours5'] = ( isset( $bh_sl_location_meta['_bh_sl_hours_five'][0] ) ) ? $bh_sl_location_meta['_bh_sl_hours_five'][0] : '';
			$bh_sl_location_data['hours6'] = ( isset( $bh_sl_location_meta['_bh_sl_hours_six'][0] ) ) ? $bh_sl_location_meta['_bh_sl_hours_six'][0] : '';
			$bh_sl_location_data['hours7'] = ( isset( $bh_sl_location_meta['_bh_sl_hours_seven'][0] ) ) ? $bh_sl_location_meta['_bh_sl_hours_seven'][0] : '';
		}

		// Allow lat/lng to be overridden by custom meta if set - other custom post type.
		if ( ! empty( $bh_sl_location_meta[ $address_options['latitude'] ][0] ) ) {
			$bh_sl_location_data['lat'] = $bh_sl_location_meta[ $address_options['latitude'] ][0];
		}
		if ( ! empty( $bh_sl_location_meta[ $address_options['longitude'] ][0] ) ) {
			$bh_sl_location_data['lng'] = $bh_sl_location_meta[ $address_options['longitude'] ][0];
		}

		// Allow lat/lng to be overridden by custom fields if set.
		if ( isset( $bh_sl_location_meta['latitude'][0] ) ) {
			$bh_sl_location_data['lat'] = $bh_sl_location_meta['latitude'][0];
		}
		if ( isset( $bh_sl_location_meta['longitude'][0] ) ) {
			$bh_sl_location_data['lng'] = $bh_sl_location_meta['longitude'][0];
		}

		// Add any additional custom post meta.
		$custom_fields = get_post_custom( $location_id );
		if ( count( $custom_fields ) > 0 ) {
			// Skip the fields we already have.
			foreach ( $custom_fields as $custom_field => $value ) {
				if ( ( ! array_key_exists( $custom_field, $bh_sl_location_data ) ) && ( '_' !== substr( $custom_field, 0, 1 ) ) ) {
					$bh_sl_location_data[ $custom_field ] = $value[0];
				}
			}
		}

		// Add any taxonomies assigned to the post type.
		$location_taxonomies = get_object_taxonomies( $post_type );
		if ( is_array( $location_taxonomies ) ) {
			foreach ( $location_taxonomies as $location_taxonomy ) {
				$tax_terms = get_the_terms( $location_id, $location_taxonomy );

				// Add categories if any are set.
				if ( false !== $tax_terms && is_array( $tax_terms ) && count( $tax_terms ) > 0 ) {
					$selected_tax_cats      = array();
					$selected_tax_cat_terms = array();

					foreach ( $tax_terms as $tax_term ) {
						array_push( $selected_tax_cats, $tax_term->name );
						array_push( $selected_tax_cat_terms, $tax_term );
					}

					// String of category names.
					if ( count( $selected_tax_cats ) > 0 ) {
						$bh_sl_location_data[ $location_taxonomy ] = implode( ', ', $selected_tax_cats );
					}

					// Array of category term objects. Added after - the above is kept for backwards compatibility.
					if ( count( $selected_tax_cat_terms ) > 0 ) {
						$bh_sl_location_data[ $location_taxonomy . '_terms' ] = $selected_tax_cat_terms;
					}
				}
			}
		}

		return $bh_sl_location_data;
	}

	/**
	 * Data setup for transient when using a custom post type
	 *
	 * @param string $post_type Post type.
	 *
	 * @return string
	 */
	protected function bh_storelocator_posts_query( $post_type ) {
		$location_data = '';

		// Before query hook.
		do_action( 'bh_sl_before_location_query' );

		// Post type is required.
		if ( '' === $post_type ) {
			return $location_data;
		}

		$bh_sl_locations_query_args = array(
			'no_found_rows'  => true,
			'post_type'      => $post_type,
			'posts_per_page' => 1000,
		);

		$bh_sl_locations_query = new WP_Query( apply_filters( 'bh_sl_locations_query_args', $bh_sl_locations_query_args ) );

		// Check for no locations.
		if ( empty( $bh_sl_locations_query->posts ) ) {
			return $location_data;
		}

		// Format the query.
		if ( $bh_sl_locations_query->have_posts() ) {
			$address_options            = get_option( 'bh_storelocator_meta_options' );
			$bh_sl_locations_query_data = array();
			$locations                  = array();

			while ( $bh_sl_locations_query->have_posts() ) {
				$bh_sl_locations_query->the_post();

				// Build the location data.
				$bh_sl_locations_query_data = $this->bh_storelocator_build_location_data( $post_type, $address_options );

				// Build the array that will be encoded.
				if ( ! empty( $bh_sl_locations_query_data ) ) {
					array_push( $locations, $bh_sl_locations_query_data );
				}
			}
			$location_data = wp_json_encode( $locations );
		}

		// After query hook.
		do_action( 'bh_sl_after_location_query' );

		return $location_data;
	}

	/**
	 * Data setup for custom post type and more than 1,000 locations
	 */
	public function bh_storelocator_posts_query_ajax() {

		// Check the referrer for security.
		check_ajax_referer( 'bh_storelocator_ajax_query', 'security' );

		global $wpdb, $post;
		$location_data  = array();
		$location_posts = array();
		$coords_table   = $wpdb->prefix . 'cardinal_locator_coords';

		// Before query hook.
		do_action( 'bh_sl_before_location_query' );

		// Get the origin coordinates.
		$orig_lat = filter_input( INPUT_GET, 'origLat', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION );
		$orig_lng = filter_input( INPUT_GET, 'origLng', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION );
		// Get the post type.
		$post_type = filter_input( INPUT_GET, 'postType', FILTER_SANITIZE_STRING );
		// Get the post ID.
		$post_id = filter_input( INPUT_GET, 'postID', FILTER_SANITIZE_NUMBER_INT );

		// Set up custom locations query.
		$location_ids = array();

		$location_posts = $wpdb->get_results(
			$wpdb->prepare( "
					SELECT DISTINCT id
					FROM $coords_table
					WHERE lat BETWEEN %f - DEGREES(0.0253) AND %f + DEGREES(0.0253)
					AND lng BETWEEN %f - DEGREES(0.0253) AND %f + DEGREES(0.0253)
					LIMIT 500
				",
				$orig_lat,
				$orig_lat,
				$orig_lng,
				$orig_lng
			)
		);

		foreach ( $location_posts as $location_post ) {
			array_push( $location_ids, $location_post->id );
		}

		$bh_sl_locations_query_args = array(
			'no_found_rows'  => true,
			'post_type'      => $post_type,
			'post_status'    => array( 'publish' ),
			'post__in'       => $location_ids,
			'posts_per_page' => 500,
		);

		$bh_sl_locations_query = new WP_Query( apply_filters( 'bh_sl_locations_query_args', $bh_sl_locations_query_args ) );

		if ( $bh_sl_locations_query->have_posts() ) {
			$bh_sl_locations_query_data = array();
			$address_options            = get_option( 'bh_storelocator_meta_options' );

			// Locations loop.
			while ( $bh_sl_locations_query->have_posts() ) {
				$bh_sl_locations_query->the_post();

				// Build the location data.
				$bh_sl_locations_query_data = $this->bh_storelocator_build_location_data( $post_type, $address_options );

				// Build the array that will be encoded.
				array_push( $location_data, $bh_sl_locations_query_data );
			}

			// Query debugging.
			if ( defined( 'SAVEQUERIES' ) && SAVEQUERIES ) {
				$queries = array();
				foreach ( $wpdb->queries as $query ) {
					$sql = preg_replace( "/[\s]/", ' ', $query[0] );
					$sql = preg_replace( "/[ ]{2,}/", ' ', $sql );

					$queries[] = array(
						'sql'   => $sql,
						'time'  => $query[1],
						'stack' => $query[2],
					);
				}
				$location_data['queries'] = $queries;
			}

			echo wp_json_encode( apply_filters( 'bh_sl_location_data', $location_data, $post_id ) );
		}

		// After query hook.
		do_action( 'bh_sl_after_location_query' );

		// Need to add this to prevent 0 from being appended.
		die();
	}

	/**
	 * Register plugin locations custom post type
	 */
	public function bh_storelocator_post_type() {

		// Locations.
		$locations_labels = array(
			'name'               => _x( 'Locations', 'Post Type General Name', 'bh-storelocator' ),
			'singular_name'      => _x( 'Location', 'Post Type Singular Name', 'bh-storelocator' ),
			'menu_name'          => __( 'Locations', 'bh-storelocator' ),
			'name_admin_bar'     => __( 'Locations', 'bh-storelocator' ),
			'parent_item_colon'  => __( 'Parent Location:', 'bh-storelocator' ),
			'all_items'          => __( 'All Locations', 'bh-storelocator' ),
			'add_new_item'       => __( 'Add New Location', 'bh-storelocator' ),
			'add_new'            => __( 'Add New', 'bh-storelocator' ),
			'new_item'           => __( 'New Location', 'bh-storelocator' ),
			'edit_item'          => __( 'Edit Location', 'bh-storelocator' ),
			'update_item'        => __( 'Update Location', 'bh-storelocator' ),
			'view_item'          => __( 'View Location', 'bh-storelocator' ),
			'search_items'       => __( 'Search Locations', 'bh-storelocator' ),
			'not_found'          => __( 'No Locations found', 'bh-storelocator' ),
			'not_found_in_trash' => __( 'No Locations found in Trash', 'bh-storelocator' ),
		);

		$locations_args = array(
			'label'               => __( 'Locations', 'bh-storelocator' ),
			'description'         => __( 'Locations', 'bh-storelocator' ),
			'labels'              => $locations_labels,
			'supports'            => array(
				'title',
				'editor',
				'author',
				'excerpt',
				'revisions',
				'thumbnail',
				'custom-fields',
				'comments',
			),
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'menu_position'       => 5,
			'menu_icon'           => 'dashicons-location-alt',
			'show_in_admin_bar'   => true,
			'show_in_nav_menus'   => true,
			'can_export'          => true,
			'has_archive'         => true,
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
			'capability_type'     => 'post',
			'rewrite'             => array(
				'slug'       => 'locations',
				'with_front' => false,
			),
			'show_in_rest'        => true,
		);

		register_post_type( self::BH_SL_CPT, apply_filters( 'bh_sl_cpt_params', $locations_args ) );
	}

	/**
	 * Register plugin custom taxonomy for locations post type
	 */
	public function bh_storelocator_post_tax() {
		$loc_cat_labels = array(
			'name'                       => _x( 'Location Categories', 'Taxonomy General Name', 'bh-storelocator' ),
			'singular_name'              => _x( 'Location Category', 'Taxonomy Singular Name', 'bh-storelocator' ),
			'menu_name'                  => __( 'Location Categories', 'bh-storelocator' ),
			'all_items'                  => __( 'All Categories', 'bh-storelocator' ),
			'parent_item'                => __( 'Parent Category', 'bh-storelocator' ),
			'parent_item_colon'          => __( 'Parent Category:', 'bh-storelocator' ),
			'new_item_name'              => __( 'New Item Name', 'bh-storelocator' ),
			'add_new_item'               => __( 'Add New Category', 'bh-storelocator' ),
			'edit_item'                  => __( 'Edit Category', 'bh-storelocator' ),
			'update_item'                => __( 'Update Category', 'bh-storelocator' ),
			'view_item'                  => __( 'View Category', 'bh-storelocator' ),
			'separate_items_with_commas' => __( 'Separate categories with commas', 'bh-storelocator' ),
			'add_or_remove_items'        => __( 'Add or remove categories', 'bh-storelocator' ),
			'choose_from_most_used'      => __( 'Choose from the most used', 'bh-storelocator' ),
			'popular_items'              => __( 'Popular Categories', 'bh-storelocator' ),
			'search_items'               => __( 'Search Categories', 'bh-storelocator' ),
			'not_found'                  => __( 'Not Found', 'bh-storelocator' ),
		);

		$loc_cat_args = array(
			'labels'            => $loc_cat_labels,
			'hierarchical'      => true,
			'public'            => true,
			'show_ui'           => true,
			'show_admin_column' => true,
			'show_in_nav_menus' => true,
			'show_tagcloud'     => true,
			'rewrite'           => array( 'slug' => 'locations-category' ),
		);

		register_taxonomy( self::BH_SL_TAX, apply_filters( 'bh_sl_tax_cpts', array( self::BH_SL_CPT ) ), apply_filters( 'bh_sl_tax_params', $loc_cat_args ) );
	}

	/**
	 * Filter to pass the correct URLs to jQuery when using WPML with multiple domains.
	 * Added to avoid cross-origin JS error - templates were loading from the primary WPML site domain.
	 *
	 * @param array $wp_info Array of WordPress paths and URLs sent to jQuery.
	 *
	 * @return mixed
	 */
	public function bh_storelocator_wpml_plugin_paths( $wp_info ) {
		global $sitepress;

		if ( method_exists( $sitepress, 'convert_url' ) && method_exists( $sitepress, 'get_setting' ) ) {

			// Only modify the paths if "A different domain per language" is selected as the Language URL format setting.
			if ( 2 === (int) $sitepress->get_setting( 'language_negotiation_type' ) ) {
				$wp_info['template_uri'] = $sitepress->convert_url( $wp_info['template_uri'] );
				$wp_info['plugin_path']  = $sitepress->convert_url( $wp_info['plugin_path'] );
				$wp_info['plugin_url']   = $sitepress->convert_url( $wp_info['plugin_url'] );
				$wp_info['admin_ajax']   = $sitepress->convert_url( $wp_info['admin_ajax'] );
			}
		}

		return $wp_info;
	}

	/**
	 * Set up the custom post meta fields for locations.
	 */
	public function call_bh_storelocator_post_meta() {
		new BH_Store_Locator_Post_Meta();
	}

	/**
	 * Set up the shortcode.
	 */
	public function bh_storelocator_setup_shortcode() {
		$shortcode = new BH_Store_Locator_Shortcode( $this->primary_option_vals, $this->address_option_vals, $this->filter_option_vals, $this->style_option_vals, $this->structure_option_vals, $this->language_option_vals );
		$shortcode->init();
	}

	/**
	 * Set up the single location map widget.
	 */
	public function bh_storelocator_setup_map_widget() {
		new BH_Store_Locator_Widget();
	}

	/**
	 * Set up remote location data caching.
	 */
	public function bh_storelocator_setup_remote_location_data_caching() {
		$cache_remote_data = new BH_Store_Locator_Cache_Remote_Data( $this->primary_option_vals );
		$cache_remote_data->init();
	}
}
