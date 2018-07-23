<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * render checkbox output 
 * @since 0.0.1
 * @param array $field_details
 * @param boolean|int $field_value
 * @return void
 */

function fieldpress_render_checkbox( $field_details, $field_value ) {
	
	/*defaults attributes */
	$default_attr = apply_filters( 'fieldpress_checkbox_field_default_args',array(
		'type'          => 'checkbox',
		'id'            => '',
		'class'         => '',
		'style'         => '',
	) );
	$field_attr = $field_details['attr'];
	$attributes = wp_parse_args( $field_attr, $default_attr );
	$attributes['type'] = 'checkbox'; /*force any type to checkbox*/

	$choices = ( isset( $field_details['choices'] ) ? $field_details['choices'] : '' );
	$query_args = ( isset( $field_details['query_args'] ) ? $field_details['query_args'] : array() );

	$output = '<ul>';
	if ( !empty( $choices ) ){
		$choices  = ( is_array( $choices ) ) ? $choices : fieldpress_get_choices( $choices, $query_args );
		$attributes['name'] = $attributes['name'].'[]';
		foreach ( $choices as $choice_value => $choice ) {
			$attributes['value'] = $choice_value;
			$output .= '<li>';
			$output .= '<label>';
			$output .= '<input ';

			foreach ( $attributes as $name => $value ) {
				$output .= sprintf('%1$s="%2$s"', esc_attr( $name ), esc_attr( $value ));
			}
			if( is_array( $field_value )){
				$output .= checked( in_array( $choice_value, $field_value ), true, false );
			}
			$output .= '>';
			$output .= ( isset( $choice ) ?  esc_html( $choice ): '' );
			$output .= '</label>';
			$output .= '</li>';
		}
	}
	else{
		$output .= '<li>';
		$output .= '<label>';
		$output .= '<input ';
		foreach ($attributes as $name => $value) {
			$output .= sprintf('%1$s="%2$s"', esc_attr( $name ), esc_attr( $value ));
		}
		$output .= checked( $field_value, true, false) ;
		$output .= '>';
		$output .= ( isset( $field_details['checkbox-label'] ) ?  esc_html( $field_details['checkbox-label'] ) : '' );
		$output .= '</label>';
		$output .= '</li>';
	}
	$output .= '</ul>';
	echo $output;
}