// Load More functionality for catalog page

// Abilita JS: nasconde gli items hidden e mostra il bottone Load More
document.documentElement.classList.add('js-enabled');

const loadMoreBtn = document.getElementById('load-more-btn');
const catalogGrid = document.getElementById('catalog-grid');
const _sortSelect = document.getElementById('sort-select');

const itemsPerLoad = 6;

function updateVisibleCount() {
    const hiddenItems = catalogGrid.querySelectorAll('.catalog-item-hidden');
    const visibleCount = catalogGrid.querySelectorAll('.catalog-item:not(.catalog-item-hidden)').length;
    const totalCount = catalogGrid.querySelectorAll('.catalog-item').length;

    // Update results count
    const resultsCount = document.querySelector('.results-count');
    if (resultsCount) {
        resultsCount.textContent = `${visibleCount} di ${totalCount} risultati`;
    }

    // Hide button if no more items
    if (hiddenItems.length === 0) {
        loadMoreBtn.style.display = 'none';
        loadMoreBtn.setAttribute('aria-hidden', 'true');
    } else {
        loadMoreBtn.style.display = '';
        loadMoreBtn.setAttribute('aria-hidden', 'false');
    }
}

loadMoreBtn.addEventListener('click', () => {
    const hiddenItems = catalogGrid.querySelectorAll('.catalog-item-hidden');

    // Show next batch
    const itemsToShow = Array.from(hiddenItems).slice(0, itemsPerLoad);
    itemsToShow.forEach(item => {
        item.classList.remove('catalog-item-hidden');
    });

    updateVisibleCount();
});

// Initial count update
updateVisibleCount();

// dropdown change handler
if (_sortSelect) {
    _sortSelect.addEventListener('change', (e) => {
        const url = new URL(window.location.href);
        url.searchParams.set('sort', e.target.value);
        window.location.href = url.toString();
    });
}
