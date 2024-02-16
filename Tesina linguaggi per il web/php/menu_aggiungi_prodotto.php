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
                        <label class="nome" for="nome">Nome Prodotto:</label>
                        <input class="input" type="text" name="nome" required><br>
                        <label class="nome" for="descrizione">Descrizione Prodotto:</label>
                        <input class="input" name="descrizione" required><br>
                        <label class="nome" for="prezzo">Prezzo Prodotto:</label>
                        <input class="input" type="number" name="prezzo" step="0.01" min="0" required><br>
                        <label class="nome" for="immagine">Immagine Prodotto:</label>
                        <input class="input" type="file" name="immagine" accept="image/*" required><br>
                        <label class="nome" for="tipologia">Tipologia Prodotto</label>
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
</body>
</html>
