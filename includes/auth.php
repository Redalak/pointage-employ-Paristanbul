<?php
function require_admin() {
    if (empty($_SESSION['is_admin'])) {
        header('Location: login.php');
        exit;
    }
}

function handle_admin_login() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $password = $_POST['password'] ?? '';
        if ($password === ADMIN_PASSWORD) {
            $_SESSION['is_admin'] = true;
            header('Location: dashboard.php');
            exit;
        }
        $error = 'Mot de passe invalide';
        return $error;
    }
    return null;
}
