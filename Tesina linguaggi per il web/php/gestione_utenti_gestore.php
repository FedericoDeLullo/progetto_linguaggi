<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=
    , initial-scale=1.0">
    <title>Gestione Utenti</title>
    <link rel="stylesheet" href="../css/style_standard.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="../css/style_header.css">
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
            <a href="../php/catalogo_utente_magliette.php" class="stile">
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
            <a href="../html/index.html" class="stile">                   
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
<h1 class="titolo">PROFILI CLIENTI</h1>

<?php
// Include il file di connessione al database
require_once('../res/connection.php');
// Query per ottenere gli utenti
$sql = "SELECT id, nome, cognome, crediti, reputazione FROM utenti WHERE utente = 1";
$result = $connessione->query($sql);

// Stampa la tabella degli utenti
echo '<table border="1">';
echo '<tr>';
echo '<th>ID</th>';
echo '<th>Nome</th>';
echo '<th>Cognome</th>';
echo '<th>Reputazione</th>';
echo '<th>Crediti</th>';
echo '</tr>';

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . $row['id'] . '</td>';
        echo '<td>' . $row['nome'] . '</td>';
        echo '<td>' . $row['cognome'] . '</td>';
        echo '<td>' . $row['reputazione'] . '</td>';
        echo '<td>' . $row['crediti'] . '</td>';
        echo '</tr>';
    }
} else {
    echo '<tr><td colspan="3">Nessun utente trovato</td></tr>';
}

echo '</table>';

?>
</div>
                
<?php
// Chiudi la connessione al database
$connessione->close();
?>

</body>
</html>