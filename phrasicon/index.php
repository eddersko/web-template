<?php 
$xmlDoc=new DOMDocument(); 
$xmlDoc->load("phrasicon.xml"); 
$xpath = new DOMXPath($xmlDoc); 
$entries = $xpath->query("//phrase"); 
$count = $entries->length; 
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>Phrasicon Template</title>
    <meta name="keywords" content="phrasicon, language learning, language tools" />
    <meta name="description" content="Multi-layered Language Learning Resources" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="author" content="User" />
    <meta name="copyright" content="User" />
    <link rel="stylesheet" href="css/foundation.css" />
    <script src="js/vendor/modernizr.js"></script>
    <script src="js/loadxmldoc.js"></script>
</head>

<body>

    <!-- Menu Bar. -->
    <div class="fixed">
        <nav class="top-bar" data-topbar>
            <ul class="title-area">

                <li class="name">
                    <h1>
                  <a href="../">
                    Back to Main Menu
                  </a>
                </h1>
                </li>
                <li class="toggle-topbar menu-icon"><a href="#"><span>menu</span></a>
                </li>
            </ul>

            <section class="top-bar-section">

                <ul class="right">
                    <li class="divider"></li>
                    <li class="name">
                        <!-- Link to Dictionary. -->
                        <h1>
                        <a href="../dictionary">Online Talking Dictionary</a>
                        </h1>
                    </li>
                    <li class="divider"></li>
                </ul>
            </section>
        </nav>
    </div>


    <div class="row">
        <div class="large-12 columns">

            <hr>
            <!-- Title of Page. -->
            <h4 class="title"><a class="home" href="../phrasicon/">Online Phrasicon Template</a></h4>
            <hr>

            <!-- Search Menu (title)-->
            <h4 class="subsubheader">English Word Lookup</h4>

            <!-- Search Menu (A-Z) -->
            <ul class="pagination">
                <center>
                    <li><a href="../phrasicon/category.php?letter=a&lang=eng">a</a>
                    </li>
                    <li><a href="../phrasicon/category.php?letter=b&lang=eng">b</a>
                    </li>
                    <li><a href="../phrasicon/category.php?letter=c&lang=eng">c</a>
                    </li>
                    <li><a href="../phrasicon/category.php?letter=d&lang=eng">d</a>
                    </li>
                    <li><a href="../phrasicon/category.php?letter=e&lang=eng">e</a>
                    </li>
                    <li><a href="../phrasicon/category.php?letter=f&lang=eng">f</a>
                    </li>
                    <li><a href="../phrasicon/category.php?letter=g&lang=eng">g</a>
                    </li>
                    <li><a href="../phrasicon/category.php?letter=h&lang=eng">h</a>
                    </li>
                    <li><a href="../phrasicon/category.php?letter=i&lang=eng">i</a>
                    </li>
                    <li><a href="../phrasicon/category.php?letter=j&lang=eng">j</a>
                    </li>
                    <li><a href="../phrasicon/category.php?letter=k&lang=eng">k</a>
                    </li>
                    <li><a href="../phrasicon/category.php?letter=l&lang=eng">l</a>
                    </li>
                    <li><a href="../phrasicon/category.php?letter=m&lang=eng">m</a>
                    </li>
                    <li><a href="../phrasicon/category.php?letter=n&lang=eng">n</a>
                    </li>
                    <li><a href="../phrasicon/category.php?letter=o&lang=eng">o</a>
                    </li>
                    <li><a href="../phrasicon/category.php?letter=p&lang=eng">p</a>
                    </li>
                    <li><a href="../phrasicon/category.php?letter=q&lang=eng">q</a>
                    </li>
                    <li><a href="../phrasicon/category.php?letter=r&lang=eng">r</a>
                    </li>
                    <li><a href="../phrasicon/category.php?letter=s&lang=eng">s</a>
                    </li>
                    <li><a href="../phrasicon/category.php?letter=t&lang=eng">t</a>
                    </li>
                    <li><a href="../phrasicon/category.php?letter=u&lang=eng">u</a>
                    </li>
                    <li><a href="../phrasicon/category.php?letter=v&lang=eng">v</a>
                    </li>
                    <li><a href="../phrasicon/category.php?letter=w&lang=eng">w</a>
                    </li>
                    <li><a href="../phrasicon/category.php?letter=x&lang=eng">x</a>
                    </li>
                    <li><a href="../phrasicon/category.php?letter=y&lang=eng">y</a>
                    </li>
                    <li><a href="../phrasicon/category.php?letter=z&lang=eng">z</a>
                    </li>
                </center>
            </ul>



            <div class="row collapse">
                <div class="large-2 small-3 columns">
                    <form name="form1" action="../phrasicon/word.php" method="post">
                        <!-- Language options. -->
                        <select name="lang">
                            <option value="english">English</option>
                            <option value="source">Source</option>
                        </select>

                </div>

                <div class="large-6 small-4 columns">
                    <!-- Search bar. -->
                    <input type="text" placeholder="Type word..." name="word">

                </div>
                <div class="large-3 small-3 columns">
                    <!-- Submit button. -->
                    <input class="button postfix" type="submit" value="Submit">
                </div>
                <div class="large-1 small-2 columns">

                    <!-- Dropdown for special characters. -->
                    <a class="button dropdown postfix" data-dropdown="drop"></a>
                    <ul id="drop" class="f-dropdown" data-dropdown-content>
                        <li><a onmouseover="showtip(this,event,'U02B0')" onmouseout=hidetip() href="javascript:;" onclick="form1.word.value=form1.word.value + 'ʔ';">ʔ</a> 
                        </li>
                    </ul>

                </div>

            </div>
<div class="row collapse">
    			&nbsp;<input id="checkbox1" type="checkbox" name="hyper" value="hyper"><label for="checkbox1">Hyper Search</label>
    </div>
                    </form>

            <p>
                <!-- Picture here. -->
                <img src="background_phrasicon.jpg" />
            </p>

        </div>
    </div>

    <!-- The About section starts here... -->
    <div class="row">
        <div class="large-12 columns">

            <!-- Title of About Section -->
            <h4 class="subheader">About the Phrasicon</h4>

            <!-- There are <?php echo $count ?> entries in the phrasicon. -->
            
            <!-- Paragraph #1 -->
            <p>Lorem ipsum dolor sit amet, eu mollis vel. Non feugiat eu magna nulla sapien, per justo tellus vel dui. Amet phasellus suspendisse orci cras habitasse, in ut mauris diam, egestas cras interdum, egestas aliquet felis in varius justo lectus, erat amet adipiscing. Convallis sagittis mollis, rhoncus metus vitae proin erat libero maecenas, viverra dapibus vitae, amet sapien velit habitant, nostra suspendisse. Egestas sodales nascetur molestie interdum ipsum, lacus sed, leo neque vitae massa urna pellentesque turpis. Dui cras, a posuere at nec.</p>

            <!-- Paragraph #2 -->
            <p>Consectetuer consectetuer neque, sem ultrices. Tortor et interdum tristique, maecenas malesuada justo in velit fermentum, lorem sed amet. Eget bibendum posuere mollis id in malesuada, risus amet, tristique velit vitae. Rhoncus massa, lobortis eget nulla non a tincidunt facilisis, elit pellentesque urna vestibulum enim tincidunt fusce. Placerat magna quam tincidunt neque ullamcorper non. Leo neque, pede et ipsum sed elit, ut ut, feugiat amet eu. Luctus nulla ligula, eleifend posuere integer nunc, tortor ut dui sit odio curabitur cursus, metus suspendisse tempor. Malesuada sed vivamus elit, congue praesent augue vel, molestie ipsum pede diam at nunc aliquet, dictumst suspendisse dui, tincidunt justo suspendisse justo mauris at. Eget in accumsan, semper nulla elit ligula per ante, lobortis tempus risus ullamcorper, in lobortis. Aliquam magna, fermentum metus vehicula consectetuer mattis est, mauris placerat adipiscing sem ornare nunc. Risus nullam etiam sed, enim auctor commodo ante, duis nullam eget nam vitae. Torquent mi suspendisse libero sapien molestie risus, felis est nascetur aenean, elementum non ultrices wisi pellentesque ac leo, at dui facilisi.</p>
            <br>
        </div>
    </div>

    <!-- ...ends here. -->

    <script src="js/vendor/jquery.js"></script>
    <script src="js/foundation/foundation.js"></script>
    <script>
        $(document).foundation();

        var doc = document.documentElement;
        doc.setAttribute('data-useragent', navigator.userAgent);
    </script>
</body>

</html>