<?php
declare(strict_types=1);

require_once __DIR__ . '/helpers.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    json_response(['ok' => false, 'message' => 'Метод не поддерживается'], 405);
}

require_admin();

$input = read_json_input();
$deleteAll = !empty($input['all']);
$ids = $input['ids'] ?? [];

if (!$deleteAll && !is_array($ids)) {
    json_response(['ok' => false, 'message' => 'Нужно выбрать заявки'], 422);
}

$ids = array_values(array_filter(array_map(
    static fn ($id): string => clean_text($id, 80),
    is_array($ids) ? $ids : []
)));
$selected = array_flip($ids);

if (!$deleteAll && !$selected) {
    json_response(['ok' => false, 'message' => 'Нужно выбрать заявки'], 422);
}

$orders = load_orders();
$remaining = [];
$deleted = 0;

foreach ($orders as $order) {
    $orderId = (string) ($order['id'] ?? '');
    $shouldDelete = $deleteAll || isset($selected[$orderId]);

    if ($shouldDelete) {
        delete_order_files($order);
        $deleted++;
        continue;
    }

    $remaining[] = $order;
}

save_orders($remaining);

json_response([
    'ok' => true,
    'deleted' => $deleted,
    'remaining' => count($remaining),
]);
