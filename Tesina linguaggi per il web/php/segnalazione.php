<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../css/style_standard.css">
    <link rel="stylesheet" href="../css/style_menu.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="../css/style_header.css">
    <?php
        include('../res/header.php');
    ?>
</head>
<body>
    <div class="cont">
        <table>
            <?php      
            require_once('../res/connection.php');

            if(isset($_GET['id_domanda']) && !isset($_GET['id_risposta'])){
                $id_domanda = $_GET['id_domanda'];
                $testo_domanda = $_GET['testo_domanda'];
                $id_prodotto = $_GET['id_prodotto'];
                $autoreDomanda = $_GET['autoreDomanda'];
                $nome = $_GET['nome'];
                $tipologia = $_GET['tipologia'];
                $segnalatore = $_SESSION['email'];
                ?>
                <tr>
                    <td colspan="2">
                        <form class="form" action="processa_segnalazione.php" method="post">
                            <input type="hidden" name="id_domanda" value="<?php echo $id_domanda; ?>">     
                            <input type="hidden" name="id_prodotto" value="<?php echo $id_prodotto; ?>">
                            <input type="hidden" name="testo_domanda" value="<?php echo $testo_domanda; ?>">
                            <input type="hidden" name="autoreDomanda" value="<?php echo $autoreDomanda; ?>">
                            <input type="hidden" name="nome" value="<?php echo $nome; ?>">
                            <input type="hidden" name="segnalatore" value="<?php echo $segnalatore; ?>">
                            <input type="hidden" name="tipologia" value="<?php echo $tipologia; ?>">
                            <textarea style="width:500px; height:100px; resize:none; vertical-align:top;" class="input" name="segnalazione" placeholder="Testo Segnalazione Domanda..." required></textarea>
                            <br><br><br>
                            <button type="submit" name="report" class="btn">Invia Segnalazione</span></button>
                        </form>
                    </td>
                </tr>
                <?php
            }elseif(isset($_GET['id_risposta']) && isset($_GET['id_domanda'])){
                $id_risposta = $_GET['id_risposta'];
                $testo_risposta = $_GET['testo_risposta'];
                $id_prodotto = $_GET['id_prodotto'];
                $autoreRisposta = $_GET['autoreRisposta'];
                $id_domanda = $_GET['id_domanda'];
                $nome = $_GET['nome'];
                $tipologia = $_GET['tipologia'];
                $segnalatore = $_SESSION['email'];
                ?>
                <tr>
                    <td colspan="2">
                        <form class="form" action="processa_segnalazione.php" method="post">
                            <input type="hidden" name="id_domanda" value="<?php echo $id_domanda; ?>">    
                            <input type="hidden" name="id_risposta" value="<?php echo $id_risposta; ?>">      
                            <input type="hidden" name="id_prodotto" value="<?php echo $id_prodotto; ?>">
                            <input type="hidden" name="testo_risposta" value="<?php echo $testo_risposta; ?>">
                            <input type="hidden" name="segnalatore" value="<?php echo $segnalatore; ?>">
                            <input type="hidden" name="autoreRisposta" value="<?php echo $autoreRisposta; ?>">
                            <input type="hidden" name="nome" value="<?php echo $nome; ?>">
                            <input type="hidden" name="tipologia" value="<?php echo $tipologia; ?>">
                            <textarea style="width:500px; height:100px; resize:none; vertical-align:top;" class="input" name="segnalazione" placeholder="Testo Segnalazione Risposta..." required></textarea>
                            <br><br><br>
                            <button type="submit" name="report" class="btn">Invia Segnalazione</span></button>
                        </form>
                    </td>
                </tr>
                <?php
            }elseif(isset($_GET['id_recensione'])){
                $testo_recensione = $_GET['testo_recensione'];
                $id_prodotto = $_GET['id_prodotto'];
                $autoreRecensione = $_GET['autoreRecensione'];
                $id_recensione = $_GET['id_recensione'];
                $nome = $_GET['nome'];
                $segnalatore = $_SESSION['email'];
                $tipologia = $_GET['tipologia'];
                ?>
                <tr>
                    <td colspan="2">
                        <form class="form" action="processa_segnalazione.php" method="post">
                            <input type="hidden" name="id_prodotto" value="<?php echo $id_prodotto; ?>">
                            <input type="hidden" name="testo_recensione" value="<?php echo $testo_recensione; ?>">
                            <input type="hidden" name="autoreRecensione" value="<?php echo $autoreRecensione; ?>">
                            <input type="hidden" name="id_recensione" value="<?php echo $id_recensione; ?>">
                            <input type="hidden" name="segnalatore" value="<?php echo $segnalatore; ?>">
                            <input type="hidden" name="nome" value="<?php echo $nome; ?>">
                            <input type="hidden" name="tipologia" value="<?php echo $tipologia; ?>">
                            <textarea style="width:500px; height:100px; resize:none; vertical-align:top;" class="input" name="segnalazione" placeholder="Testo Segnalazione Recensione..." required></textarea>
                            <br><br><br>
                            <button type="submit" name="report" class="btn">Invia Segnalazione</span></button>
                        </form>
                    </td>
                </tr>
                <?php
            }
            ?>
        </table>
    </div>
</body>
</html>