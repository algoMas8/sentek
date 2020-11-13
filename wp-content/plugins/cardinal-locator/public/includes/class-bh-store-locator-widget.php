<?php
/**
 * Map widget setup
 *
 * @package BH_Store_Locator
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class BH_Store_Locator_Widget
 */
class BH_Store_Locator_Widget extends WP_Widget {

	/**
	 * BH_Store_Locator_Widget constructor.
	 */
	public function __construct() {
		parent::__construct(
			'cardinal-map-widget',
			__( 'Cardinal Store Locator Single Map', 'bh-storelocator' ),
			array( 'description' => __( 'Displays a map of the location on a single location post.', 'bh-storelocator' ) )
		);
	}

	/**
	 * Front-end display of widget.
	 *
	 * @param array $args Widget arguments.
	 * @param array $instance Saved values.
	 */
	public function widget( $args, $instance ) {
		global $post;
		$primary_defaults    = BH_Store_Locator_Defaults::get_primary_defaults();
		$primary_option_vals = get_option( 'bh_storelocator_primary_options', $primary_defaults );

		if (
			'object' !== gettype( $post ) ||
			! is_single() ||
			( 'cpt' === $primary_option_vals['datasource'] && get_post_type() !== $primary_option_vals['posttype'] ) ||
			( 'locations' === $primary_option_vals['datasource'] && get_post_type() !== BH_Store_Locator::BH_SL_CPT )
		) {
			return;
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
			return;
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

		echo wp_kses_post( $args['before_widget'] );

		if ( ! empty( $instance['title'] ) ) {
			echo wp_kses_post( $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'] );
		}

		echo '<div id="bh-sl-map-widget" class="bh-sl-map-widget" data-lat="' . esc_attr( $lat ) . '" data-lng="' . esc_attr( $lng ) . '" data-zoom="' . esc_attr( $instance['zoom'] ) . '" data-cats="' . esc_attr( $cats ) . '"></div>';

		echo wp_kses_post( $args['after_widget'] );
	}

	/**
	 * Back-end widget form.
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		$form_markup = '';
		$title       = '';
		$zoom        = 16;

		// Check for saved title.
		if ( isset( $instance['title'] ) ) {
			$title = $instance['title'];
		}

		// Check for saved zoom setting.
		if ( isset( $instance['zoom'] ) ) {
			$zoom = $instance['zoom'];
		}

		$form_markup .= '<p><label for="' . $this->get_field_id( 'title' ) . '">' . __( 'Title:', 'bh-storelocator' ) . '</label>';
		$form_markup .= '<input class="widefat" id="' . $this->get_field_id( 'title' ) . '" name="' . $this->get_field_name( 'title' ) . '" type="text" value="' . esc_attr( $title ) . '"></p>';

		$form_markup .= '<p><label for="' . $this->get_field_id( 'zoom' ) . '">' . __( 'Zoom:', 'bh-storelocator' ) . '</label>';
		$form_markup .= '<input id="' . $this->get_field_id( 'zoom' ) . '" name="' . $this->get_field_name( 'zoom' ) . '" type="number" min="0" max="50" step="1" value="' . esc_attr( $zoom ) . '"></p>';

		echo wp_kses(
			$form_markup,
			array(
				'p'     => array(),
				'label' => array( 'for' => array() ),
				'input' => array(
					'class' => array(),
					'id'    => array(),
					'name'  => array(),
					'type'  => array(),
					'min'   => array(),
					'max'   => array(),
					'step'  => array(),
					'value' => array(),
				),
			)
		);
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance          = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? wp_strip_all_tags( $new_instance['title'] ) : '';
		$instance['zoom']  = ( ! empty( $new_instance['zoom'] ) ) ? wp_strip_all_tags( $new_instance['zoom'] ) : '';
		return $instance;
	}
}

/**
 * Register the map widget.
 */
function bh_storelocator_register_map_widget() {
	register_widget( 'BH_Store_Locator_Widget' );
}

add_action( 'widgets_init', 'bh_storelocator_register_map_widget' );
