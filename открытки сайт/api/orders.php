<?php
declare(strict_types=1);

require_once __DIR__ . '/helpers.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    json_response(['ok' => false, 'message' => 'Метод не поддерживается'], 405);
}

$input = read_json_input();
$required = ['category', 'template', 'clientName', 'phone', 'mainNames', 'eventDate', 'eventTime', 'address', 'city'];

foreach ($required as $field) {
    if (clean_text($input[$field] ?? '') === '') {
        json_response(['ok' => false, 'message' => 'Заполните обязательные поля'], 422);
    }
}

$order = [
    'id' => make_order_id(),
    'status' => 'Ждет оплаты',
    'confirmed' => false,
    'createdAt' => date(DATE_ATOM),
    'confirmedAt' => null,
    'category' => clean_text($input['category'] ?? '', 80),
    'template' => clean_text($input['template'] ?? '', 120),
    'templateId' => clean_text($input['templateId'] ?? '', 80),
    'inviteLanguage' => clean_text($input['inviteLanguage'] ?? 'kk', 10),
    'music' => clean_text($input['music'] ?? '', 120),
    'productType' => clean_text($input['productType'] ?? '', 80),
    'clientName' => clean_text($input['clientName'] ?? '', 120),
    'phone' => clean_text($input['phone'] ?? '', 80),
    'mainNames' => clean_text($input['mainNames'] ?? '', 160),
    'guestName' => clean_text($input['guestName'] ?? '', 160),
    'eventDate' => clean_text($input['eventDate'] ?? '', 40),
    'eventTime' => clean_text($input['eventTime'] ?? '', 40),
    'address'        => clean_text($input['address'] ?? '', 260),
    'city'           => clean_text($input['city'] ?? '', 120),
    'gisLink'        => clean_text($input['gisLink'] ?? '', 500),
    'organizerNames' => clean_text($input['organizerNames'] ?? '', 200),
    'customText'     => clean_text($input['customText'] ?? '', 2200),
    'price' => clean_text($input['price'] ?? '', 20),
    'oldPrice' => clean_text($input['oldPrice'] ?? '', 20),
];

$pricing = load_pricing();
$priceKey = pricing_key_for_order($order);
$order['pricingKey'] = $priceKey;
$order['isVip'] = is_vip_template_id($order['templateId']);
$order['price'] = (string) $pricing[$priceKey]['current'];
$order['oldPrice'] = (string) $pricing[$priceKey]['old'];

$uploadDir = __DIR__ . '/../uploads/orders/' . $order['id'];
$publicDir = 'uploads/orders/' . $order['id'];

if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0775, true);
}

if (!empty($_FILES['customMusic']['tmp_name']) && is_uploaded_file($_FILES['customMusic']['tmp_name'])) {
    $name = basename((string) $_FILES['customMusic']['name']);
    $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
    if (in_array($ext, ['mp3', 'wav', 'm4a', 'ogg', 'aac'], true)) {
        $target = $uploadDir . '/music.' . $ext;
        if (move_uploaded_file($_FILES['customMusic']['tmp_name'], $target)) {
            $order['customMusicPath'] = $publicDir . '/music.' . $ext;
            $order['music'] = 'custom';
        }
    }
}

if (!empty($_FILES['customPhoto']['tmp_name']) && is_uploaded_file($_FILES['customPhoto']['tmp_name'])) {
    $name = basename((string) $_FILES['customPhoto']['name']);
    $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
    if (in_array($ext, ['jpg', 'jpeg', 'png', 'webp'], true)) {
        $target = $uploadDir . '/photo.' . $ext;
        if (move_uploaded_file($_FILES['customPhoto']['tmp_name'], $target)) {
            $order['customPhotoPath'] = $publicDir . '/photo.' . $ext;
        }
    }
}

$orders = load_orders();
array_unshift($orders, $order);
save_orders($orders);

json_response(['ok' => true, 'order' => $order], 201);
