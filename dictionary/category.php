<?php

putenv('PYTHONPATH=/home2/northfz2/python/lib/python2.7/site-packages:');

$placeholder = "Type English word...";

$_SESSION['letter'] = $_POST['word'];


$list = "<div class=\"three-columns\"><ul class=\"no-bullet\">";
$count = 0;
  
$xmlDoc = new DOMDocument();
$xmlDoc->load("dictionary.xml");
$xpath = new DOMXPath($xmlDoc);

if ($_SESSION['letter'] == null) {
$_SESSION['letter'] = $_GET['letter'];
$letter =  $_SESSION['letter'];


// for every entry, grab the headword and the stems. the unique array it. 

$a = array();
$syn = array();
$result = $xpath->query("//entry");    

foreach($result as $entry) {

$id = $entry->getAttribute('id');
$stem = $entry->childNodes->item(3)->childNodes->item(1)->childNodes->item(1)->nodeValue;
$eng = $entry->childNodes->item(3)->childNodes->item(1)->childNodes->item(3)->nodeValue;



if ((fnmatch($letter."*",$eng) or fnmatch(strtoupper($letter)."*",$eng)) and ($eng != $stem)) {

$a += array($eng => $id);
$count++;
//$list = $list . "<li><a href=\"../dictionary/word.php?word=" . $stem . "#" . $id . "\">" . $eng . "</a></li>";
//$new_word = $eng;

} elseif ( (! in_array($stem, $syn) ) and (fnmatch($letter."*",$stem) or fnmatch(strtoupper($letter)."*",$stem))) {

$a += array($stem => 0);
$count++;
//$list = $list . "<li><a href=\"../dictionary/word.php?word=" . $stem. "\">" . $stem . "</a></li>";
    $new_word = $stem;
    array_push($syn, $stem);
}

}

uksort($a, "strnatcasecmp");

foreach ($a as $key => $val) {
    $ident = "";
    $k = $key;
    if ($val != 0) {
      $ident =  $ident . "#" . $val;
      $result = $xpath->query("//entry[@id = '$val']");
      foreach($result as $entry) {    
      $k = $entry->childNodes->item(3)->childNodes->item(1)->childNodes->item(1)->nodeValue;
    }
    }
    $list = $list . "<li><a href=\"../dictionary/word.php?word=" . $k . $ident . "\">" . $key . "</a></li>";
    $new_word = $val;
    $count++;
}
    

} else {

$counting = TRUE;
$new_word = "";
$placeholder = $_POST['word'];
$words = split (' ', $_SESSION['letter']);

$num = 0;
    
foreach($words as $w) {
  if ($w != "") {
      $num++;
  }
}


$word = "";
    
foreach($words as $w) {
    $word .= $w;
    if($num > 1) {
     $word .= " ";
     $num--;
    }
}

if ($_POST['lemmatize'] == 'YES') {
$word = exec('python lemmatize.py ' . $_POST['word']);
$counting = FALSE;
} 


$is_adj = FALSE;
    
if (strlen($word) <= 3) {
    
$result = $xpath->query("/dictionary/entry/sense/cit[quote='$word']/../.. | /dictionary/entry/sense/cit[starts-with(quote, '$word ')]/../..");    

$pos = $xpath->query("/dictionary/entry/sense/cit[quote='$word']/../../gramGrp/pos"); 

foreach($pos as $tag) {
    if ($tag->nodeValue == 'adjective') {
        $is_adj = TRUE;
        break;
    }
}

if ($is_adj) {
$result = $xpath->query("/dictionary/entry/sense/cit[quote='$word']/../.. | /dictionary/entry/sense/cit[starts-with(quote, '$word')]/../..");    
}
    
} else {
    
$result = $xpath->query("/dictionary/entry/sense/cit[quote='$word']/../.. | /dictionary/entry/sense/cit[starts-with(quote, '$word')]/../..");    
    
}
    
foreach($result as $entry) {
$id = $entry->getAttribute('id');
$stem = $entry->childNodes->item(3)->childNodes->item(1)->childNodes->item(1)->nodeValue;
$eng = $entry->childNodes->item(3)->childNodes->item(1)->childNodes->item(3)->nodeValue;

$list = $list . "<li><a href=\"../dictionary/word.php?word=" . $stem . "#" . $id . "\">" . $eng . "</a></li>";
$count++;
$new_word = $stem;
}

$result = array();
    
if ((strlen($word) > 3) || $is_adj) {    
    
$len = strlen($word);

$result = $xpath->query("(/dictionary/entry/sense/cit[(substring(quote, string-length(quote) - $len) = ' $word') and (not(starts-with(quote, '$word'))) and (quote != '$new_word')]/../..)"); 
}
foreach($result as $entry) {
$id = $entry->getAttribute('id');
$stem = $entry->childNodes->item(3)->childNodes->item(1)->childNodes->item(1)->nodeValue;
$eng = $entry->childNodes->item(3)->childNodes->item(1)->childNodes->item(3)->nodeValue;

    
    $list = $list . "<li><a href=\"../dictionary/word.php?word=" . $stem. "#" . $id . "\">" . $eng . "</a></li>";
    $new_word = $stem;
    $count++;
}
}
$list .= "</ul>";

$redirect = "";
$num_results = "";

    if ($count == 1) {
 $redirect .= "<meta http-equiv=\"refresh\" content=\"0; url=../dictionary/word.php?word=". $new_word . "#" . $id . "\"/>";   
 $num_results = $num_results . "<p><b>" . $count . "</b> search result found.</p>"; 
} 
    
 $body = "<body>";
if (($count == 0 && $counting)) {
 $list = "";
 $form = "<form id=\"myForm\" name=\"myForm\" action=\"../dictionary/category.php\" method=\"POST\">
<input type=hidden name=\"word\" value=\"$word\"/>
<input type=hidden name=\"lemmatize\" value=\"YES\"/>
<input name=\"submit\" class=\"button postfix\" type=\"submit\"  value=\"Sure!\"/>
</form>";
 $warning = "<h4 class=\"subsubheader\">No results found.</h4><h4 class=\"subsubheader\">Try an extended search?</h4><h4 class=\"subsubheader\"><em>Note: It'll take around 10 seconds.</em></h4>";
} elseif ($count > 1 && $counting) {
    $num_results = $num_results . "<h4 class=\"subsubheader\"><b>" . $count . "</b> search results found.</h4><h4 class=\"subsubheader\">Each of these links will take you to a dictionary entry that contains the word you are searching for...</h4><br>"; 

} elseif ($count == 0) {
     $list = "<h4 class=\"subsubheader\">No results found.</h4>";

}

?> 

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>Dictionary Template</title>
    <meta name="description" content="Multi-layered Language Learning Resources" />
    <meta name="author" content="User" />
    <meta name="copyright" content="User" />
    <link rel="stylesheet" href="css/foundation.css" />
    <script src="js/vendor/modernizr.js"></script>
    <script src="js/loadxmldoc.js"></script>
    <?php echo $redirect ?>
</head>
    
    <?php echo $body ?>
    
        <!-- Menu Bar. -->
    
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
              <li class="toggle-topbar menu-icon"><a href="#"><span>menu</span></a></li>
            </ul>
            <section class="top-bar-section">
              <ul class="right">
                <li class="divider"></li>
                <li class="name">
                    <h1>
                    <!-- Link to Phrasicon -->
                    <a href="../phrasicon">
                        Phrasicon
                        </a>
                    </h1>
                </li>
                <li class="divider"></li>
              </ul>
            </section>
          </nav>
        </div>
   
    <div class="row">
    <div class="large-12 columns">    
    
        <hr>

        <!-- Title of the page. -->
        
        <h4 class="title"><a class="home" href="../dictionary/">Online Talking Dictionary Template</a></h4>
        
        <hr>
        
        <!-- Search by letter (title).  -->
        
        <h4 class="subsubheader">English to Source</h4>

        
        <!-- Search by letter (A-Z).  -->
        
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
                
            <!-- Search bar. -->
            <input type="text" placeholder= "<?php echo $placeholder?>" name="word"> 

        </div> 
        <div class="large-4 small-3 columns"> 
        <!-- Submit Button. -->
          <input class="button postfix" type="submit" value="Submit">
            </form>
        </div> 
        </div>
        
        <!-- Background image. -->
        <p><img src="background.jpg"/></p>    
    
    </div>
    </div>
  
    <div class="row">
    <div class="large-12 columns">
    <div class="text-center">
        
        <!-- Search results. -->
        <?php echo $num_results ?>
        <?php echo $list ?>
        <?php echo $warning ?>
        <?php echo $form ?>
    </div>
    </div>
    </div>
    </div>

    <script src="js/vendor/jquery.js"></script>
    <script src="js/foundation/foundation.js"></script>
    <script>
        $(document).foundation();

        var doc = document.documentElement;
        doc.setAttribute('data-useragent', navigator.userAgent);
    </script>
  </body>
</html>
