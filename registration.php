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
$first_name = mysqli_real_escape_string($link, $_POST['fname']);
$CompanyName = mysqli_real_escape_string($link, $_POST['cname']);
$email_address = mysqli_real_escape_string($link, $_POST['email']);
$Phone = mysqli_real_escape_string($link, $_POST['phone']);
$Uname = mysqli_real_escape_string($link, $_POST['uname']);
$Password = mysqli_real_escape_string($link, $_POST['password']);
 
// attempt insert query execution
 if(isset($_POST['submit'])) {

    //connect to the database
    $check=mysqli_query($link,"select * from signup where Email='$email_address'");
    $checkrows=mysqli_num_rows($check);

   if($checkrows>0) {
      echo "Email exists";
   } else
   {

$sql = "INSERT INTO signup (FirstName, CompanyName, Email,PhoneNumber,UserName,Password) 
VALUES ('$first_name', '$CompanyName', '$email_address','$Phone','$Uname','$Password')";
$result = mysqli_query($link, $sql);
   mysqli_free_result($result);
 }
 }
 ?>
<form name="frmcon" action="http://192.168.42.245:1914/wordpress/wp-signup.asp" method="post">
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
// close connection
mysqli_close($link);
?>
<html>
<body>
<p style="font-size:50px">Please wait</p>
</body>
</html>