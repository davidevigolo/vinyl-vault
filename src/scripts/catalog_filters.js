// disable auto-scroll on load
if ('scrollRestoration' in history) {
    history.scrollRestoration = 'manual';
}

// restore scroll position
const savedScroll = sessionStorage.getItem('catalogScrollPosition');
if (savedScroll) {
    requestAnimationFrame(() => {
        window.scrollTo({
            top: parseInt(savedScroll),
            behavior: 'instant'
        });
    });
    sessionStorage.removeItem('catalogScrollPosition');
}

// restore focus after submit
const focusElementId = sessionStorage.getItem('focusElementId');
if (focusElementId) {
    sessionStorage.removeItem('focusElementId');
    requestAnimationFrame(() => {
        const element = document.getElementById(focusElementId);
        if (element) {
            element.focus();
            element.setAttribute('data-focus-visible', 'true');
            setTimeout(() => {
                element.removeAttribute('data-focus-visible');
            }, 2000);
        }
    });
}

// show year hint if corrected
if (sessionStorage.getItem('showYearHint')) {
    sessionStorage.removeItem('showYearHint');
    requestAnimationFrame(() => {
        const yearContainer = document.querySelector('.year-range-container');
        if (yearContainer) {
            let hint = document.getElementById('year-hint');
            if (!hint) {
                hint = document.createElement('div');
                hint.id = 'year-hint';
                hint.className = 'year-hint';
                hint.setAttribute('role', 'status');
                hint.setAttribute('aria-live', 'polite');
                yearContainer.appendChild(hint);
            }
            hint.textContent = 'Oops! Gli anni validi vanno dal 1900 al 2026';
            hint.classList.add('visible');
            setTimeout(() => {
                hint.classList.remove('visible');
            }, 5000);
        }
    });
}


const desktopForm = document.getElementById('filters-form');
const mobileForms = document.querySelectorAll('.mobile-filter-form');

// save scroll and submit
function saveScrollAndSubmit(form) {
    if (form.classList.contains('mobile-filter-form')) {
        syncMobileFormParams(form);
    }
    sessionStorage.setItem('catalogScrollPosition', window.scrollY.toString());
    document.body.classList.add('page-transitioning');
    setTimeout(() => {
        form.submit();
    }, 150);
}

// sync url params to mobile forms
function syncMobileFormParams(form) {
    const urlParams = new URLSearchParams(window.location.search);
    const container = form.querySelector('.hidden-params-container');
    if (!container) return;

    container.innerHTML = '';

    const formInputs = form.querySelectorAll('input[name]:not([type="hidden"]), select[name]');
    const formParamNames = new Set();
    formInputs.forEach(input => {
        const name = input.name;
        if (name) {
            const baseName = name.replace('[]', '');
            formParamNames.add(baseName);
        }
    });

    for (const [key, value] of urlParams.entries()) {
        const baseKey = key.replace('[]', '');
        if (!formParamNames.has(baseKey) && !formParamNames.has(key)) {
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = key;
            hiddenInput.value = value;
            container.appendChild(hiddenInput);
        }
    }

    // add sort if needed
    if (!urlParams.has('sort')) {
        const sortSelect = document.getElementById('sort-select');
        if (sortSelect && sortSelect.value && sortSelect.value !== 'collected') {
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'sort';
            hiddenInput.value = sortSelect.value;
            container.appendChild(hiddenInput);
        }
    }
}

// reset button
const resetButton = document.querySelector('.btn-reset-all');
if (resetButton) {
    resetButton.addEventListener('click', (e) => {
        sessionStorage.setItem('catalogScrollPosition', window.scrollY.toString());
        document.body.classList.add('page-transitioning');
    });
}

// remove filter buttons
const removeFilterButtons = document.querySelectorAll('.remove-filter-btn');
removeFilterButtons.forEach(button => {
    button.addEventListener('click', (e) => {
        e.preventDefault();
        sessionStorage.setItem('catalogScrollPosition', window.scrollY.toString());
        document.body.classList.add('page-transitioning');
        setTimeout(() => {
            window.location.href = button.dataset.href;
        }, 150);
    });
});

// year filter validation
if (desktopForm) {
    const yearMinInput = document.getElementById('year-min');
    const yearMaxInput = document.getElementById('year-max');
    const yearTag = document.querySelector('.filter-tag-static');

    function updateYearTag() {
        if (yearTag && yearMinInput && yearMaxInput) {
            const minVal = yearMinInput.value || '1900';
            const maxVal = yearMaxInput.value || '2026';
            yearTag.textContent = `${minVal} - ${maxVal}`;
        }
    }

    function validateYearInput(input) {
        let value = parseInt(input.value);

        if (isNaN(value) || value < 1900) {
            value = 1900;
        }
        if (value > 2026) {
            value = 2026;
        }

        input.value = value;
    }

    if (yearMinInput) {
        yearMinInput.addEventListener('input', updateYearTag);
        yearMinInput.addEventListener('blur', () => {
            validateYearInput(yearMinInput);
            updateYearTag();
        });
    }

    if (yearMaxInput) {
        yearMaxInput.addEventListener('input', updateYearTag);
        yearMaxInput.addEventListener('blur', () => {
            validateYearInput(yearMaxInput);
            updateYearTag();
        });
    }
}

// mobile filters
mobileForms.forEach(form => {
    const originalAction = form.getAttribute('action');
    form.removeAttribute('action');

    const applyButton = form.querySelector('.btn-apply-mobile-filter');

    if (applyButton) {
        applyButton.addEventListener('click', (e) => {
            e.preventDefault();
            form.setAttribute('action', originalAction);
            saveScrollAndSubmit(form);
        });
    }

    form.addEventListener('submit', (e) => {
        e.preventDefault();
        return false;
    });

    const checkboxes = form.querySelectorAll('input[type="checkbox"]');
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('click', (e) => {
            e.stopPropagation();
        });
        checkbox.addEventListener('change', (e) => {
            e.stopPropagation();
        });
    });

    const labels = form.querySelectorAll('label');
    labels.forEach(label => {
        label.addEventListener('click', (e) => {
            e.stopPropagation();
        });
    });
});

// mobile filter toggles
const filterToggles = document.querySelectorAll('[data-filter]');

filterToggles.forEach(toggle => {
    toggle.addEventListener('click', () => {
        const filterId = toggle.getAttribute('aria-controls');
        const filterPanel = document.getElementById(filterId);

        if (!filterPanel) return;

        const isExpanded = toggle.getAttribute('aria-expanded') === 'true';

        // close other panels
        filterToggles.forEach(otherToggle => {
            if (otherToggle !== toggle) {
                otherToggle.setAttribute('aria-expanded', 'false');
                const otherId = otherToggle.getAttribute('aria-controls');
                const otherPanel = document.getElementById(otherId);
                if (otherPanel) {
                    otherPanel.setAttribute('hidden', '');
                }
            }
        });

        // toggle panel
        toggle.setAttribute('aria-expanded', !isExpanded);
        if (isExpanded) {
            filterPanel.setAttribute('hidden', '');
        } else {
            filterPanel.removeAttribute('hidden');
        }
    });

    // keyboard support
    toggle.addEventListener('keydown', (e) => {
        if (e.key === 'Enter' || e.key === ' ') {
            e.preventDefault();
            toggle.click();
        }
    });
});

// sort dropdown
const sortSelect = document.getElementById('sort-select');
if (sortSelect) {
    sortSelect.addEventListener('change', (e) => {
        const url = new URL(window.location.href);
        url.searchParams.set('sort', e.target.value);
        sessionStorage.setItem('catalogScrollPosition', window.scrollY.toString());
        sessionStorage.setItem('focusElementId', 'sort-select');
        document.body.classList.add('page-transitioning');
        setTimeout(() => {
            window.location.href = url.toString();
        }, 150);
    });
}

// search
const searchInput = document.getElementById('catalog-search');
const clearSearchBtn = document.getElementById('clear-search-btn');

if (searchInput) {
    function updateClearButtonVisibility() {
        if (clearSearchBtn) {
            if (searchInput.value.trim() !== '') {
                clearSearchBtn.removeAttribute('hidden');
            } else {
                clearSearchBtn.setAttribute('hidden', '');
            }
        }
    }

    updateClearButtonVisibility();
    searchInput.addEventListener('input', updateClearButtonVisibility);

    // clear search btn
    if (clearSearchBtn) {
        clearSearchBtn.addEventListener('click', (e) => {
            e.preventDefault();
            searchInput.value = '';
            updateClearButtonVisibility();

            const url = new URL(window.location.href);
            url.searchParams.delete('q');
            sessionStorage.setItem('catalogScrollPosition', window.scrollY.toString());
            sessionStorage.setItem('focusElementId', 'catalog-search');
            document.body.classList.add('page-transitioning');
            setTimeout(() => {
                window.location.href = url.toString();
            }, 150);
        });
    }
}
