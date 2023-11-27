<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catalogo Prodotti</title>
    <link rel="stylesheet" href="../css/style_catalogo.css">
</head>
<body>
<div class="home">
                    <a href="../html/index_loggato_admin.html">
                <div class="home_link" title="home"><img src="../img/home1.png" alt="home"></div></a>
            </div>
<?php
// Leggi il file XML del catalogo
$xmlFile = '../xml/catalogo_prodotti.xml'; // Sostituisci con il percorso corretto
$dom = new DOMDocument();
$dom->load($xmlFile);

// Ottieni la lista di prodotti
$prodotti = $dom->getElementsByTagName('prodotto');

// Itera attraverso i prodotti e stampali
foreach ($prodotti as $prodotto) {
    $nome = $prodotto->getElementsByTagName('nome')->item(0)->nodeValue;
    $descrizione = $prodotto->getElementsByTagName('descrizione')->item(0)->nodeValue;
    $prezzo = $prodotto->getElementsByTagName('prezzo')->item(0)->nodeValue;
    $immagine = $prodotto->getElementsByTagName('immagine')->item(0)->nodeValue;

    // Stampa le informazioni del prodotto
    echo '<div class="prodotto">';
    echo '<h2 class="nome">' . $nome . '</h2>';
    echo '<p class="des">' . $descrizione . '</p>';
    echo '<p class="prezzo">Prezzo: ' . $prezzo . '€</p>';
    echo '<div class="box">';
    echo '<img class="img" src="' . $immagine . '" alt="' . $nome . '">';
    echo '</div>';
    echo '<a href="../php/carrello.php" class="btn">Aggiungi al carrello</a>';
    echo '</div>';
}
?>

</body>
</html>
