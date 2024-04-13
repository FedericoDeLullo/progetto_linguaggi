<?php
function calcolaBonusAcquisto() {
    $somma_totale = 0;

    if (isset($_SESSION['carrello'])) {
        foreach ($_SESSION['carrello'] as $prodotto_carrello) {
            if(isset($prodotto_carrello) && isset($prodotto_carrello['bonus']) && isset($prodotto_carrello['quantita']) && isset($prodotto_carrello['prezzo'])){
                $somma_totale += $prodotto_carrello['bonus'] * $prodotto_carrello['quantita'];
            }
        }
    }

    return $somma_totale;
}

function getAcquisti($xmlFile)
{
    $acquisti = [];

    $acquisti_doc = new DOMDocument();
    $acquisti_doc->load($xmlFile);

    $acquistiList = $acquisti_doc->getElementsByTagName('acquisto');

    foreach ($acquistiList as $acquisto) {
        $IDUtente = $acquisto->getAttribute('id_utente');
        $data = $acquisto->getElementsByTagName('data')->item(0)->nodeValue;
        $ora = $acquisto->getElementsByTagName('ora')->item(0)->nodeValue;
        $idProdotto = $acquisto->getElementsByTagName('id_prodotto')->item(0)->nodeValue;
        $nome = $acquisto->getElementsByTagName('nome')->item(0)->nodeValue;
        $prezzoUnitario = $acquisto->getElementsByTagName('prezzo_unitario')->item(0)->nodeValue;
        $quantita = $acquisto->getElementsByTagName('quantita')->item(0)->nodeValue;
        $prezzoTotale = $acquisto->getElementsByTagName('prezzo_totale')->item(0)->nodeValue;

        $acquisti[] = [
            'IDUtente' => $IDUtente,
            'data' => $data,
            'ora' => $ora,
            'idProdotto' => $idProdotto,
            'nome' => $nome,
            'prezzoUnitario' => $prezzoUnitario,
            'quantita' => $quantita,
            'prezzo_totale' => $prezzoTotale,
        ];
    }

    return $acquisti;
}
// Funzione per caricare i prodotti dal catalogo
function getProdotti($xmlFile) {

    // Array dove poi metterò i prodotti presi dal file catalogo.xml
    $prodotti = [];

    // Crea un nuovo oggetto DOMDocument e carica il file XML
    $dom = new DOMDocument();
    $dom->load($xmlFile);

    $lista_prodotti = $dom->getElementsByTagName('prodotto');

    foreach ($lista_prodotti as $prodotto) {

        $id_prodotto = $prodotto->getElementsByTagName('id_prodotto')->item(0)->nodeValue;
        $nome = $prodotto->getElementsByTagName('nome')->item(0)->nodeValue;
        $descrizione = $prodotto->getElementsByTagName('descrizione')->item(0)->nodeValue;
        $prezzo = $prodotto->getElementsByTagName('prezzo')->item(0)->nodeValue;
        $tipologia = $prodotto->getElementsByTagName('tipologia')->item(0)->nodeValue;
        $sconto_generico = $prodotto->getElementsByTagName('sconto_generico')->item(0)->nodeValue;
        $immagine = $prodotto->getElementsByTagName('immagine')->item(0)->nodeValue;

        // Mi prendo i parametri dello sconto
        $sconto = $prodotto->getElementsByTagName('sconto')->item(0);

        $sconto_X = $sconto->getElementsByTagName('x')->item(0)->nodeValue;
        $sconto_Y = $sconto->getElementsByTagName('y')->item(0)->nodeValue;
        $sconto_M = $sconto->getElementsByTagName('m')->item(0)->nodeValue;
        $sconto_data_M = $sconto->getElementsByTagName('data_m')->item(0)->nodeValue;
        $sconto_N = $sconto->getElementsByTagName('n')->item(0)->nodeValue;
        $sconto_R = $sconto->getElementsByTagName('r')->item(0)->nodeValue;

        $prodotti[] = [
            'id_prodotto' => $id_prodotto,
            'nome' => $nome,
            'descrizione' => $descrizione,
            'prezzo' => $prezzo,
            'tipologia' => $tipologia,
            'sconto_generico' => $sconto_generico,
            'immagine' => $immagine,

            'sconto' => [
                'x' => $sconto_X,
                'y' => $sconto_Y,
                'm' => $sconto_M,
                'data_m' => $sconto_data_M,
                'n' => $sconto_N,
                'r' => $sconto_R,
            ]
        ];
    }

    return $prodotti;
}



function calcolaScontoProdotto($xmlpath, $id_prodotto, $prezzo)
{
    $prezzoFinale = 0;

    if (isset($_SESSION['loggato']) && $_SESSION['loggato'] == true) {

        include('connection.php');


        $prodotti_documento = getProdotti($xmlpath);

        $sconto_percentuale = 0;

        foreach ($prodotti_documento as $prodotto_documento) {

            if ($prodotto_documento['id_prodotto'] == $id_prodotto) {

                $sc_X = $prodotto_documento['sconto']['x'];
                $sc_Y = $prodotto_documento['sconto']['y'];
                $sc_M = $prodotto_documento['sconto']['m'];
                $sc_data_M = $prodotto_documento['sconto']['data_m'];
                $sc_N = $prodotto_documento['sconto']['n'];
                $sc_R = $prodotto_documento['sconto']['r'];
                $sc_ha_acquistato = $prodotto_documento['sconto']['ha_acquistato'];

                $sc_generico = $prodotto_documento['sconto_generico'];

                // Parto con i parametri X e Y

                // 1) Inizio calcolandomi la data completa X mesi + Y anni
                $XY = $sc_Y * 12 + $sc_X;

                $dataMinimaRegistrazione = new DateTime();
                $dataMinimaRegistrazione->sub(new DateInterval("P{$XY}M"));

                // 2) Ora devo prendere la data di registrazione e controllare se la data di registrazione > di $data rispetto a quella attuale
                $query = "SELECT utenti.data_registrazione FROM utenti WHERE utenti.email = '{$_SESSION['email']}'";
                $ris = $connessione->query($query);

                if (mysqli_num_rows($ris) == 1) {
                    $row = $ris->fetch_assoc();
                    $data_registrazione = $row['data_registrazione'];
                }

                // Converto la data in formato DateTime per poter fare la differenza
                $data_formattata_registrazione = DateTime::createFromFormat('Y-m-d', $data_registrazione);

                if ($data_formattata_registrazione <= $dataMinimaRegistrazione) {
                    $X_Y_check = true;
                } else {
                    $X_Y_check = false;
                }

                // Ora devo gestirmi i parametri M e data_M

                // 1) Mi preparo il necessario ovvero l'id dell'utente loggato e mi carico gli acquisti
                $xmlpath_acquisti = "../xml/storico_acquisti.xml";
                $acquisti = getAcquisti($xmlpath_acquisti);

                $query = "SELECT utenti.id FROM utenti WHERE utenti.email = '{$_SESSION['email']}'";
                $ris = $connessione->query($query);

                if (mysqli_num_rows($ris) == 1) {
                    $row = $ris->fetch_assoc();
                    $id_loggato = $row['id'];
                }

                $spesa_totale_entro_data = 0;

                // 2) Ora faccio il controllo se si è speso un certo ammontare di crediti entro una certa data
                foreach ($acquisti as $acquisto) {
                    if ($acquisto['IDUtente'] == $id_loggato && $acquisto['data'] >= $sc_data_M) {
                        // Considero un singolo acquisto alla volta
                
                        // Supponendo che $acquisto['nome'] sia il nome del prodotto
                        $nomeProdotto = $acquisto['nome'];
                
                        // Aggiungo il prezzo del singolo prodotto alla spesa totale
                        $spesa_totale_entro_data += $acquisto['prezzo_totale'];
                    }
                }
                // 3) Controllo se la quantità spesa entro una certa data è almeno uguale a quella dello sconto parametrico
                if ($spesa_totale_entro_data >= $sc_M) {
                    $M_data_da_M_check = true;
                } else {
                    $M_data_da_M_check = false;
                }

                $spesa_totale = 0;

                // Ora mi devo occupare del parametro N, ovvero se sono stati spesi un certo ammontare di crediti in totale
                foreach ($acquisti as $acquisto) {
                    if ($acquisto['IDUtente'] == $id_loggato) {
                        // Somma direttamente il prezzo totale di ogni acquisto
                        $spesa_totale += $acquisto['prezzo_totale'];
                    }
                }

                if ($spesa_totale >= $sc_N) {
                    $N_check = true;
                } else {
                    $N_check = false;
                }

                // Ora controllo che il cliente loggato abbia una certa reputazione, ovvero il parametro R
                $query = "SELECT utenti.reputazione FROM utenti WHERE utenti.email = '{$_SESSION['email']}'";
                $ris = $connessione->query($query);

                if (mysqli_num_rows($ris) == 1) {
                    $row = $ris->fetch_assoc();
                    $reputazione_loggato = $row['reputazione'];
                }

                if ($reputazione_loggato >= $sc_R) {
                    $R_check = true;
                } else {
                    $R_check = false;
                }


                // Ora ho controllato TUTTI i parametri, se tutte le variabili booleane sono a true aggiungo uno sconto percentuale
                if ($X_Y_check && $M_data_da_M_check && $N_check && $R_check) {
                    $sconto_percentuale += 4;
                    $_SESSION['sconto_parametrico'] = true;
                }

                // Ora ci sommo anche lo sconto generico se diverso da 0
                if ($sc_generico > 0) {
                    $sconto_percentuale += $sc_generico;
                    $_SESSION['sconto_generico'] = true;
                }
            }
        }

        $quantitaPercentuale = $prezzo * ($sconto_percentuale / 100);

        $prezzoFinale = $prezzo - $quantitaPercentuale;

        // In questo modo non mi approssima i numeri => ex 19.1 in 19.13
        $prezzoFinale = number_format($prezzoFinale, 2, '.', '');

        // Se non mi è stato modificato il prezzo con quello scontato metto quello originale
        if ($prezzoFinale == 0) {
            $prezzoFinale = $prezzo;
        }
    }

    return $prezzoFinale;
}
?>
