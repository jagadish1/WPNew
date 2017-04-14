<?php
/**
 * @version    $Id$
 * @package    WordPress Content Filter
 * @author     ZuFusion
 * @copyright  Copyright (C) 2015 ZuFusion All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 */

function wcf_register_field_author_field() {

	$query_args = array();
	$query_args['fields'] = array( 'ID', 'display_name' );
	$query_args['role'] = apply_filters('wcf_author_field_role', 'author');

	$users_options = array();
	$users = get_users( $query_args);

	foreach ( $users  as $user ) {
		if ('admin' == $user->display_name) {
			continue;
		}
		$users_options[$user->ID] = $user->display_name;
	}

	$options = array(
		'frontend_callback' => 'wcf_forms_field_author_frontend',
		'admin_options' => array(
			array(
				'type' => 'text',
				'name' => 'label',
				'value' => 'Author',
				'label' => __( 'Label', WORDPRESS_CONTENT_FILTER_LANG ),
				'class' => '',
				'desc' => __( 'Display field label at the frontend', WORDPRESS_CONTENT_FILTER_LANG ),
			),
			array(
				'type' => 'text',
				'name' => 'change_all_label',
				'value' => '',
				'label' => __( 'Change All Label', WORDPRESS_CONTENT_FILTER_LANG ),
				'class' => '',
				'desc' => __( 'Change select all items label', WORDPRESS_CONTENT_FILTER_LANG ),
			),

		),
		'user_options' =>  $users_options
	);

	wcf_register_field( 'author', __( 'Author', WORDPRESS_CONTENT_FILTER_LANG ), $options );
}

add_action( 'init', 'wcf_register_field_author_field' );


function wcf_forms_field_author_frontend($form_id = '', $field_id, $data = array() ) {

	global $wcf_register_fields;

	$options = isset($wcf_register_fields['author']['options']) ? $wcf_register_fields['author']['options'] : array();
	$user_options = isset($options['user_options']) ? $options['user_options'] : array();

	$users = $user_options;

	if (count($users)) {

		$all_label = $data['change_all_label'] != '' ? $data['change_all_label'] : __('All', WORDPRESS_CONTENT_FILTER_LANG);

		$users = array('all' => $all_label) + $users;

		$pre_name = "wcf_author[".$field_id."]";

		$author_options = array(
			'type' => 'select',
			'name' => $pre_name,
			'value' => '',
			'options' => $users,
			'label' => $data['label'],
			'class' => '',
			'label_class' => 'wcf-label',
			'desc' => '',
			'before_html' => '<div class="wcf-field-body">',
			'after_html' => '</div>',
		);
		wcf_forms_field($author_options);
	} else {
		echo __('Not Found any users with the role is Author', WORDPRESS_CONTENT_FILTER_LANG );
	}

}