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
                    $_SESSION['id']= $row['id'];
                    $_SESSION['username'] = $row['username'];
                    header("Location: private_area.php");
                }
                else{
                    //echo "la password non è corretta";
                    header("Location: ../file_html/password_ko.html");
                    exit;
                }
            }
            else{
                //echo "non ci sono utenti registrati con questo user";
                header("Location: ../file_html/username_ko.html");
                exit;
            }

        }
        else{
            echo "Errore in fase di login";
        }
        $connessione->close();
    }
?>