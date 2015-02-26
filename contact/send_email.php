<?php

    /*
    * Author: Edwin Ko eddersko.com
    * This script is free software.
    */

if(isset($_POST['email'])) {
 
     
 
    // Your email goes here.
 
    $email_to = "enter email here";
      
 
    function died($error) {
 
        // your error code can go here
 
        echo "We are very sorry, but there were error(s) found with the form you submitted. ";
 
        echo "These errors appear below.<br /><br />";
 
        echo $error."<br /><br />";
 
        echo "Please go back and fix these errors.<br /><br />";
 
        die();
 
    }
 
     
 
    // validation expected data exists
 
    if(!isset($_POST['name']) ||
 
        !isset($_POST['email']) ||
 
        !isset($_POST['message'])) {
 
        died('We are sorry, but there appears to be a problem with the form you submitted.');      
 
    }
 
     
 
    $name = $_POST['name']; // required
 
    $email_from = $_POST['email']; // required
  
    $message = $_POST['message']; // required
 
     
 
    $error_message = "";
 
    $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';
 
  if(!preg_match($email_exp,$email_from)) {
 
    $error_message .= 'The email address you entered does not appear to be valid.<br />';
 
  }
 
    $string_exp = "/^[A-Za-z .'-]+$/";
 
  if(!preg_match($string_exp,$name)) {
 
    $error_message .= 'The name you entered does not appear to be valid.<br />';
 
  }
 
 
  if(strlen($message) < 2) {
 
    $error_message .= 'The message you entered do not appear to be valid.<br />';
 
  }
 
  if(strlen($error_message) > 0) {
 
    died($error_message);
 
  }
    
    // Email Body Message
    $email_message = "A new message has been sent from the Language Tools website...\n\n";
 
     
 
    function clean_string($string) {
 
      $bad = array("content-type","bcc:","to:","cc:","href");
 
      return str_replace($bad,"",$string);
 
    }
 
     
 
    $email_message .= "Name: ".clean_string($name)."\n\n";
  
    $email_message .= "Email: ".clean_string($email_from)."\n\n";
  
    $email_message .= "Message:\n".clean_string($message)."\n\n";
 
    // Email Subject Header 
    $email_subject = "Language Tools: New Message";

     
 
// create email headers
 
$headers = 'From: '.$email_from."\r\n".
 
'Reply-To: '.$email_from."\r\n" .
 
'X-Mailer: PHP/' . phpversion();
 
@mail($email_to, $email_subject, $email_message, $headers); 
 
?>
 
 
 
<!-- include your own success html here -->
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>Phrasicon Template</title>
    <meta name="description" content="Multi-layered Language Learning Resources" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="author" content="User" />
    <meta name="copyright" content="User" />
    <link rel="stylesheet" href="css/foundation.css" />
    <script src="js/vendor/modernizr.js"></script>
    <script src="js/loadxmldoc.js"></script>
</head>
<body>
<nav class="top-bar" data-topbar>
<ul class="title-area">
 
<li class="name">
<h1>
<a href="../">
Back to Menu
</a>
</h1>
</li>
</ul>
</nav>
 
 
<div class="row">
 
<div class="large-3 columns">
<br> 
<p>
<img src="../placeholder.png"><br/>
</p>

</div> 
<div class="large-9 columns">
    <br>

<h5>Thank you for contacting us. We will be in touch with you very soon!</h5>

</div>
 
</div> 

<script src="js/vendor/jquery.js"></script>
<script src="js/foundation/foundation.js"></script>
<script>
      $(document).foundation();

      var doc = document.documentElement;
      doc.setAttribute('data-useragent', navigator.userAgent);
    </script>
<script type="text/javascript">
/* <![CDATA[ */
(function(){try{var s,a,i,j,r,c,l=document.getElementsByTagName("a"),t=document.createElement("textarea");for(i=0;l.length-i;i++){try{a=l[i].getAttribute("href");if(a&&"www.cloudflare.com/email-protection"==a.substr(7 ,35)){s='';j=43;r=parseInt(a.substr(j,2),16);for(j+=2;a.length-j&&a.substr(j,1)!='X';j+=2){c=parseInt(a.substr(j,2),16)^r;s+=String.fromCharCode(c);}j+=1;s+=a.substr(j,a.length-j);t.innerHTML=s.replace(/</g,"&lt;").replace(/>/g,"&gt;");l[i].setAttribute("href","mailto:"+t.value);}}catch(e){}}}catch(e){}})();
/* ]]> */
</script>
</body>
 
 
<?php
 
}
 
?>