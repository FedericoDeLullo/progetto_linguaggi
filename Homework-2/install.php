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
    path_foto VARCHAR(100),
    path_info VARCHAR(255)
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
$sql = "INSERT INTO articoli (nome, categoria, path_foto, path_info) VALUES ('Wii', 'console', '../img/console_1.png', 'https://www.nintendo.it/Wii/Wii-94559.html')";
if ($connessione->query($sql) === TRUE) {
    echo "Tabella 'articoli' popolata correttamente\n";
} else {
    echo "Errore durante il popolamento della tabella 'articoli': " . $connessione->error;
}
$sql = "INSERT INTO articoli (nome, categoria, path_foto, path_info) VALUES ('Nintendo Switch', 'console', '../img/console_2.png', 'https://www.nintendo.it/Console-e-accessori/Famiglia-Nintendo-Switch/Nintendo-Switch/Nintendo-Switch-1148779.html')";
if ($connessione->query($sql) === TRUE) {
    echo "Tabella 'articoli' popolata correttamente\n";
} else {
    echo "Errore durante il popolamento della tabella 'articoli': " . $connessione->error;
}
$sql = "INSERT INTO articoli (nome, categoria, path_foto, path_info) VALUES ('Playstation 5', 'console', '../img/console_3.png', 'https://www.playstation.com/it-it/ps5/')";
if ($connessione->query($sql) === TRUE) {
    echo "Tabella 'articoli' popolata correttamente\n";
} else {
    echo "Errore durante il popolamento della tabella 'articoli': " . $connessione->error;
}
$sql = "INSERT INTO articoli (nome, categoria, path_foto, path_info) VALUES ('Playstation 4', 'console', '../img/console_4.png', 'https://www.playstation.com/it-it/ps4/')";
if ($connessione->query($sql) === TRUE) {
    echo "Tabella 'articoli' popolata correttamente\n";
} else {
    echo "Errore durante il popolamento della tabella 'articoli': " . $connessione->error;
}
$sql = "INSERT INTO articoli (nome, categoria, path_foto, path_info) VALUES ('Xbox', 'console', '../img/console_5.png', 'https://www.xbox.com/it-IT/consoles/xbox-series-x')";
if ($connessione->query($sql) === TRUE) {
    echo "Tabella 'articoli' popolata correttamente\n";
} else {
    echo "Errore durante il popolamento della tabella 'articoli': " . $connessione->error;
}
$sql = "INSERT INTO articoli (nome, categoria, path_foto, path_info) VALUES ('Dragon Ball', 'manga', '../img/manga_1.png', 'https://www.animeclick.it/manga/9542/dragonball')";
if ($connessione->query($sql) === TRUE) {
    echo "Tabella 'articoli' popolata correttamente\n";
} else {
    echo "Errore durante il popolamento della tabella 'articoli': " . $connessione->error;
}
$sql = "INSERT INTO articoli (nome, categoria, path_foto, path_info) VALUES ('One Piece', 'manga', '../img/manga_2.png', 'https://www.animeclick.it/anime/1160/one-piece')";
if ($connessione->query($sql) === TRUE) {
    echo "Tabella 'articoli' popolata correttamente\n";
} else {
    echo "Errore durante il popolamento della tabella 'articoli': " . $connessione->error;
}
$sql = "INSERT INTO articoli (nome, categoria, path_foto, path_info) VALUES ('Attack on Titan', 'manga', '../img/manga_3.png', 'https://www.animeclick.it/manga/11470/shingeki-no-kyojin')";
if ($connessione->query($sql) === TRUE) {
    echo "Tabella 'articoli' popolata correttamente\n";
} else {
    echo "Errore durante il popolamento della tabella 'articoli': " . $connessione->error;
}
$sql = "INSERT INTO articoli (nome, categoria, path_foto, path_info) VALUES ('Demon Slayer', 'manga', '../img/manga_4.png', 'https://www.animeclick.it/manga/17678/kimetsu-no-yaiba')";
if ($connessione->query($sql) === TRUE) {
    echo "Tabella 'articoli' popolata correttamente\n";
} else {
    echo "Errore durante il popolamento della tabella 'articoli': " . $connessione->error;
}
$sql = "INSERT INTO articoli (nome, categoria, path_foto, path_info) VALUES ('Naruto', 'manga', '../img/manga_5.png', 'https://www.animeclick.it/manga/9847/naruto')";
if ($connessione->query($sql) === TRUE) {
    echo "Tabella 'articoli' popolata correttamente\n";
} else {
    echo "Errore durante il popolamento della tabella 'articoli': " . $connessione->error;
}


// Chiusura della connessione
$connessione->close();
?>