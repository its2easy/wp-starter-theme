<?php
use Carbon_Fields\Container;
use Carbon_Fields\Field;

/**
 * Taxonomies options
 */
add_action( 'carbon_fields_register_fields', 'crb_attach_term_fields' );
function crb_attach_term_fields() {

}

//echo carbon_get_term_meta( $category->term_id, 'crb_editor' );