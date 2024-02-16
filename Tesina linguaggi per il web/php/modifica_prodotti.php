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
    <div class="cont">
        <?php

        // Verifica che il form sia stato inviato
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $id_prodotto = $_POST['id_prodotto'];
            // Percorso del file XML
            $xmlFile = '../xml/catalogo_prodotti.xml';

            // Carica il file XML
            $dom = new DOMDocument();
            $dom->load($xmlFile);

            // Identifica il prodotto da modificare
            $prodottoDaModificare = null;
            foreach ($dom->getElementsByTagName('prodotto') as $prodotto) {
                $nomeNode = $prodotto->getElementsByTagName('nome')->item(0);
                $nomeEsistente = $nomeNode->nodeValue;
        
                // Verifica se il nome è già presente
                if ($_POST['nome'] == $nomeEsistente) {
                    $_SESSION['errore_nome_esistente'] = 'true';
                    header("Location: ../php/modifica_prodotti_form.php?id_prodotto=$id_prodotto");
                    exit(); // Esce dal ciclo se il nome è già presente
                }else{
                $id = (int)$prodotto->getElementsByTagName('id_prodotto')->item(0)->nodeValue;
                if ($id == $_POST['id_prodotto']) {
                    $prodottoDaModificare = $prodotto;
                    break;
                  } 
                 }
            }

            // Verifica se il prodotto è stato trovato
            if ($prodottoDaModificare) {
                // Modifica le caratteristiche del prodotto
                $prodottoDaModificare->getElementsByTagName('nome')->item(0)->nodeValue = $_POST['nome'];
                $prodottoDaModificare->getElementsByTagName('descrizione')->item(0)->nodeValue = $_POST['descrizione'];
                $prodottoDaModificare->getElementsByTagName('prezzo')->item(0)->nodeValue = $_POST['prezzo'];

                // Gestione dell'immagine solo se è stato caricato un nuovo file
                if (!empty($_FILES['immagine']['name'])) {
                    $immaginePath = '../img/' . basename($_FILES['immagine']['name']);
                    move_uploaded_file($_FILES['immagine']['tmp_name'], $immaginePath);

                    // Rimuovi l'immagine esistente (se presente)
                    $immagineNode = $prodottoDaModificare->getElementsByTagName('immagine')->item(0);
                    if ($immagineNode) {
                        $prodottoDaModificare->removeChild($immagineNode);
                    }

                    // Aggiungi l'immagine nuova
                    $newImmagineNode = $dom->createElement('immagine', $immaginePath);
                    $prodottoDaModificare->appendChild($newImmagineNode);
                }

                // Salva le modifiche
                $dom->save($xmlFile);
                header("Location: catalogo_magliette.php");
                exit(); // Termina l'esecuzione dopo la redirect
            } else {
                echo '<p class="error">Prodotto non trovato.</p>';
            }
        }

        ?>
    </div>
</body>
</html>