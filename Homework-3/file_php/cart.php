
<?php
require_once("connection.php");
session_start();

if (!isset($_POST['azione'])) {
} else if ($_POST['azione'] === 'modifica') {
  $id_articolo_scelto = $_POST['id_articolo'];
  $quantita = $_POST['quantita'];

  $_SESSION['carrello'][$id_articolo_scelto] = $quantita * 1;
} else if ($_POST['azione'] === 'rimuovi') {
  $id_articolo_scelto = $_POST['id_articolo'];

  unset($_SESSION['carrello'][$id_articolo_scelto]);
}
if (isset($_SESSION['crediti'])) {
  $crediti = $_SESSION['crediti'];
}
?>

<?xml version="1.0" encoding="UTF-8" ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="it" lang="it">
<head>
<link rel="stylesheet" href="../file_css/style.css" type="text/css">

  <title>Carrello</title>
</head>

<body>

  <div class="cart">
    <h2 class="tito">CARRELLO</h2>

    <div>
      <ul class="elenco_articoli">
<?php 
  $xmlFile = "../file_xml/articoli.xml";

  $xml = simplexml_load_file($xmlFile);

  $totale = 0;
  if (isset($_SESSION['carrello'])) {
    foreach ($xml->prodotti as $prodotti){
      $id_articolo = (string)$prodotti->id_articolo;
      $nome = (string)$prodotti->nome;
      $prezzo = (integer)$prodotti->prezzo;
  
      if (!isset($_SESSION['carrello'][$id_articolo])) {
        continue;
      }

      $quantita = $_SESSION['carrello'][$id_articolo];
      if ($quantita <= 0) {
        continue;
      }

      $totale += $quantita * $prezzo;
     
?>
        <li><?php echo($nome); ?>, <?php echo($prezzo); ?> &euro;
          <form class="c" action="cart.php" method="post">
            <input type="hidden" name="id_articolo" value="<?php echo ($id_articolo); ?>" />
            <input type="number" name="quantita" value="<?php echo($quantita); ?>" min="0" step="1" size="3" max="99" />
            <button type="submit" name="azione" value="modifica" class="cart-btn" title="modifica">Modifica</button>
            <button type="submit" name="azione" value="rimuovi" class="cart-btn" title="rimuovi">Rimuovi</button>
          </form>
        </li>
<?php
    }
  }
?>
      </ul>
<?php
    if ($totale === 0) {
?>
      <h2 class="tit">Carrello vuoto</h2>
<?php
    }
?>

        <b>Totale</b>:
      
        <span class="prezzo"><?php echo($totale); ?>&euro;</span>
        <br></br>
        <b>Crediti disponibili</b>: 
        <span class="prezzo"><?php echo($crediti); ?>&euro;</span>
    
      </p>
    </div>

    <div>
        <a href="articoli.php"> <button class="btn">Indietro</button></a>
       
        <form action="acquisto.php" method="post"> 
  <input type="submit" name="conferma" value="Conferma acquisto" class="btn" />
</form>
  </div>
   
</body>

</html>