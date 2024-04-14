<?php 
    require_once('connection.php');

    $username = $connessione->real_escape_string($_POST['username']);
    $password = $connessione->real_escape_string($_POST['password']);

    if($_SERVER["REQUEST_METHOD"]==="POST"){
        $sql_select = "SELECT * FROM utenti WHERE username = '$username'";
        if($result = $connessione->query($sql_select)){
            if($result->num_rows === 1){
                $row = $result->fetch_array(MYSQLI_ASSOC);
                if(password_verify($password, $row['passwd'])){
                    session_start();
                    $_SESSION['loggato'] = true;
                    $_SESSION['username'] = $row['username'];
                    $_SESSION['crediti'] = $row['crediti'];

                    header("Location: ../HTML/index1.html");
                }
                else{
                    header("Location: ../HTML/account_ko.html");
                    exit;
                }
            }
            else{
                header("Location: ../HTML/account_ko.html");
                exit;
            }

        }
        else{
            echo "Errore in fase di login";
        }
        $connessione->close();
    }
?>