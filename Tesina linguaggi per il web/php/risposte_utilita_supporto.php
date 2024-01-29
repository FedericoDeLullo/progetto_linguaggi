<?php

require_once('../res/connection.php');
session_start();
$xmlFile = '../xml/catalogo_prodotti.xml';

// Carica il file XML
$dom = new DOMDocument();
$dom->preserveWhiteSpace = false;
$dom->load($xmlFile);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['vota'])) {
    $id_risposta = $_POST['id_risposta'];
    $votoUtilita = $_POST['votoUtilita'];
    $votoSupporto = $_POST['votoSupporto'];
    $id_prodotto = $_POST['id_prodotto'];
    $tipologia = $_POST['tipologia'];
    $id_utente = $_SESSION['id'];
    $nome = $_POST['nome'];

    // Trova la risposta con l'id_risposta specificato
    $xpath = new DOMXPath($dom);
    $rispostaNode = $xpath->query("//risposta[id_risposta='$id_risposta']")->item(0);

    // Verifica se la risposta esiste prima di procedere
    if ($rispostaNode) {
        $id_utente_risp = $rispostaNode->getAttribute("id_utente");

        $sql = "SELECT reputazione FROM utenti WHERE id = $id_utente";
        $result = $connessione->query($sql);

        if ($result->num_rows == 1) {
            // Ottieni la riga risultante dalla query
            $row = $result->fetch_assoc();

            // Ottieni il valore della reputazione dall'array associativo
            $reputazioneUtente = $row['reputazione'];
        }

        // Ottieni o crea i nodi "utilita" e "supporto" all'interno della risposta
        $utilitaNode = $rispostaNode->getElementsByTagName("utilita")->item(0);
        if (!$utilitaNode) {
            $utilitaNode = $rispostaNode->appendChild($dom->createElement("utilita"));
        }

        $supportoNode = $rispostaNode->getElementsByTagName("supporto")->item(0);
        if (!$supportoNode) {
            $supportoNode = $rispostaNode->appendChild($dom->createElement("supporto"));
        }

        // Aggiungi o aggiorna il nodo "valore" per "utilita"
        $valoreUtilitaNode = $utilitaNode->getElementsByTagName("valore")->item(0);
        if (!$valoreUtilitaNode) {
            $valoreUtilitaNode = $utilitaNode->appendChild($dom->createElement("valore"));

            // Imposta l'attributo "id_utente" per "utilita"
            $valoreUtilitaNode->setAttribute("id_utente", $id_utente);
            $valoreUtilitaNode->setAttribute("reputazione_Vot", $reputazioneUtente);
        }

        // Imposta il valore di "valore" per "utilita"
        $valoreUtilitaNode->nodeValue = $votoUtilita;

        // Aggiungi o aggiorna il nodo "valore" per "supporto"
        $valoreSupportoNode = $supportoNode->getElementsByTagName("valore")->item(0);
        if (!$valoreSupportoNode) {
            $valoreSupportoNode = $supportoNode->appendChild($dom->createElement("valore"));

            // Imposta l'attributo "id_utente" per "supporto"
            $valoreSupportoNode->setAttribute("id_utente", $id_utente);
            $valoreSupportoNode->setAttribute("reputazione_Vot", $reputazioneUtente);
        }

        // Imposta il valore di "valore" per "supporto"
        $valoreSupportoNode->nodeValue = $votoSupporto;

        $dom->normalizeDocument();

        $dom->formatOutput = true;

        // Salva il documento XML aggiornato
        $dom->save($xmlFile);

        // inizializzazione delle variabili
        $sommaVotiUtilitaSupporto = 0;
        $sommaReputazioni = 0;

        // Ottieni i voti di utilità e supporto
        $votiUtilita = $utilitaNode->getElementsByTagName("valore");
        $votiSupporto = $supportoNode->getElementsByTagName("valore");

        // Itera attraverso tutti i voti
        for ($i = 0; $i < $votiUtilita->length; $i++) {
            $votoUtilita = intval($votiUtilita->item($i)->nodeValue);
            $votoSupporto = intval($votiSupporto->item($i)->nodeValue);

            // Ottieni la reputazione dell'utente che ha lasciato il voto
            $reputazione_utente = intval($votiUtilita->item($i)->getAttribute("reputazione_Vot"));

            // Calcola la parte della sommatoria
            $sommaVotiUtilitaSupporto += (($votoUtilita + $votoSupporto) * $reputazione_utente);
            $sommaReputazioni += $reputazione_utente;
        }

        // Calcola il risultato finale
        $risultatoFinale = (10/8) * ($sommaVotiUtilitaSupporto / $sommaReputazioni);

        $query = "SELECT reputazione FROM utenti WHERE id = $id_utente_risp";
        $result = $connessione->query($query);

        if ($result->num_rows == 1) {
            // Ottieni la riga risultante dalla query
            $row = $result->fetch_assoc();

            // Ottieni il valore della reputazione dall'array associativo
            $reputazioneUtenteDom = $row['reputazione'];

            // Assegna il valore di $risultatoFinale a $reputazioneUtenteDom
            $reputazioneUtenteDom = $risultatoFinale;

            // Ora puoi aggiornare la reputazione nel database
            $updateQuery = "UPDATE utenti SET reputazione = $reputazioneUtenteDom WHERE id = $id_utente_risp";
            $connessione->query($updateQuery);

            header("Location: domande.php?id_prodotto=" . $id_prodotto . "&tipologia=" . $tipologia . "&nome=" . $nome);
        }
    }
}
?>
