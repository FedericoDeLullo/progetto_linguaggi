<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista Recensioni</title>
    <link rel="stylesheet" href="../css/style_standard.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="../css/style_header.css">
    <?php
        include('../res/header.php');
    ?>
</head>
<body>

<div class="cont">
<?php
if(isset($_SESSION['successo_segnalazione_recensione']) && $_SESSION['successo_segnalazione_recensione'] == 'true'){
    echo '<h2 id="successo">Segnalazione della recensione inviata con successo. Attendere l\'approvazione del gestore...</h2>';
    unset($_SESSION['successo_segnalazione_recensione']);
}
if(isset($_SESSION['creazione_recensione']) && $_SESSION['creazione_recensione'] == 'true'){
    echo '<h2 id="successo">Recensione aggiunta con successo!</h2>';
    unset($_SESSION['creazione_recensione']);
}
require_once('../res/connection.php');
if(isset($_SESSION['loggato'])){
 $id_utente = $_SESSION['id'];
 $gestore = $_SESSION['gestore'];
 $admin = $_SESSION['ammin'];
 $utente = $_SESSION['utente'];
     if($gestore == 1 || $admin == 1){ 


if (isset($_GET['tipologia']) && isset($_GET['id_prodotto'])) {
    $tipologia = $_GET['tipologia'];
    $id_prodotto = $_GET['id_prodotto'];
    $nome = $_GET['nome'];
}
if(isset($_SESSION['id'])){
    $idUtenteSessione = $_SESSION['id'];
 }

$xmlFile = '../xml/catalogo_prodotti.xml';
$dom = new DOMDocument();
$dom->load($xmlFile);

// Trova tutti gli elementi 'recensione' nel file XML relativi all'id_prodotto desiderato
$xpath = new DOMXPath($dom);
$recensioni = $xpath->query("//recensioni/recensione[@id_prodotto='$id_prodotto']");

// Mostra le recensioni in una tabella
if ($recensioni->length > 0) {
    echo '<h1 class="titolo">Recensioni del prodotto: ' . $nome . '</h1>';
    echo '<table>';



    foreach ($recensioni as $recensione) {  
          $id_utente_recensione = $recensione->getAttribute("id_utente");
         if($id_utente == $id_utente_recensione){
          echo '<tr><th>Gestione Recensione</th><th>Autore</th><th>Recensione</th><th>Data e Ora</th><th>Voto Utilità</th><th>Voto Supporto</th><th>Azione</th></tr>';

        
        $utilitaNode = $xpath->query("utilita/valore[@id_utente='$idUtenteSessione']", $recensione)->item(0);
        $supportoNode = $xpath->query("supporto/valore[@id_utente='$idUtenteSessione']", $recensione)->item(0);

          // Recupera attributi e valori da utilita e supporto
        $utilitaValue = $utilitaNode ? $utilitaNode->nodeValue : "N/A";
        $supportoValue = $supportoNode ? $supportoNode->nodeValue : "N/A";

        
        $id_recensione = $recensione->getElementsByTagName("id_recensione")->item(0)->nodeValue;
        $autore = $recensione->getElementsByTagName("autore")->item(0)->nodeValue;
        $testo = $recensione->getElementsByTagName("testo")->item(0)->nodeValue;
        $data = $recensione->getElementsByTagName("data")->item(0)->nodeValue;
        $ora = $recensione->getElementsByTagName("ora")->item(0)->nodeValue;
        $id_recensione = $recensione->getElementsByTagName("id_recensione")->item(0)->nodeValue;

       
        echo '<tr>';
        echo '<td>';
        echo '<p>';
        echo '<a href="elimina_recensioni.php?id_prodotto=' . urlencode($id_prodotto) . '&id_recensione=' . $id_recensione. '&testo_recensione='. $testo .'&autoreRecensione='. $autore .'&tipologia='. $tipologia . '&nome='. $nome . '"><span id="simbolo_recensione" class="material-symbols-outlined">delete</span></a>';
        echo '</p>';
        echo '</td>';
        echo '<td><strong>' . $autore . '</strong></td>';
        echo '<td>' . $testo . '</td>';
        echo '<td>' . $data . ' ' . $ora . '</td>';
        echo '<td>';
        echo '---';
        echo '</td>';echo '<td>';
        echo '---';
        echo '</td>';
        echo '<td>';
        echo '---';
        echo '</td>'; 
        
    
         }else{
            echo '<tr><th>Gestione Recensione</th><th>Autore</th><th>Recensione</th><th>Data e Ora</th><th>Voto Utilità</th><th>Voto Supporto</th><th>Azione</th></tr>';
        
        
        $utilitaNode = $xpath->query("utilita/valore[@id_utente='$idUtenteSessione']", $recensione)->item(0);
        $supportoNode = $xpath->query("supporto/valore[@id_utente='$idUtenteSessione']", $recensione)->item(0);

          // Recupera attributi e valori da utilita e supporto
        $utilitaValue = $utilitaNode ? $utilitaNode->nodeValue : "N/A";
        $supportoValue = $supportoNode ? $supportoNode->nodeValue : "N/A";

        
        $id_recensione = $recensione->getElementsByTagName("id_recensione")->item(0)->nodeValue;
        $autore = $recensione->getElementsByTagName("autore")->item(0)->nodeValue;
        $testo = $recensione->getElementsByTagName("testo")->item(0)->nodeValue;
        $data = $recensione->getElementsByTagName("data")->item(0)->nodeValue;
        $ora = $recensione->getElementsByTagName("ora")->item(0)->nodeValue;
        $id_recensione = $recensione->getElementsByTagName("id_recensione")->item(0)->nodeValue;

       
        echo '<tr>';
        echo '<td>';
        echo '<p>';
        echo '<a href="elimina_recensioni.php?id_prodotto=' . urlencode($id_prodotto) . '&id_recensione=' . $id_recensione. '&testo_recensione='. $testo .'&autoreRecensione='. $autore .'&tipologia='. $tipologia . '&nome='. $nome . '"><span id="simbolo_recensione" class="material-symbols-outlined">delete</span></a>';
        echo '</p>';
        echo '</td>';
        echo '<td><strong>' . $autore . '</strong></td>';
        echo '<td>' . $testo . '</td>';
        echo '<td>' . $data . ' ' . $ora . '</td>';
        echo '<td>' . $utilitaValue . '</td>';
        echo '<td>' . $supportoValue . '</td>';
        echo '<td>';

        $utilitaIdUtente = $utilitaNode ? $utilitaNode->getAttribute("id_utente") : "N/A";
        $supportoIdUtente = $supportoNode ? $supportoNode->getAttribute("id_utente") : "N/A";


        // Verifica se l'utente ha già votato questa recensione
        if ($utilitaIdUtente == $_SESSION['id'] || $supportoIdUtente == $_SESSION['id']) {
            echo '<p class="nome"><span class="material-symbols-outlined">verified</span></p>';
        } else {
            // Se l'utente non ha ancora votato, mostra i pulsanti per il voto
            echo '<form action="../res/utilita_supporto.php" method="post">';
            echo '<input type="hidden" name="id_recensione" value="' . $id_recensione . '"/>';
            echo '<input type="hidden" name="id_prodotto" value="' . $id_prodotto . '"/>';
            echo '<input type="hidden" name="tipologia" value="' . $tipologia . '"/>';
            echo '<input type="hidden" name="id_utente" value="' . $id_utente . '"/>';

            
            // Pulsanti per il voto di utilità
            echo '<label class="nome" for="votoUtilita">Utilità (da 1 a 5): </label>';
            echo '<input class="input" type="number" name="votoUtilita" min="1" max="5" required/><br>';

            // Pulsanti per il voto di supporto
            echo '<label class="nome" for="votoSupporto">Supporto (da 1 a 3): </label>';
            echo '<input class="input" type="number" name="votoSupporto" min="1" max="3" required/>';

            echo '<button class="done" type="submit" name="vota"><span title="Invia" class="material-symbols-outlined">done_outline</span></button>';
            echo '</form>';
        }

        echo '</td>';
        echo '</tr>';
    }


  }      echo '</table>';

 }else {
    echo '<tr><td colspan="4"><p class="titolo">Nessuna recensione disponibile.</p></td></tr>';
}
}
elseif($utente = 1){
    if (isset($_GET['tipologia']) && isset($_GET['id_prodotto'])) {
        $tipologia = $_GET['tipologia'];
        $id_prodotto = $_GET['id_prodotto'];
        $nome = $_GET['nome'];
    }
    if(isset($_SESSION['id'])){
        $idUtenteSessione = $_SESSION['id'];
     }
    
    $xmlFile = '../xml/catalogo_prodotti.xml';
    $dom = new DOMDocument();
    $dom->load($xmlFile);
    
    // Trova tutti gli elementi 'recensione' nel file XML relativi all'id_prodotto desiderato
    $xpath = new DOMXPath($dom);
    $recensioni = $xpath->query("//recensioni/recensione[@id_prodotto='$id_prodotto']");
    
    // Mostra le recensioni in una tabella
    if ($recensioni->length > 0) {
        echo '<h1 class="titolo">Recensioni del prodotto: ' . $nome . '</h1>';
        echo '<table>';
    
    
    
        foreach ($recensioni as $recensione) {  
              $id_utente_recensione = $recensione->getAttribute("id_utente");
             if($id_utente == $id_utente_recensione){
              echo '<tr><th>Gestione Recensione</th><th>Autore</th><th>Recensione</th><th>Data e Ora</th><th>Voto Utilità</th><th>Voto Supporto</th><th>Azione</th></tr>';
    
            
            $utilitaNode = $xpath->query("utilita/valore[@id_utente='$idUtenteSessione']", $recensione)->item(0);
            $supportoNode = $xpath->query("supporto/valore[@id_utente='$idUtenteSessione']", $recensione)->item(0);
    
              // Recupera attributi e valori da utilita e supporto
            $utilitaValue = $utilitaNode ? $utilitaNode->nodeValue : "N/A";
            $supportoValue = $supportoNode ? $supportoNode->nodeValue : "N/A";
    
            
            $id_recensione = $recensione->getElementsByTagName("id_recensione")->item(0)->nodeValue;
            $autore = $recensione->getElementsByTagName("autore")->item(0)->nodeValue;
            $testo = $recensione->getElementsByTagName("testo")->item(0)->nodeValue;
            $data = $recensione->getElementsByTagName("data")->item(0)->nodeValue;
            $ora = $recensione->getElementsByTagName("ora")->item(0)->nodeValue;
            $id_recensione = $recensione->getElementsByTagName("id_recensione")->item(0)->nodeValue;

           
            echo '<tr>';
            echo '<td>';
            echo '<p>';
            echo '<a href="elimina_recensioni.php?id_prodotto=' . urlencode($id_prodotto) . '&id_recensione=' . $id_recensione. '&testo_recensione='. $testo .'&autoreRecensione='. $autore .'&tipologia='. $tipologia . '&nome='. $nome . '"><span id="simbolo_recensione" class="material-symbols-outlined">delete</span></a>';
            echo '</p>';
            echo '</td>';
            echo '<td><strong>' . $autore . '</strong></td>';
            echo '<td>' . $testo . '</td>';
            echo '<td>' . $data . ' ' . $ora . '</td>';
            echo '<td>';
            echo '---';
            echo '</td>';echo '<td>';
            echo '---';
            echo '</td>';
            echo '<td>';
            echo '---';
            echo '</td>'; 
            
        
             }else{
                echo '<tr><th>Gestione Recensione</th><th>Autore</th><th>Recensione</th><th>Data e Ora</th><th>Voto Utilità</th><th>Voto Supporto</th><th>Azione</th></tr>';
            
            
            $utilitaNode = $xpath->query("utilita/valore[@id_utente='$idUtenteSessione']", $recensione)->item(0);
            $supportoNode = $xpath->query("supporto/valore[@id_utente='$idUtenteSessione']", $recensione)->item(0);
    
              // Recupera attributi e valori da utilita e supporto
            $utilitaValue = $utilitaNode ? $utilitaNode->nodeValue : "N/A";
            $supportoValue = $supportoNode ? $supportoNode->nodeValue : "N/A";
    
            
            $id_recensione = $recensione->getElementsByTagName("id_recensione")->item(0)->nodeValue;
            $autore = $recensione->getElementsByTagName("autore")->item(0)->nodeValue;
            $testo = $recensione->getElementsByTagName("testo")->item(0)->nodeValue;
            $data = $recensione->getElementsByTagName("data")->item(0)->nodeValue;
            $ora = $recensione->getElementsByTagName("ora")->item(0)->nodeValue;
            $id_recensione = $recensione->getElementsByTagName("id_recensione")->item(0)->nodeValue;

           
            echo '<tr>';
            echo '<td>';
            echo '<p>';
            echo '<a href="segnalazione.php?id_prodotto=' . urlencode($id_prodotto) . '&id_recensione=' . $id_recensione. '&testo_recensione='. $testo .'&autoreRecensione='. $autore . '&nome=' . $nome . '&tipologia='. $tipologia .'"><span id="simbolo_recensione" class="material-symbols-outlined">report</span></a>';
            echo '</p>';
            echo '</td>';
            echo '<td><strong>' . $autore . '</strong></td>';
            echo '<td>' . $testo . '</td>';
            echo '<td>' . $data . ' ' . $ora . '</td>';
            echo '<td>' . $utilitaValue . '</td>';
            echo '<td>' . $supportoValue . '</td>';
            echo '<td>';
    
            $utilitaIdUtente = $utilitaNode ? $utilitaNode->getAttribute("id_utente") : "N/A";
            $supportoIdUtente = $supportoNode ? $supportoNode->getAttribute("id_utente") : "N/A";
    
    
            // Verifica se l'utente ha già votato questa recensione
            if ($utilitaIdUtente == $_SESSION['id'] || $supportoIdUtente == $_SESSION['id']) {
                echo '<p class="nome"><span class="material-symbols-outlined">verified</span></p>';
            } else {
                // Se l'utente non ha ancora votato, mostra i pulsanti per il voto
                echo '<form action="../res/utilita_supporto.php" method="post">';
                echo '<input type="hidden" name="id_recensione" value="' . $id_recensione . '"/>';
                echo '<input type="hidden" name="id_prodotto" value="' . $id_prodotto . '"/>';
                echo '<input type="hidden" name="tipologia" value="' . $tipologia . '"/>';
                echo '<input type="hidden" name="id_utente" value="' . $id_utente . '"/>';
                echo '<input type="hidden" name="nome" value="' . $nome . '"/>';

                
                // Pulsanti per il voto di utilità
                echo '<label class="nome" for="votoUtilita">Utilità (da 1 a 5): </label>';
                echo '<input class="input" type="number" name="votoUtilita" min="1" max="5" required/><br>';
    
                // Pulsanti per il voto di supporto
                echo '<label class="nome" for="votoSupporto">Supporto (da 1 a 3): </label>';
                echo '<input class="input" type="number" name="votoSupporto" min="1" max="3" required/>';
    
                echo '<button class="done" type="submit" name="vota"><span title="Invia" class="material-symbols-outlined">done_outline</span></button>';
                echo '</form>';
            }
    
            echo '</td>';
            echo '</tr>';
        }
    
    
      }      echo '</table>';
    
     } else {
        echo '<tr><td colspan="4"><p class="titolo">Nessuna recensione disponibile.</p></td></tr>';
    }
}


} 
?>
</div>

</body>
</html>