<?php
/**
 * @version    $Id$
 * @package    WordPress Content Filter
 * @author     ZuFusion
 * @copyright  Copyright (C) 2015 ZuFusion All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 */


if (!class_exists('Wordpress_Content_Filter')) {


    /**
     * Class Wordpress_Content_Filter base
     */
    class Wordpress_Content_Filter
    {

        protected static $instance = null;

        const post_type = 'zf-wcf';

        private $wcf_query = null;

        public $options = null;

        public function __construct() {

            add_action('plugins_loaded', array( &$this, 'load_textdomain' ) );

            add_action('init', array(&$this, 'init'));
            add_action('widgets_init', array(&$this, 'register_widgets'));
            add_action('wp_enqueue_scripts', array(&$this, 'load_assets'), 100);
            add_action('wp_head', array( $this, 'custom_style' ), 700 );
            add_shortcode('wcf_form', array($this, 'form_shortcode'));
            add_shortcode('wcf_result', array($this, 'result_shortcode'));
            add_filter('widget_text', 'do_shortcode');

            $this->includes();

            $this->wcf_query = new Wordpress_Content_Filter_Query();
            $this->options = wcf_get_options();
            // actions
            add_action('wcf_form_search_after', array(&$this, 'form_search_after'), 10, 2);

            // filters
            add_filter('template_include', array($this, 'template_chooser'));

            /* Install and default settings */
            add_action( 'activate_' . plugin_basename(WORDPRESS_CONTENT_FILTER_PLUGIN_FILE),  array($this, 'install' ));

        }

        public function includes() {

            // require
            require_once(WORDPRESS_CONTENT_FILTER_PLUGIN_PATH . "inc/functions.php");
            // require query class
            require_once( WORDPRESS_CONTENT_FILTER_PLUGIN_PATH . "inc/query.php" );
            // require fields
            require_once( WORDPRESS_CONTENT_FILTER_PLUGIN_PATH . "inc/fields/input-query.php" );
            require_once( WORDPRESS_CONTENT_FILTER_PLUGIN_PATH . "inc/fields/meta-field.php" );
            require_once( WORDPRESS_CONTENT_FILTER_PLUGIN_PATH . "inc/fields/heading.php" );
            require_once( WORDPRESS_CONTENT_FILTER_PLUGIN_PATH . "inc/fields/taxonomy.php" );
            require_once( WORDPRESS_CONTENT_FILTER_PLUGIN_PATH . "inc/fields/submit-button.php" );
            require_once( WORDPRESS_CONTENT_FILTER_PLUGIN_PATH . "inc/fields/author.php" );
            require_once( WORDPRESS_CONTENT_FILTER_PLUGIN_PATH . "inc/fields/sort.php" );
            require_once( WORDPRESS_CONTENT_FILTER_PLUGIN_PATH . "inc/fields/separator.php" );
            require_once( WORDPRESS_CONTENT_FILTER_PLUGIN_PATH . "inc/fields/date.php" );
            require_once( WORDPRESS_CONTENT_FILTER_PLUGIN_PATH . "inc/fields/range-slider.php" );
            require_once( WORDPRESS_CONTENT_FILTER_PLUGIN_PATH . "inc/fields/price.php" );
            require_once( WORDPRESS_CONTENT_FILTER_PLUGIN_PATH . "inc/fields/rating.php" );
            require_once( WORDPRESS_CONTENT_FILTER_PLUGIN_PATH . "inc/fields/text.php" );
            require_once( WORDPRESS_CONTENT_FILTER_PLUGIN_PATH . "inc/fields/acf.php" );

        }

        /**
         * Return an instance of this class.
         */
        public static function get_instance() {

            if (null == self::$instance) {
                self::$instance = new self;
            }

            return self::$instance;
        }

        /**
         * Init
         */
        public function init() {

            register_post_type( self::post_type, array(
                'labels'              => array(
                    'name'          => __( 'Search Forms', WORDPRESS_CONTENT_FILTER_LANG ),
                    'singular_name' => __( 'Search Form', WORDPRESS_CONTENT_FILTER_LANG ),
                    'add_new'            => __('Add New', WORDPRESS_CONTENT_FILTER_LANG),
                    'add_new_item'       => __('Add New Search Form', WORDPRESS_CONTENT_FILTER_LANG),
                    'edit_item'          => __('Edit Search Form', WORDPRESS_CONTENT_FILTER_LANG),
                    'new_item'           => __('Add New Search Form', WORDPRESS_CONTENT_FILTER_LANG),
                    'all_items'          => __('All Search Forms', WORDPRESS_CONTENT_FILTER_LANG),
                    'view_item'          => __('View Search Form', WORDPRESS_CONTENT_FILTER_LANG),
                    'search_items'       => __('Search Forms Search', WORDPRESS_CONTENT_FILTER_LANG),
                    'not_found'          => __('No Search Forms Found', WORDPRESS_CONTENT_FILTER_LANG),
                    'not_found_in_trash' => __('No Search Forms found in trash', WORDPRESS_CONTENT_FILTER_LANG),
                    'menu_name'          => __('WordPress Content Filter', WORDPRESS_CONTENT_FILTER_LANG)
                ),
                'public'              => true,
                'menu_icon'           => 'dashicons-feedback',
                'exclude_from_search' => true,
                'publicly_queryable'  => true,
                'has_archive' => false,  // it shouldn't have archive page
                'rewrite'             => false,
                'query_var'           => false,
                'supports'            => array('title'),
            ));

            if (is_admin()) {

                require_once ('admin/main.php');

                add_action( 'do_meta_boxes', array( $this, 'remove_revolution_slider_meta_boxes' ) );
            }
        }

        /**
         * Load Localisation files.
         */
        public function load_textdomain() {

            $domain = WORDPRESS_CONTENT_FILTER_LANG;
            $locale = apply_filters( 'wordpress_content_filter_plugin_locale', get_locale(), $domain );

            if ( $loaded = load_textdomain( 'wordpress-content-filter', trailingslashit( WP_LANG_DIR ) . $domain . '/' . $domain . '-' . $locale . '.mo' ) ) {
                return $loaded;
            } else {
                load_plugin_textdomain( 'wordpress-content-filter', FALSE, basename(WORDPRESS_CONTENT_FILTER_PLUGIN_PATH) . '/languages/' );
            }

        }


        /**
         * load assets for plugins
         */
        public function load_assets()
        {

            global $wp_scripts;
            // get registered script object for jquery-ui
            $ui = $wp_scripts->query('jquery-ui-core');

            wp_enqueue_style('zf-jquery-ui-smoothness', '//code.jquery.com/ui/'.$ui->ver.'/themes/smoothness/jquery-ui.min.css', false, 'all');
            wp_enqueue_style('wordpress-content-filter-style', WORDPRESS_CONTENT_FILTER_PLUGIN_URL . 'assets/css/style.css', array('dashicons'), false, 'all');

            if ($this->options['color_scheme'] != '') {

                if (file_exists(WORDPRESS_CONTENT_FILTER_PLUGIN_PATH . 'assets/css/colors/'.$this->options['color_scheme'].'.css')) {
                    $color_url = apply_filters('wcf_color_url', WORDPRESS_CONTENT_FILTER_PLUGIN_URL . 'assets/css/colors/'.$this->options['color_scheme'].'.css');
                } else {
                    $color_url = apply_filters('wcf_color_url', WORDPRESS_CONTENT_FILTER_THEME_URL . 'wordpress-content-filter/colors/'.$this->options['color_scheme'].'.css');
                }

                wp_enqueue_style('wordpress-content-filter-color', $color_url, array(), false, 'all');
            }

            wp_enqueue_script('wordpress-content-filter', WORDPRESS_CONTENT_FILTER_PLUGIN_URL . 'assets/js/wordpress-content-filter.min.js', array('jquery', 'jquery-ui-core', 'jquery-ui-datepicker', 'jquery-ui-slider'), null, true);
            wp_localize_script( 'wordpress-content-filter', 'wcf_variables', array(
                'wcf_ajax_nonce' => wp_create_nonce( 'wcf_ajax'),
                'ajax_url' => admin_url( 'admin-ajax.php' ),
                'scroll_top' => $this->options['scroll_top'],
                'ajax_loader' => $this->options['ajax_loader'],
            ) );
        }

        function custom_style() {

            $custom_css = $this->options['custom_css'];
            if ($custom_css != '') {
                ?>
                <style type="text/css"><?php echo $custom_css;?></style>
            <?php
            }
        }
        /**
         * register widgets function.
         *
         * @access public
         * @return void
         */
        function register_widgets() {

            include_once('widget.php');

            register_widget('Wordpress_Content_Filter_Widget');
        }

        /**
         * Display a form search
         * @param $atts
         * @return string
         */
        public function form_shortcode($atts){

            extract(shortcode_atts(array(
                'id' => false,
                'title' => '',
            ), $atts));

            if ($id) {

                $fields = wcf_get_form_search_values($id);
                $settings = wcf_get_form_search_settings($id);

                ob_start();
                include wcf_get_template('wcf-form-search', false, false);
                $output = ob_get_clean();
                return $output;
            } else {
                echo __('The form ID doesn\'t existing', WORDPRESS_CONTENT_FILTER_LANG) ;
            }
        }

        /**
         * Display a template results
         * @param $atts
         * @return string
         */
        public function result_shortcode($atts) {

            extract(shortcode_atts(array(
                'id' => false,
            ), $atts));

            if ($id) {
                $output = '';
                $fields = wcf_get_form_search_values($id);
                $settings = wcf_get_form_search_settings($id);
                $columns = $settings['columns_per_row'] != '' ? $settings['columns_per_row'] : 3;
                $template_loop = 'wcf-loop';
                if ($settings['search_type'] == 'single') {

                    if (!post_type_exists($settings['post_type'][0])) {
                        return __('The post type: ' . $settings['post_type'] .' doesn\'t existing', WORDPRESS_CONTENT_FILTER_LANG);
                    }

                    $template_loop = $template_loop . '-' . $settings['post_type'][0];
                }

                $columns = apply_filters('wcf_result_columns', $columns, $id, $fields, $settings);
                $template_loop = apply_filters('wcf_result_loop_template', $template_loop, $id, $fields, $settings);

                $loop = wcf_get_template($template_loop, false, false);

                if ($settings['search_type'] == 'single' && $loop == '') {
                    $loop = wcf_get_template('wcf-loop', false, false);
                }

                $output .= '<div id="wcf-form-wrapper-' . $id .'" class="wcf-form-wrapper" data-ajax="'.$settings['display_results'].'"'
                 . ' data-form="'.$id.'" data-loop="'.$template_loop.'" data-columns="'.$columns.'">';

                if (is_archive() || is_search()) {
                    // display on archive, search template
                    ob_start();
                    //
                    if ($loop != '') {
                        include $loop;
                        wcf_pagination();
                    }
                    $output .= ob_get_clean();

                } else {
                    // display posts as archive
                    $args = array(
                        'post_status' => 'publish',
                    );

                    $args = wp_parse_args($this->wcf_query->process_vars($id, $_GET), $args);

                    query_posts($args);
                    ob_start();
                    //
                    if ($loop != '') {
                        include $loop;
                        wcf_pagination();
                    }
                    $output .= ob_get_clean();
                    wp_reset_query();

                }

                $output .= '</div>';
                return $output;
            } else {
                echo __('The form ID doesn\'t existing', WORDPRESS_CONTENT_FILTER_LANG) ;
            }

        }
        /**
         * Display hidden fields for search form
         * @param int   $form_id
         * @param array $attrs
         * @param array $settings
         */
        public function form_search_after($form_id = 0, $settings = array()) {

            $post_types = isset($settings['post_type']) ? $settings['post_type'] : array();
            $post_types = implode(',', $post_types);
            ?>
            <input type="hidden" name="form_id" value="<?php echo $form_id;?>"/>
            <input type="hidden" name="post_types" value="<?php echo $post_types;?>"/>
            <?php if ($settings['per_page'] != '') { ?>
                <input type="hidden" name="posts_per_page" value="<?php echo $settings['per_page'];?>"/>
            <?php
            }
        }

        /**
         * Set template type
         * @param $template
         * @return mixed
         */
        function template_chooser($template) {
            global $wp_query;

            if( $wp_query->is_search() ) {
                if (isset($_GET['form_id'])) {
                    $form_id = $_GET['form_id'] ;
                    $settings = wcf_get_form_search_settings($form_id);
                    if ($settings['custom_template'] != '') {
                        return locate_template( $settings['custom_template'], false );
                    }
                }
            }

            return $template;
        }

        function remove_revolution_slider_meta_boxes() {
            remove_meta_box( 'mymetabox_revslider_0', self::post_type, 'normal' );
        }

        function install() {

            if ( get_posts( array(
                'post_type' => self::post_type
            ))) {
                return;
            } else {

                $post_id = wp_insert_post( array(
                    'post_type' => self::post_type,
                    'post_status' => 'publish',
                    'post_title' => __('Form Search')
                 ));


                if ( $post_id ) {

                    $field_values = $this->parse_data('field_values.json');
                    $form_settings = $this->parse_data('form_settings.json');

                    if (!empty($field_values)) {
                        update_post_meta( $post_id, '_wcf_form_search_field_values', $field_values );
                    }

                    if (!empty($form_settings)) {
                        update_post_meta( $post_id, '_wcf_form_search_settings', $form_settings );
                    }

                }

            }

        }

        /**
         * parse json file to array
         * @param $file_name
         */

        function parse_data($file_name) {
            $file = WORDPRESS_CONTENT_FILTER_PLUGIN_PATH . 'inc/admin/' . $file_name;
            if (file_exists($file)) {
                return json_decode(file_get_contents($file), true);
            } else {
                return false;
            }
        }

    }
}