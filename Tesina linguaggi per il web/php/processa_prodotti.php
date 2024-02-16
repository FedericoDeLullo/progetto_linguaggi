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
    if (isset($_POST['id_prodotto'], $_POST['autore'], $_POST['domanda'])) {
        $id_prodotto = $_POST['id_prodotto'];
        $autore = $_POST['autore'];
        $domanda = $_POST['domanda'];
        $tipologia = $_POST['tipologia'];
        $nome = $_POST['nome'];
        $id_utente = $_SESSION['id'];
        $id_domanda = uniqid();

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
            // Crea o trova l'elemento 'domande'
            $domandeNode = $prodottoNode->getElementsByTagName('domande')->item(0);
            if (!$domandeNode) {
                $domandeNode = $dom->createElement('domande');
                $prodottoNode->appendChild($domandeNode);
            }

            // Crea l'elemento 'domanda'
            $domandaNode = $dom->createElement('domanda');
            $domandaNode->setAttribute('id_prodotto', $id_prodotto);
            $domandaNode->setAttribute('id_utente', $id_utente);

            // Aggiungi gli elementi 'autore', 'testo' e 'data e ora' all'elemento 'domanda'
            $autoreNode = $dom->createElement('autore', $autore);
            $testoNode = $dom->createElement('testo', $domanda);
            $idDomandaNode = $dom->createElement('id_domanda', $id_domanda);

            $domandaNode->appendChild($autoreNode);
            $domandaNode->appendChild($testoNode);
            $domandaNode->appendChild($idDomandaNode);

            // Aggiungi l'elemento 'domanda' all'elemento 'domande'
            $domandeNode->appendChild($domandaNode);

            $dom->normalizeDocument();
            $dom->formatOutput = true;

            // Salva il file XML aggiornato
            $dom->save($xmlFile);

            echo 'Domanda inviata con successo.';
            $_SESSION['creazione_domanda'] = 'true';
            header("Location: ../php/domande.php?id_prodotto=$id_prodotto&nome=$nome&tipologia=$tipologia&id=$id_utente");
        } else {
            echo 'Prodotto non trovato.';
        }
    } else {
        echo 'Dati del modulo mancanti.';
    }
}
?>


</body>
</html>
