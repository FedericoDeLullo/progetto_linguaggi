<?php
// Configurazione del database
$host = "127.0.0.1";
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

// Creazione della tabella "articoli"
$sql = "CREATE TABLE IF NOT EXISTS articoli (
  id INT AUTO_INCREMENT PRIMARY KEY, 
    nome VARCHAR(50),
    categoria VARCHAR(10),
    id_articolo VARCHAR (50),
    prezzo INT,
    quantita INT
)";
if ($connessione->query($sql) === TRUE) {
    echo "Tabella 'articoli' creata correttamente\n";
} else {
    echo "Errore durante la creazione della tabella 'articoli': " . $connessione->error;
}
$sql = "CREATE TABLE IF NOT EXISTS acquisti (
  id INT AUTO_INCREMENT PRIMARY KEY, 
      username VARCHAR(50),
      id_articolo VARCHAR (50),
      quantita INT
)";

if ($connessione->query($sql) === TRUE) {
    echo "Tabella 'acquisti' creata correttamente\n";
} else {
    echo "Errore durante la creazione della tabella 'articoli': " . $connessione->error;
}
$sql = "INSERT INTO `utenti` (`username`, `email`, `passwd`) VALUES
 ('Lollo', 'lorenzofrancescotti@gmail.com', '" . password_hash('lollo', PASSWORD_DEFAULT) . "'),
 ('Federico', 'federico@gmail.com', '" . password_hash('roma', PASSWORD_DEFAULT) . "')";
 if ($connessione->query($sql) === TRUE) {
    echo "Tabella 'utenti' popolata correttamente\n";
} else {
    echo "Errore durante il popolamento della tabella 'utenti': " . $connessione->error;
}

$sql = "DELETE FROM articoli";
if ($connessione->query($sql) === TRUE) {
    echo "Tabella 'articoli' svuotata correttamente\n";
} else {
    echo "Errore durante lo svuotamento della tabella 'articoli': " . $connessione->error;
}

$sql = "INSERT INTO articoli (nome, categoria, id_articolo, prezzo, quantita) VALUES ('The Last of Us', 'giochi', 'gioco_1', '20', '50')";
if ($connessione->query($sql) === TRUE) {
    echo "Tabella 'articoli' popolata correttamente\n";
} else {
    echo "Errore durante il popolamento della tabella 'articoli': " . $connessione->error;
}

$sql = "INSERT INTO articoli (nome, categoria, id_articolo, prezzo, quantita) VALUES ('Gta 5', 'giochi', 'gioco_2', '20', '50')";
if ($connessione->query($sql) === TRUE) {
    echo "Tabella 'articoli' popolata correttamente\n";
} else {
    echo "Errore durante il popolamento della tabella 'articoli': " . $connessione->error;
}

$sql = "INSERT INTO articoli (nome, categoria, id_articolo, prezzo, quantita) VALUES ('Fifa 23', 'giochi', 'gioco_3' , '20', '50')";
if ($connessione->query($sql) === TRUE) {
    echo "Tabella 'articoli' popolata correttamente\n";
} else {
    echo "Errore durante il popolamento della tabella 'articoli': " . $connessione->error;
}

$sql = "INSERT INTO articoli (nome, categoria, id_articolo, prezzo, quantita) VALUES ('Rainbow Six Siege', 'giochi','gioco_4', '20', '50')";
if ($connessione->query($sql) === TRUE) {
    echo "Tabella 'articoli' popolata correttamente\n";
} else {
    echo "Errore durante il popolamento della tabella 'articoli': " . $connessione->error;
}

$sql = "INSERT INTO articoli (nome, categoria,  id_articolo, prezzo, quantita) VALUES ('Super Mario Galaxy', 'giochi', 'gioco_5', '20', '50')";
if ($connessione->query($sql) === TRUE) {
    echo "Tabella 'articoli' popolata correttamente\n";
} else {
    echo "Errore durante il popolamento della tabella 'articoli': " . $connessione->error;
}
$sql = "INSERT INTO articoli (nome, categoria,  id_articolo, prezzo, quantita) VALUES ('Wii', 'console', 'console_1', '200', '50')";
if ($connessione->query($sql) === TRUE) {
    echo "Tabella 'articoli' popolata correttamente\n";
} else {
    echo "Errore durante il popolamento della tabella 'articoli': " . $connessione->error;
}
$sql = "INSERT INTO articoli (nome, categoria, id_articolo, prezzo, quantita) VALUES ('Nintendo Switch', 'console', 'console_2', '400', '50' )";
if ($connessione->query($sql) === TRUE) {
    echo "Tabella 'articoli' popolata correttamente\n";
} else {
    echo "Errore durante il popolamento della tabella 'articoli': " . $connessione->error;
}
$sql = "INSERT INTO articoli (nome, categoria, id_articolo, prezzo, quantita) VALUES ('Playstation 5', 'console', 'console_3', '500', '50')";
if ($connessione->query($sql) === TRUE) {
    echo "Tabella 'articoli' popolata correttamente\n";
} else {
    echo "Errore durante il popolamento della tabella 'articoli': " . $connessione->error;
}
$sql = "INSERT INTO articoli (nome, categoria, id_articolo, prezzo, quantita) VALUES ('Playstation 4', 'console', 'console_4', '200', '50')";
if ($connessione->query($sql) === TRUE) {
    echo "Tabella 'articoli' popolata correttamente\n";
} else {
    echo "Errore durante il popolamento della tabella 'articoli': " . $connessione->error;
}
$sql = "INSERT INTO articoli (nome, categoria, id_articolo, prezzo, quantita) VALUES ('Xbox', 'console', 'console_5', '250', '50')";
if ($connessione->query($sql) === TRUE) {
    echo "Tabella 'articoli' popolata correttamente\n";
} else {
    echo "Errore durante il popolamento della tabella 'articoli': " . $connessione->error;
}
$sql = "INSERT INTO articoli (nome, categoria, id_articolo, prezzo, quantita) VALUES ('Dragon Ball', 'manga', 'manga_1', '20', '50')";
if ($connessione->query($sql) === TRUE) {
    echo "Tabella 'articoli' popolata correttamente\n";
} else {
    echo "Errore durante il popolamento della tabella 'articoli': " . $connessione->error;
}
$sql = "INSERT INTO articoli (nome, categoria, id_articolo, prezzo, quantita) VALUES ('One Piece', 'manga', 'manga_2', '20', '50')";
if ($connessione->query($sql) === TRUE) {
    echo "Tabella 'articoli' popolata correttamente\n";
} else {
    echo "Errore durante il popolamento della tabella 'articoli': " . $connessione->error;
}
$sql = "INSERT INTO articoli (nome, categoria, id_articolo, prezzo, quantita) VALUES ('Attack on Titan', 'manga', 'manga_3', '20', '50')";
if ($connessione->query($sql) === TRUE) {
    echo "Tabella 'articoli' popolata correttamente\n";
} else {
    echo "Errore durante il popolamento della tabella 'articoli': " . $connessione->error;
}
$sql = "INSERT INTO articoli (nome, categoria, id_articolo, prezzo, quantita) VALUES ('Demon Slayer', 'manga', 'manga_4', '20', '50')";
if ($connessione->query($sql) === TRUE) {
    echo "Tabella 'articoli' popolata correttamente\n";
} else {
    echo "Errore durante il popolamento della tabella 'articoli': " . $connessione->error;
}
$sql = "INSERT INTO articoli (nome, categoria, id_articolo, prezzo, quantita) VALUES ('Naruto', 'manga',  'manga_5', '20', '50')";
if ($connessione->query($sql) === TRUE) {
    echo "Tabella 'articoli' popolata correttamente\n";
} else {
    echo "Errore durante il popolamento della tabella 'articoli': " . $connessione->error;
}


// Chiusura della connessione
$connessione->close();
?>