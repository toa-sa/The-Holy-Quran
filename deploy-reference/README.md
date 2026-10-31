# مرجع ملفات الإنتاج لكل موقع · Per-site production reference (31 أكتوبر 2026)

نسخ مرجعية من الخادم لملفات **خاصة بكل موقع** لا يحملها المستودع كما هي (لأن محتواها يختلف حسب النطاق) أو لا توجد فيه.
لا تُرفع إلى المواقع من هنا، ولا تحوي أي إعدادات أو كلمات مرور أو رسائل (`includes/config.php` وبيانات المدير والرسائل وأرشيف X Studio مستثناة دائماً).

| الموقع | المسار على الخادم |
|---|---|
| `alshabeeb.net` | `/home/alshabee/public_html` |
| `quranforabdullah.com` | `/home/alshabee/public_html/quranforabdullah.com` |
| `ziyadalosaimi.com` | `/home/alshabee/public_html/ziyadalosaimi.com` |

| الملفات | ملاحظة |
|---|---|
| `.htaccess`، `robots.txt`، `sitemaps/*.xml` | تختلف حسب نطاق كل موقع |
| `style/default/images/social-share.png` | صورة المشاركة الخاصة بالموقع |
| `app-privacy.html`، `app-support.html` (alshabeeb.net) | صفحتا الخصوصية والدعم لتطبيق القرآن الكريم |
| `php.ini`، `.user.ini` (ziyadalosaimi.com) | يولّدها cPanel |

أي تعديل على هذه الملفات في الإنتاج يُنسخ هنا فوراً (قاعدة الإنتاج = المستودع).
