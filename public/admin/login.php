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
</head>
<body class="container py-5">
  <h1>Connexion admin</h1>
  <?php if ($error): ?><div class="alert alert-danger"><?= htmlspecialchars($error) ?></div><?php endif; ?>
  <form method="post" class="mt-3" style="max-width:320px">
    <div class="mb-3">
      <label class="form-label">Mot de passe</label>
      <input type="password" class="form-control" name="password" required>
    </div>
    <button class="btn btn-primary" type="submit">Se connecter</button>
  </form>
</body>
</html>
