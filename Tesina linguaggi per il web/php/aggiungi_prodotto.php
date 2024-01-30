<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aggiungi Prodotto</title>
    <link rel="stylesheet" href="../css/style_standard.css">
    <link rel="stylesheet" href="../css/style_header.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
</head>
<body>
    
<header class="header">
    <div class="header_menu">  
        <div class="header_menu_item">
            <a href="index_gestore.php">
                <img class="logo" src="../img/logo.PNG">
                <span class="logo-text">RugbyWorld</span>
            </a>
        </div>
        <div class="header_menu_item">
            <a href="catalogo_gestore_magliette.php" class="stile">
                <div class="header_menu_link" title="Catalogo">
                    <span class="material-symbols-outlined">receipt_long</span>CATALOGO
                </div>
            </a>
        </div>
        <div class="header_menu_item">
            <a href="#" class="stile">
                <div class="header_menu_link" title="Faq">
                    <span class="material-symbols-outlined">quiz</span>FAQ
                </div>
            </a>
        </div>
        <div class="header_menu_item">
            <a href="../html/gestione_catalogo.html" class="stile">
                <div class="header_menu_link" title="Gestisci Catalogo">
                    <span class="material-symbols-outlined">folder_managed</span>GESTISCI CATALOGO
                </div>
            </a>
        </div>
        <div class="header_menu_item">
          <a href="gestione_utenti_gestore.php" class="stile">
              <div class="header_menu_link" title="Profili Clienti">
                  <span class="material-symbols-outlined">group</span>PROFILI CLIENTI
              </div>
          </a>
      </div>
        <div class="header_menu_item">
            <a href="../res/logout.php" class="stile">                   
                <div class="header_menu_link" title="Logout">
                    <span class="material-symbols-outlined">logout</span>LOGOUT
                </div>
            </a>
        </div>
        <div class="header_menu_item">
            <a href="#" class="stile">                   
                <div class="header_menu_link" title="Carrello">
                    <span class="material-symbols-outlined">shopping_cart</span>CARRELLO
                </div>
            </a>
        </div>
    </div>
</header>

<div class="cont">
<?php
// Verifica che il form sia stato inviato
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Percorso del file XML
    $xmlFile = '../xml/catalogo_prodotti.xml';

    // Verifica che tutti i campi necessari siano stati compilati
    if (isset($_POST['nome'], $_POST['descrizione'], $_POST['prezzo'], $_FILES['immagine'], $_POST['tipologia'])) {
        // Carica il file XML
        $xml = simplexml_load_file($xmlFile);

        // Trova l'ultimo ID nel catalogo
        $ultimoID = 0;
        foreach ($xml->prodotto as $prodotto) {
            $id = (int)$prodotto->id_prodotto;
            if ($id > $ultimoID) {
                $ultimoID = $id;
            }
        }

        // Calcola il prossimo ID disponibile
        $prossimoID = $ultimoID + 1;

        // Aggiungi un nuovo prodotto con l'ID incrementato
        $prodotto = $xml->addChild('prodotto');
        $prodotto->addChild('id_prodotto', $prossimoID);
        $prodotto->addChild('nome', $_POST['nome']);
        $prodotto->addChild('descrizione', $_POST['descrizione']);
        $prodotto->addChild('prezzo', $_POST['prezzo']);
        $prodotto->addChild('tipologia', $_POST['tipologia']);  // Aggiunge la tipologia

        // Gestione dell'immagine
        $immaginePath = '../img/' . basename($_FILES['immagine']['name']);

        // Verifica che l'upload dell'immagine sia avvenuto con successo
        if (move_uploaded_file($_FILES['immagine']['tmp_name'], $immaginePath)) {
            $prodotto->addChild('immagine', $immaginePath);

            // Salva le modifiche
            $xml->asXML($xmlFile);

            echo '<h1 class="titolo">Prodotto aggiunto con successo!!!</h1>';
        } 
        else{
            echo '<h1 class="titolo">Errore durante il caricamento dell\'immagine...</h1>';
        }
    } 
    else {
        echo '<h1 class="titolo">Compila tutti i campi obbligatori...</h1>';
    }
}
?>
</div>
</body>
</html>