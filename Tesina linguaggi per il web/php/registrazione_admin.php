<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrazione</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="../css/style_register.css">
    <link rel="stylesheet" href="../css/style_header.css">
    <?php
        include('../res/header.php');
    ?>
</head>
<body>

<div class="cont">
    <div class="wrapper">

        <form action="../res/admin_register.php" method="post" class="form">
            <h1 class="titolo">REGISTRAZIONE</h1>
            <div class="data">Data di nascita:</div>
            <div class="inp nome">
                <input type="text" name="nome" id="" class="input" placeholder="Nome" required>
            </div>
            <div class="inp cognome">
                <input type="date" name="data_di_nascita" id="" class="input col" placeholder="Data di nascita" required>
            </div>
            <div class="inp dn">
                <input type="text" name="cognome" id="" class="input" placeholder="Cognome" required>
            </div>
            <div class="inp email">
                <input type="email" name="email" id="" class="input col" placeholder="Email" required>
            </div>
            <div class="inp indirizzo">
                <input type="text" name="indirizzo_di_residenza" id="" class="input" placeholder="Indirizzo di residenza" required>
            </div>
            <div class="inp cf">
                <input type="text" name="codice_fiscale" id="" class="input col" placeholder="Codice fiscale" maxlength="16" required>
            </div>
            <div class="inp cellulare">
                <input type="text" name="cellulare" class="input" placeholder="Numero di Cellulare" pattern="\d{10}" maxlength="10" required>
            </div>
            <div class="inp password">
                <input type="password" name="password" id="" class="input col" placeholder="Password" required>
            </div>
            <div class="inp codice">
                <input type="number" name="codice" id="" class="input col" placeholder="Codice Admin" required>
            </div>
            <button class="submit_plus" type="submit">Crea Account</button>
            <p class="footer">Hai già un account?<a href="login_admin.php" class="link">Accedi!</a></p>    
        </form>

        <div class="banner"></div> 
    </div>
</div>

</body>
</html>