<?php
session_start();
require_once('connection.php');
$xmlFile = '../xml/catalogo_prodotti.xml';

// Carica il file XML
$dom = new DOMDocument();
$dom->preserveWhiteSpace = false;
$dom->load($xmlFile);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['vota'])) {
    $id_recensione = $_POST['id_recensione'];
    $votoUtilita = $_POST['votoUtilita'];
    $votoSupporto = $_POST['votoSupporto'];
    $id_prodotto = $_POST['id_prodotto'];
    $tipologia = $_POST['tipologia'];
    $id_utente = $_SESSION['id'];
    $nome = $_POST['nome'];

    $xpath = new DOMXPath($dom);
    $recensioneNode = $xpath->query("//recensione[id_recensione='$id_recensione']")->item(0);

    if ($recensioneNode) {
        $id_utente_rec = $recensioneNode->getAttribute("id_utente"); 
        $sql = "SELECT reputazione FROM utenti WHERE id = $id_utente";
        $result = $connessione->query($sql);

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();

            $reputazioneUtente = $row['reputazione'];
        
        }
        $utilitaNode = $recensioneNode->getElementsByTagName("utilita")->item(0);
        if (!$utilitaNode) {
            $utilitaNode = $recensioneNode->appendChild($dom->createElement("utilita"));
        }

        $supportoNode = $recensioneNode->getElementsByTagName("supporto")->item(0);
        if (!$supportoNode) {
            $supportoNode = $recensioneNode->appendChild($dom->createElement("supporto"));
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

  $query = "SELECT reputazione FROM utenti WHERE id = $id_utente_rec";
  $result = $connessione->query($query);

  if ($result->num_rows == 1) {
      $row = $result->fetch_assoc();

      $reputazioneUtenteRec = $row['reputazione'];

      $reputazioneUtenteRec = $risultatoFinale;

      $updateQuery = "UPDATE utenti SET reputazione = $reputazioneUtenteRec WHERE id = $id_utente_rec";
      $connessione->query($updateQuery);

      header("Location: ../php/lista_recensioni.php?id_prodotto=" . $id_prodotto . "&tipologia=" . $tipologia . "&nome=" . $nome);
  }
}
}
?>