<?php

return [
    'supportedLocales' => [
        'en'          => ['name' => 'English',                'script' => 'Latn', 'native' => 'English', 'regional' => 'en_GB'],
        'nl'          => ['name' => 'Dutch',                  'script' => 'Latn', 'native' => 'Nederlands', 'regional' => 'nl_NL'],
        'de'          => ['name' => 'German',                 'script' => 'Latn', 'native' => 'Deutsch', 'regional' => 'de_DE'],
        'tr'          => ['name' => 'Turkish',                'script' => 'Latn', 'native' => 'Türkçe', 'regional' => 'tr_TR'],
        'es'          => ['name' => 'Spanish',                'script' => 'Latn', 'native' => 'Español', 'regional' => 'es_ES'],
        'it'          => ['name' => 'Italian',                'script' => 'Latn', 'native' => 'italiano', 'regional' => 'it_IT'],
        'ru'          => ['name' => 'Russian',                'script' => 'Cyrl', 'native' => 'русский', 'regional' => 'ru_RU'],
        'fr'          => ['name' => 'French',                 'script' => 'Latn', 'native' => 'Français', 'regional' => 'fr_FR'],
        'ar'          => ['name' => 'Arabic',                 'script' => 'Arab', 'native' => 'العربية', 'regional' => 'ar_AE'],
        'el'          => ['name' => 'Greek',                  'script' => 'Grek', 'native' => 'Ελληνικά', 'regional' => 'el_GR'],
        'pl'          => ['name' => 'Polish',                 'script' => 'Latn', 'native' => 'polski', 'regional' => 'pl_PL'],
        'ro'          => ['name' => 'Romanian',               'script' => 'Latn', 'native' => 'română', 'regional' => 'ro_RO'],
        'uk'          => ['name' => 'Ukrainian',              'script' => 'Cyrl', 'native' => 'українська', 'regional' => 'uk_UA'],
        'bg'          => ['name' => 'Bulgarian',              'script' => 'Cyrl', 'native' => 'български', 'regional' => 'bg_BG'],
        'pt'          => ['name' => 'Portuguese',             'script' => 'Latn', 'native' => 'português', 'regional' => 'pt_PT'],
        'sr'          => ['name' => 'Serbian (Cyrillic)',     'script' => 'Cyrl', 'native' => 'Српски', 'regional' => 'sr_RS'],
        'sv'          => ['name' => 'Swedish',                'script' => 'Latn', 'native' => 'svenska', 'regional' => 'sv_SE'],
        'da'          => ['name' => 'Danish',                 'script' => 'Latn', 'native' => 'Dansk', 'regional' => 'da_DK'],
        'fi'          => ['name' => 'Finnish',                'script' => 'Latn', 'native' => 'suomi', 'regional' => 'fi_FI'],
        'nn'          => ['name' => 'Norwegian Nynorsk',      'script' => 'Latn', 'native' => 'Norsk', 'regional' => 'nn_NO'],
        'hr'          => ['name' => 'Croatian',               'script' => 'Latn', 'native' => 'hrvatski', 'regional' => 'hr_HR'],
        'hu'          => ['name' => 'Hungarian',              'script' => 'Latn', 'native' => 'magyar', 'regional' => 'hu_HU'],
        'cs'          => ['name' => 'Czech',                  'script' => 'Latn', 'native' => 'čeština', 'regional' => 'cs_CZ'],
        'sq'          => ['name' => 'Albanian',               'script' => 'Latn', 'native' => 'shqip', 'regional' => 'sq_AL'],
        'bs'          => ['name' => 'Bosnian',                'script' => 'Latn', 'native' => 'Bosanski', 'regional' => 'bs_BA'],
        'lt'          => ['name' => 'Lithuanian',             'script' => 'Latn', 'native' => 'lietuvių', 'regional' => 'lt_LT'],
        'sl'          => ['name' => 'Slovene',                'script' => 'Latn', 'native' => 'slovenščina', 'regional' => 'sl_SI'],
        'sk'          => ['name' => 'Slovak',                 'script' => 'Latn', 'native' => 'slovenčina', 'regional' => 'sk_SK'],
        'zh'          => ['name' => 'Chinese (Simplified)',   'script' => 'Hans', 'native' => '简体中文', 'regional' => 'zh_CN'],
        'ko'          => ['name' => 'Korean',                 'script' => 'Hang', 'native' => '한국어', 'regional' => 'ko_KR'],
        'ja'          => ['name' => 'Japanese',               'script' => 'Jpan', 'native' => '日本語', 'regional' => 'ja_JP'],
    ],

    'useAcceptLanguageHeader' => true,

    'hideDefaultLocaleInURL' => true,

    'localesOrder' => [],

    'localesMapping' => [
        'zh' => 'zh-Hans',
        'nn' => 'no'
    ],

    'utf8suffix' => env('LARAVELLOCALIZATION_UTF8SUFFIX', '.UTF-8'),

    'urlsIgnored' => ['/skipped'],

    'httpMethodsIgnored' => ['POST', 'PUT', 'PATCH', 'DELETE'],
];
