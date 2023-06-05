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
    header("Location:PHP/index.php");
} else {
    echo "Errore durante la creazione della tabella 'utenti': " . $connessione->error;
}

// Creazione della tabella "articoli"
$sql = "CREATE TABLE IF NOT EXISTS articoli (
  id INT AUTO_INCREMENT PRIMARY KEY, 
    nome VARCHAR(50),
    categoria VARCHAR(10),
    id_prodotto INT (20),
    prezzo INT (50)
)";

if ($connessione->query($sql) === TRUE) {
    echo "Tabella 'articoli' creata correttamente\n";
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

$sql = "INSERT INTO articoli (nome, categoria, id_articolo, prezzo) VALUES ('The Last of Us', 'giochi', 'gioco_1', '19.99')";
if ($connessione->query($sql) === TRUE) {
    echo "Tabella 'articoli' popolata correttamente\n";
} else {
    echo "Errore durante il popolamento della tabella 'articoli': " . $connessione->error;
}

$sql = "INSERT INTO articoli (nome, categoria, id_articolo, prezzo) VALUES ('Gta 5', 'giochi', 'gioco_2', '19.99')";
if ($connessione->query($sql) === TRUE) {
    echo "Tabella 'articoli' popolata correttamente\n";
} else {
    echo "Errore durante il popolamento della tabella 'articoli': " . $connessione->error;
}

$sql = "INSERT INTO articoli (nome, categoria, id_articolo, prezzo) VALUES ('Fifa 23', 'giochi', 'gioco_3' , '19.99')";
if ($connessione->query($sql) === TRUE) {
    echo "Tabella 'articoli' popolata correttamente\n";
} else {
    echo "Errore durante il popolamento della tabella 'articoli': " . $connessione->error;
}

$sql = "INSERT INTO articoli (nome, categoria, id_articolo, prezzo) VALUES ('Rainbow Six Siege', 'giochi','gioco_4', '19.99')";
if ($connessione->query($sql) === TRUE) {
    echo "Tabella 'articoli' popolata correttamente\n";
} else {
    echo "Errore durante il popolamento della tabella 'articoli': " . $connessione->error;
}

$sql = "INSERT INTO articoli (nome, categoria,  id_articolo, prezzo) VALUES ('Super Mario Galaxy', 'giochi', 'gioco_5', '19.99')";
if ($connessione->query($sql) === TRUE) {
    echo "Tabella 'articoli' popolata correttamente\n";
} else {
    echo "Errore durante il popolamento della tabella 'articoli': " . $connessione->error;
}
$sql = "INSERT INTO articoli (nome, categoria,  id_articolo, prezzo) VALUES ('Wii', 'console', 'console_1', '199.99')";
if ($connessione->query($sql) === TRUE) {
    echo "Tabella 'articoli' popolata correttamente\n";
} else {
    echo "Errore durante il popolamento della tabella 'articoli': " . $connessione->error;
}
$sql = "INSERT INTO articoli (nome, categoria, id_articolo, prezzo) VALUES ('Nintendo Switch', 'console', 'console_2', '399.99' )";
if ($connessione->query($sql) === TRUE) {
    echo "Tabella 'articoli' popolata correttamente\n";
} else {
    echo "Errore durante il popolamento della tabella 'articoli': " . $connessione->error;
}
$sql = "INSERT INTO articoli (nome, categoria, id_articolo, prezzo) VALUES ('Playstation 5', 'console', 'console_3', '499.99')";
if ($connessione->query($sql) === TRUE) {
    echo "Tabella 'articoli' popolata correttamente\n";
} else {
    echo "Errore durante il popolamento della tabella 'articoli': " . $connessione->error;
}
$sql = "INSERT INTO articoli (nome, categoria, id_articolo, prezzo) VALUES ('Playstation 4', 'console', 'console_4', '199.99')";
if ($connessione->query($sql) === TRUE) {
    echo "Tabella 'articoli' popolata correttamente\n";
} else {
    echo "Errore durante il popolamento della tabella 'articoli': " . $connessione->error;
}
$sql = "INSERT INTO articoli (nome, categoria, id_articolo, prezzo) VALUES ('Xbox', 'console', 'console_5', '249.99')";
if ($connessione->query($sql) === TRUE) {
    echo "Tabella 'articoli' popolata correttamente\n";
} else {
    echo "Errore durante il popolamento della tabella 'articoli': " . $connessione->error;
}
$sql = "INSERT INTO articoli (nome, categoria, id_articolo, prezzo) VALUES ('Dragon Ball', 'manga', 'manga_1', '19.99')";
if ($connessione->query($sql) === TRUE) {
    echo "Tabella 'articoli' popolata correttamente\n";
} else {
    echo "Errore durante il popolamento della tabella 'articoli': " . $connessione->error;
}
$sql = "INSERT INTO articoli (nome, categoria, id_articolo, prezzo) VALUES ('One Piece', 'manga', 'manga_2', '19.99')";
if ($connessione->query($sql) === TRUE) {
    echo "Tabella 'articoli' popolata correttamente\n";
} else {
    echo "Errore durante il popolamento della tabella 'articoli': " . $connessione->error;
}
$sql = "INSERT INTO articoli (nome, categoria, id_articolo, prezzo) VALUES ('Attack on Titan', 'manga', 'manga_3', '19.99')";
if ($connessione->query($sql) === TRUE) {
    echo "Tabella 'articoli' popolata correttamente\n";
} else {
    echo "Errore durante il popolamento della tabella 'articoli': " . $connessione->error;
}
$sql = "INSERT INTO articoli (nome, categoria, id_articolo, prezzo) VALUES ('Demon Slayer', 'manga', 'manga_4', '19.99')";
if ($connessione->query($sql) === TRUE) {
    echo "Tabella 'articoli' popolata correttamente\n";
} else {
    echo "Errore durante il popolamento della tabella 'articoli': " . $connessione->error;
}
$sql = "INSERT INTO articoli (nome, categoria, id_articolo, prezzo) VALUES ('Naruto', 'manga',  'manga_5', '19.99')";
if ($connessione->query($sql) === TRUE) {
    echo "Tabella 'articoli' popolata correttamente\n";
} else {
    echo "Errore durante il popolamento della tabella 'articoli': " . $connessione->error;
}


// Chiusura della connessione
$connessione->close();
?>