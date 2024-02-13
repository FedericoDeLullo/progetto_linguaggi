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
    <div class="cont">
        <?php
        if ($_SERVER["REQUEST_METHOD"] === "GET") {
            // Percorso del file XML
            $xmlFile = '../xml/catalogo_prodotti.xml';

            // Carica il file XML
            $dom = new DOMDocument();
            $dom->load($xmlFile);

            if (isset($_GET['id_recensione'])) {
                // Specifica l'id_recensione che si desidera eliminare
                $id_recensione = $_GET['id_recensione'];
                $id_prodotto = $_GET['id_prodotto'];
                $nome = $_GET['nome'];
                $tipologia = $_GET['tipologia'];

                // Utilizza XPath per trovare il nodo da eliminare
                $xpath = new DOMXPath($dom);
                $query = "//recensione[id_recensione='{$id_recensione}']";
                $recensioneNodes = $xpath->query($query);

                // Verifica se il nodo è stato trovato
                if ($recensioneNodes->length > 0) {
                    // Rimuovi il nodo trovato
                    $recensioneNode = $recensioneNodes->item(0);
                    $recensioneNode->parentNode->removeChild($recensioneNode);

                    // Salva le modifiche nel file XML
                    $dom->save($xmlFile);

                    // Reindirizza alla pagina delle recensioni aggiornata
                    header("Location: lista_recensioni.php?id_prodotto=" . $id_prodotto . "&nome=" . urlencode($nome) . "&tipologia=" . urlencode($tipologia));
                }
            }
        }
        ?>
    </div>
</body>
</html>