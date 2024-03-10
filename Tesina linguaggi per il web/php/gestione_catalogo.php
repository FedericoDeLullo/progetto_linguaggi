<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../css/style_menu.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="../css/style_header.css">
    <?php
        include('../res/header.php');
    ?>
</head>
<body>
<?php
// Include il file di connessione al database
require_once('../res/connection.php');
if (!isset($_SESSION['id'])) {
    // Reindirizza l'utente alla pagina di accesso se non è loggato
    header("Location: login_cliente.php");
    exit();
}

// Controlla se l'utente è un amministratore
$id_utente = $_SESSION['id'];
$sql_select = "SELECT gestore FROM utenti WHERE id = '$id_utente' AND gestore = 1";

if ($result = $connessione->query($sql_select)) {
    if ($result->num_rows === 1) {
        ?>
        <div class="cont">
            <table>
                <tr>
                    <td class="due_bottoni"><a href="menu_aggiungi_prodotto.php" class="admin">Aggiungi Prodotto</a></td>
                    <td class="due_bottoni"><a href="menu_rimuovi_prodotto.php" class="admin">Rimuovi Prodotto</a></td>
                </tr>
            </table>
            <div class="sep"></div>
        </div>   
        <?php
    } else {
        // Se l'utente non è un amministratore, reindirizzalo a una pagina di accesso negato
        header("Location: accesso_negato.php");
        exit();
    }
} else {
echo "Errore nella query: " . $connessione->error;
}
?>
</body>
</html>