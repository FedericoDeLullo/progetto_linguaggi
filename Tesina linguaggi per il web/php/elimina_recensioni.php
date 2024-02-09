<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recensioni Prodotti</title>
    <link rel="stylesheet" href="../css/style_standard.css">
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



if ($_SERVER["REQUEST_METHOD"] === "GET") {


// Load the XML file
$xmlFile = '../xml/catalogo_prodotti.xml';
$xml = simplexml_load_file($xmlFile);

if(isset($_GET['id_recensione'])){
// Specify the id_domanda you want to delete
$id_recensione = $_GET['id_recensione'];
$id_prodotto = $_GET['id_prodotto'];
$nome = $_GET['nome'];
$tipologia = $_GET['tipologia'];

$recensione = $xml->xpath("//recensione[id_recensione='{$id_recensione}']");

// Check if the node was found
if (!empty($recensione)) {
    // Remove the found node
    unset($recensione[0][0]);

    // Save the changes back to the XML file
    $xml->asXML($xmlFile);
    header("Location: lista_recensioni.php?id_prodotto=" . $id_prodotto . "&nome=" . urlencode($nome) . "&tipologia=" . urlencode($tipologia));
}
} 
}
?>

</body>
</html>


