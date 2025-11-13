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
  <div class="container py-4">
    <div class="card">
      <h1 class="h4">Tableau de bord</h1>
      <div class="actions mt-2">
        <a class="btn btn-outline-secondary" href="employees.php">Employés</a>
        <a class="btn btn-outline-secondary" href="attendances.php">Journal / Historique</a>
        <a class="btn btn-outline-secondary" href="totals.php">Totaux jour/semaine</a>
        <a class="btn btn-outline-danger" href="logout.php">Déconnexion</a>
      </div>
    </div>
  </div>
</body>
</html>
