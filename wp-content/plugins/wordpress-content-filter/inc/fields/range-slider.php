<?php
/**
 * @version    $Id$
 * @package    WordPress Content Filter
 * @author     ZuFusion
 * @copyright  Copyright (C) 2015 ZuFusion All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 */

function wcf_register_range_slider_field() {

	$options = array(
		'frontend_callback' => 'wcf_forms_field_range_slider_frontend',
		'before_admin_options_desc' => __('Note: This field only for developer.', WORDPRESS_CONTENT_FILTER_LANG),
		'admin_options' => array(
			array(
				'type' => 'text',
				'name' => 'label',
				'value' => 'Room',
				'label' => __( 'Label', WORDPRESS_CONTENT_FILTER_LANG ),
				'class' => '',
				'desc' => __( 'Display field label at the frontend', WORDPRESS_CONTENT_FILTER_LANG ),
			),

			array(
				'type' => 'text',
				'name' => 'range_slug',
				'value' => 'room',
				'label' => __( 'Slug', WORDPRESS_CONTENT_FILTER_LANG ),
				'class' => '',
				'desc' => __( 'Enter your slug. For example: room, Using this value to build query post', WORDPRESS_CONTENT_FILTER_LANG ),
			),

			array(
				'type' => 'text',
				'name' => 'range_value',
				'value' => '1-100',
				'label' => __( 'Range Min/Max', WORDPRESS_CONTENT_FILTER_LANG ),
				'class' => '',
				'desc' => __( 'Enter a range min/max. For example: 1-300', WORDPRESS_CONTENT_FILTER_LANG ),
			),
			array(
				'type' => 'text',
				'name' => 'range_step',
				'value' => '1',
				'label' => __( 'Step Size', WORDPRESS_CONTENT_FILTER_LANG ),
				'class' => '',
				'desc' => __( 'Enter step the slider takes between the min and max', WORDPRESS_CONTENT_FILTER_LANG ),
			),
		),
	);

	wcf_register_field( 'range_slider', __( 'Range Slider', WORDPRESS_CONTENT_FILTER_LANG ), $options );
}

add_action( 'init', 'wcf_register_range_slider_field' );


function wcf_forms_field_range_slider_frontend($form_id = '', $field_id, $data = array() ) {

	$label = $data['label'] != '' ? $data['label'] : '';
	$pre_name = isset($data['range_slug']) ? $data['range_slug'] . '['.$field_id.']' : "wcf_range_slider[".$field_id."]";
	$range_value = isset($data['range_value']) && !empty($data['range_value']) ? explode('-', $data['range_value']) : array();
	$min = $range_value[0];
	$max = $range_value[1];
	?>

	<div class="slider-range-wrapper">
		<label for="<?php echo $field_id;?>" class="wcf-label"><?php echo $label;?> : <span class="range-slider-label"><span class="range_from"><?php echo $min;?></span> - <span class="range_to"><?php echo $max;?></span></span></label>
		<div class="wcf-field-body">
			<div class="slider-range" data-step="<?php echo $data['range_step'];?>"></div>
			<input type="hidden" name="<?php echo $pre_name . '[min]';?>" class="range_min" data-min="<?php echo $range_value[0];?>" value="<?php echo $min; ?>"/>
			<input type="hidden" name="<?php echo $pre_name . '[max]';?>" class="range_max" data-max="<?php echo $range_value[1];?>" value="<?php echo $max; ?>"/>
		</div>
	</div>
<?php
}