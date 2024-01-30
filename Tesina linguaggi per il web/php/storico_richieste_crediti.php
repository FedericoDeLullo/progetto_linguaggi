<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Storico Esiti Pagamenti</title>
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

    <?php
    session_start();

    // Verifica se l'utente è loggato
    if (!isset($_SESSION['loggato'])) {
        header("Location: ../html/login_cliente.html");
        exit();
    }

    $userEmail = $_SESSION['email'];
    $xmlFile = '../xml/requests.xml';
    $dom = new DOMDocument();
    $dom->load($xmlFile);

    $requests = $dom->getElementsByTagName('request');

    echo '<div class="cont">';
    echo '<h1 class="titolo">Storico Richiesta Crediti</h1>';

    // Flag per indicare se ci sono richieste per l'utente loggato
    $hasUserRequests = false;

    // Inizio della tabella
    echo '<table border="1">';
    echo '<tr>';
    echo '<th>Importo</th>';
    echo '<th>Status</th>';
    echo '</tr>';

    // Loop attraverso le richieste
    foreach ($requests as $request) {
        $email = $request->getElementsByTagName('email')->item(0)->nodeValue;
        $importo = $request->getElementsByTagName('importo')->item(0)->nodeValue;
        $status = $request->getAttribute('status');

        // Verifica se la richiesta appartiene all'utente loggato
        if ($email == $userEmail) {
            $hasUserRequests = true;

            // Stampa le informazioni della richiesta all'interno di una riga della tabella
            echo '<tr>';
            echo "<td>$importo</td>";
            echo "<td>$status</td>";
            echo '</tr>';
        }
    }

    // Chiusura della tabella
    echo '</table>';

    echo '</div>';
    // Verifica se ci sono richieste per l'utente loggato
    if (!$hasUserRequests) {
        echo '<p class="titolo">Nessuna richiesta di ricarica effettuata.</p>';
    }
    ?>

   
</body>
</html>
