
<?php
require_once("connection.php");
session_start();

if (!isset($_POST['azione'])) {
} else if ($_POST['azione'] === 'modifica') {
  $id_articolo = $_POST['id_articolo'];
  $quantita = $_POST['quantita'];

  $_SESSION['carrello'][$id_articolo] = $quantita * 1;
} else if ($_POST['azione'] === 'rimuovi') {
  $id_articolo = $_POST['id_articolo'];

  unset($_SESSION['carrello'][$id_articolo]);
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
  $totale = 0;
  if (isset($_SESSION['carrello'])) {
    $query = "SELECT * FROM articoli";
    $result = mysqli_query($connessione, $query);
    if (!$result) {
      printf("Errore nella query.\n");
      exit();
    }

    while ($articolo = mysqli_fetch_assoc($result)) {
      if (!isset($_SESSION['carrello'][$articolo['id_articolo']])) {
        continue;
      }

      $quantita = $_SESSION['carrello'][$articolo['id_articolo']];
      if ($quantita <= 0) {
        continue;
      }

      $totale += $quantita * $articolo['prezzo'];
?>
        <li><?php echo($articolo['nome']); ?>, <?php echo($articolo['prezzo']); ?> &euro;
          <form class="c" action="cart.php" method="post">
            <input type="hidden" name="id_articolo" value="<?php echo ($articolo['id_articolo']); ?>" />
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
      </p>
    </div>

    <div>
        <a href="articoli.php"> <button class="btn">Indietro</button></a>
       
        <form action="acquisto.php" method="post"> 
  <input type="submit" name="conferma" value="Conferma acquisto" class="btn" />
</form>

   
</body>

</html>