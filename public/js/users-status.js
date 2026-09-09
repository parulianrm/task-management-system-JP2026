document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('[data-status-toggle]').forEach(function (checkbox) {
        checkbox.addEventListener('change', function () {
            var statusText = checkbox.closest('td').querySelector('.status-text');
            statusText.textContent = checkbox.checked ? 'Aktif' : 'Nonaktif';
        });
    });
});
