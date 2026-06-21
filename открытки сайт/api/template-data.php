<?php
declare(strict_types=1);

function unsplash_image(string $id, int $width = 1800): string
{
    return "https://images.unsplash.com/{$id}?auto=format&fit=crop&w={$width}&q=84";
}

function template_designs(): array
{
    return [
        'uilenu-1' => [
            'style' => 'ink',
            'layout' => 'vip-calligraphy',
            'photo' => unsplash_image('photo-1519741497674-611481863552'),
            'source' => 'https://unsplash.com/',
            'intro' => 'Ағайын-туыс, бауырлар, құда-жекжат, нағашы-жиен, дос-жарандар! Сіздерді ұлымыз бен келініміздің үйлену тойына арналған ақ дастарханымыздың қадірлі қонағы болуға шақырамыз.',
        ],
        'uilenu-2' => [
            'style' => 'ivory',
            'layout' => 'split-elegance',
            'photo' => unsplash_image('photo-1523438885200-e635ba2c371e'),
            'source' => 'https://unsplash.com/',
            'intro' => 'Ақ отауымыздың алғашқы қуанышын бірге бөлісіп, жас жұпқа ақ тілегіңізді арнауыңызды қалаймыз.',
        ],
        'uilenu-3' => [
            'style' => 'floral',
            'layout' => 'floral-frame',
            'photo' => unsplash_image('photo-1469371670807-013ccf25f16a'),
            'source' => 'https://unsplash.com/',
            'intro' => 'Екі жүректің қуанышты күніне ортақ болып, шаттығымызды бірге бөлісуге шақырамыз.',
        ],
        'uilenu-4' => [
            'style' => 'classic',
            'layout' => 'banquet-classic',
            'photo' => unsplash_image('photo-1511795409834-ef04bbd61622'),
            'source' => 'https://unsplash.com/',
            'intro' => 'Жібек жолындай жарасымды тойымызда қадірлі қонағымыз болып, төрімізден орын алыңыз.',
        ],
        'uilenu-5' => [
            'style' => 'rose',
            'layout' => 'photo-poster',
            'photo' => unsplash_image('photo-1522673607200-164d1b6ce486'),
            'source' => 'https://unsplash.com/',
            'intro' => 'Шашу шашылып, ақ тілектер айтылатын қуанышты күнімізге шын жүректен шақырамыз.',
        ],
        'uilenu-6' => [
            'style' => 'gold',
            'layout' => 'golden-arch',
            'photo' => unsplash_image('photo-1507504031003-b417219a0fde'),
            'source' => 'https://unsplash.com/',
            'intro' => 'Алтын сақинадай берік одақтың бастауына куә болып, ақ батаңызды беріңіз.',
        ],
        'uilenu-7' => [
            'style' => 'night',
            'layout' => 'evening-glow',
            'photo' => unsplash_image('photo-1492684223066-81342ee5ff30'),
            'source' => 'https://unsplash.com/',
            'intro' => 'Нұрлы кешіміздің қадірлі қонағы болып, қуанышымызды бірге бөлісіңіз.',
        ],
        'sundet-1' => [
            'style' => 'sunny',
            'layout' => 'boy-hero',
            'photo' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/9/9f/Kazah_Jurt4.jpg/1280px-Kazah_Jurt4.jpg',
            'source' => 'https://commons.wikimedia.org/wiki/File:Kazah_Jurt4.jpg',
            'intro' => 'Батыр баламыздың сүндет тойына келіп, ақ батаңызды беріп, қуанышымызға ортақ болыңыз.',
        ],
        'sundet-2' => [
            'style' => 'heritage',
            'layout' => 'ornament-card',
            'photo' => unsplash_image('photo-1542662565-7e4b66bae529'),
            'source' => 'https://unsplash.com/',
            'intro' => 'Ақ баталы қуанышымызға келіп, дастарханымыздың төрінен орын алыңыз.',
        ],
        'sundet-3' => [
            'style' => 'joy',
            'layout' => 'playful-paper',
            'photo' => unsplash_image('photo-1515488042361-ee00e0ddd4e4'),
            'source' => 'https://unsplash.com/',
            'intro' => 'Қуаныш күні бірге болып, баламызға жақсы тілегіңізді арнаңыз.',
        ],
        'sundet-4' => [
            'style' => 'classic',
            'layout' => 'formal-boy',
            'photo' => 'assets/images/sundet-er-jigit.jpg',
            'source' => 'https://kznews.kz/uploads/cache/1200x675/resized-images/2025/10/176091704442849263.jpg',
            'intro' => 'Ер жігіттің алғашқы салтанатты тойына қадірлі қонақ болып келіңіз.',
        ],
        'besik-1' => [
            'style' => 'soft',
            'layout' => 'baby-soft',
            'photo' => unsplash_image('photo-1522771930-78848d9293e8'),
            'source' => 'https://unsplash.com/',
            'intro' => 'Ақ бесікке бөленген сәби қуанышына келіп, ақ тілегіңізді арнаңыз.',
        ],
        'besik-2' => [
            'style' => 'pearl',
            'layout' => 'baby-cloud',
            'photo' => unsplash_image('photo-1546015720-b8b30df5aa27'),
            'source' => 'https://unsplash.com/',
            'intro' => 'Сәби нұры үйімізге шаттық сыйлады. Сол қуанышқа ортақ болыңыз.',
        ],
        'besik-3' => [
            'style' => 'cradle',
            'layout' => 'cradle-note',
            'photo' => unsplash_image('photo-1492725764893-90b379c2b6e7'),
            'source' => 'https://unsplash.com/',
            'intro' => 'Бесік жыры тербеген қуанышқа келіп, отбасы шаттығын бөлісіңіз.',
        ],
        'merey-1' => [
            'style' => 'gold',
            'layout' => 'jubilee-gold',
            'photo' => unsplash_image('photo-1530103862676-de8c9debad1d'),
            'source' => 'https://unsplash.com/',
            'intro' => 'Мерейлі жасқа арналған салтанатты кешіміздің қадірлі қонағы болыңыз.',
        ],
        'merey-2' => [
            'style' => 'classic',
            'layout' => 'dastarkhan-warm',
            'photo' => unsplash_image('photo-1555244162-803834f70033'),
            'source' => 'https://unsplash.com/',
            'intro' => 'Ақ дастархан басында бас қосып, жылы тілегіңізді білдіріңіз.',
        ],
        'merey-3' => [
            'style' => 'night',
            'layout' => 'celebration-night',
            'photo' => unsplash_image('photo-1496024840928-4c417adf211d'),
            'source' => 'https://unsplash.com/',
            'intro' => 'Той думанға толы мерекелік кешімізге шақырамыз.',
        ],
        'asberu-1' => [
            'style' => 'calm',
            'layout' => 'calm-letter',
            'photo' => unsplash_image('photo-1498837167922-ddd27525d352'),
            'source' => 'https://unsplash.com/',
            'intro' => 'Жылы естелік пен құрмет дастарханына шақырамыз.',
        ],
        'asberu-2' => [
            'style' => 'calm',
            'layout' => 'guest-table',
            'photo' => unsplash_image('photo-1543353071-10c8ba85a904'),
            'source' => 'https://unsplash.com/',
            'intro' => 'Туған-туыс пен қонақтарға арналған асқа келіп, бірге болыңыз.',
        ],
        'asberu-3' => [
            'style' => 'pearl',
            'layout' => 'white-table',
            'photo' => unsplash_image('photo-1504674900247-0877df9cc836'),
            'source' => 'https://unsplash.com/',
            'intro' => 'Ақ ниетпен жайылған дастарханымыздың қадірлі қонағы болыңыз.',
        ],
    ];
}

function template_design(string $templateId): array
{
    $designs = template_designs();
    return $designs[$templateId] ?? [
        'style' => 'classic',
        'layout' => 'split-elegance',
        'photo' => unsplash_image('photo-1519741497674-611481863552'),
        'source' => 'https://unsplash.com/',
        'intro' => 'Қуанышымызға ортақ болыңыздар.',
    ];
}

function music_track_path(string $musicName, string $templateId = ''): string
{
    if ($musicName === 'Қазақтың тойы бітпесін') {
        return str_starts_with($templateId, 'sundet-')
            ? 'assets/music/sundet/qazaqtyn-toyi-bitpesin.mp3'
            : 'assets/music/merey/qazaqtyn-toyi-bitpesin.mp3';
    }

    $tracks = [
        'Abzal Uteshov - Tokta' => 'assets/music/uilenu/abzal-uteshov-tokta.mp3',
        'Abzal Uteshov - Tota' => 'assets/music/uilenu/abzal-uteshov-tokta.mp3',
        'MOLDANAZAR - Mahabbatym' => 'assets/music/uilenu/moldanazar-mahabbatym.mp3',
        'Moldanazar - Ozin Gana' => 'assets/music/uilenu/moldanazar-ozin-gana.mp3',
        'Ақылбек Жеменей - Қызыл өрік' => 'assets/music/uilenu/akylbek-zhemeney-kyzyl-orik.mp3',
        'Мәлік Жамбылұлы - Аягөз қайда барасың' => 'assets/music/uilenu/malik-zhambyluly-ayagoz.mp3',
        'Ерке сылқым' => 'assets/music/sundet/erke-sylkym.mp3',
        'Сүндет той' => 'assets/music/sundet/sundet-toy.mp3',
        'Асылбек Енсепов - Детство' => 'assets/music/besik/aylbek-ensepov-detstvo.mp3',
        'Той көріңіз' => 'assets/music/besik/toy-koriniz.mp3',
        'Қызым' => 'assets/music/besik/kyzym.mp3',
        'Дос-Мұқасан - Той жыры' => 'assets/music/merey/dos-mukasan-toy-zhyry.mp3',
        'Мадина Сәдуақасова - Ata-Dástúr' => 'assets/music/merey/madina-ata-dastur.mp3',
        'Мадина Сәдуақасова - Ata-Dastur' => 'assets/music/merey/madina-ata-dastur.mp3',
        'Елу жас' => 'assets/music/asberu/elu-zhas.mp3',
        'Жолыққан қандай жақсы - Ернар Айдар' => 'assets/music/asberu/zholyqqan-qandai-zhaqsy.mp3',
        'Сырлау дауысы' => 'assets/music/asberu/syrlau-dauysy.mp3',
        'Акылбек Жеменей - Қызыл өрік' => 'assets/music/uilenu/akylbek-zhemeney-kyzyl-orik.mp3',
        'Мәлік Жамбылұлы - Аягөз қайда барасың' => 'assets/music/uilenu/malik-zhambyluly-ayagoz.mp3',
        'Ерке сылқым' => 'assets/music/sundet/erke-sylkym.mp3',
        'Сүндет той' => 'assets/music/sundet/sundet-toy.mp3',
        'Асылбек Енсепов - Детство' => 'assets/music/besik/aylbek-ensepov-detstvo.mp3',
        'Той көріңіз' => 'assets/music/besik/toy-koriniz.mp3',
        'Қызым' => 'assets/music/besik/kyzym.mp3',
        'Дос-Мұқасан - Той жыры' => 'assets/music/merey/dos-mukasan-toy-zhyry.mp3',
        'Мадина Садуақасова - Ata-Dástúr' => 'assets/music/merey/madina-ata-dastur.mp3',
        'Елу жас' => 'assets/music/asberu/elu-zhas.mp3',
        'Жолыққан қандай жақсы - Ернар Айдар' => 'assets/music/asberu/zholyqqan-qandai-zhaqsy.mp3',
        'Сырлау дауысы' => 'assets/music/asberu/syrlau-dauysy.mp3',
    ];

    if (isset($tracks[$musicName])) {
        return $tracks[$musicName];
    }

    $normalizedMusicName = trim(preg_replace('/\s+/u', ' ', $musicName) ?? $musicName);
    $normalizedMusicName = function_exists('mb_strtolower')
        ? mb_strtolower($normalizedMusicName, 'UTF-8')
        : strtolower($normalizedMusicName);

    foreach ($tracks as $name => $path) {
        $normalizedName = trim(preg_replace('/\s+/u', ' ', $name) ?? $name);
        $normalizedName = function_exists('mb_strtolower')
            ? mb_strtolower($normalizedName, 'UTF-8')
            : strtolower($normalizedName);
        if ($normalizedName === $normalizedMusicName) {
            return $path;
        }
    }

    return '';
}
