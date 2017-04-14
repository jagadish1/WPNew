<?php
/* Plugin Name: Parameter
Plugin URI: http://webopius.com/
Description: A plugin to allow parameters to be passed in the URL and recognized by WordPress
Author: Adam Boyse
Version: 1.0
Author URI: http://www.webopius.com/
*/
add_filter('query_vars', 'parameter_queryvars' );
function parameter_queryvars( $qvars )
{
$qvars[] = 'myvar';
return $qvars;
}
?>