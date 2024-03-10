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

  if ($status == 'In Attesa') {
      $hasPendingRequests = true;
      }
    }
    ?>

<div class="cont">
<h1 class="titolo">PROFILI UTENTI</h1>

<?php
// Include il file di connessione al database
require_once('../res/connection.php');
if (!isset($_SESSION['id'])) {
    // Reindirizza l'utente alla pagina di accesso se non è loggato
    header("Location: login_cliente.php");
    exit();
}

// Controlla se l'utente è un amministratore
$id_utente = $_SESSION['id'];
$sql_select = "SELECT gestore FROM utenti WHERE id = '$id_utente' AND gestore = 1";

if ($result = $connessione->query($sql_select)) {
    if ($result->num_rows === 1) {
        // Query per ottenere gli utenti
        $sql = "SELECT id, nome, cognome, crediti,email, reputazione, ammin, gestore FROM utenti ORDER BY
        CASE 
            WHEN ammin = 1 THEN 1
            WHEN gestore = 1 THEN 2
            ELSE 3
        END";
        $result = $connessione->query($sql);


        // Stampa la tabella degli utenti
        echo '<table border="1">';
        echo '<tr>';
        echo '<th>Ruolo</th>';
        echo '<th>Nome</th>';
        echo '<th>Cognome</th>';
        echo '<th>email</th>';
        echo '<th>Reputazione</th>';
        echo '<th>Crediti</th>';
        echo '<th>Storico Acquisti</th>';
        echo '</tr>';

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $ruolo = '';
                if ($row['ammin'] == 1) {
                    $ruolo = 'Admin';
                } elseif ($row['gestore'] == 1) {
                    $ruolo = 'Gestore';
                } else {
                    $ruolo = 'Cliente';
                }
                echo '<tr>';
                echo '<td><strong>' . $ruolo . '</strong></td>';
                echo '<td>' . $row['nome'] . '</td>';
                echo '<td>' . $row['cognome'] . '</td>';
                echo '<td>' . $row['email'] . '</td>';
                echo '<td>' . $row['reputazione'] . '</td>';
                echo '<td>' . $row['crediti'] . '</td>';
                echo '<td>';
                echo '<form action="storico_acquisti_utenti.php" method="POST">';
                echo '<input type="hidden" name="id" value="' . $row['id'] . '"/>';
                echo '<input type="hidden" name="email" value="' . $row['email'] . '"/>';
                echo '<button class="done" type="submit"><span id="done" class="material-symbols-outlined">shopping_bag</span></button>';
                echo '</form>';
                echo '</td>';
                echo '</tr>';
            }
        } else {
            echo '<tr><td colspan="3">Nessun utente trovato</td></tr>';
        }

        echo '</table>';
    } else {
        // Se l'utente non è un amministratore, reindirizzalo a una pagina di accesso negato
        header("Location: accesso_negato.php");
        exit();
    }
} else {
echo "Errore nella query: " . $connessione->error;
}
?>
</div>
                
<?php
// Chiudi la connessione al database
$connessione->close();
?>

</body>
</html>