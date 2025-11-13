<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/attendance.php';
$page_title = 'Pointage QR';
require_once __DIR__ . '/../src/vue/partials/header.php';
require_once __DIR__ . '/../src/vue/partials/navbar_kiosk.php';

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
<div class="container py-4">
  <?php if ($flash): ?>
    <div class="alert alert-info auto-dismiss"><?= htmlspecialchars($flash) ?></div>
  <?php endif; ?>

  <div class="row g-4">
    <div class="col-md-7">
      <div class="card">
        <h4 class="mb-3">Scanner QR</h4>
        <div id="reader" style="width:100%"></div>
        <form id="qrForm" method="post" class="mt-3 d-flex gap-2">
          <input type="hidden" name="qr" id="qrField">
          <button class="btn btn-success" name="action" value="in" type="submit">Arriver</button>
          <button class="btn btn-danger" name="action" value="out" type="submit">Partir</button>
        </form>
      </div>
    </div>
    <div class="col-md-5">
      <div class="card">
        <h4 class="mb-2">Instructions</h4>
        <ul class="small-muted mb-0">
          <li>Présentez votre QR au lecteur.</li>
          <li>Arriver ouvre une session, Partir la clôture.</li>
        </ul>
      </div>
    </div>
  </div>
</div>
<script src="https://unpkg.com/html5-qrcode" defer></script>
<?php require_once __DIR__ . '/../src/vue/partials/footer.php'; ?>
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
