this.document.getElementById('disk').value == '' ? this.document.getElementById('edition').disabled = true : null;
this.document.getElementById('disk').value == '' ? this.document.getElementById('add-track-button').disabled = true : null;
this.document.querySelectorAll('.track-fieldset').forEach((fieldset, index) => fieldset.getAttribute('data-display') === 'false' ? fieldset.style.display = 'none' : null);

this.document.getElementById('disk').addEventListener('input', function () {
    let errorMessage = document.getElementById('disk-error');
    let editionInput = document.getElementById('edition');
    let addTrackButton = document.getElementById('add-track-button');
    editionInput.value = '';
    
    validateSelect(this, errorMessage);
    editionInput.removeAttribute('disabled');
    
    // Reset and hide all track fieldsets
    document.querySelectorAll('.track-fieldset').forEach((fieldset, index) => {
        // Clear all inputs within the fieldset
        fieldset.querySelectorAll('input').forEach(input => {
            input.value = '';
        });
        
        // Clear all error messages within the fieldset
        fieldset.querySelectorAll('[id$="-error"]').forEach(errorMsg => {
            errorMsg.textContent = 'Obbligatorio';
        });
        
        // Hide all track fieldsets except the first one
        if (index > 0) {
            fieldset.style.display = 'none';
            fieldset.querySelectorAll('input').forEach(input => {
                input.disabled = true;
            });
        }
    });
    
    // Clear the max tracks error if it exists
    const maxTracksError = document.querySelector('#max-tracks-error');
    if (maxTracksError) {
        maxTracksError.textContent = '';
    }
    
    if (this.value.trim() !== '') {
        addTrackButton.removeAttribute('disabled');
    } else {
        addTrackButton.disabled = true;
    }
});

this.document.getElementById('edition').addEventListener('input', function () {
    let selectDiskEditionForm = document.getElementById('select-disk-edition-form');
    selectDiskEditionForm.submit();
});

this.document.getElementById('edition').addEventListener('input', function () {
    // Find the error message element
    let errorMessage = document.getElementById('edition-error');
    validateSelect(this, errorMessage);
});

// General validation for all track inputs using event delegation
this.document.addEventListener('input', function (event) {
    if (event.target.name === 'title[]') {
        const index = event.target.id.split('-')[1];
        const errorMessage = document.getElementById(`title-${index}-error`);
        if (errorMessage) {
            const error = validateTrackTitle(event.target);
            // Show errors only for visible (added) tracks
            const fieldset = event.target.closest('.track-fieldset');
            if (fieldset && getComputedStyle(fieldset).display !== 'none') {
                errorMessage.textContent = error;
            } else {
                errorMessage.textContent = '';
            }
        }
    } else if (event.target.name === 'duration[]') {
        const index = event.target.id.split('-')[1];
        const errorMessage = document.getElementById(`duration-${index}-error`);
        if (errorMessage) {
            const error = validateTrackDuration(event.target);
            // For index 0, always show errors. For others, only show if field has value
            if (index === '0') {
                errorMessage.textContent = error;
            } else {
                errorMessage.textContent = event.target.value.trim() === '' ? '' : error;
            }
        }
    }
});

this.document.getElementById('add-track-button').addEventListener('click', function () {
    const hiddenFieldset = Array.from(document.querySelectorAll('.track-fieldset')).find(fieldset => getComputedStyle(fieldset).display === 'none');
    
    if (!hiddenFieldset) {
        // No more tracks available - limit reached
        const errorMessage = document.querySelector('#max-tracks-error');
        if (errorMessage) {
            errorMessage.textContent = 'Hai raggiunto il numero massimo di tracce per il tipo di disco selezionato';
        }
        return;
    }
    
    // Clear any existing error message
    const errorMessage = document.querySelector('#max-tracks-error');
    if (errorMessage) {
        errorMessage.textContent = '';
    }
    
    // Show the next hidden fieldset
    hiddenFieldset.style.display = 'block';
    
    // Make inputs required and enabled when the track is shown
    hiddenFieldset.querySelectorAll('input:not([type="hidden"])').forEach(input => {
        input.required = true;
        input.disabled = false;
    });
});

// Handle remove track button clicks using event delegation
this.document.addEventListener('click', function (event) {
    if (event.target.closest('.remove-track-button')) {
        const button = event.target.closest('.remove-track-button');
        const fieldset = button.closest('.track-fieldset');
        
        if (fieldset) {
            const fieldsetId = fieldset.id;
            const index = parseInt(fieldsetId.split('-')[1]);
            
            // Don't allow removing the first track (index 0)
            if (index === 0) {
                return;
            }
            
            // Get all visible fieldsets
            const allFieldsets = Array.from(document.querySelectorAll('.track-fieldset'));
            const visibleFieldsets = allFieldsets.filter(fs => getComputedStyle(fs).display !== 'none');
            
            // Find the position of the current fieldset among visible ones
            const currentPosition = visibleFieldsets.indexOf(fieldset);
            
            // Shift content from subsequent visible fieldsets
            for (let i = currentPosition + 1; i < visibleFieldsets.length; i++) {
                const currentFs = visibleFieldsets[i - 1];
                const nextFs = visibleFieldsets[i];
                
                // Copy input values from next to current
                const currentInputs = currentFs.querySelectorAll('input');
                const nextInputs = nextFs.querySelectorAll('input');
                
                currentInputs.forEach((input, idx) => {
                    if (nextInputs[idx]) {
                        input.value = nextInputs[idx].value;
                    }
                });
            }
            
            // Clear and hide the last visible fieldset
            const lastVisible = visibleFieldsets[visibleFieldsets.length - 1];
            lastVisible.querySelectorAll('input').forEach(input => {
                input.value = '';
                input.required = false;
                input.disabled = true;
            });
            
            lastVisible.querySelectorAll('[id$="-error"]').forEach(errorMsg => {
                errorMsg.textContent = 'Obbligatorio';
            });
            
            lastVisible.style.display = 'none';
            
            // Clear the max tracks error if it exists
            const maxTracksError = document.querySelector('#max-tracks-error');
            if (maxTracksError) {
                maxTracksError.textContent = '';
            }
        }
    }
});


function validateTrackTitle(input)  {
    let errorMessage = '';
    let pattern = /^[a-zA-Z0-9àèéìòùÀÈÉÌÒÙ\s]*$/;
    let value = input.value.trim();

    if (value.length < 1) {
        errorMessage += 'Obbligatorio';
    } else if (value.length > 200) {
        errorMessage += 'Il titolo non deve superare i 200 caratteri';
    } else if (!value.match(pattern)) {
        errorMessage += 'Caratteri non validi nel titolo';
    }else {
        errorMessage = '';
    }
    return errorMessage;
}

function validateTrackDuration(input) {
    let errorMessage = '';
    let value = input.value.trim();
    let numValue = parseInt(value, 10);

    if (value === '') {
        errorMessage = 'Obbligatorio';
    } else if (isNaN(numValue)) {
        errorMessage = 'Deve essere un numero';
    } else if (numValue < 1) {
        errorMessage = 'Minimo 1 secondo';
    } else if (numValue > 32767) {
        errorMessage = 'Massimo 32767 secondi';
    } else {
        errorMessage = '';
    }
    return errorMessage;
}

function validateSelect(element, errorMessage) {
    let value = element.value.trim();
    if (value !== '') {
        if (errorMessage) {
            errorMessage.textContent = '';
        }
    }
}

function getMaxTracksForDiskType(diskType) {
    if (!diskType) return 30; // Default if no disk type is selected
    
    const limits = {
        'SINGLE': 1,
        'EP': 6,
        'Album': 30
    };
    
    return limits[diskType] || 30;
}

function filterEditionsByDisk(diskId) {
    const editionSelect = document.getElementById('edition');
    const optGroups = editionSelect.getElementsByTagName('optgroup');

    for (let i = 0; i < optGroups.length; i++) {
        const optGroup = optGroups[i];
        if (optGroup.getAttribute('data-disk-id') === diskId) {
            optGroup.style.display = '';
        } else {
            optGroup.style.display = 'none';
        }
    }
}

this.document.getElementById('disk').addEventListener('input', function () {
    const selectedDiskId = this.value;
    filterEditionsByDisk(selectedDiskId);
});