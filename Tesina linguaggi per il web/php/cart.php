<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Il tuo carrello</title>
    <link rel="stylesheet" href="../css/style_standard.css">
    <link rel="stylesheet" href="../css/style_search.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="../css/style_header.css">
    <?php
        include('../res/header.php');
        include('../res/funzioni.php');
    ?>
</head>
<body>
<div class="cont">

<?php        
require_once('../res/connection.php');  

$sql_select = "SELECT * FROM utenti WHERE id = '$id_utente'";
if($result = $connessione->query($sql_select)){
    if($result->num_rows === 1){
        $row = $result->fetch_array(MYSQLI_ASSOC);
    }
    $_SESSION['crediti'] = $row['crediti'];
    }

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

// Gestisci le azioni di rimuovere il prodotto o modificare la quantità
if (isset($_POST['azione'])) {
    
    if ($_POST['azione'] === 'svuota_carrello') {
        // Azione per svuotare il carrello
        unset($_SESSION['carrello']);
        unset($carrello);
    } elseif ($_POST['azione'] === 'rimuovi_prodotto') {
        // Azione per rimuovere singolarmente un prodotto
        $index = $_POST['index'];
        if (isset($carrello[$index])) {
            unset($_SESSION['carrello'][$index]);
            unset($carrello[$index]);
            $_SESSION['carrello'] = array_values($_SESSION['carrello']); // Resetta gli indici dell'array
            $carrello = array_values($carrello); // Resetta gli indici dell'array

        }
    } elseif ($_POST['azione'] === 'modifica_quantita') {
        // Azione per modificare la quantità di un prodotto
        $index = $_POST['index'];
        $nuova_quantita = $_POST['nuova_quantita'];

        if (isset($_SESSION['carrello'][$index]) && $nuova_quantita >= 1) {
            $_SESSION['carrello'][$index]['quantita'] = $nuova_quantita;
            $carrello[$index]['quantita'] = $nuova_quantita;
        }
        
    } elseif (isset($_POST['azione']) && $_POST['azione'] === 'conferma_acquisto') {
        $email = $_SESSION['email'];
    
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
                    $acquisto->appendChild($dom->createElement('bonus', $prodotto_carrello['bonus']));

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
                unset($carrello);


                if (!$result) {
                    printf("Errore nella query.\n");
                    exit();
                }
                echo '<h2 id="successo">Acquisto confermato!</h2>';
            } 
        }else {
            echo '<h2>Non hai abbastanza crediti per effettuare l\'acquisto.</h2>';
        }
    }
}
?>
    <h1 class="titolo">Il Tuo Carrello</h1>
<?php

            // Leggi il file XML del catalogo
            $xmlFile = '../xml/catalogo_prodotti.xml'; 
            $dom = new DOMDocument();
            $dom->load($xmlFile);

            // Ottieni la lista di prodotti
            $prodottiCatalogo = $dom->getElementsByTagName('prodotto');

            // Converte la NodeList in un array per semplificare l'ordinamento
            $prodottiCatalogoArray = iterator_to_array($prodottiCatalogo);

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
    echo '<th>Modifica Quantità</th>';
    echo '<th>Rimuovi Prodotto</th>';
    echo '</tr>';
    
    foreach ($carrello as $index => $prodotto_carrello) {
        // Controlla se l'id del prodotto esiste
        if (!isset($prodotto_carrello['id_prodotto'])) {
            continue; // Salta l'iterazione se l'id del prodotto non esiste
        }
        // Cerca il valore nella lista XML
        $trovato = false;
        foreach ($prodottiCatalogoArray as $prodottoCatalogo) {
            $id_prodotto = $prodottoCatalogo->getElementsByTagName('id_prodotto')->item(0)->nodeValue;
            if ($id_prodotto == $prodotto_carrello['id_prodotto']) {
                $trovato = true;
                break;
            }
        }

        // Output del risultato
        if (!$trovato) {
            echo "Il valore $id_prodotto non esiste nella lista XML di catalogo.";
            unset($_SESSION['carrello'][$index]);
            unset($carrello[$index]);
            $_SESSION['carrello'] = array_values($_SESSION['carrello']); // Resetta gli indici dell'array
            $carrello = array_values($carrello); // Resetta gli indici dell'array
            continue;
        }
        echo '<tr>';
        echo '<td>' . $prodotto_carrello['nome'] . '</td>';
        echo '<td>' . (isset($prodotto_carrello['quantita']) ? $prodotto_carrello['quantita'] : 'N/A') . '</td>';
        echo '<td>' . $prodotto_carrello['prezzo'] . '€</td>';  // Prezzo unitario
    
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
        echo $bonusTotale . '€</td>';

        echo '<td>';
        echo '<form action="cart.php" method="post">';
        echo '<input type="hidden" name="index" value="' . $index . '">';
        echo '<input class="input" style="width:50px;margin-bottom:0px;" type="number" name="nuova_quantita" value="' . $prodotto_carrello['quantita'] . '" min="1" max="99">';
        echo '<button class="done" type="submit" name="azione" value="modifica_quantita">CONFERMA<span class="material-symbols-outlined" id="done">done_outline</span></button>';
        echo '</form>';
        echo '</td>';
        echo '<td>';
        echo '<form action="cart.php" method="post">';
        echo '<input type="hidden" name="index" value="' . $index . '">';
        echo '<button class="done" type="submit" name="azione" value="rimuovi_prodotto"><span class="material-symbols-outlined" id="done">delete</span></button>';
        echo '</form>';
        echo '</td>';
        echo '</tr>';
    }
    
    echo '<tr>';
    echo '<td colspan="5">Crediti disponibili: ' . $_SESSION['crediti'] . '€</td>';
    echo '<td colspan="3">Indirizzo di Consegna: <input style="margin-bottom:0px;" class="input" type="text" name="indirizzo_consegna" value="' . ($_SESSION['indirizzo'] ?? '') . '"></td>';
    echo '</tr>';
    
    echo '</table>';
    
    echo '<form action="cart.php" method="post" style="display: flex; justify-content: space-between; margin-top: 5vh;">';
    echo '<button style="margin-bottom:10px;" class="btn" type="submit" name="azione" value="svuota_carrello">Svuota Carrello</button>';
    echo '<button style="margin-bottom:10px;" class="btn" type="submit" name="azione" value="conferma_acquisto">Acquista</button>';
    echo '</form>';
 
    } else {
    echo '<p style="margin-top: 50px;" class="titolo">Il carrello è vuoto.</p>';
    
}
?>
</div>
</body>
</html>