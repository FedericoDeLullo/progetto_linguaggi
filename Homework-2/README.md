# progetto_linguaggi
Progetto realizzato dagli studenti Federico De Lullo e Lorenzo Francescotti.

Link repository GitHub:
Federico:https://github.com/FedericoDeLullo/progetto_linguaggi.git
Lorenzo:https://github.com/lollofrancescotti/progetto_linguaggi.git


Abbiamo continuato il nostro sito precedente aggiungendo elementi in PHP e MYSQL.

Per far partire il sito bisogna cliccare su install.php che creerà il database e porterà automaticamente alla home.
Per accedere agli articoli è necessario registrarsi e poi loggarsi.
Se in fase di registrazione viene inserite credenziali già precedentemente utilizzate, il controllo verrà effettuato sull'username.
Dunque se si vuole utilizzare un username uguale ad uno già usato verrà stampato il messaggio  "Utente già esistente".
E' stato aggiunto un carrello per gli acquisti.
Nella pagina degli articoli verrà selezionato l'articolo e la quantità desiderata e poi si dovrà premere il pulsante "aggiungi" per aggiungerlo al carrello.
All'interno del carrello, se sono presenti articoli, una volta premuto il bottone "Conferma acquisto" verrà aggiornata la tabella "acquisti" all'interno del database con l'username di chi ha acquistato, l'id_articolo e la quantità.
Se nel carrello non sono presenti articoli e si preme su "conferma articoli" ci stamperà un errore e verremo reindirizzati alla pagina degli articoli.
Per accedere alla pagina degli acquisti effettuati "Acquisti" sarà necessario prima loggarsi.
