<?php
declare(strict_types=1);

function e(mixed $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function invite_rsvp_labels(string $lang): array
{
    if ($lang === 'ru') {
        return ['title' => 'Дорогой гость, подтвердите присутствие', 'name' => 'имя', 'yes' => 'Да, я приду', 'family' => 'Приду с семьей', 'no' => 'К сожалению, не смогу прийти'];
    }
    if ($lang === 'uz') {
        return ['title' => 'Hurmatli mehmon, kelishingizni tasdiqlang', 'name' => 'ism', 'yes' => 'Ha, boraman', 'family' => 'Oilam bilan boraman', 'no' => 'Afsuski, bora olmayman'];
    }
    return ['title' => 'Құрметті қонақ, тойға келетініңізді растаңыз', 'name' => 'атыңыз', 'yes' => 'Иә, өзім барамын', 'family' => 'Отбасыммен келемін', 'no' => 'Өкінішке орай, келе алмаймын'];
}

function invite_time_title(string $lang): string
{
    return $lang === 'ru' ? 'Время и место' : ($lang === 'uz' ? 'Vaqt va manzil' : 'Басталу уақыты');
}

function invite_story_title(string $lang): string
{
    return $lang === 'ru' ? 'Приглашение' : ($lang === 'uz' ? 'Taklifnoma' : 'Шақыру');
}

function render_music_panel(array $ctx): void
{
    if (!$ctx['musicPath']) {
        return;
    }
    ?>
    <div class="floating-music" id="floatingMusic">
      <audio id="inviteAudio" src="<?= e($ctx['musicPath']) ?>" preload="auto" loop></audio>
      <button
        type="button"
        id="musicToggle"
        class="music-toggle"
        aria-label="<?= e($ctx['txt']['musicOn']) ?>"
        title="<?= e($ctx['txt']['musicOn']) ?>"
        data-play="<?= e($ctx['txt']['musicOn']) ?>"
        data-stop="<?= e($ctx['txt']['musicOff']) ?>"
      >
        <span class="music-play" aria-hidden="true"></span>
        <span class="music-pause" aria-hidden="true"></span>
      </button>
    </div>
    <?php
}

function render_rsvp(array $ctx): void
{
    $labels = invite_rsvp_labels($ctx['lang']);
    $submitLabel = $ctx['lang'] === 'ru' ? 'Отправить' : ($ctx['lang'] === 'uz' ? 'Yuborish' : 'Жауап беру');
    ?>
    <section class="rsvp-card">
      <h2><?= e($labels['title']) ?></h2>
      <input id="rsvpName" type="text" placeholder="<?= e($labels['name']) ?>">
      <button type="button" data-rsvp="<?= e($labels['yes']) ?>"><?= e($labels['yes']) ?></button>
      <button type="button" data-rsvp="<?= e($labels['family']) ?>"><?= e($labels['family']) ?></button>
      <button type="button" data-rsvp="<?= e($labels['no']) ?>"><?= e($labels['no']) ?></button>
      <button type="button" class="rsvp-submit" id="rsvpSubmit"><?= e($submitLabel) ?></button>
      <a id="rsvpWhatsapp" class="whatsapp-rsvp" href="<?= e($ctx['whatsappUrl']) ?>" target="_blank" rel="noreferrer"><?= e($ctx['txt']['replyButton']) ?></a>
    </section>
    <?php
}

function render_dresscode(array $ctx): void
{
    $colors = $ctx['dresscodeColors'] ?? ['#1a1a1a', '#c0392b', '#2c3e90', '#ecf0f1'];
    $title = 'Dress code';
    $text = $ctx['lang'] === 'ru'
        ? 'Уважаемые гости, просим прийти в красивой и элегантной одежде.'
        : ($ctx['lang'] === 'uz'
            ? 'Hurmatli mehmonlar, toʻyga chiroyli va tantanali kiyimda kelishingizni soʻraymiz.'
            : 'Құрметті қонақтар, тойға әдемі әрі салтанатты киіммен келулеріңізді сұраймыз.');
    ?>
    <section class="dresscode-section">
      <p class="script-title"><?= e($title) ?></p>
      <p class="dresscode-text"><?= e($text) ?></p>
      <div class="dresscode-colors">
        <?php foreach ($colors as $c): ?>
          <span class="dresscode-swatch" style="background:<?= e($c) ?>"></span>
        <?php endforeach; ?>
      </div>
    </section>
    <?php
}

function render_venue_hero(array $ctx): void
{
    $title = $ctx['lang'] === 'ru' ? 'Начало торжества' : ($ctx['lang'] === 'uz' ? 'Toʻy boshlanish vaqti' : 'Тойдың басталу уақыты');
    $mapLabel = $ctx['lang'] === 'ru' ? 'Перейти к карте' : ($ctx['lang'] === 'uz' ? 'Xaritaga oʻtish' : 'Картаға өту');
    ?>
    <section class="venue-hero">
      <p class="script-title"><?= e($title) ?></p>
      <?php if (!empty($ctx['eventDate'])): ?>
        <h2><?= e($ctx['eventDate']) ?></h2>
      <?php endif; ?>
      <?php if (!empty($ctx['eventTime'])): ?>
        <div class="venue-time"><?= e($ctx['eventTime']) ?></div>
      <?php endif; ?>
      <?php if (!empty($ctx['address'])): ?>
        <p class="venue-address"><?= e($ctx['address']) ?></p>
      <?php endif; ?>
      <?php if (!empty($ctx['mapUrl'])): ?>
        <a class="map-link" href="<?= e($ctx['mapUrl']) ?>" target="_blank" rel="noreferrer">
          <svg viewBox="0 0 24 24" width="20" height="20"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5S10.62 6.5 12 6.5s2.5 1.12 2.5 2.5S13.38 11.5 12 11.5z" fill="currentColor"/></svg>
          <?= e($mapLabel) ?>
        </a>
      <?php endif; ?>
    </section>
    <?php
}

function render_place(array $ctx, string $variant = 'plain'): void
{
    ?>
    <section class="time-place <?= e($variant) ?>">
      <p class="script-title"><?= e(invite_time_title($ctx['lang'])) ?></p>
      <h2><?= e($ctx['eventTime']) ?></h2>
      <p><?= e($ctx['address']) ?></p>
      <a class="action-link" href="<?= e($ctx['mapUrl']) ?>" target="_blank" rel="noreferrer"><?= e($ctx['txt']['map']) ?></a>
    </section>
    <?php
}

function render_date_stamp(array $ctx, string $variant = 'stamp'): void
{
    ?>
    <section class="date-stamp <?= e($variant) ?>">
      <span><?= e($ctx['txt']['date']) ?></span>
      <strong><?= e($ctx['eventDate']) ?></strong>
      <em><?= e($ctx['eventTime']) ?></em>
    </section>
    <?php
}

function render_story_block(array $ctx, string $className = 'story-block'): void
{
    ?>
    <section class="<?= e($className) ?>">
      <p class="kicker"><?= e(invite_story_title($ctx['lang'])) ?></p>
      <h2><?= e($ctx['dear']) ?></h2>
      <p><?= e($ctx['message']) ?></p>
    </section>
    <?php
}

function render_vip_calligraphy(array $ctx): void
{
    $parts = preg_split('/\s+(?:мен|және|и|&)\s+/u', $ctx['mainNames']) ?: [$ctx['mainNames']];
    $firstName = trim($parts[0] ?? $ctx['mainNames']);
    $secondName = trim($parts[1] ?? '');
    ?>
    <section class="vip-photo-strip">
      <div class="vip-photo-window"></div>
      <p><?= e($ctx['category']) ?></p>
    </section>
    <section class="vip-letter">
      <div class="vip-names">
        <span><?= e($firstName) ?></span>
        <i aria-hidden="true"></i>
        <span><?= e($secondName ?: $ctx['mainNames']) ?></span>
      </div>
      <p class="vip-date"><?= e($ctx['eventDate']) ?></p>
      <h2><?= e($ctx['dear']) ?></h2>
      <p class="vip-message"><?= e($ctx['message']) ?></p>
    </section>
    <?= render_calendar($ctx['eventDate'], $ctx['lang']) ?>
    <?php render_place($ctx, 'vip-place');
}

function render_split_elegance(array $ctx): void
{
    ?>
    <section class="split-invite">
      <div class="split-photo"></div>
      <div class="split-letter">
        <p class="kicker"><?= e($ctx['category']) ?></p>
        <h1><?= e($ctx['mainNames']) ?></h1>
        <p><?= e($ctx['message']) ?></p>
      </div>
    </section>
    <?php render_date_stamp($ctx, 'horizontal'); render_place($ctx, 'compact-place');
}

function render_floral_frame(array $ctx): void
{
    ?>
    <section class="floral-invite">
      <div class="floral-frame">
        <span class="ornament-line"></span>
        <p class="kicker"><?= e($ctx['category']) ?></p>
        <h1><?= e($ctx['mainNames']) ?></h1>
        <p><?= e($ctx['message']) ?></p>
      </div>
    </section>
    <?= render_calendar($ctx['eventDate'], $ctx['lang']) ?>
    <?php render_place($ctx, 'soft-place');
}

function render_banquet_classic(array $ctx): void
{
    ?>
    <section class="banquet-invite">
      <div class="banquet-photo"></div>
      <div class="banquet-card">
        <span><?= e($ctx['eventDate']) ?></span>
        <h1><?= e($ctx['mainNames']) ?></h1>
        <p><?= e($ctx['message']) ?></p>
      </div>
    </section>
    <?php render_place($ctx, 'classic-place');
}

function render_photo_poster(array $ctx): void
{
    ?>
    <section class="poster-invite">
      <div class="poster-copy">
        <p><?= e($ctx['category']) ?></p>
        <h1><?= e($ctx['mainNames']) ?></h1>
        <span><?= e($ctx['eventDate']) ?> / <?= e($ctx['eventTime']) ?></span>
      </div>
    </section>
    <?php render_story_block($ctx, 'poster-letter'); render_place($ctx, 'dark-place');
}

function render_golden_arch(array $ctx): void
{
    ?>
    <section class="arch-invite">
      <div class="arch-photo"></div>
      <div class="arch-copy">
        <p class="kicker"><?= e($ctx['category']) ?></p>
        <h1><?= e($ctx['mainNames']) ?></h1>
        <p><?= e($ctx['message']) ?></p>
      </div>
    </section>
    <?= render_calendar($ctx['eventDate'], $ctx['lang']) ?>
    <?php render_place($ctx, 'gold-place');
}

function render_evening_glow(array $ctx): void
{
    ?>
    <section class="night-invite">
      <p class="kicker"><?= e($ctx['category']) ?></p>
      <h1><?= e($ctx['mainNames']) ?></h1>
      <p><?= e($ctx['message']) ?></p>
      <div><?= e($ctx['eventDate']) ?> / <?= e($ctx['eventTime']) ?></div>
    </section>
    <?php render_place($ctx, 'night-place');
}

function render_child_layout(array $ctx): void
{
    ?>
    <section class="child-invite">
      <div class="child-ribbon"><?= e($ctx['category']) ?></div>
      <div class="child-photo"></div>
      <div class="child-note">
        <span><?= e($ctx['dear']) ?></span>
        <h1><?= e($ctx['mainNames']) ?></h1>
        <p><?= e($ctx['message']) ?></p>
      </div>
    </section>
    <?php render_date_stamp($ctx, 'bubble'); render_place($ctx, 'child-place');
}

function render_baby_layout(array $ctx): void
{
    ?>
    <section class="baby-invite">
      <div class="baby-photo"></div>
      <div class="baby-card">
        <p><?= e($ctx['category']) ?></p>
        <h1><?= e($ctx['mainNames']) ?></h1>
        <span><?= e($ctx['message']) ?></span>
      </div>
    </section>
    <?php render_date_stamp($ctx, 'cloud'); render_place($ctx, 'baby-place');
}

function render_jubilee_layout(array $ctx): void
{
    ?>
    <section class="jubilee-invite">
      <div class="jubilee-date"><?= e($ctx['eventDate']) ?></div>
      <h1><?= e($ctx['mainNames']) ?></h1>
      <p><?= e($ctx['message']) ?></p>
    </section>
    <?php render_place($ctx, 'jubilee-place');
}

function render_calm_layout(array $ctx): void
{
    ?>
    <section class="calm-invite">
      <div class="calm-photo"></div>
      <div class="calm-letter">
        <p><?= e($ctx['category']) ?></p>
        <h1><?= e($ctx['mainNames']) ?></h1>
        <span><?= e($ctx['message']) ?></span>
      </div>
    </section>
    <?php render_date_stamp($ctx, 'quiet'); render_place($ctx, 'calm-place');
}

function render_invite_design(array $ctx): void
{
    $layout = $ctx['layout'];
    if ($layout === 'vip-calligraphy') {
        render_vip_calligraphy($ctx);
    } elseif ($layout === 'split-elegance') {
        render_split_elegance($ctx);
    } elseif ($layout === 'floral-frame') {
        render_floral_frame($ctx);
    } elseif ($layout === 'banquet-classic') {
        render_banquet_classic($ctx);
    } elseif ($layout === 'photo-poster') {
        render_photo_poster($ctx);
    } elseif ($layout === 'golden-arch') {
        render_golden_arch($ctx);
    } elseif ($layout === 'evening-glow' || $layout === 'celebration-night') {
        render_evening_glow($ctx);
    } elseif (str_contains($layout, 'baby') || str_contains($layout, 'cradle')) {
        render_baby_layout($ctx);
    } elseif (str_contains($layout, 'boy') || str_contains($layout, 'playful') || str_contains($layout, 'ornament') || str_contains($layout, 'formal')) {
        render_child_layout($ctx);
    } elseif (str_contains($layout, 'jubilee') || str_contains($layout, 'dastarkhan')) {
        render_jubilee_layout($ctx);
    } elseif (str_contains($layout, 'calm') || str_contains($layout, 'guest') || str_contains($layout, 'white')) {
        render_calm_layout($ctx);
    } else {
        render_split_elegance($ctx);
    }
    // Обратный отсчёт — только для будущих дат
    if (!empty($ctx['eventDate'])) {
        render_countdown($ctx);
    }
}

function render_countdown(array $ctx): void
{
    $lang = $ctx['lang'];
    $title   = $lang === 'ru' ? 'До события осталось' : ($lang === 'uz' ? 'Tadbirgacha qoldi' : 'Тойға дейін');
    $dayLbl  = $lang === 'ru' ? 'дней'   : ($lang === 'uz' ? 'kun'     : 'күн');
    $hrLbl   = $lang === 'ru' ? 'часов'  : ($lang === 'uz' ? 'soat'    : 'сағат');
    $minLbl  = $lang === 'ru' ? 'минут'  : ($lang === 'uz' ? 'daqiqa'  : 'минут');
    $secLbl  = $lang === 'ru' ? 'секунд' : ($lang === 'uz' ? 'soniya'  : 'секунд');
    $eventDatetime = $ctx['eventDate'] . 'T' . ($ctx['eventTime'] ?: '18:00') . ':00';
    ?>
    <section class="countdown-section" id="countdownBlock">
      <h2 class="script-title"><?= e($title) ?></h2>
      <div class="countdown-grid">
        <div class="countdown-unit">
          <span class="countdown-number" id="cdDays">00</span>
          <span class="countdown-label"><?= e($dayLbl) ?></span>
        </div>
        <span class="countdown-separator">:</span>
        <div class="countdown-unit">
          <span class="countdown-number" id="cdHours">00</span>
          <span class="countdown-label"><?= e($hrLbl) ?></span>
        </div>
        <span class="countdown-separator">:</span>
        <div class="countdown-unit">
          <span class="countdown-number" id="cdMins">00</span>
          <span class="countdown-label"><?= e($minLbl) ?></span>
        </div>
        <span class="countdown-separator">:</span>
        <div class="countdown-unit">
          <span class="countdown-number" id="cdSecs">00</span>
          <span class="countdown-label"><?= e($secLbl) ?></span>
        </div>
      </div>
    </section>
    <script>
    (function() {
      var target = new Date("<?= e($eventDatetime) ?>");
      function tick() {
        var now = new Date(), diff = target - now;
        if (diff <= 0) { var el = document.getElementById('countdownBlock'); if(el) el.style.display='none'; return; }
        var d = Math.floor(diff/86400000), h = Math.floor((diff%86400000)/3600000),
            m = Math.floor((diff%3600000)/60000), s = Math.floor((diff%60000)/1000);
        function pad(n){ return String(n).padStart(2,'0'); }
        document.getElementById('cdDays').textContent  = pad(d);
        document.getElementById('cdHours').textContent = pad(h);
        document.getElementById('cdMins').textContent  = pad(m);
        document.getElementById('cdSecs').textContent  = pad(s);
      }
      tick(); setInterval(tick, 1000);
    })();
    </script>
    <?php
}

function render_organizers(array $ctx): void
{
    if (empty($ctx['organizerNames'])) {
        return;
    }
    $label = $ctx['lang'] === 'ru' ? 'Хозяева торжества' : ($ctx['lang'] === 'uz' ? 'Taklif qiluvchilar' : 'Той иелері');
    ?>
    <section class="organizers-card">
      <p class="script-title"><?= e($label) ?></p>
      <h3 class="organizers-names"><?= e($ctx['organizerNames']) ?></h3>
    </section>
    <?php
}
