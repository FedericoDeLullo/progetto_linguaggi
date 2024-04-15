<?php
session_start();
require_once('connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
        $segnalato = 0;
        // Carica il file XML del catalogo
        $xmlFile = '../xml/catalogo_prodotti.xml';
        $dom = new DOMDocument();
        $dom->preserveWhiteSpace = false;
        $dom->load($xmlFile);

        // Trova il prodotto nel file XML
        $xpath = new DOMXPath($dom);
        $prodottoNode = $xpath->query("//prodotto[id_prodotto=$id_prodotto]")->item(0);

        if ($prodottoNode) {
$domandaNode = $xpath->query("//domande/domanda[id_domanda='$id_domanda']")->item(0);

if ($domandaNode) {
    $rispostaNode = $dom->createElement('risposta');

    $rispostaNode->setAttribute('id_prodotto', $id_prodotto);
    $rispostaNode->setAttribute('id_utente', $id_utente);
    $rispostaNode->setAttribute('segnalato', $segnalato);

    $idRispostaNode = $dom->createElement('id_risposta', uniqid());
    $idDomandaNode = $dom->createElement('id_domanda', $id_domanda);

    $autoreRispostaNode = $dom->createElement('autore', $autore);
    $dataRispostaNode = $dom->createElement('data', $dataRisposta);
    $oraRispostaNode = $dom->createElement('ora', $oraRisposta);
    $testoRispostaNode = $dom->createElement('testo', $rispostaTesto);
    $rispostaNode->appendChild($idRispostaNode);
    $rispostaNode->appendChild($idDomandaNode);

    $rispostaNode->appendChild($autoreRispostaNode);
    $rispostaNode->appendChild($dataRispostaNode);
    $rispostaNode->appendChild($oraRispostaNode);
    $rispostaNode->appendChild($testoRispostaNode);

    $risposteNode = $domandaNode->getElementsByTagName('risposte')->item(0);
    if (!$risposteNode) {
        $risposteNode = $dom->createElement('risposte');
        $domandaNode->appendChild($risposteNode);
    }

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