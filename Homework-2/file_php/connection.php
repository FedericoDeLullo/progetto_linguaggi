<?php
    $host = "localhost:3308";
    $username = "root";
    $password = "";
    $db = "GameStation";

    $connessione = new mysqli($host, $username, $password, $db);

    if($connessione == false){
        die("Errore durante la connessione: ".$connessione->connect_error);
    }

?>
