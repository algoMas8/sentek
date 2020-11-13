<?php
/**
 * Locations post meta fields
 *
 * @package BH_Store_Locator
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class BH_Store_Locator_Post_Meta
 */
class BH_Store_Locator_Post_Meta {
	/**
	 * Hook into the appropriate actions when the class is constructed.
	 */
	public function __construct() {
		add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ) );
		add_action( 'save_post', array( $this, 'save' ) );
	}

	/**
	 * Adds the meta box container.
	 *
	 * @param string $post_type Post type.
	 */
	public function add_meta_box( $post_type ) {
		// Limit meta box to locations post type.
		$post_types = array( 'bh_sl_locations' );

		if ( in_array( $post_type, $post_types, true ) ) {
			add_meta_box(
				'locations_meta_box',
				__( 'Location fields', 'bh-storelocator' ),
				array( $this, 'render_meta_box_content' ),
				$post_type,
				'normal',
				'high'
			);
		}
	}

	/**
	 * Save the meta when the post is saved.
	 *
	 * @param integer $post_id Post ID.
	 *
	 * @return mixed
	 */
	public function save( $post_id ) {
		$nonce     = filter_input( INPUT_POST, 'bh_sl_inner_custom_box_nonce', FILTER_SANITIZE_STRING );
		$post_type = filter_input( INPUT_POST, 'post_type', FILTER_SANITIZE_STRING );

		/**
		 * We need to verify this came from the our screen and with proper authorization,
		 * because save_post can be triggered at other times.
		 */

		// Check if our nonce is set.
		if ( ! isset( $nonce ) ) {
			return $post_id;
		}

		// Verify that the nonce is valid.
		if ( ! wp_verify_nonce( $nonce, 'bh_sl_inner_custom_box' ) ) {
			return $post_id;
		}

		// If this is an autosave, our form has not been submitted, so we don't want to do anything.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return $post_id;
		}

		// Check the user's permissions.
		if ( 'page' === $post_type ) {

			if ( ! current_user_can( 'edit_page', $post_id ) ) {
				return $post_id;
			}
		} else {

			if ( ! current_user_can( 'edit_post', $post_id ) ) {
				return $post_id;
			}
		}

		/* OK, it's safe for us to save the data now. */

		// Sanitize the user input.
		$featured_location = filter_input( INPUT_POST, 'bh_sl_featured', FILTER_SANITIZE_STRING );
		$address           = filter_input( INPUT_POST, 'bh_sl_address', FILTER_SANITIZE_STRING );
		$address2          = filter_input( INPUT_POST, 'bh_sl_address_two', FILTER_SANITIZE_STRING );
		$city              = filter_input( INPUT_POST, 'bh_sl_city', FILTER_SANITIZE_STRING );
		$state             = filter_input( INPUT_POST, 'bh_sl_state', FILTER_SANITIZE_STRING );
		$postal            = filter_input( INPUT_POST, 'bh_sl_postal', FILTER_SANITIZE_STRING );
		$country           = filter_input( INPUT_POST, 'bh_sl_country', FILTER_SANITIZE_STRING );
		$phone             = filter_input( INPUT_POST, 'bh_sl_phone', FILTER_SANITIZE_STRING );
		$email             = filter_input( INPUT_POST, 'bh_sl_email', FILTER_SANITIZE_EMAIL );
		$fax               = filter_input( INPUT_POST, 'bh_sl_fax', FILTER_SANITIZE_STRING );
		$website           = filter_input( INPUT_POST, 'bh_sl_web', FILTER_SANITIZE_URL );
		$hours1            = filter_input( INPUT_POST, 'bh_sl_hours_one', FILTER_SANITIZE_STRING );
		$hours2            = filter_input( INPUT_POST, 'bh_sl_hours_two', FILTER_SANITIZE_STRING );
		$hours3            = filter_input( INPUT_POST, 'bh_sl_hours_three', FILTER_SANITIZE_STRING );
		$hours4            = filter_input( INPUT_POST, 'bh_sl_hours_four', FILTER_SANITIZE_STRING );
		$hours5            = filter_input( INPUT_POST, 'bh_sl_hours_five', FILTER_SANITIZE_STRING );
		$hours6            = filter_input( INPUT_POST, 'bh_sl_hours_six', FILTER_SANITIZE_STRING );
		$hours7            = filter_input( INPUT_POST, 'bh_sl_hours_seven', FILTER_SANITIZE_STRING );

		// Update the meta fields.
		update_post_meta( $post_id, '_bh_sl_featured', $featured_location );
		update_post_meta( $post_id, '_bh_sl_address', $address );
		update_post_meta( $post_id, '_bh_sl_address_two', $address2 );
		update_post_meta( $post_id, '_bh_sl_city', $city );
		update_post_meta( $post_id, '_bh_sl_state', $state );
		update_post_meta( $post_id, '_bh_sl_postal', $postal );
		update_post_meta( $post_id, '_bh_sl_country', $country );
		update_post_meta( $post_id, '_bh_sl_phone', $phone );
		update_post_meta( $post_id, '_bh_sl_email', $email );
		update_post_meta( $post_id, '_bh_sl_fax', $fax );
		update_post_meta( $post_id, '_bh_sl_web', $website );
		update_post_meta( $post_id, '_bh_sl_hours_one', $hours1 );
		update_post_meta( $post_id, '_bh_sl_hours_two', $hours2 );
		update_post_meta( $post_id, '_bh_sl_hours_three', $hours3 );
		update_post_meta( $post_id, '_bh_sl_hours_four', $hours4 );
		update_post_meta( $post_id, '_bh_sl_hours_five', $hours5 );
		update_post_meta( $post_id, '_bh_sl_hours_six', $hours6 );
		update_post_meta( $post_id, '_bh_sl_hours_seven', $hours7 );
	}


	/**
	 * Render Meta Box content.
	 *
	 * @param WP_Post $post The post object.
	 */
	public function render_meta_box_content( $post ) {

		// Add an nonce field so we can check for it later.
		wp_nonce_field( 'bh_sl_inner_custom_box', 'bh_sl_inner_custom_box_nonce' );

		// Use get_post_meta to retrieve existing values from the database.
		$featured_value    = get_post_meta( $post->ID, '_bh_sl_featured', true );
		$address_value     = get_post_meta( $post->ID, '_bh_sl_address', true );
		$address_two_value = get_post_meta( $post->ID, '_bh_sl_address_two', true );
		$city_value        = get_post_meta( $post->ID, '_bh_sl_city', true );
		$state_value       = get_post_meta( $post->ID, '_bh_sl_state', true );
		$postal_value      = get_post_meta( $post->ID, '_bh_sl_postal', true );
		$country_value     = get_post_meta( $post->ID, '_bh_sl_country', true );
		$phone_value       = get_post_meta( $post->ID, '_bh_sl_phone', true );
		$email_value       = get_post_meta( $post->ID, '_bh_sl_email', true );
		$fax_value         = get_post_meta( $post->ID, '_bh_sl_fax', true );
		$web_value         = get_post_meta( $post->ID, '_bh_sl_web', true );
		$hours_one_value   = get_post_meta( $post->ID, '_bh_sl_hours_one', true );
		$hours_two_value   = get_post_meta( $post->ID, '_bh_sl_hours_two', true );
		$hours_three_value = get_post_meta( $post->ID, '_bh_sl_hours_three', true );
		$hours_four_value  = get_post_meta( $post->ID, '_bh_sl_hours_four', true );
		$hours_five_value  = get_post_meta( $post->ID, '_bh_sl_hours_five', true );
		$hours_six_value   = get_post_meta( $post->ID, '_bh_sl_hours_six', true );
		$hours_seven_value = get_post_meta( $post->ID, '_bh_sl_hours_seven', true );

		// Featured location.
		$featured_field_args = array(
			'label_for' => 'bh_sl_featured',
			'name'      => 'bh_sl_featured',
			'value'     => esc_attr( $featured_value ),
		);

		bh_storelocator_meta_checkboxfield( $featured_field_args, __( 'Featured location', 'bh-storelocator' ), false );

		// Address field.
		$address_field_args = array(
			'label_for'   => 'bh_sl_address',
			'name'        => 'bh_sl_address',
			'value'       => esc_attr( $address_value ),
			'option_name' => 'bh_sl_locations_meta',
		);

		bh_storelocator_meta_textfield( $address_field_args, __( 'Address', 'bh-storelocator' ), false );

		// Address secondary field.
		$address2_field_args = array(
			'label_for' => 'bh_sl_address_two',
			'name'      => 'bh_sl_address_two',
			'value'     => esc_attr( $address_two_value ),
		);

		bh_storelocator_meta_textfield( $address2_field_args, __( 'Address 2', 'bh-storelocator' ), false );

		// City.
		$city_field_args = array(
			'label_for'   => 'bh_sl_city',
			'name'        => 'bh_sl_city',
			'value'       => esc_attr( $city_value ),
			'option_name' => 'bh_sl_locations_meta',
		);

		bh_storelocator_meta_textfield( $city_field_args, __( 'City', 'bh-storelocator' ), false );

		// State/Province.
		$state_field_args = array(
			'label_for' => 'bh_sl_state',
			'name'      => 'bh_sl_state',
			'value'     => esc_attr( $state_value ),
		);

		bh_storelocator_meta_textfield( $state_field_args, __( 'State/Province', 'bh-storelocator' ), false );

		// Postal code.
		$postal_field_args = array(
			'label_for' => 'bh_sl_postal',
			'name'      => 'bh_sl_postal',
			'value'     => esc_attr( $postal_value ),
		);

		bh_storelocator_meta_textfield( $postal_field_args, __( 'Postal Code', 'bh-storelocator' ), false );

		// Country.
		$country_field_args = array(
			'label_for' => 'bh_sl_country',
			'name'      => 'bh_sl_country',
			'value'     => esc_attr( $country_value ),
		);

		bh_storelocator_meta_textfield( $country_field_args, __( 'ccTLD two letter country code', 'bh-storelocator' ), false );

		// Phone.
		$phone_field_args = array(
			'label_for' => 'bh_sl_phone',
			'name'      => 'bh_sl_phone',
			'value'     => esc_attr( $phone_value ),
		);

		bh_storelocator_meta_textfield( $phone_field_args, __( 'Phone', 'bh-storelocator' ), false );

		// Fax.
		$fax_field_args = array(
			'label_for' => 'bh_sl_fax',
			'name'      => 'bh_sl_fax',
			'value'     => esc_attr( $fax_value ),
		);

		bh_storelocator_meta_textfield( $fax_field_args, __( 'Fax', 'bh-storelocator' ), false );

		// Email.
		$email_field_args = array(
			'label_for' => 'bh_sl_email',
			'name'      => 'bh_sl_email',
			'value'     => esc_attr( $email_value ),
		);

		bh_storelocator_meta_textfield( $email_field_args, __( 'Email', 'bh-storelocator' ), false );

		// Website.
		$website_field_args = array(
			'label_for' => 'bh_sl_web',
			'name'      => 'bh_sl_web',
			'value'     => esc_attr( $web_value ),
		);

		bh_storelocator_meta_urlfield( $website_field_args, __( 'Website', 'bh-storelocator' ), false );

		// Hours 1.
		$hours_one_field_args = array(
			'label_for' => 'bh_sl_hours_one',
			'name'      => 'bh_sl_hours_one',
			'value'     => esc_attr( $hours_one_value ),
		);

		bh_storelocator_meta_textfield( $hours_one_field_args, __( 'Hours 1', 'bh-storelocator' ), false );

		// Hours 2.
		$hours_two_field_args = array(
			'label_for' => 'bh_sl_hours_two',
			'name'      => 'bh_sl_hours_two',
			'value'     => esc_attr( $hours_two_value ),
		);

		bh_storelocator_meta_textfield( $hours_two_field_args, __( 'Hours 2', 'bh-storelocator' ), false );

		// Hours 3.
		$hours_three_field_args = array(
			'label_for' => 'bh_sl_hours_three',
			'name'      => 'bh_sl_hours_three',
			'value'     => esc_attr( $hours_three_value ),
		);

		bh_storelocator_meta_textfield( $hours_three_field_args, __( 'Hours 3', 'bh-storelocator' ), false );

		// Hours 4.
		$hours_four_field_args = array(
			'label_for' => 'bh_sl_hours_four',
			'name'      => 'bh_sl_hours_four',
			'value'     => esc_attr( $hours_four_value ),
		);

		bh_storelocator_meta_textfield( $hours_four_field_args, __( 'Hours 4', 'bh-storelocator' ), false );

		// Hours 5.
		$hours_five_field_args = array(
			'label_for' => 'bh_sl_hours_five',
			'name'      => 'bh_sl_hours_five',
			'value'     => esc_attr( $hours_five_value ),
		);

		bh_storelocator_meta_textfield( $hours_five_field_args, __( 'Hours 5', 'bh-storelocator' ), false );

		// Hours 6.
		$hours_six_field_args = array(
			'label_for' => 'bh_sl_hours_six',
			'name'      => 'bh_sl_hours_six',
			'value'     => esc_attr( $hours_six_value ),
		);

		bh_storelocator_meta_textfield( $hours_six_field_args, __( 'Hours 6', 'bh-storelocator' ), false );

		// Hours 7.
		$hours_seven_field_args = array(
			'label_for' => 'bh_sl_hours_seven',
			'name'      => 'bh_sl_hours_seven',
			'value'     => esc_attr( $hours_seven_value ),
		);

		bh_storelocator_meta_textfield( $hours_seven_field_args, __( 'Hours 7', 'bh-storelocator' ), false );
	}
}
