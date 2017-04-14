<?php
/*
Attempt MySQL server connection. Assuming you are running MySQL
server with default setting (user 'root' with no password)
*/

$link = mysqli_connect("localhost", "root", "HP7540$", "wordpress520");
 
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
 $emailErr="";
 $unameErr="";
// Escape user inputs for security
$first_name = mysqli_real_escape_string($link, $_POST['fname']);
$CompanyName = mysqli_real_escape_string($link, $_POST['cname']);
$email_address = mysqli_real_escape_string($link, $_POST['email']);
$Phone = mysqli_real_escape_string($link, $_POST['phone']);
$Uname = mysqli_real_escape_string($link, $_POST['uname']);
$Password = mysqli_real_escape_string($link, $_POST['password']);

// attempt insert query execution
 if(isset($_POST['Submit'])) {

    //connect to the database
    $check=mysqli_query($link,"select * from signup where Email='$email_address'");
    $checkrows=mysqli_num_rows($check);
	   $check1=mysqli_query($link,"select * from signup where UserName='$Uname'");
    $checkrows1=mysqli_num_rows($check1);
   if($checkrows>0) {
      $emailErr="Email exists";
   } else if ($checkrows1>0) {
      $unameErr="Username exists";
   } else
   {

$sql = "INSERT INTO signup (FirstName, CompanyName, Email,PhoneNumber,UserName,Password) VALUES ('$first_name', '$CompanyName', '$email_address','$Phone','$Uname','$Password')";
$result = mysqli_query($link, $sql);
   mysqli_free_result($result);
   get_header();
 ?>
<form name="frmcon" action="http://www.visapro.com/wp-signup2.asp" method="post">
<input type="hidden" name="validate" value="1">
<input type="hidden" name="FirstName" value="<?php echo $first_name ?>">
<input type="hidden" name="CompanyName" value="<?php echo $CompanyName ?>">
<input type="hidden" name="Email" value="<?php echo $email_address ?>">
<input type="hidden" name="PhoneNumber" value="<?php echo $Phone ?>">
<input type="hidden" name="UserName" value="<?php echo $Uname ?>">
<input type="hidden" name="Password" value="<?php echo $Password ?>">
<input type="hidden" name="chreg" value="Y">
</form>
<script language="JavaScript">
frmcon.submit();
</script><?php
}
 };
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
<div class="sgn-frm-inn-rht"><input id="fname" name="fname" required type="text" value="<?php echo $first_name;?>" placeholder="Enter your first name" /></div>
</div>
<div class="sgn-frm-row">
<div class="sgn-frm-inn-lft">

Company Name *

</div>
<div class="sgn-frm-inn-rht"><input name="cname" type="text" value="<?php echo $CompanyName;?>" placeholder="Enter your company name (optional)" /></div>
</div>
<div class="sgn-frm-row">
<div class="sgn-frm-inn-lft">

Email

</div>
<div class="sgn-frm-inn-rht"><input id="email" name="email" required type="email" value="<?php echo $email_address;?>" placeholder="Enter your email address" /> <span class="error"> <?php echo $emailErr;?></span></div>
</div>
<div class="sgn-frm-row">
<div class="sgn-frm-inn-lft">

Phone Number

</div>
<div class="sgn-frm-inn-rht"><input id="phone" name="phone" type="number" required value="<?php echo $Phone;?>" placeholder="Enter your phone number" /></div>
</div>
<div class="sgn-frm-row">
<div class="sgn-frm-inn-lft">

Username

</div>
<div class="sgn-frm-inn-rht"><input id="uname" maxlength="15" name="uname" required type="text" value="<?php echo $Uname;?>" placeholder="Enter 5-15 characters" /> <span class="error"><?php echo $unameErr;?></span></div>
</div>
<div class="sgn-frm-row">
<div class="sgn-frm-inn-lft">

Password

</div>
<div class="sgn-frm-inn-rht"><input id="password" maxlength="10" name="password" required type="password" value="<?php echo $Password;?>" placeholder="Enter 3-10 characters" /></div>
</div>

<div class="sgn-frm-row-btn"><input class="sgn-frm-row-button Sbtn" name="Submit" type="Submit" value="CREATE MY SECURE ACCOUNT" /></div>
</form></div>
</body>
</html>
<?php 
get_footer();
?>