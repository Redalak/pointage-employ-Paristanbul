<?php
require_once __DIR__ . '/../../includes/config.php';
require_once __DIR__ . '/../../includes/auth.php';
require_admin();
?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin - Tableau de bord</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body class="container py-4">
  <h1>Admin</h1>
  <div class="mb-3">
    <a class="btn btn-outline-secondary" href="employees.php">Employés</a>
    <a class="btn btn-outline-secondary" href="attendances.php">Journal / Historique</a>
    <a class="btn btn-outline-danger" href="logout.php">Déconnexion</a>
  </div>
</body>
</html>
