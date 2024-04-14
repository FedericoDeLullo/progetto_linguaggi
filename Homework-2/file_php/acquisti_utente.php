<?php

require_once('connection.php');

session_start();
$username=$_SESSION['username'];

$query="SELECT* from articoli ar, acquisti ac where ac.username='$username' and ar.id_articolo=ac.id_articolo"
?>
 <?php

if(!isset($_SESSION['loggato'])) {
header("Location: ../HTML/login.html");
}
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="../file_css/style.css" type="text/css"/>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>I miei acquisti</title>
</head>
<body>
<h2 class="miei-acq">I MIEI ACQUISTI</h2>
		<div class="tabella">
			<ul class="riga prima">
				 <li>Nome</li>
				 <li>Quantità</li>
				 <li>Prezzo unitario</li>
			</ul>
				<?php

					$res = mysqli_query($connessione,$query);

					if(mysqli_num_rows($res) > 0){

			 			foreach ($res as $row){
			 				echo "<ul class=\"riga\">
			 						<li>" . $row['nome'] . "</li>
			 						<li>" . $row['quantita'] . "</li>
			 						<li>" . $row['prezzo'] . " &euro;</li>
			 					 </ul>";
			 			}
					} else {
						echo "<p class=\"no\">NON CI SONO ACQUISTI</p>";
					}
                    ?>
                    <a href="../HTML/index1.html"><button class="btn2">Torna alla Home</button></a>
</body>
</html>