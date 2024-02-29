<?php
require_once("../res/connection.php");

// Controlla se la variabile di sessione 'acquisti' è definita e non è vuota
if (isset($_SESSION['acquisti']) && !empty($_SESSION['acquisti'])) {
    // Includi il tuo file XML
    $xmlFile = "../xml/catalogo_prodotti.xml";
    $doc = new DomDocument();
    $doc->load($xmlFile);

    echo '<div class="cart">';
    echo '<h2 class="tito">ULTIMI ACQUISTI</h2>';
    echo '<div>';
    echo '<ul class="elenco_articoli">';

    // Ciclo attraverso gli acquisti nella variabile di sessione
    foreach ($_SESSION['acquisti'] as $acquisto) {
        $id_prodotto = $acquisto['id_prodotto'];
        $quantita = $acquisto['quantita'];
    
        // Cerca il prodotto nel tuo catalogo usando l'id_prodotto
        $xpath = new DOMXPath($doc);
        $query = "//prodotto[id_prodotto='$id_prodotto']";
        $result = $xpath->query($query);
    
        // Verifica se il prodotto è stato trovato
        if ($result->length > 0) {
            $prodotto = $result->item(0);
    
            $nome = $prodotto->getElementsByTagName('nome')->item(0)->nodeValue;
            $prezzo = (int)$prodotto->getElementsByTagName('prezzo')->item(0)->nodeValue;
    
            // Mostra il prodotto con quantità, nome e prezzo
            echo '<li>Quantità: ' . $quantita . ', Nome: ' . $nome . ', Prezzo: ' . $prezzo . ' &euro;</li>';
        } else {
            // Output di debug nel caso in cui il prodotto non sia stato trovato
            echo '<li>Prodotto non trovato con ID: ' . $id_prodotto . '</li>';
        }
    }

    echo '</ul>';
    echo '</div>';
    echo '<div>';
    echo '<a href="../HTML/index1.html"><button class="home_acq">Torna alla Homepage</button></a>';
    echo '</div>';
    echo '</div>';
} else {
    // Nessun acquisto disponibile
    echo '<p>Nessun acquisto effettuato.</p>';
}

?>
