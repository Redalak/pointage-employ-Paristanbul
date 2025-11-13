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
</head>
<body class="container py-4">
  <h1>Journal / Historique</h1>
  <div class="mb-3"><a class="btn btn-secondary" href="dashboard.php">Retour</a></div>

  <form class="row g-2 mb-3">
    <div class="col-md-3">
      <input class="form-control" type="datetime-local" name="from" value="<?= htmlspecialchars(str_replace(' ','T',$from)) ?>">
    </div>
    <div class="col-md-3">
      <input class="form-control" type="datetime-local" name="to" value="<?= htmlspecialchars(str_replace(' ','T', substr($to,0,16))) ?>">
    </div>
    <div class="col-md-3">
      <select class="form-select" name="emp">
        <option value="">Tous</option>
        <?php foreach($emps as $e): ?>
          <option value="<?= $e['id'] ?>" <?= $emp===$e['id']?'selected':'' ?>><?= htmlspecialchars($e['full_name']) ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="col-md-3">
      <button class="btn btn-primary">Filtrer</button>
      <a class="btn btn-outline-success" href="export.php?from=<?= urlencode($from) ?>&to=<?= urlencode($to) ?>&emp=<?= urlencode((string)$emp) ?>">Export CSV</a>
    </div>
  </form>

  <table class="table table-striped">
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
</body>
</html>
