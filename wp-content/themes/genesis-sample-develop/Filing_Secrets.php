<?php


//* Template Name: Filing Secrets

 get_header(); ?>
 <style>
 .post_blog {
    width: 262px;
    float: left;
    margin-right: 25px;
}
 .post_blog:last-child{ margin-right: 0px;}
 .displaytitle_blog {
    font-size: 16px;
    font-weight: bold;
    text-align: center;
}
.post_blog_line {
    width: 100%;
    float: left;
    margin-top: 15px;
}
.title_the_articles {
    font-weight: bold;
    color: #47a6da;
    text-transform: uppercase;
}
.title_the_articles {
    font-weight: bold;
    color: #47a6da;
    text-transform: uppercase;
    border-bottom: 1px solid #dfdfdf;
    padding-bottom: 6px;
    PADDING-TOP: 6PX;
}
 </style>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">


<?php

$args = array( 'post_type' => 'post', 'posts_per_page' => 4 );
$loop = new WP_Query( $args );
?>
<div class="title_the_articles">RELATED ARTICLES > </div>
<div class="post_blog_line">
<?php 
while ( $loop->have_posts() ) : $loop->the_post();
?>
<div class="post_blog">
<a href="<?php the_permalink();?>">
<?php
the_post_thumbnail();
?>
</a>
<?php

echo '<div class="displaytitle_blog">';
  the_title();
  echo '</div>';
  ?>
  </div>
  
 <?php
endwhile;
?>
</div>
	</main><!-- .site-main -->



</div><!-- .content-area -->

<?php get_footer(); ?>