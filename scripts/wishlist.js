
window.addEventListener('load', function() {
    this.document.querySelectorAll('input[name="priority_level[]"]').forEach(function(input) {
        input.addEventListener('input', function() {
            // Find the error message element
            let errorMessage = this.parentElement.querySelector('.priority-error-message');
            
            // Validate range
            let value = parseInt(this.value);
            if (this.value !== '' && (isNaN(value) || value < 0 || value > 100)) {
                // Show error message
                if (errorMessage) {
                    errorMessage.style.display = 'block';
                }
            } else {
                // Hide error message
                if (errorMessage) {
                    errorMessage.style.display = 'none';
                }
            }
        });
    });
});