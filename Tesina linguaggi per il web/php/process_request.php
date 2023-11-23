<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestione Crediti</title>
    <link rel="stylesheet" href="../css/style_ricarica.css">
</head>
<body>
  <?php

require_once('connection.php');
session_start();
$email = $_SESSION['email'];
$importo = $_POST['importo'];

$sql = "INSERT INTO richieste (email, importo, accettata) VALUES ('$email', $importo, 0)";

if ($connessione->query($sql) === TRUE) {
    echo " <p class = 'richiesta'> Richiesta inviata con successo. Attendere l'approvazione dell'amministratore.</p>";?>
    <a href="../html/index_loggato.html" class="btn1">Torna alla Home</a> <?php
} else {
    echo "Errore nell'invio della richiesta: " . $connessione->error;
}

$connessione->close();
?>  
</body>
</html>

