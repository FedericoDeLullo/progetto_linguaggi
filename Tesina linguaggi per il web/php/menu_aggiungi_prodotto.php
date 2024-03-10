<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aggiungi Prodotto</title>
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

        if(isset($_SESSION['successo_aggiunta_prodotto']) && $_SESSION['successo_aggiunta_prodotto'] == 'true'){
            echo '<h2 id="successo">Prodotto aggiunto con successo!!!</h2>';
            unset($_SESSION['successo_aggiunta_prodotto']);
        }
        if(isset($_SESSION['errore_immagine']) && $_SESSION['errore_immagine'] == 'true'){
            echo '<h2>Errore durante il caricamento dell\'immagine...</h2>';
            unset($_SESSION['errore_immagine']);
        }
        if(isset($_SESSION['errore_campi_vuoti']) && $_SESSION['errore_campi_vuoti'] == 'true'){
            echo '<h2>Compila tutti i campi obbligatori...</h2>';
            unset($_SESSION['errore_campi_vuoti']);
        }
        if(isset($_SESSION['errore_nome_esistente']) && $_SESSION['errore_nome_esistente'] == 'true'){
            echo '<h2>Nome prodotto già esistente...</h2>';
            unset($_SESSION['errore_nome_esistente']);
        }
        ?>
        <div class="cont">
            <h1 class="titolo">Aggiungi Prodotto</h1>
            <table>
                <tr>
                    <td colspan="2">
                        <form class="form" action="../res/aggiungi_prodotto.php" method="post" enctype="multipart/form-data">
                            <label class="nome" for="nome">Nome:</label>
                            <input class="input" type="text" name="nome" required><br>
                            <textarea style="width:500px; height:100px; resize:none; vertical-align:top;" class="input" name="descrizione" placeholder="Inserisci la DESCRIZIONE..."required></textarea><br>
                            <label class="nome" for="prezzo">Prezzo:</label>
                            <input class="input" type="number" name="prezzo" min="1" required><br>
                            <label class="nome" for="immagine">Immagine:</label>
                            <input class="input" type="file" name="immagine" accept="image/*" required><br>
                            <label class="nome" for="tipologia">Tipologia:</label>
                            <select select id="tipologia" name="tipologia">
                                <option value="magliette">Maglietta</option>
                                <option value="pantaloncini">Pantaloncino</option>
                                <option value="calzettoni">Calzettoni</option>
                            </select>
                            <br><br><br>
                            <input class="btn" type="submit" value="Aggiungi Prodotto">
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
