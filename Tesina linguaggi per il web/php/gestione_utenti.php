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

<div class="cont">
<h1 class="titolo">GESTIONE UTENTI</h1>

<?php
// Include il file di connessione al database
require_once('../res/connection.php');
// Query per ottenere gli utenti
$sql = "SELECT id, nome, cognome, email, passwd, crediti, indirizzo_di_residenza, cellulare, ban, reputazione, ammin, gestore FROM utenti ORDER BY 
  CASE 
    WHEN ammin = 1 THEN 1
    WHEN gestore = 1 THEN 2
    ELSE 3
  END;";
$result = $connessione->query($sql);

// Stampa la tabella degli utenti
echo '<table border="1">';
echo '<tr>';
echo '<th>Ruolo</th>';
echo '<th>Nome</th>';
echo '<th>Cognome</th>';
echo '<th>Email</th>';
echo '<th>Crediti</th>';
echo '<th>Reputazione</th>';
echo '<th>Indirizzo di residenza</th>';
echo '<th>Cellulare</th>';
echo '<th>Modifica Dati</th>';
echo '<th>Modifica Password</th>';
echo '<th>Gestisci</th>';
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
        echo '<td>' . $row['crediti'] . '</td>';
        echo '<td>' . $row['reputazione'] . '</td>';
        echo '<td>' . $row['indirizzo_di_residenza'] . '</td>';
        echo '<td>' . $row['cellulare'] . '</td>';
        echo '<td><a href="modifica_utente.php?id=' . $row['id'] . '"><span id="edit" class="material-symbols-outlined">edit</span></a></td>';
        echo '<td><a href="modifica_password.php?id=' . $row['id'] . '&admin=' . $row['ammin'] . '"><span id="edit" class="material-symbols-outlined">key</span></a></td>';

        if ($row['email'] == $_SESSION['email']) {
            // questo è l'utente attuale
            echo '<td><span id="done" class="material-symbols-outlined">ar_on_you</span></a></td>';
        } elseif ($row['ammin'] == 1) {
            echo '<td><a id="minus" href="conferma_ban.php?id=' . $row['id'] . '&ban=' . $row['ban'] . '"><span id="minus" class="material-symbols-outlined">keyboard_double_arrow_down</span> Retrocedi</a></td>';
        } elseif ($row['gestore'] == 1) {
            echo '<td>
                <a id="plus" href="conferma_ban.php?id=' . $row['id'] . '&ban=' . $row['ban'] . '"><span id="plus" class="material-symbols-outlined">keyboard_double_arrow_up</span> Promuovi</a><br>
                <a id="minus" href="conferma_ban.php?id=' . $row['id'] . '&ban=' . $row['ban'] . '"><span id="minus" class="material-symbols-outlined">keyboard_double_arrow_down</span> Retrocedi</a>
            </td>';
        } else {
            if ($row['ban'] == 1) {
                // Utente disattivato
                echo '<td><a class="done" href="conferma_ban.php?id=' . $row['id'] . '&ban=' . $row['ban'] . '"><span id="done" class="material-symbols-outlined">visibility_off</span> Attiva</a></td>';
            } else {
                // Utente attivato
                echo '<td>
                    <a id="plus" href="conferma_ban.php?id=' . $row['id'] . '&ban=' . $row['ban'] . '"><span id="plus" class="material-symbols-outlined">keyboard_double_arrow_up</span> Promuovi</a><br>
                    <a class="done" href="conferma_ban.php?id=' . $row['id'] . '&ban=' . $row['ban'] . '"><span id="done" class="material-symbols-outlined">visibility</span> Disattiva</a>
                </td>';
            }
        }
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