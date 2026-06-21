<?php
declare(strict_types=1);
require_once __DIR__ . '/api/result.php';
require_once __DIR__ . '/api/invite-i18n.php';
require_once __DIR__ . '/api/invite-layouts.php';

function card_photo_url(string $photo): string
{
    if ($photo === '' || preg_match('#^(https?://|data:)#i', $photo)) {
        return $photo;
    }

    return base_url() . '/' . ltrim($photo, '/');
}

$token = clean_text($_GET['token'] ?? '', 80);
$order = $token !== '' ? find_order_by_token($token, 'card') : null;

if (!$order) {
    http_response_code(404);
}

$lang = $order ? (string) ($order['inviteLanguage'] ?? 'kk') : 'kk';
$txt = invite_texts($lang);
$templateId = $order ? (string) ($order['templateId'] ?? '') : '';
$design = $order ? template_design($templateId) : null;
$layout = $design['layout'] ?? 'split-elegance';
$hasCustomPhoto = $order && !empty($order['customPhotoPath']);
$photo = $hasCustomPhoto ? (string) $order['customPhotoPath'] : (string) ($design['photo'] ?? '');
$photoCssUrl = card_photo_url($photo);
$mainNames = $order ? (string) $order['mainNames'] : '';
$dear = $order ? (string) ($order['guestName'] ?: $txt['dear']) : '';
$message = $order ? (string) ($order['customText'] ?: ($design['intro'] ?? '')) : '';
$city = $order ? (string) ($order['city'] ?? '') : '';
$addrVal = $order ? (string) ($order['address'] ?? '') : '';
$address = implode(', ', array_filter([$city, $addrVal]));
$rawGis = $order && !empty($order['gisLink']) ? (string) $order['gisLink'] : '';
if ($rawGis !== '') {
    // Extract actual URL if user pasted text + link together
    if (preg_match('/(https?:\/\/\S+)/i', $rawGis, $m)) {
        $mapUrl = $m[1];
    } elseif (preg_match('/^(2gis|gis)\./i', $rawGis)) {
        $mapUrl = 'https://' . $rawGis;
    } else {
        $mapUrl = 'https://2gis.kz/search/' . rawurlencode($rawGis);
    }
} else {
    $mapUrl = 'https://2gis.kz/search/' . rawurlencode($address);
}
$whatsappText = $order ? $txt['reply'] . ': ' . $order['id'] : '';
$replyPhone = '77024667526';
if ($order && !empty($order['phone'])) {
    $digits = preg_replace('/\D+/', '', (string) $order['phone']) ?? '';
    if (strlen($digits) === 11 && str_starts_with($digits, '8')) {
        $digits = '7' . substr($digits, 1);
    } elseif (strlen($digits) === 10) {
        $digits = '7' . $digits;
    }
    if (strlen($digits) >= 10) {
        $replyPhone = $digits;
    }
}
$whatsappUrl = 'https://wa.me/' . $replyPhone . '?text=' . rawurlencode($whatsappText);
$musicPath = '';
if ($order) {
    $musicPath = !empty($order['customMusicPath'])
        ? (string) $order['customMusicPath']
        : music_track_path((string) ($order['music'] ?? ''), $templateId);
}
$ctx = [
    'lang' => $lang,
    'txt' => $txt,
    'templateId' => $templateId,
    'layout' => $layout,
    'category' => $order['category'] ?? '',
    'mainNames' => $mainNames,
    'dear' => $dear,
    'message' => $message,
    'eventDate' => $order['eventDate'] ?? '',
    'eventTime' => $order['eventTime'] ?? '',
    'address' => $address,
    'mapUrl' => $mapUrl,
    'whatsappUrl' => $whatsappUrl,
    'musicPath' => $musicPath,
    'organizerNames' => $order ? (string) ($order['organizerNames'] ?? '') : '',
];
?>
<!doctype html>
<html lang="<?= e($lang) ?>">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= $order ? e($mainNames) : e($txt['notFound']) ?></title>
  <link rel="stylesheet" href="css/result.css?v=260614-kelshi">
</head>
<body class="<?= $order ? 'invite-body theme-' . e((string) $design['style']) . ' layout-' . e((string) $layout) . ' tpl-' . e($templateId) . ($layout === 'vip-calligraphy' ? ' vip-template' : '') . ($hasCustomPhoto ? ' has-custom-photo' : '') : '' ?>">
  <?php if (!$order): ?>
    <main class="not-found">
      <h1><?= e($txt['notFound']) ?></h1>
      <p><?= e($txt['saveText']) ?></p>
    </main>
  <?php else: ?>
    <main class="invite-page" style="--hero-photo: url('<?= e($photoCssUrl) ?>')">
      <section class="opening-cover" id="closedCover">
        <div class="opening-card">
          <span class="opening-sheet" aria-hidden="true"></span>
          <span><?= e((string) $order['category']) ?></span>
          <h1><?= e($mainNames) ?></h1>
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
        <footer class="invite-footer">
          <p><?= e($txt['order']) ?>: <?= e((string) $order['id']) ?></p>
          <?php if (!$hasCustomPhoto && !empty($design['source'])): ?>
            <a class="photo-credit" href="<?= e((string) $design['source']) ?>" target="_blank" rel="noreferrer">Photo source</a>
          <?php endif; ?>
        </footer>
      </article>
    </main>
    <script>
      window.inviteOrderId = <?= json_encode((string) $order['id'], JSON_UNESCAPED_UNICODE) ?>;
      window.inviteWhatsapp = <?= json_encode($replyPhone, JSON_UNESCAPED_UNICODE) ?>;
    </script>
    <script src="js/result.js?v=260614-kelshi"></script>
  <?php endif; ?>
</body>
</html>
