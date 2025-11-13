<?php
require_once __DIR__ . '/db.php';

function find_employee_by_qr($token) {
    global $pdo;
    $stmt = $pdo->prepare('SELECT * FROM employees WHERE qr_token = ? AND active = 1');
    $stmt->execute([$token]);
    return $stmt->fetch();
}

function open_session_for_employee($employee_id) {
    global $pdo;
    $stmt = $pdo->prepare('SELECT * FROM clock_sessions WHERE employee_id = ? AND ended_at IS NULL ORDER BY id DESC LIMIT 1');
    $stmt->execute([$employee_id]);
    return $stmt->fetch();
}

function check_in_with_token($token) {
    global $pdo;
    $emp = find_employee_by_qr($token);
    if (!$emp) return ['ok' => false, 'msg' => 'Employé introuvable ou inactif'];
    $open = open_session_for_employee($emp['id']);
    if ($open) return ['ok' => false, 'msg' => 'Session déjà ouverte. Faire Départ d\'abord'];
    $now = date('Y-m-d H:i:s');
    $day = date('Y-m-d');
    $stmt = $pdo->prepare('INSERT INTO clock_sessions (employee_id, day_date, started_at) VALUES (?,?,?)');
    $stmt->execute([$emp['id'], $day, $now]);
    return ['ok' => true, 'msg' => 'Arrivée enregistrée', 'employee' => $emp];
}

function check_out_with_token($token) {
    global $pdo;
    $emp = find_employee_by_qr($token);
    if (!$emp) return ['ok' => false, 'msg' => 'Employé introuvable ou inactif'];
    $open = open_session_for_employee($emp['id']);
    if (!$open) return ['ok' => false, 'msg' => 'Aucune session ouverte'];
    $now = new DateTime('now');
    $start = new DateTime($open['started_at']);
    $minutes = (int) round(($now->getTimestamp() - $start->getTimestamp()) / 60);
    $stmt = $pdo->prepare('UPDATE clock_sessions SET ended_at = ?, minutes_worked = ? WHERE id = ?');
    $stmt->execute([$now->format('Y-m-d H:i:s'), $minutes, $open['id']]);
    return ['ok' => true, 'msg' => 'Départ enregistré', 'employee' => $emp, 'minutes' => $minutes];
}

function list_employees() {
    global $pdo;
    return $pdo->query('SELECT * FROM employees ORDER BY full_name')->fetchAll();
}

function create_employee($name, $role) {
    global $pdo;
    $token = bin2hex(random_bytes(16));
    $stmt = $pdo->prepare('INSERT INTO employees (full_name, qr_token, role) VALUES (?,?,?)');
    $stmt->execute([$name, $token, $role]);
}

function update_employee($id, $name, $role, $active) {
    global $pdo;
    $stmt = $pdo->prepare('UPDATE employees SET full_name=?, role=?, active=? WHERE id=?');
    $stmt->execute([$name, $role, (int)$active, $id]);
}

function delete_employee($id) {
    global $pdo;
    $stmt = $pdo->prepare('DELETE FROM employees WHERE id=?');
    $stmt->execute([$id]);
}

function attendance_for_date_range($from, $to, $emp_id = null) {
    global $pdo;
    $params = [$from, $to];
    $sql = 'SELECT cs.*, e.full_name FROM clock_sessions cs JOIN employees e ON e.id = cs.employee_id WHERE cs.started_at BETWEEN ? AND ?';
    if ($emp_id) { $sql .= ' AND cs.employee_id = ?'; $params[] = $emp_id; }
    $sql .= ' ORDER BY cs.started_at DESC';
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll();
}

function daily_totals($date) {
    global $pdo;
    $stmt = $pdo->prepare('SELECT e.full_name, SUM(IFNULL(minutes_worked,0)) as minutes FROM clock_sessions cs JOIN employees e ON e.id=cs.employee_id WHERE cs.day_date = ? GROUP BY cs.employee_id ORDER BY e.full_name');
    $stmt->execute([$date]);
    return $stmt->fetchAll();
}

function weekly_totals($from, $to) {
    global $pdo;
    $stmt = $pdo->prepare('SELECT e.full_name, SUM(IFNULL(minutes_worked,0)) as minutes
        FROM clock_sessions cs
        JOIN employees e ON e.id = cs.employee_id
        WHERE cs.started_at BETWEEN ? AND ?
        GROUP BY cs.employee_id
        ORDER BY e.full_name');
    $stmt->execute([$from, $to]);
    return $stmt->fetchAll();
}
