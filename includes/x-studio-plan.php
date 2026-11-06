<?php
declare(strict_types=1);

/**
 * The weekly content template for the X publishing studio.
 *
 * This file is the single source of the plan's text. Both the studio page and
 * the storage layer read it from here, so the two can never drift apart: there
 * is no second copy of these texts anywhere in the project.
 *
 * It is source, not runtime state. Nothing here is written to, and including it
 * has no side effects.
 */

/**
 * Arabic names of the week's days, indexed the way the studio counts them:
 * 0 is Sunday and 6 is Saturday.
 */
function qfa_x_studio_plan_day_names(): array {
    return [
        "الأحد",
        "الاثنين",
        "الثلاثاء",
        "الأربعاء",
        "الخميس",
        "الجمعة",
        "السبت",
    ];
}

/**
 * The 21 posts of the weekly template, three for each day.
 *
 * Each entry carries both what the page renders (time_label, type_label) and
 * what the storage schema records (time on a 24 hour clock, the type slug, and
 * the source a link placeholder points at). source_type is left as 'none'
 * wherever the target cannot be derived with certainty from the text itself.
 */
function qfa_x_studio_plan_posts(): array {
    return [
        [
            'day' => 0,
            'time' => "08:00",
            'time_label' => "08:00 ص",
            'type' => "ayah",
            'type_label' => "آية",
            'text' => "﴿وَقُل رَّبِّ زِدْنِي عِلْمًا﴾\n\nدعاء قرآني جامع لطلب العلم النافع والزيادة من فضله سبحانه.\n\n📖 سورة طه: [رابط السورة]",
            'source_type' => "surah",
            'source_ref' => 20,
            'link_placeholders' => [
                "[رابط السورة]",
            ],
        ],
        [
            'day' => 0,
            'time' => "13:00",
            'time_label' => "01:00 م",
            'type' => "dhikr",
            'type_label' => "ذكر",
            'text' => "سبحان الله وبحمده، سبحان الله العظيم 🌿\n\nذكرٌ يسير على اللسان، عظيم في الميزان.",
            'source_type' => "none",
            'source_ref' => null,
            'link_placeholders' => [],
        ],
        [
            'day' => 0,
            'time' => "20:30",
            'time_label' => "08:30 م",
            'type' => "dua",
            'type_label' => "دعاء",
            'text' => "اللهم اغفر لصاحب هذه الصدقة الجارية وارحمه، واجعل القرآن نورًا له ورفعةً في درجاته.",
            'source_type' => "none",
            'source_ref' => null,
            'link_placeholders' => [],
        ],
        [
            'day' => 1,
            'time' => "08:00",
            'time_label' => "08:00 ص",
            'type' => "ayah",
            'type_label' => "آية",
            'text' => "﴿إِنَّ مَعَ الْعُسْرِ يُسْرًا﴾\n\nمهما اشتد الأمر، فرحمة الله أقرب وأوسع.\n\n📖 سورة الشرح: [رابط السورة]",
            'source_type' => "surah",
            'source_ref' => 94,
            'link_placeholders' => [
                "[رابط السورة]",
            ],
        ],
        [
            'day' => 1,
            'time' => "17:00",
            'time_label' => "05:00 م",
            'type' => "site",
            'type_label' => "من الموقع",
            'text' => "حصّن مساءك بذكر الله 🌙\n\nأذكار المساء الصحيحة مع عداد يساعدك على إتمام وردك:\n[رابط أذكار المساء]",
            'source_type' => "adhkar",
            'source_ref' => "evening",
            'link_placeholders' => [
                "[رابط أذكار المساء]",
            ],
        ],
        [
            'day' => 1,
            'time' => "21:00",
            'time_label' => "09:00 م",
            'type' => "dua",
            'type_label' => "دعاء",
            'text' => "اللهم اجعل هذا الحساب بابًا للأجر الذي لا ينقطع، وارحم صاحبه رحمةً واسعة.",
            'source_type' => "none",
            'source_ref' => null,
            'link_placeholders' => [],
        ],
        [
            'day' => 2,
            'time' => "08:00",
            'time_label' => "08:00 ص",
            'type' => "ayah",
            'type_label' => "آية",
            'text' => "﴿فَاذْكُرُونِي أَذْكُرْكُمْ﴾\n\nابدأ يومك بذكر الله؛ ففي الذكر طمأنينة القلوب.\n\n📖 سورة البقرة: [رابط السورة]",
            'source_type' => "surah",
            'source_ref' => 2,
            'link_placeholders' => [
                "[رابط السورة]",
            ],
        ],
        [
            'day' => 2,
            'time' => "13:00",
            'time_label' => "01:00 م",
            'type' => "dhikr",
            'type_label' => "ذكر",
            'text' => "لا حول ولا قوة إلا بالله.\n\nكلمة استعانة وتفويض، يطمئن بها القلب ويقوى بها العبد.",
            'source_type' => "none",
            'source_ref' => null,
            'link_placeholders' => [],
        ],
        [
            'day' => 2,
            'time' => "20:30",
            'time_label' => "08:30 م",
            'type' => "dua",
            'type_label' => "دعاء",
            'text' => "اللهم آنس وحشة صاحب هذه الصدقة الجارية، ونوّر قبره، واجمعه بمن يحب في جنات النعيم.",
            'source_type' => "none",
            'source_ref' => null,
            'link_placeholders' => [],
        ],
        [
            'day' => 3,
            'time' => "08:00",
            'time_label' => "08:00 ص",
            'type' => "ayah",
            'type_label' => "آية",
            'text' => "﴿أَلَا بِذِكْرِ اللَّهِ تَطْمَئِنُّ الْقُلُوبُ﴾\n\n📖 سورة الرعد: [رابط السورة]",
            'source_type' => "surah",
            'source_ref' => 13,
            'link_placeholders' => [
                "[رابط السورة]",
            ],
        ],
        [
            'day' => 3,
            'time' => "17:00",
            'time_label' => "05:00 م",
            'type' => "site",
            'type_label' => "من الموقع",
            'text' => "اقرأ ما تيسر من كتاب الله، واستمع لتلاوة خاشعة من قارئك المفضل.\n\n📖 القرآن الكريم: [رابط الموقع]",
            'source_type' => "none",
            'source_ref' => null,
            'link_placeholders' => [
                "[رابط الموقع]",
            ],
        ],
        [
            'day' => 3,
            'time' => "21:00",
            'time_label' => "09:00 م",
            'type' => "dua",
            'type_label' => "دعاء",
            'text' => "ربنا آتنا في الدنيا حسنة، وفي الآخرة حسنة، وقنا عذاب النار.",
            'source_type' => "none",
            'source_ref' => null,
            'link_placeholders' => [],
        ],
        [
            'day' => 4,
            'time' => "08:00",
            'time_label' => "08:00 ص",
            'type' => "ayah",
            'type_label' => "آية",
            'text' => "﴿وَمَا تَوْفِيقِي إِلَّا بِاللَّهِ﴾\n\nكل توفيق من الله، فاستعن به وتوكل عليه.\n\n📖 سورة هود: [رابط السورة]",
            'source_type' => "surah",
            'source_ref' => 11,
            'link_placeholders' => [
                "[رابط السورة]",
            ],
        ],
        [
            'day' => 4,
            'time' => "17:00",
            'time_label' => "05:00 م",
            'type' => "dhikr",
            'type_label' => "ذكر",
            'text' => "أستغفر الله العظيم وأتوب إليه 🌿",
            'source_type' => "none",
            'source_ref' => null,
            'link_placeholders' => [],
        ],
        [
            'day' => 4,
            'time' => "21:00",
            'time_label' => "09:00 م",
            'type' => "dua",
            'type_label' => "دعاء",
            'text' => "اللهم بلّغنا الجمعة بقلوب مطمئنة، وأعمال مقبولة، وذنوب مغفورة.",
            'source_type' => "none",
            'source_ref' => null,
            'link_placeholders' => [],
        ],
        [
            'day' => 5,
            'time' => "08:00",
            'time_label' => "08:00 ص",
            'type' => "friday",
            'type_label' => "الجمعة",
            'text' => "جمعة مباركة 🤍\n\nأكثروا من الصلاة والسلام على رسول الله ﷺ.",
            'source_type' => "none",
            'source_ref' => null,
            'link_placeholders' => [],
        ],
        [
            'day' => 5,
            'time' => "10:00",
            'time_label' => "10:00 ص",
            'type' => "kahf",
            'type_label' => "سورة الكهف",
            'text' => "نورٌ ما بين الجمعتين 🌿\n\nلا تنسَ قراءة سورة الكهف وتدبر آياتها.\n\n📖 سورة الكهف: [رابط السورة]",
            'source_type' => "surah",
            'source_ref' => 18,
            'link_placeholders' => [
                "[رابط السورة]",
            ],
        ],
        [
            'day' => 5,
            'time' => "16:30",
            'time_label' => "04:30 م",
            'type' => "friday",
            'type_label' => "الجمعة",
            'text' => "في يوم الجمعة ساعة لا يوافقها عبد مسلم يسأل الله خيرًا إلا أعطاه؛ فالتمسها وأكثر من الدعاء.",
            'source_type' => "none",
            'source_ref' => null,
            'link_placeholders' => [],
        ],
        [
            'day' => 6,
            'time' => "08:30",
            'time_label' => "08:30 ص",
            'type' => "ayah",
            'type_label' => "آية",
            'text' => "﴿وَهُوَ مَعَكُمْ أَيْنَ مَا كُنتُمْ﴾\n\nمعية الله سكينةٌ للقلب وأمان.\n\n📖 سورة الحديد: [رابط السورة]",
            'source_type' => "surah",
            'source_ref' => 57,
            'link_placeholders' => [
                "[رابط السورة]",
            ],
        ],
        [
            'day' => 6,
            'time' => "13:00",
            'time_label' => "01:00 م",
            'type' => "site",
            'type_label' => "من الموقع",
            'text' => "تعرّف على معاني الآيات من التفاسير الميسرة والموثوقة.\n\n📚 التفاسير: [رابط التفاسير]",
            'source_type' => "none",
            'source_ref' => null,
            'link_placeholders' => [
                "[رابط التفاسير]",
            ],
        ],
        [
            'day' => 6,
            'time' => "20:30",
            'time_label' => "08:30 م",
            'type' => "dua",
            'type_label' => "دعاء",
            'text' => "اللهم اختم لنا أسبوعنا بعفوك ورضاك، وافتح لنا القادم بالخير والبركة.",
            'source_type' => "none",
            'source_ref' => null,
            'link_placeholders' => [],
        ],
    ];
}

/**
 * The same template shaped the way the studio page renders it: one entry per
 * day holding the day name, a count label, and that day's posts as
 * [time label, type label, text].
 */
function qfa_x_studio_plan_view_days(): array {
    $names = qfa_x_studio_plan_day_names();
    $days = [];

    foreach ($names as $index => $name) {
        $days[$index] = [$name, '', []];
    }

    foreach (qfa_x_studio_plan_posts() as $post) {
        $days[$post['day']][2][] = [$post['time_label'], $post['type_label'], $post['text']];
    }

    foreach ($days as $index => $day) {
        $days[$index][1] = count($day[2]) . ' تغريدات';
    }

    return $days;
}

/**
 * Arabic labels for every post type the studio can show, including the types
 * only generated weeks use.
 */
function qfa_x_studio_plan_type_labels(): array {
    $labels = [];
    foreach (qfa_x_studio_plan_posts() as $post) {
        $labels[$post['type']] = $post['type_label'];
    }
    $labels['hadith'] = "حديث";
    return $labels;
}

/**
 * The weekly schedule of generated weeks: [day, time, kind]. Day 0 is Sunday.
 * Three posts a day, the most the stored plan allows.
 */
function qfa_x_studio_plan_schedule(): array {
    return [
        [0, "08:00", 'ayah'],   [0, "13:00", 'hadith'], [0, "20:30", 'dua'],
        [1, "08:00", 'ayah'],   [1, "13:00", 'dhikr'],  [1, "17:00", 'site'],
        [2, "08:00", 'ayah'],   [2, "13:00", 'hadith'], [2, "20:30", 'dua'],
        [3, "08:00", 'ayah'],   [3, "13:00", 'dhikr'],  [3, "17:00", 'site'],
        [4, "08:00", 'ayah'],   [4, "13:00", 'hadith'], [4, "21:00", 'dua'],
        [5, "08:00", 'friday'], [5, "10:00", 'kahf'],   [5, "16:30", 'friday_hour'],
        [6, "08:00", 'ayah'],   [6, "13:00", 'hadith'], [6, "20:30", 'dua'],
    ];
}

/**
 * Build the posts of one week from the site's own content.
 *
 * Verses, supplications, hadith and adhkar are quoted from the site's data
 * through x-studio-sources.php: the evening supplications are Quranic duas
 * (Saturday's asks readers to pray for the owner of this sadaqah), and the
 * "from the site" posts quote an evening dhikr or a verse with its Muyassar
 * tafseer next to the page link. Only the Friday greetings are template texts.
 * Each list advances week by week, so nothing repeats until its list has been
 * used up. A slot whose source cannot be read falls back to a template text of
 * the same kind rather than being left empty.
 *
 * Returns entries in the template's shape (without the display labels).
 */
function qfa_x_studio_plan_generate(string $startDate): array {
    require_once __DIR__ . '/x-studio-sources.php';

    $week = qfa_x_sources_week_index($startDate);

    $byType = [];
    foreach (qfa_x_studio_plan_posts() as $template) {
        $byType[$template['type']][] = $template;
    }
    $fridayHour = null;
    foreach ($byType['friday'] ?? [] as $template) {
        if ((int)$template['day'] === 5 && $template['time'] !== "08:00") {
            $fridayHour = $template;
        }
    }

    $ayat = qfa_x_sources_ayat();
    $kahf = qfa_x_sources_kahf();
    $hadith = qfa_x_sources_hadith();
    $adhkar = qfa_x_sources_adhkar();

    /*
     * Template texts reused in rotation. Thursday's and Saturday's
     * supplications speak of the coming Friday and the closing week, so they
     * stay on their own day; the others rotate between the remaining slots.
     */
    $duas = [];
    $duaOfDay = [];
    foreach ($byType['dua'] ?? [] as $template) {
        if (in_array((int)$template['day'], [4, 6], true)) {
            $duaOfDay[(int)$template['day']] = $template;
        } else {
            $duas[] = $template;
        }
    }
    $sites = $byType['site'] ?? [];
    $fallback = [
        'ayah' => $byType['ayah'] ?? [],
        'dhikr' => $byType['dhikr'] ?? [],
        'kahf' => $byType['kahf'] ?? [],
    ];

    $perWeek = [];
    foreach (qfa_x_studio_plan_schedule() as $slot) {
        $perWeek[$slot[2]] = ($perWeek[$slot[2]] ?? 0) + 1;
    }

    // Quranic duas: Sunday, Tuesday and Thursday from the general list,
    // Saturday from the forgiveness-and-mercy list for the sadaqah's owner.
    $duaList = qfa_x_sources_duas();
    $mercyList = qfa_x_sources_mercy_duas();
    $duaPerWeek = max(0, ($perWeek['dua'] ?? 0) - 1);

    // This week's verses, so the tafseer post never quotes one of them.
    $weekAyat = [];
    for ($k = 0; $k < ($perWeek['ayah'] ?? 0); $k++) {
        $entry = $ayat[qfa_x_sources_pick(count($ayat), $week, $perWeek['ayah'], $k)] ?? null;
        if ($entry !== null) {
            $weekAyat[$entry[0] . ':' . $entry[1]] = true;
        }
    }
    $tafseerPosts = [];
    foreach ($ayat as $entry) {
        $text = qfa_x_sources_tafseer_post($entry);
        if ($text !== '') {
            $tafseerPosts[] = ['key' => $entry[0] . ':' . $entry[1], 'surah' => (int)$entry[0], 'post' => $text];
        }
    }
    // This week's adhkar, so the evening adhkar post never quotes one of them.
    $weekAdhkar = [];
    for ($k = 0; $k < ($perWeek['dhikr'] ?? 0); $k++) {
        $weekAdhkar[] = (string)($adhkar[qfa_x_sources_pick(count($adhkar), $week, $perWeek['dhikr'], $k)] ?? '');
    }
    $eveningPosts = qfa_x_sources_evening_posts();

    $used = [];
    $posts = [];
    foreach (qfa_x_studio_plan_schedule() as [$day, $time, $kind]) {
        $k = $used[$kind] ?? 0;
        $used[$kind] = $k + 1;
        $n = $perWeek[$kind];

        $post = [
            'day' => $day,
            'time' => $time,
            'type' => $kind,
            'text' => '',
            'source_type' => 'none',
            'source_ref' => null,
            'link_placeholders' => [],
        ];
        $template = null;

        switch ($kind) {
            case 'ayah':
                $entry = $ayat[qfa_x_sources_pick(count($ayat), $week, $n, $k)] ?? null;
                if ($entry !== null) {
                    $post['text'] = qfa_x_sources_ayah_post($entry);
                    $post['source_type'] = 'surah';
                    $post['source_ref'] = (int)$entry[0];
                    $post['link_placeholders'] = ["[رابط السورة]"];
                }
                if ($post['text'] === '') {
                    $template = $fallback['ayah'][qfa_x_sources_pick(count($fallback['ayah']), $week, $n, $k)] ?? null;
                }
                break;

            case 'kahf':
                $entry = $kahf[qfa_x_sources_pick(count($kahf), $week, $n, $k)] ?? null;
                if ($entry !== null) {
                    $post['text'] = qfa_x_sources_ayah_post($entry, "نورٌ ما بين الجمعتين 🌿");
                    $post['source_type'] = 'surah';
                    $post['source_ref'] = 18;
                    $post['link_placeholders'] = ["[رابط السورة]"];
                }
                if ($post['text'] === '') {
                    $template = $fallback['kahf'][0] ?? null;
                }
                break;

            case 'hadith':
                $ref = $hadith[qfa_x_sources_pick(count($hadith), $week, $n, $k)] ?? null;
                $post['text'] = ($ref === null ? '' : qfa_x_sources_hadith_post($ref));
                if ($post['text'] === '') {
                    $post['type'] = 'dhikr';
                    $template = $fallback['dhikr'][qfa_x_sources_pick(count($fallback['dhikr']), $week, $n, $k)] ?? null;
                }
                break;

            case 'dhikr':
                $post['text'] = $adhkar[qfa_x_sources_pick(count($adhkar), $week, $n, $k)] ?? '';
                if ($post['text'] === '') {
                    $template = $fallback['dhikr'][qfa_x_sources_pick(count($fallback['dhikr']), $week, $n, $k)] ?? null;
                }
                break;

            case 'dua':
                if ($day === 6) {
                    $entry = $mercyList[qfa_x_sources_pick(count($mercyList), $week, 1, 0)] ?? null;
                    $header = "🤍 ادعُ لصاحب هذه الصدقة الجارية";
                } else {
                    $entry = $duaList[qfa_x_sources_pick(count($duaList), $week, $duaPerWeek, $k)] ?? null;
                    $header = "🤲 من أدعية القرآن الكريم";
                }
                if ($entry !== null) {
                    $post['text'] = qfa_x_sources_ayah_post($entry, $header, false);
                    $post['source_type'] = 'surah';
                    $post['source_ref'] = (int)$entry[0];
                    $post['link_placeholders'] = ["[رابط السورة]"];
                }
                if ($post['text'] === '') {
                    $template = $duaOfDay[$day]
                        ?? ($duas[qfa_x_sources_pick(count($duas), $week, $n - count($duaOfDay), $k)] ?? null);
                }
                break;

            case 'site':
                // First weekly slot: an evening dhikr with the evening adhkar page.
                // Second: a verse and its Muyassar tafseer with the tafseer pages.
                if ($k % 2 === 0) {
                    $count = count($eveningPosts);
                    for ($step = 0; $step < $count; $step++) {
                        $candidate = $eveningPosts[qfa_x_sources_pick($count, $week, 1, $step * 3)];
                        $clash = false;
                        foreach ($weekAdhkar as $taken) {
                            $clash = $clash || ($taken !== '' && strpos($taken, $candidate['text']) === 0);
                        }
                        if (!$clash) {
                            $post['text'] = $candidate['post'];
                            $post['source_type'] = 'adhkar';
                            $post['source_ref'] = 'evening';
                            $post['link_placeholders'] = ["[رابط أذكار المساء]"];
                            break;
                        }
                    }
                } else {
                    // A clash with this week's verses jumps a third of the list
                    // away, so the skipped verse is not simply taken next week.
                    $count = count($tafseerPosts);
                    $third = max(1, intdiv($count, 3));
                    for ($step = 0; $step < $count; $step++) {
                        $candidate = $tafseerPosts[qfa_x_sources_pick($count, $week + intdiv($count, 2), 1, $step * $third)];
                        if (!isset($weekAyat[$candidate['key']])) {
                            $post['text'] = $candidate['post'];
                            $post['source_type'] = 'surah';
                            $post['source_ref'] = $candidate['surah'];
                            $post['link_placeholders'] = ["[رابط التفاسير]"];
                            break;
                        }
                    }
                }
                if ($post['text'] === '') {
                    $template = $sites[qfa_x_sources_pick(count($sites), $week, $n, $k)] ?? null;
                }
                break;

            case 'friday':
                // Odd weeks quote the verse on sending blessings upon the Prophet ﷺ.
                if ($week % 2 !== 0) {
                    $post['text'] = qfa_x_sources_ayah_post([33, 56, 56, 0, 0], "جمعة مباركة 🤍");
                    $post['source_type'] = 'surah';
                    $post['source_ref'] = 33;
                    $post['link_placeholders'] = ["[رابط السورة]"];
                }
                if ($post['text'] !== '') {
                    break;
                }
                foreach ($byType['friday'] ?? [] as $candidate) {
                    if ((int)$candidate['day'] === 5 && $candidate['time'] === "08:00") {
                        $template = $candidate;
                    }
                }
                break;

            case 'friday_hour':
                // Alternate between the template's reminder and the Muwatta hadith it paraphrases.
                $post['type'] = 'friday';
                if ($week % 2 !== 0) {
                    $post['text'] = qfa_x_sources_hadith_post(qfa_x_sources_friday_hadith());
                }
                if ($post['text'] === '') {
                    $template = $fridayHour;
                }
                break;
        }

        if ($post['text'] === '' && $template !== null) {
            $post['text'] = (string)$template['text'];
            $post['source_type'] = (string)$template['source_type'];
            $post['source_ref'] = $template['source_ref'];
            $post['link_placeholders'] = array_values($template['link_placeholders']);
        }
        if ($post['text'] === '') {
            continue;
        }
        $posts[] = $post;
    }

    return $posts;
}
