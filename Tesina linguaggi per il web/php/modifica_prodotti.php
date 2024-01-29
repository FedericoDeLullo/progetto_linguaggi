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

    // Identifica il prodotto da modificare (puoi sostituire questo passaggio con la tua logica specifica)
    $prodottoDaModificare = null;
    foreach ($xml->prodotto as $prodotto) {
        $id = (int)$prodotto->id_prodotto;
        if ($id == $_POST['id_prodotto']) {
            $prodottoDaModificare = $prodotto;
            break;
        }
    }

    // Verifica se il prodotto è stato trovato
    if ($prodottoDaModificare) {
        // Modifica le caratteristiche del prodotto
        $prodottoDaModificare->nome = $_POST['nome'];
        $prodottoDaModificare->descrizione = $_POST['descrizione'];
        $prodottoDaModificare->prezzo = $_POST['prezzo'];

        // Gestione dell'immagine solo se è stato caricato un nuovo file
        if (!empty($_FILES['immagine']['name'])) {
            $immaginePath = '../img/' . basename($_FILES['immagine']['name']);
            move_uploaded_file($_FILES['immagine']['tmp_name'], $immaginePath);
            $prodottoDaModificare->immagine = $immaginePath;
        }

        // Salva le modifiche
        $xml->asXML($xmlFile);

        echo '<p class="ok">Prodotto modificato con successo.';
        ?>
        <a href="index_gestore.php" class="btn2">Torna alla Home</a>
        <?php
    } else {
        echo '<p class="error">Prodotto non trovato.';
    }
}
?>
</body>
</html>
