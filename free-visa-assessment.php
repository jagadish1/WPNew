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
 
// Escape user inputs for security
$first_name = mysqli_real_escape_string($link, $_POST['ffname']);
$email_address = mysqli_real_escape_string($link, $_POST['femail']);
$Phone = mysqli_real_escape_string($link, $_POST['fphone']);
$fmessage = mysqli_real_escape_string($link, $_POST['fmessage']);
 
// attempt insert query execution
$sql = "INSERT INTO freevisaassessment (FirstName,Email,Phone,Message) VALUES ('$first_name', '$email_address','$Phone','$fmessage')";
$result = mysqli_query($link, $sql);
 mysqli_free_result($result);
 ?>
<form name="frmcon" action="http://192.168.42.245:1914/wordpress/assessment.asp" method="post">
<input type="hidden" name="validate" value="1">
<input type="hidden" name="FirstName" value="<?php echo $first_name ?>">
<input type="hidden" name="Email" value="<?php echo $email_address ?>">
<input type="hidden" name="PhoneNumber" value="<?php echo $Phone ?>">
<input type="hidden" name="Message" value="<?php echo $fmessage ?>">
<input type="hidden" name="chreg" value="Y">
</form>
<script language="JavaScript">
frmcon.submit();
</script>
 <?php
// close connection
mysqli_close($link);
?>



