<?php
/**
 * @version    $Id$
 * @package    WordPress Content Filter
 * @author     ZuFusion
 * @copyright  Copyright (C) 2015 ZuFusion All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 */

function wcf_register_price_field() {

	$options = array(
		'frontend_callback' => 'wcf_forms_field_price_frontend',
		'before_admin_options_desc' => __('This field only use for shop that filter products by price', WORDPRESS_CONTENT_FILTER_LANG),
		'admin_options' => array(
			array(
				'type' => 'text',
				'name' => 'label',
				'value' => 'Price',
				'label' => __( 'Label', WORDPRESS_CONTENT_FILTER_LANG ),
				'class' => '',
				'desc' => __( 'Display field label at the frontend', WORDPRESS_CONTENT_FILTER_LANG ),
			),
			array(
				'type' => 'select',
				'label' => __( 'Select Shop', WORDPRESS_CONTENT_FILTER_LANG ),
				'name' => 'shop',
				'value' => 'product',
				'options' => apply_filters('wcf_price_shop_type_options', array(
					'product' => __('Products', WORDPRESS_CONTENT_FILTER_LANG),
					'download' => __('Downloads', WORDPRESS_CONTENT_FILTER_LANG),
				)),
				'class' => '',
				'desc' => __( 'Note: you need check the shop that you want to search at Settings -> Post Type (Settings metabox right). In case, Shop no listed in Settings -> Post Type. That means you have\'t installed yet or It was not supported by the this plugin', WORDPRESS_CONTENT_FILTER_LANG ),
			),

			array(
				'type' => 'text',
				'name' => 'range_value',
				'value' => '1-100',
				'label' => __( 'Price Min/Max', WORDPRESS_CONTENT_FILTER_LANG ),
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
			array(
				'type' => 'text',
				'name' => 'price_format',
				'value' => '${price}',
				'label' => __( 'Price Format', WORDPRESS_CONTENT_FILTER_LANG ),
				'class' => '',
				'desc' => __( 'You use {price} to format price like this: ${price}, {price}$, ...', WORDPRESS_CONTENT_FILTER_LANG ),
			),
		),
	);

	wcf_register_field( 'price', __( 'Price - Shop', WORDPRESS_CONTENT_FILTER_LANG ), $options );
}

add_action( 'init', 'wcf_register_price_field' );


function wcf_forms_field_price_frontend($form_id = '', $field_id, $data = array() ) {

	$settings = wcf_get_form_search_settings( $form_id );
	$post_types = isset($settings['post_type']) ? $settings['post_type'] : array();
	if (!in_array($data['shop'], $post_types)) {
		echo __('This shop has not checked yet in the Settings -> Post Type of form search', WORDPRESS_CONTENT_FILTER_LANG);
		return;
	}

	$label = $data['label'] != '' ? $data['label'] : '';
	$pre_name = "wcf_range_price[".$field_id."]";
	$range_value = isset($data['range_value']) && !empty($data['range_value']) ? explode('-', $data['range_value']) : array();

	$min = isset( $_GET[$pre_name]['min'] ) ? esc_attr( $_GET[$pre_name]['min'] ) : $range_value[0];
	$max = isset( $_GET[$pre_name]['max'] ) ? esc_attr( $_GET[$pre_name]['max'] ) : $range_value[1];

	$min_symbol = str_replace('{price}', '<span class="range_from">'.$min.'</span>', $data['price_format']);
	$max_symbol = str_replace('{price}', '<span class="range_to">'.$max.'</span>', $data['price_format']);
	?>
	<div class="slider-range-wrapper">
		<label for="<?php echo $field_id;?>" class="wcf-label"><?php echo $label;?> : <span class="range-slider-label"><?php echo $min_symbol;?> - <?php echo $max_symbol;?></span></label>
		<div class="wcf-field-body">
			<div class="slider-range" data-step="1"></div>
			<input type="hidden" name="<?php echo $pre_name . '[min]';?>" class="range_min" data-min="<?php echo $range_value[0];?>" value="<?php echo $min; ?>"/>
			<input type="hidden" name="<?php echo $pre_name . '[max]';?>" class="range_max" data-max="<?php echo $range_value[1];?>" value="<?php echo $max; ?>"/>
		</div>
	</div>
<?php
}