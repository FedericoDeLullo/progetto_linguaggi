<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rimuovi Prodotto</title>
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

    // Carica il file XML
    $xml = simplexml_load_file($xmlFile);

    // Cerca e rimuovi il prodotto
    foreach ($xml->prodotto as $prodotto) {
        if ((string)$prodotto->nome == $_POST['nome']) {
            unset($prodotto[0]);
            echo '<h1 class="titolo">Prodotto rimosso con successo!!!</h1>';
            break;
        }
        else{
            echo '<h1 class="titolo">Prodotto inesistente, controlla che il nome del prodotto inserito sia nel catalogo...</h1>';
        }
    }

    // Salva le modifiche
    $xml->asXML($xmlFile);
}
?>
</div>
</body>
</html>