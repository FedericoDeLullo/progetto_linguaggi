        <?php
        session_start();
        // Verifica che il form sia stato inviato
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $id_prodotto = $_POST['id_prodotto'];
            $tipologia = $_POST['tipologia'];
            // Percorso del file XML
            $xmlFile = '../xml/catalogo_prodotti.xml';

            
            // Carica il file XML
            $dom = new DOMDocument();
            $dom->preserveWhiteSpace = false;

            $dom->load($xmlFile);

            // Identifica il prodotto da modificare
            $prodottoDaModificare = null;
            foreach ($dom->getElementsByTagName('prodotto') as $prodotto) {
                $nomeNode = $prodotto->getElementsByTagName('nome')->item(0);
                $nomeEsistente = $nomeNode->nodeValue;
        
                // Verifica se il nome è già presente
                if ($_POST['nome'] == $nomeEsistente && $_SESSION['nome_prodotto_attuale'] != $nomeEsistente) {
                    $_SESSION['errore_nome_esistente'] = 'true';
                    header("Location: ../php/modifica_prodotti_form.php?id_prodotto=$id_prodotto");
                    exit(); // Esce dal ciclo se il nome è già presente
                }else{
                $id = (int)$prodotto->getElementsByTagName('id_prodotto')->item(0)->nodeValue;
                if ($id == $_POST['id_prodotto']) {
                    $prodottoDaModificare = $prodotto;
                    break;
                  } 
                 }
            }

            // Verifica se il prodotto è stato trovato
            if ($prodottoDaModificare) {
                // Modifica le caratteristiche del prodotto
                $prodottoDaModificare->getElementsByTagName('nome')->item(0)->nodeValue = $_POST['nome'];
                $prodottoDaModificare->getElementsByTagName('descrizione')->item(0)->nodeValue = $_POST['descrizione'];
                $prodottoDaModificare->getElementsByTagName('prezzo')->item(0)->nodeValue = $_POST['prezzo'];
            
                // Gestione dell'immagine solo se è stato caricato un nuovo file
                if (!empty($_FILES['immagine']['name'])) {
                    $immaginePath = '../img/' . basename($_FILES['immagine']['name']);
            
                    // Verifica che il file sia un'immagine valida con getimagesize
                    $immagineInfo = @getimagesize($_FILES['immagine']['tmp_name']);
                    if ($immagineInfo !== false) {
                        // Rimuovi l'immagine esistente (se presente)
                        $immagineNode = $prodottoDaModificare->getElementsByTagName('immagine')->item(0);
                        if ($immagineNode) {
                            $prodottoDaModificare->removeChild($immagineNode);
                        }
            
                        // Aggiungi l'immagine nuova
                        $newImmagineNode = $dom->createElement('immagine', $immaginePath);
                        $prodottoDaModificare->appendChild($newImmagineNode);
            
                    } else {
                        // Messaggio di errore se il file non è un'immagine valida
                        $_SESSION['errore_immagine'] = 'true';
                        header("Location: ../php/modifica_prodotti_form.php?id_prodotto=$id_prodotto");
                        exit();
                    }
                }
                $dom->normalizeDocument();
                $dom->formatOutput = true; 
                // Salva le modifiche
                $dom->save($xmlFile);
                header('Location: catalogo_' . $tipologia . '.php');
                exit();
            }
             else {
                echo '<p class="error">Prodotto non trovato.</p>';
            }
        }

        ?>