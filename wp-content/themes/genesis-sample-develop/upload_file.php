
<?php
/**
 * The template for displaying about us page.
 *
 * Template Name: upload_file
 *
 */

get_header(); ?>
<?php
echo "hello";
$servername= "localhost";
$username="root";
$passwprd="HP7540$";
$dbname="wordpress520";
$conn = mysqli_connect($servername, $username, $passwprd, $dbname);
if (!$conn){
	
	die("connection failed:". mysqli_connect_error());
}
$allowedExts= array("jpg", "jpeg", "png", "gif", "mp3", "mp4", "wma");
$extension = pathinfo($FILES['file']['name'],PATHINFO_EXTENSION);

if ((($_FILES["file"]["type"] == "video/mp4")
|| ($_FILES["file"]["type"] == "audio/mp3")
|| ($_FILES["file"]["type"] == "audio/wma")
|| ($_FILES["file"]["type"] == "image/jpg")
|| ($_FILES["file"]["type"] == "image/jpeg")
|| ($_FILES["file"]["type"] == "image/png")
|| ($_FILES["file"]["type"] == "image/gif"))
&& ($_FILES["file"]["size"] < 90000000000)
&& in_array($extension, $allowedExts))
{
	if ($_FILES["file"] ["error"] > 0 )
	{
		echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
	}
 else
    {
    echo "Upload: " . $_FILES["file"]["name"] . "<br />";
    echo "Type: " . $_FILES["file"]["type"] . "<br />";
    echo "Size: " . ($_FILES["file"]["size"] / 1024) . " MB<br />";
    echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br />";

    if (file_exists("http://192.168.42.128/WPNew/wp-content/themes/genesis-sample-develop/upload/" . $_FILES["file"]["name"]))
      {
      echo $_FILES["file"]["name"] . " already exists. ";
      }
    else
      {
      move_uploaded_file($_FILES["file"]["tmp_name"],
      "http://192.168.42.128/WPNew/wp-content/themes/genesis-sample-develop/upload/" . $_FILES["file"]["name"]);
      echo "Stored in: " . "http://192.168.42.128/WPNew/wp-content/themes/genesis-sample-develop/upload/" . $_FILES["file"]["name"];
      $vname = $_FILES["file"]["name"];

      $sql = "INSERT INTO blogimg (video) VALUES ('".$vname."')";
      echo "$sql"+$sql;

        if (mysqli_query($conn, $sql)) {
            echo "Done successfully";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }

        mysqli_close($conn);
      }
    }
  }
else
  {
  echo "Invalid file";
  }


?>