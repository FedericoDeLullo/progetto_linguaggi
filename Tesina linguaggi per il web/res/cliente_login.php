<?php 
    session_start();
    require_once('connection.php');

    $email = $connessione->real_escape_string($_POST['email']);
    $password = $connessione->real_escape_string($_POST['password']);
    
    if($_SERVER["REQUEST_METHOD"] === "POST"){
        $sql_select = "SELECT * FROM utenti WHERE email = '$email' AND utente = 1";
        if($result = $connessione->query($sql_select)){
            if($result->num_rows === 1){
                $row = $result->fetch_array(MYSQLI_ASSOC);
                
                // Confronto diretto delle password (senza hashing)
                if(password_verify($password, $row['passwd'])){
                    // Verifica il campo 'ban'
                    if($row['ban'] == 1){
                        header("Location: ../php/utente_bannato.php"); // Reindirizza a pagina di errore ban
                        exit;
                    }
                    $_SESSION['loggato'] = true;
                    $_SESSION['email'] = $row['email'];
                    $_SESSION['crediti'] = $row['crediti'];
                    $_SESSION['id'] = $row['id'];
                    $_SESSION['utente'] = $row['utente'];
                    $_SESSION['gestore'] = $row['gestore'];
                    $_SESSION['ammin'] = $row['ammin'];
                    header("Location: ../php/index.php");
                } else {
                    $_SESSION['errore_login'] = 'true';
                    header("Location: ../php/login_cliente.php");
                    exit;
                }
            } else {
                $_SESSION['errore_login'] = 'true';
                header("Location: ../php/login_cliente.php");
                exit;
            }
        } else {
            $_SESSION['errore_login'] = 'true';
            header("Location: ../php/login_cliente.php");
        }
        $connessione->close();
    }
?>