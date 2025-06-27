<!-- views/auth/login.php -->
<div class="container mt-5" style="max-width:400px;">
  <h2 class="mb-4">Iniciar sesión</h2>
  <?php if (!empty($error)): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
  <?php endif; ?>
  <form method="post">
    <div class="mb-3">
      <input name="username" class="form-control" placeholder="Usuario" required>
    </div>
    <div class="mb-3">
      <input type="password" name="password" class="form-control" placeholder="Contraseña" required>
    </div>
    <button class="btn btn-primary w-100">Entrar</button>
  </form>
</div>
