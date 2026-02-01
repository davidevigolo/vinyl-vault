const starContainers = document.querySelectorAll('.stars-container');

starContainers.forEach(container => {
    const isReadonly = container.classList.contains('readonly');

    if (isReadonly) {
        // --- Modalità READONLY (collection_item.html) ---
        // Usa <span class="star"> e data-rating su .rating-section
        const stars = container.querySelectorAll('.star');
        const ratingSection = container.closest('.rating-section');
        const initialValue = parseInt(ratingSection?.getAttribute('data-rating')) || 0;

        // Funzione per colorare le stelle
        const highlightStars = (rating) => {
            stars.forEach(s => {
                const val = parseInt(s.getAttribute('data-value'));
                s.classList.toggle('active', val <= rating);
            });
        };

        // Inizializza le stelle con il valore salvato nel DB
        highlightStars(initialValue);
    } else {
        // --- Modalità EDIT (collection_item_edit.html) ---
        // Usa radio inputs - pre-seleziona il radio button e aggiorna il campo nascosto
        const radioInputs = container.querySelectorAll('input[type="radio"]');
        const initialValue = parseInt(container.getAttribute('data-rating')) || 0;
        const collectionItem = container.closest('.collection-item');
        
        // Trova il campo nascosto per questo specifico item
        const hiddenInput = collectionItem?.querySelector('.rating-hidden-input');

        // Seleziona il radio button corrispondente al valore iniziale
        if (initialValue > 0) {
            radioInputs.forEach(radio => {
                if (parseInt(radio.value) === initialValue) {
                    radio.checked = true;
                }
            });
        }

        // Aggiungi listener per aggiornare il campo nascosto quando cambia la selezione
        radioInputs.forEach(radio => {
            radio.addEventListener('change', function() {
                if (this.checked && hiddenInput) {
                    hiddenInput.value = this.value;
                }
            });
        });
    }
});