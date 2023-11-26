<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestione Crediti</title>
    <link rel="stylesheet" href="../css/style_ricarica.css">
</head>
<body>
<?php
session_start();

if (!isset($_SESSION['loggato'])) {
    header("Location: ../html/login.html");
    exit();
}

$email = $_SESSION['email'];
$importo = $_POST['importo'];

$xmlFile = '../xml/requests.xml';  // Utilizzo di un percorso relativo
$dom = new DOMDocument();

try {
    $dom->load($xmlFile);
} catch (Exception $e) {
    die('Errore nel caricamento del file XML: ' . $e->getMessage());
}

$root = $dom->documentElement;

$request = $dom->createElement('request');
$request->setAttribute('status', 'pending');

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

echo "<p class='richiesta'>Richiesta inviata con successo. Attendere l'approvazione dell'amministratore.</p>";
?>
<a href="../html/index_loggato.html" class="btn1">Torna alla Home</a>

</body>
</html>