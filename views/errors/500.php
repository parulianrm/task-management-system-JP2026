<?php
$pageTitle = '500 - Kesalahan Server';
require __DIR__ . '/../partials/header.php';
?>
<main class="auth-screen">
    <div class="error-card">
        <div class="error-code">500</div>
        <h1 class="error-title">Terjadi Kesalahan</h1>
        <p class="error-desc">Ada masalah di server. Silakan coba lagi beberapa saat lagi.</p>
        <a href="/dashboard" class="btn-primary">Kembali ke Dashboard</a>
    </div>
</main>
<?php require __DIR__ . '/../partials/footer.php'; ?>
