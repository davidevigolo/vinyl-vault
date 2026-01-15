# Note sull'Accessibilità

Questo documento raccoglie le tecniche e le best practices implementate per garantire la conformità WCAG

## Classe `.sr-only` (Screen Reader Only)

Utility CSS globale per nascondere visualmente elementi mantenendoli accessibili agli screen reader. Conforme WCAG 2.1 Level AA.

**Quando usarla:**
- Heading nascosti per struttura semantica (es: `<h1 class="sr-only">Esplora</h1>`)
- Label nascoste per form quando il placeholder visivo non basta
- Skip links per navigazione rapida
- Testo descrittivo aggiuntivo per link/bottoni ambigui

**Implementazione in `style.css`:**
```css
.sr-only {
    position: absolute;
    width: 1px;
    height: 1px;
    padding: 0;
    margin: -1px;
    overflow: hidden;
    clip: rect(0, 0, 0, 0);
    white-space: nowrap;
    border-width: 0;
}
```

## Attributi ARIA

### `aria-label`
Fornisce un'etichetta accessibile quando il testo visibile non è sufficiente o è ambiguo.

**Esempi implementati:**
```html
<!-- Link "Guarda tutti" con contesto -->
<a href="catalogo.php?filter=recommended" aria-label="Guarda tutti i vinili raccomandati">Guarda tutti</a>

<!-- Link su card con contesto completo -->
<a href="artist.php?id=[artist_id]" aria-label="Vai alla pagina di [artist_name]">
```

### `aria-labelledby`
Collega una sezione al suo heading per una migliore navigazione con screen reader.

```html
<section id="album-week" class="hero-banner" aria-labelledby="album-week-title">
    <h2 id="album-week-title">Scopri il tuo prossimo disco</h2>
</section>
```

### `aria-hidden="true"`
Nasconde elementi puramente decorativi dagli screen reader.

```html
<!-- Immagini decorative -->
<img src="assets/images/collection-icon.jpg" alt="" aria-hidden="true">

<!-- Testo decorativo nel banner -->
<span lang="eng" aria-hidden="true"></span>
```

## Immagini e Alt Text

### Immagini significative
Sempre con alt text descrittivo:
```html
<img src="[cover_image]" alt="[title] by [artist]">
<img src="[image_path]" alt="Foto di [artist_name]">
```

### Immagini decorative
Alt vuoto + `aria-hidden`:
```html
<img src="assets/images/logo-full-light.jpg" alt="" aria-hidden="true">
```

## Unità Relative per Scalabilità

### Dimensioni in `rem`
Tutte le dimensioni critiche usano `rem` invece di pixel fissi per rispettare le preferenze di zoom dell'utente (WCAG 1.4.4)

```css
/* Card images - scalano con lo zoom */
.card img {
    width: 10rem;
    height: 10rem;
}

/* Typography */
font-size: 1rem;
padding: 0.75rem 1.5rem;
gap: 2rem;
```

## Struttura Semantica HTML5

### Landmark Regions
```html
<header>   <!-- Banner landmark -->
<nav>      <!-- Navigation landmark -->
<main>     <!-- Main landmark -->
<section>  <!-- Section grouping -->
<article>  <!-- Self-contained content (cards) -->
```

### Attributo `lang`
Parole in lingua diversa marcate correttamente:
```html
<span lang="eng">Home</span>
<img src="..." lang="eng" alt="...">
```

### Breadcrumb Navigation
```html
<nav id="breadcrumb" aria-label="percorso di navigazione">
    <p><span lang="eng">Home</span> &gt; Esplora</p>
</nav>
```

## Layout Responsivo Accessibile

### Grid Responsive senza Scroll Orizzontale
Il sistema grid si adatta automaticamente prevenendo problemi di zoom orizzontale (WCAG 1.4.10)

```css
/* Base: auto-fit con minimo 200px */
.trending-vinyls-container,
.vinyls-container,
.artists-container,
.most-liked-artists-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 2rem;
}

/* Mobile: 2 colonne */
@media (max-width: 768px) {
    grid-template-columns: repeat(2, 1fr);
}

/* Desktop: 4 colonne */
@media (min-width: 769px) {
    grid-template-columns: repeat(4, 1fr);
}
```

### Card Accessibili
```css
.card {
    width: 100%;           /* Responsive */
    max-width: 250px;      /* Controllo dimensione massima */
    margin: 0 auto;        /* Centratura */
}
```

## Link Descrittivi nelle Card

Ogni card ha link espliciti invece di wrapper generici:
```html
<article class="vinyl-card card">
    <img src="[cover_image]" alt="[title] by [artist]">
    <a href="artist.php?id=[artist_id]">[artist]</a>
    <h3><a href="vinyl.php?id=[disk_id]&edition=[ed_name]">[title]</a></h3>
</article>
```

**Vantaggi:**
- Screen reader può navigare tra link specifici
- Utente tastiera può tabbarre tra elementi distinti
- Contesto chiaro per ogni link

## Button Styling Accessibile

### `.btn-primary`
```css
.btn-primary {
    padding: 0.75rem 1.5rem;      /* Area touch minima 44x44px */
    white-space: nowrap;          /* Previene wrap su zoom */
    border-radius: 2em;
    transition: background 0.3s;
}

.btn-primary:hover {
    background: var(--brand-primary-dark);
    opacity: 1;                   /* Override hover generico */
}
```

## Gestione Immagini Mancanti

Placeholder accessibile quando le immagini non sono disponibili:
```php
// TBD: Usare image_path quando le immagini saranno caricate
'cover_image' => 'assets/images/pollo.webp',
```
## Tabella wishlist

La tabella wishlist presenta una colonna dedicata alle copertine dei dischi, la colonna e ogni elemento di copertina sono nascosti agli screen reader in quanto puramente decorativi, tramite aria-hidden="true". Si sarebbe ottenuto altrimenti una ripetizione continua di informazioni non necessarie per l'utente con disabilità visive.

## Note di Sviluppo Futuro

### Da implementare quando necessario:
- **Focus styles visibili**: Outline colorato per navigazione tastiera
- **Skip links**: "Salta al contenuto" per utenti tastiera
- **Form labels**: Sempre associare label esplicite agli input
- **Error messages**: Associare errori ai campi con aria-describedby
- **Loading states**: aria-live per aggiornamenti dinamici

