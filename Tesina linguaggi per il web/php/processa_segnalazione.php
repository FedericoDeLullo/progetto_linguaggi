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

if (!isset($_SESSION['loggato'])) {
    header("Location: login_cliente.php");
    exit();
}

if(isset($_POST['id_domanda']) && !isset($_POST['id_risposta'])){
$id_domanda = $_POST['id_domanda'];
$testo_domanda = $_POST['testo_domanda'];
$testo_segnalazione = $_POST['segnalazione'];
$id_prodotto = $_POST['id_prodotto'];
$autoreDomanda = $_POST['autoreDomanda'];
$nome = $_POST['nome'];
$tipologia = $_POST['tipologia'];

$xmlFile = '../xml/segnalazioni.xml';  // Utilizzo di un percorso relativo
$dom = new DOMDocument();

try {
    $dom->load($xmlFile);
} catch (Exception $e) {
    die('Errore nel caricamento del file XML: ' . $e->getMessage());
}

$root = $dom->documentElement;

$segnalazione = $dom->createElement('segnalazione');
$segnalazione->setAttribute('status', 'In Attesa');
$segnalazione->setAttribute('id_domanda', $id_domanda);
$segnalazione->setattribute('id_prodotto', $id_prodotto);

$domanda_element = $dom->createElement('testo_domanda', $testo_domanda);
$segnalazione->appendChild($domanda_element);

$autore_element = $dom->createElement('autoreDomanda', $autoreDomanda);
$segnalazione->appendChild($autore_element);

$segnalazione_element = $dom->createElement('testo_segnalazione_dom', $testo_segnalazione);
$segnalazione->appendChild($segnalazione_element);

$root->appendChild($segnalazione);

try {
    $dom->save($xmlFile);
} catch (Exception $e) {
    die('Errore nel salvataggio del file XML: ' . $e->getMessage());
}

$_SESSION['successo_segnalazione_domanda'] = 'true';
header("Location: ../php/domande.php?id_prodotto=$id_prodotto&nome=$nome&tipologia=$tipologia&id=$id_utente");
}
 elseif(isset($_POST['id_risposta'])){

    $id_domanda = $_POST['id_domanda'];
    $testo_segnalazione = $_POST['segnalazione'];
    $id_prodotto = $_POST['id_prodotto'];
    $testo_risposta = $_POST['testo_risposta'];
    $id_risposta = $_POST['id_risposta'];
    $autoreRisposta = $_POST['autoreRisposta'];
    $nome = $_POST['nome'];
    $tipologia = $_POST['tipologia'];

    $xmlFile = '../xml/segnalazioni.xml'; 
    $dom = new DOMDocument();
    
    try {
        $dom->load($xmlFile);
    } catch (Exception $e) {
        die('Errore nel caricamento del file XML: ' . $e->getMessage());
    }
    
    $root = $dom->documentElement;
    
    $segnalazione = $dom->createElement('segnalazione');
    $segnalazione->setAttribute('status', 'In Attesa');
    $segnalazione->setAttribute('id_risposta', $id_risposta);
    $segnalazione->setattribute('id_prodotto', $id_prodotto);

    
    $domanda_element = $dom->createElement('id_domanda', $id_domanda);
    $segnalazione->appendChild($domanda_element);
    
    $risposta_element = $dom->createElement('testo_risposta', $testo_risposta);
    $segnalazione->appendChild($risposta_element);
    
    
$autore_element = $dom->createElement('autoreRisposta', $autoreRisposta);
$segnalazione->appendChild($autore_element);

    $segnalazione_element = $dom->createElement('testo_segnalazione_ris', $testo_segnalazione);
    $segnalazione->appendChild($segnalazione_element);
    
    $root->appendChild($segnalazione);
    
    try {
        $dom->save($xmlFile);
    } catch (Exception $e) {
        die('Errore nel salvataggio del file XML: ' . $e->getMessage());
    }
    $_SESSION['successo_segnalazione_risposta'] = 'true';
    header("Location: ../php/domande.php?id_prodotto=$id_prodotto&nome=$nome&tipologia=$tipologia&id=$id_utente");
     
}elseif(isset($_POST['id_recensione'])){
    $id_recensione = $_POST['id_recensione'];
$testo_recensione = $_POST['testo_recensione'];
$testo_segnalazione = $_POST['segnalazione'];
$id_prodotto = $_POST['id_prodotto'];
$autoreRecensione = $_POST['autoreRecensione'];
$nome = $_POST['nome'];
$tipologia = $_POST['tipologia'];

$xmlFile = '../xml/segnalazioni.xml';  // Utilizzo di un percorso relativo
$dom = new DOMDocument();

try {
    $dom->load($xmlFile);
} catch (Exception $e) {
    die('Errore nel caricamento del file XML: ' . $e->getMessage());
}

$root = $dom->documentElement;

$segnalazione = $dom->createElement('segnalazione');
$segnalazione->setAttribute('status', 'In Attesa');
$segnalazione->setattribute('id_prodotto', $id_prodotto);
$segnalazione->setattribute('id_recensione', $id_recensione);



$recensione_element = $dom->createElement('testo', $testo_recensione);
$segnalazione->appendChild($recensione_element);

$autore_element = $dom->createElement('autore', $autoreRecensione);
$segnalazione->appendChild($autore_element);

$segnalazione_element = $dom->createElement('testo_segnalazione_rec', $testo_segnalazione);
$segnalazione->appendChild($segnalazione_element);

$root->appendChild($segnalazione);

try {
    $dom->save($xmlFile);
} catch (Exception $e) {
    die('Errore nel salvataggio del file XML: ' . $e->getMessage());
}

$_SESSION['successo_segnalazione_recensione'] = 'true';
header("Location: ../php/lista_recensioni.php?id_prodotto=$id_prodotto&tipologia=$tipologia&nome=$nome&id=$id_utente");
}

?>
</div>
</body>
</html>