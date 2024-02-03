<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recensione</title>
    <link rel="stylesheet" href="../css/style_standard.css">
    <link rel="stylesheet" href="../css/style_header.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <?php
        include('../res/header.php');
    ?>
</head>
<body>

<div class="cont">
<?php 
    if(isset($_GET['tipologia'])){
        $tipologia = $_GET['tipologia'];
    }
?>            
    <h1 class="titolo">Recensione aggiunta con successo</h1>
    
    <div class="contenitore">
        <a href="catalogo_<?php echo $tipologia; ?>.php"> <button class="btn">Ritorna al catalogo</button></a>
    </div>

  </div>
</body>
</html>   