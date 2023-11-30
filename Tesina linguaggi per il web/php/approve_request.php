<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestione Crediti</title>
    <link rel="stylesheet" href="../css/style_crediti.css">
</head>
<body>
<?php
require_once('connection.php');

// Recupera i dati dal form in admin_approve.php
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
                echo "Richiesta approvata con successo. I crediti sono stati aggiunti all'account di $email."; ?>
                <a href="../php/admin_approval.php" class="btn4">Torna alle richieste</a> <?php
            } else {
                echo "Errore nell'aggiornamento dei crediti dell'utente nel database: " . $connessione->error;
            }

            $connessione->close();
            exit();
        }
     }
  } 
} elseif ($action=="Rifiuta") {
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

                echo "Richiesta rifiutata con successo!";?>
                <a href="../php/admin_approval.php" class="btn1">Torna alle Richieste</a> <?php
                $connessione->close();
                exit();
            }
        }
    }

} else {
    echo "Errore nel rifiuto della richiesta: richiesta non trovata.";}

$connessione->close();
?>

</body>
</html>