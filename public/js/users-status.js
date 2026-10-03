document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('[data-user-toggle]').forEach(function (checkbox) {
        checkbox.addEventListener('change', function () {
            var userId = checkbox.dataset.userToggle;
            var statusText = checkbox.closest('td').querySelector('.status-text');
            var newValue = checkbox.checked;

            apiPost('/api/users.php', {
                action: 'toggle_active',
                id: userId,
                is_active: newValue
            }).then(function (result) {
                if (!result.success) {
                    checkbox.checked = !newValue;
                    alert(result.message || 'Gagal mengubah status.');
                    return;
                }
                statusText.textContent = newValue ? 'Aktif' : 'Nonaktif';
            });
        });
    });

    document.querySelectorAll('[data-user-edit]').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var user = USERS_DATA.filter(function (u) { return u.id === parseInt(btn.dataset.userEdit, 10); })[0];
            if (!user) return;

            var modal = document.getElementById('user-edit-modal');
            modal.querySelectorAll('.field-error').forEach(function (span) { span.textContent = ''; });

            var form = modal.querySelector('form');
            form.dataset.userId = user.id;

            document.getElementById('edit-user-name').value = user.name;
            document.getElementById('edit-user-email').value = user.email;
            document.getElementById('edit-user-role').value = user.role;

            modal.showModal();
        });
    });

    document.querySelectorAll('[data-user-reset]').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var modal = document.getElementById('user-reset-password-modal');
            var form = modal.querySelector('form');
            form.dataset.userId = btn.dataset.userReset;
            form.reset();
            modal.querySelectorAll('.field-error').forEach(function (span) { span.textContent = ''; });
            modal.showModal();
        });
    });

    var resetForm = document.getElementById('user-reset-password-form');
    if (resetForm) {
        resetForm.addEventListener('submit', function (event) {
            event.preventDefault();
            var passwordInput = resetForm.querySelector('[name="password"]');
            var confirmInput = resetForm.querySelector('[name="password_confirmation"]');
            var passwordError = resetForm.querySelector('[data-error-for="password"]');
            var confirmError = resetForm.querySelector('[data-error-for="password_confirmation"]');
            passwordError.textContent = '';
            confirmError.textContent = '';

            if (passwordInput.value !== confirmInput.value) {
                confirmError.textContent = 'Konfirmasi password tidak sama.';
                return;
            }

            apiPost('/api/users.php', {
                action: 'reset_password',
                id: resetForm.dataset.userId,
                password: passwordInput.value
            }).then(function (result) {
                if (!result.success) {
                    if (result.errors && result.errors.password) {
                        passwordError.textContent = result.errors.password;
                    } else {
                        passwordError.textContent = result.message || 'Gagal reset password.';
                    }
                    return;
                }

                resetForm.closest('dialog').close();
                sessionStorage.setItem('toastMessage', 'Password berhasil direset.');
                sessionStorage.setItem('toastType', 'success');
                window.location.reload();
            }).catch(function () {
                passwordError.textContent = 'Gagal reset password, coba lagi nanti.';
            });
        });
    }

});
