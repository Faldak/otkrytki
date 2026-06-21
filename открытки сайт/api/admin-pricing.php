<?php
declare(strict_types=1);

require_once __DIR__ . '/helpers.php';

require_admin();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    json_response(['ok' => true, 'pricing' => load_pricing()]);
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    json_response(['ok' => false, 'message' => 'Method not allowed'], 405);
}

$input = read_json_input();
$pricing = [
    'web' => [
        'current' => $input['web']['current'] ?? null,
        'old' => $input['web']['old'] ?? null,
    ],
    'vipWeb' => [
        'current' => $input['vipWeb']['current'] ?? null,
        'old' => $input['vipWeb']['old'] ?? null,
    ],
];

save_pricing($pricing);
json_response(['ok' => true, 'pricing' => load_pricing()]);
