# Note sulle Query SQL

Questo documento descrive le query principali utilizzate nei componenti del progetto

## Album della Settimana (`album_of_week.php`)

**Query**: Seleziona il vinile più collezionato dalla community

**Logica**: Conta quante volte ogni edizione appare nella tabella `ownership`, fa JOIN con `edition`, `disk`, `disk_author_release` e `author` per recuperare tutti i dati necessari. Ordina per `ownership_count` decrescente e prende solo il primo risultato (LIMIT 1)

**Scopo**: Mostrare come "album della settimana" il vinile più popolare tra gli utenti

## Raccomandazioni Personalizzate (`recommended_vinyls.php`)

### Query 1: Genere Preferito
Analizza la collezione dell'utente autenticato per trovare il genere musicale più presente. Conta le occorrenze di ogni genere nei dischi posseduti (tabella `ownership` JOIN `disk_genre_classification`), ordina per frequenza e seleziona il più comune

### Query 2: Raccomandazioni
Seleziona 4 vinili casuali del genere preferito che l'utente NON possiede ancora. Utilizza NOT EXISTS per escludere i dischi già in `ownership`. ORDER BY RAND() garantisce varietà nelle raccomandazioni

### Query 3: Fallback
Se l'utente non è autenticato o non ha collezioni, mostra i 4 vinili più collezionati dalla community (stessa logica dell'album della settimana, ma con LIMIT 4)

**Sicurezza**: Utilizza prepared statements con `mysqli_prepare` e `mysqli_stmt_bind_param` per prevenire SQL injection.

## Artisti Più Amati (`most_liked_artists.php`)

**Query**: Seleziona i 4 artisti con più vinili collezionati.

**Logica**: Fa JOIN tra `author`, `disk_author_release` e `ownership`. Conta il numero di utenti distinti (`COUNT(DISTINCT o.user_id)`) che possiedono almeno un vinile di quell'artista. Ordina per `collector_count` decrescente e limita a 4 risultati.

**Scopo**: Mostrare gli artisti più popolari basandosi sulla diffusione delle loro opere nelle collezioni degli utenti.
