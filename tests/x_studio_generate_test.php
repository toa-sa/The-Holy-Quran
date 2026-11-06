<?php
/*
 * Checks for the X studio's weekly generation (includes/x-studio-sources.php
 * and qfa_x_studio_plan_generate): every curated entry resolves to site text,
 * every generated week is a valid plan of 21 posts that fit in a tweet, and
 * the lists rotate instead of repeating week to week.
 * Run: php tests/x_studio_generate_test.php
 */

if (PHP_SAPI !== 'cli') {
    http_response_code(404);
    exit;
}

require dirname(__DIR__) . '/includes/x-studio-store.php';
require dirname(__DIR__) . '/includes/x-studio-plan.php';
require_once dirname(__DIR__) . '/includes/x-studio-sources.php';

$checks = 0;
$failures = 0;
function check($name, $ok){
    global $checks, $failures;
    $checks++;
    if( !$ok ) $failures++;
    if( !$ok || getenv('VERBOSE') ) echo ( $ok ? 'ok   - ' : 'FAIL - ' ).$name."\n";
}

// Every curated entry quotes real site text.
foreach (array_merge(qfa_x_sources_ayat(), qfa_x_sources_kahf()) as $entry) {
    check('verse ' . implode(':', $entry) . ' resolves', qfa_x_sources_ayah_text($entry) !== '');
}
foreach (qfa_x_sources_hadith() as $ref) {
    check('hadith ' . implode('/', $ref) . ' resolves', qfa_x_sources_hadith_text($ref) !== '');
}
foreach (array_merge(qfa_x_sources_duas(), qfa_x_sources_mercy_duas()) as $entry) {
    check('dua ' . implode(':', $entry) . ' resolves', qfa_x_sources_ayah_text($entry) !== '');
}
check('evening adhkar posts available', count(qfa_x_sources_evening_posts()) >= 5);
check('friday hadith resolves', qfa_x_sources_hadith_text(qfa_x_sources_friday_hadith()) !== '');
check('adhkar available', count(qfa_x_sources_adhkar()) >= 5);
check('114 surah names', count(qfa_x_sources_surah_names()) === 114);

// A verse slice is the site's own words, unchanged.
$whole = qfa_x_sources_ayah(20, 114);
$slice = qfa_x_sources_ayah_text([20, 114, 114, 16, 19]);
check('slice is part of the verse', $slice !== '' && strpos($whole, $slice) !== false);

// A year of generated weeks.
$tz = new DateTimeZone('Asia/Riyadh');
$previous = null;
for ($i = 0; $i < 53; $i++) {
    $bounds = qfa_x_store_week_bounds((new DateTimeImmutable('2026-11-08 12:00', $tz))->modify('+' . $i . ' weeks'));
    $plan = qfa_x_store_build_week($bounds);
    $week = $bounds['week_id'];

    check("$week validates", qfa_x_store_validate($plan) === []);
    check("$week has 21 posts", count($plan['posts']) === 21);

    $texts = [];
    foreach ($plan['posts'] as $post) {
        // A link placeholder becomes a 23 character t.co link.
        $length = qfa_x_sources_length($post['text']) + 10 * count($post['link_placeholders']);
        check("$week {$post['post_id']} fits in a tweet", $length <= 280);
        if (in_array($post['type'], ['ayah', 'hadith'], true)) {
            $texts[] = $post['text'];
        }
    }
    if ($previous !== null) {
        check("$week shares no verse or hadith with the week before", array_intersect($texts, $previous) === []);
    }
    $previous = $texts;
}

// Supplications and "from the site" posts come from site content, not the
// fixed template, and do not repeat until their list has gone round.
$templateTexts = array_column(qfa_x_studio_plan_posts(), 'text');
$seen = ['dua' => [], 'site' => []];
// The site posts draw on short lists (evening adhkar and tafseer that fit a
// tweet) and step around this week's other posts, so their floor is lower.
$cycle = [
    'dua' => intdiv(count(qfa_x_sources_duas()), 3),
    'site' => 3,
];
for ($i = 0; $i < 53; $i++) {
    $start = (new DateTimeImmutable('2026-11-08', $tz))->modify('+' . $i . ' weeks')->format('Y-m-d');
    $posts = qfa_x_studio_plan_generate($start);
    $week = 'week of ' . $start;
    check("$week has no repeated text", count(array_unique(array_column($posts, 'text'))) === count($posts));
    foreach ($posts as $post) {
        if (!in_array($post['type'], ['dua', 'site'], true)) {
            continue;
        }
        check("$week {$post['type']} day {$post['day']} quotes the site", !in_array($post['text'], $templateTexts, true));
        $last = $seen[$post['type']][$post['text']] ?? null;
        check("$week {$post['type']} day {$post['day']} not repeated within its cycle", $last === null || $i - $last >= $cycle[$post['type']]);
        $seen[$post['type']][$post['text']] = $i;
    }
    foreach ($posts as $post) {
        if ($post['type'] === 'dua' && $post['day'] === 6) {
            check("$week Saturday dua is for the sadaqah's owner", strpos($post['text'], 'صاحب هذه الصدقة') !== false);
        }
    }
}

// Same week, same posts.
$bounds = qfa_x_store_week_bounds(new DateTimeImmutable('2026-11-08 12:00', $tz));
$a = qfa_x_store_build_week($bounds)['posts'];
$b = qfa_x_store_build_week($bounds)['posts'];
check('generation is deterministic', array_column($a, 'text') === array_column($b, 'text'));

// Refreshing the current week keeps touched posts and replaces the rest.
$tmp = sys_get_temp_dir() . '/qfa-x-refresh-' . getmypid() . '.php';
@unlink($tmp);
$nowRiyadh = new DateTimeImmutable('now', $tz);
$seeded = qfa_x_store_seed_week($tmp, $nowRiyadh);
check('seed for refresh test', $seeded['status'] === QFA_X_OK);
$read = qfa_x_store_read($tmp);
$plan = $read['data'];
$plan['posts'][0]['text'] = 'نص قديم معتمد';
$plan['posts'][0]['approved'] = true;
$plan['posts'][0]['approved_at'] = qfa_x_now();
$plan['posts'][1]['text'] = 'نص قديم غير معتمد';
qfa_x_store_write($plan, (int)$plan['week']['revision'], $tmp);
$refresh = qfa_x_store_refresh_week($tmp, $nowRiyadh);
$after = qfa_x_store_read($tmp)['data']['posts'];
check('refresh succeeds', $refresh['status'] === QFA_X_OK);
check('approved post kept', $after[0]['text'] === 'نص قديم معتمد' && $after[0]['approved'] === true);
check('untouched post replaced', $after[1]['text'] !== 'نص قديم غير معتمد');
check('still 21 posts', count($after) === 21);
@unlink($tmp);
@unlink($tmp . '.bak');

echo "$checks checks, $failures failures\n";
exit($failures === 0 ? 0 : 1);
