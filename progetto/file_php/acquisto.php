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

    $_SESSION['carrello'] = array();

  header("Location: ../HTML/acquisto_ok.html");
  exit();
} else {
  header("Location: ../HTML/acquisto_ko.html");
}
?>
