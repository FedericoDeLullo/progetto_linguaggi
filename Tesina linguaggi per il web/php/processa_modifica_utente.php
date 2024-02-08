<?php
session_start();
require_once('../res/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ricevi i dati del modulo inviati tramite POST
    $id_utente = $_POST['id'];
    $nome = $_POST['nome'];
    $cognome = $_POST['cognome'];
    $crediti = $_POST['crediti'];
    $indirizzo = $_POST['indirizzo'];
    $cellulare = $_POST['cellulare'];
    $email = $_POST['email'];

    // Esegui una query per ottenere l'email e il numero di cellulare attuali dell'utente dal database
    $query_dati_attuali = "SELECT email, cellulare FROM utenti WHERE id = ?";
    $stmt_dati_attuali = $connessione->prepare($query_dati_attuali);
    $stmt_dati_attuali->bind_param("i", $id_utente);
    $stmt_dati_attuali->execute();
    $ris_dati_attuali = $stmt_dati_attuali->get_result();

    if ($ris_dati_attuali) {
        $row_dati_attuali = $ris_dati_attuali->fetch_assoc();
        $email_attuale = $row_dati_attuali['email'];
        $cellulare_attuale = $row_dati_attuali['cellulare'];

        // Verifica se l'email inviata è diversa dall'email attuale dell'utente nel database
        if ($email !== $email_attuale) {
            // Costruisci la query SQL per controllare se l'email esiste già nel database
            $controllo_email = "SELECT email FROM utenti WHERE email = ?";

            // Utilizza statement preparati per evitare SQL injection
            $stmt_controllo_email = $connessione->prepare($controllo_email);
            $stmt_controllo_email->bind_param("s", $email);
            $stmt_controllo_email->execute();
            $ris_controllo_email = $stmt_controllo_email->get_result();

            if ($ris_controllo_email) { 
                // Verifica se ci sono risultati (email già esistente)
                if ($ris_controllo_email->num_rows == 0) {
                    // Nessuna email corrispondente trovata, procedi con l'aggiornamento dei dati dell'utente
                    $query_email = "UPDATE utenti SET nome = ?, email = ?, cognome = ?, indirizzo_di_residenza = ? WHERE id = ?";

                    // Utilizza statement preparati per evitare SQL injection
                    $stmt_aggiornamento_email = $connessione->prepare($query_email);
                    $stmt_aggiornamento_email->bind_param("ssssi", $nome, $email, $cognome, $indirizzo, $id_utente);

                    if ($stmt_aggiornamento_email->execute()) {
                        // Aggiornamento dell'email eseguito con successo, procedi con il controllo e l'aggiornamento del numero di cellulare
                        if ($cellulare !== $cellulare_attuale) {
                            // Costruisci la query SQL per controllare se il numero di cellulare esiste già nel database
                            $controllo_cellulare = "SELECT cellulare FROM utenti WHERE cellulare = ?";

                            // Utilizza statement preparati per evitare SQL injection
                            $stmt_controllo_cellulare = $connessione->prepare($controllo_cellulare);
                            $stmt_controllo_cellulare->bind_param("s", $cellulare);
                            $stmt_controllo_cellulare->execute();
                            $ris_controllo_cellulare = $stmt_controllo_cellulare->get_result();

                            if ($ris_controllo_cellulare) { 
                                // Verifica se ci sono risultati (numero di cellulare già esistente)
                                if ($ris_controllo_cellulare->num_rows == 0) {
                                    // Nessun numero di cellulare corrispondente trovato, procedi con l'aggiornamento dei dati dell'utente
                                    $query_cellulare = "UPDATE utenti SET cellulare = ? WHERE id = ?";

                                    // Utilizza statement preparati per evitare SQL injection
                                    $stmt_aggiornamento_cellulare = $connessione->prepare($query_cellulare);
                                    $stmt_aggiornamento_cellulare->bind_param("si", $cellulare, $id_utente);

                                    if ($stmt_aggiornamento_cellulare->execute()) {
                                        header("Location: gestione_utenti.php");
                                    } else {
                                        echo 'Errore durante il salvataggio delle modifiche: ' . $stmt_aggiornamento_cellulare->error;
                                    }
                                } else {
                                    // Il numero di cellulare inviato è già presente nel database
                                    $_SESSION['errore_cellulare_ex'] = 'true';
                                    $_SESSION['cellulare_errato'] = $cellulare;

                                    header("Location: ../php/modifica_utente.php?id=" . $id_utente);       
                                    exit(1);
                                }
                            } else {
                                $_SESSION['errore_query'] = 'true';
                                header('Location: ../php/modifica_utente.php');
                                exit(1);
                            }
                        } else {
                            // Il numero di cellulare inviato è uguale a quello nella sessione, quindi non è necessario aggiornarlo
                            header("Location: gestione_utenti.php");
                        }
                    } else {
                        echo 'Errore durante il salvataggio delle modifiche: ' . $stmt_aggiornamento_email->error;
                    }
                } else {
                    // L'email inviata è già presente nel database
                    $_SESSION['errore_email_ex'] = 'true';
                    $_SESSION['email_errata'] = $email;

                    header("Location: ../php/modifica_utente.php?id=" . $id_utente);       
                    exit(1);
                }
            } else {
                $_SESSION['errore_query'] = 'true';
                header('Location: ../php/modifica_utente.php');
                exit(1);
            }
        } else {
            // L'email inviata è uguale all'email nella sessione, procedi con il controllo e l'aggiornamento del numero di cellulare
            if ($cellulare !== $cellulare_attuale) {
                // Costruisci la query SQL per controllare se il numero di cellulare esiste già nel database
                $controllo_cellulare = "SELECT cellulare FROM utenti WHERE cellulare = ?";

                // Utilizza statement preparati per evitare SQL injection
                $stmt_controllo_cellulare = $connessione->prepare($controllo_cellulare);
                $stmt_controllo_cellulare->bind_param("s", $cellulare);
                $stmt_controllo_cellulare->execute();
                $ris_controllo_cellulare = $stmt_controllo_cellulare->get_result();

                if ($ris_controllo_cellulare) { 
                    // Verifica se ci sono risultati (numero di cellulare già esistente)
                    if ($ris_controllo_cellulare->num_rows == 0) {
                        // Nessun numero di cellulare corrispondente trovato, procedi con l'aggiornamento dei dati dell'utente
                        $query_cellulare = "UPDATE utenti SET cellulare = ? WHERE id = ?";

                        // Utilizza statement preparati per evitare SQL injection
                        $stmt_aggiornamento_cellulare = $connessione->prepare($query_cellulare);
                        $stmt_aggiornamento_cellulare->bind_param("si", $cellulare, $id_utente);

                        if ($stmt_aggiornamento_cellulare->execute()) {
                            header("Location: gestione_utenti.php");
                        } else {
                            echo 'Errore durante il salvataggio delle modifiche: ' . $stmt_aggiornamento_cellulare->error;
                        }
                    } else {
                        // Il numero di cellulare inviato è già presente nel database
                        $_SESSION['errore_cellulare_ex'] = 'true';
                        $_SESSION['cellulare_errato'] = $cellulare;

                        header("Location: ../php/modifica_utente.php?id=" . $id_utente);       
                        exit(1);
                    }
                } else {
                    $_SESSION['errore_query'] = 'true';
                    header('Location: ../php/modifica_utente.php');
                    exit(1);
                }
            } else {
                // Il numero di cellulare inviato è uguale a quello nella sessione, quindi non è necessario aggiornarlo
                header("Location: gestione_utenti.php");
            }
        }
    } else {
        echo 'Metodo di richiesta non valido.';
    }
}

$stmt_dati_attuali->close();
$stmt_controllo_email->close();
$stmt_controllo_cellulare->close();
$stmt_aggiornamento_email->close();
$stmt_aggiornamento_cellulare->close();
$connessione->close();
?>