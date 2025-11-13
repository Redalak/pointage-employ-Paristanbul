<?php
require_once __DIR__ . '/../../includes/config.php';
require_once __DIR__ . '/../../includes/auth.php';
require_admin();
$page_title = 'Admin - Tableau de bord';
$assets_prefix = '../';
require_once __DIR__ . '/../../src/vue/partials/header.php';
require_once __DIR__ . '/../../src/vue/partials/navbar_admin.php';
?>
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
<?php require_once __DIR__ . '/../../src/vue/partials/footer.php'; ?>
