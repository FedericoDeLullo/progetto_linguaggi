<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style_crediti.css">
    <title>Approvazione Crediti</title>
</head>
<body>
<?php
require_once('connection.php');


// Recupera l'ID della richiesta approvata
$request_id = $_POST['id'];

// Aggiorna lo stato della richiesta nel database
$sql_update = "UPDATE richieste SET accettata = 1 WHERE id = $request_id";

if ($connessione->query($sql_update) === TRUE) {
    // Recupera l'utente e l'importo dalla richiesta
    $sql_select = "SELECT email, importo FROM richieste WHERE id = $request_id";
    $result = $connessione->query($sql_select);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $email = $row['email'];
        $importo = $row['importo'];

        // Aggiorna il credito dell'utente nel database
        $sql_credit_update = "UPDATE utenti SET crediti = crediti + $importo WHERE email = '$email'";
        $connessione->query($sql_credit_update);

        echo "Richiesta approvata con successo. I crediti sono stati aggiunti all'account di $email.";?>
        <a href="admin_approval.php" class="btn3">Torna alle richieste</a> <?php
    } else {
        echo "Errore nell'ottenere i dettagli della richiesta.";
    }
} else {
    echo "Errore nell'approvazione della richiesta: " . $conn->error;
}

$connessione->close();
?>

</body>
</html>

