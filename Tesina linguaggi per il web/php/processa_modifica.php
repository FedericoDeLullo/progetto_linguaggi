<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $faq_id = htmlspecialchars($_POST['faq_id']);
    $new_question = htmlspecialchars($_POST['answer']);

    $xmlFile = '../xml/faq.xml';

    if (file_exists($xmlFile)) {
        $dom = new DOMDocument();
        $dom->preserveWhiteSpace = false;

        $dom->load($xmlFile);

        $xpath = new DOMXPath($dom);
        $query = "//entry[@id='{$faq_id}']";
        $entries = $xpath->query($query);

        if ($entries->length > 0) {
            $entry = $entries->item(0);

            // Trova l'elemento question e aggiorna il suo testo
            $questions = $xpath->query("question", $entry);
            if ($questions->length > 0) {
                $question = $questions->item(0);
                $question->nodeValue = $new_question;
               
                $dom->normalizeDocument();
                $dom->formatOutput = true; 
                // Salva le modifiche nel file XML
                $dom->save($xmlFile);
                header('Location: faq.php');
                exit();
            } else {
                echo "Errore: Elemento 'question' non trovato.";
            }
        } else {
            echo "Errore: Domanda non trovata.";
        }
    } else {
        echo "Errore: Il file XML delle FAQ non esiste.";
    }
}
?>