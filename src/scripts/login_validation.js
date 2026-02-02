const form = document.getElementById('login-form');

const emailInput = document.getElementById('email-input');
const passwordInput = document.getElementById('password-input');
const btn = document.getElementById('login-btn');

const emailErrorId = 'email-error';
const passwordErrorId = 'password-error';
const authErrorId = 'auth-error';

const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
const isEmailValid = (email) => email.length > 0 && emailRegex.test(email);

const isPasswordValid = (password) => password.length > 0;

const showError = (input, errorId, message) => {
    const wrapper = input.parentElement;
    let errorElement = wrapper.querySelector('.error-message');

    if (!errorElement) {
        errorElement = document.createElement('p');
        errorElement.className = 'error-message';
        errorElement.id = errorId;
        errorElement.setAttribute('aria-live', 'assertive');
        wrapper.appendChild(errorElement);
    }

    errorElement.innerHTML = message;
    input.classList.add('input-error');
}

const clearError = (input, errorId) => {
    const errorElement = document.getElementById(errorId);
    if (errorElement) {
        errorElement.remove();
    }
    input.classList.remove('input-error');
}

const updateButtonState = () => {
    const emailValue = emailInput.value;
    const passwordValue = passwordInput.value;

    if (isEmailValid(emailValue) && isPasswordValid(passwordValue)) {
        btn.removeAttribute('disabled');
    } else {
        btn.setAttribute('disabled', 'disabled');
    }
};

const checkEmail = (event) => {
    const email = event.target.value;

    if (email.length === 0) {
        showError(emailInput, emailErrorId, 'L\'email è obbligatoria');
    } else if (!emailRegex.test(email)) {
        showError(emailInput, emailErrorId, 'Formato email non valido');
    } else {
        clearError(emailInput, emailErrorId);
    }

    updateButtonState();
}

const checkPassword = (event) => {
    const password = event.target.value;

    if (password.length === 0) {
        showError(passwordInput, passwordErrorId, 'La password è obbligatoria');
    } else {
        clearError(passwordInput, passwordErrorId);
    }

    updateButtonState();
}

updateButtonState();

emailInput.addEventListener('input', (event) => checkEmail(event))
passwordInput.addEventListener('input', (event) => checkPassword(event))
