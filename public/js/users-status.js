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
});
