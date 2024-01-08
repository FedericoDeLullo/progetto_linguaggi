<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aggiungi Prodotto</title>
    <link rel="stylesheet" href="../css/style_aggiungi.css">
</head>
<body>
<div class="home">
                    <a href="../html/">
                <div class="home_link" title="home"><img src="../img/home1.png" alt="home"></div></a>
            </div>
    
    <h2>Aggiungi Prodotto</h2>
    <div class="cont">
    <form  class="form" action="aggiungi_prodotto.php" method="post" enctype="multipart/form-data">
        <label class="nome" for="nome">Nome Prodotto:</label>
        <input class="nome" type="text" name="nome" required><br>
<div class="des">
        <label class="" for="descrizione">Descrizione Prodotto:</label>
        <textarea class="" name="descrizione" required></textarea><br>
</div>
        <label class="prezzo" for="prezzo">Prezzo Prodotto:</label>
        <input class="prezzo" type="number" name="prezzo" step="0.01" required><br>

        <label class="immagine" for="immagine">Immagine Prodotto:</label>
        <input class="immagine" type="file" name="immagine" accept="image/*" required><br>

        <label class="tipologia" for="tipologia">Tipologia Prodotto</label>
    <select select id="tipologia" name="tipologia">
        <option value="magliette">Magliette</option>
        <option value="pantaloncini">Pantaloncini</option>
        <option value="calzettoni">Calzettoni</option>
    </select>
<br><br>
        <input class="btn" type="submit" value="Aggiungi Prodotto">
    </form>
</div>
</body>
</html>
