<?php
session_start();
require_once('connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifica se sono stati inviati dati del modulo
    if (isset($_POST['id_prodotto'], $_POST['autore'], $_POST['risposta'], $_POST['id_domanda'])) {
        $id_prodotto = $_POST['id_prodotto'];
        $autore = $_POST['autore'];
        $rispostaTesto = $_POST['risposta'];
        $dataRisposta = date('Y-m-d');
        $oraRisposta = date('H:i:s');
        $id_domanda = $_POST['id_domanda'];
        $tipologia = $_POST['tipologia'];
        $id_utente = $_SESSION['id'];
        $nome = $_POST['nome'];

        // Carica il file XML del catalogo
        $xmlFile = '../xml/catalogo_prodotti.xml';
        $dom = new DOMDocument();
        $dom->preserveWhiteSpace = false;
        $dom->load($xmlFile);

        // Trova il prodotto nel file XML
        $xpath = new DOMXPath($dom);
        $prodottoNode = $xpath->query("//prodotto[id_prodotto=$id_prodotto]")->item(0);

        // Verifica se il nodo del prodotto esiste prima di procedere
        if ($prodottoNode) {
            // Trova la domanda nel file XML
          // Trova la domanda nel file XML
$domandaNode = $xpath->query("//domande/domanda[id_domanda='$id_domanda']")->item(0);

// Verifica se il nodo della domanda esiste prima di procedere
if ($domandaNode) {
    // Crea l'elemento 'risposta'
    $rispostaNode = $dom->createElement('risposta');

    $rispostaNode->setAttribute('id_prodotto', $id_prodotto);
    $rispostaNode->setAttribute('id_utente', $id_utente);
    // Crea gli elementi 'id_risposta', 'autore', 'data', 'ora', 'testo'
    $idRispostaNode = $dom->createElement('id_risposta', uniqid());
    $idDomandaNode = $dom->createElement('id_domanda', $id_domanda);

    $autoreRispostaNode = $dom->createElement('autore', $autore);
    $dataRispostaNode = $dom->createElement('data', $dataRisposta);
    $oraRispostaNode = $dom->createElement('ora', $oraRisposta);
    $testoRispostaNode = $dom->createElement('testo', $rispostaTesto);
    // Aggiungi gli elementi all'elemento 'risposta'
    $rispostaNode->appendChild($idRispostaNode);
    $rispostaNode->appendChild($idDomandaNode);

    $rispostaNode->appendChild($autoreRispostaNode);
    $rispostaNode->appendChild($dataRispostaNode);
    $rispostaNode->appendChild($oraRispostaNode);
    $rispostaNode->appendChild($testoRispostaNode);

    // Trova o crea l'elemento 'risposte' all'interno della domanda
    $risposteNode = $domandaNode->getElementsByTagName('risposte')->item(0);
    if (!$risposteNode) {
        $risposteNode = $dom->createElement('risposte');
        $domandaNode->appendChild($risposteNode);
    }

    // Aggiungi l'elemento 'risposta' alle risposte della domanda
    $risposteNode->appendChild($rispostaNode);

    // Salva il file XML aggiornato
    $dom->formatOutput = true;
    $dom->save($xmlFile);

    echo 'Risposta salvata con successo.';
    header("Location: ../php/domande.php?tipologia=" . $tipologia . "&id_prodotto=" . $id_prodotto . "&nome=" . urlencode($nome));
} else {
    echo 'Domanda non trovata.';
}}}}
?>