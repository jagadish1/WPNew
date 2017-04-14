<?php
if $_POST['validate']==1 {
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
</script>
<?php
}
?>

<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css"/>
</head>
<body>

<form id="signup" class="login-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" name="frmcon">
<input name="validate" type="hidden" value="1" />


</form>