<?php
session_start();
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

    // Controlla se l'email inviata è diversa dall'email nella sessione
    if ($email !== $_SESSION['email']) {
        // Costruisci la query SQL per controllare se l'email esiste già nel database
        $controllo_email = "SELECT email FROM utenti WHERE email = ?";

        // Utilizza statement preparati per evitare SQL injection
        $stmt = $connessione->prepare($controllo_email);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $ris_e = $stmt->get_result();
        if ($ris_e) { 
            // Verifica se ci sono risultati (email già esistente)
            if ($ris_e->num_rows == 0) {
                // Nessuna email corrispondente trovata, quindi puoi procedere con l'aggiornamento dei dati dell'utente
                $query = "UPDATE utenti SET nome = ?, email = ?, passwd = ?, cognome = ?, indirizzo_di_residenza = ?, cellulare = ? WHERE id = ?";

                // Utilizza statement preparati per evitare SQL injection
                $stmt = $connessione->prepare($query);
                $stmt->bind_param("ssssssi", $nome, $email, $password, $cognome, $indirizzo, $cellulare, $id_utente);

                if ($stmt->execute()) {
                    header("Location: gestione_profilo.php");
                } else {
                    echo 'Errore durante il salvataggio delle modifiche: ' . $stmt->error;
                }
            } else {
                // L'email inviata è già presente nel database
                echo 'L\'email inserita è già presente nel database.';
            }
        } else {
            $_SESSION['errore_query'] = 'true';
            header('Location: ../php/modifica_profilo.php');
            exit(1);
        }
    } else {
        // L'email inviata è uguale all'email nella sessione, aggiorna tutti gli altri parametri
        $query = "UPDATE utenti SET nome = ?, passwd = ?, cognome = ?, indirizzo_di_residenza = ?, cellulare = ? WHERE id = ?";

        // Utilizza statement preparati per evitare SQL injection
        $stmt = $connessione->prepare($query);
        $stmt->bind_param("sssssi", $nome, $password, $cognome, $indirizzo, $cellulare, $id_utente);

        if ($stmt->execute()) {
            header("Location: gestione_profilo.php");
        } else {
            echo 'Errore durante il salvataggio delle modifiche: ' . $stmt->error;
        }
    }
} else {
    echo 'Metodo di richiesta non valido.';
}

$stmt->close();
$connessione->close();
?>