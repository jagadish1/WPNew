<?php 
/**
Template Name:Temporary
*/
$c=$_GET["country"];
$p=$_GET["profession"];

$DisplayProfessional = $p . "s";
If (strtoupper(p) == "BUSINESSMAN"){  $DisplayProfessional = "Businessmen";}
If (strtoupper(p) == "COACH"){ $DisplayProfessional = "Coaches";}
If (strtoupper(p) == "FOOTBALL COACH"){ $DisplayProfessional = "Football Coaches";}
If (strtoupper(p) = "MISSIONARY"){ $DisplayProfessional = "Missionaries";}

$ISE1Eligible="N";
If ((strtoupper($c) == "Argentina")or ({
$ISE1Eligible="Y";
}
echo $DisplayProfessional;

?>
<html>
<head>
</head>
<body>
<div>Hi my city is: 
<?php

echo $c;
?>
</div>
<div>Hi my profession is: 
<?php

echo strtoupper($p);
?>
</div>
</body>
</html>
