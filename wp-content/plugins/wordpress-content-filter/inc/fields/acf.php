<?php
/**
 * @version    $Id$
 * @package    WordPress Content Filter
 * @author     ZuFusion
 * @copyright  Copyright (C) 2015 ZuFusion All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 */

function wcf_register_acf_field() {


	$fields = array();

	if (is_admin()) {
		$args = array(
			'posts_per_page' => -1,
			'post_type'      => 'acf',
		);
		$field_types = apply_filters('wcf_acf_field_type', array('text','textarea','select','checkbox','radio','true_false' ));

		$groups = get_posts( $args );
		if ($groups) {
			foreach ( $groups as $group ) {
				$group_fields = apply_filters('acf/field_group/get_fields', array(), $group->ID);
				if (is_array($group_fields)) {
					$fields[''] = __('Select a Field', WORDPRESS_CONTENT_FILTER_LANG);
					foreach ( $group_fields as $field ) {
						if (in_array($field['type'], $field_types)) {
							$fields[$field['key']] = $field['label'] .' - ' .$field['type'];
						}
					}
				}
			}
		}

	}

	$options = array(
		'frontend_callback' => 'wcf_forms_acf_frontend',
		'before_admin_options_desc' => __('This field only support some field types from Advanced Custom Fields if field type is Text, Text Area, Select/Multiselect, Checkbox, Radio Button, True/False : ', WORDPRESS_CONTENT_FILTER_LANG),
		'admin_options' => array(

			array(
				'type' => 'select',
				'name' => 'field',
				'options' => $fields,
				'value' => '',
				'label' => __( 'Field', WORDPRESS_CONTENT_FILTER_LANG ),
				'class' => '',
				'desc' => __( 'Select a field of Advanced Custom Fields', WORDPRESS_CONTENT_FILTER_LANG ),
				'extra_attr' => '',
			),
			array(
				'type' => 'text',
				'name' => 'label',
				'value' => '',
				'label' => __( 'Label', WORDPRESS_CONTENT_FILTER_LANG ),
				'class' => '',
				'desc' => __( 'Display field label at the frontend', WORDPRESS_CONTENT_FILTER_LANG ),
			),
			array(
				'type' => 'radio',
				'label' => __( 'Hide Select All', WORDPRESS_CONTENT_FILTER_LANG ),
				'name' => 'hide_all',
				'value' => 'yes',
				'options' => array(
					'yes' => __('Yes', WORDPRESS_CONTENT_FILTER_LANG),
					'no' => __('No', WORDPRESS_CONTENT_FILTER_LANG),
				),
				'class' => '',
				'desc' => __('Hide select all option', WORDPRESS_CONTENT_FILTER_LANG),
			),
			array(
				'type' => 'text',
				'name' => 'change_all_label',
				'value' => '',
				'label' => __( 'Change All Label', WORDPRESS_CONTENT_FILTER_LANG ),
				'class' => '',
				'desc' => __( 'Change select all items label', WORDPRESS_CONTENT_FILTER_LANG ),
			),
			array(
				'type' => 'select',
				'name' => 'compare',
				'value' => '=',
				'options' => array(
					'=' => __('=' , WORDPRESS_CONTENT_FILTER_LANG),
					'!=' => __('!=' , WORDPRESS_CONTENT_FILTER_LANG),
					'>' => __('>', WORDPRESS_CONTENT_FILTER_LANG),
					'>=' => __('>=', WORDPRESS_CONTENT_FILTER_LANG),
					'<' => __('<', WORDPRESS_CONTENT_FILTER_LANG),
					'<=' => __('<=', WORDPRESS_CONTENT_FILTER_LANG),
					'like' => __('LIKE', WORDPRESS_CONTENT_FILTER_LANG),
					'not_like' => __('NOT LIKE', WORDPRESS_CONTENT_FILTER_LANG),
					'in' => __('IN', WORDPRESS_CONTENT_FILTER_LANG),
					'not_in' => __('NOT IN', WORDPRESS_CONTENT_FILTER_LANG),
					'between' => __('BETWEEN', WORDPRESS_CONTENT_FILTER_LANG),
					'not_between' => __('NOT BETWEEN', WORDPRESS_CONTENT_FILTER_LANG),
					'exist' => __('EXIST', WORDPRESS_CONTENT_FILTER_LANG),
					'not_exist' => __('NOT EXIST', WORDPRESS_CONTENT_FILTER_LANG),
				),
				'label' => __( 'Compare', WORDPRESS_CONTENT_FILTER_LANG ),
				'class' => '',
				'desc' => __('The \'range choices\' only use for BETWEEN, NOT BETWEEN and the field type is not Checkbox, Multiselect .<br>
if you select IN, NOT IN then make sure the field type must be Checkbox, Multiselect <br>
if you select =, !=, >, >=, <, <=, LIKE, NOT LIKE then make sure the field type must be Text, Text Area, Select, Radio Button,True/False
<br> ==== <br> for normal choices <br>50 : 50<br>100 : 100 <br> for range choices <br>50-100 : 50 - 100<br>100-200 : 100 - 200', WORDPRESS_CONTENT_FILTER_LANG),
			),
		),
	);

	wcf_register_field( 'acf', __( 'Advanced Custom Fields', WORDPRESS_CONTENT_FILTER_LANG ), $options );
}

add_action( 'init', 'wcf_register_acf_field' );

function wcf_forms_acf_frontend($form_id = '', $field_id, $data = array() ) {


	if ($data['field'] == '') { echo __('Please, select a field', WORDPRESS_CONTENT_FILTER_LANG); return;}

	$field = apply_filters('acf/load_field', false, $data['field'] );

	$options = array();
	if (isset($field['choices'])) {
		if ($data['hide_all'] == 'no') {
			$options['all'] = ($data['change_all_label'] != '') ? $data['change_all_label'] : __('All', WORDPRESS_CONTENT_FILTER_LANG);
		}
		$options = array_merge($options, $field['choices']);
	}

	$pre_name = "wcf_acf[".$field_id."]";
	$label_class = 'wcf-label';
	$radio_checkbox_layout = 'wcf-horizontal';
	$default_value = $field['default_value'];

	switch ($field['type']) {
		case 'select':
			$field_type = $field['multiple'] ? 'multiselect' : 'select';
			$default_value = explode("\n", $default_value);
			$field_args = array(
				'type' => $field_type,
				'name' => $pre_name,
				'id' => $pre_name . '_select',
				'value' => $default_value,
				'options' => $options,
				'label' => $data['label'],
				'class' => '',
				'label_class' => $label_class,
				'before_html' => '<div class="wcf-field-body">',
				'after_html' => '</div>',
				'desc' => '',
			);
			wcf_forms_field($field_args);
			break;

		case 'radio':

			if ($field['layout'] == 'vertical') {
				$radio_checkbox_layout = 'wcf-vertical';
			}

			$field_args = array(
				'type' => 'radio',
				'name' => $pre_name ,
				'id' => $pre_name . '_radio',
				'value' => $data['default_value'],
				'options' => $options,
				'label' => $data['label'],
				'label_class' => $label_class,
				'wrapper_class' => $radio_checkbox_layout,
				'before_html' => '<div class="wcf-field-body">',
				'after_html' => '</div>',
			);

			wcf_forms_field($field_args);
			break;
		case 'checkbox':

			$default_value = explode("\n", $default_value);

			if ($field['layout'] == 'vertical') {
				$radio_checkbox_layout = 'wcf-vertical';
			}
			$pre_html = '';
			if ($data['hide_all'] == 'no') {
				$all_checked = in_array('all', $default_value) ?'checked="checked"' : '';
				$pre_html = '<div class="wcf-checkbox-wrapper"><input type="checkbox" value="all" name="'.$pre_name . '[]'.'" class="wcf-checkbox-all" '.$all_checked.'><label class="wcf-checkbox-label"> '.$options['all'].'</label></div>';
				unset($options['all']);
				if ($all_checked != '') {
					$default_value = array();
					foreach ( $options as $key => $default ) {
						$default_value[] = $key;
					}
				}
			}

			$field_args = array(
				'type' => 'checkbox',
				'name' => $pre_name . '[]' ,
				'id' => $pre_name . '_checkbox',
				'value' => $default_value,
				'options' => $options,
				'label' => $data['label'],
				'label_class' => $label_class,
				'class' => 'wcf-checkbox-item',
				'wrapper_class' => $radio_checkbox_layout,
				'before_html' => '<div class="wcf-field-body">' . $pre_html,
				'after_html' => '</div>',
			);

			wcf_forms_field($field_args);
			break;
		case 'text':
			$field_args = array(
				'type' => 'text',
				'name' => $pre_name ,
				'id' => $pre_name . '_text',
				'value' => $data['default_value'],
				'label' => $data['label'],
				'label_class' => $label_class,
				'before_html' => '<div class="wcf-field-body">',
				'after_html' => '</div>',
			);

			wcf_forms_field($field_args);
			break;
		case 'textarea':

			$field_args = array(
				'type' => 'textarea',
				'name' => $pre_name ,
				'id' => $pre_name . '_text',
				'value' => $data['default_value'],
				'label' => $data['label'],
				'label_class' => $label_class,
				'before_html' => '<div class="wcf-field-body">',
				'after_html' => '</div>',
			);

			wcf_forms_field($field_args);
			break;
	}

}