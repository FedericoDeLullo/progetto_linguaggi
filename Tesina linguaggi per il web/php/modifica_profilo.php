<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifica Utente</title>

    <link rel="stylesheet" href="../css/style_standard.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="../css/style_header.css"></head></head>
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
require_once('../res/connection.php');

// Verifica se è stato fornito un ID utente valido
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id_utente = $_GET['id'];

    // Esegui una query per ottenere i dati dell'utente
    $query = "SELECT * FROM utenti WHERE id = $id_utente";
    $result = $connessione->query($query);

    if ($result->num_rows == 1) {
        $utente = $result->fetch_assoc();
    ?>
    <h1 class="titolo">Modifica Profilo</h1>
<table>
     <tr>
        <td colspan="2">
        <form class="form" action="processa_modifica_profilo.php" method="post">
                    <input class="input" type="hidden" name="id" value="<?php echo $utente['id']; ?>">
                    <label class="nome" for="nome">Nome:</label>
                    <input class="input" type="text" id="nome" name="nome" value="<?php echo $utente['nome']; ?>" required><br>
                    <label class="nome" for="nome">Cognome:</label>
                    <input class="input" type="text" id="cognome" name="cognome" value="<?php echo $utente['cognome']; ?>" required><br>
                    <label class="nome" for="email">Email:</label>
                    <input class="input" type="email" id="email" name="email" value="<?php echo $utente['email']; ?>" required><br>
                    <label class="nome" for="nome">Password:</label>
                    <input class="input" type="text" id="password" name="password" value="<?php echo $utente['passwd']; ?>" required><br>
                    <label class="nome" for="nome">Indirizzo di residenza:</label>
                    <input class="input" type="text" id="indirizzo" name="indirizzo" value="<?php echo $utente['indirizzo_di_residenza']; ?>" required><br>
                    <label class="nome" for="nome">Cellulare:</label>
                    <input class="input" type="number" id="cellulare" name="cellulare" value="<?php echo $utente['cellulare']; ?>" required>
                    <br><br><br>
                    <input class="btn" type="submit" value="Salva Modifiche">
                </form>
    
    </td>
        </tr>
    </table>
    <?php
    } else {
        echo 'Utente non trovato.';
    }
} else {
    echo 'ID utente non valido.';
}

$connessione->close();
?>
</body>
</html>
