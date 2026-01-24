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

        // Inizializza SEMPRE le stelle con il valore salvato nel DB
        const initialValue = parseInt(ratingInput.value) || 0;
        highlightStars(initialValue);

        // Se è readonly, ci fermiamo qui: non aggiungiamo eventi click o reset
        if (isReadonly) return;

        // --- Logica per la modalità EDIT (senza classe readonly) ---
        const resetButton = container.querySelector('.btn-reset-stars');

        stars.forEach(star => {
            star.addEventListener('click', function() {
                const value = parseInt(this.getAttribute('data-value'));
                ratingInput.value = value;
                highlightStars(value);
            });
        });

        if (resetButton) {
            resetButton.addEventListener('click', function(e) {
                e.preventDefault();
                ratingInput.value = 0;
                highlightStars(0);
            });
        }
    });
});