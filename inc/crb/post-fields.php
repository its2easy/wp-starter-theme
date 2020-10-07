<?php
use Carbon_Fields\Container;
use Carbon_Fields\Field;

/**
 * Post type options
 */
add_action( 'carbon_fields_register_fields', 'crb_attach_post_fields' );
function crb_attach_post_fields() {

	// FRONTPAGE
	Container::make( 'post_meta', 'homepage_container', 'Настройки "Главной"' )
	         ->where( 'post_type', '=', 'page' )
	         ->where( 'post_id', '=', get_option( 'page_on_front' ) )
	         ->add_tab( 'Основное', array(

	         ) )
	         ->add_tab( 'Другое', array(

	         ) );

}

//echo carbon_get_post_meta( get_the_ID(), 'crb_location' );