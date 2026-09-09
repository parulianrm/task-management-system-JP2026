document.addEventListener('DOMContentLoaded', function () {
    var form = document.getElementById('login-form');
    if (!form) return;

    var emailInput = document.getElementById('email');
    var passwordInput = document.getElementById('password');
    var emailError = document.getElementById('email-error');
    var passwordError = document.getElementById('password-error');

    function isValidEmail(value) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value);
    }

    form.addEventListener('submit', function (event) {
        event.preventDefault();

        emailError.textContent = '';
        passwordError.textContent = '';

        var isValid = true;

        if (emailInput.value.trim() === '') {
            emailError.textContent = 'Email wajib diisi.';
            isValid = false;
        } else if (!isValidEmail(emailInput.value.trim())) {
            emailError.textContent = 'Format email tidak valid.';
            isValid = false;
        }

        if (passwordInput.value === '') {
            passwordError.textContent = 'Password wajib diisi.';
            isValid = false;
        }

        if (isValid) {
            console.log('Form valid — siap dikirim ke server (belum ada backend).');
        }
    });
});
