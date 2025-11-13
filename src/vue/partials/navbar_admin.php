<?php $assets_prefix = $assets_prefix ?? '../'; ?>
<nav class="navbar navbar-dark">
  <div class="container d-flex align-items-center py-2">
    <span class="brand">Admin</span>
    <div class="d-flex gap-2">
      <a class="btn btn-outline-light btn-sm" href="dashboard.php">Tableau</a>
      <a class="btn btn-outline-light btn-sm" href="employees.php">Employés</a>
      <a class="btn btn-outline-light btn-sm" href="attendances.php">Journal</a>
      <a class="btn btn-outline-light btn-sm" href="totals.php">Totaux</a>
      <a class="btn btn-outline-danger btn-sm" href="logout.php">Quitter</a>
    </div>
  </div>
</nav>
