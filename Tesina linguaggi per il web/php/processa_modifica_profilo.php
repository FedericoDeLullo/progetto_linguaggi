<?php
session_start();
require_once('../res/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ricevi i dati del modulo inviati tramite POST
    $id_utente = $_POST['id'];
    $nome = $_POST['nome'];
    $cognome = $_POST['cognome'];
    $indirizzo = $_POST['indirizzo'];
    $cellulare = $_POST['cellulare'];
    $email = $_POST['email'];

    // Esegui una query per ottenere l'email attuale dell'utente dal database
    $query_email_attuale = "SELECT email FROM utenti WHERE id = ?";
    $stmt_email_attuale = $connessione->prepare($query_email_attuale);
    $stmt_email_attuale->bind_param("i", $id_utente);
    $stmt_email_attuale->execute();
    $ris_email_attuale = $stmt_email_attuale->get_result();

    if ($ris_email_attuale) {
        $row_email_attuale = $ris_email_attuale->fetch_assoc();
        $email_attuale = $row_email_attuale['email'];

        // Controlla se l'email inviata è diversa dall'email attuale dell'utente nel database
        if ($email !== $email_attuale) {
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
                    $query = "UPDATE utenti SET nome = ?, email = ?, cognome = ?, indirizzo_di_residenza = ?, cellulare = ? WHERE id = ?";

                    // Utilizza statement preparati per evitare SQL injection
                    $stmt = $connessione->prepare($query);
                    $stmt->bind_param("sssssi", $nome, $email, $cognome, $indirizzo, $cellulare, $id_utente);

                    if ($stmt->execute()) {
                        header("Location: gestione_profilo.php");
                    } 
                    else {
                        echo 'Errore durante il salvataggio delle modifiche: ' . $stmt->error;
                    }
                } 
                else {
                    // L'email inviata è già presente nel database
                    $_SESSION['errore_email_ex'] = 'true';
                    $_SESSION['email_errata'] = $email;

                    header("Location: ../php/modifica_profilo.php?id=" . $id_utente);       
                    exit(1);
                }
            } 
            else {
                $_SESSION['errore_query'] = 'true';
                header('Location: ../php/modifica_profilo.php');
                exit(1);
            }
        } 
        else {
            // L'email inviata è uguale all'email nella sessione, aggiorna tutti gli altri parametri
            $query = "UPDATE utenti SET nome = ?, cognome = ?, indirizzo_di_residenza = ?, cellulare = ? WHERE id = ?";

            // Utilizza statement preparati per evitare SQL injection
            $stmt = $connessione->prepare($query);
            $stmt->bind_param("ssssi", $nome, $cognome, $indirizzo, $cellulare, $id_utente);

            if ($stmt->execute()) {
                header("Location: gestione_profilo.php");
            } 
            else {
                echo 'Errore durante il salvataggio delle modifiche: ' . $stmt->error;
            }
        }
    } 
    else {
        echo 'Metodo di richiesta non valido.';
    }
}

$stmt->close();
$connessione->close();
?>