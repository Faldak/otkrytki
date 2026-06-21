<?php
declare(strict_types=1);

require_once __DIR__ . '/helpers.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    json_response(['ok' => false, 'message' => 'Метод не поддерживается'], 405);
}

require_admin();

$input = read_json_input();
$id = clean_text($input['id'] ?? '', 80);

if ($id === '') {
    json_response(['ok' => false, 'message' => 'Не указан номер заявки'], 422);
}

$orders = load_orders();
$found = false;

foreach ($orders as &$order) {
    if (($order['id'] ?? '') === $id) {
        if (!empty($order['confirmed'])) {
            json_response(['ok' => false, 'message' => 'Подтвержденную заявку нельзя отменить'], 409);
        }

        $order['status'] = 'Отменена';
        $order['cancelled'] = true;
        $order['cancelledAt'] = date(DATE_ATOM);
        $found = true;
        break;
    }
}
unset($order);

if (!$found) {
    json_response(['ok' => false, 'message' => 'Заявка не найдена'], 404);
}

save_orders($orders);
json_response(['ok' => true, 'message' => 'Заявка отменена']);

