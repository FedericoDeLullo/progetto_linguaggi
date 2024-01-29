<?php
    require_once('connection.php');

    $email = $connessione->real_escape_string($_POST['email']);
    $nome = $connessione->real_escape_string($_POST['nome']);
    $cognome = $connessione->real_escape_string($_POST['cognome']);
    $data_di_nascita = $connessione->real_escape_string($_POST['data_di_nascita']);
    $cellulare = $connessione->real_escape_string($_POST['cellulare']);
    $indirizzo_di_residenza = $connessione->real_escape_string($_POST['indirizzo_di_residenza']);
    $codice_fiscale = $connessione->real_escape_string($_POST['codice_fiscale']);
    $password = $connessione->real_escape_string($_POST['password']);
    $codice = $connessione->real_escape_string($_POST['codice']);
    
    $utente=0;
    $admin_ok=0;
    $gestore=1;
    $crediti=0;
    $reputazione=11;
    $codice_gestore=4567;
    $ban=0;

    if(empty($codice) || empty($nome) || empty($email) || empty($password) || empty($cognome) || empty($data_di_nascita) || empty($codice_fiscale) || empty($indirizzo_di_residenza) || empty($cellulare) || $codice != $codice_gestore ) {
            header("Location: ../html/registrazione_fallita.html");
            exit;
    }
            
    $sql = "INSERT INTO utenti (email, nome, cognome, data_di_nascita, cellulare, indirizzo_di_residenza, codice_fiscale, passwd, crediti, ammin, utente, gestore, reputazione, ban) VALUES ('$email','$nome','$cognome','$data_di_nascita','$cellulare','$indirizzo_di_residenza', '$codice_fiscale','$password', '$crediti', '$admin_ok', '$utente', '$gestore', '$reputazione', '$ban')";
    
try {
      $connessione->query($sql);
      header("Location: ../html/login_gestore.html");
} catch (Exception $e) {
    header("Location: ../html/registrazione_ko.html");
    exit;
}
    
?>