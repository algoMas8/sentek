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
 * Class BH_Store_Locator_Admin
 */
class BH_Store_Locator_Admin {

	/**
	 * URL of the store
	 *
	 * @var string
	 */
	const STORE_URL = 'https://cardinalwp.com';

	/**
	 * Product name
	 *
	 * @var string
	 */
	const PRODUCT_NAME = 'Cardinal Locator Single License';

	/**
	 * Instance of this class.
	 *
	 * @var object
	 */
	protected static $instance = null;

	/**
	 * Slug of the plugin screen.
	 *
	 * @var string
	 */
	protected $plugin_screen_hook_suffix = null;

	/**
	 * License defaults.
	 *
	 * @var array|null
	 */
	private $license_defaults = null;

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
	 * License option values.
	 *
	 * @var mixed|null|void
	 */
	public $license_option_vals = null;

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
	 * Geocode error messaging.
	 *
	 * @var string
	 */
	public $geocode_error = '';

	/**
	 * Initialize the plugin by loading admin scripts & styles and adding a
	 * settings page and menu.
	 */
	private function __construct() {

		require_once 'includes/field-helpers.php';
		require_once 'includes/custom-filters.php';
		require_once 'includes/license-settings.php';
		require_once 'includes/primary-settings.php';
		require_once 'includes/meta-settings.php';
		require_once 'includes/filter-settings.php';
		require_once 'includes/style-settings.php';
		require_once 'includes/structure-settings.php';
		require_once 'includes/language-settings.php';
		require_once 'includes/field-validation.php';
		require_once 'includes/class-bh-store-locator-system-info.php';

		// Set up settings defaults.
		$this->license_defaults      = BH_Store_Locator_Defaults::get_license_defaults();
		$this->primary_defaults      = BH_Store_Locator_Defaults::get_primary_defaults();
		$this->address_meta_defaults = BH_Store_Locator_Defaults::get_address_defaults();
		$this->filter_defaults       = BH_Store_Locator_Defaults::get_filter_defaults();
		$this->style_defaults        = BH_Store_Locator_Defaults::get_style_defaults();
		$this->structure_defaults    = BH_Store_Locator_Defaults::get_structure_defaults();
		$this->language_defaults     = BH_Store_Locator_Defaults::get_language_defaults();
		$this->wp_info               = BH_Store_Locator_Defaults::get_wp_info_defaults();

		// Get option values for use.
		$this->license_option_vals   = get_option( 'bh_storelocator_license_options', $this->license_defaults );
		$this->primary_option_vals   = get_option( 'bh_storelocator_primary_options', $this->primary_defaults );
		$this->address_option_vals   = get_option( 'bh_storelocator_meta_options', $this->address_meta_defaults );
		$this->filter_option_vals    = get_option( 'bh_storelocator_filter_options', $this->filter_defaults );
		$this->style_option_vals     = get_option( 'bh_storelocator_style_options', $this->style_defaults );
		$this->structure_option_vals = get_option( 'bh_storelocator_structure_options', $this->structure_defaults );
		$this->language_option_vals  = get_option( 'bh_storelocator_language_options', $this->language_defaults );

		$plugin_basename = plugin_basename( plugin_dir_path( __DIR__ ) . 'cardinal-locator.php' );
		$plugin_version  = get_option( 'bh_storelocator_version' );

		// EDD updater.
		$edd_updater = new BH_Store_Locator_Plugin_Updater(
			self::STORE_URL,
			$plugin_basename,
			array(
				'version'   => BH_Store_Locator::VERSION,
				'license'   => $this->license_option_vals['license_key'],
				'item_name' => self::PRODUCT_NAME,
				'author'    => 'Bjorn Holine',
				'url'       => home_url(),
			)
		);

		// Plugin updater.
		if ( BH_Store_Locator::VERSION !== $plugin_version ) {
			add_action( 'init', array( $this, 'bh_storelocator_updater' ) );
		}

		// Call $plugin_slug from public plugin class.
		$plugin            = BH_Store_Locator::get_instance();
		$this->plugin_slug = $plugin->get_plugin_slug();

		// Register new post type, taxonomy and post meta if option is selected.
		if ( 'locations' === $this->primary_option_vals['datasource'] ) {
			add_action( 'init', array( $this, 'bh_storelocator_flush_rewrites_check' ) );
		}

		// Flush rewrites if option is deselected for another data source.
		if ( 'locations' !== $this->primary_option_vals['datasource'] && post_type_exists( 'bh_sl_locations' ) ) {
			add_action( 'init', array( $this, 'bh_storelocator_flush_rewrites' ) );
		}

		// Load admin style sheet and JavaScript.
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_styles' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );

		// Admin notices.
		add_action( 'admin_notices', array( $this, 'bh_storelocator_geocode_error' ) );
		add_action( 'admin_notices', array( $this, 'bh_storelocator_geocode_missing_api_key' ) );
		add_action( 'admin_notices', array( $this, 'bh_storelocator_expired_license' ) );
		add_action( 'admin_notices', array( $this, 'bh_storelocator_missing_license' ) );

		// Add the options page and menu item.
		add_action( 'admin_menu', array( $this, 'add_plugin_admin_menu' ) );

		// Add an action link pointing to the options page.
		add_filter( 'plugin_action_links_' . $plugin_basename, array( $this, 'add_action_links' ) );

		// Define custom functionality.
		if ( ! empty( $GLOBALS['pagenow'] ) && ( 'options-general.php' === $GLOBALS['pagenow'] || 'options.php' === $GLOBALS['pagenow'] ) ) {
			add_action( 'admin_init', array( $this, 'bh_storelocator_register_settings' ) );
		}

		// Custom post type add, update or delete.
		if ( 'locations' === $this->primary_option_vals['datasource'] || 'cpt' === $this->primary_option_vals['datasource'] ) {
			add_action( 'save_post', array( $this, 'bh_storelocator_geocode_post_type' ), 99, 2 );
			add_action( 'save_post', array( $this, 'bh_storelocator_delete_transient' ) );
			add_action( 'before_delete_post', array( $this, 'bh_storelocator_delete_location' ) );
		}

		// Location category image field.
		if ( 'true' === $this->style_option_vals['loccatimgs'] ) {
			add_action( BH_Store_Locator::BH_SL_TAX . '_add_form_fields', array( $this, 'bh_storelocator_tax_meta' ), 10, 2 );

			// Location category edit image field.
			add_action( BH_Store_Locator::BH_SL_TAX . '_edit_form_fields', array( $this, 'bh_storelocator_edit_tax_meta' ), 10, 2 );

			// Location category save image fields.
			add_action( 'edited_' . BH_Store_Locator::BH_SL_TAX, array( $this, 'bh_storelocator_save_tax_meta' ), 10, 2 );
			add_action( 'create_' . BH_Store_Locator::BH_SL_TAX, array( $this, 'bh_storelocator_save_tax_meta' ), 10, 2 );
		}

		// License activation.
		add_action( 'wp_ajax_bh_storelocator_license_activate', array( $this, 'bh_storelocator_activate_license' ) );
		add_action( 'wp_ajax_nopriv_bh_storelocator_license_activate', array( $this, 'bh_storelocator_activate_license' ) );

		// License deactivation.
		add_action( 'wp_ajax_bh_storelocator_license_deactivate', array( $this, 'bh_storelocator_deactivate_license' ) );
		add_action( 'wp_ajax_nopriv_bh_storelocator_license_deactivate', array( $this, 'bh_storelocator_deactivate_license' ) );

		// License checks.
		add_action( 'init', array( $this, 'bh_storelocator_check_license' ) );
		add_action( 'current_screen', array( $this, 'bh_storelocator_admin_remove_license_transient' ) );
		add_action( 'in_plugin_update_message-' . $plugin_basename, array( $this, 'bh_storelocator_in_plugin_update_message' ), 10, 2 );

		// Save the plugin version number in the database.
		update_option( 'bh_storelocator_version', BH_Store_Locator::VERSION );

		// Add filter for lat/lng when using the WordPress Importer plugin.
		if ( class_exists( 'WP_Importer' ) ) {
			add_filter( 'wp_import_post_meta', array( $this, 'bh_storelocator_meta_import' ), 10, 3 );
		}

		// Delete the locations transient after the primary settings have been updated.
		add_action( 'update_option_bh_storelocator_primary_options', array( $this, 'bh_storelocator_delete_transient' ) );

		// Delete the remote data transients after the primary settings have been updated.
		if ( 'remoteurl' === $this->primary_option_vals['datasource'] ) {
			add_action( 'update_option_bh_storelocator_primary_options', array( $this, 'bh_storelocator_delete_remote_transients' ) );
		}

		// Add city column to locations edit page.
		add_filter( 'manage_posts_columns', array( $this, 'bh_storelocator_city_column' ), 5, 2 );

		// Add city value to city column on locations edit page.
		add_action( 'manage_posts_custom_column', array( $this, 'bh_storelocator_city_column_content' ), 5, 2 );

		// Location preview meta box.
		add_action( 'add_meta_boxes', array( $this, 'add_preview_meta_box' ) );

		// Coordinate update on manual map override.
		add_action( 'wp_ajax_bh_storelocator_post_meta_coords_update', array( $this, 'bh_storelocator_post_meta_coords_update' ) );
		add_action( 'wp_ajax_nopriv_bh_storelocator_post_meta_coords_update', array( $this, 'bh_storelocator_post_meta_coords_update' ) );

		// Add plugin icons.
		add_filter( 'csl_add_plugin_icons', array( $this, 'bh_store_locator_edd_add_plugin_icons' ) );
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
	 * Register and enqueue admin-specific style sheet.
	 *
	 * @return null|void Return early if no settings page is registered.
	 */
	public function enqueue_admin_styles() {

		if ( ! isset( $this->plugin_screen_hook_suffix ) ) {
			return;
		}

		// Settings page.
		$screen = get_current_screen();
		if ( $this->plugin_screen_hook_suffix === $screen->id || BH_Store_Locator::BH_SL_TAX === $screen->taxonomy ) {
			wp_enqueue_style( 'wp-color-picker' );
		}

		wp_enqueue_style( $this->plugin_slug . '-admin-styles', plugins_url( 'assets/css/admin-min.css', __FILE__ ), array(), BH_Store_Locator::VERSION );

	}

	/**
	 * Register and enqueue admin-specific JavaScript.
	 *
	 * @return null Return early if no settings page is registered.
	 */
	public function enqueue_admin_scripts() {

		if ( ! isset( $this->plugin_screen_hook_suffix ) ) {
			return;
		}

		$admin_info = array();

		// Location post settings.
		if ( ( BH_Store_Locator::BH_SL_CPT === get_post_type() ) || ( 'cpt' === $this->primary_option_vals['datasource'] ) ) {
			global $post;
			$post_id                  = false;
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

			// Build query string if params are set.
			if ( count( $maps_query_string_params ) > 0 ) {
				$maps_query_string = '?' . http_build_query( $maps_query_string_params );
			}

			// Single admin post scripts.
			if ( is_object( $post ) ) {
				// Google Maps.
				wp_enqueue_script( 'google-maps', 'https://maps.google.com/maps/api/js' . $maps_query_string, array(), '1.0.0', true );

				// AJAX nonce and admin-ajax.
				$admin_post_info = array(
					'admin_ajax'      => admin_url( 'admin-ajax.php' ),
					'post_meta_nonce' => wp_create_nonce( 'bh_storelocator_location_meta' ),
					'post_id'         => $post_id,
				);

				// Post admin scripts.
				wp_enqueue_script( $this->plugin_slug . '-post-script', plugins_url( 'assets/js/post-min.js', __FILE__ ), array( 'jquery', 'google-maps' ), BH_Store_Locator::VERSION );
				wp_localize_script( $this->plugin_slug . '-post-script', 'bhStoreLocatorAdminPost', $admin_post_info );
			}
		}

		// Settings page.
		$screen = get_current_screen();
		if ( $this->plugin_screen_hook_suffix === $screen->id || BH_Store_Locator::BH_SL_TAX === $screen->taxonomy ) {
			// Make sure media uploader scripts are loaded.
			wp_enqueue_script( 'media-upload' );
			wp_enqueue_script( 'thickbox' );
			wp_enqueue_style( 'thickbox' );

			// Color picker.
			wp_enqueue_script( 'wp-color-picker' );

			// Admin scripts.
			wp_enqueue_script( $this->plugin_slug . '-admin-script', plugins_url( 'assets/js/admin-min.js', __FILE__ ), array( 'jquery' ), BH_Store_Locator::VERSION );

			// AJAX nonce and admin-ajax.
			$admin_info = array(
				'activate_nonce'   => wp_create_nonce( 'bh_storelocator_activate_license' ),
				'deactivate_nonce' => wp_create_nonce( 'bh_storelocator_deactivate_license' ),
				'admin_ajax'       => admin_url( 'admin-ajax.php' ),
				'loading_icon'     => admin_url() . 'images/loading.gif',
				'license_status'   => get_option( 'bh_storelocator_license_status' ),
				'activate_text'    => __( 'Activate', 'bh-storelocator' ),
				'deactivate_text'  => __( 'Deactivate', 'bh-storelocator' ),
				'invalid_text'     => __( 'Invalid license. Please email support@cardinalwp.com with your license key if you believe you have received this message in error.', 'bh-storelocator' ),
			);

			// Need to pass some admin settings.
			wp_localize_script( $this->plugin_slug . '-admin-script', 'bhStoreLocatorFilterSettings', $this->filter_option_vals );
			wp_localize_script( $this->plugin_slug . '-admin-script', 'bhStoreLocatorAdminInfo', $admin_info );
		}

	}

	/**
	 * Register the administration menu for this plugin into the WordPress Dashboard menu.
	 */
	public function add_plugin_admin_menu() {

		// Add a settings page for this plugin to the Settings menu.
		$this->plugin_screen_hook_suffix = add_options_page(
			__( 'Cardinal Locator', 'bh-storelocator' ),
			__( 'Cardinal Locator', 'bh-storelocator' ),
			'manage_options',
			$this->plugin_slug,
			array( $this, 'display_plugin_admin_page' )
		);

	}

	/**
	 * Render the settings page for this plugin.
	 */
	public function display_plugin_admin_page() {
		include_once 'views/admin.php';
	}

	/**
	 * Add settings action link to the plugins page.
	 *
	 * @param array $links Settings action link.
	 *
	 * @return array
	 */
	public function add_action_links( $links ) {

		return array_merge(
			array(
				'settings' => '<a href="' . admin_url( 'options-general.php?page=' . $this->plugin_slug ) . '">' . __( 'Settings', 'bh-storelocator' ) . '</a>',
			),
			$links
		);

	}

	/**
	 * Custom plugin updates
	 */
	public function bh_storelocator_updater() {

		// Check for custom database table and create if it doesn't exist.
		$this->bh_storelocator_check_db_table();

	}

	/**
	 * Check to see if the custom database table exists
	 */
	public function bh_storelocator_check_db_table() {
		global $wpdb;
		$table_name = $wpdb->prefix . 'cardinal_locator_coords';

		$results = $wpdb->get_results( $wpdb->prepare( "SHOW TABLES LIKE %s", $table_name ) );
		$table_exists = count( $results ) > 0;

		if ( false === $table_exists ) {
			bh_storelocator_create_db_table();
		}
	}

	/**
	 * Admin settings pages
	 */
	public function bh_storelocator_register_settings() {
		bh_storelocator_license_plugin_settings( $this->license_defaults );
		bh_storelocator_primary_plugin_settings( $this->primary_defaults );
		bh_storelocator_address_plugin_settings( $this->address_meta_defaults );
		bh_storelocator_filter_plugin_settings( $this->filter_defaults );
		bh_storelocator_style_plugin_settings( $this->style_defaults );
		bh_storelocator_structure_plugin_settings( $this->structure_defaults );
		bh_storelocator_language_plugin_settings( $this->language_defaults );
	}

	/**
	 * Manipulate the plugin data to include the plugin icon (workaround).
	 *
	 * @param object $plugin_data Plugin update data transient.
	 *
	 * @return object modified plugin data
	 */
	public function bh_store_locator_edd_add_plugin_icons( $plugin_data ) {
		if ( 'object' !== gettype( $plugin_data ) ) {
			return $plugin_data;
		}

		$plugin_data->icons = array(
			'2x' => trailingslashit( $this->wp_info['plugin_path'] ) . 'admin/assets/img/icon-256x256.png',
		);

		return $plugin_data;
	}

	/**
	 * Delete the locations transient when a location is added or updated.
	 */
	public function bh_storelocator_delete_transient() {
		// Check for the transient and delete it if it's set.
		$locations_transient = get_transient( 'bh_sl_locations' );

		if ( ! empty( $locations_transient ) ) {
			delete_transient( 'bh_sl_locations' );
		}
	}

	/**
	 * Delete the remote location data transients when the primary settings are updated.
	 */
	public function bh_storelocator_delete_remote_transients() {
		// Check for the transient and delete it if it's set.
		$remote_data_transient = get_transient( 'bh_sl_remote_location_data' );

		if ( ! empty( $remote_data_transient ) ) {
			delete_transient( 'bh_sl_remote_location_data' );
		}
	}

	/**
	 * Delete the entry from custom database table
	 *
	 * @param integer $post_id ID of the post being deleted.
	 */
	public function bh_storelocator_delete_location( $post_id ) {
		global $post_type, $wpdb;
		$table_name = $wpdb->prefix . 'cardinal_locator_coords';

		if ( ( BH_Store_Locator::BH_SL_CPT !== $post_type ) && ( 'cpt' !== $this->primary_option_vals['datasource'] ) ) {
			return;
		}

		// Delete entry from custom table query.
		$wpdb->query( $wpdb->prepare("DELETE
					FROM $table_name
					WHERE id = %d",
			$post_id
		));
	}

	/**
	 * Add lat/lng post meta
	 *
	 * @param integer $post_id Post ID.
	 * @param string  $address Address.
	 * @param string  $region Country code.
	 * @param string  $components Component restrictions filter.
	 */
	public function bh_storelocator_latlng_meta( $post_id, $address, $region = '', $components = '' ) {
		// Geocode the address.
		if ( isset( $address ) && ! empty( $address ) ) {
			$location_data = $this->bh_storelocator_geocode_address( $address, $region, $components );

			// Get the latitude and longitude from the JSON data.
			if ( isset( $location_data ) ) {
				if ( isset( $location_data['results'][0]['geometry']['location']['lat'] ) ) {
					$new_lat = $location_data['results'][0]['geometry']['location']['lat'];
				}
				if ( isset( $location_data['results'][0]['geometry']['location']['lng'] ) ) {
					$new_lng = $location_data['results'][0]['geometry']['location']['lng'];
				}
				if ( isset( $location_data['results'][0]['place_id'] ) ) {
					$place_id = $location_data['results'][0]['place_id'];
				}

				// Add or update post meta with the coordinates.
				if ( isset( $new_lat ) ) {
					update_post_meta( $post_id, 'bh_storelocator_location_lat', $new_lat );
				}
				if ( isset( $new_lng ) ) {
					update_post_meta( $post_id, 'bh_storelocator_location_lng', $new_lng );
				}
				if ( isset( $place_id ) ) {
					update_post_meta( $post_id, 'bh_storelocator_location_placeid', $place_id );
				}

				// Also add coordinates to a custom table.
				if ( isset( $new_lat ) && isset( $new_lng ) ) {
					$this->bh_storelocator_latlng_db( $post_id, $new_lat, $new_lng );
				}

				// Check for no results.
				if ( 'ZERO_RESULTS' === $location_data['status'] ) {
					add_filter( 'redirect_post_location', array( $this, 'bh_storelocator_notice_query_var' ), 99 );
				}

				// Check for no API key.
				if ( 'MISSING_KEY' === $location_data['status'] ) {
					add_filter( 'redirect_post_location', array( $this, 'bh_storelocator_notice_missing_key_query_var' ), 99 );
				}

				// Check for other error.
				if ( 'ERROR' === $location_data['status'] ) {

					if ( isset( $location_data['error'] ) ) {
						$this->geocode_error = $location_data['error'];
					}

					add_filter( 'redirect_post_location', array( $this, 'bh_storelocator_notice_geocode_error_query_var' ), 99 );
				}
			}
		}
	}

	/**
	 * Add lat/lng to the custom table
	 *
	 * @param integer $post_id Post ID.
	 * @param float   $lat     Latitude.
	 * @param float   $lng     Longitude.
	 */
	public function bh_storelocator_latlng_db( $post_id, $lat, $lng ) {
		global $wpdb;
		$table_name = $wpdb->prefix . 'cardinal_locator_coords';

		// Insert into custom table.
		$wpdb->query( $wpdb->prepare("INSERT IGNORE
					INTO $table_name
					( id, lat, lng )
					VALUES ( %d, %f, %f )
					ON DUPLICATE KEY UPDATE lat = %f, lng = %f",
			$post_id,
			$lat,
			$lng,
			$lat,
			$lng
		));
	}

	/**
	 * Add query argument if there's a geocoding error so an error can be displayed.
	 *
	 * @param string $location URL.
	 *
	 * @return string
	 */
	public function bh_storelocator_notice_query_var( $location ) {
		remove_filter( 'redirect_post_location', array( $this, 'bh_storelocator_notice_query_var' ), 99 );
		return add_query_arg(
			array(
				'geocode_error' => rawurlencode( 'true' ),
			),
			$location
		);
	}

	/**
	 * Add query argument if Google API key is missing.
	 *
	 * @param string $location URL.
	 *
	 * @return string
	 */
	public function bh_storelocator_notice_missing_key_query_var( $location ) {
		remove_filter( 'redirect_post_location', array( $this, 'bh_storelocator_notice_missing_key_query_var' ), 99 );
		return add_query_arg(
			array(
				'missing_key' => rawurlencode( 'true' ),
			),
			$location
		);
	}

	/**
	 * Add query argument if there's a geocoding error so an error can be displayed.
	 *
	 * @param string $location URL.
	 *
	 * @return string
	 */
	public function bh_storelocator_notice_geocode_error_query_var( $location ) {
		remove_filter( 'redirect_post_location', array( $this, 'bh_storelocator_notice_geocode_error_query_var' ), 99 );
		return add_query_arg(
			array(
				'geocode_error'   => rawurlencode( 'true' ),
				'geocode_message' => rawurlencode( $this->geocode_error ),
			),
			$location
		);
	}

	/**
	 * Adds error notice when geocoding of custom post type is unsuccessful.
	 */
	public function bh_storelocator_geocode_error() {
		$geocode_error_param   = filter_input( INPUT_GET, 'geocode_error', FILTER_SANITIZE_STRING );
		$geocode_error_message = filter_input( INPUT_GET, 'geocode_message', FILTER_SANITIZE_STRING );

		if ( ! isset( $geocode_error_param ) ) {
			return;
		}

		if ( 'true' === $geocode_error_param ) {
			echo '<div class="notice error is-dismissible"><p>';

			if ( isset( $geocode_error_message ) ) {
				$geocode_error = $geocode_error_message;
			} else {
				$geocode_error = sprintf(
					__( 'Geocoding was unsuccessful. Please check the address on <a target="%s" href="%s" rel="%s">Google Maps</a> or enter more address information.', 'bh-storelocator' ),
					'_blank',
					'https://www.google.com/maps',
					'noopener noreferrer'
				);
			}

			echo wp_kses(
				$geocode_error,
				array(
					'a' => array(
						'target' => array(),
						'href'   => array(),
						'rel'    => array(),
					),
				)
			);
			echo '</p></div>';
		}
	}

	/**
	 * Added error notice when geocoding fails because of a missing API key.
	 */
	public function bh_storelocator_geocode_missing_api_key() {
		$geocode_error_param = filter_input( INPUT_GET, 'missing_key', FILTER_SANITIZE_STRING );

		if ( ! isset( $geocode_error_param ) ) {
			return;
		}

		if ( 'true' === $geocode_error_param ) {
			echo '<div class="notice error is-dismissible"><p>';
			$geocode_error = sprintf(
				__( 'Geocoding was unsuccessful. Your Google Maps API key is not set. Please set it under the <a href="%s" rel="%s">Primary Settings tab</a>.', 'bh-storelocator' ),
				trailingslashit( get_admin_url() ) . 'options-general.php?page=' . esc_html( $this->plugin_slug ) . '&tab=primary_settings',
				'noopener noreferrer'
			);
			echo wp_kses(
				$geocode_error,
				array(
					'a' => array(
						'target' => array(),
						'href'   => array(),
						'rel'    => array(),
					),
				)
			);
			echo '</p></div>';
		}
	}

	/**
	 * Adds error notice when geocoding of custom post type is unsuccessful.
	 */
	public function bh_storelocator_expired_license() {

		// Don't do anything if the license field is empty.
		if ( empty( $this->license_option_vals['license_key'] ) ) {
			return;
		}

		// Get license status transient.
		$license_transient = get_transient( 'bh_sl_license_status' );

		if ( 'valid' === $license_transient ) {
			return;
		}

		if ( 'inactive' !== $license_transient ) {

			echo '<div class="notice error"><p>';
			$geocode_error = sprintf(
				__( '<strong>License Error:</strong> Your Cardinal Store Locator license is %s. Please <a target="%s" href="%s" rel="%s">log in to your account</a> to fix this issue in order to receive updates.', 'bh-storelocator' ),
				$license_transient,
				'_blank',
				'https://cardinalwp.com/login/',
				'noopener noreferrer'
			);

			echo wp_kses(
				$geocode_error,
				array(
					'a'      => array(
						'target' => array(),
						'href'   => array(),
						'rel'    => array(),
					),
					'strong' => array(),
				)
			);

			echo '</p></div>';
		}
	}

	/**
	 * Display a notice if the plugin license hasn't been set.
	 */
	public function bh_storelocator_missing_license() {

		if ( empty( $this->license_option_vals['license_key'] ) ) {

			echo '<div class="notice notice-warning"><p>';
			$geocode_error = sprintf(
				__( 'Please set your <a href="%s" rel="%s">Cardinal Store Locator license</a>.', 'bh-storelocator' ),
				trailingslashit( get_admin_url() ) . 'options-general.php?page=' . esc_html( $this->plugin_slug ) . '&tab=license_settings',
				'noopener noreferrer'
			);

			echo wp_kses(
				$geocode_error,
				array(
					'a'      => array(
						'href' => array(),
						'rel'  => array(),
					),
					'strong' => array(),
				)
			);

			echo '</p></div>';
		}
	}

	/**
	 * Google geocode request
	 *
	 * @param string $address Address.
	 * @param string $region Two letter country code.
	 * @param string $components Component filtering parameters.
	 *
	 * @return array|mixed|null
	 */
	public function bh_storelocator_geocode_address( $address, $region = '', $components = '' ) {

		// Check for Google Geocoding API key and fall back to the front-end key if nothign is set.
		if ( isset( $this->primary_option_vals['apikey_backend'] ) && ! empty( $this->primary_option_vals['apikey_backend'] ) ) {
			$maps_key = $this->primary_option_vals['apikey_backend'];
		} elseif ( isset( $this->primary_option_vals['apikey'] ) && ! empty( $this->primary_option_vals['apikey'] ) ) {
			$maps_key = $this->primary_option_vals['apikey'];
		} else {
			$maps_key = '';
		}

		$geocode_data  = wp_safe_remote_get( 'https://maps.googleapis.com/maps/api/geocode/json?key=' . $maps_key . '&address=' . rawurlencode( $address ) . $region . $components );
		$response_body = json_decode( wp_remote_retrieve_body( $geocode_data ), true );

		if ( is_wp_error( $geocode_data ) ) {
			$location_data['status'] = 'ERROR';
			$location_data['error']  = $geocode_data->get_error_message();
		} elseif ( empty( $maps_key ) ) {
			$location_data['status'] = 'MISSING_KEY';

			if ( isset( $response_body['error_message'] ) ) {
				$location_data['error'] = $response_body['error_message'];
			}
		} elseif ( isset( $response_body['status'] ) && 'OK' !== $response_body['status'] ) {
			if ( 'ZERO_RESULTS' === $response_body['status'] ) {
				$location_data['status'] = $response_body['status'];
			} else {
				$location_data['status'] = 'ERROR';
			}

			if ( isset( $response_body['error_message'] ) ) {
				$location_data['error'] = $response_body['error_message'];
			}
		} else {
			$location_data = $response_body;
		}

		return $location_data;
	}

	/**
	 * Geocode custom post type locations
	 *
	 * @param integer $post_id Post ID.
	 * @param array   $post Post array.
	 */
	public function bh_storelocator_geocode_post_type( $post_id, $post ) {
		if ( ! isset( $post->post_type ) ) {
			return;
		}

		$primary_options = get_option( 'bh_storelocator_primary_options' );

		// Check to see if current post type is equal to the option set in the locator settings.
		if ( 'cpt' === $primary_options['datasource'] && $post->post_type === $primary_options['posttype'] ) {
			$address            = '';
			$address_options    = get_option( 'bh_storelocator_meta_options' );
			$address_parameters = array(
				'address',
				'address_2',
				'city',
				'state',
				'postal',
			);

			// Check for multiple address fields or just 1 in the settings.
			if ( ! empty( $address_options['address'] ) && ! empty( $address_options['city'] ) ) {
				$address_components = array();
				foreach ( $address_options as $address_option => $value ) {
					if ( 'country' !== $address_option && ! empty( $value ) && in_array( $address_option, $address_parameters, true ) ) {
						// Get the custom meta values from the keys set in the Address Meta Settings.
						array_push( $address_components, get_post_meta( $post_id, $value, true ) );
					}
				}
				$address = trim( implode( ' ', $address_components ) );
			} elseif ( ! empty( $address_options['address'] ) ) {
				$address = $address_options['address'];
			}

			// Create a region variable for the region biasing parameter.
			$region = '';
			if ( ! empty( $address_options['country'] ) ) {
				$region = '&region=' . get_post_meta( $post_id, $address_options['country'], true );
			}

			// Set up a components restriction filter parameter.
			$components = '';
			if ( ! empty( $address_options['country'] ) ) {
				$components = '&components=country:' . get_post_meta( $post_id, $address_options['country'], true );
			}

			// Do the geocoding and add the post meta.
			$this->bh_storelocator_latlng_meta( $post_id, $address, $region, $components );
		} elseif ( BH_Store_Locator::BH_SL_CPT === $post->post_type ) {
			$street_address     = get_post_meta( $post_id, '_bh_sl_address' );
			$street_address_two = get_post_meta( $post_id, '_bh_sl_address_two' );
			$city               = get_post_meta( $post_id, '_bh_sl_city' );
			$state              = get_post_meta( $post_id, '_bh_sl_state' );
			$postal             = get_post_meta( $post_id, '_bh_sl_postal' );
			$country            = get_post_meta( $post_id, '_bh_sl_country', true );

			$address_components = array_merge( $street_address, $street_address_two, $city, $state, $postal );
			$address            = implode( ' ', $address_components );

			// Create a region variable for the region biasing parameter.
			$region = '';
			if ( '' !== $country ) {
				$region = '&region=' . $country;
			}

			// Set up a components restriction filter parameter.
			$components = '';
			if ( ! empty( $country ) ) {
				$components = '&components=country:' . $country;
			}

			// Do the geocoding and add the post meta.
			$this->bh_storelocator_latlng_meta( $post_id, $address, $region, $components );
		}
	}

	/**
	 * Flush rewrite rules when locations is selected the first time
	 */
	public function bh_storelocator_flush_rewrites_check() {
		// Flush rewrites if the option is selected for the first time.
		if ( ! post_type_exists( 'bh_sl_locations' ) ) {
			flush_rewrite_rules();
		}
	}

	/**
	 * Flush rewrite rules
	 */
	public function bh_storelocator_flush_rewrites() {
		// Flush rewrites if the option is selected for the first time.
		flush_rewrite_rules();
	}

	/**
	 * Add taxonomy image fields if the taxonomy is active.
	 */
	public function bh_storelocator_tax_meta() {
		$input_id      = 'catimage';
		$img_args      = array(
			'option_name' => 'bh_sl_cat_tax',
			'name'        => $input_id,
			'id'          => $input_id,
			'value'       => '',
		);
		$cat_img_label = __( 'Category image', 'bh-storelocator' );
		$cat_img_desc  = __( 'Custom category image for map.', 'bh-storelocator' );

		echo '<div class="form-field">';
		echo '<label for="term_meta[' . esc_html( $input_id ) . ']">' . esc_html( $cat_img_label ) . '</label>';

		printf(
			'<input type="text" name="%1$s[%2$s]" id="%3$s" value="%4$s">',
			esc_html( $img_args['option_name'] ),
			esc_html( $img_args['name'] ),
			esc_html( $img_args['id'] ),
			esc_html( $img_args['value'] )
		);

		printf(
			'<input class="upload-img-btn" type="button" value="Upload Image">'
		);

		echo '<p class="description">' . esc_html( $cat_img_desc ) . '</p>';
		echo '</div>';
	}

	/**
	 * Add taxonomy image fields to term edit screen.
	 *
	 * @param object $term Taxonomy term object.
	 */
	public function bh_storelocator_edit_tax_meta( $term ) {
		$input_id      = 'catimage';
		$term_id       = $term->term_id;
		$option_name   = 'bh_sl_cat_tax';
		$cat_img_label = __( 'Category image', 'bh-storelocator' );
		$cat_img_desc  = __( 'Custom category image for map.', 'bh-storelocator' );
		$cat_img_value = '';

		// Check for an existing value.
		$cat_img_value = get_option( $input_id . '_' . $term_id );

		$img_args = array(
			'option_name' => $option_name,
			'name'        => $input_id,
			'id'          => $input_id,
			'value'       => ( $cat_img_value[ $input_id ] ) ? $cat_img_value[ $input_id ] : '',
		);

		echo '<tr class="form-field">';
		echo '<th scope="row" valign="top"><label for="' . esc_html( $img_args['option_name'] ) . '[' . esc_html( $img_args['name'] ) . ']">' . esc_html( $cat_img_label ) . '</label></th>';
		echo '<td>';

		printf(
			'<input type="text" name="%1$s[%2$s]" id="%3$s" value="%4$s">',
			esc_html( $img_args['option_name'] ),
			esc_html( $img_args['name'] ),
			esc_html( $img_args['id'] ),
			esc_html( $img_args['value'] )
		);

		printf(
			'<input class="upload-img-btn" type="button" value="Upload Image">'
		);

		echo '<p class="description">' . esc_html( $cat_img_desc ) . '</p>';
		echo '</td>';
		echo '</tr>';
	}

	/**
	 * Save custom taxonomy fields
	 *
	 * @param integer $term_id Term ID.
	 */
	public function bh_storelocator_save_tax_meta( $term_id ) {
		$input_id       = 'catimage';
		$post_term_meta = filter_input( INPUT_POST, 'bh_sl_cat_tax', FILTER_SANITIZE_STRING, FILTER_REQUIRE_ARRAY );

		if ( isset( $post_term_meta ) ) {
			$term_meta = get_option( $input_id . '_' . $term_id );
			$cat_keys  = array_keys( $post_term_meta );
			foreach ( $cat_keys as $key ) {
				if ( isset( $post_term_meta[ $key ] ) ) {
					$term_meta[ $key ] = $post_term_meta[ $key ];
				}
			}

			// Save the option array.
			update_option( $input_id . '_' . $term_id, $term_meta );
		}
	}

	/**
	 * Activate license
	 */
	public function bh_storelocator_activate_license() {
		// Check the referrer for security.
		check_ajax_referer( 'bh_storelocator_activate_license', 'security' );
		$license = filter_input( INPUT_POST, 'bh_sl_license', FILTER_SANITIZE_STRING );

		// Data to send in our API request.
		$api_params = array(
			'edd_action' => 'activate_license',
			'license'    => $license,
			'item_name'  => urlencode( self::PRODUCT_NAME ),
			'url'        => home_url(),
		);

		// Call the custom API.
		$response = wp_remote_post( self::STORE_URL, array( 'timeout' => 15, 'sslverify' => false, 'body' => $api_params ) );

		// Make sure the response came back okay.
		if ( is_wp_error( $response ) ) {
			return false;
		}

		// Decode the license data.
		$license_data = json_decode( wp_remote_retrieve_body( $response ) );

		// Set a license status option.
		update_option( 'bh_storelocator_license_status', $license_data->license );

		wp_send_json_success(
			array(
				'script_response' => $license_data->license,
			)
		);
	}

	/**
	 * Deactivate license
	 */
	public function bh_storelocator_deactivate_license() {
		// Check the referrer for security.
		check_ajax_referer( 'bh_storelocator_deactivate_license', 'security' );

		// Retrieve the license from the database.
		$license = trim( $this->license_option_vals['license_key'] );

		// Data to send in our API request.
		$api_params = array(
			'edd_action' => 'deactivate_license',
			'license'    => $license,
			'item_name'  => urlencode( self::PRODUCT_NAME ),
			'url'        => home_url(),
		);

		// Call the custom API.
		$response = wp_remote_post( self::STORE_URL, array( 'timeout' => 15, 'sslverify' => false, 'body' => $api_params ) );

		// Make sure the response came back okay.
		if ( is_wp_error( $response ) ) {
			return false;
		}

		// Decode the license data.
		$license_data = json_decode( wp_remote_retrieve_body( $response ) );

		// Deactivate.
		if ( 'deactivated' === $license_data->license ) {
			delete_option( 'bh_storelocator_license_status' );
			wp_send_json_success( array(
				'script_response' => 'deactivated',
			));
		}
	}

	/**
	 * /**
	 * Check license status once a month and avoid activation issues after URL change.
	 *
	 * @return bool|void
	 */
	public function bh_storelocator_check_license() {
		$license_transient = 'bh_sl_license_status';

		// Don't do anything if the license field is empty.
		if ( empty( $this->license_option_vals['license_key'] ) ) {
			return;
		}

		// Get license status and set it to a transient.
		if ( false === ( $license_status_transient = get_transient( $license_transient ) ) ) {

			// Retrieve the license from the database.
			$license = trim( $this->license_option_vals['license_key'] );

			// Data to send in our API request.
			$api_params = array(
				'edd_action' => 'check_license',
				'license'    => $license,
				'item_name'  => urlencode( self::PRODUCT_NAME ),
				'url'        => home_url(),
			);

			// Call the custom API.
			$response = wp_remote_post( self::STORE_URL, array( 'timeout' => 15, 'sslverify' => false, 'body' => $api_params ) );

			// Make sure the response came back okay.
			if ( is_wp_error( $response ) ) {
				return false;
			}

			// Decode the license data.
			$license_data = json_decode( wp_remote_retrieve_body( $response ) );

			// Set a license status variable.
			if ( is_object( $license_data ) && 'valid' === $license_data->license ) {
				// Store the status in a transient that expires in 30 days.
				set_transient( $license_transient, 'valid', 30 * DAY_IN_SECONDS );
			} elseif ( is_object( $license_data ) && property_exists( $license_data, 'license' ) ) {
				// Deactivate.
				delete_option( 'bh_storelocator_license_status' );

				// Store the status in a transient that expires in 30 days.
				set_transient( $license_transient, $license_data->license, 30 * DAY_IN_SECONDS );
			} else {
				// Deactivate.
				delete_option( 'bh_storelocator_license_status' );

				// Store the status in a transient that expires in 30 days.
				set_transient( $license_transient, 'invalid', 30 * DAY_IN_SECONDS );
			}
		}
	}

	/**
	 * Remove license status transient when plugins/updates page is viewed.
	 */
	public function bh_storelocator_admin_remove_license_transient() {
		$current_screen = get_current_screen();

		if ( gettype( $current_screen ) !== 'object' || ! property_exists( $current_screen, 'base' ) ) {
			return;
		}

		if ( 'plugins' === $current_screen->base || 'updates-core' === $current_screen->base ) {
			if ( false !== get_transient( 'bh_sl_license_status' ) ) {
				delete_transient( 'bh_sl_license_status' );
			}

			$this->bh_storelocator_check_license();
		}
	}

	/**
	 * Add extra messaging for invalid/expired licences.
	 *
	 * @param array  $plugin_data Plugin information.
	 * @param object $response Latest plugin information.
	 */
	public function bh_storelocator_in_plugin_update_message( $plugin_data, $response ) {

		// Don't do anything if the license field is empty.
		if ( empty( $this->license_option_vals['license_key'] ) ) {
			return;
		}

		// Get license status transient.
		$license_transient = get_transient( 'bh_sl_license_status' );

		if ( 'valid' === $license_transient ) {
			return;
		}

		echo '<br>';
		if ( 'inactive' === $license_transient ) {
			$license_error = sprintf( __( '<strong>License Inactive:</strong> Your license is not activated for this site. Please activate your license by visiting the <a href="%s">License Settings</a>.', 'bh-storelocator' ), admin_url( 'options-general.php?page=bh-storelocator&tab=license_settings' ) );
		} else {
			$license_error = sprintf( __( '<strong>License Error:</strong> Your license for Cardinal Store Locator is %s. Please <a target="%s" href="%s" rel="%s">log in to your account</a> to fix this issue in order to receive updates.', 'bh-storelocator' ), $license_transient, '_blank', 'https://cardinalwp.com/login/', 'noopener noreferrer' );
		}

		echo wp_kses( $license_error, array( 'strong' => array(), 'a' => array( 'target' => array(), 'href' => array(), 'rel' => array() ) ) );
	}

	/**
	 * Insert coordinates to the database when using WordPress Importer plugin if they are present
	 *
	 * @param array   $post_meta Post meta.
	 * @param integer $post_id Post ID.
	 * @param array   $post Post attributes.
	 * @return mixed
	 */
	public function bh_storelocator_meta_import( $post_meta, $post_id, $post ) {
		$location_coords = array();
		$lat             = '';
		$lng             = '';

		// Loop over the meta keys.
		foreach ( $post_meta as $meta ) {
			if ( 'bh_storelocator_location_lat' === $meta['key'] ) {
				$lat = $meta['value'];
			}

			if ( 'bh_storelocator_location_lng' === $meta['key'] ) {
				$lng = $meta['value'];
			}

			if ( is_numeric( $lat ) && is_numeric( $lng ) && is_integer( $post_id ) ) {
				array_push( $location_coords, array( $post_id, $lat, $lng ) );
			}
		}

		// Send for insertion.
		if ( count( $location_coords ) > 0 ) {
			bh_storelocator_bg_process_insert( $location_coords );
		}

		return $post_meta;
	}

	/**
	 * Add city column to edit locations pages.
	 *
	 * @param array  $posts_columns An array of column names.
	 * @param string $post_type     The post type slug.
	 *
	 * @return mixed
	 */
	public function bh_storelocator_city_column( $posts_columns, $post_type ) {
		if ( ( BH_Store_Locator::BH_SL_CPT !== $post_type ) && ( 'cpt' !== $this->primary_option_vals['datasource'] ) ) {
			return $posts_columns;
		}

		$new_post_cols = array();

		foreach ( $posts_columns as $key => $title ) {
			if ( 'author' === $key ) {
				$new_post_cols['city'] = __( 'City', 'bh-storelocator' );
			}

			$new_post_cols[ $key ] = $title;
		}

		$posts_columns = $new_post_cols;

		return $posts_columns;
	}

	/**
	 * Add city value to city column of edit locations pages.
	 *
	 * @param string $column_name The name of the column to display.
	 * @param int    $post_id     The current post ID.
	 */
	public function bh_storelocator_city_column_content( $column_name, $post_id ) {
		if ( ( BH_Store_Locator::BH_SL_CPT !== get_post_type( $post_id ) ) && ( 'cpt' !== $this->primary_option_vals['datasource'] ) ) {
			return;
		}

		if ( 'city' === $column_name ) {
			$city_val = get_post_meta( $post_id, '_bh_sl_city', true );

			// Check for mapped meta value.
			if ( 'cpt' === $this->primary_option_vals['datasource'] ) {
				$city_meta = get_post_meta( $post_id, $this->address_option_vals['city'], true );

				if ( $city_meta ) {
					$city_val = $city_meta;
				}
			}

			if ( ! empty( $city_val ) ) {
				echo esc_html( $city_val );
			}
		}
	}

	/**
	 * AJAX update coordinates after marker in Location Preview meta box has been dragged to a new location.
	 */
	public function bh_storelocator_post_meta_coords_update() {
		// Check the referrer for security.
		check_ajax_referer( 'bh_storelocator_location_meta', 'security' );

		$lat     = filter_input( INPUT_POST, 'lat', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION );
		$lng     = filter_input( INPUT_POST, 'lng', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION );
		$post_id = filter_input( INPUT_POST, 'post_id', FILTER_SANITIZE_NUMBER_INT );

		// Add coordinate override meta field with coordinate values.
		if ( isset( $lat ) ) {
			update_post_meta( $post_id, 'latitude', $lat );
		}
		if ( isset( $lng ) ) {
			update_post_meta( $post_id, 'longitude', $lng );
		}
	}

	/**
	 * Adds the map preview meta box container.
	 *
	 * @param string $post_type Post type.
	 */
	public function add_preview_meta_box( $post_type ) {
		// Limit meta box to locations post type.
		if ( 'cpt' === $this->primary_option_vals['datasource'] ) {
			$post_types = array( $this->primary_option_vals['posttype'] );
		} else {
			$post_types = array( 'bh_sl_locations' );
		}

		if ( in_array( $post_type, $post_types, true ) ) {
			add_meta_box(
				'map_preview_meta_box',
				__( 'Location Preview', 'bh-storelocator' ),
				array( $this, 'render_preview_meta_box_content' ),
				$post_type,
				'side'
			);
		}
	}

	/**
	 * Displays a preview of the location on a map if the coordinates are set.
	 *
	 * @param WP_Post $post The post object.
	 */
	public function render_preview_meta_box_content( $post ) {
		$post_meta = get_post_meta( $post->ID );

		// Check for existing coordinates.
		if ( empty( $post_meta ) ||
		     ! array_key_exists( 'bh_storelocator_location_lat', $post_meta ) ||
		     ! array_key_exists( 'bh_storelocator_location_lng', $post_meta ) ||
		     ! is_array( $post_meta['bh_storelocator_location_lat'] ) ||
		     ! is_array( $post_meta['bh_storelocator_location_lng'] ) ) {
			return;
		}

		$lat = $post_meta['bh_storelocator_location_lat'][0];
		$lng = $post_meta['bh_storelocator_location_lng'][0];

		// Check for mapped meta values with other custom post type.
		if ( 'cpt' === $this->primary_option_vals['datasource'] ) {
			// Latitude mapped meta.
			if ( isset( $post_meta[ $this->address_option_vals['latitude'] ][0] ) ) {
				$lat = $post_meta[ $this->address_option_vals['latitude'] ][0];
			}

			// Longitude mapped meta.
			if ( isset( $post_meta[ $this->address_option_vals['longitude'] ][0] ) ) {
				$lng = $post_meta[ $this->address_option_vals['longitude'] ][0];
			}
		}

		// Latitude override.
		if ( isset( $post_meta['latitude'][0] ) ) {
			$lat = $post_meta['latitude'][0];
		}

		// Longitude override.
		if ( isset( $post_meta['longitude'][0] ) ) {
			$lng = $post_meta['longitude'][0];
		}

		if ( empty( $lat ) || empty( $lng ) ) {
			return;
		}

		echo '<div data-lat="' . esc_html( $lat ) . '" data-lng="' . esc_html( $lng ) . '" id="bh-sl-location-preview"></div>';
		echo '<p class="description">' . esc_html__( 'Drag the marker on the map above to update the coordinates. Make sure to update the location to save.', 'bh-storelocator' ) . '</p>';
		echo '<button id="bh-sl-location-preview-reset" class="button button-large">' . esc_html__( 'Reset', 'bh-storelocator' ) . '</button>';
	}
}
