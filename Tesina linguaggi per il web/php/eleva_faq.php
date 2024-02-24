<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recensioni Prodotti</title>
    <link rel="stylesheet" href="../css/style_standard.css">
    <link rel="stylesheet" href="../css/style_catalogo.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
        <link rel="stylesheet" href="../css/style_header.css">
        <?php
        include('../res/header.php');
        ?>
</head>
<body>
<div class="cont">

<?php  
 echo '<h1 class="titolo">Eleva FAQ</h1>';

if(isset( $_POST['id_risposta']) ){
    
    $id_risposta = $_POST['id_risposta'];
    $id_domanda = $_POST['id_domanda'];
    $testo_domanda = $_POST['testo_domanda'];
    $id_prodotto = $_POST['id_prodotto'];
    $testo_risposta = $_POST['testo_risposta'];

    ?>
    <table style="width:50vw;">
        <tr>
            <td colspan="2">
                <form class="form" method="POST" action="processa_eleva_faq.php">
                    <label class="titolo" for="domanda">Testo Domanda:</label><br><br>
                    <textarea style="width:500px; height:100px; resize:none; vertical-align:top;" class="input" name="domanda" required><?php echo $testo_domanda?></textarea><br><br>
                    <label class="titolo" for="risposta">Testo Risposta</label><br><br>
                    <textarea style="width:500px; height:100px; resize:none; vertical-align:top;" class="input" name="risposta" required><?php echo $testo_risposta ?></textarea><br><br>
                    <button class="btn" type="submit" name="vota">Aggiungi FAQ</button>
                </form>
            </td>
        </tr>
    </table>
    <?php
} elseif(isset($_POST['id_domanda'])) {

    $id_domanda = $_POST['id_domanda'];
    $testo_domanda = $_POST['testo_domanda'];
    $id_prodotto = $_POST['id_prodotto'];
    
    ?>
    <table style="width:50vw;">
        <tr>
            <td colspan="2">
                <form class="form" method="POST" action="processa_eleva_faq.php">
                    <label class="titolo" for="domanda">Testo Domanda:</label><br><br>
                    <textarea style="width:500px; height:100px; resize:none; vertical-align:top;" class="input" name="domanda" required><?php echo $testo_domanda?></textarea><br><br>
                    <label class="titolo" for="domanda">Testo Risposta:</label><br><br>
                    <textarea style="width:500px; height:100px; resize:none; vertical-align:top;" class="input" name="risposta" placeholder="Inserisci una risposta alla faq selezionata..." required></textarea><br><br>
                    <button class="btn" type="submit" name="vota">Aggiungi FAQ</button>
                </form>
            </td>
        </tr>
    </table> 
    <?php
}?>
</div>

</body>
</html>