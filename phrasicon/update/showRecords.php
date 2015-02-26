<?php

    /*
    * Author: Edwin Ko eddersko.com
    * This script is free software.
    */

$english = $_GET['english'];

$xmlDoc = new DOMDocument();
$xmlDoc->load("../phrasicon.xml");
$xpath = new DOMXPath($xmlDoc);
$result = $xpath->query("(//gloss[starts-with(g, '$english')]/..) | (//phrase[contains(translation, '$english')])");

echo "<table>
<tr>
<th>ID</th>
<th>Reference</th>";

// Source
echo "<th>Source</th>";

echo "<th>Morpheme</th>
<th>Gloss</th>
<th>Translation</th>
<th>Media</th>";


// This is where you add annotation layers. 
 
// ExtraAnno1
//echo "<th>ExtraAnno1</th>";

// ExtraAnno2
// echo "<th>ExtraAnno2</th>";

// ExtraAnno3
// echo "<th>ExtraAnno3</th>";

// ExtraAnno4
// echo "<th>ExtraAnno4</th>";

// ExtraAnno5
// echo "<th>ExtraAnno5</th>";


echo "</tr>";


foreach($result as $entry) {
echo "<tr class=\"even\">";
    
$id = $entry->getAttribute('id');
echo "<td>" . $id . "</td>";
    
$ref = $entry->childNodes->item(1)->nodeValue;
echo "<td>" . $ref . "</td>";
    
$pomo = $entry->childNodes->item(3)->nodeValue;
echo "<td>" . $pomo . "</td>";


$length = $entry->childNodes->item(5)->childNodes->length;

$pomo_example = array();

for ($x=1; $x<$length-1; $x+=2) {
  $val = $entry->childNodes->item(5)->childNodes->item($x)->nodeValue;

array_push($pomo_example, $val);
}

echo "<td>";

echo implode(' ',$pomo_example);
    
echo "</td>";
  
$length = $entry->childNodes->item(7)->childNodes->length;

$eng_example = array();

for ($x=1; $x<$length-1; $x+=2) {
$val = $entry->childNodes->item(7)->childNodes->item($x)->nodeValue;
array_push($eng_example, $val);
}

echo "<td>";

echo implode(' ',$eng_example);
    
echo "</td>";  
    
    
$english = $entry->childNodes->item(9)->nodeValue;

echo "<td>" . $english . "</td>";

    
$media = $entry->childNodes->item(11)->getAttribute('url');;

    echo "<td>" . $media . "</td>";

// This is where you add annotation layers. 
    
// ExtraAnno1

/*
    
$length = $entry->childNodes->item(13)->childNodes->length;

$extraAnno1 = array();

for ($x=1; $x<$length-1; $x+=2) {
$val = $entry->childNodes->item(13)->childNodes->item($x)->nodeValue;
array_push($extraAnno1, $val);
}

echo "<td>";

echo implode(' ',$extraAnno1);
    
echo "</td>";  

*/

// ExtraAnno2

/*

$length = $entry->childNodes->item(15)->childNodes->length;

$extraAnno2 = array();

for ($x=1; $x<$length-1; $x+=2) {
$val = $entry->childNodes->item(15)->childNodes->item($x)->nodeValue;
array_push($extraAnno2, $val);
}

echo "<td>";

echo implode(' ',$extraAnno2);
    
echo "</td>";  
    
*/
    
// ExtraAnno3

/*

$length = $entry->childNodes->item(17)->childNodes->length;

$extraAnno3 = array();

for ($x=1; $x<$length-1; $x+=2) {
$val = $entry->childNodes->item(17)->childNodes->item($x)->nodeValue;
array_push($extraAnno3, $val);
}

echo "<td>";

echo implode(' ',$extraAnno3);
    
echo "</td>";  
    
*/

// ExtraAnno4
    
/*

$length = $entry->childNodes->item(19)->childNodes->length;

$extraAnno4 = array();

for ($x=1; $x<$length-1; $x+=2) {
$val = $entry->childNodes->item(19)->childNodes->item($x)->nodeValue;
array_push($extraAnno4, $val);
}

echo "<td>";

echo implode(' ',$extraAnno4);
    
echo "</td>";  
    

*/

// ExtraAnno5

/*

$length = $entry->childNodes->item(21)->childNodes->length;

$extraAnno5 = array();

for ($x=1; $x<$length-1; $x+=2) {
$val = $entry->childNodes->item(21)->childNodes->item($x)->nodeValue;
array_push($extraAnno5, $val);
}

echo "<td>";

echo implode(' ',$extraAnno5);
    
echo "</td>";  
    

*/
    
    
  echo "</tr>";

}

echo "</table>";
?> 