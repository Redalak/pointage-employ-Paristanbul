<?php
require_once __DIR__ . '/../../includes/config.php';
require_once __DIR__ . '/../../includes/auth.php';
$error = handle_admin_login();
?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin - Connexion</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="../assets/styles.css">
  <script src="../assets/app.js" defer></script>
</head>
<body>
  <nav class="navbar navbar-dark">
    <div class="container d-flex align-items-center py-2">
      <span class="brand">Admin</span>
      <a class="btn btn-outline-light btn-sm" href="../index.php">Kiosque</a>
    </div>
  </nav>
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
</body>
</html>
