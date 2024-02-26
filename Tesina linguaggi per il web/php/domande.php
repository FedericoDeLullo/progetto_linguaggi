<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recensioni Prodotti</title>
    <link rel="stylesheet" href="../css/style_standard.css">
    <link rel="stylesheet" href="../css/style_catalogo.css">
    <link rel="stylesheet" href="../css/style_search.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="../css/style_header.css">
    <?php
        include('../res/header.php');
    ?>
</head>
<body>
<div class="cont">
<?php
if(isset($_GET['tipologia']) && isset($_GET['id_prodotto'])){
    $tipologia = $_GET['tipologia'];
    $id_prodotto = $_GET['id_prodotto'];
    $nome = $_GET['nome'];
}

if(isset($_SESSION['successo_segnalazione_domanda']) && $_SESSION['successo_segnalazione_domanda'] == 'true'){
    echo '<h2 id="successo">Segnalazione della domanda inviata con successo. Attendere l\'approvazione del gestore...</h2>';
    unset($_SESSION['successo_segnalazione_domanda']);
}
if(isset($_SESSION['successo_segnalazione_risposta']) && $_SESSION['successo_segnalazione_risposta'] == 'true'){
    echo '<h2 id="successo">Segnalazione della risposta inviata con successo. Attendere l\'approvazione del gestore...</h2>';
    unset($_SESSION['successo_segnalazione_risposta']);
}
if(isset($_SESSION['creazione_domanda']) && $_SESSION['creazione_domanda'] == 'true'){
    echo '<h2 id="successo">Domanda aggiunta con successo!</h2>';
    unset($_SESSION['creazione_domanda']);
}
?>

<?php
       require_once('../res/connection.php');
       if(isset($_SESSION['loggato'])){
        $id_utente = $_SESSION['id'];
        $gestore = $_SESSION['gestore'];
        $admin = $_SESSION['ammin'];
        $utente = $_SESSION['utente'];
            if($utente == 1){ 

if (!isset($_SESSION['email'])) {
    // L'utente non è autenticato, puoi reindirizzarlo alla pagina di login o fare altre azioni
    header("Location: login_cliente.php");
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

    // Trova tutti gli elementi 'domande' nel file XML relativi all'id_prodotto desiderato
    $xpath = new DOMXPath($dom);
    $domande = $xpath->query("//domande/domanda[@id_prodotto='$id_prodotto']");

// Mostra le domande e i form di risposta in una tabella


if ($domande->length > 0) {
    echo '<h1 class="titolo">Domande Prodotto: ' . $nome . '</h1>';
    echo '<table>';


    foreach ($domande as $domanda) {    
        $id_utente_domanda = $domanda->getAttribute("id_utente");
        if($id_utente == $id_utente_domanda){
            echo '<tr>';
        echo '<th>Gestisci Domanda</th><th>Autore Domanda</th><th>Domanda</th><th>Voto Utilità</th><th>Voto Supporto</th><th>Valutazione</th><th>Rispondi</th>';
        echo '</tr>';
        
        $utilitaNode = $xpath->query("utilita/valore[@id_utente='$idUtenteSessione']", $domanda)->item(0);
        $supportoNode = $xpath->query("supporto/valore[@id_utente='$idUtenteSessione']", $domanda)->item(0);

        // Ottieni i valori di utilità e supporto o imposta "N/A" se non presenti
        $utilitaValue = $utilitaNode ? $utilitaNode->nodeValue : "N/A";
        $supportoValue = $supportoNode ? $supportoNode->nodeValue : "N/A";

        $id_domanda = $domanda->getElementsByTagName("id_domanda")->item(0)->nodeValue;
        $autoreDomanda = $domanda->getElementsByTagName("autore")->item(0)->nodeValue;
        $testoDomanda = $domanda->getElementsByTagName("testo")->item(0)->nodeValue;
        
        echo '<tr>';
        echo '<td>';
        echo '<p>';
        echo '<a title="Elimina" href="elimina_dom_risp.php?id_domanda=' . urlencode($id_domanda) . '&nome=' . $nome . '&testo_domanda=' . urlencode($testoDomanda) . '&id_prodotto=' . urlencode($id_prodotto) . '"><span id="simbolo_recensione" class="material-symbols-outlined">delete</span></a>';
        echo '</p>';
        echo '</td>';
        echo '<td><strong>' . $autoreDomanda . '</strong></td>';
        echo '<td>' . $testoDomanda . '</td>'; 
        echo '<td>';
        echo '---';
        echo '</td>'; 
        echo '<td>';
        echo '---';
        echo '</td>';
        echo '<td>';
        echo '---';
        echo '</td>';
        echo '<td>';
        echo '---';
        echo '</td>';
        }
 else {
        echo '<tr>';
        echo '<th>Gestisci Domanda</th><th>Autore Domanda</th><th>Domanda</th><th>Voto Utilità</th><th>Voto Supporto</th><th>Valutazione</th><th>Rispondi</th>';
        echo '</tr>';
        
        $utilitaNode = $xpath->query("utilita/valore[@id_utente='$idUtenteSessione']", $domanda)->item(0);
        $supportoNode = $xpath->query("supporto/valore[@id_utente='$idUtenteSessione']", $domanda)->item(0);

        // Ottieni i valori di utilità e supporto o imposta "N/A" se non presenti
        $utilitaValue = $utilitaNode ? $utilitaNode->nodeValue : "N/A";
        $supportoValue = $supportoNode ? $supportoNode->nodeValue : "N/A";

        $id_domanda = $domanda->getElementsByTagName("id_domanda")->item(0)->nodeValue;
        $autoreDomanda = $domanda->getElementsByTagName("autore")->item(0)->nodeValue;
        $testoDomanda = $domanda->getElementsByTagName("testo")->item(0)->nodeValue;
        
        echo '<tr>';
        echo '<td>';
        echo '<p>';
        echo '<a title="Segnala" href="segnalazione.php?id_domanda=' . urlencode($id_domanda) . '&nome=' . $nome . '&testo_domanda=' . urlencode($testoDomanda) . '&id_prodotto=' . urlencode($id_prodotto) . '&autoreDomanda='. $autoreDomanda . '&tipologia='. $tipologia .'"><span id="simbolo_recensione" class="material-symbols-outlined">report</span></a>';
        echo '</p>';
        echo '</td>';
        echo '<td><strong>' . $autoreDomanda . '</strong></td>';
        echo '<td>' . $testoDomanda . '</td>'; 
        echo '<td>' . $utilitaValue . '</td>';
        echo '<td>' . $supportoValue . '</td>';
        
        // Ottieni l'id_utente dai nodi "valore" all'interno degli elementi "utilita" e "supporto"
        $utilitaIdUtente = $utilitaNode ? $utilitaNode->getAttribute("id_utente") : "N/A";
        $supportoIdUtente = $supportoNode ? $supportoNode->getAttribute("id_utente") : "N/A";

        if ($utilitaIdUtente == $_SESSION['id'] || $supportoIdUtente == $_SESSION['id']) {
            echo '<td><p><span id="ver" class="material-symbols-outlined">verified</span></p></td>';
        }  else {
         // Colonna per i pulsanti di voto delle domande
        echo '<td>';
        echo '<form action="../res/domande_utilita_supporto.php" method="post">';
        echo '<input type="hidden" name="id_domanda" value="' . $id_domanda . '"/>';
        echo '<input type="hidden" name="id_prodotto" value="' . $id_prodotto . '"/>';
        echo '<input type="hidden" name="tipologia" value="' . $tipologia . '"/>';
        echo '<input type="hidden" name="nome" value="' . $nome . '"/>';

        echo '<label class="titolo" for="votoUtilita">Utilità (da 1 a 5): </label>';
        echo '<input class="input" type="number" name="votoUtilita" min="1" max="5" required/><br>';
    
        echo '<label class="titolo" for="votoSupporto">Supporto (da 1 a 3): </label>';
        echo '<input class="input" type="number" name="votoSupporto" min="1" max="3" required/>';
    
        echo '<button class="done" type="submit" name="vota">CONFERMA<span id="done" title="Invia" class="material-symbols-outlined">done_outline</span></button>';
        echo '</form>';
   
        echo '</td>';
        }
        echo '<td>';
        // Form per rispondere alla domanda
        echo '<form action="../res/risposte.php" method="post">';
        echo '<input type="hidden" name="id_prodotto" value="' . $id_prodotto . '"/>';
        echo '<input type="hidden" name="tipologia" value="' . $tipologia . '"/>';
        echo '<input type="hidden" name="nome" value="' . $nome . '"/>';            
        echo '<input type="hidden" name="autore" value="' . $email . '"/>';
        echo '<input type="hidden" name="id_domanda" value="' . $id_domanda . '"/>';
        echo '<textarea style="height:50px; resize:none; vertical-align:top;" class="input" name="risposta" placeholder="Inserisci la risposta..." required></textarea>';
        echo '<button class="btn" type="submit">Invia risposta</button>';
        

        echo '</form>';
        echo '</tr>';
 }
 
        // Mostra le risposte
        $risposte = $domanda->getElementsByTagName('risposta');
        if ($risposte->length > 0) {
            echo '<tr><th class="risp">Gestisci Risposta</th><th class="risp">Autore Risposta</th><th class="risp">Risposta</th><th>Voto Utilità</th><th>Voto Supporto</th><th class="risp">Valutazione</th></tr>';
        
            foreach ($risposte as $risposta) {
                $id_utente_risposta=$risposta->getAttribute('id_utente');
                if($id_utente_risposta == $id_utente){
                $utilitaNode = $xpath->query("utilita_risposta/valore[@id_utente='$idUtenteSessione']", $risposta)->item(0);
                $supportoNode = $xpath->query("supporto_risposta/valore[@id_utente='$idUtenteSessione']", $risposta)->item(0);
            
                // Ottieni i valori di utilità e supporto o imposta "N/A" se non presenti
                $utilitaValue = $utilitaNode ? $utilitaNode->nodeValue : "N/A";
                $supportoValue = $supportoNode ? $supportoNode->nodeValue : "N/A";
            
                $id_domanda = $risposta->getElementsByTagName("id_domanda")->item(0)->nodeValue;
                $id_risposta = $risposta->getElementsByTagName("id_risposta")->item(0)->nodeValue;
                $autoreRisposta = $risposta->getElementsByTagName("autore")->item(0)->nodeValue;
                $dataRisposta = $risposta->getElementsByTagName("data")->item(0)->nodeValue;
                $oraRisposta = $risposta->getElementsByTagName("ora")->item(0)->nodeValue;
                $testoRisposta = $risposta->getElementsByTagName("testo")->item(0)->nodeValue;
        
                
              // Nuova riga per ogni risposta
                echo '<tr>';
                echo '<td>';
                echo '<p>';
                echo '<a title="Elimina" href="elimina_dom_risp.php?id_prodotto=' . urlencode($id_prodotto) . '&nome=' . $nome . '&id_risposta=' . urlencode($id_risposta) . '&testo_risposta=' . urlencode($testoRisposta) . '"><span id="simbolo_recensione" class="material-symbols-outlined">delete</span></a>';
                echo '</p>';
                echo '</td>';          
                echo '<td>';
                echo '<strong>' . $autoreRisposta . '</strong> ha risposto il ' . $dataRisposta . ' alle ' . $oraRisposta;
                echo '</td>';
                echo '<td style="max-width:300px; word-wrap: break-word;">';
                echo $testoRisposta;
                echo '</td>';
                echo '<td>';
                echo '---';
                echo '</td>'; echo '<td>';
                echo '---';
                echo '</td>'; echo '<td>';
                echo '---';
                echo '</td>'; 
                
            } else {
                $utilitaNode = $xpath->query("utilita_risposta/valore[@id_utente='$idUtenteSessione']", $risposta)->item(0);
                $supportoNode = $xpath->query("supporto_risposta/valore[@id_utente='$idUtenteSessione']", $risposta)->item(0);
            
                // Ottieni i valori di utilità e supporto o imposta "N/A" se non presenti
                $utilitaValue = $utilitaNode ? $utilitaNode->nodeValue : "N/A";
                $supportoValue = $supportoNode ? $supportoNode->nodeValue : "N/A";
            
                $id_risposta = $risposta->getElementsByTagName("id_risposta")->item(0)->nodeValue;
                $autoreRisposta = $risposta->getElementsByTagName("autore")->item(0)->nodeValue;
                $dataRisposta = $risposta->getElementsByTagName("data")->item(0)->nodeValue;
                $oraRisposta = $risposta->getElementsByTagName("ora")->item(0)->nodeValue;
                $testoRisposta = $risposta->getElementsByTagName("testo")->item(0)->nodeValue;
        
                
              // Nuova riga per ogni risposta
                echo '<tr>';
                echo '<td>';
                echo '<p>';
                echo '<a title="Segnala" href="segnalazione.php?id_prodotto=' . urlencode($id_prodotto) . '&nome=' . $nome . '&id_risposta=' . urlencode($id_risposta) . '&testo_risposta=' . urlencode($testoRisposta) . '&autoreRisposta=' . $autoreRisposta . '&id_domanda=' . $id_domanda . '&tipologia='. $tipologia .'"><span id="simbolo_recensione" class="material-symbols-outlined">report</span></a>';
                echo '</p>';
                echo '</td>';          
                echo '<td>';
                echo '<strong>' . $autoreRisposta . '</strong> ha risposto il ' . $dataRisposta . ' alle ' . $oraRisposta;
                echo '</td>';
                echo '<td style="max-width:300px; word-wrap: break-word;">';
                echo $testoRisposta;
                echo '</td>';
                echo '<td>' . $utilitaValue . '</td>';
                echo '<td>' . $supportoValue . '</td>';
                echo '<td>';

                
        // Ottieni l'id_utente dai nodi "valore" all'interno degli elementi "utilita" e "supporto"
        $utilitaIdUtente = $utilitaNode ? $utilitaNode->getAttribute("id_utente") : "N/A";
        $supportoIdUtente = $supportoNode ? $supportoNode->getAttribute("id_utente") : "N/A";


        if ($utilitaIdUtente == $_SESSION['id'] || $supportoIdUtente == $_SESSION['id']) {
            echo '<p><span id="ver" class="material-symbols-outlined">verified</span></p>';
        }  else {
                // Colonna per i pulsanti di voto delle risposte
                echo '<div>';
                echo '<form action="../res/risposte_utilita_supporto.php" method="post">';
                echo '<input type="hidden" name="id_domanda" value="' . $id_domanda . '"/>';
                echo '<input type="hidden" name="id_risposta" value="' . $id_risposta . '"/>';
                echo '<input type="hidden" name="id_prodotto" value="' . $id_prodotto . '"/>';
                echo '<input type="hidden" name="tipologia" value="' . $tipologia . '"/>';
                echo '<input type="hidden" name="nome" value="' . $nome . '"/>';            

                echo '<label class="titolo" for="votoUtilita">Utilità (da 1 a 5): </label>';
                echo '<input class="input" type="number" name="votoUtilita" min="1" max="5" required/><br>';
            
                echo '<label class="titolo" for="votoSupporto">Supporto (da 1 a 3): </label>';
                echo '<input class="input" type="number" name="votoSupporto" min="1" max="3" required/>';
            
                echo '<button class="done" type="submit" name="vota">CONFERMA<span id="done" title="Invia" class="material-symbols-outlined">done_outline</span></button>';
                echo '</form>';
                   }
                echo '</div>';
        
                echo '</td>';
                echo '</tr>';
            
            }
          }
        }
      }
    } else {
            echo '<tr><td colspan="4"><p class="titolo">Nessuna domanda disponibile.</p></td></tr>';
        }
    }
     elseif($gestore == 1 || $admin == 1){
        
if (!isset($_SESSION['email'])) {
    // L'utente non è autenticato, puoi reindirizzarlo alla pagina di login o fare altre azioni
    header("Location: login_cliente.php");
    exit();
}else{
    $email = $_SESSION['email'];

}

if(isset($_SESSION['id'])){
   $idUtenteSessione = $_SESSION['id'];
}

if(isset($_GET['id_prodotto'])){
    $id_prodotto = $_GET['id_prodotto']; 
}


    // Carica il file XML del catalogo
    $xmlFile = '../xml/catalogo_prodotti.xml';
    $dom = new DOMDocument();
    $dom->load($xmlFile);

    // Trova tutti gli elementi 'domande' nel file XML relativi all'id_prodotto desiderato
    $xpath = new DOMXPath($dom);
    $domande = $xpath->query("//domande/domanda[@id_prodotto='$id_prodotto']");

// Mostra le domande e i form di risposta in una tabella


if(isset($_GET['nome']) && isset($_GET['tipologia'])){
    
    $nome = $_GET['nome'];
    $tipologia = $_GET['tipologia'];

}

if ($domande->length > 0) {
    echo '<h1 class="titolo">Domande Prodotto: ' . $nome . '</h1>';
    echo '<table>';


    foreach ($domande as $domanda) { 
        $id_utente_domanda = $domanda->getAttribute("id_utente");
        if($id_utente == $id_utente_domanda){

            echo '<tr>';
        echo '<th>Gestisci Domanda</th><th>Autore Domanda</th><th>Domanda</th><th>Voto Utilità</th><th>Voto Supporto</th><th>Valutazione</th><th>Rispondi</th>';
        echo '</tr>';
        
        $utilitaNode = $xpath->query("utilita/valore[@id_utente='$idUtenteSessione']", $domanda)->item(0);
        $supportoNode = $xpath->query("supporto/valore[@id_utente='$idUtenteSessione']", $domanda)->item(0);

        // Ottieni i valori di utilità e supporto o imposta "N/A" se non presenti
        $utilitaValue = $utilitaNode ? $utilitaNode->nodeValue : "N/A";
        $supportoValue = $supportoNode ? $supportoNode->nodeValue : "N/A";

        $id_domanda = $domanda->getElementsByTagName("id_domanda")->item(0)->nodeValue;
        $autoreDomanda = $domanda->getElementsByTagName("autore")->item(0)->nodeValue;
        $testoDomanda = $domanda->getElementsByTagName("testo")->item(0)->nodeValue;
        
        echo '<tr>';
        echo '<td>';
        echo '<p>';
        echo '<a title="Elimina" href="elimina_dom_risp.php?id_domanda=' . urlencode($id_domanda) . '&nome=' . $nome . '&testo_domanda=' . urlencode($testoDomanda) . '&id_prodotto=' . urlencode($id_prodotto) . '"><span id="simbolo_recensione" class="material-symbols-outlined">delete</span></a>';
        echo '</p>';
        echo '</td>';
        echo '<td><strong>' . $autoreDomanda . '</strong></td>';
        echo '<td>' . $testoDomanda . '</td>'; 
        echo '<td>';
        echo '---';
        echo '</td>'; 
        echo '<td>';
        echo '---';
        echo '</td>';
        echo '<td>';
        echo '---';
        echo '</td>';
        echo '<td>';
        echo '---';
        echo '</td>';
        }
 else {
        echo '<tr>';
        echo '<th>Gestisci Domanda</th><th>Autore Domanda</th><th>Domanda</th><th>Voto Utilità</th><th>Voto Supporto</th><th>Valutazione</th><th>Rispondi</th>';
        echo '</tr>';
        
        $utilitaNode = $xpath->query("utilita/valore[@id_utente='$idUtenteSessione']", $domanda)->item(0);
        $supportoNode = $xpath->query("supporto/valore[@id_utente='$idUtenteSessione']", $domanda)->item(0);

        // Ottieni i valori di utilità e supporto o imposta "N/A" se non presenti
        $utilitaValue = $utilitaNode ? $utilitaNode->nodeValue : "N/A";
        $supportoValue = $supportoNode ? $supportoNode->nodeValue : "N/A";

        $id_domanda = $domanda->getElementsByTagName("id_domanda")->item(0)->nodeValue;
        $autoreDomanda = $domanda->getElementsByTagName("autore")->item(0)->nodeValue;
        $testoDomanda = $domanda->getElementsByTagName("testo")->item(0)->nodeValue;
        
        echo '<tr>';
        echo '<td>';
        echo '<form action="eleva_faq.php" method="post">';
        echo '<input type="hidden" name="testo_domanda" value="' . htmlspecialchars($testoDomanda) . '"/>';
        echo '<input type="hidden" name="id_domanda" value="' . $id_domanda . '"/>';
        echo '<input type="hidden" name="id_prodotto" value="' . $id_prodotto . '"/>';
        echo '<button class="done" type="submit" name="vota"><span id="done" title="Eleva a Faq" class="material-symbols-outlined">edit</span></button>';
        echo '</form>';
        echo '<a title="Elimina" href="elimina_dom_risp.php?id_domanda=' . $id_domanda . '&nome=' . $nome . '&id_prodotto=' . $id_prodotto . '&nome=' . $nome . '&tipologia=' . $tipologia . '"><span style="margin-top:10px;" id="done" class="material-symbols-outlined">delete</span></a>';
        echo '</td>';
        echo '<td><strong>' . $autoreDomanda . '</strong></td>';
        echo '<td>' . $testoDomanda . '</td>'; 
        echo '<td>' . $utilitaValue . '</td>';
        echo '<td>' . $supportoValue . '</td>';
        // Ottieni l'id_utente dai nodi "valore" all'interno degli elementi "utilita" e "supporto"
        $utilitaIdUtente = $utilitaNode ? $utilitaNode->getAttribute("id_utente") : "N/A";
        $supportoIdUtente = $supportoNode ? $supportoNode->getAttribute("id_utente") : "N/A";

        if ($utilitaIdUtente == $_SESSION['id'] || $supportoIdUtente == $_SESSION['id']) {
            echo '<td><p><span id="ver" class="material-symbols-outlined">verified</span></p></td>';
        }  else {
         // Colonna per i pulsanti di voto delle domande
        echo '<td>';
        echo '<form action="../res/domande_utilita_supporto.php" method="post">';
        echo '<input type="hidden" name="id_domanda" value="' . $id_domanda . '"/>';
        echo '<input type="hidden" name="id_prodotto" value="' . $id_prodotto . '"/>';
        echo '<input type="hidden" name="tipologia" value="' . $tipologia . '"/>';
        echo '<input type="hidden" name="nome" value="' . $nome . '"/>';            

        echo '<label class="titolo" for="votoUtilita">Utilità (da 1 a 5): </label>';
        echo '<input class="input" type="number" name="votoUtilita" min="1" max="5" required/><br>';
    
        echo '<label class="titolo" for="votoSupporto">Supporto (da 1 a 3): </label>';
        echo '<input class="input" type="number" name="votoSupporto" min="1" max="3" required/>';
    
        echo '<button class="done" type="submit" name="vota">CONFERMA<span id="done" title="Invia" class="material-symbols-outlined">done_outline</span></button>';
        echo '</form>';
   
        echo '</td>';
        }
        echo '<td>';
        // Form per rispondere alla domanda
        echo '<form action="../res/risposte.php" method="post">';
        echo '<input type="hidden" name="id_prodotto" value="' . $id_prodotto . '"/>';
        echo '<input type="hidden" name="tipologia" value="' . $tipologia . '"/>';
        echo '<input type="hidden" name="nome" value="' . $nome . '"/>';            
        echo '<input type="hidden" name="autore" value="' . $email . '"/>';
        echo '<input type="hidden" name="id_domanda" value="' . $id_domanda . '"/>';
        echo '<textarea style="height:50px; resize:none; vertical-align:top;" class="input" name="risposta" placeholder="Inserisci la risposta..." required></textarea>';
        echo '<button class="btn" type="submit">Invia risposta</button>';
        

        echo '</form>';
        echo '</tr>';
 }
 
        // Mostra le risposte
        $risposte = $domanda->getElementsByTagName('risposta');
        if ($risposte->length > 0) {
            echo '<tr><th class="risp">Gestisci Risposta</th><th class="risp">Autore Risposta</th><th class="risp">Risposta</th><th>Voto Utilità</th><th>Voto Supporto</th><th class="risp">Valutazione</th></tr>';
        
            foreach ($risposte as $risposta) {
                $id_utente_risposta=$risposta->getAttribute('id_utente');
                if($id_utente_risposta == $id_utente){
                $utilitaNode = $xpath->query("utilita_risposta/valore[@id_utente='$idUtenteSessione']", $risposta)->item(0);
                $supportoNode = $xpath->query("supporto_risposta/valore[@id_utente='$idUtenteSessione']", $risposta)->item(0);
            
                // Ottieni i valori di utilità e supporto o imposta "N/A" se non presenti
                $utilitaValue = $utilitaNode ? $utilitaNode->nodeValue : "N/A";
                $supportoValue = $supportoNode ? $supportoNode->nodeValue : "N/A";
            
                $id_risposta = $risposta->getElementsByTagName("id_risposta")->item(0)->nodeValue;
                $autoreRisposta = $risposta->getElementsByTagName("autore")->item(0)->nodeValue;
                $dataRisposta = $risposta->getElementsByTagName("data")->item(0)->nodeValue;
                $oraRisposta = $risposta->getElementsByTagName("ora")->item(0)->nodeValue;
                $testoRisposta = $risposta->getElementsByTagName("testo")->item(0)->nodeValue;
        
                
              // Nuova riga per ogni risposta
                echo '<tr>';
                echo '<td>';
                echo '<p>';
                echo '<a href="elimina_dom_risp.php?id_prodotto=' . urlencode($id_prodotto) . '&nome=' . $nome . '&id_risposta=' . urlencode($id_risposta) . '&testo_risposta=' . urlencode($testoRisposta) . '"><span id="simbolo_recensione" class="material-symbols-outlined">delete</span></a>';
                echo '</p>';
                echo '</td>';          
                echo '<td>';
                echo '<strong>' . $autoreRisposta . '</strong> ha risposto il ' . $dataRisposta . ' alle ' . $oraRisposta;
                echo '</td>';
                echo '<td style="max-width:300px; word-wrap: break-word;">';
                echo $testoRisposta;
                echo '</td>';
                echo '<td>';
                echo '---';
                echo '</td>'; echo '<td>';
                echo '---';
                echo '</td>'; echo '<td>';
                echo '---';
                echo '</td>'; 
                
            } else {
                $utilitaNode = $xpath->query("utilita_risposta/valore[@id_utente='$idUtenteSessione']", $risposta)->item(0);
                $supportoNode = $xpath->query("supporto_risposta/valore[@id_utente='$idUtenteSessione']", $risposta)->item(0);
            
                // Ottieni i valori di utilità e supporto o imposta "N/A" se non presenti
                $utilitaValue = $utilitaNode ? $utilitaNode->nodeValue : "N/A";
                $supportoValue = $supportoNode ? $supportoNode->nodeValue : "N/A";
            
                $id_risposta = $risposta->getElementsByTagName("id_risposta")->item(0)->nodeValue;
                $autoreRisposta = $risposta->getElementsByTagName("autore")->item(0)->nodeValue;
                $dataRisposta = $risposta->getElementsByTagName("data")->item(0)->nodeValue;
                $oraRisposta = $risposta->getElementsByTagName("ora")->item(0)->nodeValue;
                $testoRisposta = $risposta->getElementsByTagName("testo")->item(0)->nodeValue;
        
                
                // Nuova riga per ogni risposta
                echo '<tr>';
                echo '<td>';
                echo '<form action="eleva_faq.php" method="post">';
                echo '<input type="hidden" name="testo_risposta" value="' . htmlspecialchars($testoRisposta) . '"/>';
                echo '<input type="hidden" name="id_risposta" value="' . $id_risposta . '"/>';
                echo '<input type="hidden" name="id_domanda" value="' . $id_domanda . '"/>';
                echo '<input type="hidden" name="id_prodotto" value="' . $id_prodotto . '"/>';
                echo '<input type="hidden" name="nome" value="' . $nome . '"/>';            
                echo '<input type="hidden" name="testo_risposta" value="' . htmlspecialchars($testoRisposta) . '"/>';
                echo '<input type="hidden" name="testo_domanda" value="' . htmlspecialchars($testoDomanda) . '"/>';
                echo '<button class="done" type="submit" name="vota"><span id="done" title="Invia" class="material-symbols-outlined">edit</span></button>';
                echo '</form>';
                echo '<a href="elimina_dom_risp.php?id_risposta=' . $id_risposta . '&nome=' . $nome . '&id_domanda=' . $id_domanda . '&id_prodotto=' . $id_prodotto . '&nome=' . $nome . '&tipologia=' . $tipologia . '">';             
                 echo '<span style="margin-top:10px;" id="done" class="material-symbols-outlined">delete</span>';
                echo '</a>';              
                  echo '</td>';          
                  echo '<td>';
                  echo '<strong>' . $autoreRisposta . '</strong> ha risposto il ' . $dataRisposta . ' alle ' . $oraRisposta;
                  echo '</td>';
                  echo '<td style="max-width:300px; word-wrap: break-word;">';
                  echo $testoRisposta;
                  echo '</td>';
                  echo '<td>' . $utilitaValue . '</td>';
                  echo '<td>' . $supportoValue . '</td>';
                  echo '<td>';
  
                
        // Ottieni l'id_utente dai nodi "valore" all'interno degli elementi "utilita" e "supporto"
        $utilitaIdUtente = $utilitaNode ? $utilitaNode->getAttribute("id_utente") : "N/A";
        $supportoIdUtente = $supportoNode ? $supportoNode->getAttribute("id_utente") : "N/A";


        if ($utilitaIdUtente == $_SESSION['id'] || $supportoIdUtente == $_SESSION['id']) {
            echo '<p><span id="ver" class="material-symbols-outlined">verified</span></p>';
        }  else {
                // Colonna per i pulsanti di voto delle risposte
                echo '<div>';
                echo '<form action="../res/risposte_utilita_supporto.php" method="post">';
                echo '<input type="hidden" name="id_domanda" value="' . $id_domanda . '"/>';
                echo '<input type="hidden" name="id_risposta" value="' . $id_risposta . '"/>';
                echo '<input type="hidden" name="id_prodotto" value="' . $id_prodotto . '"/>';
                echo '<input type="hidden" name="tipologia" value="' . $tipologia . '"/>';
                echo '<input type="hidden" name="nome" value="' . $nome . '"/>';            

                echo '<label class="titolo" for="votoUtilita">Utilità (da 1 a 5): </label>';
                echo '<input class="input" type="number" name="votoUtilita" min="1" max="5" required/><br>';
            
                echo '<label class="titolo" for="votoSupporto">Supporto (da 1 a 3): </label>';
                echo '<input class="input" type="number" name="votoSupporto" min="1" max="3" required/>';
            
                echo '<button class="done" type="submit" name="vota">CONFERMA<span id="done" title="Invia" class="material-symbols-outlined">done_outline</span></button>';
                echo '</form>';
                   }
                echo '</div>';
        
                echo '</td>';
                echo '</tr>';
            
            }
     }}}}  else {
            echo '<tr><td colspan="4"><p class="titolo">Nessuna domanda disponibile.</p></td></tr>';
        }
    }
}

?>
</div>
</body>
</html>