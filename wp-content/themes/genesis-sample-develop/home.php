<?php
/**
 * The template for displaying about us page.
 *
 * Template Name: home
 *
 */

get_header(); ?>
<?php
echo "hello";
$servername= "localhost";
$username="root";
$passwprd="HP7540$";
$dbname="wordpress520";
$conn = mysqli_connect($servername, $username, $passwprd, $dbname);
if (!$conn){
	
	die("connection failed:". mysqli_connect_error());
}
?>
<html>
<head>

<style>
.btn{
	display:inline-block;
	padding: 6px 12px;
	margin-bottom:0px;
	font-weight: 400;
    line-height: 1.42857143;
    text-align: center;
    white-space: nowrap;
    vertical-align: middle;
	border: 1px solid transparent;
    border-radius: 4px;

}
.btn-primary{
    background-color: #1c9cde;
	color: white;

}
.button{
	font-family: 'Glyphicons Halflings';
	display: inline-block;
	font-style: normal;
	font-weight: normal;
	content: "\e080";
	text-decoration: none !important;
	font-size: 20px;
}
a{
	text-decoration: none !important;
}
.img-responsive{
	display: block;
	max-width: 100%;
	height: auto;
}
img{
	border: 0;
	vertical-align: middle;
}
</style>
</head>
<body>
<div class="container">
<h2>Immigration Blog</h2>
<div class="row">
<?php
$query = "SELECT video FROM blogimg";
$result = $mysqli->query($query);

/* numeric array */
$row = $result->fetch_array();
foreach($result_list as $row) {
?>
    <img class="img-responsive" src="<?php echo "upload/"; echo $result_list['video'];  ?>">        
<?php } ?>

<hr>
<h2>
<a href="#">Title</a>
</h2>
<p>text</p>
<p>time</p>
<a class="btn btn-primary button" href="#">Read More</a>
</div>
</div>



</body>
</html>
<?php get_footer(); ?>
