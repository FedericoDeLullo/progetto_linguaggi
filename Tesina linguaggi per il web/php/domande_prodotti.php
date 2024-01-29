<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fai una Domanda</title>
    <link rel="stylesheet" href="../css/style_catalogo.css"> <!-- Sostituisci con il percorso corretto al tuo file CSS -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
</head>
<body>

<?php
require_once('../res/connection.php');
session_start();

// Verifica se è stato fornito un ID del prodotto nella query string
if (isset($_GET['id_prodotto'])) {
    $id_prodotto = $_GET['id_prodotto'];
    $nome_prodotto = $_GET['nome'];
    $email_utente = $_SESSION['email'];
    $tipologia = $_GET['tipologia'];
    $id_utente = $_GET['id'];
    ?>
    <div class="home">
        <a href="catalogo_utente_<?php echo $tipologia; ?>.php">
            <span id="casa" class="material-symbols-outlined">home</span>
        </a>
    </div>

    <form class="dom" method="post" action="domande_prodotti.php">
        <input type="hidden" name="id_prodotto" value="<?php echo $id_prodotto; ?>">
        <input type="hidden" name="tipologia" value="<?php echo $tipologia; ?>">
        <input type="hidden" name="autore" value="<?php echo $email_utente; ?>">
        <div class="que">
            <label for="domanda">Fai una domanda su: <?php echo $nome_prodotto; ?>:</label>
        </div>
        <textarea class="text" name="domanda" rows="4" cols="50" required></textarea>
        <div class="send">
            <input class="button" type="submit" value="Invia Domanda">
        </div>
    </form>

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
