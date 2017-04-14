<?php
/*
Attempt MySQL server connection. Assuming you are running MySQL
server with default setting (user 'root' with no password)
*/

$link = mysqli_connect("localhost", "root", "visapro2_wp", "ELXco8S3DlDB5uqbXCB8");
 
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

$ip = mysqli_real_escape_string($link, $_POST['fname']); // some IP address
$fname = split ("\ ", $ip);
$first_name = $fname[1];
$lastname = $fname[2];




$sql = "INSERT INTO splitname (Firstname, Lastname,middlename) VALUES ('$first_name', '$lastname','$mname')";
$result = mysqli_query($link, $sql);
mysqli_free_result($result);

// close connection
mysqli_close($link);
?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css"/>
</head>
<body>

<div id="wp-signupfrm" class="sgn-frm-main"><form id="signup" class="login-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" name="frmcon"><input name="validate" type="hidden" value="1" />
<div class="dupli1"></div>
<div class="sgn-frm-row">
<div class="sgn-frm-inn-lft">
First Name
</div>
<div class="sgn-frm-inn-rht"><input id="fname" name="fname" required type="text" value="<?php echo $first_name . " " .$lastname;?>" placeholder="Enter your first name" /></div>
</div>
<div class="sgn-frm-row-btn"><input class="sgn-frm-row-button Sbtn" name="Submit" type="Submit" value="CREATE MY SECURE ACCOUNT" /></div>
</form></div>
</body>
</html>
