<?php
    require_once('connection.php');

    $email = $connessione->real_escape_string($_POST['email']);
    $nome = $connessione->real_escape_string($_POST['nome']);
    $cognome = $connessione->real_escape_string($_POST['cognome']);
    $data_di_nascita = $connessione->real_escape_string($_POST['data_di_nascita']);
    $cellulare = $connessione->real_escape_string($_POST['cellulare']);
    $indirizzo = $connessione->real_escape_string($_POST['indirizzo']);
    $codice_fiscale = $connessione->real_escape_string($_POST['codice_fiscale']);
    $password = $connessione->real_escape_string($_POST['password']);
    $crediti = $connessione->real_escape_string($_POST['crediti']);

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    if(empty($nome) || empty($email) || empty($password) || empty($cognome) || empty($data_di_nascita) || empty($codice_fiscale) || empty($indirizzo) ||empty($cellulare)) {
            header("Location:../html/registrazione_fallita.html");
            exit;
    }
            
    $sql = "INSERT INTO utenti (email, nome, cognome, data_di_nascita, cellulare, indirizzo_di_residenza, codice_fiscale, passwd, crediti) VALUES ('$email','$nome','$cognome','$data_di_nascita','$cellulare','$indirizzo', '$codice_fiscale','$hashed_password', '$crediti')";
    
try {
      $connessione->query($sql);
      header("Location: ../html/login.html");
} catch (Exception $e) {
    header("Location: ../html/registrazione_ko.html");
    exit;
}
    
?>
