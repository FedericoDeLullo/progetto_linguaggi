<?php
    if(!isset($_SESSION['loggato']) || $_SESSION['loggato'] !== true){
        header("location: ../php/login.php");
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Area privata</title>
    </head>
    <body>
        <div class=reg4>
            <h1>Accesso eseguito correttamente!</h1>
        
            <a href="../html/index_loggato.html"> <br>Ritorna al sito</a>
        </div>
    </body>
</html>