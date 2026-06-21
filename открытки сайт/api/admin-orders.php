<?php
declare(strict_types=1);

require_once __DIR__ . '/helpers.php';

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    json_response(['ok' => false, 'message' => 'Метод не поддерживается'], 405);
}

require_admin();
json_response(['ok' => true, 'orders' => load_orders()]);

