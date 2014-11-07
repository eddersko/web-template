<?php
$user = $_POST['user'];
$pass = $_POST['pass'];

if($user == "123"
&& $pass == "abc")
{
        include("../insertion.php");
}
else
{
    if(isset($_POST))
    {?>
<hml>
    <head>            <link rel="stylesheet" href="../css/foundation.css" />

    <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
    <title>Phrasicon Template</title>    </head>
<body>

    <div class="row">
            <div class="large-12 columns">    
    <hr>
                        <h4 class="title">Online Phrasicon Data Entry</h4>
                <hr>
            <form method="POST" action="index.php">
            Username <input type="text" name="user" placeholder='123' ></input><br/>
            Password <input type="password" name="pass" placeholder='abc'></input><br/>
            <input class="radius button expand" type="submit" value="Submit">
            </form>
</div></div>

<br><br>
</body></html>
    <?}
}
?>