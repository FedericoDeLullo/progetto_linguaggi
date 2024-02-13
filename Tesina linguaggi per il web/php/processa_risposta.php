<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $faq_id = htmlspecialchars($_POST['faq_id']);
    $answer_text = htmlspecialchars($_POST['answer']);

    $xmlFile = '../xml/faq.xml';

    if (file_exists($xmlFile)) {
        $dom = new DOMDocument();
        $dom->load($xmlFile);

        $xpath = new DOMXPath($dom);
        $query = "//entry[@id='{$faq_id}']";
        $entries = $xpath->query($query);

        if ($entries->length > 0) {
            $entry = $entries->item(0);

            // Cerca l'elemento <answers> se esiste già
            $answers = $xpath->query("answers", $entry);

            // Verifica se l'elemento <answers> esiste già
            if ($answers->length === 0) {
                // Se non esiste, crealo e aggiungi la nuova risposta
                $answersElement = $dom->createElement("answers");
                $entry->appendChild($answersElement);
            } else {
                // Se esiste già, rimuovi le risposte esistenti
                foreach ($answers as $answer) {
                    $answer->parentNode->removeChild($answer);
                }
            }

            // Aggiungi la nuova risposta all'elemento <answers>
            $newAnswerElement = $dom->createElement("answer", $answer_text);
            $newAnswerElement->setAttribute("id", uniqid());
            $answersElement->appendChild($newAnswerElement);

            // Salva le modifiche nel file XML
            $dom->save($xmlFile);
            header('Location: faq.php');
            exit();
        } else {
            echo "Errore: Domanda non trovata.";
        }
    } else {
        echo "Errore: Il file XML delle FAQ non esiste.";
    }
}
?>