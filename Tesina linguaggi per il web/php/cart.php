<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Il tuo carrello</title>
    <link rel="stylesheet" href="../css/style_standard.css">
    <link rel="stylesheet" href="../css/style_catalogo.css">
    <link rel="stylesheet" href="../css/style_search.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="../css/style_header.css">
    <?php
        include('../res/header.php');
    ?>
</head>
<body>
<div class="cont">

<?php

// Verifica se l'azione è "aggiungi_al_carrello"
if (isset($_POST['azione']) && $_POST['azione'] === 'aggiungi_al_carrello') {
    $id_prodotto = $_POST['id_prodotto'];
    $nome = $_POST['nome'];
    $prezzo = $_POST['prezzo'];
    $quantita = $_POST['quantita'];
    $id_utente = $_SESSION['id'];

    // Inizializza o ottieni il carrello dalla sessione
    if (!isset($_SESSION['carrello'])) {
        $_SESSION['carrello'] = array();
    }

    // Aggiungi il prodotto al carrello
    $_SESSION['carrello'][] = array(
        'id_prodotto' => $id_prodotto,
        'nome' => $nome,
        'prezzo' => $prezzo,
        'quantita' => $quantita,
    );
}

// Pagina di visualizzazione del carrello
?>

<?php
// Gestisci le azioni di rimuovere il prodotto o modificare la quantità

if (isset($_POST['azione'])) {
    if ($_POST['azione'] === 'svuota_carrello') {
        // Azione per svuotare il carrello
        unset($_SESSION['carrello']);
    } elseif ($_POST['azione'] === 'rimuovi_prodotto') {
        // Azione per rimuovere singolarmente un prodotto
        $index = $_POST['index'];
        if (isset($_SESSION['carrello'][$index])) {
            unset($_SESSION['carrello'][$index]);
            $_SESSION['carrello'] = array_values($_SESSION['carrello']); // Resetta gli indici dell'array
        }
    } elseif ($_POST['azione'] === 'modifica_quantita') {
        // Azione per modificare la quantità di un prodotto
        $index = $_POST['index'];
        $nuova_quantita = $_POST['nuova_quantita'];

        if (isset($_SESSION['carrello'][$index]) && $nuova_quantita >= 1) {
            $_SESSION['carrello'][$index]['quantita'] = $nuova_quantita;
        }
    } elseif (isset($_POST['azione']) && $_POST['azione'] === 'conferma_acquisto') {
        // Gestisci l'azione di conferma acquisto
        $crediti_utente = isset($_SESSION['crediti']) ? $_SESSION['crediti'] : 0;
    
        // Calcola il totale dell'acquisto
        $totale_acquisto = 0;
        $prodotti_acquistati = array();
    
        foreach ($_SESSION['carrello'] as $prodotto_carrello) {
            $totale_acquisto += $prodotto_carrello['prezzo'] * $prodotto_carrello['quantita'];
            $prodotti_acquistati[] = $prodotto_carrello;
        }
    
        // Verifica se i crediti sono sufficienti per l'acquisto
        if ($crediti_utente >= $totale_acquisto) {
            // Sottrai i crediti dal totale dell'acquisto
            $crediti_utente -= $totale_acquisto;
    
            // Aggiorna i crediti dell'utente nella sessione
            $_SESSION['crediti'] = $crediti_utente;
    
            // Salvataggio degli acquisti nel file storico_acquisti.php tramite DomDocument
            $xmlFileAcquisti = "../xml/storico_acquisti.xml";
            $docAcquisti = new DomDocument();
    
            if (file_exists($xmlFileAcquisti)) {
                $docAcquisti->load($xmlFileAcquisti);
            } else {
                $docAcquisti->appendChild($docAcquisti->createElement('acquisti'));
            }
    
            $rootAcquisti = $docAcquisti->documentElement;
    
            foreach ($prodotti_acquistati as $prodotto_acquistato) {
                $prodottoAcquistoNode = $docAcquisti->createElement('prodotto');
                $prodottoAcquistoNode->setAttribute('id_utente', $id_utente);
                $prodottoAcquistoNode->appendChild($docAcquisti->createElement('id_prodotto', $prodotto_acquistato['id_prodotto']));
                $prodottoAcquistoNode->appendChild($docAcquisti->createElement('nome', $prodotto_acquistato['nome']));
                $prodottoAcquistoNode->appendChild($docAcquisti->createElement('prezzo', $prodotto_acquistato['prezzo']));
                $prodottoAcquistoNode->appendChild($docAcquisti->createElement('quantita', $prodotto_acquistato['quantita']));
                $rootAcquisti->appendChild($prodottoAcquistoNode);
            }
    
            $docAcquisti->save($xmlFileAcquisti);
    
            // Svuota il carrello dopo l'acquisto
            unset($_SESSION['carrello']);
    
            $query = "UPDATE utenti SET crediti = $crediti_utente WHERE id = '$id_utente'";
            $result = mysqli_query($connessione, $query);
    
            if (!$result) {
                printf("Errore nella query.\n");
                exit();
            }
    
            echo '<p>Acquisto confermato!</p>';
        } else {
            echo '<p>Non hai abbastanza crediti per effettuare l\'acquisto.</p>';
        }
    }
}
?>

<?php
// Verifica se il carrello contiene prodotti
if (!empty($_SESSION['carrello'])) {
    echo '<table>';
    echo '<tr>';
    echo '<th>Prodotto</th>';
    echo '<th>Quantità</th>';
    echo '<th>Prezzo Unitario</th>';
    echo '<th>Prezzo Totale</th>';
    echo '<th>Azioni</th>';
    echo '</tr>';
  
    foreach ($_SESSION['carrello'] as $index => $prodotto_carrello) {
        echo '<tr>';
        echo '<td>' . $prodotto_carrello['nome'] . '</td>';
        echo '<td>' . (isset($prodotto_carrello['quantita']) ? $prodotto_carrello['quantita'] : 'N/A') . '</td>';
        echo '<td>' . $prodotto_carrello['prezzo'] . '€</td>';
        
        $prezzoTotale = isset($prodotto_carrello['prezzo']) && isset($prodotto_carrello['quantita'])
            ? $prodotto_carrello['prezzo'] * $prodotto_carrello['quantita']
            : 'N/A';
        
        echo '<td>' . $prezzoTotale . '€</td>';
        echo '<td>';
        echo '<form action="cart.php" method="post">';
        echo '<input type="hidden" name="index" value="' . $index . '">';
        echo '<button type="submit" name="azione" value="rimuovi_prodotto">Rimuovi Prodotto</button>';
        echo '</form>';
        echo '<form action="cart.php" method="post">';
        echo '<input type="hidden" name="index" value="' . $index . '">';
        echo '<input class="input" type="number" name="nuova_quantita" value="' . $prodotto_carrello['quantita'] . '" min="1">';
        echo '<button type="submit" name="azione" value="modifica_quantita">Modifica Quantità</button>';
        echo '</form>';
        echo '</td>';
        echo '</tr>';
    }

    echo '</table>';

    echo '<p>Crediti disponibili: ' . $_SESSION['crediti'] . '</p>';
    echo '<form action="cart.php" method="post">';
    echo '<button type="submit" name="azione" value="svuota_carrello">Svuota Carrello</button>';
    echo '<button type="submit" name="azione" value="conferma_acquisto">Conferma Acquisto</button>';
    echo '</form>';
} else {
    echo '<p>Il carrello è vuoto.</p>';
}
?>

</body>
</html>
