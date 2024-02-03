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
    <?php
        include('../res/header.php');
    ?>
</head>
<body>
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
          