<?php
/**
 * @version    $Id$
 * @package    WordPress Content Filter
 * @author     ZuFusion
 * @copyright  Copyright (C) 2015 ZuFusion All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 */

function wcf_register_field_meta_field() {

	$meta_keys = array();

	if (is_admin()) {

		$metas = wcf_get_all_meta_keys();

		if (is_array($metas) && !empty($metas)) {
			$meta_keys[''] = __('Select a meta key', WORDPRESS_CONTENT_FILTER_LANG);
			foreach ( $metas as $key_value ) {
				$meta_keys[$key_value] = $key_value;
			}
		}

	}

	$options = array(
		'frontend_callback' => 'wcf_forms_field_meta_frontend',
		'admin_options' => array(
			array(
				'type' => 'select',
				'name' => 'meta_key',
				'options' => $meta_keys,
				'value' => '',
				'label' => __( 'Meta Key', WORDPRESS_CONTENT_FILTER_LANG ),
				'class' => '',
				'desc' => __( 'Select a meta key you prefer, the options below will be generated values base on this meta key', WORDPRESS_CONTENT_FILTER_LANG ),
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
				'desc' => __('The \'range options\' (see the options below) only use for BETWEEN, NOT BETWEEN and the Display Type is not CheckBox, Multiselect .<br>
if you select IN, NOT IN then make sure the Display Type must be CheckBox, Multiselect <br>
if you select =, !=, >, >=, <, <=, LIKE, NOT LIKE then make sure the field type must be Select, Radio', WORDPRESS_CONTENT_FILTER_LANG),
			),
			array(
				'type' => 'select',
				'label' => __( 'Display Type', WORDPRESS_CONTENT_FILTER_LANG ),
				'name' => 'display_type',
				'value' => 'dropdown',
				'options' => array(
					'select' => __('Select', WORDPRESS_CONTENT_FILTER_LANG),
					'radio' => __('Radio', WORDPRESS_CONTENT_FILTER_LANG),
					'checkbox' => __('CheckBox', WORDPRESS_CONTENT_FILTER_LANG),
					'multiselect' => __('Multiselect', WORDPRESS_CONTENT_FILTER_LANG),
				),
				'class' => '',
				'desc' => '',
			),
			array(
				'type' => 'radio',
				'label' => __( 'Radio/Checkbox Layout', WORDPRESS_CONTENT_FILTER_LANG ),
				'name' => 'radio_checkbox_layout',
				'value' => 'horizontal',
				'options' => array(
					'vertical' => __('Vertical', WORDPRESS_CONTENT_FILTER_LANG),
					'horizontal' => __('Horizontal', WORDPRESS_CONTENT_FILTER_LANG),
				),
				'class' => '',
				'desc' => '',
			),
			array(
				'type' => 'textarea',
				'name' => 'options',
				'value' => '',
				'label' => __( 'Options', WORDPRESS_CONTENT_FILTER_LANG ),
				'class' => '',
				'desc' => __('Enter each option on a new line. You define both a value and label like this: <br> value1::Label1 <br> value2::Label2.
<br> ==== <br> for normal options <br>50::50<br>100::100 <br> for range option <br>50-100::50 - 100<br>100-200::100 - 200', WORDPRESS_CONTENT_FILTER_LANG),
			),
			array(
				'type' => 'textarea',
				'name' => 'default_value',
				'value' => '',
				'label' => __( 'Default Value', WORDPRESS_CONTENT_FILTER_LANG ),
				'class' => '',
				'desc' => __('Enter a default value for dropdown or radio type. Otherwise <br>
Enter each default value on a new line for CheckBox or Multiple Select type.', WORDPRESS_CONTENT_FILTER_LANG),
			),
		),
	);

	wcf_register_field( 'meta_field', __('Meta Field', WORDPRESS_CONTENT_FILTER_LANG ), $options );
}

add_action( 'init', 'wcf_register_field_meta_field' );

function wcf_forms_field_meta_frontend($form_id = '', $field_id, $data = array() ) {

	$pre_name = "wcf_meta_field[".$field_id."]";

	if ($data['meta_key'] == '') { echo __('Please, select a meta key', WORDPRESS_CONTENT_FILTER_LANG); return;}

	$opts = explode("\n", $data['options']);
	$options = array();
	if (!empty($opts)) {

		if ($data['hide_all'] == 'no') {
			$options['all'] = ($data['change_all_label'] != '') ? $data['change_all_label'] : __('All', WORDPRESS_CONTENT_FILTER_LANG);
		}

		foreach ( $opts as $opt ) {
			$opt_tem                = explode( '::', $opt );
			$options[ $opt_tem[0] ] = $opt_tem[1];
		}
	}
	$label_class = 'wcf-label';
	$radio_checkbox_layout = 'wcf-'.$data['radio_checkbox_layout'];

	switch ($data['display_type']) {
		case 'select':
			$field_args = array(
				'type' => 'select',
				'name' => $pre_name,
				'id' => $pre_name . '_select',
				'value' => $data['default_value'],
				'options' => $options,
				'label' => $data['label'],
				'class' => '',
				'label_class' => $label_class,
				'desc' => '',
				'before_html' => '<div class="wcf-field-body">',
				'after_html' => '</div>',
			);
			wcf_forms_field($field_args);
			break;
		case 'multiselect':

			$default_value = $data['default_value'];
			$selected_value = explode("\n", $default_value);

			$field_args = array(
				'type' => 'multiple',
				'name' => $pre_name . '[]',
				'id' => $pre_name . '_select',
				'value' => $selected_value,
				'options' => $options,
				'label' => $data['label'],
				'class' => '',
				'label_class' => $label_class,
				'before_html' => '<div class="wcf-field-body">',
				'after_html' => '</div>',
			);

			wcf_forms_field($field_args);
			break;
		case 'radio':

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
			$default_value = $data['default_value'];
			$default_value = explode("\n", $default_value);
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
	}


}