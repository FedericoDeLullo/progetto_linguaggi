<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestione Crediti</title>
    <link rel="stylesheet" href="../css./style_crediti.css">
</head>
<body>
<?php
$xmlFile = '../xml/requests.xml';
$dom = new DOMDocument();
$dom->load($xmlFile);

$requests = $dom->getElementsByTagName('request');

echo '<h1 class="richiesta">Richieste di Ricarica Crediti</h1>';

// Flag per indicare se ci sono richieste pendenti
$hasPendingRequests = false;

// Loop attraverso le richieste
foreach ($requests as $request) {
    $status = $request->getAttribute('status');

    // Verifica se lo status è 'pending'
    if ($status == 'pending') {
        $hasPendingRequests = true;

        $email = $request->getElementsByTagName('email')->item(0)->nodeValue;
        $importo = $request->getElementsByTagName('importo')->item(0)->nodeValue;

        echo "<p class='richiesta1'>Richiesta da $email per un importo di $importo crediti.</p>";
        echo '<form action="approve_request.php" method="post">';
        echo "<input type='hidden' name='email' value='$email'>";
        echo "<input type='hidden' name='importo' value='$importo'>";
        echo '<input class="btn" type="submit" name="action" value="Approva">';
        echo '<input class="btn3" type="submit" name="action" value="Rifiuta">';
        echo '</form>';
    }
}

// Verifica il flag per determinare se ci sono richieste pendenti
if (!$hasPendingRequests) {
    echo '<p class="richiesta2">Nessuna richiesta di ricarica attualmente in sospeso.</p>';
    ?>
    <a href="../html/index_loggato_admin.html" class="btn5">Torna alla Home</a>
    <?php
}
?>
</body>
</html>