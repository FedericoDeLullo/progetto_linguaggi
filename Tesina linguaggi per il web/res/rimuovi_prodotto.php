<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Percorso del file XML
    $xmlFile = '../xml/catalogo_prodotti.xml';

    // Carica il file XML
    $dom = new DOMDocument();
    $dom->preserveWhiteSpace = false;

    $dom->load($xmlFile);

    $prodottoTrovato = false;

    $xpath = new DOMXPath($dom);
    $prodottoNodes = $xpath->query("/catalogo_prodotti/prodotto[nome='{$_POST['nome']}']");
    foreach ($prodottoNodes as $prodottoNode) {
        $prodottoNode->parentNode->removeChild($prodottoNode);
        $prodottoTrovato = true;
        break; 
    }

    if ($prodottoTrovato) {
        $dom->normalizeDocument();
                $dom->formatOutput = true;
        $dom->save($xmlFile);
        $_SESSION['successo_rimozione_prodotto'] = 'true';
        header("Location: ../php/menu_rimuovi_prodotto.php");
    } else {
        $_SESSION['fallimento_rimozione_prodotto'] = 'true';
        header("Location: ../php/menu_rimuovi_prodotto.php");
    }
}
?>