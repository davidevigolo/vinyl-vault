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

function openMenu() {
    headerRight.classList.add('is-open');
    menuToggle.setAttribute('aria-expanded', 'true');
    menuToggle.innerHTML = '<span aria-hidden="true">✕</span>';
    menuToggle.setAttribute('aria-label', 'Chiudi menù');
}

function closeMenu() {
    headerRight.classList.remove('is-open');
    menuToggle.setAttribute('aria-expanded', 'false');
    menuToggle.innerHTML = '<span aria-hidden="true">☰</span>';
    menuToggle.setAttribute('aria-label', 'Apri menù');
}

function isMenuToggleVisible() {
    return window.getComputedStyle(menuToggle).display !== 'none';
}

if (menuToggle && headerRight) {
    // Click toggle per utenti mouse
    menuToggle.addEventListener('click', () => {
        const isOpen = headerRight.classList.contains('is-open');
        isOpen ? closeMenu() : openMenu();
    });

    // Apre il menu quando qualsiasi elemento riceve focus (solo mobile)
    headerRight.addEventListener('focusin', () => {
        if (isMenuToggleVisible()) {
            openMenu();
        }
    });

    // Chiude il menu quando il focus esce da headerRight (solo mobile)
    headerRight.addEventListener('focusout', (e) => {
        if (isMenuToggleVisible() && !headerRight.contains(e.relatedTarget)) {
            closeMenu();
        }
    });

    // Chiude il menu con Escape
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && headerRight.classList.contains('is-open')) {
            closeMenu();
            menuToggle.focus();
        }
    });
}