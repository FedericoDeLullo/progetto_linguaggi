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
    $crediti = $connessione->real_escape_string($_POST['crediti']);
    $codice = $connessione->real_escape_string($_POST['codice']);

    $codice_admin=1234;
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    if(empty($codice) || empty($nome) || empty($email) || empty($password) || empty($cognome) || empty($data_di_nascita) || empty($codice_fiscale) || empty($indirizzo_di_residenza) || empty($cellulare) || $codice != $codice_admin ) {
            header("Location:../html/registrazione_fallita_admin.html");
            exit;
    }
            
    $sql = "INSERT INTO utenti (email, nome, cognome, data_di_nascita, cellulare, indirizzo_di_residenza, codice_fiscale, passwd, crediti) VALUES ('$email','$nome','$cognome','$data_di_nascita','$cellulare','$indirizzo_di_residenza', '$codice_fiscale','$hashed_password', '$crediti')";
    
try {
      $connessione->query($sql);
      header("Location: ../html/admin_login.html");
} catch (Exception $e) {
    header("Location: ../html/registrazione_ko_admin.html");
    exit;
}
    
?>