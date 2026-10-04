<?php
$pageTitle = '404 - Halaman Tidak Ditemukan';
$basePath = '../';
require __DIR__ . '/../partials/header.php';
?>
<main class="auth-screen">
    <div class="error-card">
        <img src="/images/404.png" class="error-icon" alt="" />
        <div class="error-code">404</div>
        <h1 class="error-title">Halaman Tidak Ditemukan</h1>
        <p class="error-desc">URL yang kamu buka tidak ada atau sudah dipindahkan.</p>
        <a href="/dashboard" class="btn-primary">Kembali ke Dashboard</a>
    </div>
</main>
<?php require __DIR__ . '/../partials/footer.php'; ?>
