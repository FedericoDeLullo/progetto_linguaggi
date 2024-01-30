<?php 
    require_once('connection.php');

    $email = $connessione->real_escape_string($_POST['email']);
    $password = $connessione->real_escape_string($_POST['password']);
    $codice = $connessione->real_escape_string($_POST['codice']);

    $codice_gestore=4567;

    if($_SERVER["REQUEST_METHOD"]==="POST"){
        $sql_select = "SELECT * FROM utenti WHERE email = '$email'";
        if($result = $connessione->query($sql_select)){
            if($result->num_rows === 1){
                $row = $result->fetch_array(MYSQLI_ASSOC);
                if($password === $row['passwd'] && $codice==$codice_gestore){
                    session_start();
                    $_SESSION['loggato'] = true;
                    $_SESSION['id'] = $row['id'];
                    $_SESSION['email'] = $row['email'];
                    $_SESSION['crediti'] = $row['crediti'];
                    $_SESSION['utente'] = $row['utente'];
                    $_SESSION['gestore'] = $row['gestore'];
                    $_SESSION['ammin'] = $row['ammin'];
                    header("Location: ../php/index_gestore.php");
                }
                else{
                    header("Location: ../html/login_ko.html");
                    exit;
                }
            }
            else{
                header("Location: ../html/login_ko.html");
                exit;
            }

        }
        else{
            echo "Errore in fase di login";
        }
        $connessione->close();
    }
?>