<?php
/**
 * Plugin Name: Add a Yoast Breadcrumb
 * Plugin URI: http://www.digitalcontact.co.il
 * Description: This plugin gives you an option to append a link after the first breadcrumb (Home)
 *              and prepend a breadcrumb prior to the last breadcrumb (current page) - per page.
 * Version: 1.1.0
 * Author: Allon Sacks
 * Author URI: http://www.digitalcontact.co.il
 * License: GPL2
 */
defined( 'ABSPATH' ) or die( 'Time for a U turn!' );

add_action('add_meta_boxes', 'dc_prepend_page_metaboxes', 10, 2);
add_action('save_post', 'dc_prepend_save_display_metabox');

function dc_prepend_page_metaboxes() {
    $post_types = array();
    foreach ( get_post_types( '', 'names' ) as $post_type ) {
        $post_types[] = $post_type;
    }
    foreach($post_types as $type) add_meta_box('prepend-breadcrumb', 'Add a breadcrumb', 'dc_prepend_draw_display_metabox', $type, 'side', 'default');
}

function dc_prepend_draw_display_metabox($post) {
    global $post;
    $data = get_post_custom($post->ID);
    $breadcrumb_after_home_title = isset($data['breadcrumb_after_home_title']) ? esc_attr($data['breadcrumb_after_home_title'][0]) : '';
    $breadcrumb_after_home_link = isset($data['breadcrumb_after_home_link']) ? esc_attr($data['breadcrumb_after_home_link'][0]) : '';
    $breadcrumb_title = isset($data['breadcrumb_title']) ? esc_attr($data['breadcrumb_title'][0]) : '';
    $breadcrumb_link = isset($data['breadcrumb_link']) ? esc_attr($data['breadcrumb_link'][0]) : '';

    wp_nonce_field('dc_prepend_display_metabox_nonce', 'display_metabox_nonce');
    ?>
    <p>Add a breadcrumb after the homepage</p>
    <p><label for="breadcrumb_title"><?php esc_attr_e('Title of after home breadcrumb', 'dc_prepend'); ?></label> <input type="text" name="breadcrumb_after_home_title" id="breadcrumb_after_home_title" placeholder="Breadcrumb Title" value="<?php echo $breadcrumb_after_home_title?>"></p>
    <p><label for="breadcrumb_link"><?php esc_attr_e('Link of after home breadcrumb', 'dc_prepend'); ?></label> <input name="breadcrumb_after_home_link" id="breadcrumb_after_home_link" placeholder="Breadcrumb Link" value="<?php echo $breadcrumb_after_home_link?>"></p>

    <p>Add a breadcrumb prior to the current page</p>
    <p><label for="breadcrumb_title"><?php esc_attr_e('Title of prepended breadcrumb', 'dc_prepend'); ?></label> <input type="text" name="breadcrumb_title" id="breadcrumb_title" placeholder="Breadcrumb Title" value="<?php echo $breadcrumb_title?>"></p>
    <p><label for="breadcrumb_link"><?php esc_attr_e('Link of prepended breadcrumb', 'dc_prepend'); ?></label> <input name="breadcrumb_link" id="breadcrumb_link" placeholder="Breadcrumb Link" value="<?php echo $breadcrumb_link?>"></p>

<?php

}

function dc_prepend_save_display_metabox($page_id) {
    if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if(!isset($_POST['display_metabox_nonce']) || !wp_verify_nonce($_POST['display_metabox_nonce'], 'dc_prepend_display_metabox_nonce' )) return;
    if(!current_user_can('edit_pages', $page_id)) return;

    if(isset($_POST['breadcrumb_after_home_title'])) {
        update_post_meta($page_id, 'breadcrumb_after_home_title', strip_tags($_POST['breadcrumb_after_home_title']));
    }
    if(isset($_POST['breadcrumb_after_home_link'])) {
        update_post_meta($page_id, 'breadcrumb_after_home_link', strip_tags($_POST['breadcrumb_after_home_link']));
    }
    if(isset($_POST['breadcrumb_title'])) {
        update_post_meta($page_id, 'breadcrumb_title', strip_tags($_POST['breadcrumb_title']));
    }
    if(isset($_POST['breadcrumb_link'])) {
        update_post_meta($page_id, 'breadcrumb_link', strip_tags($_POST['breadcrumb_link']));
    }
}


function dc_prepend_after_yoast_loads() {
    if ( function_exists('yoast_breadcrumb') ){
        add_filter( 'wpseo_breadcrumb_links', 'dc_append_yoast_breadcrumb_trail' );
        add_filter( 'wpseo_breadcrumb_links', 'dc_prepend_yoast_breadcrumb_trail' );
    }
}
add_action( 'wp', 'dc_prepend_after_yoast_loads' );


function dc_append_yoast_breadcrumb_trail( $links ) {
    global $post;
    $data = get_post_custom($post->ID);
    $breadcrumb_after_home_title = isset($data['breadcrumb_after_home_title']) ? esc_attr($data['breadcrumb_after_home_title'][0]) : '';
    $breadcrumb_after_home_link = isset($data['breadcrumb_after_home_link']) ? esc_attr($data['breadcrumb_after_home_link'][0]) : '';
    $breadcrumb_title = isset($data['breadcrumb_title']) ? esc_attr($data['breadcrumb_title'][0]) : '';
    $breadcrumb_link = isset($data['breadcrumb_link']) ? esc_attr($data['breadcrumb_link'][0]) : '';

    if ( $breadcrumb_after_home_title != '' && $breadcrumb_after_home_link != '') {
        $breadcrumb[] = array(
            'url' => $breadcrumb_after_home_link,
            'text' => $breadcrumb_after_home_title,
        );

        array_splice( $links, 1, 0, $breadcrumb ); // After Home

    }



    return $links;
}

function dc_prepend_yoast_breadcrumb_trail( $links ) {
    global $post;
    $data = get_post_custom($post->ID);
    $breadcrumb_after_home_title = isset($data['breadcrumb_after_home_title']) ? esc_attr($data['breadcrumb_after_home_title'][0]) : '';
    $breadcrumb_after_home_link = isset($data['breadcrumb_after_home_link']) ? esc_attr($data['breadcrumb_after_home_link'][0]) : '';
    $breadcrumb_title = isset($data['breadcrumb_title']) ? esc_attr($data['breadcrumb_title'][0]) : '';
    $breadcrumb_link = isset($data['breadcrumb_link']) ? esc_attr($data['breadcrumb_link'][0]) : '';

    if ( $breadcrumb_title != '' && $breadcrumb_link != '') {
        $breadcrumb[] = array(
            'url' => $breadcrumb_link,
            'text' => $breadcrumb_title,
        );

        array_splice( $links, -1, -2, $breadcrumb ); // Prior to current page

    }

    return $links;
}
