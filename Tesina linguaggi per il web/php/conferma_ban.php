<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style_standard.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="../css/style_header.css">
    <title>Gestione Utenti</title>
    <?php
        include('../res/header.php');
    ?>
</head>
<body>

<div class="cont">
    <h1 class="titolo">GESTIONE UTENTI</h1>
    <table>
        <tr>
            <td>
                <form action="../res/ban.php" method="post">
                    <?php
                    // Verifica se l'utente è autenticato e se è un amministratore
                    if (!isset($_SESSION['id']) || $_SESSION['ammin'] != 1) {
                        // Reindirizza l'utente a una pagina di accesso negato
                        header("Location: accesso_negato.php");
                        exit();
                    }
                    if(isset($_GET['ban'])) {
                        $banValue = $_GET['ban'];
                        $id_utente = $_GET['id'];
                        
                        // Aggiungi un campo hidden per inviare il valore GET nel form
                        echo '<input type="hidden" name="ban" value="' . htmlspecialchars($banValue) . '">';
                        echo '<input type="hidden" name="id" value="' . htmlspecialchars($id_utente) . '">';

                        if($banValue == 1) {
                            echo '<p class="big">Attivare l\'utente?</p>';
                            echo '<button class="done" type="submit" name="action" value="Approva"><span id="done" class="material-symbols-outlined">done</span></button>';
                            echo '<button class="done" type="submit" name="action" value="Rifiuta"><span id="done" class="material-symbols-outlined">close</span></button>';
                        } elseif($banValue == 0) {
                            echo '<p class="big">Disattivare l\'utente?</p>';
                            echo '<button class="done" type="submit" name="action" value="Approva"><span id="done" class="material-symbols-outlined">done</span></button>';
                            echo '<button class="done" type="submit" name="action" value="Rifiuta"><span id="done" class="material-symbols-outlined">close</span></button>';
                        } else {
                            echo '<p>Utente non trovato...</p>';
                        }
                    } else {
                        echo '<p>Utente non trovato...</p>';
                    }
                    ?>
                </form>
            </td>
        </tr>
    </table>
</div>

</body>
</html>
