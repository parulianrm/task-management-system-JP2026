<?php
$pageTitle = '403 - Akses Ditolak';
$basePath = '../';
require __DIR__ . '/../partials/header.php';
?>
<main class="auth-screen">
    <div class="error-card">
        <div class="error-code">403</div>
        <h1 class="error-title">Akses Ditolak</h1>
        <p class="error-desc">Kamu tidak punya izin untuk membuka halaman ini.</p>
       <a href="/dashboard" class="btn-primary">Kembali ke Dashboard</a>
    </div>
</main>
<?php require __DIR__ . '/../partials/footer.php'; ?>
