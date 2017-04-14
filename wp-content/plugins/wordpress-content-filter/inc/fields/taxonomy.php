<?php
/**
 * @version    $Id$
 * @package    WordPress Content Filter
 * @author     ZuFusion
 * @copyright  Copyright (C) 2015 ZuFusion All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 */

function wcf_register_field_taxonomy_field() {

	$taxonomy_options = array();

	if (is_admin()) {

		$taxonomies = get_taxonomies( array(), 'objects' );

		if (is_array($taxonomies) && !empty($taxonomies)) {
			$taxonomy_options[''] = __('Select a taxonomy', WORDPRESS_CONTENT_FILTER_LANG);
			foreach ( $taxonomies as $key_value ) {
				$taxonomy_options[$key_value->name] = $key_value->label;
			}
		}

	}


	$options = array(
		'frontend_callback' => 'wcf_forms_field_taxonomy_frontend',
		'admin_options' => array(
			array(
				'type' => 'select',
				'name' => 'taxonomy',
				'options' => $taxonomy_options,
				'value' => '',
				'label' => __( 'Taxonomy', WORDPRESS_CONTENT_FILTER_LANG ),
				'class' => '',
				'desc' => __( 'Select a taxonomy you prefer', WORDPRESS_CONTENT_FILTER_LANG ),
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
				'label' => __( 'Display Type', WORDPRESS_CONTENT_FILTER_LANG ),
				'name' => 'display_type',
				'value' => 'dropdown',
				'options' => array(
					'select' => __('Select', WORDPRESS_CONTENT_FILTER_LANG),
					'radio' => __('Radio', WORDPRESS_CONTENT_FILTER_LANG),
					'checkbox' => __('CheckBox', WORDPRESS_CONTENT_FILTER_LANG),
					'multiselect' => __('Multiselect', WORDPRESS_CONTENT_FILTER_LANG),
					'color' => __('Color', WORDPRESS_CONTENT_FILTER_LANG),
				),
				'class' => '',
				'desc' => '',
			),
			array(
				'type' => 'terms_color',
				'label' => __( 'Terms Color', WORDPRESS_CONTENT_FILTER_LANG ),
				'name' => 'terms_color',
				'value' => array(),
				'class' => '',
				'desc' => __( 'There colors are generated base on Taxonomy when you select, Using this option for "Display Type" is Color', WORDPRESS_CONTENT_FILTER_LANG ),
				'after_html_field' => '<a href="#" class="button wcf-generate-terms-color-button">'.__('Generate terms color', WORDPRESS_CONTENT_FILTER_LANG).'</a>',
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
				'type' => 'radio',
				'label' => __( 'Operator', WORDPRESS_CONTENT_FILTER_LANG ),
				'name' => 'taxonomy_operator',
				'value' => 'in',
				'options' => array(
					'in' => __('IN', WORDPRESS_CONTENT_FILTER_LANG),
					'not_in' => __('NOT IN', WORDPRESS_CONTENT_FILTER_LANG),
					'and' => __('AND', WORDPRESS_CONTENT_FILTER_LANG),
				),
				'class' => '',
				'desc' => __('Operator to test relationship between the taxonomy values, Only use for CheckBox, Multiselect, Color. Default is IN', WORDPRESS_CONTENT_FILTER_LANG),
			),

			array(
				'type' => 'textarea',
				'name' => 'default_value',
				'value' => '',
				'label' => __( 'Default Value', WORDPRESS_CONTENT_FILTER_LANG ),
				'class' => '',
				'desc' => __('Enter a default value for dropdown or radio type. Otherwise <br>
Enter each default value on a new line for CheckBox or Multiple or Color Select type. <br> Enter \'all\' for all values (when Hide Select All is No)', WORDPRESS_CONTENT_FILTER_LANG),
				'after_html_field' => '<a href="#TB_inline?width=400&height=400&inlineId=wcf-thickbox" class="thickbox button wcf-exclude-terms-button" data-type="default">'.__('Select Terms', WORDPRESS_CONTENT_FILTER_LANG).'</a>',
			),

			array(
				'type' => 'radio',
				'label' => __( 'Hide Empty Terms?', WORDPRESS_CONTENT_FILTER_LANG ),
				'name' => 'hide_empty_terms',
				'value' => 'no',
				'options' => array(
					'yes' => __('Yes', WORDPRESS_CONTENT_FILTER_LANG),
					'no' => __('No', WORDPRESS_CONTENT_FILTER_LANG),
				),
				'class' => '',
				'desc' => __('Hide the terms that no posts assigned to', WORDPRESS_CONTENT_FILTER_LANG),
			),
			array(
				'type' => 'text',
				'label' => __( 'Exclude Terms', WORDPRESS_CONTENT_FILTER_LANG ),
				'name' => 'exclude_terms',
				'value' => '',
				'class' => '',
				'desc' => __('Exclude term IDs of Taxonomy, separated by commas', WORDPRESS_CONTENT_FILTER_LANG),
				'after_html_field' => '<a href="#TB_inline?width=400&height=400&inlineId=wcf-thickbox" class="thickbox button wcf-exclude-terms-button" data-type="exclude">'.__('Select Terms', WORDPRESS_CONTENT_FILTER_LANG).'</a>',
			),
			array(
				'type' => 'radio',
				'label' => __( 'Show Count', WORDPRESS_CONTENT_FILTER_LANG ),
				'name' => 'show_count',
				'value' => 'yes',
				'options' => array(
					'yes' => __('Yes', WORDPRESS_CONTENT_FILTER_LANG),
					'no' => __('No', WORDPRESS_CONTENT_FILTER_LANG),
				),
				'class' => '',
				'desc' => __('Show count posts are in the taxonomy', WORDPRESS_CONTENT_FILTER_LANG),
			),
		),
	);

	wcf_register_field( 'taxonomy', __('Taxonomy', WORDPRESS_CONTENT_FILTER_LANG ), $options );
}

add_action( 'init', 'wcf_register_field_taxonomy_field' );

function wcf_forms_field_taxonomy_frontend($form_id = '', $field_id, $data = array() ) {


	if ($data['taxonomy'] == '') { echo __('Please, select a taxonomy', WORDPRESS_CONTENT_FILTER_LANG); return;}

	$pre_name = "wcf_taxonomy[".$field_id."]";
	$options = array();
	if ($data['hide_all'] == 'no') {
		$options['all'] = ($data['change_all_label'] != '') ? $data['change_all_label'] : __('All', WORDPRESS_CONTENT_FILTER_LANG);
	}
	$args = array(
		'exclude_terms' => $data['exclude_terms'],
		'hide_empty' => $data['hide_empty_terms'] == 'yes' ? true : false,
	);
	if (!taxonomy_exists($data['taxonomy'])) { echo __('The taxonomy doesn\'t exist', WORDPRESS_CONTENT_FILTER_LANG); return;}

	$terms = get_terms($data['taxonomy'], $args);

	if (!empty($terms)) {
		foreach ( $terms as $term ) {
			$term_name = $data['show_count'] == 'yes' ? $term->name . ' <span class="wcf-count-terms">('.$term->count.')</span>' : $term->name;
			$options[$term->slug] = $term_name;
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
				'label_class' => $label_class,
				'class' => '',
				'desc' => '',
				'before_html' => '<div class="wcf-field-body">',
				'after_html' => '</div>',
			);

			wcf_forms_field($field_args);
			break;

		case 'radio':
			$field_args = array(
				'type' => 'radio',
				'name' => $pre_name,
				'id' => $pre_name . '_radio',
				'value' => $data['default_value'],
				'options' => $options,
				'label' => $data['label'],
				'label_class' => $label_class,
				'class' => '',
				'desc' => '',
				'wrapper_class' => $radio_checkbox_layout,
				'before_html' => '<div class="wcf-field-body">',
				'after_html' => '</div>',
			);

			wcf_forms_field($field_args);
			break;
		case 'color':

			$default_value = $data['default_value'];
			$selected_value = explode("\n", $default_value);

			$color_options = array();

			if ($data['terms_color'] != '') {
				$color_options = maybe_unserialize($data['terms_color']);
			}

			$field_args = array(
				'type' => 'checkbox_color',
				'name' => $pre_name . '[]',
				'id' => $pre_name . '_checkbox',
				'value' => $selected_value,
				'options' => $color_options,
				'label' => $data['label'],
				'label_class' => $label_class,
				'class' => 'wcf-checkbox-item',
				'desc' => '',
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
				$pre_html = '<div class="wcf-checkbox-wrapper"><input type="checkbox" value="all" name="'.$pre_name . '[]'.'" class="wcf-checkbox-all" '.$all_checked.'> <label class="wcf-checkbox-label">'.$options['all'].'</label></div>';
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
				'name' => $pre_name . '[]',
				'id' => $pre_name . '_checkbox',
				'value' => $default_value,
				'options' => $options,
				'label' => $data['label'],
				'label_class' => $label_class,
				'class' => 'wcf-checkbox-item',
				'desc' => '',
				'wrapper_class' => $radio_checkbox_layout,
				'before_html' => '<div class="wcf-field-body">' . $pre_html,
				'after_html' => '</div>',
			);

			wcf_forms_field($field_args);
			break;
	}
}