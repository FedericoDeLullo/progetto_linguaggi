<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=
    , initial-scale=1.0">
    <title>Gestione Utenti</title>
    <link rel="stylesheet" href="../css/style_standard.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="../css/style_header.css">
    <?php
        include('../res/header.php');
    ?>
</head>
<body>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $userId = $_POST['id'];
    $email = $_POST['email'];
    $xmlFile = '../xml/storico_acquisti.xml'; 
    $dom = new DOMDocument();
    
    $dom->load($xmlFile);

    $acquisti = $dom->getElementsByTagName('acquisto');

    // Verifica se ci sono acquisti per l'utente specificato
    $acquistiUtente = [];
    foreach ($acquisti as $acquisto) {
        $idUtente = $acquisto->getAttribute('id_utente');

        if ($idUtente == $userId) {
            $acquistiUtente[] = $acquisto;
        }
    }

   

    if (count($acquistiUtente) > 0) { 
        echo '<h1 class="titolo">Storico Acquisti per l\'utente ID: ' . $email . '</h1>';
        echo '<table border="1">';
        echo '<tr>';
        echo '<th>ID Prodotto</th>';
        echo '<th>Nome Prodotto</th>';
        echo '<th>Prezzo Unitario</th>';
        echo '<th>Quantità</th>';
        echo '<th>Prezzo Totale</th>';
        echo '<th>Bonus Crediti</th>';
        echo '<th>Data Acquisto</th>';
        echo '<th>Ora Acquisto</th>';
        echo '</tr>';

        foreach ($acquistiUtente as $acquisto) {
            $idProdotto = $acquisto->getElementsByTagName('id_prodotto')->item(0)->nodeValue;
            $nome = $acquisto->getElementsByTagName('nome')->item(0)->nodeValue;
            $prezzoUnitario = $acquisto->getElementsByTagName('prezzo_unitario')->item(0)->nodeValue;
            $quantita = $acquisto->getElementsByTagName('quantita')->item(0)->nodeValue;
            $prezzoTotale = $acquisto->getElementsByTagName('prezzo_totale')->item(0)->nodeValue;
            $bonus = $acquisto->getElementsByTagName('bonus')->item(0)->nodeValue;
            $data = $acquisto->getElementsByTagName('data')->item(0)->nodeValue;
            $ora = $acquisto->getElementsByTagName('ora')->item(0)->nodeValue;

            echo '<tr>';
            echo '<td>' . $idProdotto . '</td>';
            echo '<td>' . $nome . '</td>';
            echo '<td>' . $prezzoUnitario . '€</td>';
            echo '<td>' . $quantita . '</td>';
            echo '<td>' . $prezzoTotale . '€</td>';
            echo '<td>' . $bonus . '€</td>';
            echo '<td>' . $data . '</td>';
            echo '<td>' . $ora . '</td>';
            echo '</tr>';
        }

        echo '</table>';
    } else {
        echo '<h2 class="titolo">Nessun acquisto presente per l\'utente: ' . $email . '</h2>';
    }
} else {
    echo 'ID utente non specificato.';
}
?>

</body>
</html>