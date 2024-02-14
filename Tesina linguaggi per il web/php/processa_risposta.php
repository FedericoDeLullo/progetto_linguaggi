<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $faq_id = htmlspecialchars($_POST['faq_id']);
    $answer_text = htmlspecialchars($_POST['answer']);

    $xmlFile = '../xml/faq.xml';

    if (file_exists($xmlFile)) {
        $xml = new DOMDocument();
        $xml->load($xmlFile);
        $xpath = new DOMXPath($xml);

        $entries = $xpath->query("/faq/entry[@id='$faq_id']");

        if ($entries->length > 0) {
            $entry = $entries[0];

            // Cerca l'elemento <answers> se esiste già
            $answers = $xpath->query('answers', $entry);

            // Verifica se l'elemento <answers> esiste già
            if ($answers->length === 0) {
                // Se non esiste, crealo e aggiungi la nuova risposta
                $answers = $entry->appendChild($xml->createElement('answers'));
                $newAnswer = $answers->appendChild($xml->createElement('answer', $answer_text));
                $newAnswer->setAttribute('id', uniqid());
            } else {
                // Se esiste già, rimuovi le risposte esistenti
                foreach ($answers[0]->childNodes as $childNode) {
                    $answers[0]->removeChild($childNode);
                }

                // Aggiungi la nuova risposta all'elemento <answers>
                $newAnswer = $answers[0]->appendChild($xml->createElement('answer', $answer_text));
                $newAnswer->setAttribute('id', uniqid());
            }

            // Salva le modifiche nel file XML
            $xml->save($xmlFile);
            header('Location: faq.php');
            exit();
        }

        echo "Errore: Domanda non trovata.";
    } else {
        echo "Errore: Il file XML delle FAQ non esiste.";
    }
}
?>
