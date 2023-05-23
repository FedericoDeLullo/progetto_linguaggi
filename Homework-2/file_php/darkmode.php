<?php

session_start();


$durata_cookie = time() + (3600*24); 
setcookie('tema', '', $durata_cookie, '/'); 

if (isset($_POST['light'])) {
    $tema = $_POST['light'];
    setcookie("tema", $tema, $durata_cookie, '/');
    header('Location:../PHP/index.php'); 
    exit(1);
} 
  
else if (isset($_POST['dark'])) {
    $tema = $_POST['dark'];
    setcookie("tema", $tema, $durata_cookie, '/');
    header('Location:../PHP/index.php'); 
    exit(1);
}
else if (isset($_POST['light1'])) {
    $tema = $_POST['light1'];
    setcookie("tema", $tema, $durata_cookie, '/');
    header('Location:../PHP/index1.php'); 
    exit(1);
}
else if (isset($_POST['dark1'])) {
    $tema = $_POST['dark1'];
    setcookie("tema", $tema, $durata_cookie, '/');
    header('Location:../PHP/index1.php'); 
    exit(1);
}

?>