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


<?php
$xmlFile = '../xml/segnalazioni.xml';
$dom = new DOMDocument();
$dom->load($xmlFile);

$segnalazioni = $dom->getElementsByTagName('segnalazione');



if($segnalazione->getAttribute('id_domanda')){


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

    if ($status == 'pending') {
        $hasPendingRequests = true;

        $domandaElement = $segnalazione->getElementsByTagName('testo_domanda')->item(0)->nodeValue;
        $testoElement = $segnalazione->getElementsByTagName('testo_segnalazione')->item(0)->nodeValue;
        $id_domanda = $segnalazione->getAttribute('id_domanda');
        $id_prodotto = $segnalazione->getAttribute('id_prodotto');


        echo '<tr>';
        echo "<td>$domandaElement</td>";
        echo "<td>$testoElement</td>";
        echo '<td>';
        echo '<form action="approva_segnalazione.php" method="post">';
        echo "<input type='hidden' name='domanda' value='$domandaElement'>";
        echo "<input type='hidden' name='id_domanda' value='$id_domanda'>";
        echo "<input type='hidden' name='id_prodotto' value='$id_prodotto'>";
        echo "<input type='hidden' name='testo' value='$testoElement'>";
        echo '<button class="done" type="submit" name="action" value="Approva"><span id="done" class="material-symbols-outlined">done</span></button>';
        echo '<button class="done" type="submit" name="action" value="Rifiuta"><span id="done" class="material-symbols-outlined">close</span></button> ';
        echo '</form>';
        echo '</td>';
        echo '</tr>';
    }
}

echo '</tbody>';
echo '</table>';

// Verifica il flag per determinare se ci sono richieste pendenti
if (!$hasPendingRequests) {
    echo '<p class="titolo">Nessuna segnalazione attualmente in sospeso.</p>';
}    
echo '</div>';
} 
elseif($segnalazione->getAttribute('id_risposta')){
    
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

    if ($status == 'pending') {
        $hasPendingRequests = true;

        $rispostaElement = $segnalazione->getElementsByTagName('testo_risposta')->item(0)->nodeValue;
        $testoElement = $segnalazione->getElementsByTagName('testo_segnalazione')->item(0)->nodeValue;
        $id_risposta = $segnalazione->getAttribute('id_risposta');
        $id_prodotto = $segnalazione->getAttribute('id_prodotto');


        echo '<tr>';
        echo "<td>$rispostaElement</td>";
        echo "<td>$testoElement</td>";
        echo '<td>';
        echo '<form action="approva_segnalazione.php" method="post">';
        echo "<input type='hidden' name='risposta' value='$rispostaElement'>";
        echo "<input type='hidden' name='id_risposta' value='$id_risposta'>";
        echo "<input type='hidden' name='id_prodotto' value='$id_prodotto'>";
        echo "<input type='hidden' name='testo' value='$testoElement'>";
        echo '<button class="done" type="submit" name="action" value="Approva"><span id="done" class="material-symbols-outlined">done</span></button>';
        echo '<button class="done" type="submit" name="action" value="Rifiuta"><span id="done" class="material-symbols-outlined">close</span></button> ';
        echo '</form>';
        echo '</td>';
        echo '</tr>';
    }
}

echo '</tbody>';
echo '</table>';

// Verifica il flag per determinare se ci sono richieste pendenti
if (!$hasPendingRequests) {
    echo '<p class="titolo">Nessuna segnalazione attualmente in sospeso.</p>';
}    
echo '</div>';
}
?>

</body>
</html>