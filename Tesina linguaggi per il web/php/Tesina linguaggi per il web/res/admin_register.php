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
    $admin_ok=1;
    $gestore=0;
    $codice_admin=1234;
    $crediti=0;
    $reputazione=11;
    $ban=0;

    if(empty($codice) || empty($nome) || empty($email) || empty($password) || empty($cognome) || empty($data_di_nascita) || empty($codice_fiscale) || empty($indirizzo_di_residenza) || empty($cellulare) || $codice != $codice_admin ) {
            header("Location: ../php/registrazione_fallita.php");
            exit;
    }
            
    $sql = "INSERT INTO utenti (email, nome, cognome, data_di_nascita, cellulare, indirizzo_di_residenza, codice_fiscale, passwd, crediti, ammin, utente, gestore, reputazione, ban) VALUES ('$email','$nome','$cognome','$data_di_nascita','$cellulare','$indirizzo_di_residenza', '$codice_fiscale','$password', '$crediti', '$admin_ok', '$utente', '$gestore', '$reputazione', '$ban')";
    
try {
      $connessione->query($sql);
      header("Location: ../php/login_admin.php");
} catch (Exception $e) {
    header("Location: ../php/registrazione_ko.php");
    exit;
}
    
?>