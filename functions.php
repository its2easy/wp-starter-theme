<?php
if ( ! defined( 'ABSPATH' ) ) exit;

require get_template_directory() . '/inc/utils.php';// Functions
require get_template_directory() . '/inc/template-functions.php';// Functions
require get_template_directory() . '/inc/template-tags.php';// Template blocks
require get_template_directory() . '/inc/setup.php'; //Theme setup
require get_template_directory() . '/inc/cpts.php'; // Custom post types
require get_template_directory() . '/inc/actions.php';// Hooks and filters
require get_template_directory() . '/inc/enqueue.php';// Scripts and styles
require get_template_directory() . '/inc/security.php';// Cleanup
require get_template_directory() . '/inc/crb/crb.php';//Custom fields (Carbon Fields)
//require get_template_directory() . '/inc/acf/acf.php';//Custom fields (ACF)
require get_template_directory() . '/inc/mail.php'; // Email




