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
    <div class="cont">
        <?php
        // Verifica che il form sia stato inviato
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Percorso del file XML
            $xmlFile = '../xml/catalogo_prodotti.xml';

            // Verifica che tutti i campi necessari siano stati compilati
            if (isset($_POST['nome'], $_POST['descrizione'], $_POST['prezzo'], $_FILES['immagine'], $_POST['tipologia'])) {
                // Carica il file XML
                $dom = new DOMDocument();
                $dom->load($xmlFile);

                // Trova l'ultimo ID nel catalogo
                $ultimoID = 0;
                $prodottoList = $dom->getElementsByTagName('prodotto');
                foreach ($prodottoList as $prodottoNode) {
                    $idNode = $prodottoNode->getElementsByTagName('id_prodotto')->item(0);
                    $id = (int)$idNode->nodeValue;
                    if ($id > $ultimoID) {
                        $ultimoID = $id;
                    }
                }

                // Calcola il prossimo ID disponibile
                $prossimoID = $ultimoID + 1;

                // Aggiungi un nuovo prodotto con l'ID incrementato
                $prodotto = $dom->createElement('prodotto');
                $dom->documentElement->appendChild($prodotto);
                
                $id_prodotto = $dom->createElement('id_prodotto', $prossimoID);
                $prodotto->appendChild($id_prodotto);

                $nome = $dom->createElement('nome', $_POST['nome']);
                $prodotto->appendChild($nome);

                $descrizione = $dom->createElement('descrizione', $_POST['descrizione']);
                $prodotto->appendChild($descrizione);

                $prezzo = $dom->createElement('prezzo', $_POST['prezzo']);
                $prodotto->appendChild($prezzo);

                $tipologia = $dom->createElement('tipologia', $_POST['tipologia']);
                $prodotto->appendChild($tipologia);

                // Gestione dell'immagine
                $immaginePath = '../img/' . basename($_FILES['immagine']['name']);

                // Verifica che l'upload dell'immagine sia avvenuto con successo
                if (move_uploaded_file($_FILES['immagine']['tmp_name'], $immaginePath)) {
                    $immagine = $dom->createElement('immagine', $immaginePath);
                    $prodotto->appendChild($immagine);

                    // Salva le modifiche
                    $dom->save($xmlFile);

                    echo '<h1 class="titolo">Prodotto aggiunto con successo!!!</h1>';
                } else {
                    echo '<h1 class="titolo">Errore durante il caricamento dell\'immagine...</h1>';
                }
            } else {
                echo '<h1 class="titolo">Compila tutti i campi obbligatori...</h1>';
            }
        }
        ?>
    </div>
</body>
</html>