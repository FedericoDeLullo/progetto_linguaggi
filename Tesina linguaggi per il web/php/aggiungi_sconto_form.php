<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Il tuo carrello</title>
    <link rel="stylesheet" href="../css/style_standard.css">
    <link rel="stylesheet" href="../css/style_catalogo.css">
    <link rel="stylesheet" href="../css/style_search.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="../css/style_header.css">
    <?php
        include('../res/header.php');
    ?>
</head>
<body>
<div class="cont">
<h1 class="titolo">Aggiungi sconto</h1>

<form method="post" action="gestione_sconti.php">
    <table>
        <tr>
            <th>SCONTO</th>
            <th>PERCENTUALE</th>
            <th>SELEZIONE</th>
        </tr>
        <tr>
            <td>Clienti che hanno speso N crediti finora</td>
            <td><input type="number" name="percentuale_sconto_spesi_n" min="0" max="100" placeholder="%">%</td>
            <td class="checkbox-cell"><input type="checkbox" name="sconto_clienti_spesi_n"></td>
        </tr>
        <tr>
            <td>Clienti che hanno speso M crediti da una certa data</td>
            <td><input type="number" name="percentuale_sconto_spesi_da_data" min="0" max="100" placeholder="%">%</td>
            <td class="checkbox-cell"><input type="checkbox" name="sconto_clienti_spesi_da_data"></td>
        </tr>
        <tr>
            <td>Clienti che hanno acquistato una certa offerta</td>
            <td><input type="number" name="percentuale_sconto_offerta" min="0" max="100" placeholder="%">%</td>
            <td class="checkbox-cell"><input type="checkbox" name="sconto_clienti_offerta"></td>
        </tr>
        <tr>
            <td>Clienti che hanno una certa reputazione</td>
            <td><input type="number" name="percentuale_sconto_reputazione" min="0" max="100" placeholder="%">%</td>
            <td class="checkbox-cell"><input type="checkbox" name="sconto_clienti_reputazione"></td>
        </tr>
        <tr>
            <td>Clienti che sono con noi da X mesi</td>
            <td><input type="number" name="percentuale_sconto_da_x_mesi" min="0" max="100" placeholder="%">%</td>
            <td class="checkbox-cell"><input type="checkbox" name="sconto_clienti_da_x_mesi"></td>
        </tr>
        <tr>
            <td>Clienti che sono con noi da Y anni</td>
            <td><input type="number" name="percentuale_sconto_da_y_anni" min="0" max="100" placeholder="%">%</td>
            <td class="checkbox-cell"><input type="checkbox" name="sconto_clienti_da_y_anni"></td>
        </tr>
        <tr>
            <td>Sconto indiscriminato</td>
            <td><input type="number" name="percentuale_sconto_indiscriminato" min="0" max="100" placeholder="%">%</td>
            <td class="checkbox-cell"><input type="checkbox" name="sconto_indiscriminato"></td>
        </tr>
        <tr>
            <td colspan="3"><input type="submit" value="Aggiungi Sconti"></td>
        </tr>
    </table>
</form>

</div>
</body>
</html>
