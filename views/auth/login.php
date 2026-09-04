<?php $pageTitle = 'Login - Task Management System'; ?>
<?php require __DIR__ . '/../partials/header.php'; ?>

<main class="auth-screen">
  <h1 class="visually-hidden">Login</h1>
  <div class="login-card">
    <h2 class="login-title">Login</h2>
    <div class="divider"></div>

    <form action="#" method="POST">
      <div class="form-group">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" placeholder="nama@neuronworks.co.id" required />
      </div>

      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="****" required />
      </div>

      <button type="submit" class="btn-submit">Masuk</button>
    </form>
  </div>
</main>

<!-- <?php require __DIR__ . '/../partials/footer.php'; ?> -->