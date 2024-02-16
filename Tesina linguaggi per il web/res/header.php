<?php
session_start();
require_once('connection.php');
if(isset($_SESSION['loggato'])){
$id_utente = $_SESSION['id'];
$gestore = $_SESSION['gestore'];
$admin = $_SESSION['ammin'];
$utente = $_SESSION['utente'];
    if($utente == 1){ 
        ?>
        <header class="header">
            <div class="header_menu">  
                <div class="header_menu_item">
                    <a href="../php/index.php">
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
                    <a href="../php/faq.php" class="stile">
                        <div class="header_menu_link" title="Faq">
                            <span class="material-symbols-outlined">quiz</span>FAQ
                        </div>
                    </a>
                </div>
                <div class="header_menu_item">
                    <a href="../php/gestione_profilo.php" class="stile">
                        <div class="header_menu_link" title="Profilo">
                            <span class="material-symbols-outlined">group</span>PROFILO
                        </div>
                    </a>
                </div>
                <div class="header_menu_item">
                <a href="../php/gestione_crediti.php" class="stile">
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
                            <span class="material-symbols-outlined">shopping_cart</span>
                        </div>
                    </a>
                </div>
            </div>
        </header>
        <?php
    } 
    elseif ($admin == 1){
        $xmlFile = '../xml/requests.xml';
        $dom = new DOMDocument();
        $dom->load($xmlFile);

        $requests = $dom->getElementsByTagName('request');
        $hasPendingRequests = false;

        foreach ($requests as $request) {
            $status = $request->getAttribute('status');

            if ($status == 'In Attesa') {
                $hasPendingRequests = true;
            }
        }
        ?>
        <header class="header">
            <div class="header_menu">  
                <div class="header_menu_item">
                    <a href="../php/index.php">
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
                    <a href="../php/faq.php" class="stile">
                        <div class="header_menu_link" title="Faq">
                            <span class="material-symbols-outlined">quiz</span>FAQ
                        </div>
                    </a>
                </div>
                <div class="header_menu_item">
                    <a href="../php/menu_richieste_crediti.php" class="stile">
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
                <a href="../php/gestione_utenti.php" class="stile">
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
                            <span class="material-symbols-outlined">shopping_cart</span>
                        </div>
                    </a>
                </div>
            </div>
        </header>
        <?php
    }
    elseif($gestore == 1){
        $xmlFile = '../xml/segnalazioni.xml';
        $dom = new DOMDocument();
        $dom->load($xmlFile);

        $segnalazioni = $dom->getElementsByTagName('segnalazione');
        $hasPendingRequests = false;

        foreach ($segnalazioni as $segnalazione) {
            $status = $segnalazione->getAttribute('status');

            if ($status == 'In Attesa') {
                $hasPendingRequests = true;
            }
        }
        ?>
        <header class="header">
            <div class="header_menu">  
                <div class="header_menu_item">
                    <a href="../php/index.php">
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
                    <a href="../php/faq.php" class="stile">
                        <div class="header_menu_link" title="Faq">
                            <span class="material-symbols-outlined">quiz</span>FAQ
                        </div>
                    </a>
                </div>
                <div class="header_menu_item">
                    <a href="../php/gestione_catalogo.php" class="stile">
                        <div class="header_menu_link" title="Gestisci Catalogo">
                            <span class="material-symbols-outlined">folder_managed</span>GESTISCI CATALOGO
                        </div>
                    </a>
                </div>
                <div class="header_menu_item">
                    <a href="../php/menu_segnalazioni.php" class="stile">
                             <div class="header_menu_link" title="Segnalazioni">
                             <?php
                             if ($hasPendingRequests) {
                                 echo '<span id="note" class="material-symbols-outlined">
                                 report
                                 </span>';
                             }
                             else { 
                             ?>
                                 <span class="material-symbols-outlined">report</span>
                             <?php }?>SEGNALAZIONI
                         </div>
                    </a>
                </div>
                <div class="header_menu_item">
                <a href="../php/gestione_utenti_gestore.php" class="stile">
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
                            <span class="material-symbols-outlined">shopping_cart</span>
                        </div>
                    </a>
                </div>
            </div>
        </header>
        <?php
    }}
    else {
        ?>
        <header class="header">
            <div class="header_menu">  
                <div class="header_menu_item">
                    <a href="../php/index.php">
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
                    <a href="../php/faq.php" class="stile">
                        <div class="header_menu_link" title="Faq">
                            <span class="material-symbols-outlined">quiz</span>FAQ
                        </div>
                    </a>
                </div>
                <div class="header_menu_item">
                    <a href="../php/login_menu.php" class="stile">                   
                        <div class="header_menu_link" title="Login">
                            <span class="material-symbols-outlined">login</span>LOGIN
                        </div>
                    </a>
                </div>
                <div class="header_menu_item">
                    <a href="../php/login_menu.php" class="stile">                   
                        <div class="header_menu_link" title="Carrello">
                            <span class="material-symbols-outlined">shopping_cart</span>
                        </div>
                    </a>
                </div>
            </div>
        </header>
        <?php
    }
?>