<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Verifica se 'domanda' e 'risposta' sono impostati
    if (isset($_POST['domanda']) && isset($_POST['risposta'])) {
        $faq_question = htmlspecialchars($_POST['domanda']);
        $faq_answer = htmlspecialchars($_POST['risposta']);

        $xmlFile = '../xml/faq.xml';

        // Verifica se il file XML esiste
        if (file_exists($xmlFile)) {
            $xml = simplexml_load_file($xmlFile);

            // Genera un ID univoco per la FAQ
            $faq_id = uniqid();

            // Aggiungi la nuova FAQ come un nuovo elemento <entry>
            $newFaq = $xml->addChild('entry');
            $newFaq->addAttribute('id', $faq_id);

            // Aggiungi la domanda alla FAQ
            $newFaq->addChild('question', $faq_question);

            // Crea l'elemento <answers> se non esiste
            if (!isset($newFaq->answers)) {
                $answers = $newFaq->addChild('answers');
            } else {
                $answers = $newFaq->answers;
            }

            // Aggiungi la risposta alla FAQ
            $newAnswer = $answers->addChild('answer', $faq_answer);
            $newAnswer->addAttribute('id', uniqid());

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
