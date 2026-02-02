document.querySelectorAll('.default-hidden').forEach(elem => {
    elem.classList.remove('default-hidden');
});
const headerSearchToggle = document.querySelector('.search-toggle');
const headerSearchContainer = document.querySelector('.header-search-container');
const headerSearchInput = document.querySelector('.header-search-input');
const headerSearchForm = document.querySelector('.header-search-form');

// Rende il container focusable per accessibilità
headerSearchContainer.setAttribute('role', 'search');

function openSearch() {
    headerSearchContainer.classList.add('visible');
    headerSearchToggle.setAttribute('aria-expanded', 'true');
    // Focus sull'input dopo l'animazione
    setTimeout(() => {
        headerSearchInput.focus();
    }, 100);
}

function closeSearch() {
    headerSearchContainer.classList.remove('visible');
    headerSearchToggle.setAttribute('aria-expanded', 'false');
    headerSearchToggle.focus();
}

headerSearchToggle.addEventListener('click', function () {
    const isVisible = headerSearchContainer.classList.contains('visible');

    if (isVisible) {
        closeSearch();
    } else {
        openSearch();
    }
});

headerSearchInput.addEventListener('keydown', function (event) {
    if (event.key === 'Tab' && event.shiftKey) {
        // Se Shift+Tab sul primo elemento, vai all'ultimo
        const isVisible = headerSearchContainer.classList.contains('visible');
        if (isVisible && submitBtn) {
            event.preventDefault();
            submitBtn.focus();
        }
    }
});
