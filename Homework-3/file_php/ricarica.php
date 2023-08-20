<?php
   require_once('connection.php');
   session_start();

   $username = $_SESSION['username'];
   $creditoresiduo =  $_SESSION['crediti'];

   $ricarica = $connessione->real_escape_string($_POST['ricarica']);

   $credito = $creditoresiduo + $ricarica;

    if($_SERVER["REQUEST_METHOD"]==="POST") {

       $query = "UPDATE utenti SET crediti = $credito WHERE username = '$username'";

       $result = $connessione->query($query);
        if (!$result) {
            printf("Errore nella query di update del credito.\n");
            exit();
        }
       $_SESSION['crediti'] = $credito;
       header("Location: ../HTML/index1.html");

    }
?>
