this.document.getElementById('country').addEventListener('input', function () {
    // Find the error message element
    let errorMessage = document.getElementById('country-error');
    validateSelect(this, errorMessage);
});

this.document.getElementById('name').addEventListener('input', function () {
    validate_name(this);
});

this.document.getElementById('standard-edition-checkbox').addEventListener('change', function () {
    let nameInput = document.getElementById('name');
    let nameError = document.getElementById('name-error');

    if (this.checked) {
        nameInput.disabled = true;
        nameError.textContent = '';
    } else {
        nameInput.disabled = false;
        nameInput.focus();
        validate_name(nameInput);
    }
});

this.document.getElementById('release-date').addEventListener('input', function () {
    // Find the error message element
    let errorMessage = document.getElementById('release-date-error');
    let value = this.value.trim();

    if (value.length < 1) {
        if (errorMessage) {
            errorMessage.textContent = 'Obbligatorio';
        }
    }
    if (value.length > 0) {
        let year = parseInt(value);
        let currentYear = new Date().getFullYear();
        if (year < 1887 || year > currentYear) {
            if (errorMessage) {
                errorMessage.textContent = 'La data di rilascio deve essere tra 1887 e ' + currentYear;
            }
        } else {
            if (errorMessage) {
                errorMessage.textContent = '';
            }
        }
    }
});

function validateSelect(element, errorMessage) {
    let value = element.value.trim();
    if (value !== '') {
        if (errorMessage) {
            errorMessage.textContent = '';
        }
    }
}

function validate_name(element) {
    // Find the error message element
    let errorMessage = document.getElementById('name-error');
    let pattern = /^[a-zA-Z0-9àèéìòùÀÈÉÌÒÙ\s]*$/;
    let value = element.value.trim();
    errorMessage.textContent = '';
    if (value.length < 1) {
        if (errorMessage) {
            errorMessage.textContent = 'Obbligatorio';
        }
    }
    if (!value.match(pattern)) {
        if (errorMessage) {
            errorMessage.textContent = 'Caratteri non validi nel nome';
        }
    }
};