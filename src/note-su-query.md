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

## Pagina Album (`album.php`)

### Informazioni Album (`album_info.php`)

**Query 1: Dati Album**
Recupera id, titolo, tipo disco, artista (id e nome), anno di rilascio, immagine, rating medio e conteggio recensioni. JOIN tra `disk`, `disk_author_release`, `author`, `edition` e `review`. Utilizza `COALESCE` per gestire album senza recensioni.

**Query 2: Generi Album**
Seleziona i generi distinti associati al disco tramite JOIN tra `genre` e `disk_genre_classification`. Ogni genere viene renderizzato come tag.

### Tracklist (`album_tracklist.php`)

**Query**: Recupera tutte le tracce associate al disco con numero, titolo e durata.

**Logica**: JOIN tra `track` e `edition_track_part_of` filtrato per disk_id. Ordina per track_number. Se il disco ha ≤2 tracce (singoli), la sezione non viene mostrata.

### Versioni Album (`album_versions.php`)

**Query**: Trova altri album dello stesso artista.

**Logica**: Partendo dal disk corrente, risale all'artista tramite `disk_author_release`, poi trova tutti gli altri dischi dello stesso artista. JOIN con `edition` per dettagli edizione. Esclude il disco corrente (`d2.id != ?`). Limita a 8 risultati.

### Crediti Album (`album_credits.php`)

**Query**: Recupera nome e immagine dell'artista principale.

**Logica**: JOIN tra `author` e `disk_author_release` filtrato per disk_id. I ruoli (Co-writing, Producer) sono attualmente statici per l'artista principale.

## Pagina Profilo (`profile.php`)

### Statistiche Profilo (`profile_statistics()`)

**Query 1: Conteggio Collezione**
```sql
SELECT COUNT(*) as count FROM ownership WHERE user_id = $user_id
```
Conta il numero totale di dischi posseduti dall'utente nella tabella `ownership`.

**Query 2: Conteggio Wishlist**
```sql
SELECT COUNT(*) as count FROM wishlist WHERE user_id = $user_id
```
Conta il numero totale di dischi nella lista desideri dell'utente.

**Query 3: Conteggio Artisti Unici**
```sql
SELECT COUNT(DISTINCT a.id) as count 
FROM ownership o 
JOIN disk d ON o.disk_id = d.id 
JOIN disk_author_release dar ON d.id = dar.disk_id 
JOIN author a ON dar.author_id = a.id 
WHERE o.user_id = $user_id
```
Conta quanti artisti diversi sono presenti nella collezione dell'utente. Utilizza `DISTINCT` per evitare duplicati da dischi multi-autore o edizioni multiple dello stesso artista.

**Scopo**: Fornire metriche di riepilogo per la dashboard del profilo utente.

### Artisti Preferiti (`favorite_artists()`)

**Query**:
```sql
SELECT a.id, a.author_name, a.image_path, COUNT(DISTINCT o.disk_id) as disk_count
FROM ownership o
JOIN disk d ON o.disk_id = d.id
JOIN disk_author_release dar ON d.id = dar.disk_id
JOIN author a ON dar.author_id = a.id
WHERE o.user_id = $user_id
GROUP BY a.id, a.author_name, a.image_path
ORDER BY disk_count DESC, a.author_name ASC
LIMIT 3
```

**Logica**: Analizza la collezione dell'utente per identificare i 3 artisti con più dischi posseduti. Utilizza `COUNT(DISTINCT o.disk_id)` per contare i dischi unici per ogni artista. Il doppio ordinamento (`disk_count DESC, author_name ASC`) garantisce che in caso di parità venga rispettato l'ordine alfabetico.

**Rendering Dinamico**: La funzione PHP costruisce dinamicamente la lista mostrando solo gli artisti effettivamente presenti (1, 2 o 3 elementi), evitando placeholder vuoti. Se non ci sono artisti (collezione vuota), viene mostrato un messaggio di stato vuoto.

**Scopo**: Mostrare quali artisti dominano la collezione dell'utente, fornendo insight sulla loro preferenza musicale.

### Preview Collezione e Wishlist

Le funzioni `collection_cards()` e `wishlist_cards()` riutilizzano le query esistenti `get_collection()` e `get_wishlist()` definite nei componenti, limitando il risultato ai primi 4 elementi tramite logica PHP (`$i < 4`). Questo approccio mantiene la coerenza con le pagine collezione/wishlist complete.

