<?php

$file = '../phrasicon.xml';
$xml = simplexml_load_file($file);
$sxe = new SimpleXMLElement($xml->asXML());

$xmlDoc = new DOMDocument();
$xmlDoc->load($file);
$xpath = new DOMXPath($xmlDoc);

if ($_POST['type'] == 'create') {
    
$result = $xpath->query("/phrasicon/phrase[last()]");  
$id = ($result->item(0)->getAttribute('id')) + 1;

$entry = $sxe->addChild("phrase");
$entry->addAttribute("id",$id);
$entry->addChild("ref", $_POST['ref']);
$entry->addChild('source', $_POST['source']);
$morpheme = $entry->addChild('morpheme');
for ($x=1; $x<13; $x++) {
    $m = $_POST['morpheme' . $x];
    if ($m == '') {
     break;   
    } else {
     $morph = $morpheme->addChild('m', $m);
    $morph->addAttribute('id', $id . "." . $x);
    }
}
$gloss = $entry->addChild('gloss');
for ($x=1; $x<13; $x++) {
    $g = $_POST['gloss' . $x];
    if ($g == '') {
     break;   
    } else {
        $glossing = $gloss->addChild('g', $g);
        $glossing->addAttribute('id', $id . "." . $x);
    }
}
$entry->addChild('translation', $_POST['translation']);
$media = $entry->addChild('media');
$media->addAttribute("mimeType", substr($_POST['media'], -3));
$media->addAttribute("url", $_POST['media']);

// This is where you add annotation layers. 
// ExtraAnno1
    
/*

$extraAnno1 = $entry->addChild('extraAnno1');
for ($x=1; $x<13; $x++) {
    $extra = $_POST['extra1_' . $x];
    if ($extra == '') {
     break;   
    } else {
        $layer = $extraAnno1->addChild('extra1', $extra);
        $layer->addAttribute('id', $id . "." . $x);
    }
}

*/    
    
// This is where you add annotation layers. 
// ExtraAnno2
    
/*

$extraAnno2 = $entry->addChild('extraAnno2');
for ($x=1; $x<13; $x++) {
    $extra = $_POST['extra2_' . $x];
    if ($extra == '') {
     break;   
    } else {
        $layer = $extraAnno2->addChild('extra2', $extra);
        $layer->addAttribute('id', $id . "." . $x);
    }
}

*/

// This is where you add annotation layers. 
// ExtraAnno3
    
/*

$extraAnno3 = $entry->addChild('extraAnno3');
for ($x=1; $x<13; $x++) {
    $extra = $_POST['extra1_' . $x];
    if ($extra == '') {
     break;   
    } else {
        $layer = $extraAnno3->addChild('extra3', $extra);
        $layer->addAttribute('id', $id . "." . $x);
    }
}

*/
 
// This is where you add annotation layers. 
// ExtraAnno4
    
/*

$extraAnno4 = $entry->addChild('extraAnno4');
for ($x=1; $x<13; $x++) {
    $extra = $_POST['extra4_' . $x];
    if ($extra == '') {
     break;   
    } else {
        $layer = $extraAnno4->addChild('extra4', $extra);
        $layer->addAttribute('id', $id . "." . $x);
    }
}

*/
    
// This is where you add annotation layers. 
// ExtraAnno5    
    
/*

$extraAnno5 = $entry->addChild('extraAnno5');
for ($x=1; $x<13; $x++) {
    $extra = $_POST['extra5_' . $x];
    if ($extra == '') {
     break;   
    } else {
        $layer = $extraAnno1->addChild('extra5', $extra);
        $layer->addAttribute('id', $id . "." . $x);
    }
}

*/
        
$dom = new DOMDocument('1.0');
$dom->preserveWhiteSpace = false;
$dom->formatOutput = true;
$dom->loadXML($sxe->asXML());
$dom->save($file);
    
} elseif ($_POST['type'] == 'modify') {
      
$id = (int)$_POST['id'];
$field = $_POST['option'];
$edit = $_POST['edit'];

$phrasicon = new SimpleXMLElement($file,null,true);
    
if ($field == 'media') {
    
$result = $phrasicon->xpath("/phrasicon/phrase[@id='$id']");
$audio = "audio/" . substr($edit, -3);
$result[0]->$field->attributes()->mimeType = $audio;
$result[0]->$field->attributes()->url = $edit;

} elseif ($field == 'morpheme') {

for ($x=1; $x<13; $x++) {
    
    $m = $_POST['morphoss' . $x];
    if ($m != '') {
    $result = $phrasicon->xpath("/phrasicon/phrase[@id='$id']");
    $result[0]->morpheme->m[$x-1] = $m;
    $result[0]->morpheme->m[$x-1]->addAttribute('id', $id . "." . $x);
    }    
    
}
    
} elseif ($field=="gloss") {


for ($x=1; $x<13; $x++) {
    
    $g = $_POST['morphoss' . $x];
    if ($g != '') {
    $result = $phrasicon->xpath("/phrasicon/phrase[@id='$id']");
    $result[0]->gloss->g[$x-1] = $g;
    $result[0]->gloss->g[$x-1]->addAttribute('id', $id . "." . $x);
    }    
    
}

}  
    
// This is where you add annotation layers. 
// ExtraAnno1

/* elseif ($field=="extraAnno1") {

for ($x=1; $x<13; $x++) {
    
    $extra = $_POST['morphoss' . $x];
    if ($extra != '') {
    $result = $phrasicon->xpath("/phrasicon/phrase[@id='$id']");
    $result[0]->extraAnno1->extra1[$x-1] = $extra;
    $result[0]->extraAnno1->extra1[$x-1]->addAttribute('id', $id . "." . $x);
    }    
    
}
    
}  */

// This is where you add annotation layers. 
// ExtraAnno2
    
/* elseif ($field=="extraAnno2") {

for ($x=1; $x<13; $x++) {
    
    $extra = $_POST['morphoss' . $x];
    if ($extra != '') {
    $result = $phrasicon->xpath("/phrasicon/phrase[@id='$id']");
    $result[0]->extraAnno2->extra2[$x-1] = $extra;
    $result[0]->extraAnno2->extra2[$x-1]->addAttribute('id', $id . "." . $x);
    }    
    
}
    
}  */  
    
// This is where you add annotation layers. 
// ExtraAnno3    

/* elseif ($field=="extraAnno3") {

for ($x=1; $x<13; $x++) {
    
    $extra = $_POST['morphoss' . $x];
    if ($extra != '') {
    $result = $phrasicon->xpath("/phrasicon/phrase[@id='$id']");
    $result[0]->extraAnno3->extra3[$x-1] = $extra;
    $result[0]->extraAnno3->extra3[$x-1]->addAttribute('id', $id . "." . $x);
    }    
    
}
    
}  */ 

// This is where you add annotation layers. 
// ExtraAnno4
    
/* elseif ($field=="extraAnno4") {

for ($x=1; $x<13; $x++) {
    
    $extra = $_POST['morphoss' . $x];
    if ($extra != '') {
    $result = $phrasicon->xpath("/phrasicon/phrase[@id='$id']");
    $result[0]->extraAnno4->extra4[$x-1] = $extra;
    $result[0]->extraAnno4->extra4[$x-1]->addAttribute('id', $id . "." . $x);
    }    
    
}
    
}  */ 

// This is where you add annotation layers. 
// ExtraAnno5  

/* elseif ($field=="extraAnno5") {

for ($x=1; $x<13; $x++) {
    
    $extra = $_POST['morphoss' . $x];
    if ($extra != '') {
    $result = $phrasicon->xpath("/phrasicon/phrase[@id='$id']");
    $result[0]->extraAnno5->extra5[$x-1] = $extra;
    $result[0]->extraAnno5->extra5[$x-1]->addAttribute('id', $id . "." . $x);
    }    
    
}
    
}  */ else {
    $result = $phrasicon->xpath("/phrasicon/phrase[@id = '$id']");  
    $result[0]->$field = $edit;
}
    
$dom = new DOMDocument('1.0');
$dom->preserveWhiteSpace = false;
$dom->formatOutput = true;
$dom->loadXML($phrasicon->asXML());
$dom->save($file);
    
} elseif ($_POST['type'] == 'delete') {
$id = (int)$_POST['id'];  

$dom = new DOMDocument('1.0');
$dom->preserveWhiteSpace = false;
$dom->formatOutput = true;

$dom->load($file);
$phrasicon = $dom->documentElement;
$xpath = new DOMXPath($dom);
    
$result = $xpath->query("/phrasicon/phrase[@id='$id']");
$result->item(0)->parentNode->removeChild($result->item(0));

    $dom->save($file);
}
echo "<div class=\"row\"><hr><br><h4 style=\"font-size: 200%\"><center><b>Query submitted.</b></center></h4><hr></div>";

mysqli_close($con);
  include("../update/interface.php");

?> 

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>Phrasicon Template</title>
    <meta name="description" content="Multi-layered Language Learning Resources" />
    <meta name="author" content="User" />
    <meta name="copyright" content="User" />
    <link rel="stylesheet" href="../css/foundation.css" />
</head>
<body>

</body>
</html>