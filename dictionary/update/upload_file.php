<?php
$allowedExts = array("csv");
$temp = explode(".", $_FILES["file"]["name"]);
$extension = end($temp);
$success = FALSE;

if ((($_FILES["file"]["size"] < 20000)
&& in_array($extension, $allowedExts))) {
  if ($_FILES["file"]["error"] > 0) {
    echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
  } else {
      move_uploaded_file($_FILES["file"]["tmp_name"],
      "../update/" . $_FILES["file"]["name"]);
      $success = TRUE;
  }
} else {
    echo "<div class=\"row\"><hr><br><h4 style=\"font-size: 200%\"><center>Invalid File.</center></h4><h4><center>\"Valar Morghulis...\"</center></h4></div>";
 include("../../../insert.php");  
}

if ($success) {
    echo "<div class=\"row\"><hr><br><h4 style=\"font-size: 200%\"><center>Upload Success!</center></h4><h4><center>\"Dracarys!\"</center></h4></div>";
 include("../../../insert.php");   
}
?> 