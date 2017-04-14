<?php


//* Template Name: Filing Secrets New Template

 get_header(); ?>
 <style>
.widget-area.header-widget-area {
    display: none;
}
.genesis-nav-menu {
    float: none;
    width: 100%;
    clear: right;
}
.genesis-nav-menu a {
    padding: 10px 20px;
    margin-top: 10px;
}
.pgtit{
font-size: 30px;
font-weight: bold;
}
.site-inner .sitewd, .pgtit{
width:50%;
margin: 0 auto;
}
.check{
background: #00b9eb;
   padding: 8px 10px;
    color: white !important;
    font-size: 15px;
text-decoration: none;
}
button#wpforms-submit-892 {
    margin: auto 160px;
}
section#search-6 {
    display: none;
}
section#baba-6 {
    display: none;
}

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
<div class="pgtit">
<?php echo get_the_title(865);?>
</div>

<?php the_content(); ?>



<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">



<?php

$args = array( 'post_type' => 'post', 'posts_per_page' => 4 );
$loop = new WP_Query( $args );
?>

</div>
	

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

</main><!-- .site-main -->
</div><!-- .content-area -->

<script src = "//code.jquery.com/jquery-3.0.0.min.js"></script> <!-- add jquery library-->
<script type = "text/javascript">
$('.SubmitButton').click(function(){ // on submit button click

    var urldata = $('#dropDownId :selected').val(); // get the selected  option value
   // window.open("http://192.168.42.128/WPNew/") // open a new window. here you need to change the url according to your wish.
});

</script>



<?php get_footer(); ?>