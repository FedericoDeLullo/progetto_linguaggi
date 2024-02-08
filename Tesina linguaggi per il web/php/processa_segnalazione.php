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


if(isset($_POST['id_domanda'])){
$id_domanda = $_POST['id_domanda'];
$testo_domanda = $_POST['testo_domanda'];
$testo_segnalazione = $_POST['segnalazione'];
$id_prodotto = $_POST['id_prodotto'];

$xmlFile = '../xml/segnalazioni.xml';  // Utilizzo di un percorso relativo
$dom = new DOMDocument();

try {
    $dom->load($xmlFile);
} catch (Exception $e) {
    die('Errore nel caricamento del file XML: ' . $e->getMessage());
}

$root = $dom->documentElement;

$segnalazione = $dom->createElement('segnalazione');
$segnalazione->setAttribute('status', 'pending');
$segnalazione->setAttribute('id_domanda', $id_domanda);
$segnalazione->setattribute('id_prodotto', $id_prodotto);

$domanda_element = $dom->createElement('testo_domanda', $testo_domanda);
$segnalazione->appendChild($domanda_element);

$segnalazione_element = $dom->createElement('testo_segnalazione_dom', $testo_segnalazione);
$segnalazione->appendChild($segnalazione_element);

$root->appendChild($segnalazione);

try {
    $dom->save($xmlFile);
} catch (Exception $e) {
    die('Errore nel salvataggio del file XML: ' . $e->getMessage());
}

echo "<h1 class='titolo'>Segnalazione inviata con successo. Attendere l'approvazione dell'amministratore...</h1>";
}
 elseif(isset($_POST['id_risposta'])){


    $testo_segnalazione = $_POST['segnalazione'];
    $id_prodotto = $_POST['id_prodotto'];
    $testo_risposta = $_POST['testo_risposta'];
    $id_risposta = $_POST['id_risposta'];

    $xmlFile = '../xml/segnalazioni.xml'; 
    $dom = new DOMDocument();
    
    try {
        $dom->load($xmlFile);
    } catch (Exception $e) {
        die('Errore nel caricamento del file XML: ' . $e->getMessage());
    }
    
    $root = $dom->documentElement;
    
    $segnalazione = $dom->createElement('segnalazione');
    $segnalazione->setAttribute('status', 'pending');
    $segnalazione->setAttribute('id_risposta', $id_risposta);
    $segnalazione->setattribute('id_prodotto', $id_prodotto);
    
    $risposta_element = $dom->createElement('testo_risposta', $testo_risposta);
    $segnalazione->appendChild($risposta_element);
    
    $segnalazione_element = $dom->createElement('testo_segnalazione_ris', $testo_segnalazione);
    $segnalazione->appendChild($segnalazione_element);
    
    $root->appendChild($segnalazione);
    
    try {
        $dom->save($xmlFile);
    } catch (Exception $e) {
        die('Errore nel salvataggio del file XML: ' . $e->getMessage());
    }
    
    echo "<h1 class='titolo'>Segnalazione risposta inviata con successo. Attendere l'approvazione dell'amministratore...</h1>";
     
}

?>
</div>
</body>
</html>