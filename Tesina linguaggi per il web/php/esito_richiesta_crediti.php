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
<header class="header">
    <div class="header_menu">  
        <div class="header_menu_item">
            <a href="../html/index_cliente.html">
                <img class="logo" src="../img/logo.PNG">
                <span class="logo-text">RugbyWorld</span>
            </a>   
        </div>
        <div class="header_menu_item">
            <a href="catalogo_utente_magliette.php" class="stile">
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
            <a href="gestione_profilo.php" class="stile">
                <div class="header_menu_link" title="Profilo">
                    <span class="material-symbols-outlined">group</span>PROFILO
                </div>
            </a>
        </div>
        <div class="header_menu_item">
          <a href="../html/gestione_crediti.html" class="stile">
              <div class="header_menu_link" title="Gestione Crediti">
                  <span class="material-symbols-outlined">monetization_on</span>GESTIONE CREDITI
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
session_start();

if (!isset($_SESSION['loggato'])) {
    header("Location: ../html/login_cliente.html");
    exit();
}

$email = $_SESSION['email'];
$importo = $_POST['importo'];

$xmlFile = '../xml/requests.xml';  // Utilizzo di un percorso relativo
$dom = new DOMDocument();

try {
    $dom->load($xmlFile);
} catch (Exception $e) {
    die('Errore nel caricamento del file XML: ' . $e->getMessage());
}

$root = $dom->documentElement;

$request = $dom->createElement('request');
$request->setAttribute('status', 'pending');

$emailElement = $dom->createElement('email', $email);
$request->appendChild($emailElement);

$importoElement = $dom->createElement('importo', $importo);
$request->appendChild($importoElement);

$root->appendChild($request);

try {
    $dom->save($xmlFile);
} catch (Exception $e) {
    die('Errore nel salvataggio del file XML: ' . $e->getMessage());
}

echo "<h1 class='titolo'>Richiesta inviata con successo. Attendere l'approvazione dell'amministratore...</h1>";
?>
</div>
</body>
</html>