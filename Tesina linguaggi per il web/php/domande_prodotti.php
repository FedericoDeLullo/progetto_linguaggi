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
require_once('../res/connection.php');
 

// Verifica se è stato fornito un ID del prodotto nella query string
if (isset($_GET['id_prodotto'])) {
    $id_prodotto = $_GET['id_prodotto'];
    $nome_prodotto = $_GET['nome'];
    $email_utente = $_SESSION['email'];
    $tipologia = $_GET['tipologia'];
    $id_utente = $_GET['id'];
    ?>
   
   <h1 class="titolo">Fai una domanda per <?php echo $nome_prodotto; ?>:</h1>

   <table>
        <tr>
            <td colspan="2">
    <form class="form" method="post" action="domande.php">
        <input type="hidden" name="id_prodotto" value="<?php echo $id_prodotto; ?>">
        <input type="hidden" name="tipologia" value="<?php echo $tipologia; ?>">
        <input type="hidden" name="autore" value="<?php echo $email_utente; ?>">
        <textarea class="input" name="domanda" rows="4" cols="50" required></textarea>
            <input class="btn" type="submit" value="Invia Domanda">
    </form>
    </td>
        </tr>
    </table>
<?php
} else {
    echo 'ID del prodotto mancante.';
}
?>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifica se sono stati inviati dati del modulo
    if (isset($_POST['id_prodotto'], $_POST['autore'], $_POST['domanda'])) {
        $id_prodotto = $_POST['id_prodotto'];
        $autore = $_POST['autore'];
        $domanda = $_POST['domanda'];
        $tipologia = $_POST['tipologia'];
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
            header("Location: domanda_ok.php?tipologia=" . $tipologia);
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
