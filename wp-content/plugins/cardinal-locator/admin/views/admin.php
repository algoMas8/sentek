<?php
/**
 * Admin settings fields
 *
 * @package BH_Store_Locator
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function bh_storelocator_support_content() {
	$html = null;
	$html .= '<h3>' . esc_html__( 'Support', 'bh-storelocator' ) . '</h3>';
	$html .= '<p>' . sprintf( __( 'Documentation, FAQs and the support request form can be found on the
	<a target="%s" href="%s" rel="%s">CardinalWP site</a>. Please submit a support request if you run into issues. If it\'s
	not a US holiday you should receive a response within 72 hours. Support is only available for active license
	holders.', 'bh-storelocator' ), '_blank', 'https://cardinalwp.com', 'noopener noreferrer' ) . '</p>';
	$html .= '<div class=bh-sl-system-info">';
	$html .= '<h3>' . esc_html__( 'System Information', 'bh-storelocator' ) . '</h3>';
	$html .= '<p>' . sprintf( __( 'When submitting a support request it will be helpful if you can create a private
	<a target="%s" href="%s" rel="%s">Gist</a> with the following information:', 'bh-storelocator' ), '_blank', 'https://gist.github.com', 'noopener noreferrer' ) . '</p>';
	$html .= '</div>';

	echo wp_kses_post( $html );

	// Output system information.
	$system_info = new BH_Store_Locator_System_Info();
	$system_info->output();
}

?>

<div class="wrap">
	<h2>Cardinal Store Locator for WordPress</h2>
	<?php
	// Get the active tab or default to primary settings.
	$current_tab = filter_input( INPUT_GET, 'tab', FILTER_SANITIZE_STRING );
	if ( 'valid' === get_option( 'bh_storelocator_license_status' ) ) {
		$active_tab = isset( $current_tab ) ? $current_tab : 'primary_settings';
	} else {
		$active_tab = isset( $current_tab ) ? $current_tab : 'license_settings';
	}

	// Get the primary setting values to show/hide address meta tab.
	$primary_options = get_option( 'bh_storelocator_primary_options' );
	?>

	<h2 class="nav-tab-wrapper">
		<a href="?page=<?php echo esc_html( $this->plugin_slug ); ?>&tab=license_settings" class="nav-tab license-settings <?php echo 'license_settings' === $active_tab ? 'nav-tab-active' : ''; ?>"><?php esc_html_e( 'License Settings', 'bh-storelocator' ); ?></a>
		<a href="?page=<?php echo esc_html( $this->plugin_slug ); ?>&tab=primary_settings" class="nav-tab primary-settings <?php echo 'primary_settings' === $active_tab ? 'nav-tab-active' : ''; ?>"><?php esc_html_e( 'Primary Settings', 'bh-storelocator' ); ?></a>
		<?php if ( isset( $this->primary_option_vals['datasource'] ) && ( 'cpt' === $this->primary_option_vals['datasource'] ) && ( '' !== $this->primary_option_vals['posttype'] ) ) : ?>
			<a href="?page=<?php echo esc_html( $this->plugin_slug ); ?>&tab=address_meta_settings" class="nav-tab address-meta-settings <?php echo 'address_meta_settings' === $active_tab ? 'nav-tab-active' : ''; ?>"><?php esc_html_e( 'Address Meta Field Mapping', 'bh-storelocator' ); ?></a>
		<?php endif; ?>
		<a href="?page=<?php echo esc_html( $this->plugin_slug ); ?>&tab=style_settings" class="nav-tab style-settings <?php echo 'style_settings' === $active_tab ? 'nav-tab-active' : ''; ?>"><?php esc_html_e( 'Style Settings', 'bh-storelocator' ); ?></a>
		<a href="?page=<?php echo esc_html( $this->plugin_slug ); ?>&tab=structure_settings" class="nav-tab structure-settings <?php echo 'structure_settings' === $active_tab ? 'nav-tab-active' : ''; ?>"><?php esc_html_e( 'Structure Settings', 'bh-storelocator' ); ?></a>
		<?php if ( 'cpt' === $this->primary_option_vals['datasource'] || 'locations' === $this->primary_option_vals['datasource'] ) : ?>
			<a href="?page=<?php echo esc_html( $this->plugin_slug ); ?>&tab=filter_settings" class="nav-tab filter-settings <?php echo 'filter_settings' === $active_tab ? 'nav-tab-active' : ''; ?>"><?php esc_html_e( 'Filter Settings', 'bh-storelocator' ); ?></a>
		<?php endif; ?>
		<a href="?page=<?php echo esc_html( $this->plugin_slug ); ?>&tab=language_settings" class="nav-tab language-settings <?php echo 'language_settings' === $active_tab ? 'nav-tab-active' : ''; ?>"><?php esc_html_e( 'Language Settings', 'bh-storelocator' ); ?></a>
		<a href="?page=<?php echo esc_html( $this->plugin_slug ); ?>&tab=support" class="nav-tab support-settings <?php echo 'support' === $active_tab ? 'nav-tab-active' : ''; ?>"><?php esc_html_e( 'Support', 'bh-storelocator' ); ?></a>
	</h2>

	<form action="options.php" method="POST">
		<?php
		if ( 'license_settings' === $active_tab ) {
			settings_fields( 'plugin:bh_storelocator_license_option_group' );
			do_settings_sections( 'bh_storelocator_license_settings' );
		} elseif ( 'primary_settings' === $active_tab ) {
			settings_fields( 'plugin:bh_storelocator_primary_option_group' );
			do_settings_sections( 'bh_storelocator_primary_settings' );
		} elseif ( 'address_meta_settings' === $active_tab ) {
			settings_fields( 'plugin:bh_storelocator_meta_option_group' );
			do_settings_sections( 'bh_storelocator_meta_settings' );
		} elseif ( 'filter_settings' === $active_tab ) {
			settings_fields( 'plugin:bh_storelocator_filter_option_group' );
			do_settings_sections( 'bh_storelocator_filter_settings' );
		} elseif ( 'style_settings' === $active_tab ) {
			settings_fields( 'plugin:bh_storelocator_style_option_group' );
			do_settings_sections( 'bh_storelocator_style_settings' );
		} elseif ( 'structure_settings' === $active_tab ) {
			settings_fields( 'plugin:bh_storelocator_structure_option_group' );
			do_settings_sections( 'bh_storelocator_structure_settings' );
		} elseif ( 'language_settings' === $active_tab ) {
			settings_fields( 'plugin:bh_storelocator_language_option_group' );
			do_settings_sections( 'bh_storelocator_language_settings' );
		} elseif ( 'support' === $active_tab ) {
			bh_storelocator_support_content();
		}

		if ( 'support' !== $active_tab ) {
			submit_button();
		}

		?>
	</form>
</div><!-- .wrap -->
