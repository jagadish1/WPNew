<?php
$link = mysqli_connect("localhost", "root", "HP7540$", "wordpress520");
 
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
$first_name = mysqli_real_escape_string($link, $_POST['fname']);
$email_address = mysqli_real_escape_string($link, $_POST['email']);

$first_name =  $_REQUEST['fname'];
$email_address = $_REQUEST['email'];

 if(isset($_POST['Submit'])) {
 
 $sql = "INSERT INTO Newsletter (FirstName, Email) VALUES ('$first_name','$email_address')";
$result = mysqli_query($link, $sql);
   mysqli_free_result($result);

 ?>
<form name="frmcon" action="http://192.168.42.128/WPNew/select-immigration-alerts/?fname=<?php echo $first_name ?>&email=<?php echo $email_address ?>" method="post">
<input type="hidden" name="validate" value="1">
<input type="hidden" name="FirstName" value="<?php echo $first_name ?>">
<input type="hidden" name="Email" value="<?php echo $email_address ?>">
<input type="hidden" name="chreg" value="Y">
</form>
<script language="JavaScript">
frmcon.submit();
</script><?php
 };
// close connection
mysqli_close($link);
?>

<html>
<head>
<title>Popup contact form</title>
<link href="elements.css" rel="stylesheet">
<script src="my_js.js"></script>
</head>
<!-- Body Starts Here -->
<body id="body" style="overflow:hidden;">
<div id="abc">
<!-- Popup Div Starts Here -->
<div id="popupContact">
<!-- Contact Us Form -->
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" id="form" method="post" name="form">
<img id="close" src="images/3.png" onclick ="div_hide()">
<h2>Contact Us</h2>
<hr>
<input id="fname" name="fname" placeholder="Full Name" required type="text" value="<?php echo $first_name;?>">
<input id="email" name="email" placeholder="Email Address" required type="text" value="<?php echo $email_address;?>">
<br>
<br>
<input type="Submit" name="Submit" value="SEND ME FREE TIPS"     style="background-color: #cab374;
    width: 246px;
    height: 40px;
    border-radius: 5px;
    color: #FFFFFF;
    font-weight: bold;
    font-size: 20px;">
</form>
</div>
<!-- Popup Div Ends Here -->
</div>
<!-- Display Popup Button -->
<div style="text-align:center">
<h1>Newsletter popup Example</h1>
<button id="popup" onclick="div_show()" style="background-color: #cab374;
    width: 246px;
    height: 40px;
    border-radius: 5px;
    color: #FFFFFF;
    font-weight: bold;
    font-size: 20px;">Popup</button>
</div>		
</body>
<!-- Body Ends Here -->
</html>