<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=
    , initial-scale=1.0">
    <title>Gestione Utenti</title>
    <link rel="stylesheet" href="../css/style_gestione_utenti.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
</head>
<body>

  <h1>GESTIONE UTENTI</h1>


<?php
// Include il file di connessione al database
require_once('connection.php');
// Query per ottenere gli utenti
$sql = "SELECT id, nome, cognome, email, passwd, crediti, indirizzo_di_residenza, cellulare FROM utenti WHERE utente = 1";
$result = $connessione->query($sql);

// Stampa la tabella degli utenti
echo '<table border="1">';
echo '<tr>';
echo '<th>ID</th>';
echo '<th>Nome</th>';
echo '<th>Cognome</th>';
echo '<th>Email</th>';
echo '<th>Password</th>';
echo '<th>Crediti</th>';
echo '<th>Indirizzo di residenza</th>';
echo '<th>Cellulare</th>';
echo '<th>Modifica</th>';
echo '</tr>';

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . $row['id'] . '</td>';
        echo '<td>' . $row['nome'] . '</td>';
        echo '<td>' . $row['cognome'] . '</td>';
        echo '<td>' . $row['email'] . '</td>';
        echo '<td>' . $row['passwd'] . '</td>';
        echo '<td>' . $row['crediti'] . '</td>';
        echo '<td>' . $row['indirizzo_di_residenza'] . '</td>';
        echo '<td>' . $row['cellulare'] . '</td>';
        echo '<td><a href="modifica_utente.php?id=' . $row['id'] . '"><span class="material-symbols-outlined">
        edit
        </span></a></td>';
        echo '</tr>';
    }
} else {
    echo '<tr><td colspan="3">Nessun utente trovato</td></tr>';
}

echo '</table>';

?>
                <a href="index_loggato_admin.php" class="btn"><span id="home" class="material-symbols-outlined">
home
</span></a> <?php
// Chiudi la connessione al database
$connessione->close();
?>

</body>
</html>
