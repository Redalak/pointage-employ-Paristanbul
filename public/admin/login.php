<?php
require_once __DIR__ . '/../../includes/config.php';
require_once __DIR__ . '/../../includes/auth.php';
$error = handle_admin_login();
$page_title = 'Admin - Connexion';
$assets_prefix = '../';
require_once __DIR__ . '/../../vue/partials/header.php';
require_once __DIR__ . '/../../vue/partials/navbar_admin.php';
?>
  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-md-5">
        <div class="card">
          <h1 class="h4">Connexion admin</h1>
          <?php if ($error): ?><div class="alert alert-danger auto-dismiss"><?= htmlspecialchars($error) ?></div><?php endif; ?>
          <form method="post" class="mt-3">
            <div class="mb-3">
              <label class="form-label">Mot de passe</label>
              <input type="password" class="form-control" name="password" required>
            </div>
            <button class="btn btn-primary" type="submit">Se connecter</button>
          </form>
        </div>
      </div>
    </div>
  </div>
<?php require_once __DIR__ . '/../../vue/partials/footer.php'; ?>
