<?php
/**
 * @version    $Id$
 * @package    WordPress Content Filter
 * @author     ZuFusion
 * @copyright  Copyright (C) 2015 ZuFusion All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 */

add_action( 'wcf_forms_available_fields', 'wcf_forms_available_fields', 15, 1 );

/**
 * Display all registered field type
 *
 * @param $form_id
 */
function wcf_forms_available_fields( $form_id ) {

    global $wcf_register_fields;
	?>
    <span><?php _e('Drag each item into \'Search Form\' box below you prefer. Click the arrow on the right of the item to reveal additional configuration options.', WORDPRESS_CONTENT_FILTER_LANG)?></span>
   <ul class="menu wcf-forms-available-field-list" id="wcf-forms-available-field-list">
       <?php
       if ( is_array( $wcf_register_fields ) && ! empty( $wcf_register_fields ) ) {
           foreach ( $wcf_register_fields as $field_type => $val ) {
               wcf_forms_field_li( $field_type, $val['title'] );
           }
       }
       ?>
   </ul>
<?php

}

/**
 * Display a field type
 *
 * @param string $type
 * @param string $title
 * @param string $li_class
 * @param string $top_inner_item_settings
 * @param string $after_inner_item_settings
 */
function wcf_forms_field_li( $type = '', $title = '', $li_class = 'wcf-icon-menu', $top_inner_item_settings = '', $after_inner_item_settings = '') {

    ?>
    <li class="wcf_forms_field_li <?php echo $li_class;?>" data-type="<?php echo $type?>">
        <dl class="menu-item-bar">
            <dt class="menu-item-handle">
                <span class="item-title forms-field-title"><?php echo $title; ?></span>
                <span class="item-controls">
                    <a class="item-edit wcf-item-edit" title="<?php _e( 'Edit Menu Item', WORDPRESS_CONTENT_FILTER_LANG ); ?>"
                       href="#"></a>
                </span>
            </dt>
        </dl>
        <div class="menu-item-settings">
            <?php
            if ($top_inner_item_settings != '') {
                echo $top_inner_item_settings;
            }
            ?>
            <div class="menu-item-actions">
                <a class="item-delete wcf-delete-field" href="#"><?php _e( 'Remove', WORDPRESS_CONTENT_FILTER_LANG ); ?></a>
                <span class="meta-sep hide-if-no-js"> | </span>
                <a class="item-cancel wcf-cancel-field hide-if-no-js" href="#"><?php _e( 'Cancel', WORDPRESS_CONTENT_FILTER_LANG ); ?></a>
            </div>
            <?php
            if ($after_inner_item_settings != '') {
                echo $after_inner_item_settings;
            }
            ?>
        </div>
    </li>

<?php
}

add_action( 'wcf_forms_search_fields', 'wcf_forms_search_fields', 15, 1 );

/**
 * Display all built fields on a form search
 * @param $form_id
 */
function wcf_forms_search_fields( $form_id ) {

    global $wcf_register_fields;
    // Use get_post_meta to retrieve an existing value from the database.
    $data = get_post_meta( $form_id, '_wcf_form_search_field_values', true );
    ?>
    <ul class="menu wcf-forms-search-fields-list" id="wcf-forms-search-fields-list">
        <?php 
            if (!empty($data) && is_array($data)) {
                foreach ( $data as $key => $key_values) {
                    $field_data = explode("::", $key);
                    $field_id = $field_data[0];
                    $field_type = $field_data[1];

                    $inner_top = '<input type="hidden" name="wcf-fields[]" value="'.$field_id.'::'.$field_type.'"/>';
                    $inner_top .= '<input type="hidden" class="wcf-field-id" value="'.$field_id.'" />';
                    $inner_after = '';

                    $inner_top .=  wcf_get_field_type_options($field_type, $field_id, $key_values);
                    wcf_forms_field_li($field_type, $wcf_register_fields[$field_type]['title'], '', $inner_top);
                }

            }
        ?>
    </ul>
    <div id="wcf-thickbox" style="display:none;"><div id="wcf-thickbox-body"><?php _e('Loading ...', WORDPRESS_CONTENT_FILTER_LANG);?></div> <br> <input type="button" class="button insert_term" value="<?php _e('Insert', WORDPRESS_CONTENT_FILTER_LANG)?>" ></div>
<?php

}

add_action( 'wcf_forms_settings', 'wcf_forms_settings', 20, 1 );
/**
 * Search settings of a form search
 *
 * @param $form_id
 */
function wcf_forms_settings( $form_id ) {

    ?>
    <div id="wcf-setting-page">
        <?php

        $post_types = get_post_types( array('public' => true, '_builtin' => true ), 'objects', 'or' );
        unset($post_types['revision']);
        unset($post_types['attachment']);
        unset($post_types['nav_menu_item']);
        unset($post_types['zf-wcf']);
        $post_type_arr = array();
        foreach ( $post_types  as $post_type ) {
            $post_type_arr[$post_type->name] = $post_type->label;
        }
        $prefix_name = 'wcf-settings';
        $settings = (array)wcf_get_form_search_settings($form_id);

        $settings = wp_parse_args($settings, array(
            'search_type' => 'single',
            'post_type' => array('post'),
            'taxonomy_relation' => 'and',
            'meta_relation' => 'and',
            'date_relation' => 'or',
            'display_mode' => 'vertical',
            'mobile_fields' => 'yes',
            'toggle_field' => 'yes',
            'auto_filter' => 'yes',
            'display_results' => 'ajax',
            'custom_template' => '',
            'per_page' => 10,
            'columns_per_row' => 3,
        ));

        $search_type_options = array(
            'type' => 'radio',
            'name' => $prefix_name . '[search_type]',
            'value' => $settings['search_type'],
            'options' => array(
                'single' => __('Single', WORDPRESS_CONTENT_FILTER_LANG),
                'multiple' => __('Multiple', WORDPRESS_CONTENT_FILTER_LANG),
            ),
            'label' => __( 'Search Type', WORDPRESS_CONTENT_FILTER_LANG ),
            'class' => '',
            'desc' => __('Search single or multiple post type', WORDPRESS_CONTENT_FILTER_LANG),
        );
        wcf_forms_field($search_type_options);

        $post_type_options = array(
            'type' => 'checkbox',
            'name' => $prefix_name . '[post_type][]',
            'value' => $settings['post_type'],
            'options' => $post_type_arr,
            'label' => __( 'Post Type', WORDPRESS_CONTENT_FILTER_LANG ),
            'class' => '',
            'desc' => __('Select the post type you want to include in the search', WORDPRESS_CONTENT_FILTER_LANG),
            'wrapper_class' => 'wcf_post_type_checkbox',
        );
        wcf_forms_field($post_type_options);

        $taxonomy_options = array(
            'type' => 'radio',
            'name' => $prefix_name . '[taxonomy_relation]',
            'value' => $settings['taxonomy_relation'],
            'options' => array(
                'and' => __('AND', WORDPRESS_CONTENT_FILTER_LANG),
                'or' => __('OR', WORDPRESS_CONTENT_FILTER_LANG),
            ),
            'label' => __( 'Taxonomy', WORDPRESS_CONTENT_FILTER_LANG ),
            'class' => '',
            'desc' => __('It defines the relation when there is more than one \'Taxonomy\'', WORDPRESS_CONTENT_FILTER_LANG),
        );
        wcf_forms_field($taxonomy_options);

        $meta_options = array(
            'type' => 'radio',
            'name' => $prefix_name . '[meta_relation]',
            'value' => $settings['meta_relation'],
            'options' => array(
                'and' => __('AND', WORDPRESS_CONTENT_FILTER_LANG),
                'or' => __('OR', WORDPRESS_CONTENT_FILTER_LANG),
            ),
            'label' => __( 'Meta Field/Advanced Custom Fields', WORDPRESS_CONTENT_FILTER_LANG ),
            'class' => '',
            'desc' => __('It defines the relation when there is more than one Meta Field/Advanced Custom Fields', WORDPRESS_CONTENT_FILTER_LANG),
        );
        wcf_forms_field($meta_options);

        $date_options = array(
            'type' => 'radio',
            'name' => $prefix_name . '[date_relation]',
            'value' => $settings['date_relation'],
            'options' => array(
                'and' => __('AND', WORDPRESS_CONTENT_FILTER_LANG),
                'or' => __('OR', WORDPRESS_CONTENT_FILTER_LANG),
            ),
            'label' => __( 'Date', WORDPRESS_CONTENT_FILTER_LANG ),
            'class' => '',
            'desc' => __('It defines the relation when there is more than one Date', WORDPRESS_CONTENT_FILTER_LANG),
        );
        wcf_forms_field($date_options);

        $display_results_options = array(
            'type' => 'radio',
            'name' => $prefix_name . '[display_results]',
            'value' => $settings['display_results'],
            'options' => array(
                'ajax' => __('Ajax', WORDPRESS_CONTENT_FILTER_LANG),
                'redirect' => __('Redirect', WORDPRESS_CONTENT_FILTER_LANG),
            ),
            'label' => __( 'Display Results', WORDPRESS_CONTENT_FILTER_LANG ),
            'class' => '',
            'desc' => __('Display results with AJAX or Redirect results', WORDPRESS_CONTENT_FILTER_LANG),
        );
        wcf_forms_field($display_results_options);

        $auto_filter_options = array(
            'type' => 'radio',
            'name' => $prefix_name . '[auto_filter]',
            'value' => $settings['auto_filter'],
            'options' => array(
                'yes' => __('Yes', WORDPRESS_CONTENT_FILTER_LANG),
                'no' => __('No', WORDPRESS_CONTENT_FILTER_LANG),
            ),
            'label' => __( 'Auto Filter', WORDPRESS_CONTENT_FILTER_LANG ),
            'class' => '',
            'desc' => __('Auto filter without clicking submit button form ( Only for AJAX )', WORDPRESS_CONTENT_FILTER_LANG),
        );
        wcf_forms_field($auto_filter_options);

        $display_mode_options = array(
            'type' => 'radio',
            'name' => $prefix_name . '[display_mode]',
            'value' => $settings['display_mode'],
            'options' => array(
                'vertical' => __('Vertical', WORDPRESS_CONTENT_FILTER_LANG),
                'horizontal' => __('Horizontal', WORDPRESS_CONTENT_FILTER_LANG),
            ),
            'label' => __( 'Displaying mode', WORDPRESS_CONTENT_FILTER_LANG ),
            'class' => '',
            'desc' => __('Displaying Fields: Vertical or Horizontal', WORDPRESS_CONTENT_FILTER_LANG),
        );
        wcf_forms_field($display_mode_options);

        $vertical_fields_mobile_options = array(
            'type' => 'radio',
            'name' => $prefix_name . '[mobile_fields]',
            'value' => $settings['mobile_fields'],
            'options' => array(
                'yes' => __('Yes', WORDPRESS_CONTENT_FILTER_LANG),
                'no' => __('No', WORDPRESS_CONTENT_FILTER_LANG),
            ),
            'label' => __( 'Mobile Fields', WORDPRESS_CONTENT_FILTER_LANG ),
            'class' => '',
            'desc' => __('Horizontal Fields On Mobile (Only for Displaying Mode is Vertical)', WORDPRESS_CONTENT_FILTER_LANG),
        );
        wcf_forms_field($vertical_fields_mobile_options);

        $toggle_options = array(
            'type' => 'radio',
            'name' => $prefix_name . '[toggle_field]',
            'value' => $settings['toggle_field'],
            'options' => array(
                'yes' => __('Yes', WORDPRESS_CONTENT_FILTER_LANG),
                'no' => __('No', WORDPRESS_CONTENT_FILTER_LANG),
            ),
            'label' => __( 'Toggle Field', WORDPRESS_CONTENT_FILTER_LANG ),
            'class' => '',
            'desc' => __('Show a left arrow on field label to toggle field', WORDPRESS_CONTENT_FILTER_LANG),
        );
        wcf_forms_field($toggle_options);

        $template_options = array(
            'type' => 'text',
            'name' => $prefix_name . '[custom_template]',
            'value' => $settings['custom_template'],
            'label' => __( 'Custom Template', WORDPRESS_CONTENT_FILTER_LANG ),
            'class' => '',
            'desc' => __('Enter the template Or Leave blank to use default the search.php file from theme directory', WORDPRESS_CONTENT_FILTER_LANG),
        );
        wcf_forms_field($template_options);

        $template_options = array(
            'type' => 'text',
            'name' => $prefix_name . '[per_page]',
            'value' => $settings['per_page'],
            'label' => __( 'Results per Page', WORDPRESS_CONTENT_FILTER_LANG ),
            'class' => '',
            'desc' => '',
        );
        wcf_forms_field($template_options);

        $columns_options = array(
            'type' => 'select',
            'name' => $prefix_name . '[columns_per_row]',
            'options' => array(
                '1' => 1,
                '2' => 2,
                '3' => 3,
                '4' => 4,
            ),
            'value' => $settings['columns_per_row'],
            'label' => __( 'Columns per row', WORDPRESS_CONTENT_FILTER_LANG ),
            'class' => '',
            'desc' => '',
        );
        wcf_forms_field($columns_options);

        ?>
    </div>
<?php

}

/**
 * Get admin options for field type
 * @param      $field_type
 * @param      $field_id
 * @param bool $load_value
 * @return string
 */
function wcf_get_field_type_options($field_type, $field_id, $load_value = false) {

    global $wcf_register_fields;
    $output = '';

    if (isset($wcf_register_fields[$field_type])) {

        $options = isset($wcf_register_fields[$field_type]['options']) ? $wcf_register_fields[$field_type]['options'] : array();
        $admin_options = isset($options['admin_options']) ? $options['admin_options'] : array();
        $before_admin_options_desc = isset($options['before_admin_options_desc']) ? $options['before_admin_options_desc'] : '';
        $after_admin_options_desc = isset($options['after_admin_options_desc']) ? $options['after_admin_options_desc'] : '';
        $before_admin_html = isset($option['before_admin_html']) ? $option['before_admin_html'] : '';
        $after_admin_html = isset($option['after_admin_html']) ? $option['after_admin_html'] : '';

        do_action('wcf_before_field_type_options', $field_type, $field_id, $admin_options, $load_value);

        if (!empty($admin_options)) {

            if ($before_admin_html != '') {
                $output .= $before_admin_html;
            }

            if ($before_admin_options_desc != '') {
                $output .= '<p>'. $before_admin_options_desc .'</p>';
            }

            foreach ( $admin_options as $option ) {
                if (!empty($load_value) && isset($load_value[$option['name']])) {

                    $option['value'] = $load_value[$option['name']];
                    if (is_serialized($load_value[$option['name']])) {
                        $option['value'] = maybe_unserialize($load_value[$option['name']]);
                    }

                }
                $opts = isset($option['options']) ? $option['options'] : array();
                $class = 'wcf-forms-' . $option['name'] . ' ' . $option['class'];
                $id    = 'wcf_forms_field_' . $option['name'] . '_' . $field_id;
                $name = 'wcf_forms_field_' . $option['name'] . '_' . $field_id;
                $before_html = isset($option['before_html']) ? $option['before_html'] : '';
                $after_html = isset($option['after_html']) ? $option['after_html'] : '';
                $before_html_field = isset($option['before_html_field']) ? $option['before_html_field'] : '';
                $after_html_field = isset($option['after_html_field']) ? $option['after_html_field'] : '';
                $field_args = array(
                    'type' => $option['type'],
                    'label' => $option['label'],
                    'name' => $name,
                    'id' => $id,
                    'value' => $option['value'],
                    'options' => $opts,
                    'class' => $class,
                    'desc' => $option['desc'],
                    'before_html' => $before_html,
                    'after_html' => $after_html,
                    'before_html_field' => $before_html_field,
                    'after_html_field' => $after_html_field,
                );
                ob_start();
                wcf_forms_field($field_args);
                $output .= ob_get_clean();

            }

            if ($after_admin_options_desc != '') {
                $output .= '<p>'. $after_admin_options_desc .'</p>';
            }

            if ($after_admin_html != '') {
                $output .= $after_admin_html;
            }

        } else {
            $output .= __('This field doesn\'t have any options', WORDPRESS_CONTENT_FILTER_LANG);
        }

        do_action('wcf_after_field_type_options', $field_type, $field_id, $admin_options, $load_value);

    }

    return $output;
}


/**
 * Get all color styles from assets/css/colors/
 * @return array
 */
function wcf_get_colors() {


    // allow custom skins folder
    $dir = WORDPRESS_CONTENT_FILTER_PLUGIN_PATH . 'assets/css/colors';

    $colors = wcf_get_colors_from_path( $dir );
    // custom skins
    $addition_dir = apply_filters( 'wcf_colors_dir', WORDPRESS_CONTENT_FILTER_THEME_PATH . 'wordpress-content-filter/colors' );
    if ( $addition_dir != $dir ) {
        $custom_skins = wcf_get_colors_from_path( $addition_dir );
        if ( ! empty( $custom_skins ) ) {
            $colors = array_merge( $colors, $custom_skins );
        }
    }

    return $colors;
}

/**
 * Read list file from directory
 * @param $dir
 * @return array
 */
function wcf_get_colors_from_path( $dir ) {

    $colors = array();

    if ( is_dir( $dir ) ) {
        if ( $theme_dir = opendir( $dir ) ) {
            while ( ( $color_file = readdir( $theme_dir ) ) !== false ) {
                $ext = pathinfo( $color_file, PATHINFO_EXTENSION );
                if ( $ext == 'css' ) {
                    $key                         = str_replace( '.css', '', $color_file );
                    $colors[ strtolower( $key ) ] = $color_file;
                }
            }
        }
    }

    return $colors;
}
