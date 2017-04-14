<?php
/*
Attempt MySQL server connection. Assuming you are running MySQL
server with default setting (user 'root' with no password)
*/
$myServer = "192.168.42.245";
$myUser = "sa";
$myPass = "CiscoAT1100";
$myDB = "Testwordpress"; 

$link = mssql_connect("192.168.42.245", "sa", "CiscoAT1100", "Testwordpress");
 
// Check connection
$dbhandle = mssql_connect($myServer, $myUser, $myPass)
  or die("Couldn't connect to SQL Server on $myServer"); 
  
  $selected = mssql_select_db($myDB, $dbhandle)
  or die("Couldn't open database $myDB"); 
 
// Escape user inputs for security
 
// attempt insert query execution
$sql = "INSERT INTO signup (FirstName, CompanyName, Email,PhoneNumber,UserName,Password) VALUES ('$_POST['fname']', '$_POST['cname']', '$_POST['email']','$_POST['phone']','$_POST['uname']','$Password')";
$result = mssql_query($sql);
 ?>
<form name="frmcon" action="/wp-signup2.asp" method="post">
<input type="hidden" name="validate" value="1">
<input type="hidden" name="FirstName" value="<?php echo $_POST['fname'] ?>">
<input type="hidden" name="CompanyName" value="<?php echo $_POST['cname'] ?>">
<input type="hidden" name="Email" value="<?php echo $_POST['email'] ?>">
<input type="hidden" name="PhoneNumber" value="<?php echo $_POST['phone'] ?>">
<input type="hidden" name="UserName" value="<?php echo $_POST['uname'] ?>">
<input type="hidden" name="Password" value="<?php echo $_POST['password'] ?>">
<input type="hidden" name="chreg" value="Y">
</form>
<script language="JavaScript">
frmcon.submit();
</script>
 <?php
// close connection
mssql_close($dbhandle);
?>



