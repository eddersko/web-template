<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>Phrasicon Template</title>
    <meta name="description" content="Multi-layered Language Learning Resources" />
    <meta name="author" content="User" />
    <meta name="copyright" content="User" />
    <link rel="stylesheet" href="../css/foundation.css" />
    <script>
        function showRecords(str) {
            if (str == "") {
                document.getElementById("display").innerHTML = "";
                return;
            }
            if (window.XMLHttpRequest) {
                // code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp = new XMLHttpRequest();
            } else { // code for IE6, IE5
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function() {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    document.getElementById("display").innerHTML = xmlhttp.responseText;
                }
            }
            xmlhttp.open("GET", "showRecords.php?english=" + str, true);
            xmlhttp.send();
        }
    </script>
    <script>
        function suggest(str, id) {
            if (str == "") {
                document.getElementById(id).value = "";
                return;
            }
            if (window.XMLHttpRequest) {
                // code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp = new XMLHttpRequest();
            } else { // code for IE6, IE5
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function() {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {

                    response = xmlhttp.responseText.trim().split(" ");

                    for (i = 0; i < response.length; i++) {
                        if (response[i] == "?") {
                            document.getElementById('gloss' + (i + 1)).value = "";
                        } else {
                            document.getElementById('gloss' + (i + 1)).value = response[i].replace(/_/g, " ");
                        }
                    }
                }
            }
            num = parseInt(id.split('gloss')[1]);
            text = "";
            for (i = 1; i <= num; i++) {
                if (document.getElementById('morpheme' + i).value == " " | document.getElementById('morpheme' + i).value == "") {
                    text = text + "? ";
                } else {
                    text = text + document.getElementById('morpheme' + i).value + " ";
                }
            }
            text = text.trim();
            xmlhttp.open("GET", "autosuggest.php?txt=" + text, true);
            xmlhttp.send();
        }
        
                var counter = 12;

        function addLayer(morphDiv, glossDiv /*, extra1Div, extra2Div, extra3Div, extra4Div, extra5Div*/) {

            for (i = 1; i <= 6; i++) {
            var newMorphDiv = document.createElement('div');
            newMorphDiv.className = "large-2 columns";
            var newGlossDiv = document.createElement('div');
            newGlossDiv.className = "large-2 columns";
                
            //var newExtra1hDiv = document.createElement('div');
            //newExtra1Div.className = "large-2 columns";
            //var newExtra2Div = document.createElement('div');
            //newExtra2Div.className = "large-2 columns";
            //var newExtra3Div = document.createElement('div');
            //newExtra3Div.className = "large-2 columns";
            //var newExtra4Div = document.createElement('div');
            //newExtra4Div.className = "large-2 columns";
            //var newExtra5Div = document.createElement('div');
            //newExtra5Div.className = "large-2 columns";
                
            newMorphDiv.innerHTML = "<input id=\"morpheme" + (counter + 1) + "\" type=\"text\" name=\"morpheme"+ (counter + 1) +"\" onkeydown=\"main(event, this)\" onkeyup=\"suggest(this.value, 'gloss"+ (counter + 1) +"')\" autocomplete=\"off\">";
            newGlossDiv.innerHTML = "<input id=\"gloss"+ (counter + 1) +"\" type=\"text\" name=\"gloss"+ (counter + 1) +"\">";
                
            //newExtra1Div.innerHTML = "<input id=\"extra1_"+ (counter + 1) +"\" type=\"text\" name=\"extra1_"+ (counter + 1) +"\">";
            //newExtra2Div.innerHTML = "<input id=\"extra2_"+ (counter + 1) +"\" type=\"text\" name=\"extra2_"+ (counter + 1) +"\">";
            //newExtra3Div.innerHTML = "<input id=\"extra3_"+ (counter + 1) +"\" type=\"text\" name=\"extra3_"+ (counter + 1) +"\">";
            //newExtra4Div.innerHTML = "<input id=\"extra4_"+ (counter + 1) +"\" type=\"text\" name=\"extra4_"+ (counter + 1) +"\">";
            //newExtra5Div.innerHTML = "<input id=\"extra5_"+ (counter + 1) +"\" type=\"text\" name=\"extra5_"+ (counter + 1) +"\">";
                
            document.getElementById(morphDiv).appendChild(newMorphDiv);
            document.getElementById(glossDiv).appendChild(newGlossDiv);
            //document.getElementById(extra1Div).appendChild(newExtra1Div);
            //document.getElementById(extra2Div).appendChild(newExtra2Div);
            //document.getElementById(extra3Div).appendChild(newExtra3Div);
            //document.getElementById(extra4Div).appendChild(newExtra4Div);
            //document.getElementById(extra5Div).appendChild(newExtra5Div);
            
            counter++;
            }
            document.getElementById("cells").value = counter;
        }
        var counterEdit = 12;

        function addEditLayer(morphossDiv) {

            for (i = 1; i <= 6; i++) {
            var newMorphossDiv = document.createElement('div');
            newMorphossDiv.className = "large-2 columns";
            newMorphossDiv.innerHTML = "<input id=\"morphoss"+(counterEdit+1)+"\" type=\"text\" name=\"morphoss"+(counterEdit+1)+"\" onkeydown=\"main(event, this)\">";
            document.getElementById(morphossDiv).appendChild(newMorphossDiv);
            counterEdit++;
            }
            document.getElementById("cellsEdit").value = counterEdit;
        }
    </script>
</head>

<body>

    <div class="row">
        <hr>
        <!-- Title of Page. -->
        <h4 class="title">Online Phrasicon Template</h4>
        <hr>

        <!-- The section for creating records... -->
        <form name="create" action="../update/insert.php" method="post">
            <h4 class="subheader">Create Record</h4>
            <input type="hidden" name="type" value="create">
            <div class="large-12 columns">
                <!-- Source -->
                <h4 class="subsubheader">Source</h4>
                <input id="source" type="text" name="source" >
            </div>
            <input type="hidden" id="cells" name="cells" value="12">
            <h4 class="subsubheader">Morpheme</h4>
            <div id="morphinput">

            <div class="large-2 columns">
                <input id="morpheme1" type="text" name="morpheme1"  onkeyup="suggest(this.value, 'gloss1')" autocomplete="off">
            </div>
            <div class="large-2 columns">
                <input id="morpheme2" type="text" name="morpheme2"  onkeyup="suggest(this.value, 'gloss2')" autocomplete="off">
            </div>
            <div class="large-2 columns">
                <input id="morpheme3" type="text" name="morpheme3"  onkeyup="suggest(this.value, 'gloss3')" autocomplete="off">
            </div>
            <div class="large-2 columns">
                <input id="morpheme4" type="text" name="morpheme4"  onkeyup="suggest(this.value, 'gloss4')" autocomplete="off">
            </div>
            <div class="large-2 columns">
                <input id="morpheme5" type="text" name="morpheme5"  onkeyup="suggest(this.value, 'gloss5')" autocomplete="off">
            </div>
            <div class="large-2 columns">
                <input id="morpheme6" type="text" name="morpheme6"  onkeyup="suggest(this.value, 'gloss6')" autocomplete="off">
            </div>
            <div class="large-2 columns">
                <input id="morpheme7" type="text" name="morpheme7"  onkeyup="suggest(this.value, 'gloss7')" autocomplete="off">
            </div>
            <div class="large-2 columns">
                <input id="morpheme8" type="text" name="morpheme8"  onkeyup="suggest(this.value, 'gloss8')" autocomplete="off">
            </div>
            <div class="large-2 columns">
                <input id="morpheme9" type="text" name="morpheme9"  onkeyup="suggest(this.value, 'gloss9')" autocomplete="off">
            </div>
            <div class="large-2 columns">
                <input id="morpheme10" type="text" name="morpheme10"  onkeyup="suggest(this.value, 'gloss10')" autocomplete="off">
            </div>
            <div class="large-2 columns">
                <input id="morpheme11" type="text" name="morpheme11"  onkeyup="suggest(this.value, 'gloss11')" autocomplete="off">
            </div>
            <div class="large-2 columns">
                <input id="morpheme12" type="text" name="morpheme12"  onkeyup="suggest(this.value, 'gloss12')" autocomplete="off">
            </div>
            </div>
            <h4 class="subsubheader">Gloss</h4>
            <div id="glossinput">

            <div class="large-2 columns">
                <input id="gloss1" type="text" name="gloss1">
            </div>
            <div class="large-2 columns">
                <input id="gloss2" type="text" name="gloss2">
            </div>
            <div class="large-2 columns">
                <input id="gloss3" type="text" name="gloss3">
            </div>
            <div class="large-2 columns">
                <input id="gloss4" type="text" name="gloss4">
            </div>
            <div class="large-2 columns">
                <input id="gloss5" type="text" name="gloss5">
            </div>
            <div class="large-2 columns">
                <input id="gloss6" type="text" name="gloss6">
            </div>
            <div class="large-2 columns">
                <input id="gloss7" type="text" name="gloss7">
            </div>
            <div class="large-2 columns">
                <input id="gloss8" type="text" name="gloss8">
            </div>
            <div class="large-2 columns">
                <input id="gloss9" type="text" name="gloss9">
            </div>
            <div class="large-2 columns">
                <input id="gloss10" type="text" name="gloss10">
            </div>
            <div class="large-2 columns">
                <input id="gloss11" type="text" name="gloss11">
            </div>
            <div class="large-2 columns">
                <input id="gloss12" type="text" name="gloss12">
            </div>
            </div>

            <!-- This is where you add annotation layers. -->

            <!-- ExtraAnno1 -->

            <!--

        <h4 class="subsubheader">ExtraAnno1</h4>
            <div id="extraInput1">
            <div class="large-2 columns">
                <input id="extra1_1" type="text" name="extra1_1">
            </div>
            <div class="large-2 columns">
                <input id="extra1_2" type="text" name="extra1_2">
            </div>
            <div class="large-2 columns">
                <input id="extra1_3" type="text" name="extra1_3">
            </div>
            <div class="large-2 columns">
                <input id="extra1_4" type="text" name="extra1_4">
            </div>
            <div class="large-2 columns">
                <input id="extra1_5" type="text" name="extra1_5">
            </div>
            <div class="large-2 columns">
                <input id="extra1_6" type="text" name="extra1_6">
            </div>
            <div class="large-2 columns">
                <input id="extra1_7" type="text" name="extra1_7">
            </div>
            <div class="large-2 columns">
                <input id="extra1_8" type="text" name="extra1_8">
            </div>
            <div class="large-2 columns">
                <input id="extra1_9" type="text" name="extra1_9">
            </div>
            <div class="large-2 columns">
                <input id="extra1_10" type="text" name="extra1_10">
            </div>
            <div class="large-2 columns">
                <input id="extra1_11" type="text" name="extra1_11">
            </div>
            <div class="large-2 columns">
                <input id="extra1_12" type="text" name="extra1_12">
            </div>
            </div>
-->

            <!-- ExtraAnno2 -->


            <!--
        <h4 class="subsubheader">ExtraAnno2</h4>

            <div id="extraInput2">
            <div class="large-2 columns">
                <input id="extra2_1" type="text" name="extra2_1">
            </div>
            <div class="large-2 columns">
                <input id="extra2_2" type="text" name="extra2_2">
            </div>
            <div class="large-2 columns">
                <input id="extra2_3" type="text" name="extra2_3">
            </div>
            <div class="large-2 columns">
                <input id="extra2_4" type="text" name="extra2_4">
            </div>
            <div class="large-2 columns">
                <input id="extra2_5" type="text" name="extra2_5">
            </div>
            <div class="large-2 columns">
                <input id="extra2_6" type="text" name="extra2_6">
            </div>
            <div class="large-2 columns">
                <input id="extra2_7" type="text" name="extra2_7">
            </div>
            <div class="large-2 columns">
                <input id="extra2_8" type="text" name="extra2_8">
            </div>
            <div class="large-2 columns">
                <input id="extra2_9" type="text" name="extra2_9">
            </div>
            <div class="large-2 columns">
                <input id="extra2_10" type="text" name="extra2_10">
            </div>
            <div class="large-2 columns">
                <input id="extra2_11" type="text" name="extra2_11">
            </div>
            <div class="large-2 columns">
                <input id="extra2_12" type="text" name="extra2_12">
            </div>
            </div>
-->

            <!-- ExtraAnno3 -->

            <!--


        <h4 class="subsubheader">ExtraAnno3</h4>
            
            <div id="extraInput3">
            <div class="large-2 columns">
                <input id="extra3_1" type="text" name="extra3_1">
            </div>
            <div class="large-2 columns">
                <input id="extra3_2" type="text" name="extra3_2">
            </div>
            <div class="large-2 columns">
                <input id="extra3_3" type="text" name="extra3_3">
            </div>
            <div class="large-2 columns">
                <input id="extra3_4" type="text" name="extra3_4">
            </div>
            <div class="large-2 columns">
                <input id="extra3_5" type="text" name="extra3_5">
            </div>
            <div class="large-2 columns">
                <input id="extra3_6" type="text" name="extra3_6">
            </div>
            <div class="large-2 columns">
                <input id="extra3_7" type="text" name="extra3_7">
            </div>
            <div class="large-2 columns">
                <input id="extra3_8" type="text" name="extra3_8">
            </div>
            <div class="large-2 columns">
                <input id="extra3_9" type="text" name="extra3_9">
            </div>
            <div class="large-2 columns">
                <input id="extra3_10" type="text" name="extra3_10">
            </div>
            <div class="large-2 columns">
                <input id="extra3_11" type="text" name="extra3_11">
            </div>
            <div class="large-2 columns">
                <input id="extra3_12" type="text" name="extra3_12">
            </div>
            </div>
-->

            <!-- ExtraAnno4 -->

            <!--

        <h4 class="subsubheader">ExtraAnno4</h4>
        
            <div id="extraInput4">
            <div class="large-2 columns">
                <input id="extra4_1" type="text" name="extra4_1">
            </div>
            <div class="large-2 columns">
                <input id="extra4_2" type="text" name="extra4_2">
            </div>
            <div class="large-2 columns">
                <input id="extra4_3" type="text" name="extra4_3">
            </div>
            <div class="large-2 columns">
                <input id="extra4_4" type="text" name="extra4_4">
            </div>
            <div class="large-2 columns">
                <input id="extra4_5" type="text" name="extra4_5">
            </div>
            <div class="large-2 columns">
                <input id="extra4_6" type="text" name="extra4_6">
            </div>
            <div class="large-2 columns">
                <input id="extra4_7" type="text" name="extra4_7">
            </div>
            <div class="large-2 columns">
                <input id="extra4_8" type="text" name="extra4_8">
            </div>
            <div class="large-2 columns">
                <input id="extra4_9" type="text" name="extra4_9">
            </div>
            <div class="large-2 columns">
                <input id="extra4_10" type="text" name="extra4_10">
            </div>
            <div class="large-2 columns">
                <input id="extra4_11" type="text" name="extra4_11">
            </div>
            <div class="large-2 columns">
                <input id="extra4_12" type="text" name="extra4_12">
            </div>
            </div>
-->


            <!-- ExtraAnno5 -->

            <!--

        <h4 class="subsubheader">ExtraAnno5</h4>

            <div id="extraInput5">
            <div class="large-2 columns">
                <input id="extra5_1" type="text" name="extra5_1">
            </div>
            <div class="large-2 columns">
                <input id="extra5_2" type="text" name="extra5_2">
            </div>
            <div class="large-2 columns">
                <input id="extra5_3" type="text" name="extra5_3">
            </div>
            <div class="large-2 columns">
                <input id="extra5_4" type="text" name="extra5_4">
            </div>
            <div class="large-2 columns">
                <input id="extra5_5" type="text" name="extra5_5">
            </div>
            <div class="large-2 columns">
                <input id="extra5_6" type="text" name="extra5_6">
            </div>
            <div class="large-2 columns">
                <input id="extra5_7" type="text" name="extra5_7">
            </div>
            <div class="large-2 columns">
                <input id="extra5_8" type="text" name="extra5_8">
            </div>
            <div class="large-2 columns">
                <input id="extra5_9" type="text" name="extra5_9">
            </div>
            <div class="large-2 columns">
                <input id="extra5_10" type="text" name="extra5_10">
            </div>
            <div class="large-2 columns">
                <input id="extra5_11" type="text" name="extra5_11">
            </div>
            <div class="large-2 columns">
                <input id="extra5_12" type="text" name="extra5_12">
            </div>
            </div>
-->
            <center><a onclick="addLayer('morphinput', 'glossinput')" class="button round">+ Add Row</a>
            </center>
            
            <!-- <center><a onclick="addLayer('morphinput', 'glossinput', 'extraInput1','extraInput2','extraInput3','extraInput4','extraInput5')" class="button round">+ Add Row</a>
            </center> -->
            
            <div class="large-12 columns">
                <h4 class="subsubheader">Translation</h4>
                <input type="text" name="translation_abc">
            </div>
            <!-- 
            <div class="large-12 columns">
                <h4 class="subsubheader">Translation (123)</h4>
                <input type="text" name="translation_123">
            </div>
-->
            <div class="large-4 columns">
                <h4 class="subsubheader">Reference</h4>
                <input type="text" name="ref">
            </div>
            <div class="large-4 columns">
                <h4 class="subsubheader">Media</h4>
                <input type="text" name="media">
            </div>
            <div class="large-4 columns">
                <br>
                <br>
                <input class="postfix button" type="submit" value="Create">
            </div>
        </form>
        <!-- ...ends here. -->

        <hr>

        <!-- The section for displaying records... -->
        <h4 class="subheader">Display Record(s)</h4>
        <div class="large-3 columns">

            <h4 class="subsubheader">Find by Translation</h4>
            <input type="text" name="field" onkeyup="showRecords(this.value)">
        </div>
        <br>
        <br>


        <div class="large-9 columns">


            <div id="display">
                <h4 class="subsubheader">Records will be displayed here.</h4>
            </div>

        </div>
        <!-- ...ends here. -->

        <hr>

        <!-- The section for modifying records... -->
        <form name="modify" action="../update/insert.php" method="post">
            <h4 class="subheader">Modify Record</h4>
            <input type="hidden" name="type" value="modify">
            <div class="large-3 columns">
                <h4 class="subsubheader">Find by ID</h4>
                <input type="text" name="id">
            </div>
            <div class="large-3 columns">
                <h4 class="subsubheader">Field</h4>
                <select name="option">
                    <!-- Source -->
                    <option value="source">Source</option>
                    <option value="morpheme">Morpheme</option>
                    <option value="gloss">Gloss</option>
                    <option value="translation|en">Translation</option>
                    <!--<option value="translation|123">Translation (123)</option>-->
                    <option value="media">Media</option>
                    <option value="ref">Reference</option>
                    <!-- This is where you add annotation layers. -->

                    <!-- ExtraAnno1 -->
                    <!--- <option value="extraAnno1">ExtraAnno1</option> -->

                    <!-- ExtraAnno2 -->
                    <!--- <option value="extraAnno2">ExtraAnno2</option> -->

                    <!-- ExtraAnno3 -->
                    <!--- <option value="extraAnno3">ExtraAnno3</option> -->

                    <!-- ExtraAnno4 -->
                    <!--- <option value="extraAnno4">ExtraAnno4</option> -->

                    <!-- ExtraAnno5 -->
                    <!--- <option value="extraAnno5">ExtraAnno5</option> -->
                </select>
            </div>
            <div class="large-3 columns">

                <h4 class="subsubheader">Edit</h4>
                <input id="edit" type="text" name="edit" >
            </div>
            <br>
            <br>
            <div class="large-3 columns">

                <input class="postfix button" type="submit" value="Modify">
            </div>

            <!-- This is where you add annotation layers. -->
            <!-- Add the names of the annotation layer after Morpheme/Gloss. Ex. Morpheme/Gloss/Tone -->

            <h4 class="subsubheader">Morpheme/Gloss</h4>
            <div id="morphossInput">
            <input type="hidden" id="cellsEdit" name="cellsEdit" value="12">
            <div class="large-2 columns">
                <input id="morphoss1" type="text" name="morphoss1" >
            </div>
            <div class="large-2 columns">
                <input id="morphoss2" type="text" name="morphoss2" >
            </div>
            <div class="large-2 columns">
                <input id="morphoss3" type="text" name="morphoss3" >
            </div>
            <div class="large-2 columns">
                <input id="morphoss4" type="text" name="morphoss4" >
            </div>
            <div class="large-2 columns">
                <input id="morphoss5" type="text" name="morphoss5" >
            </div>
            <div class="large-2 columns">
                <input id="morphoss6" type="text" name="morphoss6" >
            </div>
            <div class="large-2 columns">
                <input id="morphoss7" type="text" name="morphoss7" >
            </div>
            <div class="large-2 columns">
                <input id="morphoss8" type="text" name="morphoss8" >
            </div>
            <div class="large-2 columns">
                <input id="morphoss9" type="text" name="morphoss9" >
            </div>
            <div class="large-2 columns">
                <input id="morphoss10" type="text" name="morphoss10" >
            </div>
            <div class="large-2 columns">
                <input id="morphoss11" type="text" name="morphoss11" >
            </div>
            <div class="large-2 columns">
                <input id="morphoss12" type="text" name="morphoss12" >
            </div>
            </div>
            <center><a onclick="addEditLayer('morphossInput')" class="button round">+ Add Row</a>
            </center>
        </form>
        <!-- ...ends here. -->
        
        <hr>
        <form action="../update/insert.php" method="post">
            <h4 class="subheader">Mass Edit</h4>
            <input type="hidden" name="type" value="mass_edit">
            <div class="large-3 columns">
                <h4 class="subsubheader">Morpheme</h4> 
                <input type="text" name="morph">
            </div>
            <div class="large-3 columns">
                <h4 class="subsubheader">Gloss</h4> 
                <input type="text" name="gloss">
            </div>
            <div class="large-3 columns">
                <h4 class="subsubheader">Edit</h4> 
                <input type="text" name="edit">
            </div>
            <br>
            <br>
            <div class="large-3 columns">
                <input class="button postfix" type="submit" value="Edit">
            </div>
        </form>


        <br>
        <br>
        <hr>

        <!-- The section for deleting records... -->
        <form action="../update/insert.php" method="post">
            <h4 class="subheader">Delete Record</h4>
            <input type="hidden" name="type" value="delete">
            <div class="large-3 columns">
                <h4 class="subsubheader">Delete by ID</h4>
                <input type="text" name="id">
            </div>
            <br>
            <br>
            <div class="large-3 columns">
                <input class="button postfix" type="submit" value="Delete">
            </div>
        </form>
        <!-- ...ends here. -->

        <br>
        <br>
        <hr>

        <!-- The section for uploading XML database file... -->
        <h4 class="subheader">Import/Export XML File</h4>
        <form action="upload_file.php" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="large-3 columns">
                    <input type="file" name="file[]">
                </div>
            </div>
            <div class="row">
                <div class="large-3 columns">
                    <input class="button postfix" type="submit" name="submit" value="Import">
                </div>
                <div class="large-3 columns">
                    <a class="button postfix" href="../phrasicon.xml" download>Export</a>
                </div>
            </div>
        </form>
        <hr>
        <!-- ...ends here. -->

        <!-- The section for uploading sound files... -->
        <form action="uploadFiles.php" method="post" enctype="multipart/form-data">

            <h4 class="subheader">Upload Sound Files</h4>

            <input type="file" name="file[]" multiple>
            <br>

            <div class="row">
                <div class="large-3 columns">
                    <input class="button postfix" type="submit" name="submit" value="Submit">
                </div>
            </div>
        </form>
        <!-- ...ends here. -->

        <hr>

    </div>

    <script src="../js/vendor/jquery.js"></script>
    <script src="../js/foundation/foundation.js"></script>
    <script>
        $(document).foundation();
        var doc = document.documentElement;
        doc.setAttribute('data-useragent', navigator.userAgent);
    </script>
</body>

</html>