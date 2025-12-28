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

Facendo riferimento all'esempio precedente, elementi riutilizzati in più pagine come la lista dei vinili in tendenza, andranno gestiti in un file php a parte (p.e. `trending_vinyls.php`) che verrà incluso nel file php principale (`index.php`) e il cui output verrà assegnato alla variabile `$trending_vinyls`. In questo modo si mantiene il codice modulare e facilmente manutenibile. Esempio:
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