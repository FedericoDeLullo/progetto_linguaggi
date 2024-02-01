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
        ?>
    </head>
<?php
require_once('../res/connection.php');
if(isset($_SESSION['loggato'])){   

    ?>

    <body>
        <div class="cont">
            <div class="container">
                <a class="btn" href="catalogo_magliette.php">Magliette</a>
                <a class="btn" href="catalogo_pantaloncini.php">Pantaloncini</a>
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
                            <option value="nome">Nome</option>
                            <option value="prezzo">Prezzo</option>
                        </select>
                        <button class="btn_stilizzato"><span class="material-symbols-outlined">check</span></button>
                    </td>
                </tr>
            </table>
        <?php
        require_once('../res/connection.php');
        if(isset($_SESSION['id'])){
            $id_utente = $_SESSION['id'];
        }

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

            // Aggiunta: verifica la tipologia
            $tipologia = $prodotto->getElementsByTagName('tipologia')->item(0)->nodeValue;
            if ($tipologia !== 'calzettoni') {
                continue; // Salta il prodotto se la tipologia non è 'maglietta'
            }
            
            // Stampa le informazioni del prodotto
            echo '<div class="prodotto">';
            echo '<h1 class="nome">';
                echo '<a title="Lista delle domande" href="domande.php?id_prodotto=' . $id_prodotto . '&nome=' . $nome .'&tipologia='. $tipologia .'&id='. $id_utente .'"><span id="simbolo_recensione" class="material-symbols-outlined">question_mark</span></a>';
                echo '<a title="Lascia una domanda" href="domande_prodotti.php?id_prodotto=' . $id_prodotto . '&nome=' . $nome .'&tipologia='. $tipologia .'&id='. $id_utente .'"><span id="simbolo_recensione" class="material-symbols-outlined">rate_review</span></a>';
                echo $nome;
                echo '<a title="Lascia una recensione" href="recensione_cliente.php?id_prodotto=' . $id_prodotto . '&nome=' . $nome .'&tipologia='. $tipologia .'&id='. $id_utente .'"><span id="simbolo_recensione" class="material-symbols-outlined">note_stack_add</span></a>';
                echo '<a title="Lista delle recensioni" href="lista_recensioni.php?id_prodotto=' . $id_prodotto . '&nome=' . $nome .'&tipologia='. $tipologia .'&id='. $id_utente .'"><span id="simbolo_recensione" class="material-symbols-outlined">reviews</span></a>';
            echo '</h1>';
            echo '<table class="table">';
                echo '<tr>';
                    echo '<td class="td">';
                        echo '<div class="box">';
                            echo '<a href="domande_prodotti.php?id_prodotto=' . $id_prodotto . '&nome=' . urlencode($nome) . '&tipologia=' . urlencode($tipologia) . '&id=' . $id_utente . '">';
                            echo '<img src="' . $immagine . '" alt="' . $nome . '">';
                        echo '</div>';
                    echo '</td>';
                    echo '<td class="td">';
                        echo '<p class="des">' . $descrizione . '</p>';
                        echo '<p class="prezzo">Prezzo: ' . $prezzo . '€</p>';
                        echo '<a href="../php/carrello.php"><span id="cart" class="material-symbols-outlined">add_shopping_cart</span></a>';
                echo '</tr>';
            echo '</table>';
            echo '</div>';
        }
        ?>
            <script>
                // Quando il documento è caricato
                $(document).ready(function() {
                    // Associo un'azione al bottone di ricerca "search-button"
                    $('.search-button').on('click', function() {
                        var searchText = $('.search-input').val().toLowerCase();

                        $('.prodotto').each(function() {
                            var titolo = $(this).find('.nome1').text().toLowerCase();

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
                            var titolo = $(this).find('.nome1').text().toLowerCase();

                            if (titolo.indexOf(searchText) !== -1) {
                                $(this).show();
                            } else {
                                $(this).hide();
                            }
                        });
                    });

                    // Ordino i prodotti in base alla richiesta
                    $('#filter').on('click', function() {
                        var selectedOption = $('#ordina').val();
                        window.location.href = 'catalogo_calzettoni.php?ordina=' + selectedOption;
                    });
                });
            </script>
        </div>
    </body>
    </html>
    <?php
} 
else {
    ?>
    <body>
        <div class="cont">
            <div class="container">
                <a class="btn" href="catalogo_magliette.php">Magliette</a>
                <a class="btn" href="catalogo_pantaloncini.php">Pantaloncini</a>
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
                            <option value="nome">Nome</option>
                            <option value="prezzo">Prezzo</option>
                        </select>
                        <button class="btn_stilizzato"><span class="material-symbols-outlined">check</span></button>
                    </td>
                </tr>
            </table>
        <?php
        require_once('../res/connection.php');
        if(isset($_SESSION['id'])){
            $id_utente = $_SESSION['id'];
        }
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

            // Aggiunta: verifica la tipologia
            $tipologia = $prodotto->getElementsByTagName('tipologia')->item(0)->nodeValue;
            if ($tipologia !== 'calzettoni') {
                continue; // Salta il prodotto se la tipologia non è 'maglietta'
            }
            
            // Stampa le informazioni del prodotto
            echo '<div class="prodotto">';
            echo '<h1 class="nome">' . $nome . '</h1>';
            echo '<p class="des">' . $descrizione . '</p>';
            echo '<p class="prezzo">Prezzo: ' . $prezzo . '€</p>';
            echo '<div class="box">';
            echo '<img class="img" src="' . $immagine . '" alt="' . $nome . '">';
            echo '</div>';
            echo '<a href="login_menu.php"><span id="cart" class="material-symbols-outlined">add_shopping_cart</span></a>';
            echo '</div>';
        }
        ?>
            <script>
                // Quando il documento è caricato
                $(document).ready(function() {
                    // Associo un'azione al bottone di ricerca "search-button"
                    $('.search-button').on('click', function() {
                        var searchText = $('.search-input').val().toLowerCase();

                        $('.prodotto').each(function() {
                            var titolo = $(this).find('.nome1').text().toLowerCase();

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
                            var titolo = $(this).find('.nome1').text().toLowerCase();

                            if (titolo.indexOf(searchText) !== -1) {
                                $(this).show();
                            } else {
                                $(this).hide();
                            }
                        });
                    });

                    // Ordino i prodotti in base alla richiesta
                    $('#filter').on('click', function() {
                        var selectedOption = $('#ordina').val();
                        window.location.href = 'catalogo_calzettoni.php?ordina=' + selectedOption;
                    });
                });
            </script>
        </div>
    </body>
    </html>
<?php
}
?>