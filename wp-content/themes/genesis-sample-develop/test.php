<?php
/**
 * The template for displaying our services page.
 *
 * Template Name: our services
 *
 */

get_header(); ?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Our Services</title>
<style>
.mainblogclass {
    float: left;
    width: 100%;
    max-width: 93%;
    margin-bottom: 3%;
    margin-top: 2%;
}
.showthumbnailimage img {
    float: left;
    margin-left: 4%;
}
.tittleforblogs {
    font-size: 30px;
    text-align: center;
    font-weight: 600;
}
.main_wapperclass {
    width: 100%;
    margin: 0 auto;
    max-width: 70%;
}

.showdate {
    float: left;
    font-size: 16px;
    width: 10%;
    text-align: center;
    right: 4%;
    color: #707070;
    background: #f6f6f6;
    border-top: 2px solid#cd0a0a;
}
.showcontent {
    float: left;
    width: 77%;
    margin-left: 5%;
    /* margin-bottom: 5%; */
    background: #f15b5a;
    padding: 1% 4%;
    color: #fff;
    /* text-align: center; */
    font-size: 18px;
}
.displaytitle {
    float: right;
    width: 81%;
    font-size: 22px;
    /* margin-left: 2%; */
}

.showcontent1 {
    float: right;
    width: 87%;
    font-size: 18px;
    text-align: justify;
    padding-right: 8%;
}
.readmore {
    float: right;
    width: 100%;
    max-width: 87%;
    margin-top: 0px;
}
.readmore a {
    float: left;
    font-size: 18px;
    background: #2ba3e1;
    padding: 5px;
    border-radius: 4px;
    text-decoration: none;
    color: #fff;
}
</style>
</head>

<body>
<div class="main_wapperclass">
<div class="breadcrub">
<?php
if ( function_exists('yoast_breadcrumb') ) {
yoast_breadcrumb('
<p id="breadcrumbs">','</p>
');
}
?>
</div>

<div class="tittleforblogs">
Free Immigration Resources
</div>

<?php
 echo do_shortcode( '[searchandfilter taxonomies="category,post_tag"]' ); 
$args = array( 'post_type' => 'articles', 'posts_per_page' => 3 );
$loop = new WP_Query( $args );
while ( $loop->have_posts() ) : $loop->the_post();
endwhile;
?>

</div>
<div class="mainblogclass">
 <h3>Articles</h3>
<?php

$args = array( 'post_type' => 'post', 'posts_per_page' => 3 );
$loop = new WP_Query( $args );
while ( $loop->have_posts() ) : $loop->the_post();
the_post_thumbnail();
endwhile;
?>
</div>

<div class="mainblogclass">
<h3>PPT</h3>
<?php
$args = array( 'post_type' => 'ppt', 'posts_per_page' => 3 );
$loop = new WP_Query( $args );
while ( $loop->have_posts() ) : $loop->the_post();
the_post_thumbnail();
endwhile;
?>
</div>
<div class="mainblogclass">
<h3>VIDEOS</h3>
<?php

$args = array( 'post_type' => 'Videos', 'posts_per_page' => 1 );
$loop = new WP_Query( $args );
while ( $loop->have_posts() ) : $loop->the_post();
the_post_thumbnail();
endwhile;
?>
</div>
<div class="mainblogclass">
<h3>Ebook</h3>
<?php

$args = array( 'post_type' => 'Ebook', 'posts_per_page' =>4 );
$loop = new WP_Query( $args );
while ( $loop->have_posts() ) : $loop->the_post();
the_post_thumbnail();
endwhile;
?>
</div>
</div>
</body>
</html>
<?php get_footer(); ?>
