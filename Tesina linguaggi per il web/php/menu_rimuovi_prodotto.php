<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rimuovi Prodotto</title>
    <link rel="stylesheet" href="../css/style_standard.css">
    <link rel="stylesheet" href="../css/style_header.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
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
        if(isset($_SESSION['successo_rimozione_prodotto']) && $_SESSION['successo_rimozione_prodotto'] == 'true'){
            echo '<h2 id="successo">Prodotto rimosso con successo!!!</h2>';
            unset($_SESSION['successo_rimozione_prodotto']);
        }
        if(isset($_SESSION['fallimento_rimozione_prodotto']) && $_SESSION['fallimento_rimozione_prodotto'] == 'true'){
            echo '<h2>Prodotto inesistente, controlla che il nome del prodotto inserito sia nel catalogo...</h2>';
            unset($_SESSION['fallimento_rimozione_prodotto']);
        }
        ?>
    <div class="cont">
        <h1 class="titolo">Rimuovi Prodotto</h1>
        <table>
            <tr>
                <td colspan="2">
                    <form class="form" action="../res/rimuovi_prodotto.php" method="post">
                        <label class="nome" for="nome">Inserire il Nome del Prodotto:</label>
                        <input class="input" type="text" name="nome" required>
                        <br><br><br>
                        <input class="btn" type="submit" value="Rimuovi Prodotto">
                    </form>
                </td>
            </tr>
        </table>
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