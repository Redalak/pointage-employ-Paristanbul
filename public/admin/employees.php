<?php
require_once __DIR__ . '/../../includes/config.php';
require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../includes/attendance.php';
require_admin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['create'])) {
        create_employee(trim($_POST['name']), $_POST['role']);
    } elseif (isset($_POST['update'])) {
        update_employee((int)$_POST['id'], trim($_POST['name']), $_POST['role'], isset($_POST['active']) ? 1 : 0);
    } elseif (isset($_POST['delete'])) {
        delete_employee((int)$_POST['id']);
    }
    header('Location: employees.php');
    exit;
}
$employees = list_employees();
?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Employés</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="../assets/styles.css">
  <script src="../assets/app.js" defer></script>
</head>
<body>
  <nav class="navbar navbar-dark">
    <div class="container d-flex align-items-center py-2">
      <span class="brand">Admin</span>
      <a class="btn btn-outline-light btn-sm" href="dashboard.php">Retour</a>
    </div>
  </nav>
  <div class="container py-4">
    <div class="card mb-4">
      <h1 class="h4">Employés</h1>
      <form method="post" class="row g-2 mt-2">
        <div class="col-md-5"><input class="form-control" name="name" placeholder="Nom complet" required></div>
        <div class="col-md-3">
          <select class="form-select" name="role">
            <option value="employee">Employé</option>
            <option value="admin">Admin</option>
          </select>
        </div>
        <div class="col-md-2"><button class="btn btn-primary w-100" name="create">Ajouter</button></div>
      </form>
    </div>

    <div class="table-responsive card">
      <table class="table align-middle">
        <thead><tr><th>Nom</th><th>QR</th><th>Rôle</th><th>Actif</th><th>Actions</th></tr></thead>
        <tbody>
        <?php foreach ($employees as $e): ?>
          <tr>
            <td><?= htmlspecialchars($e['full_name']) ?></td>
            <td class="qr-preview">
              <img src="https://api.qrserver.com/v1/create-qr-code/?size=120x120&data=<?= urlencode($e['qr_token']) ?>" width="64" height="64" alt="QR">
              <div><span class="badge badge-soft"><?= substr($e['qr_token'],0,8) ?>...</span></div>
            </td>
            <td><?= htmlspecialchars($e['role']) ?></td>
            <td><?= $e['active'] ? 'Oui' : 'Non' ?></td>
            <td>
              <form method="post" class="row g-2 align-items-center">
                <input type="hidden" name="id" value="<?= $e['id'] ?>">
                <div class="col-md-4"><input class="form-control" name="name" value="<?= htmlspecialchars($e['full_name']) ?>"></div>
                <div class="col-md-3">
                  <select class="form-select" name="role">
                    <option value="employee" <?= $e['role']==='employee'?'selected':'' ?>>Employé</option>
                    <option value="admin" <?= $e['role']==='admin'?'selected':'' ?>>Admin</option>
                  </select>
                </div>
                <div class="col-md-2 form-check">
                  <input class="form-check-input" type="checkbox" name="active" <?= $e['active']? 'checked':'' ?>>
                  <label class="form-check-label">Actif</label>
                </div>
                <div class="col-md-3">
                  <button class="btn btn-sm btn-primary" name="update">Maj</button>
                  <button class="btn btn-sm btn-outline-danger" name="delete" onclick="return confirm('Supprimer?')">Suppr</button>
                </div>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</body>
</html>
