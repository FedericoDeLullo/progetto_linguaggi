<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style_standard.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="../css/style_header.css">
    <title>Gestione Utenti</title>
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
                <div class="header_menu_link" title="Profilo">
                
                   
                        <span class="material-symbols-outlined">notifications_unread</span>
                    ACCETTA CREDITI
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
    <h1 class="titolo">GESTIONE UTENTI</h1>
    <table>
        <tr>
            <td>
                <form action="ban.php" method="post">
                    <?php
                    if(isset($_GET['ban'])) {
                        $banValue = $_GET['ban'];
                        $id_utente = $_GET['id'];
                        
                        // Aggiungi un campo hidden per inviare il valore GET nel form
                        echo '<input type="hidden" name="ban" value="' . htmlspecialchars($banValue) . '">';
                        echo '<input type="hidden" name="id" value="' . htmlspecialchars($id_utente) . '">';

                        if($banValue == 1) {
                            echo '<p class="big">Attivare l\'utente?</p>';
                            echo '<button class="done" type="submit" name="action" value="Approva"><span id="done" class="material-symbols-outlined">done</span></button>';
                            echo '<button class="done" type="submit" name="action" value="Rifiuta"><span id="done" class="material-symbols-outlined">close</span></button>';
                        } elseif($banValue == 0) {
                            echo '<p class="big">Disattivare l\'utente?</p>';
                            echo '<button class="done" type="submit" name="action" value="Approva"><span id="done" class="material-symbols-outlined">done</span></button>';
                            echo '<button class="done" type="submit" name="action" value="Rifiuta"><span id="done" class="material-symbols-outlined">close</span></button>';
                        } else {
                            echo '<p>Utente non trovato...</p>';
                        }
                    } else {
                        echo '<p>Utente non trovato...</p>';
                    }
                    ?>
                </form>
            </td>
        </tr>
    </table>
</div>

</body>
</html>
