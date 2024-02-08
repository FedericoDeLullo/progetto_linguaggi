<?php
session_start();
require_once('../res/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id_utente = $_POST['id'];
    $password = $_POST['password'];
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $query = "UPDATE utenti SET passwd = ? WHERE id = ?";

    // Utilizza statement preparati per evitare SQL injection
    $stmt = $connessione->prepare($query);
    $stmt->bind_param("si", $hashed_password, $id_utente);

    if ($stmt->execute()) {
        if(isset($_POST['admin'])){
            header("Location: gestione_utenti.php");
        }
        else {
            header("Location: gestione_profilo.php");

        }
    }
    else {
        echo 'Errore durante il salvataggio delle modifiche: ' . $stmt->error;
    }
}
?>