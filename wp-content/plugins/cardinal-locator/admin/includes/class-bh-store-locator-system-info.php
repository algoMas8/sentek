<?php
/**
 * System information for debugging
 *
 * Based on the system information output from Easy Digital Downloads
 *
 * @package BH_Store_Locator
 */

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * Class BH_Store_Locator_System_Info
 */
class BH_Store_Locator_System_Info {

	/**
	 * Over 1,000 locations boolean
	 *
	 * @var bool
	 */
	protected $many_locations = false;

	/**
	 * Get the site's active plugins
	 */
	function get_active_plugins() {
		$plugins = get_plugins();
		$active_plugins = get_option( 'active_plugins', array() );

		foreach ( $plugins as $plugin_path => $plugin ) {
			if ( ! in_array( $plugin_path, $active_plugins, true ) ) {
				continue;
			}

			echo esc_textarea( $plugin['Name'] . ': ' . $plugin['Version'] ) . "\n";
		}
	}

	/**
	 * Get the networks's active plugins
	 */
	function get_network_active_plugins() {
		$plugins = wp_get_active_network_plugins();
		$active_plugins = get_site_option( 'active_sitewide_plugins', array() );

		foreach ( $plugins as $plugin_path ) {
			$plugin_base = plugin_basename( $plugin_path );

			// If the plugin isn't active, don't show it.
			if ( ! array_key_exists( $plugin_base, $active_plugins ) ) {
				continue;
			}

			$plugin = get_plugin_data( $plugin_path );

			echo esc_textarea( $plugin['Name'] . ' :' . $plugin['Version'] ) . "\n";
		}
	}

	/**
	 * Try to identify the hosting provider
	 */
	function get_host() {
		$host = false;
		$server_name = filter_input( INPUT_SERVER, 'SERVER_NAME', FILTER_SANITIZE_STRING );

		if ( defined( 'WPE_APIKEY' ) ) {
			$host = 'WP Engine';
		} elseif ( defined( 'PAGELYBIN' ) ) {
			$host = 'Pagely';
		} elseif ( 'localhost:/tmp/mysql5.sock' === DB_HOST ) {
			$host = 'ICDSoft';
		} elseif ( 'mysqlv5' === DB_HOST ) {
			$host = 'NetworkSolutions';
		} elseif ( false !== strpos( DB_HOST, 'ipagemysql.com' ) ) {
			$host = 'iPage';
		} elseif ( false !== strpos( DB_HOST, 'ipowermysql.com' ) ) {
			$host = 'IPower';
		} elseif ( false !== strpos( DB_HOST, '.gridserver.com' ) ) {
			$host = 'MediaTemple Grid';
		} elseif ( false !== strpos( DB_HOST, '.pair.com' ) ) {
			$host = 'pair Networks';
		} elseif ( false !== strpos( DB_HOST, '.stabletransit.com' ) ) {
			$host = 'Rackspace Cloud';
		} elseif ( false !== strpos( DB_HOST, '.sysfix.eu' ) ) {
			$host = 'SysFix.eu Power Hosting';
		} elseif ( false !== strpos( $server_name, 'Flywheel' ) ) {
			$host = 'Flywheel';
		} else {
			// Adding a general fallback for data gathering.
			$host = 'DBH: ' . DB_HOST . ', SRV: ' . $server_name;
		}

		return $host;
	}

	/**
	 * Output a group of option values
	 *
	 * @param string $option_group Group of options to output.
	 */
	function output_plugin_settings( $option_group ) {
		$vals = get_option( $option_group );

		if ( is_array( $vals ) ) {
			foreach ( $vals as $key => $val ) {
				// Over 1,000 locations setting check.
				if ( 'manylocations' === $key && 'true' === $val ) {
					$this->many_locations = true;
				}

				if ( is_array( $val ) && count( $val ) > 0 ) {
					echo esc_textarea( $key . ': ' . implode( ', ', $val ) ) . "\n";
				} elseif ( ! is_array( $val ) ) {
					echo esc_textarea( $key . ': ' . $val ) . "\n";
				}
			}
		}
	}

	/**
	 * Output row count from the custom database table
	 */
	function output_table_count() {
		global $wpdb;
		$table_name = $wpdb->prefix . 'cardinal_locator_coords';

		$row_count = $wpdb->get_var( "SELECT COUNT(*) FROM $table_name" );

		echo esc_textarea( 'Row count: ' . $row_count ) . "\n";
	}

	/**
	 * Get the total number of location posts.
	 *
	 * @return object|string
	 */
	function total_location_count() {
		$total = '';

		$primary_option_vals = get_option( 'bh_storelocator_primary_options', BH_Store_Locator_Defaults::get_primary_defaults() );

		if ( 'locations' === $primary_option_vals['datasource'] ) {
			$post_count = wp_count_posts( BH_Store_Locator::BH_SL_CPT );

			if ( property_exists( $post_count, 'publish' ) ) {
				$total = $post_count->publish;
			}
		} elseif ( 'cpt' === $primary_option_vals['datasource'] ) {
			$post_count = wp_count_posts( $primary_option_vals['posttype'] );

			if ( property_exists( $post_count, 'publish' ) ) {
				$total = $post_count->publish;
			}
		} else {
			$total = 'Static file';
		}

		return $total;
	}

	/**
	 * Output the System Info
	 */
	function output() {
		global $wpdb;

		$theme_data = wp_get_theme();
		$theme = $theme_data->Name . ' ' . $theme_data->Version;
		$host = $this->get_host();
		$server_software = filter_input( INPUT_SERVER, 'SERVER_SOFTWARE', FILTER_SANITIZE_STRING );

		?>
		<form action="" method="post" dir="ltr">
		<textarea readonly="readonly" onclick="this.focus();this.select()" class="bh-sl-system-info-textarea" name="bh-sl-sysinfo" title="<?php echo esc_html__( 'To copy the system info, click below then press CTRL + C (PC) or CMD + C (Mac).', 'bh-storelocator' ); ?>">
### Begin System Info ###

Multisite:                <?php echo is_multisite() ? 'Yes' . "\n" : 'No' . "\n" ?>
SITE_URL:                 <?php echo esc_url( site_url() ) . "\n"; ?>
HOME_URL:                 <?php echo esc_url( home_url() ) . "\n"; ?>
CardinalWP Version:       <?php echo esc_textarea( BH_Store_Locator::VERSION ) . "\n"; ?>
Total Location Count:     <?php echo esc_textarea( $this->total_location_count() ) . "\n"; ?>
WordPress Version:        <?php echo esc_textarea( get_bloginfo( 'version' ) ) . "\n"; ?>
Permalink Structure:      <?php echo esc_textarea( get_option( 'permalink_structure' ) ) . "\n"; ?>
Active Theme:             <?php echo esc_textarea( $theme ) . "\n"; ?>
<?php if ( $host ) : ?>Host:                     <?php echo esc_textarea( $host ) . "\n"; ?><?php endif; ?>
Registered Post Stati:    <?php echo esc_textarea( implode( ', ', get_post_stati() ) ) . "\n"; ?>
PHP Version:              <?php echo esc_textarea( PHP_VERSION ) . "\n"; ?>
MySQL Version:            <?php echo esc_textarea( $wpdb->db_version() ) . "\n"; ?>
Web Server Info:          <?php echo esc_textarea( $server_software ) . "\n"; ?>
WordPress Memory Limit:   <?php echo esc_textarea( WP_MEMORY_LIMIT ); ?><?php echo "\n"; ?>
PHP Memory Limit:         <?php echo esc_textarea( ini_get( 'memory_limit' ) ) . "\n"; ?>
PHP Upload Max Size:      <?php echo esc_textarea( ini_get( 'upload_max_filesize' ) ) . "\n"; ?>
PHP Post Max Size:        <?php echo esc_textarea( ini_get( 'post_max_size' ) ) . "\n"; ?>
PHP Upload Max Filesize:  <?php echo esc_textarea( ini_get( 'upload_max_filesize' ) ) . "\n"; ?>
PHP Time Limit:           <?php echo esc_textarea( ini_get( 'max_execution_time' ) ) . "\n"; ?>
PHP Max Input Vars:       <?php echo esc_textarea( ini_get( 'max_input_vars' ) ) . "\n"; ?>
PHP Arg Separator:        <?php echo esc_textarea( ini_get( 'arg_separator.output' ) ) . "\n"; ?>
PHP Allow URL File Open:  <?php echo ini_get( 'allow_url_fopen' ) ? 'Yes' : 'No'; ?><?php echo "\n"; ?>
WP_DEBUG:                 <?php echo defined( 'WP_DEBUG' ) ? WP_DEBUG ? 'Enabled' . "\n" : 'Disabled' . "\n" : 'Not set' . "\n" ?>
WP Table Prefix:          <?php echo 'Length: '. strlen( $wpdb->prefix ); echo ' Status:'; if ( strlen( $wpdb->prefix ) > 16 ) { echo ' ERROR: Too Long'; } else { echo ' Acceptable'; } echo "\n"; ?>
Show On Front:            <?php echo esc_textarea( get_option( 'show_on_front' ) ) . "\n" ?>
Page On Front:            <?php $id = get_option( 'page_on_front' ); echo esc_textarea( get_the_title( $id ) . ' (#' . $id . ')' ) . "\n" ?>
Page For Posts:           <?php $id = get_option( 'page_for_posts' ); echo esc_textarea( get_the_title( $id ) . ' (#' . $id . ')' ) . "\n" ?>
Session:                  <?php echo isset( $_SESSION ) ? 'Enabled' : 'Disabled'; ?><?php echo "\n"; ?>
Session Name:             <?php echo esc_html( ini_get( 'session.name' ) ); ?><?php echo "\n"; ?>
Cookie Path:              <?php echo esc_html( ini_get( 'session.cookie_path' ) ); ?><?php echo "\n"; ?>
Save Path:                <?php echo esc_html( ini_get( 'session.save_path' ) ); ?><?php echo "\n"; ?>
Use Cookies:              <?php echo ini_get( 'session.use_cookies' ) ? 'On' : 'Off'; ?><?php echo "\n"; ?>
Use Only Cookies:         <?php echo ini_get( 'session.use_only_cookies' ) ? 'On' : 'Off'; ?><?php echo "\n"; ?>
DISPLAY ERRORS:           <?php echo ( ini_get( 'display_errors' ) ) ? 'On (' . ini_get( 'display_errors' ) . ')' : 'N/A'; ?><?php echo "\n"; ?>
FSOCKOPEN:                <?php echo ( function_exists( 'fsockopen' ) ) ? 'Your server supports fsockopen.' : 'Your server does not support fsockopen.'; ?><?php echo "\n"; ?>
cURL:                     <?php echo ( function_exists( 'curl_init' ) ) ? 'Your server supports cURL.' : 'Your server does not support cURL.'; ?><?php echo "\n"; ?>
SOAP Client:              <?php echo ( class_exists( 'SoapClient' ) ) ? 'Your server has the SOAP Client enabled.' : 'Your server does not have the SOAP Client enabled.'; ?><?php echo "\n"; ?>
SUHOSIN:                  <?php echo ( extension_loaded( 'suhosin' ) ) ? 'Your server has SUHOSIN installed.' : 'Your server does not have SUHOSIN installed.'; ?><?php echo "\n"; ?>

ACTIVE PLUGINS:

<?php
$this->get_active_plugins();

if ( is_multisite() ) :
	?>

NETWORK ACTIVE PLUGINS:

<?php
$this->get_network_active_plugins();

endif; ?>

CARDINAL PRIMARY SETTINGS:

<?php $this->output_plugin_settings( 'bh_storelocator_primary_options' ); ?>

CARDINAL FILTER SETTINGS:

<?php $this->output_plugin_settings( 'bh_storelocator_filter_options' ); ?>

CARDINAL STYLE SETTINGS:

<?php $this->output_plugin_settings( 'bh_storelocator_style_options' ); ?>

CARDINAL STRUCTURE SETTINGS:

<?php $this->output_plugin_settings( 'bh_storelocator_structure_options' ); ?>

<?php if ( $this->many_locations ) : ?>

DATABASE:

<?php $this->output_table_count(); ?>

<?php endif; ?>

### End System Info ###</textarea></form>
	<?php }

}
