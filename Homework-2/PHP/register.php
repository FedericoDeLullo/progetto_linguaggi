<?php
    session_start();

    if(isset($_COOKIE["tema"]) && $_COOKIE["tema"] == "dark"){
        echo "<link rel=\"stylesheet\" href=\"../file_css/style_dark_login.css\" type=\"text/css\" />";
    }
    else{
        echo "<link rel=\"stylesheet\" href=\"../file_css/style2.css\" type=\"text/css\" />";
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login in php</title>
</head>
<body>
    
<div class=reg1>
<form action="../file_php/register.php" method= "post">
<h1>Registrati</h1>



<label for="username">Username</label>
<input type="text" name="username" id="username">

<label for="email">Email</label>
<input type="email" name="email" id="email">

<label for="password">Password</label>
<input type="password" name="password" id="password">

<input type="submit" value="Invia"></input>

<p>Hai già un account? <a href="../PHP/login.php">Accedi</a></p>
<p class="home"> Torna alla home <a href="../PHP/index.php">Home</a></p>

</form>

    </div>
  </body>
</html>