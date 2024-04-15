<?php
session_start();
require_once('connection.php');
$xmlFile = '../xml/catalogo_prodotti.xml';

// Carica il file XML
$dom = new DOMDocument();
$dom->preserveWhiteSpace = false;
$dom->load($xmlFile);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['vota'])) {
    $id_risposta = $_POST['id_risposta'];
    $id_domanda = $_POST['id_domanda'];
    $votoUtilita = $_POST['votoUtilita'];
    $votoSupporto = $_POST['votoSupporto'];
    $id_prodotto = $_POST['id_prodotto'];
    $tipologia = $_POST['tipologia'];
    $id_utente = $_SESSION['id'];
    $nome = $_POST['nome'];

    $xpath = new DOMXPath($dom);
    $rispostaNode = $xpath->query("//risposta[id_risposta='$id_risposta']")->item(0);

    if ($rispostaNode) {
        $id_utente_risp = $rispostaNode->getAttribute("id_utente");

        $sql = "SELECT reputazione FROM utenti WHERE id = $id_utente";
        $result = $connessione->query($sql);

        if ($result && $result->num_rows == 1) {
            $row = $result->fetch_assoc();

            $reputazioneUtente = $row['reputazione'];

            $utilitaNode = $rispostaNode->getElementsByTagName("utilita_risposta")->item(0);
            if (!$utilitaNode) {
                $utilitaNode = $rispostaNode->appendChild($dom->createElement("utilita_risposta"));
            }

            $supportoNode = $rispostaNode->getElementsByTagName("supporto_risposta")->item(0);
            if (!$supportoNode) {
                $supportoNode = $rispostaNode->appendChild($dom->createElement("supporto_risposta"));
            }

        
                $valoreUtilitaNode = $utilitaNode->appendChild($dom->createElement("valore"));

                $valoreUtilitaNode->setAttribute("id_utente", $id_utente);
                $valoreUtilitaNode->setAttribute("reputazione_Vot", $reputazioneUtente);
        
            $valoreUtilitaNode->nodeValue = $votoUtilita;

           
                $valoreSupportoNode = $supportoNode->appendChild($dom->createElement("valore"));

                $valoreSupportoNode->setAttribute("id_utente", $id_utente);
                $valoreSupportoNode->setAttribute("reputazione_Vot", $reputazioneUtente);
            

            $valoreSupportoNode->nodeValue = $votoSupporto;

            $dom->normalizeDocument();
            $dom->formatOutput = true;

            // Salva il documento XML aggiornato
            $dom->save($xmlFile);

            $sommaVotiUtilitaSupporto = 0;
            $sommaReputazioni = 0;

            $votiUtilita = $utilitaNode->getElementsByTagName("valore");
            $votiSupporto = $supportoNode->getElementsByTagName("valore");

            for ($i = 0; $i < $votiUtilita->length; $i++) {
                $votoUtilita = intval($votiUtilita->item($i)->nodeValue);
                $votoSupporto = intval($votiSupporto->item($i)->nodeValue);

                $reputazione_utente = intval($votiUtilita->item($i)->getAttribute("reputazione_Vot"));

                $sommaVotiUtilitaSupporto += (($votoUtilita + $votoSupporto) * $reputazione_utente);
                $sommaReputazioni += $reputazione_utente;
            }

            $risultatoFinale = (10/8) * ($sommaVotiUtilitaSupporto / $sommaReputazioni);

            $query = "SELECT reputazione, ammin, gestore, utente FROM utenti WHERE id = $id_utente_risp";
            $result = $connessione->query($query);

            if ($result && $result->num_rows == 1) {
                $row = $result->fetch_assoc();

                if ($row['ammin'] == 1 || $row['gestore'] == 1){
                    $updateQuery1 = "UPDATE utenti SET reputazione = 11 WHERE id = $id_utente_risp";
                    $connessione->query($updateQuery1);
                    header("Location: ../php/domande.php?id_prodotto=" . $id_prodotto . "&tipologia=" . $tipologia . "&nome=" . $nome);
                   }
                   else {
        

                $reputazioneUtenteDom = $row['reputazione'];

                $reputazioneUtenteDom = $risultatoFinale;

                $updateQuery = "UPDATE utenti SET reputazione = $reputazioneUtenteDom WHERE id = $id_utente_risp";
                $connessione->query($updateQuery);

                header("Location: ../php/domande.php?id_prodotto=" . $id_prodotto . "&tipologia=" . $tipologia . "&nome=" . $nome);
                exit; 
            }
          }
        }
    }
}

echo "Errore durante l'aggiornamento della risposta.";
?>
