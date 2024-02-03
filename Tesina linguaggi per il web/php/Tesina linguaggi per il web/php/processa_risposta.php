<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $faq_id = htmlspecialchars($_POST['faq_id']);
    $answer_text = htmlspecialchars($_POST['answer']);
    $user_email = htmlspecialchars($_POST['email']);

    $xmlFile = '../xml/faq.xml';

    if (file_exists($xmlFile)) {
        $xml = simplexml_load_file($xmlFile);

        foreach ($xml->entry as $entry) {
            $id = $entry->attributes()->id;

            if ($id == $faq_id) {
                // Verifica se l'elemento <answers> esiste già
                if (!isset($entry->answers)) {
                    // Se non esiste, crealo
                    $answers = $entry->addChild('answers');
                } else {
                    // Se esiste già, utilizza l'elemento esistente
                    $answers = $entry->answers;
                }

                // Aggiungi una nuova risposta all'elemento <answers>
                $newAnswer = $answers->addChild('answer', $answer_text);
                $newAnswer->addAttribute('id', uniqid());
                // Aggiungi l'email dell'utente come attributo
                $newAnswer->addAttribute('email', $user_email);
                break;
            }
        }

        $xml->asXML($xmlFile);
    } else {
        echo "Errore: Il file XML delle FAQ non esiste.";
    }

    header('Location: faq.php');
    exit();
}
?>
