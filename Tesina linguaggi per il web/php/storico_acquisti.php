<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../css/style_standard.css">
    <link rel="stylesheet" href="../css/style_menu.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="../css/style_header.css">
    <?php
        include('../res/header.php');
    ?>
</head>
<body>
<?php

if (isset($_SESSION['id'])) {
    $xmlPath = '../xml/storico_acquisti.xml';

    if (file_exists($xmlPath)) {
        $dom = new DomDocument;
        $dom->load($xmlPath);

        $id_utente_sessione = $_SESSION['id'];
        $email = $_SESSION['email'];
        $contatore = 0;

        echo '<h1 class="titolo">Storico Acquisti: ' . $email . '</h1>';
        echo '<table border="1">';
        echo '<tr>';
        echo '<th>Nome Prodotto</th>';
        echo '<th>Prezzo Unitario</th>';
        echo '<th>Quantità</th>';
        echo '<th>Prezzo Totale</th>';
        echo '<th>Bonus Crediti</th>';
        echo '<th>Data Acquisto</th>';
        echo '<th>Ora Acquisto</th>';
        echo '</tr>';

        foreach ($dom->getElementsByTagName('acquisto') as $acquisto) {
            $id_utente_acquisto = $acquisto->getAttribute('id_utente');

            if ($id_utente_acquisto == $id_utente_sessione) {
                $nome = $acquisto->getElementsByTagName('nome')->item(0)->nodeValue;
                $prezzo_unitario = $acquisto->getElementsByTagName('prezzo_unitario')->item(0)->nodeValue;
                $quantita = $acquisto->getElementsByTagName('quantita')->item(0)->nodeValue;
                $prezzo_totale = $acquisto->getElementsByTagName('prezzo_totale')->item(0)->nodeValue;
                $bonus = $acquisto->getElementsByTagName('bonus')->item(0)->nodeValue;
                $data_acquisto = $acquisto->getElementsByTagName('data')->item(0)->nodeValue;
                $ora_acquisto = $acquisto->getElementsByTagName('ora')->item(0)->nodeValue;

                echo '<tr>';
                echo '<td>' . $nome . '</td>';
                echo '<td>' . $prezzo_unitario . '€</td>';
                echo '<td>' . $quantita . '</td>';
                echo '<td>' . $prezzo_totale . '€</td>';
                echo '<td>' . $bonus . '€</td>';
                echo '<td>' . $data_acquisto . '</td>';
                echo '<td>' . $ora_acquisto . '</td>';
                echo '</tr>';
                $contatore++;
            }
        }
        echo '</table>';
        if ($contatore == 0) {
            echo '<p class="titolo">Non hai effettuato acquisti per il momento...</p>';
        }
    } else {
        echo '<p>Il file storico_acquisti.xml non esiste ancora o è vuoto.</p>';
    }
} else {
    echo '<p>Utente non autenticato.</p>';
}
?>
</body>
</html>