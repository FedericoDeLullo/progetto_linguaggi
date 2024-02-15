<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../css/style_login.css">
    <link rel="stylesheet" href="../css/style_header.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <?php
        include('../res/header.php');
    ?>
</head>
<body>
    <?php
        if(isset($_SESSION['errore_login']) && $_SESSION['errore_login'] == 'true'){
            echo '<h2>Errore in fase di login...</h2>';
            unset($_SESSION['errore_login']);
        }
    ?>
    <div class="cont">
        <div class="wrapper">
            <form action="../res/admin_login.php" class="form_plus" method="post">
                <h1 class="titolo">LOGIN</h1>
                <div class="inp">
                    <input type="text" name="email" id="email"  class="input" placeholder="Email">
                    <i class="fa_solid fa_user"></i>
                </div>
                <div class="inp">
                    <input type="password" name="password" id="password"  class="input" placeholder="Password">
                    <i class="fa_solid fa_lock"></i>
                </div>
                <div class="inp">
                    <input type="number" name="codice" id="codice"  class="input" placeholder="Codice Admin">
                    <i class="fa_solid fa_lock"></i>
                </div>
                <button class="submit" type="submit">Inizia la sessione</button>
                <p class="footer">Non hai un account? <a href="registrazione_admin.php" class="link">Registrati come Admin!</a></p>
                </form>
            <div class="banner">
                <h1 class="wel_text">Benvenuto<br/></h1>
                <img src="../img/logo.PNG">
            </div>
        </div>
    </div>
</body>
</html>