<?php
/**
 * The template for displaying about us page.
 *
 * Template Name: upload
 *
 */

get_header();?>
<html>
<head>

<style>
</style>
</head>
<body>
<form action ="http://192.168.42.128/WPNew/wp-content/themes/genesis-sample-develop/upload_file.php" method="post" enctype= "multipart/form-data">
<label for="file"><span>Filename:</span></label>
<input type="file" name="file" id="file"/>
<br/>
<input type="submit" name="submit" id="submit"/>
</form>
</body>
</html>
