<?php
add_action('acf/init', 'theme_acf_add_options_page');
function theme_acf_add_options_page() {
	if( !function_exists('acf_add_options_page') ) return;

	acf_add_options_page(array(
		'page_title' 	=> 'Настройки темы',
		'menu_title'	=> 'Настройки темы',
		'menu_slug' 	=> 'theme-general-settings',
		'capability'	=> 'edit_posts',
		'position'      => '2',
		'icon_url'      => 'dashicons-admin-generic',
		'redirect'		=> true,
		'autoload'      => false,
	));


	acf_add_local_field_group(array(
		'key' => 'group_628f60926db6d',
		'title' => 'Опции темы',
		'location' => array(
			array(
				array(
					'param' => 'options_page',
					'operator' => '==',
					'value' => 'theme-general-settings',
				),
			),
		),
		'menu_order' => 0,
		'position' => 'normal',
		'style' => 'default',
		'label_placement' => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen' => '',
		'active' => true,
		'show_in_rest' => 0,

		'fields' => array_merge(
			theme_options__get_general_tab(),
			theme_options__get_scripts_tab(),
			theme_options__get_socials_tab(),
			theme_options__get_other_tab()
		),
	));

}

// ОБЩИЕ
function theme_options__get_general_tab(){
	return array(
		array(
			'key' => 'field_628f60b265d94',
			'label' => 'Общие',
			'name' => '',
			'type' => 'tab',
			'placement' => 'top',
			'endpoint' => 0,
		),
		array(
			'key' => 'field_628f61f265d95',
			'label' => 'Получатели писем',
			'name' => 'theme_email_recipients',
			'type' => 'repeater',
			'required' => 1,
			'collapsed' => 'field_628f621f65d96',
			'min' => 1,
			'max' => 0,
			'layout' => 'table',
			'button_label' => 'Добавить email',
			'sub_fields' => array(
				array(
					'key' => 'field_628f621f65d96',
					'label' => 'Email',
					'name' => 'email',
					'type' => 'email',
				),
			),
		)
	);
}

// СКРИПТЫ
function theme_options__get_scripts_tab(){
	return array(
		array(
			'key' => 'field_628f626765d97',
			'label' => 'Скрипты',
			'name' => '',
			'type' => 'tab',
			'placement' => 'top',
			'endpoint' => 0,
		),
		array(
			'key' => 'field_628f628a65d98',
			'label' => 'Будет вставлено перед &lt;/head&gt;',
			'name' => 'theme_head_script',
			'type' => 'textarea',
		),
		array(
			'key' => 'field_628f64c5c6636',
			'label' => 'Будет вставлено после &lt;body&gt;',
			'name' => 'theme_body_start_script',
			'type' => 'textarea',
		),
		array(
			'key' => 'field_628f64f1c6637',
			'label' => 'Будет вставлено после &lt;/body&gt;',
			'name' => 'theme_body_end_script',
			'type' => 'textarea',
		),
	);
}

// СОЦ. СЕТИ
function theme_options__get_socials_tab(){
	return array(
		array(
			'key' => 'field_628f65496489f',
			'label' => 'Соц. сети',
			'name' => '',
			'type' => 'tab',
			'placement' => 'top',
			'endpoint' => 0,
		),
		array(
			'key' => 'field_628f656e648a0',
			'label' => 'Viber',
			'name' => 'theme_viber',
			'type' => 'text',
			'instructions' => 'Примеры: "viber://add?number=%2Bномербезплюса" - на телефонах открывает добавление контакта, на компьютере открывает контакт с возможностью выбрать действие, "viber://chat/?number=%2Bномербезплюса" -	отрывает чат, "viber://contact?number=%2Bномербезплюса" - отрывает контакт с возможностью выбора действия',
			'wrapper' => array(
				'width' => '50',
			),
		),
		array(
			'key' => 'field_628f65b2648a1',
			'label' => 'Whatsapp',
			'name' => 'theme_whatsapp',
			'type' => 'text',
			'instructions' => 'Обычно это	https://wa.me/<номер> или https://api.whatsapp.com/send?phone=<номер>. <номер> — это полный номер телефона в международном формате.	Не используйте нули, плюсы, скобки или дефисы при вводе номера телефона в международном формате.',
			'wrapper' => array(
				'width' => '50',
			),
		),
		array(
			'key' => 'field_628f65df648a2',
			'label' => 'Telegram',
			'name' => 'theme_telegram',
			'type' => 'text',
			'instructions' => 'Пример:	https://t.me/username',
			'wrapper' => array(
				'width' => '33',
			),
		),
	);
}

// ДРУГОЕ
function theme_options__get_other_tab(){
	return array(
		array(
			'key' => 'field_628f66460930b',
			'label' => 'Другое',
			'name' => '',
			'type' => 'tab',
			'placement' => 'top',
			'endpoint' => 0,
		),
	);
}
