<?php
$xmlFile = '../xml/catalogo_prodotti.xml';

// Carica il file XML
$dom = new DOMDocument();
$dom->load($xmlFile);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['vota'])) {
    $id_recensione = $_POST['id_recensione'];
    $votoUtilita = $_POST['votoUtilita'];
    $votoSupporto = $_POST['votoSupporto'];
    $id_prodotto = $_POST['id_prodotto'];
    $tipologia = $_POST['tipologia'];

    // Trova la recensione con l'id_recensione specificato
    $xpath = new DOMXPath($dom);
    $recensioneNode = $xpath->query("//recensione[id_recensione='$id_recensione']")->item(0);

    // Verifica se la recensione esiste prima di procedere
    if ($recensioneNode) {
        // Crea un nuovo nodo "utilita" per l'utente corrente
        $id_utente = $_SESSION['id']; // Assumi che l'id utente sia memorizzato in una sessione
        $newUtilitaNode = $dom->createElement('utilita');
        $newUtilitaNode->setAttribute('id_utente', $id_utente);
        $newUtilitaNode->appendChild($dom->createElement('valore', $votoUtilita));

        // Crea un nuovo nodo "supporto" per l'utente corrente
        $newSupportoNode = $dom->createElement('supporto');
        $newSupportoNode->setAttribute('id_utente', $id_utente);
        $newSupportoNode->appendChild($dom->createElement('valore', $votoSupporto));

        // Aggiungi i nuovi nodi "utilita" e "supporto" alla recensione
        $recensioneNode->appendChild($newUtilitaNode);
        $recensioneNode->appendChild($newSupportoNode);

        // Salva il documento XML aggiornato
        $dom->save($xmlFile);

        // Reindirizza alla pagina delle recensioni
        header("Location: lista_recensioni.php?id_prodotto=" . $id_prodotto . "&nome=" . $nome . "&tipologia=" . $tipologia);
    }
}
?>