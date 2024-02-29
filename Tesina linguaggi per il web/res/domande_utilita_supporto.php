<?php
session_start();
require_once('connection.php');
 
$xmlFile = '../xml/catalogo_prodotti.xml';
// Carica il file XML
$dom = new DOMDocument();
$dom->preserveWhiteSpace = false;
$dom->load($xmlFile);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['vota'])) {
    $id_domanda = $_POST['id_domanda'];
    $votoUtilita = $_POST['votoUtilita'];
    $votoSupporto = $_POST['votoSupporto'];
    $id_prodotto = $_POST['id_prodotto'];
    $tipologia = $_POST['tipologia'];
    $id_utente = $_SESSION['id'];
    $nome = $_POST['nome'];

    // Trova la domanda con l'id_domanda specificato
    $xpath = new DOMXPath($dom);
    $domandaNode = $xpath->query("//domanda[id_domanda='$id_domanda']")->item(0);

    // Verifica se la domanda esiste prima di procedere
    if ($domandaNode) {
        $id_utente_dom = $domandaNode->getAttribute("id_utente");

        $sql = "SELECT reputazione FROM utenti WHERE id = $id_utente";
        $result = $connessione->query($sql);

        if ($result->num_rows == 1) {
            // Ottieni la riga risultante dalla query
            $row = $result->fetch_assoc();

            // Ottieni il valore della reputazione dall'array associativo
            $reputazioneUtente = $row['reputazione'];
        

        // Ottieni o crea i nodi "utilita" e "supporto"
        $utilitaNode = $domandaNode->getElementsByTagName("utilita")->item(0);
        if (!$utilitaNode) {
            $utilitaNode = $domandaNode->appendChild($dom->createElement("utilita"));
        }

        $supportoNode = $domandaNode->getElementsByTagName("supporto")->item(0);
        if (!$supportoNode) {
            $supportoNode = $domandaNode->appendChild($dom->createElement("supporto"));
        }

        // Aggiungi un nuovo nodo "valore" per "utilita"
        $valoreUtilitaNode = $utilitaNode->appendChild($dom->createElement("valore"));

        // Imposta l'attributo "id_utente" per "utilita"
        $valoreUtilitaNode->setAttribute("id_utente", $id_utente);
        $valoreUtilitaNode->setAttribute("reputazione_Vot", $reputazioneUtente);

        // Imposta il valore di "valore" per "utilita"
        $valoreUtilitaNode->nodeValue = $votoUtilita;

        // Aggiungi un nuovo nodo "valore" per "supporto"
        $valoreSupportoNode = $supportoNode->appendChild($dom->createElement("valore"));

        // Imposta l'attributo "id_utente" per "supporto"
        $valoreSupportoNode->setAttribute("id_utente", $id_utente);
        $valoreSupportoNode->setAttribute("reputazione_Vot", $reputazioneUtente);

        // Imposta il valore di "valore" per "supporto"
        $valoreSupportoNode->nodeValue = $votoSupporto;

        $dom->normalizeDocument();

        $dom->formatOutput = true;

        // Salva il documento XML aggiornato
        $dom->save($xmlFile);

        // inizializzazione delle variabili
        $sommaVotiUtilitaSupporto = 0;
        $sommaReputazioni = 0;

        // Ottieni i voti di utilità e supporto
        $votiUtilita = $utilitaNode->getElementsByTagName("valore");
        $votiSupporto = $supportoNode->getElementsByTagName("valore");

        // Itera attraverso tutti i voti
        for ($i = 0; $i < $votiUtilita->length; $i++) {
            $votoUtilita = intval($votiUtilita->item($i)->nodeValue);
            $votoSupporto = intval($votiSupporto->item($i)->nodeValue);

            // Ottieni la reputazione dell'utente che ha lasciato il voto
            $reputazione_utente = intval($votiUtilita->item($i)->getAttribute("reputazione_Vot"));

            // Calcola la parte della sommatoria
            $sommaVotiUtilitaSupporto += (($votoUtilita + $votoSupporto) * $reputazione_utente);
            $sommaReputazioni += $reputazione_utente;
        }

        // Calcola il risultato finale
        $risultatoFinale = (10/8) * ($sommaVotiUtilitaSupporto / $sommaReputazioni);

        $query = "SELECT reputazione, ammin, gestore, utente FROM utenti WHERE id = $id_utente_dom";
        $result = $connessione->query($query);


        if ($result->num_rows == 1) {
            // Ottieni la riga risultante dalla query
            $row = $result->fetch_assoc();

           if ($row['ammin'] == 1 || $row['gestore'] == 1){
            $updateQuery1 = "UPDATE utenti SET reputazione = 11 WHERE id = $id_utente_dom";
            $connessione->query($updateQuery1);
            header("Location: ../php/domande.php?id_prodotto=" . $id_prodotto . "&tipologia=" . $tipologia . "&nome=" . $nome);

           }
           else {


            // Ottieni il valore della reputazione dall'array associativo
            $reputazioneUtenteDom = $row['reputazione'];

            // Assegna il valore di $risultatoFinale a $reputazioneUtenteDom
            $reputazioneUtenteDom = $risultatoFinale;

            // Ora puoi aggiornare la reputazione nel database
            $updateQuery = "UPDATE utenti SET reputazione = $reputazioneUtenteDom WHERE id = $id_utente_dom";
            $connessione->query($updateQuery);

            header("Location: ../php/domande.php?id_prodotto=" . $id_prodotto . "&tipologia=" . $tipologia . "&nome=" . $nome);
           }
        }
     }
   }
}
?>