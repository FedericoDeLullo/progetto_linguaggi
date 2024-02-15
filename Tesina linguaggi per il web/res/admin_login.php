<?php 
    session_start();
    require_once('connection.php');

    $email = $connessione->real_escape_string($_POST['email']);
    $password = $connessione->real_escape_string($_POST['password']);
    $codice = $connessione->real_escape_string($_POST['codice']);
    $codice_admin=1234;

    if($_SERVER["REQUEST_METHOD"]==="POST"){
        $sql_select = "SELECT * FROM utenti WHERE email = '$email' AND ammin = 1";
        if($result = $connessione->query($sql_select)){
            if($result->num_rows === 1){
                $row = $result->fetch_array(MYSQLI_ASSOC);
                if(password_verify($password, $row['passwd']) && $codice==$codice_admin){
                    $_SESSION['loggato'] = true;
                    $_SESSION['id'] = $row['id'];
                    $_SESSION['email'] = $row['email'];
                    $_SESSION['crediti'] = $row['crediti'];
                    $_SESSION['utente'] = $row['utente'];
                    $_SESSION['gestore'] = $row['gestore'];
                    $_SESSION['ammin'] = $row['ammin'];
                    header("Location: ../php/index.php");
                }
                else{
                    $_SESSION['errore_login'] = 'true';
                    header("Location: ../php/login_admin.php");
                    exit;
                }
            }
            else{
                $_SESSION['errore_login'] = 'true';
                header("Location: ../php/login_admin.php");
                exit;
            }

        }
        else{
            $_SESSION['errore_login'] = 'true';
            header("Location: ../php/login_admin.php");
        }
        $connessione->close();
    }
?>