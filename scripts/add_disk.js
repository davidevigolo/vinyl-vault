
window.addEventListener('load', function () {
    this.document.getElementById('title').addEventListener('input', function () {
        // Find the error message element
        let errorMessage = document.getElementById('title-error');
        let pattern = /^[a-zA-Z0-9àèéìòùÀÈÉÌÒÙ\s]*$/;

        // Validate range
        let value = this.value.trim();
        if (value.length < 1) {
            if (errorMessage) {
                errorMessage.textContent = 'Obbligatorio';
            }
        }
        if (value.length > 200) {
            if (errorMessage) {
                errorMessage.textContent = 'Il titolo non deve superare i 200 caratteri';
            }
        }
        if (value.length >= 1 && value.length <= 200) {
            // Hide error message
            if (errorMessage) {
                errorMessage.textContent = '';
            }
        }
        if(!value.match(pattern)) {
            if (errorMessage) {
                errorMessage.textContent = 'Caratteri non validi nel titolo';
            }
        }
    });

    this.document.getElementById('artist').addEventListener('input', function () {
        // Find the error message element
        let errorMessage = document.getElementById('artist-error');

        // Validate selected
        let value = this.value.trim();

        validateSelect(this, errorMessage);
    });

    this.document.getElementById('genre').addEventListener('input', function () {
        // Find the error message element
        let errorMessage = document.getElementById('genre-error');

        // Validate selected
        validateSelect(this, errorMessage);
    });

    this.document.getElementById('type').addEventListener('input', function () {
        // Find the error message element
        let errorMessage = document.getElementById('type-error');

        // Validate selected
        validateSelect(this, errorMessage);
    });
});

function validateSelect(element, errorMessage) {
    let value = element.value.trim();
    if (value !== '') {
        if (errorMessage) {
            errorMessage.textContent = '';
        }
    }
}