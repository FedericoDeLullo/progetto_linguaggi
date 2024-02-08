<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fai una Domanda</title>   
     <link rel="stylesheet" href="../css/style_standard.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="../css/style_header.css">
    <?php
        include('../res/header.php');
    ?>
</head>
<body>
<div class="cont">
<?php
require_once('../res/connection.php');

// Verifica se è stato fornito un ID del prodotto nella query string o nel corpo della richiesta POST
if (isset($_REQUEST['id_prodotto'])) {
    $id_prodotto = $_REQUEST['id_prodotto'];
    $nome_prodotto = $_REQUEST['nome'];
    $email_utente = $_SESSION['email'];
    $tipologia = $_REQUEST['tipologia'];
    $id_utente = $_SESSION['id'];
    ?>
   
   <h1 class="titolo">Fai una domanda per <?php echo $nome_prodotto; ?>:</h1>

   <table>
        <tr>
            <td colspan="2">
    <form class="form" method="post" action="processa_prodotti.php">
        <input type="hidden" name="id_prodotto" value="<?php echo $id_prodotto; ?>">
        <input type="hidden" name="tipologia" value="<?php echo $tipologia; ?>">
        <input type="hidden" name="autore" value="<?php echo $email_utente; ?>">
        <input type="hidden" name="nome" value="<?php echo $nome_prodotto; ?>">

        <textarea class="input" name="domanda" rows="4" cols="50" required></textarea>
            <input class="btn" type="submit" value="Invia Domanda">
    </form>
    </td>
        </tr>
    </table>
<?php
} else {
    echo 'ID del prodotto mancante.';
}
?>
</div>
</body>
</html>
