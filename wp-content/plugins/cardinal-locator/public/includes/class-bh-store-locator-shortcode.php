<?php
/**
 * Shortcode functionality
 *
 * @package BH_Store_Locator
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use function Cardinal_Locator\Helpers\get_country_data;

/**
 * Class BH_Store_Locator_Shortcode
 */
class BH_Store_Locator_Shortcode {

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
	 * BH_Store_Locator_Shortcode constructor.
	 *
	 * @param array $primary_vals Primary setting values.
	 * @param array $address_vals Address setting values.
	 * @param array $filter_vals Filter setting values.
	 * @param array $style_vals Style setting values.
	 * @param array $structure_vals Structure setting values.
	 * @param array $language_vals Language setting values.
	 */
	public function __construct( $primary_vals, $address_vals, $filter_vals, $style_vals, $structure_vals, $language_vals ) {

		// Get option values for use.
		$this->primary_option_vals   = $primary_vals;
		$this->address_option_vals   = $address_vals;
		$this->filter_option_vals    = $filter_vals;
		$this->style_option_vals     = $style_vals;
		$this->structure_option_vals = $structure_vals;
		$this->language_option_vals  = $language_vals;
	}

	/**
	 * Init.
	 */
	public function init() {

		// Only register the shortcodes if there are locations added.
		if ( $this->bh_storelocator_check_post_type_locations() ) {
			// Add custom plugin shortcode.
			add_shortcode( 'cardinal-storelocator', array( $this, 'bh_storelocator_shortcode' ) );
			// Add filters shortcode.
			add_shortcode( 'cardinal-storelocator-filters', array( $this, 'bh_storelocator_filters_shortcode' ) );
			// Single map shortcode.
			add_shortcode( 'cardinal-storelocator-single-map', array( $this, 'bh_storelocator_single_map_shortcode' ) );
			// Address shortcode for single posts.
			add_shortcode( 'cardinal-storelocator-address', array( $this, 'bh_storelocator_single_address' ) );
		}
	}

	/**
	 * Check to see if any location posts have been added
	 */
	public function bh_storelocator_check_post_type_locations() {
		$display = false;

		// Before query hook.
		do_action( 'bh_sl_before_location_query' );

		if ( 'cpt' === $this->primary_option_vals['datasource'] ) {
			$location_args = array(
				'no_found_rows'          => true,
				'post_type'              => $this->primary_option_vals['posttype'],
				'posts_per_page'         => 1,
				'update_post_meta_cache' => false,
				'update_post_term_cache' => false,
			);

			$location_query = new WP_Query( $location_args );

			if ( count( $location_query->posts ) > 0 ) {
				$display = true;
			}
		} elseif ( 'locations' === $this->primary_option_vals['datasource'] ) {
			$location_args = array(
				'no_found_rows'          => true,
				'post_type'              => BH_Store_Locator::BH_SL_CPT,
				'posts_per_page'         => 1,
				'update_post_meta_cache' => false,
				'update_post_term_cache' => false,
			);

			$location_query = new WP_Query( $location_args );

			if ( count( $location_query->posts ) > 0 ) {
				$display = true;
			}
		} elseif ( 'localfile' === $this->primary_option_vals['datasource'] || 'remoteurl' === $this->primary_option_vals['datasource'] ) {
			$display = true;
		}

		wp_reset_postdata();

		// After query hook.
		do_action( 'bh_sl_after_location_query' );

		return $display;
	}

	/**
	 * Get the values of the custom meta field by key
	 *
	 * @param string $key Meta key to check.
	 *
	 * @return array|void
	 */
	private function bh_storelocator_get_location_meta_vals( $key = '' ) {
		global $wpdb;
		$all_meta_vals = array();

		if ( empty( $key ) ) {
			return;
		}

		$used_meta_vals = wp_cache_get( 'bh_storelocator_meta_vals' . $key );

		if ( false === $used_meta_vals ) {

			$used_meta_vals = $wpdb->get_col(
				$wpdb->prepare( "
			        SELECT DISTINCT pm.meta_value FROM {$wpdb->postmeta} pm
			        LEFT JOIN {$wpdb->posts} p ON p.ID = pm.post_id
			        WHERE pm.meta_key = '%s'
			        AND p.post_status = '%s'
			        AND p.post_type = '%s'
			    ",
					$key,
					'publish',
					BH_Store_Locator::BH_SL_CPT
				)
			);

			wp_cache_set( 'bh_storelocator_meta_vals' . $key, $used_meta_vals );
		}

		// Prepare the array to return.
		if ( count( $used_meta_vals ) > 0 ) {
			foreach ( $used_meta_vals as $meta_val ) {
				array_push( $all_meta_vals, $meta_val );
			}
		}

		return $all_meta_vals;
	}

	/**
	 * Get all possible meta/taxonomy values
	 *
	 * @param string $tax The meta or taxnoomy name.
	 *
	 * @return array
	 */
	protected function bh_storelocator_get_tax_meta_vals( $tax ) {
		$vals = array();

		// Initially handle filters that are post meta, otherwise check to see if it's a taxonomy.
		if ( 'city' === $tax ) {
			$vals = $this->bh_storelocator_get_location_meta_vals( '_bh_sl_city' );
		} elseif ( 'state' === $tax ) {
			$vals = $this->bh_storelocator_get_location_meta_vals( '_bh_sl_state' );
		} elseif ( 'postal' === $tax ) {
			$vals = $this->bh_storelocator_get_location_meta_vals( '_bh_sl_postal' );
		} elseif ( taxonomy_exists( $tax ) ) {
			$tax_terms = get_terms( $tax );

			// Return the taxonomy term names.
			foreach ( $tax_terms as $tax_term ) {
				array_push( $vals, $tax_term->name );
			}
		}

		return $vals;
	}

	/**
	 * Set up the select filter markup.
	 *
	 * @param array  $vals Filter values.
	 * @param string $filter_name Filter name.
	 * @param string $filter_label Filter label.
	 *
	 * @return string
	 */
	protected function bh_storelocator_setup_select_filters( $vals, $filter_name, $filter_label ) {
		$filter_output = '';

		$filter_output .= '<ul id="' . $filter_name . '-filters-container" class="bh-sl-filters">';
		$filter_output .= '<li><h3 class="bh-sl-filter-title">' . $filter_label . '</h3></li>';
		$filter_output .= '<li>';
		$filter_output .= '<select name="' . $filter_name . '">';
		$filter_output .= '<option value="">' . __( 'All', 'bh-storelocator' ) . '</option>';

		foreach ( $vals as $val ) {
			if ( null !== $val ) {
				$filter_output .= '<option value="' . $val . '">' . $val . '</option>';
			}
		}

		$filter_output .= '</select>';
		$filter_output .= '</li>';
		$filter_output .= '</ul>';

		return $filter_output;
	}

	/**
	 * Set up the checkbox filter markup.
	 *
	 * @param array  $vals Filter values.
	 * @param string $filter_name Filter name.
	 * @param string $filter_label Filter label.
	 *
	 * @return string
	 */
	protected function bh_storelocator_setup_checkbox_filters( $vals, $filter_name, $filter_label ) {
		$filter_output = '';

		$filter_output .= '<ul id="' . $filter_name . '-filters-container" class="bh-sl-filters">';
		$filter_output .= '<li><h3 class="bh-sl-filter-title">' . $filter_label . '</h3></li>';

		foreach ( $vals as $val ) {
			if ( null !== $val ) {
				$filter_output .= '<li>';
				$filter_output .= '<label>';
				$filter_output .= '<input type="checkbox" name="' . $filter_name . '" value="' . $val . '"> <span class="bh-sl-cat-' . sanitize_title( $val ) . '">' . $val . '</span>';
				$filter_output .= '</label>';
				$filter_output .= '</li>';
			}
		}

		$filter_output .= '</ul>';

		return $filter_output;
	}

	/**
	 * Set up the radio filter markup.
	 *
	 * @param array  $vals Filter values.
	 * @param string $filter_name Filter name.
	 * @param string $filter_label Filter label.
	 *
	 * @return string
	 */
	protected function bh_storelocator_setup_radio_filters( $vals, $filter_name, $filter_label ) {
		$filter_output = '';

		$filter_output .= '<ul id="' . $filter_name . '-filters-container" class="bh-sl-filters">';
		$filter_output .= '<li><h3 class="bh-sl-filter-title">' . $filter_label . '</h3></li>';

		foreach ( $vals as $val ) {
			if ( null !== $val ) {
				$filter_output .= '<li>';
				$filter_output .= '<input type="radio" name="' . $filter_name . '" value="' . $val . '"> <span class="bh-sl-cat-' . sanitize_title( $val ) . '">' . $val . '</span>';
				$filter_output .= '</li>';
			}
		}

		$filter_output .= '</ul>';

		return $filter_output;
	}

	/**
	 * Setup the filter markup
	 *
	 * @param array $atts Shortcode attributes.
	 *
	 * @return string
	 */
	public function bh_storelocator_shortcode_filters_setup( $atts = array() ) {
		$html    = '';
		$filters = array();

		if ( isset( $this->filter_option_vals['bhslfilters'] ) && is_array( $this->filter_option_vals['bhslfilters'] ) ) {

			foreach ( $this->filter_option_vals['bhslfilters'] as $key => $val ) {

				if ( false !== strpos( $key, 'bh-sl-filter-key' ) ) {
					$filters[] = $val;
				}
			}
		}

		// Attributes.
		$atts = shortcode_atts(
			array(
				'filter-types' => implode( ',', $filters ),
			),
			$atts,
			'cardinal-storelocator-filters'
		);

		// Filters.
		$filter_pairs          = array();
		$matching_filter_pairs = array();
		$filter_count          = 0;
		$filter_restrictions   = explode( ',', $atts['filter-types'] );

		$html .= '<div class="' . esc_html( $this->structure_option_vals['taxonomyfilterscontainer'] ) . '">';
		foreach ( $this->filter_option_vals['bhslfilters'] as $key => $filter ) {

			// Allow filters to be set manually.
			if ( false !== strpos( $key, 'bh-sl-filter-key' ) && ! in_array( $filter, $filter_restrictions, true ) ) {
				continue;
			}

			if ( false !== strpos( $key, 'bh-sl-filter-key' ) ) {
				$filter_pairs['key'] = $filter;
			} elseif ( false !== strpos( $key, 'bh-sl-filter-type' ) ) {
				$filter_pairs['type'] = $filter;
			}

			if ( $filter_count % 2 ) {
				array_unshift( $matching_filter_pairs, $filter_pairs );
				$filter_pairs = array();
			}

			$filter_count++;
		}

		// Array is in the reverse order after the above loop - reversing.
		$matching_filter_pairs = array_reverse( $matching_filter_pairs );

		// Another for loop to output the actual filters.
		foreach ( $matching_filter_pairs as $matching_filter ) {
			// Get all the possible filter values.
			$filter_vals = $this->bh_storelocator_get_tax_meta_vals( $matching_filter['key'] );
			// Sort the array using natural order.
			natsort( $filter_vals );

			// Allow the filter vals to be modified.
			$filter_vals = apply_filters( 'bh_sl_filter_vals_' . $matching_filter['key'], $filter_vals );

			// Filter label setup.
			if ( 'city' === $matching_filter['key'] ) {
				$filter_label = __( 'City', 'bh-storelocator' );
			} elseif ( 'state' === $matching_filter['key'] ) {
				$filter_label = __( 'State', 'bh-storelocator' );
			} elseif ( 'postal' === $matching_filter['key'] ) {
				$filter_label = __( 'Postal Code', 'bh-storelocator' );
			} elseif ( taxonomy_exists( $matching_filter['key'] ) ) {
				$filter_tax   = get_taxonomy( $matching_filter['key'] );
				$filter_label = $filter_tax->labels->name;
			}

			// Output the appropriate filter markup.
			if ( count( $filter_vals ) > 0 ) {
				if ( 'select' === $matching_filter['type'] ) {
					$html .= $this->bh_storelocator_setup_select_filters( $filter_vals, $matching_filter['key'], $filter_label );
				} elseif ( 'checkbox' === $matching_filter['type'] ) {
					$html .= $this->bh_storelocator_setup_checkbox_filters( $filter_vals, $matching_filter['key'], $filter_label );
				} elseif ( 'radio' === $matching_filter['type'] ) {
					$html .= $this->bh_storelocator_setup_radio_filters( $filter_vals, $matching_filter['key'], $filter_label );
				}
			}
		}

		$html .= '</div>';

		return $html;
	}

	/**
	 * Set up the sort option markup.
	 */
	public function bh_storelocator_shortcode_sort_options_setup() {
		$html = '';

		$sort_options = array(
			'name'     => array(
				'label' => __( 'Name', 'bh-storelocator' ),
				'type'  => 'alpha',
			),
			'address'  => array(
				'label' => __( 'Address', 'bh-storelocator' ),
				'type'  => 'numeric',
			),
			'address2' => array(
				'label' => __( 'Address 2', 'bh-storelocator' ),
				'type'  => 'numeric',
			),
			'city'     => array(
				'label' => __( 'City', 'bh-storelocator' ),
				'type'  => 'alpha',
			),
			'state'    => array(
				'label' => __( 'State', 'bh-storelocator' ),
				'type'  => 'alpha',
			),
			'country'  => array(
				'label' => __( 'Country', 'bh-storelocator' ),
				'type'  => 'alpha',
			),
			'distance' => array(
				'label' => __( 'Distance', 'bh-storelocator' ),
				'type'  => 'numeric',
			),
			'date'     => array(
				'label' => __( 'Date', 'bh-storelocator' ),
				'type'  => 'date',
			),
		);

		// Allow the order options to be filtered for removals, custom additions, etc.
		apply_filters( 'bh_sl_shortcode_sort_vals', $sort_options, $this->structure_option_vals, $this->language_option_vals );

		if ( is_array( $sort_options ) ) {
			foreach ( $sort_options as $key => $sort_option ) {
				$selected = '';

				// Select the initial sorting method set in Structure Settings.
				if ( $key === $this->structure_option_vals['customsortingprop'] ) {
					$selected = 'selected';
				}

				$html .= '<option data-method="' . esc_attr( $sort_option['type'] ) . '" value="' . esc_attr( $key ) . '" ' . esc_attr( $selected ) . '>' . esc_html( $sort_option['label'] ) . '</option>';
			}
		}

		return $html;
	}

	/**
	 * Set up the order option markup.
	 */
	public function bh_storelocator_shortcode_order_options_setup() {
		$html = '';

		$order_options = array(
			'asc'  => array(
				'label' => __( 'Ascending', 'bh-storelocator' ),
			),
			'desc' => array(
				'label' => __( 'Descending', 'bh-storelocator' ),
			),
		);

		foreach ( $order_options as $key => $order_option ) {
			$selected = '';

			// Select the initial sorting method set in Structure Settings.
			if ( $key === $this->structure_option_vals['customsortingorder'] ) {
				$selected = 'selected';
			}

			$html .= '<option value="' . esc_attr( $key ) . '" ' . esc_attr( $selected ) . '>' . esc_html( $order_option['label'] ) . '</option>';
		}

		return $html;
	}

	/**
	 * Shortcode
	 *
	 * @param array $atts Shortcode attributes.
	 *
	 * @return mixed
	 */
	public function bh_storelocator_shortcode( $atts ) {
		// Pass shortcode attributes to jQuery.
		wp_localize_script( 'storelocator-script', 'bhStoreLocatorAtts', (array) $atts );

		$html           = '';
		$filters_markup = '';

		$html .= '<div class="bh-sl-container">';
		$html .= '<div class="' . esc_html( $this->structure_option_vals['formcontainerdiv'] ) . '">';

		// Form open.
		if ( 'true' !== $this->structure_option_vals['noform'] ) {
			$html .= '<form id="' . esc_html( $this->structure_option_vals['formid'] ) . '" method="get" action="#">';
		}

		$html .= '<div class="bh-sl-form-input">';

		// Name search.
		if ( 'true' === $this->structure_option_vals['namesearch'] ) {
			$html .= '<div class="bh-sl-form-input-group">';
			$html .= '<label for="' . $this->structure_option_vals['namesearchid'] . '">' . $this->language_option_vals['namesearchlabel'] . '</label>';
			$html .= '<input type="text" id="' . $this->structure_option_vals['namesearchid'] . '" name="' . $this->structure_option_vals['namesearchid'] . '" />';
			$html .= '</div>';
		}

		// Address input field.
		$html .= '<div class="bh-sl-form-input-group">';
		$html .= '<label for="' . esc_html( $this->structure_option_vals['inputid'] ) . '">' . esc_html( $this->language_option_vals['addressinputlabel'] ) . '</label>';
		$html .= '<input placeholder="" type="text" id="' . esc_html( $this->structure_option_vals['inputid'] ) . '" name="' . esc_html( $this->structure_option_vals['inputid'] ) . '" />';
		$html .= '</div>';

		// Maximum distance.
		if ( 'true' === $this->structure_option_vals['maxdistance'] && null !== $this->structure_option_vals['maxdistvals'] ) {
			$html .= '<div class="bh-sl-form-input-group">';
			$html .= '<label for="' . $this->structure_option_vals['maxdistanceid'] . '">' . $this->language_option_vals['maxdistancelabel'] . '</label>';

			$distance_vals = explode( ',', $this->structure_option_vals['maxdistvals'] );
			if ( 'm' === $this->primary_option_vals['lengthunit'] ) {
				$dist_lang = $this->language_option_vals['mileslang'];
			} else {
				$dist_lang = $this->language_option_vals['kilometerslang'];
			}

			$html .= '<select id="' . $this->structure_option_vals['maxdistanceid'] . '" name="' . $this->structure_option_vals['maxdistanceid'] . '">';

			foreach ( $distance_vals as $distance ) {
				$html .= '<option value="' . $distance . '">' . $distance . ' ' . $dist_lang . '</option>';
			}

			$html .= '</select>';
			$html .= '</div>';
		}

		// Region selection.
		if ( 'true' === $this->structure_option_vals['region'] && null !== $this->structure_option_vals['regionvals'] ) {
			$region_vals = explode( ',', $this->structure_option_vals['regionvals'] );

			$html .= '<div class="bh-sl-form-input-group">';
			$html .= '<label for="' . $this->structure_option_vals['regionid'] . '">' . $this->language_option_vals['regionlabel'] . '</label>';
			$html .= '<select id="' . $this->structure_option_vals['regionid'] . '" name="' . $this->structure_option_vals['regionid'] . '">';

			foreach ( $region_vals as $region ) {
				$html .= '<option value="' . $region . '">' . $region . '</option>';
			}

			$html .= '</select>';
			$html .= '</div>';
		}

		// Length unit selection.
		if ( 'true' === $this->structure_option_vals['lengthswap'] ) {
			$html .= '<div class="bh-sl-form-input-group">';
			$html .= '<label for="' . $this->structure_option_vals['lengthswapid'] . '">' . $this->language_option_vals['lengthunitlabel'] . '</label>';
			$html .= '<select id="' . $this->structure_option_vals['lengthswapid'] . '" name="' . $this->structure_option_vals['lengthswapid'] . '">';

			if ( 'm' === $this->primary_option_vals['lengthunit'] ) {
				$html .= '<option value="default-distance">' . __( 'Miles', 'bh-storelocator' ) . '</option>';
				$html .= '<option value="alt-distance">' . __( 'Kilometers', 'bh-storelocator' ) . '</option>';
			} else {
				$html .= '<option value="default-distance">' . __( 'Kilometers', 'bh-storelocator' ) . '</option>';
				$html .= '<option value="alt-distance">' . __( 'Miles', 'bh-storelocator' ) . '</option>';
			}

			$html .= '</select>';
			$html .= '</div>';
		}

		// Custom sorting.
		if ( 'true' === $this->structure_option_vals['customsorting'] ) {
			$html .= '<div class="bh-sl-form-input-group">';
			$html .= '<label for="' . esc_attr( $this->structure_option_vals['customsortingid'] ) . '">' . $this->language_option_vals['sortbylabel'] . '</label>';
			$html .= '<select id="' . esc_attr( $this->structure_option_vals['customsortingid'] ) . '" name="' . esc_attr( $this->structure_option_vals['customsortingid'] ) . '">';
			$html .= $this->bh_storelocator_shortcode_sort_options_setup();
			$html .= '</select>';
			$html .= '</div>';

			$html .= '<div class="bh-sl-form-input-group">';
			$html .= '<label for="' . esc_attr( $this->structure_option_vals['customorderid'] ) . '">' . $this->language_option_vals['orderlabel'] . '</label>';
			$html .= '<select id="' . esc_attr( $this->structure_option_vals['customorderid'] ) . '" name="bh-sl-order">';
			$html .= $this->bh_storelocator_shortcode_order_options_setup();
			$html .= '</select>';
			$html .= '</div>';
		}

		$html .= '</div>';

		$html .= '<button id="bh-sl-submit" type="submit">' . $this->language_option_vals['submitbtnlabel'] . '</button>';

		// Geocode button.
		if ( ( isset( $this->structure_option_vals['geocodebtn'] ) && 'true' === $this->structure_option_vals['geocodebtn'] ) && isset( $this->structure_option_vals['geocodebtnid'] ) && isset( $this->structure_option_vals['geocodebtnlabel'] ) ) {
			$html .= '<button id="' . $this->structure_option_vals['geocodebtnid'] . '" class="bh-sl-geolocation">' . $this->structure_option_vals['geocodebtnlabel'] . '</button>';
		}

		// Include filter markup.
		if ( ! isset( $atts['filters'] ) ) {
			// Set the filters markup to a variable so it can be added as a filter value.
			$filters_markup = $this->bh_storelocator_shortcode_filters_setup();
			$html .= $filters_markup;
		}

		// Form close.
		if ( 'true' !== $this->structure_option_vals['noform'] ) {
			$html .= '</form>';
		}

		$html .= '</div>';
		$html .= '<div id="bh-sl-map-container" class="bh-sl-map-container">';
		$html .= '<div id="' . esc_html( $this->structure_option_vals['mapid'] ) . '" class="bh-sl-map"></div>';
		$html .= '<div class="' . esc_html( $this->structure_option_vals['listdiv'] ) . '">';
		$html .= '<ul class="list"></ul>';
		$html .= '</div>'; // End listdiv.

		// Pagination.
		if ( 'true' === $this->primary_option_vals['pagination'] ) {
			$html .= '<div class="bh-sl-pagination-container">';
			$html .= '<ol class="bh-sl-pagination"></ol>';
			$html .= '</div>';
		}

		$html .= '</div>'; // End bh-sl-map-container.
		$html .= '</div>'; // End bh-sl-container.

		return apply_filters( 'bh_sl_shortcode', $html, $filters_markup, $this->structure_option_vals, $this->language_option_vals );
	}

	/**
	 * Filters shortcode
	 * Adding an additional shortcode for the filters so they can be placed in another location if needed.
	 *
	 * @param array $atts Shortcode attributes.
	 *
	 * @return mixed
	 */
	public function bh_storelocator_filters_shortcode( $atts ) {
		$html    = '';

		// Include filter markup.
		$html .= $this->bh_storelocator_shortcode_filters_setup( $atts );

		return apply_filters( 'bh_sl_filters_shortcode', $html, $this->structure_option_vals, $this->language_option_vals );
	}

	/**
	 * Single map shortcode
	 *
	 * @param array $atts Shortcode attributes.
	 *
	 * @return mixed
	 */
	public function bh_storelocator_single_map_shortcode( $atts ) {
		global $post;
		$html = '';
		$zoom = 16;

		if ( 'object' !== gettype( $post ) || ! is_single() ) {
			return $html;
		}

		$post_meta = get_post_meta( $post->ID );
		$lat       = '';
		$lng       = '';
		$terms     = array();
		$cats      = '';

		// Get the latitude from the location meta.
		if ( isset( $post_meta['latitude'][0] ) ) {
			$lat = $post_meta['latitude'][0];
		} elseif ( isset( $post_meta['bh_storelocator_location_lat'][0] ) ) {
			$lat = $post_meta['bh_storelocator_location_lat'][0];
		}

		// Get the longitude from the location meta.
		if ( isset( $post_meta['longitude'][0] ) ) {
			$lng = $post_meta['longitude'][0];
		} elseif ( isset( $post_meta['bh_storelocator_location_lng'][0] ) ) {
			$lng = $post_meta['bh_storelocator_location_lng'][0];
		}

		if ( empty( $lat ) || empty( $lng ) ) {
			return $html;
		}

		// Get the taxonomy terms.
		if ( BH_Store_Locator::BH_SL_CPT === get_post_type() ) {
			$tax_terms = get_the_terms( $post->ID, BH_Store_Locator::BH_SL_TAX );

			if ( is_array( $tax_terms ) ) {
				foreach ( $tax_terms as $tax_term ) {
					array_push( $terms, $tax_term->name );
				}

				if ( count( $terms ) > 0 ) {
					$cats = implode( ',', $terms );
				}
			}
		}

		// Check for zoom attribute.
		if ( isset( $atts['zoom'] ) && is_integer( intval( $atts['zoom'] ) ) ) {
			$zoom = intval( $atts['zoom'] );
		}

		$html = '<div id="bh-sl-map-shortcode" class="bh-sl-map-shortcode" data-lat="' . esc_attr( $lat ) . '" data-lng="' . esc_attr( $lng ) . '" data-zoom="' . absint( $zoom ) . '" data-cats="' . esc_attr( $cats ) . '"></div>';

		return apply_filters( 'bh_sl_single_map_shortcode', $html );
	}

	/**
	 * Address shortcode for single locations.
	 *
	 *  @param array $atts Shortcode attributes.
	 *
	 * @return string
	 */
	public function bh_storelocator_single_address( $atts = array() ) {
		global $post;
		$address = array();
		$html    = '';

		// Normalize attribute keys.
		$atts = array_change_key_case( (array) $atts, CASE_LOWER );

		if ( 'object' !== gettype( $post ) && ! isset( $atts['id'] ) ) {
			return $html;
		}

		// Check for ID attribute.
		if ( isset( $atts['id'] ) ) {
			$post_id = absint( $atts['id'] );
		} else {
			$post_id = $post->ID;
		}

		$post_type = get_post_type( $post_id );

		// Check to see if current post type is equal to the option set in the locator settings.
		if ( 'cpt' === $this->primary_option_vals['datasource'] && $post_type === $this->primary_option_vals['posttype'] ) {
			$address_options    = get_option( 'bh_storelocator_meta_options' );
			$address_parameters = array(
				'address',
				'address_2',
				'city',
				'state',
				'postal',
				'country',
				'phone',
				'email',
				'website',
			);

			// Check for multiple address fields or just 1 in the settings.
			if ( ! empty( $address_options['address'] ) && ! empty( $address_options['city'] ) ) {

				foreach ( $address_options as $address_option => $value ) {

					if ( ! empty( $value ) && in_array( $address_option, $address_parameters, true ) ) {

						// Get the custom meta values from the keys set in the Address Meta Settings.
						$address[ $address_option ] = get_post_meta( $post_id, $value, true );
					}
				}
			} elseif ( ! empty( $address_options['address'] ) ) {
				$address = $address_options['address'];
			}
		} elseif ( BH_Store_Locator::BH_SL_CPT === $post_type ) {

			$address['address']  = get_post_meta( $post_id, '_bh_sl_address', true );
			$address['address2'] = get_post_meta( $post_id, '_bh_sl_address_two', true );
			$address['city']     = get_post_meta( $post_id, '_bh_sl_city', true );
			$address['state']    = get_post_meta( $post_id, '_bh_sl_state', true );
			$address['postal']   = get_post_meta( $post_id, '_bh_sl_postal', true );
			$address['country']  = get_post_meta( $post_id, '_bh_sl_country', true );
			$address['phone']    = get_post_meta( $post_id, '_bh_sl_phone', true );
			$address['email']    = get_post_meta( $post_id, '_bh_sl_email', true );
			$address['website']  = get_post_meta( $post_id, '_bh_sl_web', true );
		}

		if ( count( $address ) === 0 ) {
			return $html;
		}

		// Get telephone code if country is set.
		if ( isset( $address['country'] ) && is_string( $address['country'] ) && 2 === strlen( $address['country'] ) ) {
			$country  = get_country_data( $address['country'] );
			$tel_code = '+' . $country['code'] . '-';
		} else {
			$tel_code = '';
		}

		// Filter for address components.
		$address = apply_filters( 'bh_sl_filter_single_address_components', $address );

		$html .= '<address class="bh-sl-single-address-wrap">';
		if ( array_key_exists( 'address', $address ) && $address['address'] ) {
			$html .= '<span class="bh-sl-single-address">' . esc_html( $address['address'] ) . '</span><br>';
		}
		if ( array_key_exists( 'address2', $address ) && $address['address2'] ) {
			$html .= '<span class="bh-sl-single-address2">' . esc_html( $address['address2'] ) . '</span><br>';
		}
		if ( array_key_exists( 'city', $address ) && $address['city'] ) {
			$html .= '<span class="bh-sl-single-city">' . esc_html( $address['city'] ) . '</span>';
		}
		if ( array_key_exists( 'state', $address ) && $address['state'] ) {
			$html .= ', <span class="bh-sl-single-state">' . esc_html( $address['state'] ) . '</span><br> ';
		}
		if ( array_key_exists( 'postal', $address ) && $address['postal'] ) {
			$html .= '<span class="bh-sl-single-postal">' . esc_html( $address['postal'] ) . '</span><br>';
		}
		if ( array_key_exists( 'country', $address ) && $address['country'] ) {
			$html .= '<span class="bh-sl-single-country">' . esc_html( $address['country'] ) . '</span><br>';
		}
		$html .= '</address>';

		if ( array_key_exists( 'phone', $address ) && $address['phone'] ) {
			$html .= '<a class="bh-sl-single-phone" href="tel:' . esc_attr( $tel_code . $address['phone'] ) . '">' . esc_html( $address['phone'] ) . '</a><br>';
		}
		if ( array_key_exists( 'email', $address ) && $address['email'] ) {
			$html .= '<a class="bh-sl-single-email" href="mailto:' . esc_attr( $address['email'] ) . '">' . esc_html( $address['email'] ) . '</a><br>';
		}
		if ( array_key_exists( 'website', $address ) && $address['website'] ) {
			$html .= '<a class="bh-sl-single-website" href="' . esc_attr( $address['website'] ) . '">' . esc_html( $address['website'] ) . '</a><br>';
		}

		// Filter for address markup.
		$html = apply_filters( 'bh_sl_filter_single_address_markup', $html, $address );

		return $html;
	}
}
