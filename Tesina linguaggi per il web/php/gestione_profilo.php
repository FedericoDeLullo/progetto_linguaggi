<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestione Utente</title>
    <link rel="stylesheet" href="../css/style_standard.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="../css/style_header.css">
    <?php
        include('../res/header.php');
    ?>
</head>
<body>
    
<div class="cont">

<?php
// Include il file di connessione al database
require_once('../res/connection.php');
 

// Verifica se l'utente è loggato
if (isset($_SESSION['id'])) {
    $id_utente = $_SESSION['id'];

    // Esegui la query per ottenere i dati dell'utente
    $query = "SELECT * FROM utenti WHERE id = $id_utente";
    $result = $connessione->query($query);

    if ($result->num_rows > 0) {
        $utente = $result->fetch_assoc();
?>
        <h1 class="titolo">Gestione Utente</h1>

            <table>
                <tr>
                    <th>Nome:</th>
                    <td><?php echo $utente['nome']; ?></td>
                    <td><a href="modifica_profilo.php?id=<?php echo $utente['id']; ?>"><span id="edit" class="material-symbols-outlined">edit</span></a></td>
                </tr>
                <tr>
                    <th>Cognome:</th>
                    <td><?php echo $utente['cognome']; ?></td>
                    <td><a href="modifica_profilo.php?id=<?php echo $utente['id']; ?>"><span id="edit" class="material-symbols-outlined">edit</span></a></td>

                </tr>
                <tr>
                    <th>Email:</th>
                    <td><?php echo $utente['email']; ?></td>
                    <td><a href="modifica_profilo.php?id=<?php echo $utente['id']; ?>"><span id="edit" class="material-symbols-outlined">edit</span></a></td>

                </tr>
                <tr>
                    <th>Password:</th>
                    <td>* * * * * * * * * *</td>
                    <td><a href="modifica_password.php?id=<?php echo $utente['id']; ?>"><span id="edit" class="material-symbols-outlined">key</span></a></td>

                </tr>
                <tr>
                    <th>Crediti:</th>
                    <td><?php echo $utente['crediti']; ?></td>
                    <td><a href="richiesta_crediti.php"><span id="edit" class="material-symbols-outlined">add</span></a></td>
                </tr>
                <tr>
                    <th>Reputazione:</th>
                    <td><?php echo $utente['reputazione']; ?></td>
                </tr>
                <tr>
                    <th>Cellulare:</th>
                    <td><?php echo $utente['cellulare']; ?></td>
                    <td><a href="modifica_profilo.php?id=<?php echo $utente['id']; ?>"><span id="edit" class="material-symbols-outlined">edit</span></a></td>
                </tr>
                <tr>
                    <th>Indirizzo di residenza:</th>
                    <td><?php echo $utente['indirizzo_di_residenza']; ?></td>
                    <td><a href="modifica_profilo.php?id=<?php echo $utente['id']; ?>"><span id="edit" class="material-symbols-outlined">edit</span></a></td>

                </tr>
            </table>

<?php
    } else {
        echo 'Utente non trovato.';
    }
} else {
    echo 'Utente non loggato.';
}
echo '</div>';

// Chiudi la connessione al database
$connessione->close();
?>

</body>
</html>