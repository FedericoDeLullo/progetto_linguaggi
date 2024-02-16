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
                    $dom->save($xmlFile);
                }

                if ($idDomandaElement == $id_domanda) {
                    $xmlFileCatalogo = '../xml/catalogo_prodotti.xml';
                    $xmlCatalogo = new DOMDocument();
                    $dom->preserveWhiteSpace = false;

                    $xmlCatalogo->load($xmlFileCatalogo);

                    // Cerca il prodotto
                    $prodottoNodes = $xmlCatalogo->getElementsByTagName('prodotto');
                    foreach ($prodottoNodes as $prodotto) {
                        // Cerca e rimuovi la domanda
                        $domandeNodes = $prodotto->getElementsByTagName('domande');
                        foreach ($domandeNodes as $domande) {
                            $domandaNodes = $domande->getElementsByTagName('domanda');
                            foreach ($domandaNodes as $domandaNode) {
                                $idDomandaElementValue = $domandaNode->getElementsByTagName('id_domanda')->item(0)->nodeValue;
                    
                                if ($idDomandaElementValue == $idDomandaElement) {
                                    $domande->removeChild($domandaNode);
                                    $_SESSION['successo_domanda'] = 'true';
                                    header("Location: menu_segnalazioni.php");
                                    
                                    $dom->normalizeDocument();
                                    $dom->formatOutput = true;
                                    $xmlCatalogo->save($xmlFileCatalogo);
                                    break 3;  // Exit all loops
                                }
                            }
                        }
                    }
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
                }

                if ($idRispostaElement == $id_risposta) {
                    $xmlFileCatalogo = '../xml/catalogo_prodotti.xml';
                    $xmlCatalogo = new DOMDocument();
                    $dom->preserveWhiteSpace = false;

                    $xmlCatalogo->load($xmlFileCatalogo);
                
                    // Cerca il prodotto
                    $prodottoNodes = $xmlCatalogo->getElementsByTagName('prodotto');
                    foreach ($prodottoNodes as $prodotto) {
                        // Cerca e rimuovi la domanda
                        $domandeNodes = $prodotto->getElementsByTagName('domande');
                        foreach ($domandeNodes as $domande) {
                            $domandaNodes = $domande->getElementsByTagName('domanda');
                            foreach ($domandaNodes as $domandaNode) {
                                $risposteNodes = $domandaNode->getElementsByTagName('risposte');
                                foreach ($risposteNodes as $risposte) {
                                    $rispostaNodes = $risposte->getElementsByTagName('risposta');
                                    foreach ($rispostaNodes as $rispostaNode) {
                                        $idRispostaElementNode = $rispostaNode->getElementsByTagName('id_risposta')->item(0);
                
                                        if ($idRispostaElementNode !== null && $idRispostaElementNode->nodeValue == $idRispostaElement) {
                                            $risposte->removeChild($rispostaNode);
                                            $_SESSION['successo_risposta'] = 'true';
                                            header("Location: menu_segnalazioni.php");
                                            
                                            $dom->normalizeDocument();
                                            $dom->formatOutput = true;
                                            $xmlCatalogo->save($xmlFileCatalogo);
                                            break 4;  // Exit all loops
                                        }
                                    }
                                }
                            }
                        }
                    }
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
                }

                if ($idRecensioneElement == $id_recensione) {
                    $xmlFileCatalogo = '../xml/catalogo_prodotti.xml';
                    $xmlCatalogo = new DOMDocument();
                    $dom->preserveWhiteSpace = false;

                    $xmlCatalogo->load($xmlFileCatalogo);

                    // Cerca il prodotto
                    $prodottoNodes = $xmlCatalogo->getElementsByTagName('prodotto');
                    foreach ($prodottoNodes as $prodotto) {
                        $recensioniNodes = $prodotto->getElementsByTagName('recensioni');
                        foreach ($recensioniNodes as $recensioni) {
                            $recensioneNodes = $recensioni->getElementsByTagName('recensione');
                            foreach ($recensioneNodes as $recensioneNode) {
                                $idRecensioneNode = $recensioneNode->getElementsByTagName('id_recensione')->item(0)->nodeValue;

                                if ($idRecensioneNode == $idRecensioneElement) {
                                    $recensioni->removeChild($recensioneNode);
                                    $_SESSION['successo_recensione'] = 'true';
                                    header("Location: menu_segnalazioni.php");
                                    
                                    $dom->normalizeDocument();
                                    $dom->formatOutput = true;
                                    $xmlCatalogo->save($xmlFileCatalogo);
                                    break 3;  // Exit all loops
                                }
                            }
                        }
                    }
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