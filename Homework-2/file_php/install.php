<?php
// Configurazione del database
$host = "localhost:3308";
$username = "root";
$password = "";
$db = "GameStation";

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
    header("Location: ../index.html");
} else {
    echo "Errore durante la creazione del database: " . $connessione->error;
}

// Selezione del database
$connessione->select_db($db);

// Creazione della tabella "utenti"
$sql = "CREATE TABLE IF NOT EXISTS utenti (
    username VARCHAR(50) PRIMARY KEY,
    email VARCHAR(100),
    passwd VARCHAR(100)
)";
if ($connessione->query($sql) === TRUE) {
    echo "Tabella 'utenti' creata correttamente\n";
} else {
    echo "Errore durante la creazione della tabella 'utenti': " . $connessione->error;
}

// Creazione della tabella "articoli"
$sql = "CREATE TABLE IF NOT EXISTS articoli (
    id INT AUTO_INCREMENT PRIMARY KEY, 
    nome VARCHAR(50),
    categoria VARCHAR(10),
    prezzo DECIMAL(4,2),
    qta INT,
    path_foto VARCHAR(100)
)";
if ($connessione->query($sql) === TRUE) {
    echo "Tabella 'articoli' creata correttamente\n";
} else {
    echo "Errore durante la creazione della tabella 'articoli': " . $connessione->error;
}

$sql = "DELETE FROM articoli";
if ($connessione->query($sql) === TRUE) {
    echo "Tabella 'articoli' svuotata correttamente\n";
} else {
    echo "Errore durante lo svuotamento della tabella 'articoli': " . $connessione->error;
}

$sql = "INSERT INTO articoli (nome, categoria, prezzo, qta, path_foto) VALUES ('gioco_1', 'giochi', 9.99, 10, '../img/gioco_1.png')";
if ($connessione->query($sql) === TRUE) {
    echo "Tabella 'articoli' popolata correttamente\n";
} else {
    echo "Errore durante il popolamento della tabella 'articoli': " . $connessione->error;
}

$sql = "INSERT INTO articoli (nome, categoria, prezzo, qta, path_foto) VALUES ('gioco_2', 'giochi', 8.99, 20, '../img/gioco_2.png')";
if ($connessione->query($sql) === TRUE) {
    echo "Tabella 'articoli' popolata correttamente\n";
} else {
    echo "Errore durante il popolamento della tabella 'articoli': " . $connessione->error;
}

$sql = "INSERT INTO articoli (nome, categoria, prezzo, qta, path_foto) VALUES ('gioco_3', 'giochi', 99.99, 1, '../img/gioco_3.png')";
if ($connessione->query($sql) === TRUE) {
    echo "Tabella 'articoli' popolata correttamente\n";
} else {
    echo "Errore durante il popolamento della tabella 'articoli': " . $connessione->error;
}

$sql = "INSERT INTO articoli (nome, categoria, prezzo, qta, path_foto) VALUES ('gioco_4', 'giochi', 19.99, 10, '../img/gioco_4.png')";
if ($connessione->query($sql) === TRUE) {
    echo "Tabella 'articoli' popolata correttamente\n";
} else {
    echo "Errore durante il popolamento della tabella 'articoli': " . $connessione->error;
}

$sql = "INSERT INTO articoli (nome, categoria, prezzo, qta, path_foto) VALUES ('gioco_5', 'giochi', 9.99, 5, '../img/gioco_5.png')";
if ($connessione->query($sql) === TRUE) {
    echo "Tabella 'articoli' popolata correttamente\n";
} else {
    echo "Errore durante il popolamento della tabella 'articoli': " . $connessione->error;
}

// Chiusura della connessione
$connessione->close();
?>
