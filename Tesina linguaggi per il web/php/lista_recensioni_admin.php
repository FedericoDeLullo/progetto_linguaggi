<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista Recensioni</title>
    <link rel="stylesheet" href="../css/style_standard.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="../css/style_header.css">
</head>
<body>

<header class="header">
    <div class="header_menu">  
        <div class="header_menu_item">
            <a href="index_admin.php">
                <img class="logo" src="../img/logo.PNG">
                <span class="logo-text">RugbyWorld</span>
            </a>
        </div>
        <div class="header_menu_item">
            <a href="../php/catalogo_admin_magliette.php" class="stile">
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
            <a href="menu_richieste_crediti.php" class="stile">
                <div class="header_menu_link" title="Accetta Crediti">
                    <?php
                    if ($hasPendingRequests) {
                        echo '<span id="note" class="material-symbols-outlined">
                        notifications_unread
                        </span>';
                    }
                    else { 
                    ?>
                        <span class="material-symbols-outlined">notifications_unread</span>
                    <?php }?>ACCETTA CREDITI
                </div>
            </a>
        </div>
        <div class="header_menu_item">
          <a href="gestione_utenti.php" class="stile">
              <div class="header_menu_link" title="Gestione Utenti">
                  <span class="material-symbols-outlined">manage_accounts</span>GESTIONE UTENTI
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
session_start(); // Assicurati di iniziare la sessione se non lo hai già fatto

if (isset($_GET['tipologia']) && isset($_GET['id_prodotto'])) {
    $tipologia = $_GET['tipologia'];
    $id_prodotto = $_GET['id_prodotto'];
    $nome = $_GET['nome'];
    $id_utente = $_SESSION['id']; // Assumi che l'id utente sia memorizzato in una sessione
}

$xmlFile = '../xml/catalogo_prodotti.xml';
$dom = new DOMDocument();
$dom->load($xmlFile);

// Trova tutti gli elementi 'recensione' nel file XML relativi all'id_prodotto desiderato
$xpath = new DOMXPath($dom);
$recensioni = $xpath->query("//recensione[@id_prodotto='$id_prodotto']");

// Mostra le recensioni in una tabella
if ($recensioni->length > 0) {
    echo '<h1 class="titolo">Recensioni del prodotto: ' . $nome . '</h1>';
    echo '<table>';
    echo '<tr><th>Autore</th><th>Recensione</th><th>Data e Ora</th><th>Voto Utilità</th><th>Voto Supporto</th><th>Azione</th></tr>';

    foreach ($recensioni as $recensione) {
        $id_recensione = $recensione->getElementsByTagName("id_recensione")->item(0)->textContent;
        $autore = $recensione->getElementsByTagName("autore")->item(0)->textContent;
        $testo = $recensione->getElementsByTagName("testo")->item(0)->textContent;
        $data = $recensione->getElementsByTagName("data")->item(0)->textContent;
        $ora = $recensione->getElementsByTagName("ora")->item(0)->textContent;

        // Recupera attributi e valori da utilita e supporto
        $utilitaNode = $recensione->getElementsByTagName('utilita')->item(0);
        $id_utente_utilita = $utilitaNode->getAttribute('id_utente');
        $utilitaValue = $utilitaNode->getElementsByTagName('valore')->item(0)->textContent;

        $supportoNode = $recensione->getElementsByTagName('supporto')->item(0);
        $id_utente_supporto = $supportoNode->getAttribute('id_utente');
        $supportoValue = $supportoNode->getElementsByTagName('valore')->item(0)->textContent;

        echo '<tr>';
        echo '<td>' . $autore . '</td>';
        echo '<td>' . $testo . '</td>';
        echo '<td>' . $data . ' ' . $ora . '</td>';
        echo '<td>' . $utilitaValue . '</td>';
        echo '<td>' . $supportoValue . '</td>';
        echo '<td>';

        // Verifica se l'utente ha già votato questa recensione
        if ($utilitaValue == 0 && $supportoValue == 0) {
            // Se l'utente non ha ancora votato, mostra i pulsanti per il voto
            echo '<form action="utilita_supporto.php" method="post">';
            echo '<input type="hidden" name="id_recensione" value="' . $id_recensione . '"/>';
            echo '<input type="hidden" name="id_prodotto" value="' . $id_prodotto . '"/>';
            echo '<input type="hidden" name="tipologia" value="' . $tipologia . '"/>';
            
            
            // Pulsanti per il voto di utilità
            echo '<label class="nome" for="votoUtilita">Utilità (da 1 a 3): </label>';
            echo '<input class="input" type="number" name="votoUtilita" min="1" max="3" required/><br>';

            // Pulsanti per il voto di supporto
            echo '<label class="nome" for="votoSupporto">Supporto (da 1 a 5): </label>';
            echo '<input class="input" type="number" name="votoSupporto" min="1" max="5" required/>';

            echo '<button class="btn" type="submit" name="vota">CONFERMA<span title="Invia" class="material-symbols-outlined">done_outline</span></button>';
            echo '</form>';
        } else {
            echo '<p class="nome"><span class="material-symbols-outlined">verified</span></p>';
        }

        echo '</td>';
        echo '</tr>';
    }

    echo '</table>';
} else {
    echo '<p class="titolo">Nessuna recensione disponibile.</p>';
}
?>
</div>

</body>
</html>