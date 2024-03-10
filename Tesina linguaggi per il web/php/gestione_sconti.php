<?php

session_start();

$id_prodotto = $_POST['id_prodotto'];

$sc_X = $_POST['registrazione_mesi'];
$sc_Y = $_POST['registrazione_anni'];
$sc_M = $_POST['crediti_data'];
$sc_data_M = $_POST['da_data'];
$sc_N = $_POST['crediti'];
$sc_R = $_POST['reputazione'];
$sc_bonus = $_POST['bonus'];
$tipologia = $_POST['tipologia'];
$sc_generico = $_POST['generico'];

$xmlPath = "../xml/catalogo_prodotti.xml";

$document = new DOMDocument();
$document->load($xmlPath);    

$prodotti = $document->getElementsByTagName("prodotto");

foreach($prodotti as $prodotto){

    $id_prodotto_pp = $prodotto->getElementsByTagName("id_prodotto")->item(0)->nodeValue;

    if($id_prodotto_pp == $id_prodotto){

        //ci troviamo nel fumetto da modificare
        $sconto = $prodotto->getElementsByTagName('sconto')->item(0);
        $sconto->getElementsByTagName('x')->item(0)->nodeValue = $sc_X;
        $sconto->getElementsByTagName('y')->item(0)->nodeValue = $sc_Y;
        $sconto->getElementsByTagName('m')->item(0)->nodeValue = $sc_M;
        $sconto->getElementsByTagName('data_m')->item(0)->nodeValue = $sc_data_M;
        $sconto->getElementsByTagName('n')->item(0)->nodeValue = $sc_N;
        $sconto->getElementsByTagName('r')->item(0)->nodeValue = $sc_R;

        $prodotto->getElementsByTagName('sconto_generico')->item(0)->nodeValue = $sc_generico;
        $prodotto->getElementsByTagName('bonus')->item(0)->nodeValue = $sc_bonus;

        break; 
    }
}

// Salva il documento XML aggiornato nel file
$document->save($xmlPath);
$_SESSION['form_off_X'] = $sc_X;
$_SESSION['form_off_Y'] = $sc_Y;
$_SESSION['form_off_M'] = $sc_M;
$_SESSION['form_off_data_M'] = $sc_data_M;
$_SESSION['form_off_N'] = $sc_N;
$_SESSION['form_off_R'] = $sc_R;

$_SESSION['form_off_generico'] = $sc_generico;
$_SESSION['form_off_bonus'] = $sc_bonus;
header('Location: catalogo_' . $tipologia . '.php');

?>