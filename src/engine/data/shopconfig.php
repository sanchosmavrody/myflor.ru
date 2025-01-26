<?php

//define('ZADARMA_KEY', '2ea5a97fcfd4cbb18a45');
//define('ZADARMA_SECRET', 'eab2e2bd83dc871066aa');

define('ZADARMA_KEY', 'cd2c3c5aac353099045e');
define('ZADARMA_SECRET', 'd62891cf92c80bbccd03');

define('SMSER_LOGIN', 'idealflorist');
define('SMSER_PASSWORD', 'idealflorist321');
define('SMSER_SENDER', 'I.F');


define('TTF_TERMINAL', '1550565506921');//1550565506921
define('TTF_SECRET', 'ob6ql6zjo0akea2e');//ob6ql6zjo0akea2e


define('dadatatoken', '5eaf99e5874141a6ce002e8d3badc229ecb42825');


define('ADMIN_SMS_PUSH', '');//79999805913,79999805913

define('PRICE_SHEETID', '1NN-SEHaweoz9jQMZ3K6BgeW_0bQ_z9-6bfG8XSgYj_I');
const RegXPLib = ['pay_sb' => ['part' => "card|kard|сard|на карту|накарту|sber|sb|сбер|сб",
    'regxp' => '(\!|#)(__part__)\s?([0-9]{2,6})'],
    'prepay' => ['part' => "prepay|предоплата",
        'regxp' => '(\!|#)(__part__)\s?([0-9]{2,6})'],
    'prepayed' => ['part' => "prepayed|внес предоплату",
        'regxp' => '(\!|#)(__part__)\s?([0-9]{2,6})'],

    'morepay' => ['part' => "morepay|доплата",
        'regxp' => '(\!|#)(__part__)\s?([0-9]{2,6})'],
    'morepayed' => ['part' => "morepayed|доплатил",
        'regxp' => '(\!|#)(__part__)\s?([0-9]{2,6})'],

    // 'tag_group' => ['part'  => "m|g|м|г|M|G|М|Г|m-|g-|м-|г-|M-|G-|М-|Г-",
    //     'regxp' => '(\!|#)(__part__)\s?([0-9]{2,6})'],

    'tag_group' => ['part' => "m|g|г|M|G|М|Г|m-|g-|м-|г-|M-|G-|М-|Г-",
        'regxp' => '(\!|#)(__part__)\s?([ а-яА-Яa-zA-Z0-9.-]){2,45}(\W|$| |\n|\r)'],

    'pay_online' => ['part' => "online|rk|RK|оnline|онлайн|рк",
        'regxp' => '(\!|#)(__part__)\s?([0-9]{2,6})'],
    'remind' => ['part' => "remind|rmnd|rm|rem|напомнить",
        'regxp' => '(\!|#)(remind|rmnd|rm|rem|напомнить)\s([0-9:.,\s]{5,10})\s([0-9:\s]{5})'],
    'tag_info' => ['part' => "НА ОПЛАТЕ|фотОтправлено",
        'regxp' => '(\!|#)(__part__)'],
    'tag_warning' => ['part' => "звонок|фото|записка:|Записка:|аноним|анононимно|инкогнито|сюрприз|Анониманая доставка|Анонимная доставка|чек|сдача",
        'regxp' => '(\!|#)(__part__)'],
    'tag_danger' => ['part' => "замена|курьеру|КУРЬЕРУ|флористу|менеджеру|оператору|из8марта",
        'regxp' => '(\!|#)(__part__)'],
    'tag_default' => ['part' => "",
        'regxp' => ''],];

const TranslateEnum = ["periodFrom" => "C",
    "periodTo" => "По",
    "addProduct" => "Добавить составляющую",
    "addItem" => "Добавить товар",
    "lastDebt" => "Долг",
    "calcSum" => "Сумма",
    "FDateAdd" => "Дата",
    "correctionSum" => "Корекция",
    "correctionComment" => "Камент корекции",
    "totalDebt" => "Итого",
    "closedSum" => "Оплачено",
    "typeEnum" => "Тип",
    "responsibleUserId" => "Сотрудник",
    "Comment" => "Камент",
    "sdacha" => "Сдача",
    "costExpenses" => "c/c р. ",
    "costFact" => "c/c ф.",
    "level" => "Бал",
    "buketCount" => "Букетов",
    "Date" => "Выполнен",
    "courierName" => "Имя",
    "floristName" => "Флорист",
    "Name" => "Имя",
    "orderId" => "№",
    "paymentType" => "Оплата",
    "totalSumm" => "Сумма",
    "payedSummOnline" => "Онлайн",
    "payedSummRs" => "РС",
    "payedSummCash" => "Магазин",
    "payedSummCard" => "Сбер",
    "payedSummCourier" => "Получил",
    "costCourierFact" => "Доставка",
    "saldo" => "Расчет",
    "AdminComments" => "Каменты",

    "Status" => "Статус",
    "Amount" => "Сумма",
    "Phone" => "Телефон",
    "PaymentId" => "PaymentId",
    "pId" => "pId",
    "DateAdd" => "Дата",
    "orderId" => "Заказ",];

const levelFreeDost = 3500;
const dostMskPrice = 390;

const deliveryPriceList = ['metro' => 390,
    'railway' => 820,
    'province' => 1020];

const  AssembledList = [0 => 'Нет',
    1 => 'Закуплен',
    2 => 'В сборке',
    3 => 'Собран',
    4 => 'Оплачен',
    5 => 'Отложен',];


const FrameList = ['faq' => 'https://open.ivideon.com/embed/v2/?server=100-omdK8tRVUHQDY4Tbo8gyHL&camera=0&width=&height=&lang=ru',
    'prices' => 'https://docs.google.com/spreadsheets/d/1NN-SEHaweoz9jQMZ3K6BgeW_0bQ_z9-6bfG8XSgYj_I/edit?usp=drive_web&ouid=117628041981996032543'];
//const FrameList = ['faq'    => 'https://docs.google.com/document/d/11FL5g6Uux2GCrsoXhtE3QQmuWnsOa_bZmGtv0JRffoo/edit#heading=h.qh9l0jq55a8x',
//                   'prices' => 'https://docs.google.com/spreadsheets/d/1NN-SEHaweoz9jQMZ3K6BgeW_0bQ_z9-6bfG8XSgYj_I/edit?usp=drive_web&ouid=117628041981996032543'];

//https://open.ivideon.com/embed/v2/?server=100-omdK8tRVUHQDY4Tbo8gyHL&amp;camera=0&amp;width=&amp;height=&amp;lang=ru

const paymentTypeLib = ['cash' => 'Курьеру',
    'online' => 'Онлайн',
    'card' => 'Сбер'];


const SrcLib = ['site',
    'site1click',
    'instagram',
    'chat',
    'phone',
    'whatsapp',
    'market',
    'flowwow',
    'flawery'];

const dellReasonLibs = ['Холодный лид',
    'Думает',
    'Предоплата',
    'Курьер',

    'Нет в наличии',
    'Возврат',
    'Дорого',
    'Долго',
    'Гнида',
    'Тест или дубль', 'Спам',];

const TplText = ['SENDPHOTO_compleet' => 'Фото с получателем', 'SENDPHOTO_assembled' => 'Ваш заказ собран'];



//<div class="iv-embed" style="margin:0 auto;padding:0;border:0;width:1282px;"><div class="iv-v" style="display:block;margin:0;padding:1px;border:0;background:#000;"><iframe class="iv-i" style="display:block;margin:0;padding:0;border:0;" src="https://open.ivideon.com/embed/v2/?server=100-omdK8tRVUHQDY4Tbo8gyHL&amp;camera=0&amp;width=&amp;height=&amp;lang=ru" width="1280" height="720" frameborder="0" allowfullscreen></iframe></div><div class="iv-b" style="display:block;margin:0;padding:0;border:0;"><div style="float:right;text-align:right;padding:0 0 10px;line-height:10px;"><a class="iv-a" style="font:10px Verdana,sans-serif;color:inherit;opacity:.6;" href="https://www.ivideon.com/" target="_blank">Powered by Ivideon</a></div><div style="clear:both;height:0;overflow:hidden;">&nbsp;</div><script src="https://open.ivideon.com/embed/v2/embedded.js"></script></div></div>

