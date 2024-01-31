<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rimuovi Prodotto</title>
    <link rel="stylesheet" href="../css/style_standard.css">
    <link rel="stylesheet" href="../css/style_header.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <?php
        include('../res/header.php');
    ?>
</head>
<body>

<div class="cont">
    <h1 class="titolo">Rimuovi Prodotto</h1>
    <table>
        <tr>
            <td colspan="2">
                <form class="form" action="rimuovi_prodotto.php" method="post">
                    <label class="nome" for="nome">Nome Prodotto:</label>
                    <input class="input" type="text" name="nome" required>
                    <br><br><br>
                    <input class="btn" type="submit" value="Rimuovi Prodotto">
                </form>
            </td>
        </tr>
    </table>
</div>
</body>
</html>
