<?php
/**
 * Field setup helper functions
 *
 * @package BH_Store_Locator
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Generic text field
 *
 * @param array  $args label, name, value, option name.
 * @param string $description field description.
 * @param bool   $conditional field is dependant on another field.
 */
function bh_storelocator_textfield( $args, $description = '', $conditional = false ) {
	$conditional_val = ( true === $conditional ) ? 'conditional' : '';

	printf(
		'<input type="text" name="%1$s[%2$s]" id="%3$s" value="%4$s" class="%5$s" size="45">',
		esc_html( $args['option_name'] ),
		esc_html( $args['name'] ),
		esc_html( $args['label_for'] ),
		esc_html( $args['value'] ),
		esc_html( $conditional_val )
	);

	if ( '' !== $description ) {
		echo wp_kses( '<p class="description">' . $description . '</p>', array( 'p' => array( 'class' => array() ), 'a' => array( 'href' => array(), 'target' => array(), 'rel' => array() ), 'ul' => array(), 'li' => array(), 'br' => array() ) );
	}
}

/**
 * Generic text field - regular text for longer fields
 *
 * @param array  $args label, name, value, option name.
 * @param string $description field description.
 * @param bool   $conditional field is dependant on another field.
 */
function bh_storelocator_regulartextfield( $args, $description = '', $conditional = false ) {
	$conditional_val = ( true === $conditional ) ? 'conditional' : '';

	printf(
		'<input type="text" name="%1$s[%2$s]" id="%3$s" value="%4$s" class="regular-text">',
		esc_html( $args['option_name'] ),
		esc_html( $args['name'] ),
		esc_html( $args['label_for'] ),
		esc_html( $args['value'] ),
		esc_html( $conditional_val )
	);

	if ( '' !== $description ) {
		echo wp_kses( '<p class="description">' . $description . '</p>', array( 'p' => array( 'class' => array() ), 'a' => array( 'href' => array(), 'target' => array(), 'rel' => array() ), 'ul' => array(), 'li' => array(), 'br' => array() ) );
	}
}

/**
 * Generic email field
 *
 * @param array  $args label, name, value, option name.
 * @param string $description field description.
 * @param bool   $conditional field is dependant on another field.
 */
function bh_storelocator_emailfield( $args, $description = '', $conditional = false ) {
	$conditional_val = ( true === $conditional ) ? 'conditional' : '';

	printf(
		'<input type="email" name="%1$s[%2$s]" id="%3$s" value="%4$s" class="%5$s" size="45">',
		esc_html( $args['option_name'] ),
		esc_html( $args['name'] ),
		esc_html( $args['label_for'] ),
		esc_html( $args['value'] ),
		esc_html( $conditional_val )
	);

	if ( '' !== $description ) {
		echo wp_kses( '<p class="description">' . $description . '</p>', array( 'p' => array( 'class' => array() ), 'a' => array( 'href' => array(), 'target' => array(), 'rel' => array() ), 'ul' => array(), 'li' => array(), 'br' => array() ) );
	}
}

/**
 * Generic URL field
 *
 * @param array  $args label, name, value, option name.
 * @param string $description field description.
 * @param bool   $conditional field is dependant on another field.
 */
function bh_storelocator_urlfield( $args, $description = '', $conditional = false ) {
	$conditional_val = ( true === $conditional ) ? 'conditional' : '';

	printf(
		'<input type="url" name="%1$s[%2$s]" id="%3$s" value="%4$s" class="%5$s" size="45">',
		esc_html( $args['option_name'] ),
		esc_html( $args['name'] ),
		esc_html( $args['label_for'] ),
		esc_html( $args['value'] ),
		esc_html( $conditional_val )
	);

	if ( '' !== $description ) {
		echo wp_kses( '<p class="description">' . $description . '</p>', array( 'p' => array( 'class' => array() ), 'a' => array( 'href' => array(), 'target' => array(), 'rel' => array() ), 'ul' => array(), 'li' => array(), 'br' => array() ) );
	}
}

/**
 * Generic telephone field
 *
 * @param array  $args label, name, value, option name.
 * @param string $description field description.
 * @param bool   $conditional field is dependant on another field.
 */
function bh_storelocator_telfield( $args, $description = '', $conditional = false ) {
	$conditional_val = ( true === $conditional ) ? 'conditional' : '';

	printf(
		'<input type="tel" name="%1$s[%2$s]" id="%3$s" value="%4$s" class="%5$s" size="45">',
		esc_html( $args['option_name'] ),
		esc_html( $args['name'] ),
		esc_html( $args['label_for'] ),
		esc_html( $args['value'] ),
		esc_html( $conditional_val )
	);

	if ( '' !== $description ) {
		echo wp_kses( '<p class="description">' . $description . '</p>', array( 'p' => array( 'class' => array() ), 'a' => array( 'href' => array(), 'target' => array(), 'rel' => array() ), 'ul' => array(), 'li' => array(), 'br' => array() ) );
	}
}

/**
 * Generic textarea field
 *
 * @param array  $args label, name, value, option name.
 * @param string $description field description.
 * @param bool   $conditional field is dependant on another field.
 */
function bh_storelocator_textareafield( $args, $description = '', $conditional = false ) {
	$conditional_val = ( true === $conditional ) ? 'conditional' : '';

	printf(
		'<textarea cols="50" rows="10" name="%1$s[%2$s]" id="%3$s" class="large-text code %5$s">%4$s</textarea>',
		esc_html( $args['option_name'] ),
		esc_html( $args['name'] ),
		esc_html( $args['label_for'] ),
		esc_html( $args['value'] ),
		esc_html( $conditional_val )
	);

	if ( '' !== $description ) {
		echo wp_kses( '<p class="description">' . $description . '</p>', array( 'p' => array( 'class' => array() ), 'a' => array( 'href' => array(), 'target' => array(), 'rel' => array() ), 'ul' => array(), 'li' => array(), 'br' => array() ) );
	}
}

/**
 * Generic select field
 *
 * @param array  $args $args label, name, value, option name.
 * @param string $description field description.
 * @param bool   $conditional field is dependant on another field.
 */
function bh_storelocator_selectfield( $args, $description = '', $conditional = false ) {
	$conditional_val = ( true === $conditional ) ? 'conditional' : '';

	printf(
		'<select name="%1$s[%2$s]" id="%3$s" class="%4$s">',
		esc_html( $args['option_name'] ),
		esc_html( $args['name'] ),
		esc_html( $args['label_for'] ),
		esc_html( $conditional_val )
	);

	foreach ( $args['options'] as $val => $title ) {
		printf(
			'<option value="%1$s" %2$s>%3$s</option>',
			esc_html( $val ),
			selected( $val, $args['value'], false ),
			esc_html( $title )
		);
	}

	echo '</select>';

	if ( '' !== $description ) {
		echo wp_kses( '<p class="description">' . $description . '</p>', array( 'p' => array( 'class' => array() ), 'a' => array( 'href' => array(), 'target' => array(), 'rel' => array() ), 'ul' => array(), 'li' => array(), 'br' => array() ) );
	}
}

/**
 * Generic color field
 *
 * @param array $args label, name, value, option name.
 */
function bh_storelocator_colorfield( $args ) {
	printf(
		'<input name="%1$s[%2$s]" id="%3$s" value="%4$s" class="color-field" data-default-color="%4$s">',
		esc_html( $args['option_name'] ),
		esc_html( $args['name'] ),
		esc_html( $args['label_for'] ),
		esc_html( $args['value'] )
	);
}

/**
 * Generic image upload field
 *
 * @param array  $args label, name, value, option name.
 * @param string $description field description.
 * @param bool   $conditional field is dependant on another field.
 */
function bh_storelocator_imagefield( $args, $description = '', $conditional = false ) {
	$conditional_val = ( true === $conditional ) ? 'conditional' : '';

	printf(
		'<input name="%1$s[%2$s]" id="%3$s" value="%4$s" class="%5$s" size="45">',
		esc_html( $args['option_name'] ),
		esc_html( $args['name'] ),
		esc_html( $args['label_for'] ),
		esc_html( $args['value'] ),
		esc_html( $conditional_val )
	);

	printf(
		'<input class="upload-img-btn" type="button" value="Upload Image">'
	);

	if ( '' !== $description ) {
		echo wp_kses( '<p class="description">' . $description . '</p>', array( 'p' => array( 'class' => array() ), 'a' => array( 'href' => array(), 'target' => array(), 'rel' => array() ), 'ul' => array(), 'li' => array(), 'br' => array() ) );
	}
}

/**
 * Image dimensions field
 *
 * @param array  $args label, name, value, option name.
 * @param string $description field description.
 * @param bool   $conditional field is dependant on another field.
 */
function bh_storelocator_imagedimfield( $args, $description = '', $conditional = false ) {
	$conditional_val = ( true === $conditional ) ? 'conditional' : '';

	echo '<label class="bh-sl-imgdimlabel" for="' . esc_html( $args['label_for'] . 'width' ) . '">Width</label>';

	printf(
		'<input type="number" min="0" step="1" name="%1$s[%2$s]" id="%3$s" value="%4$s" class="small-text bh-sl-imgdiminput %5$s">',
		esc_html( $args['option_name'] ),
		esc_html( $args['name'] . 'width' ),
		esc_html( $args['label_for'] . 'width' ),
		esc_html( $args['value-width'] ),
		esc_html( $conditional_val )
	);

	echo '<label class="bh-sl-imgdimlabel" for="' . esc_html( $args['label_for'] . 'height' ) . '">Height</label>';

	printf(
		'<input type="number" min="0" step="1" name="%1$s[%2$s]" id="%3$s" value="%4$s" class="small-text bh-sl-imgdiminput %5$s">',
		esc_html( $args['option_name'] ),
		esc_html( $args['name'] . 'height' ),
		esc_html( $args['label_for'] . 'height' ),
		esc_html( $args['value-height'] ),
		esc_html( $conditional_val )
	);

	if ( '' !== $description ) {
		echo wp_kses( '<p class="description">' . $description . '</p>', array( 'p' => array( 'class' => array() ), 'a' => array( 'href' => array(), 'target' => array(), 'rel' => array() ), 'ul' => array(), 'li' => array(), 'br' => array() ) );
	}
}

/**
 * Number field
 *
 * @param array  $args label, name, value, option name.
 * @param string $description field description.
 * @param bool   $conditional field is dependant on another field.
 */
function bh_storelocator_numberfield( $args, $description = '', $conditional = false ) {
	$conditional_val = ( true === $conditional ) ? 'conditional' : '';

	printf(
		'<input type="number" min="%5$s" max="%6$s" step="1" name="%1$s[%2$s]" id="%3$s" value="%4$s" class="small-text bh-sl-imgdiminput %7$s">',
		esc_html( $args['option_name'] ),
		esc_html( $args['name'] ),
		esc_html( $args['label_for'] ),
		esc_html( $args['value'] ),
		esc_html( $args['min'] ),
		esc_html( $args['max'] ),
		esc_html( $conditional_val )
	);

	if ( '' !== $description ) {
		echo wp_kses( '<p class="description">' . $description . '</p>', array( 'p' => array( 'class' => array() ), 'a' => array( 'href' => array(), 'target' => array(), 'rel' => array() ), 'ul' => array(), 'li' => array(), 'br' => array() ) );
	}
}

/**
 * Generic checkbox field
 *
 * @param array  $args label, name, value, option name.
 * @param string $description field description.
 * @param bool   $conditional field is dependant on another field.
 */
function bh_storelocator_checkboxfield( $args, $description = '', $conditional = false ) {
	$conditional_val = ( true === $conditional ) ? 'conditional' : '';

	printf(
		'<label class="bh-sl-checkbox" for="%3$s"><input type="checkbox" name="%1$s[%2$s]" id="%3$s" value="1" class="%5$s" %7$s>%6$s</label>',
		esc_html( $args['option_name'] ),
		esc_html( $args['name'] ),
		esc_html( $args['label_for'] ),
		esc_html( $args['value'] ),
		esc_html( $conditional_val ),
		wp_kses( $description, array( 'a' => array( 'href' => array(), 'target' => array(), 'rel' => array() ) ) ),
		checked( '1', $args['value'], false )
	);
}

/**
 * Generic text field for meta
 *
 * @param array  $args label, name, value, option name.
 * @param string $description field description.
 * @param bool   $conditional field is dependant on another field.
 */
function bh_storelocator_meta_textfield( $args, $description = '', $conditional = false ) {
	$conditional_val = ( true === $conditional ) ? 'conditional' : '';

	printf(
		'<input type="text" name="%1$s" id="%2$s" value="%3$s" class="%4$s" size="45">',
		esc_html( $args['name'] ),
		esc_html( $args['label_for'] ),
		esc_html( $args['value'] ),
		esc_html( $conditional_val )
	);

	if ( '' !== $description ) {
		echo wp_kses( '<p class="description ' . $args['name'] . '-label">' . $description . '</p>', array( 'p' => array( 'class' => array() ), 'a' => array( 'href' => array(), 'target' => array(), 'rel' => array() ), 'ul' => array(), 'li' => array(), 'br' => array() ) );
	}
}

/**
 * Generic checkbox field for meta
 *
 * @param array  $args label, name, value, option name.
 * @param string $description field description.
 * @param bool   $conditional field is dependant on another field.
 */
function bh_storelocator_meta_checkboxfield( $args, $description = '', $conditional = false ) {
	$conditional_val = ( true === $conditional ) ? 'conditional' : '';

	printf(
		'<label class="bh-sl-checkbox" for="%2$s"><input type="checkbox" name="%1$s" id="%2$s" value="1" class="%4$s" %6$s>%5$s</label>',
		esc_html( $args['name'] ),
		esc_html( $args['label_for'] ),
		esc_html( $args['value'] ),
		esc_html( $conditional_val ),
		wp_kses( $description, array( 'a' => array( 'href' => array(), 'target' => array(), 'rel' => array() ) ) ),
		checked( '1', $args['value'], false )
	);
}

/**
 * Generic URL field for meta
 *
 * @param array  $args label, name, value, option name.
 * @param string $description field description.
 * @param bool   $conditional field is dependant on another field.
 */
function bh_storelocator_meta_urlfield( $args, $description = '', $conditional = false ) {
	$conditional_val = ( true === $conditional ) ? 'conditional' : '';

	printf(
		'<input type="url" name="%1$s" id="%2$s" value="%3$s" class="%4$s" size="45">',
		esc_html( $args['name'] ),
		esc_html( $args['label_for'] ),
		esc_html( $args['value'] ),
		esc_html( $conditional_val )
	);

	if ( '' !== $description ) {
		echo wp_kses( '<p class="description">' . $description . '</p>', array( 'p' => array( 'class' => array() ), 'a' => array( 'href' => array(), 'target' => array(), 'rel' => array() ), 'ul' => array(), 'li' => array(), 'br' => array() ) );
	}
}
