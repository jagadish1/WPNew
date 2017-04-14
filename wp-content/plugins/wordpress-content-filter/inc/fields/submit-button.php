<?php
/**
 * @version    $Id$
 * @package    WordPress Content Filter
 * @author     ZuFusion
 * @copyright  Copyright (C) 2015 ZuFusion All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 */

function wcf_register_field_submit_button_field() {

	$options = array(
		'frontend_callback' => 'wcf_forms_field_submit_button_frontend',
		'admin_options' => array(
			array(
				'type' => 'text',
				'name' => 'search_button_text',
				'value' => __('Search', WORDPRESS_CONTENT_FILTER_LANG),
				'label' => __( 'Search Button Text', WORDPRESS_CONTENT_FILTER_LANG ),
				'class' => '',
				'desc' => '',
			),
		),
	);

	wcf_register_field( 'submit_button', __( 'Submit Button', WORDPRESS_CONTENT_FILTER_LANG ), $options );
}

add_action( 'init', 'wcf_register_field_submit_button_field' );


function wcf_forms_field_submit_button_frontend($form_id = '', $field_id, $data = array() ) {
	?>
	<div class="wcf-clear"></div>
	<button type="submit" class="wcf-submit-button"><?php echo $data['search_button_text'];?></button>
<?php
}