// Color stars based on rating value
const ratingSections = document.querySelectorAll('.rating-section');

ratingSections.forEach(section => {
    const stars = section.querySelectorAll('.star');
    const initialValue = parseInt(section.getAttribute('data-rating')) || 0;

    // Funzione per colorare le stelle
    const highlightStars = (rating) => {
        stars.forEach(s => {
            const val = parseInt(s.getAttribute('data-value'));
            s.classList.toggle('active', val <= rating);
        });
    };

    // Inizializza le stelle con il valore salvato
    highlightStars(initialValue);
});
