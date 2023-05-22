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
    header("Location:../index.html");
} else {
    echo "Errore durante la creazione della tabella 'utenti': " . $connessione->error;
}

// Creazione della tabella "articoli"
$sql = "CREATE TABLE IF NOT EXISTS articoli (
    id INT AUTO_INCREMENT PRIMARY KEY, 
    nome VARCHAR(50),
    categoria VARCHAR(10),
    path_foto VARCHAR(100),
    path_info VARCHAR(255)
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

$sql = "INSERT INTO articoli (nome, categoria, path_foto, path_info) VALUES ('The Last of Us', 'giochi', '../img/gioco_1.png', 'https://it.wikipedia.org/wiki/The_Last_of_Us')";
if ($connessione->query($sql) === TRUE) {
    echo "Tabella 'articoli' popolata correttamente\n";
} else {
    echo "Errore durante il popolamento della tabella 'articoli': " . $connessione->error;
}

$sql = "INSERT INTO articoli (nome, categoria, path_foto, path_info) VALUES ('Gta 5', 'giochi', '../img/gioco_2.png', 'https://www.rockstargames.com/it/gta-v')";
if ($connessione->query($sql) === TRUE) {
    echo "Tabella 'articoli' popolata correttamente\n";
} else {
    echo "Errore durante il popolamento della tabella 'articoli': " . $connessione->error;
}

$sql = "INSERT INTO articoli (nome, categoria,path_foto, path_info) VALUES ('Fifa 23', 'giochi', '../img/gioco_3.png','https://www.ea.com/it-it/games/fifa/fifa-23' )";
if ($connessione->query($sql) === TRUE) {
    echo "Tabella 'articoli' popolata correttamente\n";
} else {
    echo "Errore durante il popolamento della tabella 'articoli': " . $connessione->error;
}

$sql = "INSERT INTO articoli (nome, categoria, path_foto, path_info) VALUES ('Rainbow Six Siege', 'giochi', '../img/gioco_4.png', 'https://www.ubisoft.com/it-it/game/rainbow-six/siege')";
if ($connessione->query($sql) === TRUE) {
    echo "Tabella 'articoli' popolata correttamente\n";
} else {
    echo "Errore durante il popolamento della tabella 'articoli': " . $connessione->error;
}

$sql = "INSERT INTO articoli (nome, categoria, path_foto, path_info) VALUES ('Super Mario Galaxy', 'giochi', '../img/gioco_5.png', 'https://www.nintendo.it/Giochi/Universo-Nintendo/Portale-di-Super-Mario/Portale-di-Super-Mario-627604.html')";
if ($connessione->query($sql) === TRUE) {
    echo "Tabella 'articoli' popolata correttamente\n";
} else {
    echo "Errore durante il popolamento della tabella 'articoli': " . $connessione->error;
}

$sql = "INSERT INTO articoli (nome, categoria, path_foto, path_info) VALUES ('Super Mario Galaxy', 'console', '../img/console_1.png', 'https://www.nintendo.it/Giochi/Universo-Nintendo/Portale-di-Super-Mario/Portale-di-Super-Mario-627604.html')";
if ($connessione->query($sql) === TRUE) {
    echo "Tabella 'articoli' popolata correttamente\n";
} else {
    echo "Errore durante il popolamento della tabella 'articoli': " . $connessione->error;
}
$sql = "INSERT INTO articoli (nome, categoria, path_foto, path_info) VALUES ('Super Mario Galaxy', 'console', '../img/console_2.png', 'https://www.nintendo.it/Giochi/Universo-Nintendo/Portale-di-Super-Mario/Portale-di-Super-Mario-627604.html')";
if ($connessione->query($sql) === TRUE) {
    echo "Tabella 'articoli' popolata correttamente\n";
} else {
    echo "Errore durante il popolamento della tabella 'articoli': " . $connessione->error;
}
$sql = "INSERT INTO articoli (nome, categoria, path_foto, path_info) VALUES ('Super Mario Galaxy', 'console', '../img/console_3.png', 'https://www.nintendo.it/Giochi/Universo-Nintendo/Portale-di-Super-Mario/Portale-di-Super-Mario-627604.html')";
if ($connessione->query($sql) === TRUE) {
    echo "Tabella 'articoli' popolata correttamente\n";
} else {
    echo "Errore durante il popolamento della tabella 'articoli': " . $connessione->error;
}
$sql = "INSERT INTO articoli (nome, categoria, path_foto, path_info) VALUES ('Super Mario Galaxy', 'console', '../img/console_4.png', 'https://www.nintendo.it/Giochi/Universo-Nintendo/Portale-di-Super-Mario/Portale-di-Super-Mario-627604.html')";
if ($connessione->query($sql) === TRUE) {
    echo "Tabella 'articoli' popolata correttamente\n";
} else {
    echo "Errore durante il popolamento della tabella 'articoli': " . $connessione->error;
}
$sql = "INSERT INTO articoli (nome, categoria, path_foto, path_info) VALUES ('Super Mario Galaxy', 'console', '../img/console_5.png', 'https://www.nintendo.it/Giochi/Universo-Nintendo/Portale-di-Super-Mario/Portale-di-Super-Mario-627604.html')";
if ($connessione->query($sql) === TRUE) {
    echo "Tabella 'articoli' popolata correttamente\n";
} else {
    echo "Errore durante il popolamento della tabella 'articoli': " . $connessione->error;
}
$sql = "INSERT INTO articoli (nome, categoria, path_foto, path_info) VALUES ('Super Mario Galaxy', 'manga', '../img/manga_1.png', 'https://www.nintendo.it/Giochi/Universo-Nintendo/Portale-di-Super-Mario/Portale-di-Super-Mario-627604.html')";
if ($connessione->query($sql) === TRUE) {
    echo "Tabella 'articoli' popolata correttamente\n";
} else {
    echo "Errore durante il popolamento della tabella 'articoli': " . $connessione->error;
}
$sql = "INSERT INTO articoli (nome, categoria, path_foto, path_info) VALUES ('Super Mario Galaxy', 'manga', '../img/manga_2.png', 'https://www.nintendo.it/Giochi/Universo-Nintendo/Portale-di-Super-Mario/Portale-di-Super-Mario-627604.html')";
if ($connessione->query($sql) === TRUE) {
    echo "Tabella 'articoli' popolata correttamente\n";
} else {
    echo "Errore durante il popolamento della tabella 'articoli': " . $connessione->error;
}
$sql = "INSERT INTO articoli (nome, categoria, path_foto, path_info) VALUES ('Super Mario Galaxy', 'manga', '../img/manga_3.png', 'https://www.nintendo.it/Giochi/Universo-Nintendo/Portale-di-Super-Mario/Portale-di-Super-Mario-627604.html')";
if ($connessione->query($sql) === TRUE) {
    echo "Tabella 'articoli' popolata correttamente\n";
} else {
    echo "Errore durante il popolamento della tabella 'articoli': " . $connessione->error;
}
$sql = "INSERT INTO articoli (nome, categoria, path_foto, path_info) VALUES ('Super Mario Galaxy', 'manga', '../img/manga_4.png', 'https://www.nintendo.it/Giochi/Universo-Nintendo/Portale-di-Super-Mario/Portale-di-Super-Mario-627604.html')";
if ($connessione->query($sql) === TRUE) {
    echo "Tabella 'articoli' popolata correttamente\n";
} else {
    echo "Errore durante il popolamento della tabella 'articoli': " . $connessione->error;
}
$sql = "INSERT INTO articoli (nome, categoria, path_foto, path_info) VALUES ('Super Mario Galaxy', 'manga', '../img/manga_5.png', 'https://www.nintendo.it/Giochi/Universo-Nintendo/Portale-di-Super-Mario/Portale-di-Super-Mario-627604.html')";
if ($connessione->query($sql) === TRUE) {
    echo "Tabella 'articoli' popolata correttamente\n";
} else {
    echo "Errore durante il popolamento della tabella 'articoli': " . $connessione->error;
}




// Chiusura della connessione
$connessione->close();
?>
