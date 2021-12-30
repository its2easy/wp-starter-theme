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

	// Gutenberg
	add_theme_support( 'wp-block-styles' ); // include dist/block-library/theme.min.css inline
	add_theme_support( 'editor-styles' );

	$theme_system_path = get_template_directory();
	$distFolderPath = "$theme_system_path/dist";
	$manifest = theme_get_webpack_manifest_data($distFolderPath);
	$cssPath = '';
	if (array_key_exists('style', $manifest)) { // separate styles
		$cssPath = "dist/". $manifest['style'][0];
	}

	add_editor_style($cssPath);
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
	//add_image_size( 'entry_preview', 430, 300, array( 'center', 'center' ) );
}

/**
 * Adds a class to Gutenberg editor wrapper for styles scoping based on post type
 */
add_action( 'admin_print_footer_scripts', 'action_function_name_48586' );
function action_function_name_48586(){
	$isPost =  is_edit_or_new_cpt('post');
	$isPage =  is_edit_or_new_cpt('page');
	if ($isPost || $isPage  ) :
		?>
		<script type="text/javascript">
            window.addEventListener('load', function () {
                if ( !document.querySelector('body').classList.contains("block-editor-page") ) return;
                let postType = false;
                if (document.querySelector('body').classList.contains("post-type-post")) postType = "post";
                if (document.querySelector('body').classList.contains("post-type-page")) postType = "page";

                addEditorClass()
                function addEditorClass(){
                    let editor = document.querySelector('.block-editor-block-list__layout');

                    if ( !editor ) {
                        setTimeout(addEditorClass, 500);
                    } else {
                        editor.classList.add('type-' + postType);
                        console.log('added');
                    }
                }
            });
		</script>
	<?php
	endif;
}




