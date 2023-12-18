<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestione Utente</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php
// Include il file di connessione al database
require_once('connection.php');
session_start();

// Verifica se l'utente è loggato
if (isset($_SESSION['id_utente'])) {
    $id_utente = $_SESSION['id_utente'];

    // Esegui la query per ottenere i dati dell'utente
    $query = "SELECT * FROM utenti WHERE id = $id_utente";
    $result = $connessione->query($query);

    if ($result->num_rows > 0) {
        $utente = $result->fetch_assoc();
?>
        <h1>Gestione Utente</h1>

        <form action="modifica_utente.php" method="post">
            <!-- Visualizza i dati attuali dell'utente -->
            <label for="nome">Nome: </label>
            <input type="text" name="nome" value="<?php echo $utente['nome']; ?>" required><br>

            <label for="cognome">Cognome: </label>
            <input type="text" name="cognome" value="<?php echo $utente['cognome']; ?>" required><br>

            <label for="email">Email: </label>
            <input type="email" name="email" value="<?php echo $utente['email']; ?>" required><br>

            <label for="password">Nuova Password: </label>
            <input type="password" name="password"><br>

            <label for="conferma_password">Conferma Nuova Password: </label>
            <input type="password" name="conferma_password"><br>

            <input type="submit" value="Modifica">
        </form>

        <a href="index.php">Torna alla Home</a>
<?php
    } else {
        echo 'Utente non trovato.';
    }
} else {
    echo 'Utente non loggato.';
}

// Chiudi la connessione al database
$connessione->close();
?>

</body>
</html>
