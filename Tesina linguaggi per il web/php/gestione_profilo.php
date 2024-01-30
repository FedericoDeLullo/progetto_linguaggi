<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestione Utente</title>
    <link rel="stylesheet" href="../css/style_standard.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="../css/style_header.css">

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
// Include il file di connessione al database
require_once('../res/connection.php');
session_start();

// Verifica se l'utente è loggato
if (isset($_SESSION['id'])) {
    $id_utente = $_SESSION['id'];

    // Esegui la query per ottenere i dati dell'utente
    $query = "SELECT * FROM utenti WHERE id = $id_utente";
    $result = $connessione->query($query);

    if ($result->num_rows > 0) {
        $utente = $result->fetch_assoc();
?>
        <h1 class="titolo">Gestione Utente</h1>

            <table>
                <tr>
                    <th>Nome:</th>
                    <td><?php echo $utente['nome']; ?></td>
                    <td><a href="modifica_profilo.php?id=<?php echo $utente['id']; ?>"><span id="edit" class="material-symbols-outlined">edit</span></a></td>

                </tr>
                <tr>
                    <th>Cognome:</th>
                    <td><?php echo $utente['cognome']; ?></td>
                    <td><a href="modifica_profilo.php?id=<?php echo $utente['id']; ?>"><span id="edit" class="material-symbols-outlined">edit</span></a></td>

                </tr>
                <tr>
                    <th>Email:</th>
                    <td><?php echo $utente['email']; ?></td>
                    <td><a href="modifica_profilo.php?id=<?php echo $utente['id']; ?>"><span id="edit" class="material-symbols-outlined">edit</span></a></td>

                </tr>
                <tr>
                    <th>Password:</th>
                    <td><?php echo $utente['passwd']; ?></td>
                    <td><a href="modifica_profilo.php?id=<?php echo $utente['id']; ?>"><span id="edit" class="material-symbols-outlined">edit</span></a></td>

                </tr>
                <tr>
                    <th>Crediti:</th>
                    <td><?php echo $utente['crediti']; ?></td>
                    <td><a href="richiesta_crediti.php"><span id="edit" class="material-symbols-outlined">
        edit
        </span></a></td>
                </tr>
                <tr>
                <tr>
                    <th>Reputazione:</th>
                    <td><?php echo $utente['reputazione']; ?></td>

                </tr>
                    <th>Cellulare:</th>
                    <td><?php echo $utente['cellulare']; ?></td>
                    <td><a href="modifica_profilo.php?id=<?php echo $utente['id']; ?>"><span id="edit" class="material-symbols-outlined">edit</span></a></td>

                </tr><tr>
                    <th>Indirizzo di residenza:</th>
                    <td><?php echo $utente['indirizzo_di_residenza']; ?></td>
                    <td><a href="modifica_profilo.php?id=<?php echo $utente['id']; ?>"><span id="edit" class="material-symbols-outlined">edit</span></a></td>

                </tr>
            </table>

<?php
    } else {
        echo 'Utente non trovato.';
    }
} else {
    echo 'Utente non loggato.';
}
echo '</div>';

// Chiudi la connessione al database
$connessione->close();
?>

</body>
</html>
