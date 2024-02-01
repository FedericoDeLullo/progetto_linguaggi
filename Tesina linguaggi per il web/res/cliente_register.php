<?php
    session_start();
    require_once('connection.php');

    $email = $connessione->real_escape_string($_POST['email']);
    $nome = $connessione->real_escape_string($_POST['nome']);
    $cognome = $connessione->real_escape_string($_POST['cognome']);
    $data_di_nascita = $connessione->real_escape_string($_POST['data_di_nascita']);
    $cellulare = $connessione->real_escape_string($_POST['cellulare']);
    $indirizzo_di_residenza = $connessione->real_escape_string($_POST['indirizzo_di_residenza']);
    $codice_fiscale = $connessione->real_escape_string($_POST['codice_fiscale']);
    $password = $connessione->real_escape_string($_POST['password']);

    $utente=1;
    $admin_ok=0;
    $gestore=0;
    $crediti=0;
    $reputazione=1;
    $ban=0;
     
    $_SESSION['form_email'] = $email;

    //controllo email già esistente
    $controllo_email = "SELECT * FROM utenti u WHERE u.email = '$email'";
    $ris_email = mysqli_query($connessione, $controllo_email);

    if(mysqli_num_rows($ris_email) > 0){
        $_SESSION['errore_email'] = 'true';
        header('Location: ../php/registrazione_cliente.php');
        exit(1);
    }

    if(empty($nome) || empty($email) || empty($password) || empty($cognome) || empty($data_di_nascita) || empty($codice_fiscale) || empty($indirizzo_di_residenza) ||empty($cellulare)) {
            header("Location: ../php/registrazione_fallita.php");
            exit;
    }
            
    $sql = "INSERT INTO utenti (email, nome, cognome, data_di_nascita, cellulare, indirizzo_di_residenza, codice_fiscale, passwd, crediti, utente, ammin, gestore, reputazione, ban) VALUES ('$email','$nome','$cognome','$data_di_nascita','$cellulare','$indirizzo_di_residenza', '$codice_fiscale','$password', '$crediti', '$utente', '$admin_ok', '$gestore', '$reputazione', '$ban')";
    
try {
      $connessione->query($sql);
      header("Location: ../php/login_cliente.php");
} catch (Exception $e) {
    header("Location: ../php/registrazione_ko.php");
    exit;
}
    
?>