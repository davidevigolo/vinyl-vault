this.document.getElementById('disk').value == '' ? this.document.getElementById('edition').setAttribute('disabled', 'true') : null;
this.document.querySelectorAll('.track-fieldset').forEach((fieldset, index) => fieldset.getAttribute('data-display') === 'false' ? fieldset.style.display = 'none' : null);

this.document.getElementById('disk').addEventListener('input', function () {
    let errorMessage = document.getElementById('disk-error');
    let editionInput = document.getElementById('edition');
    editionInput.value = '';
    
    validateSelect(this, errorMessage);
    editionInput.removeAttribute('disabled');
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
    const hiddenFieldset = Array.from(document.querySelectorAll('.track-fieldset')).find(fieldset => getComputedStyle(fieldset).display === 'none');
    if (hiddenFieldset) {
        hiddenFieldset.style.display = 'block';
    }else {
        alert('Hai raggiunto il numero massimo di tracce aggiungibili.');
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