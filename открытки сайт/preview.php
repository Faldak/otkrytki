<?php
declare(strict_types=1);
require_once __DIR__ . '/api/helpers.php';
require_once __DIR__ . '/api/template-data.php';
require_once __DIR__ . '/api/invite-i18n.php';
require_once __DIR__ . '/api/invite-layouts.php';

function card_photo_url(string $photo): string
{
    if ($photo === '' || preg_match('#^(https?://|data:)#i', $photo)) {
        return $photo;
    }
    return base_url() . '/' . ltrim($photo, '/');
}

$templateId = clean_text($_GET['templateId'] ?? 'uilenu-1', 80);
$lang = clean_text($_GET['lang'] ?? 'kk', 10);
$txt = invite_texts($lang);
$design = template_design($templateId);
$layout = $design['layout'] ?? 'split-elegance';

$hasCustomPhoto = false;
$photo = (string) ($design['photo'] ?? '');

$mainNames = clean_text($_GET['mainNames'] ?? '', 160);
$dear = clean_text($_GET['guestName'] ?? '', 160);
if ($dear === '') {
    $dear = $lang === 'ru' ? 'Дорогие гости' : ($lang === 'uz' ? 'Hurmatli mehmonlar' : 'Құрметті қонақтар');
}
$message = clean_text($_GET['customText'] ?? '', 2200);
if ($message === '') {
    $message = $design['intro'] ?? '';
}
$city = clean_text($_GET['city'] ?? '', 120);
$address = clean_text($_GET['address'] ?? '', 260);
$fullAddress = implode(', ', array_filter([$city, $address]));

$rawGis = !empty($_GET['gisLink']) ? (string) $_GET['gisLink'] : '';
if ($rawGis !== '') {
    if (preg_match('/(https?:\/\/\S+)/i', $rawGis, $m)) {
        $mapUrl = $m[1];
    } elseif (preg_match('/^(2gis|gis)\./i', $rawGis)) {
        $mapUrl = 'https://' . $rawGis;
    } else {
        $mapUrl = 'https://2gis.kz/search/' . rawurlencode($rawGis);
    }
} else {
    $mapUrl = 'https://2gis.kz/search/' . rawurlencode($fullAddress);
}

$music = clean_text($_GET['music'] ?? '', 120);
$musicPath = music_track_path($music, $templateId);

$ctx = [
    'lang' => $lang,
    'txt' => $txt,
    'templateId' => $templateId,
    'layout' => $layout,
    'category' => $_GET['category'] ?? '',
    'mainNames' => $mainNames,
    'dear' => $dear,
    'message' => $message,
    'eventDate' => $_GET['eventDate'] ?? '',
    'eventTime' => $_GET['eventTime'] ?? '',
    'address' => $fullAddress,
    'mapUrl' => $mapUrl,
    'whatsappUrl' => '#',
    'musicPath' => $musicPath,
    'organizerNames' => clean_text($_GET['organizerNames'] ?? '', 200),
];
?>
<!doctype html>
<html lang="<?= e($lang) ?>">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Preview</title>
  <link rel="stylesheet" href="css/result.css?v=260614-kelshi">
  <style>
    /* Prevent links from navigating in preview */
    a[href]:not([href="#"]) { pointer-events: none; }
    /* Keep music and open button working */
    #openInvite, .music-toggle, .floating-music { pointer-events: auto !important; }
    /* No padding-bottom since no action bar in preview */
    .invite-page { padding-bottom: 0 !important; }

    /* "НЕ ОПЛАЧЕНО" watermark overlay */
    .preview-watermark {
      position: fixed;
      inset: 0;
      z-index: 99999;
      pointer-events: none;
      overflow: hidden;
    }
    .preview-watermark::before {
      content: attr(data-text);
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%) rotate(-35deg);
      font-family: 'Montserrat', Arial, sans-serif;
      font-size: clamp(2.5rem, 8vw, 5rem);
      font-weight: 900;
      color: rgba(200, 50, 50, 0.18);
      white-space: nowrap;
      letter-spacing: 0.1em;
      text-transform: uppercase;
      user-select: none;
    }
    .preview-watermark::after {
      content: attr(data-text);
      position: absolute;
      top: 18%;
      left: 50%;
      transform: translate(-50%, -50%) rotate(-35deg);
      font-family: 'Montserrat', Arial, sans-serif;
      font-size: clamp(2rem, 6vw, 3.5rem);
      font-weight: 900;
      color: rgba(200, 50, 50, 0.12);
      white-space: nowrap;
      letter-spacing: 0.1em;
      text-transform: uppercase;
      user-select: none;
    }
  </style>
</head>
<?php
$isPreview = !empty($_GET['preview']);
$watermarkText = 'ТӨЛЕНГЕН ЖОҚ';
if ($lang === 'ru') $watermarkText = 'НЕ ОПЛАЧЕНО';
elseif ($lang === 'uz') $watermarkText = "TO'LANMAGAN";
?>
<body class="invite-body theme-<?= e((string) $design['style']) ?> layout-<?= e((string) $layout) ?> tpl-<?= e($templateId) ?><?= $layout === 'vip-calligraphy' ? ' vip-template' : '' ?>">
  <?php if ($isPreview): ?>
    <div class="preview-watermark" data-text="<?= e($watermarkText) ?>"></div>
  <?php endif; ?>
  <main class="invite-page" data-photo="<?= e(card_photo_url($photo)) ?>" style="--hero-photo: url('<?= e(card_photo_url($photo)) ?>')">
    <section class="opening-cover" id="closedCover">
      <div class="opening-card">
        <span class="opening-sheet" aria-hidden="true"></span>
        <span><?= e((string) ($ctx['category'] ?: 'Шақыру')) ?></span>
        <h1><?= e($mainNames ?: 'Дидар & Дана') ?></h1>
        <p><?= e($dear) ?></p>
        <button type="button" id="openInvite"><?= e($txt['open']) ?></button>
      </div>
    </section>

    <article class="invite-card">
      <?php render_invite_design($ctx); ?>
      <?php render_venue_hero($ctx); ?>
      <?php render_organizers($ctx); ?>
      <?php render_music_panel($ctx); ?>
      <?php render_rsvp($ctx); ?>
    </article>
  </main>
  <script>
    window.inviteOrderId = "PREVIEW";
    window.inviteWhatsapp = "77024667526";
  </script>
  <script src="js/result.js?v=260614-kelshi"></script>
</body>
</html>
