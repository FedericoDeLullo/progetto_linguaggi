<?php 
        require_once("connection.php");
        session_start();
    
        if (!isset($_POST['azione'])) {
        
        }
        else if ($_POST['azione'] === 'aggiungi') {
            $id_articolo_scelto = $_POST['id_articolo'];
            $quantita = $_POST['quantita'];

            if (!isset($_SESSION['carrello'][$id_articolo_scelto])) {
                $_SESSION['carrello'][$id_articolo_scelto] = 0;
            }
            $_SESSION['carrello'][$id_articolo_scelto] += $quantita;
        }
    ?>
    
    <!DOCTYPE html> 
<html lang="en">
    <head>
        <link rel="stylesheet" type="text/css" href="../file_css/style.css" />
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Articoli</title>
    </head>
    <body>

    <?php

    if(!isset($_SESSION['loggato'])) {
    header("Location: ../HTML/login.html");
    }
     ?>
     
    <div id="contenuto">
    <div class="title">

    <a href="../HTML/index1.html"><img src="../img/home.png" alt="tasto_home" class="home"></a>

    <h2 class="mod">Articoli Disponibili</h2>

    <a class="ok" href="cart.php"><img src="../img/cart_white.png" alt="tasto_cart" class="carrello"></a>

    <h5 class="mod1">GIOCHI</h5>
    <h5 class="mod2">CONSOLE</h5>
    <h5 class="mod3">MANGA</h5>

</div>
<video autoplay muted loop id="video_back">
    <source src="../video/video_sfondo.mp4" type="video/mp4"></source> 
</video>
    <div id="catalogo-articoli"> 
    <body>


<?php
    
    $xmlFile = "../file_xml/articoli.xml";

    $xml = simplexml_load_file($xmlFile);

    foreach ($xml->prodotti as $prodotti) {
        
                $id_articolo = (string)$prodotti->id_articolo;
                $prezzo = (integer)$prodotti->prezzo;

                $lunghezza = (string)$prodotti->attributes()->lunghezza;

                $PEGI = (string)$prodotti->attributes()->PEGI;

            echo '<div class="articoli">';
            echo '<img src="../img/' . $id_articolo . '.png" class="card"></img>';           
             echo '<p class="pegi">' .$PEGI; '</p>';
             echo '<p class="pegi">' . $lunghezza; '</p>';
             echo '<p class="prezzo">' . $prezzo . ' &euro;</p>';
            echo '<form class="ca" action="articoli.php#articoli' . $id_articolo . '" method="post">';
            echo '<input type="hidden" name="id_articolo" value="' . $id_articolo . '" />';
            echo '<input type="number" name="quantita" value="0" min="0" step="1" size="3" max="99" />';
            echo '<button type="submit" name="azione" value="aggiungi" class="carr">Aggiungi</button>';
            echo '</form>';
            echo '</div>';
    }
        ?>
    </div>

    </body>
</html>