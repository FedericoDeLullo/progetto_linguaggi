<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifica Utente</title>
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
require_once('../res/connection.php');

// Verifica se è stato fornito un ID utente valido
if (isset($_GET['id']) && is_numeric($_GET['id']) && !isset($_GET['admin'])) {
    $id_utente = $_GET['id'];

    // Esegui una query per ottenere i dati dell'utente
    $query = "SELECT * FROM utenti WHERE id = $id_utente";
    $result = $connessione->query($query);

    if ($result->num_rows == 1) {
        $utente = $result->fetch_assoc();
        ?>
 
 <h1 class="titolo">Modifica Password</h1>
        <table>
            <tr>
                <td colspan="2">
                    <form class="form" action="processa_modifica_pass.php" method="post">
                    <input class="input" type="hidden" name="id" value="<?php echo $utente['id']; ?>">
                    <input style="width:200px;" class="input" type="text" id="password" name="password" value="<?php echo $utente['passwd']; ?>" required><br>
                        <br><br><br>
                        <input class="btn" type="submit" value="Salva Password">
                    </form>
                </td>
            </tr>
        </table>
        <?php
    } 
    else {
        echo '<h2>Utente non trovato.</h2>';
    }
}
 elseif (isset($_GET['id']) && isset($_GET['admin'])) {
    $id_utente = $_GET['id'];
    $admin = $_GET['admin'];
    // Esegui una query per ottenere i dati dell'utente
    $query = "SELECT * FROM utenti WHERE id = $id_utente";
    $result = $connessione->query($query);

    if ($result->num_rows == 1) {
        $utente = $result->fetch_assoc();
        ?>
 
 <h1 class="titolo">Modifica Password</h1>
        <table>
            <tr>
                <td colspan="2">
                    <form class="form" action="processa_modifica_pass.php" method="post">
                    <input class="input" type="hidden" name="id" value="<?php echo $utente['id']; ?>">
                    <input class="input" type="hidden" name="admin" value="<?php echo $admin ?>">
                    <input style="width:200px;" class="input" type="text" id="password" name="password" value="<?php echo $utente['passwd']; ?>" required><br>
                        <br><br><br>
                        <input class="btn" type="submit" value="Salva Password">
                    </form>
                </td>
            </tr>
        </table>
        <?php
    } 
    else {
        echo '<h2>Utente non trovato.</h2>';
    }
} 


$connessione->close();
?>
</div>

</body>
</html>