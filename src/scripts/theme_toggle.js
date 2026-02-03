const themeToggle = document.querySelector('.theme-toggle');
const htmlElement = document.documentElement;
const searchToggle = document.querySelector('.search-toggle');

const applyTheme = (theme) => {
    htmlElement.setAttribute('data-theme', theme);

    const themeIcon = themeToggle?.querySelector('.theme-icon');
    if (themeIcon) {
        // switch icon
        themeIcon.src = theme === 'light' ? 'assets/images/moon.webp' : 'assets/images/sun.webp';
        themeIcon.alt = theme === 'light' ? 'Attiva tema scuro' : 'Attiva tema chiaro';
    }

    if (searchToggle) {
        const searchIcon = searchToggle?.querySelector('.search-icon');
        if (themeIcon) {
            searchIcon.src = theme === 'light' ? 'assets/images/search-light.webp' : 'assets/images/search-dark.webp';
        }
    }

    const searchIconCatalog = document.getElementById('catalog-search-icon');
    if (searchIconCatalog) {
        searchIconCatalog.src = theme === 'light' ? 'assets/images/search-dark.webp' : 'assets/images/search-light.webp';
    }

    // save changes
    localStorage.setItem('selected-theme', theme);
};

const savedTheme = localStorage.getItem('selected-theme') || 'light';
applyTheme(savedTheme);

if (themeToggle) {
    themeToggle.addEventListener('click', () => {
        const currentTheme = htmlElement.getAttribute('data-theme');
        const newTheme = currentTheme === 'light' ? 'dark' : 'light';
        applyTheme(newTheme);
    });
}