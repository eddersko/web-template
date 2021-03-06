<?php

    /*
    * Author: Edwin Ko eddersko.com
    * This script is free software.
    */

$file = '../phrasicon.xml';
$xml = simplexml_load_file($file);
$sxe = new SimpleXMLElement($xml->asXML());

$xmlDoc = new DOMDocument();
$xmlDoc->load($file);
$xpath = new DOMXPath($xmlDoc);

if ($_POST['type'] == 'create') {

$num_cells = $_POST['cells'];
$result = $xpath->query("/phrasicon/phrase[last()]");  
$id = ($result->item(0)->getAttribute('id')) + 1;

$entry = $sxe->addChild("phrase");
$entry->addAttribute("id",$id);
$entry->addChild("ref", $_POST['ref']);
$entry->addChild('source', $_POST['source']);
$morpheme = $entry->addChild('morpheme');
for ($x=1; $x<=$num_cells; $x++) {
    $m = $_POST['morpheme' . $x];
    if ($m == '') {
     break;   
    } else {
     $morph = $morpheme->addChild('m', $m);
    $morph->addAttribute('id', $id . "." . $x);
    }
}
$gloss = $entry->addChild('gloss');
$gloss->addAttribute("lang", "en");
for ($x=1; $x<=$num_cells; $x++) {
    $g = $_POST['gloss' . $x];
    if ($g == '') {
     break;   
    } else {
        $glossing = $gloss->addChild('g', $g);
        $glossing->addAttribute('id', $id . "." . $x);
    }
}
$translation1 = $entry->addChild('translation', $_POST['translation_abc']);
$translation1->addAttribute("lang", "en");   
$media = $entry->addChild('media');
$media->addAttribute("mimeType", substr($_POST['media'], -3));
$media->addAttribute("url", $_POST['media']);

// This is where you add annotation layers. 
// Rename-able    
    
// ExtraAnno1
    
/*

$extraAnno1 = $entry->addChild('extraAnno1');
for ($x=1; $x<=$num_cells; $x++) {
    $extra = $_POST['extra1_' . $x];
    if ($extra == '') {
     break;   
    } else {
        $layer = $extraAnno1->addChild('extra1', $extra);
        $layer->addAttribute('id', $id . "." . $x);
    }
}

*/    
    
// ExtraAnno2
    
/*

$extraAnno2 = $entry->addChild('extraAnno2');
for ($x=1; $x<=$num_cells; $x++) {
    $extra = $_POST['extra2_' . $x];
    if ($extra == '') {
     break;   
    } else {
        $layer = $extraAnno2->addChild('extra2', $extra);
        $layer->addAttribute('id', $id . "." . $x);
    }
}

*/

// ExtraAnno3
    
/*

$extraAnno3 = $entry->addChild('extraAnno3');
for ($x=1; $x<=$num_cells; $x++) {
    $extra = $_POST['extra1_' . $x];
    if ($extra == '') {
     break;   
    } else {
        $layer = $extraAnno3->addChild('extra3', $extra);
        $layer->addAttribute('id', $id . "." . $x);
    }
}

*/
 
// ExtraAnno4
    
/*

$extraAnno4 = $entry->addChild('extraAnno4');
for ($x=1; $x<=$num_cells; $x++) {
    $extra = $_POST['extra4_' . $x];
    if ($extra == '') {
     break;   
    } else {
        $layer = $extraAnno4->addChild('extra4', $extra);
        $layer->addAttribute('id', $id . "." . $x);
    }
}

*/
    
// ExtraAnno5    
    
/*

$extraAnno5 = $entry->addChild('extraAnno5');
for ($x=1; $x<=$num_cells; $x++) {
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
$numcells = $_POST['cellsEdit'];
$phrasicon = new SimpleXMLElement($file,null,true);
    
if ($field == 'media') {
    
$result = $phrasicon->xpath("/phrasicon/phrase[@id='$id']");
$audio = "audio/" . substr($edit, -3);
$result[0]->$field->attributes()->mimeType = $audio;
$result[0]->$field->attributes()->url = $edit;

} elseif ($field == 'morpheme') {

for ($x=1; $x<=$numcells; $x++) {
    
    $m = $_POST['morphoss' . $x];
    if ($m != '') {
    $result = $phrasicon->xpath("/phrasicon/phrase[@id='$id']");
    $result[0]->morpheme->m[$x-1] = $m;
    $result[0]->morpheme->m[$x-1]->addAttribute('id', $id . "." . $x);
    }    
    
}
    
} elseif ($field=="gloss") {


for ($x=1; $x<=$numcells; $x++) {
    
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
// Rename-able
    
/* elseif ($field=="extraAnno1") {

for ($x=1; $x<=$numcells; $x++) {
    
    $extra = $_POST['morphoss' . $x];
    if ($extra != '') {
    $result = $phrasicon->xpath("/phrasicon/phrase[@id='$id']");
    $result[0]->extraAnno1->extra1[$x-1] = $extra;
    $result[0]->extraAnno1->extra1[$x-1]->addAttribute('id', $id . "." . $x);
    }    
    
}
    
}  */

// ExtraAnno2
    
/* elseif ($field=="extraAnno2") {

for ($x=1; $x<=$numcells; $x++) {
    
    $extra = $_POST['morphoss' . $x];
    if ($extra != '') {
    $result = $phrasicon->xpath("/phrasicon/phrase[@id='$id']");
    $result[0]->extraAnno2->extra2[$x-1] = $extra;
    $result[0]->extraAnno2->extra2[$x-1]->addAttribute('id', $id . "." . $x);
    }    
    
}
    
}  */  
    
// ExtraAnno3    

/* elseif ($field=="extraAnno3") {

for ($x=1; $x<=$numcells; $x++) {
    
    $extra = $_POST['morphoss' . $x];
    if ($extra != '') {
    $result = $phrasicon->xpath("/phrasicon/phrase[@id='$id']");
    $result[0]->extraAnno3->extra3[$x-1] = $extra;
    $result[0]->extraAnno3->extra3[$x-1]->addAttribute('id', $id . "." . $x);
    }    
    
}
    
}  */ 

// ExtraAnno4
    
/* elseif ($field=="extraAnno4") {

for ($x=1; $x<=$numcells; $x++) {
    
    $extra = $_POST['morphoss' . $x];
    if ($extra != '') {
    $result = $phrasicon->xpath("/phrasicon/phrase[@id='$id']");
    $result[0]->extraAnno4->extra4[$x-1] = $extra;
    $result[0]->extraAnno4->extra4[$x-1]->addAttribute('id', $id . "." . $x);
    }    
    
}
    
}  */ 

// ExtraAnno5  

/* elseif ($field=="extraAnno5") {

for ($x=1; $x<=$numcells; $x++) {
    
    $extra = $_POST['morphoss' . $x];
    if ($extra != '') {
    $result = $phrasicon->xpath("/phrasicon/phrase[@id='$id']");
    $result[0]->extraAnno5->extra5[$x-1] = $extra;
    $result[0]->extraAnno5->extra5[$x-1]->addAttribute('id', $id . "." . $x);
    }    
    
}
    
}  */ else {
    
    $field_explode = explode('|', $field);
    if ($field_explode[0] == "translation") {
    $field = $field_explode[0];
    $lang = $field_explode[1];
    $result = $phrasicon->xpath("/phrasicon/phrase[@id = '$id']/translation[@lang = '$lang']/..");  
    $result[0]->$field = $edit;        
    } else {
    $result = $phrasicon->xpath("/phrasicon/phrase[@id = '$id']");  
    $result[0]->$field = $edit;
    }

}
    
$dom = new DOMDocument('1.0');
$dom->preserveWhiteSpace = false;
$dom->formatOutput = true;
$dom->loadXML($phrasicon->asXML());
$dom->save($file);
    
} elseif ($_POST['type'] == 'mass_edit') {

$morph = $_POST['morph'];
$gloss = $_POST['gloss'];
$edit = $_POST['edit'];

$phrasicon = new SimpleXMLElement($file,null,true);
        
$result = $phrasicon->xpath("//m[text()='$morph']");

$ids = array();
    
foreach ($result as $entry) {
    array_push($ids, $entry[id]);
}
    
for ($x=0; $x<sizeof($ids); $x++) {
    $result = $phrasicon->xpath("/phrasicon/phrase/gloss/g[@id='" . $ids[$x] . "']/../..");
    $id = explode(".", $ids[$x])[1]; 
    if ($result[0]->gloss->g[$id-1] == $gloss) {
        $result[0]->gloss->g[$id-1] = $edit;
    }  
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

$phrasicon = new SimpleXMLElement($file,null,true);
$result = $phrasicon->xpath("/phrasicon/metadata"); 
$result[0]->modified = date("Y-m-d");
$dom = new DOMDocument('1.0');
$dom->preserveWhiteSpace = false;
$dom->formatOutput = true;
$dom->loadXML($phrasicon->asXML());
$dom->save($file);

?> 