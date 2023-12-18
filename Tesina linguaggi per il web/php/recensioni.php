<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recensioni Prodotti</title>
    <link rel="stylesheet" href="../css/style_recensioni.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
</head>
<body>

<?php
if(isset($_GET['tipologia']) && isset($_GET['id_prodotto'])){
    $tipologia = $_GET['tipologia'];
    $id_prodotto = $_GET['id_prodotto'];
    $nome = $_GET['nome'];
}
?>

<div class="home">
    <a href="catalogo_utente_<?php echo $tipologia; ?>.php">             
        <span id="casa" class="material-symbols-outlined">home</span>
    </a>
</div>

<?php
       require_once('connection.php');
session_start();

if (!isset($_SESSION['email'])) {
    // L'utente non è autenticato, puoi reindirizzarlo alla pagina di login o fare altre azioni
    header("Location: ../html/login.html");
    exit();
}else{
    $email = $_SESSION['email'];

}

if(isset($_SESSION['id'])){
   $idUtenteSessione = $_SESSION['id'];
}

    // Carica il file XML del catalogo
    $xmlFile = '../xml/catalogo_prodotti.xml';
    $dom = new DOMDocument();
    $dom->load($xmlFile);

    // Trova tutti gli elementi 'recensione' nel file XML relativi all'id_prodotto desiderato
    $xpath = new DOMXPath($dom);
    $recensioni = $xpath->query("//recensione[@id_prodotto='$id_prodotto']");

    // Mostra le recensioni in una tabella
    if ($recensioni->length > 0) {
        echo '<h1>Recensioni Prodotto ' . $nome . '</h1>';
        echo '<table>';
        echo '<tr><th>Autore</th><th>Recensione</th><th>Data e Ora</th><th>Voto Utilità</th><th>Voto Supporto</th><th>Azione</th></tr>';
    
        foreach ($recensioni as $recensione) {

           // Cerca gli elementi 'utilita' e 'supporto' con id_utente corrispondente
$utilitaNode = $xpath->query("utilita/valore[@id_utente='$idUtenteSessione']", $recensione)->item(0);
$supportoNode = $xpath->query("supporto/valore[@id_utente='$idUtenteSessione']", $recensione)->item(0);

// Assegna i valori o "N/A" se l'elemento non esiste
$utilitaValue = $utilitaNode ? $utilitaNode->nodeValue : "N/A";
$supportoValue = $supportoNode ? $supportoNode->nodeValue : "N/A";

$id_recensione = $recensione->getElementsByTagName("id_recensione")->item(0)->nodeValue;
$autore = $recensione->getElementsByTagName("autore")->item(0)->nodeValue;
$testo = $recensione->getElementsByTagName("testo")->item(0)->nodeValue;
$data = $recensione->getElementsByTagName("data")->item(0)->nodeValue;
$ora = $recensione->getElementsByTagName("ora")->item(0)->nodeValue;


            
            echo '<tr>';
            echo '<td>' . $autore . '</td>';
            echo '<td>' . $testo . '</td>';
            echo '<td>' . $data . ' ' . $ora . '</td>';
            echo '<td>' . $utilitaValue . '</td>';
            echo '<td>' . $supportoValue . '</td>';
            echo '<td>';


        // Ottieni l'id_utente dai nodi "valore" all'interno degli elementi "utilita" e "supporto"
        $utilitaIdUtente = $utilitaNode ? $utilitaNode->getAttribute("id_utente") : "N/A";
        $supportoIdUtente = $supportoNode ? $supportoNode->getAttribute("id_utente") : "N/A";


            if ($utilitaIdUtente == $_SESSION['id'] || $supportoIdUtente == $_SESSION['id']) {
                echo '<p><span id="ver" class="material-symbols-outlined">verified</span></p>';
            }  else {
               echo '<form action="utilita_supporto.php" method="post">';
                echo '<input type="hidden" name="id_recensione" value="' . $id_recensione . '"/>';
                echo '<input type="hidden" name="id_prodotto" value="' . $id_prodotto . '"/>';
                echo '<input type="hidden" name="tipologia" value="' . $tipologia . '"/>';

                // Pulsanti per il voto di utilità
                echo '<label class="uti" for="votoUtilita">Utilità (da 1 a 5): </label>';
                echo '<input class="util" type="number" name="votoUtilita" min="1" max="5" required/>'; ?><br><?php
    
                // Pulsanti per il voto di supporto
                echo '<label class="sup" for="votoSupporto">Supporto (da 1 a 3): </label>';
                echo '<input type="number" name="votoSupporto" min="1" max="3" required/>';
          
                echo '<button class="vota" type="submit" name="vota"><span id="done" title="Invia" class="material-symbols-outlined">
                done_outline
                </span></button>';
                echo '</form>';
            }
            
            echo '</td>';
            echo '</tr>';
        }echo '</table>';
    }
    else {
        echo '<p>Nessuna recensione disponibile.</p>';
     } 
?>

</body>
</html>
