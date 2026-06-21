<?php
declare(strict_types=1);

require_once __DIR__ . '/config.php';

function start_secure_session(): void
{
    if (session_status() === PHP_SESSION_ACTIVE) {
        return;
    }

    $secure = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off';
    session_set_cookie_params([
        'lifetime' => 0,
        'path' => '/',
        'secure' => $secure,
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
    session_start();
}

function json_response(array $data, int $status = 200): void
{
    http_response_code($status);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    exit;
}

function read_json_input(): array
{
    $raw = file_get_contents('php://input') ?: '';
    $data = json_decode($raw, true);
    return is_array($data) ? $data : $_POST;
}

function clean_text(mixed $value, int $maxLength = 500): string
{
    $text = trim((string) $value);
    $text = preg_replace('/\s+/u', ' ', $text) ?? '';
    if (function_exists('mb_substr')) {
        return mb_substr($text, 0, $maxLength, 'UTF-8');
    }
    return substr($text, 0, $maxLength);
}

function ensure_data_file(): void
{
    $dir = dirname(DATA_FILE);
    if (!is_dir($dir)) {
        mkdir($dir, 0775, true);
    }
    if (!file_exists(DATA_FILE)) {
        file_put_contents(DATA_FILE, "[]", LOCK_EX);
    }
}

function load_orders(): array
{
    ensure_data_file();
    $raw = file_get_contents(DATA_FILE);
    $orders = json_decode($raw ?: '[]', true);
    return is_array($orders) ? $orders : [];
}

function save_orders(array $orders): void
{
    ensure_data_file();
    file_put_contents(
        DATA_FILE,
        json_encode(array_values($orders), JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT),
        LOCK_EX
    );
}

function default_pricing(): array
{
    return [
        'web' => ['current' => 590, 'old' => 1990],
        'vipWeb' => ['current' => 990, 'old' => 2990],
    ];
}

function ensure_pricing_file(): void
{
    $dir = dirname(PRICING_FILE);
    if (!is_dir($dir)) {
        mkdir($dir, 0775, true);
    }

    if (!file_exists(PRICING_FILE)) {
        save_pricing(default_pricing());
    }
}

function normalize_price_value(mixed $value, int $fallback): int
{
    $price = (int) $value;
    return $price > 0 ? min($price, 999999) : $fallback;
}

function normalize_pricing(array $pricing): array
{
    $defaults = default_pricing();
    $normalized = [];

    foreach ($defaults as $key => $default) {
        $normalized[$key] = [
            'current' => normalize_price_value($pricing[$key]['current'] ?? null, $default['current']),
            'old' => normalize_price_value($pricing[$key]['old'] ?? null, $default['old']),
        ];
    }

    return $normalized;
}

function load_pricing(): array
{
    ensure_pricing_file();
    $raw = file_get_contents(PRICING_FILE);
    $pricing = json_decode($raw ?: '{}', true);
    return normalize_pricing(is_array($pricing) ? $pricing : []);
}

function save_pricing(array $pricing): void
{
    $dir = dirname(PRICING_FILE);
    if (!is_dir($dir)) {
        mkdir($dir, 0775, true);
    }

    file_put_contents(
        PRICING_FILE,
        json_encode(normalize_pricing($pricing), JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT),
        LOCK_EX
    );
}

function remove_directory_recursive(string $path): void
{
    if (!is_dir($path)) {
        return;
    }

    $items = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($path, FilesystemIterator::SKIP_DOTS),
        RecursiveIteratorIterator::CHILD_FIRST
    );

    foreach ($items as $item) {
        if ($item->isDir()) {
            rmdir($item->getPathname());
        } else {
            unlink($item->getPathname());
        }
    }

    rmdir($path);
}

function delete_order_files(array $order): void
{
    $id = clean_text($order['id'] ?? '', 80);
    if ($id === '' || !preg_match('/^[A-Za-z0-9_-]+$/', $id)) {
        return;
    }

    $uploadsRoot = realpath(__DIR__ . '/../uploads/orders');
    if ($uploadsRoot === false) {
        return;
    }

    $orderDir = realpath($uploadsRoot . DIRECTORY_SEPARATOR . $id);
    if ($orderDir === false || !is_dir($orderDir)) {
        return;
    }

    $rootPrefix = rtrim($uploadsRoot, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
    if (!str_starts_with($orderDir . DIRECTORY_SEPARATOR, $rootPrefix)) {
        return;
    }

    remove_directory_recursive($orderDir);
}

function make_order_id(): string
{
    return 'TS-' . date('ymd') . '-' . random_int(100, 999);
}

function make_result_token(): string
{
    return bin2hex(random_bytes(12));
}

function base_url(): string
{
    $https = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off';
    $scheme = $https ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'] ?? 'localhost:8000';
    $scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '/'));
    $root = preg_replace('#/api$#', '', $scriptDir) ?: '';
    return rtrim($scheme . '://' . $host . $root, '/');
}

function result_type_for_order(array $order): string
{
    return 'card';
}

function is_vip_template_id(string $templateId): bool
{
    return in_array($templateId, ['uilenu-1', 'uilenu-3', 'uilenu-6'], true);
}

function pricing_key_for_order(array $order): string
{
    $templateId = clean_text($order['templateId'] ?? '', 80);
    return is_vip_template_id($templateId) ? 'vipWeb' : 'web';
}

function result_path(string $type, string $token): string
{
    $page = 'card.php';
    return $page . '?token=' . rawurlencode($token);
}

function admin_logged_in(): bool
{
    start_secure_session();
    return !empty($_SESSION['admin_logged_in']);
}

function require_admin(): void
{
    if (!admin_logged_in()) {
        json_response(['ok' => false, 'message' => 'РўСЂРµР±СѓРµС‚СЃСЏ РІС…РѕРґ РІ Р°РґРјРёРЅРєСѓ'], 401);
    }
}


function public_url(string $path): string
{
    if ($path === '' || preg_match('#^https?://#i', $path)) {
        return $path;
    }

    return base_url() . '/' . ltrim($path, '/');
}

function verify_admin_login(string $username, string $password): bool
{
    if (!hash_equals(ADMIN_USERNAME, $username)) {
        return false;
    }

    $hash = hash('sha256', ADMIN_PASSWORD_SALT . $password);
    return hash_equals(ADMIN_PASSWORD_HASH, $hash);
}

