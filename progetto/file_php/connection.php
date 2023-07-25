<?php
    $host = "127.0.0.1";
    $username = "root";
    $password = "";
    $db = "GameStation2";

    $connessione = new mysqli($host, $username, $password, $db);

    if($connessione == false){
        die("Errore durante la connessione: ".$connessione->connect_error);
    }

?>
