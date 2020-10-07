<?php
if ( ! defined( 'ABSPATH' ) ) exit;

function sreda_scripts() {
	$version = wp_get_theme()->get( 'Version' );
	$assetPrefix = '';
	// PROD
	if (!defined('WP_ENVIRONMENT') || WP_ENVIRONMENT == "production") {
		$assetPrefix = get_template_directory_uri() . '/assets';
	} else { // DEV
		$assetPrefix = 'http://localhost:3000/wp-content/themes/wp-starter-theme/assets'; //todo fix
	}

	wp_enqueue_style( 'gfonts-roboto',
		'https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap');
	wp_deregister_script( 'jquery' );
	// If there is no jquery, you're gonna have problems
	wp_enqueue_script( 'jquery', get_template_directory_uri() . '/assets/js/vendor/jquery/jquery-3.5.0.min.js', array(), $version, true );
	// Old style scripts
	wp_enqueue_script( 'sreda-scripts', get_template_directory_uri() . '/assets/js/app.js', array(), $version, true );

	// webpack assets
	wp_enqueue_style( 'app-styles', $assetPrefix . '/css/main.css', array(), $version);
	wp_enqueue_script( 'app-scripts', $assetPrefix . '/js/main.js', array(), $version, true );

	wp_localize_script(
		'app-scripts', 'ajax_object', array(
			'ajax_url' => admin_url( 'admin-ajax.php' ),
			'nonce' => wp_create_nonce( 'theme_form' ),
		)
	);

}
add_action( 'wp_enqueue_scripts', 'sreda_scripts' );

// Remove wp-embed script
function theme_deregister_wp_embed(){
	wp_deregister_script( 'wp-embed' );
}
add_action( 'wp_footer', 'theme_deregister_wp_embed' );
// Remove gutenberg default blocks styles
function theme_remove_wp_block_library_css(){
	wp_dequeue_style( 'wp-block-library' );
}
add_action( 'wp_enqueue_scripts', 'theme_remove_wp_block_library_css', 100 );


// Add defer of async
//function theme_add_async_attribute( $tag, $handle ) {
//	if ( 'reCAPTCHA' !== $handle ) {
//		return $tag;
//	}
//	$async = str_replace( ' src', ' async="async" src', $tag );
//	$defer = str_replace( ' src', ' defer="defer" src', $async );
//	return $defer;
//}
//add_filter( 'script_loader_tag', 'theme_add_async_attribute', 10, 2 );
