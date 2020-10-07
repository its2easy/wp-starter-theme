<?php
/**
 * Inspired by Simon Bradburys cleanup.php from b4st theme https://github.com/SimonPadbury/b4st
 *
 */
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Removes the generator tag with WP version numbers. Hackers will use this to find weak and old WP installs
 *
 * @return string
 */
function no_generator() {
    return '';
}
add_filter( 'the_generator', 'no_generator' );

/*
Clean up wp_head() from unused or unsecure stuff
*/
function theme_cleanup(){
	remove_action('wp_head', 'wp_generator');
	remove_action('wp_head', 'rsd_link');
	remove_action('wp_head', 'wlwmanifest_link');
	remove_action('wp_head', 'index_rel_link');
	remove_action('wp_head', 'feed_links', 2);
	remove_action('wp_head', 'feed_links_extra', 3);
	remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10);
	remove_action('wp_head', 'start_post_rel_link');
	remove_action('wp_head', 'wp_shortlink_wp_head', 10);
	remove_action('template_redirect', 'rest_output_link_header', 11);
	remove_action('wp_head', 'rest_output_link_wp_head', 10);
	remove_action( 'wp_head', 'wp_resource_hints', 2 );

	//emoji
	remove_action('wp_head', 'print_emoji_detection_script', 7);
	remove_action('wp_print_styles', 'print_emoji_styles');
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
}
add_action('init', 'theme_cleanup');

// Embeds
function disable_embeds_code_init() {
	// Remove the REST API endpoint.
	remove_action( 'rest_api_init', 'wp_oembed_register_route' );

	// Turn off oEmbed auto discovery.
	add_filter( 'embed_oembed_discover', '__return_false' );

	// Don't filter oEmbed results.
	remove_filter( 'oembed_dataparse', 'wp_filter_oembed_result', 10 );

	// Remove oEmbed discovery links.
	remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );

	// Remove oEmbed-specific JavaScript from the front-end and back-end.
	remove_action( 'wp_head', 'wp_oembed_add_host_js' );

	add_filter( 'tiny_mce_plugins', 'disable_embeds_tiny_mce_plugin' );

	// Remove all embeds rewrite rules.
	add_filter( 'rewrite_rules_array', 'disable_embeds_rewrites' );

	// Remove filter of the oEmbed result before any HTTP requests are made.
	remove_filter( 'pre_oembed_result', 'wp_filter_pre_oembed_result', 10 );
}
add_action( 'init', 'disable_embeds_code_init', 9999 );

function disable_embeds_tiny_mce_plugin($plugins) {
	return array_diff( $plugins, array('wpembed') );
}
function disable_embeds_rewrites ($rules) {
	foreach($rules as $rule => $rewrite) {
		if(false !== strpos($rewrite, 'embed=true')) {
			unset($rules[$rule]);
		}
	}
	return $rules;
}

// Show less info to users on failed login for security.
// (Will not let a valid username be known.)
if ( ! function_exists('show_less_login_info') ) {
	function show_less_login_info() {
		return "<strong>Error</strong>: Stop guessing!";
	}
}
add_filter( 'login_errors', 'show_less_login_info' );

// disable XML-RPC
add_filter( 'xmlrpc_enabled', '__return_false' );

// Disable RSS
function theme_disable_rss_feed() {
	wp_die( __( 'No feed available, please visit the <a rel="noopener" href="'. esc_url( home_url( '/' ) ) .'">homepage</a>!' ) );
}
add_action('do_feed', 'theme_disable_rss_feed', 1);
add_action('do_feed_rdf', 'theme_disable_rss_feed', 1);
add_action('do_feed_rss', 'theme_disable_rss_feed', 1);
add_action('do_feed_rss2', 'theme_disable_rss_feed', 1);
add_action('do_feed_atom', 'theme_disable_rss_feed', 1);
add_action('do_feed_rss2_comments', 'theme_disable_rss_feed', 1);
add_action('do_feed_atom_comments', 'theme_disable_rss_feed', 1);

// Disable self pingback
function no_self_ping( &$links ) {
	$home = get_option( 'home' );
	foreach ( $links as $l => $link ) {
		if ( 0 === strpos( $link, $home ) ) {
			unset( $links[ $l ] );
		}
	}
}
add_action( 'pre_ping', 'no_self_ping' );