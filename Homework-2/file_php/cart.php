<?php
require_once("connection.php");

$conn_db = connessione_db();

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
}
?>

<?xml version="1.0" encoding="UTF-8" ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="it" lang="it">
<head>
  <title>Carrello &ndash; R&amp;C gym</title>

  <link rel="stylesheet" type="text/css" href="../file_css/style.css" />
</head>

<body>

  <div class="cart">
    <h2>CARRELLO</h2>

    <div>
      <ul class="lista-carrello">
<?php
  $totale = 0;
  if (isset($_SESSION['carrello'])) {
    $query = "SELECT * FROM articoli";
    $result = mysqli_query($conn_db, $query);
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
            <button type="submit" name="azione" value="modifica" class="button-icona ml-8" title="modifica quantita">&#x01F4DD</button>
            <button type="submit" name="azione" value="rimuovi" class="button-icona ml-8" title="rimuovi elemento">&#x01F5D1</button>
          </form>
        </li>
        <hr class="mt-8 mb-8 hr-corsi" />
<?php
    }
  }
?>
      </ul>
<?php
    if ($totale === 0) {
?>
      <h2 class="centrato prezzo">Carrello vuoto, non &egrave; possibile proseguire con l&rsquo;ordine!</h2>
<?php
    }
?>

      <p class="risultato-carrello" class="mt-32">
        <b>Totale</b>:
        <span class="prezzo"><?php echo($totale); ?>&euro;</span>
      </p>
    </div>

    <div class="centrato pt-64">
        <a id="indietro-carrello" class="button" href="shop.php">Indietro</a>
        <a id="indietro-carrello" class="button" href="ordine.php" <?php if($totale === 0) { ?> style="pointer-events: none;" <?php } ?>>Prosegui ordine</a>
    </div>
  </div>
</body>

</html>