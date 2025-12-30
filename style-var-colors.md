# Colori CSS

I colori sono definiti tramite variabili CSS semantiche che indicano il loro ruolo nell'interfaccia, non il valore cromatico. Qesto permette di gestire facilmente temi diversi senza riscrivere il codice

## Colori Principali del Brand

### `--brand-primary` 
Colore principale di Vinyl Vault. Utilizzato per bottoni e azioni primarie

### `--brand-primary-dark`
Variante scura del colore principale, utilizzata per hover e stati di focus sui bottoni

## Link

### `--link-unvisited`
Colore per i link non ancora visitati

### `--link-visited`
Colore per i link già visitati. Permette agli utenti di tracciare la navigazione e migliora l'esperienza utente
 
## Sfondi

### `--bg-page`
Sfondo principale della pagina, il livello base dell'interfaccia

### `--bg-section`
Sfondo delle sezioni (blocchi tematici), serve per distinguere le diverse aree funzionali

### `--bg-surface`
Superfici elevate come card

## Testo

### `--text-primary`
Testo principale ad alta leggibilità, usato per titoli e contenuti importanti

### `--text-secondary`
Testo di supporto per descrizioni e informazioni secondarie

### `--text-muted`
Testo a bassa priorità visiva per placeholder e label non attive

## Bordi e Separatori

### `--border-default`
Colore standard per bordi e separatori

## Nota sulla Tematizzazione

I colori cambiano automaticamente in base al tema (chiaro/scuro) attraverso l'attributo `data-theme` su `:root`. Questo approccio permette di cambiare tema dinamicamente gestendo tutte le variabili in un unico punto.

## Nota su Accessibilità

Il colore `--text-muted` richiede particolare attenzione nella verifica del contrasto in base a dove è posizionato!
