const themeToggle = document.querySelector('.theme-toggle');
const htmlElement = document.documentElement;

const applyTheme = (theme) => {
    htmlElement.setAttribute('data-theme', theme);

    const themeIcon = themeToggle?.querySelector('.theme-icon');
    if (themeIcon) {
        // switch icon
        themeIcon.src = theme === 'light' ? 'assets/images/moon.png' : 'assets/images/sun.png';
        themeIcon.alt = theme === 'light' ? 'Attiva tema scuro' : 'Attiva tema chiaro';
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