<?php
/**
 * @version    $Id$
 * @package    WordPress Content Filter
 * @author     ZuFusion
 * @copyright  Copyright (C) 2015 ZuFusion All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 */

function wcf_register_rating_field() {

	$options = array(
		'frontend_callback' => 'wcf_forms_field_rating_frontend',
		'before_admin_options_desc' => __('Note: currently, the plugin only supports filter rating for Products (WooCommerce)', WORDPRESS_CONTENT_FILTER_LANG),
		'admin_options' => array(
			array(
				'type' => 'text',
				'name' => 'label',
				'value' => 'Rating',
				'label' => __( 'Label', WORDPRESS_CONTENT_FILTER_LANG ),
				'class' => '',
				'desc' => __( 'Display field label at the frontend', WORDPRESS_CONTENT_FILTER_LANG ),
			),
			array(
				'type' => 'select',
				'label' => __( 'Select Shop', WORDPRESS_CONTENT_FILTER_LANG ),
				'name' => 'shop',
				'value' => 'product',
				'options' => apply_filters('wcf_rating_shop_type_options', array(
					'product' => __('Products', WORDPRESS_CONTENT_FILTER_LANG),
//					'download' => __('Downloads', WORDPRESS_CONTENT_FILTER_LANG),
				)),
				'class' => '',
				'desc' => __( 'Note: you need check the shop that you want to search at Settings -> Post Type (Settings metabox right). In case, Shop no listed in Settings -> Post Type. That means you have\'t installed yet or It was not supported by the this plugin', WORDPRESS_CONTENT_FILTER_LANG ),
			),
			array(
				'type' => 'radio',
				'label' => __( 'Filter by rating', WORDPRESS_CONTENT_FILTER_LANG ),
				'name' => 'filter',
				'value' => 'no',
				'options' => array(
					'no' => __('No', WORDPRESS_CONTENT_FILTER_LANG),
					'yes' => __('Yes', WORDPRESS_CONTENT_FILTER_LANG),
				),
				'class' => '',
				'desc' => __( 'Check default filter by rating at the frontend', WORDPRESS_CONTENT_FILTER_LANG ),
			),
		),
	);

	wcf_register_field( 'rating', __( 'Rating', WORDPRESS_CONTENT_FILTER_LANG ), $options );
}

add_action( 'init', 'wcf_register_rating_field' );


function wcf_forms_field_rating_frontend($form_id = '', $field_id, $data = array() ) {

	$label = $data['label'] != '' ? $data['label'] : '';
	$pre_name = "wcf_rating[".$field_id."]";
	$min = 1;
	$max = 5;
	?>

	<div class="wcf-rating">
		<label for="<?php echo $field_id;?>" class="wcf-label"><?php echo $label;?> : <span class="range-slider-label"><span class="range_from"><?php echo $min;?></span> - <span class="range_to"><?php echo $max;?></span> <?php echo __('Stars', WORDPRESS_CONTENT_FILTER_LANG);?></span></label>
		<div class="wcf-field-body">
			<div class="wcf-stars">
				<input class="wcf-star wcf-star-5" id="<?php echo $pre_name . '_';?>star-5" type="radio" name="<?php echo $pre_name . '[star]';?>" value="5" checked="checked"/>
				<label class="wcf-star wcf-star-5" for="<?php echo $pre_name . '_';?>star-5"></label>
				<input class="wcf-star wcf-star-4" id="<?php echo $pre_name . '_';?>star-4" type="radio" name="<?php echo $pre_name . '[star]';?>" value="4"/>
				<label class="wcf-star wcf-star-4" for="<?php echo $pre_name . '_';?>star-4"></label>
				<input class="wcf-star wcf-star-3" id="<?php echo $pre_name . '_';?>star-3" type="radio" name="<?php echo $pre_name . '[star]';?>" value="3"/>
				<label class="wcf-star wcf-star-3" for="<?php echo $pre_name . '_';?>star-3"></label>
				<input class="wcf-star wcf-star-2" id="<?php echo $pre_name . '_';?>star-2" type="radio" name="<?php echo $pre_name . '[star]';?>" value="2"/>
				<label class="wcf-star wcf-star-2" for="<?php echo $pre_name . '_';?>star-2"></label>
				<input class="wcf-star wcf-star-1" id="<?php echo $pre_name . '_';?>star-1" type="radio" name="<?php echo $pre_name . '[star]';?>" value="1"/>
				<label class="wcf-star wcf-star-1" for="<?php echo $pre_name . '_';?>star-1"></label>
		    </div>
			<?php
			$field_args = array(
				'type' => 'checkbox',
				'name' => $pre_name . '[filter]' ,
				'id' => $pre_name . '_checkbox',
				'class' => 'wcf-checkbox-item',
				'value' => $data['filter'],
				'options' => array(
					'yes' => __('Filter by rating')
				),
			);

			wcf_forms_field($field_args);
			?>

		</div>
	</div>
<?php
}