<?php
session_start();

if (!isset($_SESSION['loggato'])) {
    header("Location: ../html/login.html");
    exit();
}

$email = $_SESSION['email'];
$crediti = $_SESSION['crediti'];


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Richiesta di Ricarica Crediti</title>
    <link rel="stylesheet" href="../css/style_ricarica.css">
</head>
<body>
<div class="home">
                    <a href="../html/index_loggato.html">
                <div class="home_link" title="home"><img src="../img/home1.png" alt="home"></div></a>
            </div>
    
    <h1>Richiesta di Ricarica Crediti</h1>
    <p class="info">Username: <?php echo $email; ?></p>
    <p class="info">Credito Residuo: <?php echo $crediti; ?></p>
   <form class="form" action="process_request.php" method="post">
        <label for="importo">Importo richiesto:</label>
        <input type="number" name="importo" required>
        <br><br><br>
        <input class="submit" type="submit" value="Invia richiesta">
    </form>
</body>
</html>
