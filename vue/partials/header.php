<?php
if (!isset($page_title)) { $page_title = 'Application'; }
$assets_prefix = $assets_prefix ?? '';
?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= htmlspecialchars($page_title) ?></title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?= $assets_prefix ?>assets/styles.css">
  <script src="<?= $assets_prefix ?>assets/app.js" defer></script>
</head>
<body>
