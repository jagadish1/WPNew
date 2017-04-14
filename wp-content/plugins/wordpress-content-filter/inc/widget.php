<?php

/**
 * @version    $Id$
 * @package    WordPress Content Filter
 * @author     ZuFusion
 * @copyright  Copyright (C) 2015 ZuFusion All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 */

class Wordpress_Content_Filter_Widget extends WP_Widget
{

    function __construct()
    {
        $widget_ops = array(
            'description' => __('Display a Form Search from the form management', WORDPRESS_CONTENT_FILTER_LANG),
            'name'        => __('WordPress Content Filter', WORDPRESS_CONTENT_FILTER_LANG)
        );
        parent::__construct('wcf_widget', __('WordPress Content Filter', WORDPRESS_CONTENT_FILTER_LANG), $widget_ops);
    }

    public function form($instance)
    {
        $instance = wp_parse_args($instance,
            array(
                'id'           => '',
                'title'           => '',
            )
        );

        $title  = esc_attr($instance['title']);

        $forms = get_posts( array(
            'post_type' => 'zf-wcf'
        ));

        $forms_options = array();
        if (!empty($forms)) {
            foreach ( $forms as $form ) {
                $forms_options[$form->ID] = $form->post_title;
            }
        }
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', WORDPRESS_CONTENT_FILTER_LANG);?> : </label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>"
                   name="<?php echo $this->get_field_name('title'); ?>" type="text"
                   value="<?php echo esc_attr($title); ?>"/>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('id'); ?>"><?php _e('Form', WORDPRESS_CONTENT_FILTER_LANG);?>:</label>

            <select name="<?php echo $this->get_field_name('id'); ?>"
                     id="<?php echo $this->get_field_id('id'); ?>" class="widefat">
                <?php
                if (!empty($forms_options)) {

                    foreach ($forms_options as $form_id => $form_title) {
                        ?>
                        <option
                            value="<?php echo $form_id; ?>"<?php selected($instance['id'], $form_id); ?>><?php echo $form_title; ?></option>
                    <?php
                    }
                }
                ?>
            </select>

            <br/>
            <small><?php _e('Select a form search.', WORDPRESS_CONTENT_FILTER_LANG); ?></small>
        </p>

    <?php

    }

    function update($new_instance, $old_instance)
    {

        $instance          = $old_instance;
        $instance['title'] = strip_tags( $new_instance['title'] );
        $instance['id']    = strip_tags( $new_instance['id'] );

        return $instance;
    }

    public function widget($args, $instance) {

        extract($args, EXTR_SKIP);
        $id = $instance['id'];

        echo $before_widget;

        $widget_title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
        if (!empty($widget_title)) {
            echo $before_title . $widget_title . $after_title;
        }

        if ($id) {
            $fields = wcf_get_form_search_values($id);
            $settings = wcf_get_form_search_settings($id);

            ob_start();
            include wcf_get_template('wcf-form-search', false, false);
            $output = ob_get_clean();
            echo $output;
        } else {
            echo __('The form ID doesn\'t existing', WORDPRESS_CONTENT_FILTER_LANG) ;
        }

        echo $after_widget;
    }


}