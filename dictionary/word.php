<?php

$_SESSION['word'] = $_GET['word'];

$word =  $_SESSION['word'];

$xmlDoc = new DOMDocument();
$xmlDoc->load("dictionary.xml");
$xpath = new DOMXPath($xmlDoc);

$result = $xpath->query("/dictionary/entry/sense/cit[usg='$word']/../..");  

$table = "";

foreach($result as $entry) {
    
$id = $entry->getAttribute('id');
    
$hyper = $entry->childNodes->item(3)->childNodes->item(1)->childNodes->item(1)->nodeValue;
    
$pomo = $entry->childNodes->item(1)->childNodes->item(1)->nodeValue;
    
$eng = $entry->childNodes->item(3)->childNodes->item(1)->childNodes->item(3)->nodeValue;

$pos = $entry->childNodes->item(5)->childNodes->item(1)->nodeValue;    

$note = $entry->childNodes->item(7)->nodeValue;      
    
$media = $entry->childNodes->item(9)->getAttribute('url');
    
$count = 0;

$examples = "";
$polysemy = $xpath->query("/dictionary/entry/form[orth='$pomo']/..")->length;  

$len = strlen($pomo) -1;
$len1 = strlen($hyper) -1;
$len2 = strlen($hyper);

$xmlDoc = new DOMDocument();
$xmlDoc->load("../phrasicon/phrasicon.xml");
$xpath = new DOMXPath($xmlDoc);

    
if ($polysemy > 1) {

$p = false;
$e = false;
    
$count += $xpath->query("//phrase[starts-with(source, '".$pomo." ')]")->length;    
$count += $xpath->query("//phrase[contains(source, ' ".$pomo." ')]")->length;    
$count += $xpath->query("//phrase[(substring(source, string-length(translation) - $len) = '".$pomo."')]")->length; 
$count += $xpath->query("//morpheme[m='".$pomo."']")->length;

if ($count > 0) {
    $p = true;
}

$count = 0;    

$count += $xpath->query("//phrase[starts-with(translation, '$hyper')]")->length;   
$count += $xpath->query("//phrase[contains(translation, ' $hyper ')]")->length;    
$count += $xpath->query("//phrase[(substring(translation, string-length(translation) - ".$len1.") = '".$hyper."')]")->length;
$count += $xpath->query("//phrase[(substring(translation, string-length(translation) - ".$len2.") = '".$hyper."?')]")->length;
$count += $xpath->query("//phrase[(substring(translation, string-length(translation) - ".$len2.") = '".$hyper.".')]")->length; 
$count += $xpath->query("(//gloss[g='$hyper'])")->length;       

if ($count > 0) {
    $e = true;
}

if ($p and $e) {
    $count = 1;   
}
    
} else {

$count += $xpath->query('//phrase[starts-with(source, "'.$pomo.' ")]')->length; 
$count += $xpath->query('//phrase[contains(source,  " '.$pomo.' ")]')->length;    
$count += $xpath->query('//phrase[(substring(source, string-length(translation) - $len) = "'.$pomo.'")]')->length; 
$count += $xpath->query('//morpheme[m="'.$pomo.'"]')->length;
}

    
if ($count > 0) {
    if ($polysemy > 1) {
                $examples .= "<tr><td colspan=\"2\"><center><a href=\"../phrasicon/word.php?word=" . $pomo . "&eng=" . $eng . "&lang=poly\">Example phrases (phrasicon)</a></center></td></tr>";

} else {
            $examples .= "<tr><td colspan=\"2\"><center><a href=\"../phrasicon/word.php?word=" . $pomo . "&lang=pomo\">Example phrases (phrasicon)</a></center></td></tr>";

    }
    
}
    
$table = $table . "<a name=\"" . $id ."\"><table align=\"center\" width=\"300px\"><tr><td class=\"english\"colspan=\"2\"><center>" . $eng . "</center></td></tr>"
        . "<tr><td class=\"pomo\" colspan=\"2\"><center>" . $pomo . "</center></td></tr>"
        . "<tr class=\"body\">"
        . "<td valign=\"top\" class=\"description\"><center><em>" . $pos . "</center></em></td><td class=\"description\">"
        . $note . "</td></tr>" . $examples 
        . "<tr class=\"space\"><td colspan=\"2\"><audio width=\"300px\" src=\"../dictionary/sounds/" . $media . "\" controls preload=\"auto\" autobuffer></audio></td></tr></table></a>";
    
}

?> 

<!DOCTYPE html>
<html class="no-js" lang="en">
  
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dictionary Template</title>
    <link rel="stylesheet" href="css/foundation.css" />
    <script src="js/vendor/modernizr.js"></script> 
  </head>
    
  <body>

 <div class="fixed">
        <nav class="top-bar" data-topbar>
            <ul class="title-area">

                <li class="name">
                    <h1>
                  <a href="../">
                    Back to Main Menu
                  </a>
                </h1>
                </li>
                <li class="toggle-topbar menu-icon"><a href="#"><span>menu</span></a>
                </li>
            </ul>

            <section class="top-bar-section">

                <ul class="right">
                    <li class="divider"></li>
                    <li>
                        <a href="../phrasicon">Phrasicon</a>

                    </li>
                    <li class="divider"></li>
                </ul>
            </section>
        </nav>
    </div>
    <div class="row">
    <div class="large-12 columns">    
        
        <hr>
        <h4 class="title"><a class="home" href="../dictionary/">Online Talking Dictionary Template</a></h4>
        
        <hr>
        <h4 class="subsubheader">English to Source</h4>
        
        <ul class="pagination"> <center>
          <li><a href="../dictionary/category.php?letter=a">a</a></li> 
          <li><a href="../dictionary/category.php?letter=b">b</a></li> 
          <li><a href="../dictionary/category.php?letter=c">c</a></li> 
          <li><a href="../dictionary/category.php?letter=d">d</a></li> 
          <li><a href="../dictionary/category.php?letter=e">e</a></li> 
          <li><a href="../dictionary/category.php?letter=f">f</a></li> 
          <li><a href="../dictionary/category.php?letter=g">g</a></li> 
          <li><a href="../dictionary/category.php?letter=h">h</a></li> 
          <li><a href="../dictionary/category.php?letter=i">i</a></li> 
          <li><a href="../dictionary/category.php?letter=j">j</a></li> 
          <li><a href="../dictionary/category.php?letter=k">k</a></li> 
          <li><a href="../dictionary/category.php?letter=l">l</a></li> 
          <li><a href="../dictionary/category.php?letter=m">m</a></li> 
          <li><a href="../dictionary/category.php?letter=n">n</a></li> 
          <li><a href="../dictionary/category.php?letter=o">o</a></li> 
          <li><a href="../dictionary/category.php?letter=p">p</a></li> 
          <li><a href="../dictionary/category.php?letter=q">q</a></li> 
          <li><a href="../dictionary/category.php?letter=r">r</a></li> 
          <li><a href="../dictionary/category.php?letter=s">s</a></li> 
          <li><a href="../dictionary/category.php?letter=t">t</a></li> 
          <li><a href="../dictionary/category.php?letter=u">u</a></li> 
          <li><a href="../dictionary/category.php?letter=v">v</a></li> 
          <li><a href="../dictionary/category.php?letter=w">w</a></li> 
          <li><a href="../dictionary/category.php?letter=x">x</a></li> 
          <li><a href="../dictionary/category.php?letter=y">y</a></li> 
          <li><a href="../dictionary/category.php?letter=z">z</a></li></center>
        </ul>
        
        <div class="row collapse"> 
        <div class="large-8 small-9 columns"> 
            <form action="../dictionary/category.php" method="post">
            <input type="text" placeholder="Type English word..." name="word">
			<!--&nbsp;<input id="checkbox1" name="match" type="checkbox" value="match" checked><label for="checkbox1">Match whole word only</label>-->
        </div> 
        <div class="large-4 small-3 columns"> 
          <input class="button postfix" type="submit" value="Submit">
            </form>
        </div> 
        </div>
        
     
        <p><img src="background.jpg"/></p>  
  
        <?php echo $table ?>
    </div>
    </div>
      
      
    <footer class="row">
    <div class="large-12 columns">
        <hr>
        <div class="row">
        <div class="large-12 columns">
        <h4 class="subsubheader" style="text-align:center">Copyright 2014 &copy; User</h4><br>
        </div>
        </div>
    </div> 
    </footer> 
      
      <script src="js/vendor/jquery.js"></script>
    <script src="js/foundation/foundation.js"></script>
    <script>
        $(document).foundation();

        var doc = document.documentElement;
        doc.setAttribute('data-useragent', navigator.userAgent);
    </script>
  </body>
    
</html>