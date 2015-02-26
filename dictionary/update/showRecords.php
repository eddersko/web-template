<?php

    /*
    * Author: Edwin Ko eddersko.com
    * This script is free software.
    */

$english = $_GET['english'];

$xmlDoc = new DOMDocument();
$xmlDoc->load("../dictionary.xml");
$xpath = new DOMXPath($xmlDoc);

if ($english == " ") {
 
$result = $xpath->query("//entry");
    
} else {

$result = $xpath->query("//entry/sense/cit[starts-with(quote, '$english')]/../.. | //entry/sense/cit[starts-with(usg, '$english')]/../..");

}
    
echo "<table>
<tr>
<th>ID</th>
<th>Hypernym</th>";

// Source
echo "<th>Source</th>";

// English
echo "<th>English</th>";

echo "<th>POS</th>
<th>Description</th>
<th>Media</th>
<th>Reference</th>";

// This is where you add annotation layers. 
// Rename-able

// echo "<th>ExtraAnno1</th>";
// echo "<th>ExtraAnno2</th>";
// echo "<th>ExtraAnno3</th>";
// echo "<th>ExtraAnno4</th>";
// echo "<th>ExtraAnno5</th>";


echo "</tr>";


foreach($result as $entry) {

$id = $entry->getAttribute('id');
$hyper = $entry->childNodes->item(3)->childNodes->item(1)->childNodes->item(1)->nodeValue;
$source = $entry->childNodes->item(1)->childNodes->item(1)->nodeValue;
$eng = $entry->childNodes->item(3)->childNodes->item(1)->childNodes->item(3)->nodeValue;
$pos = $entry->childNodes->item(5)->childNodes->item(1)->nodeValue;    
$desc = $entry->childNodes->item(7)->nodeValue;  
$media = $entry->childNodes->item(9)->getAttribute('url');
$ref = $entry->childNodes->item(11)->nodeValue;
  
// This is where you add annotation layers. 

// $extraAnno1 = $entry->childNodes->item(13)->nodeValue; 
// $extraAnno2 = $entry->childNodes->item(15)->nodeValue; 
// $extraAnno3 = $entry->childNodes->item(15)->nodeValue; 
// $extraAnno4 = $entry->childNodes->item(17)->nodeValue; 
// $extraAnno5 = $entry->childNodes->item(21)->nodeValue; 
    
  echo "<tr>";
  echo "<td>" . $id . "</td>";
  echo "<td>" . $hyper . "</td>";
  echo "<td>" . $source . "</td>";
  echo "<td>" . $eng . "</td>";
  echo "<td>" . $pos . "</td>";
 echo "<td>" . $desc . "</td>";
  echo "<td>" . $media . "</td>";
 echo "<td>" . $ref . "</td>";

// This is where you add annotation layers. 

// echo "<td>" . $extraAnno1 . "</td>";
// echo "<td>" . $extraAnno2 . "</td>";
// echo "<td>" . $extraAnno3 . "</td>";
// echo "<td>" . $extraAnno4 . "</td>";
// echo "<td>" . $extraAnno5 . "</td>";

 echo "</tr>";
    
}
echo "</table>";

?> 