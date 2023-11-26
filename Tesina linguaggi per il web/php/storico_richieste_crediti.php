<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Storico Esiti Pagamenti</title>
    <link rel="stylesheet" href="../css/style_storico_pagamenti.css">
</head>
<body>
    <?php
    session_start();

    // Verifica se l'utente è loggato
    if (!isset($_SESSION['loggato'])) {
        header("Location: ../html/login.html");
        exit();
    }

    $userEmail = $_SESSION['email'];
    $xmlFile = '../xml/requests.xml';
    $dom = new DOMDocument();
    $dom->load($xmlFile);

    $requests = $dom->getElementsByTagName('request');

    echo '<h1 class="richiesta">Storico Richiesta Crediti</h1>';

    // Flag per indicare se ci sono richieste per l'utente loggato
    $hasUserRequests = false;

    // Loop attraverso le richieste
    foreach ($requests as $request) {
        $email = $request->getElementsByTagName('email')->item(0)->nodeValue;
        $importo = $request->getElementsByTagName('importo')->item(0)->nodeValue;
        $status = $request->getAttribute('status');

        // Verifica se la richiesta appartiene all'utente loggato
        if ($email == $userEmail) {
            $hasUserRequests = true;

            // Stampa le informazioni della richiesta
            echo "<p class='richiesta1'>Richiesta per un importo di $importo crediti - Stato: $status</p>";
        }
    }

    // Verifica se ci sono richieste per l'utente loggato
    if (!$hasUserRequests) {
        echo '<p class="richiesta2">Nessuna richiesta di ricarica effettuata.</p>';
    }
    ?>

    <a href="../html/index_loggato.html" class="btn">Torna alla Home</a>
</body>
</html>
