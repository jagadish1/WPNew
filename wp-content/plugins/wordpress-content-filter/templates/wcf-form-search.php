<?php
/**
 * @version    $Id$
 * @package    WordPress Content Filter
 * @author     ZuFusion
 * @copyright  Copyright (C) 2015 ZuFusion All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 */


$wcf_form_class = 'wcf-form-search';
$wcf_form_class .= $settings['toggle_field'] == 'yes' ? ' wcf-arrow-field' : '';

echo '<form name="wcf-form-'.$id.'" id="wcf-form-'.$id.'" class="'.$wcf_form_class.'" method="get" action="'.home_url().'" role="search" data-form="'.$id.'" data-ajax="'.$settings['display_results'].'" data-auto="'.$settings['auto_filter'].'">';

do_action( 'wcf_form_search_before', $id, $settings);

$form_title = '';
if (isset($title)) {

	if ($title != '') {
		$form_title = $title;
	} else {
		$form = get_post($id);
		$form_title = $form->post_title;
	}

	if ($form_title != '') {
		echo '<h3 class="wcf-form-title">'.$form_title.'</h3>';
	}
}

wcf_display_form_fields($id, $fields, $settings);

do_action( 'wcf_form_search_after', $id, $settings);

echo '</form>';
echo '<div class="wcf-clear"></div>';