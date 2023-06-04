<?php
    session_start();

    if(isset($_COOKIE["tema"]) && $_COOKIE["tema"] == "dark"){
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
      <li><a href="login.php">Login</a></li>
      <li><a href="#">Home</a></li>
      <li><a href="../file_php/articoli.php">Articoli</a></li>
      <li><a href="#contatti">Contatti</a></li>
 
     <?php   
        echo "<form action = \"../file_php/darkmode.php\" method='POST'>";
        echo "<button class=\"but\"  name=\"light\" type=\"submit\" value= \"light\">";
        echo "<img class=\"dark\" src = \"../img/sole.png\"></img></button>";
        echo "<button class=\"but\" name=\"dark\" type=\"submit\" value= \"dark\">";
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