<?php 
    require_once('connection.php');

    $email = $connessione->real_escape_string($_POST['email']);
    $password = $connessione->real_escape_string($_POST['password']);
    $codice = $connessione->real_escape_string($_POST['codice']);

    $codice_admin=1234;

    if($_SERVER["REQUEST_METHOD"]==="POST"){
        $sql_select = "SELECT * FROM utenti WHERE email = '$email'";
        if($result = $connessione->query($sql_select)){
            if($result->num_rows === 1){
                $row = $result->fetch_array(MYSQLI_ASSOC);
                if(password_verify($password, $row['passwd']) && $codice==$codice_admin){
                    session_start();
                    $_SESSION['loggato'] = true;
                    $_SESSION['email'] = $row['email'];
                    $_SESSION['crediti'] = $row['crediti'];

                    header("Location: ../html/index_loggato_admin.html");
                }
                else{
                    header("Location: ../html/account_ko_admin.html");
                    exit;
                }
            }
            else{
                header("Location: ../html/account_ko_admin.html");
                exit;
            }

        }
        else{
            echo "Errore in fase di login";
        }
        $connessione->close();
    }
?>