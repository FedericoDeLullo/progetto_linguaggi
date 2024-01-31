<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="../css/style_standard.css">
    <link rel="stylesheet" href="../css/style_header.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Domande</title>
</head>
<body>

<header class="header">
    <div class="header_menu">  
        <div class="header_menu_item">
            <a href="index.html">
                <img class="logo" src="../img/logo.PNG">
                <span class="logo-text">RugbyWorld</span>
            </a>
        </div>
        <div class="header_menu_item">
            <a href="../php/catalogo_magliette.php" class="stile">
                <div class="header_menu_link" title="Catalogo">
                    <span class="material-symbols-outlined">receipt_long</span>CATALOGO
                </div>
            </a>
        </div>
        <div class="header_menu_item">
            <a href="#" class="stile">
                <div class="header_menu_link" title="Faq">
                    <span class="material-symbols-outlined">quiz</span>FAQ
                </div>
            </a>
        </div>
        <div class="header_menu_item">
            <a href="#" class="stile">
                <div class="header_menu_link" title="About us">
                    <span class="material-symbols-outlined">group</span>ABOUT US
                </div>
            </a>
        </div>
        <div class="header_menu_item">
            <a href="../res/logout.php" class="stile">                   
                <div class="header_menu_link" title="Login">
                    <span class="material-symbols-outlined">login</span>LOGOUT
                </div>
            </a>
        </div>
        <div class="header_menu_item">
            <a href="login_menu.html" class="stile">                   
                <div class="header_menu_link" title="Carrello">
                    <span class="material-symbols-outlined">shopping_cart</span>CARRELLO
                </div>
            </a>
        </div>
    </div>
</header>
<?php 
  if(isset($_GET['tipologia'])){
    $tipologia = $_GET['tipologia'];
  }
?>
<div class="cont">
        <h1 class="titolo">Domanda aggiunta con successo!</h1>
</div>

</body>
</html>
           