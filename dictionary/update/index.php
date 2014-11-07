<?php
$user = $_POST['user'];
$pass = $_POST['pass'];

if($user == "abc"
&& $pass == "123")
{
        include("../insert.php");
}
else
{
    if(isset($_POST))
    {?>
<hml>
    <head>            <link rel="stylesheet" href="../css/foundation.css" />

    <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
    <title>Online Talking Dictionary Template</title>    </head>
<body>

    <div class="row">
            <div class="large-12 columns">    
    <hr>
                        <h4 class="title">Talking Dictionary Data Entry</h4>
                <hr>
            <form method="POST" action="index.php">
            Username <input type="text" name="user" placeholder='abc' ></input><br/>
            Password <input type="password" name="pass" placeholder='123'></input><br/>
            <input class="radius button expand" type="submit" value="Submit">
            </form>
</div></div>

<br><br>
</body></html>
    <?}
}
?>