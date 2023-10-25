<?php
// Configurazione del database
$host = "127.0.0.1";
$username = "root";
$password = "";
$db = "Fut_Shirt";

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
    nome VARCHAR(50) PRIMARY KEY,
    cognome varchar(50),
    email VARCHAR(100),
    passwd VARCHAR(255),
    crediti INT,
    data_di_nascita DATE,
    indirizzo_di_residenza VARCHAR(255),
    codice_fiscale VARCHAR(255),
    cellulare VARCHAR(255)
)";
if ($connessione->query($sql) === TRUE) {
    echo "Tabella 'utenti' creata correttamente\n";
    header("Location:html/index.html");
} else {
    echo "Errore durante la creazione della tabella 'utenti': " . $connessione->error;
}

// Inserimento dei dati nella tabella 'utenti'
$sql = "INSERT INTO `utenti` (`nome`,`cognome`, `email`, `passwd`,`crediti`,`data_di_nascita`,`indirizzo_di_residenza`,`codice_fiscale`,`cellulare`) VALUES
 ('Lorenzo','Francescotti', 'lorenzofrancescotti@gmail.com', '" . password_hash('lollo', PASSWORD_DEFAULT) . "','1000', '2001-06-14', 'Via Muzio Clementi', 'FRCMDIIKE4211DE','3339553001' ),
 ('Federico', 'De Lullo', 'federico@gmail.com', '" . password_hash('roma', PASSWORD_DEFAULT) . "','1000','2001-04-11','Via A.Stradivari 4', 'DLLLFVHBI556CD','3293321366')";
if ($connessione->query($sql) === TRUE) {
    echo "Tabella 'utenti' popolata correttamente\n";
} else {
    echo "Errore durante il popolamento della tabella 'utenti': " . $connessione->error;
}

// Chiusura della connessione
$connessione->close();
?>
