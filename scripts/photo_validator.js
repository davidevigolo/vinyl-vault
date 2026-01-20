this.document.getElementById('photo').addEventListener('input', function () {
    // Find the error message element
    let errorMessage = document.getElementById('photo-error');
    let photo = this.value.trim();
    if (!photo) {
        errorMessage.textContent = 'Obbligatorio';
        return;
    }

    let message = '';

    // Replace the $SELECTION_PLACEHOLDER$ with the following line:
    message = '';
    message += validateFileSize(this);
    message += validateFileExtension(this);
    errorMessage.textContent = message;
}); // Added closing brace here

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
        errorMessage += 'Il file supera la dimensione massima di 2MB.';
    } else {
        errorMessage += '';
    }
    return errorMessage;
}