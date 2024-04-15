<?php
require_once('connection.php');

if(isset($_GET['id']) && isset($_GET['ban'])) {
    $id = $connessione->real_escape_string($_GET['id']);
    $ban = $connessione->real_escape_string($_GET['ban']);

    $query_check_ammin = "SELECT ammin FROM utenti WHERE id = $id";
    $result_check_ammin = $connessione->query($query_check_ammin);
    if ($result_check_ammin && $result_check_ammin->num_rows > 0) {
        $row = $result_check_ammin->fetch_assoc();
        if ($row['ammin'] == 0) {
            $query = "UPDATE utenti SET gestore = 0, utente = 1, reputazione = 10 WHERE id = $id";
        } else {
            $query = "UPDATE utenti SET ammin = 0, gestore = 1, reputazione = 11 WHERE id = $id";
        }

        if ($connessione->query($query) === TRUE) {
            header("Location: ../php/gestione_utenti.php");
            exit();
        } else {
            echo "Errore durante l'aggiornamento del database: " . $connessione->error;
        }
    } else {
        echo "Nessun risultato trovato per l'utente con l'id specificato.";
    }
} else {
    echo "ID e/o ban non forniti.";
}

$connessione->close();
?>