<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Richiesta di Ricarica Crediti</title>
    <link rel="stylesheet" href="../css/style_ricarica.css">
</head>
<body>
    
<?php
require_once("connection.php");
session_start();

 if(!isset($_SESSION['loggato'])) {
    header("Location: ../html/login.html");
    }
    ?>

    <h1>Richiesta di Ricarica Crediti</h1>
    <form class = "form" action="process_request.php" method="post">  
        <label class="input" for="email"><?php echo 'Username: ' . $_SESSION['email']; ?></label>
        <br><br><br>
        <label class="input" for="credito"><?php echo 'Credito Residuo: ' . $_SESSION['crediti']; ?></label>
        <br><br><br>
        <label for="importo">Importo richiesto:</label>
        <input type="number" name="importo" required>
        <br><br><br>
        <input class="btn" type="submit" value="Invia richiesta">
    </form>
</body>
</html>
