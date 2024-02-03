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
require_once('../res/connection.php');

$email = $_POST['email'];
$importo = $_POST['importo'];
$action = $_POST['action'];

if ($action=="Approva") {
$xmlFile = '../xml/requests.xml';
$dom = new DOMDocument();
$dom->load($xmlFile);

$requests = $dom->getElementsByTagName('request');

    foreach ($requests as $request) {
        $statusElement = $request->getAttribute('status');

        if ($statusElement == 'pending') {
            $emailElement = $request->getElementsByTagName('email')->item(0);
            $importoElement = $request->getElementsByTagName('importo')->item(0);

            $requestEmail = $emailElement->nodeValue;
            $requestImporto = $importoElement->nodeValue;

            if ($requestEmail == $email && $requestImporto == $importo) {
                // Aggiorna lo stato della richiesta nel file XML
                $request->setAttribute('status', 'approved');
                $dom->save($xmlFile);

                // Aggiorna i crediti dell'utente nel database
                $sql_credit_update = "UPDATE utenti SET crediti = crediti + $importo WHERE email = '$email'";
                if ($connessione->query($sql_credit_update) === TRUE) {
                    echo '<h1 class="titolo">Richiesta approvata con successo. I crediti sono stati aggiunti all\'account di $email.</h1>';
                } 
                else {
                    echo '<h1 class="titolo">Errore nell\'aggiornamento dei crediti dell\'utente nel database: ' . $connessione->error . '</h1>';
                }

                $connessione->close();
                exit();
            }
        }
    } 
}
elseif ($action=="Rifiuta") {
    $xmlFile = '../xml/requests.xml';
    $dom = new DOMDocument();
    $dom->load($xmlFile);

    $requests = $dom->getElementsByTagName('request');

    foreach ($requests as $request) {
        $statusElement = $request->getAttribute('status');

        if ($statusElement == 'pending') {
            $emailElement = $request->getElementsByTagName('email')->item(0);
            $importoElement = $request->getElementsByTagName('importo')->item(0);

            $requestEmail = $emailElement->nodeValue;
            $requestImporto = $importoElement->nodeValue;

            if ($requestEmail == $email && $requestImporto == $importo) {
                // Aggiorna lo stato della richiesta nel file XML a 'deny'
                $request->setAttribute('status', 'deny');
                $dom->save($xmlFile);

                echo '<h1 class="titolo">Richiesta rifiutata con successo!!!</h1>';
                $connessione->close();
                exit();
            }
        }
    }
}
else {
    echo '<h1 class="titolo">Errore: richiesta non trovata...</h1';
}

$connessione->close();
?>
</div>
</body>
</html>