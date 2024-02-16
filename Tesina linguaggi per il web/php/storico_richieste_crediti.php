<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Storico Esiti Pagamenti</title>
    <link rel="stylesheet" href="../css/style_standard.css">
    <link rel="stylesheet" href="../css/style_header.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <?php
        include('../res/header.php');
    ?>
</head>
<body>

    <?php
     

    // Verifica se l'utente è loggato
    if (!isset($_SESSION['loggato'])) {
        header("Location: login_cliente.php");
        exit();
    }

    $userEmail = $_SESSION['email'];
    $xmlFile = '../xml/requests.xml';
    $dom = new DOMDocument();
    $dom->load($xmlFile);

    $requests = $dom->getElementsByTagName('request');

    echo '<div class="cont">';
    echo '<h1 class="titolo">Storico Richiesta Crediti</h1>';

    // Flag per indicare se ci sono richieste per l'utente loggato
    $hasUserRequests = false;

    // Inizio della tabella
    echo '<table border="1">';
    echo '<tr>';
    echo '<th>Importo</th>';
    echo '<th>Stato</th>';
    echo '</tr>';

    // Loop attraverso le richieste
    foreach ($requests as $request) {
        $email = $request->getElementsByTagName('email')->item(0)->nodeValue;
        $importo = $request->getElementsByTagName('importo')->item(0)->nodeValue;
        $status = $request->getAttribute('status');

        // Verifica se la richiesta appartiene all'utente loggato
        if ($email == $userEmail) {
            $hasUserRequests = true;

            // Stampa le informazioni della richiesta all'interno di una riga della tabella
            echo '<tr>';
            echo "<td>$importo</td>";
            echo "<td>$status</td>";
            echo '</tr>';
        }
    }

    // Chiusura della tabella
    echo '</table>';

    echo '</div>';
    // Verifica se ci sono richieste per l'utente loggato
    if (!$hasUserRequests) {
        echo '<p class="titolo">Nessuna richiesta di ricarica effettuata.</p>';
    }
    ?>

   
</body>
</html>
