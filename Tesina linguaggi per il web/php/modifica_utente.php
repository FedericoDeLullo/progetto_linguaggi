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

        if(isset($_SESSION['errore_query']) && $_SESSION['errore_query'] == 'true'){
            echo "<h2>Errore durante la richiesta!</h2>";
            unset($_SESSION['errore_query']);
        }

        if(isset($_SESSION['errore_email_ex']) && $_SESSION['errore_email_ex'] == 'true'){//isset verifica se errore è settata
            echo "<h2>L'email '" . $_SESSION['email_errata'] . "' è già in uso!</h2>";
            unset($_SESSION['errore_email_ex']); //la unsetto altrimenti rimarrebbe la scritta
            unset($_SESSION['mod_mail']); //pulisco il form del campo email perché è errato
        }

        if(isset($_SESSION['errore_cellulare_ex']) && $_SESSION['errore_cellulare_ex'] == 'true'){
            echo "<h2>Il numero di cellulare '" . $_SESSION['cellulare_errato'] . "' è già in uso!</h2>";
            unset($_SESSION['errore_cellulare_ex']);
            unset($_SESSION['mod_cellulare']);
        }
        
        if(isset($_SESSION['errore_codice_fiscale_ex']) && $_SESSION['errore_codice_fiscale_ex'] == 'true'){
            echo "<h2>Il codice fiscale '" . $_SESSION['codice_fiscale_errato'] . "' è già in uso!</h2>";
            unset($_SESSION['errore_codice_fiscale_ex']);
            unset($_SESSION['mod_codice_fiscale']);
        }
        
        ?>
        <h1 class="titolo">Modifica Utente</h1>
        <table>
            <tr>
                <td colspan="2">
                    <form class="form" action="processa_modifica_utente.php" method="post">
                        <input class="input" type="hidden" name="id" value="<?php echo $utente['id']; ?>">
                        <input class="input" type="hidden" id="email_vecchia" name="email_vecchia" value="<?php echo $utente['email']; ?>" required><br>

                        <label class="nome" for="nome">Nome:</label>
                        <input class="input" type="text" id="nome" name="nome" value="<?php echo $utente['nome']; ?>" required><br>
                        <label class="nome" for="nome">Cognome:</label>
                        <input class="input" type="text" id="cognome" name="cognome" value="<?php echo $utente['cognome']; ?>" required><br>
                        <label class="nome" for="email">Email:</label>
                        <input class="input" type="email" id="email" name="email" value="<?php echo $utente['email']; ?>" required><br>
                        <label class="nome" for="nome">Crediti:</label>
                        <input class="input" type="number" id="crediti" name="crediti" value="<?php echo $utente['crediti']; ?>" min="0" required><br>
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
        echo '<h2>Utente non trovato.</h2>';
    }
}
else {
    echo '<h2>ID utente non valido.</h2>';
}

$connessione->close();
?>
</div>

</body>
</html>