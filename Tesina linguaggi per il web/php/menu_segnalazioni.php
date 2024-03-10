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
    // Controlla se l'utente è un amministratore
    require_once('../res/connection.php');

    if (!isset($_SESSION['id'])) {
        // Reindirizza l'utente alla pagina di accesso se non è loggato
        header("Location: login_cliente.php");
        exit();
    }

    // Controlla se l'utente è un amministratore
    $id_utente = $_SESSION['id'];
    $sql_select = "SELECT gestore FROM utenti WHERE id = '$id_utente' AND gestore = 1";

    if ($result = $connessione->query($sql_select)) {
        if ($result->num_rows === 1) {
            if(isset($_SESSION['domanda_gia_rimossa']) && $_SESSION['domanda_gia_rimossa'] == 'true'){
                echo '<h2>Domanda già rimossa!!!</h2>';
                unset($_SESSION['domanda_gia_rimossa']);
                unset($_SESSION['risposta_gia_rimossa']);
                unset($_SESSION['recensione_gia_rimossa']);
                unset($_SESSION['successo_domanda']);
                unset($_SESSION['domanda_gia_rimossa']);
                unset($_SESSION['successo_risposta']);
                unset($_SESSION['successo_recensione']);
                unset($_SESSION['segnalazione_rifiutata']);
            }
            elseif(isset($_SESSION['risposta_gia_rimossa']) && $_SESSION['risposta_gia_rimossa'] == 'true'){
                echo '<h2>Risposta già rimossa!!!</h2>';
                unset($_SESSION['domanda_gia_rimossa']);
                unset($_SESSION['risposta_gia_rimossa']);
                unset($_SESSION['recensione_gia_rimossa']);
                unset($_SESSION['successo_domanda']);
                unset($_SESSION['domanda_gia_rimossa']);
                unset($_SESSION['successo_risposta']);
                unset($_SESSION['successo_recensione']);
                unset($_SESSION['segnalazione_rifiutata']);    }
            elseif(isset($_SESSION['recensione_gia_rimossa']) && $_SESSION['recensione_gia_rimossa'] == 'true'){
                echo '<h2>Recensione già rimossa!!!</h2>';
                unset($_SESSION['domanda_gia_rimossa']);
                unset($_SESSION['risposta_gia_rimossa']);
                unset($_SESSION['recensione_gia_rimossa']);
                unset($_SESSION['successo_domanda']);
                unset($_SESSION['domanda_gia_rimossa']);
                unset($_SESSION['successo_risposta']);
                unset($_SESSION['successo_recensione']);
                unset($_SESSION['segnalazione_rifiutata']);
            }
            elseif(isset($_SESSION['successo_domanda']) && $_SESSION['successo_domanda'] == 'true'){
                echo '<h2 id="successo">Domanda rimossa con successo!!!</h2>';
                unset($_SESSION['domanda_gia_rimossa']);
                unset($_SESSION['risposta_gia_rimossa']);
                unset($_SESSION['recensione_gia_rimossa']);
                unset($_SESSION['successo_domanda']);
                unset($_SESSION['domanda_gia_rimossa']);
                unset($_SESSION['successo_risposta']);
                unset($_SESSION['successo_recensione']);
                unset($_SESSION['segnalazione_rifiutata']);    }
            elseif(isset($_SESSION['domanda_gia_rimossa']) && $_SESSION['domanda_gia_rimossa'] == 'true'){
                echo '<h2>La domanda relativa alla risposta segnalata è già stata rimossa!!!</h2>';
                unset($_SESSION['domanda_gia_rimossa']);
                unset($_SESSION['risposta_gia_rimossa']);
                unset($_SESSION['recensione_gia_rimossa']);
                unset($_SESSION['successo_domanda']);
                unset($_SESSION['domanda_gia_rimossa']);
                unset($_SESSION['successo_risposta']);
                unset($_SESSION['successo_recensione']);
                unset($_SESSION['segnalazione_rifiutata']);    }
            elseif(isset($_SESSION['successo_risposta']) && $_SESSION['successo_risposta'] == 'true'){
                echo '<h2 id="successo">Risposta rimossa con successo!!!</h2>';
                unset($_SESSION['domanda_gia_rimossa']);
                unset($_SESSION['risposta_gia_rimossa']);
                unset($_SESSION['recensione_gia_rimossa']);
                unset($_SESSION['successo_domanda']);
                unset($_SESSION['domanda_gia_rimossa']);
                unset($_SESSION['successo_risposta']);
                unset($_SESSION['successo_recensione']);
                unset($_SESSION['segnalazione_rifiutata']);    }
            elseif(isset($_SESSION['successo_recensione']) && $_SESSION['successo_recensione'] == 'true'){
                echo '<h2 id="successo">Recensione rimossa con successo!!!</h2>';
                unset($_SESSION['domanda_gia_rimossa']);
                unset($_SESSION['risposta_gia_rimossa']);
                unset($_SESSION['recensione_gia_rimossa']);
                unset($_SESSION['successo_domanda']);
                unset($_SESSION['domanda_gia_rimossa']);
                unset($_SESSION['successo_risposta']);
                unset($_SESSION['successo_recensione']);
                unset($_SESSION['segnalazione_rifiutata']);    }
            elseif(isset($_SESSION['segnalazione_rifiutata']) && $_SESSION['segnalazione_rifiutata'] == 'true'){
                echo '<h2 id="successo">Segnalazione rifiutata con successo!!!</h2>';
                unset($_SESSION['domanda_gia_rimossa']);
                unset($_SESSION['risposta_gia_rimossa']);
                unset($_SESSION['recensione_gia_rimossa']);
                unset($_SESSION['successo_domanda']);
                unset($_SESSION['domanda_gia_rimossa']);
                unset($_SESSION['successo_risposta']);
                unset($_SESSION['successo_recensione']);
                unset($_SESSION['segnalazione_rifiutata']);    }

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
            echo '<th>Autore Segnalazione</th>';
            echo '<th>Post Segnalato</th>';
            echo '<th>Autore Post Segnalato</th>';
            echo '<th>Segnalazione</th>';
            echo '<th>Azione</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';

            foreach ($segnalazioni as $segnalazione) {

                $segnalatore = $segnalazione->getAttribute('autore_segnalazione');
                $status = $segnalazione->getAttribute('status');
                $id_domanda = $segnalazione->getAttribute('id_domanda');
                $id_risposta = $segnalazione->getAttribute('id_risposta');
                $id_recensione = $segnalazione->getAttribute('id_recensione');
                $id_prodotto = $segnalazione->getAttribute('id_prodotto');

                if ($status == 'In Attesa') {
                    $hasPendingRequests = true;

                

                    if ($id_domanda && !$id_risposta && !$id_recensione) {
                        // Stampa solo la domanda
                        $id_prodotto = $segnalazione->getAttribute('id_prodotto');

                        $domandaElement = $segnalazione->getElementsByTagName('testo_domanda')->item(0)->nodeValue;
                        $testoElementDom = $segnalazione->getElementsByTagName('testo_segnalazione_dom')->item(0)->nodeValue;
                        $autore_dom = $segnalazione->getElementsByTagName('autoreDomanda')->item(0)->nodeValue;



                        echo '<tr>';
                        echo "<td>$segnalatore</td>";
                        echo "<td>$domandaElement</td>";
                        echo "<td>$autore_dom</td>";
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
                    } elseif (!$id_domanda && $id_risposta && !$id_recensione) {
                        // Stampa solo la risposta
                        $rispostaElement = $segnalazione->getElementsByTagName('testo_risposta')->item(0)->nodeValue;
                        $testoElementRis = $segnalazione->getElementsByTagName('testo_segnalazione_ris')->item(0)->nodeValue;
                        $id_prodotto = $segnalazione->getAttribute('id_prodotto');
                        $autore_risp = $segnalazione->getElementsByTagName('autoreRisposta')->item(0)->nodeValue;
                        $id_domanda_elem = $segnalazione->getElementsByTagName('id_domanda')->item(0)->nodeValue;


                        echo '<tr>';
                        echo "<td>$segnalatore</td>";
                        echo "<td>$rispostaElement</td>";
                        echo "<td>$autore_risp</td>";
                        echo "<td>$testoElementRis</td>"; 
                        echo '<td>';
                        echo '<form action="approva_segnalazione.php" method="post">';
                        echo "<input type='hidden' name='risposta' value='$rispostaElement'>";
                        echo "<input type='hidden' name='id_risposta' value='$id_risposta'>";
                        echo "<input type='hidden' name='id_domanda_elem' value='$id_domanda_elem'>";
                        echo "<input type='hidden' name='id_prodotto' value='$id_prodotto'>";
                        echo "<input type='hidden' name='testo_ris' value='$testoElementRis'>";
                        echo '<button class="done" type="submit" name="action" value="Approva"><span id="done" class="material-symbols-outlined">done</span></button>';
                        echo '<button class="done" type="submit" name="action" value="Rifiuta"><span id="done" class="material-symbols-outlined">close</span></button> ';
                        echo '</form>';            
                        echo '</td>';
                        echo '</tr>';
                    } elseif ($id_domanda && $id_risposta && !$id_recensione) {
                        // Stampa sia domanda che risposta
                        $id_prodotto = $segnalazione->getAttribute('id_prodotto');
                        $domandaElement = $segnalazione->getElementsByTagName('testo_domanda')->item(0)->nodeValue;
                        $rispostaElement = $segnalazione->getElementsByTagName('testo_risposta')->item(0)->nodeValue;
                        $testoElementRis = $segnalazione->getElementsByTagName('testo_segnalazione_ris')->item(0)->nodeValue;
                        $testoElementDom = $segnalazione->getElementsByTagName('testo_segnalazione_dom')->item(0)->nodeValue;
                        $id_domanda_elem = $segnalazione->getElementsByTagName('id_domanda')->item(0)->nodeValue;


                        echo '<tr>';
                        echo "<td>$segnalatore</td>";
                        echo "<td>$domandaElement</td>";
                        echo "<td>$rispostaElement</td>";
                        echo '<td>';
                        echo '<form action="approva_segnalazione.php" method="post">';
                        echo "<input type='hidden' name='risposta' value='$rispostaElement'>";
                        echo "<input type='hidden' name='id_risposta' value='$id_risposta'>";
                        echo "<input type='hidden' name='domanda' value='$domandaElement'>";
                        echo "<input type='hidden' name='id_domanda' value='$id_domanda'>";
                        echo "<input type='hidden' name='id_domanda_elem' value='$id_domanda_elem'>";
                        echo "<input type='hidden' name='id_prodotto' value='$id_prodotto'>";
                        echo "<input type='hidden' name='testo_dom' value='$testoElementDom'>";
                        echo "<input type='hidden' name='testo_ris' value='$testoElementRis'>";
                        echo '<button class="done" type="submit" name="action" value="Approva"><span id="done" class="material-symbols-outlined">done</span></button>';
                        echo '<button class="done" type="submit" name="action" value="Rifiuta"><span id="done" class="material-symbols-outlined">close</span></button> ';
                        echo '</form>';            
                        echo '</td>';
                        echo '</tr>';
                    } elseif(!$id_domanda && !$id_risposta && $id_recensione){
                        $id_prodotto = $segnalazione->getAttribute('id_prodotto');
                        $recensioneElement = $segnalazione->getElementsByTagName('testo')->item(0)->nodeValue;
                        $testoElementRec = $segnalazione->getElementsByTagName('testo_segnalazione_rec')->item(0)->nodeValue;
                        $autore_rec = $segnalazione->getElementsByTagName('autore')->item(0)->nodeValue;



                        echo '<tr>';
                        echo "<td>$segnalatore</td>";
                        echo "<td>$recensioneElement</td>";
                        echo "<td>$autore_rec</td>";
                        echo "<td>$testoElementRec</td>";
                        echo '<td>';
                        echo '<form action="approva_segnalazione.php" method="post">';
                        echo "<input type='hidden' name='recensione' value='$recensioneElement'>";
                        echo "<input type='hidden' name='id_recensione' value='$id_recensione'>";
                        echo "<input type='hidden' name='id_prodotto' value='$id_prodotto'>";
                        echo "<input type='hidden' name='testo_rec' value='$testoElementRec'>";
                        echo '<button class="done" type="submit" name="action" value="Approva"><span id="done" class="material-symbols-outlined">done</span></button>';
                        echo '<button class="done" type="submit" name="action" value="Rifiuta"><span id="done" class="material-symbols-outlined">close</span></button> ';
                        echo '</form>';            
                        echo '</td>';
                        echo '</tr>';
                    }elseif($id_domanda && !$id_risposta && $id_recensione){
                        $id_prodotto = $segnalazione->getAttribute('id_prodotto');
                        $domandaElement = $segnalazione->getElementsByTagName('testo_domanda')->item(0)->nodeValue;
                        $recensioneElement = $segnalazione->getElementsByTagName('testo')->item(0)->nodeValue;
                        $testoElementRec = $segnalazione->getElementsByTagName('testo_segnalazione_rec')->item(0)->nodeValue;
                        $testoElementDom = $segnalazione->getElementsByTagName('testo_segnalazione_dom')->item(0)->nodeValue;


                        echo '<tr>';
                        echo "<td>$segnalatore</td>";
                        echo "<td>$domandaElement</td>";
                        echo "<td>$recensioneElement</td>";
                        echo '<td>';
                        echo '<form action="approva_segnalazione.php" method="post">';
                        echo "<input type='hidden' name='recensione' value='$recensioneElement'>";
                        echo "<input type='hidden' name='id_recensione' value='$id_recensione'>";
                        echo "<input type='hidden' name='domanda' value='$domandaElement'>";
                        echo "<input type='hidden' name='id_domanda' value='$id_domanda'>";
                        echo "<input type='hidden' name='id_prodotto' value='$id_prodotto'>";
                        echo "<input type='hidden' name='testo_dom' value='$testoElementDom'>";
                        echo "<input type='hidden' name='testo' value='$testoElementRec'>";
                        echo '<button class="done" type="submit" name="action" value="Approva"><span id="done" class="material-symbols-outlined">done</span></button>';
                        echo '<button class="done" type="submit" name="action" value="Rifiuta"><span id="done" class="material-symbols-outlined">close</span></button> ';
                        echo '</form>';            
                        echo '</td>';
                        echo '</tr>';
                    }elseif(!$id_domanda && $id_risposta && $id_recensione){
                        $id_prodotto = $segnalazione->getAttribute('id_prodotto');
                        $recensioneElement = $segnalazione->getElementsByTagName('testo')->item(0)->nodeValue;
                        $rispostaElement = $segnalazione->getElementsByTagName('testo_risposta')->item(0)->nodeValue;
                        $testoElementRis = $segnalazione->getElementsByTagName('testo_segnalazione_ris')->item(0)->nodeValue;
                        $testoElementRec = $segnalazione->getElementsByTagName('testo_segnalazione_rec')->item(0)->nodeValue;
                        $id_domanda_elem = $segnalazione->getElementsByTagName('id_domanda')->item(0)->nodeValue;


                        echo '<tr>';
                        echo "<td>$segnalatore</td>";
                        echo "<td>$recensioneElement</td>";
                        echo "<td>$rispostaElement</td>";
                        echo '<td>';
                        echo '<form action="approva_segnalazione.php" method="post">';
                        echo "<input type='hidden' name='risposta' value='$rispostaElement'>";
                        echo "<input type='hidden' name='id_risposta' value='$id_risposta'>";
                        echo "<input type='hidden' name='recensione' value='$recensioneElement'>";
                        echo "<input type='hidden' name='id_recensione' value='$id_recensione'>";
                        echo "<input type='hidden' name='id_domanda_elem' value='$id_domanda_elem'>";
                        echo "<input type='hidden' name='id_prodotto' value='$id_prodotto'>";
                        echo "<input type='hidden' name='testo' value='$testoElementRec'>";
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
        } else {
            // Se l'utente non è un amministratore, reindirizzalo a una pagina di accesso negato
            header("Location: accesso_negato.php");
            exit();
        }
    } else {
        echo "Errore nella query: " . $connessione->error;
    }
    ?>
</body>
</html>