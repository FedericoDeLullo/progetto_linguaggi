<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Verifica se 'faq_question' è impostato
    if (isset($_POST['faq_question'])) {
        $faq_question = htmlspecialchars($_POST['faq_question']);

        $xmlFile = '../xml/faq.xml';

        if (file_exists($xmlFile)) {
            $xml = simplexml_load_file($xmlFile);

            // Genera un ID univoco per la FAQ
            $faq_id = uniqid();

            // Aggiungi la nuova FAQ come un nuovo elemento <entry>
            $newFaq = $xml->addChild('entry');
            $newFaq->addAttribute('id', $faq_id);

            // Aggiungi la domanda alla FAQ
            $newFaq->addChild('question', $faq_question);

            // Salva le modifiche nel file XML
            $xml->asXML($xmlFile);

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
