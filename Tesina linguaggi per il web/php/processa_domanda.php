<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['faq_question'])) {
        $faq_question = htmlspecialchars($_POST['faq_question']);

        $xmlFile = '../xml/faq.xml';

        if (file_exists($xmlFile)) {
            // Carica il file XML
            $dom = new DOMDocument();
            $dom->preserveWhiteSpace = false;

            $dom->load($xmlFile);

            $faq_id = uniqid();

            $newFaq = $dom->createElement('entry');
            $newFaq->setAttribute('id', $faq_id);

            $questionNode = $dom->createElement('question', $faq_question);
            $newFaq->appendChild($questionNode);

            // Aggiungi la nuova FAQ al documento XML
            $dom->documentElement->appendChild($newFaq);
            $dom->normalizeDocument();
            $dom->formatOutput = true; 
            // Salva le modifiche nel file XML
            $dom->save($xmlFile);

            header('Location: faq.php');
            exit();
        } else {
            echo "Errore: Il file XML delle FAQ non esiste.";
        }
    } else {
        echo "Errore: Dati mancanti nella richiesta.";
    }
}
?>