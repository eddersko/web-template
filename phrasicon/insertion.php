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
                    document.getElementById(id).value = xmlhttp.responseText;
                }
            }
            xmlhttp.open("GET", "autosuggest.php?morpheme=" + str, true);
            xmlhttp.send();
        }
    </script>
    <script type='text/javascript'>
        var id;

        function main(e, obj) {
            id = obj.id;
            keyPress(e);
        }

        function KeyPress(e) {
            var evtobj = window.event ? event : e;
            if (evtobj.keyCode == 65 && evtobj.altKey) {
                document.getElementById(id).value += 'ʰ';
            } else if (evtobj.keyCode == 191 && evtobj.altKey) {
                document.getElementById(id).value += 'ʔ';
            } else if (evtobj.keyCode == 78 && evtobj.altKey) {
                document.getElementById(id).value += 't̪';
            }
        }
        document.onkeydown = KeyPress;
    </script>
</head>

<body>

    <div class="row">
        <hr>
        <!-- Title of Page. -->
        <h4 class="title">Online Phrasicon Template</h4>
        <hr>
        
        <!-- The section for creating records... -->
        <form name="create" action="../update/inject.php" method="post">
            <h4 class="subheader">Create Record</h4>
            <input type="hidden" name="type" value="create">
            <div class="large-12 columns">
                <h4 class="subsubheader">Source</h4>
                <input id="source" type="text" name="source" onkeydown="main(event, this)">
            </div>

            <h4 class="subsubheader">Morpheme</h4>

            <div class="large-1 columns">
                <input id="morpheme1" type="text" name="morpheme1" onkeydown="main(event, this)" onkeyup="suggest(this.value, 'gloss1')">
            </div>
            <div class="large-1 columns">
                <input id="morpheme2" type="text" name="morpheme2" onkeydown="main(event, this)" onkeyup="suggest(this.value, 'gloss2')">
            </div>
            <div class="large-1 columns">
                <input id="morpheme3" type="text" name="morpheme3" onkeydown="main(event, this)" onkeyup="suggest(this.value, 'gloss3')">
            </div>
            <div class="large-1 columns">
                <input id="morpheme4" type="text" name="morpheme4" onkeydown="main(event, this)" onkeyup="suggest(this.value, 'gloss4')">
            </div>
            <div class="large-1 columns">
                <input id="morpheme5" type="text" name="morpheme5" onkeydown="main(event, this)" onkeyup="suggest(this.value, 'gloss5')">
            </div>
            <div class="large-1 columns">
                <input id="morpheme6" type="text" name="morpheme6" onkeydown="main(event, this)" onkeyup="suggest(this.value, 'gloss6')">
            </div>
            <div class="large-1 columns">
                <input id="morpheme7" type="text" name="morpheme7" onkeydown="main(event, this)" onkeyup="suggest(this.value, 'gloss7')">
            </div>
            <div class="large-1 columns">
                <input id="morpheme8" type="text" name="morpheme8" onkeydown="main(event, this)" onkeyup="suggest(this.value, 'gloss8')">
            </div>
            <div class="large-1 columns">
                <input id="morpheme9" type="text" name="morpheme9" onkeydown="main(event, this)" onkeyup="suggest(this.value, 'gloss9')">
            </div>
            <div class="large-1 columns">
                <input id="morpheme10" type="text" name="morpheme10" onkeydown="main(event, this)" onkeyup="suggest(this.value, 'gloss10')">
            </div>
            <div class="large-1 columns">
                <input id="morpheme11" type="text" name="morpheme11" onkeydown="main(event, this)" onkeyup="suggest(this.value, 'gloss11')">
            </div>
            <div class="large-1 columns">
                <input id="morpheme12" type="text" name="morpheme12" onkeydown="main(event, this)" onkeyup="suggest(this.value, 'gloss12')">
            </div>
            <h4 class="subsubheader">Gloss</h4>

            <div class="large-1 columns">
                <input id="gloss1" type="text" name="gloss1">
            </div>
            <div class="large-1 columns">
                <input id="gloss2" type="text" name="gloss2">
            </div>
            <div class="large-1 columns">
                <input id="gloss3" type="text" name="gloss3">
            </div>
            <div class="large-1 columns">
                <input id="gloss4" type="text" name="gloss4">
            </div>
            <div class="large-1 columns">
                <input id="gloss5" type="text" name="gloss5">
            </div>
            <div class="large-1 columns">
                <input id="gloss6" type="text" name="gloss6">
            </div>
            <div class="large-1 columns">
                <input id="gloss7" type="text" name="gloss7">
            </div>
            <div class="large-1 columns">
                <input id="gloss8" type="text" name="gloss8">
            </div>
            <div class="large-1 columns">
                <input id="gloss9" type="text" name="gloss9">
            </div>
            <div class="large-1 columns">
                <input id="gloss10" type="text" name="gloss10">
            </div>
            <div class="large-1 columns">
                <input id="gloss11" type="text" name="gloss11">
            </div>
            <div class="large-1 columns">
                <input id="gloss12" type="text" name="gloss12">
            </div>

            </row>
            <row>
                <div class="large-12 columns">
                    <h4 class="subsubheader">Translation</h4>
                    <input type="text" name="translation">
                </div>
            </row>
            <row>
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
            </row>
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
        <form name="modify" action="../update/inject.php" method="post">
            <h4 class="subheader">Modify Record</h4>
            <input type="hidden" name="type" value="modify">
            <div class="large-3 columns">
                <h4 class="subsubheader">Find by ID</h4>
                <input type="text" name="id">
            </div>
            <div class="large-3 columns">
                <h4 class="subsubheader">Field</h4>
                <select name="option">
                    <option value="source">Source</option>
                    <option value="morpheme">Morpheme</option>
                    <option value="gloss">Gloss</option>
                    <option value="translation">Translation</option>
                    <option value="media">Media</option>
                    <option value="ref">Reference</option>
                </select>
            </div>
            <div class="large-3 columns">

                <h4 class="subsubheader">Edit</h4>
                <input id="edit" type="text" name="edit" onkeydown="main(event, this)">
            </div>
            <br>
            <br>
            <div class="large-3 columns">

                <input class="postfix button" type="submit" value="Modify">
            </div>

            <h4 class="subsubheader">Morpheme/Gloss</h4>

            <div class="large-1 columns">
                <input id="morphoss1" type="text" name="morphoss1" onkeydown="main(event, this)">
            </div>
            <div class="large-1 columns">
                <input id="morphoss2" type="text" name="morphoss2" onkeydown="main(event, this)">
            </div>
            <div class="large-1 columns">
                <input id="morphoss3" type="text" name="morphoss3" onkeydown="main(event, this)">
            </div>
            <div class="large-1 columns">
                <input id="morphoss4" type="text" name="morphoss4" onkeydown="main(event, this)">
            </div>
            <div class="large-1 columns">
                <input id="morphoss5" type="text" name="morphoss5" onkeydown="main(event, this)">
            </div>
            <div class="large-1 columns">
                <input id="morphoss6" type="text" name="morphoss6" onkeydown="main(event, this)">
            </div>
            <div class="large-1 columns">
                <input id="morphoss7" type="text" name="morphoss7" onkeydown="main(event, this)">
            </div>
            <div class="large-1 columns">
                <input id="morphoss8" type="text" name="morphoss8" onkeydown="main(event, this)">
            </div>
            <div class="large-1 columns">
                <input id="morphoss9" type="text" name="morphoss9" onkeydown="main(event, this)">
            </div>
            <div class="large-1 columns">
                <input id="morphoss10" type="text" name="morphoss10" onkeydown="main(event, this)">
            </div>
            <div class="large-1 columns">
                <input id="morphoss11" type="text" name="morphoss11" onkeydown="main(event, this)">
            </div>
            <div class="large-1 columns">
                <input id="morphoss12" type="text" name="morphoss12" onkeydown="main(event, this)">
            </div>
        </form>
        <!-- ...ends here. -->
    
        <br>
        <br>
        <hr>
    
        <!-- The section for deleting records... -->
        <form action="../update/inject.php" method="post">
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
    
        <!-- The section for uploading files... -->
        <form action="uploadFiles.php" method="post" enctype="multipart/form-data">

            <h4 class="subheader">Upload Files</h4>

            <input type="file" name="file[]" multiple>
            <br>

            <input type="submit" name="submit" value="Submit">

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