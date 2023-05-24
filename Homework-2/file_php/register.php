<?php
    require_once('connection.php');

    $email = $connessione->real_escape_string($_POST['email']);
    $username = $connessione->real_escape_string($_POST['username']);
    $password = $connessione->real_escape_string($_POST['password']);
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO utenti (email, username, passwd) VALUES ('$email','$username','$hashed_password')";

    if(!empty($username) && !empty($email) && !empty($password) && $connessione->query($sql)=== true) {
       
        header("Location: ../PHP/registrazione_ok.php");
    }
    else
    if(empty($username) || empty($email) || empty($password)){
        header("Location:../PHP/registrazione_fallita.php");
    }
    else {
        header("Location: ../PHP/registrazione_ko.php");
        exit;
    }

?>
