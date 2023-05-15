<?php
require_once("config.php");


session_start();

if (!isset($_POST['azione'])) {
  // Non fa niente
} else if ($_POST['azione'] === 'modifica') {
  $id_articolo = $_POST['id_articolo'];
  $quantita = $_POST['quantita'];

  $_SESSION['carrello'][$id_articolo] = $quantita * 1;
} else if ($_POST['azione'] === 'rimuovi') {
  $id_articolo = $_POST['id_articolo'];

  unset($_SESSION['carrello'][$id_articolo]);
} else if ($_POST['azione'] === 'svuota') {
  unset($_SESSION['carrello']);
}

?>

<?xml version="1.0" encoding="UTF-8" ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="it" lang="it">
<head>
  <title>Carrello</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Baloo+Bhaijaan+2&amp;display=swap" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Rampart+One&amp;display=swap" />
  <link rel="stylesheet" type="text/css" href="../file_css/style.css" />
</head>

<body>


  <div class="carrello">
    <h2>CARRELLO</h2>

    <div>
      <ul id="lista-carrello">
<?php
  $totale = 0;
  if (isset($_SESSION['carrello'])) {
    $query = "SELECT * FROM prodotti" ;
    $result = mysqli_query($connessione, $query);
    if (!$result) {
      printf("Errore nella query.\n");
      exit();
    }

    while ($articolo = mysqli_fetch_assoc($result)) {
      if (!isset($_SESSION['carrello'][$articolo['id']])) {
        continue;
      }

      $quantita = $_SESSION['carrello'][$articolo['id']];
      if ($quantita <= 0) {
        continue;
      }

      $totale += $quantita * $articolo['prezzo'];
?>
        <li><?php echo($articolo['nome']); ?>, <?php echo($articolo['prezzo']); ?> &euro;
          <form class="mt-8" action="carrello.php" method="post">
            <input type="hidden" name="id_articolo" value="<?php echo ($articolo['id']); ?>" />
            <input type="number" name="quantita" value="<?php echo($quantita); ?>" min="0" step="1" size="3" max="99" />
            <button type="submit" name="azione" value="rimuovi" class="button">Rimuovi</button>
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
      <h1 class="prezzo">Carrello vuoto!</h1>
<?php
    }
?>

      <p id="risultato-carrello" >
        <b>Totale</b>:
        <span class="prezzo"><?php echo($totale); ?>&euro;</span>
      </p>
    </div>

    <div>
      <form action="carrello.php" method="post">
        <a id="indietro-carrello" class="button" href="articoli.php">Indietro</a>
        <button type="submit" name="azione" value="svuota" class="button">Svuota carrello</button>
      </form>
    </div>
  </div>

  

</body>

</html>