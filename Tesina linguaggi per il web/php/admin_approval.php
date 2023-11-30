<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestione Crediti</title>
    <link rel="stylesheet" href="../css./style_crediti.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
</head>
<body>
<?php
$xmlFile = '../xml/requests.xml';
$dom = new DOMDocument();
$dom->load($xmlFile);

$requests = $dom->getElementsByTagName('request');

echo '<h1 class="richiesta">Richieste di Ricarica Crediti</h1>';


$hasPendingRequests = false;

echo '<table>';
echo '<thead>';
echo '<tr>';
echo '<th>Email</th>';
echo '<th>Importo</th>';
echo '<th>Azione</th>';
echo '</tr>';
echo '</thead>';
echo '<tbody>';

foreach ($requests as $request) {
    $status = $request->getAttribute('status');

    if ($status == 'pending') {
        $hasPendingRequests = true;

        $email = $request->getElementsByTagName('email')->item(0)->nodeValue;
        $importo = $request->getElementsByTagName('importo')->item(0)->nodeValue;

        echo '<tr>';
        echo "<td>$email</td>";
        echo "<td>$importo</td>";
        echo '<td>';
        echo '<form action="approve_request.php" method="post">';
        echo "<input type='hidden' name='email' value='$email'>";
        echo "<input type='hidden' name='importo' value='$importo'>";
        echo '<button type="submit" name="action" value="Approva"><span class="material-symbols-outlined">done</span></button>';
        echo '<button type="submit" name="action" value="Rifiuta"><span class="material-symbols-outlined">close</span></button> ';
        echo '</form>';
        echo '</td>';
        echo '</tr>';
    }
}

echo '</tbody>';
echo '</table>';

// Verifica il flag per determinare se ci sono richieste pendenti
if (!$hasPendingRequests) {
    echo '<p class="richiesta2">Nessuna richiesta di ricarica attualmente in sospeso.</p>';
    ?>
    <a href="index_loggato_admin.php" class="btn5">Torna alla Home</a>
    <?php
}
?>

</body>
</html>