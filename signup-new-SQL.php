<?php
/*
Attempt MySQL server connection. Assuming you are running MySQL
server with default setting (user 'root' with no password)
*/

<?php  
$serverName = "192.168.42.245"; 
$uid = "sa";   
$pwd = "CiscoAT1100";  
$databaseName = "visapro"; 

$connectionInfo = array( "UID"=>$uid,                            
                         "PWD"=>$pwd,                            
                         "Database"=>$databaseName); 
  
/* Connect using SQL Server Authentication. */  
$conn = sqlsrv_connect( $serverName, $connectionInfo);  
  
$tsql = "SELECT FirstName, Email FROM Article_Data";  
  
/* Execute the query. */  
  
$stmt = sqlsrv_query( $conn, $tsql);  
  
if ( $stmt )  
{  
     echo "Statement executed.<br>\n";  
}   
else   
{  
     echo "Error in statement execution.\n";  
     die( print_r( sqlsrv_errors(), true));  
}  
  
/* Iterate through the result set printing a row of data upon each iteration.*/  
  
while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_NUMERIC))  
{  
     echo "Col1: ".$row[0]."\n";  
     echo "Col2: ".$row[1]."\n";  
     echo "Col3: ".$row[2]."<br>\n";  
     echo "-----------------<br>\n";  
}  
  
/* Free statement and connection resources. */  
sqlsrv_free_stmt( $stmt);  
sqlsrv_close( $conn);  
?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css"/>
</head>
<body>

<div id="wp-signupfrm" class="sgn-frm-main"><form id="signup" class="login-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" name="frmcon"><input name="validate" type="hidden" value="1" />
<div class="sgn-frm-row-btn"><input class="sgn-frm-row-button Sbtn" name="Submit" type="Submit" value="CREATE MY SECURE ACCOUNT" /></div>
</form></div>
</body>
</html>