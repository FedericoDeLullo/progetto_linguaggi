<?php
    require_once('connection.php');

    $email = $connessione->real_escape_string($_POST['email']);
    $username = $connessione->real_escape_string($_POST['username']);
    $password = $connessione->real_escape_string($_POST['password']);
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO utenti (email, username, passwd) VALUES ('$email','$username','$hashed_password')";

    if($connessione->query($sql)=== true){
        header("Location: ../file_html/registrazione_ok.html");
    }
    else {
        //echo "Errore nella registrazione utente $sql. ". $connessione->error;
        header("Location: ../file_html/registrazione_ko.html");
        exit;
    }
?>
