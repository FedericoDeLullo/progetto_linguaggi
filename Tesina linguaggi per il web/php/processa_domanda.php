<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Verifica se 'faq_question' è impostato
    if (isset($_POST['faq_question'])) {
        $faq_question = htmlspecialchars($_POST['faq_question']);

        $xmlFile = '../xml/faq.xml';

        if (file_exists($xmlFile)) {
            // Carica il file XML
            $dom = new DOMDocument();
            $dom->load($xmlFile);

            // Genera un ID univoco per la FAQ
            $faq_id = uniqid();

            // Crea l'elemento <entry> per la nuova FAQ
            $newFaq = $dom->createElement('entry');
            $newFaq->setAttribute('id', $faq_id);

            // Crea l'elemento <question> e aggiungi il testo
            $questionNode = $dom->createElement('question', $faq_question);
            $newFaq->appendChild($questionNode);

            // Aggiungi la nuova FAQ al documento XML
            $dom->documentElement->appendChild($newFaq);

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