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

## Vinili di Tendenza (`trending_vinyls.php`)

**Query**: Seleziona i 4 vinili più desiderati per la home page

**Logica**: Parte da `wishlist_count` (vista che raggruppa wishlist per disk_id/edition_name), fa JOIN con `disk` e `edition` per i dettagli. Utilizza due subquery per recuperare il primo author_id e author_name associato al disco (LIMIT 1 sulle subquery per evitare duplicati da dischi multi-autore).

**Scopo**: Mostrare i vinili più popolari nelle wishlist degli utenti. La query evita duplicati partendo dalla vista aggregata invece di fare JOIN diretti con disk_author_release.

## Vinili Più Collezionati (`most_collected_vinyls.php`)

**Query**: Seleziona i 4 vinili più posseduti dagli utenti.

**Logica**: Parte da `ownership`, fa JOIN con `edition` e `disk`, raggruppa per disk_id/edition_name e conta gli utenti (`COUNT(o.user_id)`). Utilizza subquery per author_id e author_name (stessa tecnica di trending_vinyls). Ordina per `ownership_count` decrescente e limita a 4.

**Scopo**: Mostrare i vinili più diffusi nelle collezioni, diverso da trending (wishlist vs ownership). Indica quali vinili sono effettivamente più posseduti dalla community.

## Pagina Artista (`artist.php`)

### Informazioni Artista (`artist_info.php`)

**Query 1: Dati Artista**
Seleziona id, nome, nazionalità e percorso immagine dell'artista dalla tabella `author` tramite l'ID ricevuto in GET. Utilizza prepared statement per sicurezza.

**Query 2: Generi Musicali**
Recupera i generi distinti associati all'artista attraverso un JOIN tra `genre`, `disk_genre_classification` e `disk_author_release`. Ogni genere viene renderizzato come `<span class="tag" role="listitem">` per accessibilità.

### Album dell'Artista (`artist_albums.php`)

**Query**: Seleziona tutti gli album (disk_type = 'ALBUM') dell'artista con le relative edizioni.

**Logica**: JOIN tra `disk`, `disk_author_release`, `edition` e `author`. Filtra per artist_id e disk_type. Ordina per data di rilascio decrescente per mostrare prima le uscite più recenti. Recupera anche author_name e author_id per i link interni.

**Fallback immagine**: Verifica l'esistenza del file immagine sul server prima di usarlo, altrimenti utilizza `pollo.webp` come placeholder.

### Singoli ed EP (`artist_singles.php`)

**Query**: Seleziona singoli ed EP (disk_type IN ('SINGLE', 'EP')) dell'artista.

**Logica**: Stessa struttura della query album ma con filtro diverso sul tipo di disco. Permette di separare la discografia tra produzioni complete (album) e singole tracce.

### Artisti Simili (`similar_artists.php`)

**Query**: Trova artisti che condividono generi musicali con l'artista corrente.

**Logica**: Utilizza una subquery IN per identificare gli author_id che hanno pubblicato dischi appartenenti agli stessi generi dell'artista visualizzato. Esclude l'artista stesso (`a.id != ?`) per evitare autoreferenza. Limita a 4 risultati per non sovraccaricare la UI. La similarità è determinata dalla sovrapposizione di generi.

