<?php
declare(strict_types=1);

require_once __DIR__ . '/helpers.php';

start_secure_session();
$_SESSION = [];
session_destroy();

header('Location: ../basqaru-7821.php');
exit;

