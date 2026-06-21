<?php
declare(strict_types=1);

require_once __DIR__ . '/helpers.php';
require_once __DIR__ . '/template-data.php';

function find_order_by_token(string $token, string $type): ?array
{
    foreach (load_orders() as $order) {
        if (($order['resultToken'] ?? '') === $token && ($order['resultType'] ?? '') === $type) {
            return $order;
        }
    }
    return null;
}
