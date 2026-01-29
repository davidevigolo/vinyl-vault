this.document.getElementById('disk').value == '' ? this.document.getElementById('edition').setAttribute('disabled', 'true') : null;
this.document.getElementById('disk').value == '' ? this.document.getElementById('add-track-button').setAttribute('disabled', 'true') : null;
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
            errorMsg.textContent = '';
        });
        
        // Hide all track fieldsets except the first one
        if (index > 0) {
            fieldset.style.display = 'none';
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
        addTrackButton.setAttribute('disabled', 'true');
    }
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
            // For index 0, always show errors. For others, only show if field has value
            if (index === '0') {
                errorMessage.textContent = error;
            } else {
                errorMessage.textContent = event.target.value.trim() === '' ? '' : error;
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
    const diskSelect = document.getElementById('disk');
    const selectedOption = diskSelect.options[diskSelect.selectedIndex];
    const diskType = selectedOption ? selectedOption.getAttribute('data-disk-type') : null;
    
    const maxTracks = getMaxTracksForDiskType(diskType);
    const visibleTracksCount = Array.from(document.querySelectorAll('.track-fieldset')).filter(fieldset => getComputedStyle(fieldset).display !== 'none').length;
    
    if (visibleTracksCount >= maxTracks) {
        const errorMessage = document.querySelector('#max-tracks-error');
        if (errorMessage) {
            errorMessage.textContent = 'Hai raggiunto il numero massimo di tracce per il tipo di disco selezionato';
        }
        return;
    }else{
        const errorMessage = document.querySelector('#max-tracks-error');
        if (errorMessage) {
            errorMessage.textContent = '';
        }
    }
    
    const hiddenFieldset = Array.from(document.querySelectorAll('.track-fieldset')).find(fieldset => getComputedStyle(fieldset).display === 'none');
    if (hiddenFieldset) {
        hiddenFieldset.style.display = 'block';
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