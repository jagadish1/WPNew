<?php
/**
 * @version    $Id$
 * @package    WordPress Content Filter
 * @author     ZuFusion
 * @copyright  Copyright (C) 2015 ZuFusion All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 */

function wcf_register_field_sort_field() {

	$order_by_options = apply_filters('wcf_order_by_options', array(
		'date' => __('Date', WORDPRESS_CONTENT_FILTER_LANG),
		'title' => __('Title', WORDPRESS_CONTENT_FILTER_LANG),
		'name' => __('Name', WORDPRESS_CONTENT_FILTER_LANG),
		'type' => __('Post Type', WORDPRESS_CONTENT_FILTER_LANG),
		'author' => __('Author', WORDPRESS_CONTENT_FILTER_LANG),
		'modified' => __('Modified Date', WORDPRESS_CONTENT_FILTER_LANG),
		'parent' => __('Post Parent ID', WORDPRESS_CONTENT_FILTER_LANG),
		'rand' => __('Random order', WORDPRESS_CONTENT_FILTER_LANG),
	));

	$options = array(
		'frontend_callback' => 'wcf_forms_field_sort_frontend',
		'admin_options' => array(

			array(
				'type' => 'select',
				'label' => __( 'Order By', WORDPRESS_CONTENT_FILTER_LANG ),
				'name' => 'order_by',
				'value' => 'date',
				'options' => $order_by_options,
				'class' => '',
				'desc' => '',
			),
			array(
				'type' => 'select',
				'label' => __( 'Sorting Order', WORDPRESS_CONTENT_FILTER_LANG ),
				'name' => 'sorting_order',
				'value' => 'DESC',
				'options' => array(
					'DESC' => __('Descending', WORDPRESS_CONTENT_FILTER_LANG),
					'ASC' => __('Ascending', WORDPRESS_CONTENT_FILTER_LANG)
				),
				'class' => '',
				'desc' => '',
			),

		),
		'order_by_options' => $order_by_options
	);

	wcf_register_field( 'sort', __( 'Sort', WORDPRESS_CONTENT_FILTER_LANG ), $options );
}

add_action( 'init', 'wcf_register_field_sort_field' );


function wcf_forms_field_sort_frontend($form_id = '', $field_id, $data = array() ) {

	global $wcf_register_fields;
	$order_by_options = $wcf_register_fields['sort']['options']['order_by_options'];
	$label_class = 'wcf-label';
	$pre_name = "wcf_sort[".$field_id."]";

	$order_by = array(
		'type' => 'select',
		'name' => $pre_name . '[order_by]',
		'value' => $data['order_by'],
		'options' => $order_by_options,
		'label' => __('Order By', WORDPRESS_CONTENT_FILTER_LANG),
		'label_class' => $label_class,
		'class' => '',
		'desc' => '',
		'before_html' => '<div class="wcf-field-body">',
		'after_html' => '</div>',
	);

	wcf_forms_field($order_by);

	$order = array(
		'type' => 'select',
		'name' => $pre_name . '[order]',
		'value' => $data['sorting_order'],
		'options' => array(
			'DESC' => __('Descending', WORDPRESS_CONTENT_FILTER_LANG),
			'ASC' => __('Ascending', WORDPRESS_CONTENT_FILTER_LANG)
		),
		'label' => __('Sorting Order', WORDPRESS_CONTENT_FILTER_LANG),
		'label_class' => $label_class,
		'class' => '',
		'desc' => '',
		'before_html' => '<div class="wcf-field-body">',
		'after_html' => '</div>',
	);

	wcf_forms_field($order);

}