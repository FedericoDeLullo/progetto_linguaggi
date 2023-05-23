<?php
    session_start();

    if(isset($_COOKIE["tema"]) && $_COOKIE["tema"] == "dark1"){
        echo "<link rel=\"stylesheet\" href=\"../file_css/style_dark.css\" type=\"text/css\" />";
    }
    else{
        echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../file_css/style.css\"/>";
    }
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <head>
    <title>Game Station</title>        
  </head>
 
  <body>

  
    <ul id="menu">
      <li><a href="../file_php/logout.php">Logout</a></li>
      <li><a href="#">Home</a></li>
      <li><a href="../file_php/articoli.php">Articoli</a></li>
      <li><a href="#contatti">Contatti</a></li>
       
  <?php   
        echo "<form action = \"../file_php/darkmode.php\" method='POST'>";
        echo "<button class=\"but\"  name=\"light1\" type=\"submit\" value= \"light1\">";
        echo "<img class=\"dark\" src = \"../img/sole.png\"></img></button>";
        echo "<button class=\"but\" name=\"dark1\" type=\"submit\" value= \"dark1\">";
        echo "<img class=\"dark\" src = \"../img/luna.png\" ></img></button>";
        echo "</form>";
    ?>


    </ul>
 
    <div class="header">
      <div><img src="../img/iconGS.PNG" alt=""/></div>
      <div><img src="../img/GameStation.PNG" alt=""/></div>     
    </div>

    <div class="hero">  
      <div class="hero__content">
        <img src="../img/home_1.png" class="foto" alt=""/>
        <img src="../img/home_2.png" class="foto" alt=""/>
      </div>
    </div>



    <div class="slider-container">
      <span id="slider-image-1"></span>
      <span id="slider-image-2"></span>
      <span id="slider-image-3"></span>
      <span id="slider-image-4"></span>
      <span id="slider-image-5"></span>
      <div class="image-container">
        <img src="../img/container_1.png" class="slider-image" alt="PlayStation"/>
        <img src="../img/container_2.png" class="slider-image" alt="Xbox"/>
        <img src="../img/container_3.png" class="slider-image" alt="Nintendo"/>
        <img src="../img/container_4.png" class="slider-image" alt="EAsports"/>
        <img src="../img/container_5.png" class="slider-image" alt="Ubisoft"/>
      </div>

      <div class="button-container">
        <a href="#slider-image-1" class="slider-change"></a>
        <a href="#slider-image-2" class="slider-change"></a>
        <a href="#slider-image-3" class="slider-change"></a>
        <a href="#slider-image-4" class="slider-change"></a>
        <a href="#slider-image-5" class="slider-change"></a>
      </div>
    </div>

                  
    <div class="footer">                 
      <a name="contatti"></a>

<ul class="cont" >
  <li class="servizi">Servizi e supporto</li>
  <li class="contatti">Supporto tecnico</li>
  <li class="contatti">Consulenza</li>
  <li class="contatti">Servizio clienti</li>
</ul>


<ul class="cont">
  <li class="servizi">Note legali</li> 
  <li class="contatti">Privacy center</li>
  <li class="contatti">Cookie policy</li>
  <li class="contatti">Privacy policy</li>
</ul>

<ul class="cont">
  <li class="servizi">Servizi</li>
  <li class="contatti">Traccia il tuo ordine</li>
  <li class="contatti">Ritiro usato</li>
  <li class="contatti">Verifica validità</li>
</ul>



<h5 class="servizi_social" >Social</h5>
<ul class="social_icon">
  <li class="social">c</li>
  <li class="social">f</li>
  <li class="social">g</li>
  <li class="social">t</li>
  <li class="social">n</li>
</ul>
    </div>

  </body> 
</html>