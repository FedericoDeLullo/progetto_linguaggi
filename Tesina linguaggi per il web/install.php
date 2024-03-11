<?php
// Configurazione del database
$host = "127.0.0.1";
$username = "root";
$password = "";
$db = "Rugby_World";

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
    id int AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) ,
    cognome varchar(50),
    email VARCHAR(100),
    passwd VARCHAR(255),
    crediti FLOAT,
    data_di_nascita DATE,
    indirizzo_di_residenza VARCHAR(255),
    codice_fiscale VARCHAR(255),
    cellulare VARCHAR(255),
    utente int,
    ammin int,
    gestore int,
    reputazione int,
    ban int,
    data_registrazione date
)";
if ($connessione->query($sql) === TRUE) {
    echo "Tabella 'utenti' creata correttamente\n";
    header("Location:php/index.php");
} else {
    echo "Errore durante la creazione della tabella 'utenti': " . $connessione->error;
}

// Inserimento dei dati nella tabella 'utenti'
$sql = "INSERT INTO `utenti` (`id`,`nome`,`cognome`, `email`, `passwd`,`crediti`,`data_di_nascita`,`indirizzo_di_residenza`,`codice_fiscale`,`cellulare`,`utente`,`ammin`,`gestore`,`reputazione`,`ban`,`data_registrazione`) VALUES
 ('1','Lorenzo','Francescotti', 'lorenzofrancescotti@gmail.com', '" . password_hash('Lorenzo2001!', PASSWORD_DEFAULT) . "','1000', '2001-06-14', 'Via Muzio Clementi', 'FRNLNZ01H14H501Z','3339553001','0','1','0','11', '0','2022-06-14'),
 ('2','Federico', 'De Lullo', 'federico@gmail.com', '" . password_hash('Roma1234!', PASSWORD_DEFAULT) . "','1000','2001-04-11','Via A.Stradivari 4', 'DLLFRC01D11H501P','3293321366','0','0','1','11','0','2022-06-14'),
 ('3','Federico','Gatti', 'federicodelullo84@gmail.com', '" . password_hash('Roma1234!', PASSWORD_DEFAULT) . "','0', '2001-06-14', 'Via Ugo La Malfa 4', 'FRNLNZ01H14H456D','3339553256','1','0','0','1', '0','2022-06-14'),
 ('4','Lorenzo','Insigne', 'lorenzo@gmail.com', '" . password_hash('Lorenzo2001!', PASSWORD_DEFAULT) . "','0', '2001-06-14', 'Via Caligola', 'FRNLNZ01H14H159L','3339553789','1','0','0','1', '0','2022-09-14'),
 ('5','Luca','Sintoni', 'luca@gmail.com', '" . password_hash('Luca1234!', PASSWORD_DEFAULT) . "','0', '2001-06-14', 'Via Andrea Doria', 'FRNLNZ01H14H753P','3339553123','1','0','0','1', '0','2023-04-14')";
if ($connessione->query($sql) === TRUE) {
    echo "Tabella 'utenti' popolata correttamente\n";
} else {
    echo "Errore durante il popolamento della tabella 'utenti': " . $connessione->error;
}

// Chiusura della connessione
$connessione->close();
?>