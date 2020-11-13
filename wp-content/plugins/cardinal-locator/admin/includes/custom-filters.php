<?php
/**
 * Custom filters setup
 *
 * @package BH_Store_Locator
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Builds the initial filter option HTML fields
 *
 * @param array $taxonomy_names Taxonomies associated with the datasource post type.
 */
function bh_storelocator_taxfilters_markup( $taxonomy_names ) {
	$meta_filters['city'] = __( 'City', 'bh-storelocator' );
	$meta_filters['state'] = __( 'State', 'bh-storelocator' );
	$meta_filters['postal'] = __( 'Postal', 'bh-storelocator' );
	$filter_types = array();
	$filter_types['select'] = __( 'Select field', 'bh-storelocator' );
	$filter_types['checkbox'] = __( 'Checkboxes', 'bh-storelocator' );
	$filter_types['radio'] = __( 'Radio buttons', 'bh-storelocator' );

	// Section heading.
	echo '<div class="bh-sl-tax-filters-row bh-sl-tax-filters-heading">';
	echo '<div class="bh-sl-tax-filter-left">' . esc_html__( 'Filter', 'bh-storelocator' ) . '</div>';
	echo '<div class="bh-sl-tax-filter-right">' . esc_html__( 'Field type', 'bh-storelocator' ) . '</div>';
	echo '</div>';

	// All the filters will be appended to this div.
	echo '<div id="bh-sl-filters-list"></div>';

	// Initial filter div used strictly for cloning.
	echo '<div class="bh-sl-tax-filters-row initial" draggable="true">';
	echo '<div class="bh-sl-tax-filter-left">';
	echo '<select class="bh-sl-filter-key">';
	// Output the meta fields that could be used as filters as options.
	foreach ( $meta_filters as $meta_filter_key => $meta_filter_val ) {
		echo '<option value="' . esc_html( $meta_filter_key ) . '">' . esc_html( $meta_filter_val ) . '</option>';
	}

	// Output the taxonomies as options.
	foreach ( $taxonomy_names as $taxonomy ) {
		$tax_info = get_taxonomy( $taxonomy );

		echo '<option value="' . esc_html( $taxonomy ) . '">' . esc_html( $tax_info->label ) . '</option>';
	}
	echo '</select>';
	echo '</div>';

	// Output field type option.
	echo '<div class="bh-sl-tax-filter-right">';
	echo '<select class="bh-sl-filter-type">';
	// Output the field types.
	foreach ( $filter_types as $filter_type_key => $filter_type_val ) {
		echo '<option value="' . esc_html( $filter_type_key ) . '">' . esc_html( $filter_type_val ) . '</option>';
	}
	echo '</select>';
	echo '<div class="bh-sl-remove-filter"></div>';
	echo '</div>';
	echo '</div>';

	echo '<button id="bh-sl-add-filter" class="button button-primary">' . esc_html__( 'Add filter', 'bh-storelocator' ) . '</button>';
}

/**
 * Taxonomy filters
 *
 * @param array $args label, name, option name.
 */
function bh_storelocator_taxfilters( $args ) {
	$primary_defaults = BH_Store_Locator_Defaults::get_primary_defaults();
	$primary_option_vals = get_option( 'bh_storelocator_primary_options', $primary_defaults );
	$post_type = null;

	// Determine the current post type.
	if ( 'locations' === $primary_option_vals['datasource'] ) {
		$post_type = BH_Store_Locator::BH_SL_CPT;
	} elseif ( 'cpt' === $primary_option_vals['datasource'] ) {
		$post_type = $primary_option_vals['posttype'];
	}

	if ( isset( $post_type ) ) {
		// Get all the taxonomies associated with the current post type.
		$taxonomy_names = get_object_taxonomies( $post_type );

		echo '<div class="bh-sl-taxfilters-container">';
		echo '<p>' . esc_html__( 'Field type is only necessary when using the shortcode to display the locator. If you plan on setting up the front-end HTML code in a template you do not need to worry about what the field type value is set to. Make sure to click the Save Changes button after you have set up your filters.', 'bh-storelocator' ) . '</p>';

		bh_storelocator_taxfilters_markup( $taxonomy_names );

		echo '</div>';
	}
}
