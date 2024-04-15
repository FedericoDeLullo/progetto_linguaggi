        <?php
        session_start();
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $id_prodotto = $_POST['id_prodotto'];
            $tipologia = $_POST['tipologia'];
            // Percorso del file XML
            $xmlFile = '../xml/catalogo_prodotti.xml';

            
            // Carica il file XML
            $dom = new DOMDocument();
            $dom->preserveWhiteSpace = false;

            $dom->load($xmlFile);

            $prodottoDaModificare = null;
            foreach ($dom->getElementsByTagName('prodotto') as $prodotto) {
                $nomeNode = $prodotto->getElementsByTagName('nome')->item(0);
                $nomeEsistente = $nomeNode->nodeValue;
        
                if ($_POST['nome'] == $nomeEsistente && $_SESSION['nome_prodotto_attuale'] != $nomeEsistente) {
                    $_SESSION['errore_nome_esistente'] = 'true';
                    header("Location: ../php/modifica_prodotti_form.php?id_prodotto=$id_prodotto");
                    exit();
                }else{
                $id = (int)$prodotto->getElementsByTagName('id_prodotto')->item(0)->nodeValue;
                if ($id == $_POST['id_prodotto']) {
                    $prodottoDaModificare = $prodotto;
                    break;
                  } 
                 }
            }

            if ($prodottoDaModificare) {
                $prodottoDaModificare->getElementsByTagName('nome')->item(0)->nodeValue = $_POST['nome'];
                $prodottoDaModificare->getElementsByTagName('descrizione')->item(0)->nodeValue = $_POST['descrizione'];
                $prodottoDaModificare->getElementsByTagName('prezzo')->item(0)->nodeValue = $_POST['prezzo'];
            
                if (!empty($_FILES['immagine']['name'])) {
                    $immaginePath = '../img/' . basename($_FILES['immagine']['name']);
            
                    $immagineInfo = @getimagesize($_FILES['immagine']['tmp_name']);
                    if ($immagineInfo !== false) {
                        $immagineNode = $prodottoDaModificare->getElementsByTagName('immagine')->item(0);
                        if ($immagineNode) {
                            $prodottoDaModificare->removeChild($immagineNode);
                        }
            
                        $newImmagineNode = $dom->createElement('immagine', $immaginePath);
                        $prodottoDaModificare->appendChild($newImmagineNode);
            
                    } else {
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