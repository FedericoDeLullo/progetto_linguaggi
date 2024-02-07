<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifica Utente</title>
    <link rel="stylesheet" href="../css/style_standard.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="../css/style_header.css">
    <?php
        include('../res/header.php');
    ?>
</head>
<body>
    
<div class="cont">

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
    <h1 class="titolo">Modifica Utente</h1>
    <table>
        <tr>
            <td colspan="2">
                <form class="form" action="processa_modifica_utente.php" method="post">
                    <input class="input" type="hidden" name="id" value="<?php echo $utente['id']; ?>">
                    <label class="nome" for="nome">Nome:</label>
                    <input class="input" type="text" id="nome" name="nome" value="<?php echo $utente['nome']; ?>" required><br>
                    <label class="nome" for="nome">Cognome:</label>
                    <input class="input" type="text" id="cognome" name="cognome" value="<?php echo $utente['cognome']; ?>" required><br>
                    <label class="nome" for="email">Email:</label>
                    <input class="input" type="email" id="email" name="email" value="<?php echo $utente['email']; ?>" required><br>
                    <label class="nome" for="nome">Password:</label>
                    <input class="input" type="text" id="password" name="password" value="<?php echo $utente['passwd']; ?>" required><br>
                    <label class="nome" for="nome">Crediti:</label>
                    <input class="input" type="number" id="crediti" name="crediti" value="<?php echo $utente['crediti']; ?>" required><br>
                    <label class="nome" for="nome">Indirizzo di residenza:</label>
                    <input class="input" type="text" id="indirizzo" name="indirizzo" value="<?php echo $utente['indirizzo_di_residenza']; ?>" required><br>
                    <label class="nome" for="nome">Cellulare:</label>
                    <input class="input" type="text" id="cellulare" name="cellulare" pattern="\d{10}" maxlength="10" value="<?php echo $utente['cellulare']; ?>" required>
                    <br><br><br>
                    <input class="btn" type="submit" value="Salva Modifiche">
                </form>
            </td>
        </tr>
    </table>
<?php
    } 
    else {
        echo 'Utente non trovato.';
    }
}
else {
    echo 'ID utente non valido.';
}

echo '</div>';

$connessione->close();
?>
</body>
</html>
