<?php
// Configurazione del database
$host = "127.0.0.1";
$username = "root";
$password = "";
$db = "GameStation2";

// Creazione della connessione
$connessione = new mysqli($host, $username, $password);

// Controllo della connessione
if($connessione == false){
    die("Errore durante la connessione: ".$connessione->connect_error);
}

// Creazione del database
$sql = "CREATE DATABASE IF NOT EXISTS $db";
if ($connessione->query($sql) === TRUE) {
    echo "Database creato correttamente\n";
} else {
    echo "Errore durante la creazione del database: " . $connessione->error;
}

// Selezione del database
$connessione->select_db($db);

// Creazione della tabella "utenti"
$sql = "CREATE TABLE IF NOT EXISTS utenti (
    username VARCHAR(50) PRIMARY KEY,
    email VARCHAR(100),
    passwd VARCHAR(255)
)";
if ($connessione->query($sql) === TRUE) {
    echo "Tabella 'utenti' creata correttamente\n";
    header("Location:HTML/index.html");
} else {
    echo "Errore durante la creazione della tabella 'utenti': " . $connessione->error;
}

$sql = "INSERT INTO `utenti` (`username`, `email`, `passwd`) VALUES
 ('Lollo', 'lorenzofrancescotti@gmail.com', '" . password_hash('lollo', PASSWORD_DEFAULT) . "'),
 ('Federico', 'federico@gmail.com', '" . password_hash('roma', PASSWORD_DEFAULT) . "')";
 if ($connessione->query($sql) === TRUE) {
    echo "Tabella 'utenti' popolata correttamente\n";
} else {
    echo "Errore durante il popolamento della tabella 'utenti': " . $connessione->error;
}
// Chiusura della connessione
$connessione->close();
?>