# progetto_linguaggi
Progetto realizzato dagli studenti Federico De Lullo e Lorenzo Francescotti.

Link repository GitHub:
Federico:https://github.com/FedericoDeLullo/progetto_linguaggi.git
Lorenzo:https://github.com/lollofrancescotti/progetto_linguaggi.git


Abbiamo continuato il nostro sito precedente aggiungendo elementi in  e MYSQL.

Per far partire il sito bisogna cliccare su install.php che creerà il database e porterà automaticamente alla home.
Per accedere agli articoli è necessario registrarsi e poi loggarsi.
Se in fase di registrazione viene inserite credenziali già precedentemente utilizzate, il controllo verrà effettuato sull'username.
Dunque se si vuole utilizzare un username uguale ad uno già usato verrà stampato il messaggio  "Utente già esistente".
Quando un utente seleziona un articolo, quest'ultimo viene inserito nel carrello.
Quando si finalizza l'acquisto, verrà aggiornata la tabella "acquisti" nel database, con l'username dell'utente che ha acquistato l'articolo, l'id_articolo e la quantita che è stata acquistata.
