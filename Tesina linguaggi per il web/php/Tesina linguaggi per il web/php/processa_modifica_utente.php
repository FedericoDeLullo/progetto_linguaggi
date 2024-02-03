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

    // Esegui le opportune verifiche e validazioni sui dati

    // Aggiorna i dati dell'utente nel database
    $query = "UPDATE utenti SET nome = '$nome', email = '$email', passwd = '$password', cognome = '$cognome', crediti = '$crediti', indirizzo_di_residenza = '$indirizzo', cellulare = $cellulare WHERE id = $id_utente";

    if ($connessione->query($query) === TRUE) {
       header("Location:gestione_utenti.php");

    } else {
        echo 'Errore durante il salvataggio delle modifiche: ' . $connessione->error;
    }
} else {
    echo 'Metodo di richiesta non valido.';
}

$connessione->close();
?>
