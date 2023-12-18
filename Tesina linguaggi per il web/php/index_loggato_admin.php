<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="../css/style_ham.css">
    <link rel="stylesheet" href="../css/style_index.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
</head>
<body>
  <?php
$xmlFile = '../xml/requests.xml';
$dom = new DOMDocument();
$dom->load($xmlFile);

$requests = $dom->getElementsByTagName('request');
$hasPendingRequests = false;
foreach ($requests as $request) {
  $status = $request->getAttribute('status');

  if ($status == 'pending') {
      $hasPendingRequests = true;
      }
    }
    ?>

    <div class="background-slider">

<div class="header">
            <div class="header_menu">  
              <div class="hamburger-menu">
                <input id="menu__toggle" type="checkbox" />
                <label class="menu__btn" for="menu__toggle">
                  <span></span>
                </label>
            
                <ul class="menu__box">
                  <li><a class="menu__item" href="admin_approval.php">Accetta Crediti<?php
                            if ($hasPendingRequests) {
                                echo '<span id="note" class="material-symbols-outlined">
                                notifications_unread
                                </span>';
                            }
                            ?></a></li>
                  <li><a class="menu__item" href="#">Recensioni</a></li>
                </ul>
              </div>
              <div class="header_menu_item"><a href="catalogo.php" class="stile">
                <div class="header_menu_link" title="Magliette">Catalogo</div>

               </div>
            </a>
            <div class="header_menu_item"><a href="#"class="stile">
                <div class="header_menu_link" title="Pantaloncini">Profilo</div>
                
               </div>
            </a>
               <div class="header_menu_item"><a href="gestione_utenti.php"class="stile">
                <div class="header_menu_link" title="Calzettoni">Gestione Utenti</div>
                
               </div>
            </a>
                
            <div class="header_menu_item"><a href="#"class="stile">
                <div class="header_menu_link" title="Tute">FAQ</div>
            </div>
           </a>
              <div class="login"><a href="../html/index.html" class="stile"><span class="material-symbols-outlined">
                logout
                </span>
              </div>  
            </a>
            <div class="cart"><a href="#">
                <div class="cart_link" title="cart"><img src="../img/cart.png" alt="carrello"></div>
            </div>
         </a>
        </div>
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
    <li class="servizi">About Us</li> 
    <li class="contatti">Chi siamo?</li>
    <li class="contatti">Dove siamo?</li>
    <li class="contatti">Contatti</li>
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