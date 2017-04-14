<?php
/**
 * The template for displaying our services page.
 *
 * Template Name: Category page
 *
 */

get_header(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<?php
if ( function_exists('yoast_breadcrumb') ) {
yoast_breadcrumb('
<p id="breadcrumbs">','</p>
');
}
?>

<ul id="sidebar">
	<?php dynamic_sidebar('Primary Sidebar' ); ?>
</ul>





</body>
</html>
<?php get_footer(); ?>