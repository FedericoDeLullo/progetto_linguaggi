<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestione Crediti</title>
    <link rel="stylesheet" href="../css/style_standard.css">
    <link rel="stylesheet" href="../css/style_header.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
</head>
<body>
<?php
$xmlFile = '../xml/requests.xml';
$dom = new DOMDocument();
$dom->load($xmlFile);

$requests = $dom->getElementsByTagName('request');
$hasPendingRequests = false;
foreach ($requests as $request) {
  $status = $request->getAttribute('status');

  if ($status == 'pending') {
      $hasPendingRequests = true;
      }
    }
    ?>
<header class="header">
    <div class="header_menu">  
        <div class="header_menu_item">
            <a href="index_admin.php">
                <img class="logo" src="../img/logo.PNG">
                <span class="logo-text">RugbyWorld</span>
            </a>
        </div>
        <div class="header_menu_item">
            <a href="../php/catalogo_magliette.php" class="stile">
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
                <div class="header_menu_link" title="Profilo">
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
require_once('../res/connection.php');

// Recupera i dati dal form in admin_approve.php
$email = $_POST['email'];
$importo = $_POST['importo'];
$action = $_POST['action'];

if ($action=="Approva") {
$xmlFile = '../xml/requests.xml';
$dom = new DOMDocument();
$dom->load($xmlFile);

$requests = $dom->getElementsByTagName('request');

    foreach ($requests as $request) {
        $statusElement = $request->getAttribute('status');

        if ($statusElement == 'pending') {
            $emailElement = $request->getElementsByTagName('email')->item(0);
            $importoElement = $request->getElementsByTagName('importo')->item(0);

            $requestEmail = $emailElement->nodeValue;
            $requestImporto = $importoElement->nodeValue;

            if ($requestEmail == $email && $requestImporto == $importo) {
                // Aggiorna lo stato della richiesta nel file XML
                $request->setAttribute('status', 'approved');
                $dom->save($xmlFile);

                // Aggiorna i crediti dell'utente nel database
                $sql_credit_update = "UPDATE utenti SET crediti = crediti + $importo WHERE email = '$email'";
                if ($connessione->query($sql_credit_update) === TRUE) {
                    echo '<h1 class="titolo">Richiesta approvata con successo. I crediti sono stati aggiunti all\'account di $email.</h1>';
                } 
                else {
                    echo '<h1 class="titolo">Errore nell\'aggiornamento dei crediti dell\'utente nel database: ' . $connessione->error . '</h1>';
                }

                $connessione->close();
                exit();
            }
        }
    } 
}
elseif ($action=="Rifiuta") {
    $xmlFile = '../xml/requests.xml';
    $dom = new DOMDocument();
    $dom->load($xmlFile);

    $requests = $dom->getElementsByTagName('request');

    foreach ($requests as $request) {
        $statusElement = $request->getAttribute('status');

        if ($statusElement == 'pending') {
            $emailElement = $request->getElementsByTagName('email')->item(0);
            $importoElement = $request->getElementsByTagName('importo')->item(0);

            $requestEmail = $emailElement->nodeValue;
            $requestImporto = $importoElement->nodeValue;

            if ($requestEmail == $email && $requestImporto == $importo) {
                // Aggiorna lo stato della richiesta nel file XML a 'deny'
                $request->setAttribute('status', 'deny');
                $dom->save($xmlFile);

                echo '<h1 class="titolo">Richiesta rifiutata con successo!!!</h1>';
                $connessione->close();
                exit();
            }
        }
    }
}
else {
    echo '<h1 class="titolo">Errore: richiesta non trovata...</h1';
}

$connessione->close();
?>
</div>
</body>
</html>