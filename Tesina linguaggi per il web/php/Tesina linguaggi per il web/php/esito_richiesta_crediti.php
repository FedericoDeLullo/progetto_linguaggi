<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestione Crediti</title>
    <link rel="stylesheet" href="../css/style_standard.css">
    <link rel="stylesheet" href="../css/style_header.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <?php
        include('../res/header.php');
    ?>
</head>
<body>
    
<div class="cont">
<?php
 

if (!isset($_SESSION['loggato'])) {
    header("Location: login_cliente.php");
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

echo "<h1 class='titolo'>Richiesta inviata con successo. Attendere l'approvazione dell'amministratore...</h1>";
?>
</div>
</body>
</html>