<?php

if (isset($_GET['id_prodotto'])) {
    // Recupera l'id del prodotto dalla query string
    $id_prodotto = $_GET['id_prodotto'];

    // Puoi ora utilizzare $id_prodotto per recuperare le informazioni del prodotto dal tuo file XML

    // Esempio: leggi il file XML
    $xmlFile = '../xml/catalogo_prodotti.xml';
    $dom = new DOMDocument();
    $dom->load($xmlFile);

    // Trova il nodo del prodotto con l'id corrispondente
    $xpath = new DOMXPath($dom);
    $query = "//prodotto[id_prodotto='$id_prodotto']";
    $prodottoNodeList = $xpath->query($query);

    // Se esiste un prodotto con l'id corrispondente
    if ($prodottoNodeList->length > 0) {
        $prodottoNode = $prodottoNodeList->item(0);

        // Recupera le informazioni del prodotto
        $nome = $prodottoNode->getElementsByTagName('nome')->item(0)->nodeValue;
        $descrizione = $prodottoNode->getElementsByTagName('descrizione')->item(0)->nodeValue;
        $prezzo = $prodottoNode->getElementsByTagName('prezzo')->item(0)->nodeValue;
        $immagine = $prodottoNode->getElementsByTagName('immagine')->item(0)->nodeValue;

        // Ora puoi utilizzare queste informazioni per popolare un modulo di modifica
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
    <body><?php
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
        // Prodotto non trovato con l'id specificato
        echo "Prodotto non trovato.";
    }
} else {
    // Id non fornito nella query string
    echo "ID del prodotto non fornito.";
}
?>