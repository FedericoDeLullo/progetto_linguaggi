<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestione Catalogo</title>
    <link rel="stylesheet" href="../css/style_aggiungi.css">

</head>
<body>
    
</body>
</html><?php
// Verifica che il form sia stato inviato
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Percorso del file XML
    $xmlFile = '../xml/catalogo_prodotti.xml';

    // Carica il file XML
    $xml = simplexml_load_file($xmlFile);

    // Cerca e rimuovi il prodotto
    foreach ($xml->prodotto as $prodotto) {
        if ((string)$prodotto->nome == $_POST['nome']) {
            unset($prodotto[0]);
            break;
        }
    }

    // Salva le modifiche
    $xml->asXML($xmlFile);

    echo '<p class="ok">Prodotto rimosso con successo.';?>
    <a href="../html/index_loggato_admin.html" class="btn2">Torna alla Home</a> <?php
}
?>
