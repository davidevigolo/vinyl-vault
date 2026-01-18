
window.addEventListener('load', function () {
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

    this.document.getElementById('photo').addEventListener('input', function () {
        // Find the error message element
        let errorMessage = document.getElementById('photo-error');

        // Replace the $SELECTION_PLACEHOLDER$ with the following line:
        message = '';
        message += validateFileSize(this);
        message += validateFileExtension(this);
        errorMessage.textContent = message;
    }); // Added closing brace here
});

function validateSelect(element, errorMessage) {
    let value = element.value.trim();
    if (value !== '') {
        if (errorMessage) {
            errorMessage.textContent = '';
        }
    }
}

function validateFileExtension(input) {
    const allowedExtensions = /(\.webp|\.jpg|\.jpeg)$/i;
    let value = input.value.trim();

    let errorMessage = '';
    if (value.length < 1) {
        errorMessage += 'Obbligatorio';
    } else if (!allowedExtensions.exec(value)) {
        errorMessage += 'Formato file non valido. Usa webp, jpg o jpeg.';
    } else {
        errorMessage += '';
    }
    return errorMessage;
}

function validateFileSize(input) {
    const maxSizeInMB = 2;
    const maxSizeInBytes = maxSizeInMB * 1024 * 1024; // Convert MB to Bytes
    const file = input.files[0];

    let errorMessage = '';

    if (file && file.size > maxSizeInBytes) {
        errorMessage += 'Il file supera la dimensione massima di 8MB.';
    } else {
        errorMessage += '';
    }
    return errorMessage;
}