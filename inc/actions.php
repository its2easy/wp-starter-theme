<?php

if ( ! defined( 'ABSPATH' ) ) exit;

//добавление стандартных классов меню к функции
// Add standard menu classes to all menus
add_filter( 'wp_get_nav_menu_items', 'prefix_nav_menu_classes', 10, 3 );
function prefix_nav_menu_classes($items, $menu, $args) {
	_wp_menu_item_classes_by_context($items);
	return $items;
}

//Allow .svg files to upload (doesn't work in most cases)
function additional_mime_types( $mimes ) {
	$mimes['svg'] = 'image/svg+xml';
	return $mimes;
}
add_filter( 'upload_mimes', 'additional_mime_types' );


/*  by default hard crop doesn't crop too small images, this will upscale image to crop size */
function alx_thumbnail_upscale( $default, $orig_w, $orig_h, $new_w, $new_h, $crop ){
	if ( !$crop ) return null; // let the wordpress default function handle this

	$aspect_ratio = $orig_w / $orig_h;
	$size_ratio = max($new_w / $orig_w, $new_h / $orig_h);

	$crop_w = round($new_w / $size_ratio);
	$crop_h = round($new_h / $size_ratio);

	$s_x = floor( ($orig_w - $crop_w) / 2 );
	$s_y = floor( ($orig_h - $crop_h) / 2 );

	return array( 0, 0, (int) $s_x, (int) $s_y, (int) $new_w, (int) $new_h, (int) $crop_w, (int) $crop_h );
}
add_filter( 'image_resize_dimensions', 'alx_thumbnail_upscale', 10, 6 );

// Remove admin menu items
add_action( 'admin_menu', 'my_remove_menu_pages' );
function my_remove_menu_pages() {
	remove_menu_page( 'edit-comments.php' );          //Comments
	remove_submenu_page( 'edit.php', 'edit-tags.php?taxonomy=post_tag' );          //Tags
	remove_action('admin_menu', '_add_themes_utility_last', 101); // Theme editor
	remove_submenu_page( 'tools.php', 'import.php' );          // Import
	remove_submenu_page( 'tools.php', 'export.php' );          // Export
	remove_submenu_page( 'tools.php', 'export-personal-data.php' );          // Export personal data
	remove_submenu_page( 'tools.php', 'erase-personal-data.php' );          // Delete personal data
	remove_submenu_page( 'options-general.php', 'options-privacy.php' );          // Privacy

	// Customize
	remove_submenu_page('themes.php', 'customize.php?return=%2Fwp-admin%2Fthemes.php');
	$request = urlencode($_SERVER['REQUEST_URI']);
	remove_submenu_page('themes.php', 'customize.php?return='. $request);
};



// Set posts_per_page
//add_action( 'pre_get_posts', 'set_custom_posts_per_page' );
//function set_custom_posts_per_page( $query ) {
//	if ( ! is_admin() && $query->is_main_query() ) {
//
//	    if ($query->is_post_type_archive('project')) {
//		    $query->set('posts_per_page', 12);
//        }
//		if ($query->is_category) {
//			$query->set('posts_per_page', 10);
//		}
//	    if ($query->is_search) {
//		    $query->set('posts_per_page', 12);
//        }
//
//	}
//}