<?php $pageTitle = 'Login - Task Management System'; ?>
<?php require __DIR__ . '/../partials/header.php'; ?>

<main class="auth-screen">
  <h1 class="visually-hidden">Login</h1>
  <div class="login-card">
    <h2 class="login-title">Login</h2>
    <div class="divider"></div>
    <?php $error = $_GET['error'] ?? ''; ?>
    <?php if ($error === 'invalid'): ?>
      <div class="alert alert-error" role="alert">
        Email atau password salah.
      </div>
    <?php elseif ($error === 'inactive'): ?>
      <div class="alert alert-error" role="alert">
        Akun Anda tidak aktif. Silakan hubungi Admin.
      </div>
    <?php endif; ?>
    <form id="login-form" action="/login" method="POST" novalidate>
      <div class="form-group">
        <label for="email">Email</label>
        <div class="field-wrap">
          <input type="email" id="email" name="email" placeholder="nama@neuronworks.co.id" required />
          <span class="field-error" id="email-error"></span>
        </div>
      </div>

      <div class="form-group">
        <label for="password">Password</label>
        <div class="field-wrap">
          <input type="password" id="password" name="password" placeholder="********" required />
          <span class="field-error" id="password-error"></span>
        </div>
      </div>

      <button type="submit" class="btn-submit">Masuk</button>
    </form>
  </div>
</main>

<script src="/js/validate-login.js" defer></script>
<?php require __DIR__ . '/../partials/footer.php'; ?>