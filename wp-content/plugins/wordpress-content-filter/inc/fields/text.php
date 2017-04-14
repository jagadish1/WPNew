<?php
/**
 * @version    $Id$
 * @package    WordPress Content Filter
 * @author     ZuFusion
 * @copyright  Copyright (C) 2015 ZuFusion All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 */

function wcf_register_text_field() {

	$options = array(
		'frontend_callback' => 'wcf_forms_text_frontend',
		'admin_options' => array(
			array(
				'type' => 'text',
				'name' => 'label',
				'value' => '',
				'label' => __( 'Label', WORDPRESS_CONTENT_FILTER_LANG ),
				'class' => '',
				'desc' => __( 'Display field label at the frontend', WORDPRESS_CONTENT_FILTER_LANG ),
			),
			array(
				'type' => 'textarea',
				'name' => 'text',
				'value' => '<p>This is html</p>',
				'label' => __( 'Text', WORDPRESS_CONTENT_FILTER_LANG ),
				'class' => '',
				'desc' => __('Enter Shortcode, HTML content, ....', WORDPRESS_CONTENT_FILTER_LANG),
			),

		),
	);

	wcf_register_field( 'text', __( 'Text', WORDPRESS_CONTENT_FILTER_LANG ), $options );
}

add_action( 'init', 'wcf_register_text_field' );


function wcf_forms_text_frontend($form_id = '', $field_id, $data = array() ) {
	if ($data['label'] != '') { ?>
		<label for="<?php echo $field_id;?>" class="wcf-label"><?php echo $data['label'];?> : </label>
	<?php }
	echo '<div class="wcf-field-body">';
	echo do_shortcode(html_entity_decode(strip_tags($data['text'])));
	echo '</div>';
}