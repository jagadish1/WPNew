<?php
/**
 * @version    $Id$
 * @package    WordPress Content Filter
 * @author     ZuFusion
 * @copyright  Copyright (C) 2015 ZuFusion All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 */

function wcf_register_field_date_field() {

	$options = array(
		'frontend_callback' => 'wcf_forms_field_date_frontend',
		'admin_options' => array(
			array(
				'type' => 'text',
				'name' => 'label',
				'value' => 'Date',
				'label' => __( 'Label', WORDPRESS_CONTENT_FILTER_LANG ),
				'class' => '',
				'desc' => __( 'Display field label at the frontend', WORDPRESS_CONTENT_FILTER_LANG ),
			),
			array(
				'type' => 'select',
				'name' => 'format_date',
				'options' => array(
					'mm/dd/yy' => 'mm/dd/yy',
					'dd/mm/yy' => 'dd/mm/yy',
					'yy-mm-dd' => 'yy-mm-dd',
					'd M, y' => 'd M, y',
					'd MM, y' => 'd MM, y',
				),
				'value' => 'mm/dd/yy',
				'label' => __( 'Format Date', WORDPRESS_CONTENT_FILTER_LANG ),
				'class' => '',
				'desc' => '',
			),

		),
	);

	wcf_register_field( 'date', __( 'Date', WORDPRESS_CONTENT_FILTER_LANG ), $options );
}

add_action( 'init', 'wcf_register_field_date_field' );


function wcf_forms_field_date_frontend($form_id = '', $field_id, $data = array() ) {

	$label = $data['label'] != '' ? $data['label'] : __('Date');
	$format_date = $data['format_date'] != '' ? $data['format_date'] : 'mm/dd/yy';

	?>
	<label for="<?php echo $field_id;?>" class="wcf-label"><?php echo $label;?> : </label>
	<div class="range_date_wrapper wcf-field-body" data-format-date="<?php echo $format_date?>">

	<?php

	$pre_name = "wcf_date[".$field_id."]";

	$date_from = array(
		'type' => 'text',
		'name' => $pre_name . '[date_from]',
		'value' => '',
		'class' => 'date_from',
		'label_class' => '',
		'desc' => '',
		'extra_attr' => 'placeholder="'.__('From').'"',
	);

	wcf_forms_field($date_from);

	$date_to = array(
		'type' => 'text',
		'name' => $pre_name . '[date_to]',
		'value' => '',
		'class' => 'date_to',
		'label_class' => '',
		'desc' => '',
		'extra_attr' => 'placeholder="'.__('To').'"',
	);

	wcf_forms_field($date_to);
	?>

	</div>
<?php
}