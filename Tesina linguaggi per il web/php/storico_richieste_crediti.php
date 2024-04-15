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

    $hasUserRequests = false;

    echo '<table border="1">';
    echo '<tr>';
    echo '<th>Importo</th>';
    echo '<th>Stato</th>';
    echo '</tr>';

    foreach ($requests as $request) {
        $email = $request->getElementsByTagName('email')->item(0)->nodeValue;
        $importo = $request->getElementsByTagName('importo')->item(0)->nodeValue;
        $status = $request->getAttribute('status');

        if ($email == $userEmail) {
            $hasUserRequests = true;

            echo '<tr>';
            echo "<td>$importo</td>";
            echo "<td>$status</td>";
            echo '</tr>';
        }
    }

    echo '</table>';

    echo '</div>';
    if (!$hasUserRequests) {
        echo '<p class="titolo">Nessuna richiesta di ricarica effettuata.</p>';
    }
    ?>

   
</body>
</html>
