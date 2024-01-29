<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recensioni Prodotti</title>
    <link rel="stylesheet" href="../css/style_domande_risposte.css"> <!-- Aggiungi il percorso corretto al tuo file CSS -->
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
       require_once('../res/connection.php');
session_start();

if (!isset($_SESSION['email'])) {
    // L'utente non è autenticato, puoi reindirizzarlo alla pagina di login o fare altre azioni
    header("Location: ../html/login_cliente.html");
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
    echo '<h1>Domande Prodotto: ' . $nome . '</h1>';
    echo '<table>';


    foreach ($domande as $domanda) {    
        echo '<tr>
        <th>Autore Domanda</th><th>Domanda</th><th>Voto Utilità</th><th>Voto Supporto</th><th>Valutazione</th><th>Rispondi</th>
        </tr>';
        
        $utilitaNode = $xpath->query("utilita/valore[@id_utente='$idUtenteSessione']", $domanda)->item(0);
        $supportoNode = $xpath->query("supporto/valore[@id_utente='$idUtenteSessione']", $domanda)->item(0);

        // Ottieni i valori di utilità e supporto o imposta "N/A" se non presenti
        $utilitaValue = $utilitaNode ? $utilitaNode->nodeValue : "N/A";
        $supportoValue = $supportoNode ? $supportoNode->nodeValue : "N/A";

        $id_domanda = $domanda->getElementsByTagName("id_domanda")->item(0)->nodeValue;
        $autoreDomanda = $domanda->getElementsByTagName("autore")->item(0)->nodeValue;
        $testoDomanda = $domanda->getElementsByTagName("testo")->item(0)->nodeValue;
    
        echo '<tr>';
        echo '<td>' . $autoreDomanda . '</td>';
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
        echo '<td class="voting-buttons">';
        echo '<form action="domande_utilita_supporto.php" method="post">';
        echo '<input type="hidden" name="id_domanda" value="' . $id_domanda . '"/>';
        echo '<input type="hidden" name="id_prodotto" value="' . $id_prodotto . '"/>';
        echo '<input type="hidden" name="tipologia" value="' . $tipologia . '"/>';
    
        echo '<label class="uti" for="votoUtilita">Utilità (da 1 a 5): </label>';
        echo '<input class="util" type="number" name="votoUtilita" min="1" max="5" required/><br>';
    
        echo '<label for="votoSupporto">Supporto (da 1 a 3): </label>';
        echo '<input type="number" name="votoSupporto" min="1" max="3" required/>';
    
        echo '<button type="submit" name="vota"><span id="done" title="Invia" class="material-symbols-outlined">
        done_outline
        </span></button>';
        echo '</form>';
   
        echo '</td>';
        }
        echo '<td>';
        // Form per rispondere alla domanda
        echo '<form action="risposte.php" method="post">';
        echo '<input type="hidden" name="id_prodotto" value="' . $id_prodotto . '"/>';
        echo '<input type="hidden" name="tipologia" value="' . $tipologia . '"/>';
        echo '<input type="hidden" name="nome" value="' . $nome . '"/>';            
        echo '<input type="hidden" name="autore" value="' . $email . '"/>';
        echo '<input type="hidden" name="id_domanda" value="' . $id_domanda . '"/>';
        echo '<textarea class="text" name="risposta" rows="2" cols="30" placeholder="Inserisci la risposta" required></textarea>';
        echo '<div class="send">';
        echo '<input class="button" type="submit" value="Invia risposta">';
        echo '</div>';
        echo '</form>';
    
       
    
        echo '</tr>';
    
        // Mostra le risposte
        $risposte = $domanda->getElementsByTagName('risposta');
        if ($risposte->length > 0) {
            echo '<tr><th class="risp">Autore Risposta</th><th class="risp">Risposta</th><th>Voto Utilità</th><th>Voto Supporto</th><th class="risp">Valutazione</th></tr>';
        
            foreach ($risposte as $risposta) {

                $utilitaNode = $xpath->query("utilita/valore[@id_utente='$idUtenteSessione']", $risposta)->item(0);
                $supportoNode = $xpath->query("supporto/valore[@id_utente='$idUtenteSessione']", $risposta)->item(0);
            
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
                echo '<strong>' . $autoreRisposta . '</strong> ha risposto il ' . $dataRisposta . ' alle ' . $oraRisposta;
                echo '</td>';
                echo '<td>';
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
                echo '<div class="voting-buttons">';
                echo '<form action="risposte_utilita_supporto.php" method="post">';
                echo '<input type="hidden" name="id_domanda" value="' . $id_domanda . '"/>';
                echo '<input type="hidden" name="id_risposta" value="' . $id_risposta . '"/>';
                echo '<input type="hidden" name="id_prodotto" value="' . $id_prodotto . '"/>';
                echo '<input type="hidden" name="tipologia" value="' . $tipologia . '"/>';
                echo '<input type="hidden" name="nome" value="' . $nome . '"/>';            
                echo '<label class="uti" for="votoUtilita">Utilità (da 1 a 5): </label>';
                echo '<input class="util" type="number" name="votoUtilita" min="1" max="5" required/><br>';
        
                echo '<label for="votoSupporto">Supporto (da 1 a 3): </label>';
                echo '<input type="number" name="votoSupporto" min="1" max="3" required/>';
        
                echo '<button type="submit" name="vota"><span id="done" title="Invia" class="material-symbols-outlined">
                done_outline
                </span></button>';
                echo '</form>';
        }
                echo '</div>';
        
                echo '</td>';
                echo '</tr>';
            }
        }
            }
        } else {
            echo '<tr><td colspan="4"><p>Nessuna risposta disponibile.</p></td></tr>';
        }
 
?>