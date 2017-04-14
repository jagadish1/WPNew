<?php
/**
 * @version    $Id$
 * @package    WordPress Content Filter
 * @author     ZuFusion
 * @copyright  Copyright (C) 2015 ZuFusion All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 */

/**
 * get options
 * @param array $defaults
 * @return mixed
 */
function wcf_get_options() {
	$defaults = array(
		'color_scheme'          => 'dark',
		'scroll_top'          => 'yes',
		'ajax_loader'          => '',
		'custom_css'          => '',
	);
	$defaults = apply_filters( 'wcf_default_options', $defaults );
	$options  = wp_parse_args( get_option( 'wcf_settings_options', array() ), $defaults );
	return $options;
}

/**
 * Render a field type
 * @param        $type
 * @param string $label
 * @param string $name
 * @param string $value
 * @param array  $options
 * @param string $id
 * @param string $class
 * @param string $label_class
 * @param string $desc
 * @param string $before_html
 * @param string $after_html
 * @param string $wrapper_class
 */
function wcf_forms_field( $args = array() ) {


	extract(wp_parse_args($args, array(
		'type' => 'text',
		'label' => '',
		'name' => '',
		'value' => '',
		'options' => array(),
		'id' => '',
		'class' => '',
		'label_class' => '',
		'desc' => '',
		'extra_attr' => '',
		'no_display' => 'no',
		'before_html' => '',
		'after_html' => '',
		'wrapper' => 'yes',
		'wrapper_class' => '',
		'wrapper_attr' => '',
		'before_html_field' => '',
		'after_html_field' => '',
	)));
	if ($no_display != 'no') {return;}

	$label_class = 'wcf-field-label ' . $label_class;
	if (is_array($value)) {$value = array_map('trim', $value);}

	?>
	<?php if ($wrapper == 'yes') { ?>
	<div id="forms_field_<?php echo $name;?>" class="wcf-form-field-wrapper wcf-field-<?php echo $type;?> <?php echo $wrapper_class;?>" <?php echo $wrapper_attr;?>>
	<?php } ?>
		<?php
		if ( $type != 'desc' && $label != '' ) {
			?>
			<label for="<?php echo $id;?>" id="<?php echo $id;?>_label" class="<?php echo trim($label_class);?>"><?php echo $label; ?> : </label>
		<?php
		}
		if ($before_html != '') { echo $before_html;}

		if ($before_html_field != '') { echo $before_html_field;}

		switch ( $type ) {
			case 'text':
				?>
				<input type="text" class="<?php echo $class;?>" name="<?php echo $name;?>" id="<?php echo $id;?>" value="<?php echo $value;?>" <?php echo $extra_attr;?>/>
				<?php
				break;
			case 'number':
				?>
				<input type="number" class="<?php echo $class;?>" name="<?php echo $name;?>" id="<?php echo $id;?>" value="<?php echo $value;?>" <?php echo $extra_attr;?>/>
				<?php
				break;
			case 'checkbox':

				if ( is_array( $options ) && ! empty( $options ) ) {
					foreach ( $options as $key => $text ) {

						if (is_array($value) && in_array($key, $value)) {
							$checked = 'checked="checked"';
						} else {
							$checked = checked( $value, $key , false);
						}
						?>
						<div class="wcf-checkbox-wrapper"><input type="checkbox" value="<?php echo $key;?>" name="<?php echo $name;?>" class="<?php echo $class;?>" <?php echo $checked;?> <?php echo $extra_attr;?>><label class="wcf-checkbox-label"> <?php echo $text;?></label></div>
					<?php
					}
				}

				break;
			case 'radio':

				if ( is_array( $options ) && ! empty( $options ) ) {
					foreach ( $options as $key => $text ) {

						$checked = checked( $value, $key , false);
						?>
						<div class="wcf-radio-wrapper"><input type="radio" value="<?php echo $key;?>" name="<?php echo $name;?>" class="<?php echo $class;?>" <?php echo $checked;?>><label class="wcf-radio-label"> <?php echo $text;?></label></div>
					<?php
					}
				}

				break;
			case 'select':
				?>
				<select id="<?php echo $id;?>" name="<?php echo $name;?>" class="<?php echo $class;?>">
					<?php
					if ( is_array( $options ) && ! empty( $options ) ) {
						foreach ( $options as $key => $text ) {

							$selected = selected( $key, $value , false);

							?>
							<option value="<?php echo $key;?>" <?php echo $selected; ?>><?php echo trim($text); ?></option>
						<?php
						}
					}
					?>
				</select>
				<?php
				break;

			case 'terms_color':

				if ( is_array($value) && ! empty( $value )) {

					?>
					<table class="widefat">
					<thead>
						<th><?php echo __('Name', WORDPRESS_CONTENT_FILTER_LANG);?></th>
						<th><?php echo __('Color', WORDPRESS_CONTENT_FILTER_LANG);?></th>
					</thead>
					<?php

					foreach ( $value as $slug => $color ) {

						?>
						<tr>
							<td><?php echo $slug;?></td>
							<td><input type="text" class="wcf-color-picker" name="<?php echo $name . '['.$slug.']';?>" value="<?php echo $color;?>"/></td>
						</tr>
						<?php
					}
					?>
					</table>
					<?php
				}

				break;

			case 'checkbox_color':

				if ( is_array( $options ) && ! empty( $options ) ) {
					foreach ( $options as $key => $color ) {

						if (is_array($value) && in_array($key, $value)) {
							$checked = 'checked="checked"';
						} else {
							$checked = checked( $value, $key , false);
						}
						?>
						<div class="wcf-checkbox-wrapper wcf-checkbox-color-wrapper">
							<input type="checkbox" value="<?php echo $key;?>" name="<?php echo $name;?>" id="<?php echo $id;?>" class="<?php echo $class;?>" <?php echo $checked;?> <?php echo $extra_attr;?>>
							<label class="wcf-checkbox-color-label" for="<?php echo $id;?>" style="background-color: <?php echo $color;?>;"></label>
						</div>
					<?php
					}
				}

				break;

			case 'multiple':
				?>
				<select id="<?php echo $id;?>" name="<?php echo $name;?>" class="<?php echo $class;?>" multiple="multiple">
					<?php
					if ( is_array( $options ) && ! empty( $options ) ) {
						foreach ( $options as $key => $text ) {

							if (is_array($value) && in_array($key, $value)) {
								$selected = 'selected="selected"';
							} else {
								$selected = selected( $key, $value , false);
							}
							?>
							<option value="<?php echo $key;?>" <?php echo $selected; ?>><?php echo trim($text); ?></option>
						<?php
						}
					}
					?>
				</select>
				<?php
				break;
			case 'textarea':
				?>
				<textarea id="<?php echo $id;?>" name="<?php echo $name;?>" class="<?php echo $class;?>" rows="4"><?php echo $value;?></textarea>
				<?php
				break;
			case 'hidden':
				?>
				<input type="hidden" name="<?php echo $name;?>" value="<?php echo $value;?>">
				<?php
				break;
			case 'desc':
				?>
				<span class="desc"><label for="<?php echo $id;?>" id="<?php echo $id;?>_heading"><?php _e( $label, WORDPRESS_CONTENT_FILTER_LANG ); ?></label></span>
				<?php
				break;
		}
		if ($after_html_field != '') { echo $after_html_field;}

		if ( $desc != '' ) {
			?>
			<br/><span class="description"><?php _e( $desc, WORDPRESS_CONTENT_FILTER_LANG ); ?></span>
		<?php
		}
		if ($after_html != '') { echo $after_html;}
		?>
	<?php if ($wrapper == 'yes') { ?>
	</div>
	<?php } ?>
<?php
}

function wcf_display_field($form_id = '', $field_id = '', $field_type = '', $field_data = array()) {

	global $wcf_register_fields;

	do_action( 'wcf_display_field_before', $field_id, $field_type, $field_data );

	if (!isset($wcf_register_fields[$field_type])) {return;}

	$register_configs = isset($wcf_register_fields[$field_type]['options']) ? $wcf_register_fields[$field_type]['options'] : array();

	if($register_configs['frontend_callback'] != '') {

		$args['form_id']  = $form_id;
		$args['field_id'] = $field_id;
		$args['options']  = $field_data;

		if ( is_callable( $register_configs['frontend_callback'] ) ) {
			call_user_func_array( $register_configs['frontend_callback'], $args );
		}

	}

	do_action( 'wcf_display_field_after', $field_id, $field_type, $field_data );
}

/**
 * Register a field type
 * @param       $field_type
 * @param       $title
 * @param array $options
 * @return bool
 */
function wcf_register_field($field_type, $title, $options = array()) {

	global $wcf_register_fields;

	$field_type = trim( $field_type );
	if ( '' == $field_type )
		return false;

	if( !isset( $wcf_register_fields ) ){
		$wcf_register_fields = array();
	}

	$options_defaults = array(
		'frontend_callback' => '',
		'before_admin_options_desc' => '',
		'after_admin_options_desc' => '',
		'admin_options' => ''
	);

	$options = wp_parse_args( $options, $options_defaults );

	$wcf_register_fields[$field_type] = array(
		'title' => $title,
		'options' => $options
	);

}

/**
 * Get all meta keys
 * @return array
 */

function wcf_get_all_meta_keys() {

	global $wpdb;
	$table = $wpdb->prefix.'postmeta';
	$meta_keys = $wpdb->get_results( "SELECT meta_key FROM {$table} GROUP BY meta_key");
	$keys = array();
	if (is_array($meta_keys)) {
		foreach($meta_keys as $key){
			$keys[] = $key->meta_key;
		}
	}

	return $keys;
}

/**
 * Get all values for a meta key
 * @param $meta_key
 * @return array
 */
function wcf_get_meta_values($meta_key) {

	global $wpdb;
	$table = $wpdb->prefix.'postmeta';
	$results = $wpdb->get_results($wpdb->prepare( "SELECT meta_value FROM {$table} WHERE meta_key = '%s' GROUP BY meta_value", array($meta_key)) );

	return $results;
}

/**
 * Get fields of form search
 * @param $form_id
 * @return mixed
 */
function wcf_get_form_search_values($form_id) {

	return get_post_meta( $form_id, '_wcf_form_search_field_values', true );
}

/**
 * Get fields of form search
 * @param $form_id
 * @return mixed
 */
function wcf_get_form_search_settings($form_id) {

	return get_post_meta( $form_id, '_wcf_form_search_settings', true );
}

/**
 * Search keyword in string
 * @param string $keyword
 * @param string $subject
 * @return bool
 */
function wcf_search_match($keyword = '', $subject = '') {
	$pattern = '%'.$keyword.'%';
	$pattern = str_replace('%', '.*', preg_quote($pattern));
	return (bool) preg_match("/^{$pattern}$/i", $subject);
}

/**
 * Get a template
 */

function wcf_get_template( $template, $load = true, $require_once = true ) {

	// Get the template slug
	if (strpos($template, '.php') == false) {
		$template = $template . '.php';
	}

	// Check if a custom template exists in the theme folder, if not, load the plugin template file
	$template_path = WORDPRESS_CONTENT_FILTER_THEME_PATH . 'wordpress-content-filter/templates/' . $template;

	if ( $theme_file = locate_template(  array($template_path) ) ) {
		$file = $theme_file;
	}
	else {
		$file = WORDPRESS_CONTENT_FILTER_PLUGIN_PATH . 'templates/' . $template;
		if (!file_exists($file)) $file = '';
	}

	$file = apply_filters( 'wcf_get_template', $file, $template );

	if ( $load && '' != $file ) {
		load_template( $file, $require_once );
	}

	return $file;
}

/**
 * Render pagination
 * @param int    $pages
 * @param int    $paged
 * @param bool   $echo
 * @param string $static_url
 * @return string
 */
function wcf_pagination( $pages = 0, $paged = 0, $echo = true, $static_url = '' ) {

	global $wp_rewrite, $wp_query;
	$output = '';
	if ( $pages > 0 ) {
		$total = $pages;
	} else {
		$total = $wp_query->max_num_pages;
	}
	if ( $paged == 0 ) {
		$paged = ( get_query_var( 'paged' ) ) ? intval( get_query_var( 'paged' ) ) : 1;
	}
	$big = 999999999; // This needs to be an unlikely integer
	// For more options and info view the docs for paginate_links()
	// http://codex.wordpress.org/Function_Reference/paginate_links
	if ($static_url != '') {
		$pagenum_link = str_replace( $big, '%#%', wcf_get_pagenum_link($static_url, $big));

	} else {
		$pagenum_link = str_replace( $big, '%#%', remove_query_arg( 'add-to-cart', get_pagenum_link( $big, false ) ) );
	}
//	$pagenum_link = trailingslashit( home_url() ) . '%_%';

	$paginate_links = wcf_paginate_links( array(
		'base'      => $pagenum_link,
		'current'   => max( 1, $paged ),
		'total'     => $total,
		'format'    => '?paged=%#%',
		'mid_size'  => 5,
		'prev_next' => true,
		'prev_text' => __( '&laquo; Previous', WORDPRESS_CONTENT_FILTER_LANG ),
		'next_text' => __( 'Next &raquo;', WORDPRESS_CONTENT_FILTER_LANG ),
		'type'      => 'array'
	) );

	// Display the pagination if more than one page is found
	if ( $paginate_links ) {

		foreach ( $paginate_links as $key => $link ) {
			if ( strpos( $link, 'current' ) !== false ) {
				$paginate_links[ $key ] = '<li class="active">' . $link . '</li>';
			} else {
				$paginate_links[ $key ] = '<li>' . $link . '</li>';
			}
		}
		$output .= "<ul class='wcf-pagination'>\n\t";
		$output .= join( "\n", $paginate_links );
		$output .= "\n</ul>\n";;
	}

	if ($echo == false) {
		return $output;
	} else {
		echo $output;
	}
}

/**
 * Custom paginate links
 * @param string $args
 * @return array|string
 */
function wcf_paginate_links( $args = '' ) {
	global $wp_query, $wp_rewrite;

	// Setting up default values based on the current URL.
	$pagenum_link = html_entity_decode( get_pagenum_link() );
	$url_parts    = explode( '?', $pagenum_link );

	// Get max pages and current page out of the current query, if available.
	$total   = isset( $wp_query->max_num_pages ) ? $wp_query->max_num_pages : 1;
	$current = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;

	// Append the format placeholder to the base URL.
	$pagenum_link = trailingslashit( $url_parts[0] ) . '%_%';

	// URL base depends on permalink settings.
	$format  = $wp_rewrite->using_index_permalinks() && ! strpos( $pagenum_link, 'index.php' ) ? 'index.php/' : '';
	$format .= $wp_rewrite->using_permalinks() ? user_trailingslashit( $wp_rewrite->pagination_base . '/%#%', 'paged' ) : '?paged=%#%';

	$defaults = array(
		'base' => $pagenum_link, // http://example.com/all_posts.php%_% : %_% is replaced by format (below)
		'format' => $format, // ?page=%#% : %#% is replaced by the page number
		'total' => $total,
		'current' => $current,
		'show_all' => false,
		'prev_next' => true,
		'prev_text' => __('&laquo; Previous'),
		'next_text' => __('Next &raquo;'),
		'end_size' => 1,
		'mid_size' => 2,
		'type' => 'plain',
		'add_args' => array(), // array of query args to add
		'add_fragment' => '',
		'before_page_number' => '',
		'after_page_number' => ''
	);

	$args = wp_parse_args( $args, $defaults );

	if ( ! is_array( $args['add_args'] ) ) {
		$args['add_args'] = array();
	}

	// Merge additional query vars found in the original URL into 'add_args' array.
	if ( isset( $url_parts[1] ) ) {
		// Find the format argument.
		$format_query = parse_url( str_replace( '%_%', $args['format'], $args['base'] ), PHP_URL_QUERY );
		wp_parse_str( $format_query, $format_arg );

		// Remove the format argument from the array of query arguments, to avoid overwriting custom format.
		wp_parse_str( remove_query_arg( array_keys( $format_arg ), $url_parts[1] ), $query_args );
		$args['add_args'] = array_merge( $args['add_args'], urlencode_deep( $query_args ) );
	}

	// Who knows what else people pass in $args
	$total = (int) $args['total'];
	if ( $total < 2 ) {
		return;
	}
	$current  = (int) $args['current'];
	$end_size = (int) $args['end_size']; // Out of bounds?  Make it the default.
	if ( $end_size < 1 ) {
		$end_size = 1;
	}
	$mid_size = (int) $args['mid_size'];
	if ( $mid_size < 0 ) {
		$mid_size = 2;
	}
	$add_args = $args['add_args'];
	$r = '';
	$page_links = array();
	$dots = false;

	if ( $args['prev_next'] && $current && 1 < $current ) :
		$link = str_replace( '%_%', 2 == $current ? '' : $args['format'], $args['base'] );
		$link = str_replace( '%#%', $current - 1, $link );
		if ( $add_args )
			$link = add_query_arg( $add_args, $link );
		$link .= $args['add_fragment'];

		/**
		 * Filter the paginated links for the given archive pages.
		 *
		 * @since 3.0.0
		 *
		 * @param string $link The paginated link URL.
		 */
		$page_links[] = '<a class="prev page-numbers" href="' . esc_url( apply_filters( 'paginate_links', $link ) ) . '" data-page="'.($current - 1).'">' . $args['prev_text'] . '</a>';
	endif;
	for ( $n = 1; $n <= $total; $n++ ) :
		if ( $n == $current ) :
			$page_links[] = "<span class='page-numbers current'>" . $args['before_page_number'] . number_format_i18n( $n ) . $args['after_page_number'] . "</span>";
			$dots = true;
		else :
			if ( $args['show_all'] || ( $n <= $end_size || ( $current && $n >= $current - $mid_size && $n <= $current + $mid_size ) || $n > $total - $end_size ) ) :
				$link = str_replace( '%_%', 1 == $n ? '' : $args['format'], $args['base'] );
				$link = str_replace( '%#%', $n, $link );
				if ( $add_args )
					$link = add_query_arg( $add_args, $link );
				$link .= $args['add_fragment'];

				/** This filter is documented in wp-includes/general-template.php */
				$page_links[] = "<a class='page-numbers' href='" . esc_url( apply_filters( 'paginate_links', $link ) ) . "'  data-page='".$n."'>" . $args['before_page_number'] . number_format_i18n( $n ) . $args['after_page_number'] . "</a>";
				$dots = true;
			elseif ( $dots && ! $args['show_all'] ) :
				$page_links[] = '<span class="page-numbers dots">' . __( '&hellip;' ) . '</span>';
				$dots = false;
			endif;
		endif;
	endfor;
	if ( $args['prev_next'] && $current && ( $current < $total || -1 == $total ) ) :
		$link = str_replace( '%_%', $args['format'], $args['base'] );
		$link = str_replace( '%#%', $current + 1, $link );
		if ( $add_args )
			$link = add_query_arg( $add_args, $link );
		$link .= $args['add_fragment'];

		/** This filter is documented in wp-includes/general-template.php */
		$page_links[] = '<a class="next page-numbers" href="' . esc_url( apply_filters( 'paginate_links', $link ) ) . '" data-page="'.($current + 1).'">' . $args['next_text'] . '</a>';
	endif;
	switch ( $args['type'] ) {
		case 'array' :
			return $page_links;

		case 'list' :
			$r .= "<ul class='page-numbers'>\n\t<li>";
			$r .= join("</li>\n\t<li>", $page_links);
			$r .= "</li>\n</ul>\n";
			break;

		default :
			$r = join("\n", $page_links);
			break;
	}
	return $r;
}


/**
 * Get page number link
 * @param string $static_url
 * @param int    $pagenum
 * @return string
 */
function wcf_get_pagenum_link($static_url = '', $pagenum = 1) {

	global $wp_rewrite;

	$pagenum = (int) $pagenum;
	if ($static_url != '') {
//		$request = $_SERVER['REQUEST_URI'];
		$request = $static_url;
	} else {
		$request = remove_query_arg( 'paged' );
	}
	$home_root = parse_url(home_url());
	$home_root = ( isset($home_root['path']) ) ? $home_root['path'] : '';
	$home_root = preg_quote( $home_root, '|' );

	$request = preg_replace('|^'. $home_root . '|i', '', $request);
	$request = preg_replace('|^/+|', '', $request);

	$qs_regex = '|\?.*?$|';
	preg_match( $qs_regex, $request, $qs_match );

	if ( !empty( $qs_match[0] ) ) {
		$query_string = $qs_match[0];
		$request = preg_replace( $qs_regex, '', $request );
	} else {
		$query_string = '';
	}

	$request = preg_replace( "|$wp_rewrite->pagination_base/\d+/?$|", '', $request);
	$request = preg_replace( '|^' . preg_quote( $wp_rewrite->index, '|' ) . '|i', '', $request);
	$request = ltrim($request, '/');
	$base = trailingslashit( get_bloginfo( 'url' ) );


	if ( $wp_rewrite->using_index_permalinks() && ( $pagenum > 1 || '' != $request ) )
		$base .= $wp_rewrite->index . '/';

	if ( $pagenum > 1 ) {
		$request = ( ( !empty( $request ) ) ? trailingslashit( $request ) : $request ) . user_trailingslashit( $wp_rewrite->pagination_base . "/" . $pagenum, 'paged' );
	}

	$result = $base . $request . $query_string;
	return $result;
}

/**
 * @param      $need
 * @param      $array
 * @param bool $return_key
 * @return bool|int|string
 */
function wcf_search_key_array( $need, $array, $return_key = false ) {

	foreach ( $array AS $key => $value ) {
		if ( strpos( $key, $need ) !== false ) {
			if ( $return_key ) {
				return $key;
			} else {
				return $value;
			}
		};
	}

	return false;
}

/**
 * display all fields for form search
 * @param       $form_id
 * @param array $fields
 * @param array $settings
 */
function wcf_display_form_fields($form_id, $fields = array(), $settings = array()) {

	if (!empty($fields) && is_array($fields)) {

		if (wcf_search_key_array('input_query', $fields)) {

			$display_mode = 'wcf-'.$settings['display_mode'];

			if ($settings['display_mode'] == 'vertical' && $settings['mobile_fields'] == 'yes' && wp_is_mobile()) {
				$display_mode = 'wcf-horizontal';
			}

			foreach ( $fields as $key => $field_data ) {
				$field_tem = explode("::", $key);
				echo '<div class="wcf-field-row '.$display_mode.' wcf-'.$field_tem[1].'">';
				wcf_display_field($form_id, $field_tem[0], $field_tem[1], $field_data);
				echo '</div>';
			}

		} else {
			echo __('Please add Input Query field for form search', WORDPRESS_CONTENT_FILTER_LANG);
		}

	}

}