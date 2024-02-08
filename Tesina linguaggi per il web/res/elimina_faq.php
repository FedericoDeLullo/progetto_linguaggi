<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] === "GET") {
    // Verifica se è stato fornito un parametro "id" nell'URL
    if (isset($_GET['id'])) {
        $faq_id = htmlspecialchars($_GET['id']);

        $xmlFile = '../xml/faq.xml';

        if (file_exists($xmlFile)) {
            $xml = simplexml_load_file($xmlFile);

            // Cerca l'elemento con l'ID corrispondente
            $faq_entry = $xml->xpath("//entry[@id='$faq_id']");

            // Verifica se è stato trovato un elemento
            if (!empty($faq_entry)) {
                // Rimuovi l'elemento dal file XML
                unset($faq_entry[0][0]);

                // Salva le modifiche nel file XML
                $xml->asXML($xmlFile);

                // Reindirizza alla pagina delle FAQ
                header('Location: ../php/faq.php');
                exit();
            } else {
                echo "Errore: FAQ non trovata.";
            }
        } else {
            echo "Errore: Il file XML delle FAQ non esiste.";
        }
    } else {
        echo "Errore: Parametro 'id' mancante.";
    }
}
?>