<?php
if ( ! defined( 'ABSPATH' ) ) exit;

function theme_scripts() {
	$version = wp_get_theme()->get( 'Version' );
	$theme = get_template();
	$assets_folder = 'dist';
	$theme_system_path = get_template_directory();
	$cssFile = 'css/style.css';
	$jsFile = 'js/main.js';

	$assetPrefix = "/wp-content/themes/$theme/$assets_folder/";
	$jsFileTime = filemtime( "$theme_system_path/$assets_folder/$jsFile" );
	$cssFileTime = filemtime( "$theme_system_path/$assets_folder/$cssFile" );

	wp_enqueue_style( 'gfonts-roboto', 'https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap');
	wp_deregister_script( 'jquery' );
	// If there is no jquery, you're gonna have problems
	wp_enqueue_script( 'jquery', get_template_directory_uri() .
	                             '/assets/js/vendor/jquery/jquery-3.5.0.min.js',
		array(), $version, false );

	// Old style scripts without compilation
	wp_enqueue_script( 'theme-scripts', get_template_directory_uri() . '/assets/js/app.js', array(), $version, true );

	// webpack assets (name based on webpack entry points)
	wp_enqueue_style( 'app-styles', $assetPrefix . $cssFile, array(), $cssFileTime);
	wp_enqueue_script( 'app-scripts', $assetPrefix . $jsFile, array(), $jsFileTime, true );

	wp_localize_script(
		'app-script', 'ajax_object', array(
			'ajax_url' => admin_url( 'admin-ajax.php' ),
			'nonce' => wp_create_nonce( 'theme_form' ),
		)
	);

}
add_action( 'wp_enqueue_scripts', 'theme_scripts' );

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
