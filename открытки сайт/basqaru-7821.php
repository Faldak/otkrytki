<?php
declare(strict_types=1);
require_once __DIR__ . '/api/helpers.php';
start_secure_session();
$isLoggedIn = admin_logged_in();
$loginError = $_SESSION['login_error'] ?? '';
unset($_SESSION['login_error']);
?>
<!doctype html>
<html lang="ru">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>toigakel - админка</title>
  <link rel="icon" type="image/png" href="assets/images/toigakel-swan.png?v=260611-toigakel">
  <link rel="apple-touch-icon" href="assets/images/toigakel-swan.png?v=260611-toigakel">
  <link rel="stylesheet" href="css/admin.css?v=260607-vip-pricing">
</head>
<body>
  <main class="admin-shell">
    <?php if (!$isLoggedIn): ?>
      <section class="login-panel">
        <p class="eyebrow">Жабық басқару</p>
        <h1>Вход в админку</h1>
        <p>Эта страница не связана с главным сайтом и доступна только по скрытому адресу.</p>
        <?php if ($loginError): ?>
          <div class="error-box"><?= htmlspecialchars($loginError, ENT_QUOTES, 'UTF-8') ?></div>
        <?php endif; ?>
        <form method="post" action="api/admin-login.php">
          <label>
            Логин
            <input name="username" type="text" autocomplete="username" required>
          </label>
          <label>
            Пароль
            <input name="password" type="password" autocomplete="current-password" required>
          </label>
          <button type="submit">Войти</button>
        </form>
      </section>
    <?php else: ?>
      <section class="admin-panel">
        <header class="admin-header">
          <div>
            <p class="eyebrow">toigakel</p>
            <h1>Заявки клиентов</h1>
          </div>
          <a class="logout-link" href="api/admin-logout.php">Выйти</a>
        </header>

        <div class="toolbar">
          <button id="refreshOrders" type="button">Обновить</button>
          <button id="deleteSelectedOrders" class="danger-light" type="button" disabled>Удалить выбранные</button>
          <button id="clearAllOrders" class="danger-action" type="button">Очистить все</button>
          <span id="ordersStatus">Загрузка заявок...</span>
        </div>

        <section class="pricing-panel">
          <div>
            <p class="eyebrow">Цены</p>
            <h2>Управление ценами и скидками</h2>
          </div>
          <form id="pricingForm" class="pricing-form">
            <label>
              Веб-открытка сейчас
              <input id="webPrice" name="webPrice" type="number" min="1" step="1" value="590">
            </label>
            <label>
              Веб-открытка было
              <input id="webOldPrice" name="webOldPrice" type="number" min="1" step="1" value="1990">
            </label>
            <div class="pricing-divider">VIP открытки</div>
            <label>
              VIP веб сейчас
              <input id="vipWebPrice" name="vipWebPrice" type="number" min="1" step="1" value="990">
            </label>
            <label>
              VIP веб было
              <input id="vipWebOldPrice" name="vipWebOldPrice" type="number" min="1" step="1" value="2990">
            </label>
            <button type="submit">Сохранить цены</button>
            <span id="pricingStatus">Цены загружаются...</span>
          </form>
        </section>

        <div class="orders-list" id="ordersList"></div>
      </section>
      <script src="js/admin.js?v=260607-vip-pricing"></script>
    <?php endif; ?>
  </main>
</body>
</html>
