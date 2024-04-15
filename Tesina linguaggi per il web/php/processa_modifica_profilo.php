<?php
session_start();
require_once('../res/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_utente = $_POST['id'];
    $nome = $_POST['nome'];
    $cognome = $_POST['cognome'];
    $indirizzo = $_POST['indirizzo'];
    $cellulare = $_POST['cellulare'];
    $email = $_POST['email'];
    $email_vecchia = $_POST['email_vecchia'];

    $query_email_esistente = "SELECT id FROM utenti WHERE email = ? AND id != ?";
    $stmt_email_esistente = $connessione->prepare($query_email_esistente);
    $stmt_email_esistente->bind_param("si", $email, $id_utente);
    $stmt_email_esistente->execute();
    $ris_email_esistente = $stmt_email_esistente->get_result();

    if ($ris_email_esistente->num_rows > 0) {
        $_SESSION['errore_email_ex'] = true;
        $_SESSION['email_errata'] = $email;
        header("Location: ../php/modifica_profilo.php?id=" . $id_utente);
        exit();
    }

    $query_cellulare_esistente = "SELECT id FROM utenti WHERE cellulare = ? AND id != ?";
    $stmt_cellulare_esistente = $connessione->prepare($query_cellulare_esistente);
    $stmt_cellulare_esistente->bind_param("si", $cellulare, $id_utente);
    $stmt_cellulare_esistente->execute();
    $ris_cellulare_esistente = $stmt_cellulare_esistente->get_result();

    if ($ris_cellulare_esistente->num_rows > 0) {
        $_SESSION['errore_cellulare_ex'] = true;
        $_SESSION['cellulare_errato'] = $cellulare;
        header("Location: ../php/modifica_profilo.php?id=" . $id_utente);
        exit();
    }

    $query_aggiornamento = "UPDATE utenti SET nome = ?, cognome = ?, indirizzo_di_residenza = ?, email = ?, cellulare = ? WHERE id = ?";
    $stmt_aggiornamento = $connessione->prepare($query_aggiornamento);
    $stmt_aggiornamento->bind_param("sssssi", $nome, $cognome, $indirizzo, $email, $cellulare, $id_utente);
    $_SESSION['email'] = $email;

    
    // Carica il tuo file XML con DOMDocument
    $dom = new DOMDocument;
    $dom->preserveWhiteSpace = false;

    $dom->load('../xml/catalogo_prodotti.xml');
    
    $xpath = new DOMXPath($dom);
    $autoriDaAggiornare = $xpath->query("//domanda/autore[text()='$email_vecchia'] | //domanda/risposte/risposta/autore[text()='$email_vecchia'] | //recensione/autore[text()='$email_vecchia']");
    if($autoriDaAggiornare !== 0){
    foreach ($autoriDaAggiornare as $autoreDaAggiornare) {
        $autoreDaAggiornare->nodeValue = $email;
    }
    $dom->normalizeDocument();
                $dom->formatOutput = true; 
    // Salva il documento XML aggiornato
    $dom->save('../xml/catalogo_prodotti.xml');
    }

    $dom1 = new DOMDocument;
    $dom1->preserveWhiteSpace = false;

    $dom1->load('../xml/requests.xml');
    
    $xpath1 = new DOMXPath($dom1);
    $emailsDaAggiornare = $xpath1->query("//request/email[text()='$email_vecchia']");
    if($emailsDaAggiornare !== 0){
    foreach ($emailsDaAggiornare as $emailDaAggiornare) {
        $emailDaAggiornare->nodeValue = $email;
    }
    $dom1->normalizeDocument();
                $dom1->formatOutput = true; 
    // Salva il documento XML aggiornato
    $dom1->save('../xml/requests.xml');
    }

    $dom2 = new DOMDocument;
    $dom2->preserveWhiteSpace = false;

    $dom2->load('../xml/segnalazioni.xml');
    
    $xpath2 = new DOMXPath($dom2);
    $domandeDaAggiornare = $xpath2->query("//segnalazione/autoreDomanda[text()='$email_vecchia']");
    if($domandeDaAggiornare !== 0){
    foreach ($domandeDaAggiornare as $domandaDaAggiornare) {
        $domandaDaAggiornare->nodeValue = $email;
    }
    $dom2->normalizeDocument();
                $dom2->formatOutput = true; 
    // Salva il documento XML aggiornato
    $dom2->save('../xml/segnalazioni.xml');
    }

   
    if ($stmt_aggiornamento->execute()) {
        header("Location: gestione_profilo.php");
        exit();
    } else {
        echo 'Errore durante il salvataggio delle modifiche: ' . $stmt_aggiornamento->error;
    }

    $stmt_aggiornamento->close();
}

$connessione->close();
?>