<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="../css/style_header.css">
    <link rel="stylesheet" href="../css/style_menu.css">
    <?php
        include('../res/header.php');
    ?>
</head>
<body>

<div class="cont">
    <table>
        <tr>
            <td></td>
            <td class="tre_bottoni"><a href="login_admin.php" class="admin">Accedi come admin</a></td>
        </tr>
        <tr>
            <td class="tre_bottoni"><a href="login_cliente.php" class="admin">Accedi come cliente</a></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td class="tre_bottoni"><a href="login_gestore.php" class="admin">Accedi come gestore</a></td>
        </tr>
    </table>
<div class="sep"></div>
</div>
</body>
</html>