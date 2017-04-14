<?php


//* Template Name: Service layout

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
			'xhtml'   => '<div id="content" class="hfeed">',
			'context' => 'content',
		) );

		
			do_action( 'genesis_before_loop' );
			
			
				
		$name = 'H-2B';
$link = mysqli_connect("localhost", "root", "HP7540$", "wordpress520");

// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

$sql1 = "SELECT * FROM service where visatype='$name'";
if($result = mysqli_query($link, $sql1)){
    if(mysqli_num_rows($result) > 0){      
        while($row = mysqli_fetch_array($result)){
                                
 	?>	 				         
     
<ol class="serv-tabs-lst">
<?php 
if( $row['overview']<>""){?>
 	<li><a href="http://192.168.42.128/WPNew/"><?php  echo $row['overview']; ?></a></li>
<?php
}
if( $row['process']<>""){
?> 	<li><a href="http://usimmigration.visapro.com/h1b-visa.asp"><?php echo $row['process']; ?></a></li>
<?php
}
if( $row['faq']<>""){
?> 
 	<li><a href="http://faq.visapro.com/h1b-visa-faq.asp"><?php echo $row['faq']; ?></a></li>
<?php }?>
</ol>
<?php 
 
        }
        echo "</table>";
        // Close result set
        mysqli_free_result($result);
    } else{
        echo "No records matching your query were found.";
    }
} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}
 //close connection
mysqli_close($link);	
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
