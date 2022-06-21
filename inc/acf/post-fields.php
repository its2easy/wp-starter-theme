<?php
add_action('acf/init', 'my_acf_add_local_field_groups');
function my_acf_add_local_field_groups() {

	// Example
	acf_add_local_field_group(array(
		'key' => 'group_628ddfe3297f3',
		'title' => 'Информация',
		'location' => array(
			array(
				array(
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'page',
				),
			),
		),
		'position' => 'acf_after_title',
		'style' => 'default',
		'label_placement' => 'left',
		'active' => true,
		'show_in_rest' => 0,

		'fields' => array(
			array(
				'key' => 'field_62a2ff6772823',
				'label' => 'Название',
				'name' => 'page_name',
				'type' => 'text',
				'instructions' => '',
				'required' => 0,
			),
		),
	)); // example
}

