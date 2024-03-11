<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Il tuo carrello</title>
    <link rel="stylesheet" href="../css/style_standard.css">
    <link rel="stylesheet" href="../css/style_catalogo.css">
    <link rel="stylesheet" href="../css/style_search.css">
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
$sql_select = "SELECT gestore, ammin FROM utenti WHERE id = '$id_utente' AND (gestore = 1 OR ammin = 1)";

if ($result = $connessione->query($sql_select)) {
    if ($result->num_rows === 1) {
    $id_prodotto = $_GET['id_prodotto'];
    $tipologia = $_GET['tipologia'];
    ?>
    <div class="cont">
        <h1 class="titolo">Aggiungi sconto</h1>

        <form class="form" method="post" action="gestione_sconti.php">
            <table>
                <tr>
                    <td class="input">
                        <h3>- INFORMAZIONI GENERICHE SCONTO -</h3>
                    </td>
                </tr>
                <tr>
                    <td class="input">
                        <label for="generico">SCONTO INDISCRIMINATO (%):</label>
                        <input class="input" style="margin-bottom:0; width: 80px;" type="number" id="generico" name="generico" placeholder="2" min="0" max="30" value="<?php if(isset($_SESSION['form_off_generico'])) echo $_SESSION['form_off_generico']; ?>" required>
                    </td>
                </tr>
                <tr>
                    <td class="input">
                        <label for="bonus">BONUS CREDITI:</label>
                        <input class="input" style="margin-bottom:0; width: 80px;" type="number" id="bonus" name="bonus" placeholder="2" min="0" max="5" value="<?php if(isset($_SESSION['form_off_bonus'])) echo $_SESSION['form_off_bonus']; ?>" required>
                    </td>
                </tr>
                <tr>
                    <td class="input">
                        <h3>- INFORMAZIONI SCONTO PARAMETRICO -</h3>
                    </td>
                </tr>
                <tr>
                    <td class="input">
                    <input type="hidden" name="tipologia" value="<?php echo $tipologia; ?>">
                        <label for="registrazione">MINIMO MESI DI REGISTRAZIONE:</label>
                        <input class="input" style="margin-bottom:0; width: 80px;" type="integer" id="registrazione" name="registrazione_mesi" min="1" max="12" placeholder="1" value="<?php if(isset($_SESSION['form_off_X'])) echo $_SESSION['form_off_X']; ?>" required>
                    </td>
                </tr>

                <tr>
                    <td class="input">
                        <label for="registrazione">MINIMO ANNI DI REGISTRAZIONE:</label>
                        <input class="input" style="margin-bottom:0; width: 80px;" type="integer" id="registrazione" name="registrazione_anni" min="0" max="20" placeholder="1" value="<?php if(isset($_SESSION['form_off_Y'])) echo $_SESSION['form_off_Y']; ?>" required>
                    </td>
                </tr>

                <tr>
                    <td class="input">
                        <label for="crediti_crediti_data">CREDITI SPESI DA UNA CERTA DATA:</label>
                        <input class="input" style="margin-bottom:0; width: 80px;" type="integer" id="crediti_data" name="crediti_data" placeholder="100" value="<?php if(isset($_SESSION['form_off_M'])) echo $_SESSION['form_off_M']; ?>" required>
                    </td>
                </tr>

                <tr>
                    <td class="input">
                        <label for="crediti">DATA DA CUI PARTIRE PER LO SCONTO:</label>
                        <input class="input" style="margin-bottom:0; width: 80px;" type="text" id="data" name="da_data" placeholder="1999-01-01" value="<?php if(isset($_SESSION['form_off_data_M'])) echo $_SESSION['form_off_data_M']; ?>" required pattern="\d{4}-\d{2}-\d{2}">
                    </td>
                </tr>

                <tr>
                    <td class="input">
                        <label for="crediti">MINIMO DI CREDITI SPESI IN TOTALE:</label>
                        <input class="input" style="margin-bottom:0; width: 80px;" type="integer" id="crediti" name="crediti" placeholder="100" value="<?php if(isset($_SESSION['form_off_N'])) echo $_SESSION['form_off_N']; ?>" required>
                    </td>
                </tr>

                <tr>
                    <td class="input">
                        <label for="reputazione">MINIMO DI REPUTAZIONE:</label>
                        <input class="input" style="margin-bottom:0; width: 80px;" type="integer" id="reputazione" name="reputazione" placeholder="2" value="<?php if(isset($_SESSION['form_off_R'])) echo $_SESSION['form_off_R']; ?>" required>
                    </td>
                </tr>
                <input class="input" type="hidden" name="id_prodotto" value="<?php echo $id_prodotto; ?>">
                <tr>
                    <td class="input">
                        <button class="btn" type="submit">Invia</button>
                    </td>
                </tr>
            </table>
        </form>
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
