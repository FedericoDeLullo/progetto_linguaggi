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
    <title>Modifica Prodotto</title>
    <link rel="stylesheet" href="../css/style_gestione_utenti.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />

</head>
<body>
    <h1 class="mod" >Modifica Prodotto</h1>
    <form action="modifica_prodotti.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id_prodotto" value="<?php echo $id_prodotto; ?>">
        <table>
            <tr>
                <td class="immagine"><label for="nome">Nome:</label></td>
                <td><input class="nome" type="text" name="nome" value="<?php echo $nome; ?>" required></td>
            </tr>
            <tr>
                <td class="n"><label for="descrizione">Descrizione:</label></td>
                <td><textarea class="immagine1" name="descrizione" required><?php echo $descrizione; ?></textarea></td>
            </tr>
            <tr>
                <td class="immagine"><label for="prezzo">Prezzo:</label></td>
                <td><input class="nome" type="text" name="prezzo" value="<?php echo $prezzo; ?>" required></td>
            </tr>
            <tr>
               <td class="immagine"><label for="immagine">Immagine:</label></td>
                <td><input type="file" name="immagine" accept="image/*" required></td>
           </tr>
        </table>
        <button  type="submit"><span id="save" class="material-symbols-outlined">
save
</span></button>
    </form>
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
