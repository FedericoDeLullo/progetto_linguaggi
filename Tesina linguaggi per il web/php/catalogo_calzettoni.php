<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Catalogo Prodotti</title>
        <link rel="stylesheet" href="../css/style_catalogo.css">
        <link rel="stylesheet" href="../css/style_search.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
        <link rel="stylesheet" href="../css/style_header.css">
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <?php
        include('../res/header.php');
        include('../res/funzioni.php');

        ?>
    </head>
    <body>
        <div class="cont">
            <div class="container">
                <a class="btn" href="catalogo_magliette.php">Magliette</a>
                <a class="btn" href="catalogo_pantaloncini.php">Pantaloncini</a>
                <a class="btn" href="catalogo_calzettoni.php">Calzettoni</a>
            </div>
            <table>
                <tr>
                    <td>
                        <input type="text" class="search-input" placeholder="Cerca...">
                        <button class="btn_stilizzato"><span class="material-symbols-outlined">search</span></button>
                    </td>
                    <td>
                        <label class="scritta" for="ordina">Ordina per:</label>
                        <select id="ordina"> 
                            <option value="nomeCrescente">(A-Z)</option>
                            <option value="nomeDecrescente">(Z-A)</option>                            
                            <option value="prezzoCrescente">Prezzo crescente</option>
                            <option value="prezzoDecrescente">Prezzo decrescente</option>
                        </select>
                    </td>
                </tr>
            </table>
            <?php
            require_once('../res/connection.php');
            if(isset($_SESSION['id'])){
                $id_utente = $_SESSION['id'];
            }

            // Inizializza la variabile booleana per verificare se ci sono prodotti di tipo 'calzettoni'
            $calzettoniPresenti = false;

            $ordinaPer = isset($_GET['ordina']) ? $_GET['ordina'] : 'nome';

            // Leggi il file XML del catalogo
            $xmlFile = '../xml/catalogo_prodotti.xml'; 
            $dom = new DOMDocument();
            $dom->load($xmlFile);

            // Ottieni la lista di prodotti
            $prodotti = $dom->getElementsByTagName('prodotto');

            // Converte la NodeList in un array per semplificare l'ordinamento
            $prodottiArray = iterator_to_array($prodotti);

            // Definisci una funzione di confronto per l'ordinamento
            function compare($a, $b) {
                global $ordinaPer;

                $valueA = $a->getElementsByTagName($ordinaPer)->item(0)->nodeValue;
                $valueB = $b->getElementsByTagName($ordinaPer)->item(0)->nodeValue;

                return strnatcasecmp($valueA, $valueB); // Ordinamento insensibile alle maiuscole
            }

            // Ordina l'array di prodotti
            usort($prodottiArray, 'compare');

            // Itera attraverso i prodotti e stampali
            foreach ($prodottiArray as $prodotto) {
                $nome = $prodotto->getElementsByTagName('nome')->item(0)->nodeValue;
                $descrizione = $prodotto->getElementsByTagName('descrizione')->item(0)->nodeValue;
                $prezzo = $prodotto->getElementsByTagName('prezzo')->item(0)->nodeValue;
                $immagine = $prodotto->getElementsByTagName('immagine')->item(0)->nodeValue;
                $id_prodotto = $prodotto->getElementsByTagName('id_prodotto')->item(0)->nodeValue;
                $sconto_generico = $prodotto->getElementsByTagName('sconto_generico')->item(0)->nodeValue;
                $bonus = $prodotto->getElementsByTagName('bonus')->item(0)->nodeValue;



                // Aggiunta: verifica la tipologia
                $tipologia = $prodotto->getElementsByTagName('tipologia')->item(0)->nodeValue;
                if ($tipologia !== 'calzettoni') {
                    continue; // Salta il prodotto se la tipologia non è 'maglietta'
                }

                // Imposta la variabile booleana a true se almeno un prodotto è di tipo 'calzettoni'
                $calzettoniPresenti = true;
                
                // Stampa le informazioni del prodotto
                echo '<div class="prodotto">';
                echo '<h1 class="nome">';
                require_once('../res/connection.php');
                if(isset($_SESSION['loggato'])){
                    $gestore = $_SESSION['gestore'];
                    $admin = $_SESSION['ammin'];
                    $utente = $_SESSION['utente'];
                    echo $nome;
                  if($gestore == 1){
                     echo '</h1>';
                    echo '<table class="table">';
                        echo '<tr>';
                        echo '<td>';
                        echo '<a class="btn1"style="margin-left:10vw;" title="Lista delle domande" href="domande.php?id_prodotto=' . $id_prodotto . '&nome=' . $nome .'&tipologia='. $tipologia .'&id='. $id_utente .'">Lista delle domande</a>';
                        echo '<a class="btn1"style="margin-left:10vw;" title="Lascia una domanda" href="domande_prodotti.php?id_prodotto=' . $id_prodotto . '&nome=' . $nome .'&tipologia='. $tipologia .'&id='. $id_utente .'">Scrivi una domanda</a>';
                        echo '<a class="btn1"style="margin-left:10vw;"  title="Lascia una recensione" href="recensione_cliente.php?id_prodotto=' . $id_prodotto . '&nome=' . $nome .'&tipologia='. $tipologia .'&id='. $id_utente .'">Scrivi una recensione</a>';
                        echo '<a class="btn1" style="margin-left:10vw;"title="Lista delle recensioni" href="lista_recensioni.php?id_prodotto=' . $id_prodotto . '&nome=' . $nome .'&tipologia='. $tipologia .'&id='. $id_utente .'">Lista delle recensioni</a>';
                        echo '<a class="btn1" style="margin-left:10vw;" href="modifica_prodotti_form.php?id_prodotto=' . $id_prodotto . '&tipologia=' . $tipologia . '">Modifica prodotto</a>';
                        echo '<a class="btn1" style="margin-left:10vw;" href="aggiungi_sconto_form.php?id_prodotto=' . $id_prodotto . '&tipologia=' . $tipologia . '">Aggiungi Sconto</a>';
                       echo '</td>';
                            echo '<td class="td">';
                                  echo '<div class="box">';
                                    echo '<img class="img" src="' . $immagine . '" alt="' . $nome . '">';
                                echo '</div>';
                            echo '</td>';
                            echo '<td class="td">';
                                echo '<p class="des">' . $descrizione . '</p>';
                                $xmlPath = "../xml/catalogo_prodotti.xml";

                                if(isset($_SESSION['loggato']) && $_SESSION['loggato'] == true){
                                    $prezzoScontato = calcolaScontoProdotto($xmlPath, $id_prodotto, $prezzo);
                                }
        
                                if(isset($_SESSION['sconto_parametrico']) && $_SESSION['sconto_parametrico'] == true){
                                    echo "<p id='successo'>Sconti Aggiuntivi Attivati</p>";
                                    unset($_SESSION['sconto_parametrico']);
                                }
                                echo '<table>';
                                    echo '<tr>';
                                        echo '<td>';
                                            echo "<div class='tooltip'>";
                                                echo "<span class='tooltiptext'>";
                                                    echo "<ul>";
                                                        echo "<li>Prezzo Base: $prezzo €</li>";
                                                        echo "<li>Bonus Crediti: $bonus €</li>";
                                                        echo "<li>Sconto Generico: " . $sconto_generico . " %</li>";
                                                    echo "</ul>";
                                                echo "</span>";
                                                echo "<i id='simbolo' class='material-symbols-outlined'>info</i>";
                                            echo "</div>";
                                        echo '</td>';
                                        echo '<td>';
                                            echo "<p class = 'prezzo'>Prezzo Finale: " . $prezzoScontato . " €</p>";
                                        echo '</td>';
                                    echo '</tr>';
                                echo '</table>';
                        echo "</div>";
                                echo '<div class="linea">';
                                echo '<form action="catalogo_' . $tipologia . '.php" method="post">';
                                echo '<input type="hidden" name="id_prodotto" value="' . $id_prodotto . '">';
                                echo '<input type="hidden" name="nome" value="' . $nome . '">';
                                echo '<input type="hidden" name="prezzo" value="' . $prezzo . '">';
                                echo '<input type="hidden" name="bonus" value="' . $bonus . '">';
                                echo '<input type="hidden" name="tipologia" value="' . $tipologia . '">';

                                echo '<input type="hidden" name="prezzoScontato" value="' . $prezzoScontato . '">';
                                echo ' <input class="input" type="number" name="quantita" value="0" min="1" step="1" size="3" max="99" />';
                                echo '<button style="border:none; background:none; cursor:pointer;" type="submit" name="azione" value="aggiungi_al_carrello"><span id="cart" class="material-symbols-outlined">add_shopping_cart</span></button>';
                                echo '</form>';
                                echo '</div>';                  
                                echo '</tr>';
                    echo '</table>';
                    echo '</div>';
                } elseif($utente == 1 || $admin == 1){
                    echo '</h1>';
                    echo '<table class="table">';
                        echo '<tr>';
                        echo '<td>';
                        echo '<a class="btn1"style="margin-left:10vw;" title="Lista delle domande" href="domande.php?id_prodotto=' . $id_prodotto . '&nome=' . $nome .'&tipologia='. $tipologia .'&id='. $id_utente .'">Lista delle domande</a>';
                        echo '<a class="btn1"style="margin-left:10vw;" title="Lascia una domanda" href="domande_prodotti.php?id_prodotto=' . $id_prodotto . '&nome=' . $nome .'&tipologia='. $tipologia .'&id='. $id_utente .'">Scrivi una domanda</a>';
                        echo '<a class="btn1"style="margin-left:10vw;"  title="Lascia una recensione" href="recensione_cliente.php?id_prodotto=' . $id_prodotto . '&nome=' . $nome .'&tipologia='. $tipologia .'&id='. $id_utente .'">Scrivi una recensione</a>';
                        echo '<a class="btn1" style="margin-left:10vw;"title="Lista delle recensioni" href="lista_recensioni.php?id_prodotto=' . $id_prodotto . '&nome=' . $nome .'&tipologia='. $tipologia .'&id='. $id_utente .'">Lista delle recensioni</a>';
                        if ($admin == 1) {
                            echo '<a class="btn1" style="margin-left:10vw;" href="aggiungi_sconto_form.php?id_prodotto=' . $id_prodotto . '&tipologia=' . $tipologia . '">Aggiungi Sconto</a>';
                        }
                        echo '</td>';
                            echo '<td class="td">';
                                  echo '<div class="box">';
                                    echo '<img class="img" src="' . $immagine . '" alt="' . $nome . '">';
                                echo '</div>';
                            echo '</td>';
                            echo '<td class="td">';
                                echo '<p class="des">' . $descrizione . '</p>';
                                $xmlPath = "../xml/catalogo_prodotti.xml";

                                if(isset($_SESSION['loggato']) && $_SESSION['loggato'] == true){
                                    $prezzoScontato = calcolaScontoProdotto($xmlPath, $id_prodotto, $prezzo);
                                }
        
                                if(isset($_SESSION['sconto_parametrico']) && $_SESSION['sconto_parametrico'] = true){
                                    echo "<p id='successo'>Sconti Aggiuntivi Attivati</p>";
                                    unset($_SESSION['sconto_parametrico']);
                                }
                                echo '<table>';
                                    echo '<tr>';
                                        echo '<td>';
                                            echo "<div class='tooltip'>";
                                                echo "<span class='tooltiptext'>";
                                                    echo "<ul>";
                                                        echo "<li>Prezzo Base: $prezzo €</li>";
                                                        echo "<li>Bonus Crediti: $bonus €</li>";
                                                        echo "<li>Sconto Generico: " . $sconto_generico . " %</li>";
                                                    echo "</ul>";
                                                echo "</span>";
                                                echo "<i id='simbolo' class='material-symbols-outlined'>info</i>";
                                            echo "</div>";
                                        echo '</td>';
                                        echo '<td>';
                                            echo "<p class = 'prezzo'>Prezzo Finale: " . $prezzoScontato . " €</p>";
                                        echo '</td>';
                                    echo '</tr>';
                                echo '</table>';
                        echo "</div>";
                                echo '<div class="linea">';
                                echo '<form action="catalogo_' . $tipologia . '.php" method="post">';
                                echo '<input type="hidden" name="id_prodotto" value="' . $id_prodotto . '">';
                        echo '<input type="hidden" name="nome" value="' . $nome . '">';
                        echo '<input type="hidden" name="bonus" value="' . $bonus . '">';
                        echo '<input type="hidden" name="tipologia" value="' . $tipologia . '">';

                        echo '<input type="hidden" name="prezzo" value="' . $prezzo . '">';
                        echo '<input type="hidden" name="prezzoScontato" value="' . $prezzoScontato . '">';
                        echo ' <input class="input" type="number" name="quantita" value="0" min="1" step="1" size="3" max="99" />';
                        echo '<button style="border:none; background:none; cursor:pointer;" type="submit" name="azione" value="aggiungi_al_carrello"><span id="cart" class="material-symbols-outlined">add_shopping_cart</span></button>';
                        echo '</form>';
                        echo '</div>';                  
                                echo '</tr>';
                    echo '</table>';
                    echo '</div>';
                } 



            }else{
                    echo $nome;
                     echo '</h1>';
                echo '<table class="table">';
                    echo '<tr>';
                        echo '<td class="td">';
                            echo '<div class="box">';
                                echo '<img class="img" src="' . $immagine . '" alt="' . $nome . '">';
                            echo '</div>';
                        echo '</td>';
                        echo '<td class="td">';
                            echo '<p class="des">' . $descrizione . '</p>';
                            echo '<p class="prezzo">Prezzo: ' . $prezzo . '€</p>';
                            echo '<a href="#"><span id="cart" class="material-symbols-outlined">add_shopping_cart</span></a>';
                    echo '</tr>';
                echo '</table>';
                echo '</div>';
        }
                }

                if (!$calzettoniPresenti) {
                    echo '<h3 class="titolo">il catalogo dei calzettoni è vuoto :(</h3>';
                }

            ?>
                <?php if (isset($_POST['azione']) && $_POST['azione'] === 'aggiungi_al_carrello') {
                        $id_prodotto = $_POST['id_prodotto'];
                        $nome = $_POST['nome'];
                        $prezzo = $_POST['prezzo'];
                        $prezzoScontato = $_POST['prezzoScontato'];
                        $quantita = $_POST['quantita'];
                        $bonus = $_POST['bonus'];

                        // Inizializza o ottieni il carrello dalla sessione
                        if (!isset($_SESSION['carrello'])) {
                            $_SESSION['carrello'] = array();
                        }
                    
                        // Aggiungi il prodotto al carrello
                        $_SESSION['carrello'][] = array(
                            'id_prodotto' => $id_prodotto,
                            'nome' => $nome,
                            'prezzo' => $prezzo,
                            'bonus' => $bonus,
                            'quantita' => $quantita,
                            'prezzoScontato' => $prezzoScontato,
                        );
                    }
                    ?>  
                 <script>
    // Quando il documento è caricato
    $(document).ready(function() {
        // Associo un'azione al bottone di ricerca "btn_stilizzato"
        $('.btn_stilizzato').on('click', function() {
            var searchText = $('.search-input').val().toLowerCase();

            $('.prodotto').each(function() {
                var titolo = $(this).find('.nome').text().toLowerCase();

                if (titolo.indexOf(searchText) !== -1) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });

        // Associo un'azione alla barra di ricerca quando scrivo qualcosa sulla tastiera
        $('.search-input').on('keyup', function() {
            var searchText = $(this).val().toLowerCase();

            $('.prodotto').each(function() {
                var titolo = $(this).find('.nome').text().toLowerCase();

                if (titolo.indexOf(searchText) !== -1) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });

        // Ordino i prodotti in base alla richiesta
       
        $('#ordina').on('change', function() {
    var selectedOption = $(this).val();

    if (selectedOption === 'prezzoCrescente' || selectedOption === 'prezzoDecrescente' || 
        selectedOption === 'nomeCrescente' || selectedOption === 'nomeDecrescente') {
        // Se l'opzione selezionata è prezzo o nome, ordina direttamente lato client
        var prodottiArray = $('.prodotto').toArray();

        prodottiArray.sort(function(a, b) {
            if (selectedOption.includes('prezzo')) {
                var prezzoA = parseFloat($(a).find('.prezzo').text().replace('Prezzo Finale: ', '').replace('€', '').trim());
                var prezzoB = parseFloat($(b).find('.prezzo').text().replace('Prezzo Finale: ', '').replace('€', '').trim());

                // Controlla se il prezzo è scontato
                if ($(a).find('.prezzoScontato').length > 0) {
                    prezzoA = parseFloat($(a).find('.prezzoScontato').text().replace('Prezzo Finale: ', '').replace('€', '').trim());
                }
                if ($(b).find('.prezzoScontato').length > 0) {
                    prezzoB = parseFloat($(b).find('.prezzoScontato').text().replace('Prezzo Finale: ', '').replace('€', '').trim());
                }

                return selectedOption === 'prezzoCrescente' ? prezzoA - prezzoB : prezzoB - prezzoA;
            } else if (selectedOption.includes('nome')) {
                var nomeA = $(a).find('.nome').text().toLowerCase();
                var nomeB = $(b).find('.nome').text().toLowerCase();

                return selectedOption === 'nomeCrescente' ? nomeA.localeCompare(nomeB) : nomeB.localeCompare(nomeA);
            }
        });

        // Rimuovi tutti i prodotti attualmente visualizzati
        $('.prodotto').remove();

        // Itera attraverso i prodotti ordinati e stampali
        for (var i = 0; i < prodottiArray.length; i++) {
            $('.cont').append(prodottiArray[i]);
        }
    } else {
        // Se l'opzione selezionata non è prezzo o nome, gestisci l'ordinamento lato server con il normale ricaricamento della pagina
        window.location.href = 'catalogo_calzettoni.php?ordina=' + selectedOption;
    }
});
    });
</script>
        </div>
    </body>
    </html>