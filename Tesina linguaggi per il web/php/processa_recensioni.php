<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fai una Domanda</title>   
     <link rel="stylesheet" href="../css/style_standard.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="../css/style_header.css">
    <?php
        include('../res/header.php');
    ?>
</head>
<body>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Verifica se sono stati inviati dati del modulo
        if (isset($_POST['id_prodotto'], $_POST['autore'], $_POST['recensione'])) {
            $id_prodotto = $_POST['id_prodotto'];
            $autore = $_POST['autore'];
            $recensione = $_POST['recensione'];
            $data = $_POST['data_recensione'];
            $ora = $_POST['orario_recensione'];
            $nome = $_POST['nome'];
            $tipologia = $_POST['tipologia'];
            $id_recensione = uniqid();
            $id_utente = $_SESSION['id'];
          

            // Carica il file XML del catalogo
            $xmlFile = '../xml/catalogo_prodotti.xml';
            $dom = new DOMDocument();
            $dom->preserveWhiteSpace = false;
            $dom->load($xmlFile);


            // Trova il prodotto nel file XML
            $xpath = new DOMXPath($dom);
            $prodottoNode = $xpath->query("//prodotto[id_prodotto=$id_prodotto]")->item(0);

            // Verifica se il nodo del prodotto esiste prima di procedere
            if ($prodottoNode) {
                // Crea o trova l'elemento 'recensioni'
                $recensioniNode = $prodottoNode->getElementsByTagName('recensioni')->item(0);
                if (!$recensioniNode) {
                    $recensioniNode = $dom->createElement('recensioni');
                    $prodottoNode->appendChild($recensioniNode);
                }

                // Crea l'elemento 'recensione'
                $recensioneNode = $dom->createElement('recensione');
                $recensioneNode->setAttribute('id_prodotto', $id_prodotto);
                $recensioneNode->setAttribute('id_utente', $id_utente);


                // Aggiungi gli elementi 'autore', 'testo' e 'data e ora' all'elemento 'recensione'
                $autoreNode = $dom->createElement('autore', $autore);
                $testoNode = $dom->createElement('testo', $recensione);
                $dataNode = $dom->createElement('data', $data);
                $oraNode = $dom->createElement('ora', $ora);
                $idRecensioneNode = $dom->createElement('id_recensione', $id_recensione);           
          
            
                $recensioneNode->appendChild($autoreNode);
                $recensioneNode->appendChild($testoNode);
                $recensioneNode->appendChild($dataNode);
                $recensioneNode->appendChild($oraNode);
                $recensioneNode->appendChild($idRecensioneNode);
               

                // Aggiungi l'elemento 'recensione' all'elemento 'recensioni'
                $recensioniNode->appendChild($recensioneNode);

                $dom->normalizeDocument();
                $dom->formatOutput = true;

                // Salva il file XML aggiornato
                $dom->save($xmlFile);

                echo 'Recensione salvata con successo.';
                $_SESSION['creazione_recensione'] = 'true';
                header("Location: ../php/lista_recensioni.php?id_prodotto=$id_prodotto&tipologia=$tipologia&nome=$nome&id=$id_utente");            }
            else {
                echo 'Prodotto non trovato.';
            }
        } else {
            echo 'Dati del modulo mancanti.';
        }
    }
?>

</body>
</html>
