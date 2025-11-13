<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/attendance.php';

$flash = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = trim($_POST['qr'] ?? '');
    $action = $_POST['action'] ?? '';
    if ($token && $action === 'in') {
        $res = check_in_with_token($token);
        $flash = $res['msg'];
    } elseif ($token && $action === 'out') {
        $res = check_out_with_token($token);
        $flash = $res['msg'];
    } else {
        $flash = 'Action invalide';
    }
}
?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Pointage QR</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
  <script src="https://unpkg.com/html5-qrcode" defer></script>
  <style>body{padding:20px}</style>
</head>
<body>
<div class="container">
  <h1 class="mb-3">Pointage employés</h1>
  <?php if ($flash): ?>
    <div class="alert alert-info"><?= htmlspecialchars($flash) ?></div>
  <?php endif; ?>

  <div class="row g-4">
    <div class="col-md-6">
      <h4>Scanner QR</h4>
      <div id="reader" style="width:100%"></div>
      <form id="qrForm" method="post" class="mt-3">
        <input type="hidden" name="qr" id="qrField">
        <div class="btn-group">
          <button class="btn btn-success" name="action" value="in" type="submit">Arriver</button>
          <button class="btn btn-danger" name="action" value="out" type="submit">Partir</button>
        </div>
      </form>
    </div>
    <div class="col-md-6">
      <h4>Accès admin</h4>
      <a class="btn btn-secondary" href="admin/login.php">Espace admin</a>
    </div>
  </div>
</div>
<script>
window.addEventListener('load', () => {
  const qrField = document.getElementById('qrField');
  const form = document.getElementById('qrForm');
  function onScanSuccess(decodedText){ qrField.value = decodedText; }
  const html5QrcodeScanner = new Html5QrcodeScanner('reader', { fps: 10, qrbox: 250 });
  html5QrcodeScanner.render(onScanSuccess);
});
</script>
</body>
</html>
