<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lascia una Recensione</title>
    <link rel="stylesheet" href="../css/style_catalogo.css"> <!-- Sostituisci con il percorso corretto al tuo file CSS -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
</head>
<body>

    <?php
        require_once('../res/connection.php');
session_start();
    // Verifica se è stato fornito un ID del prodotto nella query string
    if (isset($_GET['id_prodotto'])) {
        $id_prodotto = $_GET['id_prodotto'];
        $nome_prodotto = $_GET['nome'];
        $email_utente = $_SESSION['email'];
        $tipologia = $_GET['tipologia'];
        $id_utente = $_GET ['id'];
        ?>
        <div class="home">
    <a href="catalogo_utente_<?php echo $tipologia; ?>.php">             
        <span id="casa" class="material-symbols-outlined">home</span>
    </a>
</div>


<form class="rew" method="post" action="recensioni_prodotti.php">
    <input type="hidden" name="id" value="<?php echo $id_utente; ?>">
    <input type="hidden" name="id_prodotto" value="<?php echo $id_prodotto; ?>">
    <input type="hidden" name="tipologia" value="<?php echo $tipologia; ?>">
    <input type="hidden" name="autore" value="<?php echo $email_utente; ?>">
    <input type="hidden" name="orario_recensione" value="<?php echo date('H:i:s'); ?>">
    <input type="hidden" name="data_recensione" value="<?php echo date('Y-m-d'); ?>">
    <div class="rec">
        <label for="recensione">Lascia una recensione per: <?php echo $nome_prodotto; ?>:</label>
    </div>
    <textarea class="text" name="recensione" rows="4" cols="50" required></textarea>
      <div class="send">
        <input class="button" type="submit" value="Lascia Recensione">
    </div>
</form>

        <?php
    } else {
        echo 'ID del prodotto mancante.';
    }
    ?>
    <?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifica se sono stati inviati dati del modulo
    if (isset($_POST['id_prodotto'], $_POST['autore'], $_POST['recensione'])) {
        $id_prodotto = $_POST['id_prodotto'];
        $id_utente = 0;
        $autore = $_POST['autore'];
        $recensione = $_POST['recensione'];
        $data = $_POST['data_recensione'];
        $ora = $_POST['orario_recensione'];
        $tipologia = $_POST['tipologia'];
        $id_recensione = uniqid();
        $utilita=0;
        $supporto=0;

        

        // Carica il file XML del catalogo
        $xmlFile = '../xml/catalogo_prodotti.xml';
        $dom = new DOMDocument();
        $dom->load($xmlFile);

        // Trova il prodotto nel file XML
        $xpath = new DOMXPath($dom);
        $prodottoNode = $xpath->query("//prodotto[id_prodotto=$id_prodotto]")->item(0);

        // Verifica se il nodo del prodotto esiste prima di procedere
        if ($prodottoNode) {
            // Crea o trova l'elemento 'recensioni'
            $recensioniNode = $prodottoNode->getElementsByTagName('recensioni')->item(0);
            if (!$recensioniNode) {
                $recensioniNode = $dom->createElement('recensioni');
                $prodottoNode->appendChild($recensioniNode);
            }

            // Crea l'elemento 'recensione'
            $recensioneNode = $dom->createElement('recensione');

            
            $recensioneNode->setAttribute('id_prodotto', $id_prodotto);


            // Aggiungi gli elementi 'autore', 'testo' e 'data e ora' all'elemento 'recensione'
            $autoreNode = $dom->createElement('autore', $autore);
            $testoNode = $dom->createElement('testo', $recensione);
            $dataNode = $dom->createElement('data', $data);
            $oraNode = $dom->createElement('ora', $ora);
            $idRecensioneNode = $dom->createElement('id_recensione', $id_recensione);           
            
            $utilitaNode = $dom->createElement('utilita');
            $supportoNode = $dom->createElement('supporto');

            $utilitaNode->setAttribute('id_utente', $id_utente);
            $utilitaNode->appendChild($dom->createElement('valore', $utilita));
            
            $supportoNode->setAttribute('id_utente', $id_utente);
            $supportoNode->appendChild($dom->createElement('valore', $supporto));
            

            $recensioneNode->appendChild($autoreNode);
            $recensioneNode->appendChild($testoNode);
            $recensioneNode->appendChild($dataNode);
            $recensioneNode->appendChild($oraNode);
            $recensioneNode->appendChild($idRecensioneNode);
            $recensioneNode->appendChild($utilitaNode);
            $recensioneNode->appendChild($supportoNode);


            // Aggiungi l'elemento 'recensione' all'elemento 'recensioni'
            $recensioniNode->appendChild($recensioneNode);

            // Salva il file XML aggiornato
            $dom->save($xmlFile);

            echo 'Recensione salvata con successo.';
            header("Location: recensione_ok.php?tipologia=" . $tipologia);
        } else {
            echo 'Prodotto non trovato.';
        }
    } else {
        echo 'Dati del modulo mancanti.';
    }
}
?>


</body>
</html>