<?php

$xmlDoc = new DOMDocument();
$xmlDoc->load("phrasicon.xml");
    
$xpath = new DOMXPath($xmlDoc);
$entries = $xpath->query("//phrase");

$count = $entries->length; 

?>

<!DOCTYPE html>
<html class="no-js" lang="en">
  
  <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Phrasicon Template</title>
        <link rel="stylesheet" href="css/foundation.css" />
        <script src="js/vendor/modernizr.js"></script>
      <script type="text/javascript" src="//use.typekit.net/gxp8lxg.js"></script>
<script type="text/javascript">try{Typekit.load();}catch(e){}</script>
   
  </head>
    
  <body>

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
              <li class="toggle-topbar menu-icon"><a href="#"><span>menu</span></a></li>
            </ul>
         
            <section class="top-bar-section">
               
              <ul class="right">
                <li class="divider"></li>
                <li>
              <a href="../dictionary">Online Talking Dictionary</a>
                </li>
                <li class="divider"></li>
              </ul>
            </section>
          </nav></div>
   

    <div class="row">
    <div class="large-12 columns">    
        
        <hr>
        <h4 class="title"><a class="home" href="../phrasicon/">Online Phrasicon Template</a></h4>
        
        <hr>
        
        
        
        <h4 class="subsubheader">English Word Lookup</h4>

        <ul class="pagination"> 
          <center><li><a href="../phrasicon/category.php?letter=a&lang=eng">a</a></li> 
          <li><a href="../phrasicon/category.php?letter=b&lang=eng">b</a></li> 
          <li><a href="../phrasicon/category.php?letter=c&lang=eng">c</a></li> 
          <li><a href="../phrasicon/category.php?letter=d&lang=eng">d</a></li> 
          <li><a href="../phrasicon/category.php?letter=e&lang=eng">e</a></li> 
          <li><a href="../phrasicon/category.php?letter=f&lang=eng">f</a></li> 
          <li><a href="../phrasicon/category.php?letter=g&lang=eng">g</a></li> 
          <li><a href="../phrasicon/category.php?letter=h&lang=eng">h</a></li> 
          <li><a href="../phrasicon/category.php?letter=i&lang=eng">i</a></li> 
          <li><a href="../phrasicon/category.php?letter=j&lang=eng">j</a></li> 
          <li><a href="../phrasicon/category.php?letter=k&lang=eng">k</a></li> 
          <li><a href="../phrasicon/category.php?letter=l&lang=eng">l</a></li> 
          <li><a href="../phrasicon/category.php?letter=m&lang=eng">m</a></li> 
          <li><a href="../phrasicon/category.php?letter=n&lang=eng">n</a></li> 
          <li><a href="../phrasicon/category.php?letter=o&lang=eng">o</a></li> 
          <li><a href="../phrasicon/category.php?letter=p&lang=eng">p</a></li> 
          <li><a href="../phrasicon/category.php?letter=q&lang=eng">q</a></li> 
          <li><a href="../phrasicon/category.php?letter=r&lang=eng">r</a></li> 
          <li><a href="../phrasicon/category.php?letter=s&lang=eng">s</a></li> 
          <li><a href="../phrasicon/category.php?letter=t&lang=eng">t</a></li> 
          <li><a href="../phrasicon/category.php?letter=u&lang=eng">u</a></li> 
          <li><a href="../phrasicon/category.php?letter=v&lang=eng">v</a></li> 
          <li><a href="../phrasicon/category.php?letter=w&lang=eng">w</a></li> 
          <li><a href="../phrasicon/category.php?letter=x&lang=eng">x</a></li> 
          <li><a href="../phrasicon/category.php?letter=y&lang=eng">y</a></li> 
          <li><a href="../phrasicon/category.php?letter=z&lang=eng">z</a></li></center>
        </ul>

         

        <div class="row collapse"> 
                          <div class="large-2 small-3 columns"> 
                                          <form name="form1" action="../phrasicon/word.php" method="post">

                <select name="lang">
  <option value="english">English</option>
  <option value="pomo">Source</option>
</select>

        </div> 
       
           <div class="large-6 small-4 columns"> 
            <input type="text" placeholder="Type word..." name="word"> 
                
            </div>
        <div class="large-3 small-3 columns"> 
          <input class="button postfix" type="submit" value="Submit">
            </form>
        </div> 
         <div class="large-1 small-2 columns"> 
    <a class="button dropdown postfix" data-dropdown="drop"></a>
   <ul id="drop" class="f-dropdown" data-dropdown-content>  
       <li><a onmouseover="showtip(this,event,'U02B0')" 
  onmouseout=hidetip() href="javascript:;" onclick="form1.word.value=form1.word.value + 'ʔ';">ʔ</a> </li>
   </ul>
        </div>                              
                              
        </div>

        
        <p><img src="background.jpg"/></p>    

    </div>
    </div>

    <div class="row">
    <div class="large-12 columns">

        <h4 class="subheader">About the Template</h4>
                        <p align="justify">Lorem ipsum dolor sit amet, eu mollis vel. Non feugiat eu magna nulla sapien, per justo tellus vel dui. Amet phasellus suspendisse orci cras habitasse, in ut mauris diam, egestas cras interdum, egestas aliquet felis in varius justo lectus, erat amet adipiscing. Convallis sagittis mollis, rhoncus metus vitae proin erat libero maecenas, viverra dapibus vitae, amet sapien velit habitant, nostra suspendisse. Egestas sodales nascetur molestie interdum ipsum, lacus sed, leo neque vitae massa urna pellentesque turpis. Dui cras, a posuere at nec. </p>
            <p align="justify">Consectetuer consectetuer neque, sem ultrices. Tortor et interdum tristique, maecenas malesuada justo in velit fermentum, lorem sed amet. Eget bibendum posuere mollis id in malesuada, risus amet, tristique velit vitae. Rhoncus massa, lobortis eget nulla non a tincidunt facilisis, elit pellentesque urna vestibulum enim tincidunt fusce. Placerat magna quam tincidunt neque ullamcorper non. Leo neque, pede et ipsum sed elit, ut ut, feugiat amet eu. Luctus nulla ligula, eleifend posuere integer nunc, tortor ut dui sit odio curabitur cursus, metus suspendisse tempor. Malesuada sed vivamus elit, congue praesent augue vel, molestie ipsum pede diam at nunc aliquet, dictumst suspendisse dui, tincidunt justo suspendisse justo mauris at. Eget in accumsan, semper nulla elit ligula per ante, lobortis tempus risus ullamcorper, in lobortis. Aliquam magna, fermentum metus vehicula consectetuer mattis est, mauris placerat adipiscing sem ornare nunc. Risus nullam etiam sed, enim auctor commodo ante, duis nullam eget nam vitae. Torquent mi suspendisse libero sapien molestie risus, felis est nascetur aenean, elementum non ultrices wisi pellentesque ac leo, at dui facilisi.</p>    
        <br>
    </div>
    </div>



    <footer class="row">
        <div class="large-12 columns">
        <hr/>
        <div class="row">
        <div class="large-12 columns">
            <h4 class="subsubheader" style="text-align:center">Copyright 2014 &copy; User</h4><br>
        </div>
        </div>
        </div> 
    </footer>
    <script src="js/vendor/jquery.js"></script>
<script src="js/foundation/foundation.js"></script>
<script>
      $(document).foundation();

      var doc = document.documentElement;
      doc.setAttribute('data-useragent', navigator.userAgent);
    </script>
  </body>

</html>