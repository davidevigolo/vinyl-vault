// prevent browser from auto-scrolling on page load
if ('scrollRestoration' in history) {
    history.scrollRestoration = 'manual';
}

document.addEventListener('DOMContentLoaded', () => {
    
    // restore scroll position
    const savedScroll = sessionStorage.getItem('catalogScrollPosition');
    if (savedScroll) {
        // requestAnimationFrame to ensure DOM is ready
        requestAnimationFrame(() => {
            window.scrollTo({
                top: parseInt(savedScroll),
                behavior: 'instant' // Instant to avoid double animation
            });
        });
        sessionStorage.removeItem('catalogScrollPosition');
    }

    // Restore focus after filter submit
    const focusElementId = sessionStorage.getItem('focusElementId');
    if (focusElementId) {
        sessionStorage.removeItem('focusElementId');
        requestAnimationFrame(() => {
            const element = document.getElementById(focusElementId);
            if (element) {
                element.focus();
            }
        });
    }


    const desktopForm = document.getElementById('filters-form');
    const mobileForms = document.querySelectorAll('.mobile-filter-form');
    
    // Create screen reader announcement area if not exists
    let srAnnouncement = document.getElementById('sr-announcements');
    if (!srAnnouncement) {
        srAnnouncement = document.createElement('div');
        srAnnouncement.id = 'sr-announcements';
        srAnnouncement.setAttribute('role', 'status');
        srAnnouncement.setAttribute('aria-live', 'polite');
        srAnnouncement.setAttribute('aria-atomic', 'true');
        srAnnouncement.className = 'sr-only';
        document.body.appendChild(srAnnouncement);
    }
    
    // to announce filter change
    function announceFilterChange(message) {
        const srAnnouncement = document.getElementById('sr-announcements');
        if (srAnnouncement) {
            srAnnouncement.textContent = message;
        }
    }
    
    // to save scroll and submit with smooth transition
    function saveScrollAndSubmit(form) {
        // For mobile forms, sync all URL parameters before submit
        if (form.classList.contains('mobile-filter-form')) {
            syncMobileFormParams(form);
        }
        sessionStorage.setItem('catalogScrollPosition', window.scrollY.toString());

        // Add fade-out effect before submit
        document.body.classList.add('page-transitioning');
        setTimeout(() => {
            form.submit();
        }, 150);
    }

    // Sync URL parameters to mobile forms to preserve all filters
    function syncMobileFormParams(form) {
        const urlParams = new URLSearchParams(window.location.search);
        const container = form.querySelector('.hidden-params-container');
        if (!container) return;

        // Clear existing hidden inputs
        container.innerHTML = '';

        // Get form's own parameter names to skip them
        const formInputs = form.querySelectorAll('input[name]:not([type="hidden"]), select[name]');
        const formParamNames = new Set();
        formInputs.forEach(input => {
            const name = input.name;
            if (name) {
                // Handle array names like genre[]
                const baseName = name.replace('[]', '');
                formParamNames.add(baseName);
            }
        });

        // Add all URL params that are NOT in this form
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

        // Always add sort parameter if not present in URL but selected
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
    
    // Save scroll position when clicking reset button
    const resetButton = document.querySelector('.btn-reset-all');
    if (resetButton) {
        resetButton.addEventListener('click', (e) => {
            sessionStorage.setItem('catalogScrollPosition', window.scrollY.toString());
            document.body.classList.add('page-transitioning');
        });
    }
    
    // Save scroll position when clicking a remove filter button
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
    
    // Auto-submit on checkbox change (desktop)
    if (desktopForm) {
        const checkboxes = desktopForm.querySelectorAll('input[type="checkbox"]');
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', () => {
                sessionStorage.setItem('focusElementId', checkbox.id);
                saveScrollAndSubmit(desktopForm);
            });
        });
        
        // Year filter handling
        const yearMinInput = document.getElementById('year-min');
        const yearMaxInput = document.getElementById('year-max');
        const yearTag = document.querySelector('.filter-tag-static');
        let yearSubmitTimer;

        function updateYearTag() {
            if (yearTag && yearMinInput && yearMaxInput) {
                const minVal = yearMinInput.value || '1900';
                const maxVal = yearMaxInput.value || '2026';
                yearTag.textContent = `${minVal} - ${maxVal}`;
            }
        }

        function validateYearInput(input) {
            let value = parseInt(input.value);
            if (isNaN(value) || value < 1900) value = 1900;
            if (value > 2026) value = 2026;
            input.value = value;
        }

        function debouncedYearSubmit(inputId) {
            clearTimeout(yearSubmitTimer);
            yearSubmitTimer = setTimeout(() => {
                if (yearMinInput) validateYearInput(yearMinInput);
                if (yearMaxInput) validateYearInput(yearMaxInput);
                updateYearTag();
                sessionStorage.setItem('focusElementId', inputId);
                saveScrollAndSubmit(desktopForm);
            }, 500);
        }

        if (yearMinInput) {
            yearMinInput.addEventListener('input', () => {
                updateYearTag();
                debouncedYearSubmit('year-min');
            });

            yearMinInput.addEventListener('blur', () => {
                validateYearInput(yearMinInput);
                updateYearTag();
            });

            yearMinInput.addEventListener('keypress', (e) => {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    clearTimeout(yearSubmitTimer);
                    validateYearInput(yearMinInput);
                    updateYearTag();
                    sessionStorage.setItem('focusElementId', 'year-min');
                    saveScrollAndSubmit(desktopForm);
                }
            });
        }

        if (yearMaxInput) {
            yearMaxInput.addEventListener('input', () => {
                updateYearTag();
                debouncedYearSubmit('year-max');
            });

            yearMaxInput.addEventListener('blur', () => {
                validateYearInput(yearMaxInput);
                updateYearTag();
            });

            yearMaxInput.addEventListener('keypress', (e) => {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    clearTimeout(yearSubmitTimer);
                    validateYearInput(yearMaxInput);
                    updateYearTag();
                    sessionStorage.setItem('focusElementId', 'year-max');
                    saveScrollAndSubmit(desktopForm);
                }
            });
        }
    }
    
    // Manual submit for mobile filters (with apply button)
    mobileForms.forEach(form => {
        // Store original action and remove it temporarily to prevent accidental submits
        const originalAction = form.getAttribute('action');
        form.removeAttribute('action');

        // Find the apply button
        const applyButton = form.querySelector('.btn-apply-mobile-filter');

        // Handle ONLY button click for submission
        if (applyButton) {
            applyButton.addEventListener('click', (e) => {
                e.preventDefault();

                // Restore action temporarily for submit
                form.setAttribute('action', originalAction);

                // Sync params and submit
                saveScrollAndSubmit(form);
            });
        }

        // ALWAYS prevent form submission (can only submit via button click above)
        form.addEventListener('submit', (e) => {
            e.preventDefault();
            return false;
        });

        // Prevent checkboxes from triggering any form submission
        const checkboxes = form.querySelectorAll('input[type="checkbox"]');
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('click', (e) => {
                e.stopPropagation();
            });

            checkbox.addEventListener('change', (e) => {
                e.stopPropagation();
            });
        });

        // Prevent labels from triggering form submission
        const labels = form.querySelectorAll('label');
        labels.forEach(label => {
            label.addEventListener('click', (e) => {
                e.stopPropagation();
            });
        });
    });
    
    // Mobile filter toggles
    const filterToggles = document.querySelectorAll('[data-filter]');

    filterToggles.forEach(toggle => {
        toggle.addEventListener('click', () => {
            const filterId = toggle.getAttribute('aria-controls');
            const filterPanel = document.getElementById(filterId);

            if (!filterPanel) return;

            const isExpanded = toggle.getAttribute('aria-expanded') === 'true';

            // Close all other panels
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

            // Toggle current panel
            toggle.setAttribute('aria-expanded', !isExpanded);
            if (isExpanded) {
                filterPanel.setAttribute('hidden', '');
            } else {
                filterPanel.removeAttribute('hidden');
            }
        });

        // Add keyboard support (Enter and Space)
        toggle.addEventListener('keydown', (e) => {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                toggle.click();
            }
        });
    });
    
    // Sort dropdown handler
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

    // Debounced search functionality
    const searchForm = document.getElementById('search-form');
    const searchInput = document.getElementById('catalog-search');
    const clearSearchBtn = document.getElementById('clear-search-btn');
    let searchTimer;

    if (searchInput && searchForm) {
        // Update clear button visibility
        function updateClearButtonVisibility() {
            if (clearSearchBtn) {
                if (searchInput.value.trim() !== '') {
                    clearSearchBtn.removeAttribute('hidden');
                } else {
                    clearSearchBtn.setAttribute('hidden', '');
                }
            }
        }

        // Initialize visibility
        updateClearButtonVisibility();

        // Debounced search on input
        searchInput.addEventListener('input', () => {
            updateClearButtonVisibility();

            clearTimeout(searchTimer);
            searchTimer = setTimeout(() => {
                const query = searchInput.value.trim();
                // Only auto-search if there's text or if clearing a previous search
                const currentQuery = new URLSearchParams(window.location.search).get('q');
                if (query !== '' || currentQuery) {
                    announceFilterChange('Ricerca in corso...');
                    sessionStorage.setItem('catalogScrollPosition', window.scrollY.toString());
                    sessionStorage.setItem('focusElementId', 'catalog-search');
                    document.body.classList.add('page-transitioning');
                    setTimeout(() => {
                        searchForm.submit();
                    }, 150);
                }
            }, 1000); // 1 second debounce
        });

        // Clear search button
        if (clearSearchBtn) {
            clearSearchBtn.addEventListener('click', (e) => {
                e.preventDefault();
                searchInput.value = '';
                updateClearButtonVisibility();

                // Remove q parameter and reload
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

        // Still allow Enter to search immediately
        searchInput.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                clearTimeout(searchTimer);
                // Let the form submit naturally
            }
        });
    }
});
