<?php

    /*
    * Author: Edwin Ko eddersko.com
    * This script is free software.
    */

$placeholder = "Type word...";
$lang = $_POST['lang'];

$_SESSION['letter'] = $_POST['word'];

$list = "<div class=\"three-columns\"><ul class=\"no-bullet\">";
$count = 0;

$xmlDoc = new DOMDocument();
$xmlDoc->load("dictionary.xml");
$xpath = new DOMXPath($xmlDoc);

// if user selected a letter
if ($_SESSION['letter'] == null) {

$_SESSION['letter'] = $_GET['letter'];
$letter =  $_SESSION['letter'];

$a = array();
$syn = array();
$result = $xpath->query("//entry");    

if ($lang != "source") {    

foreach($result as $entry) {

$id = $entry->getAttribute('id');
$hyper = $entry->childNodes->item(3)->childNodes->item(1)->childNodes->item(1)->nodeValue;
$eng = $entry->childNodes->item(3)->childNodes->item(1)->childNodes->item(3)->nodeValue;

// if English headword begins with letter...
if ((fnmatch($letter."*",$eng) or fnmatch(strtoupper($letter)."*",$eng)) and ($eng != $hyper)) {

// store the English headword in id index
$a += array($eng => $id);
$count++;

// or if hypernym begins with letter...
} elseif ( (! in_array($hyper, $syn) ) and (fnmatch($letter."*",$hyper) or fnmatch(strtoupper($letter)."*",$hyper))) {

// store the hypernym in first index
$a += array($hyper => 0);
$count++;
$new_word = $hyper;
array_push($syn, $hyper);
}
}

// sort array alphabetically
uksort($a, "strnatcasecmp");

// grab the English headword, hypernym and id - puts as links on page
// $k is the hypernym
// $ident is the id
// $key is the English headword/hypernym
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
    
$result = $xpath->query('//entry/form[starts-with(orth, "' . $letter .'")]/..');   

$a = array();
    
foreach($result as $entry) {

$pomo = $entry->childNodes->item(1)->childNodes->item(1)->nodeValue;

array_push($a, $pomo);

}

$a = array_unique($a);
$count = sizeof($a);
sort($a);
    
foreach ($a as $pomo) {
    $list = $list . "<li><a href=\"../dictionary/word.php?word=" . $pomo . "&lang=pomo\">" . $pomo . "</a></li>";
}
        
    
}
    
// if user searches via search bar
} else {

$counting = TRUE;  
$new_word = "";
$placeholder = $_POST['word'];
$word = $_SESSION['letter'];
$word = rtrim($word, " ");


// turn off couunt if user enters nothing into search bar
if ($placeholder == "") {
    $counting = FALSE;   
}

if ($lang == "english") {    

// if user selects 'Extended Search'
if ($_POST['stemmer'] == 'YES') {
    $counting = FALSE;
    include('porterstemmer.php');
    $word = PorterStemmer::Stem($_POST['word']);
} 

$is_adj = FALSE;

// if the word searched is less than or equal to three characters long
// heuristic: the less characters the word contains, the higher the probability that
// a headword begins with those combinations of letters.
// eg. there are more words that beging with 'a' than those that begin with 'ac'
// and even less words that begin with 'act'.    
if (strlen($word) <= 3) {
    
$result = $xpath->query("/dictionary/entry/sense/cit[quote='$word']/../.. | /dictionary/entry/sense/cit[starts-with(quote, '$word ')]/../.. | //usg[text() = '$word']/../../..");    

// retrieve part of speech to check if adjective
$pos = $xpath->query("/dictionary/entry/sense/cit[quote='$word']/../../gramGrp/pos"); 

foreach($pos as $tag) {
    // if your encoding for adjective is different, please make the necessary changes
    if ($tag->nodeValue == 'adjective' | $tag->nodeValue == 'adj' | $tag->nodeValue == 'adj.' | $tag->nodeValue == 'ADJ' ) {
        $is_adj = TRUE;
        break;
    }
}

// if the word entered is an adjective
if ($is_adj) {

// search for words that start with the characters...
$result = $xpath->query("/dictionary/entry/sense/cit[quote='$word']/../.. | /dictionary/entry/sense/cit[starts-with(quote, '$word')]/../.. | //usg[text() = '$word']/../../..");    
}

// if word has more than 3 characters
} else {

$len = strlen($word);

$result = $xpath->query("/dictionary/entry/sense/cit[quote='$word']/../.. | /dictionary/entry/sense/cit[starts-with(quote, '$word')]/../.. | //usg[text() = '$word']/../../.. | /dictionary/entry/sense/cit[contains(quote, ' $word ')]/../.. | /dictionary/entry/sense/cit[(substring(quote, string-length(quote) - $len) = ' $word') and (not(starts-with(quote, '$word')))]/../..");    
    
}
   
$current = array();

// display a list of links to the entries page
foreach($result as $entry) {
$id = $entry->getAttribute('id');
$hyper = $entry->childNodes->item(3)->childNodes->item(1)->childNodes->item(1)->nodeValue;
$eng = $entry->childNodes->item(3)->childNodes->item(1)->childNodes->item(3)->nodeValue;
        array_push($current, $eng); 
        $list = $list . "<li><a href=\"../dictionary/word.php?word=" . $hyper. "#" . $id . "\">" . $eng . "</a></li>";
        $new_word = $hyper;
        $count++;
}

} else {
    
$len = strlen($word);
$lenA = strlen($word) -1;
$lenB = strlen($word) -2;

if ($len <= 3) {

$result = $xpath->query("/dictionary/entry/form[orth=\"".$word."\"]/.. | /dictionary/entry/form[(substring(orth, string-length(orth) - $len) = \" ". $word."\")]/.. ");    
    
} else {

$result = $xpath->query("/dictionary/entry/form[orth=\"".$word."\"]/.. | /dictionary/entry/form[starts-with(orth, \"".$word."\")]/.. | /dictionary/entry/form[(substring(orth, string-length(orth) - $len) = \" ". $word."\")]/.. | /dictionary/entry/form[(substring(orth, string-length(orth) - $lenA) = \" ". $word."\")]/..  | /dictionary/entry/form[(substring(orth, string-length(orth) - $lenB) = \" ". $word."\")]/..  "); 

}
    

$a = array();
    
foreach($result as $entry) {

$source = $entry->childNodes->item(1)->childNodes->item(1)->nodeValue;

array_push($a, $source);

}

$a = array_unique($a);
$count = sizeof($a);
sort($a);
    
foreach ($a as $source) {
    $list = $list . "<li><a href=\"../dictionary/word.php?word=" . $source . "&lang=source\">" . $source . "</a></li>";
    $new_word = $source;
}
 
}
    
}

$list .= "</ul>";

$redirect = "";
$num_results = "";

// if only one result found, direct to entry page
// delete if not desired
if ($count == 1 && $lang != "source") {
 $redirect .= "<meta http-equiv=\"refresh\" content=\"0; url=../dictionary/word.php?word=". $new_word . "#" . $id . "\"/>";   
 $num_results = $num_results . "<h4 class=\"subsubheader\"><b>" . $count . "</b> search result found.</h4>"; 
} 
  
if ($count == 1 && $lang == "source" && $counting) {
 $redirect .= "<meta http-equiv=\"refresh\" content=\"0; url=../dictionary/word.php?word=". $new_word . "&lang=source\"/>";   
 $num_results = $num_results . "<h4 class=\"subsubheader\"><b>" . $count . "</b> search result found.</h4>"; 
} 


$body = "<body>";

// show extended search if no results, and if user did not already choose extended search
if ($count == 0 && $counting && $lang != "source") {
 $list = "";
 $form = "<form id=\"myForm\" name=\"myForm\" action=\"../dictionary/category.php\" method=\"POST\">
<input type=hidden name=\"word\" value=\"$word\"/>
<input type=hidden name=\"stemmer\" value=\"YES\"/>
<input name=\"submit\" class=\"button postfix\" type=\"submit\"  value=\"Sure!\"/>
</form>";
 $warning = "<h4 class=\"subsubheader\">No results found.</h4><h4 class=\"subsubheader\">Try an extended search?</h4>";
// if more than one results found
} elseif ($count > 1 && $counting) {
    $num_results = $num_results . "<h4 class=\"subsubheader\"><b>" . $count . "</b> search results found.</h4><h4 class=\"subsubheader\">Each of these links will take you to a dictionary entry that contains the word you are searching for...</h4><br>"; 
// if user chose extended search and still no results
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
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
                <div class="large-2 small-3 columns">
                    <form name="form1" action="../dictionary/category.php" method="post">
                        <!-- Language options. -->
                        <select name="lang">
                            <option value="english">English</option>
                            <option value="source">Source</option>
                        </select>

                </div>

                <div class="large-6 small-4 columns">
                    <!-- Search bar. -->
                    <input type="text" placeholder="Type word..." name="word">

                </div>
                <div class="large-3 small-3 columns">
                    <!-- Submit button. -->
                    <input class="button postfix" type="submit" value="Submit">
                </div>
                <div class="large-1 small-2 columns">

                    <!-- Dropdown for special characters. -->
                    <a class="button dropdown postfix" data-dropdown="drop"></a>
                    <ul id="drop" class="f-dropdown" data-dropdown-content>
                        <li><a onmouseover="showtip(this,event,'U02B0')" onmouseout=hidetip() href="javascript:;" onclick="form1.word.value=form1.word.value + 'ʔ';">ʔ</a> 
                        </li>
                    </ul>

                </div>

            </div>
                    </form>
        
        <!-- Background image. -->
        <p><img src="background_dictionary.jpg"/></p>    
    
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
             <br>
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
