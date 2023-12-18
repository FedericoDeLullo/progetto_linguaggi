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
    
    $crediti=0;
    $utente=0;
    $admin_ok=0;
    $gestore=1;
    $rep = 11;

    $codice_gestore=4567;
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    if(empty($codice) || empty($nome) || empty($email) || empty($password) || empty($cognome) || empty($data_di_nascita) || empty($codice_fiscale) || empty($indirizzo_di_residenza) || empty($cellulare) || $codice != $codice_gestore ) {
            header("Location:../html/registrazione_fallita_gestore.html");
            exit;
    }
            
    $sql = "INSERT INTO utenti (email, nome, cognome, data_di_nascita, cellulare, indirizzo_di_residenza, codice_fiscale, passwd, crediti, ammin, utente, gestore, reputazione) VALUES ('$email','$nome','$cognome','$data_di_nascita','$cellulare','$indirizzo_di_residenza', '$codice_fiscale','$hashed_password', '$crediti', '$admin_ok', '$utente', '$gestore', '$rep')";
    
try {
      $connessione->query($sql);
      header("Location: ../html/gestore_login.html");
} catch (Exception $e) {
    header("Location: ../html/registrazione_ko_gestore.html");
    exit;
}
    
?>