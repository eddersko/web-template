<?php


$english = $_GET['english'];

$xmlDoc = new DOMDocument();
$xmlDoc->load("../phrasicon.xml");
$xpath = new DOMXPath($xmlDoc);
$result = $xpath->query("(//gloss[starts-with(g, '$english')]/..) | (//phrase[contains(translation, '$english')])");

echo "<table>
<tr>
<th>ID</th>
<th>Reference</th>
<th>Source</th>
<th>Morpheme</th>
<th>Gloss</th>
<th>Translation</th>
<th>Media</th>";

/* 
echo "<th>ExtraAnno1</th>";
*/

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

    
    
/*

$length = $entry->childNodes->item(7)->childNodes->length;

$extraAnno1 = array();

for ($x=1; $x<$length-1; $x+=2) {
$val = $entry->childNodes->item(13)->childNodes->item($x)->nodeValue;
array_push($extraAnno1, $val);
}

echo "<td>";

echo implode(' ',$extraAnno1);
    
echo "</td>";  
    

echo "<td>" . $extraAnno1 . "</td>";


*/
      
  echo "</tr>";

}

echo "</table>";
?> 