// Personal info form
const personalInfoForm = document.getElementById('personal-info-form');
const personalInfoBtn = document.getElementById('personal-info-btn');

const firstNameInput = document.getElementById('first-name-input');
const lastNameInput = document.getElementById('last-name-input');
const emailInput = document.getElementById('email-input');
const usernameInput = document.getElementById('username-input');
const bioInput = document.getElementById('bio-input');
const bioCounter = document.getElementById('bio-counter');

// Store initial values for change detection
const initialValues = {
    firstName: firstNameInput.value,
    lastName: lastNameInput.value,
    email: emailInput.value,
    username: usernameInput.value,
    bio: bioInput.value
};

// Password form
const passwordForm = document.getElementById('password-form');
const passwordBtn = document.getElementById('password-btn');

const newPasswordInput = document.getElementById('new-password-input');
const confirmPasswordInput = document.getElementById('confirm-password-input');

// Profile picture
const propicUpload = document.getElementById('propic-upload');
const currentPropic = document.getElementById('current-propic');

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

const showChangeIndicator = (input) => {
    const wrapper = input.parentElement;
    let indicator = wrapper.querySelector('.field-changed-indicator');
    
    if (!indicator) {
        indicator = document.createElement('span');
        indicator.className = 'field-changed-indicator';
        indicator.textContent = ' (modificato)';
        indicator.setAttribute('aria-live', 'polite');
        
        const label = wrapper.querySelector('label');
        if (label) {
            label.appendChild(indicator);
        }
    }
};

const hideChangeIndicator = (input) => {
    const wrapper = input.parentElement;
    const indicator = wrapper.querySelector('.field-changed-indicator');
    if (indicator) {
        indicator.remove();
    }
};

const checkIfChanged = (input, initialValue) => {
    if (input.value !== initialValue) {
        showChangeIndicator(input);
    } else {
        hideChangeIndicator(input);
    }
};

const isTextValid = (text) => text.trim().length > 0;

const hasNumbers = (text) => /[0-9]/.test(text);

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

// Update button state for personal info form
const updatePersonalInfoButtonState = () => {
    const isFormValid =
        isTextValid(firstNameInput.value) &&
        !hasNumbers(firstNameInput.value) &&
        isTextValid(lastNameInput.value) &&
        !hasNumbers(lastNameInput.value) &&
        isEmailValid(emailInput.value) &&
        isTextValid(usernameInput.value) &&
        bioInput.value.length <= 500;

    if (isFormValid) {
        personalInfoBtn.removeAttribute('disabled');
    } else {
        personalInfoBtn.setAttribute('disabled', 'disabled');
    }
};

// Update button state for password form
const updatePasswordButtonState = () => {
    const newPwd = newPasswordInput.value;
    const confirmPwd = confirmPasswordInput.value;

    const isFormValid =
        isTextValid(newPwd) &&
        isTextValid(confirmPwd) &&
        getPasswordError(newPwd) === null &&
        doPasswordsMatch(newPwd, confirmPwd);

    if (isFormValid) {
        passwordBtn.removeAttribute('disabled');
    } else {
        passwordBtn.setAttribute('disabled', 'disabled');
    }
};

const checkRequiredText = (event, errorId, fieldName) => {
    const input = event.target;
    if (!isTextValid(input.value)) {
        showError(input, errorId, `Il ${fieldName} è obbligatorio`);
    } else if (hasNumbers(input.value)) {
        showError(input, errorId, `Il ${fieldName} non può contenere numeri`);
    } else {
        clearError(input, errorId);
    }
    
    // Check if value changed for first/last name
    if (input === firstNameInput) {
        checkIfChanged(input, initialValues.firstName);
    } else if (input === lastNameInput) {
        checkIfChanged(input, initialValues.lastName);
    }
    
    updatePersonalInfoButtonState();
};

const checkUsername = (event) => {
    const input = event.target;
    if (!isTextValid(input.value)) {
        showError(input, 'username-error', 'Lo <span lang="en">username</span> è obbligatorio');
    } else {
        clearError(input, 'username-error');
    }
    checkIfChanged(input, initialValues.username);
    updatePersonalInfoButtonState();
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
    checkIfChanged(input, initialValues.email);
    updatePersonalInfoButtonState();
};

const updateBioCounter = () => {
    if (bioCounter) {
        const remaining = 500 - bioInput.value.length;
        bioCounter.textContent = `${bioInput.value.length}/500 caratteri`;
    }
};

const checkBio = (event) => {
    const input = event.target;
    updateBioCounter();
    
    if (input.value.length > 500) {
        showError(input, 'bio-error', 'La bio non può superare i 500 caratteri');
    } else {
        clearError(input, 'bio-error');
    }
    checkIfChanged(input, initialValues.bio);
    updatePersonalInfoButtonState();
};

const checkPassword = (event) => {
    const input = event.target;
    const password = input.value;

    // Password is required in this form
    if (password.length === 0) {
        showError(input, 'password-error', 'Inserisci la nuova <span lang="en">password</span>');
    } else {
        const error = getPasswordError(password);
        if (error) {
            showError(input, 'password-error', error);
        } else {
            clearError(input, 'password-error');
        }
    }

    // Re-validate confirm field if it has a value
    if (confirmPasswordInput.value.length > 0) {
        checkConfirm({ target: confirmPasswordInput });
    }

    updatePasswordButtonState();
};

const checkConfirm = (event) => {
    const input = event.target;
    const newPwd = newPasswordInput.value;
    const confirmPwd = input.value;

    if (confirmPwd.length === 0) {
        showError(input, 'password-confirm-error', 'Conferma la <span lang="en">password</span>');
    } else if (!doPasswordsMatch(newPwd, confirmPwd)) {
        showError(input, 'password-confirm-error', 'Le <span lang="en">password</span> non corrispondono');
    } else {
        clearError(input, 'password-confirm-error');
    }
    updatePasswordButtonState();
};

// Profile picture preview
const handlePropicUpload = (event) => {
    const file = event.target.files[0];
    if (!file) return;

    // Validate file size (1MB)
    const maxSize = 1 * 1024 * 1024;
    if (file.size > maxSize) {
        const wrapper = propicUpload.closest('.profile-picture-container');
        let errorElement = wrapper.querySelector('.error-message');

        if (!errorElement) {
            errorElement = document.createElement('p');
            errorElement.className = 'error-message';
            errorElement.id = 'propic-error';
            errorElement.setAttribute('aria-live', 'assertive');
            wrapper.querySelector('.profile-picture-info').appendChild(errorElement);
        }

        errorElement.innerHTML = 'Il file supera la dimensione massima di 1<abbr title="Megabyte">MB</abbr>';
        propicUpload.value = '';
        return;
    }

    // Validate file type
    const allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
    if (!allowedTypes.includes(file.type)) {
        const wrapper = propicUpload.closest('.profile-picture-container');
        let errorElement = wrapper.querySelector('.error-message');

        if (!errorElement) {
            errorElement = document.createElement('p');
            errorElement.className = 'error-message';
            errorElement.id = 'propic-error';
            errorElement.setAttribute('aria-live', 'assertive');
            wrapper.querySelector('.profile-picture-info').appendChild(errorElement);
        }

        errorElement.innerHTML = 'Formato file non valido. Usa <abbr title="Joint Photographic Experts Group" lang="en">JPG</abbr>, <abbr title="Portable Network Graphics" lang="en">PNG</abbr> o <abbr title="Web Picture format" lang="en">WEBP</abbr>';
        propicUpload.value = '';
        return;
    }

    // Clear any existing errors
    const wrapper = propicUpload.closest('.profile-picture-container');
    const errorElement = wrapper.querySelector('.error-message');
    if (errorElement) {
        errorElement.remove();
    }

    // Preview the image
    const reader = new FileReader();
    reader.onload = (e) => {
        currentPropic.src = e.target.result;
    };
    reader.readAsDataURL(file);

    // Auto-submit the form
    document.getElementById('profile-picture-form').submit();
};

// Event listeners for personal info form
firstNameInput.addEventListener('input', (e) => checkRequiredText(e, 'first-name-error', 'nome'));
lastNameInput.addEventListener('input', (e) => checkRequiredText(e, 'last-name-error', 'cognome'));
emailInput.addEventListener('input', checkEmail);
usernameInput.addEventListener('input', checkUsername);
bioInput.addEventListener('input', checkBio);

// Event listeners for password form
newPasswordInput.addEventListener('input', checkPassword);
confirmPasswordInput.addEventListener('input', checkConfirm);

// Event listener for profile picture
propicUpload.addEventListener('change', handlePropicUpload);

// Initial character counter and button states
updateBioCounter();
updatePersonalInfoButtonState();
updatePasswordButtonState();
