<?php
/**
 * @version    $Id$
 * @package    WordPress Content Filter
 * @author     ZuFusion
 * @copyright  Copyright (C) 2015 ZuFusion All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 */

function wcf_register_field_input_query_field() {

	$options = array(
		'frontend_callback' => 'wcf_forms_field_input_query_frontend',
		'admin_options' => array(
			array(
				'type' => 'text',
				'name' => 'label',
				'value' => 'Keyword',
				'label' => __( 'Label', WORDPRESS_CONTENT_FILTER_LANG ),
				'class' => '',
				'desc' => __( 'Display field label at the frontend', WORDPRESS_CONTENT_FILTER_LANG ),
			),
			array(
				'type' => 'text',
				'name' => 'input_query_placeholder',
				'value' => __('Enter keyword'),
				'label' => __( 'Placeholder Text', WORDPRESS_CONTENT_FILTER_LANG ),
				'class' => '',
				'desc' => '',
			),

		),
	);

	wcf_register_field( 'input_query', __( 'Input Query', WORDPRESS_CONTENT_FILTER_LANG ), $options );
}

add_action( 'init', 'wcf_register_field_input_query_field' );


function wcf_forms_field_input_query_frontend($form_id = '', $field_id, $data = array() ) {
	?>
	<?php if ($data['label'] != '') { ?>
		<label for="<?php echo $field_id;?>" class="wcf-label"><?php echo $data['label'];?> : </label>
	<?php } ?>
	<div class="wcf-field-body">
		<input type="text" name="s" id="wcf-input-query-<?php echo $field_id;?>" class="wcf-input-query" placeholder="<?php echo $data['input_query_placeholder']?>" value="" autocomplete="off">
	</div>
<?php
}