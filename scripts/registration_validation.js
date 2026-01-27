const form = document.getElementById('registration-form');
const submitBtn = document.getElementById('login-btn');

const firstNameInput = document.getElementById('first-name-input');
const lastNameInput = document.getElementById('last-name-input');
const emailInput = document.getElementById('email-input');
const usernameInput = document.getElementById('username-input');
const passwordInput = document.getElementById('password-input');
const passwordConfirmInput = document.getElementById('password-confirm-input');

const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

const countMatches = (str, pattern) => {
    return (str.match(pattern) || []).length;
};

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
};

const clearError = (input, errorId) => {
    const wrapper = input.parentElement;
    const errorElement = wrapper.querySelector('.error-message');
    if (errorElement) {
        errorElement.remove();
    }
    input.classList.remove('input-error');
};

const isTextValid = (text) => text.trim().length > 0;

const isEmailValid = (email) => email.trim().length > 0 && emailRegex.test(email);

const getPasswordError = (password) => {
    if (password.length < 12) {
        return 'La <span lang="en">password</span> deve essere di almeno 12 caratteri';
    }
    if (countMatches(password, /[0-9]/g) < 2) {
        return 'La <span lang="en">password</span> deve contenere almeno 2 numeri';
    }
    if (countMatches(password, /[^a-zA-Z0-9]/g) < 2) {
        return 'La <span lang="en">password</span> deve contenere almeno 2 caratteri speciali';
    }
    return null;
};

const doPasswordsMatch = (pwd, confirmPwd) => pwd === confirmPwd;

const updateButtonState = () => {
    const isFormValid =
        isTextValid(firstNameInput.value) &&
        isTextValid(lastNameInput.value) &&
        isEmailValid(emailInput.value) &&
        isTextValid(usernameInput.value) &&
        getPasswordError(passwordInput.value) === null &&
        doPasswordsMatch(passwordInput.value, passwordConfirmInput.value) &&
        passwordConfirmInput.value.length > 0;

    if (isFormValid) {
        submitBtn.removeAttribute('disabled');
    } else {
        submitBtn.setAttribute('disabled', 'disabled');
    }
};

const checkRequiredText = (event, errorId, fieldName) => {
    const input = event.target;
    if (!isTextValid(input.value)) {
        showError(input, errorId, `Il ${fieldName} è obbligatorio`);
    } else {
        clearError(input, errorId);
    }
    updateButtonState();
};

const checkUsername = (event) => {
    const input = event.target;
    if (!isTextValid(input.value)) {
        showError(input, 'username-error', 'Lo <span lang="en">username</span> è obbligatorio');
    } else {
        clearError(input, 'username-error');
    }
    updateButtonState();
};

const checkEmail = (event) => {
    const input = event.target;
    const val = input.value.trim();

    if (val.length === 0) {
        showError(input, 'email-error', 'L\'<span lang="en">email</span> è obbligatoria');
    } else if (!emailRegex.test(val)) {
        showError(input, 'email-error', 'Formato <span lang="en">email</span> non valido');
    } else {
        clearError(input, 'email-error');
    }
    updateButtonState();
};

const checkPassword = (event) => {
    const input = event.target;
    const error = getPasswordError(input.value);

    if (error) {
        showError(input, 'password-error', error);
    } else {
        clearError(input, 'password-error');
    }

    if (passwordConfirmInput.value.length > 0) {
        checkConfirm({ target: passwordConfirmInput });
    }

    updateButtonState();
};

const checkConfirm = (event) => {
    const input = event.target;
    const originalPwd = passwordInput.value;

    if (!doPasswordsMatch(originalPwd, input.value)) {
        showError(input, 'password-confirm-error', 'Le <span lang="en">password</span> non corrispondono');
    } else {
        clearError(input, 'password-confirm-error');
    }
    updateButtonState();
};

firstNameInput.addEventListener('input', (e) => checkRequiredText(e, 'first-name-error', 'nome'));
lastNameInput.addEventListener('input', (e) => checkRequiredText(e, 'last-name-error', 'cognome'));
usernameInput.addEventListener('input', checkUsername);
emailInput.addEventListener('input', checkEmail);
passwordInput.addEventListener('input', checkPassword);
passwordConfirmInput.addEventListener('input', checkConfirm);

updateButtonState();