<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style_errore.css" type="text/css">

    <title>Domande</title>
</head>
<body>
<?php 
  if(isset($_GET['tipologia'])){
    $tipologia = $_GET['tipologia'];
  }
?>

    <div>
            
        <h1>Domanda aggiunta con successo</h1>

        <a href="catalogo_utente_<?php echo $tipologia; ?>.php"> <button class="btn">Ritorna al catalogo</button></a>
</body>
</html>            
