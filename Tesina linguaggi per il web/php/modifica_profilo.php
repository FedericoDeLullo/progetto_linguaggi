<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifica Utente</title>
    <link rel="stylesheet" href="../css/style_gestione_utenti.css">
</head>
<body>
<div class="home">
                    <a href="../html/index_cliente.html">
                <div class="home_link" title="home"><img src="../img/home1.png" alt="home"></div></a>
            </div>
    <?php
require_once('../res/connection.php');

// Verifica se è stato fornito un ID utente valido
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id_utente = $_GET['id'];

    // Esegui una query per ottenere i dati dell'utente
    $query = "SELECT * FROM utenti WHERE id = $id_utente";
    $result = $connessione->query($query);

    if ($result->num_rows == 1) {
        $utente = $result->fetch_assoc();
    ?>
    <h2>Modifica Utente</h2>

    <form class="form" action="processa_modifica_utente.php" method="post">
        <input type="hidden" name="id" value="<?php echo $utente['id']; ?>">
        <label class="nome" for="nome">Nome:</label>
        <input  type="text" id="nome" name="nome" value="<?php echo $utente['nome']; ?>" required><br>
        <label class="nome" for="nome">Cognome:</label>
        <input  type="text" id="cognome" name="cognome" value="<?php echo $utente['cognome']; ?>" required><br>
        <label class="nome" for="email">Email:</label>
        <input  type="email" id="email" name="email" value="<?php echo $utente['email']; ?>" required><br>
        <label class="nome" for="nome">Password:</label>
        <input  type="text" id="password" name="password" value="<?php echo $utente['passwd']; ?>" required><br>
        <label class="nome" for="nome">Crediti:</label>
        <input  type="number" id="crediti" name="crediti" value="<?php echo $utente['crediti']; ?>" required><br>
        <label class="nome" for="nome">Indirizzo di residenza:</label>
        <input  type="text" id="indirizzo" name="indirizzo" value="<?php echo $utente['indirizzo_di_residenza']; ?>" required><br>
        <label class="nome" for="nome">Cellulare:</label>
        <input type="number" id="cellulare" name="cellulare" value="<?php echo $utente['cellulare']; ?>" required><br>
        <input class="btn1" type="submit" value="Salva Modifiche">
    </form><?php
    } else {
        echo 'Utente non trovato.';
    }
} else {
    echo 'ID utente non valido.';
}

$connessione->close();
?>
</body>
</html>
