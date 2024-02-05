<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $faq_id = htmlspecialchars($_POST['faq_id']);
    $answer_text = htmlspecialchars($_POST['answer']);

    $xmlFile = '../xml/faq.xml';

    if (file_exists($xmlFile)) {
        $xml = simplexml_load_file($xmlFile);

        foreach ($xml->entry as $entry) {
            $id = $entry->attributes()->id;

            if ($id == $faq_id) {
                // Cerca l'elemento <answers> se esiste già
                $answers = $entry->xpath('answers');

                // Verifica se l'elemento <answers> esiste già
                if (empty($answers)) {
                    // Se non esiste, crealo e aggiungi la nuova risposta
                    $answers = $entry->addChild('answers');
                    $newAnswer = $answers->addChild('answer', $answer_text);
                    $newAnswer->addAttribute('id', uniqid());
                } else {
                    // Se esiste già, rimuovi le risposte esistenti
                    unset($entry->answers->answer);

                    // Aggiungi la nuova risposta all'elemento <answers>
                    $newAnswer = $answers[0]->addChild('answer', $answer_text);
                    $newAnswer->addAttribute('id', uniqid());
                }

                // Salva le modifiche nel file XML
                $xml->asXML($xmlFile);
                header('Location: faq.php');
                exit();
            }
        }

        echo "Errore: Domanda non trovata.";
    } else {
        echo "Errore: Il file XML delle FAQ non esiste.";
    }
}
?>
