<?php


//* Template Name: work visa

get_header();

	do_action( 'genesis_before_content_sidebar_wrap' );
	genesis_markup( array(
		'html5'   => '<div %s>',
		'xhtml'   => '<div id="content-sidebar-wrap">',
		'context' => 'content-sidebar-wrap',
	) );

		do_action( 'genesis_before_content' );
		genesis_markup( array(
			'html5'   => '<main %s>',
			'xhtml'   => '<div id="content" class="hfeed seven-culmn">',
			'context' => 'content',
		) );

		
			do_action( 'genesis_before_loop' );
			
?>
<div class="seven-culmn">
<h2 style="text-align: center;"><b>Work Visas</b></h2>
<h4 style="text-align: center;">Explore the best work visa options for foreign nationals to 
work and live in the U.S.</h4>
<div class="workintro">
<p><b>Introduction</b></p>
All foreign nationals traveling to the U.S. with the intention of working temporarily must obtain a nonimmigrant work visa. The U.S. government does not issue work visas for casual employment. All work visas are based on a specific offer of employment from a U.S. employer.
</div>

<div class="common"><p class="com"><b>The most common categories of work visas are listed below:</b></p></div>
<?php
$name =get_the_title();
$link = mysqli_connect("localhost", "root", "HP7540$", "wordpress520");

// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
$y=1;
$sql1 = "SELECT * FROM workvisa where category='$name'";
if($result = mysqli_query($link, $sql1)){
    if(mysqli_num_rows($result) > 0){      
        while($row = mysqli_fetch_array($result)){
?>
<div class="work"> 	
<div class="work1">
<P class="num"><?php echo $y ?></p>
</div>
<div class="work2">
<div class="sr-tab-sec1 sr-tab-active1"><?php echo $row['title'] ?></div>
<div class="sr-tab-sec2"><?php echo $row['description'] ?></div>
<div class="sr-tab-sec3"><a href=""><?php echo $row['link'] ?></a></div>
</div>
</div>

<?php 
$y++;
}        
        mysqli_free_result($result);
    } else{
        echo "No records matching your query were found.";
    }
} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}
 //close connection
mysqli_close($link);?>
</div></div>
<br /><br />
<br />
<?php
do_action( 'genesis_loop' );
			do_action( 'genesis_after_loop' );
		genesis_markup( array(
			'html5' => '</main>', //* end .content
			'xhtml' => '</div>', //* end #content
		) );
		do_action( 'genesis_after_content' );

	echo '</div>'; //* end .content-sidebar-wrap or #content-sidebar-wrap
	do_action( 'genesis_after_content_sidebar_wrap' );


	get_footer();
?>
