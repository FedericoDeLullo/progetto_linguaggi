<?php

if (isset($_GET['id_prodotto'])) {
    $id_prodotto = $_GET['id_prodotto'];
$tipologia = $_GET['tipologia'];

    $xmlFile = '../xml/catalogo_prodotti.xml';
    $dom = new DOMDocument();
    $dom->load($xmlFile);

    $xpath = new DOMXPath($dom);
    $query = "//prodotto[id_prodotto='$id_prodotto']";
    $prodottoNodeList = $xpath->query($query);

    if ($prodottoNodeList->length > 0) {
        $prodottoNode = $prodottoNodeList->item(0);

        $nome = $prodottoNode->getElementsByTagName('nome')->item(0)->nodeValue;
        $descrizione = $prodottoNode->getElementsByTagName('descrizione')->item(0)->nodeValue;
        $prezzo = $prodottoNode->getElementsByTagName('prezzo')->item(0)->nodeValue;
        $immagine = $prodottoNode->getElementsByTagName('immagine')->item(0)->nodeValue;

?>
<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Catalogo Prodotti</title>
        <link rel="stylesheet" href="../css/style_standard.css">
        <link rel="stylesheet" href="../css/style_catalogo.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
        <link rel="stylesheet" href="../css/style_header.css">
        <?php
        include('../res/header.php');
        ?>
    </head>
    <body>
<?php
require_once('../res/connection.php');
if (!isset($_SESSION['id'])) {
    header("Location: login_cliente.php");
    exit();
}

$id_utente = $_SESSION['id'];
$sql_select = "SELECT gestore FROM utenti WHERE id = '$id_utente' AND gestore = 1";

if ($result = $connessione->query($sql_select)) {
    if ($result->num_rows === 1) {
        
            if(isset($_SESSION['errore_nome_esistente']) && $_SESSION['errore_nome_esistente'] == 'true'){
            echo '<h2>Nome prodotto già esistente...</h2>';
            unset($_SESSION['errore_nome_esistente']);
            }
            if(isset($_SESSION['errore_immagine']) && $_SESSION['errore_immagine'] == 'true'){
                echo '<h2>Tipo file non supportato!!!</h2>';
                unset($_SESSION['errore_immagine']);
            }
            $_SESSION['nome_prodotto_attuale'] = $nome;
        ?>
                <div class="cont">

            <h1 class="titolo" >Modifica Prodotto</h1>
            
            <form class="form" action="modifica_prodotti.php" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="id_prodotto" value="<?php echo $id_prodotto; ?>">
                <table class="table">
                    <tr>
                        <td>
                            <label for="nome">Nome:</label></td>
                        <td>
                        <input type="hidden"  name="tipologia" value="<?php echo $tipologia; ?>" >

                            <input class="input" type="text" name="nome" value="<?php echo $nome; ?>" required></td>
                    </tr>
                    <tr>
                        <td><label for="descrizione">Descrizione:</label></td>
                        <td><textarea style="width:250px; height:100px; resize:none;" class="input" name="descrizione" required><?php echo $descrizione; ?></textarea></td>
                    </tr>
                    <tr>
                        <td><label for="prezzo">Prezzo:</label></td>
                        <td><input class="input" type="number" name="prezzo" value="<?php echo $prezzo; ?>" min="1" required></td>
                    </tr>
                    <tr>
                    <td><label for="immagine">Immagine:</label></td>
                        <td><input type="file" class="input" name="immagine" accept="image/*" ></td>
                        <input type="hidden" name="immagine_esistente" value="<?php echo $immagine; ?>">

                </tr>
                </table>
                <button class="btn" style="margin-left:40vw;" type="submit">Salva Modifiche</button>
            </form>
            </div>
        </body>
        </html>
        <?php
            } else {
                echo "Prodotto non trovato.";
            }
        } else {
            echo "ID del prodotto non fornito.";
        }
    } else {
        header("Location: accesso_negato.php");
        exit();
    }
} else {
echo "Errore nella query: " . $connessione->error;
}
?>