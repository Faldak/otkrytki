/* ============================================================
   toigakel.kz — app.js v260611-redesign
   ============================================================ */

const whatsappNumber = "77024667526";

// ── Categories & templates ──────────────────────────────────
const categories = [
  {
    id: "uilenu",
    music: ["Abzal Uteshov - Tokta", "MOLDANAZAR - Mahabbatym", "Moldanazar - Ozin Gana", "Ақылбек Жеменей - Қызыл өрік", "Мәлік Жамбылұлы - Аягөз қайда барасың"],
    templates: [
      ["uilenu-1", "Алтын шаңырақ", "palette-mint",     "Айгерім мен Нұрсұлтан"],
      ["uilenu-2", "Ақ отау",       "palette-rose",     "Ақ отау"],
      ["uilenu-3", "Қызғалдақ той", "palette-coral",    "Үйлену тойы"],
      ["uilenu-4", "Жібек жолы",    "palette-lavender", "Құрметті қонақ"],
      ["uilenu-5", "Шашу",          "palette-sky",      "Шашу той"],
      ["uilenu-6", "Алтын сақина",  "palette-green",    "Алтын сақина"],
      ["uilenu-7", "Нұрлы кеш",     "palette-mint",     "Нұрлы кеш"],
    ]
  },
  {
    id: "sundet",
    music: ["Ерке сылқым", "Сүндет той", "Қазақтың тойы бітпесін"],
    templates: [
      ["sundet-1", "Батыр бала",  "palette-sky",   "Батыр бала"],
      ["sundet-2", "Ақ бата",     "palette-green", "Ақ бата"],
      ["sundet-3", "Қуаныш күні", "palette-coral", "Қуаныш күні"],
      ["sundet-4", "Ер жігіт",    "palette-mint",  "Ер жігіт"],
    ]
  },
  {
    id: "besik",
    music: ["Асылбек Енсепов - Детство", "Той көріңіз", "Қызым"],
    templates: [
      ["besik-1", "Ақ бесік",   "palette-mint",     "Ақ бесік"],
      ["besik-2", "Сәби нұры",  "palette-sky",      "Сәби нұры"],
      ["besik-3", "Бесік жыры", "palette-lavender", "Бесік жыры"],
    ]
  },
  {
    id: "merey",
    music: ["Дос-Мұқасан - Той жыры", "Мадина Садуақасова - Ata-Dástúr", "Қазақтың тойы бітпесін"],
    templates: [
      ["merey-1", "Мерейлі жас",  "palette-coral", "Мерейлі жас"],
      ["merey-2", "Ақ дастархан", "palette-rose",  "Ақ дастархан"],
      ["merey-3", "Той думан",    "palette-green", "Той думан"],
    ]
  },
  {
    id: "asberu",
    music: ["Елу жас", "Жолыққан қандай жақсы - Ернар Айдар", "Сырлау дауысы"],
    templates: [
      ["asberu-1", "Жылы естелік",  "palette-mint",     "Жылы естелік"],
      ["asberu-2", "Қонақ шақыру", "palette-sky",      "Қонақ шақыру"],
      ["asberu-3", "Ақ ниет",       "palette-lavender", "Ақ ниет"],
    ]
  }
].map((cat) => ({
  ...cat,
  templates: cat.templates.map(([id, title, palette, sample]) => ({
    id, title, palette, sample, duration: "28 сек", format: "Веб-шақыру",
    text: "Жеке мәліметтермен дайындалатын той шақыру үлгісі."
  }))
}));

// ── Template photos (Unsplash) ─────────────────────────────
const templateDesigns = {
  "uilenu-1": { photo: "https://images.unsplash.com/photo-1519741497674-611481863552?auto=format&fit=crop&w=1200&q=82" },
  "uilenu-2": { photo: "https://images.unsplash.com/photo-1523438885200-e635ba2c371e?auto=format&fit=crop&w=1200&q=82" },
  "uilenu-3": { photo: "https://images.unsplash.com/photo-1469371670807-013ccf25f16a?auto=format&fit=crop&w=1200&q=82" },
  "uilenu-4": { photo: "https://images.unsplash.com/photo-1511795409834-ef04bbd61622?auto=format&fit=crop&w=1200&q=82" },
  "uilenu-5": { photo: "https://images.unsplash.com/photo-1522673607200-164d1b6ce486?auto=format&fit=crop&w=1200&q=82" },
  "uilenu-6": { photo: "https://images.unsplash.com/photo-1507504031003-b417219a0fde?auto=format&fit=crop&w=1200&q=82" },
  "uilenu-7": { photo: "https://images.unsplash.com/photo-1492684223066-81342ee5ff30?auto=format&fit=crop&w=1200&q=82" },
  "sundet-1": { photo: "https://upload.wikimedia.org/wikipedia/commons/thumb/9/9f/Kazah_Jurt4.jpg/1280px-Kazah_Jurt4.jpg" },
  "sundet-2": { photo: "https://images.unsplash.com/photo-1542662565-7e4b66bae529?auto=format&fit=crop&w=1200&q=82" },
  "sundet-3": { photo: "https://images.unsplash.com/photo-1515488042361-ee00e0ddd4e4?auto=format&fit=crop&w=1200&q=82" },
  "sundet-4": { photo: "assets/images/sundet-er-jigit.jpg" },
  "besik-1":  { photo: "https://images.unsplash.com/photo-1522771930-78848d9293e8?auto=format&fit=crop&w=1200&q=82" },
  "besik-2":  { photo: "https://images.unsplash.com/photo-1546015720-b8b30df5aa27?auto=format&fit=crop&w=1200&q=82" },
  "besik-3":  { photo: "https://images.unsplash.com/photo-1492725764893-90b379c2b6e7?auto=format&fit=crop&w=1200&q=82" },
  "merey-1":  { photo: "https://images.unsplash.com/photo-1530103862676-de8c9debad1d?auto=format&fit=crop&w=1200&q=82" },
  "merey-2":  { photo: "https://images.unsplash.com/photo-1555244162-803834f70033?auto=format&fit=crop&w=1200&q=82" },
  "merey-3":  { photo: "https://images.unsplash.com/photo-1496024840928-4c417adf211d?auto=format&fit=crop&w=1200&q=82" },
  "asberu-1": { photo: "https://images.unsplash.com/photo-1498837167922-ddd27525d352?auto=format&fit=crop&w=1200&q=82" },
  "asberu-2": { photo: "https://images.unsplash.com/photo-1543353071-10c8ba85a904?auto=format&fit=crop&w=1200&q=82" },
  "asberu-3": { photo: "https://images.unsplash.com/photo-1504674900247-0877df9cc836?auto=format&fit=crop&w=1200&q=82" },
};

// ── i18n ───────────────────────────────────────────────────
const i18n = {
  kk: {
    brandSub: "тойға арналған онлайн шақыру",
    navTemplates: "Үлгілер",
    navProcess: "Қалай тапсырыс береді",
    heroLabel: "Қазақы тойға арналған шақырулар",
    heroTitle: "Қонаққа жылы жететін онлайн шақыру",
    heroText: "Үлгіні таңдаңыз, дайын мысалды көріңіз, мәліметтерді толтырыңыз. Біз оны жеке сілтемесі бар тірі шақыруға айналдырамыз.",
    heroPrimary: "Шақыру таңдау",
    heroSecondary: "Қалай жұмыс істейді",
    quickOrder: "Жылдам тапсырыс",
    chooseHoliday: "Мерекені таңдаңыз",
    quickOrderText: "Шақыру бөлек бет болып ашылады. Әр тапсырыстың өз сілтемесі болады.",
    catUilenu: "Үйлену тойы", catSundet: "Сүндет той", catBesik: "Бесік той", catMerey: "Мерей той", catAsberu: "Ас беру",
    templatesLabel: "Үлгілер",
    templatesTitle: "Алдымен мерекені, содан кейін шақыру үлгісін таңдаңыз",
    templatesText: "Әр үлгіде жалпы мысал бар. Мысалды ашып көріп, ұнаса тапсырыс бересіз.",
    processLabel: "Процесс",
    processTitle: "Қонаққа түсінікті, сізге ыңғайлы",
    step1Title: "Үлгі таңдау", step1Text: "Клиент мерекеге лайық үлгіні таңдап, мысалын көреді.",
    step2Title: "Дерек енгізу", step2Text: "Есімдер, күн, уақыт, мекенжай, 2ГИС сілтемесі және мәтін енгізіледі.",
    step3Title: "Музыка және фото", step3Text: "Дайын музыканы таңдауға немесе өз файлын қосуға болады.",
    step4Title: "Төлем және сілтеме", step4Text: "Төлемнен кейін админкада жеке сілтеме сақталады.",
    close: "Жабу",
    // Choose mode
    chooseLabel: "Тапсырыс",
    chooseModeTitle: "Қалай жасаймыз?",
    chooseModeSubtitle: "Өзіңіз толтырасыз ба, әлде менеджер жасасын ба?",
    modeSelfTitle: "Өзім жасаймын",
    modeSelfDesc: "Барлық деректерді өзім енгіземін, алдын ала көремін",
    modeManagerTitle: "Менеджерге өткізу",
    modeManagerDesc: "WhatsApp арқылы менеджер жасап береді",
    // Preview
    previewLine1: "Мұнда үлгінің жалпы көрінісі көрсетіледі",
    previewLine2: "Тапсырыста мәтін, күн және мекенжай ауысады",
    previewLabel: "Мысал",
    previewTitleText: "Үлгінің қалай көрінетінін қараңыз",
    format: "Формат",
    openWebExample: "Веб-шақыру үлгісі",
    continueOrder: "Тапсырыс беру",
    // Form steps
    step1FormLabel: "1-қадам", step1FormTitle: "Есімдер",
    step2FormLabel: "2-қадам", step2FormTitle: "Күн және орын",
    step3FormLabel: "3-қадам", step3FormTitle: "Мәтін және ұйымдастырушылар",
    step4FormLabel: "4-қадам", step4FormTitle: "Фото және музыка",
    backToPreview: "Мысалға қайту",
    nextStep: "Келесі →",
    prevStep: "← Артқа",
    previewBtn: "Алдын ала қарау 👁",
    // Step 1 fields
    brideName: "Қалыңдық есімі",
    groomName: "Жігіт есімі",
    childName: "Бала есімі",
    honoredName: "Той иесінің есімі",
    namePlaceholderBride: "Айгерім",
    namePlaceholderGroom: "Нұрсұлтан",
    namePlaceholderChild: "Ерасыл",
    namePlaceholderHonored: "Болат аға",
    // Step 2
    eventDate: "Күні",
    eventTime: "Уақыты",
    eventCity: "Қала",
    address: "Толық мекенжай",
    gisLink: "2ГИС сілтемесі",
    // Step 3
    inviteLanguage: "Шақыру тілі",
    productType: "Формат",
    webCard: "Сайт-шақыру",
    readyText: "Дайын мәтін",
    customText: "Шақыру мәтіні",
    organizerNames: "Той иелері",
    clientName: "Сіздің атыңыз",
    // Step 4
    customPhoto: "Фото (міндетті емес)",
    photoHint: "Егер фото жүктемесеңіз, шаблондық сурет пайдаланылады",
    music: "Музыка",
    customMusic: "Өз музыкаңызды қосу",
    // Preview
    previewSidebarTitle: "Дайын! Тапсырыс берейік",
    previewSidebarDesc: "Тапсырыс берген соң мен сізге WhatsApp арқылы хабарласамын.",
    yourOrderSummary: "Тапсырысыңыз:",
    submitOrder: "✅ Тапсырыс беру",
    backToForm: "← Өзгерту",
    watermarkText: "ТӨЛЕНГЕН ЖОК",
    // Result
    created: "Заявка жасалды. Статус: төлем күтуде.",
    saveResultLink: "Төлем расталғаннан кейін дайын шақыру сілтемесін WhatsApp арқылы аласыз.",
    whatsappPay: "WhatsApp-қа жазу ➜",
    // Footer
    writeWhatsapp: "WhatsApp-қа жазу",
    discount: "31 маусымға дейін барлық ашықхаттарға жеңілдік",
    viewOrder: "Қарау және тапсырыс беру",
    customMusicOption: "Өз музыкамды қосамын",
  },
  uz: {
    brandSub: "to'y uchun onlayn taklifnoma",
    navTemplates: "Andozalar",
    navProcess: "Qanday buyurtma beriladi",
    heroLabel: "To'y va marosimlar uchun taklifnomalar",
    heroTitle: "Mehmonga iliq yetib boradigan onlayn taklifnoma",
    heroText: "Andozani tanlang, tayyor namunani ko'ring va ma'lumotlarni kiriting. Biz uni alohida havolali jonli taklifnomaga aylantiramiz.",
    heroPrimary: "Taklifnoma tanlash",
    heroSecondary: "Qanday ishlaydi",
    quickOrder: "Tez buyurtma",
    chooseHoliday: "Marosimni tanlang",
    quickOrderText: "Taklifnoma alohida sahifa sifatida ochiladi. Har bir buyurtmaning o'z havolasi bo'ladi.",
    catUilenu: "Nikoh to'yi", catSundet: "Sunnat to'yi", catBesik: "Beshik to'yi", catMerey: "Yubiley", catAsberu: "Ehson oshi",
    templatesLabel: "Andozalar",
    templatesTitle: "Avval marosimni, keyin taklifnoma andozasini tanlang",
    templatesText: "Har bir andozada umumiy namuna bor. Ko'rib, yoqsa buyurtma berasiz.",
    processLabel: "Jarayon",
    processTitle: "Mehmonga tushunarli, sizga qulay",
    step1Title: "Andoza tanlash", step1Text: "Mijoz marosimga mos andozani tanlaydi va namunasini ko'radi.",
    step2Title: "Ma'lumot kiritish", step2Text: "Ismlar, sana, vaqt, manzil, 2GIS havolasi va matn kiritiladi.",
    step3Title: "Musiqa va foto", step3Text: "Tayyor musiqani tanlash yoki o'z faylini qo'shish mumkin.",
    step4Title: "To'lov va havola", step4Text: "To'lovdan keyin admin panelda shaxsiy havola saqlanadi.",
    close: "Yopish",
    chooseLabel: "Buyurtma",
    chooseModeTitle: "Qanday qilamiz?",
    chooseModeSubtitle: "O'zingiz to'ldirasizmi yoki menejer qilsinmi?",
    modeSelfTitle: "O'zim qilaman",
    modeSelfDesc: "Barcha ma'lumotlarni o'zim kiritaman, oldindan ko'raman",
    modeManagerTitle: "Menejerga berish",
    modeManagerDesc: "WhatsApp orqali menejer qilib beradi",
    previewLine1: "Bu yerda andozaning umumiy ko'rinishi ko'rsatiladi",
    previewLine2: "Buyurtmada matn, sana va manzil almashadi",
    previewLabel: "Namuna",
    previewTitleText: "Andoza qanday ko'rinishini ko'ring",
    format: "Format",
    openWebExample: "Veb taklifnoma namunasi",
    continueOrder: "Buyurtma berish",
    step1FormLabel: "1-qadam", step1FormTitle: "Ismlar",
    step2FormLabel: "2-qadam", step2FormTitle: "Sana va joy",
    step3FormLabel: "3-qadam", step3FormTitle: "Matn va tashkilotchilar",
    step4FormLabel: "4-qadam", step4FormTitle: "Foto va musiqa",
    backToPreview: "Namunaga qaytish",
    nextStep: "Keyingi →",
    prevStep: "← Orqaga",
    previewBtn: "Oldindan ko'rish 👁",
    brideName: "Kelin ismi",
    groomName: "Kuyov ismi",
    childName: "Bola ismi",
    honoredName: "Yubilyar ismi",
    namePlaceholderBride: "Zilola",
    namePlaceholderGroom: "Jasur",
    namePlaceholderChild: "Azizbek",
    namePlaceholderHonored: "Botir aka",
    eventDate: "Sana",
    eventTime: "Vaqt",
    eventCity: "Shahar",
    address: "To'liq manzil",
    gisLink: "2GIS havolasi",
    inviteLanguage: "Taklifnoma tili",
    productType: "Format",
    webCard: "Sayt-taklifnoma",
    readyText: "Tayyor matn",
    customText: "Taklifnoma matni",
    organizerNames: "To'y egalari",
    clientName: "Ismingiz",
    customPhoto: "Foto (ixtiyoriy)",
    photoHint: "Foto yuklamasangiz, shablon rasm ishlatiladi",
    music: "Musiqa",
    customMusic: "O'z musiqangizni qo'shish",
    previewSidebarTitle: "Tayyor! Buyurtma beraylik",
    previewSidebarDesc: "Buyurtmadan keyin WhatsApp orqali bog'lanaman.",
    yourOrderSummary: "Buyurtmangiz:",
    submitOrder: "✅ Buyurtma berish",
    backToForm: "← O'zgartirish",
    watermarkText: "TO'LANMAGAN",
    created: "Buyurtma yaratildi. Holat: to'lov kutilmoqda.",
    saveResultLink: "To'lov tasdiqlangandan keyin tayyor havola WhatsApp orqali keladi.",
    whatsappPay: "WhatsApp-ga o'tish ➜",
    writeWhatsapp: "WhatsApp-ga yozish",
    discount: "Barcha taklifnomalarga 31-iyungacha chegirma",
    viewOrder: "Ko'rish va buyurtma berish",
    customMusicOption: "O'z musiqamni qo'shaman",
  },
  ru: {
    brandSub: "онлайн-приглашения для тоя",
    navTemplates: "Шаблоны",
    navProcess: "Как заказать",
    heroLabel: "Приглашения для тоя и праздников",
    heroTitle: "Онлайн-приглашение, которое ощущается как живое письмо",
    heroText: "Выберите шаблон, посмотрите готовый пример и заполните данные. Мы превратим это в личную ссылку с красивым приглашением.",
    heroPrimary: "Выбрать приглашение",
    heroSecondary: "Как работает",
    quickOrder: "Быстрый заказ",
    chooseHoliday: "Выберите праздник",
    quickOrderText: "Приглашение открывается отдельной страницей. У каждого заказа своя ссылка.",
    catUilenu: "Свадьба (Үйлену той)", catSundet: "Сүндет той", catBesik: "Бесік той", catMerey: "Мерей той", catAsberu: "Ас беру",
    templatesLabel: "Шаблоны",
    templatesTitle: "Сначала выберите праздник, затем шаблон",
    templatesText: "У каждого шаблона есть общий пример. Откройте пример, оцените и оформите заказ.",
    processLabel: "Процесс",
    processTitle: "Понятно гостю, удобно вам",
    step1Title: "Выбор шаблона", step1Text: "Клиент выбирает подходящий шаблон и смотрит пример.",
    step2Title: "Данные", step2Text: "Вводятся имена, дата, время, адрес, ссылка 2ГИС и текст.",
    step3Title: "Музыка и фото", step3Text: "Можно выбрать готовую музыку или загрузить свой файл.",
    step4Title: "Оплата и ссылка", step4Text: "После оплаты личная ссылка сохраняется в админке.",
    close: "Закрыть",
    chooseLabel: "Заказ",
    chooseModeTitle: "Как будем делать?",
    chooseModeSubtitle: "Сами заполните или попросите менеджера?",
    modeSelfTitle: "Сделаю сам",
    modeSelfDesc: "Заполню все данные сам и посмотрю предпросмотр",
    modeManagerTitle: "Попросить менеджера",
    modeManagerDesc: "Менеджер сделает всё через WhatsApp",
    previewLine1: "Здесь показан общий вид шаблона",
    previewLine2: "В заказе меняются текст, дата и адрес",
    previewLabel: "Пример",
    previewTitleText: "Посмотрите, как выглядит шаблон",
    format: "Формат",
    openWebExample: "Пример веб-приглашения",
    continueOrder: "Оформить заказ",
    step1FormLabel: "Шаг 1", step1FormTitle: "Имена",
    step2FormLabel: "Шаг 2", step2FormTitle: "Дата и место",
    step3FormLabel: "Шаг 3", step3FormTitle: "Текст и организаторы",
    step4FormLabel: "Шаг 4", step4FormTitle: "Фото и музыка",
    backToPreview: "Вернуться к примеру",
    nextStep: "Далее →",
    prevStep: "← Назад",
    previewBtn: "Предпросмотр 👁",
    brideName: "Имя невесты",
    groomName: "Имя жениха",
    childName: "Имя ребёнка",
    honoredName: "Имя виновника торжества",
    namePlaceholderBride: "Айгерим",
    namePlaceholderGroom: "Нурсултан",
    namePlaceholderChild: "Ерасыл",
    namePlaceholderHonored: "Болат",
    eventDate: "Дата",
    eventTime: "Время",
    eventCity: "Город",
    address: "Полный адрес",
    gisLink: "Ссылка 2ГИС",
    inviteLanguage: "Язык приглашения",
    productType: "Формат",
    webCard: "Сайт-приглашение",
    readyText: "Готовый текст",
    customText: "Текст приглашения",
    organizerNames: "Той иелері / Хозяева торжества",
    clientName: "Ваше имя",
    customPhoto: "Фото (необязательно)",
    photoHint: "Если фото не загрузите — будет использовано шаблонное изображение",
    music: "Музыка",
    customMusic: "Добавить свою музыку",
    previewSidebarTitle: "Готово! Оформим заказ",
    previewSidebarDesc: "После оформления заказа я свяжусь с вами через WhatsApp.",
    yourOrderSummary: "Ваш заказ:",
    submitOrder: "✅ Оформить заказ",
    backToForm: "← Изменить",
    watermarkText: "НЕ ОПЛАЧЕНО",
    created: "Заявка создана. Статус: ждёт оплаты.",
    saveResultLink: "После подтверждения оплаты готовая ссылка придёт в WhatsApp.",
    whatsappPay: "Перейти в WhatsApp ➜",
    writeWhatsapp: "Написать в WhatsApp",
    discount: "Скидка до 31 июня на все открытки",
    viewOrder: "Посмотреть и заказать",
    customMusicOption: "Добавлю свою музыку",
  }
};

// ── Category names (multilang) ─────────────────────────────
const categoryNames = {
  uilenu: { kk: "Үйлену тойы",  uz: "Nikoh to'yi",    ru: "Свадьба (Үйлену той)" },
  sundet:  { kk: "Сүндет той",  uz: "Sunnat to'yi",   ru: "Сүндет той" },
  besik:   { kk: "Бесік той",   uz: "Beshik to'yi",   ru: "Бесік той" },
  merey:   { kk: "Мерей той",   uz: "Yubiley",         ru: "Мерей той" },
  asberu:  { kk: "Ас беру",     uz: "Ehson oshi",      ru: "Ас беру" },
};

// ── Ready texts ────────────────────────────────────────────
const readyTexts = {
  kk: [
    "Құрметті ағайын-туыс, бауырлар, құда-жекжат, дос-жарандар! Сіздерді отбасымыздың қуанышты күніне ортақтасып, ақ дастарханымыздың қадірлі қонағы болуға шын жүректен шақырамыз.",
    "Ардақты қонақтар! Өміріміздегі ерекше күнді жақындарымызбен бірге атап өткіміз келеді. Сіздерді салтанатты кешімізге келіп, жылы лебіздеріңізді білдіруге шақырамыз.",
    "Құрметті қонақтар! Шаңырағымызда өтетін қуанышты сәтке сіздерді арнайы шақырамыз. Келіп, қуанышымызға ортақ болыңыздар.",
  ],
  uz: [
    "Hurmatli mehmonlar! Sizni oilamizning quvonchli kunida biz bilan birga bo'lishga, dasturxonimizning aziz mehmoni bo'lishga taklif qilamiz.",
    "Aziz yaqinlarimiz! Hayotimizdagi muhim sanani siz bilan birga nishonlashni istaymiz. Tantanali kechamizga tashrif buyurishingizni so'raymiz.",
    "Hurmatli mehmonlar! Sizni oilaviy bayramimizga taklif qilamiz. Yaxshi niyat va iliq tilaklar bilan kutamiz.",
  ],
  ru: [
    "Дорогие гости! Приглашаем вас разделить с нами радость этого важного дня и стать почётными гостями нашего праздничного дастархана.",
    "Уважаемые родные и близкие! Мы будем рады видеть вас на нашем торжестве. Приходите с хорошим настроением и тёплыми пожеланиями.",
    "Дорогие гости! В этот особенный день мы хотим собрать рядом самых близких людей и разделить с вами радость.",
  ],
};

// ── VIP template IDs ───────────────────────────────────────
const vipTemplateIds = new Set(["uilenu-1", "uilenu-3", "uilenu-6"]);

// ── State ─────────────────────────────────────────────────
const state = {
  categoryId: "uilenu",
  templateId: "uilenu-1",
  language: "kk",
  formStep: 1,       // 1-4
  modalMode: "preview", // "preview"|"choose"|"form"|"fullpreview"
};

let pricing = {
  web:      { current: 590,  old: 1990 },
  vipWeb:   { current: 990,  old: 2990 },
};

// ── DOM refs ──────────────────────────────────────────────
const $ = (sel) => document.querySelector(sel);
const $$ = (sel) => [...document.querySelectorAll(sel)];

const categoryTabs      = $("#categoryTabs");
const templatesGrid     = $("#templatesGrid");
const quickCategoryList = $("#quickCategoryList");
const templatesSection  = $("#templates");
const orderModal        = $("#orderModal");
const menuToggle        = $("#menuToggle");
const mainNav           = $("#mainNav");
const footerWhatsapp    = $("#footerWhatsapp");
const languageSelect    = $("#languageSelect");

// Modal steps
const chooseStep       = $("#chooseStep");
const previewStep      = $("#previewStep");
const orderForm        = $("#orderForm");
const fullPreviewStep  = $("#fullPreviewStep");

// Preview step elements
const previewCategory  = $("#previewCategory");
const previewTitle     = $("#previewTitle");
const previewSample    = $("#previewSample");
const previewText      = $("#previewText");
const previewFormat    = $("#previewFormat");
const previewDuration  = $("#previewDuration");
const previewPrice     = $("#previewPrice");
const modalPreview     = $("#modalPreview");
const exampleLink      = $("#exampleLink");

// Form fields
const inviteLanguage   = $("#inviteLanguage");
const productType      = $("#productType");
const readyTextSelect  = $("#readyText");
const customText       = $("#customText");
const customMusicRow   = $("#customMusicRow");
const musicSelect      = $("#musicSelect");
const selectedPrice    = $("#selectedPrice");
const orderPrice       = $("#orderPrice");
const orderOldPrice    = $("#orderOldPrice");
const orderStatus      = $("#orderStatus");

// Full preview elements
const invPreviewHero   = $("#invPreviewHero");
const invCatLabel      = $("#invCatLabel");
const invMainNames     = $("#invMainNames");
const invDate          = $("#invDate");
const invTime          = $("#invTime");
const invAddress       = $("#invAddress");
const invText          = $("#invText");
const invOrganizers    = $("#invOrganizers");
// watermark removed
const sidebarOrderStatus = $("#sidebarOrderStatus");

// ── Helper functions ───────────────────────────────────────
function currentCategory() {
  return categories.find((c) => c.id === state.categoryId) || categories[0];
}

function currentTemplate() {
  const cat = currentCategory();
  return cat.templates.find((t) => t.id === state.templateId) || cat.templates[0];
}

function t(key) {
  return i18n[state.language]?.[key] || i18n.kk[key] || key;
}

function categoryLabel(cat = currentCategory()) {
  return categoryNames[cat.id]?.[state.language] || cat.name || cat.id;
}

function isVideoProduct() { return false; }

function isVipTemplate(tpl = currentTemplate()) {
  return vipTemplateIds.has(tpl.id);
}

function productKey(tpl = currentTemplate()) {
  return isVipTemplate(tpl) ? "vipWeb" : "web";
}

function formatTenge(v) {
  return `${Number(v || 0).toLocaleString("ru-RU")} тг`;
}

function oldPriceLabel() {
  if (state.language === "uz") return "oldin";
  if (state.language === "kk") return "бұрын";
  return "было";
}

function priceTitle(key) {
  const isVip   = key.startsWith("vip");
  return `${isVip ? "VIP " : ""}${t("webCard")}`;
}

function priceCard(key) {
  const item = pricing[key] || pricing.web;
  return `<div class="price-card${key.startsWith("vip") ? " vip-price-card" : ""}"><span>${priceTitle(key)}</span><strong>${formatTenge(item.current)}</strong><del>${formatTenge(item.old)}</del></div>`;
}

function fullPriceLine(key = productKey()) {
  const item = pricing[key] || pricing.web;
  return `${formatTenge(item.current)} · ${oldPriceLabel()} ${formatTenge(item.old)}`;
}

function updatePriceDisplay() {
  const key  = productKey();
  const item = pricing[key] || pricing.web;
  if (selectedPrice) selectedPrice.textContent = fullPriceLine(key);
  if (previewPrice)  previewPrice.textContent  = fullPriceLine(key);
  if (orderPrice)    orderPrice.value          = String(item.current);
  if (orderOldPrice) orderOldPrice.value       = String(item.old);
}

function videoDurationLabel() { return ""; }

function templateDescription(cat, tpl) {
  const d = {
    kk: { uilenu:"Жылы үйлену той шақыруы: фото, күн, мекенжай бар.", sundet:"Сүндет тойға арналған жарық шақыру.", besik:"Бесік тойға арналған жұмсақ шақыру.", merey:"Мерей тойға арналған салтанатты шақыру.", asberu:"Ас беруге арналған құрметті шақыру." },
    uz: { uilenu:"Nikoh to'yi uchun iliq taklifnoma: rasm, sana, manzil bilan.", sundet:"Sunnat to'yi uchun oilaviy taklifnoma.", besik:"Beshik to'yi uchun yumshoq taklifnoma.", merey:"Yubiley uchun tantanali taklifnoma.", asberu:"Ehson oshi uchun sokin taklifnoma." },
    ru: { uilenu:"Тёплое свадебное приглашение с фото, датой и адресом.", sundet:"Светлое приглашение для сүндет той.", besik:"Нежное приглашение для бесік той.", merey:"Торжественное приглашение для мерей той.", asberu:"Уважительное приглашение для ас беру." },
  };
  return d[state.language]?.[cat.id] || tpl.text;
}

// ── Name fields (Step 1) ──────────────────────────────────
function renderNameFields() {
  const container = $("#nameFieldsContainer");
  if (!container) return;
  const catId = state.categoryId;

  if (catId === "uilenu") {
    container.innerHTML = `
      <div class="form-grid">
        <div class="form-row">
          <label for="groomNameField">${t("groomName")}</label>
          <input id="groomNameField" name="groomName" type="text" placeholder="${t("namePlaceholderGroom")}" required>
        </div>
        <div class="form-row">
          <label for="brideNameField">${t("brideName")}</label>
          <input id="brideNameField" name="brideName" type="text" placeholder="${t("namePlaceholderBride")}" required>
        </div>
      </div>`;
  } else if (catId === "sundet" || catId === "besik") {
    container.innerHTML = `
      <div class="form-row">
        <label for="childNameField">${t("childName")}</label>
        <input id="childNameField" name="childName" type="text" placeholder="${t("namePlaceholderChild")}" required>
      </div>`;
  } else {
    container.innerHTML = `
      <div class="form-row">
        <label for="honoredNameField">${t("honoredName")}</label>
        <input id="honoredNameField" name="honoredName" type="text" placeholder="${t("namePlaceholderHonored")}" required>
      </div>`;
  }
}

// ── Ready texts ────────────────────────────────────────────
function activeReadyTexts() {
  return readyTexts[state.language] || readyTexts.kk;
}

function readyTextOptionLabel(i) {
  if (state.language === "ru") return `Готовый текст ${i + 1}`;
  if (state.language === "uz") return `Tayyor matn ${i + 1}`;
  return `Дайын мәтін ${i + 1}`;
}

function renderReadyTexts() {
  const texts = activeReadyTexts();
  if (!readyTextSelect) return;
  readyTextSelect.innerHTML = texts.map((_, i) => `<option value="${i}">${readyTextOptionLabel(i)}</option>`).join("");
  if (customText) {
    customText.value = texts[0] || "";
    customText.maxLength = 2200;
  }
}

// ── Music options ─────────────────────────────────────────
function renderMusicOptions() {
  const cat = currentCategory();
  if (!musicSelect) return;
  musicSelect.innerHTML =
    cat.music.map((m) => `<option value="${m}">${m}</option>`).join("") +
    `<option value="custom">${t("customMusicOption")}</option>`;
  customMusicRow.style.display = "none";
}

// ── Render category tabs ──────────────────────────────────
function renderCategoryTabs() {
  categoryTabs.innerHTML = categories.map((cat) => `
    <button type="button" class="${cat.id === state.categoryId ? "active" : ""}" data-category="${cat.id}">
      ${categoryLabel(cat)}
    </button>`).join("");
}

// ── Render template cards ─────────────────────────────────
function renderTemplates() {
  const cat = currentCategory();
  templatesGrid.innerHTML = cat.templates.map((tpl) => {
    const vip      = isVipTemplate(tpl);
    const webKey   = vip ? "vipWeb"   : "web";
    const catLabel = categoryLabel(cat);
    return `
      <article class="template-card${vip ? " vip-template-card" : ""}" data-cat="${cat.id}">
        <button type="button" data-template="${tpl.id}" aria-label="${tpl.title}">
          <div class="preview-art ${tpl.palette}" style="background-image:linear-gradient(rgba(56,36,22,.18),rgba(56,36,22,.32)),url('${templateDesigns[tpl.id]?.photo || ""}')">
            <div class="preview-art-inner-corners"></div>
            <span class="preview-art-category-tag">${catLabel}</span>
            <strong>${tpl.sample}</strong>
            ${vip ? `<span class="vip-badge">VIP</span>` : ""}
          </div>
          <div class="template-body">
            <h3>${tpl.title}</h3>
            <p>${templateDescription(cat, tpl)}</p>
            <div class="template-meta">
              <span>${tpl.format}</span>
            </div>
            <div class="template-price">
              ${priceCard(webKey)}
            </div>
            <span class="primary-btn">${t("viewOrder")}</span>
          </div>
        </button>
      </article>`;
  }).join("");
}

function renderAll() {
  renderCategoryTabs();
  renderTemplates();
}

// ── Apply language ────────────────────────────────────────
function applyLanguage() {
  document.documentElement.lang = state.language;
  $$("[data-i18n]").forEach((el) => {
    const key = el.dataset.i18n;
    if (el.tagName === "OPTION") {
      el.textContent = t(key);
    } else {
      el.textContent = t(key);
    }
  });
  if (languageSelect)   languageSelect.value   = state.language;
  if (inviteLanguage)   inviteLanguage.value   = state.language;

  // Quick category buttons
  $$("[data-i18n-btn]").forEach((btn) => {
    btn.textContent = t(btn.dataset.i18nBtn);
  });

  // Watermark
  // watermark removed

  renderReadyTexts();
  renderNameFields();
  renderAll();
  updatePreview();
}

// ── Category switch ───────────────────────────────────────
function setCategory(catId) {
  const cat = categories.find((c) => c.id === catId);
  if (!cat) return;
  state.categoryId = cat.id;
  state.templateId = cat.templates[0].id;
  renderAll();
  renderReadyTexts();
  renderNameFields();
}

function jumpToCategory(catId) {
  setCategory(catId);
  templatesSection?.scrollIntoView({ behavior: "smooth", block: "start" });
}

// ── Update preview panel ──────────────────────────────────
function updatePreview() {
  const cat = currentCategory();
  const tpl = currentTemplate();
  if (!previewCategory) return;
  previewCategory.textContent = categoryLabel(cat);
  previewTitle.textContent    = tpl.title;
  previewSample.textContent   = state.language === "ru" ? "Вот так будет выглядеть открытка"
    : state.language === "uz" ? "Taklifnoma taxminan shunday ko'rinadi"
    : "Шақыру осылай көрінеді";
  previewText.textContent     = templateDescription(cat, tpl);
  previewFormat.textContent   = tpl.format;
  modalPreview.className      = `modal-preview ${tpl.palette}`;
  modalPreview.style.backgroundImage = `linear-gradient(rgba(56,36,22,.22),rgba(56,36,22,.44)),url('${templateDesigns[tpl.id]?.photo || ""}')`;
  exampleLink.href      = `example.php?template=${encodeURIComponent(tpl.id)}&lang=${encodeURIComponent(state.language)}`;
  renderMusicOptions();
  updatePriceDisplay();
}

// ── Modal open/close ──────────────────────────────────────
function showModalStep(step) {
  // step: "choose"|"preview"|"form"|"fullpreview"
  chooseStep.classList.remove("active");
  previewStep.classList.remove("active");
  orderForm.classList.remove("active");
  fullPreviewStep.classList.remove("active");

  if (step === "choose")      chooseStep.classList.add("active");
  else if (step === "preview") previewStep.classList.add("active");
  else if (step === "form")    orderForm.classList.add("active");
  else if (step === "fullpreview") fullPreviewStep.classList.add("active");

  state.modalMode = step;
}

function openOrder(templateId) {
  const cat = currentCategory();
  const tpl = cat.templates.find((t) => t.id === templateId);
  if (!tpl) return;
  state.templateId = tpl.id;
  updatePreview();
  renderNameFields();

  // Reset form
  orderForm.reset();
  if (orderStatus) { orderStatus.classList.remove("show"); orderStatus.innerHTML = ""; }
  if (sidebarOrderStatus) { sidebarOrderStatus.classList.remove("show"); sidebarOrderStatus.innerHTML = ""; }

  // Clear any stale preview iframe
  const previewIframe = document.getElementById("previewIframe");
  if (previewIframe) { previewIframe.src = "about:blank"; }

  showModalStep("preview");
  orderModal.classList.add("open");
  orderModal.setAttribute("aria-hidden", "false");
  document.body.classList.add("modal-open");
  state.formStep = 1;
  updateStepDots(1);
  showFormStep(1);
}

function closeOrder() {
  orderModal.classList.remove("open");
  orderModal.setAttribute("aria-hidden", "true");
  document.body.classList.remove("modal-open");
}

// ── Form step navigation ──────────────────────────────────
function showFormStep(n) {
  $$(".form-step-content").forEach((el) => el.classList.remove("active"));
  const el = $(`#formStep${n}`);
  if (el) el.classList.add("active");
  state.formStep = n;
  updateStepDots(n);
}

function updateStepDots(n) {
  for (let i = 1; i <= 4; i++) {
    const dot  = $(`#dotStep${i}`);
    if (!dot) continue;
    dot.classList.remove("active", "done");
    if (i < n) dot.classList.add("done");
    else if (i === n) dot.classList.add("active");
  }
  for (let i = 1; i <= 3; i++) {
    const line = $(`#line${i}${i+1}`);
    if (line) line.classList.toggle("done", i < n);
  }
}

function validateStep(n) {
  if (n === 1) {
    const inputs = $$("#nameFieldsContainer input[required]");
    return inputs.every((el) => el.value.trim() !== "");
  }
  if (n === 2) {
    const date = $("#eventDate"), time = $("#eventTime"), city = $("#eventCity"), addr = $("#address");
    return [date, time, city, addr].every((el) => el && el.value.trim() !== "");
  }
  if (n === 3) {
    const ph = $("#phone");
    return ph && ph.value.trim() !== "";
  }
  return true;
}

function alertRequired() {
  const msg = state.language === "ru" ? "Пожалуйста, заполните все обязательные поля."
    : state.language === "uz" ? "Iltimos, barcha majburiy maydonlarni to'ldiring."
    : "Барлық міндетті өрістерді толтырыңыз.";
  alert(msg);
}

// ── Build full-preview panel ──────────────────────────────
function buildMainNames() {
  const catId = state.categoryId;
  if (catId === "uilenu") {
    const g = ($("#groomNameField")?.value || "").trim();
    const b = ($("#brideNameField")?.value || "").trim();
    return g && b ? `${g} & ${b}` : g || b || "—";
  }
  if (catId === "sundet" || catId === "besik") {
    return ($("#childNameField")?.value || "").trim() || "—";
  }
  return ($("#honoredNameField")?.value || "").trim() || "—";
}

function renderFullPreview() {
  const tpl = currentTemplate();
  const cat = currentCategory();
  const lang = state.language;

  const dateVal = $("#eventDate")?.value || "";
  const timeVal = $("#eventTime")?.value || "";
  const cityVal = ($("#eventCity")?.value || "").trim();
  const addrVal = ($("#address")?.value || "").trim();
  const gisLink = ($("#gisLink")?.value || "").trim();
  const textVal = ($("#customText")?.value || "").trim();
  const organizerVal = ($("#organizerNames")?.value || "").trim();
  const musicVal = $("#musicSelect")?.value || "";
  const mainNames = buildMainNames();

  const queryParams = new URLSearchParams({
    templateId: tpl.id,
    category: categoryLabel(cat),
    lang: lang,
    eventDate: dateVal,
    eventTime: timeVal,
    city: cityVal,
    address: addrVal,
    gisLink: gisLink,
    customText: textVal,
    organizerNames: organizerVal,
    music: musicVal,
    mainNames: mainNames
  });

  const previewIframe = document.getElementById("previewIframe");
  if (previewIframe) {
    previewIframe.src = `preview.php?${queryParams.toString()}`;
  }

  // Watermark
  // watermark removed

  // Summary sidebar
  const sum = $("#orderSummaryText");
  if (sum) {
    const tplTitle = tpl.title;
    const catTitle = categoryLabel(cat);
    const fmt = t("webCard");
    const priceKey = productKey();
    const priceItem = pricing[priceKey] || pricing.web;
    
    let displayDate = dateVal;
    if (dateVal) {
      try {
        displayDate = new Date(dateVal).toLocaleDateString(
          lang === "kk" ? "kk-KZ" : lang === "uz" ? "uz-UZ" : "ru-RU",
          { year: "numeric", month: "long", day: "numeric" }
        );
      } catch {}
    }

    sum.innerHTML = `
      <div>📌 ${catTitle} — ${tplTitle}</div>
      <div>📄 ${fmt}</div>
      <div>💰 ${formatTenge(priceItem.current)}</div>
      <div>👤 ${mainNames}</div>
      <div>📅 ${displayDate} ${timeVal}</div>
    `;
  }
}

// ── Collect main names for order payload ──────────────────
function getMainNames() {
  const catId = state.categoryId;
  if (catId === "uilenu") {
    const g = ($("#groomNameField")?.value || "").trim();
    const b = ($("#brideNameField")?.value || "").trim();
    return `${g} & ${b}`.trim();
  }
  if (catId === "sundet" || catId === "besik") return ($("#childNameField")?.value || "").trim();
  return ($("#honoredNameField")?.value || "").trim();
}

// ── WhatsApp link ──────────────────────────────────────────
function buildWhatsappLink(orderId) {
  const lang = state.language;
  let text;
  if (orderId) {
    text = lang === "ru" ? `Здравствуйте! Я оставил заявку №${orderId}, жду ответа.`
      : lang === "uz" ? `Salom! Men ${orderId} raqamli ariza qoldirdim, javob kutaman.`
      : `Сәлеметсіз бе! Мен ${orderId} нөмірлі тапсырыс бердім, жауап күтемін.`;
  } else {
    text = lang === "ru" ? "Здравствуйте! Хочу узнать о заказе приглашения."
      : lang === "uz" ? "Salom! Taklifnoma buyurtmasi haqida bilmoqchiman."
      : "Сәлеметсіз бе! Шақыру тапсырысы туралы білгім келеді.";
  }
  return `https://wa.me/${whatsappNumber}?text=${encodeURIComponent(text)}`;
}

// ── Submit order ───────────────────────────────────────────
async function submitOrder() {
  const cat = currentCategory();
  const tpl = currentTemplate();
  updatePriceDisplay();

  const formData = new FormData(orderForm);
  formData.set("category",      categoryLabel(cat));
  formData.set("template",      tpl.title);
  formData.set("templateId",    tpl.id);
  formData.set("pricingKey",    productKey(tpl));
  formData.set("isVip",         isVipTemplate(tpl) ? "1" : "0");
  formData.set("mainNames",     getMainNames());
  formData.set("guestName",     state.language === "ru" ? "Дорогие гости" : state.language === "uz" ? "Hurmatli mehmonlar" : "Құрметті қонақтар");
  formData.set("inviteLanguage", state.language);
  formData.set("music",         formData.get("musicSelect") || "");
  formData.set("city",          ($("#eventCity")?.value || "").trim());
  formData.set("organizerNames",($("#organizerNames")?.value || "").trim());

  const btnEl = $("#step4Next");
  if (btnEl) { btnEl.disabled = true; btnEl.textContent = "..."; }

  let order;
  try {
    const resp = await fetch("api/orders.php", { method: "POST", body: formData });
    const data = await resp.json();
    if (!data.ok) throw new Error(data.message || "Error");
    order = data.order;
  } catch {
    order = { id: `TG-${Date.now().toString().slice(-6)}` };
  }

  const waUrl = buildWhatsappLink(order.id);
  footerWhatsapp.href = waUrl;

  const statusHtml = `
    <strong>${t("created")} ${order.id}.</strong>
    <span>${t("saveResultLink")}</span>
    <a href="${waUrl}" target="_blank" rel="noreferrer">${t("whatsappPay")}</a>`;

  if (sidebarOrderStatus) {
    sidebarOrderStatus.classList.add("show");
    sidebarOrderStatus.innerHTML = statusHtml;
  }
  if (orderStatus) {
    orderStatus.classList.add("show");
    orderStatus.innerHTML = statusHtml;
  }

  if (btnEl) { btnEl.disabled = false; btnEl.textContent = t("submitOrder") || "✅ Тапсырыс беру"; }

  // Redirect to WhatsApp after short delay
  setTimeout(() => { window.open(waUrl, "_blank"); }, 1200);
}

// ── Pricing load ──────────────────────────────────────────
async function loadPricing() {
  try {
    const resp = await fetch("api/pricing.php");
    const data = await resp.json();
    if (data.ok && data.pricing) pricing = data.pricing;
  } catch {}
  renderAll();
  updatePreview();
}

// ──────────────────────────────────────────────────────────
// EVENT LISTENERS
// ──────────────────────────────────────────────────────────

// Menu toggle
menuToggle.addEventListener("click", () => {
  const open = mainNav.classList.toggle("open");
  menuToggle.classList.toggle("active", open);
  menuToggle.setAttribute("aria-expanded", String(open));
  document.body.classList.toggle("menu-open", open);
});

mainNav.addEventListener("click", (e) => {
  if (e.target.closest("a")) {
    mainNav.classList.remove("open");
    menuToggle.classList.remove("active");
    menuToggle.setAttribute("aria-expanded", "false");
    document.body.classList.remove("menu-open");
  }
});

// Category tabs
categoryTabs.addEventListener("click", (e) => {
  const btn = e.target.closest("[data-category]");
  if (btn) setCategory(btn.dataset.category);
});

// Quick category list
quickCategoryList?.addEventListener("click", (e) => {
  const btn = e.target.closest("[data-quick-category]");
  if (btn) jumpToCategory(btn.dataset.quickCategory);
});

// Template card click
templatesGrid.addEventListener("click", (e) => {
  const btn = e.target.closest("[data-template]");
  if (btn) openOrder(btn.dataset.template);
});

// Modal close
orderModal.addEventListener("click", (e) => {
  if (e.target.closest("[data-close-modal]")) closeOrder();
});

document.addEventListener("keydown", (e) => {
  if (e.key === "Escape" && orderModal.classList.contains("open")) closeOrder();
});

// Preview → choose mode
$("#nextToChooseMode")?.addEventListener("click", () => {
  showModalStep("choose");
});

// Choose: do it myself → go to form step 1
$("#modeDoItMyself")?.addEventListener("click", () => {
  showModalStep("form");
  showFormStep(1);
  renderNameFields();
  renderReadyTexts();
});

// Choose: ask manager → go to WhatsApp
$("#modeAskManager")?.addEventListener("click", () => {
  const tpl  = currentTemplate();
  const cat  = currentCategory();
  const lang = state.language;
  const text = lang === "ru"
    ? `Здравствуйте! Хочу заказать приглашение: ${cat.id === "uilenu" ? "Свадьба" : categoryLabel(cat)}, шаблон "${tpl.title}". Помогите, пожалуйста.`
    : lang === "uz"
    ? `Salom! Taklifnoma buyurtma qilmoqchiman: ${categoryLabel(cat)}, andoza "${tpl.title}". Yordam bering.`
    : `Сәлеметсіз бе! Шақыру тапсырыс бергім келеді: ${categoryLabel(cat)}, үлгі "${tpl.title}". Көмектесіңіз.`;
  window.open(`https://wa.me/${whatsappNumber}?text=${encodeURIComponent(text)}`, "_blank");
  closeOrder();
});

// Back to preview from form
$("#backToPreviewFromForm")?.addEventListener("click", () => {
  showModalStep("preview");
});

// Form step navigation
$("#step1Next")?.addEventListener("click", () => {
  if (!validateStep(1)) { alertRequired(); return; }
  showFormStep(2);
});

$("#step2Prev")?.addEventListener("click", () => showFormStep(1));
$("#step2Next")?.addEventListener("click", () => {
  if (!validateStep(2)) { alertRequired(); return; }
  showFormStep(3);
});

$("#step3Prev")?.addEventListener("click", () => showFormStep(2));
$("#step3Next")?.addEventListener("click", () => {
  if (!validateStep(3)) { alertRequired(); return; }
  showFormStep(4);
  renderMusicOptions();
});

$("#step4Prev")?.addEventListener("click", () => showFormStep(3));

// Preview button — open in new tab with watermark
$("#step4Preview")?.addEventListener("click", () => {
  const tpl = currentTemplate();
  const cat = currentCategory();
  const lang = state.language;

  const dateVal = $("#eventDate")?.value || "";
  const timeVal = $("#eventTime")?.value || "";
  const cityVal = ($("#eventCity")?.value || "").trim();
  const addrVal = ($("#address")?.value || "").trim();
  const gisLink = ($("#gisLink")?.value || "").trim();
  const textVal = ($("#customText")?.value || "").trim();
  const organizerVal = ($("#organizerNames")?.value || "").trim();
  const musicVal = $("#musicSelect")?.value || "";
  const mainNames = buildMainNames();

  const queryParams = new URLSearchParams({
    templateId: tpl.id,
    category: categoryLabel(cat),
    lang: lang,
    eventDate: dateVal,
    eventTime: timeVal,
    city: cityVal,
    address: addrVal,
    gisLink: gisLink,
    customText: textVal,
    organizerNames: organizerVal,
    music: musicVal,
    mainNames: mainNames,
    preview: "1"
  });

  window.open(`preview.php?${queryParams.toString()}`, "_blank");
});

// Submit order — directly from step 4
$("#step4Next")?.addEventListener("click", () => {
  submitOrder();
});

// Back from full preview to form — full reset
$("#backToFormBtn")?.addEventListener("click", () => {
  // Clear iframe to prevent stale content
  const previewIframe = document.getElementById("previewIframe");
  if (previewIframe) { previewIframe.src = "about:blank"; }
  showModalStep("form");
  showFormStep(4);
});

// Language select
languageSelect?.addEventListener("change", () => {
  state.language = languageSelect.value;
  applyLanguage();
});

inviteLanguage?.addEventListener("change", () => {
  state.language = inviteLanguage.value;
  applyLanguage();
});

// Ready text select
readyTextSelect?.addEventListener("change", () => {
  const texts = activeReadyTexts();
  if (customText) customText.value = texts[Number(readyTextSelect.value)] || "";
});

// Music select
musicSelect?.addEventListener("change", () => {
  if (customMusicRow) customMusicRow.style.display = musicSelect.value === "custom" ? "grid" : "none";
});

// Product type
productType?.addEventListener("change", () => {
  renderReadyTexts();
  updatePriceDisplay();
});

// ── Init ──────────────────────────────────────────────────
footerWhatsapp.href = buildWhatsappLink();
if (customMusicRow) customMusicRow.style.display = "none";
applyLanguage();
loadPricing();

// ── openOrderFromExample (called from example.php via opener) ─
window.openOrderFromExample = function(templateId) {
  // Find the category for this template
  let found = false;
  for (const cat of categories) {
    const tpl = cat.templates.find(t => t.id === templateId);
    if (tpl) {
      state.categoryId = cat.id;
      state.templateId = tpl.id;
      found = true;
      break;
    }
  }
  if (!found) return;
  renderAll();
  openOrder(templateId);
  // Scroll to modal
  document.getElementById('orderModal')?.scrollIntoView({ behavior: 'smooth' });
};

// ── Handle ?order= URL param (from example page redirect) ──
(function() {
  const params = new URLSearchParams(window.location.search);
  const orderTpl = params.get('order');
  const orderLang = params.get('lang');
  if (orderTpl) {
    if (orderLang && i18n[orderLang]) {
      state.language = orderLang;
    }
    // Wait for DOM to settle, then open modal
    setTimeout(() => {
      window.openOrderFromExample && window.openOrderFromExample(orderTpl);
    }, 400);
  }
})();
