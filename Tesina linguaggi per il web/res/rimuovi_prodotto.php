<?php
session_start();
// Verifica che il form sia stato inviato
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Percorso del file XML
    $xmlFile = '../xml/catalogo_prodotti.xml';

    // Carica il file XML
    $dom = new DOMDocument();
    $dom->load($xmlFile);

    $prodottoTrovato = false;

    // Cerca e rimuovi il prodotto
    $xpath = new DOMXPath($dom);
    $prodottoNodes = $xpath->query("/catalogo_prodotti/prodotto[nome='{$_POST['nome']}']");
    foreach ($prodottoNodes as $prodottoNode) {
        $prodottoNode->parentNode->removeChild($prodottoNode);
        $prodottoTrovato = true;
        break; // Interrompi dopo aver trovato e rimosso il primo prodotto con lo stesso nome
    }

    // Salva le modifiche solo se il prodotto è stato trovato
    if ($prodottoTrovato) {
        $dom->save($xmlFile);
        $_SESSION['successo_rimozione_prodotto'] = 'true';
        header("Location: ../php/menu_rimuovi_prodotto.php");
    } else {
        $_SESSION['fallimento_rimozione_prodotto'] = 'true';
        header("Location: ../php/menu_rimuovi_prodotto.php");
    }
}
?>