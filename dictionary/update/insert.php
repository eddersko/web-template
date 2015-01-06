<?php

$file = '../dictionary.xml';

$xml = simplexml_load_file($file);
$sxe = new SimpleXMLElement($xml->asXML());
$xmlDoc = new DOMDocument();
$xmlDoc->load($file);
$xpath = new DOMXPath($xmlDoc);

if ($_POST['type'] == 'create') {
$result = $xpath->query("/dictionary/entry[last()]");  
$id = ($result->item(0)->getAttribute('id')) + 1;

$entry = $sxe->addChild("entry");
$entry->addAttribute("id",$id);    
$form = $entry->addChild('form');
$form->addChild('orth', $_POST['orth']);
$sense = $entry->addChild('sense');
$cit = $sense->addChild('cit');
$cit->addAttribute("type", "translation");
$cit->addAttribute("lang", "en");
$usg = $cit->addChild('usg', $_POST['usg']);
$usg->addAttribute("type", "hyper");
$cit->addChild("quote", $_POST['quote']);
$gram = $entry->addChild("gramGrp");
$gram->addChild("pos", $_POST['pos']);
$entry->addChild('note', $_POST['note']);
$media = $entry->addChild('media');
$media->addAttribute("mimeType", "audio/".substr($_POST['media'], -3));
$media->addAttribute("url", $_POST['media']);
$entry->addChild("ref", $_POST['ref']);

// This is where you add annotation layers. 

//$entry->addChild("extraAnno1", $_POST['extraAnno1']);
//$entry->addChild("extraAnno2", $_POST['extraAnno2']);
//$entry->addChild("extraAnno3", $_POST['extraAnno3']);
//$entry->addChild("extraAnno4", $_POST['extraAnno4']);
//$entry->addChild("extraAnno5", $_POST['extraAnno5']);

    
$dom = new DOMDocument('1.0');
$dom->preserveWhiteSpace = false;
$dom->formatOutput = true;
$dom->loadXML($sxe->asXML());
$dom->save($file);
    
} elseif ($_POST['type'] == 'modify') {
    
$id = (int)$_POST['id'];
$field = $_POST['option'];
$edit = $_POST['edit'];

$dictionary = new SimpleXMLElement($file,null,true);


if ($field == 'orth') {
    
$result = $dictionary->xpath("/dictionary/entry[@id='$id']/form");

 $result[0]->$field = $edit;
    
} elseif ($field == 'pos') {

$result = $dictionary->xpath("/dictionary/entry[@id='$id']/gramGrp");

 $result[0]->$field = $edit;

} elseif ($field == 'usg' or $field == 'quote') {
    
$result = $dictionary->xpath("/dictionary/entry[@id='$id']/sense/cit");
  
$result[0]->$field = $edit;
        
} elseif ($field == 'media') {
 
$result = $dictionary->xpath("/dictionary/entry[@id='$id']");

$audio = "audio/" . substr($edit, -3);
$result[0]->$field->attributes()->mimeType = $audio;
$result[0]->$field->attributes()->url = $edit;


} else {
$result = $dictionary->xpath("/dictionary/entry[@id='$id']");
   
$result[0]->$field = $edit;
    
}

$dom = new DOMDocument('1.0');
$dom->preserveWhiteSpace = false;
$dom->formatOutput = true;
$dom->loadXML($dictionary->asXML());
$dom->save($file);
    
    
} elseif ($_POST['type'] == 'delete') {
$id = (int)$_POST['id'];  

$dom = new DOMDocument('1.0');
$dom->preserveWhiteSpace = false;
$dom->formatOutput = true;

$dom->load($file);
$dictionary = $dom->documentElement;
$xpath = new DOMXPath($dom);

$result = $xpath->query("/dictionary/entry[@id='$id']");
$result->item(0)->parentNode->removeChild($result->item(0));

$dom->save($file);
} 

echo "<div class=\"row\"><hr><br><h4 style=\"font-size: 200%\"><center><b>Query submitted.</b></center></h4><hr></div>";

  include("../update/interface.php");
?> 


<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="../css/foundation.css" />

    <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
    <title>Talking Dictionary</title>    
</head>
<body>

</body>
</html>