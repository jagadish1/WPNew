<?php
/**
 * The template for displaying our services page.
 *
 * Template Name: Resources
 *
 */

get_header(); ?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Resources</title>

</head>

<body>


<div>
Free Immigration Resources
</div>

<?php	
	echo do_shortcode( '[searchandfilter taxonomies="category,post_tag"]' ); 
?>


 <h1>Articles</h1>
<?php

	$vals = array( 'post_type' => 'post', 'category' => 'articles');
	$query = new WP_Query( $vals );
	while ( $query->have_posts() ) : $query->the_post();
		the_post_thumbnail();
	endwhile;
?>

<h1>PPT</h1>
<?php
	$vals = array( 'post_type' => 'post'  ,'category' => 'ppt' );
	$query = new WP_Query( $vals );
	while ( $query->have_posts() ) : $query->the_post();
		the_post_thumbnail();
	endwhile;
?>

<h1>VIDEOS</h1>
<?php

	$vals = array( 'post_type' => 'post' ,'category' => 'videos');
	$query = new WP_Query( $vals );
	while ( $query->have_posts() ) : $query->the_post();
		the_post_thumbnail();
	endwhile;
?>
>
<h1>Ebook</h1>
<?php

	$vals = array( 'post_type' => 'post' ,'category' => 'ebook');
	$query = new WP_Query( $vals );
	while ( $query->have_posts() ) : $query->the_post();
		the_post_thumbnail();
	endwhile;
?>

</div>
</body>
</html>
<?php get_footer(); ?>
