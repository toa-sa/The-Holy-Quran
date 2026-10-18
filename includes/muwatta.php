<?php
/*
 * «مختصر الموطأ»: the index of books, a book's chapters and hadith, one hadith
 * at a time in the style of the tafseer page, and search.
 *
 * Data: api/muwatta/muwatta.json, the same file as the iOS app, built by the
 * app's tools/import-muwatta.php from the compiler's Word file. Every string
 * is shown as stored (only HTML-escaped); the compiler asked not to be named.
 *
 *   muwatta.php             index
 *   muwatta.php?book=N      book N (1-based)
 *   muwatta.php?h=ID        hadith or addition ID (0-based, book order)
 *   muwatta.php?q=WORD      search, ignoring diacritics and letter forms
 */

if (realpath((string)($_SERVER['SCRIPT_FILENAME'] ?? '')) === __FILE__) {
    http_response_code(403);
    exit;
}

const QFA_MUWATTA_TITLE = 'مختصر الموطأ';
const QFA_MUWATTA_DUA = 'اللهم اجزِ من جمعه واختصره خيرَ الجزاء، وانفع به وبعلمه، واجعله في ميزان حسناته.';

/*
 * «طريقة القراءة»: the meaning of each mark, after the «طريقة الكتاب» page of
 * the printed book and the compiler's explanation. Same text as the app; the
 * compiler's own wording replaces it when it arrives.
 */
const QFA_MUWATTA_GUIDE = [
    ['مختصر الموطأ', 'الأحاديث المسندة من موطأ الإمام مالك برواية يحيى بن يحيى الليثي، مع زيادات من رواية غيره.'],
    ['★', 'ما رواه البخاري أو مسلم، ولو من غير طريق مالك. وعلامته في الكتاب «*» عند رقم الحديث.'],
    ['المسند', 'الحديث الذي اتصل سنده إلى النبي ﷺ، رواه كل راوٍ عمّن فوقه.'],
    ['خط تحت الراوي', 'الحديث مرسل.'],
    ['موصول', 'تُكتب في آخر الحديث المرسل إذا جاء موصولًا عند البخاري أو مسلم، ولو من طريق آخر.'],
    ['التقصّي', 'الرقم في آخر الحديث هو رقمه في كتاب «التقصّي» لابن عبد البر.'],
    ['زيادة', 'حديث من غير رواية يحيى بن يحيى الليثي، وُضع في الباب الذي يناسبه.'],
    ['الرقم الصغير فوق الكلمة', 'تعليق على هذا الموضع، وتجده تحت الحديث.'],
];
const QFA_MUWATTA_GUIDE_SOURCES = 'قوبل الكتاب بكتاب «التقصّي» لابن عبد البر، و«مسند الموطأ» للجوهري، و«أحاديث الموطأ» للدارقطني.';

function qfa_muwatta_data(): array {
    static $data = null;
    if ($data === null) {
        $json = @file_get_contents(dirname(__DIR__) . '/api/muwatta/muwatta.json');
        $data = is_string($json) ? (json_decode($json, true) ?: []) : [];
        $data['entries'] = [];
        foreach ($data['books'] ?? [] as $b => $book) {
            foreach ($book['chapters'] as $c => $chapter) {
                foreach ($chapter['items'] as $item) {
                    $data['entries'][] = ['book' => $b, 'chapter' => $c, 'item' => $item];
                }
            }
        }
    }
    return $data;
}

function qfa_muwatta_e(string $s): string {
    return htmlspecialchars($s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function qfa_muwatta_num(int $n): string {
    return strtr((string)$n, ['0' => '٠', '1' => '١', '2' => '٢', '3' => '٣', '4' => '٤', '5' => '٥', '6' => '٦', '7' => '٧', '8' => '٨', '9' => '٩']);
}

/** Search key: same as ArabicNormalizer.skeleton in the app. */
function qfa_muwatta_key(string $s): string {
    $s = preg_replace('/[\x{0610}-\x{061A}\x{064B}-\x{065F}\x{0670}\x{06D6}-\x{06ED}\x{08F0}-\x{08F2}\x{0640}\x{FEFF}\x{200B}-\x{200F}\x{2060}]/u', '', $s);
    $s = preg_replace('/[\x{0671}\x{0622}\x{0623}\x{0625}\x{0672}\x{0673}]/u', "\u{0627}", $s);
    $s = preg_replace('/[\x{0649}\x{06CC}\x{0626}]/u', "\u{064A}", $s);
    $s = str_replace(["\u{0629}", "\u{0624}"], ["\u{0647}", "\u{0648}"], $s);
    $s = trim(preg_replace('/[\s\x{00A0}]+/u', ' ', $s));
    return str_replace("\u{0627}", '', $s);
}

function qfa_muwatta_plain(array $paragraph): string {
    $out = '';
    foreach ($paragraph as $run) {
        if (isset($run[0])) {
            $out .= $run[0];
        }
    }
    return $out;
}

function qfa_muwatta_paragraphs(array $item): array {
    return array_merge(isset($item['sanad']) && $item['sanad'] ? [$item['sanad']] : [], $item['matn']);
}

function qfa_muwatta_mursal(array $item): bool {
    foreach (qfa_muwatta_paragraphs($item) as $p) {
        foreach ($p as $run) {
            if (isset($run[1]) && $run[1] === true && trim($run[0]) !== '') {
                return true;
            }
        }
    }
    return false;
}

/** A paragraph as HTML: mursal narrators underlined, notes as raised numbers. */
function qfa_muwatta_html(array $paragraph, array &$noteOrder): string {
    $out = '';
    foreach ($paragraph as $run) {
        if (isset($run['note'])) {
            $noteOrder[] = (int)$run['note'];
            $out .= '<sup class="mw-note-ref">' . qfa_muwatta_num(count($noteOrder)) . '</sup>';
        } elseif ($run[1]) {
            $out .= '<u class="mw-mursal">' . qfa_muwatta_e($run[0]) . '</u>';
        } else {
            $out .= qfa_muwatta_e($run[0]);
        }
    }
    return $out;
}

function qfa_muwatta_badges(array $item): string {
    $b = [];
    if ($item['n'] === null) $b[] = '<span class="mw-badge mw-badge-add">زيادة</span>';
    if ($item['star']) $b[] = '<span class="mw-badge mw-badge-star">★ في الصحيحين</span>';
    if (qfa_muwatta_mursal($item)) $b[] = '<span class="mw-badge">مرسل</span>';
    if (!empty($item['label'])) $b[] = '<span class="mw-badge mw-badge-label">' . qfa_muwatta_e($item['label']) . '</span>';
    if (!empty($item['ref'])) $b[] = '<span class="mw-badge">التقصّي ' . qfa_muwatta_num((int)$item['ref']) . '</span>';
    return '<span class="mw-badges">' . implode('', $b) . '</span>';
}

function qfa_muwatta_opening(array $item, int $words = 12): string {
    $paras = ($item['n'] === null || !$item['matn']) ? qfa_muwatta_paragraphs($item) : $item['matn'];
    $text = implode(' ', array_map('qfa_muwatta_plain', $paras));
    $list = preg_split('/\s+/u', trim($text));
    return implode(' ', array_slice($list, 0, $words)) . (count($list) > $words ? ' …' : '');
}

function qfa_muwatta_chapters(int $count): string {
    if ($count === 1) return 'باب واحد';
    if ($count === 2) return 'بابان';
    return qfa_muwatta_num($count) . ($count <= 10 ? ' أبواب' : ' بابًا');
}

function qfa_muwatta_page($site): string {
    $data = qfa_muwatta_data();
    $base = $site->siteurl . '/muwatta.php';
    $site->headercode .= '<link rel="stylesheet" type="text/css" href="' . $site->get_theme_folder_url() . '/css/muwatta.css?v=1.0">';
    if (empty($data['books'])) {
        $site->title = QFA_MUWATTA_TITLE;
        $site->cache_allow_create = false;
        return '<section class="mw-page"><div class="container mw-container"><p>تعذّر تحميل الكتاب.</p></div></section>';
    }

    $search = '<form class="mw-search" action="' . qfa_muwatta_e($base) . '" method="get" role="search">'
        . '<i class="fas fa-search" aria-hidden="true"></i><input type="search" name="q" placeholder="ابحث في الموطأ" value="' . qfa_muwatta_e((string)($_GET['q'] ?? '')) . '" aria-label="ابحث في الموطأ"></form>';

    // reading guide
    if (isset($_GET['guide'])) {
        $site->title = 'طريقة القراءة - ' . QFA_MUWATTA_TITLE;
        $site->url = $base . '?guide=1';
        $code = '<nav class="mw-crumb"><a href="' . qfa_muwatta_e($base) . '">' . QFA_MUWATTA_TITLE . '</a></nav><header class="mw-head"><h1>طريقة القراءة</h1></header>';
        foreach (QFA_MUWATTA_GUIDE as [$mark, $meaning]) {
            if ($mark === 'خط تحت الراوي') {
                $title = '<span class="mw-hadith-line"><u class="mw-mursal">عن ابنِ شهابٍ</u></span>';
            } elseif ($mark === 'الرقم الصغير فوق الكلمة') {
                $title = '<span class="mw-hadith-line">شَعبَانُ<sup class="mw-note-ref">١</sup></span>';
            } else {
                $title = qfa_muwatta_e($mark);
            }
            $code .= '<div class="mw-block mw-guide"><p class="mw-guide-mark' . ($mark === '★' ? ' is-star' : '') . '">' . $title . '</p><p>' . qfa_muwatta_e($meaning) . '</p></div>';
        }
        $code .= '<p class="mw-legend">' . qfa_muwatta_e(QFA_MUWATTA_GUIDE_SOURCES) . '</p>';
        $code .= '<p class="mw-guide-start"><a class="mw-button" href="' . qfa_muwatta_e($base) . '">ابدأ القراءة</a></p>';
        $site->footercode .= '<script src="' . $site->get_theme_folder_url() . '/js/muwatta.js?v=1.0" defer></script>';
        return '<section class="mw-page" data-mw-guide><div class="container mw-container">' . $code . '</div></section>';
    }

    // hadith
    if (isset($_GET['h']) && ctype_digit((string)$_GET['h'])) {
        $id = (int)$_GET['h'];
        if (!isset($data['entries'][$id])) {
            $site->cache_allow_create = false;
            return '<section class="mw-page"><div class="container mw-container"><p>الحديث غير موجود.</p></div></section>';
        }
        $entry = $data['entries'][$id];
        $book = $data['books'][$entry['book']];
        $chapter = $book['chapters'][$entry['chapter']];
        $item = $entry['item'];
        $site->title = ($item['n'] === null ? 'زيادة' : 'الحديث ' . $item['n']) . ' - ' . QFA_MUWATTA_TITLE;
        $site->description = qfa_muwatta_opening($item, 25);
        $site->url = $base . '?h=' . $id;

        $notes = [];
        $code = '<nav class="mw-crumb"><a href="' . qfa_muwatta_e($base) . '">' . QFA_MUWATTA_TITLE . '</a> / <a href="' . qfa_muwatta_e($base . '?book=' . ($entry['book'] + 1)) . '">' . qfa_muwatta_e($book['title']) . '</a>'
            . ($chapter['title'] ? ' / ' . qfa_muwatta_e($chapter['title']) : '') . '</nav>';
        if ($item['n'] === null) {
            $code .= '<div class="mw-block mw-matn"><p class="mw-block-label">زيادة من غير رواية يحيى بن يحيى الليثي</p>';
            foreach ($item['matn'] as $p) $code .= '<p>' . qfa_muwatta_html($p, $notes) . '</p>';
            $code .= '</div>';
        } else {
            $matn = $item['matn'] ?: [$item['sanad']];
            $code .= '<div class="mw-block mw-matn">';
            foreach ($matn as $p) $code .= '<p>' . qfa_muwatta_html($p, $notes) . '</p>';
            $code .= '</div>';
            $code .= '<div class="mw-info"><span class="mw-num">' . qfa_muwatta_num((int)$item['n']) . '</span>' . qfa_muwatta_badges($item) . '</div>';
            if ($item['matn'] && $item['sanad']) {
                $code .= '<div class="mw-block mw-sanad"><p class="mw-block-label">السند</p><p>' . qfa_muwatta_html($item['sanad'], $notes) . '</p></div>';
            }
        }
        $noteText = static fn($nid) => implode('<br>', array_map(static fn($p) => qfa_muwatta_e(qfa_muwatta_plain($p)), $data['notes'][(string)$nid] ?? []));
        if ($notes || !empty($chapter['note'])) {
            $code .= '<div class="mw-block mw-notes"><p class="mw-block-label">تعليق</p>';
            if (!empty($chapter['note'])) {
                $code .= '<p>على عنوان الباب: ' . $noteText((int)$chapter['note']) . '</p>';
            }
            foreach ($notes as $i => $nid) {
                $code .= '<p>' . qfa_muwatta_num($i + 1) . '. ' . $noteText($nid) . '</p>';
            }
            $code .= '</div>';
        }
        $marks = [];
        if ($item['star']) $marks[] = '★ رواه البخاري أو مسلم.';
        if (qfa_muwatta_mursal($item)) $marks[] = '<u class="mw-mursal">الخط تحت الراوي</u>: الحديث مرسل' . (($item['label'] ?? '') === 'موصول' ? '، وهو موصول عند البخاري أو مسلم.' : '.');
        if (!empty($item['ref'])) $marks[] = 'رقمه في «التقصّي» لابن عبد البر: ' . qfa_muwatta_num((int)$item['ref']);
        if ($marks) $code .= '<div class="mw-marks">' . implode('<br>', $marks) . '</div>';

        $code .= '<nav class="tafseer-ayah-navigation mw-nav" aria-label="التنقل بين الأحاديث">';
        $label = static function ($e) { return $e['item']['n'] === null ? 'زيادة' : 'رقم ' . qfa_muwatta_num((int)$e['item']['n']); };
        if ($id > 0) {
            $code .= '<a href="' . qfa_muwatta_e($base . '?h=' . ($id - 1)) . '"><i class="fa fa-arrow-right" aria-hidden="true"></i><span>الحديث السابق<small>' . $label($data['entries'][$id - 1]) . '</small></span></a>';
        } else {
            $code .= '<span class="is-disabled"><i class="fa fa-arrow-right" aria-hidden="true"></i> الحديث السابق</span>';
        }
        if (isset($data['entries'][$id + 1])) {
            $code .= '<a href="' . qfa_muwatta_e($base . '?h=' . ($id + 1)) . '"><span>الحديث التالي<small>' . $label($data['entries'][$id + 1]) . '</small></span><i class="fa fa-arrow-left" aria-hidden="true"></i></a>';
        } else {
            $code .= '<span class="is-disabled">الحديث التالي <i class="fa fa-arrow-left" aria-hidden="true"></i></span>';
        }
        $code .= '</nav>';
        return '<section class="mw-page"><div class="container mw-container">' . $code . '</div></section>';
    }

    // search
    $query = trim((string)($_GET['q'] ?? ''));
    if ($query !== '') {
        $site->cache_allow_create = false;
        $site->title = 'البحث في ' . QFA_MUWATTA_TITLE;
        $site->url = $base;
        $key = qfa_muwatta_key($query);
        $rows = '';
        $count = 0;
        if (mb_strlen($key) >= 2) {
            foreach ($data['entries'] as $id => $entry) {
                $text = implode(' ', array_map('qfa_muwatta_plain', qfa_muwatta_paragraphs($entry['item'])));
                if (!str_contains(qfa_muwatta_key($text), $key)) continue;
                $count++;
                if ($count > 100) continue;
                $book = $data['books'][$entry['book']];
                $chapter = $book['chapters'][$entry['chapter']]['title'];
                $rows .= '<a class="mw-row" href="' . qfa_muwatta_e($base . '?h=' . $id) . '"><span class="mw-num">' . ($entry['item']['n'] === null ? 'ز' : qfa_muwatta_num((int)$entry['item']['n'])) . '</span>'
                    . '<span class="mw-row-text"><small>' . qfa_muwatta_e($book['title'] . ($chapter ? ' · ' . $chapter : '')) . '</small><span class="mw-hadith-line">' . qfa_muwatta_e(qfa_muwatta_opening($entry['item'], 18)) . '</span></span></a>';
            }
        }
        $code = '<header class="mw-head"><h1>' . QFA_MUWATTA_TITLE . '</h1></header>' . $search
            . '<p class="mw-count">' . ($count ? qfa_muwatta_num($count) . ' نتيجة · البحث بدون تشكيل' . ($count > 100 ? ' (أول ١٠٠)' : '') : 'لا توجد نتائج') . '</p>'
            . ($rows ? '<div class="mw-card">' . $rows . '</div>' : '');
        return '<section class="mw-page"><div class="container mw-container">' . $code . '</div></section>';
    }

    // book
    if (isset($_GET['book']) && ctype_digit((string)$_GET['book']) && isset($data['books'][(int)$_GET['book'] - 1])) {
        $b = (int)$_GET['book'] - 1;
        $book = $data['books'][$b];
        $site->title = $book['title'] . ' - ' . QFA_MUWATTA_TITLE;
        $site->url = $base . '?book=' . ($b + 1);
        $code = '<nav class="mw-crumb"><a href="' . qfa_muwatta_e($base) . '">' . QFA_MUWATTA_TITLE . '</a></nav><header class="mw-head"><h1>' . qfa_muwatta_e($book['title']) . '</h1></header>';
        foreach ($book['chapters'] as $c => $chapter) {
            if ($chapter['title']) $code .= '<h2 class="mw-chapter">' . qfa_muwatta_e($chapter['title']) . '</h2>';
            $code .= '<div class="mw-card">';
            foreach ($data['entries'] as $id => $entry) {
                if ($entry['book'] !== $b || $entry['chapter'] !== $c) continue;
                $item = $entry['item'];
                $code .= '<a class="mw-row" href="' . qfa_muwatta_e($base . '?h=' . $id) . '"><span class="mw-num">' . ($item['n'] === null ? 'ز' : qfa_muwatta_num((int)$item['n'])) . '</span>'
                    . '<span class="mw-row-text"><span class="mw-hadith-line">' . qfa_muwatta_e(qfa_muwatta_opening($item)) . '</span>' . qfa_muwatta_badges($item) . '</span></a>';
            }
            $code .= '</div>';
        }
        return '<section class="mw-page"><div class="container mw-container">' . $code . '</div></section>';
    }

    // index
    $site->title = QFA_MUWATTA_TITLE;
    $site->description = 'الأحاديث المسندة من موطأ الإمام مالك برواية يحيى بن يحيى الليثي، مفهرسة كتابًا كتابًا وبابًا بابًا، مع البحث.';
    $site->url = $base;
    $rows = '';
    foreach ($data['books'] as $b => $book) {
        $count = 0;
        foreach ($book['chapters'] as $ch) foreach ($ch['items'] as $it) if ($it['n'] !== null) $count++;
        $rows .= '<a class="mw-row" href="' . qfa_muwatta_e($base . '?book=' . ($b + 1)) . '"><span class="mw-num">' . qfa_muwatta_num($b + 1) . '</span>'
            . '<span class="mw-row-text"><strong>' . qfa_muwatta_e($book['title']) . '</strong><small>' . qfa_muwatta_chapters(count($book['chapters'])) . ' · ' . qfa_muwatta_num($count) . ' حديثًا</small></span></a>';
    }
    $site->footercode .= '<script src="' . $site->get_theme_folder_url() . '/js/muwatta.js?v=1.0" defer></script>';
    $code = '<header class="mw-head mw-hero" data-mw-index data-guide-url="' . qfa_muwatta_e($base . '?guide=1') . '"><h1>' . QFA_MUWATTA_TITLE . '</h1><p class="mw-dua">' . QFA_MUWATTA_DUA . '</p>'
        . '<p><a class="mw-button mw-button-soft" href="' . qfa_muwatta_e($base . '?guide=1') . '"><i class="fas fa-info-circle" aria-hidden="true"></i> طريقة القراءة</a></p></header>'
        . $search . '<div class="mw-card">' . $rows . '</div>'
        . '<footer class="mw-legend"><strong>العلامات:</strong> ★ رواه البخاري أو مسلم · <u class="mw-mursal">خط تحت الراوي</u>: مرسل · «موصول»: موصول عند البخاري أو مسلم · الرقم: رقم الحديث في «التقصّي» لابن عبد البر.</footer>';
    return '<section class="mw-page"><div class="container mw-container">' . $code . '</div></section>';
}
