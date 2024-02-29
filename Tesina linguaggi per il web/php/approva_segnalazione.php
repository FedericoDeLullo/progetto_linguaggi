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

    if ($action == "Approva") {
        $xmlFile = '../xml/segnalazioni.xml';
        $dom = new DOMDocument();
        $dom->preserveWhiteSpace = false;

        $dom->load($xmlFile);

        $segnalazioni = $dom->getElementsByTagName('segnalazione');

        foreach ($segnalazioni as $segnalazione) {
            $statusElement = $segnalazione->getAttribute('status');
            $idDomandaElement = $segnalazione->getAttribute('id_domanda');

            if ($idDomandaElement == $id_domanda && $statusElement == 'Approvata') {
                $_SESSION['domanda_gia_rimossa'] = 'true';
                header("Location: menu_segnalazioni.php");

                if ($idDomandaElement == $id_domanda && $statusElement == 'In Attesa') {
                    $segnalazione->setAttribute('status', 'Approvata');
                    $dom->normalizeDocument();
                    $dom->formatOutput = true;  
                    $dom->save($xmlFile);
                    break;
                }
            } elseif ($statusElement == 'In Attesa' && $idDomandaElement == $id_domanda) {
                $domanda_element = $segnalazione->getElementsByTagName('testo_domanda')->item(0);
                $testo_element = $segnalazione->getElementsByTagName('testo_segnalazione_dom')->item(0);

                $requestDomanda = $domanda_element->nodeValue;
                $requestTesto = $testo_element->nodeValue;

                if ($requestDomanda == $domanda && $requestTesto == $testo_segnalazione_dom) {
                    // Aggiorna lo stato della richiesta nel file XML

                    $segnalazione->setAttribute('status', 'Approvata');
                    $dom->normalizeDocument();
                    $dom->formatOutput = true; 
                    $dom->save($xmlFile); 


                    $xmlFile1 = '../xml/catalogo_prodotti.xml';
                    $dom1 = new DOMDocument();
                    $dom1->preserveWhiteSpace = false;
                    
                    $dom1->load($xmlFile1);
                    $xpath = new DOMXPath($dom1);
                    $domande = $xpath->query("//domande/domanda[@id_prodotto='$id_prodotto']");
                    if ($domande->length > 0) {
                        foreach ($domande as $domanda) {  
                            $id_dom =  $domanda->getElementsByTagName('id_domanda')->item(0)->nodeValue; 
                            if ($id_dom == $id_domanda) {
                                $domanda->setAttribute("segnalato", 1);
                            }
                        }
                    }
                    $dom1->normalizeDocument();
                    $dom1->formatOutput = true; 
                    $dom1->save($xmlFile1);
                    $_SESSION['successo_domanda'] = 'true';
                    header("Location: menu_segnalazioni.php");
                    
                }
              
            }
            
        }
    } elseif ($action == "Rifiuta") {
        $xmlFile = '../xml/segnalazioni.xml';
        $dom = new DOMDocument();
        $dom->preserveWhiteSpace = false;

        $dom->load($xmlFile);

        $segnalazioni = $dom->getElementsByTagName('segnalazione');

        foreach ($segnalazioni as $segnalazione) {
            $statusElement = $segnalazione->getAttribute('status');
            $idDomandaElement = $segnalazione->getAttribute('id_domanda');

            if ($statusElement == 'In Attesa' && $idDomandaElement == $id_domanda) {
                $domanda_element = $segnalazione->getElementsByTagName('testo_domanda')->item(0);
                $testo_element = $segnalazione->getElementsByTagName('testo_segnalazione_dom')->item(0);

                $requestDomanda = $domanda_element->nodeValue;
                $requestTesto = $testo_element->nodeValue;

                if ($requestDomanda == $domanda && $requestTesto == $testo_segnalazione_dom) {
                    // Aggiorna lo stato della richiesta nel file XML
                    $segnalazione->setAttribute('status', 'Rifiutata');
                    
                    $dom->normalizeDocument();
                    $dom->formatOutput = true;
                    $dom->save($xmlFile);
                    $_SESSION['segnalazione_rifiutata'] = 'true';
                    header("Location: menu_segnalazioni.php");
                }
            }
        }
    }
} elseif (isset($_POST['id_risposta'])) {
    $risposta = $_POST['risposta'];
    $testo_segnalazione_ris = $_POST['testo_ris'];
    $action = $_POST['action'];
    $id_risposta = $_POST['id_risposta'];
    $id_prodotto = $_POST['id_prodotto'];
    $id_domanda = $_POST['id_domanda_elem'];

    if ($action == "Approva") {
        $xmlFile = '../xml/segnalazioni.xml';
        $dom = new DOMDocument();
        $dom->preserveWhiteSpace = false;

        $dom->load($xmlFile);

        $segnalazioni = $dom->getElementsByTagName('segnalazione');

        foreach ($segnalazioni as $segnalazione) {
            $statusElement = $segnalazione->getAttribute('status');
            $idRispostaElement = $segnalazione->getAttribute('id_risposta');
            $idDomandaElement = $segnalazione->getAttribute('id_domanda');

            if ($idRispostaElement == $id_risposta && $statusElement == 'Approvata') {
                $_SESSION['risposta_gia_rimossa'] = 'true';
                header("Location: menu_segnalazioni.php");

                if ($idRispostaElement == $id_risposta && $statusElement == 'In Attesa') {
                    $segnalazione->setAttribute('status', 'Approvata');
                    $dom->normalizeDocument();
                    $dom->formatOutput = true;  
                    $dom->save($xmlFile);
                    break;
                }
            } elseif ($idDomandaElement == $id_domanda && $statusElement == 'Approvata') {
                $_SESSION['domanda_gia_rimossa'] = 'true';
                header("Location: menu_segnalazioni.php");
                if ($idRispostaElement == $id_risposta && $statusElement == 'In Attesa') {
                    $segnalazione->setAttribute('status', 'Approvata');
                    $dom->normalizeDocument();
                    $dom->formatOutput = true;  
                    $dom->save($xmlFile);
                    break;
                }
            } elseif ($statusElement == 'In Attesa' && $idRispostaElement == $id_risposta) {
                $risposta_element = $segnalazione->getElementsByTagName('testo_risposta')->item(0);
                $testo_element = $segnalazione->getElementsByTagName('testo_segnalazione_ris')->item(0);

                $requestRisposta = $risposta_element->nodeValue;
                $requestTesto = $testo_element->nodeValue;

                if ($requestRisposta == $risposta && $requestTesto == $testo_segnalazione_ris) {
                    // Aggiorna lo stato della richiesta nel file XML
                    $segnalazione->setAttribute('status', 'Approvata');
                    
                    $dom->normalizeDocument();
                    $dom->formatOutput = true;
                    $dom->save($xmlFile);
                    
                    $xmlFile1 = '../xml/catalogo_prodotti.xml';
                    $dom1 = new DOMDocument();
                    $dom1->preserveWhiteSpace = false;
                    
                    $dom1->load($xmlFile1);
                    $xpath = new DOMXPath($dom1);
                    $risposte = $xpath->query("//domande/domanda/risposte/risposta[@id_prodotto='$id_prodotto']");
                    if ($risposte->length > 0) {
                        foreach ($risposte as $risposta) {  
                            $id_risp =  $risposta->getElementsByTagName('id_risposta')->item(0)->nodeValue; 
                            if ($id_risp == $id_risposta) {
                                $risposta->setAttribute("segnalato", 1);
                            }
                        }
                    }
                    $dom1->normalizeDocument();
                    $dom1->formatOutput = true; 
                    $dom1->save($xmlFile1);
                    $_SESSION['successo_risposta'] = 'true';
                    header("Location: menu_segnalazioni.php");
                    
                }
            }
        }
    } elseif ($action == "Rifiuta") {
        $xmlFile = '../xml/segnalazioni.xml';
        $dom = new DOMDocument();
        $dom->preserveWhiteSpace = false;

        $dom->load($xmlFile);

        $segnalazioni = $dom->getElementsByTagName('segnalazione');

        foreach ($segnalazioni as $segnalazione) {
            $statusElement = $segnalazione->getAttribute('status');
            $idRispostaElement = $segnalazione->getAttribute('id_risposta');

            if ($statusElement == 'In Attesa' && $idRispostaElement == $id_risposta) {
                $risposta_element = $segnalazione->getElementsByTagName('testo_risposta')->item(0);
                $testo_element = $segnalazione->getElementsByTagName('testo_segnalazione_ris')->item(0);

                $requestRisposta = $risposta_element->nodeValue;
                $requestTesto = $testo_element->nodeValue;

                if ($requestRisposta == $risposta && $requestTesto == $testo_segnalazione_ris) {
                    // Aggiorna lo stato della richiesta nel file XML
                    $segnalazione->setAttribute('status', 'Rifiutata');
                    
                    $dom->normalizeDocument();
                    $dom->formatOutput = true;
                    $dom->save($xmlFile);
                    $_SESSION['segnalazione_rifiutata'] = 'true';
                    header("Location: menu_segnalazioni.php");
                }
            }
        }
    }
} elseif (isset($_POST['id_recensione'])) {
    $recensione = $_POST['recensione'];
    $testo_segnalazione_rec = $_POST['testo_rec'];
    $action = $_POST['action'];
    $id_recensione = $_POST['id_recensione'];
    $id_prodotto = $_POST['id_prodotto'];

    if ($action == "Approva") {
        $xmlFile = '../xml/segnalazioni.xml';
        $dom = new DOMDocument();
        $dom->preserveWhiteSpace = false;

        $dom->load($xmlFile);

        $segnalazioni = $dom->getElementsByTagName('segnalazione');

        foreach ($segnalazioni as $segnalazione) {
            $statusElement = $segnalazione->getAttribute('status');
            $idRecensioneElement = $segnalazione->getAttribute('id_recensione');

            if ($idRecensioneElement == $id_recensione && $statusElement == 'Approvata') {
                $_SESSION['recensione_gia_rimossa'] = 'true';
                header("Location: menu_segnalazioni.php");

                if ($idRecensioneElement == $id_recensione && $statusElement == 'In Attesa') {
                    $segnalazione->setAttribute('status', 'Approvata');
                    $dom->normalizeDocument();
                    $dom->formatOutput = true;  
                    $dom->save($xmlFile);
                    break;
                }
            } elseif ($statusElement == 'In Attesa' && $idRecensioneElement == $id_recensione) {
                $recensione_element = $segnalazione->getElementsByTagName('testo')->item(0);
                $testo_element = $segnalazione->getElementsByTagName('testo_segnalazione_rec')->item(0);

                $requestRecensione = $recensione_element->nodeValue;
                $requestTesto = $testo_element->nodeValue;

                if ($requestRecensione == $recensione && $requestTesto == $testo_segnalazione_rec) {
                    // Aggiorna lo stato della richiesta nel file XML
                    $segnalazione->setAttribute('status', 'Approvata');
                    
                    $dom->normalizeDocument();
                    $dom->formatOutput = true;
                    $dom->save($xmlFile);
                    $xmlFile1 = '../xml/catalogo_prodotti.xml';
                    $dom1 = new DOMDocument();
                    $dom1->preserveWhiteSpace = false;
                    
                    $dom1->load($xmlFile1);
                    $xpath = new DOMXPath($dom1);
                    $recensioni = $xpath->query("//recensioni/recensione[@id_prodotto='$id_prodotto']");
                    if ($recensioni->length > 0) {
                        foreach ($recensioni as $recensione) {  
                            $id_rec =  $recensione->getElementsByTagName('id_recensione')->item(0)->nodeValue; 
                            if ($id_rec == $id_recensione) {
                                $recensione->setAttribute("segnalato", 1);
                            }
                        }
                    }
                    $dom1->normalizeDocument();
                    $dom1->formatOutput = true; 
                    $dom1->save($xmlFile1);
                    $_SESSION['successo_recensione'] = 'true';
                    header("Location: menu_segnalazioni.php");
                }
            }
        }
    } elseif ($action == "Rifiuta") {
        $xmlFile = '../xml/segnalazioni.xml';
        $dom = new DOMDocument();
        $dom->preserveWhiteSpace = false;

        $dom->load($xmlFile);

        $segnalazioni = $dom->getElementsByTagName('segnalazione');

        foreach ($segnalazioni as $segnalazione) {
            $statusElement = $segnalazione->getAttribute('status');
            $idRecensioneElement = $segnalazione->getAttribute('id_recensione');

            if ($statusElement == 'In Attesa' && $idRecensioneElement == $id_recensione) {
                $recensione_element = $segnalazione->getElementsByTagName('testo')->item(0);
                $testo_element = $segnalazione->getElementsByTagName('testo_segnalazione_rec')->item(0);

                $requestRecensione = $recensione_element->nodeValue;
                $requestTesto = $testo_element->nodeValue;

                if ($requestRecensione == $recensione && $requestTesto == $testo_segnalazione_rec) {
                    // Aggiorna lo stato della richiesta nel file XML
                    $segnalazione->setAttribute('status', 'Rifiutata');
                    
                    $dom->normalizeDocument();
                    $dom->formatOutput = true;
                    $dom->save($xmlFile);
                    $_SESSION['segnalazione_rifiutata'] = 'true';
                    header("Location: menu_segnalazioni.php");
                }
            }
        }
    }
}

?>
</body>
</html>