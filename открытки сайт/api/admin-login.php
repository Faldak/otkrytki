<?php
declare(strict_types=1);

require_once __DIR__ . '/helpers.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../basqaru-7821.php');
    exit;
}

start_secure_session();

$username = clean_text($_POST['username'] ?? '', 80);
$password = (string) ($_POST['password'] ?? '');
$attempts = (int) ($_SESSION['login_attempts'] ?? 0);
$blockedUntil = (int) ($_SESSION['login_blocked_until'] ?? 0);

if ($blockedUntil > time()) {
    $_SESSION['login_error'] = 'Слишком много попыток. Попробуйте позже';
    header('Location: ../basqaru-7821.php');
    exit;
}

if (verify_admin_login($username, $password)) {
    session_regenerate_id(true);
    $_SESSION['admin_logged_in'] = true;
    $_SESSION['admin_username'] = ADMIN_USERNAME;
    unset($_SESSION['login_attempts'], $_SESSION['login_blocked_until']);
    header('Location: ../basqaru-7821.php');
    exit;
}

$attempts++;
$_SESSION['login_attempts'] = $attempts;
if ($attempts >= 5) {
    $_SESSION['login_blocked_until'] = time() + 600;
    $_SESSION['login_attempts'] = 0;
}

$_SESSION['login_error'] = 'Неверный логин или пароль';
header('Location: ../basqaru-7821.php');
exit;
