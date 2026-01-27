document.addEventListener('DOMContentLoaded', function() {
    const starContainers = document.querySelectorAll('.stars-container');

    starContainers.forEach(container => {
        const stars = container.querySelectorAll('.star');
        const ratingInput = container.closest('.collection-rating-section').querySelector('.rating-input');
        const isReadonly = container.classList.contains('readonly');

        // Funzione per colorare le stelle
        const highlightStars = (rating) => {
            stars.forEach(s => {
                const val = parseInt(s.getAttribute('data-value'));
                s.classList.toggle('active', val <= rating);
            });
        };

        // Aggiorna gli attributi ARIA
        const updateAriaStates = (rating) => {
            stars.forEach(s => {
                const val = parseInt(s.getAttribute('data-value'));
                if (!isReadonly) {
                    s.setAttribute('aria-pressed', val <= rating ? 'true' : 'false');
                }
            });
        };

        // Inizializza SEMPRE le stelle con il valore salvato nel DB
        const initialValue = parseInt(ratingInput.value) || 0;
        highlightStars(initialValue);
        updateAriaStates(initialValue);

        // Se è readonly, ci fermiamo qui: non aggiungiamo eventi click o reset
        if (isReadonly) return;

        // --- Logica per la modalità EDIT (senza classe readonly) ---
        const resetButton = container.querySelector('.btn-reset-stars');

        stars.forEach((star, index) => {
            star.addEventListener('click', function() {
                const value = parseInt(this.getAttribute('data-value'));
                ratingInput.value = value;
                highlightStars(value);
                updateAriaStates(value);

                // Annuncia il cambio agli screen reader
                this.setAttribute('aria-label', `${value} ${value === 1 ? 'stella' : 'stelle'} selezionata`);
            });

            // Supporto tastiera con frecce direzionali
            star.addEventListener('keydown', function(e) {
                let newIndex = index;

                if (e.key === 'ArrowRight' || e.key === 'ArrowUp') {
                    e.preventDefault();
                    newIndex = Math.min(index + 1, stars.length - 1);
                    stars[newIndex].focus();
                } else if (e.key === 'ArrowLeft' || e.key === 'ArrowDown') {
                    e.preventDefault();
                    newIndex = Math.max(index - 1, 0);
                    stars[newIndex].focus();
                } else if (e.key === 'Home') {
                    e.preventDefault();
                    stars[0].focus();
                } else if (e.key === 'End') {
                    e.preventDefault();
                    stars[stars.length - 1].focus();
                }
            });
        });

        if (resetButton) {
            resetButton.addEventListener('click', function(e) {
                e.preventDefault();
                ratingInput.value = 0;
                highlightStars(0);
                updateAriaStates(0);

                // Ripristina le label originali
                stars.forEach(s => {
                    const val = parseInt(s.getAttribute('data-value'));
                    s.setAttribute('aria-label', `${val} ${val === 1 ? 'stella' : 'stelle'}`);
                });
            });
        }
    });
});