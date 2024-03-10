<?php
session_start();
// Verifica che il form sia stato inviato
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Percorso del file XML
    $xmlFile = '../xml/catalogo_prodotti.xml';

    // Verifica che tutti i campi necessari siano stati compilati
    if (isset($_POST['nome'], $_POST['descrizione'], $_POST['prezzo'], $_FILES['immagine'], $_POST['tipologia'])) {
        // Carica il file XML
        $dom = new DOMDocument();
        $dom->preserveWhiteSpace = false;
        $dom->load($xmlFile);
    
        // Trova l'ultimo ID nel catalogo
        $ultimoID = 0;
        $prodottoList = $dom->getElementsByTagName('prodotto');
    
        // Flag per verificare se il nome è già presente
        $nomePresente = false;
    
        foreach ($prodottoList as $prodottoNode) {
            $nomeNode = $prodottoNode->getElementsByTagName('nome')->item(0);
            $nomeEsistente = $nomeNode->nodeValue;
    
            // Verifica se il nome è già presente
            if ($_POST['nome'] == $nomeEsistente) {
                $_SESSION['errore_nome_esistente'] = 'true';
                header('Location:../php/menu_aggiungi_prodotto.php');
                exit(); // Esce dal ciclo se il nome è già presente
            }else{
    
            $idNode = $prodottoNode->getElementsByTagName('id_prodotto')->item(0);
            $id = (int)$idNode->nodeValue;
            if ($id > $ultimoID) {
                $ultimoID = $id;
            }
          }
        }

        // Calcola il prossimo ID disponibile
        $prossimoID = $ultimoID + 1;

        // Aggiungi un nuovo prodotto con l'ID incrementato
        $prodotto = $dom->createElement('prodotto');
        $dom->documentElement->appendChild($prodotto);
                
        $id_prodotto = $dom->createElement('id_prodotto', $prossimoID);
        $prodotto->appendChild($id_prodotto);

        $nome = $dom->createElement('nome', $_POST['nome']);
        $prodotto->appendChild($nome);

        $descrizione = $dom->createElement('descrizione', $_POST['descrizione']);
        $prodotto->appendChild($descrizione);

        $prezzo = $dom->createElement('prezzo', $_POST['prezzo']);
        $prodotto->appendChild($prezzo);

        $tipologia = $dom->createElement('tipologia', $_POST['tipologia']);
        $prodotto->appendChild($tipologia);

        $sconto_generico = $dom->createElement('sconto_generico', '0');
        $prodotto->appendChild($sconto_generico);

        $bonus = $dom->createElement('bonus', '0');
        $prodotto->appendChild($bonus);

        $sconto = $dom->createElement('sconto');
        $prodotto->appendChild($sconto);

        $x = $dom->createElement('x', '0');
        $sconto->appendChild($x);
        $y = $dom->createElement('y', '0');
        $sconto->appendChild($y);
        $m = $dom->createElement('m', '0');
        $sconto->appendChild($m);
        $data_m = $dom->createElement('data_m', '0');
        $sconto->appendChild($data_m);
        $n = $dom->createElement('n', '0');
        $sconto->appendChild($n);
        $r = $dom->createElement('r', '0');
        $sconto->appendChild($r);
        $ha_acqu = $dom->createElement('ha_acquistato', '0');
        $sconto->appendChild($ha_acqu);
        // Gestione dell'immagine
        $immaginePath = '../img/' . basename($_FILES['immagine']['name']);

        // Verifica che l'upload dell'immagine sia avvenuto con successo
        if (move_uploaded_file($_FILES['immagine']['tmp_name'], $immaginePath)) {
            $immagineInfo = getimagesize($immaginePath);

            if ($immagineInfo !== false) {
            
            $immagine = $dom->createElement('immagine', $immaginePath);
            $prodotto->appendChild($immagine);

            $dom->normalizeDocument();
            $dom->formatOutput = true; 
            // Salva le modifiche
            $dom->save($xmlFile);

            $_SESSION['successo_aggiunta_prodotto'] = 'true';
            header("Location: ../php/menu_aggiungi_prodotto.php");
        }else{
            $_SESSION['errore_immagine'] = 'true';
            header("Location: ../php/menu_aggiungi_prodotto.php");
        }
    
    } else {
            $_SESSION['errore_immagine'] = 'true';
            header("Location: ../php/menu_aggiungi_prodotto.php");
        }
    } else {
        $_SESSION['errore_campi_vuoti'] = 'true';
        header("Location: ../php/menu_aggiungi_prodotto.php");
    }
}
?>