<?php
session_start();
if(!isset($_SESSION['loggato']) || $_SESSION['loggato'] !== true){
    header("location: ../file_html/login.html");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="../file_css/style2.css"/>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Area privata</title>
</head>
<body>
    <div class=reg4>
    <h1>Accesso eseguito correttamente!</h1>
<?php
echo"Bentornato ". $_SESSION["username"];
?>

<a href="../file_html/index1.html"> <br>Ritorna al sito</a>
</div>
</body>
</html>