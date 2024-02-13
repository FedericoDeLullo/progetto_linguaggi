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

            // Load the XML file
            $xmlFile = '../xml/catalogo_prodotti.xml';
            $dom = new DOMDocument();
            $dom->load($xmlFile);

            if (isset($_GET['id_domanda']) && !isset($_GET['id_risposta'])) {
                // Specify the id_domanda you want to delete
                $id_domanda = $_GET['id_domanda'];
                $id_prodotto = $_GET['id_prodotto'];
                $nome = $_GET['nome'];
                $tipologia = $_GET['tipologia'];

                // Use XPath to find the node to delete
                $xpath = new DOMXPath($dom);
                $query = "//domanda[id_domanda='{$id_domanda}']";
                $domandaNodes = $xpath->query($query);

                // Check if the node was found
                if ($domandaNodes->length > 0) {
                    // Remove the found node
                    $domandaNode = $domandaNodes->item(0);
                    $domandaNode->parentNode->removeChild($domandaNode);

                    // Save the changes back to the XML file
                    $dom->save($xmlFile);
                    header("Location: domande.php?id_prodotto=" . $id_prodotto . "&nome=" . urlencode($nome) . "&tipologia=" . urlencode($tipologia));
                }
            } elseif (isset($_GET['id_risposta'])) {
                $id_domanda = $_GET['id_domanda'];
                $id_risposta = $_GET['id_risposta'];
                $id_prodotto = $_GET['id_prodotto'];
                $nome = $_GET['nome'];
                $tipologia = $_GET['tipologia'];

                $questionXPath = "//domanda[./risposte/risposta[id_risposta='{$id_risposta}']]";
                $xpath = new DOMXPath($dom);
                $questionNodeList = $xpath->query($questionXPath);

                if ($questionNodeList->length > 0) {
                    $answersXPath = "./risposte/risposta[id_risposta='{$id_risposta}']";
                    $answerNodeList = $xpath->query($answersXPath, $questionNodeList->item(0));

                    if ($answerNodeList->length > 0) {
                        $answerNode = $answerNodeList->item(0);
                        $answerNode->parentNode->removeChild($answerNode);

                        $dom->save('../xml/catalogo_prodotti.xml');
                        header("Location: domande.php?id_prodotto=" . $id_prodotto . "&nome=" . urlencode($nome) . "&tipologia=" . urlencode($tipologia));
                    } else {
                        echo "Answer with id_risposta '{$id_risposta}' not found within the specified question.";
                    }
                } else {
                    echo "Question containing the answer with id_risposta '{$id_risposta}' not found.";
                }
            }
        }
        ?>
    </div>
</body>
</html>