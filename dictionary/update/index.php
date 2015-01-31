<?php
$user = $_POST['user'];
$pass = $_POST['pass'];

// Username and password
if($user == "abc"
&& $pass == "123")
{
        include("./interface.php");
}
else
{
    if(isset($_POST))
    {?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>Online Talking Dictionary Template</title>
    <meta name="description" content="Multi-layered Language Learning Resources" />
    <meta name="author" content="User" />
    <meta name="copyright" content="User" />
    <link rel="stylesheet" href="../css/foundation.css" />
</head>

    <body>
    <div class="large-4 columns">    
    <br>
    </div>
            <div class="large-4 columns">    
    <hr>
                        <h4 class="title">Dictionary Data Entry</h4>
                <hr>
            <form method="POST" action="index.php">
            <input type="text" name="user" placeholder='abc' ></input>
            <input type="password" name="pass" placeholder='123'></input>
            <input class="radius button expand" type="submit" value="Login">
            </form>
    </div>


        <br>
        <br>
    </body>

</html>
<?} } ?>