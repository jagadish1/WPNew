<?php
/*
Plugin Name: WordPress Content Filter
Plugin URI: http://zufusion.com/items/wordpress-content-filter
Description: WordPress Content Filter lets you filter by rating, attribute, custom fields, taxonomies, meta fields, authors, dates, post types, sort and more.
Version: 1.1
Author: ZuFusion
Author URI: http://zufusion.com
*/

// define
define('WORDPRESS_CONTENT_FILTER_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('WORDPRESS_CONTENT_FILTER_PLUGIN_URL', plugin_dir_url( __FILE__ ));
define('WORDPRESS_CONTENT_FILTER_PLUGIN_FILE', plugin_dir_path(__FILE__) . 'wordpress-content-filter.php');
define('WORDPRESS_CONTENT_FILTER_THEME_PATH', get_template_directory() . '/');
define('WORDPRESS_CONTENT_FILTER_THEME_URL', get_template_directory_uri() . '/');
define('WORDPRESS_CONTENT_FILTER_LANG',  'wordpress-content-filter');
// Require Core
require_once(WORDPRESS_CONTENT_FILTER_PLUGIN_PATH . 'inc/core.php');
$instance = Wordpress_Content_Filter::get_instance();

