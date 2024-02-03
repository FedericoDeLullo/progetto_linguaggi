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

    <?php
    if(isset($_SESSION['errore_email']) && $_SESSION['errore_email'] == 'true'){ //isset verifica se errore_email è settata
        echo '<h2>EMAIL GIÀ ESISTENTE!</h2>';
        unset($_SESSION['errore_email']); //la unsetto altrimenti rimarrebbe la scritta
        unset($_SESSION['form_email']); //pulisco il form del campo email perché è errato
    }
    ?>

    <div class="wrapper">

        <form action="../res/cliente_register.php" method="post" class="form">
            <h1 class="titolo">REGISTRAZIONE</h1>
            <div class="data">Data di nascita:</div>
            <div class="inp nome">
                <input type="text" name="nome" id="" class="input" placeholder="Nome" value="<?php  if(isset($_SESSION['form_nome'])) echo $_SESSION['form_nome']; ?>" required>
            </div>
            <div class="inp cognome">
                <input type="date" name="data_di_nascita" id="" class="input col" placeholder="Data di nascita" value="<?php  if(isset($_SESSION['form_data_di_nascita'])) echo $_SESSION['form_data_di_nascita']; ?>" required>
            </div>
            <div class="inp dn">
                <input type="text" name="cognome" id="" class="input" placeholder="Cognome" value="<?php  if(isset($_SESSION['form_cognome'])) echo $_SESSION['form_cognome']; ?>" required>
            </div>
            <div class="inp email">
                <input type="email" name="email" id="" class="input col" placeholder="Email" value="<?php  if(isset($_SESSION['form_email'])) echo $_SESSION['form_email']; ?>" required>
            </div>
            <div class="inp indirizzo">
                <input type="text" name="indirizzo_di_residenza" id="" class="input" placeholder="Indirizzo di residenza" value="<?php  if(isset($_SESSION['form_indirizzo_di_residenza'])) echo $_SESSION['form_indirizzo_di_residenza']; ?>" required>
            </div>
            <div class="inp cf">
                <input type="text" name="codice_fiscale" id="" class="input col" placeholder="Codice fiscale" maxlength="16" value="<?php  if(isset($_SESSION['form_codice_fiscale'])) echo $_SESSION['form_codice_fiscale']; ?>" required>
            </div>
            <div class="inp cellulare">
                <input type="text" name="cellulare" class="input" placeholder="Numero di Cellulare" pattern="\d{10}" maxlength="10" value="<?php  if(isset($_SESSION['form_cellulare'])) echo $_SESSION['form_cellulare']; ?>" required>
            </div>
            <div class="inp password">
                <input type="password" name="password" id="" class="input col" placeholder="Password" required>
            </div>
        <button class="submit" type="submit">Crea Account</button>
        <p class="footer1">Hai già un account?<a href="login_cliente.php" class="link">Accedi!</a></p>    
        </form>

        <div class="banner"></div> 
   </div>
</div>

</body>
</html>