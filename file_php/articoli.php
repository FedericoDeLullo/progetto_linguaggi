<?php
require_once("config.php");


session_start();

if (!isset($_POST['azione'])) {
  // Non fa niente
} else if ($_POST['azione'] === 'aggiungi') {
  $id_articolo = $_POST['id_articolo'];
  $quantita = $_POST['quantita'];

  if (!isset($_SESSION['carrello'][$id_articolo])) {
    $_SESSION['carrello'][$id_articolo] = 0;
  }
  $_SESSION['carrello'][$id_articolo] += $quantita;
}
?>

<?xml version="1.0" encoding="UTF-8" ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="it" lang="it">
<head>
  <title>Articoli</title>
 
  <link rel="stylesheet" type="text/css" href="../file_css/style.css" />
</head>

<body>


  <div id="contenuto">
<h2>Articoli Disponibili</h2>
    <a href="carrello.php"><button type="button"  value="Vai al carrello" class="button-carrello">Vai al carrello</button></a>

    
    <a href="../file_html/index1.html"><button type="button"  value="Home" class="button-home">Home</button></a>


    <div id="catalogo-articoli"> 

<?php
  $query = "SELECT * FROM  prodotti" ;
  $result = mysqli_query($connessione, $query);
  if (!$result) {
    printf("Errore nella query.\n");
    exit();
  }
 
  while ($row = mysqli_fetch_assoc($result)) {
?>

      <div class="articoli">
       
        <img src="../img_car/<?php echo ($row['id']); ?>.png"  class="card" ></img>
        
        <form class="ciao" action="articoli.php#articoli<?php echo ($row['id']); ?>" method="post">
          <input type="hidden"  name="id_articolo" value="<?php echo ($row['id']); ?>" />
          <input type="number" name="quantita" value="0" min="0" step="1" size="3" max="99" />
          <p class="prezzo"><?php echo ($row['prezzo']); ?> &euro;</p>
          <button type="submit" name="azione" value="aggiungi" class="button">Aggiungi</button>
        </form>
      </div>
<?php
  }
?>

   


</body>

</html>