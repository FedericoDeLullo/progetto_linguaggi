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

<?php
// Controlla se l'utente è un amministratore
require_once('../res/connection.php');

if (!isset($_SESSION['id'])) {
    // Reindirizza l'utente alla pagina di accesso se non è loggato
    header("Location: login_cliente.php");
    exit();
}

// Controlla se l'utente è un amministratore
$id_utente = $_SESSION['id'];
$sql_select = "SELECT ammin FROM utenti WHERE id = '$id_utente' AND ammin = 1";

if ($result = $connessione->query($sql_select)) {
    if ($result->num_rows === 1) {
        // Se l'utente è un amministratore, esegui lo script per la gestione delle richieste di ricarica crediti
        include('../res/funzioni.php');
        
        $xmlFile = '../xml/requests.xml';
        $dom = new DOMDocument();
        $dom->load($xmlFile);
        $requests = $dom->getElementsByTagName('request');

        // Visualizza i messaggi di successo o errore
        if (isset($_SESSION['successo_richiesta_approvata']) && $_SESSION['successo_richiesta_approvata'] == 'true') {
            echo '<h2 id="successo">Richiesta approvata con successo... I crediti sono stati aggiunti all\'account di "' . $_SESSION['email'] . '"</h2>';
            unset($_SESSION['successo_richiesta_approvata']);
        }
        if (isset($_SESSION['successo_richiesta_rifiutata']) && $_SESSION['successo_richiesta_rifiutata'] == 'true') {
            echo '<h2 id="successo">Richiesta rifiutata con successo!!!</h2>';
            unset($_SESSION['successo_richiesta_rifiutata']);
        }
        if (isset($_SESSION['fallimento_richiesta']) && $_SESSION['fallimento_richiesta'] == 'true') {
            echo '<h2>Errore nell\'aggiornamento dei crediti dell\'utente nel database: ' . $connessione->error . '</h2>';
            unset($_SESSION['fallimento_richiesta']);
        }

        echo '<div class="cont">';
        echo '<h1 class="titolo">Richieste di Ricarica Crediti</h1>';

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

            if ($status == 'In Attesa') {
                $hasPendingRequests = true;

                $email = $request->getElementsByTagName('email')->item(0)->nodeValue;
                $importo = $request->getElementsByTagName('importo')->item(0)->nodeValue;

                echo '<tr>';
                echo "<td>$email</td>";
                echo "<td>$importo</td>";
                echo '<td>';
                echo '<form action="approva_richieste_crediti.php" method="post">';
                echo "<input type='hidden' name='email' value='$email'>";
                echo "<input type='hidden' name='importo' value='$importo'>";
                echo '<button class="done" type="submit" name="action" value="Approva"><span id="done" class="material-symbols-outlined">done</span></button>';
                echo '<button class="done" type="submit" name="action" value="Rifiuta"><span id="done" class="material-symbols-outlined">close</span></button> ';
                echo '</form>';
                echo '</td>';
                echo '</tr>';
            }
        }

        echo '</tbody>';
        echo '</table>';

        // Verifica il flag per determinare se ci sono richieste pendenti
        if (!$hasPendingRequests) {
            echo '<p class="titolo">Nessuna richiesta di ricarica attualmente in sospeso.</p>';
        }
        echo '</div>';
    } else {
        // Se l'utente non è un amministratore, reindirizzalo a una pagina di accesso negato
        header("Location: accesso_negato.php");
        exit();
    }
} else {
    echo "Errore nella query: " . $connessione->error;
}
?>

</body>
</html>