<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../css/style_standard.css">
    <link rel="stylesheet" href="../css/style_menu.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="../css/style_header.css">
    <?php
        include('../res/header.php');
    ?>
</head>
<body>

<?php
require_once('../res/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ricevi i dati del modulo inviati tramite POST
    $id_utente = $_POST['id'];
    $nome = $_POST['nome'];
    $cognome = $_POST['cognome'];
    $crediti = $_POST['crediti'];
    $password = $_POST['password'];
    $indirizzo = $_POST['indirizzo'];
    $cellulare = $_POST['cellulare'];
    $email = $_POST['email'];

    // Verifica se l'email è diversa da tutte le email nel database
    $query_check_email = "SELECT id FROM utenti WHERE email = '$email'";
    $result_check_email = $connessione->query($query_check_email);

    if ($result_check_email->num_rows === 0) {
        // Email non presente, esegui l'aggiornamento
        $query_update = "UPDATE utenti SET nome = '$nome', email = '$email', passwd = '$password', cognome = '$cognome', crediti = '$crediti', indirizzo_di_residenza = '$indirizzo', cellulare = $cellulare WHERE id = $id_utente";

        if ($connessione->query($query_update) === TRUE) {
            header("Location: gestione_utenti.php");
        } else {
            echo 'Errore durante il salvataggio delle modifiche: ' . $connessione->error;
        }
    } else {
        // Email già presente, verifica l'ID utente
        $row = $result_check_email->fetch_assoc();
        $id_utente_corrente = $row['id'];

        if ($id_utente_corrente != $id_utente) {
            echo '<h1 class =" titolo">L\'email fornita è già associata a un altro utente.</h1>';
        } else {
            // L'utente sta solo aggiornando i dati senza cambiare l'email
            $query_update = "UPDATE utenti SET nome = '$nome', passwd = '$password', cognome = '$cognome', crediti = '$crediti', indirizzo_di_residenza = '$indirizzo', cellulare = $cellulare WHERE id = $id_utente";

            if ($connessione->query($query_update) === TRUE) {
                header("Location: gestione_utenti.php");
            } else {
                echo 'Errore durante il salvataggio delle modifiche: ' . $connessione->error;
            }
        }
    }
} else {
    echo 'Metodo di richiesta non valido.';
}

$connessione->close();
?>
</body>
</html>