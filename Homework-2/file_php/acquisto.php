<?php
require_once("connection.php");
session_start();

if (isset($_POST['conferma'])) {
  if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
  }
  if (empty($_SESSION['carrello'])) {
    header("Location: ../HTML/acquisto_ko.html");
    exit();}
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

  $_SESSION['carrello'] = array();

  header("Location: ../HTML/acquisto_ok.html");
  exit();
} else {
  header("Location: ../HTML/acquisto_ko.html");
}
?>
