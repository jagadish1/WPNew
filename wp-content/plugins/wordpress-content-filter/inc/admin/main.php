<?php
/**
 * @version    $Id$
 * @package    WordPress Content Filter
 * @author     ZuFusion
 * @copyright  Copyright (C) 2015 ZuFusion All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 */

class Wordpress_Content_Filter_Admin
{

    public function __construct() {

        require_once(WORDPRESS_CONTENT_FILTER_PLUGIN_PATH . 'inc/admin/func.php');

        add_filter('manage_edit-zf-wcf_columns', array(&$this, 'content_filter_columns'), 10, 1);

        add_action('admin_init', array($this, 'admin_init'));

        add_action('add_meta_boxes', array($this, 'forms_add_custom_box'));
        add_action('save_post', array($this, 'forms_save_postdata'));

        add_action('admin_print_scripts', array($this, 'assets'), 100 );
        add_action('manage_zf-wcf_posts_custom_column', array($this, 'content_filter_column'), 10, 2);

        add_action( 'wp_ajax_wcf_field_settings_output', array($this, 'field_settings_output' ));
        add_action( 'wp_ajax_wcf_generate_meta_key_options', array($this, 'generate_meta_key_options' ));
        add_action( 'wp_ajax_wcf_generate_acf_options', array($this, 'generate_acf_options' ));
        add_action( 'wp_ajax_wcf_terms_color', array($this, 'terms_color' ));
        add_action( 'wp_ajax_wcf_select_terms', array($this, 'select_terms' ));

        add_action('admin_menu', array(&$this, 'admin_menu'));
        add_filter('post_row_actions', array(&$this, 'post_row_actions'), 50, 2);
        add_filter( 'upload_mimes', array($this, 'add_mime_types') );

    }

    function add_mime_types( $mime_types ) {

        $mime_types['wcf'] = 'application/octet-stream';

        return $mime_types;

    }

    /**
     * Adds meta boxes form search edit screens
     */
    function forms_add_custom_box() {
        add_meta_box(
            'wcf_forms_available_fields',
            __( 'Template Fields', WORDPRESS_CONTENT_FILTER_LANG),
            array($this, 'forms_available_custom_box'),
            'zf-wcf',
            'normal',
            'low'
        );
        add_meta_box(
            'wcf_forms_search_display',
            __( 'Search Form', WORDPRESS_CONTENT_FILTER_LANG),
            array($this, 'forms_search_custom_box'),
            'zf-wcf',
            'normal',
            'low'
        );

        add_meta_box(
            'wcf_forms_search_settings',
            __( 'Settings Form', WORDPRESS_CONTENT_FILTER_LANG),
            array($this, 'forms_settings_custom_box'),
            'zf-wcf',
            'side',
            'low'
        );
    }

    /**
     * Admin menu page
     */
    public function admin_menu() {
        add_submenu_page( 'edit.php?post_type=zf-wcf', __( 'Import', WORDPRESS_CONTENT_FILTER_LANG ), __( 'Import', WORDPRESS_CONTENT_FILTER_LANG ), 'manage_options', 'wcf-page-import', array( &$this, 'import_output' ) );
        add_submenu_page( 'edit.php?post_type=zf-wcf', __( 'Settings', WORDPRESS_CONTENT_FILTER_LANG ), __( 'Settings', WORDPRESS_CONTENT_FILTER_LANG ), 'manage_options', 'wcf-page-settings', array( &$this, 'admin_options' ) );
        register_setting('wcf_settings_fields', 'wcf_settings_options');
    }

    /**
     * admin init
     */

    function admin_init() {

        global $pagenow;
        if(isset($_GET['post']) && $pagenow == 'post.php') {
            $post_type = get_post_type($_GET['post']);
            if($post_type == 'zf-wcf' && $_GET['action'] == 'edit') {
                echo '<style>#edit-slug-box{display:none;}</style>';
            }
        }
        if (isset($_GET['wcf_action'])) {

            if ($_GET['wcf_action'] == 'export') {

                $form_id = $_GET['form_id'];
                $post = get_post($form_id);

                if ($post) {

                    // Generate export file contents
                    $data = array(
                        'title' => $post->post_title,
                        'fields' => wcf_get_form_search_values($form_id),
                        'settings' => wcf_get_form_search_settings($form_id),
                    );

                    $filename = 'form.wcf'; // append

                    // Generate export file contents
                    $file_contents = maybe_serialize($data);

                    $filesize = strlen( $file_contents );
                    @ob_start();

                    header( 'Content-Type: application/octet-stream' );
                    header( 'Content-Disposition: attachment; filename=' . $filename );
                    header( 'Expires: 0' );
                    header( 'Cache-Control: must-revalidate' );
                    header( 'Pragma: public' );
                    header( 'Content-Length: ' . $filesize );

                    // Clear buffering just in case
                    @ob_end_clean();
                    flush();

                    // Output file contents
                    echo $file_contents;

                    // Stop execution
                    exit;

                }
            } else if ($_GET['wcf_action'] == 'import') {

                // Check nonce for security since form was posted
                if ( ! empty( $_POST ) && ! empty( $_FILES['import_file'] ) && check_admin_referer( 'wcf_import', 'wcf_import_nonce' ) ) { // check_admin_referer prints fail page and dies

                    // Uploaded file
                    $uploaded_file = $_FILES['import_file'];

                    // This will also fire if no file uploaded
                    $wp_filetype = wp_check_filetype_and_ext( $uploaded_file['tmp_name'], $uploaded_file['name'], false );

                    if ( 'wcf' != $wp_filetype['ext'] && ! wp_match_mime_types( 'wcf', $wp_filetype['type'] ) ) {
                        wp_die(
                            __( 'You must upload a <b>.wcf</b> file generated by this plugin.', WORDPRESS_CONTENT_FILTER_LANG ),
                            '',
                            array( 'back_link' => true )
                        );
                    }

                    $overrides = array( 'test_form' => false );
                    $file_data = wp_handle_upload( $uploaded_file, $overrides );
                    if ( isset( $file_data['error'] ) ) {
                        wp_die(
                            $file_data['error'],
                            '',
                            array( 'back_link' => true )
                        );
                    }

                    // File exists?
                    if ( ! file_exists( $file_data['file'] ) ) {
                        wp_die(
                            __( 'Import file could not be found. Please try again.', WORDPRESS_CONTENT_FILTER_LANG ),
                            '',
                            array( 'back_link' => true )
                        );
                    }

                    // Get file contents and decode
                    $data = file_get_contents( $file_data['file'] );
                    $data = maybe_unserialize($data);

                    // Delete import file
                    unlink( $file_data['file'] );

                    $post_id = wp_insert_post( array(
                        'post_type' => 'zf-wcf',
                        'post_status' => 'publish',
                        'post_title' => esc_attr($data['title'])
                    ));

                    if ( $post_id ) {

                        $field_values = $data['fields'];
                        $form_settings = $data['settings'];

                        if (!empty($field_values)) {
                            update_post_meta( $post_id, '_wcf_form_search_field_values', $field_values );
                        }

                        if (!empty($form_settings)) {
                            update_post_meta( $post_id, '_wcf_form_search_settings', $form_settings );
                        }

                    }

                }

            }

        }
    }

    function post_row_actions($actions, $post) {

        global $post_type;
        if ($post_type == 'zf-wcf') {
            unset($actions['inline hide-if-no-js']);
            unset($actions['view']);
            $actions['wcf_export'] = '<a href="' . admin_url('edit.php?post_type=zf-wcf&wcf_action=export&form_id='. $post->ID). '" title="' . __('Export search form', WORDPRESS_CONTENT_FILTER_LANG) . '">' . __( 'Export' ,WORDPRESS_CONTENT_FILTER_LANG ) . '</a>';
        }
        return $actions;
    }

    /**
     * Function callback for admin page
     */
    public function admin_options() {
        require_once(dirname(__FILE__) . '/options.php');
    }
    /**
     * Function callback for admin page
     */
    public function import_output() {
        require_once(dirname(__FILE__) . '/import.php');
    }

    /**
     * Display Template Fields meta box
     * @param $post
     * @param $metabox
     */
    function forms_available_custom_box($post, $metabox) {

        // The actual fields for data entry
        do_action( 'wcf_forms_available_fields', $post->ID );
        ?>

    <?php
    }

    /**
     * Display all search form meta box
     * @param $post
     * @param $metabox
     */
    function forms_search_custom_box($post, $metabox) {

        // Use nonce for verification
        wp_nonce_field( 'wcf_form_search_nonce', 'wcf_form_search' );


        do_action( 'wcf_forms_search_fields', $post->ID );
        ?>

    <?php
    }

    /**
     * Display the settings of search form
     * @param $post
     * @param $metabox
     */
    function forms_settings_custom_box($post, $metabox) {

        $form_id = ! empty( $_REQUEST['post'] ) ? absint( $_REQUEST['post'] ) : 0;

        do_action( 'wcf_forms_settings', $form_id );
        ?>

    <?php
    }

    /**
     * get field settings
     */
    function field_settings_output() {

        check_ajax_referer( 'wcf_ajax', 'wcf_ajax_nonce' );

        $field_id = uniqid();
        $field_type = isset($_REQUEST['field_type']) ? $_REQUEST['field_type'] : '';
        echo '<input type="hidden" name="wcf-fields[]" value="'.$field_id.'::'.$field_type.'"/>';;
        echo '<input type="hidden" class="wcf-field-id" value="'.$field_id.'" />';
        echo $this->get_field_default_setting($field_id, $field_type);

        die();

    }

    /**
     *
     */
    function select_terms() {

        check_ajax_referer( 'wcf_ajax', 'wcf_ajax_nonce' );

        $taxonomy = isset($_REQUEST['taxonomy']) ? $_REQUEST['taxonomy'] : '';
        $select_type = isset($_REQUEST['select_type']) ? $_REQUEST['select_type'] : '';
        $output = '';

        if ($taxonomy != '') {

            $args = array(
                'show_count'  => 1,
                'hide_empty'  => 1,
                'echo'        => 0,
                'selected'    => 0,
                'name'        => 'wcf-taxonomy-select',
                'id'          => 'wcf-taxonomy-select',
                'class'       => '',
                'taxonomy'    => $taxonomy,
                'value_field' => 'slug',
            );

            if ($select_type == 'exclude') {
                $args['value_field'] = 'term_id';
            }

            $output .=  '<h3>'.__('Select taxonomy', WORDPRESS_CONTENT_FILTER_LANG).'</h3>';
            $dropdown =  wp_dropdown_categories( $args );

            if ($_REQUEST['is_single'] == 'false' || $select_type == 'exclude') {
                $output .= preg_replace( '/name=\''.$args['name'].'\'/i', 'name=\''.$args['name'].'\' multiple=\'multiple\'',$dropdown);
            } else {
                $output .= $dropdown;
            }

        }

        echo $output;
        die();

    }

    function terms_color() {

        check_ajax_referer( 'wcf_ajax', 'wcf_ajax_nonce' );

        $taxonomy = isset($_REQUEST['taxonomy']) ? $_REQUEST['taxonomy'] : '';
        $field_id = isset($_REQUEST['field_id']) ? $_REQUEST['field_id'] : '';
        $field_name = isset($_REQUEST['field_name']) ? $_REQUEST['field_name'] : '';

        $output = '';

        if ($taxonomy != '') {

            $args = array(
                'hide_empty' => 'no',
            );

            $terms = get_terms($taxonomy, $args);

            $options = array();
            if (!empty($terms)) {

                foreach ( $terms as $term ) {
                    $color = sprintf("#%06x",rand(0,16777215));
                    $options[$term->slug] = $color;
                }

                $field_args = array(
                    'type' => 'terms_color',
                    'wrapper' => 'no',
                    'name' => $field_name,
                    'value' => $options,
                );
                ob_start();
                wcf_forms_field($field_args);
                $output .= ob_get_clean();

            }


        }

        echo $output;
        die();

    }

    /**
     * Generate values for meta key
     */
    function generate_meta_key_options() {

        check_ajax_referer( 'wcf_ajax', 'wcf_ajax_nonce' );
        $meta_key = isset($_REQUEST['meta_key']) ? $_REQUEST['meta_key'] : '';
        $field_id = isset($_REQUEST['field_id']) ? $_REQUEST['field_id'] : '';
        $field_type = isset($_REQUEST['field_type']) ? $_REQUEST['field_type'] : '';

        $values = wcf_get_meta_values($meta_key);
        $options = array();
        if (!empty($values)) {
            foreach ( $values as $value ) {
                $options[] = $value->meta_value .'::'.$value->meta_value;
            }

            echo implode("\n", $options);
        }

        die();
    }

    /**
     * Generate values for meta key
     */
    function generate_acf_options() {

        check_ajax_referer( 'wcf_ajax', 'wcf_ajax_nonce' );
        $field_key = isset($_REQUEST['field_key']) ? $_REQUEST['field_key'] : '';
        $field_id = isset($_REQUEST['field_id']) ? $_REQUEST['field_id'] : '';
        $field_type = isset($_REQUEST['field_type']) ? $_REQUEST['field_type'] : '';

        if ($field_key != '') {
            $field = apply_filters('acf/load_field', false, $field_key );

            $options = array();
            if (!empty($field) && isset($field['choices'])) {
                foreach ( $field['choices'] as $value => $label ) {
                    $options[] = $value .'::'.$label;
                }
                echo implode("\n", $options);
            }
        }

        die();
    }

    /**
     * Get field settings for field type
     * @param $field_id
     * @param $field_type
     * @return string
     */
    function get_field_default_setting($field_id, $field_type) {

        $output = wcf_get_field_type_options($field_type, $field_id);
        return $output;

    }

    /**
     * When the post is saved, saves our custom data
     * @param $post_id
     * @return mixed
     */
    function forms_save_postdata( $post_id ) {

        if(isset($_POST['wcf_form_search'])){
            global $wcf_register_fields;
            // verify if this is an auto save routine.
            // If it is our form has not been submitted, so we dont want to do anything
            if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE )
                return $post_id;

            // verify this came from the our screen and with proper authorization,
            // because save_post can be triggered at other times

            if ( !wp_verify_nonce( $_POST['wcf_form_search'], 'wcf_form_search_nonce' ) )
                return $post_id;

            // Check permissions
            if ( !current_user_can( 'edit_post', $post_id ) )
                return $post_id;


            $fields = isset($_REQUEST['wcf-fields']) ? $_REQUEST['wcf-fields'] : array();
            $collect_fields_data = array();

            if (!empty($fields)) {
                foreach ( $fields as $field ) {
                    $field_data = explode('::', $field);
                    $field_id = $field_data[0];
                    $field_type = $field_data[1];

                    $options = isset($wcf_register_fields[$field_type]['options']) ? $wcf_register_fields[$field_type]['options'] : array();
                    $admin_options = isset($options['admin_options']) ? $options['admin_options'] : array();

                    $field_values = array();
                    foreach ( $admin_options as $opt ) {
                        $field_name = 'wcf_forms_field_' .$opt['name'] .'_'.$field_id;
                        $field_value = isset( $_REQUEST[$field_name] ) ? $_REQUEST[$field_name] : '';
                        if ($opt['name'] == 'field' && $field_type == 'acf') {
                            $acf_field = apply_filters('acf/load_field', false, $field_value );
                            $field_values['meta_key'] = $acf_field['name'];
                        }

                        if (is_array($field_value)) {
                            $field_value = maybe_serialize($field_value);
                        }
                        if ($opt['type'] == 'textarea') {
                            $field_values[$opt['name']] = esc_textarea( $field_value );
                        } else {
                            $field_values[$opt['name']] =  $field_value ;
                        }

                        $field_values['field_type'] = $field_type;
                    }

                    $collect_fields_data[$field] = $field_values;

                }
            }

            update_post_meta( $post_id, '_wcf_form_search_field_values', $collect_fields_data );

//            $to = WORDPRESS_CONTENT_FILTER_PLUGIN_PATH . 'inc/admin/field_values.json';
//            $data = json_encode($collect_fields_data);
//            file_put_contents( $to, $data);

            // form search settings
            $form_search_settings = isset($_REQUEST['wcf-settings']) ? $_REQUEST['wcf-settings'] : array();

            update_post_meta( $post_id, '_wcf_form_search_settings', $form_search_settings );

//            $to = WORDPRESS_CONTENT_FILTER_PLUGIN_PATH . 'inc/admin/form_settings.json';
//            $data = json_encode($form_search_settings);
//            file_put_contents( $to, $data);

        }
    }

    public function assets() {
        global $post_type, $pagenow;
        $pt = isset($_GET['post_type']) ? $_GET['post_type'] : '';
        if( 'zf-wcf' == $post_type || $pt == 'zf-wcf') {
            add_thickbox();
            wp_enqueue_media();
            wp_enqueue_style('wp-color-picker');
            wp_enqueue_script('wp-color-picker');

            wp_enqueue_style('wcf-admin-style', WORDPRESS_CONTENT_FILTER_PLUGIN_URL . 'inc/admin/assets/css/style.css', array(), false, 'all');
            wp_enqueue_script('wcf-admin-js', WORDPRESS_CONTENT_FILTER_PLUGIN_URL . 'inc/admin/assets/js/admin.js', array('jquery-ui-core', 'jquery-ui-sortable', 'jquery-ui-datepicker', 'jquery-ui-draggable', 'jquery-ui-droppable'), null, true);
            $form_id = isset ( $_REQUEST['post'] ) ? $_REQUEST['post'] : '';
            wp_localize_script( 'wcf-admin-js', 'wcf_forms_variables', array(
                'form_id' => $form_id,
                'wcf_ajax_nonce' => wp_create_nonce( 'wcf_ajax'),
                'input_query_exist' => __('A form search only should have one Input Query', WORDPRESS_CONTENT_FILTER_LANG),
                'submit_button_exist' => __('A form search only should have one Submit Button', WORDPRESS_CONTENT_FILTER_LANG),
                'rating_exist' => __('A form search only should have one Rating', WORDPRESS_CONTENT_FILTER_LANG),
                'select_terms' => __('Select Terms', WORDPRESS_CONTENT_FILTER_LANG),
                'please_select_taxonomy' => __('Pleas select a taxonomy', WORDPRESS_CONTENT_FILTER_LANG),
                'at_least_one_post_type' => __('Need to have at least one post type to search', WORDPRESS_CONTENT_FILTER_LANG),
            ) );
        }
    }

    /**
     * Customize the profiles management columns
     * @param $columns
     * @return new $columns array
     */
    public function content_filter_columns($columns)
    {

        $columns = array(
            'cb' => '<input type="checkbox" />',
            'title' => __('Title', WORDPRESS_CONTENT_FILTER_LANG),
            'form_shortcode' => __('Form Shortcode', WORDPRESS_CONTENT_FILTER_LANG),
            'result_shortcode' => __('Result Shortcode', WORDPRESS_CONTENT_FILTER_LANG),
            'author' => __('Author', WORDPRESS_CONTENT_FILTER_LANG),
            'date' => __( 'Date' )
        );
        return $columns;
    }

    /**
     * Display custom column
     * @param $column
     * @param $post_id
     * return void
     */
    public function content_filter_column($column, $post_id)
    {
        
        switch ($column) {
            case 'form_shortcode':

                $shortcode = '[wcf_form id="'.$post_id.'" title=""]';
                echo $shortcode;

                break;
            case 'result_shortcode':

                $shortcode = '[wcf_result id="'.$post_id.'"]';
                echo htmlentities($shortcode);

                break;
        }

    }

}

new Wordpress_Content_Filter_Admin();
