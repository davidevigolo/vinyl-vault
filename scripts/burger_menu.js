const menuToggle = document.querySelector('.menu-toggle');
const headerRight = document.querySelector('.header-right');

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