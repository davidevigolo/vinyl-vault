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
    
    // to save scroll and submit
    function saveScrollAndSubmit(form) {
        // For mobile forms, sync all URL parameters before submit
        if (form.classList.contains('mobile-filter-form')) {
            syncMobileFormParams(form);
        }
        sessionStorage.setItem('catalogScrollPosition', window.scrollY.toString());
        form.submit();
    }

    // Sync URL parameters to mobile forms to preserve all filters
    function syncMobileFormParams(form) {
        const urlParams = new URLSearchParams(window.location.search);
        const container = form.querySelector('.hidden-params-container');
        if (!container) return;

        // Clear existing hidden inputs
        container.innerHTML = '';

        // Get form's own parameter names to skip them
        const formInputs = form.querySelectorAll('input[name]:not([type="hidden"])');
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
        });
    }
    
    // Auto-submit on checkbox change (desktop)
    if (desktopForm) {
        const checkboxes = desktopForm.querySelectorAll('input[type="checkbox"]');
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', () => {
                saveScrollAndSubmit(desktopForm);
            });
        });
        
        // Real-time year tag update and debounced submit
        const yearMinInput = document.getElementById('year-min');
        const yearMaxInput = document.getElementById('year-max');
        const yearTag = document.querySelector('.filter-tag-static');
        let submitTimer;
        
        function updateYearTag() {
            if (yearTag && yearMinInput && yearMaxInput) {
                const minVal = yearMinInput.value || '1900';
                const maxVal = yearMaxInput.value || '2026';
                yearTag.textContent = `${minVal} - ${maxVal}`;
            }
        }
        
        function debouncedSubmit() {
            clearTimeout(submitTimer);
            submitTimer = setTimeout(() => {
                // Validate before submit
                if (yearMinInput) {
                    let val = parseInt(yearMinInput.value);
                    if (isNaN(val) || val < 1900) yearMinInput.value = 1900;
                    if (val > 2026) yearMinInput.value = 2026;
                }
                if (yearMaxInput) {
                    let val = parseInt(yearMaxInput.value);
                    if (isNaN(val) || val < 1900) yearMaxInput.value = 1900;
                    if (val > 2026) yearMaxInput.value = 2026;
                }
                updateYearTag();
                saveScrollAndSubmit(desktopForm);
            }, 300); // Wait 300ms after user stops typing in order to have a "slowish" refresh
        }
        
        if (yearMinInput) {
            yearMinInput.addEventListener('input', () => {
                updateYearTag();
                debouncedSubmit();
            });
        }
        if (yearMaxInput) {
            yearMaxInput.addEventListener('input', () => {
                updateYearTag();
                debouncedSubmit();
            });
        }
        
        // Auto-submit on year input blur (desktop)
        const yearInputs = desktopForm.querySelectorAll('input[type="number"]');
        yearInputs.forEach(input => {
            input.addEventListener('blur', () => {
                // Validate range
                let value = parseInt(input.value);
                if (isNaN(value) || value < 1900) value = 1900;
                if (value > 2026) value = 2026;
                input.value = value;
                
                updateYearTag(); // Update tag after validation
                saveScrollAndSubmit(desktopForm);
            });
            
            // Submit on Enter key
            input.addEventListener('keypress', (e) => {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    input.blur();
                }
            });
        });
    }
    
    // Auto-submit for mobile filters
    mobileForms.forEach(form => {
        const checkboxes = form.querySelectorAll('input[type="checkbox"]');
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', () => {
                saveScrollAndSubmit(form);
            });
        });

        const yearInputs = form.querySelectorAll('input[type="number"]');
        let mobileYearTimer;

        yearInputs.forEach(input => {
            // Debounced submit on input for better UX
            input.addEventListener('input', () => {
                clearTimeout(mobileYearTimer);
                mobileYearTimer = setTimeout(() => {
                    // Validate before submit
                    let value = parseInt(input.value);
                    if (isNaN(value) || value < 1900) input.value = 1900;
                    if (value > 2026) input.value = 2026;
                    saveScrollAndSubmit(form);
                }, 800); // Longer delay for mobile to avoid too many submits
            });

            input.addEventListener('blur', () => {
                clearTimeout(mobileYearTimer);
                let value = parseInt(input.value);
                if (isNaN(value) || value < 1900) value = 1900;
                if (value > 2026) value = 2026;
                input.value = value;

                saveScrollAndSubmit(form);
            });

            input.addEventListener('keypress', (e) => {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    clearTimeout(mobileYearTimer);
                    input.blur();
                }
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
                // Move focus to first input in panel for better keyboard navigation
                const firstInput = filterPanel.querySelector('input');
                if (firstInput) {
                    setTimeout(() => firstInput.focus(), 100);
                }
            }
        });
        
        // Add keyboard support (Enter and Space) TDB
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
            window.location.href = url.toString();
        });
    }
});
