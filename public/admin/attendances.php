<?php
require_once __DIR__ . '/../../includes/config.php';
require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../includes/attendance.php';
require_admin();

$from = $_GET['from'] ?? date('Y-m-01');
$to = $_GET['to'] ?? date('Y-m-d 23:59:59');
$emp = isset($_GET['emp']) && $_GET['emp'] !== '' ? (int)$_GET['emp'] : null;
$rows = attendance_for_date_range($from, $to, $emp);
$emps = list_employees();
?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Journal</title>
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
    <div class="card mb-3">
      <h1 class="h4">Journal / Historique</h1>
      <form class="row g-2 mt-2">
        <div class="col-md-3">
          <label class="form-label small">De</label>
          <input class="form-control" type="datetime-local" name="from" value="<?= htmlspecialchars(str_replace(' ','T',$from)) ?>">
        </div>
        <div class="col-md-3">
          <label class="form-label small">À</label>
          <input class="form-control" type="datetime-local" name="to" value="<?= htmlspecialchars(str_replace(' ','T', substr($to,0,16))) ?>">
        </div>
        <div class="col-md-3">
          <label class="form-label small">Employé</label>
          <select class="form-select" name="emp">
            <option value="">Tous</option>
            <?php foreach($emps as $e): ?>
              <option value="<?= $e['id'] ?>" <?= $emp===$e['id']?'selected':'' ?>><?= htmlspecialchars($e['full_name']) ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="col-md-3 d-flex align-items-end">
          <div class="d-flex gap-2">
            <button class="btn btn-primary">Filtrer</button>
            <a class="btn btn-outline-success" href="export.php?from=<?= urlencode($from) ?>&to=<?= urlencode($to) ?>&emp=<?= urlencode((string)$emp) ?>">Export CSV</a>
          </div>
        </div>
      </form>
    </div>

    <div class="table-responsive card">
      <table class="table align-middle">
        <thead><tr><th>Employé</th><th>Début</th><th>Fin</th><th>Minutes</th></tr></thead>
        <tbody>
          <?php foreach ($rows as $r): ?>
            <tr>
              <td><?= htmlspecialchars($r['full_name']) ?></td>
              <td><?= htmlspecialchars($r['started_at']) ?></td>
              <td><?= htmlspecialchars($r['ended_at'] ?? '-') ?></td>
              <td><?= (int)($r['minutes_worked'] ?? 0) ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</body>
</html>
