<?php
require_once("connection.php");
session_start();
?>

<?xml version="1.0" encoding="UTF-8" ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="it" lang="it">
<head>
<link rel="stylesheet" href="../file_css/style.css" type="text/css">

  <title>Ultimi Acquisti</title>
</head>

<body>

  <div class="cart">
    <h2 class="tito">ULTIMI ACQUISTI</h2>

    <div>
      <ul class="elenco_articoli">
<?php 
  $xmlFile = "../file_xml/articoli.xml";

  $xml = simplexml_load_file($xmlFile);

  if (isset($_SESSION['elenco_acquisti'])) {
    foreach ($xml->prodotti as $prodotti) {

      $id_articolo = (string)$prodotti->id_articolo;
      $nome = (string)$prodotti->nome;
      $prezzo = (integer)$prodotti->prezzo;
  
      if (!isset($_SESSION['elenco_acquisti'][$id_articolo])) {
         continue;
      }

      $quantita = $_SESSION['elenco_acquisti'][$id_articolo];
      if ($quantita <= 0) {
         continue;
      }

?>
        <li><?php echo($nome); ?>, <?php echo($prezzo); ?> &euro;
        </li>
<?php
    }
  }
?>

      </ul>
</div>
      <div>
      <a href="../HTML/index1.html"><button class="home_acq">Torna alla Homepage</button></a>
      </div>

</body>
</html>