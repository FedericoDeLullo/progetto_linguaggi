<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestione Catalogo</title>
    <link rel="stylesheet" href="../css/style_aggiungi.css">

</head>
<body>
<?php
// Verifica che il form sia stato inviato
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Percorso del file XML
    $xmlFile = '../xml/catalogo_prodotti.xml';

    // Carica il file XML
    $xml = simplexml_load_file($xmlFile);

    // Aggiungi un nuovo prodotto
    $prodotto = $xml->addChild('prodotto');
    $prodotto->addChild('nome', $_POST['nome']);
    $prodotto->addChild('descrizione', $_POST['descrizione']);
    $prodotto->addChild('prezzo', $_POST['prezzo']);

    // Gestione dell'immagine
    $immaginePath = '../img/' . basename($_FILES['immagine']['name']);
    move_uploaded_file($_FILES['immagine']['tmp_name'], $immaginePath);
    $prodotto->addChild('immagine', $immaginePath);

    // Salva le modifiche
    $xml->asXML($xmlFile);

    echo '<p class="ok">Prodotto aggiunto con successo.';?>
    <a href="../html/index_loggato_admin.html" class="btn2">Torna alla Home</a> <?php
}
?>
</body>
</html>
