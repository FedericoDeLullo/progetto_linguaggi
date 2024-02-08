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
 
$xmlFile = '../xml/segnalazioni.xml';
$dom = new DOMDocument();
$dom->load($xmlFile);

$segnalazioni = $dom->getElementsByTagName('segnalazione');

echo '<div class="cont">';
echo '<h1 class="titolo">Segnalazione prodotti</h1>';

$hasPendingRequests = false;

echo '<table>';
echo '<thead>';
echo '<tr>';
echo '<th>Post Segnalato</th>';
echo '<th>Segnalazione</th>';
echo '<th>Azione</th>';
echo '</tr>';
echo '</thead>';
echo '<tbody>';

foreach ($segnalazioni as $segnalazione) {
    $status = $segnalazione->getAttribute('status');
    $id_domanda = $segnalazione->getAttribute('id_domanda');
    $id_risposta = $segnalazione->getAttribute('id_risposta');

    if ($status == 'pending') {
        $hasPendingRequests = true;

        if ($id_domanda && !$id_risposta) {
            // Stampa solo la domanda
            $id_prodotto = $segnalazione->getAttribute('id_prodotto');
            $domandaElement = $segnalazione->getElementsByTagName('testo_domanda')->item(0)->nodeValue;
            $testoElementDom = $segnalazione->getElementsByTagName('testo_segnalazione_dom')->item(0)->nodeValue;
           
            echo '<tr>';
            echo "<td>$domandaElement</td>";
            echo "<td>$testoElementDom</td>";
            echo '<td>';
            echo '<form action="approva_segnalazione.php" method="post">';
            echo "<input type='hidden' name='domanda' value='$domandaElement'>";
            echo "<input type='hidden' name='id_domanda' value='$id_domanda'>";
            echo "<input type='hidden' name='id_prodotto' value='$id_prodotto'>";
            echo "<input type='hidden' name='testo_dom' value='$testoElementDom'>";
            echo '<button class="done" type="submit" name="action" value="Approva"><span id="done" class="material-symbols-outlined">done</span></button>';
            echo '<button class="done" type="submit" name="action" value="Rifiuta"><span id="done" class="material-symbols-outlined">close</span></button> ';
            echo '</form>';            
            echo '</td>';
            echo '</tr>';
        } elseif (!$id_domanda && $id_risposta) {
            // Stampa solo la risposta
            $rispostaElement = $segnalazione->getElementsByTagName('testo_risposta')->item(0)->nodeValue;
            $testoElementRis = $segnalazione->getElementsByTagName('testo_segnalazione_ris')->item(0)->nodeValue;
            $id_prodotto = $segnalazione->getAttribute('id_prodotto');


            echo '<tr>';
            echo "<td>$rispostaElement</td>";
            echo "<td>$testoElementRis</td>"; 
            echo '<td>';
            echo '<form action="approva_segnalazione.php" method="post">';
            echo "<input type='hidden' name='risposta' value='$rispostaElement'>";
            echo "<input type='hidden' name='id_risposta' value='$id_risposta'>";
            echo "<input type='hidden' name='id_prodotto' value='$id_prodotto'>";
            echo "<input type='hidden' name='testo_ris' value='$testoElementRis'>";
            echo '<button class="done" type="submit" name="action" value="Approva"><span id="done" class="material-symbols-outlined">done</span></button>';
            echo '<button class="done" type="submit" name="action" value="Rifiuta"><span id="done" class="material-symbols-outlined">close</span></button> ';
            echo '</form>';            
            echo '</td>';
            echo '</tr>';
        } elseif ($id_domanda && $id_risposta) {
            // Stampa sia domanda che risposta
            $id_prodotto = $segnalazione->getAttribute('id_prodotto');
            $domandaElement = $segnalazione->getElementsByTagName('testo_domanda')->item(0)->nodeValue;
            $rispostaElement = $segnalazione->getElementsByTagName('testo_risposta')->item(0)->nodeValue;
            $testoElementRis = $segnalazione->getElementsByTagName('testo_segnalazione_ris')->item(0)->nodeValue;
            $testoElementDom = $segnalazione->getElementsByTagName('testo_segnalazione_dom')->item(0)->nodeValue;


            echo '<tr>';
            echo "<td>$domandaElement</td>";
            echo "<td>$rispostaElement</td>";
            echo '<td>';
            echo '<form action="approva_segnalazione.php" method="post">';
            echo "<input type='hidden' name='risposta' value='$rispostaElement'>";
            echo "<input type='hidden' name='id_risposta' value='$id_risposta'>";
            echo "<input type='hidden' name='domanda' value='$domandaElement'>";
            echo "<input type='hidden' name='id_domanda' value='$id_domanda'>";
            echo "<input type='hidden' name='id_prodotto' value='$id_prodotto'>";
            echo "<input type='hidden' name='testo_dom' value='$testoElementDom'>";
            echo "<input type='hidden' name='testo_ris' value='$testoElementRis'>";
            echo '<button class="done" type="submit" name="action" value="Approva"><span id="done" class="material-symbols-outlined">done</span></button>';
            echo '<button class="done" type="submit" name="action" value="Rifiuta"><span id="done" class="material-symbols-outlined">close</span></button> ';
            echo '</form>';            
            echo '</td>';
            echo '</tr>';
        }
    }
}

echo '</tbody>';
echo '</table>';

// Verifica il flag per determinare se ci sono richieste pendenti
if (!$hasPendingRequests) {
    echo '<p class="titolo">Nessuna segnalazione attualmente in sospeso.</p>';
}
echo '</div>';
?>