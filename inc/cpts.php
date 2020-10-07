<?php
add_action( 'init', 'register_my_posttypes' );
function register_my_posttypes() {

	// Example taxonomy
	//register_taxonomy(
	//	'project-type',
	//	'project',
	//	array(
	//		'label'              => 'Тип объекта',
	//		'show_in_rest'       => true,
	//		'publicly_queryable' => false, // remove tax term page and query parameters
	//		'hierarchical'       => true,
	//		'show_admin_column'  => true,
	//	)
	//);


	// Example CPT
	//$labels = array(
	//	'name'          => "Отзыв",
	//	'singular_name' => "Отзыв",
	//	'all_items'     => 'Все Отзывы',
	//	'archives'      => 'Отзывы',
	//	'add_new'       => 'Добавить новый',
	//	'menu_name'     => 'Отзывы'
	//);
	//$args   = array(
	//	'labels'        => $labels,
	//	'public'        => true,
	//	'show_in_rest'  => true,
	//	'has_archive'   => true,
	//	'menu_position' => 22,
	//	'menu_icon'     => 'dashicons-thumbs-up',
	//	'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt', 'revisions', 'page-attributes' ),
	//);
	//register_post_type( 'testimonial', $args );

	//https://developer.wordpress.org/resource/dashicons/
	/**
	2-3 — под «Консоль»
	4-9 — под «Записи»
	10-14 — под «Медиафайлы»
	15-19 — под «Ссылки»
	20-24 — под «Страницы»
	25-59 — под «Комментарии» (по умолчанию, null)
	60-64 — под «Внешний вид»
	65-69 — под «Плагины»
	70-74 — под «Пользователи»
	75-79 — под «Инструменты»
	80-99 — под «Параметры»
	*/

}
