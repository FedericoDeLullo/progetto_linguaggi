<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style_crediti.css">
    <title>Gestione Crediti</title>
</head>
<body>
<?php
require_once('connection.php');

// Recupera richieste non ancora approvate
$sql = "SELECT * FROM richieste WHERE accettata = 0";
$result = $connessione->query($sql);

echo '<h1 class = "richiesta">Richieste di Ricarica Crediti</h1>';

if ($result->num_rows > 0) {
    // Visualizza le richieste e fornisci un pulsante per l'approvazione
    while ($row = $result->fetch_assoc()) {
        echo "<p class= 'richiesta1'>Richiesta da {$row["email"]} per un importo di {$row["importo"]} crediti.</p>";
        echo '<form action="approve_request.php" method="post">';
        echo "<input type='hidden' name='id' value='{$row['id']}'>";
        echo '<input class = "btn" type="submit" value="Approva">';
        echo "</form>";
    }
} else {
    echo '<p class = "richiesta2">Nessuna richiesta di ricarica attualmente in sospeso.</p>';?>
    <a href="../html/index_loggato_admin.html" class="btn1">Torna alla Home</a> <?php

}

$connessione->close();
?>

</body>
</html>

