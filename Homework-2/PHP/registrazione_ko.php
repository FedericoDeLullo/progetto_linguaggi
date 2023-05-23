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
        <title>Area privata</title>
    </head>
    <body>
        <div class=reg4>
            <h1>Utente gi&agrave; esistente!</h1>

            <a href="../PHP/register.php"> <br>Ritorna alla registrazione</a>
        </div>
    </body>
</html>