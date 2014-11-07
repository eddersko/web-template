<?php $sql="" ; $sql=exec( 'python processingCSV.py'); ?>

<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="../css/foundation.css" />

    <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
    <title>Talking Dictionary Template</title>

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
        <h4 class="title">Online Talking Dictionary Data Entry</h4>
        <hr>

        <form name="create" action="../update/inject.php" method="post">
            <h4 class="subheader">Create Record</h4>
            <input type="hidden" name="type" value="create">
            <row>
            <div class="large-3 columns">
                <h4 class="subsubheader">Hypernym</h4> 
                <input type="text" name="usg">
            </div>
            <div class="large-3 columns">
                <h4 class="subsubheader">Northern Pomo</h4> 
                <input id="orth" type="text" name="orth" onkeydown="main(event, this)">
            </div>
            <div class="large-3 columns">
                <h4 class="subsubheader">English</h4>
                <input type="text" name="quote">
            </div>
                    <div class="large-3 columns">
                <h4 class="subsubheader">POS</h4> 
                <input type="text" name="pos">
            </div>
                </row>
            <row>
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
            </row>
            
            <div class="large-12 columns">

                <input class="postfix button" type="submit" value="Create">
            </div>

        </form>
        <hr>

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

        <hr>


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
                    <option value="usg">Hypernym</option>
                    <option value="orth">Northern Pomo</option>
                    <option value="quote">English</option>
                    <option value="pos">Parts-of-Speech</option>
                    <option value="note">Description</option>
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


        </form>
        <br>
        <br>
        <hr>
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
        <br>
        <br>
        <hr>
          <!--
        <form action="../update/inject.php" method="post">
            <h4 class="subheader">SQL Query</h4>
            <input type="hidden" name="type" value="query">
            <textarea name="query" rows="4" placeholder='"Chaos isn’t a pit. Chaos is a ladder. Many who try to climb it fail, and never get to try again. The fall breaks them. And some are given a chance to climb, but refuse. They cling to the realm, or love, or the gods…illusions. Only the ladder is real. The climb is all there is. But they’ll never know this. Not until it’s too late." - Peter Baelish a.k.a. Littlefinger'></textarea>
            <input class="radius button" type="submit" value="Submit Query">

            <br>
            <hr>

        </form>
        
      
        <hr>
        <h4 style="text-align:center">"The Lannisters always pay their debts."</h4>
        <hr>

        <form action="upload_file.php" method="post" enctype="multipart/form-data">
            <h4>Filename Upload</h4>
            <input type="file" name="file">
            <br>
            <input type="submit" name="submit" value="Submit">
        </form>
        <hr>
        <h4>SQL Query (Copy & Paste)</h4>

        <p>
            <?php echo $sql ?>
        </p>
        <hr>
        <h4 style="text-align:center">"Fire cannot kill a dragon."</h4>
        <hr>
        <p style="font-size:120%"><em>Entering data? Lost, confused and slightly afraid? Don’t worry, hold my hand and I’ll guide you through this...</em>
        </p>
        <ol>

            <li>To add entries, upload a CSV file named <em>data_entry.csv</em> in the following configuration:</li>
            <br>
            <img src="csv_creation.png" width="800px" />
            <ul>
                <li><em>Note</em>: You will need to use the following site to convert the IPA transcriptions into HTML code: <a href="http://www.unicodetools.com/unicode/convert-to-html.php" target="_blank">Unicode to HTML Converter</a>
                </li>
                <br>
                <img src="csv_save.png" width="500px" />

                <li>Save the file as <b>CSV (MS-DOS)</b> and name the file <em>data_entry</em>.</li>
            </ul>
            <li>Clicking submit will overwrite the old CSV file with the newly uploaded one, and you will be informed whether the upload was successful.</li>
            <img src="upload.png" />
            <img src="success.png" width="500px" />
            <br>
            <br>
            <li>The SQL query above will have been modified according to the new CSV file.</li>
            <br>
            <img src="sql_query.png" />
            <ul>
                <li><em>Note</em>: You may need to wait a few seconds for the changes to occur. Be sure to refresh the page.</li>
            </ul>
            <li>Copy the SQL query and paste it into the text area near the top of the page.</li>
            <br>
            <img src="copy_query.png" />

            <ul>
                <li><b>Warning!</b> Be sure not to add in additional queries. Some changes cannot be reversed.</li>
            </ul>
            <li>Submit the query and you will first be redirected to a confirmation page, and then to the online talking dictionary.</li>
            <br>
            <img src="paste_query.png" />
            <br>
            <img src="submit.png" />

        </ol>
        <hr>
        <p style="font-size:120%"><em>Another way to modify data...</em>
        </p>

        <p>First of all, calm down. Slow, deep breaths. Altering data using this method is a little tricky as you would then need to learn SQL. Fortunately, the alternative is a lot simpler:</p>
        <ol>
            <li>Log into the <a href="https://my.bluehost.com/web-hosting/cplogin" target="_blank"><em>bluehost</em></a> account.</li>
            <li>Go into the cPanel.</li>
            <li>Scroll down towards <em>Database Tools</em> and select <em>phpmyAdmin</em>.</li>
            <li>Log into <em>phpmyAdmin</em> with the same <em>bluehost</em> credentials.</li>
            <li>On the left, click on <em>dictionary</em> right above the option <em>Create table</em>.</li>
            <li>Here, you can edit and delete entries individually or in bulk.</li>
        </ol>
        <p>See, wasn't that easy?!</p>
        <hr>
 
-->
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