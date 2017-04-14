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
$receipt = mysqli_real_escape_string($link, $_POST['cname']);
$email_address = mysqli_real_escape_string($link, $_POST['email']);
$visatype = mysqli_real_escape_string($link, $_POST['phone']);

// attempt insert query execution
 if(isset($_POST['Submit'])) {

   
$sql = "INSERT INTO salesforce (FirstName, ReceiptNumber, Email,Visatype) VALUES ('$first_name', '$receipt', '$email_address','$visatype')";
$result = mysqli_query($link, $sql);
   mysqli_free_result($result);
 ?>
<html>
<body>
<form action="https://www.salesforce.com/servlet/servlet.WebToLead?encoding=UTF-8" method="POST" id=form1 name=frmRegistration>
<input type=hidden name="oid" value="00D700000008zyv">
<input type=hidden name="retURL" value="https://www.visapro.com/s/visa-status-thankyou.asp?f1=<?php echo $receipt ?>">
<input type="hidden" name="sfga" value="00D700000008zyv"/>
<input  id="first_name" maxlength="40" name="first_name" size="20" type="hidden" value="<?php echo $first_name ?>" />
<input  id="last_name" maxlength="40" name="last_name" size="20" type="hidden" value="NULL" />
<input  id="company" maxlength="40" name="company" size="20" type="hidden" value="<?php echo $first_name ?>" />
<input  id="00N70000002Gu0Y" maxlength="30" name="00N70000002Gu0Y" size="20" type="hidden" value="<?php echo $receipt ?>"/>
<input  id="00N70000002SwnA" name="00N70000002SwnA" type="hidden" value="<?php echo $visatype ?>"/>
<input  id="email" maxlength="80" name="email" size="20" type="hidden" value="<?php $email_address ?>" />
<input  id="00N70000002Gu0d" maxlength="100" name="00N70000002Gu0d" size="20" type="hidden" value="NULL"/>
<input  id="00N70000002Gu0i" maxlength="100" name="00N70000002Gu0i" size="20" type="hidden" value="NULL"/>
<input  id="00N70000002Gu0n" maxlength="100" name="00N70000002Gu0n" size="20" type="hidden" value="NULL" />
<input id="lead_source" name="lead_source" size="100" type="hidden" value="Website"/>
<input id="00N70000001pDJD" name="00N70000001pDJD" type="hidden" value="US" />
<input id="00N70000001pDHg" name="00N70000001pDHg"  type="hidden" value="VisaProcess" />
<input id="00N70000001pDHh" name="00N70000001pDHh" type="hidden" value="Individual" >
<input id="00N70000001qu0T" name="00N70000001qu0T" type="hidden" value="VisaStatus" />
</form>
<script language="JavaScript">
document.frmRegistration.submit();
</script>
</body>
</html><?php
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

Full Name

</div>
<div class="sgn-frm-inn-rht"><input id="fname" name="fname" required type="text" value="<?php echo $first_name;?>" placeholder="Enter your Full name" /></div>
</div>
<div class="sgn-frm-row">
<div class="sgn-frm-inn-lft">

Receipt Number *

</div>
<div class="sgn-frm-inn-rht"><input name="cname" type="text" value="<?php echo $CompanyName;?>" placeholder="Enter Receipt Number (optional)" /></div>
</div>

<div class="sgn-frm-row">
<div class="sgn-frm-inn-lft">

Visa Petition

</div>
<div class="sgn-frm-inn-rht"><select name="Classification" class="signup-txt sitxt1" size="1" tabindex=4>
<option value="H-1B Visa">H-1B Visa</option>
<option value="E-1 Visa">E-1 Visa</option>
<option value="E-2 Visa">E-2 Visa</option>
<option value="E-3 Visa">E-3 Visa</option>
</select>
</div>
</div>
<div class="sgn-frm-row">
<div class="sgn-frm-inn-lft">

Email

</div>
<div class="sgn-frm-inn-rht"><input id="email" name="email" required type="email" value="<?php echo $email_address;?>" placeholder="Enter your email address" /> <span class="error"> <?php echo $emailErr;?></span></div>
</div>


<div class="sgn-frm-row-btn"><input class="sgn-frm-row-button Sbtn" name="Submit" type="Submit" value="CREATE MY SECURE ACCOUNT" /></div>
</form></div>
</body>
</html>