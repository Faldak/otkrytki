<?php
declare(strict_types=1);

function invite_texts(string $lang): array
{
    $all = [
        'kk' => [
            'save' => 'Сілтемені сақтап қойыңыз.',
            'saveText' => 'Басты сайт дайын шақырулар тізімін көрсетпейді. Егер сілтемені жоғалтсаңыз, WhatsApp арқылы тапсырыс нөмірін жазыңыз.',
            'open' => 'Шақыруды ашу',
            'dear' => 'Құрметті қонақтар',
            'date' => 'Күні',
            'time' => 'Уақыты',
            'address' => 'Мекенжай',
            'map' => '2GIS арқылы ашу',
            'reply' => 'Жауап беру',
            'replyText' => 'Келе алатыныңызды WhatsApp арқылы хабарлаңыз.',
            'replyButton' => 'WhatsApp арқылы жауап беру',
            'musicOn' => 'Музыканы қосу',
            'musicOff' => 'Музыканы тоқтату',
            'noMusic' => 'Музыка файлы кейін қосылады',
            'exampleTitle' => 'Шақыру осылай көрінеді',
            'exampleBody' => 'Бұл жалпы мысал. Нақты тапсырыста есімдер, күн, мекенжай, музыка және фото ауысады.',
            'order' => 'Тапсырыс нөмірі',
            'notFound' => 'Шақыру табылмады',
        ],
        'uz' => [
            'save' => 'Havolani saqlab qoʻying.',
            'saveText' => 'Asosiy sayt tayyor taklifnomalar roʻyxatini koʻrsatmaydi. Havolani yoʻqotsangiz, WhatsApp orqali buyurtma raqamini yozing.',
            'open' => 'Taklifnomani ochish',
            'dear' => 'Hurmatli mehmonlar',
            'date' => 'Sana',
            'time' => 'Vaqt',
            'address' => 'Manzil',
            'map' => '2GIS orqali ochish',
            'reply' => 'Javob berish',
            'replyText' => 'Kelishingizni WhatsApp orqali xabar qiling.',
            'replyButton' => 'WhatsApp orqali javob berish',
            'musicOn' => 'Musiqani yoqish',
            'musicOff' => 'Musiqani toʻxtatish',
            'noMusic' => 'Musiqa fayli keyin qoʻshiladi',
            'exampleTitle' => 'Taklifnoma shunday ko‘rinadi',
            'exampleBody' => 'Bu umumiy namuna. Haqiqiy buyurtmada ismlar, sana, manzil, musiqa va rasm almashadi.',
            'order' => 'Buyurtma raqami',
            'notFound' => 'Taklifnoma topilmadi',
        ],
        'ru' => [
            'save' => 'Сохраните эту ссылку.',
            'saveText' => 'Главный сайт не показывает список готовых приглашений. Если потеряете ссылку, напишите в WhatsApp номер заказа.',
            'open' => 'Открыть приглашение',
            'dear' => 'Дорогие гости',
            'date' => 'Дата',
            'time' => 'Время',
            'address' => 'Адрес',
            'map' => 'Открыть в 2GIS',
            'reply' => 'Ответить',
            'replyText' => 'Сообщите в WhatsApp, сможете ли вы прийти.',
            'replyButton' => 'Ответить в WhatsApp',
            'musicOn' => 'Включить музыку',
            'musicOff' => 'Остановить музыку',
            'noMusic' => 'Файл музыки будет добавлен позже',
            'exampleTitle' => 'Вот так будет выглядеть открытка',
            'exampleBody' => 'Это общий пример. В настоящем заказе изменятся имена, дата, адрес, музыка и фото.',
            'order' => 'Номер заказа',
            'notFound' => 'Приглашение не найдено',
        ],
    ];

    return $all[$lang] ?? $all['kk'];
}

function calendar_labels(string $lang): array
{
    if ($lang === 'ru') {
        return [
            'title' => 'Дата торжества',
            'months' => ['января', 'февраля', 'марта', 'апреля', 'мая', 'июня', 'июля', 'августа', 'сентября', 'октября', 'ноября', 'декабря'],
            'weekdays' => ['пн', 'вт', 'ср', 'чт', 'пт', 'сб', 'вс'],
        ];
    }
    if ($lang === 'uz') {
        return [
            'title' => 'Toʻy sanasi',
            'months' => ['yanvar', 'fevral', 'mart', 'aprel', 'may', 'iyun', 'iyul', 'avgust', 'sentabr', 'oktabr', 'noyabr', 'dekabr'],
            'weekdays' => ['du', 'se', 'cho', 'pa', 'ju', 'sha', 'ya'],
        ];
    }
    return [
        'title' => 'Той салтанаты',
        'months' => ['қаңтар', 'ақпан', 'наурыз', 'сәуір', 'мамыр', 'маусым', 'шілде', 'тамыз', 'қыркүйек', 'қазан', 'қараша', 'желтоқсан'],
        'weekdays' => ['дс', 'сс', 'ср', 'бс', 'жм', 'сб', 'жс'],
    ];
}

function render_calendar(string $dateValue, string $lang): string
{
    try {
        $date = new DateTimeImmutable($dateValue);
    } catch (Throwable) {
        $date = new DateTimeImmutable();
    }

    $labels = calendar_labels($lang);
    $first = $date->modify('first day of this month');
    $daysInMonth = (int) $date->format('t');
    $offset = (int) $first->format('N') - 1;
    $day = (int) $date->format('j');
    $month = $labels['months'][(int) $date->format('n') - 1] ?? '';
    $year = $date->format('Y');

    ob_start();
    ?>
    <section class="calendar-card">
      <p class="script-title"><?= htmlspecialchars((string) $labels['title'], ENT_QUOTES, 'UTF-8') ?></p>
      <h2><?= htmlspecialchars($day . ' ' . $month . ' ' . $year, ENT_QUOTES, 'UTF-8') ?></h2>
      <div class="calendar-grid weekdays">
        <?php foreach ($labels['weekdays'] as $weekday): ?>
          <span><?= htmlspecialchars($weekday, ENT_QUOTES, 'UTF-8') ?></span>
        <?php endforeach; ?>
      </div>
      <div class="calendar-grid days">
        <?php for ($i = 0; $i < $offset; $i++): ?>
          <span></span>
        <?php endfor; ?>
        <?php for ($i = 1; $i <= $daysInMonth; $i++): ?>
          <span class="<?= $i === $day ? 'selected-day' : '' ?>"><?= $i ?></span>
        <?php endfor; ?>
      </div>
    </section>
    <?php
    return (string) ob_get_clean();
}
