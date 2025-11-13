<?php
require_once __DIR__ . '/../../includes/config.php';
require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../includes/attendance.php';
require_admin();

$today = date('Y-m-d');
$from_day = $_GET['day'] ?? $today;
$week_start = $_GET['week_start'] ?? date('Y-m-d', strtotime('monday this week'));
$week_end = date('Y-m-d 23:59:59', strtotime($week_start . ' +6 days'));

$daily = daily_totals($from_day);
$weekly = weekly_totals($week_start . ' 00:00:00', $week_end);

function fmt_minutes($m){ $h=floor($m/60); $r=$m%60; return sprintf('%02dh%02d', $h,$r); }
?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Totaux</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body class="container py-4">
  <h1>Totaux jour/semaine</h1>
  <div class="mb-3"><a class="btn btn-secondary" href="dashboard.php">Retour</a></div>

  <div class="row g-4">
    <div class="col-md-6">
      <h4>Jour</h4>
      <form class="row g-2 mb-2">
        <div class="col-8"><input class="form-control" type="date" name="day" value="<?= htmlspecialchars($from_day) ?>"></div>
        <div class="col-4"><button class="btn btn-primary">Voir</button></div>
      </form>
      <table class="table table-striped">
        <thead><tr><th>Employé</th><th>Minutes</th><th>HH:MM</th></tr></thead>
        <tbody>
          <?php foreach($daily as $d): $m=(int)$d['minutes']; ?>
            <tr><td><?= htmlspecialchars($d['full_name']) ?></td><td><?= $m ?></td><td><?= fmt_minutes($m) ?></td></tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
    <div class="col-md-6">
      <h4>Semaine</h4>
      <form class="row g-2 mb-2">
        <div class="col-6"><input class="form-control" type="date" name="week_start" value="<?= htmlspecialchars($week_start) ?>"></div>
        <div class="col-6"><button class="btn btn-primary">Voir</button></div>
      </form>
      <table class="table table-striped">
        <thead><tr><th>Employé</th><th>Minutes</th><th>HH:MM</th></tr></thead>
        <tbody>
          <?php foreach($weekly as $w): $m=(int)$w['minutes']; ?>
            <tr><td><?= htmlspecialchars($w['full_name']) ?></td><td><?= $m ?></td><td><?= fmt_minutes($m) ?></td></tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</body>
</html>
