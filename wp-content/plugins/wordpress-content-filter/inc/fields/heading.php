<?php
/**
 * @version    $Id$
 * @package    WordPress Content Filter
 * @author     ZuFusion
 * @copyright  Copyright (C) 2015 ZuFusion All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 */

function wcf_register_field_heading_field() {

	$options = array(
		'frontend_callback' => 'wcf_forms_field_heading_frontend',
		'admin_options' => array(
			array(
				'type' => 'text',
				'name' => 'heading',
				'value' => '',
				'label' => __( 'Enter Heading', WORDPRESS_CONTENT_FILTER_LANG ),
				'class' => '',
				'desc' => '',
			),

		),
	);

	wcf_register_field( 'heading', __( 'Heading', WORDPRESS_CONTENT_FILTER_LANG ), $options );
}

add_action( 'init', 'wcf_register_field_heading_field' );


function wcf_forms_field_heading_frontend($form_id = '', $field_id, $data = array() ) {
	?>
	<label for="<?php echo $field_id;?>" id="<?php echo $field_id;?>_heading" class="wcf-field-heading"><?php echo $data['heading'];?></label>
<?php
}