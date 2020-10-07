<?php
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'after_setup_theme', 'theme_setup' );
function theme_setup() {
	//load_theme_textdomain( 'wp-starter-theme', get_template_directory() . '/languages' );

	register_nav_menus( array(
		'primary' => "Главное",
		'footer1' => "Подвал 1",
	) );

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'customize-selective-refresh-widgets' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'align-wide' ); // wide align for images in gutenberg
	//add_theme_support( 'editor-styles' ); // enable custom styles for gutenberg
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
		'script',
		'style'
	) );
}


add_action( 'widgets_init', 'theme_widgets_init' );
function theme_widgets_init() {
	register_sidebar( array(
		'name'          => 'Главный сайдбар',
		'id'            => 'sidebar-1',
		'description'   => 'Будет отображаться сбоку',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}


add_action( 'after_setup_theme', 'theme_after_setup' );
function theme_after_setup() {
	//remove_image_size('shop_single');
	add_image_size( 'entry_preview', 430, 300, array( 'center', 'center' ) );
}



