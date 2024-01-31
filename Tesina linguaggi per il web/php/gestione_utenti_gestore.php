<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=
    , initial-scale=1.0">
    <title>Gestione Utenti</title>
    <link rel="stylesheet" href="../css/style_standard.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="../css/style_header.css">
    <?php
        include('../res/header.php');
    ?>
</head>
<body>

<?php
$xmlFile = '../xml/requests.xml';
$dom = new DOMDocument();
$dom->load($xmlFile);

$requests = $dom->getElementsByTagName('request');
$hasPendingRequests = false;
foreach ($requests as $request) {
  $status = $request->getAttribute('status');

  if ($status == 'pending') {
      $hasPendingRequests = true;
      }
    }
    ?>

<div class="cont">
<h1 class="titolo">PROFILI CLIENTI</h1>

<?php
// Include il file di connessione al database
require_once('../res/connection.php');
// Query per ottenere gli utenti
$sql = "SELECT id, nome, cognome, crediti, reputazione FROM utenti WHERE utente = 1";
$result = $connessione->query($sql);

// Stampa la tabella degli utenti
echo '<table border="1">';
echo '<tr>';
echo '<th>ID</th>';
echo '<th>Nome</th>';
echo '<th>Cognome</th>';
echo '<th>Reputazione</th>';
echo '<th>Crediti</th>';
echo '</tr>';

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . $row['id'] . '</td>';
        echo '<td>' . $row['nome'] . '</td>';
        echo '<td>' . $row['cognome'] . '</td>';
        echo '<td>' . $row['reputazione'] . '</td>';
        echo '<td>' . $row['crediti'] . '</td>';
        echo '</tr>';
    }
} else {
    echo '<tr><td colspan="3">Nessun utente trovato</td></tr>';
}

echo '</table>';

?>
</div>
                
<?php
// Chiudi la connessione al database
$connessione->close();
?>

</body>
</html>