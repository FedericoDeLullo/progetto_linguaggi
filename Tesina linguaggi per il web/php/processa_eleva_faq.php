<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Verifica se 'domanda' e 'risposta' sono impostati
    if (isset($_POST['domanda']) && isset($_POST['risposta'])) {
        $faq_question = htmlspecialchars($_POST['domanda']);
        $faq_answer = htmlspecialchars($_POST['risposta']);

        $xmlFile = '../xml/faq.xml';

        // Verifica se il file XML esiste
        if (file_exists($xmlFile)) {
            $dom = new DOMDocument();
            $dom->preserveWhiteSpace = false;

            $dom->load($xmlFile);

            $entry = $dom->createElement('entry');
            $entry->setAttribute('id', uniqid());

            $question = $dom->createElement('question', $faq_question);
            $entry->appendChild($question);

            $answers = $dom->createElement('answers');
            $answer = $dom->createElement('answer', $faq_answer);
            $answers->setAttribute('id', uniqid());
            $answers->appendChild($answer);
            $entry->appendChild($answers);

            $dom->documentElement->appendChild($entry);
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