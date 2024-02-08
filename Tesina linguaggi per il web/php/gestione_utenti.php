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
$sql = "SELECT id, nome, cognome, email, passwd, crediti, indirizzo_di_residenza, cellulare, ban FROM utenti WHERE utente = 1";
$result = $connessione->query($sql);

// Stampa la tabella degli utenti
echo '<table border="1">';
echo '<tr>';
echo '<th>Nome</th>';
echo '<th>Cognome</th>';
echo '<th>Email</th>';
echo '<th>Password</th>';
echo '<th>Crediti</th>';
echo '<th>Indirizzo di residenza</th>';
echo '<th>Cellulare</th>';
echo '<th>Modifica</th>';
echo '<th>Modifica Password</th>';
echo '<th>Attiva/Disattiva Utente</th>';
echo '</tr>';

if ($result->num_rows > 0) {
    $admin = $_SESSION['ammin'];
    while ($row = $result->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . $row['nome'] . '</td>';
        echo '<td>' . $row['cognome'] . '</td>';
        echo '<td>' . $row['email'] . '</td>';
        echo '<td>* * * * * * * * * *</td>';
        echo '<td>' . $row['crediti'] . '</td>';
        echo '<td>' . $row['indirizzo_di_residenza'] . '</td>';
        echo '<td>' . $row['cellulare'] . '</td>';
        echo '<td><a href="modifica_utente.php?id=' . $row['id'] . '"><span id="edit" class="material-symbols-outlined">edit</span></a></td>';
        echo '<td><a href="modifica_password.php?id=' . $row['id'] . '&admin=' . $admin . '"><span id="edit" class="material-symbols-outlined">key</span></a></td>';

        if ($row['ban'] == 1) {
            // Utente disattivato
            echo '<td><a href="conferma_ban.php?id=' . $row['id'] . '&ban=' . $row['ban'] . '"><span id="done" class="material-symbols-outlined">visibility_off</span></a></td>';

        } else {
            // Utente attivato
            echo '<td><a href="conferma_ban.php?id=' . $row['id'] . '&ban=' . $row['ban'] . '"><span id="done" class="material-symbols-outlined">visibility</span></a></td>';
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