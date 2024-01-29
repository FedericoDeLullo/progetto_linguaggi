<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catalogo Prodotti</title>
    <link rel="stylesheet" href="../css/style_catalogo.css">
    <link rel="stylesheet" href="../css/style_search.css">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>
<body>
    <div class="home">
        <a href="index_gestore.php">
            <div class="home_link" title="home"><span id="home" class="material-symbols-outlined">home</span></div>
        </a>
    </div>
    <input type="text" class="search-input" placeholder="Cerca...">
    <button class="search-button"><span id="search" class="material-symbols-outlined">search</span></button>

    <label class="scritta" for="ordina">Ordina per:</label>
    <select id="ordina">
        <option value="nome">Nome</option>
        <option value="prezzo">Prezzo</option>
        <!-- Altre opzioni di ordinamento se necessario -->
    </select>
    <button id="filter"><span class="material-symbols-outlined">check</span></button>

    <?php
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

        echo '<div class="prodotto">';
        echo '<h2 class="nome">' . $nome . '<a href="modifica_prodotti_form.php?id_prodotto=' . $id_prodotto . '"><span id="simbolo_recensione" class="material-symbols-outlined">edit</span></a></h2>';
        echo '<p class="des">' . $descrizione . '</p>';
        echo '<p class="prezzo">Prezzo: ' . $prezzo . '€</p>';
        echo '<div class="box">';
        echo '<img class="img" src="' . $immagine . '" alt="' . $nome . '">';
        echo '</div>';
        echo '<a href="../php/carrello.php"><span id="cart" class="material-symbols-outlined">add_shopping_cart</span></a>';
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
            $('#filter').on('click', function() {
                var selectedOption = $('#ordina').val();
                window.location.href = 'catalogo_gestore.php?ordina=' + selectedOption;
            });
        });
    </script>
</body>
</html>