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
        include('../res/funzioni.php');
        require_once('../res/connection.php');  
    ?>
</head>
<body>
<div class="cont">

<?php
$carrello = isset($_SESSION['carrello']) ? $_SESSION['carrello'] : array();

// Verifica se l'azione è "aggiungi_al_carrello"
if (isset($_POST['azione']) && $_POST['azione'] === 'aggiungi_al_carrello') {
    $id_prodotto = $_POST['id_prodotto'];
    $nome = $_POST['nome'];
    $prezzo = $_POST['prezzo'];
    $prezzoScontato = $_POST['prezzoScontato'];
    $quantita = $_POST['quantita'];
    $id_utente = $_SESSION['id'];
    $bonus = $_POST['bonus'];

    // Aggiungi il prodotto al carrello
    $carrello[] = array(
        'id_prodotto' => $id_prodotto,
        'nome' => $nome,
        'bonus' => $bonus,
        'prezzo' => $prezzo,
        'quantita' => $quantita,
        'prezzoScontato' => $prezzoScontato,
    );
    $_SESSION['carrello'] = $carrello;
}

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
        $bonusDaAggiungere = calcolaBonusAcquisto();
        foreach ($_SESSION['carrello'] as $prodotto_carrello) {
            if(isset($prodotto_carrello['prezzoScontato'])){
            $totale_acquisto += $prodotto_carrello['prezzoScontato'] * $prodotto_carrello['quantita'];
        }
    else{
        $totale_acquisto += $prodotto_carrello['prezzo'] * $prodotto_carrello['quantita'];

    }
    
    }

    if ($_SESSION['crediti'] >= $totale_acquisto) {
        // Sottrai i crediti dal totale dell'acquisto
        $_SESSION['crediti'] = $_SESSION['crediti'] - $totale_acquisto + $bonusDaAggiungere;
    
        // Aggiorna i crediti nella tabella degli utenti
        $queryUpdateCrediti = "UPDATE utenti SET crediti = {$_SESSION['crediti']} WHERE id = {$_SESSION['id']}";
        $resultUpdateCrediti = mysqli_query($connessione, $queryUpdateCrediti);

            if (!empty($_SESSION['carrello'])) {
                $xmlPath = '../xml/storico_acquisti.xml';
        
                // Carica il documento XML esistente se presente, altrimenti crea uno nuovo
                $dom = new DomDocument('1.0', 'UTF-8');
                if (file_exists($xmlPath)) {
                    $dom->load($xmlPath);
                } else {
                    // Crea l'elemento radice "storico_acquisti" se il file non esiste
                    $storico_acquisti = $dom->createElement('storico_acquisti');
                    $dom->appendChild($storico_acquisti);
                }
        
                foreach ($_SESSION['carrello'] as $prodotto_carrello) {
                    // Crea l'elemento "acquisto" per ogni prodotto nel carrello
                    $acquisto = $dom->createElement('acquisto');

                    // Aggiungi l'id utente come attributo all'elemento "acquisto"
                    $acquisto->setAttribute('id_utente', $_SESSION['id']);
                
                    // Aggiungi data e ora come elementi figli
                    $acquisto->appendChild($dom->createElement('data', date('Y-m-d')));
                    $acquisto->appendChild($dom->createElement('ora', date('H:i:s')));
                
                    // Aggiungi gli altri dettagli del prodotto
                    $acquisto->appendChild($dom->createElement('id_prodotto', $prodotto_carrello['id_prodotto']));
                    $acquisto->appendChild($dom->createElement('nome', $prodotto_carrello['nome']));
                    $acquisto->appendChild($dom->createElement('prezzo_unitario', $prodotto_carrello['prezzo']));
                    $acquisto->appendChild($dom->createElement('quantita', $prodotto_carrello['quantita']));
                    $acquisto->appendChild($dom->createElement('prezzo_scontato', $prodotto_carrello['prezzoScontato']));

                    // Calcola e aggiungi il prezzo totale come elemento separato
                    $prezzo_totale = $prodotto_carrello['prezzoScontato'] * $prodotto_carrello['quantita'];
                    $acquisto->appendChild($dom->createElement('prezzo_totale', $prezzo_totale));
                
                    // Aggiungi l'elemento "acquisto" all'elemento radice "storico_acquisti"
                    $dom->documentElement->appendChild($acquisto);
                }
        
                // Salva il DOM nel file storico_acquisti.xml
                $dom->save($xmlPath);
          
            // Svuota il carrello dopo l'acquisto
            unset($_SESSION['carrello']);

            $query = "UPDATE utenti SET crediti = $crediti_utente WHERE id = '$id_utente'";
            $result = mysqli_query($connessione, $query);

            if (!$result) {
                printf("Errore nella query.\n");
                exit();
            }

            echo '<p>Acquisto confermato!</p>';
        } 
    }else {
            echo '<p>Non hai abbastanza crediti per effettuare l\'acquisto.</p>';
        }
}}
?>
    <h1 class="titolo">Il Tuo Carrello</h1>

<?php

// Verifica se il carrello contiene prodotti
if (!empty($carrello)) {
    echo '<table>';
    echo '<tr>';
    echo '<th>Prodotto</th>';
    echo '<th>Quantità</th>';
    echo '<th>Prezzo Unitario</th>';
    echo '<th>Prezzo Scontato</th>';
    echo '<th>Prezzo Totale</th>';
    echo '<th>Bonus Totale</th>';
    echo '<th>Azioni</th>';
    echo '</tr>';
    
    foreach ($_SESSION['carrello'] as $index => $prodotto_carrello) {
        echo '<tr>';
        echo '<td>' . $prodotto_carrello['nome'] . '</td>';
        echo '<td>' . (isset($prodotto_carrello['quantita']) ? $prodotto_carrello['quantita'] : 'N/A') . '</td>';
        echo '<td>' . $prodotto_carrello['prezzo'] . '€</td>';  // Prezzo unitario
    
        // Check if 'prezzoScontato' key is set before accessing its value
        echo '<td>' . (isset($prodotto_carrello['prezzoScontato']) ? $prodotto_carrello['prezzoScontato'] . '€' : 'N/A') . '</td>';
    
        echo '<td>';
    
        $prezzoTotale = isset($prodotto_carrello['prezzoScontato']) && isset($prodotto_carrello['quantita'])
            ? $prodotto_carrello['prezzoScontato'] * $prodotto_carrello['quantita']
            : 'N/A';
    
        echo $prezzoTotale . '€</td>';
        echo '<td>';
        
        // Aggiunta della cella per il Bonus Totale
        $bonusTotale = isset($prodotto_carrello['bonus']) && isset($prodotto_carrello['quantita'])
            ? $prodotto_carrello['bonus'] * $prodotto_carrello['quantita']
            : 'N/A';
        echo $bonusTotale . '</td>';

        echo '<td>';
        echo '<form action="cart.php" method="post">';
        echo '<input type="hidden" name="index" value="' . $index . '">';
        echo '<button type="submit" name="azione" value="rimuovi_prodotto">Rimuovi Prodotto<span class="material-symbols-outlined">
        delete
        </span></button>';
        echo '</form>';
        echo '<form action="cart.php" method="post">';
        echo '<input type="hidden" name="index" value="' . $index . '">';
        echo '<input class="input" type="number" name="nuova_quantita" value="' . $prodotto_carrello['quantita'] . '" min="1">';
        echo '<button type="submit" name="azione" value="modifica_quantita">Modifica Quantità</button>';
        echo '</form>';
        echo '</td>';
        echo '</tr>';
    }
    
    // Aggiungi riga per i crediti e l'indirizzo
    echo '<tr>';
    echo '<td colspan="5">Crediti disponibili: ' . $_SESSION['crediti'] . '€</td>';
    echo '</tr>';
    echo '<tr>';
    echo '<td colspan="5">Indirizzo di Consegna: <input class="input" type="text" id="indirizzo_consegna" name="indirizzo_consegna" value="' . ($_SESSION['indirizzo'] ?? '') . '"></td>';
    echo '</tr>';
    
    echo '</table>';
    
    echo '<form action="cart.php" method="post" style="display: flex; justify-content: space-between; margin-top: 5vh;">';
    echo '<button style="margin-bottom:10px;" class="btn" type="submit" name="azione" value="svuota_carrello">Svuota Carrello</button>';
    echo '<button style="margin-bottom:10px;" class="btn" type="submit" name="azione" value="conferma_acquisto">Conferma Acquisto</button>';
    echo '</form>';
    
} else {
    echo '<p style="margin-top: 50px;" class="titolo">Il carrello è vuoto.</p>';
}
?>
</div>
</body>
</html>
