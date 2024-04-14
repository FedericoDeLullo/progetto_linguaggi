<?php
include 'cart.php';
require_once("connection.php");
session_start();


if (isset($_POST['conferma'])) {
  if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
  }
  if (isset($_SESSION['crediti'])) {
  $crediti = $_SESSION['crediti'];
}
if (isset($_SESSION['username'])) {
  $username = $_SESSION['username'];
}
  if (empty($_SESSION['carrello'])) {
    header("Location: ../HTML/acquisto_ko.html");
    exit(); 
  }

  if ($crediti<$totale){
    header("Location: ../HTML/crediti_insuff.html");
  }else{
    header("Location: ../HTML/acquisto_ok.html");

    $nuovi_crediti=$crediti-$totale;
    $_SESSION['crediti']=$nuovi_crediti;

    $_SESSION['elenco_acquisti'] = $_SESSION['carrello'];
    $_SESSION['carrello'] = array();

    $query = "UPDATE utenti SET crediti = $nuovi_crediti WHERE username = '$username'";
    $result = mysqli_query($connessione, $query);
            if (!$result) {
                printf("Errore nella query.\n");
               exit();
            }
 
}


}
else {
  header("Location: ../HTML/acquisto_ko.html");
}
?>
