<?php
if ( ! defined( 'ABSPATH' ) ) exit;

add_action("wp_ajax_nopriv_theme_form", "theme_send_mail");
add_action("wp_ajax_theme_form", "theme_send_mail");

// Send emails as html instead of plain text
function theme_set_html_content_type() {
	return 'text/html';
}
add_filter( 'wp_mail_content_type', 'theme_set_html_content_type' );

// General form handler
function theme_send_mail(){
	$emails = carbon_get_theme_option( 'crb_email_recipients' ); // carbon
	//$emails = get_field('theme_email_recipients', 'option'); // acf
	$recipients_array = array_map(
		function($value){
			return $value['email'];
		},
		$emails);

	$fields = array(
		'name' => array(
			'name' => 'Имя',
			'required' => true,
		),
		'phone' => array(
			'name' => 'Телефон',
			'required' => true,
		),
		'email' => array(
			'name' => 'E-mail',
			'required' => false,
		),
		'type' => array(
			'name' => 'Тип формы',
			'required' => false,
		),
		'url' => array(
			'name' => 'Адрес страницы',
			'required' => false,
		),
		'page' => array(
			'name' => 'Страница',
			'required' => false,
		),
	);

	$fields = fill_fields_data($fields); // fill values


	//honeypot check, update after form change
	//скрит обнуляет source, destination заполнен и остается заполненым, message пустой и должен быть пустым
	//if (!empty($formFields['source']) || $formFields['destination'] != 'original' || !empty($formFields['message']) ) {
	//	echo "success";
	//	wp_die();
	//}
	// disallow all empty
	//if (empty($formFields['name']) && empty($formFields['phone']) && empty($formFields['phone'])) {
	//	echo "not filled";
	//	wp_die();
	//}

	// Headers
	$subject  = "Заявка с формы c " . $_SERVER['HTTP_HOST']; //subject in email
	$headers = '';
	//$headers  = "From: Wordpress <website@" . $_SERVER['HTTP_HOST'] . ">\r\n"; //Restricted on free hostings
	//$headers .= "Reply-To: ". strip_tags($usermail) . "\r\n";
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html;charset=utf-8 \r\n";

	// Body of the mail
	$msg  = "<html><body style='font-family:Arial,sans-serif;'>";
	$msg .= "<h2 style='font-weight:bold;border-bottom:1px dotted #ccc;'>Заявка с сайта ". $_SERVER['HTTP_HOST'] ."</h2>\r\n";

	foreach ($fields as $field) {
		if ( $field['value'] === !false ) {
			$msg .= "<p><strong>{$field['name']}: </strong> {$field['value']}</p>\r\n";
		}
	}

	$msg .= "</body></html>";


	//================================ HANDLE FILE
	$file_field = 'file';
	$attachment = '';
	$shouldSendFile = false;
	$max_allowed_file_size = 15*1024*1024; //100MB limit
	$allowed_extensions = array("jpg", "jpeg", "gif", "bmp", 'png', 'doc', 'docx', 'pdf', 'tiff', 'ai', 'cdr', 'psd', 'rar', 'zip');
	$tmp_file_array = $_FILES[$file_field];

	if (isset($tmp_file_array) && !$tmp_file_array['error']){
		$shouldSendFile = true;

		$name_of_uploaded_file = basename($tmp_file_array['name']);
		$type_of_uploaded_file = substr($name_of_uploaded_file,strrpos($name_of_uploaded_file, '.') + 1);
		$size_of_uploaded_file = $tmp_file_array["size"];//size in bytes

		//max size check
		if($size_of_uploaded_file > $max_allowed_file_size ) $shouldSendFile = false;

		//extensions check
		$allowed_ext = false;
		for($i=0; $i<sizeof($allowed_extensions); $i++)
		{
			if(strcasecmp($allowed_extensions[$i],$type_of_uploaded_file) == 0){
				$allowed_ext = true;
			}
		}
		if (!$allowed_ext) $shouldSendFile = false;

		// if verification is ok, copy to uploads and set the path
		if ($shouldSendFile) {
			$attachment = $tmp_file_array['tmp_name'];
			$upload_path = wp_upload_dir()['path'];
			$name = basename($tmp_file_array['name']);

			if ( move_uploaded_file($attachment, "$upload_path/$name") ){
				$attachment = "$upload_path/$name";
			} else {
				$attachment = '';
			}
		}

	}
	//================================ END FILE HANDLING

	//Sending
	if (wp_mail($recipients_array, $subject, $msg, $headers, $attachment)) {
		echo "Отправлено";
	} else {
		echo "Ошибка при отправке";
	}

	// delete files after sending them
	if(!empty($attachment)) {
		if (file_exists($attachment) && is_writable($attachment)){
			@unlink($attachment);
		}
	}

	wp_die();
}

function check_form_field($field_name){
	return empty( $_POST[$field_name] );
}
function sanitize_field($field_name){
	return trim( htmlspecialchars( $_POST[$field_name] ) );
}
function fill_fields_data($fields){
	$empty_text = 'Не заполнено';
	foreach ( $fields as $key => $field ) {
		$is_empty = check_form_field($key);
		if ( !$is_empty ) {
			$field['value'] = sanitize_field($key);
		}
		elseif ($field['required'] == true) {
			$field['value'] = $empty_text;
		} else {
			$field['value'] = false;
		}
	}
	return $fields;
}