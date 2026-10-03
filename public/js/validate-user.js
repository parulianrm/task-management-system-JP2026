document.addEventListener('DOMContentLoaded', function () {
    function clearErrors(form) {
        form.querySelectorAll('.field-error').forEach(function (span) { span.textContent = ''; });
    }

    function attachSubmit(formId) {
        var form = document.getElementById(formId);
        if (!form) return;

        form.addEventListener('submit', function (event) {
            event.preventDefault();
            clearErrors(form);

            var nameInput = form.querySelector('[name="name"]');
            var emailInput = form.querySelector('[name="email"]');
            var nameError = form.querySelector('[data-error-for="name"]');
            var emailError = form.querySelector('[data-error-for="email"]');

            var isValid = true;
            if (nameInput.value.trim() === '') {
                nameError.textContent = 'Nama wajib diisi.';
                isValid = false;
            }
            if (emailInput.value.trim() === '') {
                emailError.textContent = 'Email wajib diisi.';
                isValid = false;
            }
            if (!isValid) return;

            var payload = {
                name: nameInput.value.trim(),
                email: emailInput.value.trim(),
                role: form.querySelector('[name="role"]').value
            };

            var passwordInput = form.querySelector('[name="password"]');
            if (passwordInput) {
                payload.password = passwordInput.value;
            }

            var userId = form.dataset.userId;
            if (userId) {
                payload.id = userId;
            }

            apiPost('/api/users.php', payload).then(function (result) {
                if (!result.success) {
                    if (result.errors) {
                        Object.keys(result.errors).forEach(function (field) {
                            var errEl = form.querySelector('[data-error-for="' + field + '"]');
                            if (errEl) errEl.textContent = result.errors[field];
                        });
                    } else if (result.message) {
                        nameError.textContent = result.message;
                    }
                    return;
                }

                sessionStorage.setItem('toastMessage', userId ? 'User berhasil diperbarui.' : 'User berhasil ditambahkan.');
                sessionStorage.setItem('toastType', 'success');
                form.closest('dialog').close();
                window.location.reload();

            }).catch(function () {
                nameError.textContent = 'Gagal menyimpan, coba lagi nanti.';
            });
        });
    }

    attachSubmit('user-form');
    attachSubmit('user-edit-form');
});
