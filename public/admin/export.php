<?php
require_once __DIR__ . '/../../includes/config.php';
require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../includes/attendance.php';
require_admin();

$from = $_GET['from'] ?? date('Y-m-01 00:00:00');
$to = $_GET['to'] ?? date('Y-m-d 23:59:59');
$emp = isset($_GET['emp']) && $_GET['emp'] !== '' ? (int)$_GET['emp'] : null;
$rows = attendance_for_date_range($from, $to, $emp);

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename="attendance.csv"');
$out = fopen('php://output', 'w');
fputcsv($out, ['Employé','Début','Fin','Minutes']);
foreach ($rows as $r) {
    fputcsv($out, [$r['full_name'], $r['started_at'], $r['ended_at'], (int)($r['minutes_worked'] ?? 0)]);
}
fclose($out);
