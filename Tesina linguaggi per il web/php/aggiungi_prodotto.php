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

    // Verifica che tutti i campi necessari siano stati compilati
    if (isset($_POST['nome'], $_POST['descrizione'], $_POST['prezzo'], $_FILES['immagine'], $_POST['tipologia'])) {
        // Carica il file XML
        $xml = simplexml_load_file($xmlFile);

        // Trova l'ultimo ID nel catalogo
        $ultimoID = 0;
        foreach ($xml->prodotto as $prodotto) {
            $id = (int)$prodotto->id_prodotto;
            if ($id > $ultimoID) {
                $ultimoID = $id;
            }
        }

        // Calcola il prossimo ID disponibile
        $prossimoID = $ultimoID + 1;

        // Aggiungi un nuovo prodotto con l'ID incrementato
        $prodotto = $xml->addChild('prodotto');
        $prodotto->addChild('id_prodotto', $prossimoID);
        $prodotto->addChild('nome', $_POST['nome']);
        $prodotto->addChild('descrizione', $_POST['descrizione']);
        $prodotto->addChild('prezzo', $_POST['prezzo']);
        $prodotto->addChild('tipologia', $_POST['tipologia']);  // Aggiunge la tipologia

        // Gestione dell'immagine
        $immaginePath = '../img/' . basename($_FILES['immagine']['name']);

        // Verifica che l'upload dell'immagine sia avvenuto con successo
        if (move_uploaded_file($_FILES['immagine']['tmp_name'], $immaginePath)) {
            $prodotto->addChild('immagine', $immaginePath);

            // Salva le modifiche
            $xml->asXML($xmlFile);

            echo '<p class="ok">Prodotto aggiunto con successo.</p>';
            echo '<a href="index_loggato_gestore.php" class="btn2">Torna alla Home</a>';
        } else {
            echo '<p class="errore">Errore durante il caricamento dell\'immagine.</p>';
        }
    } else {
        echo '<p class="errore">Compila tutti i campi obbligatori.</p>';
    }
}
?>
</body>
</html>
