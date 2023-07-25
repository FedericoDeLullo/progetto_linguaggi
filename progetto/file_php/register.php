<?php
    require_once('connection.php');

    $email = $connessione->real_escape_string($_POST['email']);
    $username = $connessione->real_escape_string($_POST['username']);
    $password = $connessione->real_escape_string($_POST['password']);
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    if(empty($username) || empty($email) || empty($password)) {
            header("Location:../HTML/registrazione_fallita.html");
            exit;
    }
            
    $sql = "INSERT INTO utenti (email, username, passwd) VALUES ('$email','$username','$hashed_password')";
    
try {
      $connessione->query($sql);
      header("Location: ../HTML/login.html");
} catch (Exception $e) {
    header("Location: ../HTML/registrazione_ko.html");
    exit;
}
    
?>
