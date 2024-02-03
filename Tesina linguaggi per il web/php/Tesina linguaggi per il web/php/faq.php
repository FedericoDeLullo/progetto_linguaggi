<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faq</title>
    <link rel="stylesheet" href="../css/style_standard.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="../css/style_header.css">
    <?php
        include('../res/header.php');
    ?>
</head>
<?php
require_once('../res/connection.php');
if(isset($_SESSION['loggato'])){
    $id_utente = $_SESSION['id'];
    $gestore = $_SESSION['gestore'];
    $admin = $_SESSION['ammin'];
    $utente = $_SESSION['utente'];
   ?>
        <body>
       <div class="cont">
          <?php
         
        
        // Assicurati di avere l'ID dell'utente dalla sessione o da un'altra fonte
        if (isset($_SESSION['id'])) {
            $user_id = $_SESSION['id'];
        } else {
            // Tratta l'assenza dell'ID dell'utente come un errore o gestiscilo secondo le tue esigenze
            echo "Errore: ID dell'utente non disponibile.";
            exit();
        }
        
        // Genera un ID univoco per la FAQ
        $faq_id = uniqid();
        ?>
        <h1 class="titolo">Fai una domanda</h1>
        
        <table class="up">
            <tr>
                <th>Invia una domanda FAQ</th>
            </tr>
            <tr>
                <td>
                    <form action="processa_domanda.php" method="post">
                        <label class="big" for="faq_question">Fai una domanda:</label>
                        <input class="input" name="faq_question" rows="4"style="width: 500px; height: 50px;" required></input>
        
                        <!-- Includi l'ID della domanda come campo nascosto -->
                        <input type="hidden" name="faq_id" value="<?php echo $faq_id; ?>">
        
                        <!-- Includi l'ID dell'utente come campo nascosto -->
                        <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
        
                        <button class="btn" type="submit">Invia Domanda FAQ</button>
                    </form>
                </td>
            </tr>
        </table>
        
        <h1 class="titolo">Tutte le FAQ</h1>
        
        <?php
        if (isset($_SESSION['loggato'])) {
            $email = $_SESSION['email'];
        }
        $xmlFile = '../xml/faq.xml';
        
        if (file_exists($xmlFile)) {
            $xml = simplexml_load_file($xmlFile);
            ?>
            <table>
                <thead>
                    <tr>
                        <th>Domanda</th>
                        <th>Risposte</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($xml->entry as $entry) {
                        $id = $entry->attributes()->id;
                        $question = $entry->question;
                        $answers = $entry->answers;
        
                        echo "<tr>";
                        echo "<td class='big'>$question</td>";
                        echo "<td>";
        
                        // Visualizza il form per scrivere la risposta
                        
        
                        if ($answers) {
                            foreach ($answers->answer as $answer) {
                                $answerText = $answer;
                                $answerEmail = isset($answer->attributes()->email) ? $answer->attributes()->email : $email; // Ottieni l'email associata alla risposta o utilizza quella della sessione
        
                                echo "<p class='big'><strong>$answerEmail</strong>: $answerText</p>";
                            }
                        }
                        echo '<form action="processa_risposta.php" method="post">';
                        echo "<input type='hidden' name='faq_id' value='$id'>";
                        echo '<label class="big" for="answer">Lascia una risposta:</label>';
                        echo '<input class="input" name="answer" rows="4" style="width: 500px; height: 50px;" required></input>';              
                        echo "<input type='hidden' name='email' value='$email'>";
                        echo '<button class="btn" type="submit">Invia Risposta</button>';
                        echo '</form>';
                        echo "</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        <?php
        } else {
            echo "Errore: Il file XML delle FAQ non esiste.";
        }
        ?>
        </div>
        </body>
        </html>
        <?php
         }
        else { 
            ?>
        <body>



            <div class="cont">

            
            <h1 class="titolo">Tutte le FAQ</h1>
            
            <?php
           
            $xmlFile = '../xml/faq.xml';
            
            if (file_exists($xmlFile)) {
                $xml = simplexml_load_file($xmlFile);
                ?>
                <table>
                    <thead>
                        <tr>
                            <th>Domanda</th>
                            <th>Risposte</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            foreach ($xml->entry as $entry) {
                            $id = $entry->attributes()->id;
                            $question = $entry->question;
                            $answers = $entry->answers;
                            
                            echo "<tr>";
                            echo "<td class='big'>$question</td>";
                            echo "<td>";
            
                            // Visualizza il form per scrivere la risposta
                            
            
                            if ($answers) {
                                foreach ($answers->answer as $answer) {
                                    $answerText = $answer;
                                    $answerEmail = isset($answer->attributes()->email) ? $answer->attributes()->email : $email; // Ottieni l'email associata alla risposta o utilizza quella della sessione
            
                                    echo "<p class='big'><strong>$answerEmail</strong>: $answerText</p>";
                                }
                            }
                            echo "</td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            <?php
            } else {
                echo "Errore: Il file XML delle FAQ non esiste.";
            }
            ?>
            </div>
            </body>
            </html>
            <?php
            } 
        ?>
    

