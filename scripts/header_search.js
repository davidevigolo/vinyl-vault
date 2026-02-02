document.addEventListener('DOMContentLoaded', function() {
    const searchToggle = document.querySelector('.search-toggle');
    const searchContainer = document.querySelector('.header-search-container');
    const searchInput = document.querySelector('.header-search-input');
    const searchForm = document.querySelector('.header-search-form');
    
    if (!searchToggle || !searchContainer) {
        return;
    }

    // Rende il container focusable per accessibilità
    searchContainer.setAttribute('role', 'search');

    function openSearch() {
        searchContainer.classList.add('visible');
        searchToggle.setAttribute('aria-expanded', 'true');
        // Focus sull'input dopo l'animazione
        setTimeout(() => {
            searchInput.focus();
        }, 100);
    }

    function closeSearch() {
        searchContainer.classList.remove('visible');
        searchToggle.setAttribute('aria-expanded', 'false');
        searchToggle.focus();
    }

    searchToggle.addEventListener('click', function() {
        const isVisible = searchContainer.classList.contains('visible');
        
        if (isVisible) {
            closeSearch();
        } else {
            openSearch();
        }
    });

    // Chiudi la ricerca se si clicca fuori
    document.addEventListener('click', function(event) {
        if (!searchContainer.contains(event.target) && 
            !searchToggle.contains(event.target) && 
            searchContainer.classList.contains('visible')) {
            closeSearch();
        }
    });

    // Gestione tastiera per accessibilità
    searchContainer.addEventListener('keydown', function(event) {
        // Chiudi con Escape
        if (event.key === 'Escape') {
            event.preventDefault();
            closeSearch();
        }
    });

    // Focus trap: quando si raggiunge la fine del form, torna al primo elemento
    const submitBtn = searchForm.querySelector('button[type="submit"]');
    if (submitBtn) {
        submitBtn.addEventListener('keydown', function(event) {
            if (event.key === 'Tab' && !event.shiftKey) {
                // Se Tab senza Shift sull'ultimo elemento, torna all'input
                const isVisible = searchContainer.classList.contains('visible');
                if (isVisible) {
                    event.preventDefault();
                    searchInput.focus();
                }
            }
        });
    }

    searchInput.addEventListener('keydown', function(event) {
        if (event.key === 'Tab' && event.shiftKey) {
            // Se Shift+Tab sul primo elemento, vai all'ultimo
            const isVisible = searchContainer.classList.contains('visible');
            if (isVisible && submitBtn) {
                event.preventDefault();
                submitBtn.focus();
            }
        }
    });
});
