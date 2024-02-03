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

        <form action="../res/gestore_register.php" method="post" class="form">
            <h1 class="titolo">REGISTRAZIONE</h1>    <div class="data">Data di nascita:</div>


            <div class="inp nome">
                <input type="text" name="nome" id="" class="input" placeholder="Nome">
            </div>
            <div class="inp cognome">
                <input type="date" name="data_di_nascita" id="" class="input col" placeholder="Data di nascita">
            </div>
           
            <div class="inp dn">
                <input type="text" name="cognome" id="" class="input" placeholder="Cognome">
            </div>
            <div class="inp email">
                <input type="email" name="email" id="" class="input col" placeholder="Email">
            </div> <div class="inp indirizzo">
                <input type="text" name="indirizzo_di_residenza" id="" class="input" placeholder="Indirizzo di residenza">
            </div>
            <div class="inp cf">
                <input type="number" name="cellulare" id="" class="input col" placeholder="Cellulare">
            </div>
            <div class="inp cellulare">
                <input type="text" name="codice_fiscale" id="" class="input" placeholder="Codice fiscale">
            </div>
            <div class="inp password">
                <input type="password" name="password" id="" class="input col" placeholder="Password">
            </div>
            <div class="inp codice">
                <input type="number" name="codice" id="" class="input col" placeholder="Codice Gestore">
            </div>
            <button class="submit_plus" type="submit">Crea Account</button>
            <p class="footer">Hai già un account?<a href="login_gestore.php" class="link">Accedi!</a></p>    
        </form>

        <div class="banner"></div> 
    </div>
</div>

</body>
</html>