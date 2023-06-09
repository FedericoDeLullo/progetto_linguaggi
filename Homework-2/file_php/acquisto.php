<?php
require_once("connection.php");
session_start();

if (isset($_POST['conferma'])) {
  // Controlla se l'utente è loggato
  if (!isset($_SESSION['username'])) {
    // Reindirizza l'utente al login se non è loggato
    header("Location: login.php");
    exit();
  }

  // Prendi l'ID dell'utente loggato
  $username = $_SESSION['username'];


  foreach ($_SESSION['carrello'] as $id_articolo => $quantita) {
    if ($quantita <= 0) {
      continue;
    }

    $query = "INSERT INTO acquisti (username, id_articolo, quantita) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($connessione, $query);
    mysqli_stmt_bind_param($stmt, "ssi", $username, $id_articolo, $quantita);
    mysqli_stmt_execute($stmt);
  }

  // Svuota il carrello dopo aver completato l'acquisto
  $_SESSION['carrello'] = array();

  // Reindirizza l'utente a una pagina di conferma o a una pagina successiva
  header("Location: articoli.php");
  exit();
} else {
  // Se l'utente accede a questa pagina senza inviare il modulo di conferma, reindirizzalo altrove o visualizza un messaggio di errore.
  header("Location: error.php");
  exit();
}
?>
