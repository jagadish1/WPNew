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
$first_name = mysqli_real_escape_string($link, $_POST['cfname']);
$LastName = mysqli_real_escape_string($link, $_POST['clname']);
$email_address = mysqli_real_escape_string($link, $_POST['cemail']);
$Phone = mysqli_real_escape_string($link, $_POST['ccontactno']);
$city = mysqli_real_escape_string($link, $_POST['ccity']);
$country = mysqli_real_escape_string($link, $_POST['ccountry']);
$interest = mysqli_real_escape_string($link, $_POST['cinterest1']);
// attempt insert query execution
 if(isset($_POST['Submit'])) {    
$sql = "INSERT INTO eligibility_results (FirstName, LastName, Email,Phone,City,Country,Interest) VALUES ('$first_name', '$LastName', '$email_address','$Phone','$city','$country','$interest')";
$result = mysqli_query($link, $sql);
   mysqli_free_result($result);
 ?>
<form name="frmcon" action="http://192.168.42.245:1910/s/congrats-wordpress.asp" method="post">
<input type="hidden" name="validate" value="1">
<input type="hidden" name="FirstName" value="<?php echo $first_name ?>">
<input type="hidden" name="LastName" value="<?php echo $LastName ?>">
<input type="hidden" name="Email" value="<?php echo $email_address ?>">
<input type="hidden" name="PhoneNumber" value="<?php echo $Phone ?>">
<input type="hidden" name="City" value="<?php echo $city ?>">
<input type="hidden" name="Country" value="<?php echo $country ?>">
<input type="hidden" name="cinterest" value="<?php echo $interest ?>">
<input type="hidden" name="visatype" value="<?php echo $_REQUEST["visa"]; ?>">
<input type="hidden" name="chreg" value="Y">
</form>
<script language="JavaScript">
frmcon.submit();
</script><?php
 }
// close connection
mysqli_close($link);
?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css"/>
</head>
<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<TABLE cellSpacing="0" cellPadding="0" width="780" border="0" align="center" class="res-congrts-tbl"> 
	<tbody>
		<tr> 
			<td valign="top"> 
				<table cellspacing=0 cellpadding=0 width="100%" align=center border=0>
					<tbody>
						<tr> 
							<td width="79%" rowspan=2 background="/Images/Transparent.gif" valign="top"> 
								<table width="100%" border="0" cellspacing="0" cellpadding="0">
									<tr> 
										<td valign="top"><img src="http://visaoptions.visapro.com/Images/Transparent.gif" width="1" height="10"></td>
									</tr>
								</table>            
								<br>
								<div class="cngts">
									<table width="93%" border="0" align="center" cellpadding="0" cellspacing="0">
										<tr height="40"align="center">
											<td valign="top" class="Title-XL-Green"><b>Congratulations </b><font color="#FF6633"><?php echo $_REQUEST["ufnm"]; ?></font> !</td>
										</tr>
										<tr align="center" height="50">
											<td class="title-xl"><strong>You may be  <font color="60B537">eligible </font> <?php echo $_REQUEST["visa"]; ?>.</strong> </td>
										</tr>
									</table>
									<table align="center" width="93%"><tr align="center"><td width="201" height="30" class="Title-XL-small">Please check your email for your detailed Visa Eligibility report.</td></tr>
									</table>
								</div>
								<H1 class="h1cngts">Get a FREE Complimentary Visa Assessment  </H1>
								<table width="92%" border="0" cellspacing="0" cellpadding="0" align="center" style="margin-top: -185px;">
									<tr>
										<td width="65%" align="left" height="34">
											<table width="464" height="207">
												<tr>
													<td width="237" height="52"> 
														<p class="cngtsp"> Because immigration law is a complex matter, we recommend that you obtain a FREE Visa Assessment and confirm your eligibility <?php echo $_REQUEST["visa"]; ?>.</p>
													</td>
													<td width="3">&nbsp;</td>
													<td width="208"><img src="http://visaoptions.visapro.com/Images/us-visa-eligibility.jpg" alt="Free online us visa eligibilty check" width="200" height="138" class="cngtsimg"></td>
												</tr>
												<br>
												<tr>
													<td height="52" colspan="3">
														<p style="height: 2px;">&nbsp;</p>
														<p class="cngtsp"><b>VisaPro's FREE Visa Assessment service includes:</b></p>
														<ul style="line-height: 26px;">
															<li class="cngtsp">A 10-minute consultation with an experienced immigration attorney.</li> 
															<li class="cngtsp">Personal review of your specific situation.</li>
															<li class="cngtsp">Confirmation of your eligibility <?php echo $_REQUEST["visa"]; ?>.</li>
														</ul>
													</td>
      </tr>
    <tr>
      <td height="25" colspan="3" align="left" style="
    line-height: 26px;
font-family:Helvetica Neue, Helvetica,arial,sans-serif; font-size: 15px; color:#666"><strong>Fill out the form to the right and a VisaPro representative will contact you!</strong></font></td>
    </tr>
  </table>
      </td>
    <td width="2%">&nbsp;</td>
    <td width="100%" height="34" valign="top"><table width="105%" align="center" cellpadding="1" cellspacing="1" bordercolor="#CCCCCC" class="new-table lp-orange-form" style="
    margin-top: 136px;
">
  <!--<tr valign="bottom"> <td width="100%"  valign="middle" class=" blue-text sub-title"  style="text-align:center;"><font size="2px" color="#0066CC">Yes, I would like to check my Eligibilty!</font></td>
</tr>-->
  <tr align="left"> <td><font face="Tahoma, Geneva, sans-serif" color="#666666" size="3px" style="   
    letter-spacing: 1px;
    line-height: 1.4;
"> <strong>Consult with an experienced<br> 
immigration attorney.</strong>
</font>
<form name="frmcon" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
<input name="validate" type="hidden" value="1" />
   <table cellspacing="8" cellpadding="0" width="92%" border="0" style="   margin-top: 24px;   margin-left: -8px;">
  <tbody>
  <tr align="center"> 
                                    <td width="47%" align="right" class="Text-small-Black">
									<div class="cngtstext"><span class="Text-Small-Gray">First Name *</span></div></td></tr>
                 <tr>                   <td width="53%" align="left"><span class="Text-Large-Black"> 
                                      <input name="cfname" size="25" class="hs-input" value="<?php echo $_REQUEST["ufnm"]; ?>" />
                                      </span></td>
                                 
</tr><tr align="center"> 
                                    <td width="47%" align="right" class="Text-small-Black"><div class="cngtstext"><span class="Text-Small-Gray">Last Name *</span></div></td></tr>
                 <tr>                   <td width="53%" align="left"><span class="Text-Large-Black"> 
                                      <input name="clname" size="25" class="hs-input" />
                                      </span></td>
                                 
</tr>
    <tr align="center"> 
                                    <td width="47%" align="right" class="Text-small-Black"><div class="cngtstext"><span class="Text-Small-Gray">Email *</span></div></td></tr>
                 <tr>                   <td width="53%" align="left"><span class="Text-Large-Black"> 
                                      <input name="cemail" size="25" class="hs-input" value="<?php echo $_REQUEST["ueml"]; ?>" />
                                      </span></td>
                                 
</tr><tr align="center"> 
                                    <td width="47%" align="right" class="Text-small-Black"><div class="cngtstext"><span class="Text-Small-Gray">Phone Number *</span></div></td></tr><tr>                   <td width="53%" align="left"><span class="Text-Large-Black"> 
                                      <input name="ccontactno" size="25" class="hs-input" value="<?php echo $_REQUEST["uphl"]; ?>" />
                                      </span></td>
                                 
</tr><tr align="center"> 
                                    <td width="47%" align="right" class="Text-small-Black"><div class="cngtstext"><span class="Text-Small-Gray">City *</span></div></td></tr><tr>                   <td width="53%" align="left"><span class="Text-Large-Black"> 
                                      <input name="ccity" size="25" class="hs-input" />
                                      </span></td>
                                 
</tr><tr align="center"> 
                                    <td width="47%" align="right" class="Text-small-Black"><div class="cngtstext"><span class="Text-Small-Gray">Country *</span></div></td></tr>
                 <tr>                   <td width="53%" align="left"><span class="Text-Large-Black"> 
                                      <input name="ccountry" size="25" class="hs-input" />
                                      </span></td>
                                 
</tr>
<tr align="center"> 
                                    <td width="47%" align="right" class="Text-small-Black"><div class="cngtstext"><span class="Text-Small-Gray">Country *</span></div></td></tr>
                 <tr>                   <td width="53%" align="left"><span class="Text-Large-Black"> 
                                      <select style="font-size: 12px;padding-left: 8px; margin-top: 8px;" name="cinterest1" class="select-visa hs-input">
    <option selected value="">&nbsp;&nbsp;-&nbsp;&nbsp;I AM&nbsp;&nbsp;INTERESTED&nbsp;&nbsp;AS A&nbsp;&nbsp;&nbsp;-&nbsp;</option>
   
    <option value="Foreign Company">
    Foreign Company
    </option>
        <option value="Foreign Investor">
    Foreign Investor
    </option>    <option value="US Employer">
US Employer
    </option>    <option value="Foreign National (Inside US)">
Foreign National (Inside US)
    </option>    <option value="Foreign National (Outside US)">
    Foreign National (Outside US)
    </option>    <option value="Artist-Agent">
Artist - Agent
    </option>
       <option value="Artist">
Artist
    </option>   <option value="Athlete">
Athlete
    </option>
   
  </select>
                                      </span></td>
                                 
</tr>




    </tbody>
  </table> </td></tr>
  <br><br>
  <tr><td width="56%">
  <table width="100%" border="0" align="center" cellpadding="1" cellspacing="0">
    
    <tr>
      <td width="100%" align="center" class="Text-Large-Black">
        <input class="vp-button" type="Submit" name="Submit" value="Get Your Free Visa Assessment"  style="line-height: 20px;">


  &nbsp;</td></tr>
    </table>
  </td></tr>
</table ></td></tr></table>

</td></tr></table></td></tr></table>
</form>
<br>
</body>
</html>