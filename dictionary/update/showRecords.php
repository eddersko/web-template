<?php

$english = $_GET['english'];

$xmlDoc = new DOMDocument();
$xmlDoc->load("../dictionary.xml");
$xpath = new DOMXPath($xmlDoc);

$result = $xpath->query("//entry/sense/cit[starts-with(quote, '$english')]/../..");
echo "<table>
<tr>
<th>ID</th>
<th>Hypernym</th>
<th>Northern Pomo</th>
<th>English</th>
<th>POS</th>
<th>Description</th>
<th>Media</th>
<th>Reference</th>
</tr>";


foreach($result as $entry) {

$id = $entry->getAttribute('id');
$hyper = $entry->childNodes->item(3)->childNodes->item(1)->childNodes->item(1)->nodeValue;
$pomo = $entry->childNodes->item(1)->childNodes->item(1)->nodeValue;
$eng = $entry->childNodes->item(3)->childNodes->item(1)->childNodes->item(3)->nodeValue;
$pos = $entry->childNodes->item(5)->childNodes->item(1)->nodeValue;    
$desc = $entry->childNodes->item(7)->nodeValue;  
$media = $entry->childNodes->item(9)->getAttribute('url');
$ref = $entry->childNodes->item(11)->nodeValue;

    
  echo "<tr>";
  echo "<td>" . $id . "</td>";
  echo "<td>" . $hyper . "</td>";
  echo "<td>" . $pomo . "</td>";
  echo "<td>" . $eng . "</td>";
  echo "<td>" . $pos . "</td>";
 echo "<td>" . $desc . "</td>";
  echo "<td>" . $media . "</td>";
 echo "<td>" . $ref . "</td>";

  echo "</tr>";
}
echo "</table>";

?> 