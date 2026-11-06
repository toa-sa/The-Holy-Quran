<?php
declare(strict_types=1);

/**
 * Where the X publishing studio gets its weekly texts.
 *
 * Every religious text a generated week contains is quoted from data the site
 * already serves: the Quran from api/quran/includes/uthmani, the Muyassar
 * tafseer from api/quran/includes/tafseer/6, hadith from the Muwatta in
 * api/muwatta/muwatta.json, and adhkar from includes/adhkar-data.php. Nothing
 * here writes or paraphrases those texts; the lists below only say which
 * passages to quote, and the administrator approves every post before it goes
 * out.
 *
 * Rotation is deterministic: week N of the calendar takes the next items of
 * each list after week N-1, so a list is used up completely before any of its
 * items repeats, and regenerating the same week always gives the same posts.
 *
 * Pure reads with no side effects on include.
 */

// ---------------------------------------------------------------------------
// Curated lists (edit these to change what the studio quotes)
// ---------------------------------------------------------------------------

/**
 * Daily verses. Each entry is [surah, first ayah, last ayah, first word, last word];
 * the word range is 0, 0 for whole verses, otherwise a 1-based slice of the
 * first verse as the site's Uthmani text splits it on spaces.
 */
function qfa_x_sources_ayat(): array {
    return [
        [2, 152, 152, 0, 0],
        [2, 153, 153, 0, 0],
        [2, 156, 156, 0, 0],
        [2, 186, 186, 0, 0],
        [2, 201, 201, 0, 0],
        [2, 216, 216, 8, 14],
        [2, 222, 222, 26, 31],
        [2, 195, 195, 11, 16],
        [2, 286, 286, 1, 6],
        [3, 8, 8, 0, 0],
        [3, 31, 31, 0, 0],
        [3, 92, 92, 0, 0],
        [3, 133, 133, 0, 0],
        [3, 139, 139, 0, 0],
        [3, 159, 159, 25, 34],
        [3, 173, 173, 14, 17],
        [3, 190, 190, 0, 0],
        [3, 200, 200, 0, 0],
        [5, 2, 2, 41, 44],
        [6, 162, 163, 0, 0],
        [7, 23, 23, 0, 0],
        [7, 55, 55, 0, 0],
        [7, 56, 56, 11, 16],
        [7, 180, 180, 1, 5],
        [7, 199, 199, 0, 0],
        [7, 205, 205, 0, 0],
        [8, 46, 46, 10, 15],
        [9, 40, 40, 19, 23],
        [9, 51, 51, 0, 0],
        [9, 129, 129, 0, 0],
        [10, 62, 62, 0, 0],
        [11, 61, 61, 28, 31],
        [11, 88, 88, 31, 39],
        [11, 114, 114, 9, 12],
        [11, 115, 115, 0, 0],
        [12, 18, 18, 14, 18],
        [12, 64, 64, 13, 19],
        [12, 86, 86, 2, 7],
        [12, 87, 87, 7, 11],
        [12, 101, 101, 21, 24],
        [13, 28, 28, 0, 0],
        [14, 7, 7, 0, 0],
        [14, 40, 41, 0, 0],
        [15, 49, 49, 0, 0],
        [15, 97, 99, 0, 0],
        [16, 18, 18, 0, 0],
        [16, 53, 53, 0, 0],
        [16, 97, 97, 0, 0],
        [16, 128, 128, 0, 0],
        [17, 24, 24, 7, 12],
        [17, 80, 80, 0, 0],
        [20, 25, 28, 0, 0],
        [20, 46, 46, 2, 8],
        [20, 84, 84, 6, 9],
        [20, 114, 114, 16, 19],
        [21, 83, 83, 0, 0],
        [21, 87, 87, 15, 23],
        [21, 89, 89, 5, 11],
        [21, 107, 107, 0, 0],
        [23, 1, 2, 0, 0],
        [23, 97, 98, 0, 0],
        [23, 118, 118, 0, 0],
        [24, 22, 22, 20, 29],
        [24, 35, 35, 2, 5],
        [25, 58, 58, 1, 8],
        [25, 63, 63, 0, 0],
        [25, 74, 74, 0, 0],
        [26, 78, 82, 0, 0],
        [26, 83, 83, 0, 0],
        [27, 62, 62, 1, 7],
        [28, 24, 24, 8, 15],
        [29, 45, 45, 17, 19],
        [29, 69, 69, 0, 0],
        [33, 41, 42, 0, 0],
        [35, 15, 15, 0, 0],
        [39, 10, 10, 19, 24],
        [39, 36, 36, 1, 4],
        [39, 53, 53, 0, 0],
        [40, 44, 44, 6, 14],
        [40, 60, 60, 3, 5],
        [41, 34, 34, 0, 0],
        [42, 11, 11, 17, 23],
        [42, 19, 19, 1, 3],
        [46, 15, 15, 25, 42],
        [47, 19, 19, 1, 8],
        [49, 10, 10, 0, 0],
        [50, 16, 16, 10, 15],
        [51, 50, 50, 1, 3],
        [51, 56, 56, 0, 0],
        [53, 39, 39, 0, 0],
        [55, 13, 13, 0, 0],
        [55, 26, 27, 0, 0],
        [55, 60, 60, 0, 0],
        [57, 4, 4, 30, 34],
        [59, 22, 22, 0, 0],
        [59, 23, 23, 0, 0],
        [59, 24, 24, 0, 0],
        [64, 11, 11, 9, 13],
        [65, 2, 2, 27, 32],
        [65, 3, 3, 7, 12],
        [67, 1, 1, 0, 0],
        [67, 2, 2, 0, 0],
        [67, 14, 14, 0, 0],
        [71, 10, 12, 0, 0],
        [87, 1, 1, 0, 0],
        [87, 14, 15, 0, 0],
        [87, 16, 17, 0, 0],
        [89, 27, 30, 0, 0],
        [93, 3, 5, 0, 0],
        [93, 11, 11, 0, 0],
        [94, 5, 6, 0, 0],
        [94, 7, 8, 0, 0],
        [96, 1, 1, 0, 0],
        [99, 7, 8, 0, 0],
        [103, 1, 3, 0, 0],
        [108, 1, 3, 0, 0],
        [112, 1, 4, 0, 0],
    ];
}

/**
 * Friday verses from Surat al-Kahf, in the same shape as the daily list.
 */
function qfa_x_sources_kahf(): array {
    return [
        [18, 10, 10, 0, 0],
        [18, 23, 24, 0, 0],
        [18, 39, 39, 6, 12],
        [18, 46, 46, 0, 0],
        [18, 109, 109, 0, 0],
        [18, 1, 1, 0, 0],
        [18, 28, 28, 1, 10],
        [18, 49, 49, 26, 29],
    ];
}

/**
 * Hadith from the site's Muwatta, as [book, chapter, item] positions in
 * api/muwatta/muwatta.json (all counted from 0).
 */
function qfa_x_sources_hadith(): array {
    return [
        [13, 1, 1],
        [13, 3, 1],
        [13, 4, 1],
        [13, 5, 0],
        [13, 5, 1],
        [13, 5, 2],
        [13, 5, 6],
        [41, 0, 2],
        [41, 1, 0],
        [41, 1, 1],
        [41, 2, 0],
        [41, 2, 1],
        [41, 3, 0],
        [41, 3, 2],
        [43, 2, 1],
        [43, 7, 1],
        [43, 7, 8],
        [47, 0, 0],
        [47, 3, 1],
        [49, 0, 1],
        [49, 5, 0],
        [49, 7, 1],
        [50, 0, 4],
        [50, 1, 3],
        [50, 1, 6],
    ];
}

/**
 * The Friday hadith on the hour of response, same shape as the list above.
 */
function qfa_x_sources_friday_hadith(): array {
    return [3, 2, 0];
}

/**
 * Arabic surah names exactly as the site's Quran API spells them, because the
 * studio matches 'سورة <name>' against that list to resolve the surah link.
 */
function qfa_x_sources_surah_names(): array {
    return [
        1 => 'الفاتحة',
        2 => 'البقرة',
        3 => 'آل عمران',
        4 => 'النساء',
        5 => 'المائدة',
        6 => 'الأنعام',
        7 => 'الأعراف',
        8 => 'الأنفال',
        9 => 'التوبة',
        10 => 'يونس',
        11 => 'هود',
        12 => 'يوسف',
        13 => 'الرعد',
        14 => 'إبراهيم',
        15 => 'الحجر',
        16 => 'النحل',
        17 => 'الإسراء',
        18 => 'الكهف',
        19 => 'مريم',
        20 => 'طه',
        21 => 'الأنبياء',
        22 => 'الحج',
        23 => 'المؤمنون',
        24 => 'النور',
        25 => 'الفرقان',
        26 => 'الشعراء',
        27 => 'النمل',
        28 => 'القصص',
        29 => 'العنكبوت',
        30 => 'الروم',
        31 => 'لقمان',
        32 => 'السجدة',
        33 => 'الأحزاب',
        34 => 'سبأ',
        35 => 'فاطر',
        36 => 'يس',
        37 => 'الصافات',
        38 => 'ص',
        39 => 'الزمر',
        40 => 'غافر',
        41 => 'فصلت',
        42 => 'الشورى',
        43 => 'الزخرف',
        44 => 'الدخان',
        45 => 'الجاثية',
        46 => 'الأحقاف',
        47 => 'محمد',
        48 => 'الفتح',
        49 => 'الحجرات',
        50 => 'ق',
        51 => 'الذاريات',
        52 => 'الطور',
        53 => 'النجم',
        54 => 'القمر',
        55 => 'الرحمن',
        56 => 'الواقعة',
        57 => 'الحديد',
        58 => 'المجادلة',
        59 => 'الحشر',
        60 => 'الممتحنة',
        61 => 'الصف',
        62 => 'الجمعة',
        63 => 'المنافقون',
        64 => 'التغابن',
        65 => 'الطلاق',
        66 => 'التحريم',
        67 => 'الملك',
        68 => 'القلم',
        69 => 'الحاقة',
        70 => 'المعارج',
        71 => 'نوح',
        72 => 'الجن',
        73 => 'المزمل',
        74 => 'المدثر',
        75 => 'القيامة',
        76 => 'الإنسان',
        77 => 'المرسلات',
        78 => 'النبأ',
        79 => 'النازعات',
        80 => 'عبس',
        81 => 'التكوير',
        82 => 'الانفطار',
        83 => 'المطففين',
        84 => 'الانشقاق',
        85 => 'البروج',
        86 => 'الطارق',
        87 => 'الأعلى',
        88 => 'الغاشية',
        89 => 'الفجر',
        90 => 'البلد',
        91 => 'الشمس',
        92 => 'الليل',
        93 => 'الضحى',
        94 => 'الشرح',
        95 => 'التين',
        96 => 'العلق',
        97 => 'القدر',
        98 => 'البينة',
        99 => 'الزلزلة',
        100 => 'العاديات',
        101 => 'القارعة',
        102 => 'التكاثر',
        103 => 'العصر',
        104 => 'الهمزة',
        105 => 'الفيل',
        106 => 'قريش',
        107 => 'الماعون',
        108 => 'الكوثر',
        109 => 'الكافرون',
        110 => 'النصر',
        111 => 'المسد',
        112 => 'الإخلاص',
        113 => 'الفلق',
        114 => 'الناس',
    ];
}

// ---------------------------------------------------------------------------
// Readers
// ---------------------------------------------------------------------------

/** Root of the site's data, fixed from __DIR__. */
function qfa_x_sources_root(): string {
    return dirname(__DIR__);
}

/**
 * Load a "$var = array(...)" data file from the Quran API without leaking its
 * variable into the caller. Returns [] when the file is missing or unusable.
 */
function qfa_x_sources_load_array(string $file, string $var): array {
    static $cache = [];
    $key = $file . '#' . $var;
    if (array_key_exists($key, $cache)) {
        return $cache[$key];
    }

    $data = [];
    if (is_file($file) && is_readable($file)) {
        $data = (static function (string $__file, string $__var): array {
            include $__file;
            return (isset($$__var) && is_array($$__var)) ? $$__var : [];
        })($file, $var);
    }

    return $cache[$key] = $data;
}

/** One verse of the site's Uthmani text, or '' when it is not there. */
function qfa_x_sources_ayah(int $surah, int $ayah): string {
    if ($surah < 1 || $surah > 114 || $ayah < 1) {
        return '';
    }
    $verses = qfa_x_sources_load_array(qfa_x_sources_root() . '/api/quran/includes/uthmani/' . $surah . '.php', 'q');
    return isset($verses[$ayah]) ? trim((string)$verses[$ayah]) : '';
}

/**
 * The quoted Quran text for one list entry, exactly as the site stores it.
 * A word range takes a slice of the first verse; whole verses are joined with
 * the end-of-verse sign.
 */
function qfa_x_sources_ayah_text(array $entry): string {
    [$surah, $from, $to, $wordFrom, $wordTo] = array_map('intval', $entry);

    if ($wordFrom > 0) {
        $words = explode(' ', qfa_x_sources_ayah($surah, $from));
        if ($wordTo < $wordFrom || $wordTo > count($words)) {
            return '';
        }
        return trim(implode(' ', array_slice($words, $wordFrom - 1, $wordTo - $wordFrom + 1)));
    }

    $parts = [];
    for ($ayah = $from; $ayah <= $to; $ayah++) {
        $text = qfa_x_sources_ayah($surah, $ayah);
        if ($text === '') {
            return '';
        }
        $parts[] = $text;
    }
    return implode(' ۝ ', $parts);
}

/** The Muyassar tafseer of one verse as plain text, or ''. */
function qfa_x_sources_muyassar(int $surah, int $ayah): string {
    $rows = qfa_x_sources_load_array(qfa_x_sources_root() . '/api/quran/includes/tafseer/6/' . $surah . '.php', 't');
    if (!isset($rows[$ayah])) {
        return '';
    }
    // The tafseer marks quoted Quran words with ornate parentheses inside a span.
    $text = strtr((string)$rows[$ayah], ["\u{FD61}" => '﴿', "\u{FD60}" => '﴾']);
    $text = html_entity_decode(strip_tags($text), ENT_QUOTES, 'UTF-8');
    return trim((string)preg_replace('~\s+~u', ' ', $text));
}

/**
 * Length as the studio's counter and X's limit see it: UTF-16 code units,
 * worked out from the UTF-8 bytes so mbstring is not required.
 */
function qfa_x_sources_length(string $text): int {
    return preg_match_all('~[^\x80-\xBF]~', $text) + preg_match_all('~[\xF0-\xF4]~', $text);
}

/** Arabic-Indic digits for verse numbers. */
function qfa_x_sources_digits(int $number): string {
    return strtr((string)$number, ['0' => '٠', '1' => '١', '2' => '٢', '3' => '٣', '4' => '٤', '5' => '٥', '6' => '٦', '7' => '٧', '8' => '٨', '9' => '٩']);
}

/** The Muwatta text of one hadith, joined from its paragraphs, or ''. */
function qfa_x_sources_hadith_text(array $ref): string {
    static $muwatta = null;
    if ($muwatta === null) {
        $file = qfa_x_sources_root() . '/api/muwatta/muwatta.json';
        $decoded = is_readable($file) ? json_decode((string)file_get_contents($file), true) : null;
        $muwatta = is_array($decoded) ? $decoded : [];
    }

    [$book, $chapter, $item] = array_map('intval', $ref);
    $node = $muwatta['books'][$book]['chapters'][$chapter]['items'][$item]['matn'] ?? null;
    if (!is_array($node)) {
        return '';
    }

    $paragraphs = [];
    foreach ($node as $paragraph) {
        $line = '';
        foreach ((array)$paragraph as $run) {
            // Runs are [text, flag]; footnote markers are {"note": n} and carry no text.
            if (is_array($run) && isset($run[0]) && is_string($run[0])) {
                $line .= $run[0];
            }
        }
        if (trim($line) !== '') {
            $paragraphs[] = trim($line);
        }
    }
    return trim(implode(' ', $paragraphs));
}

/**
 * Adhkar short enough for one post, from the site's morning and evening lists,
 * each title once. Each entry is [text, source].
 */
function qfa_x_sources_adhkar(): array {
    require_once __DIR__ . '/adhkar-data.php';

    $seen = [];
    $out = [];
    foreach (array_merge(qfa_adhkar_morning_items(), qfa_adhkar_evening_items()) as $item) {
        $title = (string)$item[0];
        if (isset($seen[$title])) {
            continue;
        }
        $seen[$title] = true;

        $text = trim(html_entity_decode(strip_tags(str_ireplace(['<br>', '<br/>', '<br />'], "\n", (string)$item[1])), ENT_QUOTES, 'UTF-8'));
        $post = $text . "\n\n📚 " . trim((string)$item[3]);
        if (qfa_x_sources_length($post) <= 280) {
            $out[] = $post;
        }
    }
    return $out;
}

// ---------------------------------------------------------------------------
// Post builders
// ---------------------------------------------------------------------------

/**
 * A verse post: the verse, its reference, the Muyassar line when the whole
 * post still fits in one tweet, and the surah link placeholder.
 */
function qfa_x_sources_ayah_post(array $entry, string $header = ''): string {
    $quote = qfa_x_sources_ayah_text($entry);
    if ($quote === '') {
        return '';
    }

    [$surah, $from, $to, $wordFrom] = array_map('intval', $entry);
    $names = qfa_x_sources_surah_names();
    $name = $names[$surah] ?? '';
    if ($name === '') {
        return '';
    }

    $range = qfa_x_sources_digits($from) . ($to > $from ? '–' . qfa_x_sources_digits($to) : '');
    $head = ($header !== '' ? $header . "\n\n" : '');
    $body = '﴿' . $quote . '﴾ [' . $name . ': ' . $range . ']';
    $foot = "\n\n📖 سورة " . $name . ': [رابط السورة]';

    // The placeholder becomes a link X shortens to 23 characters, so budget for that.
    $linkGrowth = 23 - qfa_x_sources_length('[رابط السورة]');

    if ($wordFrom === 0 && $to === $from) {
        $tafseer = qfa_x_sources_muyassar($surah, $from);
        if ($tafseer !== '') {
            $withTafseer = $head . $body . "\n\nالتفسير الميسر: " . $tafseer . $foot;
            if (qfa_x_sources_length($withTafseer) + $linkGrowth <= 280) {
                return $withTafseer;
            }
        }
    }

    return $head . $body . $foot;
}

/** A hadith post, attributed to the Muwatta. */
function qfa_x_sources_hadith_post(array $ref): string {
    $text = qfa_x_sources_hadith_text($ref);
    return ($text === '' ? '' : $text . "\n\n📚 موطأ الإمام مالك");
}

/**
 * Index of the operating week counted from the first Sunday of 2026, so that
 * consecutive weeks take consecutive slices of every list.
 */
function qfa_x_sources_week_index(string $startDate): int {
    $epoch = strtotime('2026-01-04 00:00:00 UTC');
    $start = strtotime($startDate . ' 00:00:00 UTC');
    if ($epoch === false || $start === false) {
        return 0;
    }
    return intdiv($start - $epoch, 7 * 86400);
}

/** The k-th item of this week's slice of a list of the given size. */
function qfa_x_sources_pick(int $size, int $week, int $perWeek, int $k): int {
    if ($size <= 0) {
        return 0;
    }
    $position = ($week * $perWeek + $k) % $size;
    return ($position < 0 ? $position + $size : $position);
}
