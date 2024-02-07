<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestione Catalogo</title>
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
            } else {
                // Se non è stato fornito un nuovo file, utilizza l'immagine esistente
                $prodottoDaModificare->immagine = $_POST['immagine_esistente'];
            }

            // Salva le modifiche
            $xml->asXML($xmlFile);
            header("Location: catalogo_magliette.php");
            exit(); // Aggiunto per terminare l'esecuzione dopo la redirect
        } else {
            echo '<p class="error">Prodotto non trovato.</p>';
        }
    }
    ?>
</body>

</html>
