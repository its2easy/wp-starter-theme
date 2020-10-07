<?php
use Carbon_Fields\Container;
use Carbon_Fields\Field;

/**
 * Theme options
 */
add_action( 'carbon_fields_register_fields', 'crb_attach_theme_options' );
function crb_attach_theme_options() {

	Container::make( 'theme_options', 'Настройки темы' )
	         ->set_page_menu_position( 4 )
	         ->set_icon( 'dashicons-admin-generic' )
	         ->add_tab( "Общие", array(
		         Field::make( 'complex', 'crb_email_recipients', 'Получатели писем' )
		              ->set_required( true )
		              ->set_min( 1 )
		              ->setup_labels( array( 'plural_name' => 'Emails', 'singular_name' => 'Email' ) )
		              ->add_fields( array(
			              Field::make( 'text', 'email', 'Email' ),
		              ) ),
	         ) )
		->add_tab( "Скрипты", array(
			Field::make( 'textarea', 'crb_head_script', 'Будет вставлено перед </head>' ),
			Field::make( 'textarea', 'crb_body_start_script', 'Будет вставлено после <body>' )
			     ->set_width( 50 ),
			Field::make( 'textarea', 'crb_body_end_script', 'Будет вставлено перед </body>' )
			     ->set_width( 50 ),
		))
		->add_tab( "Соц. сети", array(
			Field::make( 'text', 'crb_viber', 'Viber' )->set_width(50)
			     ->set_help_text('
		         Примеры: "viber://add?number=%2Bномербезплюса" - на телефонах открывает добавление контакта, на 
		         компьютере открывает контакт с возможностью выбрать действие, "viber://chat/?number=%2Bномербезплюса" - 
		         отрывает чат, "viber://contact?number=%2Bномербезплюса" - отрывает контакт с возможностью выбора 
		         действия'),
			Field::make( 'text', 'crb_whatsapp', 'Whatsapp' )->set_width(50)
			     ->set_help_text('Обычно это  https://wa.me/<номер> или  
				https://api.whatsapp.com/send?phone=<номер>. <номер> — это полный номер телефона в международном формате. 
				Не используйте нули, плюсы, скобки или дефисы при вводе номера телефона в международном формате.'),
			Field::make( 'text', 'crb_telegram', 'Telegram' )->set_width(33)
			     ->set_help_text("Пример:  https://t.me/username"),
		))
		->add_tab( "Другое", array(

		));

}

//echo carbon_get_theme_option( 'crb_copyright' );