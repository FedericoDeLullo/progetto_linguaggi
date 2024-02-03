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
    $codice = $connessione->real_escape_string($_POST['codice']);
    
    $utente=0;
    $admin_ok=0;
    $gestore=1;
    $codice_gestore=4567;
    $crediti=0;
    $reputazione=11;
    $ban=0;

    $_SESSION['form_email'] = $email;
    $_SESSION['form_nome'] = $nome;
    $_SESSION['form_cognome'] = $cognome;
    $_SESSION['form_data_di_nascita'] = $data_di_nascita;
    $_SESSION['form_cellulare'] = $cellulare;
    $_SESSION['form_indirizzo_di_residenza'] = $indirizzo_di_residenza;
    $_SESSION['form_codice_fiscale'] = $codice_fiscale;

    //controllo email già esistente
    $controllo_email = "SELECT * FROM utenti u WHERE u.email = '$email'";
    $ris_email = mysqli_query($connessione, $controllo_email);

    if(mysqli_num_rows($ris_email) > 0){
        $_SESSION['errore_email'] = 'true';
        header('Location: ../php/registrazione_gestore.php');
        exit(1);
    }
            
    $sql = "INSERT INTO utenti (email, nome, cognome, data_di_nascita, cellulare, indirizzo_di_residenza, codice_fiscale, passwd, crediti, ammin, utente, gestore, reputazione, ban) VALUES ('$email','$nome','$cognome','$data_di_nascita','$cellulare','$indirizzo_di_residenza', '$codice_fiscale','$password', '$crediti', '$admin_ok', '$utente', '$gestore', '$reputazione', '$ban')";
    
    try {
        $connessione->query($sql);

        //unsetto tutte le variabili di sessione utilizzate prima visto che il form è andato a buon fine
        unset($_SESSION['form_email']);
        unset($_SESSION['form_nome']);
        unset($_SESSION['form_cognome']);
        unset($_SESSION['form_data_di_nascita']);
        unset($_SESSION['form_cellulare']);
        unset($_SESSION['form_indirizzo_di_residenza']);
        unset($_SESSION['form_codice_fiscale']);

        header("Location: ../php/login_gestore.php");
    }
    catch (Exception $e) {
        header("Location: ../php/registrazione_fallita.php");
        exit;
    }
?>