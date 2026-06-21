<?php
declare(strict_types=1);
require_once __DIR__ . '/api/helpers.php';
require_once __DIR__ . '/api/template-data.php';
require_once __DIR__ . '/api/invite-i18n.php';
require_once __DIR__ . '/api/invite-layouts.php';

$templateId = clean_text($_GET['template'] ?? 'uilenu-1', 80);
$lang = clean_text($_GET['lang'] ?? 'kk', 10);
$txt = invite_texts($lang);
$design = template_design($templateId);
$layout = $design['layout'] ?? 'split-elegance';
$sampleNames = $lang === 'ru' ? 'Дидар и Дана' : ($lang === 'uz' ? 'Dilshod va Malika' : 'Дидар мен Дана');
if (str_starts_with($templateId, 'sundet-')) {
    $sampleNames = $lang === 'uz' ? 'Alixon' : 'Алихан';
} elseif (str_starts_with($templateId, 'besik-')) {
    $sampleNames = $lang === 'uz' ? 'Ayla' : 'Аяла';
} elseif (str_starts_with($templateId, 'merey-')) {
    $sampleNames = $lang === 'ru' ? 'Вечер уважения' : ($lang === 'uz' ? 'Qadr kechasi' : 'Құрмет кеші');
} elseif (str_starts_with($templateId, 'asberu-')) {
    $sampleNames = $lang === 'ru' ? 'Поминальный дастархан' : ($lang === 'uz' ? 'Ehson dasturxoni' : 'Ас беру');
}
$sampleAddress = $lang === 'ru' ? 'Алматы, пример адреса' : ($lang === 'uz' ? 'Almaty, manzil namunasi' : 'Алматы, мысал мекенжай');
$sampleCategory = $lang === 'ru' ? 'Пример' : ($lang === 'uz' ? 'Namuna' : 'Мысал');
$sampleMusicName = '';
if (str_starts_with($templateId, 'uilenu-')) {
    $sampleMusicName = 'MOLDANAZAR - Mahabbatym';
} elseif (str_starts_with($templateId, 'sundet-')) {
    $sampleMusicName = 'Ерке сылқым';
} elseif (str_starts_with($templateId, 'besik-')) {
    $sampleMusicName = 'Қызым';
} elseif (str_starts_with($templateId, 'merey-')) {
    $sampleMusicName = 'Дос-Мұқасан - Той жыры';
} elseif (str_starts_with($templateId, 'asberu-')) {
    $sampleMusicName = 'Елу жас';
}
$sampleMusicPath = $sampleMusicName !== '' ? music_track_path($sampleMusicName, $templateId) : '';

// Demo date: 30 days from now
$targetDate = date('Y-m-d', strtotime('+30 days'));
$eventTimeDemo = '18:00';

$ctx = [
    'lang' => $lang,
    'txt' => $txt,
    'templateId' => $templateId,
    'layout' => $layout,
    'category' => $sampleCategory,
    'mainNames' => $sampleNames,
    'dear' => $txt['dear'],
    'message' => $txt['exampleBody'],
    'eventDate' => $targetDate,
    'eventTime' => $eventTimeDemo,
    'address' => $sampleAddress,
    'mapUrl' => 'https://2gis.kz',
    'whatsappUrl' => 'https://wa.me/77024667526',
    'musicPath' => $sampleMusicPath,
    'organizerNames' => $lang === 'ru' ? 'Семья Сапара и Айгерим' : ($lang === 'uz' ? 'Sapar va Aigerim oilasi' : 'Сапар мен Айгерім отбасы'),
];

// UI labels
$backLabel  = $lang === 'ru' ? '← Назад'              : ($lang === 'uz' ? '← Orqaga'       : '← Артқа');
$orderLabel = $lang === 'ru' ? 'Заказать этот шаблон' : ($lang === 'uz' ? 'Buyurtma berish' : 'Тапсырыс беру');
$sampleNotice = $lang === 'ru'
    ? 'Это демо-пример. В вашем приглашении будут ваши имена, дата и место.'
    : ($lang === 'uz'
        ? 'Bu demo namuna. Sizning taklifnomangizda o\'z ma\'lumotlaringiz bo\'ladi.'
        : 'Бұл демо мысал. Сіздің шақыруыңызда сіздің деректеріңіз болады.');
$bannerText = $lang === 'ru' ? 'Понравился шаблон?' : ($lang === 'uz' ? 'Shablon yoqdimi?' : 'Үлгі ұнады ма?');
?>
<!doctype html>
<html lang="<?= e($lang) ?>">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= e($sampleNames) ?> — toigakel</title>
  <link rel="icon" href="assets/images/toigakel-swan.png">
  <link rel="stylesheet" href="css/result.css?v=260614-kelshi">
</head>
<body class="invite-body theme-<?= e((string) $design['style']) ?> layout-<?= e((string) $layout) ?> tpl-<?= e($templateId) ?><?= $layout === 'vip-calligraphy' ? ' vip-template' : '' ?>">
  <main class="invite-page" data-photo="<?= e((string) $design['photo']) ?>" style="--hero-photo: url('<?= e((string) $design['photo']) ?>')">

    <!-- Top banner bar (kelshi-style) -->
    <div class="example-top-banner">
      <span><?= e($bannerText) ?></span>
      <div class="example-top-banner-btns">
        <button class="order-btn" type="button" id="exampleOrderBtn">
          <?= e($orderLabel) ?>
        </button>
      </div>
    </div>

    <!-- Sample notice -->
    <div class="sample-notice"><?= e($sampleNotice) ?></div>

    <!-- Envelope open animation -->
    <section class="opening-cover" id="closedCover">
      <div class="opening-card">
        <span class="opening-sheet" aria-hidden="true"></span>
        <span><?= e($sampleCategory) ?></span>
        <h1><?= e($sampleNames) ?></h1>
        <p><?= e($txt['dear']) ?></p>
        <button type="button" id="openInvite"><?= e($txt['open']) ?></button>
      </div>
    </section>

    <article class="invite-card">
      <?php render_invite_design($ctx); ?>
      <?php render_venue_hero($ctx); ?>
      <?php render_organizers($ctx); ?>
      <?php render_music_panel($ctx); ?>
      <?php render_rsvp($ctx); ?>
      <?php if (!empty($design['source'])): ?>
        <footer class="invite-footer">
          <a class="photo-credit" href="<?= e((string) $design['source']) ?>" target="_blank" rel="noreferrer">Photo source</a>
        </footer>
      <?php endif; ?>
    </article>
  </main>

  <!-- Bottom action bar removed — covered music button -->

  <script>
    window.inviteOrderId = "DEMO";
    window.inviteWhatsapp = "77024667526";

    // Order button logic — passes control back to main page
    function handleOrder() {
      var templateId = "<?= e($templateId) ?>";
      var lang = "<?= e($lang) ?>";
      if (window.opener && !window.opener.closed) {
        window.opener.focus();
        if (typeof window.opener.openOrderFromExample === 'function') {
          window.opener.openOrderFromExample(templateId);
        } else {
          window.opener.location.href = '/?order=' + encodeURIComponent(templateId) + '&lang=' + encodeURIComponent(lang);
        }
        window.close();
      } else {
        window.location.href = '/?order=' + encodeURIComponent(templateId) + '&lang=' + encodeURIComponent(lang);
      }
    }
    document.getElementById('exampleOrderBtn').addEventListener('click', handleOrder);
    // exampleOrderBtn2 removed (bottom bar deleted)
  </script>
  <script src="js/result.js?v=260614-kelshi"></script>
</body>
</html>
