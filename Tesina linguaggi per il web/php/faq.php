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
<body>
    <div class="cont">
        <?php
        require_once('../res/connection.php');
        if(isset($_SESSION['loggato'])){
            $id_utente = $_SESSION['id'];
            $gestore = $_SESSION['gestore'];
            $admin = $_SESSION['ammin'];
            $utente = $_SESSION['utente'];
        ?>
            <?php if($utente == 1){ ?>
                <h1 class="titolo">Tutte le FAQ</h1>
                <?php
                $xmlFile = '../xml/faq.xml';
                if (file_exists($xmlFile)) {
                    $dom = new DOMDocument();
                    $dom->load($xmlFile);
                    $entries = $dom->getElementsByTagName('entry');
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
                        foreach ($entries as $entry) {
                            $id = $entry->getAttribute('id');
                            $questions = $entry->getElementsByTagName('question');
                            $answers = $entry->getElementsByTagName('answer');
                        ?>
                        <tr>
                            <td><strong><?php echo $questions[0]->nodeValue; ?></strong></td>
                            <td>
                                <?php
                                foreach ($answers as $answer) {
                                ?>
                                <p><strong><?php echo $answer->nodeValue; ?></strong></p>
                                <?php
                                }
                                ?>
                            </td>
                        </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
                <?php
                } else {
                    echo "Errore: Il file XML delle FAQ non esiste.";
                }
                ?>
            <?php
            } elseif($gestore == 1 || $admin == 1){
            ?>
                <?php
                if (isset($_SESSION['id'])) {
                    $user_id = $_SESSION['id'];
                } else {
                    echo "Errore: ID dell'utente non disponibile.";
                    exit();
                }
                $faq_id = uniqid();
                ?>
                <h1 class="titolo">Inserisci una nuova FAQ</h1>
                <table class="up">
                    <tr>
                        <th>Invia una domanda FAQ</th>
                    </tr>
                    <tr>
                        <td>
                            <form action="processa_domanda.php" method="post">
                                <label class="big" for="faq_question">Inserisci una domanda:</label>
                                <input class="input" name="faq_question" rows="4" style="width: 500px; height: 50px;" required>
                                <input type="hidden" name="faq_id" value="<?php echo $faq_id; ?>">
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
                    $dom = new DOMDocument();
                    $dom->load($xmlFile);
                    $entries = $dom->getElementsByTagName('entry');
                ?>
                <table>
                    <thead>
                        <tr>
                            <th>Elimina</th>
                            <th>Domanda</th>
                            <th>Risposte</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($entries as $entry) {
                            $id = $entry->getAttribute('id');
                            $questions = $entry->getElementsByTagName('question');
                            $answers = $entry->getElementsByTagName('answer');
                        ?>
                        <tr>
                            <td>
                                <a href="../res/elimina_faq.php?id=<?php echo $id; ?>"><span id="done" class="material-symbols-outlined">delete</span></a>
                            </td>
                            <td>
                                <p class='big'><strong><?php echo $questions[0]->nodeValue; ?></strong></p>
                                <form action="processa_modifica.php" method="post">
                                    <input type='hidden' name='faq_id' value='<?php echo $id; ?>'>
                                    <label class="big" for="answer">Modifica domanda:</label>
                                    <input class="input" name="answer" style="width: 500px; height: 50px;" required>
                                    <button class="btn" type="submit">Modifica</button>
                                </form>
                            </td>
                            <td>
                                <?php
                                foreach ($answers as $answer) {
                                ?>
                                <p class='big'><strong><?php echo $answer->nodeValue; ?></strong></p>
                                <?php
                                }
                                ?>
                                <form action="processa_risposta.php" method="post">
                                    <input type='hidden' name='faq_id' value='<?php echo $id; ?>'>
                                    <label class="big" for="answer">Modifica risposta:</label>
                                    <input class="input" name="answer" rows="4" style="width: 500px; height: 50px;" required>
                                    <input type='hidden' name='email' value='<?php echo $email; ?>'>
                                    <button class="btn" type="submit">Modifica</button>
                                </form>
                            </td>
                        </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
                <?php
                } else {
                    echo "Errore: Il file XML delle FAQ non esiste.";
                }
                ?>
            <?php } else { ?>
                <h1 class="titolo">Tutte le FAQ</h1>
                <?php
                $xmlFile = '../xml/faq.xml';
                if (file_exists($xmlFile)) {
                    $dom = new DOMDocument();
                    $dom->load($xmlFile);
                    $entries = $dom->getElementsByTagName('entry');
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
                        foreach ($entries as $entry) {
                            $id = $entry->getAttribute('id');
                            $questions = $entry->getElementsByTagName('question');
                            $answers = $entry->getElementsByTagName('answer');
                        ?>
                        <tr>
                            <td class='big'><strong><?php echo $questions[0]->nodeValue; ?></strong></td>
                            <td>
                                <?php
                                foreach ($answers as $answer) {
                                ?>
                                <p class='big'><strong><?php echo $answer->nodeValue; ?></strong></p>
                                <?php
                                }
                                ?>
                            </td>
                        </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
                <?php
                } else {
                    echo "Errore: Il file XML delle FAQ non esiste.";
                }
                ?>
            <?php } 
        } else { 
        ?>
            <h1 class="titolo">Tutte le FAQ</h1>
            <?php
            $xmlFile = '../xml/faq.xml';
            if (file_exists($xmlFile)) {
                $dom = new DOMDocument();
                $dom->load($xmlFile);
                $entries = $dom->getElementsByTagName('entry');
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
                    foreach ($entries as $entry) {
                        $id = $entry->getAttribute('id');
                        $questions = $entry->getElementsByTagName('question');
                        $answers = $entry->getElementsByTagName('answer');
                    ?>
                    <tr>
                        <td class='big'><strong><?php echo $questions[0]->nodeValue; ?></strong></td>
                        <td>
                            <?php
                            foreach ($answers as $answer) {
                            ?>
                            <p class='big'><strong><?php echo $answer->nodeValue; ?></strong></p>
                            <?php
                            }
                            ?>
                        </td>
                    </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
            <?php
            } else {
                echo "Errore: Il file XML delle FAQ non esiste.";
            }
        }
        ?>
    </div>
</body>
</html>