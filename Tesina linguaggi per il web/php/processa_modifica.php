<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $faq_id = htmlspecialchars($_POST['faq_id']);
    $new_question = htmlspecialchars($_POST['answer']);

    $xmlFile = '../xml/faq.xml';

    if (file_exists($xmlFile)) {
        $xml = simplexml_load_file($xmlFile);

        foreach ($xml->entry as $entry) {
            $id = $entry->attributes()->id;

            if ($id == $faq_id) {
                // Aggiorna il testo della domanda
                $entry->question = $new_question;

                // Salva le modifiche nel file XML
                $xml->asXML($xmlFile);

                // Reindirizza alla pagina delle FAQ
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
