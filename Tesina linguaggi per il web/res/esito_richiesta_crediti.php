<?php
session_start();

if (!isset($_SESSION['loggato'])) {
    header("Location: ../php/login_cliente.php");
    exit();
}

$email = $_SESSION['email'];
$importo = $_POST['importo'];

$xmlFile = '../xml/requests.xml';
$dom = new DOMDocument();

try {
    $dom->load($xmlFile);
} catch (Exception $e) {
    die('Errore nel caricamento del file XML: ' . $e->getMessage());
}

$root = $dom->documentElement;

$request = $dom->createElement('request');
$request->setAttribute('status', 'In Attesa');

$emailElement = $dom->createElement('email', $email);
$request->appendChild($emailElement);

$importoElement = $dom->createElement('importo', $importo);
$request->appendChild($importoElement);

$root->appendChild($request);

try {
    $dom->save($xmlFile);
} catch (Exception $e) {
    die('Errore nel salvataggio del file XML: ' . $e->getMessage());
}

$_SESSION['successo_richiesta'] = 'true';
header("Location: ../php/richiesta_crediti.php");
?>