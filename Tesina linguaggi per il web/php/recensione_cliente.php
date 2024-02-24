<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lascia una Recensione</title>
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
     
    // Verifica se è stato fornito un ID del prodotto nella query string
    if (isset($_GET['id_prodotto'])) {
        $id_prodotto = $_GET['id_prodotto'];
        $nome_prodotto = $_GET['nome'];
        $email_utente = $_SESSION['email'];
        $tipologia = $_GET['tipologia'];
        $id_utente = $_GET ['id'];
?>


    <h1 class="titolo">Lascia una recensione per <?php echo $nome_prodotto; ?>:</h1>
    <table>
        <tr>
            <td colspan="2">
                <form class="form" method="post" action="processa_recensioni.php">
                    <input type="hidden" name="id" value="<?php echo $id_utente; ?>">
                    <input type="hidden" name="id_prodotto" value="<?php echo $id_prodotto; ?>">
                    <input type="hidden" name="nome" value="<?php echo $nome_prodotto; ?>">
                    <input type="hidden" name="tipologia" value="<?php echo $tipologia; ?>">
                    <input type="hidden" name="autore" value="<?php echo $email_utente; ?>">
                    <input type="hidden" name="orario_recensione" value="<?php echo date('H:i:s'); ?>">
                    <input type="hidden" name="data_recensione" value="<?php echo date('Y-m-d'); ?>">
                    <textarea style="width:300px; height:100px; resize:none; vertical-align:top;" class="input" name="recensione" placeholder="Scrivi una recensione..." required></textarea>
                    <br><br><br>
                    <input class="btn" type="submit" value="Lascia Recensione">
                </form>
            </td>
        </tr>
    </table>
<?php
    }
    else {
        echo 'ID del prodotto mancante.';
    }

    ?>
</div>
</body>
</html>