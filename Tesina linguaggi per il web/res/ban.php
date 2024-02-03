<?php
    session_start();
    require_once('connection.php');
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['action'])) {
            $action = $_POST['action'];

            if ($action === 'Approva') {
                if (isset($_POST['ban'])) {
                    $currentBanValue = $_POST['ban'];
                    $id_utente = $_POST['id'];

                    // Cambia il valore di "ban" in base alla logica richiesta
                    $newBanValue = ($currentBanValue == 0) ? 1 : 0;
                    $query = "UPDATE utenti SET ban = '$newBanValue' WHERE id = $id_utente";
                        
                    if ($connessione->query($query) === TRUE) {
                    header("Location: ../php/gestione_utenti.php");
                
                    } else {
                        echo 'Errore durante il salvataggio delle modifiche: ' . $connessione->error;
                    }
                }
            } elseif ($action === 'Rifiuta') {
                // Se l'azione è "Rifiuta", non fare nulla e reindirizza alla pagina iniziale
                header("Location: ../php/gestione_utenti.php");
                exit;
            } 
        }
    }
?>