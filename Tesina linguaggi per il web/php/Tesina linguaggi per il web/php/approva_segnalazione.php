<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestione Crediti</title>
    <link rel="stylesheet" href="../css/style_standard.css">
    <link rel="stylesheet" href="../css/style_header.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <?php
        include('../res/header.php');
    ?>
</head>
<body>

<div class="cont">
<?php
require_once('../res/connection.php');

if(isset($_POST['id_domanda'])){

$domanda = $_POST['domanda'];
$testo_segnalazione_dom = $_POST['testo_dom'];
$action = $_POST['action'];
$id_domanda = $_POST['id_domanda'];
$id_prodotto = $_POST['id_prodotto'];


if ($action=="Approva") {
$xmlFile = '../xml/segnalazioni.xml';
$dom = new DOMDocument();
$dom->load($xmlFile);

$segnalazioni = $dom->getElementsByTagName('segnalazione');

    foreach ($segnalazioni as $segnalazione) {
        $statusElement = $segnalazione->getAttribute('status');
        $idDomandaElement = $segnalazione->getAttribute('id_domanda');
        

        if ($statusElement == 'pending') {
            $domanda_element = $segnalazione->getElementsByTagName('testo_domanda')->item(0);
            $testo_element = $segnalazione->getElementsByTagName('testo_segnalazione_dom')->item(0);

            $requestDomanda = $domanda_element->nodeValue;
            $requestTesto = $testo_element->nodeValue;

            if ($requestDomanda == $domanda && $requestTesto == $testo_segnalazione_dom) {
                // Aggiorna lo stato della richiesta nel file XML
                $segnalazione->setAttribute('status', 'Approvata');
                $dom->save($xmlFile);

            }
        
            if ($idDomandaElement == $id_domanda) {
                $xmlFile = '../xml/catalogo_prodotti.xml';
            
                // Carica il file XML
                $xml = simplexml_load_file($xmlFile);
            
                // Cerca il prodotto
                foreach ($xml->prodotto as $prodotto) {
                  
                        // Cerca e rimuovi la domanda
                        foreach ($prodotto->domande->domanda as $domanda) {
                            if ((string)$domanda->id_domanda == $idDomandaElement) {
                                unset($domanda[0]);
                                echo '<h1 class="titolo">Domanda rimossa con successo!!!</h1>';
                                break;
                            }
                        }
                        // Salva le modifiche
                        $xml->asXML($xmlFile);
                        break;
            }
          }
        }      
      }
    }elseif ($action=="Rifiuta"){
        foreach ($segnalazioni as $segnalazione) {
        $statusElement = $segnalazione->getAttribute('status');
        $idDomandaElement = $segnalazione->getAttribute('id_domanda');
        

        if ($statusElement == 'pending') {
            $domanda_element = $segnalazione->getElementsByTagName('testo_domanda')->item(0);
            $testo_element = $segnalazione->getElementsByTagName('testo_segnalazione_dom')->item(0);

            $requestDomanda = $domanda_element->nodeValue;
            $requestTesto = $testo_element->nodeValue;

            if ($requestDomanda == $domanda && $requestTesto == $testo_segnalazione_dom) {
                // Aggiorna lo stato della richiesta nel file XML
                $segnalazione->setAttribute('status', 'Rifiutata');
                $dom->save($xmlFile);
                header("Location:index.php");
            }
            }
        }
    }
}
elseif (isset($_POST['id_risposta'])){
    $risposta = $_POST['risposta'];
$testo_segnalazione_ris = $_POST['testo_ris'];
$action = $_POST['action'];
$id_risposta = $_POST['id_risposta'];
$id_prodotto = $_POST['id_prodotto'];

    if ($action=="Approva") {
        $xmlFile = '../xml/segnalazioni.xml';
        $dom = new DOMDocument();
        $dom->load($xmlFile);
        
        $segnalazioni = $dom->getElementsByTagName('segnalazione');
        
            foreach ($segnalazioni as $segnalazione) {
                $statusElement = $segnalazione->getAttribute('status');
                $idRispostaElement = $segnalazione->getAttribute('id_risposta');
                
        
                if ($statusElement == 'pending') {
                    $risposta_element = $segnalazione->getElementsByTagName('testo_risposta')->item(0);
                    $testo_element = $segnalazione->getElementsByTagName('testo_segnalazione_ris')->item(0);
        
                    $requestRisposta = $risposta_element->nodeValue;
                    $requestTesto = $testo_element->nodeValue;
        
                    if ($requestRisposta == $risposta && $requestTesto == $testo_segnalazione_ris) {
                        // Aggiorna lo stato della richiesta nel file XML
                        $segnalazione->setAttribute('status', 'Approvata');
                        $dom->save($xmlFile);
        
                    }
                
                    if ($idRispostaElement == $id_risposta) {
                        $xmlFile = '../xml/catalogo_prodotti.xml';
                    
                        // Carica il file XML
                        $xml = simplexml_load_file($xmlFile);
                    
                        // Cerca il prodotto
                        foreach ($xml->prodotto as $prodotto) {
                          
                                // Cerca e rimuovi la domanda
                                foreach ($prodotto->domande->domanda as $domanda) {
                                    foreach ($domanda->risposte->risposta as $risposta) {
                                        if ((string)$risposta->id_risposta == $idRispostaElement) {
                                        unset($risposta[0]);
                                        echo '<h1 class="titolo">Risposta rimossa con successo!!!</h1>';
                                        break;
                                    }
                                    }
                                }
                                  
                                }
                                // Salva le modifiche
                                $xml->asXML($xmlFile);
                                break;
                    }
                  }
                }      
              }
            elseif ($action=="Rifiuta"){
                foreach ($segnalazioni as $segnalazione) {
                $statusElement = $segnalazione->getAttribute('status');
                $idRispostaElement = $segnalazione->getAttribute('id_risposta');
                
        
                if ($statusElement == 'pending') {
                    $risposta_element = $segnalazione->getElementsByTagName('testo_risposta')->item(0);
                    $testo_element = $segnalazione->getElementsByTagName('testo_segnalazione_ris')->item(0);
        
                    $requestRisposta = $risposta_element->nodeValue;
                    $requestTesto = $testo_element->nodeValue;
        
                    if ($requestRisposta == $risposta && $requestTesto == $testo_segnalazione_ris) {
                        // Aggiorna lo stato della richiesta nel file XML
                        $segnalazione->setAttribute('status', 'Rifiutata');
                        $dom->save($xmlFile);
                        header("Location:index.php");
                      }
                  
                   }
                }
            }
        }

?>
</body>
</html>