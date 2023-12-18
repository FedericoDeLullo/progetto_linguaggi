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
        <a href="../html/index_loggato.html">
            <div class="home_link" title="home">
                <span id="home" class="material-symbols-outlined">home</span>
            </div>
        </a>
    </div>
    
    <a class="maglie" href="catalogo_utente_magliette.php">Magliette</a>
    <a class="calze" href="catalogo_utente_calzettoni.php">Calzettoni</a>

    <input type="text" class="search-input" placeholder="Cerca..."></input>
    <button class="search-button"><span id="search" class="material-symbols-outlined">search</span></button>

    <label class="ordina" for="ordina">Ordina per:</label>
    <select id="ordina">
        <option value="nome">Nome</option>
        <option value="prezzo">Prezzo</option>
        <!-- Altre opzioni di ordinamento se necessario -->
    </select>
    <button id="filter"><span class="material-symbols-outlined">
check
</span></button>

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

    // Aggiunta: verifica la tipologia
    $tipologia = $prodotto->getElementsByTagName('tipologia')->item(0)->nodeValue;
    if ($tipologia !== 'pantaloncini') {
        continue; // Salta il prodotto se la tipologia non è 'maglietta'
    }
    
    // Stampa le informazioni del prodotto
    echo '<div class="prodotto">';
    echo '<h2 class="nome1">
    <a title="Fai una domanda" href="domande_prodotti.php?id_prodotto=' . $id_prodotto . '&nome=' . $nome .'&tipologia='. $tipologia .'&id=' . $id_utente .'"><span id="help" class="material-symbols-outlined">help</span></a>
    <a title="Fai una domanda" href="domande.php?id_prodotto=' . $id_prodotto . '&nome=' . $nome .'&tipologia='. $tipologia .'&id=' . $id_utente .'"><span id="q" class="material-symbols-outlined">live_help</span></a>' . $nome . '<a title="Lascia una recensione" href="recensioni_prodotti.php?id_prodotto=' . $id_prodotto . '&nome=' . $nome .'&tipologia='. $tipologia .'&id=' . $id_utente .'"><span id="rev" class="material-symbols-outlined">note_stack_add</span></a>
    <a title="Recensioni prodotto" href="recensioni.php?id_prodotto=' . $id_prodotto . '&nome=' . $nome .'&tipologia='. $tipologia .'&id=' . $id_utente .'"><span id="add" class="material-symbols-outlined">reviews</span></a>
    </h2>';
    echo '<p class="des1">' . $descrizione . '</p>';
    echo '<p class="prezzo1">Prezzo: ' . $prezzo . '€</p>';
    echo '<div class="box1">';
    echo '<img class="img1" src="' . $immagine . '" alt="' . $nome . '">';
    echo '</div>';
    echo '<a href="../php/carrello.php"><span id="cart1" class="material-symbols-outlined">add_shopping_cart</span></a>';
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
                window.location.href = 'catalogo_utente_pantaloncini.php?ordina=' + selectedOption;
            });
        });
    </script>
</body>
</html>
