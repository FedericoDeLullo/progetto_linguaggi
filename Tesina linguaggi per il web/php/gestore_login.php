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
                if(password_verify($password, $row['passwd']) && $codice==$codice_gestore){
                    session_start();
                    $_SESSION['loggato'] = true;
                    $_SESSION['email'] = $row['email'];
                    $_SESSION['crediti'] = $row['crediti'];

                    header("Location:index_loggato_gestore.php");
                }
                else{
                    header("Location: ../html/account_ko_gestore.html");
                    exit;
                }
            }
            else{
                header("Location: ../html/account_ko_gestore.html");
                exit;
            }

        }
        else{
            echo "Errore in fase di login";
        }
        $connessione->close();
    }
?>