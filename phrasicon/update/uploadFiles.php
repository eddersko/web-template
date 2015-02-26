<?php

    /*
    * Author: Edwin Ko eddersko.com
    * This script is free software.
    */

$success = FALSE;

if(isset($_POST['submit']))
{

   if ($_FILES["file"]["error"][0] > 0)
   {
            echo "<div class=\"row\"><hr><br><h4 style=\"font-size: 200%\"><center>Invalid File.</center></h4></div>";
 include("./index.php");
    }
    else
    {
    $y = 0;
        $length = count($_FILES['file']['name']);
        
  for ($x=0; $x<$length; $x++) {
  move_uploaded_file($_FILES["file"]["tmp_name"][$x], "../sounds/" . $_FILES["file"]["name"][$x]);
  $success = TRUE;
        }   
    }
}

if ($success) {
    echo "<div class=\"row\"><hr><br><h4 style=\"font-size: 200%\"><center>Upload Success!</center></h4></div>";
 include("./index.php");   
}
?>




