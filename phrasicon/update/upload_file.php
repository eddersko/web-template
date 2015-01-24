<?php

$success = FALSE;

if(isset($_POST['submit']))
{

   if ($_FILES["file"]["error"][0] == 0)
   {

    $y = 0;
    $length = count($_FILES['file']['name']);
        
  for ($x=0; $x<$length; $x++) {
    if ($_FILES["file"]["name"][$x] != "phrasicon.xml") {
     break;   
    }
  move_uploaded_file($_FILES["file"]["tmp_name"][$x], "../" . $_FILES["file"]["name"][$x]);
  $success = TRUE;
        }   
    }
}

if ($success) {
    echo "<div class=\"row\"><hr><br><h4 style=\"font-size: 200%\"><center>Upload Success!</center></h4></div>";
 include("./interface.php");   
} else {
 echo "<div class=\"row\"><hr><br><h4 style=\"font-size: 200%\"><center>Upload Failed...</center></h4></div>";
 include("./interface.php");
}
?>




