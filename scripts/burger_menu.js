const menuToggle = document.querySelector('.menu-toggle');
const headerRight = document.querySelector('.header-right');
const headerContainer = document.querySelector('.header-container');

// Con JS: abilita il toggle e chiude il menu di default
// Senza JS: il menu rimane aperto (is-open nell'HTML) per graceful degradation
if (headerRight && menuToggle) {
    headerRight.classList.add('js-enabled');
    headerRight.classList.remove('is-open');
    menuToggle.setAttribute('aria-expanded', 'false');

    // Aggiungi classe al container per fallback CSS senza :has()
    if (headerContainer) {
        headerContainer.classList.add('js-enabled');
    }
}

if (menuToggle && headerRight) {
    menuToggle.addEventListener('click', () => {
        const isOpen = headerRight.classList.toggle('is-open');

        menuToggle.setAttribute('aria-expanded', isOpen);

        menuToggle.innerHTML = isOpen ?
            '<span aria-hidden="true">✕</span>' :
            '<span aria-hidden="true">☰</span>';

        menuToggle.setAttribute('aria-label', isOpen ? 'Chiudi menù' : 'Apri menù');
    });
}