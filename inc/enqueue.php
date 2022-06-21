<?php
if ( ! defined( 'ABSPATH' ) ) exit;

function theme_scripts() {
	if (is_admin()) return; // Fix wp5.8 new widgets which load frontend assets on backend widgets page

	// 1) Variables
	$version = wp_get_theme()->get( 'Version' );
	$theme = get_template();
	$assetsFolder = 'dist';
	$assetUrlPrefix = "/wp-content/themes/$theme/$assetsFolder";
	$clearJsFileRE = ['/^js\//', '/\.js$/'];
	$clearCssFileRE = ['/^css\//', '/\.css$/'];

	//gulp version
	//$cssFile = 'css/style.css';
	//$jsFile = 'js/main.js';
	//$themeSystemPath = get_template_directory();
	////$jsFileTime = filemtime( "$themeSystemPath/$assetsFolder/$jsFile" );
	//$cssFileTime = filemtime( "$themeSystemPath/$assetsFolder/$cssFile" );

	// 2) Preparation
	//webpack version
	$manifest = theme_get_webpack_manifest_data(get_template_directory() . '/' . $assetsFolder);
	$jsQueue = array(); // scripts to be printed on current page
	$cssQueue = array(); // styles to enqueue
	$entrypoints = array('main', 'style'); // common js and common css

	foreach ($entrypoints as $entrypoint) {
		if ( !array_key_exists($entrypoint, $manifest)) continue; // only if there are scripts for this entrypoint
		foreach ($manifest[$entrypoint] as $asset){ // scripts and styles inside entrypoint
			if (theme_get_filename_ext($asset) == "js") $queue = &$jsQueue;
			else $queue = &$cssQueue;

			if ( !in_array($asset, $queue) ) {$queue[] = $asset; } // add asset, but skip duplicated
		}
	}

	// 3) Enqueue
	//webpack version
	foreach ($cssQueue as $cssFile) {
		wp_enqueue_style( 'app-' . preg_replace($clearCssFileRE, '', $cssFile) ,
			"$assetUrlPrefix/$cssFile", array(), null );
	}
	foreach ($jsQueue as $jsFile){
		wp_enqueue_script( "theme-".preg_replace($clearJsFileRE, '', $jsFile),
			"$assetUrlPrefix/$jsFile", array(), null, true );
	}

	// gulp version
	//wp_enqueue_style( 'app-styles', $assetUrlPrefix . '/' . $cssFile, array(), $cssFileTime);
	//wp_enqueue_script( 'app-scripts', $assetUrlPrefix . '/' . $jsFile, array(), $jsFileTime, true );


	// 4) Static assets
	wp_enqueue_style( 'gfonts-roboto', 'https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap');
	wp_deregister_script( 'jquery' );
	// If there is no jquery, you're gonna have problems
	wp_enqueue_script( 'jquery', get_template_directory_uri() . '/assets/js/vendor/jquery/jquery-3.6.0.min.js',
		array(), $version, false );
	// Old style scripts without compilation
	wp_enqueue_script( 'theme-scripts', get_template_directory_uri() . '/assets/js/app.js', array(), $version, true );

	// 5) Additional data
	if ( !empty($jsQueue) ) {
		$jsHandle = "theme-" . preg_replace($clearJsFileRE, '', $jsQueue[0]); //webpack version
	} else {
		$jsHandle = "theme-scripts";
	}

	//$jsHandle = "theme-scripts"; //gulp version
	wp_localize_script(
		$jsHandle, 'ajax_object', array(
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
	// 80kb dist/block-library/style.min.css, previously imported in vendors.scss
	if ( !is_singular() ) { //disable if not singular
		wp_dequeue_style( 'wp-block-library' );
	}
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
