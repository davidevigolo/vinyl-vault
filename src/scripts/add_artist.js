
this.document.getElementById('name').addEventListener('input', function () {
    // Find the error message element
    let errorMessage = document.getElementById('name-error');
    let pattern = /^[a-zA-Z0-9àèéìòùÀÈÉÌÒÙ\s]*$/;
    let value = this.value.trim();

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
});

this.document.getElementById('nationality').addEventListener('input', function () {
    // Find the error message element
    let errorMessage = document.getElementById('nationality-error');

    // Validate selected
    validateSelect(this, errorMessage);
});

this.document.getElementById('biography').addEventListener('input', function () {
    // Find the error message element
    let errorMessage = document.getElementById('biography-error');

    // Validate selected
    if (this.value.trim().length >= 400) {
        if (errorMessage) {
            errorMessage.textContent = 'Limite massimo di caratteri superato (400)';
        }
    } else {
        if (errorMessage) {
            errorMessage.textContent = '';
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