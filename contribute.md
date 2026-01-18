# Norme di Progetto

## Separazione Struttura, Presentazione e Comportamento

La struttura delle directory va a separare in maniera netta struttura presentazione e comportamento. E' un requisito fondamentale che questa separazione si rifletta altrettanto nel codice. Per fare ciò ogni tag html nei file php, esclusi quelli dentro le stringhe, sono considerati invalidi. Le parti "dinamiche" (p.e. lista vinili in tendenza) vanno espresse con un placeholder con la seguente sintassi:
```html
\[nome_placeholder\]
```
## Sistema di Template e Placeholder

 E' importante notare che non vanno codificate come placeholder parti che vanno valorizzate dal content editor, in quanto quest'ultimo si interfaccia solamente coi file html e non con i file php. Possono essere invece codificate come placeholder parti che variano in base al contenuto del database o in base a logiche di business (p.e. lista vinili in tendenza, lista categorie, ecc).

Per ogni pagina html deve esserci un corrispondente php. Le parti comuni del codice html che verranno riutilizzate vanno inserite nei file di layout (header.html, head.html, footer.html, ecc) nella directory `php/static/layout` e richiamate nei file html tramite i placeholder. Ad esempio, per inserire l'header in ogni pagina html si userà il placeholder `\[header\]` che verrà sostituito con il contenuto del file `php/static/layout/header.html`. E' compito poi del php sostituire i placeholder con il contenuto adeguato. Questo si fa tramite il metodo `Template::render()` (v. esempio sotto).
```html
<!-- codice html per index.html -->

<head>
    <meta name="description"
        content="Piattaforma dedicata agli appassionati di vinili per esplorare, collezionare e condividere la loro passione per la musica su vinile.">
    <meta name="keywords" content="[keywords]">
    <title>Vinyl Vault</title>
    [head] <!-- qui viene inserita la parte invariante dell'header-->
</head>

<body>
    <header>
        [header]
    </header>
    <nav id="breadcrumb" aria-label="percorso di navigazione">
        <p><span lang="eng">Home</span></p>
    </nav>

<!-- ... -->

    <section id="trending">
        [trending_vinyls]
    </section>

<!-- ... -->
```

```php
//Codice PHP per index.php...

echo Template::render(
    '../../index.html',
    [
        'head' => Template::render('layout/head.html',[]),
        'header' => Template::render('layout/header.html',[]),
        'trending_vinyls' => $trending_vinyls
        // Altri placeholder e loro contenuti possono essere aggiunti qui
    ]
);
```
## Componenti Riutilizzabili

E' buona pratica lasciare il render della pagina come ultima istruzione del file php.

Facendo riferimento all'esempio precedente, elementi riutilizzati in più pagine come la lista dei vinili in tendenza, andranno gestiti in un file php a parte (p.e. `trending_vinyls.php`) che verrà incluso tramite `include once` nel file php principale (`index.php`) e il cui output verrà assegnato alla variabile `$trending_vinyls`. In questo modo si mantiene il codice modulare e facilmente manutenibile. Esempio:
```php
// Codice PHP per trending_vinyls.php
ob_start();
$vinyls = Vinyl::getTrendingVinyls(); // Supponendo che questa funzione recuperi i vinili in tendenza
foreach ($vinyls as $vinyl) {
    echo "<div class='vinyl-item'>";
    echo "<h3>" . htmlspecialchars($vinyl->title) . "</h3>";
    echo "<p>by " . htmlspecialchars($vinyl->artist) . "</p>";
    echo "</div>";
}
return ob_get_clean();
```
```php
// Codice PHP per index.php, prima del render finale della pagina
include 'trending_vinyls.php'; // Include il file che genera la lista dei vinili in tendenza
$trending_vinyls = trending_vinyls();
```

## Convenzioni per la Nomenclatura

E' mandatorio l'utilizzo di
- `snake_case` per nomi di variabili e funzioni
- `PascalCase` per nomi di classi
- `kebab-case` per id e classi CSS

## Connessione al Database

Per la connessione al database si utilizza il pattern **Singleton** tramite la classe `DbConnection`, questo garantisce una sola istanza della connessione per l'intera applicazione evitando connessioni multiple.
Si utilizza con:

```php
$db = DbConnection::get_instance();
$conn = $db->get_connection();
```

## Sistema di Colori

I colori sono definiti tramite variabili CSS semantiche in `stylesheets/style.css`. Utilizzare sempre le variabili invece dei valori esadecimali per garantire coerenza e facilitare il possibile cambio tema. Consultare `style-var-colors.md` per la documentazione completa delle variabili disponibili.

Per testare rapidamente i colori e verificare il contrasto tra i temi, è disponibile il file `test-colors.html` che mostra tutte le variabili applicate e permette di cambiare velocemente tra tema chiaro e scuro.

## Sistema Responsive delle Card

Le card (vinili e artisti) utilizzano un sistema di layout responsive unificato per garantire una visualizzazione ottimale su tutti i dispositivi, evitando scroll orizzontale indesiderato:n 

**Container**: Tutti i container di card (`.trending-vinyls-container`, `.vinyls-container`, `.artists-container`) utilizzano CSS Grid con `grid-template-columns: repeat(auto-fit, minmax(200px, 1fr))` per adattarsi dinamicamente allo spazio disponibile.

**Media queries responsive**: Per garantire una disposizione controllata su schermi di diverse dimensioni:
- **Schermi piccoli** (≤768px): massimo 2 card per riga (`grid-template-columns: repeat(2, 1fr)`)
- **Schermi grandi** (≥769px): massimo 4 card per riga (`grid-template-columns: repeat(4, 1fr)`)

**Card flessibili**: La classe `.card` utilizza `width: 100%` con `max-width: 250px` e `margin: 0 auto` per adattarsi proporzionalmente alla griglia mantenendo dimensioni leggibili.

**Limitazione contenuti**: Per evitare layout sovraffollati, i componenti della pagina esplora mostrano un massimo di 4 elementi per sezione (impostato tramite `LIMIT 4` nelle query SQL).

## Sistema di Raccomandazione (in Esplora)

Il sistema di raccomandazione presente nella pagina "Esplora" utilizza un approccio basato sui generi musicali per suggerire vinili rilevanti all'utente. La logica implementata prevede due modalità:

**Utente autenticato**: Il sistema analizza la collezione personale dell'utente (tabella `ownership`) per identificare il genere più presente tramite la tabella `disk_genre_classification`. Una volta individuato il genere preferito, vengono raccomandati 10 vinili casuali appartenenti a quel genere che l'utente non possiede ancora. Questo approccio garantisce raccomandazioni personalizzate senza complessità algoritmica eccessiva.

**Utente non autenticato**: Come fallback, vengono mostrati i 10 vinili più collezionati dalla community (maggior numero di occorrenze in `ownership`). Questo permette di offrire contenuti rilevanti anche agli utenti non loggati, mostrando le scelte più popolari.

Il sistema è implementato nel componente `php/components/recommended_vinyls.php` e utilizza prepared statements per prevenire SQL injection. Quando verrà implementato il sistema di autenticazione, sarà sufficiente utilizzare `$_SESSION['user_id']` per attivare automaticamente le raccomandazioni personalizzate.

## Pagina Artista

La pagina artista (`artist.php`) fornisce una vista dettagliata di un singolo artista, mostrando la sua discografia completa e artisti correlati.

**Struttura**: La pagina utilizza il sistema di template standard con `artist.html` come base. Riceve l'ID dell'artista tramite parametro GET (`?id=1`) e valida che sia un intero positivo con `intval()`. Se l'ID è invalido o l'artista non esiste, redirect automatico a `index.php`.

**Componenti modulari**: La pagina è composta da 4 componenti riutilizzabili situati in `php/components/`:
- `artist_info.php`: Recupera dati base (nome, nazionalità, immagine) e generi musicali associati
- `artist_albums.php`: Lista tutti gli album dell'artista con relative edizioni
- `artist_singles.php`: Lista singoli ed EP
- `similar_artists.php`: Suggerisce artisti con generi in comune

**Fallback immagini**: Tutte le immagini (artista e copertine) implementano un controllo con `file_exists()` per verificare la presenza fisica del file. Se mancante, viene utilizzata automaticamente `assets/images/pollo.webp` come placeholder.

**Accessibilità**: La pagina implementa WCAG 2.1 Level AA con skip links verso le 4 sezioni principali (contenuto, album, singoli, artisti simili), breadcrumb con `aria-current`, landmark regions semantiche, e `role="list"` per i tag dei generi. L'attributo `lang="en"` viene utilizzato per i termini inglesi come "Album" ed "EP".

**CSS**: Gli stili specifici includono `.artist-image` (immagine circolare responsive: 10rem desktop, 8rem mobile), `.artist-genres` (container flex per i tag), e `.tag` (badge colorati per i generi con background brand-primary).
