<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>Online Talking Dictionary Template</title>
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
    <script type='text/javascript'>
    var id;
    function main(e, obj) {
        id = obj.id;
        keyPress(e);
    }
    function KeyPress(e) {
        var evtobj = window.event? event : e;
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
        <!-- Title for the page. -->
        <h4 class="title">Online Talking Dictionary Data Entry</h4>
        <hr>

        <!-- The section for creating records... -->
        <form name="create" action="../update/insert.php" method="post">
            <h4 class="subheader">Create Record</h4>
            <input type="hidden" name="type" value="create">
            <div class="large-3 columns">
            <!-- Source -->
                <h4 class="subsubheader">Source Language</h4> 
                <input id="orth" type="text" name="orth" onkeydown="main(event, this)">
            </div>
            <div class="large-3 columns">
            <!-- English -->
                <h4 class="subsubheader">English</h4>
                <input type="text" name="quote">
            </div>
                    <div class="large-3 columns">
                <h4 class="subsubheader">POS</h4> 
                <input type="text" name="pos">
            </div>
            <div class="large-3 columns">
                <h4 class="subsubheader">Hypernym</h4> 
                <input type="text" name="usg">
            </div>
            <div class="large-6 columns">
                <h4 class="subsubheader">Description</h4> 
                <input id="note" type="text" name="note" onkeydown="main(event, this)">
            </div>
            <div class="large-3 columns">
                <h4 class="subsubheader">Media</h4> 
                <input type="text" name="media">
            </div>
              <div class="large-3 columns">
                <h4 class="subsubheader">Reference</h4> 
                <input type="text" name="ref">
            </div>

            <!-- This is where you add annotation layers. -->
            <!-- Rename-able -->
            
            <!-- ExtraAnno1 -->
            <!--    
            <div class="large-12 columns">
                <h4 class="subsubheader">ExtraAnno1</h4> 
                <input type="text" name="extraAnno1">
            </div>
            -->
            
            <!-- ExtraAnno2 -->
            <!--    
            <div class="large-12 columns">
                <h4 class="subsubheader">ExtraAnno2</h4> 
                <input type="text" name="extraAnno2">
            </div>
            -->

            <!-- ExtraAnno3 -->
            <!--    
            <div class="large-12 columns">
                <h4 class="subsubheader">ExtraAnno3</h4> 
                <input type="text" name="extraAnno3">
            </div>
            -->
                
            <!-- ExtraAnno4 -->
            <!--    
            <div class="large-12 columns">
                <h4 class="subsubheader">ExtraAnno4</h4> 
                <input type="text" name="extraAnno4">
            </div>
            -->
    
            <!-- ExtraAnno5 -->
            <!--    
            <div class="large-12 columns">
                <h4 class="subsubheader">ExtraAnno5</h4> 
                <input type="text" name="extraAnno5">
            </div>
            -->
                
            
            <div class="large-12 columns">

                <input class="postfix button" type="submit" value="Create">
            </div>

        </form>
        
        <!-- ...ends here. -->
        
        <hr>

        <!-- The section for displaying records... -->
        <h4 class="subheader">Display Record(s)</h4>
        <div class="large-3 columns">

            <h4 class="subsubheader">Find by English</h4> 
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
                <!-- This is the dropdown menu indicating the field to edit. -->
                <select name="option">
                    <option value="usg">Hypernym</option>
                    <!-- Source -->
                    <option value="orth">Source</option>
                    <!-- English -->
                    <option value="quote">English</option>
                    <option value="pos">Parts-of-Speech</option>
                    <option value="note">Description</option>
                    <option value="media">Media</option>
                    <option value="ref">Reference</option>

                    <!-- This is where you add annotation layers. -->
                    <!-- Rename-able -->

                    <!-- 
                    <option value="extraAnno1">ExtraAnno1</option>
                    -->
                    <!-- 
                    <option value="extraAnno2">ExtraAnno2</option>
                    -->                    
                    <!-- 
                    <option value="extraAnno3">ExtraAnno3</option>
                    -->                    
                    <!-- 
                    <option value="extraAnno4">ExtraAnno4</option>
                    -->                    
                    <!-- 
                    <option value="extraAnno5">ExtraAnno5</option>
                    -->
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


        </form>

        <!-- ...ends here. -->
        
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
        
        <!-- The section for uploading files... -->
        <form action="uploadFiles.php" method="post" enctype="multipart/form-data">

        <h4 class="subheader">Upload Files</h4>

        <input type="file" name="file[]" multiple><br>

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