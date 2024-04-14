<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="../file_css/style2.css" type="text/css">

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>gestione credito</title>
</head>
<body>
   
<div class="reg">

<?php
require_once("connection.php");
session_start();

 if(!isset($_SESSION['loggato'])) {
    header("Location: ../HTML/login.html");
    }
    

?>

<form action="../file_php/ricarica.php" method= "post">
<h1>Credito</h1>

<label for="username"><?php echo 'Username: ' . $_SESSION['username']; ?></label>
<label for="credito"><?php echo 'Credito Residuo: ' . $_SESSION['crediti']; ?></label>

<label for="ricaricaeuro">Ricarica Credito</label>
<input type="text" name="ricarica" id="ricarica">

<input type="submit" value="Invia"></input>

<p class="home"> Torna alla home <a href="../HTML/index1.html">Home</a></p>
</form>

    </div>
  </body>
</html>