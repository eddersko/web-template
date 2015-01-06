<?php


$morpheme = $_GET['morpheme'];

$xmlDoc = new DOMDocument();
$xmlDoc->load("../phrasicon.xml");
$xpath = new DOMXPath($xmlDoc);
$result = $xpath->query("(//m[starts-with(., \"$morpheme\")])");
$a = array();

foreach($result as $entry) {

$id = $entry->getAttribute('id');
//echo $id;
$g = $xpath->query("(//g[@id = '$id'])");
$gloss = $g->item(0)->nodeValue;
$a[$gloss] += 1;
    
}
echo array_search(max($a), $a);
?>