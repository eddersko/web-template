<?php

$count = 0;
$counting = TRUE;
$word = $_POST['word'];
$lang = $_POST['lang'];
if ($word == null && $lang == null) {
    $word = $_GET['word'];
$lang = $_GET['lang'];
$eng = $_GET['eng'];
    $counting = FALSE;
}

$words = split (' ', $word);
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
$len1 = strlen($word) - 1;
$len2 = strlen($word);

$xmlDoc = new DOMDocument();
$xmlDoc->load("phrasicon.xml");
$xpath = new DOMXPath($xmlDoc); 

if ($lang == 'eng') {
    
$cWord = ucfirst($word);
    
$result = $xpath->query('(//phrase[starts-with(translation, "'.$word.' ")]) | (//phrase[starts-with(translation, "'.$cWord.' ")]) | 
(//phrase[contains(translation, " '.$word.' ")]) | (//phrase[(substring(translation, string-length(translation) - '.$len1.') = "'.$word.'")]) | (//phrase[(substring(translation, string-length(translation) - '.$len2.') = "'.$word.'?")]) | (//phrase[(substring(translation, string-length(translation) - '.$len2.') = "'.$word.'.")]) | (//phrase/gloss[g="'.$word.'"]/..)');

    
} else {
    
$len = strlen($word) - 1;

$result = $xpath->query('(//phrase[starts-with(source, "'.$word.' ")]) | (//phrase[contains(source, " '. $word .' ")]) | (//phrase[substring(source, string-length(source) - '.$len.') = "'.$word.'"]) | (//phrase/morpheme[m="'.$word.'"]/..)');    

} 

$table = "";

foreach($result as $entry) {

$source = $entry->childNodes->item(3)->nodeValue;
$english = $entry->childNodes->item(9)->nodeValue;
$media = $entry->childNodes->item(11)->getAttribute('url');
$count++;

/*

$length = $entry->childNodes->item(13)->childNodes->length;

$extraAnno1 = array();

for ($x=1; $x<$length-1; $x+=2) {
  $val = $entry->childNodes->item(13)->childNodes->item($x)->nodeValue;

array_push($extraAnno1, $val);
}

$extra = "<tr>";

$num = count($extraAnno1);
foreach($extraAnno1 as $ex) {
    $extra_cells .= "<td class=\"pomo_gloss\">";
    $extra_cells .= $ex;  
    $extra_cells .= "</td>";
}
  

*/
    
    
$length = $entry->childNodes->item(5)->childNodes->length;

$source_example = array();

for ($x=1; $x<$length-1; $x+=2) {
  $val = $entry->childNodes->item(5)->childNodes->item($x)->nodeValue;

array_push($source_example, $val);
}

$source_cells = "<tr>";

$num = count($source_example);
foreach($source_example as $pom) {
    $source_cells .= "<td class=\"pomo_gloss\">";
    $source_cells .= $pom;  
    $source_cells .= "</td>";
}
  
$length = $entry->childNodes->item(7)->childNodes->length;

$eng_example = array(); 

for ($x=1; $x<$length-1; $x+=2) {
$val = $entry->childNodes->item(7)->childNodes->item($x)->nodeValue;
array_push($eng_example, $val);
}


$eng_num = count($eng_example);

$eng_cells = "";

foreach($eng_example as $eng) {
    $eng_cells .= "<td class=\"eng_gloss\">";
    $eng_cells .= $eng;  
    $eng_cells .= "</td>";
}

if ($eng_num > $num) {
    $num = $eng_num;   
}

$table = $table . "<table align=\"center\"><tr><td class=\"pomo\" colspan=\"". $num ."\"><center>" . $pomo . "</center></td></tr>" . /* $exttraAnno1 . "</tr>" .  */ $pomo_cells . "</tr>" . $eng_cells . "</tr>" . "<tr><td class=\"english\" colspan=\"" . ($num) . "\"><em><center>" . $english . "</em></center></td></tr><tr><td colspan=\"" . ($num) . "\"><audio src=\"../phrasicon/sounds/" . $media . "\" controls preload=\"auto\" autobuffer></audio></td></tr></table>";
}

$results = "";
if ($count == 0) {
$results .= "<h4 class=\"subsubheader\">No results found.</h4>";
} elseif ($count == 1 && $counting) {
    $results .= "<h4 class=\"subsubheader\"><b>1</b> search result found.</h4>";
} elseif ($counting) {
    $results .= "<h4 class=\"subsubheader\"><b>". $count . "</b> search results found.</h4>";
}

?> 

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>Phrasicon Template</title>
    <meta name="description" content="Multi-layered Language Learning Resources" />
    <meta name="author" content="User" />
    <meta name="copyright" content="User" />
    <link rel="stylesheet" href="css/foundation.css" />
    <script src="js/vendor/modernizr.js"></script>
    <script src="js/loadxmldoc.js"></script>
</head>

<body>

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
                <li class="toggle-topbar menu-icon"><a href="#"><span>menu</span></a>
                </li>
            </ul>

            <section class="top-bar-section">

                <ul class="right">
                    <li class="divider"></li>
                    <!-- Link to Dictionary. -->
                    <li class="name">
                        <h1>
                <a href="../dictionary">Online Talking Dictionary</a>
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
            <!-- Title of Page. -->

            <h4 class="title"><a class="home" href="../phrasicon/">Online Phrasicon Template</a></h4>

            <hr>
            <!-- Search Menu (title) -->
            <h4 class="subsubheader">English Word Lookup</h4>

            <!-- Search Menu (A-Z) -->
            <ul class="pagination">
                <center>
                    <li><a href="../phrasicon/category.php?letter=a&lang=eng">a</a>
                    </li>
                    <li><a href="../phrasicon/category.php?letter=b&lang=eng">b</a>
                    </li>
                    <li><a href="../phrasicon/category.php?letter=c&lang=eng">c</a>
                    </li>
                    <li><a href="../phrasicon/category.php?letter=d&lang=eng">d</a>
                    </li>
                    <li><a href="../phrasicon/category.php?letter=e&lang=eng">e</a>
                    </li>
                    <li><a href="../phrasicon/category.php?letter=f&lang=eng">f</a>
                    </li>
                    <li><a href="../phrasicon/category.php?letter=g&lang=eng">g</a>
                    </li>
                    <li><a href="../phrasicon/category.php?letter=h&lang=eng">h</a>
                    </li>
                    <li><a href="../phrasicon/category.php?letter=i&lang=eng">i</a>
                    </li>
                    <li><a href="../phrasicon/category.php?letter=j&lang=eng">j</a>
                    </li>
                    <li><a href="../phrasicon/category.php?letter=k&lang=eng">k</a>
                    </li>
                    <li><a href="../phrasicon/category.php?letter=l&lang=eng">l</a>
                    </li>
                    <li><a href="../phrasicon/category.php?letter=m&lang=eng">m</a>
                    </li>
                    <li><a href="../phrasicon/category.php?letter=n&lang=eng">n</a>
                    </li>
                    <li><a href="../phrasicon/category.php?letter=o&lang=eng">o</a>
                    </li>
                    <li><a href="../phrasicon/category.php?letter=p&lang=eng">p</a>
                    </li>
                    <li><a href="../phrasicon/category.php?letter=q&lang=eng">q</a>
                    </li>
                    <li><a href="../phrasicon/category.php?letter=r&lang=eng">r</a>
                    </li>
                    <li><a href="../phrasicon/category.php?letter=s&lang=eng">s</a>
                    </li>
                    <li><a href="../phrasicon/category.php?letter=t&lang=eng">t</a>
                    </li>
                    <li><a href="../phrasicon/category.php?letter=u&lang=eng">u</a>
                    </li>
                    <li><a href="../phrasicon/category.php?letter=v&lang=eng">v</a>
                    </li>
                    <li><a href="../phrasicon/category.php?letter=w&lang=eng">w</a>
                    </li>
                    <li><a href="../phrasicon/category.php?letter=x&lang=eng">x</a>
                    </li>
                    <li><a href="../phrasicon/category.php?letter=y&lang=eng">y</a>
                    </li>
                    <li><a href="../phrasicon/category.php?letter=z&lang=eng">z</a>
                    </li>
                </center>
            </ul>


            <div class="row collapse">
                <div class="large-2 small-4 columns">
                    <form name="form1" action="../phrasicon/word.php" method="post">

                        <!-- Language Options -->
                        <select name="lang">
                            <option value="english">English</option>
                            <option value="pomo">Source</option>
                        </select>
                </div>



                <div class="large-6 small-4 columns">
                    <!-- Search bar. -->
                    <input type="text" placeholder="<?php echo $word ?>" name="word">

                </div>
                <div class="large-3 small-2 columns">
                    <!-- Submit button. -->
                    <input class="button postfix" type="submit" value="Submit">
                    </form>
                </div>
                <div class="large-1 small-2 columns">

                    <!-- Drop down menu for special characters. -->
                    <a class="button dropdown postfix" data-dropdown="drop"></a>
                    <ul id="drop" class="f-dropdown" data-dropdown-content>
                        <li><a onmouseover="showtip(this,event,'U02B0')" onmouseout=hidetip() href="javascript:;" onclick="form1.word.value=form1.word.value + 'ʔ';">ʔ</a> </li>
                    </ul>
                </div>

            </div>

            <!-- Picture here. -->
            <p><img src="background_phrasicon.jpg" />
            </p>

            <!-- Search results here. -->
            <?php echo $results ?>
            <br>
            <?php echo $table ?>
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